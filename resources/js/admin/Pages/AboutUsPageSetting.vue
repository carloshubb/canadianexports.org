<template>
  <div
    class="my-5"
    v-for="language in languages"
    :key="language.id"
    :class="
      (selectedLanguage == null && language.is_default) ||
      language.id == selectedLanguage
        ? 'block'
        : 'hidden'
    "
  >
    <div
      class="border rounded w-full"
      :class="collapseStates[0] ? 'bg-gray-50' : ''"
    >
      <div
        class="flex justify-between bg-primary text-white p-4 cursor-pointer"
        @click.prevent="collapseStates[0] = !collapseStates[0]"
      >
        <h3 class="text-white">Detail section</h3>
        <svg class="w-5 h-5 fill-current text-gray-500" viewBox="0 0 20 20">
          <path d="M6 9l4 4 4-4"></path>
        </svg>
      </div>
      <div class="p-4 bg-gray-100 border-t" v-show="collapseStates[0]">
        <div class="grid my-5 md:gap-6 gap-4">
          <div class="relative z-0 w-full group" v-if="isDataLoaded">
            <label :for="`page_description_${selectedLanguage}`"
              >Page description</label
            >
            <!-- <div class="mt-5 ckeditorText" :id="`page_description_${language?.id}`"></div> -->
            <editor
              @mouseleave="
                handleSelectionChange(
                  language,
                  'page_description',
                  'updateHomePageSetting'
                )
              "
              @keyup="
                handleSelectionChange(
                  language,
                  'page_description',
                  'updateHomePageSetting'
                )
              "
              :ref="`page_description_${language.id}`"
              :id="`page_description_${language.id}`"
              :initial-value="
                form[`page_description`][`page_description_${language?.id}`]
              "
              :tinymce-script-src="tinymceScriptSrc"
              :init="editorConfig"
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `page_description.page_description_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `page_description.page_description_${selectedLanguage}`
                )
              "
            ></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>



<script>
import axios from "axios";
import Editor from "@tinymce/tinymce-vue";
import { mapState } from "vuex";
export default {
  props: ["selectedLanguage"],
  computed: {
    ...mapState({
      form: (state) => state.pages.form,
      validationErros: (state) => state.pages.validationErros,
      languages: (state) => state.languages.languages,
    }),
  },
  components: {
    editor: Editor,
  },
  data() {
    return {
      collapseStates: [true, false, false, false, false, false, false],
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
    handleInput(value, language, key, mutationName) {
      // console.log(value, key, language, mutationName);
      this.$store.commit(`pages/${mutationName}`, {
        value: value,
        id: language.id,
        key,
      });
    },
    handleImage(e, language, key, mutationName) {
      // console.log(e.target.files[0], key, language, mutationName);
      var file = new FormData();
      file.append("file", e.target.files[0]);
      axios.post("/api/admin/media/image_again_upload", file).then((res) => {
        this.$store.commit(`pages/${mutationName}`, {
          value: res?.data,
          id: language.id,
          key,
        });
      });
    },
    addUpdateForm() {
      this.$store.dispatch("pages/addUpdateForm").then((res) => {
        if (res.data.status == "Success") {
          this.$emit("addUpdateFormParent");
        }
      });
    },
    fetchPageSetting() {
      this.$store
        .dispatch("pages/fetchPage", {
          url: `${process.env.MIX_ADMIN_API_URL}about-us-page-setting?withAboutUsPageSettingDetail=1&findByPageId=${this.form.id}`,
        })
        .then((res) => {
          let data =
            res.data.data && res.data.data.about_us_page_setting_detail
              ? res.data.data.about_us_page_setting_detail
              : [];

          let obj = {};
          data.map((res) => {
            obj["page_description_" + res.language_id] = res.page_description;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "page_description",
            value: obj,
          });
          this.isDataLoaded = true;
        });
    },
    checkValidationError(validationErros, language) {
      return validationErros.has(
        `page_description.page_description_${language.id}`
      );
    },
    handleSelectionChange(language, key, mutationName) {
      this.handleInput(
        tinymce.get(`${key}_${language.id}`).getContent(),
        language,
        key,
        mutationName
      );
    },
  },
  created() {
    // this.$store.commit("pages/resetForm");
    this.$store
      .dispatch("languages/fetchLanguages", {
        url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
      })
      .then((res) => {
        let data = res.data.data;

        let obj = {};
        data.map((res) => {
          obj["page_description_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "page_description",
          value: obj,
        });

        if (this.$route.params.id) {
          this.fetchPageSetting();
        }
        else{
            this.isDataLoaded = true;
        }
      });
  },
};
</script>