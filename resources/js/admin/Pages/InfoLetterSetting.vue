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
                                <span class="text-sm font-medium text-gray-500">Info letter page settings</span>
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
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`company_name_label_${selectedLanguage}`">Label for company name</label>
                        <input type="text" :name="`company_name_label_${selectedLanguage}`"
                            :id="`company_name_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'company_name_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['company_name_label'] &&
                                form['company_name_label'][
                                    `company_name_label_${selectedLanguage}`
                                ] ?
                                form['company_name_label'][
                                    `company_name_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `company_name_label.company_name_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `company_name_label.company_name_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`company_name_error_${selectedLanguage}`">Error message for company name</label>
                        <input type="text" :name="`company_name_error_${selectedLanguage}`"
                            :id="`company_name_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'company_name_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['company_name_error'] &&
                                form['company_name_error'][
                                    `company_name_error_${selectedLanguage}`
                                ] ?
                                form['company_name_error'][
                                    `company_name_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `company_name_error.company_name_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `company_name_error.company_name_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`name_label_${selectedLanguage}`">Label for name</label>
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
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`name_error_${selectedLanguage}`">Error message for name</label>
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
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`email_label_${selectedLanguage}`">Label for email</label>
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
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`email_error_${selectedLanguage}`">Error message for email</label>
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
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`country_label_${selectedLanguage}`">Label for country</label>
                        <input type="text" :name="`country_label_${selectedLanguage}`"
                            :id="`country_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'country_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['country_label'] &&
                                form['country_label'][
                                    `country_label_${selectedLanguage}`
                                ] ?
                                form['country_label'][
                                    `country_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `country_label.country_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `country_label.country_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`country_error_${selectedLanguage}`">Error message for country</label>
                        <input type="text" :name="`country_error_${selectedLanguage}`"
                            :id="`country_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'country_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['country_error'] &&
                                form['country_error'][
                                    `country_error_${selectedLanguage}`
                                ] ?
                                form['country_error'][
                                    `country_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `country_error.country_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `country_error.country_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`button_text_${selectedLanguage}`">Submit button text</label>
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
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`widget_name_${selectedLanguage}`">Banner shortcode</label>
                        <input type="text" :name="`widget_name_${selectedLanguage}`"
                            :id="`widget_name_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'widget_name',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['widget_name'] &&
                                form['widget_name'][
                                    `widget_name_${selectedLanguage}`
                                ] ?
                                form['widget_name'][
                                    `widget_name_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `widget_name.widget_name_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `widget_name.widget_name_${selectedLanguage}`
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
            this.$store.dispatch("pages/addUpdateForm").then(res =>{
                if(res.data.status == 'Success'){

            this.$emit('addUpdateFormParent');
                }
            });
        },
        fetchPageSetting() {
            this.$store
                .dispatch("pages/fetchPage", {
                    url: `${process.env.MIX_ADMIN_API_URL}info-letter-setting?withInfoLetterSettingDetail=1&findByPageId=${this.form.id}`,
                })
                .then((res) => {
                    let data = res.data.data && res.data.data.info_letter_setting_detail
                            ? res.data.data.info_letter_setting_detail
                            : [];

                    let obj = {};
                    data.map((res) => {
                        obj["company_name_label_" + res.language_id] = res.company_name_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "company_name_label",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["company_name_error_" + res.language_id] = res.company_name_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "company_name_error",
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
                        obj["country_label_" + res.language_id] = res.country_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "country_label",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["country_error_" + res.language_id] = res.country_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "country_error",
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

                    obj = {};
                    data.map((res) => {
                        obj["widget_name_" + res.language_id] = res.widget_name;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "widget_name",
                        value: obj,
                    });
                });
        },
        checkValidationError(validationErros, language) {
            return (
                validationErros.has(`company_name_label.company_name_label_${language.id}`) ||
                validationErros.has(`company_name_error.company_name_error_${language.id}`) ||
                validationErros.has(`name_label.name_label_${language.id}`) ||
                validationErros.has(`name_error.name_error_${language.id}`) ||
                validationErros.has(`email_label.email_label_${language.id}`) ||
                validationErros.has(`email_error.email_error_${language.id}`) ||
                validationErros.has(`country_label.country_label_${language.id}`) ||
                validationErros.has(`country_error.country_error_${language.id}`) ||
                validationErros.has(`button_text.button_text_${language.id}`) ||
                validationErros.has(`widget_name.widget_name_${language.id}`)
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
                    obj["company_name_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "company_name_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["company_name_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "company_name_error",
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
                    obj["country_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "country_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["country_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "country_error",
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

                obj = {};
                data.map((res) => {
                    obj["widget_name_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "widget_name",
                    value: obj,
                });

                if(this.$route.params.id){
                    this.fetchPageSetting();
                }
            });
    },
};
</script>
