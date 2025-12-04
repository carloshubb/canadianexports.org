<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class LoginPageSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'login_page_setting_id' => $this->login_page_setting_id,
            'language_id' => $this->language_id,
            'required_fields_text' => $this->required_fields_text,
            'main_heading' => $this->main_heading,
            'email_label' => $this->email_label,
            'email_error' => $this->email_error,
            'email_help' => $this->email_help,
            'password_label' => $this->password_label,
            'password_error' => $this->password_error,
            'remeber_me_label' => $this->remeber_me_label,
            'forgot_password_text' => $this->forgot_password_text,
            'signin_btn_text' => $this->signin_btn_text,
            'signup_btn_text' => $this->signup_btn_text,
            'signup_btn_url' => $this->signup_btn_url,
            'protect_account_heading' => $this->protect_account_heading,
            'protect_account_description' => $this->protect_account_description,

            'login_page_setting' => new LoginPageSettingResource($this->whenLoaded('loginPageSetting')),
        ];
    }
}
