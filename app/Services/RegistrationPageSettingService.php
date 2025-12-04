<?php

namespace App\Services;

use App\Models\RegPageSettingDetail;

class RegistrationPageSettingService
{
    public function validation($languages, $validationRule, $errorMessages)
    {
        foreach ($languages as $language) {
            $validationRule = array_merge($validationRule, ['page_title.page_title_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['page_title.page_title_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['page_description.page_description_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['page_description.page_description_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_1_heading.step_1_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_1_heading.step_1_heading_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_1_acc_heading.step_1_acc_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_1_acc_heading.step_1_acc_heading_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_1_acc_description.step_1_acc_description_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['step_1_description.step_1_description_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_1_description.step_1_description_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_1_auto_renew_label.step_1_auto_renew_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_1_auto_renew_label.step_1_auto_renew_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step1_free_pkg_text.step1_free_pkg_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step1_free_pkg_text.step1_free_pkg_text_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step1_feature_pkg_text.step1_feature_pkg_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step1_feature_pkg_text.step1_feature_pkg_text_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step1_premium_pkg_text.step1_premium_pkg_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step1_premium_pkg_text.step1_premium_pkg_text_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_2_heading.step_2_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_2_heading.step_2_heading_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_2_acc_heading.step_2_acc_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_2_acc_heading.step_2_acc_heading_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_2_acc_description.step_2_acc_description_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_2_acc_description.step_2_acc_description_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_2_name_label.step_2_name_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_2_name_label.step_2_name_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_2_name_error.step_2_name_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_2_name_error.step_2_name_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_2_name_placeholder.step_2_name_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_2_name_placeholder.step_2_name_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_2_email_label.step_2_email_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_2_email_label.step_2_email_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_2_email_error.step_2_email_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_2_email_error.step_2_email_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_2_email_placeholder.step_2_email_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_2_email_placeholder.step_2_email_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_2_password_label.step_2_password_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_2_password_label.step_2_password_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_2_password_error.step_2_password_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_2_password_error.step_2_password_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_2_password_placeholder.step_2_password_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_2_password_placeholder.step_2_password_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_2_confirm_password_label.step_2_confirm_password_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_2_confirm_password_label.step_2_confirm_password_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_2_confirm_password_error.step_2_confirm_password_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_2_confirm_password_error.step_2_confirm_password_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_2_confirm_password_placeholder.step_2_confirm_password_placeholder_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['step_2_profile_image_label.step_2_profile_image_label_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['step_2_profile_image_placeholder.step_2_profile_image_placeholder_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['step_2_profile_image_error.step_2_profile_image_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_2_confirm_password_placeholder.step_2_confirm_password_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_3_heading.step_3_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_3_heading.step_3_heading_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_3_acc_heading.step_3_acc_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_3_acc_heading.step_3_acc_heading_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_3_description.step_3_description_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_3_description.step_3_description_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_3_business_categories_label.step_3_business_categories_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_3_business_categories_label.step_3_business_categories_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_3_business_categories_error.step_3_business_categories_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_3_business_categories_error.step_3_business_categories_error_' . $language->id . '.required' => 'This field is required.']);

            // $validationRule = array_merge($validationRule, ['step_3_business_categories_placeholder.step_3_business_categories_placeholder_' . $language->id => ['nullable', 'string']]);
            // $errorMessages = array_merge($errorMessages, ['step_3_business_categories_placeholder.step_3_business_categories_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_heading.step_4_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_heading.step_4_heading_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_acc_heading.step_4_acc_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_acc_heading.step_4_acc_heading_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_name_label.step_4_name_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_name_label.step_4_name_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_name_error.step_4_name_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_name_error.step_4_name_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_name_placeholder.step_4_name_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_name_placeholder.step_4_name_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_email_label.step_4_email_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_email_label.step_4_email_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_email_error.step_4_email_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_email_error.step_4_email_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_email_placeholder.step_4_email_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_email_placeholder.step_4_email_placeholder_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['step_4_cta_link_label.step_4_cta_link_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_cta_link_label.step_4_cta_link_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_cta_link_error.step_4_cta_link_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_cta_link_error.step_4_cta_link_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_cta_link_placeholder.step_4_cta_link_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_cta_link_placeholder.step_4_cta_link_placeholder_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['step_4_cta_btn_label.step_4_cta_btn_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_cta_btn_label.step_4_cta_btn_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_cta_btn_error.step_4_cta_btn_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_cta_btn_error.step_4_cta_btn_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_cta_btn_placeholder.step_4_cta_btn_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_cta_btn_placeholder.step_4_cta_btn_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_address_label.step_4_address_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_address_label.step_4_address_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_address_error.step_4_address_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_address_error.step_4_address_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_address_placeholder.step_4_address_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_address_placeholder.step_4_address_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_phone_label.step_4_phone_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_phone_label.step_4_phone_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_phone_error.step_4_phone_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_phone_error.step_4_phone_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_phone_placeholder.step_4_phone_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_phone_placeholder.step_4_phone_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_website_label.step_4_website_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_website_label.step_4_website_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_website_error.step_4_website_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_website_error.step_4_website_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_website_placeholder.step_4_website_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_website_placeholder.step_4_website_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_short_description_label.step_4_short_description_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_short_description_label.step_4_short_description_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_short_description_error.step_4_short_description_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_short_description_error.step_4_short_description_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_short_description_placeholder.step_4_short_description_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_short_description_placeholder.step_4_short_description_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_description_label.step_4_description_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_description_label.step_4_description_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_description_error.step_4_description_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_description_error.step_4_description_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_description_placeholder.step_4_description_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_description_placeholder.step_4_description_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_keywords_label.step_4_keywords_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_keywords_label.step_4_keywords_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_keywords_error.step_4_keywords_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_keywords_error.step_4_keywords_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_4_keywords_placeholder.step_4_keywords_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_4_keywords_placeholder.step_4_keywords_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['pre_media_tab_description.pre_media_tab_description_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['pre_media_tab_description.pre_media_tab_description_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_5_heading.step_5_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_5_heading.step_5_heading_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_5_title_label.step_5_title_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_5_title_label.step_5_title_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_5_title_error.step_5_title_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_5_title_error.step_5_title_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_5_title_placeholder.step_5_title_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_5_title_placeholder.step_5_title_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_5_description_label.step_5_description_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_5_description_label.step_5_description_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_5_description_error.step_5_description_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_5_description_error.step_5_description_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_5_description_placeholder.step_5_description_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_5_description_placeholder.step_5_description_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_5_acc_heading.step_5_acc_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_5_acc_heading.step_5_acc_heading_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_5_logo_label.step_5_logo_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_5_logo_label.step_5_logo_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_5_logo_error.step_5_logo_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_5_logo_error.step_5_logo_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_5_logo_placeholder.step_5_logo_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_5_logo_placeholder.step_5_logo_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_5_video_label.step_5_video_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_5_video_label.step_5_video_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_5_video_error.step_5_video_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_5_video_error.step_5_video_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_5_video_placeholder.step_5_video_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_5_video_placeholder.step_5_video_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_5_gallery_image_label.step_5_gallery_image_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_5_gallery_image_label.step_5_gallery_image_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_5_gallery_image_placeholder.step_5_gallery_image_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_5_gallery_image_placeholder.step_5_gallery_image_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_5_gallery_image_error.step_5_gallery_image_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_5_gallery_image_error.step_5_gallery_image_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_6_heading.step_6_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_6_heading.step_6_heading_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_6_acc_heading.step_6_acc_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_6_acc_heading.step_6_acc_heading_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_6_facebook_label.step_6_facebook_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_6_facebook_label.step_6_facebook_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_6_facebook_error.step_6_facebook_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_6_facebook_error.step_6_facebook_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_6_facebook_placeholder.step_6_facebook_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_6_facebook_placeholder.step_6_facebook_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_6_twitter_label.step_6_twitter_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_6_twitter_label.step_6_twitter_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_6_twitter_error.step_6_twitter_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_6_twitter_error.step_6_twitter_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_6_twitter_placeholder.step_6_twitter_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_6_twitter_placeholder.step_6_twitter_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_6_youtube_label.step_6_youtube_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_6_youtube_label.step_6_youtube_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_6_youtube_error.step_6_youtube_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_6_youtube_error.step_6_youtube_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_6_youtube_placeholder.step_6_youtube_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_6_youtube_placeholder.step_6_youtube_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_6_linkedin_label.step_6_linkedin_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_6_linkedin_label.step_6_linkedin_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_6_linkedin_error.step_6_linkedin_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_6_linkedin_error.step_6_linkedin_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_6_linkedin_placeholder.step_6_linkedin_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['step_6_linkedin_placeholder.step_6_linkedin_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['step_6_social_media5_label.step_6_social_media5_label_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['step_6_social_media5_placeholder.step_6_social_media5_placeholder_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['step_6_social_media5_error.step_6_social_media5_error_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['terms_and_conditions_label.terms_and_conditions_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['terms_and_conditions_label.terms_and_conditions_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['terms_and_conditions_error.terms_and_conditions_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['terms_and_conditions_error.terms_and_conditions_error_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['greeting_text.greeting_text_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['submit_button_text.submit_button_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['submit_button_text.submit_button_text_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['footer_text.footer_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['footer_text.footer_text_' . $language->id . '.required' => 'This field is required.']);
        }
        return ['validation_rules' => $validationRule, 'error_messages' => $errorMessages];
    }

    public function fields($regPageSetting, $language, $request)
    {
        return [
            'reg_page_setting_id' => $regPageSetting->id,
            'language_id' => $language->id,
            'page_title' => $request['page_title']['page_title_' . $language->id] ?? null,
            'page_description' => $request['page_description']['page_description_' . $language->id] ?? null,
            'step_1_heading' => $request['step_1_heading']['step_1_heading_' . $language->id] ?? null,
            'step_1_acc_heading' => $request['step_1_acc_heading']['step_1_acc_heading_' . $language->id] ?? null,
            'step_1_acc_description' => $request['step_1_acc_description']['step_1_acc_description_' . $language->id] ?? null,
            'step_1_description' => $request['step_1_description']['step_1_description_' . $language->id] ?? null,
            'step_1_auto_renew_label' => $request['step_1_auto_renew_label']['step_1_auto_renew_label_' . $language->id] ?? null,
            'step1_free_pkg_text' => $request['step1_free_pkg_text']['step1_free_pkg_text_' . $language->id] ?? null,
            'step1_feature_pkg_text' => $request['step1_feature_pkg_text']['step1_feature_pkg_text_' . $language->id] ?? null,
            'step1_premium_pkg_text' => $request['step1_premium_pkg_text']['step1_premium_pkg_text_' . $language->id] ?? null,
            'step_2_heading' => $request['step_2_heading']['step_2_heading_' . $language->id] ?? null,
            'step_2_acc_heading' => $request['step_2_acc_heading']['step_2_acc_heading_' . $language->id] ?? null,
            'step_2_acc_description' => $request['step_2_acc_description']['step_2_acc_description_' . $language->id] ?? null,
            'step_2_name_label' => $request['step_2_name_label']['step_2_name_label_' . $language->id] ?? null,
            'step_2_name_error' => $request['step_2_name_error']['step_2_name_error_' . $language->id] ?? null,
            'step_2_name_placeholder' => $request['step_2_name_placeholder']['step_2_name_placeholder_' . $language->id] ?? null,
            'step_2_email_label' => $request['step_2_email_label']['step_2_email_label_' . $language->id] ?? null,
            'step_2_email_error' => $request['step_2_email_error']['step_2_email_error_' . $language->id] ?? null,
            'step_2_email_placeholder' => $request['step_2_email_placeholder']['step_2_email_placeholder_' . $language->id] ?? null,
            'step_2_password_label' => $request['step_2_password_label']['step_2_password_label_' . $language->id] ?? null,
            'step_2_password_error' => $request['step_2_password_error']['step_2_password_error_' . $language->id] ?? null,
            'step_2_password_placeholder' => $request['step_2_password_placeholder']['step_2_password_placeholder_' . $language->id] ?? null,
            'step_2_confirm_password_label' => $request['step_2_confirm_password_label']['step_2_confirm_password_label_' . $language->id] ?? null,
            'step_2_confirm_password_error' => $request['step_2_confirm_password_error']['step_2_confirm_password_error_' . $language->id] ?? null,
            'step_2_confirm_password_placeholder' => $request['step_2_confirm_password_placeholder']['step_2_confirm_password_placeholder_' . $language->id] ?? null,
            'step_2_profile_image_label' => $request['step_2_profile_image_label']['step_2_profile_image_label_' . $language->id] ?? null,
            'step_2_profile_image_placeholder' => $request['step_2_profile_image_placeholder']['step_2_profile_image_placeholder_' . $language->id] ?? null,
            'step_2_profile_image_error' => $request['step_2_profile_image_error']['step_2_profile_image_error_' . $language->id] ?? null,
            'step_3_heading' => $request['step_3_heading']['step_3_heading_' . $language->id] ?? null,
            'step_3_acc_heading' => $request['step_3_acc_heading']['step_3_acc_heading_' . $language->id] ?? null,
            'step_3_description' => $request['step_3_description']['step_3_description_' . $language->id] ?? null,
            'step_3_business_categories_label' => $request['step_3_business_categories_label']['step_3_business_categories_label_' . $language->id] ?? null,
            'step_3_business_categories_error' => $request['step_3_business_categories_error']['step_3_business_categories_error_' . $language->id] ?? null,
            // 'step_3_business_categories_placeholder' => $request['step_3_business_categories_placeholder']['step_3_business_categories_placeholder_' . $language->id] ?? null,
            'step_4_heading' => $request['step_4_heading']['step_4_heading_' . $language->id] ?? null,
            'step_4_acc_heading' => $request['step_4_acc_heading']['step_4_acc_heading_' . $language->id] ?? null,
            'step_4_name_label' => $request['step_4_name_label']['step_4_name_label_' . $language->id] ?? null,
            'step_4_name_error' => $request['step_4_name_error']['step_4_name_error_' . $language->id] ?? null,
            'step_4_name_placeholder' => $request['step_4_name_placeholder']['step_4_name_placeholder_' . $language->id] ?? null,
            'step_4_email_label' => $request['step_4_email_label']['step_4_email_label_' . $language->id] ?? null,
            'step_4_email_error' => $request['step_4_email_error']['step_4_email_error_' . $language->id] ?? null,
            'step_4_email_placeholder' => $request['step_4_email_placeholder']['step_4_email_placeholder_' . $language->id] ?? null,
            'step_4_cta_link_label' => $request['step_4_cta_link_label']['step_4_cta_link_label_' . $language->id] ?? null,
            'step_4_cta_link_error' => $request['step_4_cta_link_error']['step_4_cta_link_error_' . $language->id] ?? null,
            'step_4_cta_link_placeholder' => $request['step_4_cta_link_placeholder']['step_4_cta_link_placeholder_' . $language->id] ?? null,
            'step_4_cta_btn_label' => $request['step_4_cta_btn_label']['step_4_cta_btn_label_' . $language->id] ?? null,
            'step_4_cta_btn_error' => $request['step_4_cta_btn_error']['step_4_cta_btn_error_' . $language->id] ?? null,
            'step_4_cta_btn_placeholder' => $request['step_4_cta_btn_placeholder']['step_4_cta_btn_placeholder_' . $language->id] ?? null,

            'step_4_address_label' => $request['step_4_address_label']['step_4_address_label_' . $language->id] ?? null,
            'step_4_address_error' => $request['step_4_address_error']['step_4_address_error_' . $language->id] ?? null,
            'step_4_address_placeholder' => $request['step_4_address_placeholder']['step_4_address_placeholder_' . $language->id] ?? null,
            'step_4_phone_label' => $request['step_4_phone_label']['step_4_phone_label_' . $language->id] ?? null,
            'step_4_phone_error' => $request['step_4_phone_error']['step_4_phone_error_' . $language->id] ?? null,
            'step_4_phone_placeholder' => $request['step_4_phone_placeholder']['step_4_phone_placeholder_' . $language->id] ?? null,
            'step_4_website_label' => $request['step_4_website_label']['step_4_website_label_' . $language->id] ?? null,
            'step_4_website_error' => $request['step_4_website_error']['step_4_website_error_' . $language->id] ?? null,
            'step_4_website_placeholder' => $request['step_4_website_placeholder']['step_4_website_placeholder_' . $language->id] ?? null,
            'step_4_short_description_label' => $request['step_4_short_description_label']['step_4_short_description_label_' . $language->id] ?? null,
            'step_4_short_description_error' => $request['step_4_short_description_error']['step_4_short_description_error_' . $language->id] ?? null,
            'step_4_short_description_placeholder' => $request['step_4_short_description_placeholder']['step_4_short_description_placeholder_' . $language->id] ?? null,
            'step_4_description_label' => $request['step_4_description_label']['step_4_description_label_' . $language->id] ?? null,
            'step_4_description_error' => $request['step_4_description_error']['step_4_description_error_' . $language->id] ?? null,
            'step_4_description_placeholder' => $request['step_4_description_placeholder']['step_4_description_placeholder_' . $language->id] ?? null,
            'step_4_keywords_label' => $request['step_4_keywords_label']['step_4_keywords_label_' . $language->id] ?? null,
            'step_4_keywords_error' => $request['step_4_keywords_error']['step_4_keywords_error_' . $language->id] ?? null,
            'step_4_keywords_placeholder' => $request['step_4_keywords_placeholder']['step_4_keywords_placeholder_' . $language->id] ?? null,
            'pre_media_tab_description' => $request['pre_media_tab_description']['pre_media_tab_description_' . $language->id] ?? null,
            'step_5_heading' => $request['step_5_heading']['step_5_heading_' . $language->id] ?? null,
            'step_5_title_label' => $request['step_5_title_label']['step_5_title_label_' . $language->id] ?? null,
            'step_5_title_error' => $request['step_5_title_error']['step_5_title_error_' . $language->id] ?? null,
            'step_5_title_placeholder' => $request['step_5_title_placeholder']['step_5_title_placeholder_' . $language->id] ?? null,
            'step_5_description_label' => $request['step_5_description_label']['step_5_description_label_' . $language->id] ?? null,
            'step_5_description_error' => $request['step_5_description_error']['step_5_description_error_' . $language->id] ?? null,
            'step_5_description_placeholder' => $request['step_5_description_placeholder']['step_5_description_placeholder_' . $language->id] ?? null,
            'step_5_acc_heading' => $request['step_5_acc_heading']['step_5_acc_heading_' . $language->id] ?? null,
            'step_5_logo_label' => $request['step_5_logo_label']['step_5_logo_label_' . $language->id] ?? null,
            'step_5_logo_error' => $request['step_5_logo_error']['step_5_logo_error_' . $language->id] ?? null,
            'step_5_logo_placeholder' => $request['step_5_logo_placeholder']['step_5_logo_placeholder_' . $language->id] ?? null,
            'step_5_video_label' => $request['step_5_video_label']['step_5_video_label_' . $language->id] ?? null,
            'step_5_video_error' => $request['step_5_video_error']['step_5_video_error_' . $language->id] ?? null,
            'step_5_video_placeholder' => $request['step_5_video_placeholder']['step_5_video_placeholder_' . $language->id] ?? null,
            'step_5_gallery_image_label' => $request['step_5_gallery_image_label']['step_5_gallery_image_label_' . $language->id] ?? null,
            'step_5_gallery_image_placeholder' => $request['step_5_gallery_image_placeholder']['step_5_gallery_image_placeholder_' . $language->id] ?? null,
            'step_5_gallery_image_error' => $request['step_5_gallery_image_error']['step_5_gallery_image_error_' . $language->id] ?? null,
            'step_6_heading' => $request['step_6_heading']['step_6_heading_' . $language->id] ?? null,
            'step_6_acc_heading' => $request['step_6_acc_heading']['step_6_acc_heading_' . $language->id] ?? null,
            'step_6_facebook_label' => $request['step_6_facebook_label']['step_6_facebook_label_' . $language->id] ?? null,
            'step_6_facebook_error' => $request['step_6_facebook_error']['step_6_facebook_error_' . $language->id] ?? null,
            'step_6_facebook_placeholder' => $request['step_6_facebook_placeholder']['step_6_facebook_placeholder_' . $language->id] ?? null,
            'step_6_twitter_label' => $request['step_6_twitter_label']['step_6_twitter_label_' . $language->id] ?? null,
            'step_6_twitter_error' => $request['step_6_twitter_error']['step_6_twitter_error_' . $language->id] ?? null,
            'step_6_twitter_placeholder' => $request['step_6_twitter_placeholder']['step_6_twitter_placeholder_' . $language->id] ?? null,
            'step_6_youtube_label' => $request['step_6_youtube_label']['step_6_youtube_label_' . $language->id] ?? null,
            'step_6_youtube_error' => $request['step_6_youtube_error']['step_6_youtube_error_' . $language->id] ?? null,
            'step_6_youtube_placeholder' => $request['step_6_youtube_placeholder']['step_6_youtube_placeholder_' . $language->id] ?? null,
            'step_6_linkedin_label' => $request['step_6_linkedin_label']['step_6_linkedin_label_' . $language->id] ?? null,
            'step_6_linkedin_error' => $request['step_6_linkedin_error']['step_6_linkedin_error_' . $language->id] ?? null,
            'step_6_linkedin_placeholder' => $request['step_6_linkedin_placeholder']['step_6_linkedin_placeholder_' . $language->id] ?? null,
            'step_6_social_media5_label' => $request['step_6_social_media5_label']['step_6_social_media5_label_' . $language->id] ?? null,
            'step_6_social_media5_placeholder' => $request['step_6_social_media5_placeholder']['step_6_social_media5_placeholder_' . $language->id] ?? null,
            'step_6_social_media5_error' => $request['step_6_social_media5_error']['step_6_social_media5_error_' . $language->id] ?? null,
            'terms_and_conditions_label' => $request['terms_and_conditions_label']['terms_and_conditions_label_' . $language->id] ?? null,
            'terms_and_conditions_error' => $request['terms_and_conditions_error']['terms_and_conditions_error_' . $language->id] ?? null,
            'greeting_text' => $request['greeting_text']['greeting_text_' . $language->id] ?? null,
            'submit_button_text' => $request['submit_button_text']['submit_button_text_' . $language->id] ?? null,
            'footer_text' => $request['footer_text']['footer_text_' . $language->id] ?? null,
        ];
    }

    public function store($regPageSetting, $language, $request)
    {
        $fields = $this->fields($regPageSetting, $language, $request);
        RegPageSettingDetail::create($fields);
        return true;
    }

    public function update($regPageSetting, $language, $request)
    {
        $fields = $this->fields($regPageSetting, $language, $request);
        RegPageSettingDetail::whereRegPageSettingId($regPageSetting->id)->whereLanguageId($language->id)->update($fields);
        return true;
    }
}
