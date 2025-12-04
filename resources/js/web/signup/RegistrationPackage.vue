<template>
  <div>
    <div class="mb-4">
      <div
        class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-xblue via-primary to-blue-600 rounded-md"
        v-if="profile == '1'"
      >
        <h4
          class="text-white"
          v-html="
            JSON.parse(user)?.is_package_amount_paid
              ? regPageSetting?.reg_page_setting_detail?.[0]?.step_1_acc_heading
              : regPageSetting?.reg_page_setting_detail?.[0]?.step_1_heading
          "
        ></h4>
      </div>
      <div
        class="text-center mt-4 flex flex-col justify-center items-center"
        v-if="profile == '1'"
      >
        <p
          v-html="
            regPageSetting?.reg_page_setting_detail?.[0]?.step_1_acc_description
          "
        ></p>
        <svg
          width="40"
          height="40"
          viewBox="0 0 423 557"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M218.622 394.188C205.437 369.942 189.652 346.998 165.4 327.791C165.763 330.7 166.013 333.291 166.234 335.575C166.362 336.897 166.48 338.115 166.604 339.233C167.098 343.688 167.677 346.328 168.973 348.249C204.057 400.251 226.795 457.628 244.498 517.214C246.733 524.734 249.158 532.171 252.838 538.674C257.861 547.547 263.59 552.388 269.794 553.935C276.002 555.484 283.315 553.892 291.848 548.519L293.041 550.413L291.848 548.519C295.988 545.913 299.802 542.48 303.406 538.833L305.091 540.498L303.406 538.833C336.692 505.157 370.667 471.561 416.292 452.479C396.86 445.344 379.509 446.081 363.303 451.598C345.416 457.686 328.814 469.633 312.323 483.624L308.206 487.117V481.718C308.206 466.752 308.572 452.192 308.93 437.928C309.691 407.663 310.419 378.726 307.546 350.052C295.137 226.192 244.28 121.418 143.472 46.6022C117.563 27.3736 84.5008 16.4676 52.7553 5.99609L52.2958 5.84448L53.0178 3.65552L52.2957 5.84442C41.1379 2.16345 34.2754 1.64648 27.4674 3.67877C21.6912 5.40308 15.8071 8.98517 7.38014 14.6144C113.844 23.9766 174.073 94.7545 222.293 180.262C273.209 270.554 285.806 366.598 263.619 472.218L262.303 478.483L259.025 472.984C251.387 460.169 244.792 446.906 238.362 433.65C237.402 431.67 236.446 429.691 235.49 427.714C230.034 416.425 224.605 405.19 218.622 394.188Z"
            fill="black"
            stroke="black"
            stroke-width="5"
          />
        </svg>
      </div>
      <div class="my-4 space-y-2" id="registration_package_id">
        <div :class="profile == '1' ? 'bg-white' : 'bg-gray-50'">
          <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="flex justify-center">
              <fieldset
                class="grid sm:grid-cols-4 grid-cols-2 gap-2 text-center"
              >
                <legend class="sr-only">Payment frequency</legend>

                <div>
                  <label
                    class="w-28 block"
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
                    <span>
                      {{
                          JSON.parse(payment_setting)[
                                    "monthly_label"
                                ]
                              ?? "Monthly"
                      }}
                    </span>
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
                      @click="
                        updatePackageForm('payment_frequency', 'quarterly')
                      "
                    />
                    <span>
                      {{
                          JSON.parse(payment_setting)[
                                    "quaterly_label"
                                ]
                              ?? "Quarterly"
                      }}</span>
                  </label>
                  <p class="text-center text-xs mt-2">({{
                          JSON.parse(payment_setting)[
                                    "save_label"
                                ]
                              ?? "Save"
                      }} {{ discountPercentages.quarterly || 10 }}%)</p>
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
                    <span>{{
                          JSON.parse(payment_setting)[
                                    "semi_annual_label"
                                ]
                              ?? "Semi-annual"
                      }}</span>
                  </label>
                  <p class="text-center text-xs mt-2">({{
                          JSON.parse(payment_setting)[
                                    "save_label"
                                ]
                              ?? "Save"
                      }} {{ discountPercentages.semi_annually || 20 }}%)</p>
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
                      @click="
                        updatePackageForm('payment_frequency', 'annually')
                      "
                    />
                    <span>
                      {{
                          JSON.parse(payment_setting)[
                                    "annual_label"
                                ]
                              ?? "Annual"
                      }}</span>
                  </label>
                  <p class="text-center text-xs mt-2">({{
                          JSON.parse(payment_setting)[
                                    "save_label"
                                ]
                              ?? "Save"
                      }} {{ discountPercentages.annually || 40 }}%)</p>
                </div>
              </fieldset>
            </div>
            <Error
              fieldName="registration_package_id"
              :validationErros="validationErros"
            />
            <div
              class="isolate mx-auto mt-10 grid max-w-md grid-cols-1 gap-8 lg:mx-0 lg:max-w-none md:grid-cols-2 lg:grid-cols-3"
            >
              <div
                class="rounded-3xl p-6 xl:p-6 border bg-white cursor-pointer"
                id="free-package"
                :class="package_type == 'free' ? 'ring-2 ring-[#006EB7]' : ''"
                @click.prevent="updatePackageForm('package_type', freePackage)"
              >
                <div class="flex items-center justify-center gap-x-4">
                  <h3
                    id="tier-free"
                    class="text-center text-3xl font-medium text-primary"
                  >
                    {{ freePackage?.registration_package_detail?.[0]?.name }}
                  </h3>
                  <p
                    class="rounded-full bg-red-600/10 px-2.5 py-1 text-xs font-semibold leading-5 text-red-600"
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
                    >/
                    {{
                          JSON.parse(payment_setting)[
                                    "month_label"
                                ]
                              ?? "/month"
                      }}</span
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
                      class="h-6 w-5 flex-none text-[#006EB7]"
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
                    <span v-html="formatFeatureName(features?.name)"></span>
                  </li>
                </ul>
              </div>

              <div
                class="rounded-3xl p-6 xl:p-6 border bg-white cursor-pointer"
                :class="
                  package_type == 'premium' ? 'ring-2 ring-[#006EB7]' : ''
                "
                id="premium-package"
                @click.prevent="
                  updatePackageForm('package_type', premiumPackage)
                "
              >
                <div class="flex items-center justify-center gap-x-4">
                  <h3
                    id="tier-premium"
                    class="text-center text-3xl font-medium text-primary"
                  >
                    {{ premiumPackage?.registration_package_detail?.[0]?.name }}
                  </h3>
                  <p
                    class="rounded-full bg-red-600/10 px-2.5 py-1 text-xs font-semibold leading-5 text-red-600"
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
                    >/ {{
                          JSON.parse(payment_setting)[
                                    "month_label"
                                ]
                              ?? "/month"
                      }}</span
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
                      class="h-6 w-5 flex-none text-[#006EB7]"
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
                    <span v-html="formatFeatureName(features?.name)"></span>
                  </li>
                </ul>
              </div>

              <div
                class="rounded-3xl p-6 xl:p-6 border bg-white cursor-pointer"
                id="featured-package"
                :class="
                  package_type == 'featured' ? 'ring-2 ring-[#006EB7]' : ''
                "
                @click.prevent="
                  updatePackageForm('package_type', featuredPackage)
                "
              >
                <div class="flex items-center justify-center gap-x-4">
                  <h3
                    id="tier-featured"
                    class="text-center text-3xl font-medium text-primary"
                  >
                    {{
                      featuredPackage?.registration_package_detail?.[0]?.name
                    }}
                  </h3>
                  <p
                    class="rounded-full bg-red-600/10 px-2.5 py-1 text-xs font-semibold leading-5 text-red-600"
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
                    >/ {{
                          JSON.parse(payment_setting)[
                                    "month_label"
                                ]
                              ?? "/month"
                      }}</span
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
                      class="h-6 w-5 flex-none text-[#006EB7]"
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
                    <span v-html="formatFeatureName(features?.name)"></span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="flex items-center mb-4">
        <input
          id="auto-renew"
          type="checkbox"
          value=""
          class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary"
          @input="updateAutoRenew('is_auto_renew', $event.target.checked)"
          :checked="
            form.get('is_auto_renew') && form.get('is_auto_renew') == 'true'
              ? true
              : false
          "
        />
        <label
          for="auto-renew"
          class="ml-2 text-gray-900 text-base md:text-base lg:text-lg"
        >
          {{
            regPageSetting &&
            regPageSetting.reg_page_setting_detail &&
            regPageSetting.reg_page_setting_detail[0]
              ? regPageSetting.reg_page_setting_detail[0]
                  .step_1_auto_renew_label
              : ""
          }}
        </label>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { mapState } from "vuex";
