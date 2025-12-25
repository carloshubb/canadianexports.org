<template>
  <form class="lg:w-full" @submit.prevent="processPayment()">
    <div class="bg-white rounded-lg shadow-3xl my-6 p-8">


      <!-- Sponsorship Amount & Frequency (Only for "Enter Your Amount" option) -->
      <div  class="bg-white rounded-lg overflow-hidden shadow-3xl my-6">
        <div class="px-4 py-3 sm:px-6 text-left bg-gradient-to-r from-primary via-primary to-secondary rounded-t-md">
          <h4 class="text-white">Select Your Sponsorship Amount & Frequency*</h4>

        </div>
        <div class="p-6">
          <div class="relative w-full mb-6">
            <fieldset
              class="flex items-center border w-full overflow-hidden bg-white rounded-md md:rounded-lg shadow-sm">
              <template v-for="(label, key, index) in frequencies" :key="key">
                <div class="w-full" v-if="index < Object.keys(frequencies).length - 1">
                  <label
                    class="w-full block cursor-pointer px-5 py-5 text-base md:text-lg text-center border rounded-none"
                    :class="[
                      selectedFrequency === key
                        ? 'border-2 border-green-500 text-green-500'
                        : 'border-gray-200',
                      index === 0 ? 'rounded-l-md md:rounded-l-lg' : '',
                      index === Object.keys(frequencies).length - 2 ? 'rounded-r-md md:rounded-r-lg' : ''
                    ]">
                    <input v-if="index < Object.keys(frequencies).length - 1" type="radio" name="sponsorship_frequency"
                      class="sr-only" :value="key" v-model="selectedFrequency" @change="onFrequencyChange(key)" />
                    <span class="select-none font-FuturaMdCnBT text-base md:text-lg">{{ label }}</span>
                  </label>
                </div>
              </template>
            </fieldset>


          </div>

          <div id="sponsorship_amount" class="relative w-full">
            <div class="flex gap-4 overflow-x-auto whitespace-nowrap pb-2">
              <div v-for="amount in getAmountsByFrequency(selectedFrequency)" :key="amount.id" class="flex-1">
                <div
                  class="bg-gray-50 rounded-md border shadow text-base md:text-lg font-medium flex flex-col items-center justify-center h-20 hover:shadow-md border-gray-100 cursor-pointer hover:border-2 hover:border-green-500 transition-all"
                  :class="form.sponsorship_amount == amount.amount && form.frequency == amount.frequency
                    ? 'border-2 border-green-500 text-green-600 bg-green-50'
                    : ''
                    " @click="updateSponsorAmount(amount)">
                  <span class="text-center select-none font-FuturaMdCnBT">${{ formatAmount(amount.amount) }}</span>
                </div>
              </div>

            </div>
            <br></br>
            <div class="relative flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="absolute left-2 h-7 text-gray-500">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z">
                </path>
              </svg>

              <input type="text" id="custom_amount1" v-model="custom_amount1" @keypress="inputAmount(custom_amount1)"
                class="block mt-1 border-2 p-2.5 w-full rounded border-gray-200 focus:outline-none focus:border focus:border-blue-600 pl-10 h-12"
                :placeholder="'Enter your own amount'" />
            </div>
            <br></br><br></br>
            <div class="flex-1 mt-3">
              <label
                class="w-full h-full flex flex-col cursor-pointer px-5 py-6 rounded-md text-base md:text-lg font-medium text-center border-2 transition-all"
                :class="form.talk_to_us_first
                  ? 'text-white bg-primary border-primary shadow-lg'
                  : 'text-primary bg-white border-gray-300 hover:border-primary'
                  ">
                <button type="radio" name="sponsorship_option" :value="true" class="sr-only"
                  v-model="form.talk_to_us_first" @click="onOptionChange(true)" ></button>
                <span class="font-FuturaMdCnBT">Talk to Us First</span>
                <span class="text-sm mt-2 opacity-90">We're happy to discuss your goals and our partnership
                  opportunities in
                  detail before you make a selection.</span>
              </label>
            </div>
            <div v-if="getAmountsByFrequency(selectedFrequency).length === 0" class="text-center py-8 text-gray-500">
              No sponsorship amounts available for this frequency.
            </div>

            <Error v-if="submitted" fieldName="sponsorship_amount" :validationErros="validationErros" full_width="1" />
          </div>
        </div>
      </div>

      <!-- Beneficiary Selection (Only for "Enter Your Amount" option) -->
      <!-- <div v-if="!form.talk_to_us_first" class="bg-white rounded-lg overflow-hidden shadow-3xl my-6">
        <div class="px-4 py-3 sm:px-6 text-left bg-gradient-to-r from-primary via-primary to-secondary rounded-t-md">
          <h4 class="text-white">Select Beneficiary</h4>
        </div>
        <div class="p-6">
          <div id="beneficiary_ids" class="relative w-full">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
              <div v-for="beneficiary in beneficiaries" :key="beneficiary.id">
                <div
                  class="bg-gray-50 rounded-md border shadow text-base p-2 md:text-lg font-medium flex items-center justify-center h-12 hover:shadow-md border-gray-100 cursor-pointer hover:border-2 hover:border-green-500 transition-all"
                  :class="
                    isBeneficiarySelected(beneficiary.id)
                      ? 'border-2 border-green-500 text-green-600 bg-green-50'
                      : ''
                  "
                  @click="toggleBeneficiary(beneficiary)"
                >
                  <span class="text-center font-FuturaMdCnBT text-base md:text-lg select-none">{{ beneficiary.name }}</span>
                </div>
              </div>
            </div>
            <Error v-if="submitted" fieldName="beneficiary_ids" :validationErros="validationErros" full_width="1" />
          </div>
        </div>
      </div> -->

      <!-- TALK TO US FIELDS (Only for "Talk to Us First" option) -->
      <div v-if="form.contact_preferences" class="bg-white rounded-lg shadow-3xl my-6">
        <div class="px-4 py-3 sm:px-6 text-left bg-gradient-to-r from-primary via-primary to-secondary rounded-t-md">
          <h4 class="text-white">Contact Preferences</h4>
        </div>
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="relative w-full" hidden>
              <label class="block text-gray-900 text-base md:text-base lg:text-lg" for="talk_to_us_name">
                Your Name and Title
                <span class="text-red-500">*</span>
              </label>
              <input type="text" id="talk_to_us_name" v-model="form.talk_to_us_name" class="can-exp-input"
                placeholder="John Doe" @input="clearErrors('talk_to_us_name')" />
              <Error v-if="submitted" fieldName="talk_to_us_name" :validationErros="validationErros" />
            </div>

            <div class="relative w-full" hidden>
              <label class="block text-gray-900 text-base md:text-base lg:text-lg" for="talk_to_us_phone">
                Numbers Only. With Area Code
                <span class="text-red-500">*</span>
              </label>
              <input type="text" id="talk_to_us_phone" v-model="form.talk_to_us_phone" class="can-exp-input"
                placeholder="+1 (555) 123-4567" @input="clearErrors('talk_to_us_phone')" />
              <Error v-if="submitted" fieldName="talk_to_us_phone" :validationErros="validationErros" />
            </div>

            <div class="relative w-full">
              <label class="block text-gray-900 text-base md:text-base lg:text-lg" for="preferred_call_time">
                Best Time to Call
                <span class="text-red-500">*</span>
              </label>
              <select id="preferred_call_time" v-model="form.preferred_call_time"
                class="can-exp-input w-full block border border-gray-300 rounded"
                @change="clearErrors('preferred_call_time')">
                <option value="morning">Morning (9 AM - 12 PM)</option>
                <option value="afternoon">Afternoon (12 PM - 5 PM)</option>
                <option value="evening">Evening (5 PM - 8 PM)</option>
              </select>
              <Error v-if="submitted" fieldName="preferred_call_time" :validationErros="validationErros" />
            </div>

            <div class="relative w-full">
              <label class="block text-gray-900 text-base md:text-base lg:text-lg" for="preferred_call_date">
                Preferred Date (Optional)
              </label>
              <VueDatePicker id="preferred_call_date" v-model="form.preferred_call_date" placeholder="YYYY-MM-DD"
                model-type="yyyy-MM-dd" :formats="{ input: 'yyyy-MM-dd' }" :time-config="{ enableTimePicker: false }"
                auto-apply @update:model-value="
                  clearErrors('preferred_call_date');">
              </VueDatePicker>
              <Error v-if="submitted" fieldName="preferred_call_date" :validationErros="validationErros" />
            </div>
          </div>
        </div>
      </div>

      <!-- COMPANY INFORMATION -->
      <div class="bg-white rounded-lg overflow-hidden shadow-3xl my-6">
        <div class="px-4 py-3 sm:px-6 text-left bg-gradient-to-r from-primary via-primary to-secondary rounded-t-md">
          <h4 class="text-white">Your Business Information</h4>
        </div>
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="relative w-full">
              <label class="block text-gray-900 text-base md:text-base lg:text-lg" for="company_name">
                Business Name
                <span class="text-red-500">*</span>
              </label>
              <input type="text" id="company_name" v-model="form.company_name" class="can-exp-input"
                @input="clearErrors('company_name')" />
              <Error v-if="submitted" fieldName="company_name" :validationErros="validationErros" />
            </div>

            <div class="relative w-full">
              <label class="block text-gray-900 text-base md:text-base lg:text-lg" for="contact_name">
                Your Name and Title
                <span class="text-red-500">*</span>
              </label>
              <textarea id="contact_name" v-model="form.contact_name" class="can-exp-input scrollbar-textarea"
                :placeholder="contactNameInstruction" :title="contactNameInstruction"
                @input="clearErrors('contact_name')"></textarea>
              <Error v-if="submitted" fieldName="contact_name" :validationErros="validationErros" />
            </div>

            <div class="relative w-full">
              <label class="block text-gray-900 text-base md:text-base lg:text-lg" for="email">
                Your Email
                <span class="text-red-500">*</span>
              </label>
              <input type="email" id="email" v-model="form.email" class="can-exp-input"
                placeholder="You will use this email to log in to your account" @input="clearErrors('email')" />

              <Error v-if="submitted" fieldName="email" :validationErros="validationErros" />
            </div>

            <div class="relative w-full">
              <label class="block text-gray-900 text-base md:text-base lg:text-lg" for="contact_number">
                Your Phone Number
                <span class="text-red-500">*</span>
              </label>
              <input type="text" id="contact_number" v-model="form.contact_number" class="can-exp-input"
                placeholder="Numbers only. With area code" @input="clearErrors('contact_number')" />
              <Error v-if="submitted" fieldName="contact_number" :validationErros="validationErros" />
            </div>

            <div class="relative w-full" v-if="!isLoggedIn">
              <label class="block text-gray-900 text-base md:text-base lg:text-lg" for="password">
                Select Password (Min. 8 characters. Must contain at least one lowercase and one uppercase)
                <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <input :type="showPassword ? 'text' : 'password'" id="password" v-model="form.password"
                  class="can-exp-input" @input="clearErrors('password')" />
                <button type="button" class="absolute right-3 top-3 text-gray-500 hover:text-gray-700"
                  @click="showPassword = !showPassword">
                  <svg v-if="!showPassword" class="w-5 h-5" viewBox="0 0 51 34" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M50.96 16.7C50.96 16.72 50.96 16.75 50.96 16.77C50.54 17.41 50.13 18.05 49.69 18.68C46.74 22.97 43.22 26.69 38.8 29.49C35.68 31.46 32.31 32.77 28.64 33.26C28.13 33.33 27.62 33.39 27.11 33.46C26.02 33.46 24.94 33.46 23.85 33.46C23.25 33.38 22.64 33.31 22.04 33.22C18.47 32.67 15.19 31.35 12.15 29.41C8.16 26.86 4.89 23.57 2.08 19.78C1.36 18.82 0.69 17.78 0 16.77C0 16.75 0 16.72 0 16.7C0.07 16.61 0.15 16.52 0.21 16.42C0.93 15.36 1.62 14.27 2.39 13.24C5.23 9.44 8.57 6.16 12.65 3.69C15.69 1.85 18.96 0.64 22.5 0.2C23.07 0.13 23.64 0.07 24.21 0C25.06 0 25.91 0 26.76 0C27.25 0.05 27.74 0.1 28.22 0.16C31.57 0.58 34.7 1.67 37.63 3.35C42.33 6.06 46.07 9.81 49.23 14.17C49.82 15 50.38 15.86 50.96 16.7ZM24.98 29.15C30.92 29.15 35.74 25.62 37.33 20.39C38.37 16.97 37.92 13.67 36.34 10.51C35.58 8.98 34.69 7.57 33.14 6.66C30.6 5.17 27.94 4.24 24.96 4.37C17.99 4.68 12.67 10.59 13.12 17.56C13.3 20.43 14.37 22.98 16.03 25.3C16.26 25.62 16.55 25.92 16.87 26.15C19.42 28.02 22.25 29.12 24.98 29.15Z"
                      fill="currentColor" />
                  </svg>
                  <svg v-else class="w-5 h-5" viewBox="0 0 51 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M28.22 0.59C27.73 0.53 27.24 0.49 26.75 0.43H24.2C23.63 0.5 23.06 0.56 22.49 0.63C18.95 1.07 15.69 2.29 12.64 4.13C8.56 6.6 5.23 9.88 2.39 13.68C1.62 14.71 0.93 15.8 0.21 16.86C0.14 16.95 0.07 17.04 0 17.13V17.21C0.69 18.22 1.35 19.25 2.08 20.23C4.89 24.01 8.16 27.31 12.15 29.86C12.19 29.89 12.23 29.91 12.27 29.93C12.33 29.8 12.4 29.69 12.48 29.57L15.51 24.97C14.14 22.86 13.27 20.55 13.11 17.99C12.67 11.02 17.98 5.1 24.95 4.8C26.2 4.75 27.39 4.88 28.54 5.16L31.18 1.16C30.21 0.91 29.23 0.72 28.22 0.59ZM49.22 14.6C46.3 10.58 42.89 7.08 38.68 4.43C38.61 4.55 38.55 4.65 38.48 4.76L35.45 9.37C35.78 9.87 36.07 10.4 36.34 10.94C37.91 14.11 38.37 17.4 37.33 20.82C35.74 26.05 30.92 29.58 24.98 29.58C24.12 29.57 23.24 29.45 22.37 29.24L19.77 33.2C20.51 33.4 21.27 33.55 22.04 33.67C22.64 33.76 23.25 33.83 23.85 33.91H27.11C27.62 33.84 28.13 33.78 28.64 33.71C32.31 33.22 35.68 31.91 38.8 29.93C43.22 27.13 46.74 23.41 49.69 19.12C50.12 18.49 50.54 17.84 50.96 17.21V17.13C50.38 16.29 49.82 15.43 49.22 14.6ZM37.38 3.65C37.34 3.75 37.28 3.85 37.22 3.94L34.46 8.13L20.88 28.78L18.26 32.77L17.98 33.19C17.49 33.93 16.68 34.34 15.85 34.34C15.37 34.34 14.89 34.2 14.46 33.92C13.39 33.21 13.02 31.83 13.56 30.7C13.61 30.6 13.67 30.5 13.73 30.4L16.47 26.24L30.04 5.61L32.69 1.6L32.98 1.15C47 0.41 34.28 0 35.1 0C35.58 0 36.07 0.14 36.5 0.42C37.58 1.13 37.93 2.52 37.38 3.65Z"
                      fill="currentColor" />
                  </svg>
                </button>
              </div>
              <Error v-if="submitted" fieldName="password" :validationErros="validationErros" />
            </div>

            <div class="relative w-full" v-if="!isLoggedIn">
              <label class="block text-gray-900 text-base md:text-base lg:text-lg" for="password_confirmation"><br></br>
                Confirm Password
                <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <input :type="showPasswordConfirm ? 'text' : 'password'" id="password_confirmation"
                  v-model="form.password_confirmation" class="can-exp-input"
                  @input="clearErrors('password_confirmation')" @blur="checkPasswordMatch" />
                <button type="button" class="absolute right-3 top-3 text-gray-500 hover:text-gray-700"
                  @click="showPasswordConfirm = !showPasswordConfirm">
                  <svg v-if="!showPasswordConfirm" class="w-5 h-5" viewBox="0 0 51 34" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M50.96 16.7C50.96 16.72 50.96 16.75 50.96 16.77C50.54 17.41 50.13 18.05 49.69 18.68C46.74 22.97 43.22 26.69 38.8 29.49C35.68 31.46 32.31 32.77 28.64 33.26C28.13 33.33 27.62 33.39 27.11 33.46C26.02 33.46 24.94 33.46 23.85 33.46C23.25 33.38 22.64 33.31 22.04 33.22C18.47 32.67 15.19 31.35 12.15 29.41C8.16 26.86 4.89 23.57 2.08 19.78C1.36 18.82 0.69 17.78 0 16.77C0 16.75 0 16.72 0 16.7C0.07 16.61 0.15 16.52 0.21 16.42C0.93 15.36 1.62 14.27 2.39 13.24C5.23 9.44 8.57 6.16 12.65 3.69C15.69 1.85 18.96 0.64 22.5 0.2C23.07 0.13 23.64 0.07 24.21 0C25.06 0 25.91 0 26.76 0C27.25 0.05 27.74 0.1 28.22 0.16C31.57 0.58 34.7 1.67 37.63 3.35C42.33 6.06 46.07 9.81 49.23 14.17C49.82 15 50.38 15.86 50.96 16.7ZM24.98 29.15C30.92 29.15 35.74 25.62 37.33 20.39C38.37 16.97 37.92 13.67 36.34 10.51C35.58 8.98 34.69 7.57 33.14 6.66C30.6 5.17 27.94 4.24 24.96 4.37C17.99 4.68 12.67 10.59 13.12 17.56C13.3 20.43 14.37 22.98 16.03 25.3C16.26 25.62 16.55 25.92 16.87 26.15C19.42 28.02 22.25 29.12 24.98 29.15Z"
                      fill="currentColor" />
                  </svg>
                  <svg v-else class="w-5 h-5" viewBox="0 0 51 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M28.22 0.59C27.73 0.53 27.24 0.49 26.75 0.43H24.2C23.63 0.5 23.06 0.56 22.49 0.63C18.95 1.07 15.69 2.29 12.64 4.13C8.56 6.6 5.23 9.88 2.39 13.68C1.62 14.71 0.93 15.8 0.21 16.86C0.14 16.95 0.07 17.04 0 17.13V17.21C0.69 18.22 1.35 19.25 2.08 20.23C4.89 24.01 8.16 27.31 12.15 29.86C12.19 29.89 12.23 29.91 12.27 29.93C12.33 29.8 12.4 29.69 12.48 29.57L15.51 24.97C14.14 22.86 13.27 20.55 13.11 17.99C12.67 11.02 17.98 5.1 24.95 4.8C26.2 4.75 27.39 4.88 28.54 5.16L31.18 1.16C30.21 0.91 29.23 0.72 28.22 0.59ZM49.22 14.6C46.3 10.58 42.89 7.08 38.68 4.43C38.61 4.55 38.55 4.65 38.48 4.76L35.45 9.37C35.78 9.87 36.07 10.4 36.34 10.94C37.91 14.11 38.37 17.4 37.33 20.82C35.74 26.05 30.92 29.58 24.98 29.58C24.12 29.57 23.24 29.45 22.37 29.24L19.77 33.2C20.51 33.4 21.27 33.55 22.04 33.67C22.64 33.76 23.25 33.83 23.85 33.91H27.11C27.62 33.84 28.13 33.78 28.64 33.71C32.31 33.22 35.68 31.91 38.8 29.93C43.22 27.13 46.74 23.41 49.69 19.12C50.12 18.49 50.54 17.84 50.96 17.21V17.13C50.38 16.29 49.82 15.43 49.22 14.6ZM37.38 3.65C37.34 3.75 37.28 3.85 37.22 3.94L34.46 8.13L20.88 28.78L18.26 32.77L17.98 33.19C17.49 33.93 16.68 34.34 15.85 34.34C15.37 34.34 14.89 34.2 14.46 33.92C13.39 33.21 13.02 31.83 13.56 30.7C13.61 30.6 13.67 30.5 13.73 30.4L16.47 26.24L30.04 5.61L32.69 1.6L32.98 1.15C47 0.41 34.28 0 35.1 0C35.58 0 36.07 0.14 36.5 0.42C37.58 1.13 37.93 2.52 37.38 3.65Z"
                      fill="currentColor" />
                  </svg>
                </button>
              </div>
              <Error v-if="submitted" fieldName="password_confirmation" :validationErros="validationErros" />
            </div>

            <div class="relative w-full md:col-span-2">
              <label class="block text-gray-900 text-base md:text-base lg:text-lg" for="url">
                Your Website
                {{ !form.talk_to_us_first ? "" : "(Optional)" }}
              </label>
              <input type="url" id="url" v-model="form.url" class="can-exp-input" @input="clearErrors('url')" />
              <Error v-if="submitted" fieldName="url" :validationErros="validationErros" />
            </div>
          </div>
        </div>
      </div>

      <!-- COMPANY DESCRIPTION & IMAGES -->
      <div class="bg-white rounded-lg overflow-hidden shadow-3xl my-6">
        <div class="px-4 py-3 sm:px-6 text-left bg-gradient-to-r from-primary via-primary to-secondary rounded-t-md">
          <h4 class="text-white">Business Description & Media</h4>
        </div>
        <div class="p-6">
          <div class="grid grid-cols-1 gap-4">
            <div class="relative w-full">
              <label class="block text-gray-900 text-base md:text-base lg:text-lg" for="summary">
                Brief Introduction
                {{ !form.talk_to_us_first ? "(Required)" : "(Optional)" }}
                <span v-if="!form.talk_to_us_first" class="text-red-500">*</span>
              </label>
              <textarea id="summary" v-model="form.summary" rows="3" class="can-exp-input resize-none"
                placeholder="Describe the nature of your business in no more than 30 words. You can write your business slogan, company mission, or highlight your competitive advantage. This information will appear next to your company name on the search result page and will help you to attract visitors to your profile page. Make sure to describe your business in an engaging, informative way so that when the importer reads it, they will be more inclined to click on your profile page. to check out your business profile. For example, if the importer is looking for product x, from Canada, they will carry out a search on the Canadian Exports website and may come up with 20+ search results. Each one of these results will have their own short business description and the importer will click on the one that appeals to them the most. That's why your description about what you offer needs to be as eye-catching as possible to stand out from the rest of your competitors."
                @input="clearErrors('summary')"></textarea>
              <Error v-if="submitted" fieldName="summary" :validationErros="validationErros" />
            </div>

            <div class="relative w-full">
              <label class="block text-gray-900 text-base md:text-base lg:text-lg" for="detail_description">
                Detailed Description
                {{ !form.talk_to_us_first ? "(Required)" : "(Optional)" }}
                <span v-if="!form.talk_to_us_first" class="text-red-500">*</span>
              </label>
              <textarea id="detail_description" v-model="form.detail_description" rows="4"
                class="can-exp-input resize-none"
                placeholder="This is the text that will appear on your actual business profile page. Once the importer has selected YOUR company and clicked on YOUR name in the search results page, they will be taken to your business profile page. Use this space to outline what your business does and why potential customers should choose YOU. Your description should be no more than 300 words and include details about your products and services. This is your opportunity to reach potential clients, introduce them to your products, and attract further business"
                @input="clearErrors('detail_description')"></textarea>
              <Error v-if="submitted" fieldName="detail_description" :validationErros="validationErros" />
            </div>

            <div class="relative w-full">
              <label class="block text-gray-900 text-base md:text-base lg:text-lg" for="message">
                Additional Message
              </label>
              <textarea id="message" v-model="form.message" rows="3" class="can-exp-input resize-none"
                placeholder="Is there any additional information you'd like to share with us, or specific support you'd like to receive before we get in touch?"
                @input="clearErrors('message')"></textarea>
              <Error v-if="submitted" fieldName="message" :validationErros="validationErros" />
            </div>

            <!-- Featured Image Upload (appears on Home page) -->
            <div class="relative w-full">
              <label class="block text-gray-900 text-base md:text-base lg:text-lg" for="featured_image">
                Featured Image ((appears on the Home page). Allowed file types: PNG, GIF, JPG, JPEG. Max. 10MB.)
                <span class="text-red-500">*</span>
              </label>
              <FilePond @input="clearErrors('featured_image')" ref="filePondFeatured" name="featured_image"
                label-idle="<span class='cursor-pointer'>Drag & Drop your featured image or Browse</span>"
                class="cursor-pointer" accepted-file-types="image/*" max-file-size="10MB"
                @init="handleFeaturedImageInit" @processfile="handleFeaturedImageProcess"
                @removefile="handleFeaturedImageRemoveFile" :files="featured_image_path" />
              <Error v-if="submitted" fieldName="featured_image" :validationErros="validationErros" />
            </div>

            <!-- Profile Image Upload -->
            <div class="relative w-full">
              <label class="block text-gray-900 text-base md:text-base lg:text-lg" for="logo">
                Profile Image (Allowed file types: PNG, GIF, JPG, JPEG. Max. 10MB.)
                <span class="text-red-500">*</span>
              </label>
              <FilePond @input="clearErrors('logo')" ref="filePondLogo" name="logo"
                label-idle="<span class='cursor-pointer'>Drag & Drop your profile image or Browse</span>"
                class="cursor-pointer" accepted-file-types="image/*" max-file-size="10MB" @init="handleFilePondInit"
                @processfile="handleLogoProcess" @removefile="handleLogoRemoveFile" :files="logo_path" />
              <Error v-if="submitted" fieldName="logo" :validationErros="validationErros" />
            </div>
          </div>
        </div>
      </div>

      <!-- PAYMENT METHOD (Only for "Enter Your Amount" option) -->
      <div v-if="!form.talk_to_us_first && form.sponsorship_amount > 0"
        class="bg-white rounded-lg overflow-hidden shadow-3xl my-6">
        <div class="px-4 py-3 sm:px-6 text-left bg-gradient-to-r from-primary via-primary to-secondary rounded-t-md">
          <h4 class="text-white">Payment Method</h4>
        </div>
        <div class="p-6">
          <div class="flex flex-col space-y-4 md:flex-row md:space-x-4 md:space-y-0 mt-2">
            <div class="flex items-center">
              <input id="stripe" value="stripe" name="payment-method" type="radio"
                class="h-4 w-4 border-gray-300 accent-primary" @click="setPaymentMethod('stripe')"
                :checked="form.payment_method == 'stripe'" />
              <label for="stripe" class="ml-2 block text-gray-900 font-medium">
                Pay with Credit Card
              </label>
            </div>
            <div class="flex items-center">
              <input id="paypal" value="paypal" name="payment-method" type="radio"
                class="h-4 w-4 border-gray-300 accent-primary" @click="setPaymentMethod('paypal')"
                :checked="form.payment_method == 'paypal'" />
              <label for="paypal" class="ml-2 block text-gray-900 font-medium">
                <svg viewBox="0 0 157 44" fill="none" xmlns="http://www.w3.org/2000/svg"
                  class="w-16 h-16 text-[#635BFF]">
                  <g clip-path="url(#clip0_6_187)">
                    <path
                      d="M6.89999 2C7.29999 0.3 7.79999 0 9.49999 0C11.5 0 13.5 0 15.6 0C18.2 0.1 20.8 0.1 23.4 0.3C24.9 0.4 26.4 0.9 27.8 1.5C31.1 2.9 32.9 6.5 32.3 10.3C31.5 16 27.9 19.1 22.6 20.7C20.1 21.4 17.6 21.6 15 21.7C14.6 21.7 14.3 21.7 13.9 21.7C11.8 21.8 11 22.4 10.4 24.4C9.79999 26.7 9.09999 28.9 8.49999 31.2C8.19999 32.4 7.89999 32.6 6.59999 32.6C4.79999 32.6 2.99999 32.6 1.29999 32.4C0.0999947 32.3 -0.200005 31.9 0.0999947 30.7L6.89999 2ZM15.3 15.6C17 15.6 19.3 14.9 21 14.1C22.3 13.5 23 12.5 23.2 11.1C23.6 8.9 22.9 7.2 21.2 6.6C19.4 5.9 17.4 5.8 15.5 6.2C14.8 6.4 14.3 6.8 14.2 7.5C13.7 9.3 13.2 11.1 12.9 12.9C12.5 15.1 13 15.6 15.3 15.6ZM59.6 40.3C59.2 41 58.8 41.7 58.5 42.4C58.3 43 58.6 43.5 59.2 43.5C60.8 43.5 62.5 43.5 64.1 43.5C65.6 43.5 66.6 42.9 67.4 41.7C68 40.7 68.6 39.6 69.2 38.6C75.2 28.5 81.2 18.3 87.2 8.2C87.4 7.9 87.5 7.7 87.7 7.3C85.7 7.3 83.9 7.4 82 7.3C80 7.2 78.7 8.1 77.7 9.8C75.3 14 72.9 18.1 70.5 22.2C70.3 22.5 70.1 22.8 69.8 23.1C69.7 23.1 69.7 23 69.6 23C69.5 22.7 69.4 22.3 69.4 22C68.7 17.7 68 13.4 67.3 9.1C67.1 8.1 66.3 7.3 65.2 7.3C63.9 7.3 62.5 7.4 61.2 7.3C59.4 7.2 59.1 8.1 59.3 9.5L63 33.2C63.1 33.7 63 34.2 62.7 34.6L59.6 40.3ZM44.9 32.7C45.1 31.7 45.2 31 45.4 30.1C44.9 30.4 44.6 30.6 44.3 30.8C42.1 32 40 33 37.6 33.4C33.8 34 30.2 31.9 29.4 28.4C28.7 25.5 29.8 22.3 32.3 20.5C34.6 18.8 37.3 18.1 40 17.7C42.6 17.3 45.1 17 47.7 16.8C48.5 16.7 48.6 16.4 48.6 15.7C48.4 13.9 47.2 12.9 45 12.7C42.2 12.5 39.4 13.2 36.7 13.9C36.2 14 35.7 14.2 35.1 14.4C35.1 14.1 35 13.9 35 13.7C35.1 12.4 35.1 11.1 35.2 9.9C35.2 9.4 35.3 8.9 35.9 8.7C41 7.6 46.1 7 51.3 8.1C51.6 8.2 52 8.3 52.3 8.4C55.8 9.6 57 11.5 56.3 15.1C55.3 20.1 54.2 25.2 53.1 30.2C53 30.7 52.8 31.2 52.6 31.7C52.2 32.4 51.6 32.9 50.8 32.9C48.9 32.7 47 32.7 44.9 32.7ZM47.4 21C46.4 21.1 45.4 21.1 44.6 21.3C43 21.6 41.5 21.9 40 22.3C38.6 22.7 37.9 23.8 37.6 25.2C37.3 26.8 38 27.9 39.6 28.2C41.8 28.6 43.8 28 45.6 27C45.9 26.8 46.2 26.6 46.3 26.3C46.6 24.5 47 22.8 47.4 21Z"
                      fill="#162E53" />
                    <path
                      d="M91.7 1.4C92.1 0.3 92.6 0 93.7 0C95.9 0 98.1 0 100.3 0C102.9 0.1 105.5 0.1 108.1 0.3C109.6 0.5 111.1 0.9 112.5 1.5C115.7 2.8 117.5 6.3 117.1 9.9C116.5 15.3 113.1 19.2 107.3 20.6C105 21.2 102.5 21.3 100.1 21.6C99.6 21.7 99.1 21.6 98.5 21.6C96.5 21.7 95.7 22.3 95.1 24.2C94.5 26.4 93.8 28.7 93.2 30.9C92.8 32.2 92.6 32.4 91.2 32.4C89.5 32.4 87.9 32.4 86.2 32.3C84.6 32.2 84.4 31.8 84.7 30.3L91.7 1.4ZM102.3 5.9C101.7 6 100.9 6 100.2 6.2C99.7 6.4 99.2 6.8 99 7.2C98.4 9.3 97.9 11.4 97.5 13.5C97.2 15 97.7 15.4 99.2 15.5C101.4 15.6 103.5 15 105.5 14.1C107.1 13.4 107.8 12.2 108 10.5C108.2 8 107.2 6.6 104.8 6.1C104 6 103.2 6 102.3 5.9ZM119.7 14.1C119.8 13 119.8 11.9 119.9 10.8C120.1 8.3 119.8 8.7 122.3 8.2C126.2 7.4 130.1 7.1 134.1 7.6C135.2 7.7 136.4 8 137.4 8.4C140.5 9.5 141.7 11.5 141.1 14.7C140.1 19.8 138.9 24.9 137.8 30C137.7 30.5 137.5 31.1 137.2 31.5C136.8 32 136.2 32.6 135.7 32.6C133.7 32.7 131.6 32.7 129.5 32.7C129.7 31.8 129.8 31 130 30.2C129.3 30.6 128.7 31 128 31.3C125.9 32.4 123.7 33.5 121.3 33.5C117.8 33.6 115.1 31.9 114.1 29C113.1 26 114.2 22.4 116.9 20.5C119.2 18.8 121.9 18.1 124.6 17.7C127.2 17.3 129.7 17.1 132.3 16.8C132.9 16.7 133.2 16.5 133.1 15.8C133 14 131.7 12.9 129.5 12.7C126.5 12.5 123.6 13.2 120.8 14C120.5 14.1 120.2 14.2 120 14.2C120 14.2 119.9 14.1 119.7 14.1ZM132 21C131.1 21.1 130.2 21.1 129.4 21.2C127.8 21.5 126.2 21.7 124.7 22.2C123.4 22.6 122.5 23.5 122.2 24.9C121.8 26.7 122.5 27.8 124.3 28.1C126.4 28.4 128.4 27.9 130.2 26.8C130.5 26.6 130.8 26.3 130.9 25.9C131.3 24.4 131.6 22.7 132 21ZM156.3 0.1C154.3 0.1 152.5 0.1 150.6 0.1C149 0.1 148.6 0.4 148.2 2L142 30.1C141.6 31.8 141.9 32.2 143.7 32.2C144.9 32.2 146.2 32.3 147.4 32.3C148.9 32.3 149.2 32.1 149.5 30.6L156.3 0.1Z"
                      fill="#1E6196" data-v-470ebd7e=""></path>
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
                  <input v-model="form.cardholder_name" type="text" placeholder="John Doe" class="can-exp-input"
                    @input="clearErrors('cardholder_name')" />
                  <Error v-if="submitted" fieldName="cardholder_name" :validationErros="validationErros" />
                </div>

                <!-- Card Element -->
                <div class="input_text relative mb-4">
                  <label class="block text-sm font-medium text-gray-700 mb-1">Card Details</label>
                  <div id="card-element" class="p-3 border border-gray-300 rounded"></div>
                  <div id="card-errors" class="text-red-500 text-sm mt-1"></div>
                </div>
              </div>
            </div>
          </div>

          <Error v-if="submitted" fieldName="payment_method" :validationErros="validationErros" full_width="1" />
        </div>
      </div>

      <!-- SUBMIT BUTTON -->
      <ListErrors :validationErrors="validationErros" />
      <div class="mt-8 flex justify-center items-center">
        <button aria-label="Submit Sponsorship" class="button-exp-fill text-lg px-8 py-3" type="submit"
          :disabled="loading">
          <span v-if="loading" class="flex items-center">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
              </path>
            </svg>
            Processing...
          </span>
          <span v-else>
            Submit
          </span>
        </button>
      </div>
    </div>

    <!-- Loading Overlay -->
    <div v-if="loading">
      <div id="form_preloader">
        <div id="form_status">
          <div class="form_spinner">
            <div class="form-double-bounce1"></div>
            <div class="form-double-bounce2"></div>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
