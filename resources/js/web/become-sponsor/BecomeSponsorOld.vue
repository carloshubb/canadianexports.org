<template>
  <form class="lg:w-full" id="contact-us-form" @submit.prevent="recaptcha()">
    <div class="my-4">
      <div class="grid mt-4 md:grid-cols-2 gap-4">
        <div class="relative w-full mb-3">
          <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="company_name">{{
            JSON.parse(become_sponsor)["company_name_label"] }}
            <span class="text-red-500">*</span>
          </label>
          <input type="text" class="can-exp-input" :placeholder="JSON.parse(become_sponsor)['company_name_placeholder']
            " id="company_name" v-model="form.company_name" @input="clearErrors('company_name')" />
          <Error v-if="submitted" fieldName="company_name" :validationErros="validationErros" />
        </div>

        <div class="relative w-full mb-3">
          <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="name">{{
            JSON.parse(become_sponsor)["name_label"] }}
            <span class="text-red-500">*</span>
          </label>
          <textarea rows="2" class="can-exp-input resize-none"
            :placeholder="JSON.parse(become_sponsor)['name_placeholder']" id="name" v-model="form.name"
            @input="clearErrors('name')"></textarea>
          <Error v-if="submitted" fieldName="name" :validationErros="validationErros" />
        </div>

        <!-- <div class="relative w-full mb-3">
                    <label
                        class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg"
                        for="email"
                        >{{ JSON.parse(become_sponsor)["email_label"] }}
                        <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        class="can-exp-input"
                        placeholder=""
                        id="email"
                        v-model="form.email"
                    />
                    <Error
                        fieldName="email"
                        :validationErros="validationErros"
                    />
                </div> -->
        <div class="relative w-full mb-3">
          <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="email">{{
            JSON.parse(become_sponsor)["email_label"] }}
            <span class="text-red-500">*</span>
          </label>
          <input type="text" class="can-exp-input" :placeholder="JSON.parse(become_sponsor)['email_placeholder']"
            id="email" v-model="form.email" @input="clearErrors('email')" />
          <Error v-if="submitted" fieldName="email" :validationErros="validationErros" />
        </div>
        <div class="relative w-full">
          <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="url">{{
            JSON.parse(become_sponsor)["url_label"] }}
            <span class="text-red-500">*</span></label>
          <input type="text" class="can-exp-input" :placeholder="JSON.parse(become_sponsor)['url_placeholder']" id="url"
            v-model="form.url" @input="clearErrors('url')" />
          <Error v-if="submitted" fieldName="url" :validationErros="validationErros" />
        </div>
        <div class="relative w-full mb-3">
          <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="contact_number">{{
            JSON.parse(become_sponsor)["contact_number_label"] }}
            <span class="text-red-500">*</span></label>
          <input type="text" class="can-exp-input" :placeholder="JSON.parse(become_sponsor)['contact_number_placeholder']
            " id="contact_number" v-model="form.contact_number" @keypress="restrictToNumbers($event, 16)"
            @input="clearErrors('contact_number')" />
          <Error v-if="submitted" fieldName="contact_number" :validationErros="validationErros" />
        </div>
        <div class="relative w-full mb-3">
          <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="appointment">{{
            JSON.parse(become_sponsor)["appointment_label"] }}
            <span class="text-red-500">*</span></label>
          <select id="type" v-model="form.appointment" @input="clearErrors('appointment')"
            class="can-exp-input w-full block border border-gray-300 rounded">
            <option value="yes" :selected="form.appointment == 'yes'">
              {{ JSON.parse(become_sponsor)["appointment_yes_option"] }}
            </option>
            <option value="no" :selected="form.appointment == 'no'">
              {{ JSON.parse(become_sponsor)["appointment_no_option"] }}
            </option>
          </select>
          <Error v-if="submitted" fieldName="appointment" :validationErros="validationErros" />
        </div>
        <div class="relative w-full mb-3" v-if="form.appointment == 'yes'">
          <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="time_to_call">{{
            JSON.parse(become_sponsor)["time_to_call_label"] }}
            <span class="text-red-500">*</span></label>
          <select id="type" v-model="form.time_to_call" @input="clearErrors('time_to_call')"
            class="can-exp-input w-full block border border-gray-300 rounded">
            <option value="am" :selected="form.time_to_call == 'am'">
              {{ JSON.parse(become_sponsor)["time_to_call_am_label"] }}
            </option>
            <option value="pm" :selected="form.time_to_call == 'pm'">
              {{ JSON.parse(become_sponsor)["time_to_call_pm_label"] }}
            </option>
          </select>
          <Error fieldName="time_to_call" :validationErros="validationErros" />
        </div>
        <div class="relative w-full mb-3" v-if="form.appointment == 'yes'">
          <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="appointment_date">{{
            JSON.parse(become_sponsor)["appointment_date_label"] }}
          </label>
          <input type="date" class="can-exp-input" id="appointment_date" v-model="form.appointment_date"
            @input="checkDateLength($event)" />
          <Error v-if="submitted" fieldName="appointment_date" :validationErros="validationErros" />
        </div>
        <div class="relative w-full mb-3">
          <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="image">
            {{ JSON.parse(become_sponsor)["image_label"] }} Images (Files must be less than 10 MB. Allowed file types:
            PNG, GIF, JPG, JPEG).
          </label>
          <FilePond @input="clearErrors('image')" ref="filePond" :labelIdle="`<span class='cursor-pointer'>${JSON.parse(become_sponsor)['image_placeholder']
            }</span>`" class="cursor-pointer" name="image" class-name="my-pond" accepted-file-types="image/*"
            @init="handleFilePondInit" @processfile="handleFilePondFlagIconProcess"
            @removefile="handleFilePondFlagIconRemoveFile" credits="false" v-bind:files="image_path" />
          <Error v-if="submitted" fieldName="image" :validationErros="validationErros" />
        </div>
        <div class="relative w-full mb-3">
          <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="feature_image">
            {{ JSON.parse(become_sponsor)["feature_image_label"] }} Images (Files must be less than 10 MB. Allowed file
            types: PNG, GIF, JPG, JPEG).
          </label>
          <FilePond @input="clearErrors('feature_image')" ref="filePond2" :labelIdle="`<span class='cursor-pointer'>${JSON.parse(become_sponsor)['image_placeholder']
            }</span>`" class="cursor-pointer" name="feature_image" class-name="my-pond" accepted-file-types="image/*"
            credits="false" v-bind:files="image_path_2" @init="handleImagePath2Init"
            @processfile="handleImagePath2Process" @removefile="handleImagePath2RemoveFile" />
          <Error v-if="submitted" fieldName="feature_image" :validationErros="validationErros" />
        </div>

      </div>
      <div class="grid mt-4 md:grid-cols-2 gap-4">
        <div class="relative w-full mb-3">
          <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="summary">{{
            JSON.parse(become_sponsor)["summary_label"] }}
            <span class="text-red-500">*</span></label>
          <textarea @input="clearErrors('summary')" rows="5" class="can-exp-input resize-none"
            :placeholder="JSON.parse(become_sponsor)['summary_placeholder']" id="summary"
            v-model="form.summary"></textarea>
          <Error v-if="submitted" fieldName="summary" :validationErros="validationErros" />
        </div>
        <div class="relative w-full mb-3">
          <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="detail_description">{{
            JSON.parse(become_sponsor)["detail_description_label"] }}
            <span class="text-red-500">*</span></label>
          <textarea @input="clearErrors('detail_description')" rows="5" class="can-exp-input resize-none" :placeholder="JSON.parse(become_sponsor)['detail_description_placeholder']
            " id="detail_description" v-model="form.detail_description"></textarea>
          <Error v-if="submitted" fieldName="detail_description" :validationErros="validationErros" />
        </div>
      </div>
      <div class="relative w-full mb-3">
        <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="message">{{
          JSON.parse(become_sponsor)["message_label"] }}
          <span class="text-red-500">*</span></label>
        <textarea @input="clearErrors('message')" rows="5" class="can-exp-input resize-none"
          :placeholder="JSON.parse(become_sponsor)['message_placeholder']" id="message"
          v-model="form.message"></textarea>
        <Error v-if="submitted" fieldName="message" :validationErros="validationErros" />
      </div>
    </div>
    <Error v-if="submitted" fieldName="captcha" :validationErros="validationErros" />
    <ListErrors :validationErrors="validationErros" />
    <div class="mt-8 flex justify-center items-center">
      <button aria-label="Candian Exporters" class="button-exp-fill" type="submit" id="send-message">
        {{ JSON.parse(become_sponsor)["submit_btn_text"] }}
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
import ListErrors from "./../components/ListErrors.vue";
import axios from "axios";
import ErrorHandling from "../../ErrorHandling";
// Import filepond
import vueFilePond, { setOptions } from "vue-filepond";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js";
import FilePondPluginImagePreview from "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview
);
export default {
  props: ["become_sponsor", "submit_url", "page_id"],
  components: {
    Error,
    ListErrors,
    FilePond,
  },
  data() {
    return {
      form: {
        name: "",
        company_name: "",
        contact_number: "",
        email: "",
        message: "",
        summary: "",
        detail_description: "",
        url: "",
        time_to_call: "am",
        appointment: "yes",
        appointment_date: this.getCurrentDate(),
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
  methods: {

    async storeData() {
      this.submitted = true;
      this.loading = true;

      try {
        const formData = new FormData();
        formData.append('type', 'sponsor');
        formData.append('url', this.form.url);
        formData.append('name', this.form.name);
        formData.append('email', this.form.email);
        formData.append('business_name', this.form.company_name);
        formData.append('small_business_description', this.form.summary);
        formData.append('detail_description', this.form.detail_description);
        formData.append('contact_number', this.form.contact_number);
        formData.append('message', this.form.message);
        formData.append('time_to_call', this.form.time_to_call);
        formData.append('appointment', this.form.appointment);
        formData.append('appointment_date', this.form.appointment_date);
        formData.append('is_visible', 0);
        formData.append('media_id', this.images.image_path);
        formData.append('image', this.images.image_path_2);

        const response = await axios.post(`${process.env.MIX_WEB_API_URL}banners`, formData, {
          headers: { 'Content-Type': 'multipart/form-data' },
        });

        if (response.data.status === 'Success') {
          console.log('response.data.status', response.data)
            helper.swalSuccessMessageForWeb(response.data.message);
            this.clearForm();
        } else {
            helper.swalErrorMessageForWeb(response.data.message);
        }
      } catch (error) {
        this.loading = false;
        this.validationErrors = new ErrorHandling();

        if (error.response) {
          if (error.response.status === 422) {
            this.validationErrors.record(error.response.data.errors);
            this.scrollToFirstError();
          } else if (error.response.data?.status === 'Error') {
            helper.swalErrorMessageForWeb(error.response.data.message);
          }
        }
      } finally {
        this.loading = false;
      }
    },
    // updateForm(field, value) {
    //   this.$store.commit("banners/setForm", {
    //     [field]: value,
    //   });
    // },
    // addUpdateForm() {
    //   this.updateForm('image', this.images.image_path_2);
    //   this.updateForm('media_id', this.images.image_path);
    //   this.$store
    //     .dispatch("banners/addUpdateForm")
    //     .then(() => this.$router.push({ name: "admin.banners.index" }));
    // },

    clearErrors(fieldName) {
      if (this.submitted) {
        this.validationErros.clear(fieldName);
      }
    },
    checkDateLength(event) {
      // Check if the value is in the correct format (YYYY-MM-DD)
      let value = event.target.value;

      let dateParts = value.split('-');

      // Ensure there are 3 parts (year, month, day)
      if (dateParts.length === 3) {
        // Limit the year part to 4 digits
        if (dateParts[0].length > 4) {
          dateParts[0] = dateParts[0].slice(0, 4);
        }

        if (dateParts[1].length > 2) {
          dateParts[1] = dateParts[1].slice(0, 2); // Limit month to 2 digits
        }

        if (dateParts[2].length > 2) {
          dateParts[2] = dateParts[2].slice(0, 2); // Limit day to 2 digits
        }

        // Rejoin the parts and set the value back
        event.target.value = dateParts.join('-');
      }

      this.form.appointment_date = event.target.value;
    },
    clearForm() {
      this.form["name"] = "";
      this.form["company_name"] = "";
      this.form["contact_number"] = "";
      this.form["email"] = "";
      this.form["message"] = "";
      this.form["summary"] = "";
      this.form["detail_description"] = "";
      this.form["url"] = "";
      this.form["image"] = "";
      this.form["feature_image"] = "";
      this.form["time_to_call"] = "am";
      this.form["appointment"] = "yes";
      this.form["appointment_date"] = this.getCurrentDate();
      this.image_path_2 = [];
      this.images.image_path_2 = null;
      this.image_path = [];
      this.images.image_path = null;
      if (this.$refs.filePond) this.$refs.filePond.removeFiles();
      if (this.$refs.filePond2) this.$refs.filePond2.removeFiles();
      this.validationErros = new ErrorHandling();
      localStorage.removeItem("become_sponsor_form");
    },
    getCurrentDate() {
      const today = new Date();
      const formattedDate = today.toISOString().slice(0, 10);
      return formattedDate;
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
                this.storeData();
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
      if (this.form["appointment"] == "no") {
        this.form["appointment_date"] = null;
      }
      this.image = this.images.image_path;
      this.feature_image = this.images.image_path_2;
      this.form.page_id = this.page_id;
      axios
        .post(this.submit_url, this.form)
        .then((res) => {
          this.loading = 0;
          if (res.data.status == "Success") {
            helper.swalSuccessMessageForWeb(res.data.message);
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
