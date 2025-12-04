<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Mail\AutoResponseToCustomerMail;
use App\Mail\SponsorMail;
use App\Models\Banner;
use App\Models\Sponsor;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SponsorController extends Controller
{
    use StatusResponser;


    public function sendMessage(Request $request)
    {
        $data = $this->validate($request, [
            "email" => "required|email",
            "contact" => "required|string",
            'captcha' => 'required'
        ]);
        $isValid = $this->isValid($request->captcha);
        if (!$isValid) {
            return 'capcha failed.';
        }

        $general_setting = getGeneralSettingByKey();
        if (isset($general_setting['admin_email'])) {
            $adminEmailsArr = explode(',', $general_setting['admin_email']);
        }
        if (isset($adminEmailsArr) && count($adminEmailsArr) > 1) {
            $to_email = $adminEmailsArr[0];
            unset($adminEmailsArr[0]);
            Mail::to($to_email)->cc($adminEmailsArr)->send(new SponsorMail($data));
        } else {
            $to_email = isset($adminEmailsArr[0]) ? $adminEmailsArr[0] : null;
            if ($to_email) {
                Mail::to($to_email)->send(new SponsorMail($data));
            }
        }
        Mail::to($request->email)->send(new AutoResponseToCustomerMail([]));

        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_16']);
        $message_16 = isset($general_messages['message_16']) ? $general_messages['message_16'] : '';

        return $this->successResponse([], $message_16);
    }

    public function isValid($captcha)
    {
        try {

            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $data = [
                'secret'   => config('services.recaptcha.secret'),
                'response' => $captcha,
                'remoteip' => $_SERVER['REMOTE_ADDR']
            ];

            $options = [
                'http' => [
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                ]
            ];

            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            return json_decode($result)->success;
        } catch (\Exception $e) {
            return null;
        }
    }

    function show($abbreviation, $slug)
    {
        // Try new sponsors table first
        $sponsor = Sponsor::with(['logoMedia', 'featuredMedia', 'beneficiary'])
            ->where('slug', $slug)
            ->orWhere('id', $slug)
            ->where('status', 'active')
            ->where('is_visible', true)
            ->first();

        // If found in new table, use it
        if ($sponsor) {
            return view('web.sponsor.show', compact('sponsor'));
        }

        // Fallback to old banners table for backward compatibility
        $banner = Banner::with('mediaImage')
            ->whereSlug($slug)
            ->orWhere('id', $slug)
            ->where('type', 'sponsor')
            ->firstOrFail();

        // For backward compatibility, pass as 'sponsor' to the view
        $sponsor = $banner;
        return view('web.sponsor.show', compact('sponsor', 'banner'));
    }
}
