<template>
  <AppLayout>
    <div class="relative shadow-md sm:rounded-lg bg-white py-4">
      <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
          <div class="sm:flex-auto">
            <h1 class="can-exp-h3 mb-0 text-primary">Coffee Wall Beneficiaries</h1>
            <p class="mt-2 text-sm text-gray-700">
              A list of all the beneficiaries for coffee on the wall
            </p>
          </div>
          <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <button
              @click="openForm()"
              class="button-exp-fill"
            >
              Add new beneficiary
            </button>
          </div>
        </div>
        <div class="mt-8 flow-root">
          <div class="-mx-4 sm:-mx-0">
            <div
              class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg"
            >
              <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gradient-to-l from-blue-500 to-blue-400">
                  <tr>
                    <th
                      scope="col"
                      class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                    >
                      Name
                    </th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                      <span class="sr-only">Edit</span>
                    </th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                  <tr
                    class="hover:shadow-lg"
                    v-for="beneficiary in beneficiaries"
                    :key="beneficiary.id"
                  >
                    <td
                      class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none"
                    >
                      <div class="font-medium text-gray-900">
                        {{ beneficiary.name }}
                      </div>
                    </td>
                    <td
                      class="relative flex justify-end py-4 pl-3 pr-4 text-right text-sm font-medium"
                    >
                      <div class="flex items-center space-x-4">
                        <a
                          href="#"
                          @click.prevent="editBeneficiary(beneficiary.id)"
                          data-tooltip="Edit beneficiary"
                          class="text-gray-500 hover:text-gray-700"
                        >
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"
                            />
                          </svg>
                        </a>
                        <a
                          href="#"
                          class="text-red-500 hover:text-red-700 cursor-pointer"
                          data-tooltip="Delete beneficiary"
                          @click.prevent="deleteBeneficiary(beneficiary)"
                        >
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                            />
                          </svg>
                        </a>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div v-if="showForm" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
          <h2 class="text-lg font-bold mb-4">{{ isFormEdit ? 'Edit' : 'Add' }} Beneficiary</h2>
          <form @submit.prevent="submitForm">
            <div class="mb-4">
              <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
              <input type="text" id="name" v-model="form.name" class="can-exp-input w-full block border border-gray-300 rounded" />
              <p v-if="validationErros.has('name')" class="mt-2 text-sm text-red-400">{{ validationErros.get('name') }}</p>
            </div>
            <div class="flex justify-end">
              <button type="button" class="button-exp-outline mr-2" @click="closeForm">Cancel</button>
              <button type="submit" class="button-exp-fill" :disabled="loading">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState({
      beneficiaries: (state) => state.coffee_wall_beneficiaries.beneficiaries,
      loading: (state) => state.coffee_wall_beneficiaries.loading,
      form: (state) => state.coffee_wall_beneficiaries.form,
      validationErros: (state) => state.coffee_wall_beneficiaries.validationErros,
      isFormEdit: (state) => state.coffee_wall_beneficiaries.isFormEdit,
    }),
  },
  data() {
    return {
      showForm: false,
    };
  },
  methods: {
    openForm() {
      this.$store.commit("coffee_wall_beneficiaries/resetForm");
      this.showForm = true;
    },
    closeForm() {
      this.showForm = false;
    },
    submitForm() {
      this.$store.dispatch("coffee_wall_beneficiaries/addUpdateForm").then(() => {
        this.showForm = false;
        this.$store.dispatch("coffee_wall_beneficiaries/fetchBeneficiaries");
      });
    },
    editBeneficiary(id) {
      this.$store.dispatch("coffee_wall_beneficiaries/fetchBeneficiary", id).then(() => {
        this.showForm = true;
      });
    },
    deleteBeneficiary(item) {
      if (confirm("Are you sure you want to delete this beneficiary?")) {
        this.$store.dispatch("coffee_wall_beneficiaries/deleteBeneficiary", item.id).then(() => {
          this.$store.dispatch("coffee_wall_beneficiaries/fetchBeneficiaries");
        });
      }
    },
  },
  created() {
    this.$store.dispatch("coffee_wall_beneficiaries/fetchBeneficiaries");
  },
};
</script>
