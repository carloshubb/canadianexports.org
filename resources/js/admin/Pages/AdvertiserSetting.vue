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
                <div class="grid my-5 gap-4 md:gap-6">
                    <div class="relative z-0 w-full group">
                        <label :for="`tab1_text_${selectedLanguage}`">Tab 1 label</label>
                        <input type="text" :name="`tab1_text_${selectedLanguage}`"
                            :id="`tab1_text_${selectedLanguage}`"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'tab1_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['tab1_text'] &&
                                form['tab1_text'][
                                    `tab1_text_${selectedLanguage}`
                                ] ?
                                form['tab1_text'][
                                    `tab1_text_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `tab1_text.tab1_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `tab1_text.tab1_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label :for="`tab2_text_${selectedLanguage}`">Tab 2 label</label>
                        <input type="text" :name="`tab2_text_${selectedLanguage}`"
                            :id="`tab2_text_${selectedLanguage}`"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'tab2_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['tab2_text'] &&
                                form['tab2_text'][
                                    `tab2_text_${selectedLanguage}`
                                ] ?
                                form['tab2_text'][
                                    `tab2_text_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `tab2_text.tab2_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `tab2_text.tab2_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label :for="`tab3_text_${selectedLanguage}`">Tab 3 label</label>
                        <input type="text" :name="`tab3_text_${selectedLanguage}`"
                            :id="`tab3_text_${selectedLanguage}`"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'tab3_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['tab3_text'] &&
                                form['tab3_text'][
                                    `tab3_text_${selectedLanguage}`
                                ] ?
                                form['tab3_text'][
                                    `tab3_text_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `tab3_text.tab3_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `tab3_text.tab3_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label :for="`contact_tab_heading_${selectedLanguage}`">Contact tab heading</label>
                        <input type="text" :name="`contact_tab_heading_${selectedLanguage}`"
                            :id="`contact_tab_heading_${selectedLanguage}`"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'contact_tab_heading',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['contact_tab_heading'] &&
                                form['contact_tab_heading'][
                                    `contact_tab_heading_${selectedLanguage}`
                                ] ?
                                form['contact_tab_heading'][
                                    `contact_tab_heading_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `contact_tab_heading.contact_tab_heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `contact_tab_heading.contact_tab_heading_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label :for="`required_fields_text_${selectedLanguage}`">Required fields text</label>
                        <input type="text" :name="`required_fields_text_${selectedLanguage}`"
                            :id="`required_fields_text_${selectedLanguage}`"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'required_fields_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['required_fields_text'] &&
                                form['required_fields_text'][
                                    `required_fields_text_${selectedLanguage}`
                                ] ?
                                form['required_fields_text'][
                                    `required_fields_text_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `required_fields_text.required_fields_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `required_fields_text.required_fields_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label :for="`name_label_${selectedLanguage}`">Name label</label>
                        <input type="text" :name="`name_label_${selectedLanguage}`"
                            :id="`name_label_${selectedLanguage}`"
                            class="can-exp-input w-full block border border-gray-300 rounded"
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
                        <label :for="`name_error_${selectedLanguage}`">Name error</label>
                        <input type="text" :name="`name_error_${selectedLanguage}`"
                            :id="`name_error_${selectedLanguage}`"
                            class="can-exp-input w-full block border border-gray-300 rounded"
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
                        <label :for="`company_name_label_${selectedLanguage}`">Company name label</label>
                        <input type="text" :name="`company_name_label_${selectedLanguage}`"
                            :id="`company_name_label_${selectedLanguage}`"
                            class="can-exp-input w-full block border border-gray-300 rounded"
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
                        <label :for="`company_name_error_${selectedLanguage}`">Company name error</label>
                        <input type="text" :name="`company_name_error_${selectedLanguage}`"
                            :id="`company_name_error_${selectedLanguage}`"
                            class="can-exp-input w-full block border border-gray-300 rounded"
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
                        <label :for="`message_label_${selectedLanguage}`">Message label</label>
                        <input type="text" :name="`message_label_${selectedLanguage}`"
                            :id="`message_label_${selectedLanguage}`"
                            class="can-exp-input w-full block border border-gray-300 rounded"
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
                    <div class="relative z-0 w-full group">
                        <label :for="`message_error_${selectedLanguage}`">Message error</label>
                        <input type="text" :name="`message_error_${selectedLanguage}`"
                            :id="`message_error_${selectedLanguage}`"
                            class="can-exp-input w-full block border border-gray-300 rounded"
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
                    <div class="relative z-0 w-full group">
                        <label :for="`send_me_a_copy_text_${selectedLanguage}`">Send me a copy text</label>
                        <input type="text" :name="`send_me_a_copy_text_${selectedLanguage}`"
                            :id="`send_me_a_copy_text_${selectedLanguage}`"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'send_me_a_copy_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['send_me_a_copy_text'] &&
                                form['send_me_a_copy_text'][
                                    `send_me_a_copy_text_${selectedLanguage}`
                                ] ?
                                form['send_me_a_copy_text'][
                                    `send_me_a_copy_text_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `send_me_a_copy_text.send_me_a_copy_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `send_me_a_copy_text.send_me_a_copy_text_${selectedLanguage}`
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
                    <div class="relative z-0 w-full group">
                        <label :for="`contact_info_heading_${selectedLanguage}`">Contact info heading</label>
                        <input type="text" :name="`contact_info_heading_${selectedLanguage}`"
                            :id="`contact_info_heading_${selectedLanguage}`"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'contact_info_heading',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['contact_info_heading'] &&
                                form['contact_info_heading'][
                                    `contact_info_heading_${selectedLanguage}`
                                ] ?
                                form['contact_info_heading'][
                                    `contact_info_heading_${selectedLanguage}`
                                ] :
                                ''" />


                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `contact_info_heading.contact_info_heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `contact_info_heading.contact_info_heading_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label :for="`mail_address_text_${selectedLanguage}`">Mail address text</label>
                        <input type="text" :name="`mail_address_text_${selectedLanguage}`"
                            :id="`mail_address_text_${selectedLanguage}`"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'mail_address_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['mail_address_text'] &&
                                form['mail_address_text'][
                                    `mail_address_text_${selectedLanguage}`
                                ] ?
                                form['mail_address_text'][
                                    `mail_address_text_${selectedLanguage}`
                                ] :
                                ''" />


                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `mail_address_text.mail_address_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `mail_address_text.mail_address_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label :for="`phone_text_${selectedLanguage}`">Phone text</label>
                        <input type="text" :name="`phone_text_${selectedLanguage}`"
                            :id="`phone_text_${selectedLanguage}`"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'phone_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['phone_text'] &&
                                form['phone_text'][
                                    `phone_text_${selectedLanguage}`
                                ] ?
                                form['phone_text'][
                                    `phone_text_${selectedLanguage}`
                                ] :
                                ''" />


                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `phone_text.phone_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `phone_text.phone_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label :for="`email_text_${selectedLanguage}`">Email text</label>
                        <input type="text" :name="`email_text_${selectedLanguage}`"
                            :id="`email_text_${selectedLanguage}`"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'email_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['email_text'] &&
                                form['email_text'][
                                    `email_text_${selectedLanguage}`
                                ] ?
                                form['email_text'][
                                    `email_text_${selectedLanguage}`
                                ] :
                                ''" />


                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `email_text.email_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `email_text.email_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label :for="`link_text_${selectedLanguage}`">Link text</label>
                        <input type="text" :name="`link_text_${selectedLanguage}`"
                            :id="`link_text_${selectedLanguage}`"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'link_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['link_text'] &&
                                form['link_text'][
                                    `link_text_${selectedLanguage}`
                                ] ?
                                form['link_text'][
                                    `link_text_${selectedLanguage}`
                                ] :
                                ''" />


                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `link_text.link_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `link_text.link_text_${selectedLanguage}`
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
                    url: `${process.env.MIX_ADMIN_API_URL}advertiser-setting?withAdvertiserSettingDetail=1&findByPageId=${this.form.id}`,
                })
                .then((res) => {
                    let data = res.data.data && res.data.data.advertiser_setting_detail
                            ? res.data.data.advertiser_setting_detail
                            : [];

                    let obj = {};
                    data.map((res) => {
                        obj["tab1_text_" + res.language_id] = res.tab1_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "tab1_text",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["tab2_text_" + res.language_id] = res.tab2_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "tab2_text",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["tab3_text_" + res.language_id] = res.tab3_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "tab3_text",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["contact_tab_heading_" + res.language_id] = res.contact_tab_heading;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "contact_tab_heading",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["required_fields_text_" + res.language_id] = res.required_fields_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "required_fields_text",
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
                        obj["send_me_a_copy_text_" + res.language_id] = res.send_me_a_copy_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "send_me_a_copy_text",
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
                        obj["contact_info_heading_" + res.language_id] = res.contact_info_heading;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "contact_info_heading",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["mail_address_text_" + res.language_id] = res.mail_address_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "mail_address_text",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["phone_text_" + res.language_id] = res.phone_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "phone_text",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["email_text_" + res.language_id] = res.email_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "email_text",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["link_text_" + res.language_id] = res.link_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "link_text",
                        value: obj,
                    });
                });
        },
        checkValidationError(validationErros, language) {
            return (
                validationErros.has(`tab1_text.tab1_text_${language.id}`) ||
                validationErros.has(`tab2_text.tab2_text_${language.id}`) ||
                validationErros.has(`tab3_text.tab3_text_${language.id}`) ||
                validationErros.has(`contact_tab_heading.contact_tab_heading_${language.id}`) ||
                validationErros.has(`required_fields_text.required_fields_text_${language.id}`) ||
                validationErros.has(`name_label.name_label_${language.id}`) ||
                validationErros.has(`name_error.name_error_${language.id}`) ||
                validationErros.has(`company_name_label.company_name_label_${language.id}`) ||
                validationErros.has(`company_name_error.company_name_error_${language.id}`) ||
                validationErros.has(`email_label.email_label_${language.id}`) ||
                validationErros.has(`email_error.email_error_${language.id}`) ||
                validationErros.has(`message_label.message_label_${language.id}`) ||
                validationErros.has(`message_error.message_error_${language.id}`) ||
                validationErros.has(`send_me_a_copy_text.send_me_a_copy_text_${language.id}`) ||
                validationErros.has(`button_text.button_text_${language.id}`) ||
                validationErros.has(`contact_info_heading.contact_info_heading_${language.id}`) ||
                validationErros.has(`mail_address_text.mail_address_text_${language.id}`) ||
                validationErros.has(`phone_text.phone_text_${language.id}`) ||
                validationErros.has(`email_text.email_text_${language.id}`) ||
                validationErros.has(`link_text.link_text_${language.id}`)
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
                    obj["tab1_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "tab1_text",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["tab2_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "tab2_text",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["tab3_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "tab3_text",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["contact_tab_heading_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "contact_tab_heading",
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
                    obj["send_me_a_copy_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "send_me_a_copy_text",
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
                    obj["contact_info_heading_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "contact_info_heading",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["mail_address_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "mail_address_text",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["phone_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "phone_text",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["email_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "email_text",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["link_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "link_text",
                    value: obj,
                });

                if(this.$route.params.id){
                    this.fetchPageSetting();
                }
            });
    },
};
</script>
