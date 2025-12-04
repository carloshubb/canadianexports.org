<template>
    <AppLayout>
        <div class="relative shadow-md sm:rounded-lg bg-white py-4">
            <header class="pt-4">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h3 class="can-exp-h3 text-primary"> {{isFormEdit ? 'Edit' : 'Create'}} faq </h3>
                        <router-link :to="{ name: 'admin.faqs.index'}" class="button-exp-fill">
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
                                    ((selectedLanguage == null && language.is_default) || selectedLanguage == language.id ?
                                        'bg-blue-600 text-white' : ''), (validationErros.has(
                                            `question.question_${language.id}`) || validationErros.has(
                                        `answer.answer_${language.id}`) ? 'bg-red-600 border-red-600 text-white hover:text-white rounded hover:bg-red-600 hover:border-red-600' :
                                        '')
                                ]">{{ language . name }}</a>
                        </li>
                    </ul>
                </div>

                <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2  lg:grid-cols-2 gap-6 " v-for="language in languages" :key="language.id"
                    :class="(selectedLanguage == null && language.is_default) || selectedLanguage == language.id ? 'block' : 'hidden'">
                    <div class="relative z-0 w-full group">
                        <label for="question">Question</label>
                        <input type="text" name="question" id="question"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" " @input="handleQuestionInput($event.target.value, language)"
                            :value="form['question'] && form['question'][`question_${language.id}`] ? form['question'][`question_${language.id}`] : ''" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`question.question_${language.id}`)"
                            v-text="validationErros.get(`question.question_${language.id}`)"></p>
                    </div>
                    <div class="relative z-0 w-full group" v-if="isDataLoaded">
                        <label :for="`answer_${selectedLanguage}`">Answer</label>
                        <editor
                        @mouseleave="
                                handleSelectionChange(
                                    language,
                                    'answer'
                                )
                            "
                        @keyup="
                                handleSelectionChange(
                                    language,
                                    'answer'
                                )
                            "
                            :ref="`answer_${language.id}`"
                            :id="`answer_${language.id}`"
                            :initial-value="form[`answer`][`answer_${language?.id}`]
                            "
                            :tinymce-script-src="tinymceScriptSrc"
                            :init="editorConfig"
                        />


                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `answer.answer_${language.id}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `answer.answer_${language.id}`
                                )
                            ">
                        </p>
                    </div>

                </div>
                <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2  lg:grid-cols-2 gap-6 ">
                        <div class="relative z-0 w-full group">
                            <label for="type">Type</label>
                            <select id="type" @change="updateForm('type', $event.target.value)" class="can-exp-input w-full block border border-gray-300 rounded">
                                <option value="">Select type...</option>
                                <option value="importer" :selected="form.type == 'importer'">Importer</option>
                                <option value="exporter" :selected="form.type == 'exporter'">Exporter</option>
                            </select>
    
                            <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('type')" v-text="validationErros.get('type')"></p>
                        </div>
                    </div>
                <button type="submit" class="button-exp-fill" :disabled="loading">Submit</button>
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
                loading: state => state.faqs.loading,
                isFormEdit: state => state.faqs.isFormEdit,
                form: state => state.faqs.form,
                validationErros: state => state.faqs.validationErros,
                languages: state => state.languages.languages,
            }),
        },
    components: {
        editor: Editor,
    },
        data(){
            return {
                selectedLanguage: null,
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
            updateForm(field, value){
                this.$store.commit('faqs/setFormValues', {
                    [field]: value
                });
            },
            handleSelectionChange(language, key, mutationName) {
                this.$store.commit('faqs/updateAnswer', {
                    'answer': tinymce.get(`${key}_${language.id}`).getContent(),
                    'id': language.id,
                });
            },
            handleQuestionInput(value, language){
                this.$store.commit('faqs/updateQuestion', {
                    'question': value,
                    'id': language.id,
                });
            },
            addUpdateForm(){
                this.$store.dispatch('faqs/addUpdateForm')
                .then(() => this.$router.push({name: 'admin.faqs.index'}));
            },
            changeLanguageTab(language){
                this.selectedLanguage = language.id;
            },
            fetchFaq(){
                if(this.$route.params.id){
                    let id = this.$route.params.id;
                    this.$store.commit('faqs/setIsFormEdit', 1);
                    this.$store.dispatch('faqs/fetchFaq', {
                        id: id,
                        url: `${process.env.MIX_ADMIN_API_URL}faqs/${id}?withFaqDetail=1`
                    }).then(res => {
                        let data = res.data.data && res.data.data.faq_detail ? res.data.data.faq_detail : [];
                        this.updateForm('type', res.data.data?.type);
                        let obj = {};
                        data.map(res => {
                            obj['question_'+res.language_id] = res.question;
                        });
                        this.$store.commit('faqs/setQuestion', obj);

                        obj = {};
                        data.map(res => {
                            obj['answer_'+res.language_id] = res.answer;
                        });
                        this.$store.commit('faqs/setAnswer', obj);
                        this.isDataLoaded = 1;
                    });
                }
                else{
                    this.isDataLoaded = 1;
                }
            },
        },
        created(){
            this.$store.commit('faqs/resetForm');
            this.$store.dispatch('languages/fetchLanguages', {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`
            }).then(res => {
                let data = res.data.data;
                let obj = {};
                data.map(res => {
                    obj['question_'+res.id] = '';
                });
                this.$store.commit('faqs/setQuestion', obj);
                obj = {};
                data.map(res => {
                    obj['answer_'+res.id] = '';
                });
                this.$store.commit('faqs/setAnswer', obj);
                this.fetchFaq();
            });
        }
    };
</script>

<style>
.tox-notification { display: none !important }
</style>