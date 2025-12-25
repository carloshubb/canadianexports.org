<template>
  <div>
    <div class="mb-4">
      <div
        class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-xblue via-primary to-blue-600 rounded-md"
      >
        <template v-if="profile == '1'">
          <h4
            class="text-white"
            v-html="
              JSON.parse(user)?.is_package_amount_paid
                ? regPageSetting?.reg_page_setting_detail?.[0]
                    ?.step_4_acc_heading
                : regPageSetting?.reg_page_setting_detail?.[0]?.step_4_heading
            "
          ></h4>
        </template>
        <template v-else>
          <h4
            class="text-white"
            v-html="
              regPageSetting?.reg_page_setting_detail?.[0]?.step_4_heading
            "
          ></h4>
        </template>
      </div>
      <div class="my-4">
        <div class="relative w-full mb-4">
          <label
            class="block text-gray-700 mb-1 text-base md:text-base lg:text-lg"
            for="company-name"
          >
            {{
              regPageSetting?.reg_page_setting_detail?.[0]?.step_4_name_label
            }}
            <span class="text-red-500">*</span>
          </label>
          <input
            type="text"
            class="can-exp-input"
            :placeholder="
              regPageSetting?.reg_page_setting_detail?.[0]
                ?.step_4_name_placeholder
            "
            @input="
              handleInput($event.target.value, 'customer_profile_company_name');
              clearValidationError('customer_profile_company_name');
            "
            :value="
              form && form.has('customer_profile_company_name')
                ? form.get('customer_profile_company_name')
                : ''
            "
            id="customer_profile_company_name"
          />
          <Error
            fieldName="customer_profile_company_name"
            :validationErros="validationErros"
          />
        </div>
        <div class="relative w-full mb-4">
          <label
            class="block text-gray-700 mb-1 text-base md:text-base lg:text-lg"
            for="company-email"
          >
            {{
              regPageSetting?.reg_page_setting_detail?.[0]?.step_4_email_label
            }}
            <span class="text-red-500">*</span>
          </label>
          <input
            type="text"
            rows="1"
            class="can-exp-input min-h-[60px] lg:min-h-full overflow-auto"
            :placeholder="
              regPageSetting?.reg_page_setting_detail?.[0]
                ?.step_4_email_placeholder
            "
            @input="
              handleInput($event.target.value, 'customer_profile_company_email');
              clearValidationError('customer_profile_company_email');
            "
            :value="
              form && form.has('customer_profile_company_email')
                ? form.get('customer_profile_company_email')
                : ''
            "
            @change="checkIsEmailValid($event.target.value)"
            id="customer_profile_company_email"
          />
          <Error
            fieldName="customer_profile_company_email"
            :validationErros="validationErros"
          />
        </div>
        <div class="relative w-full mb-4">
          <label
            class="block text-gray-700 mb-1 text-base md:text-base lg:text-lg"
            for="mailing-address"
          >
            {{
              regPageSetting?.reg_page_setting_detail?.[0]?.step_4_address_label
            }}
            <span class="text-red-500">*</span>
          </label>
          <textarea
            rows="4"
            class="can-exp-input"
            :placeholder="
              regPageSetting?.reg_page_setting_detail?.[0]
                ?.step_4_address_placeholder
            "
            @input="handleMailingAddressInput($event)"
            @blur="clearMailingAddressError"
            :value="
              form && form.has('customer_profile_address')
                ? form.get('customer_profile_address')
                : ''
            "
            id="customer_profile_address"
          ></textarea>
          <Error
            fieldName="customer_profile_address"
            :validationErros="validationErros"
          />
        </div>
        <div class="relative w-full mb-4">
          <label
            class="block text-gray-700 mb-1 text-base md:text-base lg:text-lg"
            for="phone"
          >
            {{
              regPageSetting?.reg_page_setting_detail?.[0]?.step_4_phone_label
            }}
            <span class="text-red-500">*</span>
          </label>
          <input
            type="text"
            class="can-exp-input"
            :placeholder="
              regPageSetting?.reg_page_setting_detail?.[0]
                ?.step_4_phone_placeholder
            "
            @input="
              handleInput($event.target.value, 'customer_profile_phone');
              clearValidationError('customer_profile_phone');
            "
            :value="
              form && form.has('customer_profile_phone')
                ? form.get('customer_profile_phone')
                : ''
            "
            id="customer_profile_phone"
            @keypress="restrictToNumbers($event, 16)"
          />
          <Error
            fieldName="customer_profile_phone"
            :validationErros="validationErros"
          />
        </div>
        <div class="relative w-full mb-4">
          <label
            class="block text-gray-700 mb-1 text-base md:text-base lg:text-lg"
            for="website"
          >
            {{
              regPageSetting?.reg_page_setting_detail?.[0]?.step_4_website_label
            }}
            <span class="text-red-500">*</span>
          </label>
          <input
            type="text"
            class="can-exp-input"
            :placeholder="
              regPageSetting?.reg_page_setting_detail?.[0]
                ?.step_4_website_placeholder
            "
            @input="
              handleInput($event.target.value, 'customer_profile_website');
              clearValidationError('customer_profile_website');
            "
            :value="
              form && form.has('customer_profile_website')
                ? form.get('customer_profile_website')
                : ''
            "
            id="customer_profile_website"
          />
          <Error
            fieldName="customer_profile_website"
            :validationErros="validationErros"
          />
        </div>
        
        <!-- CTA Button Field - Only show for Premium and Featured packages -->
        <div class="relative w-full mb-4" v-if="package_type && package_type.toLowerCase() !== 'free'">
          <label
            class="block text-gray-700 mb-1 text-base md:text-base lg:text-lg"
            for="cta_btn">CTA(Call-to-Action) Button
          <span class="ml-1 text-[0.85em] text-gray-600">(Max. 5 words)</span> 
          </label>
           
          <input
            type="text"
            class="can-exp-input"
            :placeholder="'The button text that guides the user\'s next action; e.g., Learn More.'"
            @input="
              handleInput($event.target.value, 'customer_profile_cta_btn');
              clearValidationError('customer_profile_cta_btn');
            "
            :value="
              form && form.has('customer_profile_cta_btn')
                ? form.get('customer_profile_cta_btn')
                : ''
            "
            id="customer_profile_cta_btn"
          />
          <Error
            fieldName="customer_profile_cta_btn"
            :validationErros="validationErros"
          />
        </div>
        
        <!-- CTA Link Field - Only show for Premium and Featured packages -->
        <div class="relative w-full mb-4" v-if="package_type && package_type.toLowerCase() !== 'free'">
          <label
            class="block text-gray-700 mb-1 text-base md:text-base lg:text-lg"
            for="cta_link"
          >
            {{
              regPageSetting?.reg_page_setting_detail?.[0]?.step_4_cta_link_label
            }}
          </label>
          <input
            type="text"
            class="can-exp-input"
            :placeholder="
              regPageSetting?.reg_page_setting_detail?.[0]
                ?.step_4_cta_link_placeholder
            "
            @input="
              handleInput($event.target.value, 'customer_profile_cta_link');
              clearValidationError('customer_profile_cta_link');
            "
            :value="
              form && form.has('customer_profile_cta_link')
                ? form.get('customer_profile_cta_link')
                : ''
            "
            id="customer_profile_cta_link"
          />
          <Error
            fieldName="customer_profile_cta_link"
            :validationErros="validationErros"
          />
        </div>

        <div class="relative w-full mb-4">
          <label
            class="block text-gray-700 mb-1 text-base md:text-base lg:text-lg"
            for="short-description"
          >
            {{
              regPageSetting?.reg_page_setting_detail?.[0]
                ?.step_4_short_description_label
            }}<span class="ml-1 text-[0.85em] text-gray-600">(Max. 30 words)</span> 
            <span class="text-red-500">*</span>
          </label>
          <textarea
            rows="3"
            class="can-exp-input"
            :placeholder="
              regPageSetting?.reg_page_setting_detail?.[0]
                ?.step_4_short_description_placeholder
            "
            @input="
              handleInput($event.target.value, 'customer_profile_short_description');
              clearValidationError('customer_profile_short_description');
              restrictToLength($event, 30, 'short')
            "
            :value="
              form && form.has('customer_profile_short_description')
                ? form.get('customer_profile_short_description')
                : ''
            "
            id="customer_profile_short_description"
          ></textarea>
          <Error
            fieldName="customer_profile_short_description"
            :validationErros="validationErros"
          />
        </div>

        <div class="relative w-full mb-4">
          <label
            class="block text-gray-700 mb-1 text-base md:text-base lg:text-lg"
            for="detailed-description"
          >
            {{
              regPageSetting?.reg_page_setting_detail?.[0]
                ?.step_4_description_label
            }}<span class="ml-1 text-[0.85em] text-gray-600">(Max. 300 words)</span> 
            <span class="text-red-500">*</span>
          </label>
          <textarea
            rows="6"
            class="can-exp-input"
            :placeholder="
              regPageSetting?.reg_page_setting_detail?.[0]
                ?.step_4_description_placeholder
            "
            @input="
              handleInput($event.target.value, 'customer_profile_description');
              clearValidationError('customer_profile_description');
              restrictToLength($event, 300, 'detailed')
            "
            :value="
              form && form.has('customer_profile_description')
                ? form.get('customer_profile_description')
                : ''
            "
            id="customer_profile_description"
          ></textarea>
          <Error
            fieldName="customer_profile_description"
            :validationErros="validationErros"
          />
        </div>

        <div class="relative w-full mb-4">
          <label
            class="block text-gray-700 mb-1 text-base md:text-base lg:text-lg"
            for="keywords"
          >
            {{
              regPageSetting?.reg_page_setting_detail?.[0]
                ?.step_4_keywords_label
            }}
            <span class="text-red-500"></span>
          </label>
          <textarea
            rows="3"
            class="can-exp-input"
            :placeholder="
              regPageSetting?.reg_page_setting_detail?.[0]
                ?.step_4_keywords_placeholder
            "
            @input="
              handleInput($event.target.value, 'customer_profile_keywords');
              clearValidationError('customer_profile_keywords');
              restrictToKeywords($event);
            "
            :value="
              form && form.has('customer_profile_keywords')
                ? form.get('customer_profile_keywords')
                : ''
            "
            id="customer_profile_keywords"
          ></textarea>
          <Error
            fieldName="customer_profile_keywords"
            :validationErros="validationErros"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
