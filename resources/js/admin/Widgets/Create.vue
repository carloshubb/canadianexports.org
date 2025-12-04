<template>
    <AppLayout>
        <div class="relative shadow-md sm:rounded-lg bg-white py-4">
            <header class="pt-4">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h3 class="can-exp-h3 text-primary"> {{ isFormEdit ? 'Edit' : 'Create' }} widget </h3>
                        <router-link :to="{ name: 'admin.widgets.index' }" class="button-exp-fill">
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
                                            `text_detail.text_detail_${language.id}`) ?
                                        'bg-red-600 border-red-600 text-white hover:text-white rounded hover:bg-red-600 hover:border-red-600' :
                                        '')
                                ]">{{ language . name }}</a>
                        </li>
                    </ul>
                </div>

                <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2  lg:grid-cols-2 gap-6 "
                    v-for="language in languages" :key="language.id"
                    :class="(activeTab == null && language.is_default) || activeTab == language.id ? 'block' : 'hidden'">
                    <div class="relative z-0 w-full group" v-if="isDataLoaded">
                        <label :for="`text_detail_${activeTab}`">Description</label>
                        <editor
                            @mouseleave="
                                handleSelectionChange(
                                    language,
                                    'text_detail'
                                )
                            "
                            @keyup="
                                handleSelectionChange(
                                    language,
                                    'text_detail'
                                )
                            "
                            :ref="`text_detail_${language.id}`" :id="`text_detail_${language.id}`"
                            :initial-value="form[`text_detail`][`text_detail_${language?.id}`]"
                            :tinymce-script-src="tinymceScriptSrc" :init="editorConfig" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `text_detail.text_detail_${activeTab}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `text_detail.text_detail_${activeTab}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label :for="`button_text_${activeTab}`">Button text</label>
                        <input type="text" :name="`button_text_${activeTab}`" :id="`button_text_${activeTab}`"
                            class="can-exp-input w-full block border border-gray-300 rounded" placeholder=" "
                            :value="form['button_text'] &&
                                form['button_text'][
                                    `button_text_${activeTab}`
                                ] ?
                                form['button_text'][
                                    `button_text_${activeTab}`
                                ] :
                                ''"
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'button_text'
                            )" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `button_text.button_text_${activeTab}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `button_text.button_text_${activeTab}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label :for="`button_link_${activeTab}`">Button URL</label>
                        <input type="text" :name="`button_link_${activeTab}`" :id="`button_link_${activeTab}`"
                            class="can-exp-input w-full block border border-gray-300 rounded" placeholder=" "
                            :value="form['button_link'] &&
                                form['button_link'][
                                    `button_link_${activeTab}`
                                ] ?
                                form['button_link'][
                                    `button_link_${activeTab}`
                                ] :
                                ''"
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'button_link'
                            )" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `button_link.button_link_${activeTab}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `button_link.button_link_${activeTab}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label :for="`action_${activeTab}`">URL Action</label>
                        <select type="text" :name="`action_${activeTab}`" :id="`action_${activeTab}`"
                            class="can-exp-input w-full block border border-gray-300 rounded" placeholder=" "
                            :value="form['action'] &&
                                form['action'][
                                    `action_${activeTab}`
                                ] ?
                                form['action'][
                                    `action_${activeTab}`
                                ] :
                                ''"
                            @change="
                            handleInput(
                                $event.target.value,
                                language,
                                'action'
                            )" >
                            <option value="internal" :selected="form.layout == 'internal'">Internal Link</option>
                            <option value="external" :selected="form.layout == 'external'">External Link</option>
                        </select>

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `action.action_${activeTab}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `action.action_${activeTab}`
                                )
                            ">
                        </p>
                    </div>
                </div>

                <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2  lg:grid-cols-2 gap-6 ">
                    <div class="relative z-0 w-full group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name"
                            class="can-exp-input w-full block border border-gray-300 rounded" placeholder=" "
                            :value="form.name" @input="updateForm('name', $event.target.value)" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('name')"
                            v-text="validationErros.get('name')"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="layout">Layout</label>
                        <select id="layout" class="can-exp-input w-full block border border-gray-300 rounded"
                            @input="updateForm('layout', $event.target.value)">
                            <option value="layout_1" :selected="form.layout == 'layout_1'">Layout 1</option>
                            <option value="layout_2" :selected="form.layout == 'layout_2'">Layout 2</option>
                            <option value="layout_3" :selected="form.layout == 'layout_3'">Layout 3</option>
                        </select>
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`layout`)"
                            v-text="validationErros.get(`layout`)"></p>
                    </div>

                </div>
                <div class="grid md:grid-cols-4 md:gap-6">
                    <div class="relative z-0 w-full group">
                        <label for="#" class="mb-1">Right side banner</label>
                        <FilePond  labelIdle='<span class="cursor-pointer">Drag & Drop your files or <span class="filepond--label-action"> Browse </span></span>' class="cursor-pointer" name="image_path" class-name="my-pond" accepted-file-types="image/*"
                            @init="handleFilePondInit" @processfile="handleFilePondFlagIconProcess"
                            @removefile="handleFilePondFlagIconRemoveFile" credits="false" v-bind:files="image_path" />
                    <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('image_path')"
                        v-text="validationErros.get('image_path')"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="#" class="mb-1">Left side banner</label>
                        <FilePond
                                labelIdle='<span class="cursor-pointer">Drag & Drop your files or <span class="filepond--label-action"> Browse </span></span>'
                                class="cursor-pointer"
                                name="image_media"
                                class-name="my-pond"
                                accepted-file-types="image/*"
                                credits="false"
                                ref="image_media"
                                v-bind:files="image_path_2"
                                @init="handleImagePath2Init"
                                @processfile="handleImagePath2Process"
                                @removefile="handleImagePath2RemoveFile"
                            />
                    <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('image_path_2')"
                        v-text="validationErros.get('image_path_2')"></p>
                    </div>
                </div>

                <button type="submit" class="button-exp-fill" :disabled="loading">Submit</button>
            </form>
        </div>

    </AppLayout>
</template>



<script>
import Editor from "@tinymce/tinymce-vue";
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
                loading: state => state.widgets.loading,
                isFormEdit: state => state.widgets.isFormEdit,
                form: state => state.widgets.form,
                validationErros: state => state.widgets.validationErros,
                languages: state => state.languages.languages,
            }),
            is_default:{
                get: function(){
                    return this.$store.state.widgets.form.is_default;
                },
                set: function(val){
                    this.$store.commit('widgets/setForm', {
                        is_default: val
                    });
                }
            },
        },
        data(){
            return {
                image_path_2: [],
                image_path: [],
                images:{
                    image_path_2:null,
                    image_path:null,
                },
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
            handleImagePath2Init() {
            setOptions({
                credits: false,
                server: {
                    url: process.env.MIX_ADMIN_API_URL,
                    process: (
                        fieldName,
                        file,
                        metadata,
                        load,
                        error,
                        progress,
                        abort,
                        transfer,
                        options
                    ) => {
                        const formData = new FormData();
                        formData.append("media", file, file.name);
                        formData.append("is_temp_media", 1);
                        formData.append("type", "pages");

                        const request = new XMLHttpRequest();
                        request.open(
                            "POST",
                            `${process.env.MIX_ADMIN_API_URL}media/process`
                        );
                        request.setRequestHeader(
                            "X-CSRF-TOKEN",
                            document.head.querySelector(
                                'meta[name="csrf-token"]'
                            ).content
                        );

                        request.upload.onprogress = (e) => {
                            progress(e.lengthComputable, e.loaded, e.total);
                        };
                        request.onload = function () {
                            if (request.status >= 200 && request.status < 300) {
                                load(request.responseText);
                            } else {
                                error("oh no");
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
                        formData.append("media", uniqueFileId);

                        const request = new XMLHttpRequest();
                        request.open(
                            "POST",
                            `${process.env.MIX_ADMIN_API_URL}media/revert`
                        );
                        request.setRequestHeader(
                            "X-CSRF-TOKEN",
                            document.head.querySelector(
                                'meta[name="csrf-token"]'
                            ).content
                        );

                        request.send(formData);

                        return {
                            abort: () => {
                                request.abort();
                                abort();
                            },
                        };
                    },
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                    },
                },
            });
        },
        handleImagePath2Process(error, file) {
            this.images.image_path_2 = file.serverId;
        },
        handleImagePath2RemoveFile(error, file) {
            this.images.image_path_2 = null;
        },
        convertImagePath2ImgUrlToBase64(url, type) {
            var image = new Image();
            let vm = this;
            image.onload = function () {
                var canvas = document.createElement("canvas");
                canvas.width = image.width;
                canvas.height = image.height;

                canvas.getContext("2d").drawImage(this, 0, 0);

                canvas.toBlob(
                    function (source) {
                        var newImg = document.createElement("img"),
                            url = URL.createObjectURL(source);

                        newImg.onload = function () {
                            URL.revokeObjectURL(url);
                        };

                        newImg.src = url;
                    },
                    type,
                    1
                );
                let dataUrl = canvas.toDataURL(type);
                let files = [
                    {
                        source: dataUrl,
                        options: {
                            type: "local",
                        },
                    },
                ];
                // setOptions({files:files});
                vm.image_path_2 = files;
            };
            image.src = url;
        },
            handleSelectionChange(language, key) {
                this.handleInput(
                    tinymce.get(`${key}_${language.id}`).getContent(),
                    language,
                    key,
                );
            },
            handleInput(value, language, fieldName){
                this.$store.commit('widgets/updateWidget', {
                    key: fieldName,
                    id: language.id,
                    value: value,
                });
            },
            changeLanguageTab(language){
                this.activeTab = language.id;
            },
            updateForm(field, value){
                this.$store.commit('widgets/setWidget', {
                    key: field,
                    value: value
                });
            },
            addUpdateForm(){
                this.$store.commit('widgets/setWidget', {
                    key: 'image_path_2',
                    value: this.images.image_path_2
                });
                this.$store.commit('widgets/setWidget', {
                    key: 'image_path',
                    value: this.images.image_path
                });
                this.$store.dispatch('widgets/addUpdateForm')
                .then(() => this.$router.push({name: 'admin.widgets.index'}));
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
                            formData.append('type', 'image_path');

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
                this.images.image_path = file.serverId;
            },
            handleFilePondFlagIconRemoveFile(error, file){
                this.images.image_path = null;
            },
            convertImgUrlToBase64(url, type) {
                var image = new Image();
            let vm = this;
            image.onload = function () {
                var canvas = document.createElement("canvas");
                canvas.width = image.width;
                canvas.height = image.height;

                canvas.getContext("2d").drawImage(this, 0, 0);

                canvas.toBlob(
                    function (source) {
                        var newImg = document.createElement("img"),
                            url = URL.createObjectURL(source);

                        newImg.onload = function () {
                            URL.revokeObjectURL(url);
                        };

                        newImg.src = url;
                    },
                    type,
                    1
                );
                let dataUrl = canvas.toDataURL(type);
                let files = [
                    {
                        source: dataUrl,
                        options: {
                            type: "local",
                        },
                    },
                ];
                // setOptions({files:files});
                vm.image_path = files;
            };
            image.src = url;
            },
            fetchWidget(){
                let id = this.$route.params.id;
                this.$store.commit('widgets/setIsFormEdit', 1);
                this.$store.dispatch('widgets/fetchWidget', {
                    url: `${process.env.MIX_ADMIN_API_URL}widgets/${id}?withWidgetDetail=1&withMedia=1&withMedia2=1`
                }).then(res => {
                    if(res.data.status == 'Success'){
                        if(this.form.image_path){
                            this.convertImgUrlToBase64(this.form.media.full_path, `image/${this.form.media.extension}`);
                            this.images.image_path = JSON.stringify([res.data.data.media.path]);
                        }
                        if(res.data.data.image_path_2 && res.data.data.media2){
                            this.convertImagePath2ImgUrlToBase64(res.data.data.media2.full_path, `image/${res.data.data.media2.extension}`)
                            this.images.image_path_2 = JSON.stringify([res.data.data.media2.path]);
                        }
                        this.updateForm('name', res.data.data.name);
                        this.updateForm('type', res.data.data.type);

                        let data = res.data.data && res.data.data.widget_detail
                            ? res.data.data.widget_detail
                            : [];
                        let obj = {};
                        data.map((res) => {
                            obj["text_detail_" + res.language_id] = res.text_detail;
                        });
                        this.$store.commit("widgets/setWidget", {
                            key: "text_detail",
                            value: obj,
                        });
                        obj = {};
                        data.map((res) => {
                            obj["button_text_" + res.language_id] = res.button_text;
                        });
                        this.$store.commit("widgets/setWidget", {
                            key: "button_text",
                            value: obj,
                        });
                        obj = {};
                        data.map((res) => {
                            obj["button_link_" + res.language_id] = res.button_link;
                        });
                        this.$store.commit("widgets/setWidget", {
                            key: "button_link",
                            value: obj,
                        });
                        obj = {};
                        data.map((res) => {
                            obj["action_" + res.language_id] = res.action;
                        });
                        this.$store.commit("widgets/setWidget", {
                            key: "action",
                            value: obj,
                        });
                        this.isDataLoaded = 1;
                    }
                });
            },
        },
        components: {
            FilePond,
            editor: Editor,
        },
        created(){
            this.image_path_2 = [];
            this.images.image_path_2 = null;
            this.image_path = [];
            this.images.image_path = null;
            // setOptions({files:[]});
            this.$store.commit('widgets/resetForm');
            this.updateForm('layout', 'layout_1');
            this.$store.dispatch('languages/fetchLanguages', {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`
            }).then(res => {
                let data = res.data.data;
                let obj = {};
                data.map(res => {
                    if(res.is_default){
                        this.activeTab = res.id;
                    }
                    obj['text_detail_'+res.id] = '';
                });
                this.$store.commit('widgets/setWidget', {
                    key: "text_detail",
                    value: obj,
                });
                obj = {};
                data.map(res => {
                    obj['button_text_'+res.id] = '';
                });
                this.$store.commit('widgets/setWidget', {
                    key: "button_text",
                    value: obj,
                });
                obj = {};
                data.map(res => {
                    obj['button_link_'+res.id] = '';
                });
                this.$store.commit('widgets/setWidget', {
                    key: "button_link",
                    value: obj,
                });
                obj = {};
                data.map(res => {
                    obj['action_'+res.id] = '';
                });
                this.$store.commit('widgets/setWidget', {
                    key: "action",
                    value: obj,
                });
                if(this.$route.params.id){
                    this.fetchWidget();
                }
                else{
                    this.isDataLoaded = 1;
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

.tox-notification { display: none !important }
</style>
