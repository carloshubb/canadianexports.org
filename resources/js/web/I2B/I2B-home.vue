<template>
<div>
  <div class="swiper i2b-slider-container">
    <div class="swiper-wrapper">
      <div
        class="swiper-slide"
        v-for="inquiry in JSON.parse(inquiries)"
        :key="inquiry.id"
      >
        <div class="i2b-swiper-slide">
          <div
            class="h-full relative isolate overflow-hidden bg-white px-6 py-6 sm:py-6 lg:px-6 border-4 border-primary rounded-xl mb-4"
          >
            <div
              class="absolute inset-0 -z-10 bg-[radial-gradient(45rem_50rem_at_top,theme(colors.indigo.100),white)] opacity-20"
            ></div>
            <div
              class="absolute inset-y-0 right-1/2 -z-10 mr-16 w-[200%] origin-bottom-left skew-x-[-30deg] bg-white shadow-xl shadow-indigo-600/10 ring-1 ring-indigo-50 sm:mr-28 lg:mr-0 xl:mr-16 xl:origin-center"
            ></div>
            <div class="content flex flex-col h-full">
              <div class="flex-1">
                <h2
                  class="card-heading rounded-t-lg cursor-pointer"
                  @click.prevent="
                    displayI2BModal(
                      inquiry?.id,
                      inquiry?.['i2b_detail']?.[0]?.['name'] || ''
                    )
                  "
                >
                  {{ inquiry?.["i2b_detail"]?.[0]?.["name"] || "" }}
                </h2>
                <!-- <p class="text-sm">
              {{ (inquiry)?.["i2b_detail"]?.[0]?.["country_name"] }}
            </p> -->
              </div>

              <ul class="my-4 space-y-3 list-none p-0 flex-auto">
                <li>
                  <div
                    class="flex items-start justify-between py-2 gap-4 rounded group"
                  >
                    <div class="flex-1 whitespace-nowrap w-1/2">
                      {{
                        JSON.parse(home_page_setting_detail)[
                          "section2_category_label"
                        ]
                      }}
                    </div>
                    <div class="w-1/2">
                      {{ inquiry?.["business_category_name"] }}
                    </div>
                  </div>
                </li>
                <li>
                  <div
                    class="flex items-start justify-between py-2 gap-4 rounded group"
                  >
                    <div class="flex-1 whitespace-nowrap w-1/2">
                      {{
                        JSON.parse(home_page_setting_detail)[
                          "section2_country_label"
                        ]
                      }}
                    </div>
                    <div class="w-1/2">
                      {{ inquiry?.["i2b_detail"]?.[0]?.["country_name"] }}
                    </div>
                  </div>
                </li>
                <li>
                  <div
                    href="#"
                    class="flex items-start justify-between py-2 gap-4 rounded group"
                  >
                    <div class="flex-1 whitespace-nowrap w-1/2">
                      {{
                        JSON.parse(home_page_setting_detail)[
                          "section2_deadline_label"
                        ]
                      }}
                    </div>
                    <div class="w-1/2">
                      {{ inquiry?.["deadline_date"] }}
                    </div>
                  </div>
                </li>
                <li>
                  <div
                    href="#"
                    class="flex items-start justify-between py-2 gap-4 rounded group"
                  >
                    <div class="flex-1 whitespace-nowrap w-1/2">
                      {{
                        JSON.parse(home_page_setting_detail)[
                          "section2_estimated_value_label"
                        ]
                      }}
                    </div>
                    <div class="w-1/2">${{ inquiry?.["estimated_value"] }}</div>
                  </div>
                </li>
              </ul>
              <div class="flex-end mt-2 rounded-b-lg flex justify-end">
                <!-- <a
                  href="#"
                  class="can-exp-a btn btn-link after:bg-secondary duration-500 ease-in-out flex items-center gap-1 w-fit"
                  @click.prevent="
                    displayI2BModal(
                      inquiry?.id,
                      inquiry?.['i2b_detail']?.[0]?.['name'] || ''
                    )
                  "
                >
                  {{
                    JSON.parse(home_page_setting_detail)[
                      "section2_i2b_button_text"
                    ]
                  }}
                </a> -->
                <a
  href="#"
  class="can-exp-a btn btn-link after:bg-secondary duration-500 ease-in-out flex items-center gap-1 w-fit"
  @click.prevent="handleI2bButtonClick(inquiry?.id)"
