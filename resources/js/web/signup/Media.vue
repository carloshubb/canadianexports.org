<template>
  <div>
    <div class="my-4">
      <p class="mb-4">
        {{
          regPageSetting?.reg_page_setting_detail?.[0]
            ?.pre_media_tab_description
        }}
      </p>
      <div
        class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-xblue via-primary to-blue-600 rounded-md cursor-pointer"
      >
        <template v-if="profile == '1'">
          <h4
            @click.prevent="displayMediaSection = !displayMediaSection"
            class="text-white"
            v-html="
              JSON.parse(user)?.is_package_amount_paid
                ? regPageSetting?.reg_page_setting_detail?.[0]
                    ?.step_5_acc_heading
                : regPageSetting?.reg_page_setting_detail?.[0]?.step_5_heading
            "
          ></h4>
        </template>
        <template v-else>
          <h4
            class="text-white"
            @click.prevent="displayMediaSection = !displayMediaSection"
            v-html="
              regPageSetting?.reg_page_setting_detail?.[0]?.step_5_heading
            "
          ></h4>
        </template>
      </div>
      <div class="my-4" v-if="displayMediaSection">
        <!-- <div class="relative w-full mb-4">
          <label
            class="block text-gray-700 mb-1 text-base md:text-base lg:text-lg"
            for="step_5_title_label"
          >
            {{
              regPageSetting?.reg_page_setting_detail?.[0]?.step_5_title_label
            }}
          </label>
          <textarea
            type="text"
            rows="1"
            class="can-exp-input min-h-[60px] lg:min-h-full overflow-auto"
            @input="updateForm('customer_media_title', $event.target.value)"
            :placeholder="
              regPageSetting?.reg_page_setting_detail?.[0]
                ?.step_5_title_placeholder
            "
            :value="
              form && form.has('customer_media_title')
                ? form.get('customer_media_title')
                : ''
            "
            id="customer_media_title"
          ></textarea>
          <Error
            fieldName="customer_media_title"
            :validationErros="validationErros"
          />
        </div>
        <div class="relative w-full mb-4">
          <label
            class="block text-gray-700 mb-1 text-base md:text-base lg:text-lg"
            for="step_5_description_label"
          >
            {{
              regPageSetting?.reg_page_setting_detail?.[0]
                ?.step_5_description_label
            }}
          </label>
          <textarea
            rows="3"
            class="can-exp-input"
            :placeholder="
              regPageSetting?.reg_page_setting_detail?.[0]
                ?.step_5_description_placeholder
            "
            @input="
              updateForm('customer_media_description', $event.target.value)
            "
            :value="
              form && form.has('customer_media_description')
                ? form.get('customer_media_description')
                : ''
            "
            id="customer_media_description"
          ></textarea>
          <Error
            fieldName="customer_media_description"
            :validationErros="validationErros"
          />
        </div> -->
        <div class="relative w-full mb-4">
  <label
    class="block text-gray-700 mb-1 text-base md:text-base lg:text-lg"
    for="step_5_title_label"
  >
    {{
      regPageSetting?.reg_page_setting_detail?.[0]?.step_5_title_label
    }}
  </label>
  <textarea
    rows="1"
    class="can-exp-input min-h-[60px] lg:min-h-full overflow-auto"
    @input="limitWords($event, 'customer_media_title', 10); updateForm('customer_media_title', $event.target.value)"
    :placeholder="regPageSetting?.reg_page_setting_detail?.[0]?.step_5_title_placeholder"
    :value="form.customer_media_title"
    id="customer_media_title"
  ></textarea>
  <Error fieldName="customer_media_title" :validationErros="validationErros" />
</div>

<div class="relative w-full mb-4">
  <label
    class="block text-gray-700 mb-1 text-base md:text-base lg:text-lg"
    for="step_5_description_label"
  >
    {{
      regPageSetting?.reg_page_setting_detail?.[0]
        ?.step_5_description_label
    }}
  </label>
  <textarea
    rows="3"
    class="can-exp-input"
    @input="limitWords($event, 'customer_media_description', 50); updateForm('customer_media_description', $event.target.value)"
    :placeholder="regPageSetting?.reg_page_setting_detail?.[0]?.step_5_description_placeholder"
    :value="form.customer_media_description"
    id="customer_media_description"
  ></textarea>
  <Error fieldName="customer_media_description" :validationErros="validationErros" />
