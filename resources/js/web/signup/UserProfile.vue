<template>
  <div>
    <div class="mb-4">
      <div class="my-4" v-if="profile">
        <template v-if="JSON.parse(user)?.is_package_amount_paid">
          <h4 class="font-Futura">{{ regPageSetting?.reg_page_setting_detail?.[0]
            ?.greeting_text ?? 'Welcome back' }} {{ JSON.parse(user)?.name }},</h4>
          <p class="font-Futura" v-html="regPageSetting?.reg_page_setting_detail?.[0]
              ?.step_2_acc_description
            "></p>
        </template>
      </div>
      <div class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-xblue via-primary to-blue-600 rounded-md">
        <template v-if="profile == '1'">
          <h4 class="text-white" v-html="JSON.parse(user)?.is_package_amount_paid
              ? regPageSetting?.reg_page_setting_detail?.[0]
                ?.step_2_acc_heading
              : regPageSetting?.reg_page_setting_detail?.[0]?.step_2_heading
            "></h4>
        </template>
        <template v-else>
          <h4 class="text-white" v-html="regPageSetting?.reg_page_setting_detail?.[0]?.step_2_heading
            "></h4>
        </template>
      </div>

      <div class="my-4">
        <div class="relative w-full mb-4">
          <label class="block text-gray-700 mb-1 text-base md:text-base lg:text-lg" for="name">
            {{
              regPageSetting?.reg_page_setting_detail?.[0]?.step_2_name_label
            }}
            <span class="text-red-500"></span>
          </label>
          <textarea type="text" id="name" rows="1" class="can-exp-input min-h-[60px] lg:min-h-full overflow-auto"
            :placeholder="regPageSetting?.reg_page_setting_detail?.[0]
                ?.step_2_name_placeholder
              " :value="form && form.has('name') ? form.get('name') : ''"
            @input="updateForm('name', $event.target.value)" ref="name"></textarea>
          <Error fieldName="name" :validationErros="validationErros" />
        </div>
        <div class="relative w-full mb-4">
          <label class="block text-gray-700 mb-1 text-base md:text-base lg:text-lg" for="email">
            {{
              regPageSetting?.reg_page_setting_detail?.[0]?.step_2_email_label
            }}
            <span class="text-red-500"></span>
          </label>
          <input type="text" id="email" rows="1" class="can-exp-input min-h-[60px] lg:min-h-full overflow-auto"
            :value="form && form.has('email') ? form.get('email') : ''" :placeholder="regPageSetting?.reg_page_setting_detail?.[0]
                ?.step_2_email_placeholder
              " @input="updateForm('email', $event.target.value)" @change="checkIsEmailValid($event.target.value)"
            ref="email" autocomplete="off" :disabled="profile == '1' && JSON.parse(user)?.is_package_amount_paid == '0'
              " :class="profile == '1' && JSON.parse(user)?.is_package_amount_paid == '0'
                ? 'opacity-50 cursor-not-allowed'
                : ''
              " />
          <Error fieldName="email" :validationErros="validationErros" />
        </div>
        <div class="relative w-full mb-4" v-if="profile == '1' && JSON.parse(user)?.is_package_amount_paid">
          <label class="block text-gray-700 mb-1 text-base md:text-base lg:text-lg" for="profile-image">
            {{
              regPageSetting?.reg_page_setting_detail?.[0]
                ?.step_2_profile_image_label
            }}
          </label>
          <FilePond class="cursor-pointer" name="profile-image" class-name="my-pond" accepted-file-types="image/*"
            credits="false"
            :labelIdle="`<span class='cursor-pointer'>${regPageSetting?.reg_page_setting_detail?.[0]?.step_2_profile_image_placeholder}</span>`"
            ref="profile-image" v-bind:files="files" @init="handleProfileImageInit"
            @processfile="handleProfileImageProcess" @removefile="handleProfileImageRemoveFile" />
          <Error fieldName="profile_image" :validationErros="validationErros" />
        </div>
        <div class="relative w-full mb-4" v-if="profile != '1'">
          <label class="block text-gray-700 mb-1 text-base md:text-base lg:text-lg" for="password">
            {{
              regPageSetting?.reg_page_setting_detail?.[0]
                ?.step_2_password_label
            }}
            <span class="text-red-500"></span>
          </label>
          <div class="relative">
            <input :type="display_password" id="password" class="can-exp-input" :placeholder="regPageSetting?.reg_page_setting_detail?.[0]
                ?.step_2_password_placeholder
              " @input="updateForm('password', $event.target.value)" ref="password" />
            <svg class="w-5 h-5 text-gray-500 absolute top-3" :class="lang &&
                JSON.parse(lang) &&
                JSON.parse(lang)['direction'] == 'ltr'
                ? 'right-3'
                : 'left-3'
              " @click="display_password = 'text'" v-if="display_password == 'password'" viewBox="0 0 51 35"
              fill="none" xmlns="http://www.w3.org/2000/svg">
              <g clip-path="url(#clip0_1249_2209)">
                <path
                  d="M28.22 0.59C27.73 0.53 27.24 0.49 26.75 0.43H24.2C23.63 0.5 23.06 0.56 22.49 0.63C18.95 1.07 15.69 2.29 12.64 4.13C8.56 6.6 5.23 9.88 2.39 13.68C1.62 14.71 0.93 15.8 0.21 16.86C0.14 16.95 0.07 17.04 0 17.13V17.21C0.69 18.22 1.35 19.25 2.08 20.23C4.89 24.01 8.16 27.31 12.15 29.86C12.19 29.89 12.23 29.91 12.27 29.93C12.33 29.8 12.4 29.69 12.48 29.57L15.51 24.97C14.14 22.86 13.27 20.55 13.11 17.99C12.67 11.02 17.98 5.1 24.95 4.8C26.2 4.75 27.39 4.88 28.54 5.16L31.18 1.16C30.21 0.91 29.23 0.72 28.22 0.59ZM49.22 14.6C46.3 10.58 42.89 7.08 38.68 4.43C38.61 4.55 38.55 4.65 38.48 4.76L35.45 9.37C35.78 9.87 36.07 10.4 36.34 10.94C37.91 14.11 38.37 17.4 37.33 20.82C35.74 26.05 30.92 29.58 24.98 29.58C24.12 29.57 23.24 29.45 22.37 29.24L19.77 33.2C20.51 33.4 21.27 33.55 22.04 33.67C22.64 33.76 23.25 33.83 23.85 33.91H27.11C27.62 33.84 28.13 33.78 28.64 33.71C32.31 33.22 35.68 31.91 38.8 29.93C43.22 27.13 46.74 23.41 49.69 19.12C50.12 18.49 50.54 17.84 50.96 17.21V17.13C50.38 16.29 49.82 15.43 49.22 14.6ZM37.38 3.65C37.34 3.75 37.28 3.85 37.22 3.94L34.46 8.13L20.88 28.78L18.26 32.77L17.98 33.19C17.49 33.93 16.68 34.34 15.85 34.34C15.37 34.34 14.89 34.2 14.46 33.92C13.39 33.21 13.02 31.83 13.56 30.7C13.61 30.6 13.67 30.5 13.73 30.4L16.47 26.24L30.04 5.61L32.69 1.6L32.98 1.15C33.47 0.41 34.28 0 35.1 0C35.58 0 36.07 0.14 36.5 0.42C37.58 1.13 37.93 2.52 37.38 3.65Z"
                  fill="currentcolor" />
              </g>
              <defs>
                <clipPath id="clip0_1249_2209">
                  <rect width="50.96" height="34.34" fill="currentcolor" />
                </clipPath>
              </defs>
            </svg>
            <svg class="w-5 h-5 text-gray-500 absolute top-3" :class="lang &&
                JSON.parse(lang) &&
                JSON.parse(lang)['direction'] == 'ltr'
                ? 'right-3'
                : 'left-3'
              " @click="display_password = 'password'" v-else-if="display_password == 'text'" viewBox="0 0 51 34"
              fill="none" xmlns="http://www.w3.org/2000/svg">
              <g clip-path="url(#clip0_1248_2207)">
                <path
                  d="M50.96 16.7C50.96 16.72 50.96 16.75 50.96 16.77C50.54 17.41 50.13 18.05 49.69 18.68C46.74 22.97 43.22 26.69 38.8 29.49C35.68 31.46 32.31 32.77 28.64 33.26C28.13 33.33 27.62 33.39 27.11 33.46C26.02 33.46 24.94 33.46 23.85 33.46C23.25 33.38 22.64 33.31 22.04 33.22C18.47 32.67 15.19 31.35 12.15 29.41C8.16 26.86 4.89 23.57 2.08 19.78C1.36 18.82 0.69 17.78 0 16.77C0 16.75 0 16.72 0 16.7C0.07 16.61 0.15 16.52 0.21 16.42C0.93 15.36 1.62 14.27 2.39 13.24C5.23 9.44 8.57 6.16 12.65 3.69C15.69 1.85 18.96 0.64 22.5 0.2C23.07 0.13 23.64 0.07 24.21 0C25.06 0 25.91 0 26.76 0C27.25 0.05 27.74 0.1 28.22 0.16C31.57 0.58 34.7 1.67 37.63 3.35C42.33 6.06 46.07 9.81 49.23 14.17C49.82 15 50.38 15.86 50.96 16.7ZM24.98 29.15C30.92 29.15 35.74 25.62 37.33 20.39C38.37 16.97 37.92 13.67 36.34 10.51C35.58 8.98 34.69 7.57 33.14 6.66C30.6 5.17 27.94 4.24 24.96 4.37C17.99 4.68 12.67 10.59 13.12 17.56C13.3 20.43 14.37 22.98 16.03 25.3C16.26 25.62 16.55 25.92 16.87 26.15C19.42 28.02 22.25 29.12 24.98 29.15Z"
                  fill="currentcolor" />
              </g>
              <defs>
                <clipPath id="clip0_1248_2207">
                  <rect width="50.96" height="33.48" fill="currentcolor" />
                </clipPath>
              </defs>
            </svg>

          </div>
          <Error fieldName="password" :validationErros="validationErros" />
        </div>
        <div class="relative w-full mb-4" v-if="profile != '1'">
          <label class="block text-gray-700 mb-1 text-base md:text-base lg:text-lg" for="confirm-password">
            {{
              regPageSetting?.reg_page_setting_detail?.[0]
                ?.step_2_confirm_password_label
            }}
            <span class="text-red-500"></span>
          </label>
          <div class="relative">
            <input :type="display_confirm_password" id="confirm-password" class="can-exp-input" :placeholder="regPageSetting?.reg_page_setting_detail?.[0]
                ?.step_2_confirm_password_placeholder
              " @input="updateForm('password_confirmation', $event.target.value)" @blur="checkPassword()"
              ref="confirm_password" />
            <svg class="w-5 h-5 text-gray-500 absolute top-3" :class="lang &&
                JSON.parse(lang) &&
                JSON.parse(lang)['direction'] == 'ltr'
                ? 'right-3'
                : 'left-3'
              " @click="display_confirm_password = 'text'" v-if="display_confirm_password == 'password'"
              viewBox="0 0 51 35" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g clip-path="url(#clip0_1249_2209)">
                <path
                  d="M28.22 0.59C27.73 0.53 27.24 0.49 26.75 0.43H24.2C23.63 0.5 23.06 0.56 22.49 0.63C18.95 1.07 15.69 2.29 12.64 4.13C8.56 6.6 5.23 9.88 2.39 13.68C1.62 14.71 0.93 15.8 0.21 16.86C0.14 16.95 0.07 17.04 0 17.13V17.21C0.69 18.22 1.35 19.25 2.08 20.23C4.89 24.01 8.16 27.31 12.15 29.86C12.19 29.89 12.23 29.91 12.27 29.93C12.33 29.8 12.4 29.69 12.48 29.57L15.51 24.97C14.14 22.86 13.27 20.55 13.11 17.99C12.67 11.02 17.98 5.1 24.95 4.8C26.2 4.75 27.39 4.88 28.54 5.16L31.18 1.16C30.21 0.91 29.23 0.72 28.22 0.59ZM49.22 14.6C46.3 10.58 42.89 7.08 38.68 4.43C38.61 4.55 38.55 4.65 38.48 4.76L35.45 9.37C35.78 9.87 36.07 10.4 36.34 10.94C37.91 14.11 38.37 17.4 37.33 20.82C35.74 26.05 30.92 29.58 24.98 29.58C24.12 29.57 23.24 29.45 22.37 29.24L19.77 33.2C20.51 33.4 21.27 33.55 22.04 33.67C22.64 33.76 23.25 33.83 23.85 33.91H27.11C27.62 33.84 28.13 33.78 28.64 33.71C32.31 33.22 35.68 31.91 38.8 29.93C43.22 27.13 46.74 23.41 49.69 19.12C50.12 18.49 50.54 17.84 50.96 17.21V17.13C50.38 16.29 49.82 15.43 49.22 14.6ZM37.38 3.65C37.34 3.75 37.28 3.85 37.22 3.94L34.46 8.13L20.88 28.78L18.26 32.77L17.98 33.19C17.49 33.93 16.68 34.34 15.85 34.34C15.37 34.34 14.89 34.2 14.46 33.92C13.39 33.21 13.02 31.83 13.56 30.7C13.61 30.6 13.67 30.5 13.73 30.4L16.47 26.24L30.04 5.61L32.69 1.6L32.98 1.15C33.47 0.41 34.28 0 35.1 0C35.58 0 36.07 0.14 36.5 0.42C37.58 1.13 37.93 2.52 37.38 3.65Z"
                  fill="currentcolor" />
              </g>
              <defs>
                <clipPath id="clip0_1249_2209">
                  <rect width="50.96" height="34.34" fill="currentcolor" />
                </clipPath>
              </defs>
            </svg>
            <svg class="w-5 h-5 text-gray-500 absolute top-3" :class="lang &&
                JSON.parse(lang) &&
                JSON.parse(lang)['direction'] == 'ltr'
                ? 'right-3'
                : 'left-3'
              " @click="display_confirm_password = 'password'" v-else-if="display_confirm_password == 'text'"
              viewBox="0 0 51 34" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g clip-path="url(#clip0_1248_2207)">
                <path
                  d="M50.96 16.7C50.96 16.72 50.96 16.75 50.96 16.77C50.54 17.41 50.13 18.05 49.69 18.68C46.74 22.97 43.22 26.69 38.8 29.49C35.68 31.46 32.31 32.77 28.64 33.26C28.13 33.33 27.62 33.39 27.11 33.46C26.02 33.46 24.94 33.46 23.85 33.46C23.25 33.38 22.64 33.31 22.04 33.22C18.47 32.67 15.19 31.35 12.15 29.41C8.16 26.86 4.89 23.57 2.08 19.78C1.36 18.82 0.69 17.78 0 16.77C0 16.75 0 16.72 0 16.7C0.07 16.61 0.15 16.52 0.21 16.42C0.93 15.36 1.62 14.27 2.39 13.24C5.23 9.44 8.57 6.16 12.65 3.69C15.69 1.85 18.96 0.64 22.5 0.2C23.07 0.13 23.64 0.07 24.21 0C25.06 0 25.91 0 26.76 0C27.25 0.05 27.74 0.1 28.22 0.16C31.57 0.58 34.7 1.67 37.63 3.35C42.33 6.06 46.07 9.81 49.23 14.17C49.82 15 50.38 15.86 50.96 16.7ZM24.98 29.15C30.92 29.15 35.74 25.62 37.33 20.39C38.37 16.97 37.92 13.67 36.34 10.51C35.58 8.98 34.69 7.57 33.14 6.66C30.6 5.17 27.94 4.24 24.96 4.37C17.99 4.68 12.67 10.59 13.12 17.56C13.3 20.43 14.37 22.98 16.03 25.3C16.26 25.62 16.55 25.92 16.87 26.15C19.42 28.02 22.25 29.12 24.98 29.15Z"
                  fill="currentcolor" />
              </g>
              <defs>
                <clipPath id="clip0_1248_2207">
                  <rect width="50.96" height="33.48" fill="currentcolor" />
                </clipPath>
              </defs>
            </svg>

          </div>
          <Error fieldName="password_confirmation" :validationErros="validationErros" />
        </div>
        <!-- <div class="mt-10 flex justify-center" v-if="profile == '1'">
                    <button aria-label="Candian Exporters"
                        type="button"
                        @click="updateUserProfile()"
                        class="button-exp-fill"
                    >
                        {{ general_setting && general_setting['process_button_text'] ? general_setting['process_button_text'] : ''}}
                    </button>
                </div> -->
      </div>
    </div>
  </div>
