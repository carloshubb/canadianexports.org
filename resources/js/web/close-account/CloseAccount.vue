<template>
  <form class="lg:w-full" id="contact-us-form" @submit.prevent="displayDeleteProfile">
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
          { 'opacity-40 cursor-not-allowed': !isFormValid || loading, 'opacity-100': isFormValid && !loading }
        ]"
        type="submit"
        id="send-message"
        :disabled="!isFormValid || loading"
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
    // Called when the user presses the submit button (or otherwise submits the form)
    displayDeleteProfile() {
      this.submitted = true;

      if (!this.isFormValid) {
        this.validationErros.record({
          name: this.form.name.trim() === "" ? ["Name is required"] : [],
          email: this.form.email.trim() === "" ? ["Email is required"] : [],
          message: this.form.message.trim() === "" ? ["Message is required"] : [],
        });
        return; // don't show confirmation if not valid
      }

      // Optional: If you want to block non-logged-in users here, add a guard like:
      // if (!this.$store?.state?.authUser) {
      //   swal.fire('Please login', 'You must be logged in to close your account', 'warning');
      //   return;
      // }

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
          // run recaptcha then delete on success
          this.recaptcha("delete");
        } else {
          // per request: after popup is closed (when user cancels), take them to Home
          window.location.href = "/";
        }
      });
    },

    deleteProfile() {
      // Set loading while we send
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
            
            // show success then redirect (helper returns a promise)
            helper.swalSuccessMessageForWeb(res.data.message).then(() => {
              window.location.href = redirectUrl;
            });
          } else {
            helper.swalErrorMessageForWeb(res.data.message);
            // After error popup close, send user home (you requested 'after popup closed, take user home')
            // If you prefer not to redirect on server error, remove the next line.
            window.location.href = "/";
          }
        })
        .catch((error) => {
          this.loading = false;
          
          const message =
            (error.response &&
              error.response.data &&
              error.response.data.message) ||
            "Something went wrong. Please try again.";
          
          helper.swalErrorMessageForWeb(message).then(() => {
            // after error popup closed, go to home (matches your request)
            window.location.href = "/";
          });
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

    /**
     * recaptcha(nextAction)
     * - nextAction: "save" (default) or "delete"
     *
     * On success of server-side verifyRecaptcha, will call saveForm() or deleteProfile()
     */
    async recaptcha(nextAction = "save") {
      this.submitted = true;

      if (!this.isFormValid) {
        return;
      }

      // start loading only when running captcha
      this.loading = true;
      
      try {
        const recaptcha = await load(process.env.MIX_reCAPTCHA_site_key);
        recaptcha.showBadge();

        const token = await recaptcha.execute("submit");
        // send token to API to verify
        const res = await axios.post(`${process.env.MIX_WEB_API_URL}verifyRecaptcha`, { token });

        // always hide badge after a short delay
        setTimeout(() => recaptcha.hideBadge(), 3000);

        if (res.data.status == "Success") {
          // on success, call the intended action
          if (nextAction === "delete") {
            // calls deleteProfile which will turn off loading on completion
            this.deleteProfile();
          } else {
            // default: call existing saveForm (contact-like)
            this.saveForm();
          }
        } else if (res.data.status == "Error") {
          this.loading = false;
          this.validationErros.record({ captcha: [res.data.message] });
        } else {
          // unknown response shape
          this.loading = false;
          this.validationErros.record({ captcha: ["reCAPTCHA verification failed"] });
        }
      } catch (err) {
        // network or recaptcha error
        this.loading = false;
        // optionally show the user an error
        // helper.swalErrorMessageForWeb('reCAPTCHA failed. Please try again.');
      }
    },

    saveForm() {
      // existing behavior retained for non-delete saves
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
