<template>
  <form class="lg:w-full" id="contact-us-form" @submit.prevent="recaptcha()">
    <div class="my-4">
      <div class="grid mt-4 md:grid-cols-2 gap-4">
        <div class="relative w-full mb-3">
          <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="name">
            {{ JSON.parse(close_account_setting)["name_label"] }}
            <span class="text-red-500">*</span>
          </label>
          <input 
            @input="clearErrors('name')" 
            type="text" 
            class="can-exp-input" 
            :placeholder="JSON.parse(close_account_setting)['name_placeholder']"
            id="name" 
            v-model="form.name" 
          />
          <Error v-if="submitted" fieldName="name" :validationErros="validationErros" />
        </div>

        <div class="relative w-full mb-3">
          <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="email">
            {{ JSON.parse(close_account_setting)["email_label"] }}
            <span class="text-red-500">*</span>
          </label>
          <input 
            @input="clearErrors('email')" 
            type="text" 
            class="can-exp-input" 
            :placeholder="JSON.parse(close_account_setting)['email_placeholder']"
            id="email" 
            v-model="form.email" 
          />
          <Error v-if="submitted" fieldName="email" :validationErros="validationErros" />
        </div>

        <div class="relative w-full mb-3 col-span-2">
          <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="message">
            {{ JSON.parse(close_account_setting)["message_label"] }}
            <span class="text-red-500">*</span>
          </label>
          <textarea 
            @input="clearErrors('message')" 
            rows="5" 
            type="text" 
            class="can-exp-input" 
            :placeholder="JSON.parse(close_account_setting)['message_placeholder']"
            id="message" 
            v-model="form.message">
          </textarea>
          <Error v-if="submitted" fieldName="message" :validationErros="validationErros" />
        </div>
      </div>
    </div>
    
    <Error v-if="submitted" fieldName="captcha" :validationErros="validationErros" />
    
    <div class="mt-8 flex justify-center items-center">
      <button 
        aria-label="Canadian Exporters" 
        :class="[
          'button-exp-fill cursor-pointer transition-opacity',
          { 'opacity-40 cursor-not-allowed': !isFormValid, 'opacity-100': isFormValid }
        ]"
        type="button" 
        id="send-message"
        :disabled="!isFormValid || loading"
        @click.prevent="displayDeleteProfile"
      >
        {{ JSON.parse(close_account_setting) ? JSON.parse(close_account_setting)["button_text"] : "" }}
      </button>
    </div>

    <div v-if="loading">
      <div id="form_preloader">
        <div id="form_status">
          <div class="form_spinner">
            <div class="form-double-bounce1"></div>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
import { load } from "recaptcha-v3";
import Error from "../components/Error.vue";
import axios from "axios";
import swal from "sweetalert2";
import ErrorHandling from "../../ErrorHandling";

export default {
  props: ["close_account_setting", "submit_url", "page_id", "popup_setting"],
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
    };
  },
  computed: {
    isFormValid() {
      return (
        this.form.name.trim() !== "" &&
        this.form.email.trim() !== "" &&
        this.form.message.trim() !== ""
      );
    },
  },
  methods: {
    displayDeleteProfile() {
      // Validate form before showing popup
      if (!this.isFormValid) {
        this.submitted = true;
        this.validationErros.record({
          name: this.form.name.trim() === "" ? ["Name is required"] : [],
          email: this.form.email.trim() === "" ? ["Email is required"] : [],
          message: this.form.message.trim() === "" ? ["Message is required"] : [],
        });
        return;
      }

      swal.fire({
        title: this.popup_setting && JSON.parse(this.popup_setting) && JSON.parse(this.popup_setting)['message_30'] ? JSON.parse(this.popup_setting)['message_30'] : "Are you sure?",
        html: "<p class='text-center'>" + (this.popup_setting && JSON.parse(this.popup_setting) && JSON.parse(this.popup_setting)['message_31'] ? JSON.parse(this.popup_setting)['message_31'] : "Do you really want to close your account?") + "</p>",
        icon: "warning",
        buttonsStyling: false,
        customClass: {
          title: "swalSuccessClass",
          htmlContainer: "swalSuccessClass",
          confirmButton: 'button-exp-fill mr-2 hover:bg-blue-500 focus:outline-none',
          cancelButton: 'button-exp-no-fill bg-red-500 text-white hover:bg-red-400 border-none hover:text-white focus:outline-none',
        },
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: this.popup_setting && JSON.parse(this.popup_setting) && JSON.parse(this.popup_setting)['message_32'] ? JSON.parse(this.popup_setting)['message_32'] : "Yes, close it!",
        cancelButtonText: this.popup_setting && JSON.parse(this.popup_setting) && JSON.parse(this.popup_setting)['message_33'] ? JSON.parse(this.popup_setting)['message_33'] : "Cancel"
      }).then((result) => {
        if (result.isConfirmed) {
          this.deleteProfile();
        }
      });
    },

    deleteProfile() {
      this.loading = true;
      
      const formData = {
        name: this.form.name,
        email: this.form.email,
        message: this.form.message,
        page_id: this.page_id,
      };

      axios
        .post(this.submit_url, formData)
        .then((res) => {
          this.loading = false;
          
          if (res.data.status == "Success") {
            const redirectUrl = res.data && res.data.data ? res.data.data.redirect_url : "/";
            
            helper.swalSuccessMessageForWeb(res.data.message).then(() => {
              // Redirect to home page or specified URL
              window.location.href = redirectUrl;
            });
          } else {
            helper.swalErrorMessageForWeb(res.data.message);
          }
        })
        .catch((error) => {
          this.loading = false;
          
          const message =
            (error.response &&
              error.response.data &&
              error.response.data.message) ||
            "Something went wrong. Please try again.";
          
          helper.swalErrorMessageForWeb(message);
        });
    },

    clearErrors(fieldName) {
      if (this.submitted) {
        this.validationErros.clear(fieldName);
      }
    },

    clearForm() {
      this.form.name = "";
      this.form.email = "";
      this.form.message = "";
      this.validationErros = new ErrorHandling();
      this.submitted = false;
    },

    async recaptcha() {
      this.submitted = true;
      
      if (!this.isFormValid) {
        return;
      }

      this.loading = true;
      
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
                this.loading = false;
                this.validationErros.record({
                  captcha: [res.data.message],
                });
              }
            })
            .catch(() => {
              this.loading = false;
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
          
          if (res.data.status == "Success") {
            helper.swalPreSuccessMessageForWeb(res.data.message);
            this.clearForm();
          } else {
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
        });
    },
  },
};
</script>