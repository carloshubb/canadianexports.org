<template>
  <AppLayout>
    <div class="relative shadow-md sm:rounded-lg bg-white py-4">
      <header class="pt-4">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <div>
              <h3 class="can-exp-h3 text-primary">Webinar Registrations</h3>
              <p class="text-gray-600 mt-1">{{ webinar?.title }}</p>
            </div>
            <router-link :to="{ name: 'admin.webinars.index' }" class="button-exp-fill">
              Back to Webinars
            </router-link>
          </div>
        </div>
      </header>

      <!-- Webinar Info -->
      <div v-if="webinar" class="px-4 sm:px-6 lg:px-8 py-4 border-b bg-gray-50">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <div>
            <p class="text-sm text-gray-600">Scheduled</p>
            <p class="font-semibold">{{ formatDate(webinar.scheduled_at) }}</p>
          </div>
          <div>
            <p class="text-sm text-gray-600">Total Registrations</p>
            <p class="font-semibold text-2xl">{{ registrations.length }}</p>
          </div>
          <div>
            <p class="text-sm text-gray-600">Attended</p>
            <p class="font-semibold text-2xl text-green-600">
              {{registrations.filter(r => r.status === 'attended').length}}
            </p>
          </div>
          <div>
            <p class="text-sm text-gray-600">Available Seats</p>
            <p class="font-semibold text-2xl">
              {{webinar.max_attendees ? webinar.max_attendees - registrations.filter(r => r.status !==
                'cancelled').length : '∞' }}
            </p>
          </div>
        </div>
      </div>

      <!-- Export Button -->
      <div class="px-4 sm:px-6 lg:px-8 py-4 flex justify-end">
        <button @click="exportToXLS" class="button-exp-fill">
          Export to Excel
        </button>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3">Name</th>
              <th scope="col" class="px-6 py-3">Email</th>
              <th scope="col" class="px-6 py-3">Phone</th>
              <th scope="col" class="px-6 py-3">Company</th>
              <th scope="col" class="px-6 py-3">Registered At</th>
              <th scope="col" class="px-6 py-3">Status</th>
              <th scope="col" class="px-6 py-3">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="loading" class="bg-white border-b">
              <td colspan="7" class="px-6 py-4 text-center">Loading...</td>
            </tr>
            <tr v-else-if="!registrations.length" class="bg-white border-b">
              <td colspan="7" class="px-6 py-4 text-center">No registrations yet</td>
            </tr>
            <tr v-else v-for="reg in registrations" :key="reg.id" class="bg-white border-b hover:bg-gray-50">
              <td class="px-6 py-4 font-medium text-gray-900">{{ reg.name }}</td>
              <td class="px-6 py-4">{{ reg.email }}</td>
              <td class="px-6 py-4">{{ reg.phone || 'N/A' }}</td>
              <td class="px-6 py-4">{{ reg.company || 'N/A' }}</td>
              <td class="px-6 py-4">{{ formatDate(reg.registered_at) }}</td>
              <td class="px-6 py-4">
                <span :class="getStatusClass(reg.status)" class="px-2 py-1 rounded text-xs">
                  {{ reg.status }}
                </span>
              </td>
              <td class="px-6 py-4">
                <button v-if="reg.status === 'registered'" @click="markAsAttended(reg.id)"
                  class="text-green-600 hover:underline mr-3">
                  Mark Attended
                </button>
                <button v-if="reg.status !== 'cancelled'" @click="cancelRegistration(reg.id)"
                  class="text-red-600 hover:underline">
                  Cancel
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "../Layouts/App.vue";
import axios from "axios";

export default {
  name: 'AdminWebinarRegistrations',
  components: { AppLayout },
  data() {
    return {
      webinar: null,
      registrations: [],
      loading: false,
    };
  },
  methods: {
    async loadData() {
      this.loading = true;
      try {
        // Load webinar details
        const webinarResponse = await axios.get(
          `${process.env.MIX_ADMIN_API_URL}webinars/${this.$route.params.id}`
        );
        this.webinar = webinarResponse.data.success ? webinarResponse.data.data : webinarResponse.data.data || webinarResponse.data;

        // Load registrations
        const regResponse = await axios.get(
          `${process.env.MIX_ADMIN_API_URL}webinars/${this.$route.params.id}/registrations`
        );
        const regData = regResponse.data.success ? regResponse.data.data : regResponse.data;
        this.registrations = regData?.data || regData || [];
      } catch (error) {
        console.error('Failed to load data:', error);
        this.$swal('Error', 'Failed to load registrations', 'error');
      } finally {
        this.loading = false;
      }
    },
    async markAsAttended(registrationId) {
      try {
        const { data } = await axios.patch(
          `${process.env.MIX_ADMIN_API_URL}webinar-registrations/${registrationId}/attended`
        );
        this.loadData();
        this.$swal('Success', data.message || 'Marked as attended', 'success');
      } catch (error) {
        this.$swal('Error', error.response?.data?.message || 'Failed to update status', 'error');
      }
    },
    async cancelRegistration(registrationId) {
      if (!confirm('Are you sure you want to cancel this registration?')) return;

      try {
        const { data } = await axios.patch(
          `${process.env.MIX_ADMIN_API_URL}webinar-registrations/${registrationId}/cancel`
        );
        this.loadData();
        this.$swal('Success', data.message || 'Registration cancelled', 'success');
      } catch (error) {
        this.$swal('Error', error.response?.data?.message || 'Failed to cancel registration', 'error');
      }
    },
    exportToXLS() {
      const headers = ['Name', 'Email', 'Phone', 'Company', 'Registered At', 'Status'];
      const rows = this.registrations.map(reg => [
        reg.name,
        reg.email,
        reg.phone || '',
        reg.company || '',
        this.formatDate(reg.registered_at),
        reg.status,
      ]);

      let csvContent = headers.join(',') + '\n';
      rows.forEach(row => {
        csvContent += row.map(cell => `"${cell}"`).join(',') + '\n';
      });

      const blob = new Blob([csvContent], { type: 'text/xls;charset=utf-8;' });
      const link = document.createElement('a');
      const url = URL.createObjectURL(blob);

      link.setAttribute('href', url);
      link.setAttribute('download', `webinar-registrations-${this.$route.params.id}.xls`);
      link.style.visibility = 'hidden';

      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    },
    formatDate(dateString) {
      const date = new Date(dateString);
      return date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], {
        hour: '2-digit',
        minute: '2-digit',
      });
    },
    getStatusClass(status) {
      const classes = {
        registered: 'bg-blue-200 text-blue-800',
        attended: 'bg-green-200 text-green-800',
        cancelled: 'bg-red-200 text-red-800',
      };
      return classes[status] || '';
    },
  },
  mounted() {
    this.loadData();
  },
};
</script>