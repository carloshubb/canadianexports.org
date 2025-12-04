<template>
  <div class="bg-white rounded-lg shadow-lg p-6 md:p-8">
    <div class="mb-6 flex items-center justify-between">
      <div>
        <h1 class="text-3xl font-bold text-primary mb-2">My Sponsorships</h1>
        <p class="text-gray-600">Manage all your sponsorship contributions</p>
      </div>
      <a
        :href="`/${becomeSponsorSlug}`"
        class="button-exp-fill"
      >
        + Add Another Sponsorship
      </a>
    </div>

    <!-- Loading State -->
    <div v-if="loading && !sponsorships.length" class="text-center py-12">
      <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-primary"></div>
      <p class="mt-4 text-gray-600">Loading your sponsorships...</p>
    </div>

    <!-- No Sponsorships -->
    <div v-else-if="!loading && !sponsorships.length" class="text-center py-12">
      <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
      </svg>
      <h3 class="mt-4 text-lg font-medium text-gray-900">No sponsorships yet</h3>
      <p class="mt-2 text-gray-500">Get started by creating your first sponsorship.</p>
      <div class="mt-6">
        <a
          :href="`/${becomeSponsorSlug}`"
          class="button-exp-fill"
        >
          Create Your First Sponsorship
        </a>
      </div>
    </div>

    <!-- Sponsorships List -->
    <div v-else class="space-y-4">
      <div
        v-for="sponsorship in sponsorships"
        :key="sponsorship.id"
        class="border rounded-lg p-6 hover:shadow-md transition-shadow"
      >
        <div class="flex items-start justify-between">
          <div class="flex-1">
            <div class="flex items-center gap-3 mb-2">
              <h3 class="text-xl font-semibold text-gray-900">
                {{ sponsorship.business_name }}
              </h3>
              <span
                class="px-3 py-1 rounded-full text-xs font-medium"
                :class="{
                  'bg-green-100 text-green-800': sponsorship.status === 'active',
                  'bg-yellow-100 text-yellow-800': sponsorship.status === 'pending',
                  'bg-gray-100 text-gray-800': sponsorship.status === 'inactive',
                }"
              >
                {{ sponsorship.status === 'active' ? 'Active' : sponsorship.status === 'pending' ? 'Pending' : 'Inactive' }}
              </span>
              <span
                v-if="sponsorship.payment_status"
                class="px-3 py-1 rounded-full text-xs font-medium"
                :class="{
                  'bg-green-100 text-green-800': sponsorship.payment_status === 'paid',
                  'bg-yellow-100 text-yellow-800': sponsorship.payment_status === 'pending',
                  'bg-blue-100 text-blue-800': sponsorship.payment_status === 'not_required',
                }"
              >
                {{ getPaymentStatusText(sponsorship.payment_status) }}
              </span>
            </div>

            <p class="text-gray-600 mb-3 line-clamp-2">
              {{ sponsorship.summary }}
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
              <div>
                <span class="text-gray-500">Amount:</span>
                <span class="ml-2 font-medium">${{ formatAmount(sponsorship.sponsorship_amount) }}</span>
              </div>
              <div v-if="sponsorship.beneficiary">
                <span class="text-gray-500">Beneficiary:</span>
                <span class="ml-2 font-medium">{{ sponsorship.beneficiary.name }}</span>
              </div>
              <div>
                <span class="text-gray-500">Created:</span>
                <span class="ml-2 font-medium">{{ formatDate(sponsorship.created_at) }}</span>
              </div>
            </div>
          </div>

          <div class="ml-4 flex flex-col gap-2">
            <a
              :href="`/${sponsorSettingsSlug}/${sponsorship.id}`"
              class="px-4 py-2 bg-primary text-white rounded hover:bg-opacity-90 text-center"
            >
              Edit
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Loading Overlay for Refresh -->
    <div v-if="loading && sponsorships.length" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6">
        <div class="flex items-center space-x-3">
          <svg class="animate-spin h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          <span class="text-lg font-medium">Loading...</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import helper from "../../helper";

export default {
  name: "SponsorshipsList",
  props: {
    becomeSponsorSlug: {
      type: String,
      default: 'user/sponsor-settings/add'
    },
    sponsorSettingsSlug: {
      type: String,
      default: 'user/sponsor-settings'
    },
    initialSponsorships: {
      type: Array,
      default: null
    }
  },
  data() {
    return {
      sponsorships: [],
      loading: false,
    };
  },
  mounted() {
    // Use initial data if provided, otherwise fetch
    if (this.initialSponsorships && this.initialSponsorships.length > 0) {
      this.sponsorships = this.initialSponsorships;
    } else {
      this.fetchSponsorships();
    }
  },
  methods: {
    async fetchSponsorships() {
      this.loading = true;
      try {
        const response = await axios.get(`${process.env.MIX_WEB_API_URL}sponsor/profile`);
        if (response.data.status === "Success") {
          this.sponsorships = response.data.data;
        } else {
          helper.swalErrorMessageForWeb("Unable to load sponsorships");
        }
      } catch (error) {
        console.error("Error fetching sponsorships:", error);
        if (error.response && error.response.status === 404) {
          // No sponsorships yet - this is OK
          this.sponsorships = [];
        } else {
          helper.swalErrorMessageForWeb("Error loading sponsorships. Please try again.");
        }
      } finally {
        this.loading = false;
      }
    },

    formatAmount(amount) {
      if (!amount) return '0.00';
      return parseFloat(amount).toFixed(2);
    },

    formatDate(date) {
      if (!date) return 'N/A';
      return new Date(date).toLocaleDateString("en-US", {
        year: "numeric",
        month: "short",
        day: "numeric",
      });
    },

    getPaymentStatusText(status) {
      const statusMap = {
        'paid': 'Paid',
        'pending': 'Payment Pending',
        'not_required': 'Contact Request',
        'failed': 'Failed',
        'refunded': 'Refunded'
      };
      return statusMap[status] || status;
    },

    getLanguage() {
      // Get current language from URL or default to 'en'
      const path = window.location.pathname;
      const langMatch = path.match(/^\/(en|da|ab)\//);
      return langMatch ? langMatch[1] : 'en';
    },
  },
};
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>

