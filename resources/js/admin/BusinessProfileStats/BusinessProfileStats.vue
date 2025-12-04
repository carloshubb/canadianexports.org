<template>
  <AppLayout>
    <div class="relative shadow-md sm:rounded-lg bg-white py-4">
      <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
          <div class="sm:flex-auto">
            <h1 class="can-exp-h3 mb-0 text-primary">Business profile stats</h1>
            <p class="mt-2 text-sm text-gray-700">
              Stats about the business profile views, form submission with
              detail information like IP address and location of visiting user.
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
              profiles
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
                id="table-search-stats"
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
                      Business profile
                    </th>
                    <th
                      scope="col"
                      class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell"
                    >
                      Action
                    </th>
                    <th
                      scope="col"
                      class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell"
                    >
                      Location
                    </th>
                    <th
                      scope="col"
                      class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell"
                    >
                      Browser Type
                    </th>
                    <th
                      scope="col"
                      class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell"
                    >
                      Visit Time
                    </th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                      <span class="sr-only">Edit</span>
                    </th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                  <tr
                    class="hover:shadow-lg"
                    v-for="stat in stats"
                    :key="stat.id"
                  >
                    <td
                      class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-1"
                    >
                      <router-link
                        :to="{
                          name: 'admin.business-profile-stats.show',
                          params: { id: stat.customer_profile_id },
                        }"
                      >
                        <span
                          class="inline-flex items-center gap-x-1.5 rounded-md bg-blue-100 px-1.5 py-0.5 text-xs font-medium text-blue-600"
                        >
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4"
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

                          {{
                            stat.customer_profile
                              ? stat.customer_profile.company_name
                              : "View Summary"
                          }}
                        </span>
                      </router-link>
                      <dl class="font-normal lg:hidden">
                        <dt class="sr-only">Action</dt>
                        <dd class="mt-1 truncate text-gray-500">
                          {{ capitalizeFirstLetter(stat.type) }}
                        </dd>
                        <dt class="sr-only">Location</dt>
                        <dd class="mt-1 truncate text-gray-500">
                          {{ stat.visitor ? stat.visitor.country : "" }},
                          {{ stat.visitor ? stat.visitor.state : "" }},
                          {{ stat.visitor ? stat.visitor.city : "" }}
                        </dd>
                        <dt class="sr-only">IP Address</dt>
                        <dd class="mt-1 truncate text-gray-500">
                          {{ stat.visitor ? stat.visitor.ip_address : "" }}
                        </dd>
                        <dt class="sr-only">Browser</dt>
                        <!-- <dd class="mt-1 truncate text-gray-500">
                          {{ stat.visitor ? stat.visitor.browser : "" }} -
                          {{ stat.visitor ? stat.visitor.browser_version : "" }}
                        </dd> -->
                        <dd class="mt-1 truncate text-gray-500">
                          {{
                            stat.visitor && (stat.visitor.browser || stat.visitor.browser_version)
                              ? `${stat.visitor.browser || ''} ${stat.visitor.browser_version || ''}`.trim()
                              : "Other Browser"
                          }}
                        </dd>
                        <dt class="sr-only">Operating System</dt>
                        <dd class="mt-1 truncate text-gray-500">
                          {{ stat.visitor && stat.visitor.platform ? stat.visitor.platform : "Unknown OS" }}
                        </dd>
                        <dt class="sr-only">Last Updated</dt>
                        <dd class="mt-1 truncate text-gray-700">
                          {{ formatDate(stat.created_at) }}
                        </dd>
                      </dl>
                    </td>
                    <td
                      class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell"
                    >
                      {{ capitalizeFirstLetter(stat.type) }}
                    </td>
                    <td
                      class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell"
                    >
                      <div class="text-gray-900">
                        {{ stat.visitor ? stat.visitor.country : "" }},
                        {{ stat.visitor ? stat.visitor.state : "" }},
                        {{ stat.visitor ? stat.visitor.city : "" }}
                      </div>
                      <div class="mt-1 text-gray-500">
                        {{ stat.visitor ? stat.visitor.ip_address : "" }}
                      </div>
                    </td>
                    <td
                      class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell"
                    >
                      <div class="text-gray-900">
                        {{
                          stat.visitor && (stat.visitor.browser || stat.visitor.browser_version)
                            ? `${stat.visitor.browser || ''} ${stat.visitor.browser_version || ''}`.trim()
                            : "Other Browser"
                        }}
                      </div>
                      <div class="mt-1 text-gray-500">
                        {{ stat.visitor && stat.visitor.platform ? stat.visitor.platform : "Unknown OS" }}
                      </div>
                    </td>
                    <td
                      class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell"
                    >
                      {{ formatDate(stat.created_at) }}
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
                      @click="
                        fetchBusinessProfileStats(pagination.prev_page_url)
                      "
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
                      @click.prevent="
                        fetchBusinessProfileStats(pagination.next_page_url)
                      "
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
      limit: (state) => state.stats.limit,
      form: (state) => state.stats.form,
      stats: (state) => state.stats.business_profile_stats,
      pagination: (state) => state.stats.pagination,
      searchParam: (state) => state.stats.searchParam,
      loading: (state) => state.stats.loading,
    }),
  },
  data() {
    return {
      quickSearch: null,
    };
  },
  methods: {
    capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
    formatDate(dateString) {
      return moment(dateString).format("MMMM D, YYYY");
    },
    fetchBusinessProfileStats(page_url) {
      this.$store.dispatch("stats/fetchBusinessProfileStats", {
        url: page_url,
      });
    },
    updateLimit(value) {
      this.$store.commit("stats/setLimit", value);
      this.$store.dispatch("stats/fetchBusinessProfileStats");
    },
    quickSearchFilter: _.debounce(function () {
      this.$store.commit("stats/setSearchParam", this.quickSearch);
      this.$store.dispatch("stats/fetchBusinessProfileStats");
    }, 500),
  },
  created() {
    this.$store.commit("stats/setLimit", 100);
    this.$store.commit("stats/setSortBy", "company_name");
    this.$store.commit("stats/setSortType", "asc");
    this.$store.commit("stats/setSearchParam", "");
    this.$store.dispatch("stats/fetchBusinessProfileStats");
  },
  watch: {
    quickSearch: function () {
      this.quickSearchFilter();
    },
  },
};
</script>
