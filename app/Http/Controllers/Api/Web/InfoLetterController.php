<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Mail\AutoResponseToCustomerMail;
use App\Mail\InfoLetterSubscriptionMail;
use App\Mail\InfoLetterMail;
use App\Models\InfoLetter;
use App\Models\Page;
use App\Services\EmailSettingService;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class InfoLetterController extends Controller
{
    use StatusResponser;


    public function sendMessage(Request $request)
    {
        $niceNames = [];
        $defaultLang = getDefaultLanguage(1);
        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            $infoLetterSetting = getInfoLetterSetting($defaultLang, Page::whereId($request->page_id)->first());
            $infoLetterSettingDetail = $infoLetterSetting->infoLetterSettingDetail;
            $niceNames = [
                'company_name' => isset($infoLetterSettingDetail[0]->company_name_error) ? $infoLetterSettingDetail[0]->company_name_error : '',
                'name' => isset($infoLetterSettingDetail[0]->name_error) ? $infoLetterSettingDetail[0]->name_error : '',
                'email' => isset($infoLetterSettingDetail[0]->email_error) ? $infoLetterSettingDetail[0]->email_error : '',
                'country' => isset($infoLetterSettingDetail[0]->country_error) ? $infoLetterSettingDetail[0]->country_error : '',
            ];
        }
        $data = $this->validate($request, [
            "company_name" => "required|string|max:255",
            "name" => "required|string|max:255",
            "email" => "required|email",
            "country" => "required|string",
        ], [], $niceNames);

        $emailService = new EmailSettingService();
        $result = $emailService->canadianExportersForm();
        if ($result['status'] == 'Error') {
            return $result;
        }

        $subscribeHash = Hash::make($request->email);
        $subscribeHash = str_replace('===', '/', $subscribeHash);

        InfoLetter::create([
            'email_sent_by' => Auth::guard('customers')->check() ? Auth::guard('customers')->user()->id : null,
            'name' => $request->name,
            'email' => $request->email,
            'company_name' => $request->company_name,
            'country' => $request->country,
            'is_subscribe' => true,
            'subscribe_hash' => $subscribeHash,
        ]);
        $data['subscribe_hash'] = $subscribeHash;

        $general_setting = getGeneralSettingByKey();
        if (isset($general_setting['admin_email'])) {
            $adminEmailsArr = explode(',', $general_setting['admin_email']);
        }
        if (isset($adminEmailsArr) && count($adminEmailsArr) > 1) {
            $to_email = $adminEmailsArr[0];
            unset($adminEmailsArr[0]);
            Mail::to($to_email)->cc($adminEmailsArr)->send(new InfoLetterMail($data));
        } else {
            $to_email = isset($adminEmailsArr[0]) ? $adminEmailsArr[0] : null;
            if ($to_email) {
                Mail::to($to_email)->send(new InfoLetterMail($data));
            }
        }

        Mail::to($request->email)->send(new InfoLetterSubscriptionMail($data));

        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_45']);
        $message_45 = isset($general_messages['message_45']) ? $general_messages['message_45'] : '';

        return $this->successResponse([], $message_45);
    }
}
