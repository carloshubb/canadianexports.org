<template>
    <div>
        <FilePond
            labelIdle='<span class="cursor-pointer">Drag & Drop your files or <span class="filepond--label-action"> Browse </span></span>'
            class="cursor-pointer"
            :id="field_name"
            :name="field_name"
            class-name="my-pond"
            credits="false"
            accepted-file-types="image/*"
            :allow-multiple="allow_multiple == 'true' ? true : false"
            @init="handleFilePondInit"
            @processfile="handleFilePondFlagIconProcess"
            @removefile="handleFilePondFlagIconRemoveFile"
        />
    </div>
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
setOptions({ files: [] });
import { mapState } from "vuex";
export default {
    props:['field_name', 'allow_multiple', 'mutation_name', 'store_name', 'type'],
    computed: {
        ...mapState({
            form: (state) => state.events.form,
        }),
        image () {
            return this.$store.state[this.store_name] && this.$store.state[this.store_name].form[this.field_name] ? this.$store.state[this.store_name].form[this.field_name].length : null
        }
    },
    methods: {
        handleFilePondInit() {
            setOptions({
                credits: false,
                server: {
                    url: process.env.MIX_APP_URL,
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
                        formData.append("type", "media_id");

                        const request = new XMLHttpRequest();
                        request.open(
                            "POST",
                            `${process.env.MIX_APP_URL}/media/process`
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
                            `${process.env.MIX_APP_URL}/media/revert`
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
        handleFilePondFlagIconProcess(error, file) {
            let field_name = {};
            field_name[this.field_name] = file.serverId;
            this.$store.commit(this.mutation_name, field_name);
        },
        handleFilePondFlagIconRemoveFile(error, file) {
            let field_name = {};
            field_name[this.field_name] = file.serverId;
            this.$store.commit(this.mutation_name, field_name);
        },
        convertImgUrlToBase64(url, type) {
            var image = new Image();

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
                setOptions({ files: files });
            };
            image.src = url;
        },
    },
    components: {
        FilePond,
    },
    watch: {
        image (newImage, oldImage) {
            if(this.type == 'gallery_images'){
                this.event.event_media.map(res => {
                    this.convertImgUrlToBase64(
                            res.media.full_path,
                            `image/${res.media.extension}`
                        );
                });
            }
            else{
                if(this.form.media){
                    this.convertImgUrlToBase64(
                        this.form.media.full_path,
                        `image/${this.form.media.extension}`
                    );
                }
            }
        }
    }
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

.paypal-button {
    height: 25px !important;
    width: 100px !important;
}
</style>
