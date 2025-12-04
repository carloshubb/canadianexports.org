<template>
  <AppLayout>
    <div class="relative shadow-md sm:rounded-lg bg-white py-4">
      <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
          <div class="sm:flex-auto">
            <h1 class="can-exp-h3 mb-0 text-primary">Sponsors</h1>
            <p class="mt-2 text-sm text-gray-700">Manage all sponsor registrations and payments</p>
          </div>
        </div>

        <!-- Filters -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
          <!-- Search -->
          <div>
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input
              type="text"
              id="search"
              v-model="filters.searchParam"
              @input="debouncedSearch"
              placeholder="Search by name, email..."
              class="can-exp-input"
            />
          </div>

          <!-- Status Filter -->
          <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select id="status" v-model="filters.status" @change="fetchSponsors" class="can-exp-input">
              <option value="">All Statuses</option>
              <option value="active">Active</option>
              <option value="pending">Pending</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>

          <!-- Payment Status Filter -->
          <div>
            <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-1">Payment Status</label>
            <select id="payment_status" v-model="filters.payment_status" @change="fetchSponsors" class="can-exp-input">
              <option value="">All Payments</option>
              <option value="paid">Paid</option>
              <option value="pending">Pending</option>
              <option value="not_required">Talk to Us</option>
            </select>
          </div>

          <!-- Sponsorship Type Filter -->
          <div>
            <label for="sponsorship_type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
            <select id="sponsorship_type" v-model="filters.sponsorship_type" @change="fetchSponsors" class="can-exp-input">
              <option value="">All Types</option>
              <option value="paid">Paid Sponsors</option>
              <option value="talk_to_us">Talk to Us</option>
            </select>
          </div>
        </div>

        <!-- Table -->
        <div class="mt-8 flow-root">
          <div class="flex items-center justify-between mb-4">
            <div>
              Show
              <select
                class="rounded-md px-3 pr-8 py-1 border border-gray-300"
                @change="updateLimit($event.target.value)"
              >
                <option value="15" :selected="filters.limit == 15">15</option>
                <option value="25" :selected="filters.limit == 25">25</option>
                <option value="50" :selected="filters.limit == 50">50</option>
                <option value="100" :selected="filters.limit == 100">100</option>
              </select>
              entries
            </div>
            <button
              @click="clearFilters"
              class="text-sm text-primary hover:text-primary/80"
            >
              Clear Filters
            </button>
          </div>

          <div class="-mx-4 mt-4 sm:-mx-0">
            <div class="overflow-x-auto shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
              <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gradient-to-l from-blue-500 to-blue-400">
                  <tr>
                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-white">Company</th>
                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-white">Contact</th>
                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-white">Amount</th>
                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-white">Payment</th>
                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-white">Status</th>
                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-white">Date</th>
                    <th class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                      <span class="sr-only">Actions</span>
                    </th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                  <tr
                    v-for="sponsor in sponsors"
                    :key="sponsor.id"
                    class="hover:bg-gray-50"
                  >
                    <td class="px-3 py-4 text-sm">
                      <div class="flex items-center">
                        <div v-if="sponsor.logo_media" class="h-10 w-10 flex-shrink-0">
                          <img
                            class="h-10 w-10 rounded-full object-cover"
                            :src="`/${sponsor.logo_media.path}`"
                            :alt="sponsor.business_name"
                          />
                        </div>
                        <div class="ml-3">
                          <div class="font-medium text-gray-900">{{ sponsor.business_name }}</div>
                          <div class="text-gray-500 text-xs">{{ sponsor.email }}</div>
                        </div>
                      </div>
                    </td>
                    <td class="px-3 py-4 text-sm text-gray-900">
                      <div>{{ sponsor.contact_name }}</div>
                      <div class="text-gray-500 text-xs">{{ sponsor.contact_number }}</div>
                    </td>
                    <td class="px-3 py-4 text-sm">
                      <span v-if="sponsor.sponsorship_amount" class="font-medium text-green-600">
                        ${{ parseFloat(sponsor.sponsorship_amount).toFixed(2) }}
                      </span>
                      <span v-else class="text-gray-400">-</span>
                    </td>
                    <td class="px-3 py-4 text-sm">
                      <span
                        class="inline-flex rounded-full px-2 py-1 text-xs font-semibold"
                        :class="{
                          'bg-green-100 text-green-800': sponsor.payment_status === 'paid',
                          'bg-yellow-100 text-yellow-800': sponsor.payment_status === 'pending',
                          'bg-blue-100 text-blue-800': sponsor.payment_status === 'not_required',
                          'bg-red-100 text-red-800': sponsor.payment_status === 'failed',
                        }"
                      >
                        {{ formatPaymentStatus(sponsor.payment_status) }}
                      </span>
                    </td>
                    <td class="px-3 py-4 text-sm">
                      <span
                        class="inline-flex rounded-full px-2 py-1 text-xs font-semibold"
                        :class="{
                          'bg-green-100 text-green-800': sponsor.status === 'active',
                          'bg-yellow-100 text-yellow-800': sponsor.status === 'pending',
                          'bg-gray-100 text-gray-800': sponsor.status === 'inactive',
                        }"
                      >
                        {{ sponsor.status.toUpperCase() }}
                      </span>
                    </td>
                    <td class="px-3 py-4 text-sm text-gray-500">
                      {{ formatDate(sponsor.created_at) }}
                    </td>
                    <td class="relative py-4 pl-3 pr-4 text-right text-sm font-medium flex gap-2 justify-end">
                      <router-link
                        :to="{ name: 'admin.sponsors.view', params: { id: sponsor.id } }"
                        class="text-blue-600 hover:text-blue-900"
                        data-tooltip="View Details"
                      >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                      </router-link>
                      <button
                        @click="confirmDelete(sponsor)"
                        class="text-red-600 hover:text-red-900"
                        data-tooltip="Delete"
                      >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                      </button>
                    </td>
                  </tr>
                  <tr v-if="sponsors.length === 0">
                    <td colspan="7" class="px-3 py-8 text-center text-sm text-gray-500">
                      No sponsors found
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Pagination -->
            <div
              v-if="pagination && pagination.last_page > 1"
              class="px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 bg-white mt-4"
            >
              <div class="flex justify-between items-center w-full">
                <div>
                  <p class="text-sm text-gray-700">
                    Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }} entries
                  </p>
                </div>
                <div>
                  <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                    <button
                      @click="changePage(pagination.current_page - 1)"
                      :disabled="!pagination.prev_page_url"
                      class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                      Previous
                    </button>
                    <button
                      @click="changePage(pagination.current_page + 1)"
                      :disabled="!pagination.next_page_url"
                      class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                      Next
                    </button>
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
import AppLayout from "../Layouts/App.vue";
import axios from "axios";
import _ from "lodash";
import Swal from "sweetalert2";

