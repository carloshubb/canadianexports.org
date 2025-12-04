<template>
  <AppLayout>
    <div class="relative shadow-md sm:rounded-lg bg-white py-4">
      <header class="pt-4">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <h1 class="can-exp-h3 mb-0 text-primary">
              Billing Period Discounts
            </h1>
          </div>
          <p class="mt-2 text-sm text-gray-700">
            Manage discount percentages for different billing periods (Quarterly, Semi-Annual, Annual)
          </p>
        </div>
      </header>

      <form class="px-4 md:px-6 lg:px-8 mt-6" @submit.prevent="saveDiscounts">
        <div v-if="loading" class="text-center py-8">
          <p>Loading...</p>
        </div>

        <template v-else>
          <div
            v-for="discount in discounts"
            :key="discount.id"
            class="grid md:grid-cols-3 gap-4 md:gap-6 mb-6 pb-6 border-b border-gray-200 last:border-0"
          >
            <div class="relative z-0 w-full group">
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Billing Period
              </label>
              <p class="text-lg font-semibold text-gray-900 capitalize can-exp-input bg-gray-50 flex items-center">
                {{ formatPeriodType(discount.period_type) }}
                <span class="text-sm text-gray-500 font-normal ml-2"
                  >({{ discount.months }} months)</span
                >
              </p>
            </div>

            <div class="relative z-0 w-full group">
              <label
                :for="'discount_' + discount.id"
                class="block text-sm font-medium text-gray-700 mb-2"
              >
                Discount Percentage
              </label>
              <div class="relative">
                <input
                  type="number"
                  :id="'discount_' + discount.id"
                  v-model="discount.discount_percentage"
                  step="0.01"
                  min="0"
                  max="100"
                  class="can-exp-input w-full block border border-gray-300 rounded pr-12"
                  placeholder="0.00"
                />
                <div
                  class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none"
                >
                  <span class="text-gray-500 sm:text-sm">%</span>
                </div>
              </div>
              <p class="mt-1 text-xs text-gray-500">
                Current multiplier: {{ calculateMultiplier(discount.discount_percentage) }}
              </p>
            </div>

            <div class="relative z-0 w-full group">
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Preview
              </label>
              <div class="bg-blue-50 p-4 rounded border border-blue-200">
                <p class="text-sm text-gray-700">
                  Display text on signup page:
                </p>
                <p class="text-lg font-semibold text-blue-900 mt-1">
                  (Save {{ parseInt(discount.discount_percentage) || 0 }}%)
                </p>
              </div>
            </div>
          </div>

          <div class="flex justify-end pt-4">
            <button
              type="submit"
              class="button-exp-fill"
              :disabled="saving"
            >
              {{ saving ? 'Saving...' : 'Save Changes' }}
            </button>
          </div>

          <div
            v-if="successMessage"
            class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded mt-4"
          >
            {{ successMessage }}
          </div>

          <div
            v-if="errorMessage"
            class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded mt-4"
          >
            {{ errorMessage }}
          </div>
        </template>
      </form>
    </div>
  </AppLayout>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      discounts: [],
      loading: false,
      saving: false,
      successMessage: "",
      errorMessage: "",
    };
  },
  methods: {
    formatPeriodType(type) {
      const typeMap = {
        quarterly: "Quarterly",
        semi_annually: "Semi-Annual",
        annually: "Annual",
      };
      return typeMap[type] || type;
    },
    calculateMultiplier(percentage) {
      return (1 - percentage / 100).toFixed(4);
    },
    async fetchDiscounts() {
      this.loading = true;
      try {
        const response = await axios.get(
          `${process.env.MIX_ADMIN_API_URL}billing-period-discounts`
        );
        this.discounts = response.data.data;
      } catch (error) {
        console.error("Error fetching discounts:", error);
        this.errorMessage = "Failed to load discounts. Please try again.";
      } finally {
        this.loading = false;
      }
    },
    async saveDiscounts() {
      this.saving = true;
      this.successMessage = "";
      this.errorMessage = "";

      try {
        const response = await axios.post(
          `${process.env.MIX_ADMIN_API_URL}billing-period-discounts/batch-update`,
          {
            discounts: this.discounts.map((d) => ({
              id: d.id,
              discount_percentage: parseFloat(d.discount_percentage),
            })),
          }
        );

        this.successMessage = "Discounts updated successfully!";
        this.discounts = response.data.data;

        setTimeout(() => {
          this.successMessage = "";
        }, 5000);
      } catch (error) {
        console.error("Error saving discounts:", error);
        this.errorMessage =
          error.response?.data?.message ||
          "Failed to save discounts. Please try again.";
      } finally {
        this.saving = false;
      }
    },
  },
  mounted() {
    this.fetchDiscounts();
  },
};
</script>