</div>


        <div class="relative w-full mb-4">
          <label
            class="block text-gray-700 mb-1 text-base md:text-base lg:text-lg"
            for="video"
          >
            {{
              regPageSetting?.reg_page_setting_detail?.[0]?.step_5_video_label
            }}
          </label>
          <textarea
            type="url"
            rows="1"
            class="can-exp-input min-h-[60px] lg:min-h-full overflow-auto"
            :placeholder="
              regPageSetting?.reg_page_setting_detail?.[0]
                ?.step_5_video_placeholder
            "
            @input="updateForm('customer_media_video', $event.target.value)"
            :value="
              form && form.has('customer_media_video')
                ? form.get('customer_media_video')
                : ''
            "
            id="customer_media_video"
          ></textarea>
          <Error
            fieldName="customer_media_video"
            :validationErros="validationErros"
          />
        </div>
        <div class="relative col-span-2 mb-3">
          <label
            class="block text-gray-700 mb-1 text-base md:text-base lg:text-lg"
            for="image-logo"
          >
            {{
              regPageSetting?.reg_page_setting_detail?.[0]?.step_5_logo_label
            }}
          </label>
          <FilePond
            class="cursor-pointer"
            name="logo"
            class-name="my-pond"
            accepted-file-types="image/*"
            credits="false"
            :labelIdle="`<span class='cursor-pointer'>${regPageSetting?.reg_page_setting_detail?.[0]?.step_5_logo_placeholder}</span>`"
            ref="logo"
            v-bind:files="files"
            @init="handleLogoInit"
            @processfile="handleLogoProcess"
            @removefile="handleLogoRemoveFile"
            id="customer_media_image_4"
          />
          <Error
            fieldName="customer_media_image_4"
            :validationErros="validationErros"
          />
        </div>
        <div class="relative w-full mb-4" v-if="max_files > 0">
          <label
            class="block text-gray-700 mb-1 text-base md:text-base lg:text-lg"
            for="gallery-images"
          >
            {{
              regPageSetting?.reg_page_setting_detail?.[0]
                ?.step_5_gallery_image_label
            }}
            {{ max_files }}</label
          >
          <FilePond
            name="gallery_images"
            class-name="my-pond xelent-pond"
            accepted-file-types="image/*"
            allow-multiple="true"
            ref="gallery_images"
            credits="false"
            :labelIdle="`<span class='cursor-pointer'>${regPageSetting?.reg_page_setting_detail?.[0]?.step_5_gallery_image_placeholder}</span>`"
            :max-files="max_files"
            :max-parallel-uploads="max_files"
            v-bind:files="gallery_files"
            @init="handleGalleryImagesInit"
            @initfile="handleGalleryImagesInitFile"
            @warning="handleGalleryImagesWarning"
            @processfile="handleGalleryImagesProcess"
            @removefile="handleGalleryImagesRemoveFile"
            id="gallery_images"
          />
          <Error
            fieldName="gallery_images"
            :validationErros="validationErros"
          />
        </div>
        <!-- <div class="mt-10 flex justify-center" v-if="profile == '1'">
                    <button
                        aria-label="Candian Exporters"
                        type="button"
                        @click="updateMediaSetting()"
                        class="button-exp-fill"
                    >
                        {{
                            general_setting &&
                            general_setting["process_button_text"]
                                ? general_setting["process_button_text"]
                                : ""
                        }}
                    </button>
                </div> -->
      </div>
    </div>
  </div>
