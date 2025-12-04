<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Mail\AutoResponseToCustomerMail;
use App\Mail\ContactUsMail;
use App\Models\ContactForm;
use App\Services\EmailSettingService;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    use StatusResponser;


    public function sendMessage(Request $request)
    {
        $defaultLang = getDefaultLanguage(1);
        $niceNames = [];
        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            $setting = getContactUsSettingById($defaultLang, $request->page_id);
            $niceNames['name'] = isset($setting->contactUsSettingDetail[0]->name_error) ? $setting->contactUsSettingDetail[0]->name_error : '';
            $niceNames['email'] = isset($setting->contactUsSettingDetail[0]->email_error) ? $setting->contactUsSettingDetail[0]->email_error : '';
            $niceNames['message'] = isset($setting->contactUsSettingDetail[0]->message_error) ? $setting->contactUsSettingDetail[0]->message_error : '';
        }
        $data = $this->validate($request, [
            "name" => "required|string|max:255",
            "email" => "required|email",
            "message" => "required|string",
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
            Mail::to($to_email)->cc($adminEmailsArr)->send(new ContactUsMail($data));
        } else {
            $to_email = isset($adminEmailsArr[0]) ? $adminEmailsArr[0] : null;
            if ($to_email) {
                Mail::to($to_email)->send(new ContactUsMail($data));
            }
        }

        Mail::to($request->email)->send(new AutoResponseToCustomerMail([]));

        ContactForm::create([
            'email_sent_by' => Auth::guard('customers')->check() ? Auth::guard('customers')->user()->id : null,
            'name' => $request->name,
            'type' => 'contact',
            'email' => $request->email,
            'message' => $request->message,
        ]);

        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_48']);
        $message_48 = isset($general_messages['message_48']) ? $general_messages['message_48'] : '';

        return $this->successResponse([], $message_48);
    }
}
