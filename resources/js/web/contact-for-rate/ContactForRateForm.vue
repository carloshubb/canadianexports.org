<template>
  <form class="lg:w-full" id="contact-us-form" @submit.prevent="recaptcha()">
    <div class="my-4">
      <div class="grid mt-4 md:grid-cols-2 gap-4">
        <div class="relative w-full mb-3">
          <label
            class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg"
            for="name"
            >{{ JSON.parse(contact_for_rate_setting)["name_label"] }}
            <span class="text-red-500">*</span>
          </label>
          <input
           @input="clearErrors('name')"
            type="text"
            class="can-exp-input"
            :placeholder="
              JSON.parse(contact_for_rate_setting)['name_placeholder']
            "
            id="name"
            v-model="form.name"
          />
          <Error v-if="submitted" fieldName="name" :validationErros="validationErros" />
        </div>
        <div class="relative w-full mb-3">
          <label
            class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg"
            for="business_name"
            >{{ JSON.parse(contact_for_rate_setting)["business_name_label"] }}
            <span class="text-red-500">*</span>
          </label>
          <input
           @input="clearErrors('business_name')"
            type="text"
            class="can-exp-input"
            :placeholder="
              JSON.parse(contact_for_rate_setting)['business_name_placeholder']
            "
            id="business_name"
            v-model="form.business_name"
          />
          <Error v-if="submitted" fieldName="business_name" :validationErros="validationErros" />
        </div>
        <div class="relative w-full mb-3">
          <label
            class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg"
            for="phone"
            >{{ JSON.parse(contact_for_rate_setting)["phone_label"] }}
            <span class="text-red-500">*</span>
          </label>
          <input
           @input="clearErrors('phone')"
            type="text"
            class="can-exp-input"
            :placeholder="
              JSON.parse(contact_for_rate_setting)['phone_placeholder']
            "
            id="phone"
            v-model="form.phone"
          />
          <Error v-if="submitted" fieldName="phone" :validationErros="validationErros" />
        </div>

        <div class="relative w-full mb-3">
          <label
            class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg"
            for="email"
            >{{ JSON.parse(contact_for_rate_setting)["email_label"] }}
            <span class="text-red-500">*</span>
          </label>
          <input
           @input="clearErrors('email')"
            type="text"
            class="can-exp-input"
            :placeholder="
              JSON.parse(contact_for_rate_setting)['email_placeholder']
            "
            id="email"
            v-model="form.email"
          />
          <Error v-if="submitted" fieldName="email" :validationErros="validationErros" />
        </div>
        <div class="relative w-full mb-3 col-span-2">
          <label
            class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg"
            for="message"
            >{{ JSON.parse(contact_for_rate_setting)["message_label"] }}
            <span class="text-red-500">*</span>
          </label>
          <textarea
           @input="clearErrors('message')"
            rows="5"
            type="text"
            class="can-exp-input"
            :placeholder="
              JSON.parse(contact_for_rate_setting)['message_placeholder']
            "
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
        {{ JSON.parse(contact_for_rate_setting)["button_text"] }}
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
import Error from "../components/Error.vue";
// import ListErrors from "../components/ListErrors.vue";
import axios from "axios";
import ErrorHandling from "../../ErrorHandling";
export default {
  props: ["contact_for_rate_setting", "submit_url", "page_id"],
  components: {
    Error,
    // ListErrors,
  },
  data() {
    return {
      form: {
        name: "",
        business_name: "",
        phone: "",
        email: "",
        message: "",
        page_id: "",
      },
      loading: false,
      validationErros: new ErrorHandling(),
      reCAPTCHA_site_key: process.env.MIX_reCAPTCHA_site_key,
      submitted: false,
    };
  },
  methods: {
    clearErrors(fieldName) {
            if (this.submitted) {
                this.validationErros.clear(fieldName);
            }
        },
    clearForm() {
      this.form["business_name"] = "";
      this.form["name"] = "";
      this.form["phone"] = "";
      this.form["email"] = "";
      this.form["message"] = "";
      this.validationErros = new ErrorHandling();
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
