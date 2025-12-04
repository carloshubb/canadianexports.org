<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Mail\AutoResponseToCustomerMail;
use App\Mail\ContactForRateMail;
use App\Services\EmailSettingService;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;

class ContactForRateController extends Controller
{
    use StatusResponser;


    public function sendMessage(Request $request)
    {
        $defaultLang = getDefaultLanguage(1);
        $niceNames = [];
        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            $setting = getContactForRatePageSetting($defaultLang, $request->page_id);
            $niceNames = [
                'name' => $setting->contactForRateSettingDetail[0]->name_error ?? '',
                'business_name' => $setting->contactForRateSettingDetail[0]->business_name_error ?? '',
                'phone' => $setting->contactForRateSettingDetail[0]->phone_error ?? '',
                'email' => $setting->contactForRateSettingDetail[0]->email_error ?? '',
                'message' => $setting->contactForRateSettingDetail[0]->message_error ?? '',
            ];
        }
        $data = $this->validate($request, [
            "name" => "required",
            "business_name" => "required",
            "phone" => "required",
            "email" => "required",
            "message" => "required",
        ], [], $niceNames);

        $emailService = new EmailSettingService();
        $result = $emailService->canadianExportersForm();
        if ($result['status'] == 'Error') {
            return $result;
        }

        $general_setting = getGeneralSettingByKey();
        if (isset($general_setting['admin_email'])) {
            $adminEmailsArr = explode(',', $general_setting['admin_email']);
        }
        if (isset($adminEmailsArr) && count($adminEmailsArr) > 1) {
            $to_email = $adminEmailsArr[0];
            unset($adminEmailsArr[0]);
            Mail::to($to_email)->cc($adminEmailsArr)->send(new ContactForRateMail($data));
        } else {
            $to_email = isset($adminEmailsArr[0]) ? $adminEmailsArr[0] : null;
            if ($to_email) {
                Mail::to($to_email)->send(new ContactForRateMail($data));
            }
        }

        Mail::to($request->email)->send(new AutoResponseToCustomerMail([]));

        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_54']);
        $message_54 = isset($general_messages['message_54']) ? $general_messages['message_54'] : '';

        return $this->successResponse([], $message_54);
    }
}
