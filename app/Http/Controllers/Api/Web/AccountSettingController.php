<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\RegistrationPackageResource;
use App\Mail\RegistrationInvoiceToCustomerMail;
use App\Models\Customer;
use App\Models\CustomerBusinessCategory;
use App\Models\CustomerGalleryImage;
use App\Models\CustomerMedia;
use App\Models\CustomerProfile;
use App\Models\CustomerSocialMedia;
use App\Models\Order;
use App\Rules\ValidUrl;
use App\Rules\YoutubeUrl;
use App\Services\CustomerProfileService;
use App\Services\PaymentService;
use App\Services\PaypalService;
use App\Services\PDFService;
use App\Services\StripeService;
use App\Traits\FileUploadTrait;
use App\Traits\StatusResponser;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use LVR\CreditCard\CardNumber;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AccountSettingController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;


    public function index($abbreviation = null)
    {
        updateLangByAbber($abbreviation);
        $user = auth()->guard('customers')->user();
        $customerProfile = CustomerProfile::where('customer_id', $user->id)->first();
        return view('web.signup-bussiness-setting.index', compact('user', 'customerProfile'));
        // return view('web.signup-account-setting.index', compact('user'));
    }

    public function sponsorIndex($abbreviation = null)
    {
        updateLangByAbber($abbreviation);
        $user = auth()->guard('customers')->user();
        $customerProfile = CustomerProfile::where('customer_id', $user->id)->first();

        $lang = getDefaultLanguage(true);
        
        // Get the become sponsor page and settings
        $page = \App\Models\Page::where('template', 'become_sponsor_template')->first();
        $becomeSponsorSetting = null;
        $becomeSponsorSettingDetail = null;
        
        if ($page) {
            $becomeSponsorSetting = getBecomeSponsorSetting($lang, $page);
            $becomeSponsorSettingDetail = isset($becomeSponsorSetting->becomeSponsorSettingDetail[0])
                ? $becomeSponsorSetting->becomeSponsorSettingDetail[0]
                : null;
        }
        
        return view('web.signup-sponsor-setting.index', compact('user', 'customerProfile', 'lang', 'page', 'becomeSponsorSettingDetail'));
    }

    public function sponsorEdit($abbreviation = null, $id = null)
    {
        updateLangByAbber($abbreviation);
        $user = auth()->guard('customers')->user();
        $customerProfile = CustomerProfile::where('customer_id', $user->id)->first();

        $lang = getDefaultLanguage(true);
        return view('web.signup-sponsor-setting.edit', compact('user', 'customerProfile', 'lang', 'id'));
    }

    public function sponsorAdd($abbreviation = null)
    {
        updateLangByAbber($abbreviation);
        $user = auth()->guard('customers')->user();
        $customerProfile = CustomerProfile::where('customer_id', $user->id)->first();

        $lang = getDefaultLanguage(true);
        return view('web.signup-sponsor-setting.add', compact('user', 'customerProfile', 'lang'));
    }

    public function createBusinessProfile($abbreviation = null)
    {
        updateLangByAbber($abbreviation);
        $user = auth()->guard('customers')->user();
        $customerProfile = CustomerProfile::where('customer_id', $user->id)->first();
        return view('web.signup-bussiness-setting.index', compact('user', 'customerProfile'));
        // return view('web.signup-account-setting.index', compact('user'));
    }

    public function buissnessSettingView($abbreviation = null)
    {
        updateLangByAbber($abbreviation);
        $user = auth()->guard('customers')->user();
        $customerProfile = CustomerProfile::where('customer_id', $user->id)->first();
        return view('web.signup-bussiness-setting.index', compact('user', 'customerProfile'));
    }

    public function mediaSettingView($abbreviation = null)
    {
        updateLangByAbber($abbreviation);
        return view('web.signup-media-setting.index');
    }

    public function socialMediaSettingView($abbreviation = null)
    {
        updateLangByAbber($abbreviation);
        $user = auth()->guard('customers')->user();
        $customerSocialMedia = CustomerSocialMedia::where('customer_id', $user->id)->first();
        return view('web.signup-social-media-setting.index', compact('user', 'customerSocialMedia'));
    }

    public function updateProfileSetting(Request $request)
    {
        $defaultLang = getDefaultLanguage(1);
        $customerProfileService = new CustomerProfileService();
        $response = $customerProfileService->updateCustomerProfileValidation($request, $defaultLang);

        $user = Customer::whereId(auth()->guard('customers')->user()->id)->first();
        $package = getRegistrationPackage($request->registration_package_id);

        $isPackageChanged = false;
        $package_expiry_date = date('Y-m-d');
        $package_price = 0;
        $orderAmount = 0;

        if ($user->registration_package_id != $request->registration_package_id || $user->payment_frequency != $request->payment_frequency) {
            $isPackageChanged = true;
            $response['rules'] = $customerProfileService->ValidationForPaymentFields($request, $package, $response['rules']);

            $payment_setting = getI2bModalSetting(null, ['payment_setting']);

            $response['niceNames'] = $customerProfileService->niceNamesForPaymentFields($response['niceNames'], $payment_setting);


            if ($request->payment_frequency == 'monthly') {
                $package_price = $package->monthly_price;
                $package_expiry_date = date('Y-m-d', strtotime('+1 months'));
                $orderAmount = $package->monthly_price;
                $packageValidity = '1 month';
            } else if ($request->payment_frequency == 'quarterly') {
                $package_price = $package->quarterly_price;
                $package_expiry_date = date('Y-m-d', strtotime('+3 months'));
                $orderAmount = $package->quarterly_price * 3;
                $packageValidity = '3 months';
            } else if ($request->payment_frequency == 'semi_annually') {
                $package_price = $package->semi_annually_price;
                $package_expiry_date = date('Y-m-d', strtotime('+6 months'));
                $orderAmount = $package->semi_annually_price * 6;
                $packageValidity = '6 months';
            } else if ($request->payment_frequency == 'annually') {
                $package_price = $package->annually_price;
                $package_expiry_date = date('Y-m-d', strtotime('+12 months'));
                $orderAmount = $package->annually_price * 12;
                $packageValidity = '12 months';
            }
        }

        $this->validate(
            $request,
            $response['rules'],
            [],
            $response['niceNames']
        );


        $customer = Customer::whereId(Auth::guard('customers')->user()->id)->with('profileImage')->first();

        $files = $customerProfileService->uploadProfileImage($request, $customer);
        $customerProfileService->updateCustomer($request, $files);
        $customerProfileService->updateCustomerProfile($request);
        $customerProfileService->updateBusinessCategories($request);

        $customerMedia = CustomerMedia::whereCustomerId(Auth::guard('customers')->user()->id)->with('customerGalleryImages.media')->first();

        $customerProfileService->updateCustomerMedia($request, $customerMedia);
        $customerProfileService->updateCustomerGalleryImage($request, $customerMedia);
        $customerProfileService->updateCustomerSocialMedia($request);

        if ($isPackageChanged === true) {
            $subscription_status = null;
            if ($request->payment_method == 'stripe' && $package_price > 0) {
                try {
                    $stripeService = new StripeService();

                    $stripeResponse = $stripeService->upgradeUserAccount($request, $user, $package);
                    if (isset($stripeResponse['status']) && $stripeResponse['status'] == 'error') {
                        return $this->errorResponse($stripeResponse['message']);
                    } else if (isset($stripeResponse['status']) && $stripeResponse['status'] == 'success') {
                        if ($user->payment_method == 'paypal') {
                            if ($user->paypal_subscription_id) {
                                $amount = 0;

                                // Get the previous package data
                                $prevPackagePrice = $user->package_price;
                                $prevPackageStartDate = new \DateTime($user->package_subscribed_date);
                                $prevPackageEndDate = new \DateTime($user->package_expiry_date);

                                // Calculate the per-day price of the previous package
                                $diffInTime = $prevPackageEndDate->getTimestamp() - $prevPackageStartDate->getTimestamp();
                                $totalDaysOfPrevPackage = $diffInTime / (60 * 60 * 24);
                                $prevPackagePerDayPrice = $prevPackagePrice / $totalDaysOfPrevPackage;

                                // Calculate the remaining days of the previous package
                                $today = new \DateTime();
                                $remainingDays = ($prevPackageEndDate->getTimestamp() - $today->getTimestamp()) / (60 * 60 * 24);

                                // Ensure remaining days are positive
                                if ($remainingDays > 0) {
                                  // Calculate the price to be deducted based on remaining days
                                  $amount = $prevPackagePerDayPrice * $remainingDays;
                                }

                                if ($amount > 0) {
                                    Log::info('refund amount = ' . $amount);
                                    // Get the sale ID for the subscription
                                    $client = new Client();
                                    $paypalService = new PaypalService;

                                    $subscription = $client->get(env('PAYPAL_BASE_URL') . '/billing/subscriptions/' . $user->paypal_subscription_id, [
                                        'headers' => [
                                            'Content-Type' => 'application/json',
                                            'Authorization' => 'Bearer ' . $paypalService->paypalToken(),
                                        ],
                                    ]);
                                    $subscriptionBody = $subscription->getBody()->getContents();
                                    $subscriptionData = json_decode($subscriptionBody, true);

                                    $saleId = $subscriptionData['billing_info']['last_payment']['sale_id'] ?? null;
                                    Log::info('Sale id = ' . $saleId);

                                    if ($saleId) {
                                        $paypalService = new PaypalService();
                                        $refundPaypalResponse = $paypalService->refundPayPalSale($user->paypal_subscription_id, $amount);
                                        Log::info('refund paypal response = ' . $refundPaypalResponse);
                                    } else {
                                        Log::info('No sale ID found for subscription');
                                    }
                                }

                                $paymentService = new PaymentService();
                                $paymentService->cancelPayPalSubscription($user);
                            }
                        }
                    }
                } catch (\Exception $e) {
                    return $this->errorResponse($e->getMessage());
                }
                Customer::whereId($user->id)->update([
                    'type' => 'customer',
                ]);
            } else if ($request->payment_method == 'paypal' && $package_price > 0) {
                $paypalService = new PaypalService();
                Customer::whereId($user->id)->update([
                    'temp_registration_package_id' => $package->id,
                    'temp_payment_frequency' => $request->payment_frequency,
                    'temp_is_auto_renew' => $request->is_auto_renew == 'true' || $request->is_auto_renew == '1' ? 1 : 0,
                    'temp_type' => 'customer',
                ]);
                $paypalResponse = $paypalService->createSubscription($request, $user, $package, 'account_setting_upgrade');

                if ($paypalResponse['status'] == 'Error') {
                    return $this->errorResponse($paypalResponse['message']);
                } else if ($paypalResponse['status'] == 'Success') {
                    $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_19_a']);
                    $message_19_a = isset($general_messages['message_19_a']) ? $general_messages['message_19_a'] : '';

                    return $this->successResponse(
                        [
                            'type' => 'paypal',
                            'redirect_url' => $paypalResponse['redirect_url'],
                        ],
                        $message_19_a,
                    );
                }
                return $this->errorResponse();
            }

            Customer::whereId($user->id)->update([
                'registration_package_id' => $request->registration_package_id,
                'payment_frequency' => $request->payment_frequency,
                'package_price' => $package_price,
                'package_subscribed_date' => date('Y-m-d'),
                'package_expiry_date' => $package_expiry_date,
                'is_active' => 1,
                'is_auto_renew' => $request->is_auto_renew == 'true' || $request->is_auto_renew == '1' ? 1 : 0,
                'is_package_amount_paid' => 1,
                'subscription_status' => $subscription_status,
                'payment_method' => $package_price > 0 ? $request->payment_method : null,
                'stripe_item_id' => isset($stripe_item_id) ? $stripe_item_id : null,
            ]);

            $order = Order::create([
                'registration_package_id' => $package->id,
                'customer_id' => $user->id,
                'type' => 'profile',
                'payment_method' => $package_price > 0 ? $request->payment_method : null,
                'transaction_id' => isset($subscription_id) ? $subscription_id : null,
                'stripe_item_id' => isset($stripe_item_id) ? $stripe_item_id : null,
                'amount' => $orderAmount,
            ]);

            $invoiceNo = 'CE' . (str_pad((int)$order->id + 1, 4, '0', STR_PAD_LEFT));
            $order->update([
                'invoice_no' => $invoiceNo
            ]);

            // $data = [
            //     'package_name' => isset($package->registrationPackageDetail[0]) ? $package->registrationPackageDetail[0]->name : '',
            //     'package_price' => $package_price,
            //     'payment_frequency' => $request->payment_frequency,
            //     'package_validity' => $packageValidity,
            //     'customer' => $user,
            //     'order' => $order,
            //     'package_expiry_date' => $package_expiry_date
            // ];

            // $PDFService = new PDFService();
            // $PDFService->createRegistrationInvoicePDF(null, $data);
            // Mail::to($request->email)->send(new RegistrationInvoiceToCustomerMail($data));

            $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_19_a']);
            $message_19_a = isset($general_messages['message_19_a']) ? $general_messages['message_19_a'] : '';

            Session::flash('message', $message_19_a);
            Session::flash('type', 'success');
        }

        Customer::whereId($user->id)->update([
            'type' => 'customer',
        ]);



        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_9']);
        $message_9 = isset($general_messages['message_9']) ? $general_messages['message_9'] : '';

        return $this->successResponse([], $message_9);
    }



    public function updateMediaSetting(Request $request)
    {
        $request['gallery_images'] = json_decode($request->gallery_images);
        $validationRule = [
            'customer_media_title' => ['nullable', 'string', 'maxwords:10'],
            'customer_media_description' => ['nullable', 'string', 'maxwords:50'],
            'customer_media_video' => ['nullable', new YoutubeUrl()],
            'customer_media_logo' => ['nullable', 'string'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['nullable'],
        ];

        $defaultLang = getDefaultLanguage(1);
        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            $regPageSetting = getRegPageSetting();
            $regPageSettingDetail = $regPageSetting->regPageSettingDetail;
            $niceNames = [
                'customer_media_title' => isset($regPageSettingDetail[0]->step_5_title_error) ? $regPageSettingDetail[0]->step_5_title_error : '',
                'customer_media_description' => isset($regPageSettingDetail[0]->step_5_description_error) ? $regPageSettingDetail[0]->step_5_description_error : '',
                'customer_media_video' => isset($regPageSettingDetail[0]->step_5_video_error) ? $regPageSettingDetail[0]->step_5_video_error : '',
                'customer_media_logo' => isset($regPageSettingDetail[0]->step_5_logo_error) ? $regPageSettingDetail[0]->step_5_logo_error : '',
                'gallery_images' => isset($regPageSettingDetail[0]->step_5_gallery_image_error) ? $regPageSettingDetail[0]->step_5_gallery_image_error : '',
            ];
        }
        $this->validate(
            $request,
            $validationRule,
            [],
            $niceNames
        );

        $customerMedia = CustomerMedia::whereCustomerId(Auth::guard('customers')->user()->id)->with('customerGalleryImages.media')->first();

        if (isset($request->customer_media_logo)) {
            $media = json_decode($request->customer_media_logo, 1);
            if ((isset($media, $media[0], $customerMedia->customerLogo) && $customerMedia->customerLogo->path != $media[0]) || (isset($media, $media[0]) && !isset($customerMedia->customerLogo))) {
                $files = $this->moveFile($media, 'media/customers', 'profile_logo');
            } else {
                $files[0]['id'] = $customerMedia->logo;
            }
        }

        CustomerMedia::whereCustomerId(Auth::guard('customers')->user()->id)->update([
            "logo" => isset($files, $files[0]) ? $files[0]['id'] : null,
            "video" => $request->customer_media_video,
            "title" => $request->customer_media_title,
            "description" => $request->customer_media_description,
            "video_frame" => getVideoHtmlAttribute($request->customer_media_video),
        ]);

        $oldMediaIds = [];
        if (isset($request->gallery_images)) {
            $oldMediaPath = [];
            if (isset($customerMedia->customerGalleryImages)) {
                foreach ($customerMedia->customerGalleryImages as $key => $customerGalleryImages) {
                    if (isset($customerGalleryImages->media)) {
                        $oldMediaPath[] = $customerGalleryImages->media->path;
                        if (in_array($customerGalleryImages->media->path, $request->gallery_images)) {
                            $oldMediaIds[] = $customerGalleryImages->media->id;
                        }
                    }
                }
            }
            $newMedia = array_merge(array_diff($request->gallery_images, $oldMediaPath), array_diff($oldMediaPath, $request->gallery_images));
            $galleryImages = [];
            if ($newMedia) {
                $galleryImages = $this->moveFile($newMedia, 'media/customers', 'profile_gallery_images');
            }
        }
        CustomerGalleryImage::whereNotIn('media_id', $oldMediaIds)->whereCustomerMediaId($customerMedia->id)->delete();
        if (isset($galleryImages)) {
            foreach ($galleryImages as $key => $image) {
                CustomerGalleryImage::create([
                    'customer_media_id' => $customerMedia->id,
                    'media_id' => $image->id,
                ]);
            }
        }

        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_10']);
        $message_10 = isset($general_messages['message_10']) ? $general_messages['message_10'] : '';

        return $this->successResponse([], $message_10);
    }

    public function updateUserProfile(Request $request)
    {
        $isPasswordUpdate = false;
        if ($request->current_password || $request->new_password || $request->new_password_confirmation) {
            $isPasswordUpdate = true;
        }

        $validationRule = [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:App\Models\Customer,email,' . Auth::guard('customers')->user()->id],
        ];

        if ($isPasswordUpdate) {
            $validationRule = array_merge($validationRule, [
                'current_password' => ['required', 'string'],
                'new_password' => ['required', 'confirmed', 'min:8'],
            ]);
        }

        $defaultLang = getDefaultLanguage(1);
        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            $regPageSetting = getRegPageSetting();
            $regPageSettingDetail = $regPageSetting->regPageSettingDetail;
            $niceNames = [
                'name' => isset($regPageSettingDetail[0]->step_2_name_error) ? $regPageSettingDetail[0]->step_2_name_error : '',
                'email' => isset($regPageSettingDetail[0]->step_2_email_error) ? $regPageSettingDetail[0]->step_2_email_error : '',
                'current_password' => 'Current Password',
                'new_password' => 'New Password',
                'new_password_confirmation' => 'Password Confirmation',
            ];
        }
        
        $this->validate(
            $request,
            $validationRule,
            [],
            $niceNames
        );

        // If password update is requested, verify current password
        if ($isPasswordUpdate) {
            $user = Auth::guard('customers')->user();
            if (!Hash::check($request->current_password, $user->password)) {
                $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_37']);
                $message_37 = isset($general_messages['message_37']) ? $general_messages['message_37'] : 'Current password is incorrect.';
                return $this->errorResponse($message_37);
            }
        }

        // Update user data
        $updateData = [
            "name" => $request->name,
            "email" => $request->email
        ];

        // If password update is requested, add password to update data
        if ($isPasswordUpdate) {
            $updateData['password'] = Hash::make($request->new_password);
        }

        Customer::whereId(Auth::guard('customers')->user()->id)->update($updateData);

        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_11']);
        $message_11 = isset($general_messages['message_11']) ? $general_messages['message_11'] : 'Profile updated successfully.';

        return $this->successResponse([], $message_11);
    }

    public function updateSocialMedia(Request $request)
    {
        $validationRule = [
            'customer_social_media_facebook' => ['nullable', new ValidUrl()],
            'customer_social_media_linked_in' => ['nullable', new ValidUrl()],
            'customer_social_media_twitter' => ['nullable', new ValidUrl()],
            'customer_social_media_youtube' => ['nullable', new ValidUrl()],
        ];

        $defaultLang = getDefaultLanguage(1);
        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            $regPageSetting = getRegPageSetting();
            $regPageSettingDetail = $regPageSetting->regPageSettingDetail;
            $niceNames = [
                'customer_social_media_facebook' => isset($regPageSettingDetail[0]->step_6_facebook_error) ? $regPageSettingDetail[0]->step_6_facebook_error : '',
                'customer_social_media_linked_in' => isset($regPageSettingDetail[0]->step_6_linkedin_error) ? $regPageSettingDetail[0]->step_6_linkedin_error : '',
                'customer_social_media_twitter' => isset($regPageSettingDetail[0]->step_6_twitter_error) ? $regPageSettingDetail[0]->step_6_twitter_error : '',
                'customer_social_media_youtube' => isset($regPageSettingDetail[0]->step_6_youtube_error) ? $regPageSettingDetail[0]->step_6_youtube_error : '',
            ];
        }
        $this->validate(
            $request,
            $validationRule,
            [],
            $niceNames
        );

        CustomerSocialMedia::whereCustomerId(Auth::guard('customers')->user()->id)->update([
            "facebook" => $request->customer_social_media_facebook,
            "twitter" => $request->customer_social_media_twitter,
            "youtube" => $request->customer_social_media_youtube,
            "linked_in" => $request->customer_social_media_linked_in
        ]);

        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_12']);
        $message_12 = isset($general_messages['message_12']) ? $general_messages['message_12'] : '';


        return $this->successResponse([], $message_12);
    }

    public function cancelSubscription()
    {
        $user = auth()->guard('customers')->user();
        if ($user->payment_method == 'stripe') {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
            $stripe->subscriptions->update(
                $user->subscription_id,
                ['cancel_at_period_end' => true]
            );
            Customer::whereId($user->id)->update([
                'subscription_status' => 'cancel'
            ]);

            $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_13']);
            $message_13 = isset($general_messages['message_13']) ? $general_messages['message_13'] : '';

            return $this->successResponse([], $message_13);
        } else if ($user->payment_method == 'paypal') {
            if ($user->paypal_subscription_id && $user->is_auto_renew) {
                $paypalService = new PaypalService;
                $paypalService->cancelSubscriptionPlan($user);
            }
            $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_13']);
            $message_13 = isset($general_messages['message_13']) ? $general_messages['message_13'] : '';
            return $this->successResponse([], $message_13);
        }
        return $this->errorResponse();
    }

    public function resumeSubscription()
    {
        $user = auth()->guard('customers')->user();
        if ($user->payment_method == 'stripe') {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
            $stripe->subscriptions->update(
                $user->subscription_id,
                ['cancel_at_period_end' => false]
            );
            Customer::whereId($user->id)->update([
                'subscription_status' => 'ok'
            ]);

            $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_14']);
            $message_14 = isset($general_messages['message_14']) ? $general_messages['message_14'] : '';

            return $this->successResponse([], $message_14);
        } else if ($user->payment_method == 'paypal') {
            if ($user->paypal_subscription_id && $user->is_auto_renew) {
                $paypalService = new PaypalService;
                $paypalService->activateSubscriptionPlan($user);
            }

            $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_14']);
            $message_14 = isset($general_messages['message_14']) ? $general_messages['message_14'] : '';

            return $this->successResponse([], $message_14);
        }
        return $this->errorResponse();
    }

    public function upgradePackage(Request $request)
    {
        $user = auth()->guard('customers')->user();
        $package = getRegistrationPackage($request->registration_package_id);
        if ($user->registration_package_id == $request->registration_package_id) {
            $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_2']);
            $message_2 = isset($general_messages['message_2']) ? $general_messages['message_2'] : '';

            return $this->errorResponse($message_2);
        }

        if (isset($request->payment_method) && $request->payment_method == 'paypal') {
            Customer::whereId($user->id)->update([
                'is_auto_renew' => 1
            ]);
            $type = isset($request->type) ? $request->type : 'account_setting_upgrade';
            $paymentService = new PaymentService;
            $paypalResponse = $paymentService->paypalUpgradePackage($package, $user, $request, $type);

            if ($paypalResponse['status'] == 'Error') {
                return $this->errorResponse($paypalResponse['message']);
            } else if ($paypalResponse['status'] == 'Success') {
                if (isset($paypalResponse['type']) && $paypalResponse['type'] == 'no_redirect') {

                    $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_15']);
                    $message_15 = isset($general_messages['message_15']) ? $general_messages['message_15'] : '';


                    return $this->successResponse(
                        new RegistrationPackageResource($package),
                        $message_15,
                    );
                } else {

                    $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_15']);
                    $message_15 = isset($general_messages['message_15']) ? $general_messages['message_15'] : '';


                    return $this->successResponse(
                        [
                            'type' => 'paypal',
                            'redirect_url' => $paypalResponse['redirect_url'],
                        ],
                        $message_15,
                    );
                }
            }
            return $this->errorResponse();
        }
        $validationRule = [
            'registration_package_id' => ['required', 'exists:App\Models\RegistrationPackage,id'],
            'customer_payment_method_id' => ['required'],
            'card_holder_name' => ['nullable', 'required_if:customer_payment_method_id,add_new_card'],
            'card_no' => ['nullable', 'required_if:customer_payment_method_id,add_new_card', new CardNumber],
            'expiry_month' => ['nullable', 'required_if:customer_payment_method_id,add_new_card', 'min:01', 'max:12'],
            'expiry_year' => ['nullable', 'required_if:customer_payment_method_id,add_new_card', 'digits:4'],
            'cvc' => ['nullable', 'required_if:customer_payment_method_id,add_new_card', 'min:3', 'max:4'],
            'payment_method' => ['required', 'in:stripe,paypal'],
        ];

        $payment_setting = getI2bModalSetting(null, ['payment_setting']);

        $niceNames = [];
        $niceNames['card_holder_name'] = isset($payment_setting['cardholder_name_error']) ? $payment_setting['cardholder_name_error'] : '';
        $niceNames['card_no'] = isset($payment_setting['card_number_error']) ? $payment_setting['card_number_error'] : '';
        $niceNames['expiry_month'] = isset($payment_setting['expiry_month_error']) ? $payment_setting['expiry_month_error'] : '';
        $niceNames['expiry_year'] = isset($payment_setting['expiry_year_error']) ? $payment_setting['expiry_year_error'] : '';
        $niceNames['cvc'] = isset($payment_setting['cvv_error']) ? $payment_setting['cvv_error'] : '';

        $this->validate(
            $request,
            $validationRule,
            [],
            $niceNames
        );


        if ($request->payment_method == 'stripe') {
            Customer::whereId($user->id)->update([
                'is_auto_renew' => 1
            ]);

            try {
                $stripeService = new StripeService();

                $stripeResponse = $stripeService->upgradeUserAccount($request, $user, $package);
                if (isset($stripeResponse['status']) && $stripeResponse['status'] == 'error') {
                    return $this->errorResponse($stripeResponse['message']);
                } else if (isset($stripeResponse['status']) && $stripeResponse['status'] == 'success') {
                    if ($user->payment_method == 'paypal') {
                        if ($user->paypal_subscription_id) {
                            $amount = 0;

                            // Get the previous package data
                            $prevPackagePrice = $user->package_price;
                            $prevPackageStartDate = new \DateTime($user->package_subscribed_date);
                            $prevPackageEndDate = new \DateTime($user->package_expiry_date);

                            // Calculate the per-day price of the previous package
                            $diffInTime = $prevPackageEndDate->getTimestamp() - $prevPackageStartDate->getTimestamp();
                            $totalDaysOfPrevPackage = $diffInTime / (60 * 60 * 24);
                            $prevPackagePerDayPrice = $prevPackagePrice / $totalDaysOfPrevPackage;

                            // Calculate the remaining days of the previous package
                            $today = new \DateTime();
                            $remainingDays = ($prevPackageEndDate->getTimestamp() - $today->getTimestamp()) / (60 * 60 * 24);

                            // Ensure remaining days are positive
                            if ($remainingDays > 0) {
                              // Calculate the price to be deducted based on remaining days
                              $amount = $prevPackagePerDayPrice * $remainingDays;
                            }

                            if ($amount > 0) {
                                Log::info('refund amount = ' . $amount);
                                // Get the sale ID for the subscription
                                $client = new Client();
                                $paypalService = new PaypalService;

                                $subscription = $client->get(env('PAYPAL_BASE_URL') . '/billing/subscriptions/' . $user->paypal_subscription_id, [
                                    'headers' => [
                                        'Content-Type' => 'application/json',
                                        'Authorization' => 'Bearer ' . $paypalService->paypalToken(),
                                    ],
                                ]);
                                $subscriptionBody = $subscription->getBody()->getContents();
                                $subscriptionData = json_decode($subscriptionBody, true);

                                $saleId = $subscriptionData['billing_info']['last_payment']['sale_id'] ?? null;
                                Log::info('Sale id = ' . $saleId);

                                if ($saleId) {
                                    $paypalService = new PaypalService();
                                    $refundPaypalResponse = $paypalService->refundPayPalSale($user->paypal_subscription_id, $amount);
                                    Log::info('refund paypal response = ' . $refundPaypalResponse);
                                } else {
                                    Log::info('No sale ID found for subscription');
                                }
                            }

                            $paymentService = new PaymentService();
                            $paymentService->cancelPayPalSubscription($user);
                        }
                    }
                }
            } catch (\Exception $e) {
                return $this->errorResponse($e->getMessage());
            }
            $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_15']);
            $message_15 = isset($general_messages['message_15']) ? $general_messages['message_15'] : '';

            return $this->successResponse(new RegistrationPackageResource($package), $message_15);
        }
        return $this->errorResponse();
    }
}
