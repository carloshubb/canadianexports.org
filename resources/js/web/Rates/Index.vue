<template>
    <div class="my-4 space-y-2" id="registration_package_id">
        <div class="bg-gray-50">
          <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="flex justify-center">
              <fieldset
                class="grid sm:grid-cols-4 grid-cols-2 gap-2 text-center"
              >
                <legend class="sr-only">Payment frequency</legend>
                <div>
                <label
                  class="cursor-pointer rounded px-3 py-2 w-28 block"
                  :class="
                    payment_frequency == 'monthly'
                        ? 'button-exp-fill text-white'
                        : 'button-exp-no-fill'
                  "
                >
                  <input
                    type="radio"
                    name="frequency"
                    value="monthly"
                    class="sr-only"
                    @click="updatePackageForm('payment_frequency', 'monthly')"
                  />
                  <span>Monthly</span>
                </label>
            </div>
            <div>
                <label
                  class="cursor-pointer rounded px-3 py-2 w-28 block"
                  :class="
                    payment_frequency == 'quarterly'
                        ? 'button-exp-fill text-white'
                        : 'button-exp-no-fill'
                  "
                >
                  <input
                    type="radio"
                    name="frequency"
                    value="quarterly"
                    class="sr-only"
                    @click="updatePackageForm('payment_frequency', 'quarterly')"
                  />
                  <span>Quarterly</span>
                </label>
                <p class="text-center text-xs mt-2">(Save {{ discountPercentages.quarterly || 10 }}%)</p>
            </div>
            <div>
                <label
                  class="cursor-pointer rounded px-3 py-2 w-28 block"
                  :class="
                    payment_frequency == 'semi_annually'
                        ? 'button-exp-fill text-white'
                        : 'button-exp-no-fill'
                  "
                >
                  <input
                    type="radio"
                    name="frequency"
                    value="semi_annually"
                    class="sr-only"
                    @click="
                      updatePackageForm('payment_frequency', 'semi_annually')
                    "
                  />
                  <span>Semi-annual</span>
                </label>
                <p class="text-center text-xs mt-2">(Save {{ discountPercentages.semi_annually || 20 }}%)</p>
            </div>
            <div>
                <label
                  class="cursor-pointer rounded px-3 py-2 w-28 block"
                  :class="
                    payment_frequency == 'annually'
                        ? 'button-exp-fill text-white'
                        : 'button-exp-no-fill'
                  "
                >
                  <input
                    type="radio"
                    name="frequency"
                    value="annually"
                    class="sr-only"
                    @click="updatePackageForm('payment_frequency', 'annually')"
                  />
                  <span>Annual</span>
                </label>
                <p class="text-center text-xs mt-2">(Save {{ discountPercentages.annually || 40 }}%)</p>
            </div>
              </fieldset>
            </div>
            <div
              class="isolate mx-auto mt-10 grid max-w-md grid-cols-1 gap-8 lg:mx-0 lg:max-w-none  md:grid-cols-2 lg:grid-cols-3"
            >
              <div
                class="rounded-3xl p-6 xl:p-6 border bg-white cursor-pointer"
                :class="package_type == 'free' ? 'ring-2 ring-[#006EB7]' : ''"
                @click.prevent="updatePackageForm('package_type', freePackage)"
              >
                <div class="flex items-center lg:justify-center gap-x-4">
                  <h3
                    id="tier-free"
                    class="text-center text-3xl font-medium text-primary"
                  >
                    {{ freePackage?.registration_package_detail?.[0]?.name }}
                  </h3>
                  <p
                    class="rounded-full bg-red-600/10 px-2.5 py-1 text-xs font-semibold leading-5 text-red-600 whitespace-nowrap"
                    v-if="freePackage?.is_default"
                  >
                    Most popular
                  </p>
                </div>
                <p class="mt-4 text-sm leading-6 text-gray-700">
                  {{
                    freePackage?.registration_package_detail?.[0]
                      ?.short_description
                  }}
                </p>
                <p class="mt-6 flex justify-center items-baseline gap-x-1">
                  <span class="text-4xl font-bold tracking-tight text-gray-900">
                    <template v-if="payment_frequency == 'monthly'">
                      ${{ freePackage?.monthly_price }}
                    </template>
                    <template v-else-if="payment_frequency == 'quarterly'">
                      ${{ freePackage?.quarterly_price }}
                    </template>
                    <template v-else-if="payment_frequency == 'semi_annually'">
                      ${{ freePackage?.semi_annually_price }}
                    </template>
                    <template v-else-if="payment_frequency == 'annually'">
                      ${{ freePackage?.annually_price }}
                    </template>
                  </span>

                  <span class="text-sm font-semibold leading-6 text-gray-600"
                    >/month</span
                  >
                </p>
                <ul
                  role="list"
                  class="mt-8 space-y-3 text-sm leading-6 text-gray-600 xl:mt-10 p-0"
                  v-if="freePackage?.registration_package_feature"
                >
                  <li
                    class="flex gap-x-3"
                    v-for="features in freePackage?.registration_package_feature"
                    :key="features.id"
                  >
                    <svg
                      class="h-6 w-5 flex-none  text-[#006EB7]"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                      aria-hidden="true"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                        clip-rule="evenodd"
                      />
                    </svg>
                    {{ features?.name }}
                  </li>
                </ul>
              </div>

              <div
                class="rounded-3xl p-6 xl:p-6 border bg-white cursor-pointer"
                :class="package_type == 'premium' ? 'ring-2 ring-[#006EB7]' : ''"
                @click.prevent="
                  updatePackageForm('package_type', premiumPackage)
                "
              >
                <div class="flex items-center lg:justify-center gap-x-4">
                  <h3
                    id="tier-premium"
                    class="text-center text-3xl font-medium text-primary"
                  >
                    {{ premiumPackage?.registration_package_detail?.[0]?.name }}
                  </h3>
                  <p
                    class="rounded-full bg-red-600/10 px-2.5 py-1 text-xs font-semibold leading-5 text-red-600 whitespace-nowrap"
                    v-if="premiumPackage?.is_default"
                  >
                    Most popular
                  </p>
                </div>
                <p class="mt-4 text-sm leading-6 text-gray-700">
                  {{
                    premiumPackage?.registration_package_detail?.[0]
                      ?.short_description
                  }}
                </p>
                <p class="mt-6 flex justify-center items-baseline gap-x-1">
                  <span class="text-4xl font-bold tracking-tight text-gray-900">
                    <template v-if="payment_frequency == 'monthly'">
                      ${{ premiumPackage?.monthly_price }}
                    </template>
                    <template v-else-if="payment_frequency == 'quarterly'">
                      ${{ premiumPackage?.quarterly_price }}
                    </template>
                    <template v-else-if="payment_frequency == 'semi_annually'">
                      ${{ premiumPackage?.semi_annually_price }}
                    </template>
                    <template v-else-if="payment_frequency == 'annually'">
                      ${{ premiumPackage?.annually_price }}
                    </template>
                  </span>

                  <span class="text-sm font-semibold leading-6 text-gray-600"
                    >/month</span
                  >
                </p>
                <ul
                  role="list"
                  class="mt-8 space-y-3 text-sm leading-6 text-gray-600 xl:mt-10 p-0"
                  v-if="premiumPackage?.registration_package_feature"
                >
                  <li
                    class="flex gap-x-3"
                    v-for="features in premiumPackage?.registration_package_feature"
                    :key="features.id"
                  >
                    <svg
                      class="h-6 w-5 flex-none  text-[#006EB7]"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                      aria-hidden="true"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                        clip-rule="evenodd"
                      />
                    </svg>
                    {{ features?.name }}
                  </li>
                </ul>
              </div>

              <div
                class="rounded-3xl p-6 xl:p-6 border bg-white cursor-pointer"
                :class="
                  package_type == 'featured' ? 'ring-2 ring-[#006EB7]' : ''
                "
                @click.prevent="
                  updatePackageForm('package_type', featuredPackage)
                "
              >
                <div class="flex items-center lg:justify-center gap-x-4">
                  <h3
                    id="tier-featured"
                    class="text-center text-3xl font-medium text-primary"
                  >
                    {{
                      featuredPackage?.registration_package_detail?.[0]?.name
                    }}
                  </h3>
                  <p
                    class="rounded-full bg-red-600/10 px-2.5 py-1 text-xs font-semibold leading-5 text-red-600 whitespace-nowrap"
                    v-if="featuredPackage?.is_default"
                  >
                    Most popular
                  </p>
                </div>
                <p class="mt-4 text-sm leading-6 text-gray-700">
                  {{
                    featuredPackage?.registration_package_detail?.[0]
                      ?.short_description
                  }}
                </p>
                <p class="mt-6 flex justify-center items-baseline gap-x-1">
                  <span class="text-4xl font-bold tracking-tight text-gray-900">
                    <template v-if="payment_frequency == 'monthly'">
                      ${{ featuredPackage?.monthly_price }}
                    </template>
                    <template v-else-if="payment_frequency == 'quarterly'">
                      ${{ featuredPackage?.quarterly_price }}
                    </template>
                    <template v-else-if="payment_frequency == 'semi_annually'">
                      ${{ featuredPackage?.semi_annually_price }}
                    </template>
                    <template v-else-if="payment_frequency == 'annually'">
                      ${{ featuredPackage?.annually_price }}
                    </template>
                  </span>

                  <span class="text-sm font-semibold leading-6 text-gray-600"
                    >/month</span
                  >
                </p>
                <ul
                  role="list"
                  class="mt-8 space-y-3 text-sm leading-6 text-gray-600 xl:mt-10 p-0"
                  v-if="featuredPackage?.registration_package_feature"
                >
                  <li
                    class="flex gap-x-3"
                    v-for="features in featuredPackage?.registration_package_feature"
                    :key="features.id"
                  >
                    <svg
                      class="h-6 w-5 flex-none  text-[#006EB7]"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                      aria-hidden="true"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                        clip-rule="evenodd"
                      />
                    </svg>
                    {{ features?.name }}
                  </li>
                </ul>
              </div>
            </div>
            <div class="my-2" v-if="ratesSetting && ratesSetting.price_table_post_text">
          <div v-html="ratesSetting.price_table_post_text"></div>
        </div>

        <!-- Page Heading -->
        <h1 class="text-center" v-if="ratesSetting && ratesSetting.page_heading">
          {{ ratesSetting.page_heading }}
        </h1>

        <!-- Required Fields Text -->
        <div class="" v-if="ratesSetting && ratesSetting.required_fields_text">
          <p class="text-red-500">
            <span class="text-red-500">*</span>
            {{ ratesSetting.required_fields_text }}
          </p>
        </div>

            <form class="lg:w-full" id="contact-us-form" @submit.prevent="recaptcha()">
      <div class="my-4">
        <div class="grid mt-4 md:grid-cols-2 gap-4">
          <div class="relative w-full mb-3">
            <label
              class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg"
              for="name"
              >{{ (rates_setting && JSON.parse(rates_setting)?.name_label) || '' }}
              <span class="text-red-500">*</span>
            </label>
            <input
             @input="clearErrors('name')"
              type="text"
              class="can-exp-input"
              :placeholder="rates_setting ? (JSON.parse(rates_setting)?.name_placeholder || '') : ''"

              id="name"
              v-model="form.name"
            />
            <Error v-if="submitted" fieldName="name" :validationErros="validationErros" />
          </div>


          <div class="relative w-full mb-3">
            <label
              class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg"
              for="email"
              >{{ (rates_setting && JSON.parse(rates_setting)?.email_label) || '' }}
              <span class="text-red-500">*</span>
            </label>
            <input
             @input="clearErrors('email')"
              type="text"
              class="can-exp-input"
              :placeholder="rates_setting ? (JSON.parse(rates_setting)?.email_placeholder || '') : ''"

              id="email"
              v-model="form.email"
            />
            <Error v-if="submitted" fieldName="email" :validationErros="validationErros" />
          </div>
          <div class="relative w-full mb-3 col-span-2">
            <label
              class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg"
              for="message"
              >{{ (rates_setting && JSON.parse(rates_setting)?.message_label) || '' }}
              <span class="text-red-500">*</span>
            </label>
            <textarea
             @input="clearErrors('message')"
              rows="5"
              type="text"
              class="can-exp-input"
              :placeholder="rates_setting ? (JSON.parse(rates_setting)?.message_placeholder || '') : ''"

              id="message"
              v-model="form.message"
            >
            </textarea>
            <Error v-if="submitted" fieldName="message" :validationErros="validationErros" />
          </div>
        </div>
      </div>
      <Error v-if="submitted" fieldName="captcha" :validationErros="validationErros" />
      <!-- <ListErrors :validationErrors="validationErros" /> -->
      <div class="mt-8 flex justify-center items-center">
        <button
          aria-label="Candian Exporters"
          class="button-exp-fill"
          type="submit"
          id="send-message"
        >
        {{ (rates_setting && JSON.parse(rates_setting)?.button_text) || '' }}
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
          </div>

        </div>
      </div>

