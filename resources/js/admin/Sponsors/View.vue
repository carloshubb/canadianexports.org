<template>
  <AppLayout>
    <div class="relative shadow-md sm:rounded-lg bg-white py-4">
      <div class="px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
          <div>
            <h1 class="can-exp-h3 mb-0 text-primary">Sponsor Details</h1>
            <p class="mt-1 text-sm text-gray-500">View sponsor information and manage status</p>
          </div>
          <router-link
            :to="{ name: 'admin.sponsors.index' }"
            class="button-exp-fill"
          >
            ← Back to List
          </router-link>
        </div>

        <div v-if="loading" class="flex justify-center items-center py-12">
          <svg class="animate-spin h-12 w-12 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
        </div>

        <div v-else-if="sponsor">
          <!-- Status Cards -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <!-- Sponsorship Amount -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-lg p-4">
              <div class="text-sm text-green-600 font-medium mb-1">Sponsorship Amount</div>
              <div class="text-3xl font-bold text-green-700">
                {{ sponsor.sponsorship_amount ? `$${parseFloat(sponsor.sponsorship_amount).toFixed(2)}` : 'N/A' }}
              </div>
              <div v-if="sponsor.paid_at" class="text-xs text-green-600 mt-1">
                Paid on {{ formatDate(sponsor.paid_at) }}
              </div>
            </div>

            <!-- Payment Status -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-lg p-4">
              <div class="text-sm text-blue-600 font-medium mb-1">Payment Status</div>
              <div class="text-2xl font-bold text-blue-700">
                {{ formatPaymentStatus(sponsor.payment_status) }}
              </div>
              <div v-if="sponsor.payment_method" class="text-xs text-blue-600 mt-1">
                via {{ sponsor.payment_method.toUpperCase() }}
              </div>
            </div>

            <!-- Sponsor Status -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-lg p-4">
              <div class="text-sm text-purple-600 font-medium mb-1">Status</div>
              <div class="text-2xl font-bold text-purple-700">
                {{ sponsor.status.toUpperCase() }}
              </div>
              <div class="text-xs text-purple-600 mt-1">
                {{ sponsor.is_visible ? '👁️ Visible on site' : '🔒 Hidden from site' }}
              </div>
            </div>
          </div>

          <!-- Company Information -->
          <div class="bg-white border border-gray-200 rounded-lg mb-6">
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
              <h3 class="text-lg font-semibold text-gray-800">Company Information</h3>
            </div>
            <div class="p-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="text-sm font-medium text-gray-500">Company Name</label>
                  <p class="mt-1 text-base text-gray-900">{{ sponsor.business_name }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-500">Contact Person</label>
                  <p class="mt-1 text-base text-gray-900">{{ sponsor.contact_name }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-500">Email</label>
                  <p class="mt-1 text-base text-gray-900">{{ sponsor.email }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-500">Contact Number</label>
                  <p class="mt-1 text-base text-gray-900">{{ sponsor.contact_number }}</p>
                </div>
                <div class="md:col-span-2">
                  <label class="text-sm font-medium text-gray-500">Company Website</label>
                  <p class="mt-1 text-base text-gray-900">
                    <a v-if="sponsor.url" :href="sponsor.url" target="_blank" class="text-primary hover:underline">
                      {{ sponsor.url }}
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                      </svg>
                    </a>
                    <span v-else class="text-gray-400">Not provided</span>
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Descriptions -->
          <div class="bg-white border border-gray-200 rounded-lg mb-6">
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
              <h3 class="text-lg font-semibold text-gray-800">Descriptions</h3>
            </div>
            <div class="p-6 space-y-4">
              <div>
                <label class="text-sm font-medium text-gray-500">Brief Description</label>
                <p class="mt-1 text-base text-gray-900 whitespace-pre-wrap">{{ sponsor.summary || 'N/A' }}</p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-500">Detailed Description</label>
                <p class="mt-1 text-base text-gray-900 whitespace-pre-wrap">{{ sponsor.detail_description || 'N/A' }}</p>
              </div>
              <div v-if="sponsor.message">
                <label class="text-sm font-medium text-gray-500">Additional Message</label>
                <p class="mt-1 text-base text-gray-900 whitespace-pre-wrap">{{ sponsor.message }}</p>
              </div>
            </div>
          </div>

          <!-- Media -->
          <div class="bg-white border border-gray-200 rounded-lg mb-6">
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
              <h3 class="text-lg font-semibold text-gray-800">Media Files</h3>
            </div>
            <div class="p-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="text-sm font-medium text-gray-500 mb-2 block">Company Logo</label>
                  <div v-if="sponsor.logo_media" class="border rounded-lg p-4 bg-gray-50">
                    <img
                      :src="`/${sponsor.logo_media.path}`"
                      :alt="sponsor.business_name"
                      class="max-h-48 mx-auto object-contain"
                    />
                  </div>
                  <p v-else class="text-gray-400 italic">No logo uploaded</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-500 mb-2 block">Featured Image</label>
                  <div v-if="sponsor.featured_media" class="border rounded-lg p-4 bg-gray-50">
                    <img
                      :src="`/${sponsor.featured_media.path}`"
                      :alt="sponsor.business_name"
                      class="max-h-48 mx-auto object-cover"
                    />
                  </div>
                  <p v-else class="text-gray-400 italic">No featured image uploaded</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Payment Details (if paid) -->
          <div v-if="sponsor.payment_status === 'paid'" class="bg-white border border-gray-200 rounded-lg mb-6">
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
              <h3 class="text-lg font-semibold text-gray-800">Payment Details</h3>
            </div>
            <div class="p-6">
              <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                  <label class="text-sm font-medium text-gray-500">Payment Method</label>
                  <p class="mt-1 text-base text-gray-900">{{ sponsor.payment_method ? sponsor.payment_method.toUpperCase() : 'N/A' }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-500">Transaction ID</label>
                  <p class="mt-1 text-base text-gray-900 font-mono text-sm">{{ sponsor.transaction_id || 'N/A' }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-500">Payment Date</label>
                  <p class="mt-1 text-base text-gray-900">{{ formatDateTime(sponsor.paid_at) }}</p>
                </div>
                <div v-if="sponsor.beneficiary">
                  <label class="text-sm font-medium text-gray-500">Beneficiary</label>
                  <p class="mt-1 text-base text-gray-900">{{ sponsor.beneficiary.name }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Talk to Us Details (if applicable) -->
          <div v-if="sponsor.talk_to_us_first" class="bg-yellow-50 border border-yellow-200 rounded-lg mb-6">
            <div class="px-4 py-3 bg-yellow-100 border-b border-yellow-200">
              <h3 class="text-lg font-semibold text-gray-800">📞 Contact Request Details</h3>
            </div>
            <div class="p-6">
              <div class="bg-white rounded p-4 mb-4">
                <p class="text-yellow-800 font-medium mb-2">⚠️ This sponsor requested to talk before committing</p>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="text-sm font-medium text-gray-500">Contact Name</label>
                  <p class="mt-1 text-base text-gray-900">{{ sponsor.talk_to_us_name || sponsor.contact_name }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-500">Contact Phone</label>
                  <p class="mt-1 text-base text-gray-900">{{ sponsor.talk_to_us_phone || sponsor.contact_number }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-500">Preferred Call Time</label>
                  <p class="mt-1 text-base text-gray-900">{{ sponsor.preferred_call_time ? sponsor.preferred_call_time.toUpperCase() : 'N/A' }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-500">Preferred Date</label>
                  <p class="mt-1 text-base text-gray-900">{{ sponsor.preferred_call_date ? formatDate(sponsor.preferred_call_date) : 'Not specified' }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Admin Actions -->
          <div class="bg-white border border-gray-200 rounded-lg mb-6">
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
              <h3 class="text-lg font-semibold text-gray-800">Status Management</h3>
            </div>
            <div class="p-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Status Toggle -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Sponsor Status</label>
                  <select
                    v-model="editForm.status"
                    @change="updateStatus"
                    class="can-exp-input"
                  >
                    <option value="active">Active</option>
                    <option value="pending">Pending</option>
                    <option value="inactive">Inactive</option>
                  </select>
                  <p class="mt-1 text-xs text-gray-500">
                    Only active sponsors can be shown on the website
                  </p>
                </div>

                <!-- Visibility Toggle -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Visibility</label>
                  <div class="flex items-center space-x-3">
                    <button
                      @click="toggleVisibility"
                      class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors"
                      :class="editForm.is_visible ? 'bg-primary' : 'bg-gray-200'"
                    >
                      <span
                        class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"
                        :class="editForm.is_visible ? 'translate-x-6' : 'translate-x-1'"
                      ></span>
                    </button>
                    <span class="text-sm text-gray-900">
                      {{ editForm.is_visible ? 'Visible on website' : 'Hidden from website' }}
                    </span>
                  </div>
                  <p class="mt-1 text-xs text-gray-500">
                    Toggle sponsor visibility on the public website
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- System Information -->
          <div class="bg-white border border-gray-200 rounded-lg">
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
              <h3 class="text-lg font-semibold text-gray-800">System Information</h3>
            </div>
            <div class="p-6">
              <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                  <label class="text-xs font-medium text-gray-500">Sponsor ID</label>
                  <p class="mt-1 text-gray-900">#{{ sponsor.id }}</p>
                </div>
                <div>
                  <label class="text-xs font-medium text-gray-500">Slug</label>
                  <p class="mt-1 text-gray-900 font-mono">{{ sponsor.slug }}</p>
                </div>
                <div>
                  <label class="text-xs font-medium text-gray-500">Sponsorship Type</label>
                  <p class="mt-1 text-gray-900">{{ sponsor.sponsorship_type === 'paid' ? 'Paid' : 'Talk to Us First' }}</p>
                </div>
                <div>
                  <label class="text-xs font-medium text-gray-500">Created Date</label>
                  <p class="mt-1 text-gray-900">{{ formatDateTime(sponsor.created_at) }}</p>
                </div>
                <div>
                  <label class="text-xs font-medium text-gray-500">Last Updated</label>
                  <p class="mt-1 text-gray-900">{{ formatDateTime(sponsor.updated_at) }}</p>
                </div>
                <div v-if="sponsor.customer">
                  <label class="text-xs font-medium text-gray-500">Customer Account</label>
                  <p class="mt-1 text-gray-900">{{ sponsor.customer.email }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div v-else class="text-center py-12">
          <p class="text-gray-500">Sponsor not found</p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "../Layouts/App.vue";
import axios from "axios";
import Swal from "sweetalert2";

export default {
  name: "SponsorView",
  components: {
    AppLayout,
  },
  data() {
    return {
      sponsor: null,
      editForm: {
        status: "",
        is_visible: false,
      },
      loading: false,
    };
  },
  mounted() {
    this.fetchSponsor();
  },
  methods: {
    async fetchSponsor() {
      this.loading = true;
      try {
        const response = await axios.get(
          `${process.env.MIX_ADMIN_API_URL}sponsors/${this.$route.params.id}?withMedia=1&withBeneficiary=1&withCustomer=1`
        );

        if (response.data.status === "Success") {
          this.sponsor = response.data.data;
          this.editForm.status = this.sponsor.status;
          this.editForm.is_visible = this.sponsor.is_visible;
        }
      } catch (error) {
        console.error("Error fetching sponsor:", error);
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Failed to load sponsor details",
        });
        this.$router.push({ name: "admin.sponsors.index" });
      } finally {
        this.loading = false;
      }
    },

    async updateStatus() {
      try {
        const response = await axios.put(
          `${process.env.MIX_ADMIN_API_URL}sponsors/${this.sponsor.id}`,
          { status: this.editForm.status }
        );

        if (response.data.status === "Success") {
          this.sponsor.status = this.editForm.status;
          Swal.fire({
            icon: "success",
            title: "Updated",
            text: "Status updated successfully",
            timer: 2000,
            showConfirmButton: false,
          });
        }
      } catch (error) {
        console.error("Error updating status:", error);
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Failed to update status",
        });
        this.editForm.status = this.sponsor.status; // Revert
      }
    },

    async toggleVisibility() {
      const newVisibility = !this.editForm.is_visible;
      
      try {
        const response = await axios.put(
          `${process.env.MIX_ADMIN_API_URL}sponsors/${this.sponsor.id}`,
          { is_visible: newVisibility }
        );

        if (response.data.status === "Success") {
          this.editForm.is_visible = newVisibility;
          this.sponsor.is_visible = newVisibility;
          Swal.fire({
            icon: "success",
            title: "Updated",
            text: `Sponsor is now ${newVisibility ? 'visible' : 'hidden'} on the website`,
            timer: 2000,
            showConfirmButton: false,
          });
        }
      } catch (error) {
        console.error("Error toggling visibility:", error);
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Failed to update visibility",
        });
      }
    },

    formatPaymentStatus(status) {
      const statusMap = {
        paid: "✓ Paid",
        pending: "⏳ Pending Payment",
        not_required: "📞 Talk to Us First",
        failed: "✗ Failed",
      };
      return statusMap[status] || status;
    },

    formatDate(date) {
      if (!date) return "N/A";
      return new Date(date).toLocaleDateString("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric",
      });
    },

    formatDateTime(date) {
      if (!date) return "N/A";
      return new Date(date).toLocaleDateString("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
      });
    },
  },
};
</script>

<style scoped>
/* Custom styles if needed */
</style>

