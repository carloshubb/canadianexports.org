<template>
  <AppLayout>
    <div class="relative shadow-md sm:rounded-lg bg-white py-4">
      <header class="pt-4">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <h3 class="can-exp-h3 text-primary">
              {{ isFormEdit ? "Edit" : "Create" }} banner
            </h3>
            <router-link
              :to="{ name: 'admin.banners.index' }"
              class="button-exp-fill"
            >
              Back
            </router-link>
          </div>
        </div>
      </header>
      <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
        <div
          class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6"
        >
          <!-- <div class="relative z-0 w-full group">
                        <label for="type">Type</label>
                        <select id="type" @change="updateForm('type', $event.target.value)" class="can-exp-input w-full block border border-gray-300 rounded">
                            <option value="">Select type...</option>
                            <option value="banners" :selected="form.type == 'banners'">Banner</option>
                            <option value="sponsor" :selected="form.type == 'sponsor'">Sponsor</option>
                        </select>

                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('type')" v-text="validationErros.get('type')"></p>
                    </div> -->
          <div class="relative z-0 w-full group">
            <label for="business-name">Company name</label>
            <input
              type="text"
              id="business-name"
              class="can-exp-input w-full block border border-gray-300 rounded"
              placeholder=" "
              :value="form.business_name"
              @input="updateForm('business_name', $event.target.value)"
            />
            <p
              class="mt-2 text-sm text-red-400"
              v-if="validationErros.has('business_name')"
              v-text="validationErros.get('business_name')"
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="name">Your name and title</label>
            <input
              type="text"
              id="name"
              class="can-exp-input w-full block border border-gray-300 rounded"
              placeholder=" "
              :value="form.name"
              @input="updateForm('name', $event.target.value)"
            />
            <p
              class="mt-2 text-sm text-red-400"
              v-if="validationErros.has('name')"
              v-text="validationErros.get('name')"
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="email">Email</label>
            <input
              type="text"
              id="email"
              class="can-exp-input w-full block border border-gray-300 rounded"
              placeholder=" "
              :value="form.email"
              @input="updateForm('email', $event.target.value)"
            />
            <p
              class="mt-2 text-sm text-red-400"
              v-if="validationErros.has('email')"
              v-text="validationErros.get('email')"
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="url">Company website</label>
            <input
              type="text"
              name="url"
              id="url"
              class="can-exp-input w-full block border border-gray-300 rounded"
              placeholder=" "
              :value="form.url"
              @input="updateForm('url', $event.target.value)"
            />
            <p
              class="mt-2 text-sm text-red-400"
              v-if="validationErros.has('url')"
              v-text="validationErros.get('url')"
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="contact_number">Contact number</label>
            <input
              type="text"
              id="contact_number"
              class="can-exp-input w-full block border border-gray-300 rounded"
              placeholder=" "
              :value="form.contact_number"
              @input="updateForm('contact_number', $event.target.value)"
            />
            <p
              class="mt-2 text-sm text-red-400"
              v-if="validationErros.has('contact_number')"
              v-text="validationErros.get('contact_number')"
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="time_to_call">Best time to call you</label>
            <select
                id="time_to_call"
                class="can-exp-input w-full block border border-gray-300 rounded"
                :value="form.time_to_call"
                @change="updateForm('time_to_call', $event.target.value)"
            >
                <option value="am">AM</option>
                <option value="pm">PM</option>
            </select>
            <p
              class="mt-2 text-sm text-red-400"
              v-if="validationErros.has('time_to_call')"
              v-text="validationErros.get('time_to_call')"
            ></p>
            </div>
            <div class="relative z-0 w-full group">
            <label for="appointment">Appointment required?</label>
            <select
                id="appointment"
                class="can-exp-input w-full block border border-gray-300 rounded"
                :value="form.appointment"
                @change="updateForm('appointment', $event.target.value)"
            >
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
            <p
              class="mt-2 text-sm text-red-400"
              v-if="validationErros.has('appointment')"
              v-text="validationErros.get('appointment')"
            ></p>
            </div>
            <div class="relative z-0 w-full group" v-if="form.appointment === 'yes'">
            <label for="appointment_date">Appointment Date</label>
            <input
              type="date"
              id="appointment_date"
              class="can-exp-input w-full block border border-gray-300 rounded"
              placeholder=" "
              :value="form.appointment_date"
              @input="updateForm('appointment_date', $event.target.value)"
            />
            <p
              class="mt-2 text-sm text-red-400"
              v-if="validationErros.has('appointment_date')"
              v-text="validationErros.get('appointment_date')"
            ></p>
          </div>


          <div class="relative z-0 w-full group">
            <label for="image_1">Image-1 (appears on the Home page) Images (Files must be less than 10 MB. Allowed file types: PNG, GIF, JPG, JPEG).</label>
            <FilePond
              labelIdle='<span class="cursor-pointer">Drag & Drop your logo or <span class="filepond--label-action"> Browse </span></span>'
              class="cursor-pointer"
              name="image_path"
              class-name="my-pond"
              accepted-file-types="image/*"
              @init="handleFilePondInit"
              @processfile="handleFilePondFlagIconProcess"
              @removefile="handleFilePondFlagIconRemoveFile"
              credits="false"
              v-bind:files="image_path"
            />
            <p
              class="mt-2 text-sm text-red-400"
              v-if="validationErros.has('media_id')"
              v-text="validationErros.get('media_id')"
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="image_2">Image-2 (appears on your profile page) Images (Files must be less than 10 MB. Allowed file types: PNG, GIF, JPG, JPEG).</label>
            <FilePond
              labelIdle='<span class="cursor-pointer">Drag & Drop your featured image or <span class="filepond--label-action"> Browse </span></span>'
              class="cursor-pointer"
              name="image_media"
              class-name="my-pond"
              accepted-file-types="image/*"
              credits="false"
              ref="image_media"
              v-bind:files="image_path_2"
              @init="handleImagePath2Init"
              @processfile="handleImagePath2Process"
              @removefile="handleImagePath2RemoveFile"
            />
            <p
              class="mt-2 text-sm text-red-400"
              v-if="validationErros.has('image')"
              v-text="validationErros.get('image')"
            ></p>
          </div>

          <div class="relative z-0 w-full group" v-if="isDataLoaded">
            <label for="small_business_description"
              >Brief Introduction</label
            >
            <editor
              @mouseleave="handleSelectionChange('small_business_description')"
              @keyup="handleSelectionChange('small_business_description')"
              :ref="`small_business_description`"
              :id="`small_business_description`"
              :initial-value="form[`small_business_description`]"
              :init="editorConfig"
              :tinymce-script-src="tinymceScriptSrc"
            />
            <p
              class="mt-2 text-sm text-red-400"
              v-if="validationErros.has('small_business_description')"
              v-text="validationErros.get('small_business_description')"
            ></p>
          </div>
          <div class="relative z-0 w-full group" v-if="isDataLoaded">
            <label for="detail_description">Detailed description</label>
            <editor
              @mouseleave="handleSelectionChange('detail_description')"
              @keyup="handleSelectionChange('detail_description')"
              :ref="`detail_description`"
              :id="`detail_description`"
              :initial-value="form[`detail_description`]"
              :init="editorConfig"
              :tinymce-script-src="tinymceScriptSrc"
            />
            <p
              class="mt-2 text-sm text-red-400"
              v-if="validationErros.has('detail_description')"
              v-text="validationErros.get('detail_description')"
            ></p>
          </div>
          <div class="relative z-0 w-full group" v-if="isDataLoaded">
            <label for="message">Message</label>
            <editor
              @mouseleave="handleSelectionChange('message')"
              @keyup="handleSelectionChange('message')"
              :ref="`message`"
              :id="`message`"
              :initial-value="form[`message`]"
              :init="editorConfig"
              :tinymce-script-src="tinymceScriptSrc"
            />
            <p
              class="mt-2 text-sm text-red-400"
              v-if="validationErros.has('message')"
              v-text="validationErros.get('message')"
            ></p>
          </div>
          <div class="relative z-0 w-full group flex items-center">
            <input
            type="checkbox"
            id="display-on-website"
            :checked="form.is_visible"
            @change="updateForm('is_visible', $event.target.checked)"
            />
            <label for="display-on-website" class="block mt-1 ml-2">Display on home page</label>
            </div>
            <div class="relative z-0 w-full group mt-4">
            <label for="is_active">Status</label>
            <select
                id="is_active"
                class="can-exp-input w-full block border border-gray-300 rounded"
                :value="form.is_active"
                @change="updateForm('is_active', $event.target.value)"
            >
            <option value="inactive">In Active</option>
                <option value="active">Active</option>
            </select>
            </div>
        </div>
        <button type="submit" class="button-exp-fill" :disabled="loading">
          Submit
        </button>
      </form>
    </div>
  </AppLayout>
