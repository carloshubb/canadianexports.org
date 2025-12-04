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
                                <span class="text-sm font-medium">Page & form settings</span>
                                <span class="text-sm font-medium text-gray-500">Comments / Suggesions page & form settings</span>
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
            <div class="p-4 bg-gray-50 border-t" v-show="collapseStates[0]">
                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`page_heading_${selectedLanguage}`">Page heading</label>
                        <input type="text" :name="`page_heading_${selectedLanguage}`"
                            :id="`page_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'page_heading',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['page_heading'] &&
                                form['page_heading'][
                                    `page_heading_${selectedLanguage}`
                                ] ?
                                form['page_heading'][
                                    `page_heading_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `page_heading.page_heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `page_heading.page_heading_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-6" v-if="isDataLoaded">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`page_description_${selectedLanguage}`">Description</label>
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
                            :initial-value="form[`page_description`][`page_description_${language?.id}`]
                            "
                            :tinymce-script-src="tinymceScriptSrc"
                            :init="editorConfig"
                        />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `page_description.page_description_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `page_description.page_description_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`heading_${selectedLanguage}`">Heading</label>
                        <input type="text" :name="`heading_${selectedLanguage}`"
                            :id="`heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'heading',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['heading'] &&
                                form['heading'][
                                    `heading_${selectedLanguage}`
                                ] ?
                                form['heading'][
                                    `heading_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `heading.heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `heading.heading_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`required_field_text_${selectedLanguage}`">Required field text</label>
                        <input type="text" :name="`required_field_text_${selectedLanguage}`"
                            :id="`required_field_text_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'required_field_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['required_field_text'] &&
                                form['required_field_text'][
                                    `required_field_text_${selectedLanguage}`
                                ] ?
                                form['required_field_text'][
                                    `required_field_text_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `required_field_text.required_field_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `required_field_text.required_field_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`name_label_${selectedLanguage}`">Name label</label>
                        <input type="text" :name="`name_label_${selectedLanguage}`"
                            :id="`name_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'name_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['name_label'] &&
                                form['name_label'][
                                    `name_label_${selectedLanguage}`
                                ] ?
                                form['name_label'][
                                    `name_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `name_label.name_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `name_label.name_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`name_error_${selectedLanguage}`">Name error</label>
                        <input type="text" :name="`name_error_${selectedLanguage}`"
                            :id="`name_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'name_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['name_error'] &&
                                form['name_error'][
                                    `name_error_${selectedLanguage}`
                                ] ?
                                form['name_error'][
                                    `name_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `name_error.name_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `name_error.name_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-2">
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
                    <div class="sm:col-span-2">
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
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`message_label_${selectedLanguage}`">Message label</label>
                        <input type="text" :name="`message_label_${selectedLanguage}`"
                            :id="`message_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'message_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['message_label'] &&
                                form['message_label'][
                                    `message_label_${selectedLanguage}`
                                ] ?
                                form['message_label'][
                                    `message_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `message_label.message_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `message_label.message_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`message_error_${selectedLanguage}`">Message error</label>
                        <input type="text" :name="`message_error_${selectedLanguage}`"
                            :id="`message_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'message_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['message_error'] &&
                                form['message_error'][
                                    `message_error_${selectedLanguage}`
                                ] ?
                                form['message_error'][
                                    `message_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `message_error.message_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `message_error.message_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`button_text_${selectedLanguage}`">Button text</label>
                        <input type="text" :name="`button_text_${selectedLanguage}`"
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
                            :value="form['button_text'] &&
                                form['button_text'][
                                    `button_text_${selectedLanguage}`
                                ] ?
                                form['button_text'][
                                    `button_text_${selectedLanguage}`
                                ] :
                                ''" />


                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `button_text.button_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `button_text.button_text_${selectedLanguage}`
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
            collapseStates: [true, false, false, false, false, false, false],
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
                    url: `${process.env.MIX_ADMIN_API_URL}comments-setting?withCommentsSettingDetail=1&findByPageId=${this.form.id}`,
                })
                .then((res) => {
                    let data = res.data.data && res.data.data.comments_setting_detail
                            ? res.data.data.comments_setting_detail
                            : [];

                    let obj = {};
                    data.map((res) => {
                        obj["page_heading_" + res.language_id] = res.page_heading;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "page_heading",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["page_description_" + res.language_id] = res.page_description;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "page_description",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["heading_" + res.language_id] = res.heading;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "heading",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["required_field_text_" + res.language_id] = res.required_field_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "required_field_text",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["name_label_" + res.language_id] = res.name_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "name_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["name_error_" + res.language_id] = res.name_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "name_error",
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
                        obj["message_label_" + res.language_id] = res.message_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "message_label",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["message_error_" + res.language_id] = res.message_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "message_error",
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
                    this.isDataLoaded = 1;
                });
        },
        checkValidationError(validationErros, language) {
            return (
                validationErros.has(`page_heading.page_heading_${language.id}`) ||
                validationErros.has(`page_description.page_description_${language.id}`) ||
                validationErros.has(`heading.heading_${language.id}`) ||
                validationErros.has(`required_field_text.required_field_text_${language.id}`) ||
                validationErros.has(`name_label.name_label_${language.id}`) ||
                validationErros.has(`name_error.name_error_${language.id}`) ||
                validationErros.has(`email_label.email_label_${language.id}`) ||
                validationErros.has(`email_error.email_error_${language.id}`) ||
                validationErros.has(`message_label.message_label_${language.id}`) ||
                validationErros.has(`message_error.message_error_${language.id}`) ||
                validationErros.has(`button_text.button_text_${language.id}`)
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
                    obj["page_heading_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "page_heading",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["page_description_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "page_description",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["heading_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "heading",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["required_field_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "required_field_text",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["name_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "name_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["name_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "name_error",
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
                    obj["message_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "message_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["message_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "message_error",
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