import Error from "./../components/Error.vue";

export default {
  components: {
    Error,
  },
  computed: {
    ...mapState({
      regPageSetting: (state) => state.signup.regPageSetting,
      validationErros: (state) => state.signup.validationErros,
      form: (state) => state.signup.form,
      selectedPackageId: (state) => state.signup.selectedPackageId,
      registrationPackages: (state) => state.signup.registrationPackages,
      package_type: (state) => state.signup.package_type,
    }),
    freePackage() {
      if (this.$store.state.signup.registrationPackages) {
        return this.$store.state.signup.registrationPackages.find(
          (p) => p.package_type == "free"
        );
      }
      return null;
    },
    featuredPackage() {
      if (this.$store.state.signup.registrationPackages) {
        return this.$store.state.signup.registrationPackages.find(
          (p) => p.package_type == "featured"
        );
      }
      return null;
    },
    premiumPackage() {
      if (this.$store.state.signup.registrationPackages) {
        return this.$store.state.signup.registrationPackages.find(
          (p) => p.package_type == "premium"
        );
      }
      return null;
    },
  },
  data() {
    return {
      payment_frequency: "annually",
      discountPercentages: {
        quarterly: 10,
        semi_annually: 20,
        annually: 40,
      },
    };
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
      }
    },
    updateForm(field, registrationPackage) {
      this.$store.commit(
        "signup/setMaxFiles",
        registrationPackage.images_allowed
      );
      this.$store.commit("signup/setSelectedPackageId", registrationPackage.id);
      this.$store.commit("signup/setForm", {
        field: [field],
        value: registrationPackage.id,
      });
    },
    updatePackageForm(field, value) {
      if (field == "payment_frequency") {
        this[field] = value;
        this.$store.commit("signup/setPaymentFrequency", value);
      }
      if (field == "package_type") {
        this.$store.commit("signup/setSelectedRegistrationPackage", value);
        this.$store.commit("signup/setPackageType", value.package_type);
        this.updateForm("registration_package_id", value);
        value = value.package_type;
      }
      this.$store.commit("signup/setForm", {
        field: [field],
        value: value,
      });
    },
    updateAutoRenew(field, value) {
      this.$store.commit("signup/setForm", {
        field: [field],
        value: value,
      });
    },
    formatFeatureName(name) {
      if (!name) {
        return "";
      }
      return String(name).replace(/\((\d+)\)/g, '<sup class="footnote-indicator">($1)</sup>');
    },
  },
  created() {
    this.fetchBillingDiscounts();

    if (this.profile && this.profile == "1") {
      let user = JSON.parse(this.user);
      this.updatePackageForm("payment_frequency", user?.payment_frequency);
      if (user?.type == "customer") {
        this.updatePackageForm("package_type", user?.registration_package);
      }
      this.$store.commit(
        "signup/setMaxFiles",
        user?.registration_package?.images_allowed
      );
      this.$store.commit(
        "signup/setSelectedPackageId",
        user?.registration_package_id
      );

      this.$store
        .dispatch("signup/fetchRegistrationPackages", {
          url: `${process.env.MIX_WEB_API_URL}get-registration-packages?getPackagesOnly=1&withPackageFeatures=1&getProfilePackagesOnly=1`,
        })
        .then((res) => {
          if (user?.type != "customer") {
            let packages = res.data.data ?? null;
            if (packages) {
              packages.map((result) => {
                if (result.is_default) {
                  this.updatePackageForm("package_type", result);
                }
              });
            }
          }
        });
      let is_auto_renew = false;
      if (
        user.is_auto_renew == "1" ||
        user.is_auto_renew == 1 ||
        user.is_auto_renew == "true" ||
        user.is_auto_renew == "true"
      ) {
        is_auto_renew = true;
      }
      this.updateAutoRenew("is_auto_renew", is_auto_renew);
    } else {
      this.updatePackageForm("payment_frequency", "annually");
    }
  },
  mounted() {
    const url = window.location.href;
    const parsedUrl = new URL(url);
    const queryParams = new URLSearchParams(parsedUrl.search);
    const _package = queryParams.get("package");
    let _this = this;
    setTimeout(() => {
      if (_package == "free") {
        _this.updatePackageForm("package_type", _this.freePackage);
      } else if (_package == "premium") {
        _this.updatePackageForm("package_type", _this.premiumPackage);
      } else if (_package == "featured") {
        _this.updatePackageForm("package_type", _this.featuredPackage);
      }
    }, 2000);
  },
  props: ["profile", "user", "payment_setting"],
};
</script>

<style scoped>
.footnote-indicator {
  font-size: 0.75em;
  vertical-align: super;
  line-height: 1;
}
</style>