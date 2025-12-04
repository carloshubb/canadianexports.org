<template>
  <AppLayout>
    <div class="relative shadow-md sm:rounded-lg bg-white py-4">
      <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
          <div class="sm:flex-auto">
            <h1 class="can-exp-h3 mb-0 text-primary">
              Import business profile
            </h1>
            <p class="mt-2 text-sm text-gray-700">
              Import business profiles by uploading excel file
            </p>
          </div>
          <div class="mt-4 flex md:ml-4 md:mt-0">
            <router-link
              :to="{ name: 'admin.business-profiles.index' }"
              class="button-exp-fill"
            >
              Back to business profiles
            </router-link>
            <a
              href="/sample/import-sample-business-profiles.xlsx"
              class="ml-3 inline-flex items-center gap-x-1.5 button-exp-no-fill"
            >
              Download Sample file
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="-mr-0.5 h-5 w-5"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"
                />
              </svg>
            </a>
          </div>
        </div>
        <div class="mt-8 flow-root">
          <div class="-mx-4 mt-8 sm:-mx-0">
            <form
              class="px-4 md:px-6 lg:px-8"
              @submit.prevent="addUpdateForm()"
            >
              <div
                class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6"
              >
                <div class="relative z-0 w-full group">
                  <label for="import_file">Upload excel file</label>
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
              <button
                type="submit"
                class="button-exp-fill flex items-center"
                :disabled="loading"
              >
                <svg
                  v-if="loading"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  class="size-6 animate-spin mr-2"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"
                  />
                </svg>
                <span v-if="loading">Processing...</span>
                <span v-else>Submit</span>
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import { mapState } from "vuex";
import ErrorHandling from "../../ErrorHandling";
export default {
  data() {
    return {
      loading: false,
      import_file: null,
      validationErros: new ErrorHandling(),
    };
  },
  methods: {
    handleInputFile(e, field) {
      this.loading = true;
      var file = new FormData();
      file.append("file", e.target.files[0]);
      file.append("upload_dir", "business-profiles/import");
      file.append("type", "only_excel");
      axios
        .post(`${process.env.MIX_ADMIN_API_URL}media/image_again_upload`, file)
        .then((res) => {
          this.loading = false;
          this[field] = res?.data;
          // this.handleInput(res?.data, field);
        })
        .catch((error) => {
          this.loading = false;
          if (error.response && error.response.status == 422) {
            let obj = {};
            obj[field] = error.response.data.errors["file"];
            // this.$store.commit('i2b/setValidationErros', obj);
            this.validationErros.record(obj);
          }
        });
    },
    addUpdateForm() {
      this.loading = true;
      axios
        .post(`${process.env.MIX_ADMIN_API_URL}import-business-profiles`, {
          import_file: this.import_file,
        })
        .then((res) => {
          this.loading = false;
          if (res.data.status == "Success") {
            helper.swalSuccessMessage(res.data.message);
            this.$router.push({ name: "admin.business-profiles.index" });
          } else {
            helper.swalErrorMessage(res.data.message);
          }
        })
        .catch((error) => {
          this.loading = false;
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
  created() {},
};
</script>