</template>
<script>
import { mapState } from "vuex";
import { load } from "recaptcha-v3";
import Error from "../components/Error.vue";
import axios from "axios";
import ErrorHandling from "../../ErrorHandling";

export default {
  props: {
    user: {
      type: Object,
      default: null,
    },
    rates_setting: {
      type: Object,
      required: true,
    },
    submit_url: {
      type: String,
      required: true,
    },
    page_id: {
      type: Number,
      required: true,
    },
  },
  components: {
    Error,
  },
  data() {
    return {
      form: {
        name: "",
        email: "",
        message: "",
        page_id: "",
      },
      loading: false,
      validationErros: new ErrorHandling(),
      reCAPTCHA_site_key: process.env.MIX_reCAPTCHA_site_key,
      submitted: false,
      payment_frequency: "annually",
      discountPercentages: {
        quarterly: 10,
        semi_annually: 20,
        annually: 40,
      },
    };
  },
  mounted() {
    this.loadFormData(); // Load saved form data when the component is mounted
  },
  watch: {
    // Watch for changes in form fields and save them to localStorage
    form: {
      handler(newValue) {
        localStorage.setItem("ratesFormData", JSON.stringify(newValue));
      },
      deep: true, // Ensure deep watching for nested objects/arrays
    },
  },
  computed: {
    ratesSetting() {
      // Parse the rates_setting prop if it's passed as a JSON string
      return typeof this.rates_setting === "string"
        ? JSON.parse(this.rates_setting)
        : this.rates_setting;
    },
    ...mapState({
      registrationPackages: (state) => state.signup.registrationPackages,
      package_type: (state) => state.signup.package_type,
    }),
    freePackage() {
      return this.registrationPackages?.find((p) => p.package_type === "free") || null;
    },
    featuredPackage() {
      return this.registrationPackages?.find((p) => p.package_type === "featured") || null;
    },
    premiumPackage() {
      return this.registrationPackages?.find((p) => p.package_type === "premium") || null;
    },
  },
  methods: {
    async fetchBillingDiscounts() {
      try {
        const response = await axios.get(
          `${process.env.MIX_WEB_API_URL}get-billing-discounts`
        );
        const discounts = response.data.data;
        if (discounts) {
          this.discountPercentages = {
            quarterly: parseInt(discounts.quarterly?.discount_percentage) || 10,
            semi_annually: parseInt(discounts.semi_annually?.discount_percentage) || 20,
            annually: parseInt(discounts.annually?.discount_percentage) || 40,
          };
        }
      } catch (error) {
        console.error("Error fetching billing discounts:", error);
        // Keep default values on error
      }
    },
    loadFormData() {
      const savedFormData = localStorage.getItem("ratesFormData");
      if (savedFormData) {
        this.form = JSON.parse(savedFormData);
      }
    },
    updatePackageForm(field, value) {
      if (field === "payment_frequency") {
        this[field] = value;
        this.$store.commit("signup/setPaymentFrequency", value);
      }
      if (field === "package_type") {
        this.$store.commit("signup/setSelectedRegistrationPackage", value);
        this.$store.commit("signup/setPackageType", value.package_type);
        value = value.package_type;
      }
      this.$store.commit("signup/setForm", { field, value });
    },
    clearErrors(fieldName) {
      if (this.submitted) {
        this.validationErros.clear(fieldName);
      }
    },
    clearForm() {
      this.form = { name: "", email: "", message: "", page_id: "" };
      this.validationErros = new ErrorHandling();
      localStorage.removeItem("ratesFormData");
    },
    async recaptcha() {
      this.submitted = true;
      this.loading = true;
      load(this.reCAPTCHA_site_key).then((recaptcha) => {
        recaptcha.showBadge();
        recaptcha.execute("submit").then((token) => {
          axios
            .post(`${process.env.MIX_WEB_API_URL}verifyRecaptcha`, { token })
            .then((res) => {
              recaptcha.hideBadge();
              if (res.data.status === "Success") {
                this.saveForm();
              } else {
                this.loading = false;
                this.validationErros.record({ captcha: [res.data.message] });
              }
            });
        });
      });
    },
    saveForm() {
      this.form.page_id = this.page_id;
      axios
        .post(this.submit_url, this.form)
        .then((res) => {
          this.loading = false;
          if (res.data.status === "Success") {
            helper.swalPreSuccessMessageForWeb(res.data.message);
            this.clearForm();
          } else {
            helper.swalErrorMessageForWeb(res.data.message);
          }
        })
        .catch((error) => {
          this.loading = false;
          this.validationErros = new ErrorHandling();
          if (error.response?.status === 422) {
            this.validationErros.record(error.response.data.errors);
          } else if (error.response?.data?.status === "Error") {
            helper.swalErrorMessageForWeb(error.response.data.message);
          }
        });
    },
  },
  created() {
    // Fetch billing discounts
    this.fetchBillingDiscounts();

    this.$store.dispatch("signup/fetchRegistrationPackages", {
      url: `${process.env.MIX_WEB_API_URL}get-registration-packages?getPackagesOnly=1&withPackageFeatures=1&getProfilePackagesOnly=1`,
    });
  },
};
</script>

