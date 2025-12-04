<template>
  <AppLayout>
    <div class="px-4 sm:px-6 lg:px-8 py-6">
      <!-- Header Section -->
      <div class="mb-8">
        <div class="flex justify-between items-start">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">Sponsor Amounts</h1>
            <p class="mt-2 text-sm text-gray-600 max-w-2xl">
              Manage sponsorship amount options organized by payment frequency. Each frequency can have multiple amounts and one default selection.
            </p>
          </div>
          <button
            @click="openCreateModal"
            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors"
          >
            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Add New Amount
          </button>
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex justify-center items-center py-12">
        <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-primary"></div>
      </div>

      <!-- Content Section -->
      <div v-else class="space-y-6">
        <!-- Frequency Tabs -->
        <div class="border-b border-gray-200">
          <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button
              v-for="(label, key) in frequencies"
              :key="key"
              @click="activeTab = key"
              :class="[
                activeTab === key
                  ? 'border-primary text-primary'
                  : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors'
              ]"
            >
              {{ label }}
              <span
                :class="[
                  activeTab === key
                    ? 'bg-primary text-white'
                    : 'bg-gray-100 text-gray-900',
                  'ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium'
                ]"
              >
                {{ getAmountCountByFrequency(key) }}
              </span>
            </button>
          </nav>
        </div>

        <!-- Amounts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
          <!-- Amount Cards -->
          <div
            v-for="amount in getAmountsByFrequency(activeTab)"
            :key="amount.id"
            class="relative group bg-white rounded-lg border-2 border-gray-200 hover:border-primary transition-all duration-200 shadow-sm hover:shadow-md"
          >
            <!-- Default Badge -->
            <div
              v-if="amount.is_default"
              class="absolute -top-3 left-4 bg-gradient-to-r from-yellow-400 to-yellow-500 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-md flex items-center"
            >
              <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
              </svg>
              Default
            </div>

            <div class="p-6">
              <!-- Amount Display -->
              <div class="flex items-baseline mb-4">
                <span class="text-4xl font-bold text-gray-900">${{ formatAmount(amount.amount) }}</span>
                <span class="ml-2 text-sm text-gray-500">{{ getFrequencyLabel(amount.frequency) }}</span>
              </div>

              <!-- Details -->
              <div class="space-y-2 mb-4">
                <div class="flex items-center text-sm text-gray-600">
                  <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                  </svg>
                  Sort Order: <span class="ml-1 font-medium text-gray-900">{{ amount.sort_order }}</span>
                </div>
                <div class="flex items-center text-sm text-gray-600">
                  <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                  Created: <span class="ml-1 font-medium text-gray-900">{{ formatDate(amount.created_at) }}</span>
                </div>
              </div>

              <!-- Actions -->
              <div class="flex items-center justify-end space-x-2 pt-4 border-t border-gray-100">
                <button
                  @click="editAmount(amount)"
                  class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors"
                >
                  <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                  </svg>
                  Edit
                </button>
                <button
                  @click="deleteAmount(amount)"
                  class="inline-flex items-center px-3 py-2 border border-red-300 shadow-sm text-sm leading-4 font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors"
                >
                  <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                  Delete
                </button>
              </div>
            </div>
          </div>

          <!-- Add New Card -->
          <button
            @click="openCreateModalForFrequency(activeTab)"
            class="relative bg-white rounded-lg border-2 border-dashed border-gray-300 hover:border-primary transition-all duration-200 shadow-sm hover:shadow-md p-6 flex flex-col items-center justify-center min-h-[250px] group"
          >
            <div class="w-16 h-16 rounded-full bg-gray-100 group-hover:bg-blue-50 flex items-center justify-center mb-4 transition-colors">
              <svg class="w-8 h-8 text-gray-400 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
              </svg>
            </div>
            <span class="text-sm font-medium text-gray-600 group-hover:text-primary transition-colors">Add New Amount</span>
            <span class="text-xs text-gray-500 mt-1">for {{ getFrequencyLabel(activeTab) }}</span>
          </button>
        </div>

        <!-- Empty State -->
        <div v-if="getAmountsByFrequency(activeTab).length === 0" class="text-center py-12 bg-gray-50 rounded-lg">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">No amounts found</h3>
          <p class="mt-1 text-sm text-gray-500">Get started by creating a new sponsorship amount for {{ getFrequencyLabel(activeTab) }}.</p>
          <div class="mt-6">
            <button
              @click="openCreateModalForFrequency(activeTab)"
              class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
            >
              <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
              </svg>
              Add First Amount
            </button>
          </div>
        </div>

        <!-- Preview Section -->
        <div class="mt-8 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg p-6 border border-blue-100">
          <div class="flex items-start">
            <div class="flex-shrink-0">
              <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
            </div>
            <div class="ml-3 flex-1">
              <h3 class="text-sm font-medium text-blue-900">Preview</h3>
              <div class="mt-2 text-sm text-blue-700">
                <p>Sponsors will see these amounts when they select the "{{ getFrequencyLabel(activeTab) }}" frequency option on the registration page.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Create/Edit Modal - Improved -->
    <div v-if="showModal" class="fixed z-50 inset-0 overflow-y-auto">
      <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" @click="closeModal"></div>
        
        <!-- Center modal -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
          <!-- Modal Header -->
          <div class="bg-gradient-to-r from-primary to-blue-600 px-6 py-5">
            <div class="flex items-center justify-between">
              <div class="flex items-center">
                <div class="flex-shrink-0 bg-white bg-opacity-20 rounded-lg p-2">
                  <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <div class="ml-3">
                  <h3 class="text-lg font-semibold text-white">
                    {{ editingAmount ? 'Edit Sponsor Amount' : 'Add New Sponsor Amount' }}
                  </h3>
                  <p class="text-sm text-blue-100 mt-0.5">
                    {{ editingAmount ? 'Update the sponsorship amount details' : 'Create a new sponsorship amount option' }}
                  </p>
                </div>
              </div>
              <button
                @click="closeModal"
                class="text-white hover:text-gray-200 transition-colors"
              >
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>

          <!-- Modal Body -->
          <form @submit.prevent="saveAmount" class="px-6 py-6">
            <div class="space-y-5">
              <!-- Amount Input -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Amount (USD)
                    <span class="text-red-500 ml-1">*</span>
                  </div>
                </label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="text-gray-500 sm:text-sm">$</span>
                  </div>
                  <input
                    type="number"
                    v-model="form.amount"
                    step="0.01"
                    min="1"
                    required
                    class="pl-7 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm transition-colors"
                    placeholder="1000.00"
                  />
                </div>
                <p v-if="errors.amount" class="mt-1.5 text-sm text-red-600 flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                  </svg>
                  {{ errors.amount[0] }}
                </p>
                <p class="mt-1.5 text-xs text-gray-500">Enter the sponsorship amount in dollars</p>
              </div>

              <!-- Frequency Select -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Payment Frequency
                    <span class="text-red-500 ml-1">*</span>
                  </div>
                </label>
                <select
                  v-model="form.frequency"
                  required
                  class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm transition-colors"
                >
                  <option value="">Select frequency...</option>
                  <option 
                    v-for="(label, key) in frequencies" 
                    :key="key" 
                    :value="key"
                  >
                    {{ label }}
                  </option>
                </select>
                <p v-if="errors.frequency" class="mt-1.5 text-sm text-red-600 flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                  </svg>
                  {{ errors.frequency[0] }}
                </p>
                <p class="mt-1.5 text-xs text-gray-500">How often will this sponsorship be paid</p>
              </div>

              <!-- Sort Order Input -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                    </svg>
                    Sort Order
                  </div>
                </label>
                <input
                  type="number"
                  v-model="form.sort_order"
                  min="0"
                  class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm transition-colors"
                  placeholder="0"
                />
                <p class="mt-1.5 text-xs text-gray-500">Lower numbers appear first (e.g., 0, 1, 2...)</p>
              </div>

              <!-- Default Checkbox -->
              <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <div class="flex items-start">
                  <div class="flex items-center h-5">
                    <input
                      type="checkbox"
                      v-model="form.is_default"
                      id="is_default"
                      class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded"
                    />
                  </div>
                  <div class="ml-3 text-sm">
                    <label for="is_default" class="font-medium text-gray-900 cursor-pointer">
                      Set as default amount
                    </label>
                    <p class="text-gray-500 mt-1">
                      This amount will be pre-selected for sponsors choosing the {{ getFrequencyLabel(form.frequency) || 'selected' }} frequency
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Modal Footer -->
            <div class="mt-6 flex items-center justify-end space-x-3 pt-5 border-t border-gray-200">
              <button
                type="button"
                @click="closeModal"
                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors"
              >
                Cancel
              </button>
              <button
                type="submit"
                :disabled="saving"
                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <svg v-if="saving" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ saving ? 'Saving...' : (editingAmount ? 'Update Amount' : 'Create Amount') }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "../Layouts/App.vue";