>
  {{
    JSON.parse(home_page_setting_detail)[
      "section2_i2b_button_text"
    ]
  }}
</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="i2b-button-next-exp absolute top-1/2 right-0 z-50">
      <div
        class="w-8 h-8 md:w-12 md:h-12 bg-secondary text-white rounded-full flex justify-center items-center bg-opacity-40"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="w-4 h-4 md:w-6 md:h-6"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"
          />
        </svg>
      </div>
    </div>
    <div class="i2b-button-prev-exp absolute top-1/2 left-0 z-50">
      <div
        class="w-8 h-8 md:w-12 md:h-12 bg-secondary text-white rounded-full flex justify-center items-center bg-opacity-40"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="w-4 h-4 md:w-6 md:h-6"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75"
          />
        </svg>
      </div>
    </div>
    </div>
    <div
      class="fixed top-0 left-0 right-0 bottom-0 m-auto z-[1000] overflow-y-auto"
      aria-labelledby="modal-title"
      role="dialog"
      aria-modal="true"
      v-if="isI2BModalDisplayed"
    >
      <div
        class="fixed inset-0 z-100 bg-gray-500 bg-opacity-75 transition-opacity"
        @click.prevent="hideI2BModal()"
      ></div>

      <div class="overflow-y-auto">
        <div
          class="flex min-h-full items-end justify-center p-4 sm:items-center sm:p-0"
        >
          <div
            class="relative transform overflow-y-auto rounded-lg bg-white shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-4xl"
          >
            <div class="bg-white p-4">
              <div class="sm:items-start">
                <div class="sm:mt-0">
                  <div
                    class="flex items-center justify-between pb-2 border-b rounded-t"
                  >
                    <h3 class="card-heading text-primary" id="modal-title">
                      {{
                        JSON.parse(modal_setting)
                          ? JSON.parse(modal_setting)["greeting_text"] +
                            (!customer?.name ? "," : " " + customer?.name + ",")
                          : ""
                      }}
                    </h3>
                    <button
                      aria-label="Candian Exporters"
                      @click.prevent="hideI2BModal()"
                      type="button"
                      class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg p-1.5 inline-flex items-center"
                      data-modal-hide="defaultModal"
                    >
                      <img
                        class="h-6"
                        src="/assets/icons/19-X-inside-circle-2.png"
                        alt="Candian Exporters"
                      />
                      <span class="sr-only">Close modal</span>
                    </button>
                  </div>
                  <div class="">
                    <p class="can-exp-p py-2">
                      {{ displayModalBody() }}
                    </p>
                  </div>
                  <div class="" v-if="isUserLoggedIn">
                    <div class="mt-2 mb-4">
                      <Error
                        fieldName="captcha"
                        :validationErros="validationErros"
                        full_width="1"
                      />
                    </div>
                    <div class="mt-2 flex items-center justify-center">
                      <button
                        aria-label="Candian Exporters"
                        type="submit"
                        class="button-exp-fill"
                        @click="recaptcha()"
                        v-if="
                          user &&
                          (JSON.parse(user)?.registration_package
                            ?.package_type == 'featured' ||
                            JSON.parse(user)?.registration_package
                              ?.package_type == 'premium')
                        "
                      >
                        {{ getRegistrationTypeText() }}
                      </button>
                      <a
                        :href="register_url"
                        aria-label="Candian Exporters"
                        class="button-exp-fill"
                        v-else
                      >
                        {{ getRegistrationTypeText() }}
                      </a>
                    </div>
                  </div>
                  <div v-else-if="!isUserLoggedIn">
                    <form @submit.prevent="loginCustomer()">
                      <div
                        class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-4"
                      >
                        <div class="w-full">
                          <label
                            for="email"
                            class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg"
                            >{{
                              login_page_setting_detail &&
                              JSON.parse(login_page_setting_detail)[
                                "email_label"
                              ]
                                ? JSON.parse(login_page_setting_detail)[
                                    "email_label"
                                  ]
                                : "Email"
                            }}
                            <span class="text-red-500">*</span></label
                          >
                          <div>
                            <input
                              type="text"
                              class="can-exp-input"
                              id="email"
                              name="email"
                              placeholder=""
                              autofocus=""
                              v-model="login_form.email"
                            />
                          </div>
                          <Error
                            fieldName="email"
                            :validationErros="validationErros"
                            full_width="1"
                          />
                        </div>
                        <div class="w-full">
                          <label
                            for="password"
                            class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg"
                            >{{
                              login_page_setting_detail &&
                              JSON.parse(login_page_setting_detail)[
                                "password_label"
                              ]
                                ? JSON.parse(login_page_setting_detail)[
                                    "password_label"
                                  ]
                                : "Password"
                            }}
                            <span class="text-red-500">*</span></label
                          >
                          <div class="mt-2 relative">
                            <input
                              class="can-exp-input"
                              id="password"
                              :type="display_password"
                              name="password"
                              autocomplete="current-password"
                              v-model="login_form.password"
                            />
                            <svg
                              class="w-5 h-5 text-gray-500 absolute top-3"
                              :class="
                                lang &&
                                JSON.parse(lang) &&
                                JSON.parse(lang)['direction'] == 'ltr'
                                  ? 'right-3'
                                  : 'left-3'
                              "
                              @click="display_password = 'text'"
                              v-if="display_password == 'password'"
                              viewBox="0 0 51 35"
                              fill="none"
                              xmlns="http://www.w3.org/2000/svg"
                            >
                              <g clip-path="url(#clip0_1249_2209)">
                                <path
                                  d="M28.22 0.59C27.73 0.53 27.24 0.49 26.75 0.43H24.2C23.63 0.5 23.06 0.56 22.49 0.63C18.95 1.07 15.69 2.29 12.64 4.13C8.56 6.6 5.23 9.88 2.39 13.68C1.62 14.71 0.93 15.8 0.21 16.86C0.14 16.95 0.07 17.04 0 17.13V17.21C0.69 18.22 1.35 19.25 2.08 20.23C4.89 24.01 8.16 27.31 12.15 29.86C12.19 29.89 12.23 29.91 12.27 29.93C12.33 29.8 12.4 29.69 12.48 29.57L15.51 24.97C14.14 22.86 13.27 20.55 13.11 17.99C12.67 11.02 17.98 5.1 24.95 4.8C26.2 4.75 27.39 4.88 28.54 5.16L31.18 1.16C30.21 0.91 29.23 0.72 28.22 0.59ZM49.22 14.6C46.3 10.58 42.89 7.08 38.68 4.43C38.61 4.55 38.55 4.65 38.48 4.76L35.45 9.37C35.78 9.87 36.07 10.4 36.34 10.94C37.91 14.11 38.37 17.4 37.33 20.82C35.74 26.05 30.92 29.58 24.98 29.58C24.12 29.57 23.24 29.45 22.37 29.24L19.77 33.2C20.51 33.4 21.27 33.55 22.04 33.67C22.64 33.76 23.25 33.83 23.85 33.91H27.11C27.62 33.84 28.13 33.78 28.64 33.71C32.31 33.22 35.68 31.91 38.8 29.93C43.22 27.13 46.74 23.41 49.69 19.12C50.12 18.49 50.54 17.84 50.96 17.21V17.13C50.38 16.29 49.82 15.43 49.22 14.6ZM37.38 3.65C37.34 3.75 37.28 3.85 37.22 3.94L34.46 8.13L20.88 28.78L18.26 32.77L17.98 33.19C17.49 33.93 16.68 34.34 15.85 34.34C15.37 34.34 14.89 34.2 14.46 33.92C13.39 33.21 13.02 31.83 13.56 30.7C13.61 30.6 13.67 30.5 13.73 30.4L16.47 26.24L30.04 5.61L32.69 1.6L32.98 1.15C33.47 0.41 34.28 0 35.1 0C35.58 0 36.07 0.14 36.5 0.42C37.58 1.13 37.93 2.52 37.38 3.65Z"
                                  fill="currentcolor"
                                />
                              </g>
                              <defs>
                                <clipPath id="clip0_1249_2209">
                                  <rect
                                    width="50.96"
                                    height="34.34"
                                    fill="currentcolor"
                                  />
                                </clipPath>
                              </defs>
                            </svg>
                            <svg
                              class="w-5 h-5 text-gray-500 absolute top-3"
                              :class="
                                lang &&
                                JSON.parse(lang) &&
                                JSON.parse(lang)['direction'] == 'ltr'
                                  ? 'right-3'
                                  : 'left-3'
                              "
                              @click="display_password = 'password'"
                              v-else-if="display_password == 'text'"
                              viewBox="0 0 51 34"
                              fill="none"
                              xmlns="http://www.w3.org/2000/svg"
                            >
                              <g clip-path="url(#clip0_1248_2207)">
                                <path
                                  d="M50.96 16.7C50.96 16.72 50.96 16.75 50.96 16.77C50.54 17.41 50.13 18.05 49.69 18.68C46.74 22.97 43.22 26.69 38.8 29.49C35.68 31.46 32.31 32.77 28.64 33.26C28.13 33.33 27.62 33.39 27.11 33.46C26.02 33.46 24.94 33.46 23.85 33.46C23.25 33.38 22.64 33.31 22.04 33.22C18.47 32.67 15.19 31.35 12.15 29.41C8.16 26.86 4.89 23.57 2.08 19.78C1.36 18.82 0.69 17.78 0 16.77C0 16.75 0 16.72 0 16.7C0.07 16.61 0.15 16.52 0.21 16.42C0.93 15.36 1.62 14.27 2.39 13.24C5.23 9.44 8.57 6.16 12.65 3.69C15.69 1.85 18.96 0.64 22.5 0.2C23.07 0.13 23.64 0.07 24.21 0C25.06 0 25.91 0 26.76 0C27.25 0.05 27.74 0.1 28.22 0.16C31.57 0.58 34.7 1.67 37.63 3.35C42.33 6.06 46.07 9.81 49.23 14.17C49.82 15 50.38 15.86 50.96 16.7ZM24.98 29.15C30.92 29.15 35.74 25.62 37.33 20.39C38.37 16.97 37.92 13.67 36.34 10.51C35.58 8.98 34.69 7.57 33.14 6.66C30.6 5.17 27.94 4.24 24.96 4.37C17.99 4.68 12.67 10.59 13.12 17.56C13.3 20.43 14.37 22.98 16.03 25.3C16.26 25.62 16.55 25.92 16.87 26.15C19.42 28.02 22.25 29.12 24.98 29.15Z"
                                  fill="currentcolor"
                                />
                              </g>
                              <defs>
                                <clipPath id="clip0_1248_2207">
                                  <rect
                                    width="50.96"
                                    height="33.48"
                                    fill="currentcolor"
                                  />
                                </clipPath>
                              </defs>
                            </svg>
                          </div>
                          <Error
                            fieldName="password"
                            :validationErros="validationErros"
                            full_width="1"
                          />
                        </div>
                      </div>
                      <div class="mt-5 flex items-center justify-center gap-4">
                        <a
                          aria-label="Candian Exporters"
                          :href="register_url"
                          class="button-exp-no-fill"
                          >{{
                            JSON.parse(modal_setting)
                              ? JSON.parse(modal_setting)["signup_button_text"]
                              : ""
                          }}</a
                        >
                        <button
                          aria-label="Candian Exporters"
                          type="submit"
                          class="button-exp-fill border border-primary"
                        >
                          {{
                            login_page_setting_detail &&
                            JSON.parse(login_page_setting_detail)[
                              "signin_btn_text"
                            ]
                              ? JSON.parse(login_page_setting_detail)[
                                  "signin_btn_text"
                                ]
                              : "Login"
                          }}
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
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
import Error from "./../components/Error.vue";
import Upgrade from "../signup/Upgrade";
import ErrorHandling from "../../ErrorHandling";
import axios from "axios";
import { mapState } from "vuex";
export default {
  props: [
    "inquiries",
    "home_page_setting_detail",
    "display_all_i2b",
    "login_page_setting_detail",
    "inquiry_id",
    "register_url",
    "modal_setting",
    "user",
    "lang",
    "page",
    "is_home_page",
    "i2b_setting",
  ],
  computed: {
    ...mapState({
      customerPaymentMethods: (state) => state.signup.customerPaymentMethods,
    }),
    years() {
      const currentYear = new Date().getFullYear();
      return Array.from({ length: 16 }, (_, index) => currentYear + index);
    },
  },
  components: {
    Error,
    Upgrade,
  },
  data() {
    return {
      display_password: "password",
      loading: false,
      reCAPTCHA_site_key: process.env.MIX_reCAPTCHA_site_key,
      isI2BModalDisplayed: 0,
      inquiryId: null,
      isUserLoggedIn: false,
      customer: [],
      validationErros: new ErrorHandling(),
      login_form: {
        email: "",
        password: "",
        inquiry_id: "",
      },
      form: {
        inquiry_id: "",
      },
    };
  },
  methods: {
    resetValues() {
      this.form.inquiry_id = "";
      this.validationErros = new ErrorHandling();
      this.login_form.email = "";
      this.login_form.password = "";
      this.login_form.inquiry_id = "";
      this.isI2BModalDisplayed = 0;
      this.inquiryId = null;
      this.isUserLoggedIn = false;
      this.customer = [];
    },
    // displayI2BModal(i2bId, i2bName) {
    //   this.resetValues();
    //   this.loading = 1;
    //   axios
    //     .post(`${process.env.MIX_APP_URL}/get-logged-in-user`)
    //     .then((res) => {
    //       this.isI2BModalDisplayed = 1;
    //       this.inquiryId = i2bId;
    //       this.loading = 0;
    //       if (res.data.status == "Success") {
    //         this.isUserLoggedIn = true;
    //         this.customer = res?.data?.data?.customer ?? null;
    //         axios
    //           .get(
    //             `${process.env.MIX_APP_URL}/get-registration-packages?getPayToGoPackagesOnly=1`
    //           )
    //           .then((res) => {
    //             if (res.data.status == "Success") {
    //             }
    //           });
    //       } else {
    //         this.isUserLoggedIn = false;
    //       }
    //     })
    //     .finally(() => (this.loading = false));
    // },
    displayI2BModal(i2bId, i2bName) {
  this.resetValues();

  const langAbbr = this.lang?.abbreviation || 'en';

    if (this.user && !JSON.parse(this.user).is_package_amount_paid) {
      window.location.href = `${process.env.MIX_APP_URL}/${langAbbr}/user/review-confirmation`;
      return;
    }

  this.resetValues();
  this.loading = 1;
  axios
    .post(`${process.env.MIX_APP_URL}/get-logged-in-user`)
    .then((res) => {
      this.isI2BModalDisplayed = 1;
      this.inquiryId = i2bId;
      this.loading = 0;
      if (res.data.status == "Success") {
        this.isUserLoggedIn = true;
        this.customer = res?.data?.data?.customer ?? null;
        axios
          .get(
            `${process.env.MIX_APP_URL}/get-registration-packages?getPayToGoPackagesOnly=1`
          )
          .then((res) => {
            if (res.data.status == "Success") {
            }
          });
      } else {
        this.isUserLoggedIn = false;
      }
    })
    .finally(() => (this.loading = false));
},
handleI2bButtonClick(inquiryId) {
    const langAbbr = this.lang?.abbreviation || 'en';

    if (this.user && !JSON.parse(this.user).is_package_amount_paid) {
      window.location.href = `${process.env.MIX_APP_URL}/${langAbbr}/user/review-confirmation`;
    } else {

      this.displayI2BModal(inquiryId);
    }
  },
    loginCustomer() {
      this.loading = true;
      this.login_form.inquiry_id = this.inquiryId;
      axios
        .post(`${process.env.MIX_APP_URL}/logged-in-user`, this.login_form)
        .then((res) => {
          this.loading = 0;
          if (res.data.status == "Success") {
            location.reload();
          } else {
            helper.swalErrorMessageForWeb(res.data.message);
            this.isUserLoggedIn = false;
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
            helper.swalErrorMessageForWeb(error.response.data.message);
          }
        })
        .finally(() => (this.loading = false));
    },
    hideI2BModal() {
      this.isI2BModalDisplayed = 0;
      this.inquiryId = null;
    },
    async recaptcha() {
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
      this.form.inquiry_id = this.inquiryId;
      this.loading = true;
      axios
        .post(`${process.env.MIX_APP_URL}/save-inquiry`, this.form)
        .then((res) => {
          this.loading = false;
          if (res.data.status == "Success") {
            if (res?.data?.data?.type == "paypal") {
              window.location.href = res?.data?.data?.redirect_url;
            } else {
              helper.swalSuccessMessageForWeb(res.data.message);
              this.hideI2BModal();
            }
          } else if (res.data.status == "Error") {
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
            helper.swalErrorMessageForWeb(error.response.data.message);
          }
        })
        .finally(() => (this.loading = false));
    },
    removeI2b(i2bId, type) {
      this.$swal
        .fire({
          text: "Are you sure you want to remove this listing from your search results?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes",
          cancelButtonText: "No",
          showCloseButton: true,
          customClass: {
            confirmButton: "inline-flex items-center button-exp-fill",
            cancelButton:
              "inline-flex items-center bg-red-500 hover:bg-red-600 button-exp-fill cursor-pointer border-red-500",
          },
        })
        .then((result) => {
          if (result.isConfirmed) {
            axios
              .post(`${process.env.MIX_APP_URL}/remove-exports-from-search`, {
                id: i2bId,
                type: type,
              })
              .then((res) => {
                document.querySelector(`#i2b-${i2bId}`).classList.add("hidden");
              });
          }
        });
    },
    displayModalBody() {
      let bodyText = "";
      if (!this.isUserLoggedIn) {
        bodyText = JSON.parse(this.modal_setting)
          ? JSON.parse(this.modal_setting)?.["guest_package_text"]
          : "";
      } else if (
        this.user &&
        (JSON.parse(this.user)?.registration_package?.package_type ==
          "featured" ||
          JSON.parse(this.user)?.registration_package?.package_type ==
            "premium")
      ) {
        bodyText = JSON.parse(this.modal_setting)
          ? JSON.parse(this.modal_setting)["paid_package_text"]
          : "";
      } else if (
        JSON.parse(this.user)?.registration_package?.package_type == "free"
      ) {
        bodyText = JSON.parse(this.modal_setting)
          ? JSON.parse(this.modal_setting)["free_package_text"]
          : "";
      }
      return bodyText;
    },
    getRegistrationTypeText() {
      let bodyText = "";
      if (
        this.user &&
        (JSON.parse(this.user)?.registration_package?.package_type ==
          "featured" ||
          JSON.parse(this.user)?.registration_package?.package_type ==
            "premium")
      ) {
        bodyText = JSON.parse(this.modal_setting)
          ? JSON.parse(this.modal_setting)["paid_package_submit_button_text"]
          : "";
      } else {
        bodyText = JSON.parse(this.modal_setting)
          ? JSON.parse(this.modal_setting)["free_package_submit_button_text"]
          : "";
      }
      return bodyText;
    },
    toFormattedNumber(value) {
      let numberValue = Number(value);

      numberValue = isNaN(numberValue) ? 0 : numberValue;

      return numberValue.toLocaleString();
    },
  },
  created() {
    if (this.inquiry_id) {
      this.displayI2BModal(this.inquiry_id, null);
    }
  },
};
</script>
