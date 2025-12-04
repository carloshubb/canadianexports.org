<template>
    <form class="" @submit.prevent="recaptcha()">
        <div class="my-4">
            <div class="relative w-full mb-3">
                <label
                    class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg"
                    for="name"
                >
                    {{
                        JSON.parse(advertiser_setting)
                            ? JSON.parse(advertiser_setting)[
                                  "contact_tab_name_label"
                              ]
                            : "Your name"
                    }}
                    <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    class="can-exp-input"
                    placeholder=""
                    id="name"
                    v-model="form.name"
                    @input="clearErrors('name')"
                />
                <Error
                v-if="submitted"
                    fieldName="name"
                    :validationErros="validationErros"
                    full_width="1"
                />
            </div>
            <div class="relative w-full mb-3">
                <label
                    class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg"
                    for="company-name"
                >
                    {{
                        JSON.parse(advertiser_setting)
                            ? JSON.parse(advertiser_setting)[
                                  "contact_tab_company_name_label"
                              ]
                            : "Your company"
                    }}
                    <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    class="can-exp-input"
                    placeholder=""
                    id="company_name"
                    v-model="form.company_name"
                    @input="clearErrors('company_name')"
                />
                <Error
                v-if="submitted"
                    fieldName="company_name"
                    :validationErros="validationErros"
                    full_width="1"
                />
            </div>
            <div class="relative w-full mb-3">
                <label
                    class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg"
                    for="email"
                >
                    {{
                        JSON.parse(advertiser_setting)
                            ? JSON.parse(advertiser_setting)[
                                  "contact_tab_email_label"
                              ]
                            : "Your email"
                    }}
                    <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    class="can-exp-input"
                    placeholder=""
                    id="email"
                    v-model="form.email"
                    @input="clearErrors('email')"
                />
                <Error
                v-if="submitted"
                    fieldName="email"
                    :validationErros="validationErros"
                    full_width="1"
                />
            </div>
            <div class="relative w-full mb-3">
                <label
                    class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg"
                    for="mailing-address"
                >
                    {{
                        JSON.parse(advertiser_setting)
                            ? JSON.parse(advertiser_setting)[
                                  "contact_tab_message_label"
                              ]
                            : "Your message"
                    }}
                    <span class="text-red-500">*</span>
                </label>
                <textarea
                    rows="5"
                    class="can-exp-input"
                    placeholder=""
                    id="message"
                    v-model="form.message"
                    @input="clearErrors('message')"
                ></textarea>
                <Error
                v-if="submitted"
                    fieldName="message"
                    :validationErros="validationErros"
                    full_width="1"
                />
            </div>
            <div class="relative w-full mb-3">
                <div class="flex items-center">
                    <input
                        type="checkbox"
                        v-model="form.send_me_copy"
                        class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary"
                        id="send-me-copy"
                        @input="clearErrors('send-me-copy')"
                    />
                    <label
                        class="ml-2 text-gray-900 text-base md:text-base lg:text-lg"
                        for="send-me-copy"
                    >
                        {{
                            JSON.parse(advertiser_setting)
                                ? JSON.parse(advertiser_setting)[
                                      "contact_tab_send_me_a_copy_text"
                                  ]
                                : "Send me a copy"
                        }}
                    </label>
                </div>

                <Error
                v-if="submitted"
                    fieldName="send_me_copy"
                    :validationErros="validationErros"
                    full_width="1"
                />
            </div>
            <div class="recaptcha">
                <Error
                v-if="submitted"
                    fieldName="captcha"
                    :validationErros="validationErros"
                    full_width="1"
                />
            </div>
            <div class="mt-8 flex justify-center items-center">
                <button
                    aria-label="Candian Exporters"
                    class="button-exp-fill"
                    type="submit"
                >
                    {{
                        JSON.parse(advertiser_setting)
                            ? JSON.parse(advertiser_setting)[
                                  "contact_tab_button_text"
                              ]
                            : "Send"
                    }}
                </button>
            </div>
        </div>
        <div v-if="loading">
            <div id="form_preloader">
                <div id="form_status">
                    <div class="form_spinner">
                        <div class="form-double-bounce1"></div>
                        <div class="form-double-bounce2"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import { load } from "recaptcha-v3";
import Error from "./../components/Error.vue";
import axios from "axios";
import ErrorHandling from "../../ErrorHandling";
export default {
    props: ["submit_url", "customer_id", "advertiser_setting", "page_id"],
    components: {
        Error,
    },
    data() {
        return {
            form: {
                page_id: "",
                name: "",
                email: "",
                company_name: "",
                customer_profile_id: "",
                message: "",
                send_me_copy: false,
            },
            loading: false,
            validationErros: new ErrorHandling(),
            reCAPTCHA_site_key: process.env.MIX_reCAPTCHA_site_key,
            submitted: false,
        };
    },
    methods: {
        clearErrors(fieldName) {
            if (this.submitted) {
                this.validationErros.clear(fieldName);
            }
        },
        clearForm() {
            this.form["company_name"] = "";
            this.form["page_id"] = "";
            this.form["name"] = "";
            this.form["email"] = "";
            this.form["message"] = "";
            this.form["send_me_copy"] = false;
            this.form["customer_profile_id"] = this.customer_id;
            this.validationErros = new ErrorHandling();
        },
        async recaptcha() {
            this.submitted = true;
            this.loading = 1;
            load(process.env.MIX_reCAPTCHA_site_key).then((recaptcha) => {
                recaptcha.showBadge()
                recaptcha.execute("submit").then((token) => {
                    axios
                .post(`${process.env.MIX_WEB_API_URL}verifyRecaptcha`, {
                    token: token,
                })
                .then((res) => {
                    setTimeout(() => {
                        recaptcha.hideBadge()
                    }, 3000);
                    if (res.data.status == "Success") {
                        this.saveForm();
                    } else if (res.data.status == "Error") {
                        this.loading = 0;
                        this.validationErros.record({
                            captcha: [res.data.message],
                        });
                    }
                });
                });
            });
        },
        saveForm() {
            this.loading = true;
            this.form.page_id = this.page_id;
            this.form.customer_profile_id = this.customer_id;
            axios
                .post(this.submit_url, this.form)
                .then((res) => {
                    this.loading = false;
                    if (res.data.status == "Success") {
                        helper.swalSuccessMessageForWeb(res.data.message);
                        this.clearForm();
                    } else {
                        helper.swalErrorMessageForWeb(res.data.message);
                    }
                })
                .catch((error) => {
                    this.loading = false;
                    this.validationErros = new ErrorHandling();
                    if (error.response && error.response.status == 422) {
                        this.validationErros.record(error.response.data.errors);
                    } else if (
                        error.response &&
                        error.response.data &&
                        error.response.data.status == "Error"
                    ) {
                        helper.swalErrorMessageForWeb(
                            error.response.data.message
                        );
                    }
                });
        },
    },
};
</script>
