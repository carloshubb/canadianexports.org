<template>
  <AppLayout>
    <div class="relative shadow-md sm:rounded-lg bg-white py-4">
      <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
          <div class="sm:flex-auto">
            <h1 class="can-exp-h3 mb-0 text-primary">Coffee Wall FAQs</h1>
            <p class="mt-2 text-sm text-gray-700">
              Manage frequently asked questions for donors and beneficiaries
            </p>
          </div>
          <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <button
              @click="openForm()"
              class="button-exp-fill"
            >
              Add new FAQ
            </button>
          </div>
        </div>

        <!-- Filter tabs -->
        <div class="mt-4 border-b border-gray-200">
          <nav class="-mb-px flex space-x-8">
            <button
              @click="setFilter('all')"
              :class="[
                filterType === 'all'
                  ? 'border-blue-500 text-blue-600'
                  : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700',
                'whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium'
              ]"
            >
              All FAQs
            </button>
            <button
              @click="setFilter('donor')"
              :class="[
                filterType === 'donor'
                  ? 'border-blue-500 text-blue-600'
                  : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700',
                'whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium'
              ]"
            >
              Donor FAQs
            </button>
            <button
              @click="setFilter('beneficiary')"
              :class="[
                filterType === 'beneficiary'
                  ? 'border-blue-500 text-blue-600'
                  : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700',
                'whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium'
              ]"
            >
              Beneficiary FAQs
            </button>
          </nav>
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
                      Type
                    </th>
                    <th
                      scope="col"
                      class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                    >
                      Question
                    </th>
                    <th
                      scope="col"
                      class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                    >
                      Answer
                    </th>
                    <th
                      scope="col"
                      class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                    >
                      Order
                    </th>
                    <th
                      scope="col"
                      class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                    >
                      Active
                    </th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                      <span class="sr-only">Actions</span>
                    </th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                  <tr
                    class="hover:shadow-lg"
                    v-for="faq in filteredFaqs"
                    :key="faq.id"
                  >
                    <td class="px-3 py-4 text-sm">
                      <span
                        :class="[
                          'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
                          faq.type === 'donor' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'
                        ]"
                      >
                        {{ faq.type === 'donor' ? 'Donor' : 'Beneficiary' }}
                      </span>
                    </td>
                    <td class="px-3 py-4 text-sm text-gray-900 max-w-xs truncate">
                      {{ faq.question }}
                    </td>
                    <td class="px-3 py-4 text-sm text-gray-500 max-w-xs truncate">
                      {{ faq.answer }}
                    </td>
                    <td class="px-3 py-4 text-sm text-gray-900">
                      {{ faq.sort_order }}
                    </td>
                    <td class="px-3 py-4 text-sm">
                      <span
                        :class="[
                          'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
                          faq.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                        ]"
                      >
                        {{ faq.is_active ? 'Yes' : 'No' }}
                      </span>
                    </td>
                    <td
                      class="relative flex justify-end py-4 pl-3 pr-4 text-right text-sm font-medium"
                    >
                      <div class="flex items-center space-x-4">
                        <a
                          href="#"
                          @click.prevent="editFaq(faq.id)"
                          data-tooltip="Edit FAQ"
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
                          data-tooltip="Delete FAQ"
                          @click.prevent="deleteFaq(faq)"
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

      <!-- Modal Form -->
      <div v-if="showForm" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
          <h2 class="text-lg font-bold mb-4">{{ isFormEdit ? 'Edit' : 'Add' }} FAQ</h2>
          <form @submit.prevent="submitForm">
            <!-- Type Selection -->
            <div class="mb-4">
              <label for="type" class="block text-sm font-medium text-gray-700 mb-2">FAQ Type</label>
              <select 
                id="type" 
                v-model="form.type" 
                class="can-exp-input w-full block border border-gray-300 rounded"
                :disabled="isFormEdit"
              >
                <option value="donor">Donor</option>
                <option value="beneficiary">Beneficiary</option>
              </select>
              <p v-if="validationErros.has('type')" class="mt-2 text-sm text-red-400">
                {{ validationErros.get('type') }}
              </p>
            </div>

            <!-- Question -->
            <div class="mb-4">
              <label for="question" class="block text-sm font-medium text-gray-700 mb-2">Question</label>
              <textarea 
                id="question" 
                v-model="form.question" 
                rows="3"
                class="can-exp-input w-full block border border-gray-300 rounded" 
                placeholder="Enter the FAQ question"
              ></textarea>
              <p v-if="validationErros.has('question')" class="mt-2 text-sm text-red-400">
                {{ validationErros.get('question') }}
              </p>
            </div>

            <!-- Answer -->
            <div class="mb-4">
              <label for="answer" class="block text-sm font-medium text-gray-700 mb-2">Answer</label>
              <textarea 
                id="answer" 
                v-model="form.answer" 
                rows="5"
                class="can-exp-input w-full block border border-gray-300 rounded" 
                placeholder="Enter the FAQ answer"
              ></textarea>
              <p v-if="validationErros.has('answer')" class="mt-2 text-sm text-red-400">
                {{ validationErros.get('answer') }}
              </p>
            </div>

            <!-- Sort Order -->
            <div class="mb-4">
              <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
              <input 
                type="number" 
                id="sort_order" 
                v-model="form.sort_order" 
                class="can-exp-input w-full block border border-gray-300 rounded"
                placeholder="0"
              />
              <p class="mt-1 text-xs text-gray-500">Lower numbers appear first</p>
              <p v-if="validationErros.has('sort_order')" class="mt-2 text-sm text-red-400">
                {{ validationErros.get('sort_order') }}
              </p>
            </div>

            <!-- Active Toggle -->
            <div class="mb-4">
              <label class="flex items-center">
                <input 
                  type="checkbox" 
                  v-model="form.is_active" 
                  class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                />
                <span class="ml-2 text-sm text-gray-700">Active (visible on website)</span>
              </label>
            </div>

            <div class="flex justify-end space-x-2">
              <button type="button" class="button-exp-outline" @click="closeForm">Cancel</button>
              <button type="submit" class="button-exp-fill" :disabled="loading">
                {{ loading ? 'Saving...' : 'Submit' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import { mapState, mapGetters } from "vuex";
export default {
  computed: {
    ...mapState({
      faqs: (state) => state.coffee_wall_faqs.faqs,
      loading: (state) => state.coffee_wall_faqs.loading,
      form: (state) => state.coffee_wall_faqs.form,
      validationErros: (state) => state.coffee_wall_faqs.validationErros,
      isFormEdit: (state) => state.coffee_wall_faqs.isFormEdit,
      filterType: (state) => state.coffee_wall_faqs.filterType,
    }),
    ...mapGetters({
      filteredFaqs: 'coffee_wall_faqs/filteredFaqs'
    }),
  },
  data() {
    return {
      showForm: false,
    };
  },
  methods: {
    openForm() {
      this.$store.commit("coffee_wall_faqs/resetForm");
      this.showForm = true;
    },
    closeForm() {
      this.showForm = false;
      this.$store.commit("coffee_wall_faqs/resetForm");
    },
    submitForm() {
      this.$store.dispatch("coffee_wall_faqs/addUpdateForm")
        .then(() => {
          this.showForm = false;
          this.$store.dispatch("coffee_wall_faqs/fetchFaqs");
        })
        .catch(() => {
          // Error is handled in the store
        });
    },
    editFaq(id) {
      this.$store.dispatch("coffee_wall_faqs/fetchFaq", id).then(() => {
        this.showForm = true;
      });
    },
    deleteFaq(item) {
      if (confirm("Are you sure you want to delete this FAQ?")) {
        this.$store.dispatch("coffee_wall_faqs/deleteFaq", item.id)
          .then(() => {
            this.$store.dispatch("coffee_wall_faqs/fetchFaqs");
          })
          .catch(() => {
            alert("Failed to delete FAQ");
          });
      }
    },
    setFilter(type) {
      this.$store.commit("coffee_wall_faqs/setFilterType", type);
      this.$store.dispatch("coffee_wall_faqs/fetchFaqs");
    },
  },
  created() {
    this.$store.dispatch("coffee_wall_faqs/fetchFaqs");
  },
};
</script>

