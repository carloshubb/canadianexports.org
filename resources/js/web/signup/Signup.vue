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
                            <button
                                aria-label="Candian Exporters"
                                type="submit"
                                class="button-exp-fill"
                                :class="{ 'opacity-50 cursor-not-allowed pointer-events-none': !isSubmitEnabled }"
                                :disabled="!isSubmitEnabled"
                                @click.prevent="isSubmitEnabled && recaptcha()"
                            >
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
                    <div class="rounded-md p-3 mt-6 shadow bg-white">
                        <div class="flex items-center gap-2">
                            
                            <svg height="18" width="18" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                                viewBox="0 0 392.517 392.517" xml:space="preserve">
                            <path style="fill:#56ACE0;" d="M353.834,84.962c-0.065-6.012-4.784-11.184-11.507-11.184c0.388,0,0.776,0,0,0
                                c-69.495,1.487-116.752-30.707-138.861-49.002c-4.202-3.491-10.343-3.491-14.545,0c-22.626,18.747-71.37,50.618-138.473,49.002l0,0
                                c-7.176,0.517-11.313,4.202-11.83,11.184c0.065,72.275,15.321,244.622,154.699,284.897c1.875,0.517,3.943,0.517,5.818,0
                                C338.578,329.584,353.77,157.172,353.834,84.962z"/>
                            <path style="fill:#194F82;" d="M341.422,51.41c-59.992,1.487-103.37-27.022-123.733-43.895c-12.154-10.02-30.966-10.02-43.055,0
                                C154.4,24.388,111.022,52.962,51.03,51.41h-0.84c-19.717,0.323-33.293,15.127-33.875,33.552
                                c0,77.382,16.873,261.883,170.796,306.295c6.723,1.681,12.8,1.681,18.166,0c153.988-44.412,170.861-228.978,170.925-306.295
                                C376.202,66.99,361.915,51.087,341.422,51.41z M193.382,369.859C53.875,329.584,38.683,157.172,38.618,84.962
                                c0.517-7.046,4.655-10.602,11.83-11.184l0,0c67.103,1.552,115.846-30.19,138.473-49.002c4.202-3.491,10.343-3.491,14.545,0
                                c22.174,18.295,69.495,50.489,138.861,49.002c0.776,0,0.388,0,0,0c6.723,0,11.442,5.172,11.507,11.184
                                c-0.065,72.275-15.321,244.622-154.699,284.897C197.261,370.376,195.127,370.376,193.382,369.859z"/>
                            <path style="fill:#FFC10D;" d="M185.042,186.327V80.372c-29.737,18.683-61.737,30.707-95.224,35.556
                                c-5.883,0.84-10.02,6.206-9.503,12.154c1.939,20.493,5.107,40.016,9.568,58.182h95.095v0.065H185.042z"/>
                            <g>
                                <path style="fill:#FFFFFF;" d="M185.042,319.952V208.566H96.154C113.996,264.291,143.863,301.592,185.042,319.952z"/>
                                <path style="fill:#FFFFFF;" d="M302.958,115.992c-33.616-4.848-65.681-16.873-95.612-35.62v105.891h95.677
                                    c4.396-18.23,7.564-37.689,9.374-58.182C312.913,122.198,308.84,116.832,302.958,115.992z"/>
                            </g>
                            <path style="fill:#FFC10D;" d="M207.345,208.566v111.451c41.632-18.36,71.693-55.79,89.471-111.451L207.345,208.566L207.345,208.566
                                z"/>
                            <g>
                                <path style="fill:#194F82;" d="M342.327,73.713L342.327,73.713C341.164,73.713,341.81,73.713,342.327,73.713z"/>
                                <path style="fill:#194F82;" d="M306.125,93.883c-32.194-4.719-62.966-16.614-91.475-35.362c-10.99-7.24-25.859-7.24-36.848,0
                                    c-28.444,18.747-59.087,30.707-91.152,35.297c-17.648,2.651-30.125,18.554-28.444,36.331
                                    c6.012,64.129,30.384,177.131,125.931,213.527c7.628,2.844,15.774,2.715,24.242,0c96.517-36.655,120.566-149.592,126.255-213.657
                                    C336.25,112.372,323.709,96.469,306.125,93.883z M185.042,319.952c-47.192-21.01-74.02-64.388-88.954-111.127h88.954V319.952z
                                    M185.042,186.457h-95.16c-4.784-19.846-7.822-39.822-9.503-58.44c-0.517-5.947,3.62-11.313,9.503-12.154
                                    c33.487-4.913,65.422-17.002,95.224-35.685v106.279H185.042z M207.345,320.016V208.824h89.535
                                    C282.012,255.564,255.119,299.006,207.345,320.016z M303.087,186.457h-95.741V80.307c29.802,18.747,61.996,30.836,95.612,35.685
                                    c5.883,0.84,10.02,6.206,9.503,12.024C310.715,146.699,307.871,166.61,303.087,186.457z"/>
                            </g>
                            </svg>
                            <p class="can-exp-p" style="color: #187cbe; font-family: 'Futura BdCn BT'; font-size: 14pt;"> <p><span style="font-size: 18pt;"><strong><span style="color: #3498db; font-family: 'Futura BdCn BT';">Your Privacy is Our Priority</span></strong></span></p></p>
                        </div>
                        <div class="mt-2 can-exp-p">
                            <ul>
                            <li>We never never sell your personal information</li>
                            <li>You retain full ownship of the content you share on our site</li>
                            <li>We never send spam or unwanted emails</li>
                            </ul>
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
            form: (state) => state.signup.form,
            formRevision: (state) => state.signup.formRevision || 0,
        }),
        isSubmitEnabled() {
            // formRevision changes on every setForm so this re-runs whenever any field is updated
            this.formRevision;
            const form = this.form;
            if (!form) return false;
            const questionsValue = String(form.get("customer_profile_description") || "").trim();
            const termsChecked =
                form.get("is_agree") === true || form.get("is_agree") === "true";
            return questionsValue.length > 0 && termsChecked;
        },
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
                            }, 1);
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
                       // console.log("aaaaaaaaa",res.data.data.redirect_url);
                        // Clear localStorage on successful submission
                        localStorage.removeItem("formData");
                        // Redirect after user clicks OK button (promise is already resolved in store)
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
                    // Select Premium package by default
                    const premiumPackage = this.registrationPackages.find(
                        (p) => p.package_type == "premium"
                    );
                    if (premiumPackage) {
                        this.$store.commit("signup/setForm", {
                            field: "registration_package_id",
                            value: premiumPackage.id,
                        });
                        this.$store.commit(
                            "signup/setPackageType",
                            premiumPackage.package_type
                        );
                        this.$store.commit(
                            "signup/setMaxFiles",
                            premiumPackage.images_allowed
                        );
                        this.$store.commit(
                            "signup/setSelectedPackageId",
                            premiumPackage.id
                        );
                    } else {
                        // Fallback to is_default if Premium not found
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
                }
            });
        this.$store.dispatch("signup/fetchBusinessCategories");
        this.$store.dispatch("signup/fetchRegPageSetting", {
            id: this.page_id,
        });
    },
};
</script>
