<template>
    <AppLayout>
      <div class="relative shadow-md sm:rounded-lg bg-white py-4">
        <div class="px-4 sm:px-6 lg:px-8">
          <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
              <h1 class="can-exp-h3 mb-0 text-primary">Success Stories</h1>
              <p class="mt-2 text-sm text-gray-700">
                A list of all the Success Stories
              </p>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
              <router-link
                :to="{ name: 'admin.successStories.create' }"
                class="button-exp-fill"
              >
                Add new success stories
              </router-link>
            </div>
          </div>
          <div class="mt-8 flow-root">
            <div
              class="flex flex-col md:flex-row items-center justify-between mb-4"
            >
              <div class="-mt-4 sm:mt-0 mb-2 sm:mb-0">
                show
                <select
                  class="rounded-md px-3 pr-8 py-1"
                  @input="updateLimit($event.target.value)"
                >
                  <option value="10" :selected="limit == '10'">10</option>
                  <option value="25" :selected="limit == '25'">25</option>
                  <option value="50" :selected="limit == '50'">50</option>
                  <option value="100" :selected="limit == '100'">100</option>
                </select>
                success stories
              </div>
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
                <form autocomplete="off" @submit.prevent>
                <input
                  type="text"
                  id="table-search-successStories"
                  class="block pl-10 w-full md:w-80 bg-white can-exp-input"
                  placeholder="Search"
                  v-model="quickSearch"
                />
              </form>
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
                        Name
                      </th>
                      <th
                        scope="col"
                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                      >
                        Company name
                      </th>
                      <th
                        scope="col"
                        class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell"
                      >
                        Email
                      </th>
                      <th
                        scope="col"
                        class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell"
                      >
                        Message
                      </th>
                      <th
                        scope="col"
                        class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell"
                      >
                        Created
                      </th>
                      <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
      Status
    </th>
                      <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                        <span class="sr-only">Edit</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-200 bg-white">
                    <tr
                      class="hover:shadow-lg"
                     v-for="successStorie in successStories" :key="successStorie.id"
                    >

                      <td
                        class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-1"
                      >
                        {{
                           successStorie.success_stories_details &&
                successStorie.success_stories_details[0]
                    ? successStorie.success_stories_details[0].name
                    : ""
                        }}
                        <dl class="font-normal lg:hidden">
                          <dt class="sr-only">Company name</dt>
                          <dd class="mt-1 truncate text-gray-500">
                            {{  successStorie.success_stories_details &&
                successStorie.success_stories_details[0]
                    ? successStorie.success_stories_details[0].company_name
                    : "" }}
                          </dd>
                          <dt class="sr-only">Email</dt>
                          <dd class="mt-1 truncate text-gray-500">
                            {{
                              successStorie.success_stories_details &&
                successStorie.success_stories_details[0]
                    ? successStorie.success_stories_details[0].email
                    : ""
                            }}
                          </dd>
                          <dt class="sr-only">Message</dt>
                          <dd class="mt-1 truncate text-gray-500">
                           {{
                              successStorie.success_stories_details &&
                successStorie.success_stories_details[0]
                    ? successStorie.success_stories_details[0].message
                    : ""
                            }}
                          </dd>
                          <dt class="sr-only">Created</dt>
                          <dd class="mt-1 truncate text-gray-500">
                            {{ formatDate(successStorie.created_at) }}
                          </dd>
                        </dl>
                      </td>
                      <td
                        class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell"
                      >
                        {{ successStorie.success_stories_details &&
                successStorie.success_stories_details[0]
                    ? successStorie.success_stories_details[0].company_name
                    : "" }}
                      </td>
                      <td
                        class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell"
                      >
                        {{
                          successStorie.success_stories_details &&
                          successStorie.success_stories_details[0]
                            ? successStorie.success_stories_details[0].email
                            : ""
                        }}
                      </td>
                      <td
                        class="hidden w-96 px-3 py-4 text-sm text-gray-500 lg:table-cell"
                      >
                        <div>
                          <span v-if="!successStorie.showFullMessage">
                            {{
                              truncateMessage(
                                successStorie.success_stories_details &&
                                successStorie.success_stories_details[0]
                                  ? successStorie.success_stories_details[0].message
                                  : ""
                              )
                            }}<span
                              v-if="
                                isLongMessage(
                                    successStorie.success_stories_details &&
                                    successStorie.success_stories_details[0]
                                    ? successStorie.success_stories_details[0].message
                                    : ''
                                )
                              "
                              >...</span
                            >
                          </span>
                          <span v-else>
                            {{
                              successStorie.success_stories_details &&
                              successStorie.success_stories_details[0]
                                ? successStorie.success_stories_details[0].message
                                : ""
                            }}
                          </span>
                          <a
                            v-if="
                              isLongMessage(
                                successStorie.success_stories_details &&
                                successStorie.success_stories_details[0]
                                  ? successStorie.success_stories_details[0].message
                                  : ''
                              )
                            "
                            href="#"
                            @click.prevent="toggleMessage(successStorie)"
                            class="text-blue-600 hover:text-blue-800 text-sm"
                          >
                            {{
                              successStorie.showFullMessage
                                ? "Show Less"
                                : "Read More"
                            }}
                          </a>
                        </div>

                        <!-- {{ testimonial.testimonial_detail && testimonial.testimonial_detail[0] ? testimonial.testimonial_detail[0].comment : '' }} -->
                      </td>
                      <td
                        class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell"
                      >
                        {{ formatDate(successStorie.created_at) }}
                      </td>
                      <td class="px-3 py-4 text-sm text-gray-500">
                      <div class="relative">
                        <SwitchGroup as="div" class="flex items-center">
                          <Switch
                            @click="toggleStatus(successStorie)"
                            :class="[
                              successStorie.status === 'active' ? 'bg-indigo-600' : 'bg-gray-200',
                              'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2',
                            ]"
                          >
                            <span
                              aria-hidden="true"
                              :class="[
                                successStorie.status === 'active' ? 'translate-x-5' : 'translate-x-0',
                                'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out',
                              ]"
                            />
                          </Switch>
                          <SwitchLabel as="span" class="ml-3 text-sm">
                            <span class="font-medium text-gray-900">{{
                              successStorie.status === 'active' ? 'Active' : 'Inactive'
                            }}</span>
                            {{ " " }}
                          </SwitchLabel>
                        </SwitchGroup>
                      </div>
                    </td>
                      <td
                        class="relative flex justify-end py-4 pl-3 pr-4 text-right text-sm font-medium"
                      >
                        <div class="flex items-center space-x-4">
                          <router-link
                            :to="{
                              name: 'admin.successStories.edit',
                              params: { id: successStorie.id },
                            }"
                            data-tooltip="Edit successStories"
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
                            data-tooltip="Delete successStories"
                            @click.prevent="deleteSuccessStories(successStorie)"
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
              <div
                class="px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6"
                v-if="pagination"
              >
                <div class="flex justify-between items-center w-full">
                  <div>
                    <p
                      class="text-sm text-gray-700"
                      v-if="pagination.current_page"
                    >
                      Page {{ pagination.current_page }} of
                      {{ pagination.last_page }}
                    </p>
                  </div>
                  <div>
                    <nav
                      class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                      aria-label="Pagination"
                      v-if="pagination.next_page_url || pagination.prev_page_url"
                    >
                      <a
                        href="#"
                        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                        v-bind:class="[{ disabled: !pagination.prev_page_url }]"
                        @click="fetchSuccessStories(pagination.prev_page_url)"
                      >
                        <span class="sr-only">Previous</span>
                        <svg
                          class="h-5 w-5"
                          x-description="Heroicon name: solid/chevron-left"
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 20 20"
                          fill="currentColor"
                          aria-hidden="true"
                        >
                          <path
                            fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd"
                          ></path>
                        </svg>
                      </a>
                      <a
                        href="#"
                        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                        v-bind:class="[{ disabled: !pagination.next_page_url }]"
                        @click="fetchSuccessStories(pagination.next_page_url)"
                      >
                        <span class="sr-only">Next</span>
                        <svg
                          class="h-5 w-5"
                          x-description="Heroicon name: solid/chevron-right"
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 20 20"
                          fill="currentColor"
                          aria-hidden="true"
                        >
                          <path
                            fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"
                          ></path>
                        </svg>
                      </a>
                    </nav>
                  </div>
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
  import moment from "moment";
  export default {
    components: {
      LoadingTable,
    },
    computed: {
      ...mapState({
        limit: (state) => state.successStories.limit,
        form: (state) => state.successStories.form,
        successStories: (state) => state.successStories.successStories,
        pagination: (state) => state.successStories.pagination,
        validationErros: (state) => state.successStories.validationErros,
        searchParam: (state) => state.successStories.searchParam,
        loading: (state) => state.successStories.loading,
      }),
    },
    data() {
      return {
        quickSearch: null,
        showModalId: null,
        showModal: false,
        showFullMessage: false,
      };
    },
    methods: {
        async toggleStatus(successStorie) {
  try {
    const newStatus = successStorie.status === "active" ? "inactive" : "active";

    // Dispatch Vuex action to update the state properly
    await this.$store.dispatch("successStories/updateSuccessStoriesStatus", {
      id: successStorie.id,
      status: newStatus,
    });

    // API call to update status in the backend
    await axios.put(`${process.env.MIX_ADMIN_API_URL}successStories/${successStorie.id}/status`, {
      status: newStatus,
    });

  } catch (error) {
    console.error("Error updating status:", error);
  }
},
      truncateMessage(message) {
        return message.split(" ").slice(0, 10).join(" ");
      },
      toggleMessage(form) {
        form.showFullMessage = !form.showFullMessage;
      },
      isLongMessage(message) {
        return message.split(" ").length > 10;
      },
      formatDate(dateString) {
        return moment(dateString).format("MMMM D, YYYY");
      },
      fetchSuccessStories(page_url) {
        this.$store.dispatch("successStories/fetchSuccessStories", { url: page_url });
      },
      updateLimit(value) {
        this.$store.commit("successStories/setLimit", value);
        this.$store.dispatch("successStories/fetchSuccessStories");
      },
      deleteSuccessStories(item) {
    this.$swal
      .fire({
        title: "Enter password",
        input: "password",
        inputAttributes: {
          autocapitalize: "off",
          required: true,
        },
        showCancelButton: true,
        confirmButtonText: "Submit",
        showLoaderOnConfirm: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        customClass: {
          confirmButton: "inline-flex items-center button-exp-fill",
          cancelButton:
            "inline-flex items-center bg-red-500 hover:bg-red-600 button-exp-fill cursor-pointer border-red-500",
          title: "card-heading font-normal text-gray-800 px-4",
          input: "can-exp-input w-auto",
        },
        preConfirm: (password) => {
          return new Promise((resolve, reject) => {
            if (!password) {
              this.$swal.showValidationMessage("Password is required");
              reject();
            } else {
              resolve(password); // Pass the entered password to the next step
            }
          });
        },
      })
      .then((result) => {
        if (result.isConfirmed) {
          // Show the second confirmation Swal
          this.$swal
            .fire({
              title: "Are you sure you want to delete it?",
              icon: "warning",
              showCancelButton: true,
              confirmButtonText: "Yes",
              cancelButtonText: "No",
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
            })
            .then((confirmResult) => {
              if (confirmResult.isConfirmed) {
                // Perform the delete operation only if "Yes" is clicked
                this.$store
                  .dispatch("successStories/deleteSuccessStories", {
                    id: item.id,
                    password: result.value, // Use the password entered in the first Swal
                  })
                  .then((res) => {
                    if (res.data.status === "Success") {
                      helper.swalSuccessMessage(
                        res.data.message || "Deleted successfully"
                      );
                      this.$store.dispatch("successStories/fetchSuccessStories");
                    } else {
                      helper.swalErrorMessage(
                        res.data.message || "Deletion failed"
                      );
                    }
                  })
                  .catch((error) => {
                    helper.swalErrorMessage(error?.message || "Error deleting");
                  });
              }
            });
        }
      });
  },

      quickSearchFilter: _.debounce(function () {
        this.$store.commit("successStories/setSearchParam", this.quickSearch);
        this.$store.dispatch("successStories/fetchSuccessStories");
      }, 500),
      actionModal(id) {
        this.showModalId = id;
        this.showModal = !this.showModal;
      },
    },
    created() {
      this.$store.commit("successStories/setLimit", 100);
      this.$store.commit("successStories/setSortBy", "successStories_name");
      this.$store.commit("successStories/setSortType", "asc");
      this.$store.commit("languages/setSearchParam", "");
      this.$store.dispatch("successStories/fetchSuccessStories");
    },
    watch: {
      quickSearch: function () {
        this.quickSearchFilter();
      },
    },
  };
  </script>
