<template>
    <div class="sm:overflow-hidden sm:rounded-md p-2">
        <div class="">
            <div>
                <h1 class="text-center" v-html="regPageSetting &&
                        regPageSetting.reg_page_setting_detail &&
                        regPageSetting.reg_page_setting_detail[0]
                        ? regPageSetting.reg_page_setting_detail[0]
                            .page_title
                        : ''
                    "></h1>
            </div>
            <div class="">
                <span class="register-business" v-html="regPageSetting &&
                        regPageSetting.reg_page_setting_detail &&
                        regPageSetting.reg_page_setting_detail[0]
                        ? regPageSetting.reg_page_setting_detail[0]
                            .page_description
                        : ''
                    "></span>
                <form enctype="multipart/form-data" class="mt-8">
                    <div class="space-y-8">
                        <div>
                            <div
                                class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-xblue via-primary to-blue-600 rounded-md">
                                
                                    <h4 class="text-white" v-html="regPageSetting &&
                                        regPageSetting.reg_page_setting_detail &&
                                        regPageSetting
                                            .reg_page_setting_detail[0]
                                        ? regPageSetting
                                            .reg_page_setting_detail[0]
                                            .step_1_heading
                                        : ''
                                    "></h4>
                            </div>
                            <div class="text-center mt-4 flex flex-col justify-center items-center">
                                <p v-html="regPageSetting
                                        ?.reg_page_setting_detail?.[0]
                                        ?.step_1_acc_description
                                    "></p>
                                <svg width="40" height="40" viewBox="0 0 423 557" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M218.622 394.188C205.437 369.942 189.652 346.998 165.4 327.791C165.763 330.7 166.013 333.291 166.234 335.575C166.362 336.897 166.48 338.115 166.604 339.233C167.098 343.688 167.677 346.328 168.973 348.249C204.057 400.251 226.795 457.628 244.498 517.214C246.733 524.734 249.158 532.171 252.838 538.674C257.861 547.547 263.59 552.388 269.794 553.935C276.002 555.484 283.315 553.892 291.848 548.519L293.041 550.413L291.848 548.519C295.988 545.913 299.802 542.48 303.406 538.833L305.091 540.498L303.406 538.833C336.692 505.157 370.667 471.561 416.292 452.479C396.86 445.344 379.509 446.081 363.303 451.598C345.416 457.686 328.814 469.633 312.323 483.624L308.206 487.117V481.718C308.206 466.752 308.572 452.192 308.93 437.928C309.691 407.663 310.419 378.726 307.546 350.052C295.137 226.192 244.28 121.418 143.472 46.6022C117.563 27.3736 84.5008 16.4676 52.7553 5.99609L52.2958 5.84448L53.0178 3.65552L52.2957 5.84442C41.1379 2.16345 34.2754 1.64648 27.4674 3.67877C21.6912 5.40308 15.8071 8.98517 7.38014 14.6144C113.844 23.9766 174.073 94.7545 222.293 180.262C273.209 270.554 285.806 366.598 263.619 472.218L262.303 478.483L259.025 472.984C251.387 460.169 244.792 446.906 238.362 433.65C237.402 431.67 236.446 429.691 235.49 427.714C230.034 416.425 224.605 405.19 218.622 394.188Z"
                                        fill="black" stroke="black" stroke-width="5" />
                                </svg>

                            </div>

                            <RegistrationPackage :payment_setting="payment_setting" />
                        </div>
                        <div class="pt-8">
                            <UserProfile :lang="lang" />
                        </div>
                        <div class="pt-8">
                            <BusinessCategories />
                        </div>
                        <div class="pt-8">
                            <CustomerProfile />
                        </div>
                        <div class="pt-8">
                            <Media ref="mediaComponent" />
                        </div>
                        <div class="pt-8">
                            <SocialMedia />
                        </div>
                        <div class="">
                            <Error fieldName="captcha" :validationErros="validationErros" />
                        </div>
                        <div class="">
                            <Terms />
                        </div>
                    </div>

                    <div class="pt-5 border-t border-gray-200">
                        <div class="flex justify-center">
                            <button aria-label="Candian Exporters" type="submit" class="button-exp-fill"
                                @click.prevent="recaptcha()">
                                {{
                                    regPageSetting &&
                                        regPageSetting.reg_page_setting_detail &&
                                        regPageSetting.reg_page_setting_detail[0]
                                        ? regPageSetting
                                            .reg_page_setting_detail[0]
                                            .submit_button_text
                                        : "Submit"
                                }}
                            </button>
                        </div>
                    </div>

                    <div class="text-base md:text-base lg:text-lg mt-4" v-html="regPageSetting &&
                            regPageSetting.reg_page_setting_detail &&
                            regPageSetting.reg_page_setting_detail[0]
                            ? regPageSetting.reg_page_setting_detail[0]
                                .footer_text
                            : ''
                        "></div>
                </form>
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
    </div>
</template>