import axios from 'axios';

export default {
  name: 'SponsorAmountsIndex',
  components: {
    AppLayout,
  },
  data() {
    return {
      amounts: [],
      frequencies: {},
      activeTab: 'one_time',
      loading: true,
      showModal: false,
      editingAmount: null,
      saving: false,
      form: {
        amount: null,
        frequency: 'one_time',
        is_default: false,
        sort_order: 0,
      },
      errors: {},
    };
  },
  mounted() {
    this.fetchFrequencies();
    this.fetchAmounts();
  },
  methods: {
    async fetchFrequencies() {
      try {
        const response = await axios.get(`${process.env.MIX_ADMIN_API_URL}sponsor-amounts-frequencies`);
        if (response.data.status === 'Success') {
          this.frequencies = response.data.data || {};
          // Set the first available frequency as the active tab
          if (Object.keys(this.frequencies).length > 0 && !this.activeTab) {
            this.activeTab = Object.keys(this.frequencies)[0];
          }
        }
      } catch (error) {
        console.error('Error fetching frequencies:', error);
      }
    },

    async fetchAmounts() {
      this.loading = true;
      try {
        const response = await axios.get(`${process.env.MIX_ADMIN_API_URL}sponsor-amounts`);
        console.log('Sponsor amounts response:', response.data);
        
        // Handle both wrapped resource responses and direct data responses
        if (response.data.status === 'Success') {
          // Check if data is in response.data.data or directly in response.data
          this.amounts = response.data.data || response.data;
        } else if (Array.isArray(response.data)) {
          // Direct array response
          this.amounts = response.data;
        }
      } catch (error) {
        console.error('Error fetching sponsor amounts:', error);
        this.$swal.fire('Error', 'Failed to load sponsor amounts', 'error');
      } finally {
        this.loading = false;
      }
    },

    openCreateModal() {
      this.editingAmount = null;
      this.form = {
        amount: null,
        frequency: 'one_time',
        is_default: false,
        sort_order: this.amounts.length,
      };
      this.errors = {};
      this.showModal = true;
    },

    editAmount(amount) {
      this.editingAmount = amount;
      this.form = {
        amount: amount.amount,
        frequency: amount.frequency || 'one_time',
        is_default: amount.is_default,
        sort_order: amount.sort_order,
      };
      this.errors = {};
      this.showModal = true;
    },

    closeModal() {
      this.showModal = false;
      this.editingAmount = null;
      this.form = {
        amount: null,
        frequency: 'one_time',
        is_default: false,
        sort_order: 0,
      };
      this.errors = {};
    },

    async saveAmount() {
      this.saving = true;
      this.errors = {};

      try {
        let response;
        if (this.editingAmount) {
          response = await axios.put(
            `${process.env.MIX_ADMIN_API_URL}sponsor-amounts/${this.editingAmount.id}`,
            this.form
          );
        } else {
          response = await axios.post(
            `${process.env.MIX_ADMIN_API_URL}sponsor-amounts`,
            this.form
          );
        }

        if (response.data.status === 'Success') {
          this.$swal.fire({
            icon: 'success',
            title: 'Success',
            text: response.data.message,
            confirmButtonColor: '#3085d6',
          });
          this.closeModal();
          this.fetchAmounts();
        }
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data.errors || {};
        } else {
          this.$swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to save sponsor amount',
            confirmButtonColor: '#d33',
          });
        }
      } finally {
        this.saving = false;
      }
    },

    async deleteAmount(amount) {
      const result = await this.$swal.fire({
        title: 'Are you sure?',
        text: `Do you want to delete the $${this.formatAmount(amount.amount)} sponsor amount?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No',
      });

      if (result.isConfirmed) {
        try {
          const response = await axios.delete(
            `${process.env.MIX_ADMIN_API_URL}sponsor-amounts/${amount.id}`
          );
          if (response.data.status === 'Success') {
            this.$swal.fire({
              icon: 'success',
              title: 'Deleted!',
              text: response.data.message,
              confirmButtonColor: '#3085d6',
            });
            this.fetchAmounts();
          }
        } catch (error) {
          this.$swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to delete sponsor amount',
            confirmButtonColor: '#d33',
          });
        }
      }
    },

    formatAmount(amount) {
      return new Intl.NumberFormat('en-US').format(amount);
    },

    getFrequencyLabel(frequency) {
      return this.frequencies[frequency] || frequency;
    },

    getAmountsByFrequency(frequency) {
      return this.amounts.filter(amount => amount.frequency === frequency);
    },

    getAmountCountByFrequency(frequency) {
      return this.amounts.filter(amount => amount.frequency === frequency).length;
    },

    formatDate(dateString) {
      if (!dateString) return 'N/A';
      const date = new Date(dateString);
      return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
    },

    openCreateModalForFrequency(frequency) {
      this.editingAmount = null;
      this.form = {
        amount: null,
        frequency: frequency,
        is_default: false,
        sort_order: this.getAmountsByFrequency(frequency).length,
      };
      this.errors = {};
      this.showModal = true;
    },
  },
};
</script>