import Error from "../components/Error.vue";
import ListErrors from "../components/ListErrors.vue";
import axios from "axios";
import ErrorHandling from "../../ErrorHandling";
import helper from "../../helper";
import { loadStripe } from "@stripe/stripe-js";

// Import FilePond
import vueFilePond, { setOptions } from "vue-filepond";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js";
import FilePondPluginImagePreview from "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js";
import FilePondPluginFileValidateSize from "filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.esm.js";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import { VueDatePicker } from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview,
  FilePondPluginFileValidateSize
);

export default {
  name: "BecomeSponsor",
  props: ["become_sponsor", "page_id", "logged_in_user"],
  components: {
    Error,
    ListErrors,
    VueDatePicker,
    FilePond,
  },
  data() {
    return {
      form: {
        talk_to_us_first: false,
        sponsorship_amount: null,
        frequency: 'one_time',
        beneficiary_ids: [],
        payment_method: "stripe",
        company_name: "",
        contact_name: "",
        email: "",
        contact_number: "",
        password: "",
        password_confirmation: "",
        url: "",
        summary: "",
        detail_description: "",
        message: "",
        logo: null,
        featured_image: null,
        cardholder_name: "",
        payment_method_id: null,
        // Talk to Us fields
        talk_to_us_name: "",
        talk_to_us_phone: "",
        preferred_call_time: "morning",
        preferred_call_date: null,
      },
      beneficiaries: [],
      sponsorAmounts: [],
      groupedAmounts: {},
      frequencies: {},
      selectedFrequency: 'monthly',
      allBeneficiaryId: null,
      logo_path: [],
      featured_image_path: [],
      uploaded_files: {
        logo: null,
        featured_image: null,
      },
      contactNameInstruction:
        "Please include your full name and the title you would like to be addressed by, separated by a dash or hyphen. For example, John Smith - Sales Manager",
      loading: false,
      validationErros: new ErrorHandling(),
      submitted: false,
      stripe: null,
      elements: null,
      cardElement: null,
      showPassword: false,
      showPasswordConfirm: false,
    };
  },
  computed: {
    isLoggedIn() {
      return this.logged_in_user && JSON.parse(this.logged_in_user);
    }
  },
  async mounted() {
    // Pre-fill email for logged-in users
    if (this.isLoggedIn) {
      const user = JSON.parse(this.logged_in_user);
      this.form.email = user.email || '';
      this.form.contact_name = '';
    }

    this.fetchBeneficiaries();
    this.fetchSponsorAmounts();

    // Initialize Stripe Elements (same pattern as Coffee Wall)
    try {
      this.stripe = await loadStripe(process.env.MIX_STRIPE_PUBLIC_KEY);
      if (this.stripe) {
        this.elements = this.stripe.elements();
        this.cardElement = this.elements.create('card', {
          style: {
            base: {
              fontSize: '16px',
              color: '#32325d',
              fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif',
              '::placeholder': {
                color: '#aab7c4'
              }
            },
            invalid: {
              color: '#fa755a',
              iconColor: '#fa755a'
            }
          }
        });
        console.log('Stripe initialized successfully');
      }
    } catch (e) {
      console.error('Error loading Stripe:', e);
    }

    // Fix datepicker popup z-index issue
    this.fixVueDatePickerZIndex();
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
        // Remount Stripe Elements when switching to Stripe
        if (newMethod === 'stripe' && this.form.sponsorship_amount > 0) {
          this.$nextTick(() => {
            setTimeout(() => {
              this.mountStripeElement();
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
    fixVueDatePickerZIndex() {
      // Function to apply z-index fix to datepicker popup
      const applyFix = () => {
        const menus = document.querySelectorAll('.dp__outer_menu_wrap, .dp__menu, .dp__menu_transitioned');
        menus.forEach((menu) => {
          if (menu) {
            // Only set z-index, don't override position
            menu.style.setProperty('z-index', '99999', 'important');
          }
        });
      };

      // Use MutationObserver to watch for datepicker popup being added to DOM
      this.datePickerObserver = new MutationObserver(() => {
        applyFix();
      });

      // Start observing the document body for changes
      this.datePickerObserver.observe(document.body, {
        childList: true,
        subtree: true,
        attributes: true,
        attributeFilter: ['style', 'class']
      });

      // Also set it immediately if popup already exists
      this.$nextTick(() => {
        applyFix();
      });
    },
    onOptionChange(talkToUsFirst) {
      console.log("Talk to Us First option changed to:", this.form.talk_to_us_first);
      this.form.talk_to_us_first = talkToUsFirst;
      this.validationErros = new ErrorHandling();
      this.submitted = false;
      this.form.contact_preferences = !this.form.contact_preferences;
    },

    async fetchBeneficiaries() {
      try {
        const response = await axios.get(`${process.env.MIX_WEB_API_URL}get-coffee-wall-beneficiaries`);
        if (response.data.status === "Success") {
          this.beneficiaries = response.data.data;

          const allBeneficiary = this.beneficiaries.find(
            (b) => typeof b.name === 'string' && b.name.toLowerCase() === 'all'
          );
          this.allBeneficiaryId = allBeneficiary ? Number(allBeneficiary.id) : null;

          if (!Array.isArray(this.form.beneficiary_ids)) {
            this.form.beneficiary_ids = [];
          }

          if (!this.form.beneficiary_ids.length && this.allBeneficiaryId) {
            this.form.beneficiary_ids = [this.allBeneficiaryId];
          }

          this.ensureBeneficiarySelection();
        }
      } catch (error) {
        console.error("Error fetching beneficiaries:", error);
      }
    },

    async fetchSponsorAmounts() {
      try {
        const response = await axios.get(`${process.env.MIX_WEB_API_URL}get-sponsor-amounts`);
        console.log("Sponsor Amounts Response:", response.data);
        if (response.data.status === "Success") {
          this.sponsorAmounts = response.data.data.amounts || response.data.data;
          this.groupedAmounts = response.data.data.grouped || {};
          console.log("sdsdfsdfsdfdsf Sponsor Amounts:", this.groupedAmounts);
          this.frequencies = response.data.data.frequencies || {};
          //console.log("Fetched Sponsor Amounts:",this.frequencies);
          const frequencyKeys = Object.keys(this.frequencies);
          //console.log("Available Frequencies:", frequencyKeys);
          // if (frequencyKeys.length) {
          //   if (this.form.frequency && frequencyKeys.includes(this.form.frequency)) {
          //     this.selectedFrequency = this.form.frequency;
          //   } else if (frequencyKeys.includes('one_time')) {
          //     this.selectedFrequency = 'one_time';
          //     this.form.frequency = 'one_time';
          //   } else {
          //     this.selectedFrequency = frequencyKeys[0];
          //     this.form.frequency = frequencyKeys[0];
          //   }
          // }

          this.onFrequencyChange(this.selectedFrequency);
        }
      } catch (error) {
        console.error("Error fetching sponsor amounts:", error);
      }
    },

    onFrequencyChange(frequencyKey) {
      if (!frequencyKey) {
        return;
      }

      this.selectedFrequency = frequencyKey;
      this.form.frequency = frequencyKey;

      const amounts = this.getAmountsByFrequency(frequencyKey);
      console.log("Amounts for frequency", frequencyKey, amounts);
      const hasSelectedAmount = amounts.some(
        (amount) =>
          Number(amount.amount) === Number(this.form.sponsorship_amount) && amount.frequency === frequencyKey
      );

      if (!hasSelectedAmount) {
        const defaultAmount = amounts.find((amount) => amount.is_default);
        const fallbackAmount = defaultAmount || amounts[0];

        if (fallbackAmount) {
          this.form.sponsorship_amount = fallbackAmount.amount;
          this.form.frequency = fallbackAmount.frequency;
        } else {
          this.form.sponsorship_amount = null;
        }
      }

      this.clearErrors("sponsorship_amount");
    },

    updateSponsorAmount(amount) {
      this.selectedFrequency = amount.frequency;
      this.form.sponsorship_amount = amount.amount;
      this.form.frequency = amount.frequency;
      this.clearErrors("sponsorship_amount");
    },
    inputAmount(custom_amount1) {

      this.form.sponsorship_amount = custom_amount1;

      this.clearErrors("sponsorship_amount");
    },

    toggleBeneficiary(beneficiary) {
      if (!beneficiary || !beneficiary.id) {
        return;
      }

      if (!Array.isArray(this.form.beneficiary_ids)) {
        this.form.beneficiary_ids = [];
      }

      const id = Number(beneficiary.id);
      const allId = Number(this.allBeneficiaryId);

      if (allId && id === allId) {
        this.form.beneficiary_ids = [allId];
        this.clearErrors("beneficiary_ids");
        return;
      }

      const existingIndex = this.form.beneficiary_ids.findIndex(
        (selectedId) => Number(selectedId) === id
      );

      if (existingIndex > -1) {
        this.form.beneficiary_ids.splice(existingIndex, 1);
      } else {
        this.form.beneficiary_ids.push(id);
      }

      this.form.beneficiary_ids = this.form.beneficiary_ids
        .map((selectedId) => Number(selectedId))
        .filter((value, index, self) => !Number.isNaN(value) && self.indexOf(value) === index);

      this.ensureBeneficiarySelection();
      this.clearErrors("beneficiary_ids");
    },

    isBeneficiarySelected(id) {
      if (!Array.isArray(this.form.beneficiary_ids)) {
        return false;
      }

      return this.form.beneficiary_ids.map(Number).includes(Number(id));
    },

    ensureBeneficiarySelection() {
      if (!Array.isArray(this.form.beneficiary_ids)) {
        this.form.beneficiary_ids = [];
      }

      this.form.beneficiary_ids = this.form.beneficiary_ids
        .map((id) => Number(id))
        .filter((id, index, self) => !Number.isNaN(id) && self.indexOf(id) === index);

      const allId = Number(this.allBeneficiaryId);

      if (!allId) {
        return;
      }

      const hasAllSelected = this.form.beneficiary_ids.includes(allId);

      if (hasAllSelected && this.form.beneficiary_ids.length > 1) {
        this.form.beneficiary_ids = this.form.beneficiary_ids.filter((id) => id !== allId);
      }

      if (!this.form.beneficiary_ids.length) {
        this.form.beneficiary_ids = [allId];
      }
    },

    getAmountsByFrequency(frequency) {
      if (this.groupedAmounts[frequency]) {
        return this.groupedAmounts[frequency];
      }
      return [];
    },

    formatAmount(amount) {
      return new Intl.NumberFormat('en-US').format(amount);
    },

    setPaymentMethod(method) {
      this.form.payment_method = method;
      this.clearErrors("payment_method");
    },

    mountStripeElement() {
      const mountPoint = document.getElementById("card-element");

      if (!mountPoint) {
        return;
      }

      if (!this.stripe || !this.cardElement) {
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
      } catch (e) {
        console.error('Error mounting Stripe card element:', e);
        // Try recreating the element
        try {
          this.cardElement = this.elements.create('card');
          this.cardElement.mount(mountPoint);
        } catch (err) {
          console.error('Failed to create/mount card element:', err);
        }
      }
    },

    async processPayment() {
      this.submitted = true;
      this.loading = true;
      this.validationErros = new ErrorHandling();

      try {
        // Handle Stripe payment method creation (same as coffee wall)
        if (!this.form.talk_to_us_first && this.form.payment_method === "stripe" && this.form.sponsorship_amount > 0) {
          if (!this.cardElement) {
            helper.swalErrorMessageForWeb("Please enter card details");
            this.loading = false;
            return;
          }

          const { error, paymentMethod } = await this.stripe.createPaymentMethod({
            type: "card",
            card: this.cardElement,
            billing_details: {
              name: this.form.cardholder_name,
              email: this.form.email,
            },
          });

          if (error) {
            this.validationErros.record({ payment_method_id: [error.message] });
            helper.swalErrorMessageForWeb(error.message);
            this.loading = false;
            return;
          }

          // Set payment method ID for backend
          this.form.payment_method_id = paymentMethod.id;
        }

        // Prepare form data
        const formData = {
          talk_to_us_first: this.form.talk_to_us_first,
          contact_preferences: false,
          company_name: this.form.company_name,
          contact_name: this.form.contact_name,
          email: this.form.email,
          contact_number: this.form.contact_number,
          password: this.form.password,
          password_confirmation: this.form.password_confirmation,
          url: this.form.url,
          summary: this.form.summary,
          detail_description: this.form.detail_description,
          message: this.form.message,
          logo: this.uploaded_files.logo,
          featured_image: this.uploaded_files.featured_image,
          beneficiary_ids: this.form.beneficiary_ids,
        };

        if (!this.form.talk_to_us_first) {
          // Payment option
          formData.sponsorship_amount = this.form.sponsorship_amount;
          formData.frequency = this.form.frequency;
          formData.payment_method = this.form.payment_method;
          if (this.form.payment_method === "stripe") {
            formData.payment_method_id = this.form.payment_method_id;
            formData.cardholder_name = this.form.cardholder_name;
          }
        } else {
          // Talk to us option
          formData.talk_to_us_name = this.form.talk_to_us_name;
          formData.talk_to_us_phone = this.form.talk_to_us_phone;
          formData.preferred_call_time = this.form.preferred_call_time;
          formData.preferred_call_date = this.form.preferred_call_date;
        }

        const response = await axios.post(
          `${process.env.MIX_WEB_API_URL}become-sponsor/process-payment`,
          formData
        );

        if (response.data.status === "Success") {
          // Check if it's a PayPal redirect
          if (response.data.data && response.data.data.type === "paypal" && response.data.data.redirect_url) {
            // Keep loading true while redirecting to PayPal
            window.location.href = response.data.data.redirect_url;
            return;
          }

          // Success - close loading
          this.loading = false;

          // Clear form
          this.clearForm();

          // Show success message and redirect to home page when user clicks OK
          helper.swalSuccessMessageForWeb(response.data.message).then(() => {
            window.location.href = '/';
          });
        } else {
          // Error response - close loading
          this.loading = false;
          helper.swalErrorMessageForWeb(response.data.message);
        }
      } catch (error) {
        // Exception - close loading
        this.loading = false;

        if (error.response) {
          if (error.response.status === 422) {
            this.validationErros.record(error.response.data.errors);
            this.scrollToFirstError();
          } else if (error.response.data?.status === "Error") {
            helper.swalErrorMessageForWeb(error.response.data.message);
          }
        } else {
          helper.swalErrorMessageForWeb("An unexpected error occurred. Please try again.");
        }
      }
    },

    clearErrors(fieldName) {
      if (this.submitted) {
        this.validationErros.clear(fieldName);
      }
    },

    checkPasswordMatch() {
      if (this.form.password && this.form.password_confirmation) {
        if (this.form.password !== this.form.password_confirmation) {
          this.validationErros.record({
            password_confirmation: ["Passwords do not match"]
          });
        } else {
          this.validationErros.clear("password_confirmation");
        }
      }
    },

    clearForm() {
      this.form = {
        talk_to_us_first: false,
        sponsorship_amount: null,
        frequency: 'one_time',
        beneficiary_ids: [],
        payment_method: "stripe",
        company_name: "",
        contact_name: "",
        email: "",
        contact_number: "",
        password: "",
        password_confirmation: "",
        url: "",
        summary: "",
        detail_description: "",
        message: "",
        logo: null,
        featured_image: null,
        cardholder_name: "",
        payment_method_id: null,
        talk_to_us_name: "",
        talk_to_us_phone: "",
        preferred_call_time: "morning",
        preferred_call_date: null,
      };

      this.showPassword = false;
      this.showPasswordConfirm = false;

      this.uploaded_files = {
        logo: null,
        featured_image: null,
      };

      if (this.$refs.filePondLogo) this.$refs.filePondLogo.removeFiles();
      if (this.$refs.filePondFeatured) this.$refs.filePondFeatured.removeFiles();

      this.validationErros = new ErrorHandling();
      this.submitted = false;

      // Reset Stripe card element
      if (this.cardElement) {
        this.cardElement.clear();
      }

      this.selectedFrequency = this.form.frequency;
      this.ensureBeneficiarySelection();
      this.onFrequencyChange(this.selectedFrequency);
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

    getMinDate() {
      const tomorrow = new Date();
      tomorrow.setDate(tomorrow.getDate() + 1);
      return tomorrow.toISOString().split("T")[0];
    },

    // FilePond handlers for Logo (Profile Image)
    handleFilePondInit() {
      setOptions({
        credits: false,
        server: {
          url: process.env.MIX_APP_URL,
          process: (
            fieldName,
            file,
            metadata,
            load,
            error,
            progress,
            abort,
            transfer,
            options
          ) => {
            const formData = new FormData();
            formData.append("media", file, file.name);
            formData.append("is_temp_media", 1);
            formData.append("type", "logo");

            const request = new XMLHttpRequest();
            request.open("POST", `${process.env.MIX_APP_URL}/media/process`);
            request.setRequestHeader(
              "X-CSRF-TOKEN",
              document.head.querySelector('meta[name="csrf-token"]').content
            );

            request.upload.onprogress = (e) => {
              progress(e.lengthComputable, e.loaded, e.total);
            };
            request.onload = function () {
              if (request.status >= 200 && request.status < 300) {
                load(request.responseText);
              } else {
                error("oh no");
              }
            };

            request.send(formData);

            return {
              abort: () => {
                request.abort();
                abort();
              },
            };
          },
          revert: (uniqueFileId, load, error) => {
            const formData = new FormData();
            formData.append("media", uniqueFileId);

            const request = new XMLHttpRequest();
            request.open("POST", `${process.env.MIX_APP_URL}/media/revert`);
            request.setRequestHeader(
              "X-CSRF-TOKEN",
              document.head.querySelector('meta[name="csrf-token"]').content
            );

            request.send(formData);

            return {
              abort: () => {
                request.abort();
                abort();
              },
            };
          },
          headers: {
            "X-CSRF-TOKEN": document.head.querySelector(
              'meta[name="csrf-token"]'
            ).content,
          },
        },
      });
    },

    handleLogoProcess(error, file) {
      if (!error) {
        this.uploaded_files.logo = file.serverId;
      }
    },

    handleLogoRemoveFile() {
      this.uploaded_files.logo = null;
    },

    // FilePond handlers for Featured Image
    handleFeaturedImageInit() {
      setOptions({
        credits: false,
        server: {
          url: process.env.MIX_APP_URL,
          process: (
            fieldName,
            file,
            metadata,
            load,
            error,
            progress,
            abort,
            transfer,
            options
          ) => {
            const formData = new FormData();
            formData.append("media", file, file.name);
            formData.append("is_temp_media", 1);
            formData.append("type", "logo");

            const request = new XMLHttpRequest();
            request.open("POST", `${process.env.MIX_APP_URL}/media/process`);
            request.setRequestHeader(
              "X-CSRF-TOKEN",
              document.head.querySelector('meta[name="csrf-token"]').content
            );

            request.upload.onprogress = (e) => {
              progress(e.lengthComputable, e.loaded, e.total);
            };
            request.onload = function () {
              if (request.status >= 200 && request.status < 300) {
                load(request.responseText);
              } else {
                error("oh no");
              }
            };

            request.send(formData);

            return {
              abort: () => {
                request.abort();
                abort();
              },
            };
          },
          revert: (uniqueFileId, load, error) => {
            const formData = new FormData();
            formData.append("media", uniqueFileId);

            const request = new XMLHttpRequest();
            request.open("POST", `${process.env.MIX_APP_URL}/media/revert`);
            request.setRequestHeader(
              "X-CSRF-TOKEN",
              document.head.querySelector('meta[name="csrf-token"]').content
            );

            request.send(formData);

            return {
              abort: () => {
                request.abort();
                abort();
              },
            };
          },
          headers: {
            "X-CSRF-TOKEN": document.head.querySelector(
              'meta[name="csrf-token"]'
            ).content,
          },
        },
      });
    },

    handleFeaturedImageProcess(error, file) {
      if (!error) {
        this.uploaded_files.featured_image = file.serverId;
      }
    },

    handleFeaturedImageRemoveFile() {
      this.uploaded_files.featured_image = null;
    },
  },
  created() {
    // Initialize Stripe Elements (same pattern as coffee wall)
    (async () => {
      try {
        this.stripe = await loadStripe(process.env.MIX_STRIPE_PUBLIC_KEY);
        if (this.stripe) {
          this.elements = this.stripe.elements();
          this.cardElement = this.elements.create('card');

          // Try to mount immediately if DOM is ready
          this.$nextTick(() => {
            setTimeout(() => {
              this.mountStripeElement();
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
  beforeUnmount() {
    // Clean up the MutationObserver when component is destroyed
    if (this.datePickerObserver) {
      this.datePickerObserver.disconnect();
      this.datePickerObserver = null;
    }
  },
};
</script>

<style scoped>
/* Loading overlay styles */
#form_preloader {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 9999;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
}

#form_status {
  width: 200px;
  height: 200px;
  position: relative;
}

.form_spinner {
  width: 60px;
  height: 60px;
  position: relative;
  margin: 70px auto;
}

.form-double-bounce1,
.form-double-bounce2 {
  width: 100%;
  height: 100%;
  border-radius: 50%;
  background-color: #fff;
  opacity: 0.6;
  position: absolute;
  top: 0;
  left: 0;
  animation: sk-bounce 2s infinite ease-in-out;
}

.form-double-bounce2 {
  animation-delay: -1s;
}

@keyframes sk-bounce {

  0%,
  100% {
    transform: scale(0);
  }

  50% {
    transform: scale(1);
  }
}
</style>
<style>
/* @vuepic/vue-datepicker popup z-index fix - needs to be global */
.dp__outer_menu_wrap {
  z-index: 99999 !important;
}

.dp__input {
  font-size: 1.125rem;
  line-height: 1.75rem;
}

.dp__menu {
  z-index: 99999 !important;
}

.dp__menu_transitioned {
  z-index: 99999 !important;
}

/* Ensure popup is above all grid elements and form containers */
body>.dp__outer_menu_wrap {
  z-index: 99999 !important;
}
</style>
