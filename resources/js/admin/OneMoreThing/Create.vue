<template>
    <AppLayout>
        <div class="relative shadow-md sm:rounded-lg bg-white py-4">
            <header class="pt-4">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h3 class="can-exp-h3 text-primary">
                            {{ isFormEdit ? "Edit" : "Create" }} one more thing
                        </h3>
                        <router-link
                            :to="{ name: 'admin.one-more-thing.index' }"
                            class="inline-flex items-center button-exp-fill"
                        >
                            Back
                        </router-link>
                    </div>
                </div>
            </header>
            <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
                <div
                    class="text-sm font-medium text-center text-gray-500 border-gray-200"
                >
                    <ul class="flex flex-wrap mb-2 overflow-x-auto gap-1 gap-1">
                        <li
                            class="mr-2"
                            v-for="language in languages"
                            :key="language.id"
                        >
                            <a
                                @click.prevent="changeLanguageTab(language)"
                                href="#"
                                :class="[
                                    'inline-block rounded font-FuturaMdCnBT px-5 py-2 lg:text-lg md:text-base sm:text-base text-base hover:bg-blue-100 border border-primary text-center hover:border-blue-500 hover:text-blue-600',
                                    (activeTab == null &&
                                        language.is_default) ||
                                    activeTab == language.id
                                        ? 'bg-blue-600 text-white'
                                        : '',
                                    checkValidationError(
                                        validationErros,
                                        language
                                    )
                                        ? 'bg-red-600 border-red-600 text-white hover:text-white rounded hover:bg-red-600 hover:border-red-600'
                                        : '',
                                ]"
                                >{{ language.name }}</a
                            >
                        </li>
                    </ul>
                </div>
                <hr class="my-2" />
                <div
                    class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6"
                    v-for="language in languages"
                    :key="language.id"
                    :class="
                        (activeTab == null && language.is_default) ||
                        activeTab == language.id
                            ? 'block'
                            : 'hidden'
                    "
                >
                    <div class="relative z-0 w-full group grid-cols-2">
                        <label for="description" class="">Description</label>
                        <textarea
                            id="description"
                            rows="4"
                            class="can-exp-input block w-full rounded border border-gray-300"
                            placeholder=""
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'description'
                                )
                            "
                            v-text="
                                form['description'] &&
                                form['description'][
                                    `description_${language.id}`
                                ]
                                    ? form['description'][
                                          `description_${language.id}`
                                      ]
                                    : ''
                            "
                        ></textarea>

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `description.description_${language.id}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `description.description_${language.id}`
                                )
                            "
                        ></p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 md:gap-6 gap-4">
                    <div class="relative z-0 w-full group">
                        <label for="url" class="">URL</label>
                        <input
                            type="text"
                            name="url"
                            id="url"
                            class="can-exp-input block w-full rounded border border-gray-300"
                            placeholder=" "
                            :value="form.url"
                            @input="updateForm('url', $event.target.value)"
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('url')"
                            v-text="validationErros.get('url')"
                        ></p>
                    </div>
                </div>
                <div class="grid md:grid-cols-4 md:gap-6 mt-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <FilePond
                            labelIdle='<span class="cursor-pointer">Drag & Drop your files or <span class="filepond--label-action"> Browse </span></span>'
                            class="cursor-pointer"
                            credits="false"
                            name="media_id"
                            ref="media_id"
                            class-name="my-pond"
                            accepted-file-types="image/*"
                            @init="handleGalleryImagesInit"
                            @processfile="handleGalleryImagesProcess"
                            @removefile="handleGalleryImagesRemoveFile"
                            v-bind:files="media_id"
                        />
                    </div>
                    <p
                        class="mt-2 text-sm text-red-400"
                        v-if="validationErros.has('media_id')"
                        v-text="validationErros.get('media_id')"
                    ></p>
                </div>

                <button
                    type="submit"
                    class="inline-flex items-center button-exp-fill"
                    :disabled="loading"
                >
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
            loading: (state) => state.one_more_thing.loading,
            isFormEdit: (state) => state.one_more_thing.isFormEdit,
            form: (state) => state.one_more_thing.form,
            validationErros: (state) => state.one_more_thing.validationErros,
            languages: (state) => state.languages.languages,
        }),
    },
    data() {
        return {
            activeTab: null,
            media_id: [],
        };
    },
    methods: {
        handleInput(value, language, fieldName) {
            this.$store.commit("one_more_thing/updateOneMoreThing", {
                key: fieldName,
                id: language.id,
                value: value,
            });
        },
        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
        updateForm(field, value) {
            this.$store.commit("one_more_thing/setOneMoreThing", {
                key: field,
                value: value,
            });
        },
        addUpdateForm() {
            this.$store
                .dispatch("one_more_thing/addUpdateForm")
                .then(() =>
                    this.$router.push({ name: "admin.one-more-thing.index" })
                );
        },
        handleGalleryImagesInit() {
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
                        formData.append("type", "media_id");

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
        handleGalleryImagesProcess(error, file) {
            this.$store.commit("one_more_thing/setForm", {
                media_id: file.serverId,
            });
        },
        handleGalleryImagesRemoveFile(error, file) {
            this.$store.commit("one_more_thing/setForm", {
                media_id: null,
            });
        },
        fetchOneMoreThing() {
            let id = this.$route.params.id;
            this.$store.commit("one_more_thing/setIsFormEdit", 1);
            this.$store
                .dispatch("one_more_thing/fetchOneMoreThing", {
                    url: `${process.env.MIX_ADMIN_API_URL}one-more-thing/${id}?withOneMoreThingDetail=1`,
                })
                .then((res) => {
                    if (res.data.status == "Success") {
                        if (res.data.data && res.data.data.media) {
                            let image = res.data.data.media;
                            if (image) {
                                this.media_id.push({
                                    source: image.base64,
                                    options: {
                                        type: "local",
                                        metadata: {
                                            serverId: image.path,
                                            poster: image.base64,
                                        },
                                    },
                                });
                                setOptions({ files: this.media_id });
                            }
                        }
                        this.updateForm("url", res.data.data.url);

                        let data =
                            res.data.data && res.data.data.one_more_thing_detail
                                ? res.data.data.one_more_thing_detail
                                : [];
                        let obj = {};
                        data.map((res) => {
                            obj["description_" + res.language_id] =
                                res.description;
                        });
                        this.$store.commit("one_more_thing/setOneMoreThing", {
                            key: "description",
                            value: obj,
                        });
                    }
                });
        },
        checkValidationError(validationErros, language) {
            return validationErros.has(
                `description.description_${language.id}`
            );
        },
    },
    components: {
        FilePond,
    },
    created() {
        this.media_id = [];
        setOptions({ files: [] });
        this.$store.commit("one_more_thing/resetForm");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                data.map((res) => {
                    obj["description_" + res.id] = "";
                });
                this.$store.commit("one_more_thing/setOneMoreThing", {
                    key: "description",
                    value: obj,
                });

                if (this.$route.params.id) {
                    this.$store.commit("one_more_thing/setOneMoreThing", {
                        key: "id",
                        value: this.$route.params.id,
                    });
                    this.fetchOneMoreThing();
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
