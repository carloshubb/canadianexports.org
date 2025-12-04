<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\CustomerBusinessCategory;
use App\Models\CustomerGalleryImage;
use App\Models\CustomerMedia;
use App\Models\CustomerProfile;
use App\Models\CustomerSocialMedia;
use App\Rules\MaxKeywordsRule;
use App\Rules\MaxLines;
use App\Rules\MaxWordsPerKeywordRule;
use App\Rules\ValidUrl;
use App\Rules\YoutubeUrl;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use LVR\CreditCard\CardNumber;
use Illuminate\Validation\Rule;

class CustomerProfileService
{
    use FileUploadTrait;

    function updateCustomerProfileValidation($request, $defaultLang)
    {
        $customerProfileId = CustomerProfile::whereCustomerId(Auth::guard('customers')->user()->id)->value('id');
        $request['gallery_images'] = json_decode($request->gallery_images);
        $request['business_categories_id'] = json_decode($request->business_categories_id);
        $validationRule = [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:App\Models\Customer,email,' . Auth::guard('customers')->user()->id],
            'profile_image' => ['nullable', 'string'],

            'business_categories_id' => ['required', 'array', 'max:3'],
            'business_categories_id.*' => ['required', 'exists:App\Models\BusinessCategory,id'],


            'customer_profile_address' => ['required', 'string', new MaxLines(5)],
            'customer_profile_company_email' => ['required', 'email', 'unique:App\Models\CustomerProfile,company_email,' . $customerProfileId],
            'customer_profile_company_name' => ['required', 'string'],
            'customer_profile_description' => ['required', 'string', 'maxwords:3000'],
            'customer_profile_keywords' => ['required', 'string', new MaxKeywordsRule(), new MaxWordsPerKeywordRule()],
            'customer_profile_phone' => ['required', 'string'],
            'customer_profile_cta_btn' => ['nullable', 'string'],
            'customer_profile_cta_link' => ['nullable', new ValidUrl()],
            'customer_profile_short_description' => ['required', 'string', 'maxwords:30'],
            'customer_profile_website' => ['required', new ValidUrl()],

            'customer_media_title' => ['nullable', 'string', 'maxwords:10'],
            'customer_media_description' => ['nullable', 'string', 'maxwords:50'],
            'customer_media_video' => ['nullable', new YoutubeUrl()],
            'customer_media_logo' => ['nullable', 'string'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['nullable'],

            'customer_social_media_facebook' => ['nullable', new ValidUrl()],
            'customer_social_media_linked_in' => ['nullable', new ValidUrl()],
            'customer_social_media_twitter' => ['nullable', new ValidUrl()],
            'customer_social_media_youtube' => ['nullable', new ValidUrl()],
            'customer_social_media_social_media5' => ['nullable', new ValidUrl()],
        ];

        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            $regPageSetting = getRegPageSetting();
            $regPageSettingDetail = $regPageSetting->regPageSettingDetail;
            $niceNames = [
                'name' => isset($regPageSettingDetail[0]->step_2_name_error) ? $regPageSettingDetail[0]->step_2_name_error : '',
                'email' => isset($regPageSettingDetail[0]->step_2_email_error) ? $regPageSettingDetail[0]->step_2_email_error : '',
                'profile_image' => isset($regPageSettingDetail[0]->step_2_profile_image_error) ? $regPageSettingDetail[0]->step_2_profile_image_error : '',

                'business_categories_id' => isset($regPageSettingDetail[0]->step_3_business_categories_error) ? $regPageSettingDetail[0]->step_3_business_categories_error : '',


                'customer_profile_company_email' => isset($regPageSettingDetail[0]->step_4_email_label) ? $regPageSettingDetail[0]->step_4_email_label : '',
                'customer_profile_company_name' => isset($regPageSettingDetail[0]->step_4_name_label) ? $regPageSettingDetail[0]->step_4_name_label : '',
                'customer_profile_description' => isset($regPageSettingDetail[0]->step_4_description_label) ? $regPageSettingDetail[0]->step_4_description_label : '',
                'customer_profile_keywords' => isset($regPageSettingDetail[0]->step_4_keywords_label) ? $regPageSettingDetail[0]->step_4_keywords_label : '',
                'customer_profile_phone' => isset($regPageSettingDetail[0]->step_4_phone_label) ? $regPageSettingDetail[0]->step_4_phone_label : '',
                'customer_profile_short_description' => isset($regPageSettingDetail[0]->step_4_short_description_label) ? $regPageSettingDetail[0]->step_4_short_description_label : '',
                'customer_profile_website' => isset($regPageSettingDetail[0]->step_4_website_label) ? $regPageSettingDetail[0]->step_4_website_label : '',
                'customer_profile_address' => isset($regPageSettingDetail[0]->step_4_address_label) ? $regPageSettingDetail[0]->step_4_address_label : '',
'customer_profile_cta_link' => isset($regPageSettingDetail[0]->step_4_cta_link_label) ? $regPageSettingDetail[0]->step_4_cta_link_label : '',
                'customer_profile_cta_btn' => isset($regPageSettingDetail[0]->step_4_cta_btn_label) ? $regPageSettingDetail[0]->step_4_cta_btn_label : '',

                'customer_media_title' => isset($regPageSettingDetail[0]->step_5_title_error) ? $regPageSettingDetail[0]->step_5_title_error : '',
                'customer_media_description' => isset($regPageSettingDetail[0]->step_5_description_error) ? $regPageSettingDetail[0]->step_5_description_error : '',
                'customer_media_video' => isset($regPageSettingDetail[0]->step_5_video_error) ? $regPageSettingDetail[0]->step_5_video_error : '',
                'customer_media_logo' => isset($regPageSettingDetail[0]->step_5_logo_error) ? $regPageSettingDetail[0]->step_5_logo_error : '',
                'gallery_images' => isset($regPageSettingDetail[0]->step_5_gallery_image_error) ? $regPageSettingDetail[0]->step_5_gallery_image_error : '',

                'customer_social_media_facebook' => isset($regPageSettingDetail[0]->step_6_facebook_error) ? $regPageSettingDetail[0]->step_6_facebook_error : '',
                'customer_social_media_linked_in' => isset($regPageSettingDetail[0]->step_6_linkedin_error) ? $regPageSettingDetail[0]->step_6_linkedin_error : '',
                'customer_social_media_twitter' => isset($regPageSettingDetail[0]->step_6_twitter_error) ? $regPageSettingDetail[0]->step_6_twitter_error : '',
                'customer_social_media_youtube' => isset($regPageSettingDetail[0]->step_6_youtube_error) ? $regPageSettingDetail[0]->step_6_youtube_error : '',
                'customer_social_media_social_media5' => isset($regPageSettingDetail[0]->step_6_social_media5_error) ? $regPageSettingDetail[0]->step_6_social_media5_error : '',
            ];
        }
        return ['rules' => $validationRule, 'niceNames' => $niceNames];
    }