export default {
  name: "SponsorsIndex",
  components: {
    AppLayout,
  },
  data() {
    return {
      sponsors: [],
      pagination: null,
      filters: {
        searchParam: "",
        status: "",
        payment_status: "",
        sponsorship_type: "",
        limit: 15,
        page: 1,
      },
      loading: false,
    };
  },
  mounted() {
    this.fetchSponsors();
  },
  methods: {
    async fetchSponsors() {
      this.loading = true;
      try {
        const params = { ...this.filters, withMedia: 1 };
        const response = await axios.get(`${process.env.MIX_ADMIN_API_URL}sponsors`, { params });

        if (response.data.status === "Success") {
          this.sponsors = response.data.data.data || response.data.data;
          if (response.data.data.meta) {
            this.pagination = {
              current_page: response.data.data.meta.current_page,
              last_page: response.data.data.meta.last_page,
              from: response.data.data.meta.from,
              to: response.data.data.meta.to,
              total: response.data.data.meta.total,
              prev_page_url: response.data.data.links.prev,
              next_page_url: response.data.data.links.next,
            };
          }
        }
      } catch (error) {
        console.error("Error fetching sponsors:", error);
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Failed to load sponsors",
        });
      } finally {
        this.loading = false;
      }
    },

    debouncedSearch: _.debounce(function () {
      this.filters.page = 1;
      this.fetchSponsors();
    }, 500),

    updateLimit(value) {
      this.filters.limit = value;
      this.filters.page = 1;
      this.fetchSponsors();
    },

    changePage(page) {
      this.filters.page = page;
      this.fetchSponsors();
    },

    clearFilters() {
      this.filters = {
        searchParam: "",
        status: "",
        payment_status: "",
        sponsorship_type: "",
        limit: 15,
        page: 1,
      };
      this.fetchSponsors();
    },

    confirmDelete(sponsor) {
      Swal.fire({
        title: "Are you sure?",
        text: `Delete sponsor "${sponsor.business_name}"?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          this.deleteSponsor(sponsor.id);
        }
      });
    },

    async deleteSponsor(id) {
      try {
        const response = await axios.delete(`${process.env.MIX_ADMIN_API_URL}sponsors/${id}`);
        if (response.data.status === "Success") {
          Swal.fire("Deleted!", "Sponsor has been deleted.", "success");
          this.fetchSponsors();
        }
      } catch (error) {
        console.error("Error deleting sponsor:", error);
        Swal.fire("Error!", "Failed to delete sponsor.", "error");
      }
    },

    formatPaymentStatus(status) {
      const statusMap = {
        paid: "Paid",
        pending: "Pending",
        not_required: "Talk to Us",
        failed: "Failed",
      };
      return statusMap[status] || status;
    },

    formatDate(date) {
      return new Date(date).toLocaleDateString("en-US", {
        year: "numeric",
        month: "short",
        day: "numeric",
      });
    },
  },
};
</script>

<style scoped>
/* Custom styles if needed */
</style>

