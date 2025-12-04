<template>
    <AppLayout>
        <div class="relative shadow-md sm:rounded-lg bg-white py-4">
            <header class="pt-4">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h1 class="can-exp-h3 mb-0 text-primary"> {{isFormEdit ? 'Edit' : 'Create'}} menu </h1>
                        <router-link :to="{ name: 'admin.menus.index'}" class="button-exp-fill">
                            Back
                        </router-link>
                    </div>
                </div>
            </header>
            <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
                <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2  lg:grid-cols-2 gap-6 ">
                    <div class="relative z-0 w-full group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" " :value="form.name" @input="updateForm('name', $event.target.value)" />

                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('name')"
                            v-text="validationErros.get('name')"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label>&nbsp;</label>
                        <fieldset>
                            <legend class="sr-only">Is main menu?</legend>
                            <div class="flex items-center mb-4">
                                <input id="is_main_menu" name="is_main_menu" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                                    :checked="is_main_menu" v-model="is_main_menu" />
                                <label for="is_main_menu" class="ml-2 text-sm font-medium text-gray-900">Set as main
                                    menu</label>
                            </div>
                        </fieldset>
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('is_main_menu')"
                            v-text="validationErros.get('is_main_menu')"></p>

                    </div>
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
                loading: state => state.menus.loading,
                isFormEdit: state => state.menus.isFormEdit,
                form: state => state.menus.form,
                validationErros: state => state.menus.validationErros,
            }),
            is_main_menu:{
                get: function(){
                    return this.$store.state.menus.form.is_main_menu;
                },
                set: function(val){
                    this.$store.commit('menus/setForm', {
                        is_main_menu: val
                    });
                }
            },
            is_footer_menu:{
                get: function(){
                    return this.$store.state.menus.form.is_footer_menu;
                },
                set: function(val){
                    this.$store.commit('menus/setForm', {
                        is_footer_menu: val
                    });
                }
            },
        },
        methods: {
            updateLangName(lang){
                lang = JSON.parse(lang);
                this.updateForm('name', lang.name)
                this.updateForm('abbreviation', lang.code)
                this.updateForm('native_name', lang.nativeName)
            },
            updateForm(field, value){
                this.$store.commit('menus/setForm', {
                    [field]: value
                });
            },
            addUpdateForm(){
                this.$store.dispatch('menus/addUpdateForm')
                .then(() => this.$router.push({name: 'admin.menus.index'}));
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
                            formData.append('type', 'flag_icon');

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
                this.$store.commit('menus/setForm', {
                    'flag_icon': file.serverId
                });
            },
            handleFilePondFlagIconRemoveFile(error, file){
                this.$store.commit('menus/setForm', {
                    'flag_icon': null
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
        },
        components: {
            FilePond,
        },
        created(){
            setOptions({files:[]});
            this.$store.commit('menus/resetForm');
            if(this.$route.params.id){
                let id = this.$route.params.id;
                this.$store.commit('menus/setIsFormEdit', 1);
                this.$store.dispatch('menus/fetchMenu', {id: id}).then(res => {
                    if(res.data.status == 'Success'){
                        if(this.form.flag_icon){
                            this.convertImgUrlToBase64(this.form.flag_icon.full_path, `image/${this.form.flag_icon.extension}`);
                        }
                    }
                });
            }
        },
    };
</script>
