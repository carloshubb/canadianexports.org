<template>
    <AppLayout>
        <div class="relative shadow-md sm:rounded-lg bg-white py-4">
            <header class="pt-4">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h3 class="can-exp-h3 text-primary"> {{isFormEdit ? 'Edit' : 'Create'}} footer setting </h3>
                        <router-link :to="{ name: 'admin.footer-setting.index'}" class="button-exp-fill">
                            Back
                        </router-link>
                    </div>
                </div>
            </header>
            <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
                <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200">
                    <ul class="flex flex-wrap mb-2 overflow-x-auto gap-1 mt-4">
                        <li class="mr-2" v-for="language in languages" :key="language.id">
                            <a @click.prevent="changeLanguageTab(language)" href="#"
                                :class="['inline-block rounded font-FuturaMdCnBT px-5 py-2 lg:text-lg md:text-base sm:text-base text-base hover:bg-blue-100 border border-primary text-center hover:border-blue-500 hover:text-blue-600',
                                    ((activeTab == null && language.is_active) || activeTab == language.id ?
                                        'bg-blue-600 text-white' : ''), (validationErros.has(
                                        `widget1.widget1_${language.id}`) || validationErros.has(
                                        `widget2.widget2_${language.id}`) || validationErros.has(
                                        `widget3.widget3_${language.id}`) || validationErros.has(
                                        `copyright_text.copyright_text_${language.id}`) ? 'bg-red-600 border-red-600 text-white hover:text-white rounded hover:bg-red-600 hover:border-red-600' : '')
                                ]">{{ language . name }}</a>
                        </li>
                    </ul>
                </div>

                <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2  lg:grid-cols-2 gap-6 " v-for="language in languages" :key="language.id"
                    :class="(activeTab == null && language.is_active) || activeTab == language.id ? 'block' : 'hidden'">
                    <div class="relative z-0 w-full group">
                        <label for="copyright_text">Copyright text</label>
                        <input type="text" name="copyright_text" id="copyright_text"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" " @input="handleInput($event.target.value, language, 'copyright_text')"
                            :value="form['copyright_text'] && form['copyright_text'][`copyright_text_${language.id}`] ? form[
                                'copyright_text'][`copyright_text_${language.id}`] : ''" />
                        <p class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has(`copyright_text.copyright_text_${language.id}`)"
                            v-text="validationErros.get(`copyright_text.copyright_text_${language.id}`)"></p>
                    </div>
                    <div class="relative z-0 w-full group" v-if="isDataLoaded">
                        <label :for="`widget1_${language?.id}`">Widget 1 text</label>
                        <editor
                            @mouseleave="
                                handleSelectionChange(
                                    language,
                                    'widget1'
                                )
                            "
                            @keyup="
                                handleSelectionChange(
                                    language,
                                    'widget1'
                                )
                            "
                            :ref="`widget1_${language.id}`"
                            :id="`widget1_${language.id}`"
                            :initial-value="form[`widget1`][`widget1_${language?.id}`]
                            "
                            :tinymce-script-src="tinymceScriptSrc"
                            :init="editorConfig"
                        />

                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`widget1.widget1_${language.id}`)"
                            v-text="validationErros.get(`widget1.widget1_${language.id}`)"></p>
                    </div>
                    <div class="relative z-0 w-full group" v-if="isDataLoaded">
                        <label :for="`widget2_${language?.id}`">Widget 2 text</label>
                        <editor
                            @mouseleave="
                                handleSelectionChange(
                                    language,
                                    'widget2'
                                )
                            "
                            @keyup="
                                handleSelectionChange(
                                    language,
                                    'widget2'
                                )
                            "
                            :ref="`widget2_${language.id}`"
                            :id="`widget2_${language.id}`"
                            :initial-value="form[`widget2`][`widget2_${language?.id}`]
                            "
                            :tinymce-script-src="tinymceScriptSrc"
                            :init="editorConfig"
                        />

                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`widget2.widget2_${language.id}`)"
                            v-text="validationErros.get(`widget2.widget2_${language.id}`)"></p>
                    </div>

                    <div class="relative z-0 w-full group" v-if="isDataLoaded">
                        <label :for="`widget3_${language?.id}`">Widget 3 text</label>
                        <editor
                            @mouseleave="
                                handleSelectionChange(
                                    language,
                                    'widget3'
                                )
                            "
                            @keyup="
                                handleSelectionChange(
                                    language,
                                    'widget3'
                                )
                            "
                            :ref="`widget3_${language.id}`"
                            :id="`widget3_${language.id}`"
                            :initial-value="form[`widget3`][`widget3_${language?.id}`]
                            "
                            :tinymce-script-src="tinymceScriptSrc"
                            :init="editorConfig"
                        />

                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`widget3.widget3_${language.id}`)"
                            v-text="validationErros.get(`widget3.widget3_${language.id}`)"></p>
                    </div>

                </div>

                <div class="grid md:grid-cols-2 md:gap-6 gap-4">
                    <div class="relative z-0 w-full group">
                        <label for="widget1_menu_id">Widget 1 menu</label>
                        <select id="widget1_menu_id"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            @input="updateForm('widget1_menu_id', $event.target.value)">
                            <option value="">Select menu</option>
                            <option v-for="menu in menus" :key="menu.id" :value="menu.id" :selected="form.widget1_menu_id == menu.id">{{menu.name}}</option>
                        </select>
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('widget1_menu_id')"
                            v-text="validationErros.get('widget1_menu_id')"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="widget2_menu_id">Widget 2 menu</label>
                        <select id="widget2_menu_id"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            @input="updateForm('widget2_menu_id', $event.target.value)">
                            <option value="">Select menu</option>
                            <option v-for="menu in menus" :key="menu.id" :value="menu.id" :selected="form.widget2_menu_id == menu.id">{{menu.name}}</option>
                        </select>
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('widget2_menu_id')"
                            v-text="validationErros.get('widget2_menu_id')"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="widget3_menu_id">Widget 1 menu</label>
                        <select id="widget3_menu_id"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            @input="updateForm('widget3_menu_id', $event.target.value)">
                            <option value="">Select menu</option>
                            <option v-for="menu in menus" :key="menu.id" :value="menu.id" :selected="form.widget3_menu_id == menu.id">{{menu.name}}</option>
                        </select>
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('widget3_menu_id')"
                            v-text="validationErros.get('widget3_menu_id')"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="fb_link">Facebook url</label>
                        <input type="text" name="fb_link" id="fb_link"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" " :value="form.fb_link" @input="updateForm('fb_link', $event.target.value)" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('fb_link')"
                            v-text="validationErros.get('fb_link')"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="twitter_link">Twitter url</label>
                        <input type="text" name="twitter_link" id="twitter_link"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" " :value="form.twitter_link"
                            @input="updateForm('twitter_link', $event.target.value)" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('twitter_link')"
                            v-text="validationErros.get('twitter_link')"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="google_link">Google url</label>
                        <input type="text" name="google_link" id="google_link"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" " :value="form.google_link"
                            @input="updateForm('google_link', $event.target.value)" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('google_link')"
                            v-text="validationErros.get('google_link')"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="youtube_link">Youtube url</label>
                        <input type="text" name="youtube_link" id="youtube_link"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" " :value="form.youtube_link"
                            @input="updateForm('youtube_link', $event.target.value)" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('youtube_link')"
                            v-text="validationErros.get('youtube_link')"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="linkedin_link">LinkedIn url</label>
                        <input type="text" name="linkedin_link" id="linkedin_link"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" " :value="form.linkedin_link"
                            @input="updateForm('linkedin_link', $event.target.value)" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('linkedin_link')"
                            v-text="validationErros.get('linkedin_link')"></p>
                    </div>
                    <div class="relative z-0 w-full group">

                        <fieldset>
                            <legend class="sr-only">Set as default</legend>
                            <div class="flex items-center mb-4">
                                <input id="is_active" name="is_active" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                                    :checked="is_active" v-model="is_active" />
                                <label for="is_active" class="ml-2 text-sm font-medium text-gray-900">Set as
                                    default</label>
                            </div>
                        </fieldset>
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('is_active')"
                            v-text="validationErros.get('is_active')"></p>

                    </div>
                </div>
                <button type="submit" class="button-exp-fill mt-5" :disabled="loading">Submit</button>
            </form>
        </div>

    </AppLayout>
