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
            class="relative transform overflow-y-auto rounded-lg shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-4xl p-1 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500"
          >
            <div class="bg-white rounded-lg p-6">
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
                    <p class="can-exp-p py-2" v-if="!isUserLoggedIn">
                      {{ displayModalBody() }}
                    </p>
                    <p class="can-exp-p py-2" v-else>
                      Click <strong>"Submit"</strong> to receive the full details of this Purchase Inquiry by email.
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
                    <div class="flex flex-col items-center justify-center gap-6 py-4">
                      <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full">
                        <div class="text-base md:text-lg text-gray-700">
                          Already a member?
                        </div>
                        <a
                          href="../en/signin"
                          class="button-exp-fill"
                          aria-label="Log in"
                        >
                          Log in
                        </a>
                      </div>
                      <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full">
                        <div class="text-base md:text-lg text-gray-700">
                          New to Canadian Exports?
                        </div>
                        <a
                          href="../en/signup"
                          class="button-exp-fill"
                          aria-label="Register"
                        >
                          Register
                        </a>
                      </div>
                    </div>
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
      if (this.form.package_id) {
        delete this.form.package_id;
      }
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

      // Check if user has featured or premium package - they should always see the modal
      if (this.user) {
        const userData = JSON.parse(this.user);
        const packageType = userData?.registration_package?.package_type;
        
        // If user has featured or premium package, show modal regardless of payment status
        if (packageType === 'featured' || packageType === 'premium') {
          // Show the modal
        } else if (!userData.is_package_amount_paid) {
          // Only redirect if they don't have a paid package and are not featured/premium
          window.location.href = `${process.env.MIX_APP_URL}/${langAbbr}/user/review-confirmation`;
          return;
        }
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

      // Check if user has featured or premium package - they should always see the modal
      if (this.user) {
        const userData = JSON.parse(this.user);
        const packageType = userData?.registration_package?.package_type;
        
        // If user has featured or premium package, show modal regardless of payment status
        if (packageType === 'featured' || packageType === 'premium') {
          this.displayI2BModal(inquiryId);
          return;
        } else if (!userData.is_package_amount_paid) {
          // Only redirect if they don't have a paid package and are not featured/premium
          window.location.href = `${process.env.MIX_APP_URL}/${langAbbr}/user/review-confirmation`;
          return;
        }
      }

      this.displayI2BModal(inquiryId);
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
      try {
        const recaptcha = await load(process.env.MIX_reCAPTCHA_site_key);
        recaptcha.showBadge();
        const token = await recaptcha.execute("submit");
        
        try {
          const res = await axios.post(`${process.env.MIX_WEB_API_URL}verifyRecaptcha`, {
            token: token,
          });
          
          setTimeout(() => {
            recaptcha.hideBadge();
          }, 3000);
          
          if (res.data.status == "Success") {
            this.saveForm();
          } else if (res.data.status == "Error") {
            this.loading = 0;
            this.validationErros.record({
              captcha: [res.data.message || "reCAPTCHA verification failed"],
            });
          }
        } catch (error) {
          this.loading = 0;
          recaptcha.hideBadge();
          const errorMessage = error.response?.data?.message || "reCAPTCHA verification failed. Please try again.";
          this.validationErros.record({
            captcha: [errorMessage],
          });
        }
      } catch (error) {
        this.loading = 0;
        const errorMessage = error.message || "Failed to load reCAPTCHA. Please try again.";
        helper.swalErrorMessageForWeb(errorMessage);
      }
    },
    saveForm() {
      this.form.inquiry_id = this.inquiryId;
      
      // Include package_id from user if available and validate user status
      if (this.user) {
        try {
          const userData = JSON.parse(this.user);
          if (userData?.registration_package?.id) {
            this.form.package_id = userData.registration_package.id;
          }
          
          // Check if user should be able to submit
          const packageType = userData?.registration_package?.package_type;
          const isPaid = userData?.is_package_amount_paid == '1' || userData?.is_package_amount_paid == 1;
          
          // If user is not Featured/Premium and hasn't paid, show error
          if (packageType !== 'featured' && packageType !== 'premium' && !isPaid && userData?.package_price > 0) {
            this.loading = false;
            helper.swalErrorMessageForWeb("Please complete your payment to access this feature.");
            return;
          }
        } catch (e) {
          console.error('Error parsing user data:', e);
        }
      }
      
      this.loading = true;
      axios
        .post(`${process.env.MIX_APP_URL}/save-inquiry`, this.form)
        .then((res) => {
          this.loading = false;
          if (res.data.status == "Success") {
            if (res?.data?.data?.type == "paypal") {
              window.location.href = res?.data?.data?.redirect_url;
            } else {
              this.$swal.fire({
                position: "center",
                showConfirmButton: true,
                confirmButtonText: 'Close',
                showCloseButton: false,
                background: "#ffffffff",
                buttonsStyling: false,
                customClass: {
                  popup: "gradient-border-modal",
                  title: "swalSuccessClass",
                  htmlContainer: "swalSuccessClass",
                  confirmButton: 'button-exp-fill focus:outline-none',
                },
                html: `
                  <p class="text-center mb-3">The full details of this Purchase Inquiry will be emailed to you at no additional cost within the next hour.</p>
                  <p class="text-center">If you don't receive it within that time, please contact us.</p>
                `,
              });
              this.hideI2BModal();
            }
          } else if (res.data.status == "Error") {
            helper.swalErrorMessageForWeb(res.data.message || "Something went wrong, please try again.");
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
            helper.swalErrorMessageForWeb(error.response.data.message || "Something went wrong, please try again.");
          } else if (error.response && error.response.data && error.response.data.message) {
            helper.swalErrorMessageForWeb(error.response.data.message);
          } else {
            // Network error or other unexpected error
            const errorMessage = error.message || "Something went wrong, please try again.";
            helper.swalErrorMessageForWeb(errorMessage);
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
