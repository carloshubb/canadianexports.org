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
                                <span class="text-sm font-medium">User sponsers settings</span>
                                <span class="text-sm font-medium text-gray-500">User sponsers page settings</span>
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
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`no_sponser_found_text_${selectedLanguage}`">No sponser found text</label>
                        <input type="text" :name="`no_sponser_found_text_${selectedLanguage}`"
                            :id="`no_sponser_found_text_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'no_sponser_found_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['no_sponser_found_text'] &&
                                form['no_sponser_found_text'][
                                    `no_sponser_found_text_${selectedLanguage}`
                                ] ?
                                form['no_sponser_found_text'][
                                    `no_sponser_found_text_${selectedLanguage}`
                                ] :
                                ''" />


                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `no_sponser_found_text.no_sponser_found_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `no_sponser_found_text.no_sponser_found_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`user_has_sponser_text_${selectedLanguage}`">User has sponser text</label>
                        <input type="text" :name="`user_has_sponser_text_${selectedLanguage}`"
                            :id="`user_has_sponser_text_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'user_has_sponser_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['user_has_sponser_text'] &&
                                form['user_has_sponser_text'][
                                    `user_has_sponser_text_${selectedLanguage}`
                                ] ?
                                form['user_has_sponser_text'][
                                    `user_has_sponser_text_${selectedLanguage}`
                                ] :
                                ''" />


                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `user_has_sponser_text.user_has_sponser_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `user_has_sponser_text.user_has_sponser_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`upgrade_profile_btn_text_${selectedLanguage}`">Upgrade profile button text</label>
                        <input type="text" :name="`upgrade_profile_btn_text_${selectedLanguage}`"
                            :id="`upgrade_profile_btn_text_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'upgrade_profile_btn_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['upgrade_profile_btn_text'] &&
                                form['upgrade_profile_btn_text'][
                                    `upgrade_profile_btn_text_${selectedLanguage}`
                                ] ?
                                form['upgrade_profile_btn_text'][
                                    `upgrade_profile_btn_text_${selectedLanguage}`
                                ] :
                                ''" />


                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `upgrade_profile_btn_text.upgrade_profile_btn_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `upgrade_profile_btn_text.upgrade_profile_btn_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`add_sponser_btn_text_${selectedLanguage}`">Add sponser button text</label>
                        <input type="text" :name="`add_sponser_btn_text_${selectedLanguage}`"
                            :id="`add_sponser_btn_text_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'add_sponser_btn_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['add_sponser_btn_text'] &&
                                form['add_sponser_btn_text'][
                                    `add_sponser_btn_text_${selectedLanguage}`
                                ] ?
                                form['add_sponser_btn_text'][
                                    `add_sponser_btn_text_${selectedLanguage}`
                                ] :
                                ''" />


                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `add_sponser_btn_text.add_sponser_btn_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `add_sponser_btn_text.add_sponser_btn_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`search_placeholder_text_${selectedLanguage}`">Search placeholder text</label>
                        <input type="text" :name="`search_placeholder_text_${selectedLanguage}`"
                            :id="`search_placeholder_text_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'search_placeholder_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['search_placeholder_text'] &&
                                form['search_placeholder_text'][
                                    `search_placeholder_text_${selectedLanguage}`
                                ] ?
                                form['search_placeholder_text'][
                                    `search_placeholder_text_${selectedLanguage}`
                                ] :
                                ''" />


                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `search_placeholder_text.search_placeholder_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `search_placeholder_text.search_placeholder_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`show_text_${selectedLanguage}`">Show text</label>
                        <input type="text" :name="`show_text_${selectedLanguage}`"
                            :id="`show_text_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'show_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['show_text'] &&
                                form['show_text'][
                                    `show_text_${selectedLanguage}`
                                ] ?
                                form['show_text'][
                                    `show_text_${selectedLanguage}`
                                ] :
                                ''" />


                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `show_text.show_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `show_text.show_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`sponser_text_${selectedLanguage}`">Sponser text</label>
                        <input type="text" :name="`sponser_text_${selectedLanguage}`"
                            :id="`sponser_text_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'sponser_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['sponser_text'] &&
                                form['sponser_text'][
                                    `sponser_text_${selectedLanguage}`
                                ] ?
                                form['sponser_text'][
                                    `sponser_text_${selectedLanguage}`
                                ] :
                                ''" />


                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `sponser_text.sponser_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `sponser_text.sponser_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`title_text_${selectedLanguage}`">Title text</label>
                        <input type="text" :name="`title_text_${selectedLanguage}`"
                            :id="`title_text_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'title_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['title_text'] &&
                                form['title_text'][
                                    `title_text_${selectedLanguage}`
                                ] ?
                                form['title_text'][
                                    `title_text_${selectedLanguage}`
                                ] :
                                ''" />


                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `title_text.title_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `title_text.title_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`action_text_${selectedLanguage}`">Action text</label>
                        <input type="text" :name="`action_text_${selectedLanguage}`"
                            :id="`action_text_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'action_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['action_text'] &&
                                form['action_text'][
                                    `action_text_${selectedLanguage}`
                                ] ?
                                form['action_text'][
                                    `action_text_${selectedLanguage}`
                                ] :
                                ''" />


                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `action_text.action_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `action_text.action_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`edit_button_text_${selectedLanguage}`">Edit button text</label>
                        <input type="text" :name="`edit_button_text_${selectedLanguage}`"
                            :id="`edit_button_text_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'edit_button_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['edit_button_text'] &&
                                form['edit_button_text'][
                                    `edit_button_text_${selectedLanguage}`
                                ] ?
                                form['edit_button_text'][
                                    `edit_button_text_${selectedLanguage}`
                                ] :
                                ''" />


                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `edit_button_text.edit_button_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `edit_button_text.edit_button_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`start_at_end_at_text_${selectedLanguage}`">Date text</label>
                        <input type="text" :name="`start_at_end_at_text_${selectedLanguage}`"
                            :id="`start_at_end_at_text_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'start_at_end_at_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['start_at_end_at_text'] &&
                                form['start_at_end_at_text'][
                                    `start_at_end_at_text_${selectedLanguage}`
                                ] ?
                                form['start_at_end_at_text'][
                                    `start_at_end_at_text_${selectedLanguage}`
                                ] :
                                ''" />


                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `start_at_end_at_text.start_at_end_at_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `start_at_end_at_text.start_at_end_at_text_${selectedLanguage}`
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
                    url: `${process.env.MIX_ADMIN_API_URL}sponser-listing-setting?withSponserListingSettingDetail=1&findByPageId=${this.form.id}`,
                })
                .then((res) => {
                    let data = res.data.data && res.data.data.sponser_listing_setting_detail
                            ? res.data.data.sponser_listing_setting_detail
                            : [];

                    let obj = {};
                    data.map((res) => {
                        obj["no_sponser_found_text_" + res.language_id] = res.no_sponser_found_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "no_sponser_found_text",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["user_has_sponser_text_" + res.language_id] = res.user_has_sponser_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "user_has_sponser_text",
                        value: obj,
                    });
                    data.map((res) => {
                        obj["add_sponser_btn_text_" + res.language_id] = res.add_sponser_btn_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "add_sponser_btn_text",
                        value: obj,
                    });
                    data.map((res) => {
                        obj["upgrade_profile_btn_text_" + res.language_id] = res.upgrade_profile_btn_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "upgrade_profile_btn_text",
                        value: obj,
                    });
                    data.map((res) => {
                        obj["search_placeholder_text_" + res.language_id] = res.search_placeholder_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "search_placeholder_text",
                        value: obj,
                    });
                    data.map((res) => {
                        obj["show_text_" + res.language_id] = res.show_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "show_text",
                        value: obj,
                    });
                    data.map((res) => {
                        obj["sponser_text_" + res.language_id] = res.sponser_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "sponser_text",
                        value: obj,
                    });
                    data.map((res) => {
                        obj["title_text_" + res.language_id] = res.title_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "title_text",
                        value: obj,
                    });
                    data.map((res) => {
                        obj["action_text_" + res.language_id] = res.action_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "action_text",
                        value: obj,
                    });
                    data.map((res) => {
                        obj["edit_button_text_" + res.language_id] = res.edit_button_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "edit_button_text",
                        value: obj,
                    });
                    data.map((res) => {
                        obj["start_at_end_at_text_" + res.language_id] = res.start_at_end_at_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "start_at_end_at_text",
                        value: obj,
                    });
                });
        },
        checkValidationError(validationErros, language) {
            return (
                validationErros.has(`no_sponser_found_text.no_sponser_found_text_${language.id}`) ||
                validationErros.has(`user_has_sponser_text.user_has_sponser_text_${language.id}`) ||
                validationErros.has(`add_sponser_btn_text.add_sponser_btn_text_${language.id}`) ||
                validationErros.has(`upgrade_profile_btn_text.upgrade_profile_btn_text_${language.id}`) ||
                validationErros.has(`search_placeholder_text.search_placeholder_text_${language.id}`) ||
                validationErros.has(`show_text.show_text_${language.id}`) ||
                validationErros.has(`sponser_text.sponser_text_${language.id}`) ||
                validationErros.has(`action_text.action_text_${language.id}`) ||
                validationErros.has(`edit_button_text.edit_button_text_${language.id}`) ||
                validationErros.has(`start_at_end_at_text.start_at_end_at_text_${language.id}`) ||
                validationErros.has(`title_text.title_text_${language.id}`)
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
                    obj["no_sponser_found_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "no_sponser_found_text",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["user_has_sponser_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "user_has_sponser_text",
                    value: obj,
                });
                data.map((res) => {
                    obj["add_sponser_btn_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "add_sponser_btn_text",
                    value: obj,
                });
                data.map((res) => {
                    obj["upgrade_profile_btn_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "upgrade_profile_btn_text",
                    value: obj,
                });
                data.map((res) => {
                    obj["search_placeholder_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "search_placeholder_text",
                    value: obj,
                });
                data.map((res) => {
                    obj["show_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "show_text",
                    value: obj,
                });
                data.map((res) => {
                    obj["sponser_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "sponser_text",
                    value: obj,
                });
                data.map((res) => {
                    obj["title_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "title_text",
                    value: obj,
                });
                data.map((res) => {
                    obj["action_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "action_text",
                    value: obj,
                });
                data.map((res) => {
                    obj["edit_button_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "edit_button_text",
                    value: obj,
                });
                data.map((res) => {
                    obj["start_at_end_at_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "start_at_end_at_text",
                    value: obj,
                });

                if(this.$route.params.id){
                    this.fetchPageSetting();
                }
            });
    },
};
</script>
