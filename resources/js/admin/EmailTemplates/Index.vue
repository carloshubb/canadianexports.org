<template>
  <AppLayout>
    <div class="relative shadow-md sm:rounded-lg bg-white py-4">
      <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
          <div class="sm:flex-auto">
            <h1 class="can-exp-h3 mb-0 text-primary">Email Templates</h1>
            <p class="mt-2 text-sm text-gray-700">
              Manage all automated email contents and templates
            </p>
          </div>
          <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <router-link
              :to="{ name: 'admin.email-templates.create' }"
              class="button-exp-fill"
            >
              Create template
            </router-link>
          </div>
        </div>
        <div class="mt-8 flow-root">
          <div
            class="flex flex-col md:flex-row items-center justify-between mb-4"
          >
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative w-full md:w-auto">
              <div
                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
              >
                <svg
                  class="w-5 h-5 text-gray-500"
                  aria-hidden="true"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    fill-rule="evenodd"
                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                    clip-rule="evenodd"
                  ></path>
                </svg>
              </div>
              <input
                type="text"
                id="table-search-email-templates"
                class="block pl-10 w-full md:w-80 bg-white can-exp-input"
                placeholder="Search templates..."
                v-model="quickSearch"
                @input="quickSearchFilter"
              />
            </div>
          </div>
          <div class="-mx-4 mt-8 sm:-mx-0">
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
                      Key
                    </th>
                    <th
                      scope="col"
                      class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell"
                    >
                      Name
                    </th>
                    <th
                      scope="col"
                      class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell"
                    >
                      Subject
                    </th>
                    <th
                      scope="col"
                      class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                    >
                      Status
                    </th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                      <span class="sr-only">Actions</span>
                    </th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                  <LoadingTable v-if="loading" :loading="loading" :columns="5" />
                  <template v-else>
                  <tr
                    class="hover:shadow-lg"
                    v-for="tpl in filteredTemplates"
                    :key="tpl.id"
                  >
                    <td
                      class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-1"
                    >
                      <div class="font-medium text-gray-900">
                        <code class="bg-gray-100 px-2 py-1 rounded text-xs">{{ tpl.key }}</code>
                      </div>
                    </td>
                    <td
                      class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell"
                    >
                      <div class="text-gray-900 font-medium">
                        {{ tpl.name }}
                      </div>
                    </td>
                    <td
                      class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell"
                    >
                      <div class="text-gray-900 truncate" style="max-width: 300px;">
                        {{ tpl.subject }}
                      </div>
                    </td>
                    <td class="px-3 py-4 text-sm">
                      <span
                        :class="[
                          'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
                          tpl.is_active
                            ? 'bg-green-100 text-green-800'
                            : 'bg-gray-100 text-gray-800',
                        ]"
                      >
                        {{ tpl.is_active ? 'Active' : 'Inactive' }}
                      </span>
                    </td>
                    <td
                      class="relative flex justify-end py-4 pl-3 pr-4 text-right text-sm font-medium"
                    >
                      <div class="flex items-center space-x-4">
                        <router-link
                          :to="{
                            name: 'admin.email-templates.edit',
                            params: { id: tpl.id },
                          }"
                          data-tooltip="Edit template"
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
                        </router-link>
                        <a
                          href="#"
                          class="text-red-500 hover:text-red-700 cursor-pointer"
                          data-tooltip="Delete template"
                          @click.prevent="destroy(tpl)"
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
                  <tr v-if="filteredTemplates.length === 0">
                    <td colspan="5" class="px-6 py-12 text-center">
                      <svg
                        class="mx-auto h-12 w-12 text-gray-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        aria-hidden="true"
                      >
                        <path
                          vector-effect="non-scaling-stroke"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"
                        />
                      </svg>
                      <h3 class="mt-2 text-sm font-medium text-gray-900">
                        No templates found
                      </h3>
                      <p class="mt-1 text-sm text-gray-500">
                        Get started by creating a new email template.
                      </p>
                    </td>
                  </tr>
                  </template>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import axios from 'axios';
import _ from 'lodash';
import LoadingTable from '../components/LoadingTable.vue';

export default {
  name: 'EmailTemplatesIndex',
  components: {
    LoadingTable,
  },
  data() {
    return {
      loading: false,
      templates: [],
      quickSearch: '',
    };
  },
  computed: {
    filteredTemplates() {
      if (!this.quickSearch) {
        return this.templates;
      }
      const search = this.quickSearch.toLowerCase();
      return this.templates.filter(
        (tpl) =>
          tpl.key.toLowerCase().includes(search) ||
          tpl.name.toLowerCase().includes(search) ||
          tpl.subject.toLowerCase().includes(search)
      );
    },
  },
  mounted() {
    this.fetchTemplates();
  },
  methods: {
    async fetchTemplates() {
      this.loading = true;
      try {
        const { data } = await axios.get(`${process.env.MIX_ADMIN_API_URL}email-templates`);
        this.templates = data.data || [];
      } catch (error) {
        window.helper.swalErrorMessage(
          error?.response?.data?.message || 'Failed to load templates'
        );
      } finally {
        this.loading = false;
      }
    },
    async destroy(tpl) {
      this.$swal
        .fire({
          title: 'Are you sure?',
          text: `Delete template "${tpl.name}"? This action cannot be undone.`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it',
          cancelButtonText: 'Cancel',
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
        })
        .then(async (result) => {
          if (result.isConfirmed) {
            try {
              await axios.delete(`${process.env.MIX_ADMIN_API_URL}email-templates/${tpl.id}`);
              window.helper.swalSuccessMessage('Template deleted successfully');
              this.fetchTemplates();
            } catch (error) {
              window.helper.swalErrorMessage(
                error?.response?.data?.message || 'Failed to delete template'
              );
            }
          }
        });
    },
    quickSearchFilter: _.debounce(function () {
      // Filtering is handled by computed property
    }, 300),
  },
  watch: {
    quickSearch: function () {
      this.quickSearchFilter();
    },
  },
};
</script>

<style scoped>
</style>
