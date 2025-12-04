<template>
    <div class="my-5" v-for="language in languages" :key="language.id"
        :class="(selectedLanguage == null && language.is_default) ||
        language.id == selectedLanguage ?
            'block' :
            'hidden'">
        <div class="border rounded w-full" :class="collapseStates[0] ? 'bg-gray-50' : ''">
            <div class="flex justify-between bg-primary text-white p-4 cursor-pointer"
                @click.prevent="collapseStates[0] = !collapseStates[0]">
                <h3 class="text-white">
                    Detail section
                </h3>
                <svg class="w-5 h-5 fill-current text-gray-500" viewBox="0 0 20 20">
                    <path d="M6 9l4 4 4-4"></path>
                </svg>
            </div>
            <div class="p-4 bg-gray-100 border-t" v-show="collapseStates[0]">
                <div class="grid my-5 md:gap-6 gap-4">
                    <div class="relative z-0 w-full group">
                        <label :for="`body_text_${selectedLanguage}`">Header text</label>
                        <textarea class="can-exp-input w-full block border border-gray-300 rounded" :name="`body_text_${selectedLanguage}`" :id="`body_text_${selectedLanguage}`" @input="handleInput($event.target.value, language, 'body_text', 'updateHomePageSetting')" v-text="form['body_text'] && form['body_text'][`body_text_${selectedLanguage}`] ? form['body_text'][`body_text_${selectedLanguage}`] : ''"></textarea>
                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `body_text.body_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `body_text.body_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label :for="`email_label_${selectedLanguage}`">Email label</label>
                        <input type="text" :name="`email_label_${selectedLanguage}`"
                            :id="`email_label_${selectedLanguage}`"
                            class="can-exp-input w-full block border border-gray-300 rounded"
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
                        <label :for="`email_error_${selectedLanguage}`">Email error</label>
                        <input type="text" :name="`email_error_${selectedLanguage}`"
                            :id="`email_error_${selectedLanguage}`"
                            class="can-exp-input w-full block border border-gray-300 rounded"
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
                        <label :for="`button_text_${selectedLanguage}`">Button text</label>
                        <input type="text" :name="`button_text_${selectedLanguage}`"
                            :id="`button_text_${selectedLanguage}`"
                            class="can-exp-input w-full block border border-gray-300 rounded"
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
                    url: `${process.env.MIX_ADMIN_API_URL}forget-page-setting?withForgetPageSettingDetail=1&findByPageId=${this.form.id}`,
                })
                .then((res) => {
                    let data = res.data.data && res.data.data.forget_page_setting_detail
                            ? res.data.data.forget_page_setting_detail
                            : [];

                    let obj = {};
                    data.map((res) => {
                        obj["body_text_" + res.language_id] = res.body_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "body_text",
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
                validationErros.has(`body_text.body_text_${language.id}`) ||
                validationErros.has(`email_label.email_label_${language.id}`) ||
                validationErros.has(`email_error.email_error_${language.id}`) ||
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
                    obj["body_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "body_text",
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
                    obj["button_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "button_text",
                    value: obj,
                });

                if(this.$route.params.id){
                    this.fetchPageSetting();
                }
            });
    },
};
</script>