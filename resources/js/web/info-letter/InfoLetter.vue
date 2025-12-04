<template>
    <form class="lg:w-full" @submit.prevent="recaptcha()">
        <div class="my-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5">
            <div class="relative w-full">
                <label
                    class="block text-base md:text-base lg:text-lg"
                    for="company_name"
                    >{{ JSON.parse(info_letter)["company_name_label"] }}
                    <span class="text-red-500">*</span></label
                >
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
                />
            </div>
            <div class="relative w-full">
                <label
                    class="block text-base md:text-base lg:text-lg"
                    for="name"
                    >{{ JSON.parse(info_letter)["name_label"] }}
                    <span class="text-red-500">*</span></label
                >
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
                />
            </div>
            <div class="relative w-full">
                <label
                    class="block text-base md:text-base lg:text-lg"
                    for="email"
                    >{{ JSON.parse(info_letter)["email_label"] }}
                    <span class="text-red-500">*</span></label
                >
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
                />
            </div>
            <div class="relative w-full">
                <label
                    class="block text-base md:text-base lg:text-lg"
                    for="country"
                    >{{ JSON.parse(info_letter)["country_label"] }}
                    <span class="text-red-500">*</span></label
                >
                <input
                    type="text"
                    class="can-exp-input"
                    placeholder=""
                    id="country"
                    v-model="form.country"
                    @input="clearErrors('country')"
                />
                <Error
                    v-if="submitted"
                    fieldName="country"
                    :validationErros="validationErros"
                />
            </div>
        </div>
        <Error v-if="submitted" fieldName="captcha" :validationErros="validationErros" />
        <div class="mt-8 flex justify-center items-center">
            <button
                aria-label="Candian Exporters"
                class="button-exp-fill"
                type="submit"
                id="send-message"
            >
                {{ JSON.parse(info_letter)["button_text"] }}
            </button>
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
    props: ["info_letter", "recaptcha_key", "submit_url", "page_id"],
    components: {
        Error,
    },
    data() {
        return {
            form: {
                page_id: "",
                company_name: "",
                name: "",
                email: "",
                country: "",
            },
            loading: false,
            validationErros: new ErrorHandling(),
            reCAPTCHA_site_key: process.env.MIX_reCAPTCHA_site_key,
            submitted: false, // To track if the form has been submitted
        };
    },
    mounted() {
        // Load form data from localStorage
        const savedForm = localStorage.getItem("info_letter_form");
        if (savedForm) {
            this.form = JSON.parse(savedForm);
        }
    },
    watch: {
        form: {
            handler(newForm) {
                // Save form data to localStorage on change
                localStorage.setItem("info_letter_form", JSON.stringify(newForm));
            },
            deep: true,
        },
    },
    methods: {
        // Clear error messages for individual fields when user types
        clearErrors(fieldName) {
            if (this.submitted) {
                this.validationErros.clear(fieldName);
            }
        },
        clearForm() {
            this.form["page_id"] = "";
            this.form["company_name"] = "";
            this.form["name"] = "";
            this.form["email"] = "";
            this.form["country"] = "";
            this.validationErros = new ErrorHandling();
            // Clear localStorage data
            localStorage.removeItem("info_letter_form");
        },
        async recaptcha() {
            this.submitted = true; // Mark the form as submitted
            this.loading = 1;
            load(process.env.MIX_reCAPTCHA_site_key).then((recaptcha) => {
                recaptcha.showBadge();
                recaptcha.execute("submit").then((token) => {
                    axios
                        .post(`${process.env.MIX_WEB_API_URL}verifyRecaptcha`, {
                            token: token,
                        })
                        .then((res) => {
                            setTimeout(() => {
                                recaptcha.hideBadge();
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
            this.form["page_id"] = this.page_id;
            this.loading = 1;
            axios
                .post(this.submit_url, this.form)
                .then((res) => {
                    this.loading = 0;
                    if (res.data.status == "Success") {
                        helper.swalPreSuccessMessageForWeb(res.data.message);
                        this.clearForm();
                    } else {
                        helper.swalErrorMessageForWeb(res.data.message);
                    }
                })
                .catch((error) => {
                    this.loading = 0;
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
