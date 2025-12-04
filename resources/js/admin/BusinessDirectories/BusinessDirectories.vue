<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                    <h1 class="can-exp-h3 mb-0 text-primary">
                        Business directories
                    </h1>
                    <p class="mt-2 text-sm text-gray-700">
                        A list of all the business directories created by Canadian Exporter admin
                    </p>
                    </div>
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <router-link :to="{ name: 'admin.business_directories.create' }"
                        class="button-exp-fill">
                        Add new business directory
                    </router-link>

                    <router-link :to="{ name: 'admin.business-directories.bulk.import' }"
                        class="ml-3 inline-flex items-center gap-x-1.5 button-exp-no-fill">
                         Import business directories 
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-mr-0.5 h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                    </router-link>
                    </div>
                </div>
                <div class="mt-8 flow-root">
                    <div class="flex flex-col md:flex-row items-center justify-between mb-4">
                    <div class="-mt-4 sm:mt-0 mb-2 sm:mb-0">
                        show
                        <select class="rounded-md px-3 pr-8 py-1" @input="updateLimit($event.target.value)">
                        <option value="10" :selected="limit = 10">10</option>
                        <option value="25" :selected="limit = 25">25</option>
                        <option value="50" :selected="limit = 50">50</option>
                        <option value="100" :selected="limit = 100">100</option>
                        </select>
                        business directory
                    </div>
                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative w-full md:w-auto">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd"></path>
                    </svg>
                    </div>
                    <form autocomplete="off" @submit.prevent>
                    <input type="text" id="table-search-business-categories" class="block pl-10 w-full md:w-80 bg-white can-exp-input"
                    placeholder="Search" v-model="quickSearch" />
                </form>
                </div>
                </div>
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gradient-to-l from-blue-500 to-blue-400">
                            <tr class="divide-x divide-gray-200">
                                <th scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Name</th>
                                <th scope="col"
                                    class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                    Edit</th>
                            </tr>
                        </thead>
                        <LoadingTable :loading="loading" columns="2" />
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <tr class="bg-white divide-x divide-gray-200 hover:bg-gray-50"
                                v-for="business_directory in business_directories" :key="business_directory.id">
                                <td class="relative py-4 pl-4 pr-3 text-base sm:pl-6 flex items-center space-x-2">
                                    <img v-if="business_directory.image" class="w-10 h-10 rounded-full"
                                        :src="'/' + business_directory.image.path" alt="Article Category image" />
                                    <div class="font-medium text-gray-900 text-base">
                                        {{ business_directory.business_directory_detail &&
                                            business_directory.business_directory_detail[0] ?
                                            business_directory.business_directory_detail[0].name : '' }}
                                    </div>
                                </td>

                                <td
                                    class="relative py-3.5 pl-3 pr-4 text-center text-sm font-medium sm:pr-6 space-x-2 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <router-link
                                            :to="{ name: 'admin.business_directories.edit', params: { id: business_directory?.id } }"
                                            type="button" data-modal-target="editUserModal"
                                            data-modal-show="editUserModal"
                                            class="text-gray-500 hover:text-gray-700 cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                        </router-link>
                                        <a :to="{ name: 'admin.business_directories.edit', params: { id: business_directories.id } }"
                                            type="button" data-modal-target="editUserModal"
                                            data-modal-show="editUserModal"
                                            class="text-red-500 hover:text-red-700 cursor-pointer"
                                            @click.prbusiness_directory="deletebusiness_directory(business_directory)">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
   
                <div class="px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6" v-if="pagination">
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                      <div>
                        <p class="text-sm text-gray-700" v-if="pagination.current_page">
                          Page {{ pagination.current_page }} of {{ pagination.last_page }}
                        </p>
                      </div>
                      <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination" v-if="pagination.next_page_url || pagination.prev_page_url">
                        <a href="#"
                        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50" v-bind:class="[{disabled: !pagination.prev_page_url}]" @click="fetchBusinessCategories(pagination.prev_page_url)">
                        <span class="sr-only">Previous</span>
                        <svg class="h-5 w-5" x-description="Heroicon name: solid/chevron-left"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd"></path>
                        </svg>
                        </a>

                        <a href="#"
                        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                        v-bind:class="[{disabled: !pagination.next_page_url}]" @click.prevent="fetchBusinessCategories(pagination.next_page_url)">
                        <span class="sr-only">Next</span>
                        <svg class="h-5 w-5" x-description="Heroicon name: solid/chevron-right"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                        </svg>
                        </a>
                    </nav>
                      </div>
                    </div>
                  </div>
            </div>
            </div>
        </div>

    </AppLayout>
