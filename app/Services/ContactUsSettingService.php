<?php

namespace App\Services;

use App\Models\ContactUsSettingDetail;

class ContactUsSettingService
{
    public function validation($languages, $validationRule, $errorMessages)
    {
        foreach ($languages as $language) {

            $validationRule = array_merge($validationRule, ['page_heading.page_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['page_heading.page_heading_' . $language->id . '.required' => 'Page heading in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['page_description.page_description_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['page_description.page_description_' . $language->id . '.required' => 'Description in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['mail_address_label.mail_address_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['mail_address_label.mail_address_label_' . $language->id . '.required' => 'Mail address label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['mail_address.mail_address_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['mail_address.mail_address_' . $language->id . '.required' => 'Mail address in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['website_label.website_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['website_label.website_label_' . $language->id . '.required' => 'Website label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['website.website_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['website.website_' . $language->id . '.required' => 'Website in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['toll_free_label.toll_free_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['toll_free_label.toll_free_label_' . $language->id . '.required' => 'Toll free label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['toll_free.toll_free_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['toll_free.toll_free_' . $language->id . '.required' => 'Toll free in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['general_inquires_label.general_inquires_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['general_inquires_label.general_inquires_label_' . $language->id . '.required' => 'General inquires label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['general_inquires.general_inquires_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['general_inquires.general_inquires_' . $language->id . '.required' => 'General inquires in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['telephone_label.telephone_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['telephone_label.telephone_label_' . $language->id . '.required' => 'Telephone label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['telephone.telephone_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['telephone.telephone_' . $language->id . '.required' => 'Telephone in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['sales_department_label.sales_department_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['sales_department_label.sales_department_label_' . $language->id . '.required' => 'Sales department label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['sales_department.sales_department_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['sales_department.sales_department_' . $language->id . '.required' => 'Sales department in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['fax_label.fax_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['fax_label.fax_label_' . $language->id . '.required' => 'Fax label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['fax.fax_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['fax.fax_' . $language->id . '.required' => 'Fax in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['job_at_canadian_exporters_label.job_at_canadian_exporters_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['job_at_canadian_exporters_label.job_at_canadian_exporters_label_' . $language->id . '.required' => 'Jobs at Canadian Exporters label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['job_at_canadian_exporters.job_at_canadian_exporters_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['job_at_canadian_exporters.job_at_canadian_exporters_' . $language->id . '.required' => 'Jobs at Canadian Exporters in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['e_mail_label.e_mail_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['e_mail_label.e_mail_label_' . $language->id . '.required' => 'Email label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['e_mail.e_mail_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['e_mail.e_mail_' . $language->id . '.required' => 'Email in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['office_hours_label.office_hours_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['office_hours_label.office_hours_label_' . $language->id . '.required' => 'Office hours label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['office_hours.office_hours_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['office_hours.office_hours_' . $language->id . '.required' => 'Office hours in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['heading.heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['heading.heading_' . $language->id . '.required' => 'Heading in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['required_field_text.required_field_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['required_field_text.required_field_text_' . $language->id . '.required' => 'Required fields text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['name_label.name_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['name_label.name_label_' . $language->id . '.required' => 'Name in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['name_error.name_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['name_error.name_error_' . $language->id . '.required' => 'Name error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['email_label.email_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_label.email_label_' . $language->id . '.required' => 'Email in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['email_error.email_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_error.email_error_' . $language->id . '.required' => 'Email error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['message_label.message_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['message_label.message_label_' . $language->id . '.required' => 'Message in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['message_error.message_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['message_error.message_error_' . $language->id . '.required' => 'Message error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['button_text.button_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['button_text.button_text_' . $language->id . '.required' => 'Button text in ' . $language->name . ' is required.']);
        }
        return ['validation_rules' => $validationRule, 'error_messages' => $errorMessages];
    }

    public function fields($contactUsSetting, $language, $request)
    {
        return [
            'contact_us_setting_id' => $contactUsSetting->id,
            'language_id' => $language->id,
            'page_heading' => isset($request['page_heading']['page_heading_' . $language->id]) ? $request['page_heading']['page_heading_' . $language->id] : null,
            'page_description' => isset($request['page_description']['page_description_' . $language->id]) ? $request['page_description']['page_description_' . $language->id] : null,
            'mail_address_label' => isset($request['mail_address_label']['mail_address_label_' . $language->id]) ? $request['mail_address_label']['mail_address_label_' . $language->id] : null,
            'mail_address' => isset($request['mail_address']['mail_address_' . $language->id]) ? $request['mail_address']['mail_address_' . $language->id] : null,
            'website_label' => isset($request['website_label']['website_label_' . $language->id]) ? $request['website_label']['website_label_' . $language->id] : null,
            'website' => isset($request['website']['website_' . $language->id]) ? $request['website']['website_' . $language->id] : null,
            'toll_free_label' => isset($request['toll_free_label']['toll_free_label_' . $language->id]) ? $request['toll_free_label']['toll_free_label_' . $language->id] : null,
            'toll_free' => isset($request['toll_free']['toll_free_' . $language->id]) ? $request['toll_free']['toll_free_' . $language->id] : null,
            'general_inquires_label' => isset($request['general_inquires_label']['general_inquires_label_' . $language->id]) ? $request['general_inquires_label']['general_inquires_label_' . $language->id] : null,
            'general_inquires' => isset($request['general_inquires']['general_inquires_' . $language->id]) ? $request['general_inquires']['general_inquires_' . $language->id] : null,
            'telephone_label' => isset($request['telephone_label']['telephone_label_' . $language->id]) ? $request['telephone_label']['telephone_label_' . $language->id] : null,
            'telephone' => isset($request['telephone']['telephone_' . $language->id]) ? $request['telephone']['telephone_' . $language->id] : null,
            'sales_department_label' => isset($request['sales_department_label']['sales_department_label_' . $language->id]) ? $request['sales_department_label']['sales_department_label_' . $language->id] : null,
            'sales_department' => isset($request['sales_department']['sales_department_' . $language->id]) ? $request['sales_department']['sales_department_' . $language->id] : null,
            'fax_label' => isset($request['fax_label']['fax_label_' . $language->id]) ? $request['fax_label']['fax_label_' . $language->id] : null,
            'fax' => isset($request['fax']['fax_' . $language->id]) ? $request['fax']['fax_' . $language->id] : null,
            'job_at_canadian_exporters_label' => isset($request['job_at_canadian_exporters_label']['job_at_canadian_exporters_label_' . $language->id]) ? $request['job_at_canadian_exporters_label']['job_at_canadian_exporters_label_' . $language->id] : null,
            'job_at_canadian_exporters' => isset($request['job_at_canadian_exporters']['job_at_canadian_exporters_' . $language->id]) ? $request['job_at_canadian_exporters']['job_at_canadian_exporters_' . $language->id] : null,
            'e_mail_label' => isset($request['e_mail_label']['e_mail_label_' . $language->id]) ? $request['e_mail_label']['e_mail_label_' . $language->id] : null,
            'e_mail' => isset($request['e_mail']['e_mail_' . $language->id]) ? $request['e_mail']['e_mail_' . $language->id] : null,
            'office_hours_label' => isset($request['office_hours_label']['office_hours_label_' . $language->id]) ? $request['office_hours_label']['office_hours_label_' . $language->id] : null,
            'office_hours' => isset($request['office_hours']['office_hours_' . $language->id]) ? $request['office_hours']['office_hours_' . $language->id] : null,
            'heading' => isset($request['heading']['heading_' . $language->id]) ? $request['heading']['heading_' . $language->id] : null,
            'required_field_text' => isset($request['required_field_text']['required_field_text_' . $language->id]) ? $request['required_field_text']['required_field_text_' . $language->id] : null,
            'name_label' => isset($request['name_label']['name_label_' . $language->id]) ? $request['name_label']['name_label_' . $language->id] : null,
            'name_error' => isset($request['name_error']['name_error_' . $language->id]) ? $request['name_error']['name_error_' . $language->id] : null,
            'email_label' => isset($request['email_label']['email_label_' . $language->id]) ? $request['email_label']['email_label_' . $language->id] : null,
            'email_error' => isset($request['email_error']['email_error_' . $language->id]) ? $request['email_error']['email_error_' . $language->id] : null,
            'message_label' => isset($request['message_label']['message_label_' . $language->id]) ? $request['message_label']['message_label_' . $language->id] : null,
            'message_error' => isset($request['message_error']['message_error_' . $language->id]) ? $request['message_error']['message_error_' . $language->id] : null,
            'button_text' => isset($request['button_text']['button_text_' . $language->id]) ? $request['button_text']['button_text_' . $language->id] : null,
        ];
    }

    public function store($contactUsSetting, $language, $request)
    {
        $fields = $this->fields($contactUsSetting, $language, $request);
        ContactUsSettingDetail::create($fields);
        return true;
    }

    public function update($contactUsSetting, $language, $request)
    {
        $fields = $this->fields($contactUsSetting, $language, $request);
        ContactUsSettingDetail::whereContactUsSettingId($contactUsSetting->id)->whereLanguageId($language->id)->update($fields);
        return true;
    }
}
