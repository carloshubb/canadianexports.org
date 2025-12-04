<?php

namespace App\Services;

use App\Models\EventCreateSettingDetail;

class EventCreateSettingService
{
    public function validation($languages, $validationRule, $errorMessages)
    {
        foreach ($languages as $language) {

            $validationRule = array_merge($validationRule, ['create_event_tab_heading.create_event_tab_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['create_event_tab_heading.create_event_tab_heading_' . $language->id . '.required' => 'Create event tab heading in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['title_label.title_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['title_label.title_label_' . $language->id . '.required' => 'Title label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['title_error.title_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['title_error.title_error_' . $language->id . '.required' => 'Title error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['country_label.country_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['country_label.country_label_' . $language->id . '.required' => 'Country label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['country_error.country_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['country_error.country_error_' . $language->id . '.required' => 'Country error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['city_label.city_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['city_label.city_label_' . $language->id . '.required' => 'City label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['city_error.city_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['city_error.city_error_' . $language->id . '.required' => 'City error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['street_name_label.street_name_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['street_name_label.street_name_label_' . $language->id . '.required' => 'Street name label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['street_name_error.street_name_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['street_name_error.street_name_error_' . $language->id . '.required' => 'Street name label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['venue_label.venue_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['venue_label.venue_label_' . $language->id . '.required' => 'Venue label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['venue_error.venue_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['venue_error.venue_error_' . $language->id . '.required' => 'Venue error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['product_search_label.product_search_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['product_search_label.product_search_label_' . $language->id . '.required' => 'Product search label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['product_search_placeholder.product_search_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['product_search_placeholder.product_search_placeholder_' . $language->id . '.required' => 'Product search label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['product_search_error.product_search_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['product_search_error.product_search_error_' . $language->id . '.required' => 'Product search error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['short_description_label.short_description_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['short_description_label.short_description_label_' . $language->id . '.required' => 'Short description label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['short_description_placeholder.short_description_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['short_description_placeholder.short_description_placeholder_' . $language->id . '.required' => 'Short description label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['short_description_error.short_description_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['short_description_error.short_description_error_' . $language->id . '.required' => 'Short description error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['description_label.description_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['description_label.description_label_' . $language->id . '.required' => 'Description label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['description_placeholder.description_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['description_placeholder.description_placeholder_' . $language->id . '.required' => 'Description label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['description_error.description_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['description_error.description_error_' . $language->id . '.required' => 'Description error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['start_date_label.start_date_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['start_date_label.start_date_label_' . $language->id . '.required' => 'Start date label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['start_date_error.start_date_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['start_date_error.start_date_error_' . $language->id . '.required' => 'Start date error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['end_date_label.end_date_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['end_date_label.end_date_label_' . $language->id . '.required' => 'End date label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['end_date_error.end_date_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['end_date_error.end_date_error_' . $language->id . '.required' => 'End date error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['event_website_label.event_website_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['event_website_label.event_website_label_' . $language->id . '.required' => 'Event website label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['event_website_placeholder.event_website_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['event_website_placeholder.event_website_placeholder_' . $language->id . '.required' => 'Event website label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['event_website_error.event_website_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['event_website_error.event_website_error_' . $language->id . '.required' => 'Event website error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['exibitors_url_label.exibitors_url_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['exibitors_url_label.exibitors_url_label_' . $language->id . '.required' => 'Exibitors url label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['exibitors_url_placeholder.exibitors_url_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['exibitors_url_placeholder.exibitors_url_placeholder_' . $language->id . '.required' => 'Exibitors url label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['exibitors_url_error.exibitors_url_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['exibitors_url_error.exibitors_url_error_' . $language->id . '.required' => 'Exibitors url error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['visitors_label.visitors_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['visitors_label.visitors_label_' . $language->id . '.required' => 'Visitors label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['visitors_placeholder.visitors_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['visitors_placeholder.visitors_placeholder_' . $language->id . '.required' => 'Visitors label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['visitors_error.visitors_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['visitors_error.visitors_error_' . $language->id . '.required' => 'Visitors error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['press_url_label.press_url_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['press_url_label.press_url_label_' . $language->id . '.required' => 'Press url label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['press_url_placeholder.press_url_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['press_url_placeholder.press_url_placeholder_' . $language->id . '.required' => 'Press url label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['press_url_error.press_url_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['press_url_error.press_url_error_' . $language->id . '.required' => 'Press url error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['logo_label.logo_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['logo_label.logo_label_' . $language->id . '.required' => 'Logo label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['logo_error.logo_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['logo_error.logo_error_' . $language->id . '.required' => 'Logo error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['video_url_label.video_url_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['video_url_label.video_url_label_' . $language->id . '.required' => 'Video URL label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['video_url_placeholder.video_url_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['video_url_placeholder.video_url_placeholder_' . $language->id . '.required' => 'Video URL label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['video_url_error.video_url_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['video_url_error.video_url_error_' . $language->id . '.required' => 'Video URL error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['contact_info_tab_heading.contact_info_tab_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['contact_info_tab_heading.contact_info_tab_heading_' . $language->id . '.required' => 'Contact info tab heading in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['contact_name_label.contact_name_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['contact_name_label.contact_name_label_' . $language->id . '.required' => 'Contact name label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['contact_name_error.contact_name_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['contact_name_error.contact_name_error_' . $language->id . '.required' => 'Contact name error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['contact_email_label.contact_email_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['contact_email_label.contact_email_label_' . $language->id . '.required' => 'Contact email label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['contact_email_error.contact_email_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['contact_email_error.contact_email_error_' . $language->id . '.required' => 'Contact email error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['contact_phone_label.contact_phone_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['contact_phone_label.contact_phone_label_' . $language->id . '.required' => 'Contact phone label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['contact_phone_error.contact_phone_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['contact_phone_error.contact_phone_error_' . $language->id . '.required' => 'Contact phone error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['contact_designation_label.contact_designation_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['contact_designation_label.contact_designation_label_' . $language->id . '.required' => 'Contact designation label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['contact_designation_error.contact_designation_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['contact_designation_error.contact_designation_error_' . $language->id . '.required' => 'Contact designation error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['profile_image_label.profile_image_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['profile_image_label.profile_image_label_' . $language->id . '.required' => 'Profile image label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['profile_image_error.profile_image_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['profile_image_error.profile_image_error_' . $language->id . '.required' => 'Profile image error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['delete_btn_text.delete_btn_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['delete_btn_text.delete_btn_text_' . $language->id . '.required' => 'Delete button text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['add_new_contact_btn_text.add_new_contact_btn_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['add_new_contact_btn_text.add_new_contact_btn_text_' . $language->id . '.required' => 'Add new contact button text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['social_media_tab_heading.social_media_tab_heading_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['social_media_tab_heading.social_media_tab_heading_' . $language->id . '.required' => 'Social media tab heading in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['facebook_url_label.facebook_url_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['facebook_url_label.facebook_url_label_' . $language->id . '.required' => 'Facebook url label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['facebook_url_error.facebook_url_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['facebook_url_error.facebook_url_error_' . $language->id . '.required' => 'Facebook url error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['twitter_url_label.twitter_url_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['twitter_url_label.twitter_url_label_' . $language->id . '.required' => 'Twitter url label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['twitter_url_error.twitter_url_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['twitter_url_error.twitter_url_error_' . $language->id . '.required' => 'Twitter url error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['linkedin_url_label.linkedin_url_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['linkedin_url_label.linkedin_url_label_' . $language->id . '.required' => 'Linkedin url label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['linkedin_url_error.linkedin_url_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['linkedin_url_error.linkedin_url_error_' . $language->id . '.required' => 'Linkedin url error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['youtube_url_label.youtube_url_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['youtube_url_label.youtube_url_label_' . $language->id . '.required' => 'Youtube url label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['youtube_url_error.youtube_url_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['youtube_url_error.youtube_url_error_' . $language->id . '.required' => 'Youtube url error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['pintrest_url_label.pintrest_url_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['pintrest_url_label.pintrest_url_label_' . $language->id . '.required' => 'Pintrest url label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['pintrest_url_error.pintrest_url_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['pintrest_url_error.pintrest_url_error_' . $language->id . '.required' => 'Pintrest url error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['instagram_url_label.instagram_url_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['instagram_url_label.instagram_url_label_' . $language->id . '.required' => 'Instagram url label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['instagram_url_error.instagram_url_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['instagram_url_error.instagram_url_error_' . $language->id . '.required' => 'Instagram url error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['snapchat_url_label.snapchat_url_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['snapchat_url_label.snapchat_url_label_' . $language->id . '.required' => 'Snapchat url label in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['snapchat_url_error.snapchat_url_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['snapchat_url_error.snapchat_url_error_' . $language->id . '.required' => 'Snapchat url error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['button_text.button_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['button_text.button_text_' . $language->id . '.required' => 'Button text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['terms_and_conditions_label.terms_and_conditions_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['terms_and_conditions_label.terms_and_conditions_label_' . $language->id . '.required' => 'Terms and condition text in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['terms_and_conditions_error.terms_and_conditions_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['terms_and_conditions_error.terms_and_conditions_error_' . $language->id . '.required' => 'Terms and condition error in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['post_submit_button_text.post_submit_button_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['post_submit_button_text.post_submit_button_text_' . $language->id . '.required' => 'Post submit button text in ' . $language->name . ' is required.']);
        }
        return ['validation_rules' => $validationRule, 'error_messages' => $errorMessages];
    }

    public function fields($eventCreateSetting, $language, $request)
    {
        return [
            'event_create_setting_id' => $eventCreateSetting->id,
            'language_id' => $language->id,
            'create_event_tab_heading' => isset($request['create_event_tab_heading']['create_event_tab_heading_' . $language->id]) ? $request['create_event_tab_heading']['create_event_tab_heading_' . $language->id] : null,
            'title_label' => isset($request['title_label']['title_label_' . $language->id]) ? $request['title_label']['title_label_' . $language->id] : null,
            'title_error' => isset($request['title_error']['title_error_' . $language->id]) ? $request['title_error']['title_error_' . $language->id] : null,
            'country_label' => isset($request['country_label']['country_label_' . $language->id]) ? $request['country_label']['country_label_' . $language->id] : null,
            'country_error' => isset($request['country_error']['country_error_' . $language->id]) ? $request['country_error']['country_error_' . $language->id] : null,
            'city_label' => isset($request['city_label']['city_label_' . $language->id]) ? $request['city_label']['city_label_' . $language->id] : null,
            'city_error' => isset($request['city_error']['city_error_' . $language->id]) ? $request['city_error']['city_error_' . $language->id] : null,
            'street_name_label' => isset($request['street_name_label']['street_name_label_' . $language->id]) ? $request['street_name_label']['street_name_label_' . $language->id] : null,
            'street_name_error' => isset($request['street_name_error']['street_name_error_' . $language->id]) ? $request['street_name_error']['street_name_error_' . $language->id] : null,
            'venue_label' => isset($request['venue_label']['venue_label_' . $language->id]) ? $request['venue_label']['venue_label_' . $language->id] : null,
            'venue_error' => isset($request['venue_error']['venue_error_' . $language->id]) ? $request['venue_error']['venue_error_' . $language->id] : null,
            'product_search_label' => isset($request['product_search_label']['product_search_label_' . $language->id]) ? $request['product_search_label']['product_search_label_' . $language->id] : null,
            'product_search_placeholder' => isset($request['product_search_placeholder']['product_search_placeholder_' . $language->id]) ? $request['product_search_placeholder']['product_search_placeholder_' . $language->id] : null,
            'product_search_error' => isset($request['product_search_error']['product_search_error_' . $language->id]) ? $request['product_search_error']['product_search_error_' . $language->id] : null,
            'short_description_label' => isset($request['short_description_label']['short_description_label_' . $language->id]) ? $request['short_description_label']['short_description_label_' . $language->id] : null,
            'short_description_placeholder' => isset($request['short_description_placeholder']['short_description_placeholder_' . $language->id]) ? $request['short_description_placeholder']['short_description_placeholder_' . $language->id] : null,
            'short_description_error' => isset($request['short_description_error']['short_description_error_' . $language->id]) ? $request['short_description_error']['short_description_error_' . $language->id] : null,
            'description_label' => isset($request['description_label']['description_label_' . $language->id]) ? $request['description_label']['description_label_' . $language->id] : null,
            'description_placeholder' => isset($request['description_placeholder']['description_placeholder_' . $language->id]) ? $request['description_placeholder']['description_placeholder_' . $language->id] : null,
            'description_error' => isset($request['description_error']['description_error_' . $language->id]) ? $request['description_error']['description_error_' . $language->id] : null,
            'start_date_label' => isset($request['start_date_label']['start_date_label_' . $language->id]) ? $request['start_date_label']['start_date_label_' . $language->id] : null,
            'start_date_error' => isset($request['start_date_error']['start_date_error_' . $language->id]) ? $request['start_date_error']['start_date_error_' . $language->id] : null,
            'end_date_label' => isset($request['end_date_label']['end_date_label_' . $language->id]) ? $request['end_date_label']['end_date_label_' . $language->id] : null,
            'end_date_error' => isset($request['end_date_error']['end_date_error_' . $language->id]) ? $request['end_date_error']['end_date_error_' . $language->id] : null,
            'event_website_label' => isset($request['event_website_label']['event_website_label_' . $language->id]) ? $request['event_website_label']['event_website_label_' . $language->id] : null,
            'event_website_placeholder' => isset($request['event_website_placeholder']['event_website_placeholder_' . $language->id]) ? $request['event_website_placeholder']['event_website_placeholder_' . $language->id] : null,
            'event_website_error' => isset($request['event_website_error']['event_website_error_' . $language->id]) ? $request['event_website_error']['event_website_error_' . $language->id] : null,
            'exibitors_url_label' => isset($request['exibitors_url_label']['exibitors_url_label_' . $language->id]) ? $request['exibitors_url_label']['exibitors_url_label_' . $language->id] : null,
            'exibitors_url_placeholder' => isset($request['exibitors_url_placeholder']['exibitors_url_placeholder_' . $language->id]) ? $request['exibitors_url_placeholder']['exibitors_url_placeholder_' . $language->id] : null,
            'exibitors_url_error' => isset($request['exibitors_url_error']['exibitors_url_error_' . $language->id]) ? $request['exibitors_url_error']['exibitors_url_error_' . $language->id] : null,
            'visitors_label' => isset($request['visitors_label']['visitors_label_' . $language->id]) ? $request['visitors_label']['visitors_label_' . $language->id] : null,
            'visitors_placeholder' => isset($request['visitors_placeholder']['visitors_placeholder_' . $language->id]) ? $request['visitors_placeholder']['visitors_placeholder_' . $language->id] : null,
            'visitors_error' => isset($request['visitors_error']['visitors_error_' . $language->id]) ? $request['visitors_error']['visitors_error_' . $language->id] : null,
            'press_url_label' => isset($request['press_url_label']['press_url_label_' . $language->id]) ? $request['press_url_label']['press_url_label_' . $language->id] : null,
            'press_url_placeholder' => isset($request['press_url_placeholder']['press_url_placeholder_' . $language->id]) ? $request['press_url_placeholder']['press_url_placeholder_' . $language->id] : null,
            'press_url_error' => isset($request['press_url_error']['press_url_error_' . $language->id]) ? $request['press_url_error']['press_url_error_' . $language->id] : null,
            'logo_label' => isset($request['logo_label']['logo_label_' . $language->id]) ? $request['logo_label']['logo_label_' . $language->id] : null,
            'logo_error' => isset($request['logo_error']['logo_error_' . $language->id]) ? $request['logo_error']['logo_error_' . $language->id] : null,
            'video_url_label' => isset($request['video_url_label']['video_url_label_' . $language->id]) ? $request['video_url_label']['video_url_label_' . $language->id] : null,
            'video_url_placeholder' => isset($request['video_url_placeholder']['video_url_placeholder_' . $language->id]) ? $request['video_url_placeholder']['video_url_placeholder_' . $language->id] : null,
            'video_url_error' => isset($request['video_url_error']['video_url_error_' . $language->id]) ? $request['video_url_error']['video_url_error_' . $language->id] : null,
            'contact_info_tab_heading' => isset($request['contact_info_tab_heading']['contact_info_tab_heading_' . $language->id]) ? $request['contact_info_tab_heading']['contact_info_tab_heading_' . $language->id] : null,
            'contact_name_label' => isset($request['contact_name_label']['contact_name_label_' . $language->id]) ? $request['contact_name_label']['contact_name_label_' . $language->id] : null,
            'contact_name_error' => isset($request['contact_name_error']['contact_name_error_' . $language->id]) ? $request['contact_name_error']['contact_name_error_' . $language->id] : null,
            'contact_email_label' => isset($request['contact_email_label']['contact_email_label_' . $language->id]) ? $request['contact_email_label']['contact_email_label_' . $language->id] : null,
            'contact_email_error' => isset($request['contact_email_error']['contact_email_error_' . $language->id]) ? $request['contact_email_error']['contact_email_error_' . $language->id] : null,
            'contact_phone_label' => isset($request['contact_phone_label']['contact_phone_label_' . $language->id]) ? $request['contact_phone_label']['contact_phone_label_' . $language->id] : null,
            'contact_phone_error' => isset($request['contact_phone_error']['contact_phone_error_' . $language->id]) ? $request['contact_phone_error']['contact_phone_error_' . $language->id] : null,
            'contact_designation_label' => isset($request['contact_designation_label']['contact_designation_label_' . $language->id]) ? $request['contact_designation_label']['contact_designation_label_' . $language->id] : null,
            'contact_designation_error' => isset($request['contact_designation_error']['contact_designation_error_' . $language->id]) ? $request['contact_designation_error']['contact_designation_error_' . $language->id] : null,
            'profile_image_label' => isset($request['profile_image_label']['profile_image_label_' . $language->id]) ? $request['profile_image_label']['profile_image_label_' . $language->id] : null,
            'profile_image_error' => isset($request['profile_image_error']['profile_image_error_' . $language->id]) ? $request['profile_image_error']['profile_image_error_' . $language->id] : null,
            'delete_btn_text' => isset($request['delete_btn_text']['delete_btn_text_' . $language->id]) ? $request['delete_btn_text']['delete_btn_text_' . $language->id] : null,
            'add_new_contact_btn_text' => isset($request['add_new_contact_btn_text']['add_new_contact_btn_text_' . $language->id]) ? $request['add_new_contact_btn_text']['add_new_contact_btn_text_' . $language->id] : null,
            'social_media_tab_heading' => isset($request['social_media_tab_heading']['social_media_tab_heading_' . $language->id]) ? $request['social_media_tab_heading']['social_media_tab_heading_' . $language->id] : null,
            'facebook_url_label' => isset($request['facebook_url_label']['facebook_url_label_' . $language->id]) ? $request['facebook_url_label']['facebook_url_label_' . $language->id] : null,
            'facebook_url_error' => isset($request['facebook_url_error']['facebook_url_error_' . $language->id]) ? $request['facebook_url_error']['facebook_url_error_' . $language->id] : null,
            'twitter_url_label' => isset($request['twitter_url_label']['twitter_url_label_' . $language->id]) ? $request['twitter_url_label']['twitter_url_label_' . $language->id] : null,
            'twitter_url_error' => isset($request['twitter_url_error']['twitter_url_error_' . $language->id]) ? $request['twitter_url_error']['twitter_url_error_' . $language->id] : null,
            'linkedin_url_label' => isset($request['linkedin_url_label']['linkedin_url_label_' . $language->id]) ? $request['linkedin_url_label']['linkedin_url_label_' . $language->id] : null,
            'linkedin_url_error' => isset($request['linkedin_url_error']['linkedin_url_error_' . $language->id]) ? $request['linkedin_url_error']['linkedin_url_error_' . $language->id] : null,
            'youtube_url_label' => isset($request['youtube_url_label']['youtube_url_label_' . $language->id]) ? $request['youtube_url_label']['youtube_url_label_' . $language->id] : null,
            'youtube_url_error' => isset($request['youtube_url_error']['youtube_url_error_' . $language->id]) ? $request['youtube_url_error']['youtube_url_error_' . $language->id] : null,
            'pintrest_url_label' => isset($request['pintrest_url_label']['pintrest_url_label_' . $language->id]) ? $request['pintrest_url_label']['pintrest_url_label_' . $language->id] : null,
            'pintrest_url_error' => isset($request['pintrest_url_error']['pintrest_url_error_' . $language->id]) ? $request['pintrest_url_error']['pintrest_url_error_' . $language->id] : null,
            'instagram_url_label' => isset($request['instagram_url_label']['instagram_url_label_' . $language->id]) ? $request['instagram_url_label']['instagram_url_label_' . $language->id] : null,
            'instagram_url_error' => isset($request['instagram_url_error']['instagram_url_error_' . $language->id]) ? $request['instagram_url_error']['instagram_url_error_' . $language->id] : null,
            'snapchat_url_label' => isset($request['snapchat_url_label']['snapchat_url_label_' . $language->id]) ? $request['snapchat_url_label']['snapchat_url_label_' . $language->id] : null,
            'snapchat_url_error' => isset($request['snapchat_url_error']['snapchat_url_error_' . $language->id]) ? $request['snapchat_url_error']['snapchat_url_error_' . $language->id] : null,
            'button_text' => isset($request['button_text']['button_text_' . $language->id]) ? $request['button_text']['button_text_' . $language->id] : null,
            'terms_and_conditions_label' => isset($request['terms_and_conditions_label']['terms_and_conditions_label_' . $language->id]) ? $request['terms_and_conditions_label']['terms_and_conditions_label_' . $language->id] : null,
            'terms_and_conditions_error' => isset($request['terms_and_conditions_error']['terms_and_conditions_error_' . $language->id]) ? $request['terms_and_conditions_error']['terms_and_conditions_error_' . $language->id] : null,
            'post_submit_button_text' => isset($request['post_submit_button_text']['post_submit_button_text_' . $language->id]) ? $request['post_submit_button_text']['post_submit_button_text_' . $language->id] : null,
        ];
    }

    public function store($eventCreateSetting, $language, $request)
    {
        $fields = $this->fields($eventCreateSetting, $language, $request);
        EventCreateSettingDetail::create($fields);
        return true;
    }

    public function update($eventCreateSetting, $language, $request)
    {
        $fields = $this->fields($eventCreateSetting, $language, $request);
        EventCreateSettingDetail::whereEventCreateSettingId($eventCreateSetting->id)->whereLanguageId($language->id)->update($fields);
        return true;
    }
}
