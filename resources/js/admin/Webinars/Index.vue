<template>
  <AppLayout>
    <div class="relative shadow-md sm:rounded-lg bg-white">
      <header class="pt-4">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <h3 class="can-exp-h3 text-primary">Webinars</h3>
            <router-link :to="{ name: 'admin.webinars.create'}" class="button-exp-fill">
              Create Webinar
            </router-link>
          </div>
        </div>
      </header>

      <!-- Filters -->
      <div class="px-4 sm:px-6 lg:px-8 py-4 border-b">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <input
            v-model="filters.search"
            @input="debouncedSearch"
            type="text"
            placeholder="Search webinars..."
            class="can-exp-input border border-gray-300 rounded"
          />
          <select v-model="filters.status" @change="loadWebinars" class="can-exp-input border border-gray-300 rounded">
            <option value="">All Status</option>
            <option value="draft">Draft</option>
            <option value="published">Published</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
          </select>
          <input
            v-model="filters.date_from"
            @change="loadWebinars"
            type="date"
            placeholder="From Date"
            class="can-exp-input border border-gray-300 rounded"
          />
          <input
            v-model="filters.date_to"
            @change="loadWebinars"
            type="date"
            placeholder="To Date"
            class="can-exp-input border border-gray-300 rounded"
          />
        </div>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3">Title</th>
              <th scope="col" class="px-6 py-3">Presenter</th>
              <th scope="col" class="px-6 py-3">Scheduled</th>
              <th scope="col" class="px-6 py-3">Duration</th>
              <th scope="col" class="px-6 py-3">Registrations</th>
              <th scope="col" class="px-6 py-3">Status</th>
              <th scope="col" class="px-6 py-3">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="loading" class="bg-white border-b">
              <td colspan="7" class="px-6 py-4 text-center">Loading...</td>
            </tr>
            <tr v-else-if="!webinars.length" class="bg-white border-b">
              <td colspan="7" class="px-6 py-4 text-center">No webinars found</td>
            </tr>
            <tr v-else v-for="webinar in webinars" :key="webinar.id" class="bg-white border-b hover:bg-gray-50">
              <td class="px-6 py-4 font-medium text-gray-900">
                {{ webinar.title }}
              </td>
              <td class="px-6 py-4">{{ webinar.presenter_name || 'N/A' }}</td>
              <td class="px-6 py-4">{{ formatDate(webinar.scheduled_at) }}</td>
              <td class="px-6 py-4">{{ webinar.duration_minutes }} min</td>
              <td class="px-6 py-4">
                <router-link 
                  :to="{ name: 'admin.webinars.registrations', params: { id: webinar.id }}"
                  class="text-blue-600 hover:underline"
                >
                  {{ webinar.registrations_count }}
                  <span v-if="webinar.max_attendees"> / {{ webinar.max_attendees }}</span>
                </router-link>
              </td>
              <td class="px-6 py-4">
                <span :class="getStatusClass(webinar.status)" class="px-2 py-1 rounded text-xs">
                  {{ webinar.status }}
                </span>
              </td>
              <td class="px-6 py-4">
                <div class="flex gap-2">
                  <router-link 
                    :to="{ name: 'admin.webinars.edit', params: { id: webinar.id }}"
                    class="text-blue-600 hover:underline"
                  >
                    Edit
                  </router-link>
                  <button @click="deleteWebinar(webinar.id)" class="text-red-600 hover:underline">
                    Delete
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div v-if="pagination.last_page > 1" class="px-6 py-4 flex justify-between items-center">
        <div class="text-sm text-gray-700">
          Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }} results
        </div>
        <div class="flex gap-2">
          <button
            @click="changePage(pagination.current_page - 1)"
            :disabled="pagination.current_page === 1"
            class="px-3 py-1 border rounded disabled:opacity-50"
          >
            Previous
          </button>
          <button
            @click="changePage(pagination.current_page + 1)"
            :disabled="pagination.current_page === pagination.last_page"
            class="px-3 py-1 border rounded disabled:opacity-50"
          >
            Next
          </button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "../Layouts/App.vue";
import axios from "axios";

export default {
  name: 'AdminWebinarsIndex',
  components: { AppLayout },
  data() {
    return {
      webinars: [],
      loading: false,
      filters: {
        search: '',
        status: '',
        date_from: '',
        date_to: '',
      },
      pagination: {
        current_page: 1,
        last_page: 1,
        per_page: 15,
        total: 0,
        from: 0,
        to: 0,
      },
      debounceTimer: null,
    };
  },
  methods: {
    async loadWebinars(page = 1) {
      this.loading = true;
      try {
        const params = {
          page,
          per_page: this.pagination.per_page,
          ...this.filters,
        };
        
        const { data } = await axios.get(`${process.env.MIX_ADMIN_API_URL}webinars`, { params });
        
        if (data.success && data.data) {
          this.webinars = data.data.data || [];
          this.pagination = {
            current_page: data.data.current_page || 1,
            last_page: data.data.last_page || 1,
            per_page: data.data.per_page || 15,
            total: data.data.total || 0,
            from: data.data.from || 0,
            to: data.data.to || 0,
          };
        } else {
          this.webinars = [];
        }
      } catch (error) {
        console.error('Failed to load webinars:', error);
        this.$swal('Error', error.response?.data?.message || 'Failed to load webinars', 'error');
        this.webinars = [];
      } finally {
        this.loading = false;
      }
    },
    debouncedSearch() {
      clearTimeout(this.debounceTimer);
      this.debounceTimer = setTimeout(() => {
        this.loadWebinars();
      }, 500);
    },
    changePage(page) {
      if (page >= 1 && page <= this.pagination.last_page) {
        this.loadWebinars(page);
      }
    },
    async deleteWebinar(id) {
      if (!confirm('Are you sure you want to delete this webinar?')) return;
      
      try {
        const { data } = await axios.delete(`${process.env.MIX_ADMIN_API_URL}webinars/${id}`);
        if (data.success) {
          this.loadWebinars(this.pagination.current_page);
          this.$swal('Success', data.message || 'Webinar deleted successfully', 'success');
        } else {
          this.$swal('Error', data.message || 'Failed to delete webinar', 'error');
        }
      } catch (error) {
        this.$swal('Error', error.response?.data?.message || 'Failed to delete webinar', 'error');
      }
    },
    formatDate(dateString) {
      const date = new Date(dateString);
      return date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    },
    getStatusClass(status) {
      const classes = {
        draft: 'bg-gray-200 text-gray-800',
        published: 'bg-green-200 text-green-800',
        completed: 'bg-blue-200 text-blue-800',
        cancelled: 'bg-red-200 text-red-800',
      };
      return classes[status] || '';
    },
  },
  mounted() {
    this.loadWebinars();
  },
};
</script>