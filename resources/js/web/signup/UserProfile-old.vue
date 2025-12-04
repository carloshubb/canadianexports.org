<template>
    <div>
        <div class="mb-4">
            <div
                class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-primary to-secondary rounded-md cursor-pointer"
            >
                <h4
                    class=""
                    v-html="
                        profile
                            ? regPageSetting &&
                              regPageSetting.reg_page_setting_detail &&
                              regPageSetting.reg_page_setting_detail[0]
                                ? regPageSetting.reg_page_setting_detail[0]
                                      .step_2_acc_heading
                                : ''
                            : regPageSetting &&
                              regPageSetting.reg_page_setting_detail &&
                              regPageSetting.reg_page_setting_detail[0]
                            ? regPageSetting.reg_page_setting_detail[0]
                                  .step_2_heading
                            : ''
                    "
                ></h4>
            </div>
            <div class="my-4" v-if="profile">
                <h4
                    class=""
                    v-html="
                        regPageSetting &&
                              regPageSetting.reg_page_setting_detail &&
                              regPageSetting.reg_page_setting_detail[0]
                                ? regPageSetting.reg_page_setting_detail[0]
                                      .step_2_acc_description
                                : ''
                    "
                ></h4>
            </div>
            <div class="my-4">
                <div class="relative w-full mb-3">
                    <label
                        class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg"
                        for="name"
                    >
                        {{
                            regPageSetting &&
                            regPageSetting.reg_page_setting_detail &&
                            regPageSetting.reg_page_setting_detail[0]
                                ? regPageSetting.reg_page_setting_detail[0]
                                      .step_2_name_label
                                : ""
                        }} <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        class="can-exp-input"
                        :placeholder="
                            regPageSetting &&
                            regPageSetting.reg_page_setting_detail &&
                            regPageSetting.reg_page_setting_detail[0]
                                ? regPageSetting.reg_page_setting_detail[0]
                                      .step_2_name_placeholder
                                : ''
                        "
                        :value="
                            form && form.has('name') ? form.get('name') : ''
                        "
                        @input="updateForm('name', $event.target.value)"
                        ref="name"
                    />
                    <Error
                        fieldName="name"
                        :validationErros="validationErros"
                    />
                </div>
                <div class="relative w-full mb-3">
                    <label
                        class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg"
                        for="email"
                    >
                        {{
                            regPageSetting &&
                            regPageSetting.reg_page_setting_detail &&
                            regPageSetting.reg_page_setting_detail[0]
                                ? regPageSetting.reg_page_setting_detail[0]
                                      .step_2_email_label
                                : ""
                        }} <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="email"
                        class="can-exp-input"
                        :value="
                            form && form.has('email') ? form.get('email') : ''
                        "
                        :placeholder="
                            regPageSetting &&
                            regPageSetting.reg_page_setting_detail &&
                            regPageSetting.reg_page_setting_detail[0]
                                ? regPageSetting.reg_page_setting_detail[0]
                                      .step_2_email_placeholder
                                : ''
                        "
                        @input="updateForm('email', $event.target.value)"
                        @change="checkIsEmailValid($event.target.value)"
                        ref="email"
                        autocomplete="off"
                    />
                    <Error
                        fieldName="email"
                        :validationErros="validationErros"
                    />
                </div>
                <div class="relative w-full mb-3" v-if="profile != '1'">
                    <label
                        class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg"
                        for="password"
                    >
                        {{
                            regPageSetting &&
                            regPageSetting.reg_page_setting_detail &&
                            regPageSetting.reg_page_setting_detail[0]
                                ? regPageSetting.reg_page_setting_detail[0]
                                      .step_2_password_label
                                : ""
                        }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            :type="display_password"
                            id="password"
                            class="can-exp-input"
                            :placeholder="
                                regPageSetting &&
                                regPageSetting.reg_page_setting_detail &&
                                regPageSetting.reg_page_setting_detail[0]
                                    ? regPageSetting.reg_page_setting_detail[0]
                                          .step_2_password_placeholder
                                    : ''
                            "
                            @input="updateForm('password', $event.target.value)"
                            ref="password"
                        />
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5 text-gray-500 absolute top-3"
                            :class="lang && JSON.parse(lang) && JSON.parse(lang)['direction'] == 'ltr' ? 'right-3' : 'left-3'"
                            @click="display_password = 'text'"
                            v-if="display_password == 'password'"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"
                            />
                        </svg>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5 text-gray-500 absolute top-3"
                            :class="lang && JSON.parse(lang) && JSON.parse(lang)['direction'] == 'ltr' ? 'right-3' : 'left-3'"
                            @click="display_password = 'password'"
                            v-else-if="display_password == 'text'"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                            />
                        </svg>
                    </div>
                    <Error
                        fieldName="password"
                        :validationErros="validationErros"
                    />
                </div>
                <div class="relative w-full mb-3" v-if="profile != '1'">
                    <label
                        class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg"
                        for="confirm-password"
                    >
                        {{
                            regPageSetting &&
                            regPageSetting.reg_page_setting_detail &&
                            regPageSetting.reg_page_setting_detail[0]
                                ? regPageSetting.reg_page_setting_detail[0]
                                      .step_2_confirm_password_label
                                : ""
                        }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            :type="display_confirm_password"
                            id="confirm-password"
                            class="can-exp-input"
                            :placeholder="
                                regPageSetting &&
                                regPageSetting.reg_page_setting_detail &&
                                regPageSetting.reg_page_setting_detail[0]
                                    ? regPageSetting.reg_page_setting_detail[0]
                                          .step_2_confirm_password_placeholder
                                    : ''
                            "
                            @input="
                                updateForm(
                                    'password_confirmation',
                                    $event.target.value
                                )
                            "
                            @blur="checkPassword()"
                            ref="confirm_password"
                        />

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5 text-gray-500 absolute top-3"
                            :class="lang && JSON.parse(lang) && JSON.parse(lang)['direction'] == 'ltr' ? 'right-3' : 'left-3'"
                            @click="display_confirm_password = 'text'"
                            v-if="display_confirm_password == 'password'"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"
                            />
                        </svg>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5 text-gray-500 absolute top-3"
                            :class="lang && JSON.parse(lang) && JSON.parse(lang)['direction'] == 'ltr' ? 'right-3' : 'left-3'"
                            @click="display_confirm_password = 'password'"
                            v-else-if="display_confirm_password == 'text'"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                            />
                        </svg>

                    </div>
                    <Error
                        fieldName="password_confirmation"
                        :validationErros="validationErros"
                    />
                </div>
                <div class="mt-10 flex justify-center" v-if="profile == '1'">
                    <button aria-label="Candian Exporters"
                        type="button"
                        @click="updateUserProfile()"
                        class="button-exp-fill"
                    >
                        {{ general_setting && general_setting['process_button_text'] ? general_setting['process_button_text'] : ''}}
                    </button>
                </div>
            </div>
            <div class="my-4">
                <template v-if="profile == '1'">
                    <div
                        class="mt-10 flex justify-center gap-2 items-center w-full"
                    >
                        <StripeSubscriptionStatus
                            :user="JSON.parse(user)"
                        ></StripeSubscriptionStatus>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>
<script>
import { mapState } from "vuex";
import Error from "./../components/Error.vue";
import StripeSubscriptionStatus from "./StripeSubscriptionStatus.vue";
export default {
    computed: {
        ...mapState({
            form: (state) => state.signup.form,
            regPageSetting: (state) => state.signup.regPageSetting,
            validationErros: (state) => state.signup.validationErros,
            registrationPackages: (state) => state.signup.registrationPackages,
            subscription_status: (state) => state.signup.subscription_status,
        }),
    },
    data() {
        return {
            general_setting: null,
            display_password: "password",
            display_confirm_password: "password",
        };
    },
    components: {
        Error,
        StripeSubscriptionStatus,
    },
    created() {
        if (this.profile == "1") {
            let user = JSON.parse(this.user);
            this.$store.commit(
                "signup/setSubscriptionStatus",
                user.subscription_status
            );
            this.updateForm("name", user.name);
            this.updateForm("email", user.email);
            this.$store.dispatch("signup/fetchRegPageSetting", {
                id: this.page_id,
            });
            this.$store.dispatch("signup/fetchStaticSetting", {
                url: `${process.env.MIX_WEB_API_URL}get-static-setting?getGeneralSetting=1`
            }).then(res => {
                if(res.data.status == 'Success'){
                    this.general_setting = res.data.data;
                }
            });
        }
    },
    methods: {
        checkPassword() {
            let password = document.getElementById("password").value;
            let password_confirmation =
                document.getElementById("confirm-password").value;
            if (password != password_confirmation) {
                axios.get(`${process.env.MIX_WEB_API_URL}get-password-miss-match-error`)
                .then((res) => {
                    if (res.data.status == 'Error') {
                        // this.validationErros.record({'password_confirmation': [res.data.message]});
                        this.$store.commit("signup/updateValidationErros", {
                            field: "password_confirmation",
                            message: res.data.message,
                        });
                    }
                })
            } else {
                this.$store.commit("signup/removeValidationErros", {
                    field: "password_confirmation",
                });
            }
        },
        updateForm(field, value) {
            this.$store.commit("signup/setForm", {
                field: [field],
                value: value,
            });
            this.$store.commit("signup/removeValidationErros", {
                field: [field],
            });
        },
        checkIsEmailValid(val) {
            this.$store
                .dispatch("signup/checkCustomerEmail", {
                    email: val,
                })
                .then((res) => console.log(res));
        },
        updateUserProfile() {
            this.$store.dispatch("signup/updateUserProfile");
        },
    },
    props: ["profile", "user", "page_id", "lang"],
};
</script>
