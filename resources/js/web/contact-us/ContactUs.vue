<template>
    <form class="lg:w-full" id="contact-us-form" @submit.prevent="recaptcha()">
        <div class="my-4">
            <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row gap-4">
                <div class="relative w-full mb-3">
                    <label class="block text-gray-900 mb-2" for="name">
                        {{ JSON.parse(contact_us)["name_label"] }}
                        <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        class="can-exp-input"
                        placeholder=""
                        id="name"
                        v-model="form.name"
                        @input="clearFieldError('name')"
                    />
                    <Error
                        v-if="submitted && validationErros.has('name')"
                        fieldName="name"
                        :validationErros="validationErros"
                        full_width="1"
                    />
                </div>
                <div class="relative w-full mb-3">
                    <label class="block text-gray-900 mb-2" for="email">
                        {{ JSON.parse(contact_us)["email_label"] }}
                        <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        class="can-exp-input"
                        placeholder=""
                        id="email"
                        v-model="form.email"
                        @input="clearFieldError('email')"
                    />
                    <Error
                        v-if="submitted && validationErros.has('email')"
                        fieldName="email"
                        :validationErros="validationErros"
                        full_width="1"
                    />
                </div>
            </div>
            <div class="relative w-full mb-3">
                <label class="block text-gray-900 mb-2" for="message">
                    {{ JSON.parse(contact_us)["message_label"] }}
                    <span class="text-red-500">*</span>
                </label>
                <textarea
                    rows="5"
                    class="can-exp-input"
                    placeholder=""
                    id="message"
                    v-model="form.message"
                    @input="clearFieldError('message')"
                ></textarea>
                <Error
                    v-if="submitted && validationErros.has('message')"
                    fieldName="message"
                    :validationErros="validationErros"
                />
            </div>
        </div>
        <Error fieldName="captcha" :validationErros="validationErros" />
        <div class="mt-8 flex justify-center items-center">
            <button
                aria-label="Candian Exporters"
                class="button-exp-fill"
                type="submit"
                id="send-message"
            >
                {{ JSON.parse(contact_us)["button_text"] }}
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
    props: ["contact_us", "submit_url", "page_id"],
    components: {
        Error,
    },
    data() {
        return {
            form: {
                page_id: "",
                name: "",
                email: "",
                message: "",
            },
            loading: false,
            validationErros: new ErrorHandling(),
            reCAPTCHA_site_key: process.env.MIX_reCAPTCHA_site_key,
            submitted: false, // To track if form is submitted
        };
    },
    mounted() {
        // Load form data from localStorage
        const savedForm = localStorage.getItem("contact_us_form");
        if (savedForm) {
            this.form = JSON.parse(savedForm);
        }
    },
    watch: {
        form: {
            handler(newForm) {
                // Save form data to localStorage on change
                localStorage.setItem("contact_us_form", JSON.stringify(newForm));
            },
            deep: true,
        },
    },
    methods: {
        clearForm() {
            this.form.page_id = "";
            this.form.name = "";
            this.form.email = "";
            this.form.message = "";
            this.validationErros = new ErrorHandling();
            // Clear localStorage data
            localStorage.removeItem("contact_us_form");
        },
        clearFieldError(fieldName) {
            // Clear error for the specific field when the user starts typing
            if (this.validationErros.has(fieldName)) {
                this.validationErros.clear(fieldName);
            }
        },
        async recaptcha() {
            this.submitted = true; // Set submitted flag to true
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
            this.loading = 1;
            this.form.page_id = this.page_id;
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
                        helper.swalErrorMessageForWeb(error.response.data.message);
                    }
                });
        },
    },
};
</script>
