<template>
  <AppLayout>
    <div class="relative shadow-md sm:rounded-lg bg-white py-4">
      <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
          <div class="sm:flex-auto">
            <h1 class="can-exp-h3 text-primary">Customers</h1>
            <p class="mt-2 text-sm text-gray-700">
              A list of all the users in system which are registered as business
              profile or event organizers.
            </p>
          </div>
          <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <router-link
              :to="{ name: 'admin.users.create' }"
              class="button-exp-fill"
            >
              Add new user
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
              customers
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
                id="table-search-users"
                class="block pl-10 w-full md:w-80 bg-white can-exp-input"
                placeholder="Search for customers"
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
                      Customer
                    </th>
                    <th
                      scope="col"
                      class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell"
                    >
                      Customer Type
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
                      Status
                    </th>
                    <th
                      scope="col"
                      class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell"
                    >
                      Last Updated
                    </th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                      <span class="sr-only">Edit</span>
                    </th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                  <tr
                    class="hover:shadow-lg"
                    v-for="user in users"
                    :key="user.id"
                  >
                    <td
                      class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-1"
                    >
                      <div class="flex items-center">
                        <div>
                          <span>{{ user.name }}</span>
                          <span
                            v-if="user.is_account_closed"
                            class="ml-2 bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded"
                          >
                            A/C closed
                          </span>
                        </div>
                      </div>

                      <dl class="font-normal lg:hidden">
                        <dt class="sr-only">Title</dt>
                        <dd class="mt-1 truncate text-gray-700">
                          <span
                            v-if="user.type && typeof user.type === 'string'"
                          >
                            {{ capitalizeFirstLetter(user.type) }}
                          </span>
                          <span v-else> No type available </span>
                        </dd>
                        <dt class="sr-only">Email</dt>
                        <dd class="mt-1 truncate text-gray-500">
                          {{ user.email }}
                        </dd>
                        <dt class="sr-only">Status</dt>
                        <dd class="mt-1 truncate text-gray-500">
                          <SwitchGroup as="div" class="flex items-center">
                            <Switch
                              @click="updateActivationStatus(user)"
                              :class="[
                                user.is_active
                                  ? 'bg-indigo-600'
                                  : 'bg-gray-200',
                                'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2',
                              ]"
                            >
                              <span
                                aria-hidden="true"
                                :class="[
                                  user.is_active
                                    ? 'translate-x-5'
                                    : 'translate-x-0',
                                  'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out',
                                ]"
                              />
                            </Switch>
                            <SwitchLabel as="span" class="ml-3 text-sm">
                              <span class="font-medium text-gray-900">{{
                                user.is_active ? "Active" : "Inactive"
                              }}</span>
                              {{ " " }}
                            </SwitchLabel>
                          </SwitchGroup>
                        </dd>
                        <dt class="sr-only">Last Updated</dt>
                        <dd class="mt-1 truncate text-gray-700">
                          {{ formatDate(user.updated_at) }}
                        </dd>
                      </dl>
                    </td>
                    <td
                      class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell"
                    >
                      <div class="text-gray-900">
                        {{ capitalizeFirstLetter(user.type) }}
                      </div>
                    </td>
                    <td
                      class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell"
                    >
                      <div class="text-gray-900">
                        {{ user.email }}
                      </div>
                    </td>
                    <td
                      class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell"
                    >
                      <div class="relative">
                        <SwitchGroup as="div" class="flex items-center">
                          <Switch
                            @click="updateActivationStatus(user)"
                            :class="[
                              user.is_active ? 'bg-indigo-600' : 'bg-gray-200',
                              'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2',
                            ]"
                          >
                            <span
                              aria-hidden="true"
                              :class="[
                                user.is_active
                                  ? 'translate-x-5'
                                  : 'translate-x-0',
                                'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out',
                              ]"
                            />
                          </Switch>
                          <SwitchLabel as="span" class="ml-3 text-sm">
                            <span class="font-medium text-gray-900">{{
                              user.is_active ? "Active" : "Inactive"
                            }}</span>
                            {{ " " }}
                          </SwitchLabel>
                        </SwitchGroup>
                      </div>
                    </td>
                    <td
                      class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell"
                    >
                      {{ formatDate(user.updated_at) }}
                    </td>
                    <td
                      class="relative py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0"
                    >
                      <div class="flex items-center space-x-4">
                        <a
                          @click.prevent="setConfirmationModal(user)"
                          class="cursor-pointer text-yellow-500 hover:text-yellow-600"
                          data-tooltip="Reset password & send email"
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
                              d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"
                            />
                          </svg>
                        </a>
                        <router-link
                          :to="{
                            name: 'admin.users.show',
                            params: { id: user.id },
                          }"
                          data-tooltip="View customer detail information"
                          class="text-blue-500 hover:text-blue-700"
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
                              d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"
                            />
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                            />
                          </svg>
                        </router-link>

                        <router-link
                          :to="{
                            name: 'admin.users.edit',
                            params: { id: user.id },
                          }"
                          data-tooltip="Edit customer information"
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
                          :to="{
                            name: 'admin.users.edit',
                            params: { id: user.id },
                          }"
                          class="text-red-500 hover:text-red-700 cursor-pointer"
                          data-tooltip="Delete customer"
                          @click.prevent="deleteUser(user)"
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
                    Page
                    {{ pagination.current_page }} of
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
                      v-bind:class=" [
                        {
                          disabled: !pagination.prev_page_url,
                        },
                      ]"
                      @click.prevent="jumpPages(-10)"
                    >
                      <span class="sr-only">Jump back 10</span>
                      <svg
                        class="h-5 w-5"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 20 20"
                        stroke="currentColor"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M13 17l-5-5m0 0l5-5m-5 5h12"
                        />
                      </svg>
                    </a>
                    <a
                      href="#"
                      class="relative inline-flex items-center px-2 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                      v-bind:class=" [
                        {
                          disabled: !pagination.prev_page_url,
                        },
                      ]"
                      @click.prevent="goToPage(pagination.current_page - 1)"
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
                    <span class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300">
                      Page {{ pagination.current_page }} of
                      {{ pagination.last_page }}
                    </span>
                    <a
                      href="#"
                      class="relative inline-flex items-center px-2 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                      v-bind:class=" [
                        {
                          disabled: !pagination.next_page_url,
                        },
                      ]"
                      @click.prevent="goToPage(pagination.current_page + 1)"
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
                    <a
                      href="#"
                      class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                      v-bind:class=" [
                        {
                          disabled: !pagination.next_page_url,
                        },
                      ]"
                      @click.prevent="jumpPages(10)"
                    >
                      <span class="sr-only">Jump forward 10</span>
                      <svg
                        class="h-5 w-5"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 20 20"
                        stroke="currentColor"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M7 7l5 5m0 0l-5 5m5-5H1"
                        />
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
import { ref } from "vue";
import { Switch, SwitchGroup, SwitchLabel } from "@headlessui/vue";
import _ from "lodash";
import { mapState } from "vuex";
import LoadingTable from "../components/LoadingTable.vue";
import moment from "moment";
export default {
  components: {
    LoadingTable,
    Switch,
    SwitchGroup,
    SwitchLabel,
  },
  computed: {
    ...mapState({
      limit: (state) => state.users.limit,
      form: (state) => state.users.form,
      users: (state) => state.users.users,
      pagination: (state) => state.users.pagination,
      validationErros: (state) => state.users.validationErros,
      searchParam: (state) => state.users.searchParam,
      loading: (state) => state.users.loading,
    }),
  },
  data() {
    return {
      quickSearch: null,
      showModalId: null,
      showModal: false,
      displayConfirmationModal: false,
      confirmationModalId: null,
      dropdownOpen: null,
    };
  },
  methods: {
    capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
    formatDate(dateString) {
      return moment(dateString).format("MMMM D, YYYY");
    },
    setConfirmationModal(user) {
      this.$swal
        .fire({
          title: "Are you sure?",
          text: "Account's password will be reset, and a password reset request will be sent soon!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, send email!",
          showCloseButton: true,
          customClass: {
            confirmButton: "inline-flex items-center button-exp-fill",
            cancelButton:
              "inline-flex items-center bg-red-500 hover:bg-red-600 button-exp-fill cursor-pointer border-red-500",
          },
        })
        .then((result) => {
          if (result.isConfirmed) {
            this.$store
              .dispatch("users/sendWelcomeEmail", {
                id: user.id,
              })
              .then((res) => {
                if (res.data.status == "Success") {
                }
              });
          }
        });
    },
    goToPage(page) {
      if (!page || page < 1 || page > (this.pagination?.last_page || 1)) return;
      this.$router.push({ query: { ...this.$route.query, page } });
    },
    jumpPages(offset) {
      const target = (this.pagination?.current_page || 1) + offset;
      this.goToPage(target);
    },
    fetchUsers(page_url) {
      // If page_url is a number, treat as page number
      if (typeof page_url === 'number') {
        this.goToPage(page_url);
        return;
      }
      // ...existing code...
    },
    updateLimit(value) {
      this.$store.commit("users/setLimit", value);
      this.$store.dispatch("users/fetchUsers");
    },
    deleteUser(item) {
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
            resolve(password); // Proceed to confirmation dialog with password
          }
        });
      },
    })
    .then((result) => {
      if (result.isConfirmed) {
        // Show confirmation dialog after password is entered
        this.$swal
          .fire({
            title: "Are you sure you want to delete this user?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
          })
          .then((confirmResult) => {
            if (confirmResult.isConfirmed) {
              // Proceed with the delete operation if "Yes" is clicked
              this.$store
                .dispatch("users/deleteUser", {
                  id: item.id,
                  password: result.value, // Pass the password to the delete action
                })
                .then((res) => {
                  if (res.data.status === "Success") {
                    helper.swalSuccessMessage(
                      res.data.message || "User deleted successfully"
                    );
                    this.$store.dispatch("users/fetchUsers");
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
      this.$store.commit("users/setSearchParam", this.quickSearch);
      this.$store.dispatch("users/fetchUsers");
    }, 500),
    actionModal(id) {
      this.showModalId = id;
      this.showModal = !this.showModal;
    },
    updateActivationStatus(user) {
      this.$store.dispatch("users/updateActivationStatus", {
        status: user.is_active ? false : true,
        user_id: user.id,
      });
    },
  },
  created() {
    this.$store.commit("users/setLimit", 100);
    this.$store.commit("users/setSortBy", "name");
    this.$store.commit("users/setSortType", "asc");
    this.$store.dispatch("users/fetchUsers");
    // If page param exists in URL, fetch that page
    const page = parseInt(this.$route.query.page);
    if (page && !isNaN(page)) {
      this.$store.dispatch("users/fetchUsers", { page });
    }
  },
  watch: {
    quickSearch: function () {
      this.quickSearchFilter();
    },
    '$route.query.page': function(newPage) {
      if (newPage) {
        this.$store.dispatch("users/fetchUsers", { page: parseInt(newPage) });
      }
    },
  },
};
</script>

<style scoped>
.dropdown-content {
  display: none;
}
.dropdown-item:hover {
  background-color: #f3f4f6;
}
</style>
