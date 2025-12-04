<template>
    <AppLayout>
        <div class="relative shadow-md sm:rounded-lg bg-white py-4">
            <header class="pt-4">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h3 class="can-exp-h3 text-primary">
                            Edit meta tags setting
                        </h3>
                    </div>
                </div>
            </header>
            <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
                <div class="grid my-5 md:grid-cols-3 md:gap-6 gap-4">
                    <div
                        class="relative z-0 w-full group"
                        v-for="setting in general_setting"
                        :key="setting.id"
                    >
                        <div v-if="setting.key == 'facebook_meta_image'">
                            <label for="facebook_media_id"
                                >Facebook meta image</label
                            >
                            <FilePond
                                labelIdle='<span class="cursor-pointer">Drag & Drop your files or <span class="filepond--label-action"> Browse </span></span>'
                                class="cursor-pointer"
                                name="facebook_media"
                                class-name="my-pond"
                                accepted-file-types="image/*"
                                credits="false"
                                ref="facebook_media"
                                v-bind:files="facebook"
                                @init="handleFacebookInit"
                                @processfile="handleFacebookProcess"
                                @removefile="handleFacebookRemoveFile"
                            />
                        </div>
                    </div>
                </div>
                <button type="submit" class="button-exp-fill mt-5" :disabled="loading">
                    Submit
                </button>
            </form>
        </div>
    </AppLayout>
</template>

<script>
// Import filepond
import vueFilePond, { setOptions } from "vue-filepond";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js";
import FilePondPluginImagePreview from "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview
);
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            loading: (state) => state.general_setting.loading,
            form: (state) => state.general_setting.form,
            general_setting: (state) => state.general_setting.general_setting,
            validationErros: (state) => state.general_setting.validationErros,
        }),
    },
    components:{
        FilePond,
    },
    data() {
        return {
            facebook: [],
            form:{
                facebook_media_id:null,
            }
        };
    },
    methods: {
        updateForm(field, value) {
            this.form[field] = value;
        },
        addUpdateForm() {
            axios.post(`${process.env.MIX_ADMIN_API_URL}meta-tags-setting`, this.form)
            .then((res) => {
                if (res.data.status == "Success") {
                    helper.swalSuccessMessage(res.data.message);
                } else {
                    helper.swalErrorMessage(res.data.message);
                }
            })
        },
        handleFacebookInit() {
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
        handleFacebookProcess(error, file) {
            this.updateForm("facebook_media_id", file.serverId);
        },
        handleFacebookRemoveFile(error, file) {
            this.updateForm("facebook_media_id", null);
        },
        convertFacebookImgUrlToBase64(url, type) {
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
                vm.facebook = files;
            };
            image.src = url;
        },
        
        
    },
    created() {
        this.facebook = [];
        this.$store.commit("general_setting/resetForm");
        this.$store
            .dispatch("general_setting/fetchGeneralSetting", {
                url: `${process.env.MIX_ADMIN_API_URL}general-setting?onlyMetaTagsSetting=1`,
            })
            .then((res) => {
                if (res.data.status == "Success") {
                    res.data.data.map((response) => {
                        if(response.key == 'facebook_meta_image' && response.facebook){
                            this.convertFacebookImgUrlToBase64(response.facebook.full_path, `image/${response.facebook.extension}`)
                            this.updateForm(
                                "facebook_media_id", JSON.stringify([response.facebook.path])
                            );
                        }
                    })
                }
            });
    },
};
</script>
