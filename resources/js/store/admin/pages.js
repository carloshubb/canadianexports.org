import ErrorHandling from "../../ErrorHandling";

const pages = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            is_page_edit: false,
            template: null,
            facebook_media_id: null,
            twitter_media_id: null,
            linkedin_media_id: null,
            is_home_page: false,
            set_as_default_page: false,
            post_submit_button_text: {},
            company_name_label: {},
            name_label: {},
            country_label: {},
            widget_name: {},
            tab1_text: {},
            tab2_text: {},
            tab3_text: {},
            contact_tab_heading: {},
            required_fields_text: {},
            contact_info_heading: {},
            mail_address_text: {},
            phone_text: {},
            email_text: {},
            link_text: {},
            button_text: {},
            page_description: {},
            name: {},
            description: {},
            meta_keywords: {},
            page_detail: {},
            slider_heading:{},
            slider_search_placeholder:{},
            slider_advance_search_text:{},
            slider_image:{},
            section1_heading:{},
            section1_description:{},
            section1_business_category:{},
            section1_business_category_url:{},
            section2_heading:{},
            section2_category_label:{},
            section2_country_label:{},
            section2_deadline_label:{},
            section2_estimated_value_label:{},
            section2_i2b_button_text:{},
            section2_button_text:{},
            section2_button_url:{},
            section3_heading:{},
            section3_button_text:{},
            section3_button_url:{},
            section3_become_sponsor_btn_text:{},
            section3_become_sponsor_btn_url:{},
            section4_heading:{},
            section5_heading:{},
            section5_event_detail_button_text:{},
            section5_website_button_text:{},
            section5_see_all_button_text:{},
            section5_see_all_button_url:{},
            section5_add_event_text:{},
            section5_add_event_url:{},
            section6_heading:{},
            section6_description:{},
            section6_see_all_button:{},
            business_categories: [],

            // reg page
            page_title: {},

            

            company_name_placeholder: {},
            city_placeholder: {},
            province_label: {},
            province_error: {},
            province_placeholder: {},
            industry_label: {},
            industry_error: {},
            industry_placeholder: {},
            button_text: {},

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
            step_4_cta_link_label: {},
            step_4_cta_link_error: {},
            step_4_cta_link_placeholder: {},
            step_4_cta_btn_label: {},
            step_4_cta_btn_error: {},
            step_4_cta_btn_placeholder: {},
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

            keyword_label: {},
            keyword_error: {},
            keyword_placeholder: {},

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
            step_5_gallery_image_label: {},
            step_5_gallery_image_error: {},

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

            // login page setting
            logo_label: {},
            press_url_label: {},
            visitors_label: {},
            exibitors_url_label: {},
            event_website_label: {},
            end_date_label: {},
            start_date_label: {},
            description_label: {},
            short_description_label: {},
            product_search_label: {},
            product_search_placeholder: {},
            venue_label: {},
            street_name_label: {},
            city_label: {},
            title_label: {},
            title_error: {},
            country_error: {},
            city_error: {},
            street_name_error: {},
            name_error: {},
            password_error: {},
            confirm_password_error: {},
            company_name_error: {},
            venue_error: {},
            product_search_error: {},
            short_description_error: {},
            description_error: {},
            start_date_error: {},
            end_date_error: {},
            event_website_error: {},
            exibitors_url_error: {},
            visitors_error: {},
            press_url_error: {},
            logo_error: {},
            gallery_image_label: {},
            gallery_image_error: {},
            video_url_label: {},
            video_url_error: {},
            contact_name_label: {},
            contact_name_error: {},
            contact_email_label: {},
            contact_email_error: {},
            contact_phone_label: {},
            contact_phone_error: {},
            contact_designation_label: {},
            contact_designation_error: {},
            facebook_url_label: {},
            facebook_url_error: {},
            twitter_url_label: {},
            twitter_url_error: {},
            linkedin_url_label: {},
            linkedin_url_error: {},
            youtube_url_label: {},
            youtube_url_error: {},
            pintrest_url_label: {},
            pintrest_url_error: {},
            instagram_url_label: {},
            instagram_url_error: {},
            snapchat_url_label: {},
            snapchat_url_error: {},
            main_heading: {},
            email_label: {},
            email_error: {},
            contact_number_label: {},
            contact_number_error: {},
            message_label: {},
            message_error: {},
            send_me_a_copy_text: {},
            image_label: {},
            image_error: {},
            url_label: {},
            url_error: {},
            submit_btn_text: {},
            contact_label: {},
            email_help: {},
            password_label: {},
            password_placeholder: {},
            confirm_password_label: {},
            remeber_me_label: {},
            forgot_password_text: {},
            free_package_text: {},
            featured_package_text: {},
            premium_package_text: {},
            free_package_btn_text: {},
            package_error: {},
            signin_btn_text: {},
            signup_btn_text: {},
            page_heading: {},
            read_more_btn_text: {},
            number_of_featured_exporters: null,
            after_header_widget_id: null,
            before_footer_widget_id: null,
            header_widget_id: null,
            business_category_widget_id: null,
            i2b_widget_id: null,
            sponsor_widget_id: null,
            business_widget_id: null,
            events_widget_id: null,
            magazine_widget_id: null,

        },
        pages: null,
        loading: false,
        sortBy: "id",
        sortType: "desc",
        searchParam: null,
        pagination: {},
        limit: 10,
        param: "withFlagIcon=1",
        isFormEdit: false,
    },
    mutations: {
        setHeaderWidgetId(state, payload) {
            state.form.header_widget_id = payload;
        },
        setBusinessCategoryWidgetId(state, payload) {
            state.form.business_category_widget_id = payload;
        },
        setI2bWidgetId(state, payload) {
            state.form.i2b_widget_id = payload;
        },
        setSponsorWidgetId(state, payload) {
            state.form.sponsor_widget_id = payload;
        },
        setBusinessWidgetId(state, payload) {
            state.form.business_widget_id = payload;
        },
        setEventsWidgetId(state, payload) {
            state.form.events_widget_id = payload;
        },
        setMagazineWidgetId(state, payload) {
            state.form.magazine_widget_id = payload;
        },
        setBusinessCategoriesForm(state, payload) {
            state.form.business_categories = payload;
        },
        setAfterHeaderWidgetForm(state, payload) {
            state.form.after_header_widget_id = payload;
        },
        setBeforeFooterWidgetForm(state, payload) {
            state.form.before_footer_widget_id = payload;
        },
        setPageValues(state, payload) {
            state.form[payload.key] = payload.value;
        },
        setHomePageSetting(state, payload) {
            state.form[payload.key] = payload.value;
        },
        updateHomePageSetting(state, payload) {
            // console.log('object name '+ payload.key + ', '+ 'lang id '+ payload.key + ', '+ ' value '+ payload.value);
            // console.log('lang id', payload.key);
            // console.log('value', payload.value);
            state.form[payload.key][`${payload.key}_${payload.id}`] = payload.value;
        },
        resetForm(state) {
            state.form = {
                id: null,
                template: null,
                facebook_media_id: null,
                twitter_media_id: null,
                linkedin_media_id: null,
                is_home_page: false,
                set_as_default_page: false,
                post_submit_button_text: {},
                company_name_label: {},
                name_label: {},
                country_label: {},
                widget_name: {},
                tab1_text: {},
                tab2_text: {},
                tab3_text: {},
                contact_tab_heading: {},
                required_fields_text: {},
                contact_info_heading: {},
                mail_address_text: {},
                phone_text: {},
                email_text: {},
                link_text: {},
                button_text: {},
                page_description: {},
                name: {},
                description: {},
                meta_keywords: {},
                page_detail: {},
                slider_heading:{},
                slider_search_placeholder:{},
                slider_advance_search_text:{},
                slider_image:{},
                section1_heading:{},
                section1_description:{},
                section1_business_category:{},
                section1_business_category_url:{},
                section2_heading:{},
                section2_category_label:{},
                section2_country_label:{},
                section2_deadline_label:{},
                section2_estimated_value_label:{},
                section2_i2b_button_text:{},
                section2_button_text:{},
                section2_button_url:{},
                section3_heading:{},
                section3_button_text:{},
                section3_button_url:{},
                section3_become_sponsor_btn_text:{},
                section3_become_sponsor_btn_url:{},
                section4_heading:{},
                section5_heading:{},
                section5_event_detail_button_text:{},
                section5_website_button_text:{},
                section5_see_all_button_text:{},
                section5_see_all_button_url:{},
                section5_add_event_text:{},
                section5_add_event_url:{},
                section6_heading:{},
                section6_description:{},
                section6_see_all_button:{},

                // reg page
                page_title: {},

                company_name_placeholder: {},
                city_placeholder: {},
                province_label: {},
                province_error: {},
                province_placeholder: {},
                industry_label: {},
                industry_error: {},
                industry_placeholder: {},
                button_text: {},

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
                step_4_cta_link_label: {},
                step_4_cta_link_error: {},
                step_4_cta_link_placeholder: {},
                step_4_cta_btn_label: {},
                step_4_cta_btn_error: {},
                step_4_cta_btn_placeholder: {},
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
                keyword_label: {},
                keyword_error: {},
                keyword_placeholder: {},

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
                step_5_gallery_image_label: {},
                step_5_gallery_image_error: {},

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

                // login page setting
                logo_label: {},
                press_url_label: {},
                visitors_label: {},
                exibitors_url_label: {},
                event_website_label: {},
                end_date_label: {},
                start_date_label: {},
                description_label: {},
                short_description_label: {},
                product_search_label: {},
                product_search_placeholder: {},
                venue_label: {},
                street_name_label: {},
                city_label: {},
                title_label: {},
                title_error: {},
                country_error: {},
                city_error: {},
                street_name_error: {},
                name_error: {},
                password_error: {},
                confirm_password_error: {},
                company_name_error: {},
                venue_error: {},
                product_search_error: {},
                short_description_error: {},
                description_error: {},
                start_date_error: {},
                end_date_error: {},
                event_website_error: {},
                exibitors_url_error: {},
                visitors_error: {},
                press_url_error: {},
                logo_error: {},
                gallery_image_label: {},
                gallery_image_error: {},
                video_url_label: {},
                video_url_error: {},
                contact_name_label: {},
                contact_name_error: {},
                contact_email_label: {},
                contact_email_error: {},
                contact_phone_label: {},
                contact_phone_error: {},
                contact_designation_label: {},
                contact_designation_error: {},
                facebook_url_label: {},
                facebook_url_error: {},
                twitter_url_label: {},
                twitter_url_error: {},
                linkedin_url_label: {},
                linkedin_url_error: {},
                youtube_url_label: {},
                youtube_url_error: {},
                pintrest_url_label: {},
                pintrest_url_error: {},
                instagram_url_label: {},
                instagram_url_error: {},
                snapchat_url_label: {},
                snapchat_url_error: {},
                main_heading: {},
                email_label: {},
                email_error: {},
                contact_number_label: {},
                contact_number_error: {},
                message_label: {},
                message_error: {},
                send_me_a_copy_text: {},
                image_label: {},
                image_error: {},
                url_label: {},
                url_error: {},
                submit_btn_text: {},
                contact_label: {},
                email_help: {},
                password_label: {},
                password_placeholder: {},
                confirm_password_label: {},
                remeber_me_label: {},
                forgot_password_text: {},
                free_package_text: {},
                featured_package_text: {},
                premium_package_text: {},
                free_package_btn_text: {},
                package_error: {},
                signin_btn_text: {},
                signup_btn_text: {},
                page_heading: {},
                read_more_btn_text: {},
                number_of_featured_exporters: null,
            };
            state.validationErros = new ErrorHandling();
            state.error = null;
            state.isFormEdit = 0;
        },
        setPages(state, payload) {
            state.pages = payload;
        },
        setPagination(state, pagination) {
            if (pagination.meta) {
                state.pagination = {
                    current_page: pagination.meta.current_page,
                    last_page: pagination.meta.last_page,
                    next_page_url: pagination.links ? pagination.links.next : null,
                    prev_page_url: pagination.links ? pagination.links.prev : null,
                };
            }
        },
        setSearchParam(state, payload) {
            state.searchParam = payload;
            state.param = helper.updateUrlParameter(state.param, "searchParam", payload);
        },
        setLimit(state, payload) {
            state.limit = payload;
            state.param = helper.updateUrlParameter(state.param, "limit", payload);
        },
        setSortBy(state, payload) {
            state.sortBy = payload;
            state.param = helper.updateUrlParameter(state.param, "sortBy", payload);
        },
        setSortType(state, payload) {
            state.sortType = payload;
            state.param = helper.updateUrlParameter(state.param, "sortType", payload);
        },
        setLoading(state, payload) {
            state.loading = payload ? payload : !state.loading;
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
        setIsFormEdit(state, payload) {
            state.isFormEdit = payload;
        },
    },
    actions: {
        addUpdateForm({ commit, state }) {
            let method = state.isFormEdit ? "put" : "post";
            let url = state.isFormEdit
                ? `${process.env.MIX_ADMIN_API_URL}pages/${state.form.id}`
                : `${process.env.MIX_ADMIN_API_URL}pages`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios[method](url, state.form)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessage(res.data.message);
                            commit("resetForm");
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
        fetchPages({ commit, state }, payload) {
            let url = payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}pages?q=1`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setPages", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchPage({ commit, state }, payload) {
            let url = payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}pages/${payload.id}?q=1`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        deletePage({ commit }, payload) {
            commit("setLoading");
            let url = payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}pages/${payload.id}`;
            return axios
            .delete(url, {
                data: { password: payload.password },
            })
                    .then((res) => {
                        if (res.data.status == "Success") {
                            return res;
                        } else if (res.data.status == "Error") {
                            return res;
                        }
                    })
                    .catch(error => {
                        throw error;
                    })
                    .finally(() => commit("setLoading"));
        },
        passwordVerification({ commit }, payload) {
            commit("setLoading");
            let url = payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}password-verification`;
            return new Promise(function (resolve, reject) {
                axios.post(url, payload)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            // helper.swalSuccessMessage(res.data.message);
                            resolve(res);
                        } else if (res.data.status == "Error") {
                            // helper.swalErrorMessage(res.data.message);
                            resolve(res);
                        }
                    })
                    .finally(() => commit("setLoading"));
            });
        },
    },
};

export default pages;
