<template>
    <form class="lg:w-full" id="contact-us-form" @submit.prevent="recaptcha()">
        <div class="my-4">
            <div class="grid mt-4 md:grid-cols-2 gap-4">
                <div class="relative w-full mb-3">
                    <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="name">{{
                        JSON.parse(testimonial_setting)["name_label"] }}
                        <span class="text-red-500">*</span>
                    </label>
                    <input @input="clearErrors('name')" type="text" class="can-exp-input" :placeholder="JSON.parse(testimonial_setting)['name_placeholder']
                        " id="name" v-model="form.name" />
                    <Error v-if="submitted" fieldName="name" :validationErros="validationErros" />
                </div>
                <div class="relative w-full mb-3">
                    <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="email">{{
                        JSON.parse(testimonial_setting)["email_label"] }}
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" class="can-exp-input" @input="fetchCustomerData" :placeholder="JSON.parse(testimonial_setting)['email_placeholder']
                        " id="email" v-model="form.email" />
                    <Error v-if="submitted" fieldName="email" :validationErros="validationErros" />
                </div>
                <div class="relative w-full mb-3">
                    <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="company_name">{{
                        JSON.parse(testimonial_setting)["company_name_label"] }}
                        <span class="text-red-500">*</span>
                    </label>
                    <input @input="clearErrors('company_name')" type="text" class="can-exp-input" :placeholder="JSON.parse(testimonial_setting)['company_name_placeholder']
                        " id="company_name" v-model="form.company_name" />
                    <Error v-if="submitted" fieldName="company_name" :validationErros="validationErros" />
                </div>
                <div class="relative w-full mb-3">
                    <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="business_categories">
                        {{ JSON.parse(testimonial_setting)["business_categories_label"] }}
                        <span class="text-red-500">*</span>
                    </label>
                    <input @input="updateBusinessCategories($event.target.value)" type="text" class="can-exp-input"
                        :placeholder="JSON.parse(testimonial_setting)['business_categories_placeholder']"
                        id="business_categories" :value="businessCategoriesDisplay" />
                    <Error v-if="submitted" fieldName="business_categories" :validationErros="validationErros" />
                </div>

                <div class="relative w-full mb-3 col-span-2">
                    <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="message">{{
                        JSON.parse(testimonial_setting)["message_label"] }}
                        <span class="text-red-500">*</span>
                    </label>
                    <textarea @input="clearErrors('message')" rows="5" type="text" class="can-exp-input" :placeholder="JSON.parse(testimonial_setting)['message_placeholder']
                        " id="message" v-model="form.message">
            </textarea>
                    <Error v-if="submitted" fieldName="message" :validationErros="validationErros" />
                </div>
            </div>
        </div>
        <Error v-if="submitted" fieldName="captcha" :validationErros="validationErros" />
        <!-- <ListErrors :validationErrors="validationErros" /> -->
        <div class="mt-8 flex justify-center items-center">
            <button aria-label="Candian Exporters" class="button-exp-fill" type="submit" id="send-message">
                {{ JSON.parse(testimonial_setting)["button_text"] }}
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
import Error from "../components/Error.vue";
// import ListErrors from "../components/ListErrors.vue";
import axios from "axios";
import ErrorHandling from "../../ErrorHandling";
export default {
    props: ["testimonial_setting", "submit_url", "page_id"],
    components: {
        Error,
        // ListErrors,
    },
    computed: {
        businessCategoriesDisplay() {
            if (Array.isArray(this.form.business_categories)) {
                return this.form.business_categories.map(cat => cat.category_name).join(', ');
            }
            return this.form.business_categories; // Fallback for string values
        },
    },
    data() {
        return {
            form: {
                name: "",
                company_name: "",
                business_categories: "",
                email: "",
                message: "",
                page_id: "",
            },
            loading: false,
            validationErros: new ErrorHandling(),
            reCAPTCHA_site_key: process.env.MIX_reCAPTCHA_site_key,
            submitted: false,
        };
    },
    mounted() {
        this.loadFormData(); // Load saved form data when the component is mounted
    },
    watch: {
        // Watch for changes in form fields and save them to localStorage
        form: {
            handler(newValue) {
                localStorage.setItem("testimonialFormData", JSON.stringify(newValue));
            },
            deep: true, // Ensure deep watching for nested objects/arrays
        },
    },
    methods: {
        updateBusinessCategories(value) {
            if (typeof value === 'string') {
                this.form.business_categories = value.split(',').map(cat => ({
                    id: null, // You may need to fetch the ID if available
                    category_name: cat.trim(),
                }));
            } else {
                this.form.business_categories = value;
            }
            this.clearErrors('business_categories');
        },
        loadFormData() {
            const savedFormData = localStorage.getItem("testimonialFormData");
            if (savedFormData) {
                this.form = JSON.parse(savedFormData);
            }
        },
        async fetchCustomerData() {
    this.clearErrors('email');

    try {
        const response = await axios.post("/api/web/get-customer-details", {
            email: this.form.email,
        });

        if (response.data.status === "success") {
            const customer = response.data.customer;
            this.form.company_name = customer.customer_profile ? customer.customer_profile.company_name : "";

            // Map the business categories to an array of objects with id and category_name
            this.form.business_categories = customer.customer_business_category
                .map(cat => ({
                    id: cat.business_category?.id,
                    category_name: cat.business_category?.business_category_detail?.[0]?.name,
                }))
                .filter(cat => cat.id && cat.category_name); // Remove undefined/null values
        }
    } catch (error) {
        // Do not handle errors here; let them be handled during form submission
    }
},

        clearErrors(fieldName) {
            if (this.submitted) {
                this.validationErros.clear(fieldName);
            }
        },
        clearForm() {
            this.form["name"] = "";
            this.form["company_name"] = "";
            this.form["business_categories"] = "";
            this.form["email"] = "";
            this.form["message"] = "";
            this.validationErros = new ErrorHandling();
            localStorage.removeItem("testimonialFormData");
        },
        async recaptcha() {
            this.submitted = true;
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
    this.form.page_id = this.page_id;

    // Ensure business_categories is an array of objects with id and category_name
    if (typeof this.form.business_categories === 'string') {
        this.form.business_categories = this.form.business_categories.split(',').map(cat => ({
            id: null, // You may need to fetch the ID if available
            category_name: cat.trim(),
        }));
    }

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
                // Handle validation errors
                this.validationErros.record(error.response.data.errors);
            } else if (error.response && error.response.status == 403) {
                // Handle closed account error
                this.validationErros.record({ email: [error.response.data.message] });
            } else if (error.response && error.response.status == 404) {
                // Handle "no user found" error
                this.validationErros.record({ email: [error.response.data.message] });
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