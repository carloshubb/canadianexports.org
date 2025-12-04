<template>
    <div class="my-5" v-for="language in languages" :key="language.id"
        :class="(selectedLanguage == null && language.is_default) ||
        language.id == selectedLanguage ?
            'block' :
            'hidden'">
        <div class="border rounded w-full" :class="collapseStates[0] ? 'bg-blue-50' : ''">
            <div class="lg:border-b lg:border-t lg:border-gray-200 cursor-pointer" @click.prevent="collapseStates[0] = !collapseStates[0]">
                <nav class="mx-auto" aria-label="Section">
                    <ol role="list" class="overflow-hidden rounded-md lg:flex lg:rounded-none lg:border-l lg:border-r lg:border-gray-200">
                    <li class="relative overflow-hidden lg:flex-1">
                        <div class="overflow-hidden border border-gray-200 rounded-t-md border-b-0 lg:border-0 flex justify-between items-center">
                        <div class="group w-full">
                            <span class="absolute left-0 top-0 h-full w-1 bg-transparent group-hover:bg-primary lg:bottom-0 lg:top-auto lg:h-1 lg:w-full" aria-hidden="true"></span>
                            <span class="flex items-start px-6 py-2 text-sm font-medium">
                            <span class="flex-shrink-0">
                                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-white">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                                    </svg>
                                </span>
                            </span>
                            <span class="ml-4 mt-0.5 flex min-w-0 flex-col">
                                <span class="text-sm font-medium">Page settings</span>
                                <span class="text-sm font-medium text-gray-500">Page setting for Log in page</span>
                            </span>
                            </span>
                        </div>
                        <svg class="w-5 h-5 fill-current text-gray-500" viewBox="0 0 20 20">
                            <path d="M6 9l4 4 4-4"></path>
                        </svg>
                        </div>
                    </li>
                    </ol>
                </nav>
            </div>
            <div class="p-4 bg-gray-50 border-t" v-if="collapseStates[0]">
                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="col-span-6" v-if="isDataLoaded">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`main_heading_${selectedLanguage}`">Heading</label>
                        <editor
                            @mouseleave="
                                handleSelectionChange(
                                    language,
                                    'main_heading',
                                    'updateHomePageSetting'
                                )
                            "
                            @keyup="
                                handleSelectionChange(
                                    language,
                                    'main_heading',
                                    'updateHomePageSetting'
                                )
                            "
                            :ref="`main_heading_${language.id}`"
                            :id="`main_heading_${language.id}`"
                            :initial-value="form[`main_heading`][`main_heading_${language?.id}`]
                            "
                            :tinymce-script-src="tinymceScriptSrc"
                            :init="editorConfig"
                        />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `main_heading.main_heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `main_heading.main_heading_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
              <label
                class="block text-sm font-medium leading-6 text-gray-900"
                :for="`required_fields_text_${selectedLanguage}`"
                >Required fields text</label
              >
              <input
                type="text"
                :name="`required_fields_text_${selectedLanguage}`"
                :id="`required_fields_text_${selectedLanguage}`"
                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                placeholder=" "
                @input="
                  handleInput(
                    $event.target.value,
                    language,
                    'required_fields_text',
                    'updateHomePageSetting'
                  )
                "
                :value="
                  form['required_fields_text'] &&
                  form['required_fields_text'][
                    `required_fields_text_${selectedLanguage}`
                  ]
                    ? form['required_fields_text'][
                        `required_fields_text_${selectedLanguage}`
                      ]
                    : ''
                "
              />

              <p
                class="mt-2 text-sm text-red-400"
                v-if="
                  validationErros.has(
                    `required_fields_text.required_fields_text_${selectedLanguage}`
                  )
                "
                v-text="
                  validationErros.get(
                    `required_fields_text.required_fields_text_${selectedLanguage}`
                  )
                "
              ></p>
            </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`email_label_${selectedLanguage}`">Email label</label>
                        <input type="text" :name="`email_label_${selectedLanguage}`"
                            :id="`email_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'email_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['email_label'] &&
                                form['email_label'][
                                    `email_label_${selectedLanguage}`
                                ] ?
                                form['email_label'][
                                    `email_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `email_label.email_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `email_label.email_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`email_error_${selectedLanguage}`">Email error</label>
                        <input type="text" :name="`email_error_${selectedLanguage}`"
                            :id="`email_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'email_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['email_error'] &&
                                form['email_error'][
                                    `email_error_${selectedLanguage}`
                                ] ?
                                form['email_error'][
                                    `email_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `email_error.email_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `email_error.email_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`email_help_${selectedLanguage}`">Email help text</label>
                        <input type="text" :name="`email_help_${selectedLanguage}`"
                            :id="`email_help_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'email_help',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['email_help'] &&
                                form['email_help'][
                                    `email_help_${selectedLanguage}`
                                ] ?
                                form['email_help'][
                                    `email_help_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `email_help.email_help_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `email_help.email_help_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`password_label_${selectedLanguage}`">Password label</label>
                        <input type="text" :name="`password_label_${selectedLanguage}`"
                            :id="`password_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'password_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['password_label'] &&
                                form['password_label'][
                                    `password_label_${selectedLanguage}`
                                ] ?
                                form['password_label'][
                                    `password_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `password_label.password_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `password_label.password_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`password_error_${selectedLanguage}`">Password error</label>
                        <input type="text" :name="`password_error_${selectedLanguage}`"
                            :id="`password_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'password_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['password_error'] &&
                                form['password_error'][
                                    `password_error_${selectedLanguage}`
                                ] ?
                                form['password_error'][
                                    `password_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `password_error.password_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `password_error.password_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`remeber_me_label_${selectedLanguage}`">Password label</label>
                        <input type="text" :name="`remeber_me_label_${selectedLanguage}`"
                            :id="`remeber_me_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'remeber_me_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['remeber_me_label'] &&
                                form['remeber_me_label'][
                                    `remeber_me_label_${selectedLanguage}`
                                ] ?
                                form['remeber_me_label'][
                                    `remeber_me_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `remeber_me_label.remeber_me_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `remeber_me_label.remeber_me_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`forgot_password_text_${selectedLanguage}`">Forgot password text</label>
                        <input type="text" :name="`forgot_password_text_${selectedLanguage}`"
                            :id="`forgot_password_text_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'forgot_password_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['forgot_password_text'] &&
                                form['forgot_password_text'][
                                    `forgot_password_text_${selectedLanguage}`
                                ] ?
                                form['forgot_password_text'][
                                    `forgot_password_text_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `forgot_password_text.forgot_password_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `forgot_password_text.forgot_password_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`signin_btn_text_${selectedLanguage}`">Sign in </label>
                        <input type="text" :name="`signin_btn_text_${selectedLanguage}`"
                            :id="`signin_btn_text_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'signin_btn_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['signin_btn_text'] &&
                                form['signin_btn_text'][
                                    `signin_btn_text_${selectedLanguage}`
                                ] ?
                                form['signin_btn_text'][
                                    `signin_btn_text_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `signin_btn_text.signin_btn_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `signin_btn_text.signin_btn_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="col-span-6" v-if="isDataLoaded">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`signup_btn_text_${selectedLanguage}`">Sign up text </label>
                        <editor
                            @mouseleave="
                                handleSelectionChange(
                                    language,
                                    'signup_btn_text',
                                    'updateHomePageSetting'
                                )
                            "
                            @keyup="
                                handleSelectionChange(
                                    language,
                                    'signup_btn_text',
                                    'updateHomePageSetting'
                                )
                            "
                            :ref="`signup_btn_text_${language.id}`"
                            :id="`signup_btn_text_${language.id}`"
                            :initial-value="form[`signup_btn_text`][`signup_btn_text_${language?.id}`]
                            "
                            :tinymce-script-src="tinymceScriptSrc"
                            :init="editorConfig"
                        />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `signup_btn_text.signup_btn_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `signup_btn_text.signup_btn_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`protect_account_heading_${selectedLanguage}`">Protect your account heading </label>
                        <input type="text" :name="`protect_account_heading_${selectedLanguage}`"
                            :id="`protect_account_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'protect_account_heading',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['protect_account_heading'] &&
                                form['protect_account_heading'][
                                    `protect_account_heading_${selectedLanguage}`
                                ] ?
                                form['protect_account_heading'][
                                    `protect_account_heading_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `protect_account_heading.protect_account_heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `protect_account_heading.protect_account_heading_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="col-span-6" v-if="isDataLoaded">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`protect_account_description_${selectedLanguage}`">Protect your account description </label>
                        <editor
                            @mouseleave="
                                handleSelectionChange(
                                    language,
                                    'protect_account_description',
                                    'updateHomePageSetting'
                                )
                            "
                            @keyup="
                                handleSelectionChange(
                                    language,
                                    'protect_account_description',
                                    'updateHomePageSetting'
                                )
                            "
                            :ref="`protect_account_description_${language.id}`"
                            :id="`protect_account_description_${language.id}`"
                            :initial-value="form[`protect_account_description`][`protect_account_description_${language?.id}`]
                            "
                            :tinymce-script-src="tinymceScriptSrc"
                            :init="editorConfig"
                        />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `protect_account_description.protect_account_description_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `protect_account_description.protect_account_description_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</template>


<script>
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
          base_url: '/plugins/tinymce',
          suffix: '.min'
      },
      tinymceScriptSrc: '/plugins/tinymce/tinymce.min.js',
        };
    },
    methods: {
        handleSelectionChange(language, key, mutationName) {
            this.handleInput(
                tinymce.get(`${key}_${language.id}`).getContent(),
                language,
                key,
                mutationName
            );
        },
        handleInput(value, language, key, mutationName) {
            // console.log(value, key, language, mutationName);
            this.$store.commit(`pages/${mutationName}`, {
                value: value,
                id: language.id,
                key,
            });
        },
        addUpdateForm() {
            this.$store.dispatch("pages/addUpdateForm").then(res =>{
                if(res.data.status == 'Success'){

            this.$emit('addUpdateFormParent');
                }
            });
        },
        fetchPageSetting() {
            this.$store
                .dispatch("pages/fetchPage", {
                    url: `${process.env.MIX_ADMIN_API_URL}login-page-setting?withLoginPageSettingDetail=1&findByPageId=${this.form.id}`,
                })
                .then((res) => {
                    let data = res.data.data && res.data.data.login_page_setting_detail
                            ? res.data.data.login_page_setting_detail
                            : [];

                    let obj = {};
                    data.map((res) => {
                        obj["main_heading_" + res.language_id] = res.main_heading;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "main_heading",
                        value: obj,
                    });
                    obj = {};
            data.map((res) => {
              obj["required_fields_text_" + res.language_id] =
                res.required_fields_text;
            });
            this.$store.commit("pages/setHomePageSetting", {
              key: "required_fields_text",
              value: obj,
            });
                    obj = {};
                    data.map((res) => {
                        obj["email_label_" + res.language_id] = res.email_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "email_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["email_error_" + res.language_id] = res.email_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "email_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["email_help_" + res.language_id] = res.email_help;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "email_help",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["password_label_" + res.language_id] = res.password_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "password_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["password_error_" + res.language_id] = res.password_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "password_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["remeber_me_label_" + res.language_id] = res.remeber_me_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "remeber_me_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["forgot_password_text_" + res.language_id] = res.forgot_password_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "forgot_password_text",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["signin_btn_text_" + res.language_id] = res.signin_btn_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "signin_btn_text",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["protect_account_heading_" + res.language_id] = res.protect_account_heading;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "protect_account_heading",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["signup_btn_text_" + res.language_id] = res.signup_btn_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "signup_btn_text",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["protect_account_description_" + res.language_id] = res.protect_account_description;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "protect_account_description",
                        value: obj,
                    });
                    this.isDataLoaded = 1;
                });
        },
        checkValidationError(validationErros, language) {
            return (
                validationErros.has(`page_description.page_description_${language.id}`)
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
                    obj["main_heading_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "main_heading",
                    value: obj,
                });
                obj = {};
          data.map((res) => {
            obj["required_fields_text_" + res.id] = "";
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "required_fields_text",
            value: obj,
          });
                obj = {};
                data.map((res) => {
                    obj["email_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "email_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["email_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "email_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["email_help_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "email_help",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["password_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "password_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["password_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "password_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["remeber_me_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "remeber_me_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["forgot_password_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "forgot_password_text",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["signin_btn_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "signin_btn_text",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["protect_account_heading_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "protect_account_heading",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["signup_btn_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "signup_btn_text",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["protect_account_description_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "protect_account_description",
                    value: obj,
                });

                if(this.$route.params.id){
                    this.fetchPageSetting();
                }
                else{
                    this.isDataLoaded = 1;
                }
            });
    },
};
</script>
<style>
.tox-notification { display: none !important }
</style>
