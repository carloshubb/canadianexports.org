<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class EventSignupSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'event_signup_setting_id' => $this->event_signup_setting_id,
            'language_id' => $this->language_id,
            'profile_section_heading' => $this->profile_section_heading,
            'name_label' => $this->name_label,
            'name_error' => $this->name_error,
            'business_name_label' => $this->business_name_label,
            'business_name_error' => $this->business_name_error,
            'organizer_website_label' => $this->organizer_website_label,
            'your_profile_heading' => $this->your_profile_heading,
            'the_organizer_heading' => $this->the_organizer_heading,
            'contact_person_heading' => $this->contact_person_heading,
            'organizer_phone_label' => $this->organizer_phone_label,
            'mailing_address_label' => $this->mailing_address_label,
            'contact_name_label' => $this->contact_name_label,
            'contact_phone_label' => $this->contact_phone_label,
            'contact_phone_hint' => $this->contact_phone_hint,
            'contact_email_label' => $this->contact_email_label,
            'contact_email_hint' => $this->contact_email_hint,
            'contact_photo_label' => $this->contact_photo_label,
            'contact_photo_tooltip' => $this->contact_photo_tooltip,
            'main_event_image_label' => $this->main_event_image_label,
            'main_event_image_hint' => $this->main_event_image_hint,
            'photo_gallery_heading' => $this->photo_gallery_heading,
            'photo_gallery_label' => $this->photo_gallery_label,
            'photo_gallery_subtitle_featured' => $this->photo_gallery_subtitle_featured,
            'photo_gallery_subtitle_premium' => $this->photo_gallery_subtitle_premium,
            'update_btn_text' => $this->update_btn_text,
            'privacy_heading' => $this->privacy_heading,
            'privacy_bullet_1' => $this->privacy_bullet_1,
            'privacy_bullet_2' => $this->privacy_bullet_2,
            'privacy_bullet_3' => $this->privacy_bullet_3,
            'email_label' => $this->email_label,
            'email_error' => $this->email_error,
            'password_label' => $this->password_label,
            'password_placeholder' => $this->password_placeholder,
            'password_error' => $this->password_error,
            'confirm_password_label' => $this->confirm_password_label,
            'confirm_password_error' => $this->confirm_password_error,
            'free_package_text' => $this->free_package_text,
            'featured_package_text' => $this->featured_package_text,
            'premium_package_text' => $this->premium_package_text,
            'package_error' => $this->package_error,
            'package_section_heading' => $this->package_section_heading,
            'organizer_contact_section_heading' => $this->organizer_contact_section_heading,
            'event_section_heading' => $this->event_section_heading,
            'contact_section_heading' => $this->contact_section_heading,
            'media_section_heading' => $this->media_section_heading,
            'button_text' => $this->button_text,

            'event_signup_setting' => new EventSignupSettingResource($this->whenLoaded('eventSignupSetting')),
        ];
    }
}
