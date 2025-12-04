<template>
    <AppLayout>
        <div class="relative shadow-md sm:rounded-lg bg-white py-4">
            <header class="pt-4">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h3 class="can-exp-h3 text-primary">
                            Import inquiry to buy
                        </h3>
                        <router-link
                            :to="{ name: 'admin.i2b.index' }"
                            class="button-exp-fill"
                        >
                            Back
                        </router-link>
                    </div>
                </div>
            </header>
            <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">

                <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2  lg:grid-cols-2 gap-6 ">
                    <div class="col-span-2 relative z-0 w-full group">
                        <p class="mt-1">To access the sample import file, kindly click on the following link: <a href="/sample/import-sample-i2b.xlsx" download>Download Sample Import File</a></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="import_file">File</label>
                        <input
                            type="file"
                            name="import_file"
                            id="import_file"
                            class="can-exp-input w-full block border border-gray-300 rounded px-3 py-1.5 focus:ring-blue-600 focus:ring-1 focus:outline-blue-600 focus:border-blue-600"
                            placeholder=" "
                            accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                            @input="handleInputFile($event, 'import_file')"
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has(`import_file`)"
                            v-text="validationErros.get(`import_file`)"
                        ></p>
                    </div>
                    
                    
                </div>

                <button type="submit" class="button-exp-fill" :disabled="loading">Submit</button>

            </form>
        </div>
    </AppLayout>
</template>

<script>
import { mapState } from "vuex";
import ErrorHandling from '../../ErrorHandling';
export default {
    computed: {
        ...mapState({
            loading: (state) => state.i2b.loading,
        }),
    },
    data() {
        return {
            import_file: null,
            validationErros: new ErrorHandling(),
        };
    },
    methods: {
        handleInputFile(e, field) {
            var file = new FormData();
            file.append("file", e.target.files[0]);
            file.append("upload_dir", 'i2b/import');
            file.append("type", 'only_excel');
            axios
                .post(`${process.env.MIX_ADMIN_API_URL}media/image_again_upload`, file)
                .then((res) => {
                    this[field] = res?.data;
                    // this.handleInput(res?.data, field);
                }).catch((error) => {
                    if (error.response && error.response.status == 422) {
                        let obj = {};
                        obj[field] = error.response.data.errors['file'];
                            // this.$store.commit('i2b/setValidationErros', obj);
                            this.validationErros.record(obj);
                        }
                    });
        },
        addUpdateForm() {
            axios
                .post(`${process.env.MIX_ADMIN_API_URL}import-i2b`, {
                    import_file:this.import_file
                })
                .then((res) => {
                    if(res.data.status == 'Success'){
                        helper.swalSuccessMessage(res.data.message);
                        this.$router.push({ name: "admin.i2b.index" })
                    }
                    else{
                        helper.swalErrorMessage(res.data.message);
                    }
                }).catch((error) => {
                    if (error.response && error.response.status == 422) {
                        this.validationErros.record(error.response.data.errors);
                    } else if (
                        error.response &&
                        error.response.data &&
                        error.response.data.status == "Error"
                    ) {
                        helper.swalErrorMessage(error.response.data.message);
                    }
                    });
        },
    },
    created() {
    },
};
</script>