</template>

<script>
import Editor from "@tinymce/tinymce-vue";
    import { mapState } from 'vuex'
    export default {
        computed:{
            ...mapState({
                loading: state => state.footer_setting.loading,
                isFormEdit: state => state.footer_setting.isFormEdit,
                form: state => state.footer_setting.form,
                validationErros: state => state.footer_setting.validationErros,
                languages: state => state.languages.languages,
                menus: state => state.menus.menus,
            }),
            is_active:{
                get: function(){
                    return this.$store.state.footer_setting.form.is_active;
                },
                set: function(val){
                    this.$store.commit('footer_setting/setForm', {
                        is_active: val
                    });
                }
            },
        },
    components: {
        editor: Editor,
    },
        data(){
            return {
                activeTab: null,
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
            }
        },
        methods: {
            handleSelectionChange(language, key) {
                this.handleInput(
                    tinymce.get(`${key}_${language.id}`).getContent(),
                    language,
                    key
                );
            },
            handleInput(value, language, fieldName){
                this.$store.commit('footer_setting/updateFooterSetting', {
                    key: fieldName,
                    id: language.id,
                    value: value,
                });
            },
            changeLanguageTab(language){
                this.activeTab = language.id;
            },
            updateForm(field, value){
                this.$store.commit('footer_setting/setFooterSetting', {
                    key: field,
                    value: value
                });
            },
            addUpdateForm(){
                this.$store.dispatch('footer_setting/addUpdateForm')
                .then(() => this.$router.push({name: 'admin.footer-setting.index'}));
            },
            fetchFooterSetting(){
                let id = this.$route.params.id;
                this.$store.commit('footer_setting/setIsFormEdit', 1);
                this.$store.dispatch('footer_setting/fetchFooterSetting', {
                    url: `${process.env.MIX_ADMIN_API_URL}footer-setting/${id}?withFooterSettingDetail=1`
                }).then(res => {
                    if(res.data.status == 'Success'){
                        this.updateForm('fb_link', res.data.data.fb_link);
                        this.updateForm('twitter_link', res.data.data.twitter_link);
                        this.updateForm('google_link', res.data.data.google_link);
                        this.updateForm('youtube_link', res.data.data.youtube_link);
                        this.updateForm('linkedin_link', res.data.data.linkedin_link);
                        this.updateForm('widget1_menu_id', res.data.data.widget1_menu_id);
                        this.updateForm('widget2_menu_id', res.data.data.widget2_menu_id);
                        this.updateForm('widget3_menu_id', res.data.data.widget3_menu_id);
                        this.updateForm('is_active', res.data.data.is_active);

                        let data = res.data.data && res.data.data.footer_setting_detail
                            ? res.data.data.footer_setting_detail
                            : [];
                        let obj = {};
                        data.map((res) => {
                            obj["widget1_" + res.language_id] = res.widget1;
                        });
                        this.$store.commit("footer_setting/setFooterSetting", {
                            key: "widget1",
                            value: obj,
                        });

                        obj = {};
                        data.map(res => {
                            obj['widget2_'+res.language_id] = res.widget2;
                        });
                        this.$store.commit('footer_setting/setFooterSetting', {
                            key: "widget2",
                            value: obj,
                        });

                        obj = {};
                        data.map(res => {
                            obj['widget3_'+res.language_id] = res.widget3;
                        });
                        this.$store.commit('footer_setting/setFooterSetting', {
                            key: "widget3",
                            value: obj,
                        });

                        obj = {};
                        data.map(res => {
                            obj['copyright_text_'+res.language_id] = res.copyright_text;
                        });
                        this.$store.commit('footer_setting/setFooterSetting', {
                            key: "copyright_text",
                            value: obj,
                        });
                        this.isDataLoaded = 1;
                    }
                });
            },
            checkValidationError(validationErros, language) {
                return (
                    validationErros.has(`widget1.widget1_${language.id}`) ||
                    validationErros.has(`widget2.widget2_${language.id}`) ||
                    validationErros.has(`widget3.widget3_${language.id}`) ||
                    validationErros.has(`copyright_text.copyright_text_${language.id}`)
                );
            },
        },
        created(){
            this.$store.commit('footer_setting/resetForm');
            this.$store.dispatch("menus/fetchMenus", { url: `${process.env.MIX_ADMIN_API_URL}menus?getAll=1` });
            this.$store.dispatch('languages/fetchLanguages', {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`
            }).then(res => {
                let data = res.data.data;
                let obj = {};
                data.map(res => {
                    if(res.is_default){
                        this.activeTab = res.id;
                    }
                    obj['widget1_'+res.id] = '';
                });
                this.$store.commit('footer_setting/setFooterSetting', {
                    key: "widget1",
                    value: obj,
                });

                obj = {};
                data.map(res => {
                    obj['widget2_'+res.id] = '';
                });
                this.$store.commit('footer_setting/setFooterSetting', {
                    key: "widget2",
                    value: obj,
                });

                obj = {};
                data.map(res => {
                    obj['widget3_'+res.id] = '';
                });
                this.$store.commit('footer_setting/setFooterSetting', {
                    key: "widget3",
                    value: obj,
                });

                obj = {};
                data.map(res => {
                    obj['copyright_text_'+res.id] = '';
                });
                this.$store.commit('footer_setting/setFooterSetting', {
                    key: "copyright_text",
                    value: obj,
                });
                if(this.$route.params.id){
                    this.fetchFooterSetting();
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