<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Mail\AutoResponseToCustomerMail;
use App\Mail\FaqImporterMail;
use App\Services\EmailSettingService;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;

class FaqImporterController extends Controller
{
    use StatusResponser;


    public function sendMessage(Request $request)
    {
        $defaultLang = getDefaultLanguage(1);
        $niceNames = [];
        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            $setting = getFaqImporterPageSetting($defaultLang, $request->page_id);
            $niceNames = [
                'name' => $setting->faqImporterSettingDetail[0]->name_error ?? '',
                'email' => $setting->faqImporterSettingDetail[0]->email_error ?? '',
                'message' => $setting->faqImporterSettingDetail[0]->message_error ?? '',
            ];
        }
        $data = $this->validate($request, [
            "name" => "nullable",
            "email" => "nullable",
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
            Mail::to($to_email)->cc($adminEmailsArr)->send(new FaqImporterMail($data));
        } else {
            $to_email = isset($adminEmailsArr[0]) ? $adminEmailsArr[0] : null;
            if ($to_email) {
                Mail::to($to_email)->send(new FaqImporterMail($data));
            }
        }

        Mail::to($request->email)->send(new AutoResponseToCustomerMail([]));

        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_56']);
        $message_56 = isset($general_messages['message_56']) ? $general_messages['message_56'] : '';

        return $this->successResponse([], $message_56);
    }
}
