<?php

namespace App\Services;

use App\Models\HomePageSettingDetail;

class HomePageSettingService
{
    public function validation($languages, $validationRule, $errorMessages)
    {
        foreach ($languages as $language) {
            $validationRule = array_merge($validationRule, ['slider_heading.slider_heading_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['slider_search_placeholder.slider_search_placeholder_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['slider_advance_search_text.slider_advance_search_text_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['slider_image.slider_image_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['section1_heading.section1_heading_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['section1_description.section1_description_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['section1_business_category.section1_business_category_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['section1_business_category_url.section1_business_category_url_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['section2_heading.section2_heading_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['section2_category_label.section2_category_label_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['section2_country_label.section2_country_label_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['section2_deadline_label.section2_deadline_label_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['section2_estimated_value_label.section2_estimated_value_label_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['section2_i2b_button_text.section2_i2b_button_text_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['section2_button_text.section2_button_text_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['section2_button_url.section2_button_url_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['section3_heading.section3_heading_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['section3_button_text.section3_button_text_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['section3_button_url.section3_button_url_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['sponsor_value_button_text.sponsor_value_button_text_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['sponsor_value_button_url.sponsor_value_button_url_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['section4_heading.section4_heading_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['contact_for_rates_btn_text.contact_for_rates_btn_text_' . $language->id => ['nullable', 'string']]);
            
            $validationRule = array_merge($validationRule, ['contact_for_rates_btn_url.contact_for_rates_btn_url_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['section5_heading.section5_heading_' . $language->id => ['nullable', 'string']]);


            $validationRule = array_merge($validationRule, ['section5_event_detail_button_text.section5_event_detail_button_text_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['section5_website_button_text.section5_website_button_text_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['section5_see_all_button_text.section5_see_all_button_text_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['section5_see_all_button_url.section5_see_all_button_url_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['section5_add_event_text.section5_add_event_text_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['section5_add_event_url.section5_add_event_url_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['section6_heading.section6_heading_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['section6_description.section6_description_' . $language->id => ['nullable', 'string']]);

            $validationRule = array_merge($validationRule, ['section6_see_all_button.section6_see_all_button_' . $language->id => ['nullable', 'string']]);
        }
        return ['validation_rules' => $validationRule, 'error_messages' => $errorMessages];
    }

    public function fields($homePageSetting, $language, $request)
    {
        return [
            'home_page_setting_id' => $homePageSetting->id,
            'language_id' => $language->id,
            'slider_heading' => $request['slider_heading']['slider_heading_' . $language->id] ?? null,
            'slider_search_placeholder' => $request['slider_search_placeholder']['slider_search_placeholder_' . $language->id] ?? null,
            'slider_advance_search_text' => $request['slider_advance_search_text']['slider_advance_search_text_' . $language->id] ?? null,
            'slider_image' => $request['slider_image']['slider_image_' . $language->id] ?? null,
            'section1_heading' => $request['section1_heading']['section1_heading_' . $language->id] ?? null,
            'section1_description' => $request['section1_description']['section1_description_' . $language->id] ?? null,
            'section1_business_category' => $request['section1_business_category']['section1_business_category_' . $language->id] ?? null,
            'section1_business_category_url' => $request['section1_business_category_url']['section1_business_category_url_' . $language->id] ?? null,
            'section2_heading' => $request['section2_heading']['section2_heading_' . $language->id] ?? null,
            'section2_category_label' => $request['section2_category_label']['section2_category_label_' . $language->id] ?? null,
            'section2_country_label' => $request['section2_country_label']['section2_country_label_' . $language->id] ?? null,
            'section2_deadline_label' => $request['section2_deadline_label']['section2_deadline_label_' . $language->id] ?? null,
            'section2_estimated_value_label' => $request['section2_estimated_value_label']['section2_estimated_value_label_' . $language->id] ?? null,
            'section2_i2b_button_text' => $request['section2_i2b_button_text']['section2_i2b_button_text_' . $language->id] ?? null,
            'section2_button_text' => $request['section2_button_text']['section2_button_text_' . $language->id] ?? null,
            'section2_button_url' => $request['section2_button_url']['section2_button_url_' . $language->id] ?? null,
            'section3_heading' => $request['section3_heading']['section3_heading_' . $language->id] ?? null,
            'section3_button_text' => $request['section3_button_text']['section3_button_text_' . $language->id] ?? null,
            'section3_button_url' => $request['section3_button_url']['section3_button_url_' . $language->id] ?? null,
            'sponsor_value_button_url' => $request['sponsor_value_button_url']['sponsor_value_button_url_' . $language->id] ?? null,
            'sponsor_value_button_text' => $request['sponsor_value_button_text']['sponsor_value_button_text_' . $language->id] ?? null,
            'section4_heading' => $request['section4_heading']['section4_heading_' . $language->id] ?? null,
            'contact_for_rates_btn_text' => $request['contact_for_rates_btn_text']['contact_for_rates_btn_text_' . $language->id] ?? null,
            'contact_for_rates_btn_url' => $request['contact_for_rates_btn_url']['contact_for_rates_btn_url_' . $language->id] ?? null,
            'section5_heading' => $request['section5_heading']['section5_heading_' . $language->id] ?? null,
            'section5_event_detail_button_text' => $request['section5_event_detail_button_text']['section5_event_detail_button_text_' . $language->id] ?? null,
            'section5_website_button_text' => $request['section5_website_button_text']['section5_website_button_text_' . $language->id] ?? null,
            'section5_see_all_button_text' => $request['section5_see_all_button_text']['section5_see_all_button_text_' . $language->id] ?? null,
            'section5_see_all_button_url' => $request['section5_see_all_button_url']['section5_see_all_button_url_' . $language->id] ?? null,
            'section5_add_event_text' => $request['section5_add_event_text']['section5_add_event_text_' . $language->id] ?? null,
            'section5_add_event_url' => $request['section5_add_event_url']['section5_add_event_url_' . $language->id] ?? null,
            'section6_heading' => $request['section6_heading']['section6_heading_' . $language->id] ?? null,
            'section6_description' => $request['section6_description']['section6_description_' . $language->id] ?? null,
            'section6_see_all_button' => $request['section6_see_all_button']['section6_see_all_button_' . $language->id] ?? null,
        ];
    }

    public function store($homePageSetting, $language, $request)
    {
        $fields = $this->fields($homePageSetting, $language, $request);
        HomePageSettingDetail::create($fields);
        return true;
    }

    public function update($homePageSetting, $language, $request)
    {
        $fields = $this->fields($homePageSetting, $language, $request);
        HomePageSettingDetail::whereHomePageSettingId($homePageSetting->id)->whereLanguageId($language->id)->update($fields);
        return true;
    }
}