</template>
<script>
import { mapState } from "vuex";
import Error from "./../components/Error.vue";
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
  components: {
    Error,
    FilePond,
  },
  computed: {
    ...mapState({
      form: (state) => state.signup.form,
      regPageSetting: (state) => state.signup.regPageSetting,
      validationErros: (state) => state.signup.validationErros,
      max_files: (state) => state.signup.max_files,
    }),
  },
  data() {
    return {
      general_setting: null,
      displayMediaSection: false,
      gallery_files: [],
      files: [],
    };
  },
  created() {
  this.gallery_files = [];
  this.files = [];
  if (this.profile == "1") {
    let user = JSON.parse(this.user);
    if (user.is_package_amount_paid) {
      this.displayMediaSection = 1;
    }
    this.updateForm(
      "customer_media_video",
      user?.customer_media?.video == null ||
        user?.customer_media?.video == "null"
        ? ""
        : user?.customer_media?.video
    );
    this.updateForm(
      "customer_media_title",
      user?.customer_media?.title == null ||
        user?.customer_media?.title == "null"
        ? ""
        : user?.customer_media?.title
    );
    this.updateForm(
      "customer_media_description",
      user?.customer_media?.description == null ||
        user?.customer_media?.description == "null"
        ? ""
        : user?.customer_media?.description
    );
    if (user?.customer_media && user?.customer_media?.customer_logo) {
      this.files.push({
        source: user?.customer_media?.customer_logo.base64,
        options: {
          type: "local",
          metadata: {
            poster: user?.customer_media?.customer_logo.base64,
          },
        },
      });
      this.updateForm(
        "customer_media_logo",
        JSON.stringify([user?.customer_media?.customer_logo?.path])
      );
    }
    if (
      user?.customer_media &&
      user?.customer_media?.customer_gallery_images
    ) {
      let images = user?.customer_media?.customer_gallery_images;
      images.map((image) => {
        if (image.media) {
          this.gallery_files.push({
            source: image.media.base64,
            options: {
              type: "local",
              metadata: {
                serverId: image.media.path,
                poster: image.media.base64,
              },
            },
          });
        }
      });
      this.$store.commit("signup/resetGalleryImages");
      images.map((image) => {
        if (image.media) {
          this.$store.commit("signup/setGalleryImages", {
            type: "add",
            value: image.media.path,
          });
        }
      });
    }
  }

  // Retrieve form data from localStorage
  const savedFormData = JSON.parse(localStorage.getItem("formData")) || {};
  for (const [field, value] of Object.entries(savedFormData)) {
    if(field == 'customer_media_title' || field == 'customer_media_description'){
        this.form[field] = value;
    }
    else{
        this.updateForm(field, value);
    }
  }
},
  methods: {
    limitWords(event, fieldName, maxWords) {
    const inputElement = event.target;
    let val = inputElement.value;
    let words = val.trim().split(/\s+/);

    if (words.length > maxWords) {
      // Get only the first `maxWords` words and add a trailing space
      const truncatedText = words.slice(0, maxWords).join(" ") + " ";

      // Prevent input field from updating beyond limit
      this.form[fieldName] = truncatedText;

      setTimeout(() => {
        inputElement.value = truncatedText;
        inputElement.setSelectionRange(truncatedText.length, truncatedText.length);
      }, 0);
    } else {
        const formData = JSON.parse(localStorage.getItem("formData")) || {};
        formData[fieldName] = val;
        localStorage.setItem("formData", JSON.stringify(formData));
        this.form[fieldName] = val; // Allow normal updates within limit
    }
  },
  updateForm(field, value) {
    // Update Vuex store
    this.$store.commit("signup/setForm", {
      field: [field],
      value: value,
    });
    this.$store.commit("signup/removeValidationErros", {
      field: [field],
    });

    // Save form data to localStorage
    const formData = JSON.parse(localStorage.getItem("formData")) || {};
    formData[field] = value;
    localStorage.setItem("formData", JSON.stringify(formData));
  },
    updateMediaSetting() {
    this.$store.dispatch("signup/updateMediaSetting")
      .then((res) => {
        if (res.data.status == "Success") {
          // Clear localStorage on successful submission
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
    handleLogoInit() {
      setOptions({
        credits: false,
        server: {
          url: process.env.MIX_APP_URL,
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
            formData.append("type", "logo");

            const request = new XMLHttpRequest();
            request.open("POST", `${process.env.MIX_APP_URL}/media/process`);
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
            request.open("POST", `${process.env.MIX_APP_URL}/media/revert`);
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
    handleLogoProcess(error, file) {
      this.updateForm("customer_media_logo", file.serverId);
      this.$store.commit("signup/removeValidationErros", {
        field: "customer_media_logo",
      });
    },
    handleLogoRemoveFile(error, file) {
      this.updateForm("customer_media_logo", "");
    },
    handleGalleryImagesInit() {
      setOptions({
        credits: false,
        server: {
          url: process.env.MIX_APP_URL,
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
            formData.append("type", "logo");

            const request = new XMLHttpRequest();
            request.open("POST", `${process.env.MIX_APP_URL}/media/process`);
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
            request.open("POST", `${process.env.MIX_APP_URL}/media/revert`);
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
    handleGalleryImagesInitFile(file) {
      this.$store.commit("signup/removeValidationErros", {
        field: "gallery_images",
      });
    },
    handleGalleryImagesWarning(error, file, status) {
      if (error.code === 0) {
        this.$store.commit("signup/updateValidationErros", {
          field: "gallery_images",
          message: `Please limit the number of your images to ${this.max_files}`,
        });
      }
    },
    handleGalleryImagesProcess(error, file) {
      this.$store.commit("signup/setGalleryImages", {
        type: "add",
        value: JSON.parse(file.serverId)[0],
      });
      this.$store.commit("signup/removeValidationErros", {
        field: "gallery_images",
      });
    },
    handleGalleryImagesRemoveFile(error, file) {
      // console.log('handleGalleryImagesRemoveFile', error);
      if (this.profile == "1") {
        if (file.getMetadata() && file.getMetadata().serverId) {
          this.$store.commit("signup/setGalleryImages", {
            type: "remove",
            value: file.getMetadata().serverId,
          });
        }
      } else {
        this.$store.commit("signup/setGalleryImages", {
          type: "remove",
          value: JSON.parse(file.serverId)[0],
        });
      }
    },
  },
  props: ["profile", "user", "page_id"],
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
