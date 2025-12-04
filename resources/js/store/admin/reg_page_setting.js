import ErrorHandling from "../../ErrorHandling";

const reg_page_setting = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            page_title: {},
            page_description: {},

            step_1_heading: {},
            step_1_acc_heading: {},
            step_1_description: {},
            step_1_auto_renew_label: {},
            step1_free_pkg_text: {},
            step1_feature_pkg_text: {},
            step1_premium_pkg_text: {},

            step_2_heading: {},
            step_2_acc_heading: {},
            step_2_name_label: {},
            step_2_name_error: {},
            step_2_name_placeholder: {},
            step_2_email_label: {},
            step_2_email_error: {},
            step_2_email_placeholder: {},
            step_2_password_label: {},
            step_2_password_error: {},
            step_2_password_placeholder: {},
            step_2_confirm_password_label: {},
            step_2_confirm_password_error: {},
            step_2_confirm_password_placeholder: {},

            step_3_heading: {},
            step_3_acc_heading: {},
            step_3_description: {},
            step_3_business_categories_label: {},
            step_3_business_categories_error: {},
            step_3_business_categories_placeholder: {},

            step_4_heading: {},
            step_4_acc_heading: {},
            step_4_name_label: {},
            step_4_name_error: {},
            step_4_name_placeholder: {},
            step_4_email_label: {},
            step_4_email_error: {},
            step_4_email_placeholder: {},
            step_4_ctn_link_label: {},
            step_4_ctn_link_error: {},
            step_4_ctn_link_placeholder: {},
            step_4_ctn_btn_label: {},
            step_4_ctn_btn_error: {},
            step_4_ctn_btn_placeholder: {},
            step_4_address_label: {},
            step_4_address_error: {},
            step_4_address_placeholder: {},
            step_4_phone_label: {},
            step_4_phone_error: {},
            step_4_phone_placeholder: {},
            step_4_website_label: {},
            step_4_website_error: {},
            step_4_website_placeholder: {},
            step_4_short_description_label: {},
            step_4_short_description_error: {},
            step_4_short_description_placeholder: {},
            step_4_description_label: {},
            step_4_description_error: {},
            step_4_description_placeholder: {},
            step_4_keywords_label: {},
            step_4_keywords_error: {},
            step_4_keywords_placeholder: {},

            step_5_heading: {},
            step_5_title_label: {},
            step_5_title_error: {},
            step_5_description_label: {},
            step_5_description_error: {},
            step_5_acc_heading: {},
            step_5_logo_label: {},
            step_5_logo_error: {},
            step_5_logo_placeholder: {},
            step_5_video_label: {},
            step_5_video_error: {},
            step_5_video_placeholder: {},
            step_5_image_1_label: {},
            step_5_image_1_error: {},
            step_5_image_1_placeholder: {},
            step_5_image_2_label: {},
            step_5_image_2_error: {},
            step_5_image_2_placeholder: {},
            step_5_image_3_label: {},
            step_5_image_3_error: {},
            step_5_image_3_placeholder: {},
            step_5_image_4_label: {},
            step_5_image_4_error: {},
            step_5_image_4_placeholder: {},

            step_6_heading: {},
            step_6_acc_heading: {},
            step_6_facebook_label: {},
            step_6_facebook_error: {},
            step_6_facebook_placeholder: {},
            step_6_twitter_label: {},
            step_6_twitter_error: {},
            step_6_twitter_placeholder: {},
            step_6_youtube_label: {},
            step_6_youtube_error: {},
            step_6_youtube_placeholder: {},
            step_6_linkedin_label: {},
            step_6_linkedin_error: {},
            step_6_linkedin_placeholder: {},

            terms_and_conditions_label: {},
            terms_and_conditions_error: {},
            submit_button_text: {},
            footer_text: {},
        },
        reg_page_setting: null,
        loading: false,
        limit: 10,
    },
    mutations: {
        setPageTitle(state, payload){
            state.form.page_title = payload;
        },
        updatePageTitle(state, payload){
            state.form.page_title[`page_title_${payload.id}`] = payload.value;
        },
        setPageDescription(state, payload){
            state.form.page_description = payload;
        },
        updatePageDescription(state, payload){
            state.form.page_description[`page_description_${payload.id}`] = payload.value;
        },
        setStep1Heading(state, payload){
            state.form.step_1_heading = payload;
        },
        updateStep1Heading(state, payload){
            state.form.step_1_heading[`step_1_heading_${payload.id}`] = payload.value;
        },
        setStep1AccHeading(state, payload){
            state.form.step_1_acc_heading = payload;
        },
        updateStep1AccHeading(state, payload){
            state.form.step_1_acc_heading[`step_1_acc_heading_${payload.id}`] = payload.value;
        },
        setStep1Description(state, payload){
            state.form.step_1_description = payload;
        },
        updateStep1Description(state, payload){
            state.form.step_1_description[`step_1_description_${payload.id}`] = payload.value;
        },
        setStep1AutoRenewLabel(state, payload){
            state.form.step_1_auto_renew_label = payload;
        },
        updateStep1AutoRenewLabel(state, payload){
            state.form.step_1_auto_renew_label[`step_1_auto_renew_label_${payload.id}`] = payload.value;
        },
        setStep1FreePkgText(state, payload){
            state.form.step1_free_pkg_text = payload;
        },
        updateStep1FreePkgText(state, payload){
            state.form.step1_free_pkg_text[`step1_free_pkg_text_${payload.id}`] = payload.value;
        },
        setStep1FeaturePkgText(state, payload){
            state.form.step1_feature_pkg_text = payload;
        },
        updateStep1FeaturePkgText(state, payload){
            state.form.step1_feature_pkg_text[`step1_feature_pkg_text_${payload.id}`] = payload.value;
        },
        setStep1PremiumPkgText(state, payload){
            state.form.step1_premium_pkg_text = payload;
        },
        updateStep1PremiumPkgText(state, payload){
            state.form.step1_premium_pkg_text[`step1_premium_pkg_text_${payload.id}`] = payload.value;
        },
        setStep2Heading(state, payload){
            state.form.step_2_heading = payload;
        },
        updateStep2Heading(state, payload){
            state.form.step_2_heading[`step_2_heading_${payload.id}`] = payload.value;
        },
        setStep2AccHeading(state, payload){
            state.form.step_2_acc_heading = payload;
        },
        updateStep2AccHeading(state, payload){
            state.form.step_2_acc_heading[`step_2_acc_heading_${payload.id}`] = payload.value;
        },
        setStep2NameLabel(state, payload){
            state.form.step_2_name_label = payload;
        },
        updateStep2NameLabel(state, payload){
            state.form.step_2_name_label[`step_2_name_label_${payload.id}`] = payload.value;
        },
        setStep2NameError(state, payload){
            state.form.step_2_name_error = payload;
        },
        updateStep2NameError(state, payload){
            state.form.step_2_name_error[`step_2_name_error_${payload.id}`] = payload.value;
        },
        setStep2NamePlaceholder(state, payload){
            state.form.step_2_name_placeholder = payload;
        },
        updateStep2NamePlaceholder(state, payload){
            state.form.step_2_name_placeholder[`step_2_name_placeholder_${payload.id}`] = payload.value;
        },
        setStep2EmailLabel(state, payload){
            state.form.step_2_email_label = payload;
        },
        updateStep2EmailLabel(state, payload){
            state.form.step_2_email_label[`step_2_email_label_${payload.id}`] = payload.value;
        },
        setStep2EmailError(state, payload){
            state.form.step_2_email_error = payload;
        },
        updateStep2EmailError(state, payload){
            state.form.step_2_email_error[`step_2_email_error_${payload.id}`] = payload.value;
        },
        setStep2EmailPlaceholder(state, payload){
            state.form.step_2_email_placeholder = payload;
        },
        updateStep2EmailPlaceholder(state, payload){
            state.form.step_2_email_placeholder[`step_2_email_placeholder_${payload.id}`] = payload.value;
        },

        setStep2PasswordLabel(state, payload){
            state.form.step_2_password_label = payload;
        },
        updateStep2PasswordLabel(state, payload){
            state.form.step_2_password_label[`step_2_password_label_${payload.id}`] = payload.value;
        },
        setStep2PasswordError(state, payload){
            state.form.step_2_password_error = payload;
        },
        updateStep2PasswordError(state, payload){
            state.form.step_2_password_error[`step_2_password_error_${payload.id}`] = payload.value;
        },
        setStep2PasswordPlaceholder(state, payload){
            state.form.step_2_password_placeholder = payload;
        },
        updateStep2PasswordPlaceholder(state, payload){
            state.form.step_2_password_placeholder[`step_2_password_placeholder_${payload.id}`] = payload.value;
        },

        setStep2ConfirmPasswordLabel(state, payload){
            state.form.step_2_confirm_password_label = payload;
        },
        updateStep2ConfirmPasswordLabel(state, payload){
            state.form.step_2_confirm_password_label[`step_2_confirm_password_label_${payload.id}`] = payload.value;
        },
        setStep2ConfirmPasswordError(state, payload){
            state.form.step_2_confirm_password_error = payload;
        },
        updateStep2ConfirmPasswordError(state, payload){
            state.form.step_2_confirm_password_error[`step_2_confirm_password_error_${payload.id}`] = payload.value;
        },
        setStep2ConfirmPasswordPlaceholder(state, payload){
            state.form.step_2_confirm_password_placeholder = payload;
        },
        updateStep2ConfirmPasswordPlaceholder(state, payload){
            state.form.step_2_confirm_password_placeholder[`step_2_confirm_password_placeholder_${payload.id}`] = payload.value;
        },

        setStep3Heading(state, payload){
            state.form.step_3_heading = payload;
        },
        updateStep3Heading(state, payload){
            state.form.step_3_heading[`step_3_heading_${payload.id}`] = payload.value;
        },
        setStep3AccHeading(state, payload){
            state.form.step_3_acc_heading = payload;
        },
        updateStep3AccHeading(state, payload){
            state.form.step_3_acc_heading[`step_3_acc_heading_${payload.id}`] = payload.value;
        },
        setStep3Description(state, payload){
            state.form.step_3_description = payload;
        },
        updateStep3Description(state, payload){
            state.form.step_3_description[`step_3_description_${payload.id}`] = payload.value;
        },

        setStep3BusinessCategoriesLabel(state, payload){
            state.form.step_3_business_categories_label = payload;
        },
        updateStep3BusinessCategoriesLabel(state, payload){
            state.form.step_3_business_categories_label[`step_3_business_categories_label_${payload.id}`] = payload.value;
        },
        setStep3BusinessCategoriesError(state, payload){
            state.form.step_3_business_categories_error = payload;
        },
        updateStep3BusinessCategoriesError(state, payload){
            state.form.step_3_business_categories_error[`step_3_business_categories_error_${payload.id}`] = payload.value;
        },
        setStep3BusinessCategoriesPlaceholder(state, payload){
            state.form.step_3_business_categories_placeholder = payload;
        },
        updateStep3BusinessCategoriesPlaceholder(state, payload){
            state.form.step_3_business_categories_placeholder[`step_3_business_categories_placeholder_${payload.id}`] = payload.value;
        },

        setStep4Heading(state, payload){
            state.form.step_4_heading = payload;
        },
        updateStep4Heading(state, payload){
            state.form.step_4_heading[`step_4_heading_${payload.id}`] = payload.value;
        },
        setStep4AccHeading(state, payload){
            state.form.step_4_acc_heading = payload;
        },
        updateStep4AccHeading(state, payload){
            state.form.step_4_acc_heading[`step_4_acc_heading_${payload.id}`] = payload.value;
        },


        setStep4NameLabel(state, payload){
            state.form.step_4_name_label = payload;
        },
        updateStep4NameLabel(state, payload){
            state.form.step_4_name_label[`step_4_name_label_${payload.id}`] = payload.value;
        },
        setStep4NameError(state, payload){
            state.form.step_4_name_error = payload;
        },
        updateStep4NameError(state, payload){
            state.form.step_4_name_error[`step_4_name_error_${payload.id}`] = payload.value;
        },
        setStep4NamePlaceholder(state, payload){
            state.form.step_4_name_placeholder = payload;
        },
        updateStep4NamePlaceholder(state, payload){
            state.form.step_4_name_placeholder[`step_4_name_placeholder_${payload.id}`] = payload.value;
        },

        setStep4CtaBtnLabel(state, payload){
            state.form.step_4_cta_btn_label = payload;
        },
        updateStep4CtaBtnLabel(state, payload){
            state.form.step_4_cta_btn_label[`step_4_cta_btn_label_${payload.id}`] = payload.value;
        },
        setStep4CtaBtnError(state, payload){
            state.form.step_4_cta_btn_error = payload;
        },
        updateStep4CtaBtnError(state, payload){
            state.form.step_4_cta_btn_error[`step_4_cta_btn_error_${payload.id}`] = payload.value;
        },
        setStep4CtaBtnPlaceholder(state, payload){
            state.form.step_4_cta_btn_placeholder = payload;
        },
        updateStep4CtaBtnPlaceholder(state, payload){
            state.form.step_4_email_placeholder[`step_4_cta_btn_placeholder_${payload.id}`] = payload.value;
        },

        setStep4EmailLabel(state, payload){
            state.form.step_4_email_label = payload;
        },
        updateStep4EmailLabel(state, payload){
            state.form.step_4_email_label[`step_4_email_label_${payload.id}`] = payload.value;
        },
        setStep4EmailError(state, payload){
            state.form.step_4_email_error = payload;
        },
        updateStep4EmailError(state, payload){
            state.form.step_4_email_error[`step_4_email_error_${payload.id}`] = payload.value;
        },
        setStep4EmailPlaceholder(state, payload){
            state.form.step_4_email_placeholder = payload;
        },
        updateStep4EmailPlaceholder(state, payload){
            state.form.step_4_email_placeholder[`step_4_email_placeholder_${payload.id}`] = payload.value;
        },

        setStep4CtaLinkLabel(state, payload){
            state.form.step_4_cta_link_label = payload;
        },
        updateStep4CtaLinkLabel(state, payload){
            state.form.step_4_cta_link_label[`step_4_cta_link_label_${payload.id}`] = payload.value;
        },
        setStep4CtaLinkError(state, payload){
            state.form.step_4_cta_link_error = payload;
        },
        updateStep4CtaLinkError(state, payload){
            state.form.step_4_cta_link_error[`step_4_cta_link_error_${payload.id}`] = payload.value;
        },
        setStep4CtaLinkPlaceholder(state, payload){
            state.form.step_4_cta_link_placeholder = payload;
        },
        updateStep4CtaLinkPlaceholder(state, payload){
            state.form.step_4_cta_link_placeholder[`step_4_cta_link_placeholder_${payload.id}`] = payload.value;
        },

        setStep4AddressLabel(state, payload){
            state.form.step_4_address_label = payload;
        },
        updateStep4AddressLabel(state, payload){
            state.form.step_4_address_label[`step_4_address_label_${payload.id}`] = payload.value;
        },
        setStep4AddressError(state, payload){
            state.form.step_4_address_error = payload;
        },
        updateStep4AddressError(state, payload){
            state.form.step_4_address_error[`step_4_address_error_${payload.id}`] = payload.value;
        },
        setStep4AddressPlaceholder(state, payload){
            state.form.step_4_address_placeholder = payload;
        },
        updateStep4AddressPlaceholder(state, payload){
            state.form.step_4_address_placeholder[`step_4_address_placeholder_${payload.id}`] = payload.value;
        },

        setStep4PhoneLabel(state, payload){
            state.form.step_4_phone_label = payload;
        },
        updateStep4PhoneLabel(state, payload){
            state.form.step_4_phone_label[`step_4_phone_label_${payload.id}`] = payload.value;
        },
        setStep4PhoneError(state, payload){
            state.form.step_4_phone_error = payload;
        },
        updateStep4PhoneError(state, payload){
            state.form.step_4_phone_error[`step_4_phone_error_${payload.id}`] = payload.value;
        },
        setStep4PhonePlaceholder(state, payload){
            state.form.step_4_phone_placeholder = payload;
        },
        updateStep4PhonePlaceholder(state, payload){
            state.form.step_4_phone_placeholder[`step_4_phone_placeholder_${payload.id}`] = payload.value;
        },

        setStep4WebsiteLabel(state, payload){
            state.form.step_4_website_label = payload;
        },
        updateStep4WebsiteLabel(state, payload){
            state.form.step_4_website_label[`step_4_website_label_${payload.id}`] = payload.value;
        },
        setStep4WebsiteError(state, payload){
            state.form.step_4_website_error = payload;
        },
        updateStep4WebsiteError(state, payload){
            state.form.step_4_website_error[`step_4_website_error_${payload.id}`] = payload.value;
        },
        setStep4WebsitePlaceholder(state, payload){
            state.form.step_4_website_placeholder = payload;
        },
        updateStep4WebsitePlaceholder(state, payload){
            state.form.step_4_website_placeholder[`step_4_website_placeholder_${payload.id}`] = payload.value;
        },

        setStep4ShortDescriptionLabel(state, payload){
            state.form.step_4_short_description_label = payload;
        },
        updateStep4ShortDescriptionLabel(state, payload){
            state.form.step_4_short_description_label[`step_4_short_description_label_${payload.id}`] = payload.value;
        },
        setStep4ShortDescriptionError(state, payload){
            state.form.step_4_short_description_error = payload;
        },
        updateStep4ShortDescriptionError(state, payload){
            state.form.step_4_short_description_error[`step_4_short_description_error_${payload.id}`] = payload.value;
        },
        setStep4ShortDescriptionPlaceholder(state, payload){
            state.form.step_4_short_description_placeholder = payload;
        },
        updateStep4ShortDescriptionPlaceholder(state, payload){
            state.form.step_4_short_description_placeholder[`step_4_short_description_placeholder_${payload.id}`] = payload.value;
        },

        setStep4DescriptionLabel(state, payload){
            state.form.step_4_description_label = payload;
        },
        updateStep4DescriptionLabel(state, payload){
            state.form.step_4_description_label[`step_4_description_label_${payload.id}`] = payload.value;
        },
        setStep4DescriptionError(state, payload){
            state.form.step_4_description_error = payload;
        },
        updateStep4DescriptionError(state, payload){
            state.form.step_4_description_error[`step_4_description_error_${payload.id}`] = payload.value;
        },
        setStep4DescriptionPlaceholder(state, payload){
            state.form.step_4_description_placeholder = payload;
        },
        updateStep4DescriptionPlaceholder(state, payload){
            state.form.step_4_description_placeholder[`step_4_description_placeholder_${payload.id}`] = payload.value;
        },

        setStep4KeywordsLabel(state, payload){
            state.form.step_4_keywords_label = payload;
        },
        updateStep4KeywordsLabel(state, payload){
            state.form.step_4_keywords_label[`step_4_keywords_label_${payload.id}`] = payload.value;
        },
        setStep4KeywordsError(state, payload){
            state.form.step_4_keywords_error = payload;
        },
        updateStep4KeywordsError(state, payload){
            state.form.step_4_keywords_error[`step_4_keywords_error_${payload.id}`] = payload.value;
        },
        setStep4KeywordsPlaceholder(state, payload){
            state.form.step_4_keywords_placeholder = payload;
        },
        updateStep4KeywordsPlaceholder(state, payload){
            state.form.step_4_keywords_placeholder[`step_4_keywords_placeholder_${payload.id}`] = payload.value;
        },

        setStep5Heading(state, payload){
            state.form.step_5_heading = payload;
        },
        updateStep5Heading(state, payload){
            state.form.step_5_heading[`step_5_heading_${payload.id}`] = payload.value;
        },
        setStep5TitleLabel(state, payload){
            state.form.step_5_title_label = payload;
        },
        updateStep5TitleLabel(state, payload){
            state.form.step_5_title_label[`step_5_title_label_${payload.id}`] = payload.value;
        },
        setStep5TitleError(state, payload){
            state.form.step_5_title_error = payload;
        },
        updateStep5TitleError(state, payload){
            state.form.step_5_title_error[`step_5_title_error_${payload.id}`] = payload.value;
        },
        setStep5DescriptionLabel(state, payload){
            state.form.step_5_description_label = payload;
        },
        updateStep5DescriptionLabel(state, payload){
            state.form.step_5_description_label[`step_5_description_label_${payload.id}`] = payload.value;
        },
        setStep5DescriptionError(state, payload){
            state.form.step_5_description_error = payload;
        },
        updateStep5DescriptionError(state, payload){
            state.form.step_5_description_error[`step_5_description_error_${payload.id}`] = payload.value;
        },
        setStep5AccHeading(state, payload){
            state.form.step_5_acc_heading = payload;
        },
        updateStep5AccHeading(state, payload){
            state.form.step_5_acc_heading[`step_5_acc_heading_${payload.id}`] = payload.value;
        },

        setStep5LogoLabel(state, payload){
            state.form.step_5_logo_label = payload;
        },
        updateStep5LogoLabel(state, payload){
            state.form.step_5_logo_label[`step_5_logo_label_${payload.id}`] = payload.value;
        },
        setStep5LogoError(state, payload){
            state.form.step_5_logo_error = payload;
        },
        updateStep5LogoError(state, payload){
            state.form.step_5_logo_error[`step_5_logo_error_${payload.id}`] = payload.value;
        },
        setStep5LogoPlaceholder(state, payload){
            state.form.step_5_logo_placeholder = payload;
        },
        updateStep5LogoPlaceholder(state, payload){
            state.form.step_5_logo_placeholder[`step_5_logo_placeholder_${payload.id}`] = payload.value;
        },

        setStep5VideoLabel(state, payload){
            state.form.step_5_video_label = payload;
        },
        updateStep5VideoLabel(state, payload){
            state.form.step_5_video_label[`step_5_video_label_${payload.id}`] = payload.value;
        },
        setStep5VideoError(state, payload){
            state.form.step_5_video_error = payload;
        },
        updateStep5VideoError(state, payload){
            state.form.step_5_video_error[`step_5_video_error_${payload.id}`] = payload.value;
        },
        setStep5VideoPlaceholder(state, payload){
            state.form.step_5_video_placeholder = payload;
        },
        updateStep5VideoPlaceholder(state, payload){
            state.form.step_5_video_placeholder[`step_5_video_placeholder_${payload.id}`] = payload.value;
        },

        setStep5Image1Label(state, payload){
            state.form.step_5_image_1_label = payload;
        },
        updateStep5Image1Label(state, payload){
            state.form.step_5_image_1_label[`step_5_image_1_label_${payload.id}`] = payload.value;
        },
        setStep5Image1Error(state, payload){
            state.form.step_5_image_1_error = payload;
        },
        updateStep5Image1Error(state, payload){
            state.form.step_5_image_1_error[`step_5_image_1_error_${payload.id}`] = payload.value;
        },
        setStep5Image1Placeholder(state, payload){
            state.form.step_5_image_1_placeholder = payload;
        },
        updateStep5Image1Placeholder(state, payload){
            state.form.step_5_image_1_placeholder[`step_5_image_1_placeholder_${payload.id}`] = payload.value;
        },

        setStep5Image2Label(state, payload){
            state.form.step_5_image_2_label = payload;
        },
        updateStep5Image2Label(state, payload){
            state.form.step_5_image_2_label[`step_5_image_2_label_${payload.id}`] = payload.value;
        },
        setStep5Image2Error(state, payload){
            state.form.step_5_image_2_error = payload;
        },
        updateStep5Image2Error(state, payload){
            state.form.step_5_image_2_error[`step_5_image_2_error_${payload.id}`] = payload.value;
        },
        setStep5Image2Placeholder(state, payload){
            state.form.step_5_image_2_placeholder = payload;
        },
        updateStep5Image2Placeholder(state, payload){
            state.form.step_5_image_2_placeholder[`step_5_image_2_placeholder_${payload.id}`] = payload.value;
        },

        setStep5Image3Label(state, payload){
            state.form.step_5_image_3_label = payload;
        },
        updateStep5Image3Label(state, payload){
            state.form.step_5_image_3_label[`step_5_image_3_label_${payload.id}`] = payload.value;
        },
        setStep5Image3Error(state, payload){
            state.form.step_5_image_3_error = payload;
        },
        updateStep5Image3Error(state, payload){
            state.form.step_5_image_3_error[`step_5_image_3_error_${payload.id}`] = payload.value;
        },
        setStep5Image3Placeholder(state, payload){
            state.form.step_5_image_3_placeholder = payload;
        },
        updateStep5Image3Placeholder(state, payload){
            state.form.step_5_image_3_placeholder[`step_5_image_3_placeholder_${payload.id}`] = payload.value;
        },

        setStep5Image4Label(state, payload){
            state.form.step_5_image_4_label = payload;
        },
        updateStep5Image4Label(state, payload){
            state.form.step_5_image_4_label[`step_5_image_4_label_${payload.id}`] = payload.value;
        },
        setStep5Image4Error(state, payload){
            state.form.step_5_image_4_error = payload;
        },
        updateStep5Image4Error(state, payload){
            state.form.step_5_image_4_error[`step_5_image_4_error_${payload.id}`] = payload.value;
        },
        setStep5Image4Placeholder(state, payload){
            state.form.step_5_image_4_placeholder = payload;
        },
        updateStep5Image4Placeholder(state, payload){
            state.form.step_5_image_4_placeholder[`step_5_image_4_placeholder_${payload.id}`] = payload.value;
        },

        setStep6Heading(state, payload){
            state.form.step_6_heading = payload;
        },
        updateStep6Heading(state, payload){
            state.form.step_6_heading[`step_6_heading_${payload.id}`] = payload.value;
        },
        setStep6AccHeading(state, payload){
            state.form.step_6_acc_heading = payload;
        },
        updateStep6AccHeading(state, payload){
            state.form.step_6_acc_heading[`step_6_acc_heading_${payload.id}`] = payload.value;
        },

        setStep6FacebookLabel(state, payload){
            state.form.step_6_facebook_label = payload;
        },
        updateStep6FacebookLabel(state, payload){
            state.form.step_6_facebook_label[`step_6_facebook_label_${payload.id}`] = payload.value;
        },
        setStep6FacebookError(state, payload){
            state.form.step_6_facebook_error = payload;
        },
        updateStep6FacebookError(state, payload){
            state.form.step_6_facebook_error[`step_6_facebook_error_${payload.id}`] = payload.value;
        },
        setStep6FacebookPlaceholder(state, payload){
            state.form.step_6_facebook_placeholder = payload;
        },
        updateStep6FacebookPlaceholder(state, payload){
            state.form.step_6_facebook_placeholder[`step_6_facebook_placeholder_${payload.id}`] = payload.value;
        },

        setStep6TwitterLabel(state, payload){
            state.form.step_6_twitter_label = payload;
        },
        updateStep6TwitterLabel(state, payload){
            state.form.step_6_twitter_label[`step_6_twitter_label_${payload.id}`] = payload.value;
        },
        setStep6TwitterError(state, payload){
            state.form.step_6_twitter_error = payload;
        },
        updateStep6TwitterError(state, payload){
            state.form.step_6_twitter_error[`step_6_twitter_error_${payload.id}`] = payload.value;
        },
        setStep6TwitterPlaceholder(state, payload){
            state.form.step_6_twitter_placeholder = payload;
        },
        updateStep6TwitterPlaceholder(state, payload){
            state.form.step_6_twitter_placeholder[`step_6_twitter_placeholder_${payload.id}`] = payload.value;
        },

        setStep6YoutubeLabel(state, payload){
            state.form.step_6_youtube_label = payload;
        },
        updateStep6YoutubeLabel(state, payload){
            state.form.step_6_youtube_label[`step_6_youtube_label_${payload.id}`] = payload.value;
        },
        setStep6YoutubeError(state, payload){
            state.form.step_6_youtube_error = payload;
        },
        updateStep6YoutubeError(state, payload){
            state.form.step_6_youtube_error[`step_6_youtube_error_${payload.id}`] = payload.value;
        },
        setStep6YoutubePlaceholder(state, payload){
            state.form.step_6_youtube_placeholder = payload;
        },
        updateStep6YoutubePlaceholder(state, payload){
            state.form.step_6_youtube_placeholder[`step_6_youtube_placeholder_${payload.id}`] = payload.value;
        },

        setStep6LinkedinLabel(state, payload){
            state.form.step_6_linkedin_label = payload;
        },
        updateStep6LinkedinLabel(state, payload){
            state.form.step_6_linkedin_label[`step_6_linkedin_label_${payload.id}`] = payload.value;
        },
        setStep6LinkedinError(state, payload){
            state.form.step_6_linkedin_error = payload;
        },
        updateStep6LinkedinError(state, payload){
            state.form.step_6_linkedin_error[`step_6_linkedin_error_${payload.id}`] = payload.value;
        },
        setStep6LinkedinPlaceholder(state, payload){
            state.form.step_6_linkedin_placeholder = payload;
        },
        updateStep6LinkedinPlaceholder(state, payload){
            state.form.step_6_linkedin_placeholder[`step_6_linkedin_placeholder_${payload.id}`] = payload.value;
        },

        setTermsAndConditionsLabel(state, payload){
            state.form.terms_and_conditions_label = payload;
        },
        updateTermsAndConditionsLabel(state, payload){
            state.form.terms_and_conditions_label[`terms_and_conditions_label_${payload.id}`] = payload.value;
        },
        setTermsAndConditionsError(state, payload){
            state.form.terms_and_conditions_error = payload;
        },
        updateTermsAndConditionsError(state, payload){
            state.form.terms_and_conditions_error[`terms_and_conditions_error_${payload.id}`] = payload.value;
        },

        setSubmitButtonText(state, payload){
            state.form.submit_button_text = payload;
        },
        updateSubmitButtonText(state, payload){
            state.form.submit_button_text[`submit_button_text_${payload.id}`] = payload.value;
        },

        setFooterText(state, payload){
            state.form.footer_text = payload;
        },
        updateFooterText(state, payload){
            state.form.footer_text[`footer_text_${payload.id}`] = payload.value;
        },



        setRegistrationPageSetting(state, payload) {
            state.reg_page_setting = payload;
        },
        setLoading(state, payload) {
            state.loading = payload ? payload : !state.loading;
        },
        resetForm(state) {
            state.form = {
                id: null,
                page_title: {},
                page_description: {},

                step_1_heading: {},
                step_1_description: {},
                step_1_auto_renew_label: {},
                step1_free_pkg_text: {},
                step1_feature_pkg_text: {},
                step1_premium_pkg_text: {},

                step_2_heading: {},
                step_2_name_label: {},
                step_2_name_error: {},
                step_2_name_placeholder: {},
                step_2_email_label: {},
                step_2_email_error: {},
                step_2_email_placeholder: {},
                step_2_password_label: {},
                step_2_password_error: {},
                step_2_password_placeholder: {},
                step_2_confirm_password_label: {},
                step_2_confirm_password_error: {},
                step_2_confirm_password_placeholder: {},

                step_3_heading: {},
                step_3_description: {},
                step_3_business_categories_label: {},
                step_3_business_categories_error: {},
                step_3_business_categories_placeholder: {},

                step_4_heading: {},
                step_4_name_label: {},
                step_4_name_error: {},
                step_4_name_placeholder: {},
                step_4_email_label: {},
                step_4_email_error: {},
                step_4_email_placeholder: {},
                step_4_ctn_link_label: {},
                step_4_ctn_link_error: {},
                step_4_ctn_link_placeholder: {},
                step_4_ctn_btn_label: {},
                step_4_ctn_btn_error: {},
                step_4_ctn_btn_placeholder: {},
                step_4_address_label: {},
                step_4_address_error: {},
                step_4_address_placeholder: {},
                step_4_phone_label: {},
                step_4_phone_error: {},
                step_4_phone_placeholder: {},
                step_4_website_label: {},
                step_4_website_error: {},
                step_4_website_placeholder: {},
                step_4_short_description_label: {},
                step_4_short_description_error: {},
                step_4_short_description_placeholder: {},
                step_4_description_label: {},
                step_4_description_error: {},
                step_4_description_placeholder: {},
                step_4_keywords_label: {},
                step_4_keywords_error: {},
                step_4_keywords_placeholder: {},

                step_5_heading: {},
                step_5_title_label: {},
                step_5_title_error: {},
                step_5_description_label: {},
                step_5_description_error: {},
                step_5_logo_label: {},
                step_5_logo_error: {},
                step_5_logo_placeholder: {},
                step_5_video_label: {},
                step_5_video_error: {},
                step_5_video_placeholder: {},
                step_5_image_1_label: {},
                step_5_image_1_error: {},
                step_5_image_1_placeholder: {},
                step_5_image_2_label: {},
                step_5_image_2_error: {},
                step_5_image_2_placeholder: {},
                step_5_image_3_label: {},
                step_5_image_3_error: {},
                step_5_image_3_placeholder: {},
                step_5_image_4_label: {},
                step_5_image_4_error: {},
                step_5_image_4_placeholder: {},

                step_6_heading: {},
                step_6_facebook_label: {},
                step_6_facebook_error: {},
                step_6_facebook_placeholder: {},
                step_6_twitter_label: {},
                step_6_twitter_error: {},
                step_6_twitter_placeholder: {},
                step_6_youtube_label: {},
                step_6_youtube_error: {},
                step_6_youtube_placeholder: {},
                step_6_linkedin_label: {},
                step_6_linkedin_error: {},
                step_6_linkedin_placeholder: {},

                terms_and_conditions_label: {},
                terms_and_conditions_error: {},
                submit_button_text: {},
                footer_text: {},
            };
            state.validationErros = new ErrorHandling();
            state.error = null;
        },
        setForm(state, payload) {
            state.form.id = payload.id
        },
        setValidationErros(state, payload) {
            state.validationErros.record(payload);
        },
        setEmptyError(state) {
            state.validationErros = new ErrorHandling();
        },
        setError(state, payload) {
            state.error = payload;
        },
    },
    actions: {
        addUpdateForm({ commit, state }) {
            let url = `${process.env.MIX_ADMIN_API_URL}registration-page-setting`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.post(url, state.form)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessage(res.data.message);
                            resolve(res);
                        } else {
                            helper.swalErrorMessage(res.data.message);
                        }
                    })
                    .catch((error) => {
                        commit("setEmptyError");
                        if (error.response && error.response.status == 422) {
                            commit("setValidationErros", error.response.data.errors);
                        } else if (
                            error.response &&
                            error.response.data &&
                            error.response.data.status == "Error"
                        ) {
                            helper.swalErrorMessage(error.response.data.message);
                        }
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchRegistrationPageSetting({ commit, state }, payload) {
            let url = payload.url;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setForm", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
    },
};

export default reg_page_setting;