<script>
import { load } from "recaptcha-v3";
import CustomerProfile from "./CustomerProfile.vue";
import BusinessCategories from "./BusinessCategories.vue";
import RegistrationPackage from "./RegistrationPackage.vue";
import UserProfile from "./UserProfile.vue";
import Terms from "./Terms.vue";
import SocialMedia from "./SocialMedia.vue";
import Media from "./Media.vue";
import { mapState } from "vuex";
import Error from "./../components/Error.vue";

export default {
    props: ["page_id", "lang", "payment_setting"],
    computed: {
        ...mapState({
            validationErros: (state) => state.signup.validationErros,
            regPageSetting: (state) => state.signup.regPageSetting,
            registrationPackages: (state) => state.signup.registrationPackages,
            isRequiredFieldsFilled: (state) =>
                state.signup.isRequiredFieldsFilled,
        }),
    },
    components: {
        BusinessCategories,
        RegistrationPackage,
        UserProfile,
        CustomerProfile,
        Terms,
        SocialMedia,
        Media,
        Error,
    },
    data() {
        return {
            loading: false,
            toggelSubmitButton: false,
            reCAPTCHA_site_key: process.env.MIX_reCAPTCHA_site_key,
        };
    },
    methods: {
        async recaptcha() {
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
                                this.addForm();
                            } else if (res.data.status == "Error") {
                                this.loading = 0;
                                this.$store.commit(
                                    "signup/recordValidationError",
                                    {
                                        field: "captcha",
                                        error: res.data.message,
                                    }
                                );
                            }
                        });
                });
            });
        },
        async addForm() {
            this.loading = true;
            this.$store
                .dispatch("signup/addForm")
                .then((res) => {
                    this.loading = false;
                    if (res.data.status == "Success") {
                        // Clear localStorage on successful submission
                        localStorage.removeItem("formData");
                        window.location.href = res.data.data.redirect_url;
                    }
                })
                .catch((errors) => {
                    if (errors.response && errors.response.status == 422) {
                        this.focusOnFirstErrorInput(errors.response.data.errors);
                    }
                })
                .finally(() => (this.loading = false));
        },
        // focusOnFirstErrorInput(errors) {
        //     // Find the first error field and focus on it
        //     const firstErrorField = Object.keys(errors)[0];
        //     if (
        //         firstErrorField == "business_categories_id" ||
        //         firstErrorField == "registration_package_id"
        //     ) {
        //         const containerDiv = document.getElementById(firstErrorField);
        //         containerDiv.scrollIntoView();
        //         return true;
        //     } else {
        //         const firstErrorInput = document.querySelector(
        //             `[id="${firstErrorField}"]`
        //         );

        //         if (firstErrorInput) {
        //             firstErrorInput.focus();
        //         }
        //     }
        // },
        focusOnFirstErrorInput(errors) {
            // Find the first error field
            const firstErrorField = Object.keys(errors)[0];

            // Handle specific fields (e.g., media fields like 'business_categories_id' or 'registration_package_id')
            if (
                firstErrorField == "business_categories_id" ||
                firstErrorField == "registration_package_id" ||
                firstErrorField == "media_id" ||  // Add this for media-related errors
                firstErrorField == "file_upload"  // Add this for file upload errors
            ) {
                const containerDiv = document.getElementById(firstErrorField);
                if (containerDiv) {
                    containerDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    containerDiv.focus();
                }
                return true;
            } else {
                // General case: Focus on the first error input field
                if (firstErrorField === "customer_media_video") {
                    this.$refs.mediaComponent.displayMediaSection = 1;
                }

                // Handle all error fields dynamically
                this.$nextTick(() => {
                    const firstErrorInput = document.querySelector(`[id="${firstErrorField}"]`);
                    if (firstErrorInput) {
                        firstErrorInput.focus();
                    }
                });
            }
        },
    },
    created() {
        this.$store.commit("signup/setForm", {
            field: "is_auto_renew",
            value: true,
        });
        this.$store
            .dispatch("signup/fetchRegistrationPackages", {
                url: `${process.env.MIX_WEB_API_URL}get-registration-packages?getPackagesOnly=1&withPackageFeatures=1&getProfilePackagesOnly=1`,
            })
            .then((res) => {
                if (res.data.status == "Success") {
                    this.registrationPackages.map((registrationPackage) => {
                        if (registrationPackage.is_default == "1") {
                            this.$store.commit("signup/setForm", {
                                field: "registration_package_id",
                                value: registrationPackage.id,
                            });
                            this.$store.commit(
                                "signup/setPackageType",
                                registrationPackage.package_type
                            );
                            this.$store.commit(
                                "signup/setMaxFiles",
                                registrationPackage.images_allowed
                            );
                            this.$store.commit(
                                "signup/setSelectedPackageId",
                                registrationPackage.id
                            );
                            return true;
                        }
                    });
                }
            });
        this.$store.dispatch("signup/fetchBusinessCategories");
        this.$store.dispatch("signup/fetchRegPageSetting", {
            id: this.page_id,
        });
    },
};
</script>