import Error from "./../components/Error.vue";

export default {
  components: {
    Error,
  },
  data() {
    return {
      general_setting: null,
      customer_profile_cta_btn: null,
    };
  },
  computed: {
    ...mapState({
      form: (state) => state.signup.form,
      regPageSetting: (state) => state.signup.regPageSetting,
      validationErros: (state) => state.signup.validationErros,
      package_type: (state) => state.signup.package_type, // Added package_type from Vuex
    }),
    isFormValid() {
      return (
        (this.package_type === 'free' || 
          (this.form.customer_profile_cta_btn && this.form.customer_profile_cta_btn.trim() !== '')) 
          &&
        this.form.terms_privacy_agreement === true
      );
    },
    ctaBtnLabelFormatted() {
      console.log("Computing CTA Button Label", this.regPageSetting);
      const rawLabel =
        this.regPageSetting?.reg_page_setting_detail?.[0]?.step_4_cta_btn_label || "";

      if (!rawLabel) {
        return "";
      }

      return rawLabel.replace(/\(5\)/g, '<sup class="footnote-indicator">(5)</sup>');
    },
  },
  created() {
    if (this.profile == "1") {
      let user = JSON.parse(this.user);

      this.updateForm(
        "customer_profile_address",
        user?.customer_profile?.address || ""
      );
      this.updateForm(
        "customer_profile_company_email",
        user?.customer_profile?.company_email || ""
      );
      this.updateForm(
        "customer_profile_company_name",
        user?.customer_profile?.company_name || ""
      );
      this.updateForm(
        "customer_profile_description",
        user?.customer_profile?.description || ""
      );
      this.updateForm(
        "customer_profile_keywords",
        user?.customer_profile?.keywords || ""
      );
      this.updateForm(
        "customer_profile_phone",
        user?.customer_profile?.phone || ""
      );
      this.updateForm(
        "customer_profile_short_description",
        user?.customer_profile?.short_description || ""
      );
      this.updateForm(
        "customer_profile_website",
        user?.customer_profile?.website || ""
      );
      this.updateForm(
        "customer_profile_cta_link",
        user?.customer_profile?.cta_link || ""
      );
      this.updateForm(
        "customer_profile_cta_btn",
        user?.customer_profile?.cta_btn || ""
      );
    }

    // Retrieve form data from localStorage
    const savedFormData = JSON.parse(localStorage.getItem("formData")) || {};
    for (const [field, value] of Object.entries(savedFormData)) {
      this.updateForm(field, value);
    }
  },
  methods: {
    handleMailingAddressInput(event) {
      this.restrictToLines(event, 5, "customer_profile_address");
    },
    clearMailingAddressError() {
      // Clear the mailing address error when user clicks away (blur event)
      this.clearValidationError("customer_profile_address");
      this.$store.commit("signup/removeValidationErros", { 
        field: ["customer_profile_address"] 
      });
    },
    restrictToKeywords(event, maxKeywords = 5, maxWordsPerKeyword = 10) {
      let inputValue = event.target.value;
      let keywordsArray = inputValue.split(/\s*,\s*/).filter(kw => kw.trim() !== "");

      if (keywordsArray.length > maxKeywords) {
        event.target.value = keywordsArray.slice(0, maxKeywords).join(", ");
        return;
      }

      let lastKeyword = keywordsArray[keywordsArray.length - 1] || "";
      let wordsArray = lastKeyword.split(/\s+/);

      if (wordsArray.length > maxWordsPerKeyword) {
        wordsArray = wordsArray.slice(0, maxWordsPerKeyword);
        keywordsArray[keywordsArray.length - 1] = wordsArray.join(" ");
        event.target.value = keywordsArray.join(", ") + ", ";

        setTimeout(() => {
          event.target.selectionStart = event.target.selectionEnd = event.target.value.length;
        }, 0);

        return;
      }

      this.updateForm("customer_profile_keywords", event.target.value);
    },
    restrictToLength(event, maxWords, fieldName) {
      const inputElement = event.target;
      let val = inputElement.value.trim();
      let words = val.split(/\s+/);

      if (words.length > maxWords) {
        const truncatedText = words.slice(0, maxWords).join(" ") + " ";
        this.form[fieldName] = truncatedText;

        setTimeout(() => {
          inputElement.value = truncatedText;
          inputElement.setSelectionRange(truncatedText.length, truncatedText.length);
        }, 0);

        event.preventDefault();
      } else {
        this.form[fieldName] = val;
      }
    },
    restrictToLines(event, maxLines, fieldName) {
      const inputElement = event.target;
      const rawValue = inputElement.value || "";
      const normalizedValue = rawValue.replace(/\r\n/g, "\n");
      const lines = normalizedValue.split(/\n/);

      if (lines.length > maxLines) {
        const truncatedValue = lines.slice(0, maxLines).join("\n");
        inputElement.value = truncatedValue;
        this.updateForm(fieldName, truncatedValue);

        const errorMessage = `Mailing Address must not contain more than ${maxLines} lines.`;

        this.$store.commit("signup/updateValidationErros", {
          field: fieldName,
          message: errorMessage,
        });

        return;
      }

      // Clear the error when within limits
      this.clearValidationError(fieldName);
      this.$store.commit("signup/removeValidationErros", { field: [fieldName] });
      this.updateForm(fieldName, rawValue);
    },
    updateForm(field, value) {
      this.$store.commit("signup/setForm", {
        field: [field],
        value: value,
      });
      this.$store.commit("signup/removeValidationErros", {
        field: [field],
      });

      const formData = JSON.parse(localStorage.getItem("formData")) || {};
      formData[field] = value;
      localStorage.setItem("formData", JSON.stringify(formData));
    },
    handleInput(value, fieldName) {
      this.updateForm(fieldName, value);
    },
    clearValidationError(field) {
      this.$store.commit("signup/removeValidationError", field);
    },
    restrictToNumbers(event, allowedLength) {
      const keyCode = event.which ? event.which : event.keyCode;
      const inputChar = String.fromCharCode(keyCode);
      const valid = /^\d$|^[\+\-\(\)]$/.test(inputChar);
      const maxLengthReached = event.target.value.length >= allowedLength;

      if (!valid || maxLengthReached) {
        event.preventDefault();
      }
      return true;
    },
    updateBussinessProfile() {
      this.$store.dispatch("signup/updateBussinessProfile")
        .then((res) => {
          if (res.data.status == "Success") {
            localStorage.removeItem("formData");
            window.location.href = res.data.data.redirect_url;
          }
        })
        .catch((errors) => {
          if (errors.response && errors.response.status == 422) {
            this.focusOnFirstErrorInput(errors.response.data.errors);
          }
        });
    },
    checkIsEmailValid(val) {
      if (val == "") {
        return;
      }
      this.$store
        .dispatch("signup/checkCustomerProfileEmail", {
          customer_profile_company_email: val,
        })
        .then((res) => console.log(res));
    },
  },
  props: ["profile", "user", "page_id"],
};
</script>

<style scoped>
.footnote-indicator {
  font-size: 0.75em;
  vertical-align: super;
  line-height: 1;
}
</style>