</template>

<script>
import Editor from "@tinymce/tinymce-vue";
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

import { mapState } from "vuex";
export default {
  computed: {
    ...mapState({
      loading: (state) => state.banners.loading,
      isFormEdit: (state) => state.banners.isFormEdit,
      form: (state) => state.banners.form,
      validationErros: (state) => state.banners.validationErros,
    }),
    is_default: {
      get: function () {
        return this.$store.state.banners.form.is_default;
      },
      set: function (val) {
        this.$store.commit("banners/setForm", {
          is_default: val,
        });
      },
    },
  },
  data() {
    return {
      image_path_2: [],
      image_path: [],
      images: {
        image_path_2: null,
        image_path: null,
      },
      isDataLoaded: false,
      editorConfig: {
        height: 250,
        menubar: false,
        plugins:
          "anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount fullscreen code",
        toolbar:
          "undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | code | fullscreen",
        base_url: "/plugins/tinymce",
        suffix: ".min",
      },
      tinymceScriptSrc: "/plugins/tinymce/tinymce.min.js",
    };
  },
  methods: {
    updateForm(field, value) {
      this.$store.commit("banners/setForm", {
        [field]: value,
      });
    },
    addUpdateForm() {
      this.updateForm('image', this.images.image_path_2);
      this.updateForm('media_id', this.images.image_path);
      this.$store
        .dispatch("banners/addUpdateForm")
        .then(() => this.$router.push({ name: "admin.banners.index" }));
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
    handleSelectionChange(key) {
      console.log(tinymce.get(`${key}`).getContent());
      this.updateForm(key, tinymce.get(`${key}`).getContent());
    },
  },
  components: {
    FilePond,
    editor: Editor,
  },
  created() {
    this.image_path_2 = [];
    this.images.image_path_2 = null;
    this.image_path = [];
    this.images.image_path = null;

    this.$store.commit("banners/resetForm");
    if (this.$route.params.id) {
      let id = this.$route.params.id;
      this.$store.commit("banners/setIsFormEdit", 1);
      this.$store
        .dispatch("banners/fetchBanner", {
          url: `${process.env.MIX_ADMIN_API_URL}banners/${id}?withMedia=1&withMediaImage=1`,
        })
        .then((res) => {
          if (res.data.status == "Success") {
            if (this.form.media_id) {
              this.convertImgUrlToBase64(
                this.form.media.full_path,
                `image/${this.form.media.extension}`
              );
              this.images.image_path = JSON.stringify([
                res.data.data.media.path,
              ]);
              this.isDataLoaded = 1;
            }
            if (res.data.data.image && res.data.data.media_image) {
              this.convertImagePath2ImgUrlToBase64(
                res.data.data.media_image.full_path,
                `image/${res.data.data.media_image.extension}`
              );
              this.images.image_path_2 = JSON.stringify([
                res.data.data.media_image.path,
              ]);
            }
          }
        });
    } else {
      this.isDataLoaded = 1;
    }
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
