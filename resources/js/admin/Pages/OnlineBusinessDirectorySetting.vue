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
      :class="collapseStates[0] ? 'bg-blue-50' : ''"
    >
      <div
        class="lg:border-b lg:border-t lg:border-gray-200 cursor-pointer"
        @click.prevent="collapseStates[0] = !collapseStates[0]"
      >
        <nav class="mx-auto" aria-label="Section">
          <ol
            role="list"
            class="overflow-hidden rounded-md lg:flex lg:rounded-none lg:border-l lg:border-r lg:border-gray-200"
          >
            <li class="relative overflow-hidden lg:flex-1">
              <div
                class="overflow-hidden border border-gray-200 rounded-t-md border-b-0 lg:border-0 flex justify-between items-center"
              >
                <div class="group w-full">
                  <span
                    class="absolute left-0 top-0 h-full w-1 bg-transparent group-hover:bg-primary lg:bottom-0 lg:top-auto lg:h-1 lg:w-full"
                    aria-hidden="true"
                  ></span>
                  <span class="flex items-start px-6 py-2 text-sm font-medium">
                    <span class="flex-shrink-0">
                      <span
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-primary"
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke-width="1.5"
                          stroke="currentColor"
                          class="h-6 w-6 text-white"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z"
                          />
                        </svg>
                      </span>
                    </span>
                    <span class="ml-4 mt-0.5 flex min-w-0 flex-col">
                      <span class="text-sm font-medium">Form settings</span>
                      <span class="text-sm font-medium text-gray-500"
                        >Become a sponsor form setting e.g. label & error
                        messages</span
                      >
                    </span>
                  </span>
                </div>
                <svg
                  class="w-5 h-5 fill-current text-gray-500"
                  viewBox="0 0 20 20"
                >
                  <path d="M6 9l4 4 4-4"></path>
                </svg>
              </div>
            </li>
          </ol>
        </nav>
      </div>
      <div class="p-4 bg-gray-50 border-t" v-show="collapseStates[0]">
        <div
          class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
        >
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`keyword_label_${selectedLanguage}`"
              >Label for keyword</label
            >
            <input
              type="text"
              :name="`keyword_label_${selectedLanguage}`"
              :id="`keyword_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'keyword_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['keyword_label'] &&
                form['keyword_label'][
                  `keyword_label_${selectedLanguage}`
                ]
                  ? form['keyword_label'][
                      `keyword_label_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `keyword_label.keyword_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `keyword_label.keyword_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`keyword_error_${selectedLanguage}`"
              >Error message for keyword</label
            >
            <input
              type="text"
              :name="`keyword_error_${selectedLanguage}`"
              :id="`keyword_error_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'keyword_error',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['keyword_error'] &&
                form['keyword_error'][
                  `keyword_error_${selectedLanguage}`
                ]
                  ? form['keyword_error'][
                      `keyword_error_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `keyword_error.keyword_error_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `keyword_error.keyword_error_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`keyword_placeholder_${selectedLanguage}`"
              >Placeholder for keyword</label
            >
            <input
              type="text"
              :name="`keyword_placeholder_${selectedLanguage}`"
              :id="`keyword_placeholder_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'keyword_placeholder',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['keyword_placeholder'] &&
                form['keyword_placeholder'][
                  `keyword_placeholder_${selectedLanguage}`
                ]
                  ? form['keyword_placeholder'][
                      `keyword_placeholder_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `keyword_placeholder.keyword_placeholder_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `keyword_placeholder.keyword_placeholder_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`city_label_${selectedLanguage}`"
              >Label for city</label
            >
            <input
              type="text"
              :name="`city_label_${selectedLanguage}`"
              :id="`city_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'city_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['city_label'] &&
                form['city_label'][`city_label_${selectedLanguage}`]
                  ? form['city_label'][`city_label_${selectedLanguage}`]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `city_label.city_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `city_label.city_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`city_error_${selectedLanguage}`"
              >Error message for city</label
            >
            <input
              type="text"
              :name="`city_error_${selectedLanguage}`"
              :id="`city_error_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'city_error',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['city_error'] &&
                form['city_error'][`city_error_${selectedLanguage}`]
                  ? form['city_error'][`city_error_${selectedLanguage}`]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `city_error.city_error_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `city_error.city_error_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`city_placeholder_${selectedLanguage}`"
              >Placeholder for city</label
            >
            <input
              type="text"
              :name="`city_placeholder_${selectedLanguage}`"
              :id="`city_placeholder_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'city_placeholder',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['city_placeholder'] &&
                form['city_placeholder'][
                  `city_placeholder_${selectedLanguage}`
                ]
                  ? form['city_placeholder'][
                      `city_placeholder_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `city_placeholder.city_placeholder_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `city_placeholder.city_placeholder_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`province_label_${selectedLanguage}`"
              >Label for province</label
            >
            <input
              type="text"
              :name="`province_label_${selectedLanguage}`"
              :id="`province_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'province_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['province_label'] &&
                form['province_label'][
                  `province_label_${selectedLanguage}`
                ]
                  ? form['province_label'][
                      `province_label_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `province_label.province_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `province_label.province_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`province_error_${selectedLanguage}`"
              >Error message for province</label
            >
            <input
              type="text"
              :name="`province_error_${selectedLanguage}`"
              :id="`province_error_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'province_error',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['province_error'] &&
                form['province_error'][
                  `province_error_${selectedLanguage}`
                ]
                  ? form['province_error'][
                      `province_error_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `province_error.province_error_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `province_error.province_error_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`province_placeholder_${selectedLanguage}`"
              >Placeholder for province</label
            >
            <input
              type="text"
              :name="`province_placeholder_${selectedLanguage}`"
              :id="`province_placeholder_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'province_placeholder',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['province_placeholder'] &&
                form['province_placeholder'][
                  `province_placeholder_${selectedLanguage}`
                ]
                  ? form['province_placeholder'][
                      `province_placeholder_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `province_placeholder.province_placeholder_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `province_placeholder.province_placeholder_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`industry_label_${selectedLanguage}`"
              >Label for industry</label
            >
            <input
              type="text"
              :name="`industry_label_${selectedLanguage}`"
              :id="`industry_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'industry_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['industry_label'] &&
                form['industry_label'][`industry_label_${selectedLanguage}`]
                  ? form['industry_label'][`industry_label_${selectedLanguage}`]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `industry_label.industry_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `industry_label.industry_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`industry_error_${selectedLanguage}`"
              >Error industry for industry</label
            >
            <input
              type="text"
              :name="`industry_error_${selectedLanguage}`"
              :id="`industry_error_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'industry_error',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['industry_error'] &&
                form['industry_error'][`industry_error_${selectedLanguage}`]
                  ? form['industry_error'][`industry_error_${selectedLanguage}`]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `industry_error.industry_error_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `industry_error.industry_error_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`industry_placeholder_${selectedLanguage}`"
              >Placeholder for industry</label
            >

            <input
              type="text"
              :name="`industry_placeholder_${selectedLanguage}`"
              :id="`industry_placeholder_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'industry_placeholder',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['industry_placeholder'] &&
                form['industry_placeholder'][
                  `industry_placeholder_${selectedLanguage}`
                ]
                  ? form['industry_placeholder'][
                      `industry_placeholder_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `industry_placeholder.industry_placeholder_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `industry_placeholder.industry_placeholder_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`button_text_${selectedLanguage}`"
              >Submit button text</label
            >
            <input
              type="text"
              :name="`button_text_${selectedLanguage}`"
              :id="`button_text_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'button_text',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['button_text'] &&
                form['button_text'][`button_text_${selectedLanguage}`]
                  ? form['button_text'][
                      `button_text_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `button_text.button_text_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `button_text.button_text_${selectedLanguage}`
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
  data() {
    return {
      collapseStates: [true, false, false, false, false, false, false],
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
          url: `${process.env.MIX_ADMIN_API_URL}online-business-directory-setting?withBecomeSponsorSettingDetail=1&findByPageId=${this.form.id}`,
        })
        .then((res) => {
          let data =
            res.data.data && res.data.data.online_business_directory_setting_detail
              ? res.data.data.online_business_directory_setting_detail
              : [];

          let obj = {};
          data.map((res) => {
            obj["keyword_label_" + res.language_id] =
              res.keyword_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "keyword_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["keyword_error_" + res.language_id] =
              res.keyword_error;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "keyword_error",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["keyword_placeholder_" + res.language_id] =
              res.keyword_placeholder;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "keyword_placeholder",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["city_label_" + res.language_id] = res.city_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "city_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["city_error_" + res.language_id] = res.city_error;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "city_error",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["city_placeholder_" + res.language_id] = res.city_placeholder;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "city_placeholder",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["province_label_" + res.language_id] =
              res.province_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "province_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["province_error_" + res.language_id] =
              res.province_error;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "province_error",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["province_placeholder_" + res.language_id] =
              res.province_placeholder;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "province_placeholder",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["industry_label_" + res.language_id] = res.industry_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "industry_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["industry_error_" + res.language_id] = res.industry_error;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "industry_error",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["industry_placeholder_" + res.language_id] =
              res.industry_placeholder;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "industry_placeholder",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["button_text_" + res.language_id] = res.button_text;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "button_text",
            value: obj,
          });
        });
    },
    checkValidationError(validationErros, language) {
      return (
        validationErros.has(
          `keyword_label.keyword_label_${language.id}`
        ) ||
        validationErros.has(
          `keyword_error.keyword_error_${language.id}`
        ) ||
        validationErros.has(
          `keyword_placeholder.keyword_placeholder_${language.id}`
        ) ||
        validationErros.has(
          `city_label.city_label_${language.id}`
        ) ||
        validationErros.has(
          `city_error.city_error_${language.id}`
        ) ||
        validationErros.has(
          `city_placeholder.city_placeholder_${language.id}`
        ) ||
        validationErros.has(
          `province_label.province_label_${language.id}`
        ) ||
        validationErros.has(
          `province_error.province_error_${language.id}`
        ) ||
        validationErros.has(
          `province_placeholder.province_placeholder_${language.id}`
        ) ||
        validationErros.has(
          `industry_label.industry_label_${language.id}`
        ) ||
        validationErros.has(
          `industry_error.industry_error_${language.id}`
        ) ||
        validationErros.has(
          `industry_placeholder.industry_placeholder_${language.id}`
        ) ||
        validationErros.has(
          `button_text.button_text_${language.id}`
        )
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
          obj["keyword_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "keyword_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["keyword_error_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "keyword_error",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["keyword_placeholder_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "keyword_placeholder",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["city_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "city_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["city_error_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "city_error",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["city_placeholder_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "city_placeholder",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["province_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "province_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["province_error_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "province_error",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["province_placeholder_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "province_placeholder",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["industry_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "industry_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["industry_error_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "industry_error",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["industry_placeholder_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "industry_placeholder",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["button_text_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "button_text",
          value: obj,
        });

        if (this.$route.params.id) {
          this.fetchPageSetting();
        }
      });
  },
};
</script>
