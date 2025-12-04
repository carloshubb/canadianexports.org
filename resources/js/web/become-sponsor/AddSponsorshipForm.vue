<template>
  <div class="bg-white rounded-lg shadow-lg p-6 md:p-8">
    <div class="mb-6">
      <h1 class="text-3xl font-bold text-primary mb-2">Add New Sponsorship</h1>
      <p class="text-gray-600">Create an additional sponsorship under your account</p>
    </div>

    <form @submit.prevent="processPayment()">
      <!-- SPONSORSHIP OPTION -->
      <div class="bg-white rounded-lg overflow-hidden shadow-3xl my-6">
        <div class="px-4 py-3 sm:px-6 text-left bg-gradient-to-r from-primary via-primary to-secondary rounded-t-md">
          <h4 class="text-white">Choose Your Option</h4>
        </div>
        <div class="p-6">
          <fieldset class="flex flex-col md:flex-row items-stretch w-full overflow-hidden rounded-md shadow-sm gap-4">
            <!-- Option 1: Enter Your Amount -->
            <div class="flex-1">
              <label
                class="w-full h-full flex flex-col cursor-pointer px-5 py-6 rounded-md text-base md:text-lg font-medium text-center border-2 transition-all"
                :class="
                  !form.talk_to_us_first
                    ? 'text-white bg-primary border-primary shadow-lg'
                    : 'text-primary bg-white border-gray-300 hover:border-primary'
                "
              >
                <input
                  type="radio"
                  name="sponsorship_option"
                  :value="false"
                  class="sr-only"
                  v-model="form.talk_to_us_first"
                />
                <span class="text-2xl mb-2">💳</span>
                <span class="font-bold">Enter Your Amount</span>
                <span class="text-sm mt-2 opacity-90">Make a sponsorship payment now</span>
              </label>
            </div>

            <!-- Option 2: Talk to Us First -->
            <div class="flex-1">
              <label
                class="w-full h-full flex flex-col cursor-pointer px-5 py-6 rounded-md text-base md:text-lg font-medium text-center border-2 transition-all"
                :class="
                  form.talk_to_us_first
                    ? 'text-white bg-primary border-primary shadow-lg'
                    : 'text-primary bg-white border-gray-300 hover:border-primary'
                "
              >
                <input
                  type="radio"
                  name="sponsorship_option"
                  :value="true"
                  class="sr-only"
                  v-model="form.talk_to_us_first"
                />
                <span class="text-2xl mb-2">📞</span>
                <span class="font-bold">Talk to Us First</span>
                <span class="text-sm mt-2 opacity-90">Let's discuss before you commit</span>
              </label>
            </div>
          </fieldset>
        </div>
      </div>

      <!-- AMOUNT & BENEFICIARY -->
      <div v-if="!form.talk_to_us_first" class="bg-white rounded-lg overflow-hidden shadow-3xl my-6">
        <div class="px-4 py-3 sm:px-6 text-left bg-gradient-to-r from-primary via-primary to-secondary rounded-t-md">
          <h4 class="text-white">Sponsorship Details</h4>
        </div>
        <div class="p-6">
          <div class="relative w-full mb-6">
            <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg font-medium" for="sponsorship_amount">
              Enter Your Sponsorship Amount <span class="text-red-500">*</span>
            </label>
            <div class="relative flex items-center">
              <span class="absolute left-4 text-gray-500 text-xl font-bold">$</span>
              <input
                type="number"
                id="sponsorship_amount"
                v-model="form.sponsorship_amount"
                class="block pl-10 border-2 p-3 w-full rounded border-green-500 focus:outline-none focus:border-blue-600 text-lg"
                placeholder="0.00"
                min="1"
                step="0.01"
                @input="clearErrors('sponsorship_amount')"
              />
            </div>
            <Error v-if="submitted" fieldName="sponsorship_amount" :validationErros="validationErros" full_width="1" />
          </div>

          <div class="relative w-full">
            <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg font-medium">
              Select Beneficiary <span class="text-red-500">*</span>
            </label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
              <div v-for="beneficiary in beneficiaries" :key="beneficiary.id">
                <div
                  class="bg-gray-50 rounded-md border shadow text-base md:text-lg font-medium flex items-center justify-center h-12 hover:shadow-md border-gray-100 cursor-pointer hover:border-2 hover:border-green-500 transition-all"
                  :class="form.beneficiary_id == beneficiary.id ? 'border-2 border-green-500 text-green-600 bg-green-50' : ''"
                  @click="updateBeneficiary(beneficiary)"
                >
                  <span>{{ beneficiary.name }}</span>
                </div>
              </div>
            </div>
            <Error v-if="submitted" fieldName="beneficiary_id" :validationErros="validationErros" full_width="1" />
          </div>
        </div>
      </div>

      <!-- TALK TO US FIELDS -->
      <div v-if="form.talk_to_us_first" class="bg-white rounded-lg overflow-hidden shadow-3xl my-6">
        <div class="px-4 py-3 sm:px-6 text-left bg-gradient-to-r from-primary via-primary to-secondary rounded-t-md">
          <h4 class="text-white">Contact Preferences</h4>
        </div>
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="relative w-full">
              <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg">
                Preferred Call Time <span class="text-red-500">*</span>
              </label>
              <select v-model="form.preferred_call_time" class="can-exp-input" @change="clearErrors('preferred_call_time')">
                <option value="">Select time...</option>
                <option value="morning">Morning (8am - 12pm)</option>
                <option value="afternoon">Afternoon (12pm - 5pm)</option>
                <option value="evening">Evening (5pm - 8pm)</option>
              </select>
              <Error v-if="submitted" fieldName="preferred_call_time" :validationErros="validationErros" />
            </div>

            <div class="relative w-full">
              <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg">
                Preferred Call Date (Optional)
              </label>
              <input
                type="date"
                v-model="form.preferred_call_date"
                class="can-exp-input"
                :min="getMinDate()"
                @input="clearErrors('preferred_call_date')"
              />
            </div>
          </div>
        </div>
      </div>

      <!-- CONTACT INFORMATION (Hidden but auto-filled) -->
      <div class="bg-white rounded-lg overflow-hidden shadow-3xl my-6">
        <div class="px-4 py-3 sm:px-6 text-left bg-gradient-to-r from-primary via-primary to-secondary rounded-t-md">
          <h4 class="text-white">Contact Information</h4>
        </div>
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="relative w-full">
              <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg">
                Contact Person Name <span class="text-red-500">*</span>
              </label>
              <input
                type="text"
                v-model="form.contact_name"
                class="can-exp-input bg-gray-50"
                placeholder="John Doe"
                readonly
              />
              <p class="text-xs text-gray-500 mt-1">From your account</p>
            </div>

            <div class="relative w-full">
              <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg">
                Email <span class="text-red-500">*</span>
              </label>
              <input
                type="email"
                v-model="form.email"
                class="can-exp-input bg-gray-50"
                placeholder="email@example.com"
                readonly
              />
              <p class="text-xs text-gray-500 mt-1">From your account</p>
            </div>

            <div class="relative w-full md:col-span-2">
              <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg">
                Contact Number <span class="text-red-500">*</span>
              </label>
              <input
                type="text"
                v-model="form.contact_number"
                class="can-exp-input"
                placeholder="+1 (555) 123-4567"
                @input="clearErrors('contact_number')"
              />
              <p class="text-xs text-gray-500 mt-1">Enter your contact number for this sponsorship</p>
              <Error v-if="submitted" fieldName="contact_number" :validationErros="validationErros" />
            </div>
          </div>
        </div>
      </div>

      <!-- SPONSORSHIP INFO -->
      <div class="bg-white rounded-lg overflow-hidden shadow-3xl my-6">
        <div class="px-4 py-3 sm:px-6 text-left bg-gradient-to-r from-primary via-primary to-secondary rounded-t-md">
          <h4 class="text-white">Sponsorship Information</h4>
        </div>
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="relative w-full md:col-span-2">
              <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg">
                Company/Business Name <span class="text-red-500">*</span>
              </label>
              <input
                type="text"
                v-model="form.company_name"
                class="can-exp-input"
                placeholder="Your Company Inc."
                @input="clearErrors('company_name')"
              />
              <p class="text-sm text-gray-500 mt-1">This can be a different business than your previous sponsorships</p>
              <Error v-if="submitted" fieldName="company_name" :validationErros="validationErros" />
            </div>

            <div class="relative w-full md:col-span-2">
              <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg">
                Company Website (Optional)
              </label>
              <input
                type="url"
                v-model="form.url"
                class="can-exp-input"
                placeholder="https://yourcompany.com"
                @input="clearErrors('url')"
              />
              <Error v-if="submitted" fieldName="url" :validationErros="validationErros" />
            </div>

            <div class="relative w-full md:col-span-2">
              <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg">
                Brief Description <span class="text-red-500">*</span>
              </label>
              <textarea
                v-model="form.summary"
                class="can-exp-input"
                rows="3"
                placeholder="Brief description of your company and sponsorship..."
                @input="clearErrors('summary')"
              ></textarea>
              <Error v-if="submitted" fieldName="summary" :validationErros="validationErros" />
            </div>

            <div class="relative w-full md:col-span-2">
              <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg">
                Detailed Description <span class="text-red-500">*</span>
              </label>
              <textarea
                v-model="form.detail_description"
                class="can-exp-input"
                rows="5"
                placeholder="Detailed description of your company, products, or services..."
                @input="clearErrors('detail_description')"
              ></textarea>
              <Error v-if="submitted" fieldName="detail_description" :validationErros="validationErros" />
            </div>

            <div class="relative w-full md:col-span-2">
              <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg">
                Additional Message (Optional)
              </label>
              <textarea
                v-model="form.message"
                class="can-exp-input"
                rows="3"
                placeholder="Any additional information..."
                @input="clearErrors('message')"
              ></textarea>
            </div>
          </div>
        </div>
      </div>

      <!-- LOGO & FEATURED IMAGE -->
      <div class="bg-white rounded-lg overflow-hidden shadow-3xl my-6">
        <div class="px-4 py-3 sm:px-6 text-left bg-gradient-to-r from-primary via-primary to-secondary rounded-t-md">
          <h4 class="text-white">Images (Optional)</h4>
        </div>
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg">Company Logo</label>
              <file-pond
                name="logo"
                ref="logo"
                class="filepond"
                label-idle="Drop logo here or <span class='filepond--label-action text-primary'>Browse</span>"
                accepted-file-types="image/jpeg, image/png, image/jpg"
                :allow-multiple="false"
                :server="serverOptions"
                v-on:processfile="handleLogoProcessed"
                v-on:removefile="handleLogoRemoved"
              />
            </div>
            <div>
              <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg">Featured Image</label>
              <file-pond
                name="featured_image"
                ref="featured_image"
                class="filepond"
                label-idle="Drop image here or <span class='filepond--label-action text-primary'>Browse</span>"
                accepted-file-types="image/jpeg, image/png, image/jpg"
                :allow-multiple="false"
                :server="serverOptions"
                v-on:processfile="handleFeaturedProcessed"
                v-on:removefile="handleFeaturedRemoved"
              />
            </div>
          </div>
        </div>
      </div>

      <!-- PAYMENT SECTION (Only for "Enter Your Amount") -->
      <div v-if="!form.talk_to_us_first" class="bg-white rounded-lg overflow-hidden shadow-3xl my-6">
        <div class="px-4 py-3 sm:px-6 text-left bg-gradient-to-r from-primary via-primary to-secondary rounded-t-md">
          <h4 class="text-white">Payment Method</h4>
        </div>
        <div class="p-6">
          <!-- Payment Method Selection -->
          <div class="flex flex-col space-y-4 md:flex-row md:space-x-4 md:space-y-0 mt-2">
            <div class="flex items-center">
              <input
                id="stripe"
                value="stripe"
                name="payment-method"
                type="radio"
                class="h-4 w-4 border-gray-300 accent-primary"
                @click="setPaymentMethod('stripe')"
                :checked="form.payment_method == 'stripe'"
              />
              <label for="stripe" class="ml-2 block text-gray-900 font-medium">
                Pay with Credit Card
              </label>
            </div>
            <div class="flex items-center">
              <input
                id="paypal"
                value="paypal"
                name="payment-method"
                type="radio"
                class="h-4 w-4 border-gray-300 accent-primary"
                @click="setPaymentMethod('paypal')"
                :checked="form.payment_method == 'paypal'"
              />
              <label for="paypal" class="ml-2 block text-gray-900 font-medium">
                <svg viewBox="0 0 157 44" fill="none" xmlns="http://www.w3.org/2000/svg"
                  class="w-16 h-16 text-[#635BFF]">
                  <g clip-path="url(#clip0_6_187)">
                    <path
                      d="M6.89999 2C7.29999 0.3 7.79999 0 9.49999 0C11.5 0 13.5 0 15.6 0C18.2 0.1 20.8 0.1 23.4 0.3C24.9 0.4 26.4 0.9 27.8 1.5C31.1 2.9 32.9 6.5 32.3 10.3C31.5 16 27.9 19.1 22.6 20.7C20.1 21.4 17.6 21.6 15 21.7C14.6 21.7 14.3 21.7 13.9 21.7C11.8 21.8 11 22.4 10.4 24.4C9.79999 26.7 9.09999 28.9 8.49999 31.2C8.19999 32.4 7.89999 32.6 6.59999 32.6C4.79999 32.6 2.99999 32.6 1.29999 32.4C0.0999947 32.3 -0.200005 31.9 0.0999947 30.7L6.89999 2ZM15.3 15.6C17 15.6 19.3 14.9 21 14.1C22.3 13.5 23 12.5 23.2 11.1C23.6 8.9 22.9 7.2 21.2 6.6C19.4 5.9 17.4 5.8 15.5 6.2C14.8 6.4 14.3 6.8 14.2 7.5C13.7 9.3 13.2 11.1 12.9 12.9C12.5 15.1 13 15.6 15.3 15.6ZM59.6 40.3C59.2 41 58.8 41.7 58.5 42.4C58.3 43 58.6 43.5 59.2 43.5C60.8 43.5 62.5 43.5 64.1 43.5C65.6 43.5 66.6 42.9 67.4 41.7C68 40.7 68.6 39.6 69.2 38.6C75.2 28.5 81.2 18.3 87.2 8.2C87.4 7.9 87.5 7.7 87.7 7.3C85.7 7.3 83.9 7.4 82 7.3C80 7.2 78.7 8.1 77.7 9.8C75.3 14 72.9 18.1 70.5 22.2C70.3 22.5 70.1 22.8 69.8 23.1C69.7 23.1 69.7 23 69.6 23C69.5 22.7 69.4 22.3 69.4 22C68.7 17.7 68 13.4 67.3 9.1C67.1 8.1 66.3 7.3 65.2 7.3C63.9 7.3 62.5 7.4 61.2 7.3C59.4 7.2 59.1 8.1 59.3 9.5L63 33.2C63.1 33.7 63 34.2 62.7 34.6L59.6 40.3ZM44.9 32.7C45.1 31.7 45.2 31 45.4 30.1C44.9 30.4 44.6 30.6 44.3 30.8C42.1 32 40 33 37.6 33.4C33.8 34 30.2 31.9 29.4 28.4C28.7 25.5 29.8 22.3 32.3 20.5C34.6 18.8 37.3 18.1 40 17.7C42.6 17.3 45.1 17 47.7 16.8C48.5 16.7 48.6 16.4 48.6 15.7C48.4 13.9 47.2 12.9 45 12.7C42.2 12.5 39.4 13.2 36.7 13.9C36.2 14 35.7 14.2 35.1 14.4C35.1 14.1 35 13.9 35 13.7C35.1 12.4 35.1 11.1 35.2 9.9C35.2 9.4 35.3 8.9 35.9 8.7C41 7.6 46.1 7 51.3 8.1C51.6 8.2 52 8.3 52.3 8.4C55.8 9.6 57 11.5 56.3 15.1C55.3 20.1 54.2 25.2 53.1 30.2C53 30.7 52.8 31.2 52.6 31.7C52.2 32.4 51.6 32.9 50.8 32.9C48.9 32.7 47 32.7 44.9 32.7ZM47.4 21C46.4 21.1 45.4 21.1 44.6 21.3C43 21.6 41.5 21.9 40 22.3C38.6 22.7 37.9 23.8 37.6 25.2C37.3 26.8 38 27.9 39.6 28.2C41.8 28.6 43.8 28 45.6 27C45.9 26.8 46.2 26.6 46.3 26.3C46.6 24.5 47 22.8 47.4 21Z"
                      fill="#162E53" />
                      <path d="M91.7 1.4C92.1 0.3 92.6 0 93.7 0C95.9 0 98.1 0 100.3 0C102.9 0.1 105.5 0.1 108.1 0.3C109.6 0.5 111.1 0.9 112.5 1.5C115.7 2.8 117.5 6.3 117.1 9.9C116.5 15.3 113.1 19.2 107.3 20.6C105 21.2 102.5 21.3 100.1 21.6C99.6 21.7 99.1 21.6 98.5 21.6C96.5 21.7 95.7 22.3 95.1 24.2C94.5 26.4 93.8 28.7 93.2 30.9C92.8 32.2 92.6 32.4 91.2 32.4C89.5 32.4 87.9 32.4 86.2 32.3C84.6 32.2 84.4 31.8 84.7 30.3L91.7 1.4ZM102.3 5.9C101.7 6 100.9 6 100.2 6.2C99.7 6.4 99.2 6.8 99 7.2C98.4 9.3 97.9 11.4 97.5 13.5C97.2 15 97.7 15.4 99.2 15.5C101.4 15.6 103.5 15 105.5 14.1C107.1 13.4 107.8 12.2 108 10.5C108.2 8 107.2 6.6 104.8 6.1C104 6 103.2 6 102.3 5.9ZM119.7 14.1C119.8 13 119.8 11.9 119.9 10.8C120.1 8.3 119.8 8.7 122.3 8.2C126.2 7.4 130.1 7.1 134.1 7.6C135.2 7.7 136.4 8 137.4 8.4C140.5 9.5 141.7 11.5 141.1 14.7C140.1 19.8 138.9 24.9 137.8 30C137.7 30.5 137.5 31.1 137.2 31.5C136.8 32 136.2 32.6 135.7 32.6C133.7 32.7 131.6 32.7 129.5 32.7C129.7 31.8 129.8 31 130 30.2C129.3 30.6 128.7 31 128 31.3C125.9 32.4 123.7 33.5 121.3 33.5C117.8 33.6 115.1 31.9 114.1 29C113.1 26 114.2 22.4 116.9 20.5C119.2 18.8 121.9 18.1 124.6 17.7C127.2 17.3 129.7 17.1 132.3 16.8C132.9 16.7 133.2 16.5 133.1 15.8C133 14 131.7 12.9 129.5 12.7C126.5 12.5 123.6 13.2 120.8 14C120.5 14.1 120.2 14.2 120 14.2C120 14.2 119.9 14.1 119.7 14.1ZM132 21C131.1 21.1 130.2 21.1 129.4 21.2C127.8 21.5 126.2 21.7 124.7 22.2C123.4 22.6 122.5 23.5 122.2 24.9C121.8 26.7 122.5 27.8 124.3 28.1C126.4 28.4 128.4 27.9 130.2 26.8C130.5 26.6 130.8 26.3 130.9 25.9C131.3 24.4 131.6 22.7 132 21ZM156.3 0.1C154.3 0.1 152.5 0.1 150.6 0.1C149 0.1 148.6 0.4 148.2 2L142 30.1C141.6 31.8 141.9 32.2 143.7 32.2C144.9 32.2 146.2 32.3 147.4 32.3C148.9 32.3 149.2 32.1 149.5 30.6L156.3 0.1Z" fill="#1E6196" data-v-470ebd7e=""></path>
                  </g>
                  <defs>
                    <clipPath id="clip0_6_187">
                      <rect width="156.3" height="43.5" fill="white" />
                    </clipPath>
                  </defs>
                </svg>
              </label>
            </div>
          </div>

          <!-- Stripe Card Details -->
          <div v-if="form.payment_method === 'stripe'" class="border border-primary rounded p-4 mt-4">
            <div class="flex justify-center items-center">
              <div class="h-auto bg-white w-full">
                <!-- Cardholder Name -->
                <div class="input_text relative mb-4">
                  <label class="block text-sm font-medium text-gray-700 mb-1">Cardholder Name</label>
                  <input
                    v-model="form.cardholder_name"
                    type="text"
                    placeholder="John Doe"
                    class="can-exp-input"
                    @input="clearErrors('cardholder_name')"
                  />
                  <Error v-if="submitted" fieldName="cardholder_name" :validationErros="validationErros" />
                </div>

                <!-- Card Element -->
                <div class="input_text relative mb-4">
                  <label class="block text-sm font-medium text-gray-700 mb-1">Card Details</label>
                  <div ref="stripeCard" class="can-exp-input"></div>
                  <div id="card-errors" class="text-red-500 text-sm mt-1"></div>
                </div>
              </div>
            </div>
          </div>

          <Error v-if="submitted" fieldName="payment_method" :validationErros="validationErros" full_width="1" />
        </div>
      </div>

      <!-- ACTION BUTTONS -->
      <div class="flex justify-between items-center pt-6 border-t">
        <a :href="sponsorSettingsUrl" class="text-gray-600 hover:text-gray-800">
          ← Back to My Sponsorships
        </a>
        <button
          type="submit"
          class="button-exp-fill"
          :disabled="processing"
        >
          <span v-if="processing">Processing...</span>
          <span v-else-if="form.talk_to_us_first">Submit Contact Request</span>
          <span v-else>Complete Payment & Add Sponsorship</span>
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css";
import axios from "axios";
import helper from "../../helper";
import Error from "../components/Error.vue";
import ErrorHandling from "../../ErrorHandling";
import { loadStripe } from "@stripe/stripe-js";

