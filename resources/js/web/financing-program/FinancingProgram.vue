<template>
  <form class="lg:w-full" id="contact-us-form" @submit.prevent="recaptcha()">
    <div class="my-4">
      <div class="grid mt-4 md:grid-cols-2 gap-4">
        <div class="relative w-full mb-3">
          <label
            class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg"
            for="business_name"
            >{{ JSON.parse(financing_program)["business_name_label"] }}
            <span class="text-red-500">*</span>
          </label>
          <input
           @input="clearErrors('business_name')"
            type="text"
            class="can-exp-input"
            :placeholder="JSON.parse(financing_program)['business_name_placeholder']"
            id="business_name"
            v-model="form.business_name"
          />
          <Error v-if="submitted" fieldName="business_name" :validationErros="validationErros" />
        </div>
        <div class="relative w-full mb-3">
          <label
            class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg"
            for="name_title"
            >{{ JSON.parse(financing_program)["name_title_label"] }}
            <span class="text-red-500">*</span>
          </label>
          <input
           @input="clearErrors('name_title')"
            type="text"
            class="can-exp-input"
            :placeholder="JSON.parse(financing_program)['name_title_placeholder']"
            id="name_title"
            v-model="form.name_title"
          />
          <Error v-if="submitted" fieldName="name_title" :validationErros="validationErros" />
        </div>
        <div class="relative w-full mb-3">
          <label
            class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg"
            for="email"
            >{{ JSON.parse(financing_program)["email_label"] }}
            <span class="text-red-500">*</span>
          </label>
          <input
           @input="clearErrors('email')"
            type="text"
            class="can-exp-input"
            :placeholder="JSON.parse(financing_program)['email_placeholder']"
            id="email"
            v-model="form.email"
          />
          <Error v-if="submitted" fieldName="email" :validationErros="validationErros" />
        </div>
        <div class="relative w-full mb-3">
          <label
            class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg"
            for="zipcode"
            >{{ JSON.parse(financing_program)["zipcode_label"] }}
            <span class="text-red-500">*</span>
          </label>
          <input
           @input="clearErrors('zipcode')"
            type="text"
            class="can-exp-input"
            :placeholder="JSON.parse(financing_program)['zipcode_placeholder']"
            id="zipcode"
            v-model="form.zipcode"
          />
          <Error v-if="submitted" fieldName="zipcode" :validationErros="validationErros" />
        </div>

        <div class="relative w-full mb-3">
          <label
            class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg"
            for="incorporation"
            >{{ JSON.parse(financing_program)["incorporation_label"] }}
            <span class="text-red-500">*</span>
          </label>
          <input
           @input="clearErrors('incorporation')"
            type="text"
            class="can-exp-input"
            :placeholder="JSON.parse(financing_program)['incorporation_placeholder']"
            id="incorporation"
            v-model="form.incorporation"
          />
          <Error v-if="submitted" fieldName="incorporation" :validationErros="validationErros" />
        </div>
        <div class="relative w-full mb-3">
          <label
            class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg"
            for="full_time_employees"
            >{{ JSON.parse(financing_program)["full_time_employees_label"] }}
            <span class="text-red-500">*</span>
          </label>
          <input
           @input="clearErrors('full_time_employees')"
            type="text"
            class="can-exp-input"
            :placeholder="JSON.parse(financing_program)['full_time_employees_placeholder']"
            id="full_time_employees"
            v-model="form.full_time_employees"
          />
          <Error v-if="submitted" fieldName="full_time_employees" :validationErros="validationErros" />
        </div>
        <div class="relative w-full mb-3">
          <label
            class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg"
            for="revenue_last_year"
            >{{ JSON.parse(financing_program)["revenue_last_year_label"] }}
            <span class="text-red-500">*</span>
          </label>
          <input
           @input="clearErrors('revenue_last_year')"
            type="text"
            class="can-exp-input"
            :placeholder="JSON.parse(financing_program)['revenue_last_year_placeholder']"
            id="revenue_last_year"
            v-model="form.revenue_last_year"
          />
          <Error v-if="submitted" fieldName="revenue_last_year" :validationErros="validationErros" />
        </div>
        <div class="relative w-full mb-3">
          <label
            class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg"
            for="company_ownership"
            >{{ JSON.parse(financing_program)["company_ownership_label"] }}
            <span class="text-red-500">*</span>
          </label>
          <input
           @input="clearErrors('company_ownership')"
            type="text"
            class="can-exp-input"
            :placeholder="JSON.parse(financing_program)['company_ownership_placeholder']"
            id="company_ownership"
            v-model="form.company_ownership"
          />
          <Error v-if="submitted" fieldName="company_ownership" :validationErros="validationErros" />
        </div>
        <div class="relative w-full mb-3">
  <label
    class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg"
    for="needs_intentions"
  >
    {{ JSON.parse(financing_program)["needs_intentions_label"] }}
    <span class="text-red-500">*</span>
  </label>
  <input
    @input="clearErrors('needs_intentions'); limitWords($event)"
    type="text"
    class="can-exp-input"
    :placeholder="JSON.parse(financing_program)['needs_intentions_placeholder']"
    id="needs_intentions"
    v-model="form.needs_intentions"
  />
  <Error v-if="submitted" fieldName="needs_intentions" :validationErros="validationErros" />
