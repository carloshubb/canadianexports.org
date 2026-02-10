<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Page template to setting mapping (for Excel export/import of detail tables)
    |--------------------------------------------------------------------------
    | Each template that has a *_setting_detail table can export/import
    | multi-language fields via Excel. Keys: template id, Values: [ setting class, detail class ].
    | Setting model must have page_id. Detail model must have language_id and FK to setting.
    */
    'templates' => [
        'home_template' => [
            \App\Models\HomePageSetting::class,
            \App\Models\HomePageSettingDetail::class,
        ],
        'about_us_template' => [
            \App\Models\AboutUsPageSetting::class,
            \App\Models\AboutUsPageSettingDetail::class,
        ],
        'sponsor_listing' => [
            \App\Models\SponsorPageSetting::class,
            \App\Models\SponsorPageSettingDetail::class,
        ],
        'event_signup_template' => [
            \App\Models\EventSignupSetting::class,
            \App\Models\EventSignupSettingDetail::class,
        ],
        'event_create_template' => [
            \App\Models\EventCreateSetting::class,
            \App\Models\EventCreateSettingDetail::class,
        ],
        'contact_us_template' => [
            \App\Models\ContactUsSetting::class,
            \App\Models\ContactUsSettingDetail::class,
        ],
        'inquiries_to_buy_template' => [
            \App\Models\I2BSetting::class,
            \App\Models\I2BSettingDetail::class,
        ],
        'event_template' => [
            \App\Models\EventSetting::class,
            \App\Models\EventSettingDetail::class,
        ],
        'comments_template' => [
            \App\Models\CommentsSetting::class,
            \App\Models\CommentsSettingDetail::class,
        ],
        'rates_template' => [
            \App\Models\RatesSetting::class,
            \App\Models\RatesSettingDetail::class,
        ],
        'close_account_template' => [
            \App\Models\CloseAccountSetting::class,
            \App\Models\CloseAccountSettingDetail::class,
        ],
        'event_listing_template' => [
            \App\Models\EventListingSetting::class,
            \App\Models\EventListingSettingDetail::class,
        ],
        'sponser_listing_template' => [
            \App\Models\SponserListingSetting::class,
            \App\Models\SponserListingSettingDetail::class,
            'sponser_list_setting_id',
        ],
        'advertiser_page_template' => [
            \App\Models\AdvertiserSetting::class,
            \App\Models\AdvertiserSettingDetail::class,
        ],
        'forget_page_template' => [
            \App\Models\ForgetPageSetting::class,
            \App\Models\ForgetPageSettingDetail::class,
        ],
        'become_sponsor_template' => [
            \App\Models\BecomeSponsorSetting::class,
            \App\Models\BecomeSponsorSettingDetail::class,
        ],
        'online_business_directory_template' => [
            \App\Models\OnlineBusinessDirectorySetting::class,
            \App\Models\OnlineBusinessDirectorySettingDetail::class,
        ],
        'one_more_thing_template' => [
            \App\Models\OneMoreThingSetting::class,
            \App\Models\OneMoreThingSettingDetail::class,
        ],
        'exporting_fair_template' => [
            \App\Models\ExportingFairSetting::class,
            \App\Models\ExportingFairSettingDetail::class,
        ],
        'financing_program_template' => [
            \App\Models\FinancingProgramSetting::class,
            \App\Models\FinancingProgramSettingDetail::class,
            'financing_program_id',
        ],
        'contact_for_rates_template' => [
            \App\Models\ContactForRateSetting::class,
            \App\Models\ContactForRateSettingDetail::class,
        ],
        'scam_alert_template' => [
            \App\Models\ScamAlertSetting::class,
            \App\Models\ScamAlertSettingDetail::class,
        ],
        'testimonial_template' => [
            \App\Models\TestimonialSetting::class,
            \App\Models\TestimonialSettingDetail::class,
        ],
        'success_stories_template' => [
            \App\Models\SuccessStoriesSetting::class,
            \App\Models\SuccessStoriesSettingDetail::class,
        ],
        'faq_exporter_template' => [
            \App\Models\FaqExporterSetting::class,
            \App\Models\FaqExporterSettingDetail::class,
        ],
        'faq_importer_template' => [
            \App\Models\FaqImporterSetting::class,
            \App\Models\FaqImporterSettingDetail::class,
        ],
        'info_letter_template' => [
            \App\Models\InfoLetterSetting::class,
            \App\Models\InfoLetterSettingDetail::class,
        ],
        'register_template' => [
            \App\Models\RegPageSetting::class,
            \App\Models\RegPageSettingDetail::class,
        ],
        'login_template' => [
            \App\Models\LoginPageSetting::class,
            \App\Models\LoginPageSettingDetail::class,
        ],
    ],
];
