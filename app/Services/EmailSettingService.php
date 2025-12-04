<?php

namespace App\Services;

use App\Models\EmailSetting;
use App\Traits\StatusResponser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

class EmailSettingService
{
    use StatusResponser;

    public function canadianExportersForm()
    {
        $ipAddress = Request::ip();
        $cacheKey = 'email_limit_' . $ipAddress;
        $setting = getSignleGeneralSettingByKey(['canadian_exporters_emails_per_day']);
        $emailLimit = $setting['canadian_exporters_emails_per_day']; // Number of emails allowed per 24 hours

        if (Cache::has($cacheKey)) {
            $emailCount = Cache::get($cacheKey);
            if ($emailCount >= $emailLimit) {
                $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_8']);
                $message_8 = isset($general_messages['message_8']) ? $general_messages['message_8'] : '';

                return $this->errorResponse($message_8);
            }
        } else {
            $emailCount = 0;
        }

        // Increment the email count and store it in the cache for 24 hours
        $emailCount++;
        Cache::put($cacheKey, $emailCount, now()->addDay());
        return $this->successResponse([], 'Email will be sent.');
    }

    public function advertiserForm($type)
    {
        $ipAddress = Request::ip();
        $cacheKey = $type . '_limit_' . $ipAddress;
        $email_setting = null;
        if (Auth::guard('customers')->check()) {
            $package_id = Auth::guard('customers')->user()->registration_package_id;
            $email_setting = EmailSetting::where('registration_package_id', $package_id)->first();
            if($email_setting){
                $emailLimit = $email_setting->no_of_emails;
            }
        }
        if(!$email_setting){
            $setting = getSignleGeneralSettingByKey(['canadian_exporters_emails_per_day']);
            $emailLimit = $setting['canadian_exporters_emails_per_day'];
        }

        if (Cache::has($cacheKey)) {
            $emailCount = Cache::get($cacheKey);
            if ($emailCount >= $emailLimit) {
                $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_8']);
                $message_8 = isset($general_messages['message_8']) ? $general_messages['message_8'] : '';

                return $this->errorResponse($message_8);
            }
        } else {
            $emailCount = 0;
        }

        // Increment the email count and store it in the cache for 24 hours
        $emailCount++;
        Cache::put($cacheKey, $emailCount, now()->addDay());
        return $this->successResponse([], 'Email will be sent.');
    }
}
