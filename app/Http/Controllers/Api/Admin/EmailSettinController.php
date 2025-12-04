<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\EmailSettingResource;
use App\Models\EmailSetting;
use App\Models\GeneralSetting;
use App\Models\RegistrationPackage;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class EmailSettinController extends Controller
{
    use StatusResponser;


    public function index()
    {
        $emailSetting = EmailSetting::all();
        return $this->apiSuccessResponse(EmailSettingResource::collection($emailSetting), 'Data Get Successfully!');
    }

    public function store(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $packages = RegistrationPackage::whereIn('package_type', ['free', 'featured', 'premium'])->get();
        foreach ($packages as $package) {
            $validationRule = array_merge($validationRule, ['no_of_emails.no_of_emails_' . $package->id => ['required', 'string']]);
            $errorMessages = array_merge($errorMessages, ['no_of_emails.no_of_emails_' . $package->id . '.required' => 'Emails limit is required.']);
        }

        $setting = getGeneralSettingByType('email');
        foreach ($setting as $s) {
            $validationRule = array_merge($validationRule, ['canadian_exporters_emails.canadian_exporters_emails_' . $s->id => ['required', 'string']]);
            $errorMessages = array_merge($errorMessages, ['canadian_exporters_emails.canadian_exporters_emails_' . $s->id . '.required' => 'Emails limit is required.']);
        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );
        foreach ($packages as $package) {
            $emailSetting = EmailSetting::where('registration_package_id', $package->id)->exists();
            if ($emailSetting) {
                EmailSetting::where('registration_package_id', $package->id)->update([
                    'no_of_emails' => $request['no_of_emails']['no_of_emails_' . $package->id]
                ]);
            } else {
                EmailSetting::create([
                    'registration_package_id' => $package->id,
                    'no_of_emails' => $request['no_of_emails']['no_of_emails_' . $package->id]
                ]);
            }
        }
        foreach ($setting as $s) {
            $emailSetting = GeneralSetting::whereId($s->id)->exists();
            if ($emailSetting) {
                GeneralSetting::where('id', $s->id)->update([
                    'value' => $request['canadian_exporters_emails']['canadian_exporters_emails_' . $s->id]
                ]);
            }
        }

        return $this->successResponse([], 'Email setting has been updated successfully!');
        
    }
}
