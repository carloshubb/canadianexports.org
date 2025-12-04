<template>
    <AppLayout>
        <div class="relative shadow-md sm:rounded-lg bg-white py-4">
            <header class="pt-4">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h3 class="can-exp-h3 text-primary"> {{isFormEdit ? 'Edit' : 'Create'}} issue </h3>
                        <router-link :to="{ name: 'admin.issues.index'}" class="button-exp-fill">
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
                                    ((activeTab == null && language.is_default) || activeTab == language.id ?
                                        'bg-blue-600 text-white' : ''), (validationErros.has(
                                        `title.title_${language.id}`) ? 'bg-red-600 border-red-600 text-white hover:text-white rounded hover:bg-red-600 hover:border-red-600' : '')
                                ]">{{ language . name }}</a>
                        </li>
                    </ul>
                </div>

                <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2  lg:grid-cols-2 gap-6 " v-for="language in languages" :key="language.id"
                    :class="(activeTab == null && language.is_default) || activeTab == language.id ? 'block' : 'hidden'">
                    <div class="relative z-0 w-full group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" " @input="handleInput($event.target.value, language, 'title')"
                            :value="form['title'] && form['title'][`title_${language.id}`] ? form['title'][`title_${language.id}`] :
                                ''" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`title.title_${language.id}`)"
                            v-text="validationErros.get(`title.title_${language.id}`)"></p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 md:gap-6 gap-4">
                    <div class="relative z-0 w-full group">
                        <label for="pdf">Pdf</label>
                        <input type="file" name="pdf" id="pdf"
                            class="can-exp-input w-full block border border-gray-300 rounded px-3 py-1.5 focus:ring-blue-600 focus:ring-1 focus:outline-blue-600 focus:border-blue-600"
                            placeholder=" " accept="application/pdf" @input="handleImage('pdf', $event)" />
                            <a :href="form.pdf_path" target="_blank" v-if="form.pdf">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                            </svg>
                        </a>
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('pdf')"
                            v-text="validationErros.get('pdf')"></p>
                            <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('file')"
                            v-text="validationErros.get('file')"></p>
                    </div>
                    <div class="relative z-0 w-full group hidden">
                        <label>&nbsp;</label>
                        <fieldset>
                            <legend class="sr-only">Is current issue?</legend>
                            <div class="flex items-center mb-4">
                                <input id="is_current_issue" name="is_current_issue" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                                    :checked="is_current_issue" v-model="is_current_issue" />
                                <label for="is_current_issue" class="ml-2 text-sm font-medium text-gray-900">Is current
                                    issue?</label>
                            </div>
                        </fieldset>
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('is_current_issue')"
                            v-text="validationErros.get('is_current_issue')"></p>

                    </div>
                </div>
                <div class="grid my-5 md:grid-cols-4 md:gap-6">
                    <div class="relative z-0 w-full group">
                        <FilePond  labelIdle='<span class="cursor-pointer">Drag & Drop your files or <span class="filepond--label-action"> Browse </span></span>' class="cursor-pointer" name="media_id" class-name="my-pond" accepted-file-types="image/*"
                            @init="handleFilePondInit" @processfile="handleFilePondFlagIconProcess"
                            @removefile="handleFilePondFlagIconRemoveFile" credits="false" />
                    </div>
                    <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('media_id')"
                        v-text="validationErros.get('media_id')"></p>
                </div>

                <button type="submit" class="button-exp-fill" :disabled="loading">Submit</button>
            </form>
        </div>

    </AppLayout>
</template>