const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview
);

export default {
  name: "AddSponsorshipForm",
  components: {
    FilePond,
    Error,
  },
  props: {
    sponsorSettingsUrl: {
      type: String,
      default: '/user/sponsor-settings'
    },
    loggedInUser: {
      type: String,
      default: null
    }
  },
  computed: {
    user() {
      if (this.loggedInUser) {
        try {
          return JSON.parse(this.loggedInUser);
        } catch (e) {
          return null;
        }
      }
      return null;
    }
  },
  data() {
    return {
      form: {
        talk_to_us_first: false,
        company_name: "",
        contact_name: "",
        email: "",
        contact_number: "",
        url: "",
        summary: "",
        detail_description: "",
        message: "",
        logo: null,
        featured_image: null,
        sponsorship_amount: null,
        beneficiary_id: null,
        payment_method: "stripe",
        payment_method_id: null,
        cardholder_name: "",
        preferred_call_time: "",
        preferred_call_date: "",
      },
      beneficiaries: [],
      stripe: null,
      elements: null,
      cardElement: null,
      processing: false,
      submitted: false,
      validationErros: new ErrorHandling(),
      serverOptions: {
        url: process.env.MIX_WEB_API_URL,
        process: "media/process",
        revert: "media/revert",
        load: "media/load?load=",
      },
    };
  },
  mounted() {
    this.loadBeneficiaries();
    
    // Pre-fill user data from logged-in account
    if (this.user) {
      this.form.contact_name = this.user.name || '';
      this.form.email = this.user.email || '';
      
      // Ensure contact_number is never null - use empty string as fallback
      const contactNum = this.user.contact_number || this.user.phone || this.user.contact || '';
      this.form.contact_number = contactNum || '';  // Double check to ensure it's not null
      
      // Also pre-fill cardholder name with user's name
      this.form.cardholder_name = this.user.name || '';
      
      console.log('Pre-filled user data:', {
        contact_name: this.form.contact_name,
        email: this.form.email,
        contact_number: this.form.contact_number
      });
    }
  },
  watch: {
    'form.sponsorship_amount': {
      handler(newAmount) {
        // When amount is entered, payment section appears - mount Stripe element!
        if (newAmount > 0 && !this.form.talk_to_us_first && this.form.payment_method === 'stripe') {
          this.$nextTick(() => {
            setTimeout(() => {
              this.mountStripeElement();
            }, 100);
          });
        }
      }
    },
    'form.payment_method': {
      handler(newMethod) {
        // Remount Stripe Elements when switching back to Stripe
        if (newMethod === 'stripe') {
          this.$nextTick(() => {
            // Small delay to ensure DOM is ready after toggle
            setTimeout(() => {
              const mountPoint = this.$refs.stripeCard;
              if (mountPoint && this.cardElement && this.stripe) {
                try {
                  // Try to unmount first if already mounted
                  this.cardElement.unmount();
                } catch (e) {
                  // Element not mounted, that's okay
                }
                
                try {
                  // Mount to the DOM
                  this.cardElement.mount(mountPoint);
                  console.log('Stripe Element remounted successfully after toggle');
                } catch (e) {
                  console.error('Error mounting Stripe Element:', e);
                  // If mounting fails, recreate the element
                  this.cardElement = this.elements.create('card');
                  this.cardElement.mount(mountPoint);
                }
              } else if (mountPoint && this.stripe && !this.cardElement) {
                // Card element doesn't exist, create and mount it
                this.elements = this.stripe.elements();
                this.cardElement = this.elements.create('card');
                this.cardElement.mount(mountPoint);
                console.log('Stripe Element created and mounted after toggle');
              }
            }, 100);
          });
        }
      }
    },
    'form.talk_to_us_first': {
      handler(newValue) {
        // When switching to "Enter Your Amount", mount Stripe element if amount exists
        if (!newValue && this.form.payment_method === 'stripe' && this.form.sponsorship_amount > 0) {
          this.$nextTick(() => {
            setTimeout(() => {
              this.mountStripeElement();
            }, 100);
          });
        }
      }
    }
  },
  methods: {
    async loadBeneficiaries() {
      try {
        const response = await axios.get(`${process.env.MIX_WEB_API_URL}get-coffee-wall-beneficiaries`);
        if (response.data.status === "Success") {
          this.beneficiaries = response.data.data;
        }
      } catch (error) {
        console.error("Error loading beneficiaries:", error);
      }
    },

    mountStripeElement() {
      const mountPoint = this.$refs.stripeCard;
      
      if (!mountPoint) {
        console.log('Mount point not found');
        return;
      }

      if (!this.stripe || !this.cardElement) {
        console.log('Stripe or cardElement not initialized');
        return;
      }

      try {
        // Try to unmount first if already mounted
        this.cardElement.unmount();
      } catch (e) {
        // Not mounted yet, that's fine
      }

      try {
        this.cardElement.mount(mountPoint);
        console.log('Stripe Element mounted successfully');
      } catch (e) {
        console.error('Error mounting Stripe card element:', e);
        // Try recreating the element
        try {
          this.cardElement = this.elements.create('card');
          this.cardElement.mount(mountPoint);
          console.log('Stripe Element recreated and mounted');
        } catch (err) {
          console.error('Failed to create/mount card element:', err);
        }
      }
    },

    setPaymentMethod(method) {
      this.form.payment_method = method;
      this.clearErrors("payment_method");
    },

    updateBeneficiary(beneficiary) {
      this.form.beneficiary_id = beneficiary.id;
      this.clearErrors("beneficiary_id");
    },

    handleLogoProcessed(error, file) {
      if (!error) {
        this.form.logo = file.serverId;
      }
    },

    handleLogoRemoved() {
      this.form.logo = null;
    },

    handleFeaturedProcessed(error, file) {
      if (!error) {
        this.form.featured_image = file.serverId;
      }
    },

    handleFeaturedRemoved() {
      this.form.featured_image = null;
    },

    clearErrors(field) {
      if (this.validationErros[field]) {
        delete this.validationErros[field];
      }
    },

    getMinDate() {
      const tomorrow = new Date();
      tomorrow.setDate(tomorrow.getDate() + 1);
      return tomorrow.toISOString().split("T")[0];
    },

    async processPayment() {
      this.submitted = true;
      this.processing = true;
      this.validationErros = new ErrorHandling();

      try {
        // Get Stripe payment method if paying with card
        if (!this.form.talk_to_us_first && this.form.payment_method === "stripe" && this.form.sponsorship_amount > 0) {
          if (!this.cardElement) {
            helper.swalErrorMessageForWeb("Please enter card details");
            this.processing = false;
            return;
          }

          const { error, paymentMethod } = await this.stripe.createPaymentMethod({
            type: "card",
            card: this.cardElement,
            billing_details: {
              name: this.form.cardholder_name || this.form.company_name,
            },
          });

          if (error) {
            helper.swalErrorMessageForWeb(error.message);
            this.processing = false;
            return;
          }

          this.form.payment_method_id = paymentMethod.id;
        }

        // Submit the form
        const response = await axios.post(
          `${process.env.MIX_WEB_API_URL}become-sponsor/process-payment`,
          this.form
        );

        if (response.data.status === "Success") {
          // Handle PayPal redirect
          if (response.data.data.type === "paypal" && response.data.data.redirect_url) {
            window.location.href = response.data.data.redirect_url;
            return;
          }

          // Success - redirect to sponsor settings
          helper.swalSuccessMessageForWeb(
            response.data.message || "Sponsorship added successfully!"
          );
          
          setTimeout(() => {
            window.location.href = this.sponsorSettingsUrl;
          }, 1500);
        }
      } catch (error) {
        this.processing = false;
        if (error.response && error.response.status === 422) {
          this.validationErros.record(error.response.data.errors);
          this.scrollToFirstError();
          helper.swalErrorMessageForWeb("Please check the form for errors.");
        } else {
          helper.swalErrorMessageForWeb(
            error.response?.data?.message || "An error occurred. Please try again."
          );
        }
      }
    },

    scrollToFirstError() {
      const firstErrorField = Object.keys(this.validationErros.errors)[0];
      if (firstErrorField) {
        const field = document.getElementById(firstErrorField);
        if (field) {
          field.scrollIntoView({ behavior: "smooth", block: "center" });
          field.focus();
        }
      }
    },
  },
  created() {
    // Initialize Stripe Elements (same pattern as Coffee Wall and BecomeSponsor)
    (async () => {
      try {
        this.stripe = await loadStripe(process.env.MIX_STRIPE_PUBLIC_KEY);
        if (this.stripe) {
          this.elements = this.stripe.elements();
          this.cardElement = this.elements.create('card');
          console.log('Stripe initialized successfully in created()');
          
          // Try to mount after Vue renders
          this.$nextTick(() => {
            setTimeout(() => {
              const mountPoint = this.$refs.stripeCard;
              if (mountPoint && this.cardElement) {
                this.cardElement.mount(mountPoint);
                console.log('Stripe Element mounted in created()');
              }
            }, 200);
          });
        } else {
          console.error('❌ Failed to load Stripe');
        }
      } catch (e) {
        console.error('❌ Error loading Stripe:', e);
      }
    })();
  },
};
</script>

<style scoped>
.can-exp-input {
  @apply block border-2 p-3 w-full rounded border-gray-300 focus:outline-none focus:border-primary;
}
</style>

