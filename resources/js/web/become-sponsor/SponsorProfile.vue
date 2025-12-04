<template>
  <form class="lg:w-full" id="contact-us-form" @submit.prevent="recaptcha()">
    <!-- CONTACT INFORMATION -->
    <div class="bg-white rounded-lg overflow-hidden shadow-3xl my-6">
      <div class="px-4 py-3 sm:px-6 text-left bg-gradient-to-r from-primary via-primary to-secondary rounded-t-md">
        <h4 class="text-white">Contact Information</h4>
      </div>
      <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="relative w-full">
            <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="company_name">
              {{ JSON.parse(become_sponsor)["company_name_label"] }}
              <span class="text-red-500">*</span>
            </label>
            <input 
              type="text" 
              class="can-exp-input" 
              :placeholder="JSON.parse(become_sponsor)['company_name_placeholder']" 
              id="company_name" 
              v-model="form.company_name" 
              @input="clearErrors('company_name')" 
            />
            <Error v-if="submitted" fieldName="company_name" :validationErros="validationErros" />
          </div>

          <div class="relative w-full">
            <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="name">
              {{ JSON.parse(become_sponsor)["name_label"] }}
              <span class="text-red-500">*</span>
            </label>
            <input 
              type="text" 
              class="can-exp-input"
              :placeholder="JSON.parse(become_sponsor)['name_placeholder']" 
              id="name" 
              v-model="form.name"
              @input="clearErrors('name')"
            />
            <Error v-if="submitted" fieldName="name" :validationErros="validationErros" />
          </div>

          <div class="relative w-full">
            <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="email">
              {{ JSON.parse(become_sponsor)["email_label"] }}
              <span class="text-red-500">*</span>
            </label>
            <input 
              type="email" 
              class="can-exp-input" 
              :placeholder="JSON.parse(become_sponsor)['email_placeholder']"
              id="email" 
              v-model="form.email" 
              @input="clearErrors('email')" 
            />
            <Error v-if="submitted" fieldName="email" :validationErros="validationErros" />
          </div>

          <div class="relative w-full">
            <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="contact_number">
              {{ JSON.parse(become_sponsor)["contact_number_label"] }}
              <span class="text-red-500">*</span>
            </label>
            <input 
              type="text" 
              class="can-exp-input"
              :placeholder="JSON.parse(become_sponsor)['contact_number_placeholder']" 
              id="contact_number"
              v-model="form.contact_number" 
              @input="clearErrors('contact_number')" 
            />
            <Error v-if="submitted" fieldName="contact_number" :validationErros="validationErros" />
          </div>

          <div class="relative w-full">
            <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="url">
              {{ JSON.parse(become_sponsor)["url_label"] }}
              <span class="text-red-500">*</span>
            </label>
            <input 
              type="url" 
              class="can-exp-input" 
              :placeholder="JSON.parse(become_sponsor)['url_placeholder']" 
              id="url"
              v-model="form.url" 
              @input="clearErrors('url')" 
            />
            <Error v-if="submitted" fieldName="url" :validationErros="validationErros" />
          </div>
        </div>
      </div>
    </div>

    <!-- APPOINTMENT PREFERENCES -->
    <div class="bg-white rounded-lg overflow-hidden shadow-3xl my-6">
      <div class="px-4 py-3 sm:px-6 text-left bg-gradient-to-r from-primary via-primary to-secondary rounded-t-md">
        <h4 class="text-white">Appointment Preferences</h4>
      </div>
      <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="relative w-full">
            <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="appointment">
              {{ JSON.parse(become_sponsor)["appointment_label"] }}
            </label>
            <select 
              id="appointment" 
              class="can-exp-input w-full block border border-gray-300 rounded"
              v-model="form.appointment"
              @change="clearErrors('appointment')"
            >
              <option value="yes" :selected="form.appointment === 'yes'">
                {{ JSON.parse(become_sponsor)["appointment_yes_option"] }}
              </option>
              <option value="no" :selected="form.appointment === 'no'">
                {{ JSON.parse(become_sponsor)["appointment_no_option"] }}
              </option>
            </select>
            <Error v-if="submitted" fieldName="appointment" :validationErros="validationErros" />
          </div>

          <div class="relative w-full" v-if="form.appointment == 'yes'">
            <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="time_to_call">
              {{ JSON.parse(become_sponsor)["time_to_call_label"] }}
            </label>
            <select 
              id="time_to_call" 
              class="can-exp-input w-full block border border-gray-300 rounded"
              v-model="form.time_to_call"
              @change="clearErrors('time_to_call')"
            >
              <option value="am" :selected="form.time_to_call == 'am'">
                {{ JSON.parse(become_sponsor)["time_to_call_am_label"] }}
              </option>
              <option value="pm" :selected="form.time_to_call == 'pm'">
                {{ JSON.parse(become_sponsor)["time_to_call_pm_label"] }}
              </option>
            </select>
            <Error v-if="submitted" fieldName="time_to_call" :validationErros="validationErros" />
          </div>

          <div class="relative w-full" v-if="form.appointment == 'yes'">
            <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="appointment_date">
              {{ JSON.parse(become_sponsor)["appointment_date_label"] }}
              <span class="text-red-500">*</span>
            </label>
            <input 
              type="date" 
              class="can-exp-input"
              :placeholder="JSON.parse(become_sponsor)['appointment_date_placeholder']" 
              id="appointment_date"
              v-model="form.appointment_date" 
              @input="clearErrors('appointment_date')" 
            />
            <Error v-if="submitted" fieldName="appointment_date" :validationErros="validationErros" />
          </div>
        </div>
      </div>
    </div>

    <!-- COMPANY MEDIA -->
    <div class="bg-white rounded-lg overflow-hidden shadow-3xl my-6">
      <div class="px-4 py-3 sm:px-6 text-left bg-gradient-to-r from-primary via-primary to-secondary rounded-t-md">
        <h4 class="text-white">Company Media</h4>
      </div>
      <div class="p-6">
        <div class="grid grid-cols-1 gap-4">
          <div class="relative w-full">
            <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="image">
              {{ JSON.parse(become_sponsor)["image_label"] }}
              <span class="text-sm text-gray-500">- Max 5MB, PNG/JPG/JPEG/GIF</span>
            </label>
            <FilePond 
              @input="clearErrors('image')" 
              ref="filePond" 
              :labelIdle="`<span class='cursor-pointer'>${JSON.parse(become_sponsor)['image_placeholder']}</span>`" 
              class="cursor-pointer" 
              name="image" 
              accepted-file-types="image/*"
              max-file-size="5MB"
              @init="handleFilePondInit" 
              @processfile="handleFilePondFlagIconProcess"
              @removefile="handleFilePondFlagIconRemoveFile" 
              :files="image_path" 
            />
            <Error v-if="submitted" fieldName="image" :validationErros="validationErros" />
          </div>

          <div class="relative w-full">
            <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="feature_image">
              {{ JSON.parse(become_sponsor)["feature_image_label"] }}
              <span class="text-sm text-gray-500">- Max 5MB, PNG/JPG/JPEG/GIF</span>
            </label>
            <FilePond 
              @input="clearErrors('feature_image')" 
              ref="filePond2" 
              :labelIdle="`<span class='cursor-pointer'>${JSON.parse(become_sponsor)['image_placeholder']}</span>`" 
              class="cursor-pointer" 
              name="feature_image" 
              accepted-file-types="image/*"
              max-file-size="5MB"
              :files="image_path_2" 
              @init="handleImagePath2Init"
              @processfile="handleImagePath2Process" 
              @removefile="handleImagePath2RemoveFile" 
            />
            <Error v-if="submitted" fieldName="feature_image" :validationErros="validationErros" />
          </div>
        </div>
      </div>
    </div>

    <!-- COMPANY DESCRIPTION -->
    <div class="bg-white rounded-lg overflow-hidden shadow-3xl my-6">
      <div class="px-4 py-3 sm:px-6 text-left bg-gradient-to-r from-primary via-primary to-secondary rounded-t-md">
        <h4 class="text-white">Company Description</h4>
      </div>
      <div class="p-6">
        <div class="grid grid-cols-1 gap-4">
          <div class="relative w-full">
            <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="summary">
              {{ JSON.parse(become_sponsor)["summary_label"] }}
              <span class="text-red-500">*</span>
            </label>
            <textarea 
              @input="clearErrors('summary')" 
              rows="3" 
              class="can-exp-input resize-none"
              :placeholder="JSON.parse(become_sponsor)['summary_placeholder']" 
              id="summary"
              v-model="form.summary"
            ></textarea>
            <Error v-if="submitted" fieldName="summary" :validationErros="validationErros" />
          </div>

          <div class="relative w-full">
            <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="detail_description">
              {{ JSON.parse(become_sponsor)["detail_description_label"] }}
              <span class="text-red-500">*</span>
            </label>
            <textarea 
              @input="clearErrors('detail_description')" 
              rows="5" 
              class="can-exp-input resize-none" 
              :placeholder="JSON.parse(become_sponsor)['detail_description_placeholder']" 
              id="detail_description" 
              v-model="form.detail_description"
            ></textarea>
            <Error v-if="submitted" fieldName="detail_description" :validationErros="validationErros" />
          </div>

          <div class="relative w-full">
            <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="message">
              {{ JSON.parse(become_sponsor)["message_label"] }}
              <span class="text-red-500">*</span>
            </label>
            <textarea 
              @input="clearErrors('message')" 
              rows="3" 
              class="can-exp-input resize-none" 
              :placeholder="JSON.parse(become_sponsor)['message_placeholder']" 
              id="message" 
              v-model="form.message"
            ></textarea>
            <Error v-if="submitted" fieldName="message" :validationErros="validationErros" />
          </div>
        </div>
      </div>
    </div>

    <!-- SUBMIT BUTTON -->
    <Error v-if="submitted" fieldName="captcha" :validationErros="validationErros" />
    <ListErrors :validationErrors="validationErros" />
    <div class="mt-8 flex justify-center items-center">
      <button 
        aria-label="Submit Sponsor Profile" 
        class="button-exp-fill text-lg px-8 py-3" 
        type="submit" 
        id="send-message"
        :disabled="loading"
      >
        <span v-if="loading" class="flex items-center">
          <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          Processing...
        </span>
        <span v-else>
          {{ JSON.parse(become_sponsor)["submit_btn_text"] }}
        </span>
      </button>
    </div>

    <!-- Loading Overlay -->
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
import ListErrors from "./../components/ListErrors.vue";
import axios from "axios";
import ErrorHandling from "../../ErrorHandling";
// Import filepond
import vueFilePond, { setOptions } from "vue-filepond";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js";
import FilePondPluginImagePreview from "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js";
import FilePondPluginFileValidateSize from "filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.esm.js";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview,
  FilePondPluginFileValidateSize
);
export default {
  props: ["become_sponsor", "submit_url", "page_id", "user", "sponsor"],
  components: {
    Error,
    ListErrors,
    FilePond,
  },
  data() {
    return {
      form: {
        id: "",
        name: "",
        company_name: "",
        email: "",
        summary: "",
        detail_description: "",
        url: "",
        image: "",
        feature_image: "",
        page_id: "",
      },
      image_path_2: [],
      image_path: [],
      images: {
        image_path_2: null,
        image_path: null,
      },
      loading: false,
      validationErros: new ErrorHandling(),
      reCAPTCHA_site_key: process.env.MIX_reCAPTCHA_site_key,
      submitted: false,
    };
  },
  mounted() {
    // Load form data from localStorage
    const savedForm = localStorage.getItem("become_sponsor_form");
    if (savedForm) {
      this.form = JSON.parse(savedForm);
    }
  },
  watch: {
    form: {
      handler(newForm) {
        // Save form data to localStorage on change
        localStorage.setItem("become_sponsor_form", JSON.stringify(newForm));
      },
      deep: true,
    },
  },
  created() {
    let user = JSON.parse(this.user);
    let sponsor = JSON.parse(this.sponsor);
    console.log(user);
    console.log(sponsor);
    if (user) {
      this.form.name = user.name || "";
      this.form.email = user.email || "";
    }
    if (sponsor) {
      this.form.id = sponsor.id || "";
      this.form.company_name = sponsor.business_name || "";
      this.form.detail_description = this.stripHTML(sponsor.detail_description || "");
      this.form.summary = this.stripHTML(sponsor.small_business_description || "");
      this.form.contact_number = this.stripHTML(sponsor.contact_number || "");
      this.form.time_to_call = this.stripHTML(sponsor.time_to_call || "");
      this.form.appointment = this.stripHTML(sponsor.appointment || "");
      this.form.appointment_date = this.stripHTML(sponsor.appointment_date || "");
      this.form.message = this.stripHTML(sponsor.message || "");
      this.form.url = sponsor.url || "";
    }
  },
  methods: {
    stripHTML(html) {
      return html.replace(/<[^>]*>/g, "").trim(); // HTML tags remove
    },
    clearErrors(fieldName) {
      if (this.submitted) {
        this.validationErros.clear(fieldName);
      }
    },
    clearForm() {
      this.form["id"] = "";
      this.form["name"] = "";
      this.form["company_name"] = "";
      this.form["email"] = "";
      this.form["summary"] = "";
      this.form["detail_description"] = "";
      this.form["appointment_date"] = "";
      this.form["contact_number"] = "";
      this.form["time_to_call"] = "";
      this.form["appointment"] = "";
      this.form["message"] = "";
      this.form["url"] = "";
      this.form["image"] = "";
      this.form["feature_image"] = "";
      this.image_path_2 = [];
      this.images.image_path_2 = null;
      this.image_path = [];
      this.images.image_path = null;
      if (this.$refs.filePond) this.$refs.filePond.removeFiles();
      if (this.$refs.filePond2) this.$refs.filePond2.removeFiles();
      this.validationErros = new ErrorHandling();
      localStorage.removeItem("become_sponsor_form");
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
      this.image = this.images.image_path;
      this.feature_image = this.images.image_path_2;
      this.form.page_id = this.page_id;
      axios
        .post(this.submit_url, this.form)
        .then((res) => {
          this.loading = 0;
          if (res.data.status == "Success") {
            helper.swalSuccessMessageForWeb(res.data.message);
          } else {
            helper.swalErrorMessageForWeb(res.data.message);
          }
        })
        .catch((error) => {
          this.loading = 0;
          this.validationErros = new ErrorHandling();
          if (error.response && error.response.status == 422) {
            this.validationErros.record(error.response.data.errors);
            // scroll point
            this.scrollToFirstError();
          } else if (
            error.response &&
            error.response.data &&
            error.response.data.status == "Error"
          ) {
            helper.swalErrorMessageForWeb(error.response.data.message);
          }
        });
    },
    scrollToFirstError() {
      // Find the first field that has a validation error
      const firstErrorField = Object.keys(this.validationErros.errors)[0];
      if (firstErrorField) {
        const field = document.getElementById(firstErrorField);
        if (field) {
          // Scroll to the field and focus on it
          field.scrollIntoView({ behavior: "smooth", block: "center" });
          field.focus();
        }
      }
    },
    handleImagePath2Init() {
      setOptions({
        credits: false,
        server: {
          url: process.env.MIX_ADMIN_API_URL,
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
            formData.append("type", "pages");

            const request = new XMLHttpRequest();
            request.open(
              "POST",
              `${process.env.MIX_ADMIN_API_URL}media/process`
            );
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
            request.open(
              "POST",
              `${process.env.MIX_ADMIN_API_URL}media/revert`
            );
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
    handleImagePath2Process(error, file) {
      this.images.image_path_2 = file.serverId;
    },
    handleImagePath2RemoveFile(error, file) {
      this.images.image_path_2 = null;
    },
    convertImagePath2ImgUrlToBase64(url, type) {
      var image = new Image();
      let vm = this;
      image.onload = function () {
        var canvas = document.createElement("canvas");
        canvas.width = image.width;
        canvas.height = image.height;

        canvas.getContext("2d").drawImage(this, 0, 0);

        canvas.toBlob(
          function (source) {
            var newImg = document.createElement("img"),
              url = URL.createObjectURL(source);

            newImg.onload = function () {
              URL.revokeObjectURL(url);
            };

            newImg.src = url;
          },
          type,
          1
        );
        let dataUrl = canvas.toDataURL(type);
        let files = [
          {
            source: dataUrl,
            options: {
              type: "local",
            },
          },
        ];
        // setOptions({files:files});
        vm.image_path_2 = files;
      };
      image.src = url;
    },
    handleFilePondInit() {
      setOptions({
        credits: false,
        server: {
          url: process.env.MIX_ADMIN_API_URL,
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
            formData.append("type", "image_path");

            const request = new XMLHttpRequest();
            request.open(
              "POST",
              `${process.env.MIX_ADMIN_API_URL}media/process`
            );
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
            request.open(
              "POST",
              `${process.env.MIX_ADMIN_API_URL}media/revert`
            );
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
    handleFilePondFlagIconProcess(error, file) {
      this.images.image_path = file.serverId;
    },
    handleFilePondFlagIconRemoveFile(error, file) {
      this.images.image_path = null;
    },
    convertImgUrlToBase64(url, type) {
      var image = new Image();
      let vm = this;
      image.onload = function () {
        var canvas = document.createElement("canvas");
        canvas.width = image.width;
        canvas.height = image.height;

        canvas.getContext("2d").drawImage(this, 0, 0);

        canvas.toBlob(
          function (source) {
            var newImg = document.createElement("img"),
              url = URL.createObjectURL(source);

            newImg.onload = function () {
              URL.revokeObjectURL(url);
            };

            newImg.src = url;
          },
          type,
          1
        );
        let dataUrl = canvas.toDataURL(type);
        let files = [
          {
            source: dataUrl,
            options: {
              type: "local",
            },
          },
        ];
        // setOptions({files:files});
        vm.image_path = files;
      };
      image.src = url;
    },
    restrictToNumbers(event, allowedLength) {
      const keyCode = event.which ? event.which : event.keyCode;
      const inputChar = String.fromCharCode(keyCode);
      const valid = /^\d$|^[\+\-\(\)]$/.test(inputChar); // Check if the character is a digit, +, -, (, or )
      const maxLengthReached = event.target.value.length >= allowedLength;

      if (!valid || maxLengthReached) {
        event.preventDefault();
      }
      return true;
    },
  },
};
</script>
<style scoped>
/* Loading overlay styles */
#form_preloader {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 9999;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
}

#form_status {
  width: 200px;
  height: 200px;
  position: relative;
}

.form_spinner {
  width: 60px;
  height: 60px;
  position: relative;
  margin: 70px auto;
}

.form-double-bounce1,
.form-double-bounce2 {
  width: 100%;
  height: 100%;
  border-radius: 50%;
  background-color: #fff;
  opacity: 0.6;
  position: absolute;
  top: 0;
  left: 0;
  animation: sk-bounce 2s infinite ease-in-out;
}

.form-double-bounce2 {
  animation-delay: -1s;
}

@keyframes sk-bounce {
  0%,
  100% {
    transform: scale(0);
  }
  50% {
    transform: scale(1);
  }
}

/**
 * FilePond Custom Styles
 */
.filepond--drop-label {
  color: #4c4e53;
}

.filepond--label-action {
  text-decoration-color: #babdc0;
}

.filepond--panel-root {
  border-radius: 2em;
  background-color: #edf0f4;
  height: 1em;
}

.filepond--item-panel {
  background-color: #595e68;
}

.filepond--drip-blob {
  background-color: #7f8a9a;
}
</style>