<script>
    // Import filepond
    import vueFilePond, { setOptions } from 'vue-filepond';
    import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js';
    import FilePondPluginImagePreview from 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js';
    import 'filepond/dist/filepond.min.css';
    import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';
    const FilePond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginImagePreview);

    import { mapState } from 'vuex'
    export default {
        computed:{
            ...mapState({
                loading: state => state.issues.loading,
                isFormEdit: state => state.issues.isFormEdit,
                form: state => state.issues.form,
                validationErros: state => state.issues.validationErros,
                languages: state => state.languages.languages,
            }),
            is_current_issue:{
                get: function(){
                    return this.$store.state.issues.form.is_current_issue;
                },
                set: function(val){
                    this.$store.commit('issues/setForm', {
                        is_current_issue: val
                    });
                }
            },
        },
        data(){
            return {
                activeTab: null,
            }
        },
        methods: {
            handleInput(value, language, fieldName){
                this.$store.commit('issues/updateIssue', {
                    key: fieldName,
                    id: language.id,
                    value: value,
                });
            },
            changeLanguageTab(language){
                this.activeTab = language.id;
            },
            updateForm(field, value){

                this.$store.commit('issues/setIssue', {
                    key: field,
                    value: value
                });
            },
            handleImage(field, e){
                var file = new FormData();
                file.append("file", e.target.files[0]);
                file.append("type", 'only_pdf');
                axios
                    .post("/api/admin/media/image_again_upload", file)
                    .then((res) => {
                        this.$store.commit(`issues/setIssue`, {
                            value: res?.data,
                            key:field,
                        });
                    })
                    .catch((error) => {
                        this.$store.commit("issues/setEmptyError");
                        if (error.response && error.response.status == 422) {
                            this.$store.commit("issues/setValidationErros", error.response.data.errors);
                        }
                    })
            },
            addUpdateForm(){
                this.$store.dispatch('issues/addUpdateForm')
                .then(() => this.$router.push({name: 'admin.issues.index'}));
            },
            handleFilePondInit(){
                setOptions({
                    credits: false,
                    server: {
                        url: process.env.MIX_ADMIN_API_URL,
                        process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                            const formData = new FormData();
                            formData.append('media', file, file.name);
                            formData.append('is_temp_media', 1);
                            formData.append('type', 'media_id');

                            const request = new XMLHttpRequest();
                            request.open('POST', `${process.env.MIX_ADMIN_API_URL}media/process`);
                            request.setRequestHeader('X-CSRF-TOKEN', document.head.querySelector('meta[name="csrf-token"]').content)

                            request.upload.onprogress = (e) => {
                                progress(e.lengthComputable, e.loaded, e.total);
                            };
                            request.onload = function () {
                                if (request.status >= 200 && request.status < 300) {
                                    load(request.responseText);
                                } else {
                                    error('oh no');
                                }
                            };

                            request.send(formData);

                            return {
                                abort: () => {
                                    request.abort();
                                    abort();
                                },
                            };
                        },
                        revert: (uniqueFileId, load, error) => {
                            const formData = new FormData();
                            formData.append('media', uniqueFileId);

                            const request = new XMLHttpRequest();
                            request.open('POST', `${process.env.MIX_ADMIN_API_URL}media/revert`);
                            request.setRequestHeader('X-CSRF-TOKEN', document.head.querySelector('meta[name="csrf-token"]').content)

                            request.send(formData);

                            return {
                                abort: () => {
                                    request.abort();
                                    abort();
                                },
                            };
                        },
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                        }
                    }
                });
            },
            handleFilePondFlagIconProcess(error, file){
                this.$store.commit('issues/setForm', {
                    'media_id': file.serverId
                });
            },
            handleFilePondFlagIconRemoveFile(error, file){
                this.$store.commit('issues/setForm', {
                    'media_id': null
                });
            },
            convertImgUrlToBase64(url, type) {
                var image = new Image();

                image.onload = function () {
                    var canvas = document.createElement('canvas');
                    canvas.width = image.width;
                    canvas.height = image.height;

                    canvas.getContext('2d').drawImage(this, 0, 0);

                    canvas.toBlob(
                        function(source) {
                            var newImg = document.createElement("img"),
                            url = URL.createObjectURL(source);

                            newImg.onload = function() {
                            URL.revokeObjectURL(url);
                            };

                            newImg.src = url;
                        },
                        type,
                        1
                    );
                    let dataUrl = canvas.toDataURL(type);
                    let files = [{
                        'source':dataUrl,
                        'options': {
                            'type': 'local'
                        }
                    }];
                    setOptions({files:files});

                };
                image.src = url;
            },
            fetchIssue(){
                let id = this.$route.params.id;
                this.$store.commit('issues/setIsFormEdit', 1);
                this.$store.dispatch('issues/fetchIssue', {
                    url: `${process.env.MIX_ADMIN_API_URL}issues/${id}?withIssueDetail=1`
                }).then(res => {
                    if(res.data.status == 'Success'){
                        if(this.form.media_id){
                            this.convertImgUrlToBase64(this.form.media.full_path, `image/${this.form.media.extension}`);
                        }
                        this.updateForm('is_current_issue', res.data.data.is_current_issue);
                        // this.handleInput(res.data.data.pdf_path, "pdf_path");
                        // this.handleInput(res.data.data.pdf, "pdf");
                        this.updateForm("pdf_path", res.data.data.pdf_path);
                        this.updateForm("pdf", res.data.data.pdf);

                        let data = res.data.data && res.data.data.issue_detail
                            ? res.data.data.issue_detail
                            : [];
                        let obj = {};
                        data.map((res) => {
                            obj["title_" + res.language_id] = res.title;
                        });
                        this.$store.commit("issues/setIssue", {
                            key: "title",
                            value: obj,
                        });
                    }
                });
            }
        },
        components: {
            FilePond,
        },
        created(){
            setOptions({files:[]});
            this.$store.commit('issues/resetForm');
            this.$store.dispatch('languages/fetchLanguages', {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`
            }).then(res => {
                let data = res.data.data;
                let obj = {};
                data.map(res => {
                    obj['title_'+res.id] = '';
                });
                this.$store.commit('issues/setIssue', {
                    key: "title",
                    value: obj,
                });
                if(this.$route.params.id){
                    this.fetchIssue();
                }
            });
        },
    };
</script>

<style scoped>
/**
 * FilePond Custom Styles
 */
 .filepond--drop-label {
	color: #4c4e53;
}

.filepond--label-action {
	text-decoration-color: #babdc0;
}

.filepond--panel-root {
	border-radius: 2em;
	background-color: #edf0f4;
	height: 1em;
}

.filepond--item-panel {
	background-color: #595e68;
}

.filepond--drip-blob {
	background-color: #7f8a9a;
}


</style>