    function ValidationForPaymentFields($request, $package, $rules)
    {
        $price = 0;
        if (isset($request->payment_frequency)) {
            if ($request->payment_frequency == 'monthly') {
                $price = $package->monthly_price;
            } else if ($request->payment_frequency == 'quarterly') {
                $price = $package->quarterly_price;
            } else if ($request->payment_frequency == 'semi_annually') {
                $price = $package->semi_annually_price;
            } else if ($request->payment_frequency == 'annually') {
                $price = $package->annually_price;
            }
        }
        if ($price > 0) {
            if (isset($request->payment_method) && $request->payment_method == 'stripe') {
                // Using Stripe Elements on the frontend; expect a payment method id only
                $rules['card_holder_name'] = ['required'];
                $rules['payment_method_id'] = ['required', 'string'];
            }
        }
        $rules['payment_method'] = ['required', 'in:stripe,paypal'];
        return $rules;
    }

    function niceNamesForPaymentFields($niceNames, $payment_setting)
    {

        $niceNames['card_holder_name'] = isset($payment_setting['cardholder_name_error']) ? $payment_setting['cardholder_name_error'] : '';
        $niceNames['payment_method_id'] = 'Payment method';
        return $niceNames;
    }

    function uploadProfileImage($request, $customer)
    {
        if (isset($request->profile_image)) {
            $media = json_decode($request->profile_image, 1);
            if ((isset($media, $media[0], $customer->profileImage) && $customer->profileImage->path != $media[0]) || (isset($media, $media[0]) && !isset($customer->profileImage))) {
                $files = $this->moveFile($media, 'media/customers', 'profile_images');
            } else {
                $files[0]['id'] = $customer->logo;
            }
            return $files;
        }
        return false;
    }