</template>
<script>
import _ from "lodash";
import { mapState } from "vuex";
import LoadingTable from "../components/LoadingTable.vue";
export default {
    components: {
        LoadingTable,
    },
    computed: {
        ...mapState({
            limit: (state) => state.business_directories.limit,
            form: (state) => state.business_directories.form,
            business_directories: (state) => state.business_directories.business_directories,
            pagination: (state) => state.business_directories.pagination,
            validationErros: (state) => state.business_directories.validationErros,
            searchParam: (state) => state.business_directories.searchParam,
            loading: (state) => state.business_directories.loading,
        }),
    },
    data() {
        return {
            quickSearch: null,
        };
    },
    methods: {
        fetchBusinessDirectories(page_url) {
            this.$store.dispatch("business_directories/fetchBusinessDirectories", { url: page_url });
        },
        fetchBusinessDirectoriesByPage(page) {
      const baseUrl = this.pagination.base_url || this.pagination.first_page_url.split("?")[0];
      const queryParams = `?page=${page}`;
      const fullUrl = `${baseUrl}${queryParams}`;
      this.fetchBusinessDirectories(fullUrl);
    },
    // getPageNumbers() {
    //   const pages = [];
    //   const totalPages = this.pagination.last_page || 1;
    //   const currentPage = this.pagination.current_page || 1;

    //   if (totalPages <= 12) {
    //     for (let i = 1; i <= totalPages; i++) {
    //       pages.push(i);
    //     }
    //   } else {
    //     for (let i = 1; i <= 10; i++) {
    //       pages.push(i);
    //     }

    //     if (totalPages > 12) {
    //       pages.push("...");
    //     }

    //     pages.push(totalPages - 1);
    //     pages.push(totalPages);
    //   }

    //   return pages;
    // },
    getPageNumbers() {
      const pages = [];
      const totalPages = this.pagination.last_page || 1;
      const currentPage = this.pagination.current_page || 1;

      if (totalPages <= 12) {
        for (let i = 1; i <= totalPages; i++) {
          pages.push(i);
        }
      } else {
        pages.push(1, 2);

        if (currentPage >= 10) {
          pages.push("...");
          pages.push(currentPage - 1, currentPage, currentPage + 1);
          pages.push("...");
        }
        else if (currentPage > 10 && currentPage < totalPages - 3) {
          pages.push("...");
          pages.push(currentPage - 1, currentPage, currentPage + 1);
          pages.push("...");
        } else if (currentPage <= 10) {
          for (let i = 3; i <= 10; i++) {
            pages.push(i);
          }
          pages.push("...");
        }

        pages.push(totalPages - 1, totalPages);
      }

      return pages;
    },
        updateLimit(value) {
            this.$store.commit("business_directories/setLimit", value);
            this.$store.dispatch("business_directories/fetchBusinessDirectories");
        },
        deletebusiness_directory(business_directory) {
            this.$swal
                .fire({
                    title: "Enter Password",
                    input: "password",
                    inputAttributes: {
                        autocapitalize: "off",
                        required: true,
                    },
                    showCancelButton: true,
                    confirmButtonText: "Submit",
                    showLoaderOnConfirm: true,
                    preConfirm: (password) => {
                        return this.$store
                            .dispatch("business_directories/deleteTeam", {
                                id: business_directory.id,
                                password: password,
                            })
                            .then((res) => {
                                if (res.data.status !== "Success") {
                                    this.$swal.showValidationMessage(
                                        `Request failed: ${res.data.message}`
                                    );
                                }
                                return res;
                            })
                            .catch((error) => {
                                // Show validation message on error
                                if (error.response && error.response.status === 403) {
                                    this.$swal.showValidationMessage(
                                        "Incorrect password. Please try again."
                                    );
                                } else {
                                    this.$swal.showValidationMessage(
                                        `Request failed: ${error.message}`
                                    );
                                }
                            });
                    },
                    allowOutsideClick: () => !this.$swal.isLoading(),
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        helper.swalSuccessMessage(result?.value?.data?.message || "");
                        this.$store.dispatch("business_directories/fetchBusinessDirectories");
                    }
                });
        },
        quickSearchFilter: _.debounce(function () {
            this.$store.commit("business_directories/setSearchParam", this.quickSearch);
            this.$store.dispatch("business_directories/fetchBusinessDirectories");
        }, 500),
    },
    created() {
        this.$store.commit("business_directories/setSearchParam", "");
        this.$store.commit("business_directories/setLimit", 100);
        this.$store.commit("business_directories/setSortBy", "business_directory_name");
        this.$store.commit("business_directories/setSortType", "asc");
        this.$store.dispatch("business_directories/fetchBusinessDirectories");
    },
    watch: {
        quickSearch: function () {
            this.quickSearchFilter();
        },
    },
};
</script>
