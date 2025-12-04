<template>
    <AppLayout>
        <div class="relative shadow-md sm:rounded-lg bg-white py-4">
            <header class="pt-4">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h3 class="can-exp-h3 text-primary">
                            {{ isFormEdit ? "Edit" : "Create" }} language
                        </h3>
                        <router-link
                            :to="{ name: 'admin.languages.index' }"
                            class="button-exp-fill"
                        >
                            Back
                        </router-link>
                    </div>
                </div>
            </header>
            <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
                <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2  lg:grid-cols-2 gap-6 ">
                    <div class="relative z-0 w-full group">
                        <label for="name" class="">Name</label>
                        <select
                            @change="updateLangName($event.target.value)"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                        >
                            <option value="">Select language...</option>
                            <option
                                v-for="languageCode in languageCodes"
                                :key="languageCode.code"
                                :value="JSON.stringify(languageCode)"
                                :selected="languageCode.name == form.name"
                            >
                                {{ languageCode.name }}
                            </option>
                        </select>

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('name')"
                            v-text="validationErros.get('name')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="abbreviation" class="">Abbreviation</label>
                        <input
                            type="text"
                            name="abbreviation"
                            id="abbreviation"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" "
                            :value="form.abbreviation"
                            @input="
                                updateForm('abbreviation', $event.target.value)
                            "
                            disabled
                            tabindex="-1"
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('abbreviation')"
                            v-text="validationErros.get('abbreviation')"
                        ></p>
                    </div>
                </div>
                <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2  lg:grid-cols-2 gap-6 ">
                    <div class="relative z-0 w-full group">
                        <label for="native_name" class="">Native name</label>
                        <input
                            type="text"
                            name="native_name"
                            id="native_name"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" "
                            :value="form.native_name"
                            @input="
                                updateForm('native_name', $event.target.value)
                            "
                            disabled
                            tabindex="-1"
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('native_name')"
                            v-text="validationErros.get('native_name')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="direction" class="">Language direct</label>
                        <select
                            @input="
                                updateForm('direction', $event.target.value)
                            "
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            id="direction"
                        >
                            <option
                                value="ltr"
                                :selected="
                                    form.direction ==
                                    'ltr'
                                "
                            >
                                Left to right
                            </option>
                            <option
                                value="rtl"
                                :selected="
                                    form.direction ==
                                    'rtl'
                                "
                            >
                                Right to left
                            </option>
                        </select>
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('direction')"
                            v-text="validationErros.get('direction')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group mt-8">
                        <fieldset>
                            <legend class="sr-only">Set as default</legend>
                            <div class="flex items-center mb-4">
                                <input
                                    id="is_default"
                                    name="is_default"
                                    type="checkbox"
                                    value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                                    :checked="is_default"
                                    v-model="is_default"
                                />
                                <label
                                    for="is_default"
                                    class="ml-2 text-sm font-medium text-gray-900"
                                    >Set as default</label
                                >
                            </div>
                        </fieldset>
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('is_default')"
                            v-text="validationErros.get('is_default')"
                        ></p>
                    </div>
                </div>

                <div class="grid md:grid-cols-4 md:gap-6 mt-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <FilePond
                            labelIdle='<span class="cursor-pointer">Drag & Drop your files or <span class="filepond--label-action"> Browse </span></span>'
                            class="cursor-pointer"
                            credits="false"
                            name="flag_icon"
                            class-name="my-pond"
                            accepted-file-types="image/*"
                            @init="handleFilePondInit"
                            @processfile="handleFilePondFlagIconProcess"
                            @removefile="handleFilePondFlagIconRemoveFile"
                        />
                    </div>
                    <p
                        class="mt-2 text-sm text-red-400"
                        v-if="validationErros.has('flag_icon')"
                        v-text="validationErros.get('flag_icon')"
                    ></p>
                </div>

                <button type="submit" class="button-exp-fill" :disabled="loading">Submit</button>
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
            loading: (state) => state.languages.loading,
            form: (state) => state.languages.form,
            isFormEdit: (state) => state.languages.isFormEdit,
            languageCodes: (state) => state.languages.languageCodes,
            validationErros: (state) => state.languages.validationErros,
        }),
        is_default: {
            get: function () {
                return this.$store.state.languages.form.is_default;
            },
            set: function (val) {
                this.$store.commit("languages/setForm", {
                    is_default: val,
                });
            },
        },
    },
    methods: {
        updateLangName(lang) {
            lang = JSON.parse(lang);
            this.updateForm("name", lang.name);
            this.updateForm("abbreviation", lang.code);
            this.updateForm("native_name", lang.nativeName);
        },
        updateForm(field, value) {
            this.$store.commit("languages/setForm", {
                [field]: value,
            });
        },
        addUpdateForm() {
            this.$store
                .dispatch("languages/addUpdateForm")
                .then(() =>
                    this.$router.push({ name: "admin.languages.index" })
                );
        },
        handleFilePondInit() {
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
                        formData.append("type", "flag_icon");

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
        handleFilePondFlagIconProcess(error, file) {
            this.$store.commit("languages/setForm", {
                flag_icon: file.serverId,
            });
        },
        handleFilePondFlagIconRemoveFile(error, file) {
            this.$store.commit("languages/setForm", {
                flag_icon: null,
            });
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
    created() {
        setOptions({ files: [] });
        this.$store.commit("languages/resetForm");
        if (this.$route.params.id) {
            let id = this.$route.params.id;
            this.$store.commit("languages/setIsFormEdit", 1);
            this.$store
                .dispatch("languages/fetchLanguage", { id: id })
                .then((res) => {
                    if (res.data.status == "Success") {
                        if (this.form.flag_icon) {
                            this.convertImgUrlToBase64(
                                this.form.flag_icon.full_path,
                                `image/${this.form.flag_icon.extension}`
                            );
                        }
                    }
                });
        }
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