    function updateCustomer($request, $files)
    {
        Customer::whereId(Auth::guard('customers')->user()->id)->update([
            "name" => $request->name,
            "email" => $request->email,
            "profile_image_id" => isset($files, $files[0]) ? $files[0]['id'] : null,
        ]);
    }

    function updateCustomerProfile($request)
    {
        $fields = [
            'customer_id' => Auth::guard('customers')->user()->id,
            'company_name' => $request->customer_profile_company_name,
            'company_email' => $request->customer_profile_company_email,
            'short_description' => $request->customer_profile_short_description,
            'description' => $request->customer_profile_description,
            'phone' => $request->customer_profile_phone,
            'website' => $request->customer_profile_website,
            'keywords' => $request->customer_profile_keywords,
            'address' => $request->customer_profile_address,
            'cta_link' => $request->customer_profile_cta_link,
            'cta_btn' => $request->customer_profile_cta_btn,
        ];
        $customerProfile = CustomerProfile::whereCustomerId(Auth::guard('customers')->user()->id)->exists();
        if ($customerProfile) {
            CustomerProfile::whereCustomerId(Auth::guard('customers')->user()->id)->update($fields);
        } else {
            CustomerProfile::create($fields);
        }
    }

    function updateBusinessCategories($request)
    {
        CustomerBusinessCategory::whereCustomerId(Auth::guard('customers')->user()->id)->delete();
        $customerProfile = CustomerProfile::whereCustomerId(Auth::guard('customers')->user()->id)->first();
        foreach ($request->business_categories_id as $business_category_id) {
            CustomerBusinessCategory::create([
                'business_category_id' => $business_category_id,
                'customer_id' => Auth::guard('customers')->user()->id,
                'customer_profile_id' => $customerProfile->id ?? null
            ]);
        }
    }

    function updateCustomerMedia($request, $customerMedia)
    {
        if (isset($request->customer_media_logo)) {
            $media = json_decode($request->customer_media_logo, 1);
            if ((isset($media, $media[0], $customerMedia->customerLogo) && $customerMedia->customerLogo->path != $media[0]) || (isset($media, $media[0]) && !isset($customerMedia->customerLogo))) {
                $files = $this->moveFile($media, 'media/customers', 'profile_logo');
            } else {
                $files[0]['id'] = $customerMedia->logo;
            }
        }

        $customerProfile = CustomerProfile::whereCustomerId(Auth::guard('customers')->user()->id)->first();

        CustomerMedia::whereCustomerId(Auth::guard('customers')->user()->id)->update([
            "logo" => isset($files, $files[0]) ? $files[0]['id'] : null,
            "video" => $request->customer_media_video,
            "title" => $request->customer_media_title,
            "description" => $request->customer_media_description,
            "video_frame" => getVideoHtmlAttribute($request->customer_media_video),
            "customer_profile_id" => $customerProfile->id ?? null,
        ]);
    }

    function updateCustomerGalleryImage($request, $customerMedia)
    {
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
        if ($customerMedia) {
            CustomerGalleryImage::whereNotIn('media_id', $oldMediaIds)->whereCustomerMediaId($customerMedia->id)->delete();
        }
        if (isset($galleryImages)) {
            foreach ($galleryImages as $key => $image) {
                CustomerGalleryImage::create([
                    'customer_media_id' => $customerMedia->id,
                    'media_id' => $image->id,
                ]);
            }
        }
    }

    function updateCustomerSocialMedia($request)
    {
        $customerProfile = CustomerProfile::whereCustomerId(Auth::guard('customers')->user()->id)->first();
        CustomerSocialMedia::whereCustomerId(Auth::guard('customers')->user()->id)->update([
            "facebook" => $request->customer_social_media_facebook,
            "twitter" => $request->customer_social_media_twitter,
            "youtube" => $request->customer_social_media_youtube,
            "linked_in" => $request->customer_social_media_linked_in,
            "social_media5" => $request->customer_social_media_social_media5,
            "customer_profile_id" => $customerProfile->id ?? null
        ]);
    }
}