</template>
<script>
import { mapState } from "vuex";
import Error from "./../components/Error.vue";
import StripeSubscriptionStatus from "./StripeSubscriptionStatus.vue";

import vueFilePond, { setOptions } from "vue-filepond";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js";
import FilePondPluginImagePreview from "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview
);

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
      display_current_password: "password",
      display_new_password: "password",
      display_confirm_new_password: "password",
      files: [],
    };
  },
  components: {
    Error,
    StripeSubscriptionStatus,
    FilePond,
  },
  created() {
    if (this.profile == "1") {
      this.files = [];
      let user = JSON.parse(this.user);
      this.$store.commit(
        "signup/setSubscriptionStatus",
        user.subscription_status
      );
      this.updateForm("name", user.name);
      this.updateForm("email", user.email);

      if (user?.profile_image) {
        this.files.push({
          source: user?.profile_image.base64,
          options: {
            type: "local",
            metadata: {
              poster: user?.profile_image.base64,
            },
          },
        });
        this.updateForm(
          "profile_image",
          JSON.stringify([user?.profile_image?.path])
        );
      }
    }

    // Retrieve form data from localStorage
    const savedFormData = JSON.parse(localStorage.getItem("formData")) || {};
    for (const [field, value] of Object.entries(savedFormData)) {
      this.updateForm(field, value);
    }
  },
  methods: {
    checkPassword() {
      let password = document.getElementById("password").value;
      let password_confirmation =
        document.getElementById("confirm-password").value;
      if (password != password_confirmation) {
        axios
          .get(`${process.env.MIX_WEB_API_URL}get-password-miss-match-error`)
          .then((res) => {
            if (res.data.status == "Error") {
              this.$store.commit("signup/updateValidationErros", {
                field: "password_confirmation",
                message: res.data.message,
              });
            }
          });
      } else {
        this.$store.commit("signup/removeValidationErros", {
          field: "password_confirmation",
        });
      }
    },
    checkNewPasswordConfirmation() {
      let new_password = document.getElementById("new_password").value;
      let new_password_confirmation = document.getElementById("new_password_confirmation").value;
      if (new_password != new_password_confirmation) {
        this.$store.commit("signup/updateValidationErros", {
          field: "new_password_confirmation",
          message: "Passwords do not match",
        });
      } else {
        this.$store.commit("signup/removeValidationErros", {
          field: "new_password_confirmation",
        });
      }
    },
    updateForm(field, value) {
      // Update Vuex store
      this.$store.commit("signup/setForm", {
        field: [field],
        value: value,
      });
      this.$store.commit("signup/removeValidationErros", {
        field: [field],
      });

      // Save form data to localStorage
      const formData = JSON.parse(localStorage.getItem("formData")) || {};
      formData[field] = value;
      localStorage.setItem("formData", JSON.stringify(formData));
    },
    checkIsEmailValid(val) {
      if (val == "") {
        return;
      }
      this.$store
        .dispatch("signup/checkCustomerEmail", {
          email: val,
        })
        .then((res) => console.log(res));
    },
    updateUserProfile() {
      this.$store.dispatch("signup/updateUserProfile");
    },
    handleProfileImageInit() {
      setOptions({
        credits: false,
        server: {
          url: process.env.MIX_APP_URL,
          process: (
            fieldName,
            file,
            metadata,
            load,
            error,
            progress,
            abort,
            transfer,
            options
          ) => {
            const formData = new FormData();
            formData.append("media", file, file.name);
            formData.append("is_temp_media", 1);
            formData.append("type", "logo");

            const request = new XMLHttpRequest();
            request.open("POST", `${process.env.MIX_APP_URL}/media/process`);
            request.setRequestHeader(
              "X-CSRF-TOKEN",
              document.head.querySelector('meta[name="csrf-token"]').content
            );

            request.upload.onprogress = (e) => {
              progress(e.lengthComputable, e.loaded, e.total);
            };
            request.onload = function () {
              if (request.status >= 200 && request.status < 300) {
                load(request.responseText);
              } else {
                error("oh no");
              }
            };

            request.send(formData);

            return {
              abort: () => {
                request.abort();
                abort();
              },
            };
          },
          revert: (uniqueFileId, load, error) => {
            const formData = new FormData();
            formData.append("media", uniqueFileId);

            const request = new XMLHttpRequest();
            request.open("POST", `${process.env.MIX_APP_URL}/media/revert`);
            request.setRequestHeader(
              "X-CSRF-TOKEN",
              document.head.querySelector('meta[name="csrf-token"]').content
            );

            request.send(formData);

            return {
              abort: () => {
                request.abort();
                abort();
              },
            };
          },
          headers: {
            "X-CSRF-TOKEN": document.head.querySelector(
              'meta[name="csrf-token"]'
            ).content,
          },
        },
      });
    },
    handleProfileImageProcess(error, file) {
      this.updateForm("profile_image", file.serverId);
      this.$store.commit("signup/removeValidationErros", {
        field: "profile_image",
      });
    },
    handleProfileImageRemoveFile(error, file) {
      this.updateForm("profile_image", "");
    },
  },
  props: ["profile", "user", "page_id", "lang"],
};
</script>
