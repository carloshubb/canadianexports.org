<template>
  <AppLayout>
    <div class="relative shadow-md sm:rounded-lg bg-white py-4">
      <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
          <div class="sm:flex-auto">
            <h1 class="can-exp-h3 mb-0 text-primary">
              Contact / feedback messages
            </h1>
            <p class="mt-2 text-sm text-gray-700">
              A list of all the contact & feedback messages which are sent to
              Canadian Exporter
            </p>
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
              messages
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
              <input
                type="text"
                id="table-search-forms"
                class="block pl-10 w-full md:w-80 bg-white can-exp-input"
                placeholder="Search"
                v-model="quickSearch"
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
                      Sender
                    </th>
                    <th
                      scope="col"
                      class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell"
                    >
                      Message type
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
                      Business profile
                    </th>
                    <th
                      scope="col"
                      class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell"
                    >
                      Sent Date
                    </th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                  <tr
                    class="hover:shadow-lg"
                    v-for="contact_form in contact_forms"
                    :key="contact_form.id"
                  >
                    <td
                      class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-1"
                    >
                      <div class="font-medium text-gray-900">
                        {{ contact_form.name }}
                      </div>
                      <div class="mt-1 text-gray-500">
                        {{ contact_form.email }}
                      </div>
                      <dl class="font-normal lg:hidden">
                        <dt class="sr-only">Message type</dt>
                        <dd class="mt-1 truncate text-gray-700">
                          <span
                            v-if="
                              contact_form.type &&
                              typeof contact_form.type === 'string'
                            "
                          >
                            {{ capitalizeFirstLetter(contact_form.type) }}
                          </span>
                          <span v-else> No type available </span>
                        </dd>
                        <dt class="sr-only">Message</dt>
                        <dd class="mt-1 text-gray-500">
                          {{ contact_form.message }}
                        </dd>
                        <dt class="sr-only">Business user</dt>
                        <dd class="mt-1 truncate text-gray-500">
                          {{
                            contact_form.email_sent_by_user
                              ? contact_form.email_sent_by_user.name
                              : ""
                          }}
                        </dd>
                        <dt class="sr-only">Sent date</dt>
                        <dd class="mt-1 truncate text-gray-700">
                          {{ formatDate(contact_form.created_at) }}
                        </dd>
                      </dl>
                    </td>
                    <td
                      class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell"
                    >
                      <div class="text-gray-900">
                        <span
                          v-if="
                            contact_form.type &&
                            typeof contact_form.type === 'string'
                          "
                        >
                          {{ capitalizeFirstLetter(contact_form.type) }}
                        </span>
                        <span v-else> No type available </span>
                      </div>
                    </td>
                    <td
                      class="hidden w-96 px-3 py-4 text-sm text-gray-500 lg:table-cell"
                    >
                      <div>
                        <span v-if="!contact_form.showFullMessage">
                          {{ truncateMessage(contact_form.message)
                          }}<span v-if="isLongMessage(contact_form.message)"
                            >...</span
                          >
                        </span>
                        <span v-else>
                          {{ contact_form.message }}
                        </span>
                        <a
                          v-if="isLongMessage(contact_form.message)"
                          href="#"
                          @click.prevent="toggleMessage(contact_form)"
                          class="text-blue-600 hover:text-blue-800 text-sm"
                        >
                          {{
                            contact_form.showFullMessage
                              ? "Show Less"
                              : "Read More"
                          }}
                        </a>
                      </div>
                    </td>
                    <td
                      class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell"
                    >
                      {{
                        contact_form.email_sent_by_user
                          ? contact_form.email_sent_by_user.name
                          : ""
                      }}
                    </td>
                    <td
                      class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell"
                    >
                      {{ formatDate(contact_form.created_at) }}
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
                      @click="fetchContactForms(pagination.prev_page_url)"
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
                      @click="fetchContactForms(pagination.next_page_url)"
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
      limit: (state) => state.contact_forms.limit,
      form: (state) => state.contact_forms.form,
      contact_forms: (state) => state.contact_forms.contact_forms,
      pagination: (state) => state.contact_forms.pagination,
      searchParam: (state) => state.contact_forms.searchParam,
      loading: (state) => state.contact_forms.loading,
    }),
  },
  data() {
    return {
      quickSearch: null,
      showFullMessage: false,
    };
  },
  methods: {
    capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
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
    fetchContactForms(page_url) {
      this.$store.dispatch("contact_forms/fetchContactForms", {
        url: page_url,
      });
    },
    updateLimit(value) {
      this.$store.commit("contact_forms/setLimit", value);
      this.$store.dispatch("contact_forms/fetchContactForms");
    },
    quickSearchFilter: _.debounce(function () {
      this.$store.commit("contact_forms/setSearchParam", this.quickSearch);
      this.$store.dispatch("contact_forms/fetchContactForms");
    }, 500),
  },
  created() {
    this.$store.commit("contact_forms/setLimit", 100);
    this.$store.commit("contact_forms/setSortBy", "name");
    this.$store.commit("contact_forms/setSortType", "asc");
    this.$store.commit("contact_forms/setSearchParam", "");
    this.$store.dispatch("contact_forms/fetchContactForms");
  },
  watch: {
    quickSearch: function () {
      this.quickSearchFilter();
    },
  },
};
</script>
