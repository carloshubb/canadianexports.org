<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
            <header class="pt-4">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row items-center justify-center gap-4 md:justify-between">
                        <h3 class="can-exp-h3 text-primary"> {{isFormEdit ? 'Edit' : 'Create'}} business directory </h3>
                        <router-link :to="{ name: 'admin.business_directories.index' }"
                            class="inline-flex items-center button-exp-fill">
                            Back
                        </router-link>
                    </div>
                </div>
            </header>
            <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
                <div
                    class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                    <ul class="flex gap-2 flex-wrap my-4">
                        <li class="mr-2 mb-2" v-for="language in languages" :key="language.id">
                            <a @click.prevent="changeLanguageTab(language)" href="#" :class="[
                                'inline-block rounded font-FuturaMdCnBT px-5 py-2 lg:text-lg md:text-base sm:text-base text-base hover:bg-blue-100 border border-primary text-center hover:border-blue-500 hover:text-blue-600',
                                (activeTab == null && language.is_default) ||
                                    activeTab == language.id
                                    ? 'text-white bg-primary active'
                                    : '',
                                validationErros.has(
                                    `name.name_${language.id}`
                                )
                                    ? 'bg-red-600 border-red-600 text-white hover:text-white rounded hover:bg-red-600 hover:border-red-600'
                                    : '',
                            ]">{{ language.name }}</a>
                        </li>
                    </ul>
                </div>

                <div class="grid my-5 md:grid-cols-2 md:gap-6" v-for="language in languages" :key="language.id" :class="(activeTab == null && language.is_default) ||
                        activeTab == language.id
                        ? 'block'
                        : 'hidden'
                    ">
                    <div class="relative z-0 w-full group">
                        <label for="name" class="block text-base lg:text-lg">Name</label>
                        <input type="text" name="name" id="name"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" " @input="
                                handleMultipleInput(
                                    'name',
                                    $event.target.value,
                                    language
                                )
                                " :value="form['name'] && form['name'][`name_${language.id}`]
                                ? form['name'][`name_${language.id}`]
                                : ''
                            " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`name.name_${language.id}`)"
                            v-text="validationErros.get(`name.name_${language.id}`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="address" class="block text-base lg:text-lg">Address</label>
                        <input type="text" name="address" id="address"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" " @input="handleInput($event.target.value, 'address')"
                            :value="form['address'] ? form['address'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`address`)"
                            v-text="validationErros.get(`address`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="city" class="block text-base lg:text-lg">City</label>
                        <input type="text" name="city" id="city"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" " @input="handleInput($event.target.value, 'city')"
                            :value="form['city'] ? form['city'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`city`)"
                            v-text="validationErros.get(`city`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="province" class="block text-base lg:text-lg">Province</label>
                        <input type="text" name="province" id="province"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" " @input="handleInput($event.target.value, 'province')"
                            :value="form['province'] ? form['province'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`province`)"
                            v-text="validationErros.get(`province`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="postal_code" class="block text-base lg:text-lg">Postal Code</label>
                        <input type="text" name="postal_code" id="postal_code"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" " @input="handleInput($event.target.value, 'postal_code')"
                            :value="form['postal_code'] ? form['postal_code'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`postal_code`)"
                            v-text="validationErros.get(`postal_code`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="phone" class="block text-base lg:text-lg">Phone</label>
                        <input type="text" name="phone" id="phone"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" With area code" @input="handleInput($event.target.value, 'phone')"
                            :value="form['phone'] ? form['phone'] : ''" @keypress="restrictToNumbers($event, 15)" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`phone`)"
                            v-text="validationErros.get(`phone`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="fax" class="block text-base lg:text-lg">Fax</label>
                        <input type="text" name="fax" id="fax"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" " @input="handleInput($event.target.value, 'fax')"
                            :value="form['fax'] ? form['fax'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`fax`)"
                            v-text="validationErros.get(`fax`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="industry" class="block text-base lg:text-lg">Industry</label>
                        <input type="text" name="industry" id="industry"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" " @input="handleInput($event.target.value, 'industry')"
                            :value="form['industry'] ? form['industry'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`industry`)"
                            v-text="validationErros.get(`industry`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="status" class="block text-base lg:text-lg">Status</label>
                        <select name="status"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            @input="handleInput($event.target.value, 'status')">
                            <option value="">Select</option>
                            <option :selected="form['status'] == 'yes'" value="yes">
                                Active
                            </option>
                            <option :selected="form['status'] == 'no'" value="no">
                                Inactive
                            </option>
                        </select>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`status`)"
                            v-text="validationErros.get(`status`)"></p>
                    </div>
                </div>

                <!-- <ListErrors :validationErrors="validationErros" /> -->

                <button type="submit" class="button-exp-fill">
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
// import ListErrors from './../components/ListErrors.vue';
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            isFormEdit: (state) => state.business_directories.isFormEdit,
            form: (state) => state.business_directories.form,
            validationErros: (state) => state.business_directories.validationErros,
            languages: (state) => state.languages.languages,
        }),
    },
    data() {
        return {
            activeTab: null,
        };
    },
    methods: {
        restrictToNumbers(event, allowedLength) {
            const keyCode = event.which ? event.which : event.keyCode;
            const inputChar = String.fromCharCode(keyCode);
            const isValidSpecialChar = /^[\+\-\(\)]$/.test(inputChar);
            const isDigit = /^\d$/.test(inputChar);
            let currentValue = event.target.value + inputChar;
            const digitCount = currentValue.replace(/[^\d]/g, "").length;
            if (!isValidSpecialChar && (!isDigit || digitCount > allowedLength)) {
                event.preventDefault();
            }
        },
        handleInput(value, key) {
            this.$store.commit("business_directories/setState", { key, value });
            if (value.trim()) {
                this.validationErros.clear(key);
            }
        },
        handleMultipleInput(key, value, language) {
            this.$store.commit("business_directories/updateState", {
                value: value,
                id: language.id,
                key,
            });
            if (value) {
                this.validationErros.clear(`${key}.${key}_${language.id}`);
            }
        },
        addUpdateForm() {
            this.$store
                .dispatch("business_directories/addUpdateForm")
                .then(() => this.$router.push({ name: "admin.business_directories.index" }
                )).catch((error) => {
                    if (error.response && error.response.data.errors) {
                        this.focusOnFirstErrorInput(error.response.data.errors);
                    }
                });
        },
        focusOnFirstErrorInput(errors) {
            console.log("Errors object:", errors);
            const firstErrorField = Object.keys(errors)[0];
            console.log("First error field name:", firstErrorField);

            if (!firstErrorField) {
                console.log("No error field found");
                return;
            }

            const fieldNameParts = firstErrorField.split(".");
            const fieldName = fieldNameParts[0];
            console.log("Stripped error field name:", fieldName);

            let inputElement = document.querySelector(
                `[name="${fieldName}"], [v-model="${fieldName}"], [data-v-model="${fieldName}"], [data-value="${fieldName}"]`
            );

            if (!inputElement) {
                console.log(`No standard input field found for ${fieldName}, checking for rich text editor...`);

                const editorId = fieldNameParts[1] || fieldName;
                const tinymceEditor = window.tinymce?.get(editorId);

                if (tinymceEditor) {
                    console.log(`Focusing on TinyMCE editor: ${editorId}`);
                    tinymceEditor.getBody().scrollIntoView({ behavior: "smooth", block: "center" });

                    setTimeout(() => {
                        tinymceEditor.focus();
                    }, 300);

                    return;
                } else {
                    console.log(`TinyMCE editor instance not found for ${editorId}`);
                }
            }

            if (inputElement) {
                console.log("Found input element:", inputElement);
                inputElement.scrollIntoView({ behavior: "smooth", block: "center" });

                setTimeout(() => {
                    inputElement.focus();
                }, 300);

            } else {
                console.log(`No input field found for ${fieldName}`);
            }
        },
        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
        fetchBusinessDirectories() {
            if (this.$route.params.id) {
                let id = this.$route.params.id;

                this.$store.commit("business_directories/setIsFormEdit", 1);
                this.$store
                    .dispatch("business_directories/fetchBusinessDirectories", {
                        id: id,
                        url: `${process.env.MIX_ADMIN_API_URL}business_directories/${id}?withBusinessDirectoryDetail=1`,
                    })
                    .then((res) => {
                        this.$store.commit("business_directories/setState", {
                            key: "id",
                            value: id,
                        });
                        let keys = [
                            'address',
                            'city',
                            'province',
                            'postal_code',
                            'phone',
                            'fax',
                            'industry',
                            'status'
                        ]
                        for (var i = 0; i < keys.length; i++) {
                            this.$store.commit("business_directories/setState", {
                                key: keys[i],
                                value: res.data.data[keys[i]],
                            });
                        }
                        let obj = {},
                            data =
                                res.data.data && res.data.data.business_directory_detail
                                    ? res.data.data.business_directory_detail
                                    : [];

                        data.map((res) => {
                            obj["name_" + res.language_id] = res.name;
                        });
                        this.$store.commit("business_directories/setState", {
                            key: "name",
                            value: obj,
                        });
                    });
            }
        },
    },
    created() {
        setOptions({ files: [] });
        this.$store.commit("business_directories/resetForm");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                data.map((res) => {
                    obj["name_" + res.id] = "";
                });
                this.$store.commit("business_directories/setState", {
                    key: "name",
                    value: obj,
                });
                this.fetchBusinessDirectories();
            });
    },
    components: {
        FilePond,
        // ListErrors,
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