</div>
        <!-- <div class="relative w-full mb-3">
          <label
            class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg"
            for="primary_industry"
            >{{ JSON.parse(financing_program)["primary_industry_label"] }}
            <span class="text-red-500">*</span>
          </label>
          <input
           @input="clearErrors('primary_industry')"
            type="text"
            class="can-exp-input"
            :placeholder="JSON.parse(financing_program)['primary_industry_placeholder']"
            id="primary_industry"
            v-model="form.primary_industry"
          />
          <Error v-if="submitted" fieldName="primary_industry" :validationErros="validationErros" />
        </div> -->
        <div class="relative w-full mb-3">
    <label
      class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg"
      for="primary_industry"
    >
      {{ JSON.parse(financing_program)["primary_industry_label"] }}
      <span class="text-red-500">*</span>
    </label>
    <multiselect
      v-model="form.primary_industry"
      :options="businessCategories"
      :multiple="true"
      :close-on-select="false"
      track-by="id"
      label="category_name"
      :placeholder="JSON.parse(financing_program)['primary_industry_placeholder']"
      @input="clearErrors('primary_industry')"
      @select="limitSelection"
      :showLabels="false"
      class="js-example-basic-multiple appearance-none w-full can-exp-input pr-8 category-options"
      id="primary_industry"
    ></multiselect>

    <Error v-if="submitted" fieldName="primary_industry" :validationErros="validationErros" />
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
        {{ JSON.parse(financing_program)["submit_button_text"] }}
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
import Error from "./../components/Error.vue";
// import ListErrors from "./../components/ListErrors.vue";
import axios from "axios";
import ErrorHandling from "../../ErrorHandling";
import Multiselect from "vue-multiselect";
export default {
  props: ["financing_program", "submit_url", "page_id"],
  components: {
    Error,
    // ListErrors,
    Multiselect,
  },
  data() {
    return {
      form: {
        business_name: "",
        name_title: "",
        zipcode: "",
        incorporation: "",
        full_time_employees: "",
        revenue_last_year: "",
        company_ownership: "",
        needs_intentions: "",
        primary_industry: "",
        page_id: "",
        primary_industry: [],
      },
      businessCategories: [],
      loading: false,
      validationErros: new ErrorHandling(),
      reCAPTCHA_site_key: process.env.MIX_reCAPTCHA_site_key,
      submitted: false,
    };
  },
  mounted() {
    this.fetchBusinessCategories();
    this.loadFormData(); // Fetch the categories when component is mounted
  },
  watch: {
    // Watch for changes in form fields and save them to localStorage
    form: {
      handler(newValue) {
        localStorage.setItem("formData", JSON.stringify(newValue));
      },
      deep: true, // Ensure deep watching for nested objects/arrays
    },
  },
  methods: {
    loadFormData() {
      const savedFormData = localStorage.getItem("formData");
      if (savedFormData) {
        this.form = JSON.parse(savedFormData);
      }
    },
    limitSelection(selectedOption) {
    if (this.form.primary_industry.length > 3) {
      this.form.primary_industry.pop(); // Last selected option hata dega
    }
  },
    fetchBusinessCategories() {
  const apiUrl = `${process.env.MIX_WEB_API_URL}business-categories`; // Use the environment variable
  axios.get(apiUrl) // API endpoint to fetch business categories
    .then(response => {
      this.businessCategories = response.data;
    })
    .catch(error => {
      console.error("Error fetching business categories:", error);
    });
},
limitWords(event) {
  const inputElement = event.target;
  let val = inputElement.value;
  let words = val.trim().split(/\s+/);

  if (words.length > 100) {
    // Get only the first 100 words and add a trailing space
    const truncatedText = words.slice(0, 100).join(" ") + " ";

    // Prevent input field from updating beyond limit
    this.form.needs_intentions = truncatedText;

    setTimeout(() => {
      inputElement.value = truncatedText;
      inputElement.setSelectionRange(truncatedText.length, truncatedText.length);
    }, 0);
  } else {
    this.form.needs_intentions = val; // Allow normal updates within limit
  }
},
    clearErrors(fieldName) {
            if (this.submitted) {
                this.validationErros.clear(fieldName);
            }
        },
    clearForm() {
      this.form["name_title"] = "";
      this.form["business_name"] = "";
      this.form["zipcode"] = "";
      this.form["incorporation"] = "";
      this.form["full_time_employees"] = "";
      this.form["revenue_last_year"] = "";
      this.form["company_ownership"] = "";
      this.form["needs_intentions"] = "";
      this.form["primary_industry"] = "";
      this.validationErros = new ErrorHandling();
      localStorage.removeItem("formData");
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
            this.validationErros.record(error.response.data.errors);
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
<style scoped>
@import "~vue-multiselect/dist/vue-multiselect.min.css"; /* Import the Multiselect styles */

</style>
