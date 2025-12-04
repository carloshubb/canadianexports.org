<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Mail\AdminMembershipExpiryMail;
use App\Mail\AutoInfoLetterToCustomerMail;
use App\Mail\CustomerMembershipExpiryMail;
use App\Mail\HolidayMail;
use App\Models\Customer;
use App\Models\HolidayEmail;
use App\Models\InfoLetter;
use App\Models\RegistrationPackage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class CronJobController extends Controller
{
    // public function holiday_emails()
    // {
    //     $holidayEmails = HolidayEmail::whereIsEmailSent(0)->whereDate('email_sent_date', date('Y-m-d'))->get();
    //     $emailSent = [];
    //     foreach ($holidayEmails as $holidayEmail) {
    //         if (!isset($custoemrs)) {
    //             $custoemrs = Customer::select('name', 'email')->get();
    //         }
    //         foreach ($custoemrs as $customer) {
    //             if (!filter_var($customer->email, FILTER_VALIDATE_EMAIL)) {
    //                 continue;
    //             }
    //             $emailSent[] = $customer;
    //             $data['customer'] = $customer;
    //             $data['holiday_email'] = $holidayEmail;
    //             Mail::to($customer->email)->send(new HolidayMail($data));
    //         }
    //         $holidayEmail->update([
    //             'is_email_sent' => 1
    //         ]);
    //     }
    //     return $emailSent;
    //     // return 'email sent';
    // }
    // public function holiday_emails()
    // {
    //     $holidayEmails = HolidayEmail::whereIsEmailSent(0)
    //         ->whereDate('email_sent_date', date('Y-m-d'))
    //         ->get();

    //     $emailSent = [];
    //     foreach ($holidayEmails as $holidayEmail) {
    //         if (!isset($customers)) {
    //             $customers = Customer::select('name', 'email', 'is_subscribe', 'subscribe_hash')
    //                 ->where('is_subscribe', 1) // Only send to subscribed users
    //                 ->get();
    //         }

    //         $emails = [];

    //         foreach ($customers as $customer) {
    //             // if (!filter_var($customer->email, FILTER_VALIDATE_EMAIL)) {
    //             //     continue;
    //             // }
    //             if (!filter_var($customer->email, FILTER_VALIDATE_EMAIL) ||
    //             InfoLetter::where('email', $customer->email)->where('is_subscribe', 0)->exists()) {
    //             continue;
    //         }

    //             $emailSent[] = $customer;
    //             $data['customer'] = $customer;
    //             $data['holiday_email'] = $holidayEmail;

    //             $emails[] = $customer->email;

    //         }

    //         // $general_setting = getGeneralSettingByKey();
    //         // if (isset($general_setting['admin_email'])) {
    //         //     $adminEmailsArr = explode(',', $general_setting['admin_email']);
    //         // }

    //         $holidayEmail->update([
    //             'is_email_sent' => 1
    //         ]);

    //         // $batchSize = 40;
    //         // $chunks = array_chunk($emails, $batchSize);
    //         // foreach ($chunks as $batch) {
    //         //     Mail::to($adminEmailsArr[0])->bcc($batch)->send(new HolidayMail($data));
    //         // }
    //         $batchSize = 40;
    //     $chunks = array_chunk($emails, $batchSize);

    //     foreach ($chunks as $batch) {
    //         // Send to each customer directly (not BCC)
    //         foreach ($batch as $email) {
    //             Mail::to($email)->send(new HolidayMail($data));
    //         }
    //         sleep(1);
    //     }
    //     }



    //     return $emailSent;
    // }
    public function holiday_emails()
    {
        $holidayEmails = HolidayEmail::whereIsEmailSent(0)
            ->whereDate('email_sent_date', date('Y-m-d'))
            ->get();

        $emailSent = [];
        foreach ($holidayEmails as $holidayEmail) {
            // Get customers who are subscribed in BOTH systems
            $customers = Customer::where('is_subscribe', 1)
                ->whereHas('infoLetters', function($q) {
                    $q->where('is_subscribe', 1);
                })
                ->orWhere(function($query) {
                    $query->where('is_subscribe', 1)
                          ->whereDoesntHave('infoLetters');
                })
                ->get();

            $emails = [];

            foreach ($customers as $customer) {
                if (!filter_var($customer->email, FILTER_VALIDATE_EMAIL)) {
                    continue;
                }

                $emailSent[] = $customer;
                $data['customer'] = $customer;
                $data['holiday_email'] = $holidayEmail;

                $emails[] = $customer->email;
            }

            $holidayEmail->update(['is_email_sent' => 1]);

            // Send emails in batches
            $batchSize = 40;
            $chunks = array_chunk($emails, $batchSize);

            foreach ($chunks as $batch) {
                foreach ($batch as $email) {
                    Mail::to($email)->send(new HolidayMail($data));
                }
                sleep(1);
            }
        }

        return $emailSent;
    }
    public function membership_expiry_emails()
    {
        // email 7 days before expiry
        $today = Carbon::now();
        $sevenDaysLater = $today->copy()->addDays(7);
        $customers = Customer::where('is_auto_renew', 0);
        $customers = $customers->where('first_pkg_expiry_mail', 0);
        $customers = $customers->whereBetween('package_expiry_date', [$today, $sevenDaysLater])->get();

        $defaultLang = getDefaultLanguage(1);
        $general_setting = getGeneralSettingByKey();

        foreach ($customers as $customer) {
            $package = RegistrationPackage::whereId($customer->registration_package_id)->with(['registrationPackageDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            }])->first();

            $data['customer'] = $customer;
            $data['package'] = $package;
            $data['login_url'] = url(langBasedURL(null, $general_setting['user_signin_page']));
            Mail::to($customer->email)->send(new CustomerMembershipExpiryMail($data));

            $customer->update([
                'first_pkg_expiry_mail' => 1
            ]);


            if (isset($general_setting['admin_email'])) {
                $adminEmailsArr = explode(',', $general_setting['admin_email']);
            }
            if (isset($adminEmailsArr) && count($adminEmailsArr) > 1) {
                $to_email = $adminEmailsArr[0];
                unset($adminEmailsArr[0]);
                Mail::to($to_email)->cc($adminEmailsArr)->send(new AdminMembershipExpiryMail($data));
            } else {
                $to_email = isset($adminEmailsArr[0]) ? $adminEmailsArr[0] : null;
                if ($to_email) {
                    Mail::to($to_email)->send(new AdminMembershipExpiryMail($data));
                }
            }
        }


        // email one day before expiry
        $oneDayBeforeExpiry = $today->copy()->addDay();
        $customers = Customer::where('is_auto_renew', 0);
        $customers = $customers->where('second_pkg_expiry_mail', 0);
        $customers = $customers->whereDate('package_expiry_date', $oneDayBeforeExpiry->toDateString())->get();


        foreach ($customers as $customer) {
            $package = RegistrationPackage::whereId($customer->registration_package_id)->with(['registrationPackageDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            }])->first();

            $data['customer'] = $customer;
            $data['package'] = $package;
            $data['login_url'] = url(langBasedURL(null, $general_setting['user_signin_page']));
            Mail::to($customer->email)->send(new CustomerMembershipExpiryMail($data));

            $customer->update([
                'second_pkg_expiry_mail' => 1
            ]);


            if (isset($general_setting['admin_email'])) {
                $adminEmailsArr = explode(',', $general_setting['admin_email']);
            }
            if (isset($adminEmailsArr) && count($adminEmailsArr) > 1) {
                $to_email = $adminEmailsArr[0];
                unset($adminEmailsArr[0]);
                Mail::to($to_email)->cc($adminEmailsArr)->send(new AdminMembershipExpiryMail($data));
            } else {
                $to_email = isset($adminEmailsArr[0]) ? $adminEmailsArr[0] : null;
                if ($to_email) {
                    Mail::to($to_email)->send(new AdminMembershipExpiryMail($data));
                }
            }
        }


        // email 7 days after expiry
        $sevenDaysAfterExpiry = $today->copy()->addDays(7);
        $customers = Customer::where('is_auto_renew', 0);
        $customers = $customers->where('third_pkg_expiry_mail', 0);
        $customers = $customers->whereDate('package_expiry_date', $sevenDaysAfterExpiry->toDateString())->get();


        foreach ($customers as $customer) {
            $package = RegistrationPackage::whereId($customer->registration_package_id)->with(['registrationPackageDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            }])->first();

            $data['customer'] = $customer;
            $data['package'] = $package;
            $data['login_url'] = url(langBasedURL(null, $general_setting['user_signin_page']));
            Mail::to($customer->email)->send(new CustomerMembershipExpiryMail($data));

            $customer->update([
                'third_pkg_expiry_mail' => 1
            ]);



            if (isset($general_setting['admin_email'])) {
                $adminEmailsArr = explode(',', $general_setting['admin_email']);
            }
            if (isset($adminEmailsArr) && count($adminEmailsArr) > 1) {
                $to_email = $adminEmailsArr[0];
                unset($adminEmailsArr[0]);
                Mail::to($to_email)->cc($adminEmailsArr)->send(new AdminMembershipExpiryMail($data));
            } else {
                $to_email = isset($adminEmailsArr[0]) ? $adminEmailsArr[0] : null;
                if ($to_email) {
                    Mail::to($to_email)->send(new AdminMembershipExpiryMail($data));
                }
            }
        }

        return 'email sent';
    }

    function infoLetterSubscribeEmails()
    {
        $infoLetters = InfoLetter::where('is_subscribe', 1)->distinct('email')->get();
        $data = [];
        foreach ($infoLetters as $key => $infoLetter) {
            $data['subscribe_hash'] = $infoLetter->subscribe_hash ?? null;
            Mail::to($infoLetter->email)->send(new AutoInfoLetterToCustomerMail($data));
        }
    }
}
