<template>
  <div class="bg-white rounded-lg shadow-lg p-6 md:p-8">

    <!-- Profile status + View public profile (one line, badge/button style) -->
    <div v-if="sponsor" class="flex flex-wrap items-center gap-3 mb-6">
      <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-gray-200 bg-gray-50/80 text-sm text-gray-700 font-FuturaMdCnBT">
        Your Profile Status:
        <span class="inline-flex items-center gap-1.5">
          <span class="w-2 h-2 rounded-full shrink-0" :class="sponsor.status === 'active' ? 'bg-green-500' : 'bg-gray-400'"></span>
          {{ sponsor.status === 'active' ? 'Live' : (sponsor.status === 'pending' ? 'Pending' : 'Draft') }}
        </span>
      </span>
      <a :href="publicProfileUrl" target="_blank" rel="noopener noreferrer"
        class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-primary/40 bg-primary/5 text-primary text-sm font-FuturaMdCnBT hover:bg-primary/10 hover:border-primary/60 transition-colors">
        View Public Profile
      </a>
    </div>

    <!-- Sponsorship Status Card -->
    <div v-if="sponsor"
      class="bg-gradient-to-r from-blue-50 to-primary/10 border border-primary/30 rounded-lg p-6 mb-6">
      <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
          <h3 class="text-lg font-semibold text-gray-800">Sponsorship Status</h3>
          <div class="flex items-center gap-3 mt-2">
            <span class="px-3 py-1 rounded-full text-sm font-medium" :class="{
              'bg-green-100 text-green-800': sponsor.status === 'active',
              'bg-yellow-100 text-yellow-800': sponsor.status === 'pending',
              'bg-gray-100 text-gray-800': sponsor.status === 'inactive',
            }">
              {{ sponsor.status === 'active' ? '✓ Active' : sponsor.status === 'pending' ? '⏳ Pending' : 'Inactive' }}
            </span>
            <span v-if="sponsor.payment_status" class="px-3 py-1 rounded-full text-sm font-medium" :class="{
              'bg-green-100 text-green-800': sponsor.payment_status === 'paid',
              'bg-yellow-100 text-yellow-800': sponsor.payment_status === 'pending',
              'bg-blue-100 text-blue-800': sponsor.payment_status === 'not_required',
            }">
              {{ sponsor.payment_status === 'paid' ? '💳 Paid' : sponsor.payment_status === 'pending' ? 'Payment              Pending' : 'Contact Request' }}
            </span>
          </div>
        </div>
        <div v-if="sponsor.sponsorship_amount" class="text-right">
          <p class="text-sm text-gray-600">Sponsorship Amount</p>
          <p class="text-2xl font-bold text-primary">${{ parseFloat(sponsor.sponsorship_amount).toFixed(2) }}</p>
          <p v-if="sponsor.paid_at" class="text-xs text-gray-500 mt-1">
            Paid on {{ formatDate(sponsor.paid_at) }}
          </p>
        </div>
      </div>

      <!-- Payment Info (Read-only) -->
      <div v-if="sponsor.payment_status === 'paid'" class="mt-4 pt-4 border-t border-primary/20">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
          <div>
            <span class="text-gray-600">Payment Method:</span>
            <span class="ml-2 font-medium capitalize">
              {{ getPaymentMethodDisplay(sponsor.payment_method) }}
            </span>
          </div>
          <div v-if="sponsor.beneficiary">
            <span class="text-gray-600">Beneficiary:</span>
            <span class="ml-2 font-medium">{{ sponsor.beneficiary.name }}</span>
          </div>
        </div>
      </div>

      <!-- Upgrade plan (only for recurring Stripe subscriptions) -->
      <div v-if="canUpgradePlan" class="mt-4 pt-4 border-t border-primary/20">
        <p class="text-sm text-gray-600 mb-2">Upgrade your plan mid-cycle: we’ll apply unused time from your current plan as credit toward the new one.</p>
        <button type="button" @click="openUpgradeModal"
          class="px-4 py-2 rounded-md bg-primary text-white text-sm font-medium hover:opacity-90 transition-opacity">
          Upgrade plan
        </button>
      </div>
    </div>

    <!-- Edit Form -->
    <form @submit.prevent="updateProfile">
      <!-- Company Information -->
      <div class="bg-white rounded-lg overflow-hidden shadow-3xl my-6">
        <div class="px-4 py-3 sm:px-6 text-left bg-gradient-to-r from-primary via-primary to-secondary rounded-t-md">
          <h4 class="text-white">Company Information</h4>
        </div>
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2" for="company_name">
                Company Name <span class="text-red-500">*</span>
              </label>
              <input type="text" id="company_name" v-model="form.company_name" class="can-exp-input"
                placeholder="Your Company Inc." @input="clearErrors('company_name')" />
              <Error v-if="submitted" fieldName="company_name" :validationErros="validationErros" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2" for="contact_name">
                Contact Person <span class="text-red-500">*</span>
              </label>
              <input type="text" id="contact_name" v-model="form.contact_name" class="can-exp-input"
                placeholder="John Doe" @input="clearErrors('contact_name')" />
              <Error v-if="submitted" fieldName="contact_name" :validationErros="validationErros" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2" for="email">
                Email Address <span class="text-red-500">*</span>
              </label>
              <input type="email" id="email" v-model="form.email" class="can-exp-input" placeholder="john@company.com"
                @input="clearErrors('email')" />
              <Error v-if="submitted" fieldName="email" :validationErros="validationErros" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2" for="contact_number">
                Contact Number <span class="text-red-500">*</span>
              </label>
              <input type="text" id="contact_number" v-model="form.contact_number" class="can-exp-input"
                placeholder="15551234567" maxlength="15" @input="handlePhoneInput('contact_number')"
                @keypress="validatePhoneKeypress" />
              <Error v-if="submitted" fieldName="contact_number" :validationErros="validationErros" />
            </div>

            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-700 mb-2" for="url">
                Company Website
              </label>
              <input type="url" id="url" v-model="form.url" class="can-exp-input"
                placeholder="https://www.yourcompany.com" @input="clearErrors('url')" />
              <Error v-if="submitted" fieldName="url" :validationErros="validationErros" />
            </div>
          </div>
        </div>
      </div>

      <!-- Company Description -->
      <div class="bg-white rounded-lg overflow-hidden shadow-3xl my-6">
        <div class="px-4 py-3 sm:px-6 text-left bg-gradient-to-r from-primary via-primary to-secondary rounded-t-md">
          <h4 class="text-white">Company Description</h4>
        </div>
        <div class="p-6">
          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2" for="summary">
                Brief Description <span class="text-red-500">*</span>
              </label>
              <textarea id="summary" v-model="form.summary" rows="3" class="can-exp-input resize-none"
                placeholder="A brief overview of your company..." @input="clearErrors('summary')"></textarea>
              <Error v-if="submitted" fieldName="summary" :validationErros="validationErros" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2" for="detail_description">
                Detailed Description <span class="text-red-500">*</span>
              </label>
              <textarea id="detail_description" v-model="form.detail_description" rows="5"
                class="can-exp-input resize-none"
                placeholder="Tell us more about your company, products, and services..."
                @input="clearErrors('detail_description')"></textarea>
              <Error v-if="submitted" fieldName="detail_description" :validationErros="validationErros" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2" for="message">
                Additional Message
              </label>
              <textarea id="message" v-model="form.message" rows="3" class="can-exp-input resize-none"
                placeholder="Any additional information..." @input="clearErrors('message')"></textarea>
              <Error v-if="submitted" fieldName="message" :validationErros="validationErros" />
            </div>
          </div>
        </div>
      </div>

      <!-- Company Media -->
      <div class="bg-white rounded-lg overflow-hidden shadow-3xl my-6">
        <div class="px-4 py-3 sm:px-6 text-left bg-gradient-to-r from-primary via-primary to-secondary rounded-t-md">
          <h4 class="text-white">Company Media</h4>
        </div>
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Logo -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Company Logo
                <span class="text-xs text-gray-500">(Max 10MB, PNG/JPG/JPEG/GIF)</span>
              </label>

              <!-- Current Logo Preview -->
              <div v-if="sponsor && sponsor.logo_media && !form.logo" class="mb-3">
                <p class="text-xs text-gray-500 mb-2">Current Logo:</p>
                <div class="relative inline-block">
                  <img :src="`/${sponsor.logo_media.path}`" alt="Current Logo"
                    class="w-32 h-32 object-contain border rounded" />
                  <button type="button" @click="removeLogo"
                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">
                    ×
                  </button>
                </div>
              </div>

              <FilePond ref="filePondLogo" name="logo"
                label-idle="<span class='cursor-pointer'>Drag & Drop your logo or Browse</span>"
                accepted-file-types="image/*" max-file-size="10MB" @init="handleLogoInit"
                @processfile="handleLogoProcess" @removefile="handleLogoRemove" :files="logo_files" />
              <Error v-if="submitted" fieldName="logo" :validationErros="validationErros" />
            </div>

            <!-- Featured Image -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Featured Image
                <span class="text-xs text-gray-500">(Max 10MB, PNG/JPG/JPEG/GIF)</span>
              </label>

              <!-- Current Featured Image Preview -->
              <div v-if="sponsor && sponsor.featured_media && !form.featured_image" class="mb-3">
                <p class="text-xs text-gray-500 mb-2">Current Featured Image:</p>
                <div class="relative inline-block">
                  <img :src="`/${sponsor.featured_media.path}`" alt="Current Featured Image"
                    class="w-32 h-32 object-cover border rounded" />
                  <button type="button" @click="removeFeaturedImage"
                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">
                    ×
                  </button>
                </div>
              </div>

              <FilePond ref="filePondFeatured" name="featured_image"
                label-idle="<span class='cursor-pointer'>Drag & Drop your featured image or Browse</span>"
                accepted-file-types="image/*" max-file-size="10MB" @init="handleFeaturedImageInit"
                @processfile="handleFeaturedImageProcess" @removefile="handleFeaturedImageRemove"
                :files="featured_image_files" />
              <Error v-if="submitted" fieldName="featured_image" :validationErros="validationErros" />
            </div>
          </div>
        </div>
      </div>

      <!-- Your Password -->
      <div class="bg-white rounded-lg overflow-hidden shadow-3xl my-6">
        <div class="px-4 py-3 sm:px-6 text-left bg-gradient-to-r from-primary via-primary to-secondary rounded-t-md">
          <h4 class="text-white">Your Password</h4>
        </div>
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
              <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="current_password">
                Current Password
              </label>
              <div class="relative">
                <input :type="showCurrentPassword ? 'text' : 'password'" id="current_password"
                  v-model="form.current_password" class="can-exp-input" 
                  @input="clearErrors('current_password')" />
                <button type="button" class="absolute right-3 top-3 text-gray-500 hover:text-gray-700"
                  @click="showCurrentPassword = !showCurrentPassword">
                  <svg v-if="!showCurrentPassword" class="w-5 h-5" viewBox="0 0 51 34" fill="none"
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
              <Error v-if="submitted" fieldName="current_password" :validationErros="validationErros" />
            </div>

            <div>
              <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="new_password">
                New Password
              </label>
              <div class="relative">
                <input :type="showNewPassword ? 'text' : 'password'" id="new_password" v-model="form.new_password"
                  class="can-exp-input"  @input="clearErrors('new_password')" />
                <button type="button" class="absolute right-3 top-3 text-gray-500 hover:text-gray-700"
                  @click="showNewPassword = !showNewPassword">
                  <svg v-if="!showNewPassword" class="w-5 h-5" viewBox="0 0 51 34" fill="none"
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
              <Error v-if="submitted" fieldName="new_password" :validationErros="validationErros" />
            </div>

            <div>
              <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="new_password_confirmation">
                Confirm New Password
              </label>
              <div class="relative">
                <input :type="showNewPasswordConfirm ? 'text' : 'password'" id="new_password_confirmation"
                  v-model="form.new_password_confirmation" class="can-exp-input" 
                  @input="clearErrors('new_password_confirmation')" @blur="checkNewPasswordMatch" />
                <button type="button" class="absolute right-3 top-3 text-gray-500 hover:text-gray-700"
                  @click="showNewPasswordConfirm = !showNewPasswordConfirm">
                  <svg v-if="!showNewPasswordConfirm" class="w-5 h-5" viewBox="0 0 51 34" fill="none"
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
              <Error v-if="submitted" fieldName="new_password_confirmation" :validationErros="validationErros" />
            </div>
          </div>
          <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-md">
            <p class="text-sm text-blue-800">
              <strong>Note: </strong>Leave these fields blank to keep your current password. Only enter a new password if you wish to update it.
            </p>
          </div>
        </div>
      </div>

      <!-- Form Actions -->
      <div class="flex flex-col sm:flex-row gap-3 justify-center">
        <button type="button" @click="resetForm"
          class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-opacity duration-200"
          :class="{ 'opacity-50': !formDirty }"
          :disabled="loading">
          Reset Changes
        </button>
        <button type="submit" class="button-exp-fill transition-opacity duration-200" :class="{ 'opacity-50': !formDirty }"
          :disabled="loading">
          <span v-if="loading" class="flex items-center justify-center">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
              </path>
            </svg>
            Updating...
          </span>
          <span v-else>
            Update Profile
          </span>
        </button>
      </div>
    </form>

    <!-- Upgrade plan modal -->
    <div v-if="upgradeModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" @click.self="closeUpgradeModal">
      <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">Upgrade your sponsorship plan</h3>
          <p class="text-sm text-gray-600 mb-4">Your unused time on the current plan will be applied as credit. You pay: New plan price − credit.</p>

          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">New amount per period ($)</label>
              <input v-model.number="upgradeForm.new_amount" type="number" min="1" step="0.01" class="can-exp-input w-full"
                placeholder="e.g. 500" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">New billing frequency</label>
              <select v-model="upgradeForm.new_frequency" class="can-exp-input w-full">
                <option value="monthly">Monthly</option>
                <option value="quarterly">Quarterly</option>
                <option value="annually">Annually</option>
              </select>
            </div>
            <button type="button" @click="loadUpgradePreview" :disabled="upgradePreviewLoading || !upgradeForm.new_amount"
              class="w-full px-4 py-2 rounded-md border border-primary text-primary text-sm font-medium hover:bg-primary hover:text-white transition-colors">
              {{ upgradePreviewLoading ? 'Loading...' : 'See upgrade cost' }}
            </button>

            <div v-if="upgradePreview" class="p-4 bg-gray-50 rounded-md space-y-2 text-sm">
              <p><span class="text-gray-600">Unused credit from current plan:</span> <strong>${{ upgradePreview.unused_credit.toFixed(2) }}</strong></p>
              <p><span class="text-gray-600">New plan price:</span> <strong>${{ upgradePreview.new_plan_price.toFixed(2) }}</strong></p>
              <p v-if="!upgradePreview.is_downgrade" class="pt-2 border-t border-gray-200"><span class="text-gray-600">Amount due today:</span> <strong class="text-primary">${{ upgradePreview.amount_due_today.toFixed(2) }}</strong></p>
            </div>

            <!-- Downgrade: tooltip and submit request (no payment) -->
            <div v-if="upgradePreview && upgradePreview.is_downgrade" class="p-4 bg-amber-50 border border-amber-200 rounded-md">
              <p class="text-sm text-amber-800" title="Your downgrade will take effect at the end of your current billing period. If you need an immediate downgrade, please contact support.">
                Your downgrade will take effect at the end of your current billing period. If you need an immediate downgrade, please contact support.
              </p>
            </div>

            <!-- Upgrade: card and confirm pay -->
            <template v-if="upgradePreview && !upgradePreview.is_downgrade">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cardholder name</label>
                <input v-model="upgradeForm.cardholder_name" type="text" class="can-exp-input w-full" placeholder="John Doe" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Card details</label>
                <div ref="upgradeStripeCard" class="can-exp-input min-h-[40px]"></div>
                <p v-if="upgradePreview.amount_due_today === 0" class="text-xs text-gray-500 mt-1">Your credit covers this upgrade; card will be used for future renewals.</p>
              </div>
            </template>
          </div>

          <div class="flex gap-3 mt-6">
            <button type="button" @click="closeUpgradeModal"
              class="flex-1 px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Cancel</button>
            <button v-if="upgradePreview && upgradePreview.is_downgrade" type="button" @click="submitDowngradeRequest" :disabled="upgradeSubmitting"
              class="flex-1 px-4 py-2 rounded-md bg-primary text-white font-medium hover:opacity-90 disabled:opacity-50">
              {{ upgradeSubmitting ? 'Submitting...' : 'Submit downgrade request' }}
            </button>
            <button v-else-if="upgradePreview" type="button" @click="confirmUpgrade" :disabled="upgradeSubmitting || !upgradeForm.cardholder_name"
              class="flex-1 px-4 py-2 rounded-md bg-primary text-white font-medium hover:opacity-90 disabled:opacity-50">
              {{ upgradeSubmitting ? 'Processing...' : (upgradePreview.amount_due_today > 0 ? 'Confirm and pay' : 'Confirm upgrade') }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Loading Overlay -->
    <div v-if="loading" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6">
        <div class="flex items-center space-x-3">
          <svg class="animate-spin h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
            </path>
          </svg>
          <span class="text-lg font-medium">Processing...</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Error from "../components/Error.vue";
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

const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview,
  FilePondPluginFileValidateSize
);

export default {
  name: "SponsorProfileEdit",
  props: {
    sponsorshipId: {
      type: [String, Number],
      default: null
    }
  },
  components: {
    Error,
    FilePond,
  },
  data() {
    return {
      sponsor: null,
      form: {
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
        remove_logo: false,
        remove_featured_image: false,
        current_password: "",
        new_password: "",
        new_password_confirmation: "",
      },
      logo_files: [],
      featured_image_files: [],
      loading: false,
      formDirty: false,
      _skipDirtyCheck: false,
      validationErros: new ErrorHandling(),
      submitted: false,
      showCurrentPassword: false,
      showNewPassword: false,
      showNewPasswordConfirm: false,
      // Upgrade plan modal
      upgradeModalOpen: false,
      upgradePreview: null,
      upgradeForm: {
        new_amount: null,
        new_frequency: "monthly",
        cardholder_name: "",
        payment_method_id: null,
      },
      upgradePreviewLoading: false,
      upgradeSubmitting: false,
      stripe: null,
      stripeElements: null,
      stripeCardElement: null,
    };
  },
  mounted() {
    this.fetchSponsorProfile();
  },
  computed: {
    publicProfileUrl() {
      if (!this.sponsor || !this.sponsor.slug) return "#";
      const path = window.location.pathname || "";
      const langMatch = path.match(/^\/([a-z]{2})(?:\/|$)/);
      const langAbbr = langMatch ? langMatch[1] : "en";
      const base = process.env.MIX_APP_URL || "";
      return `${base}/${langAbbr}/sponsor-detail/${this.sponsor.slug}`;
    },
    canUpgradePlan() {
      if (!this.sponsor) return false;
      const freq = this.sponsor.frequency;
      const hasRecurring = freq === "monthly" || freq === "quarterly" || freq === "annually";
      return !!(this.sponsor.stripe_subscription_id && hasRecurring && this.sponsor.payment_status === "paid");
    },
  },
  watch: {
    form: {
      deep: true,
      handler() {
        if (!this._skipDirtyCheck) this.formDirty = true;
      },
    },
  },
  methods: {
    async fetchSponsorProfile() {
      this.loading = true;
      try {
        let url;
        if (this.sponsorshipId) {
          // Fetch specific sponsorship by ID
          url = `${process.env.MIX_WEB_API_URL}sponsor/profile/${this.sponsorshipId}`;
        } else {
          // Fetch first/default sponsorship (backward compatibility)
          url = `${process.env.MIX_WEB_API_URL}sponsor/profile`;
        }

        const response = await axios.get(url);
        if (response.data.status === "Success") {
          // Handle both single object and array responses
          if (Array.isArray(response.data.data)) {
            // If no specific ID and got array, use first one
            this.sponsor = response.data.data[0];
          } else {
            this.sponsor = response.data.data;
          }

          if (this.sponsor) {
            this.populateForm();
          } else {
            helper.swalErrorMessageForWeb("No sponsor profile found.");
          }
        } else {
          helper.swalErrorMessageForWeb("Unable to load sponsor profile");
        }
      } catch (error) {
        console.error("Error fetching sponsor profile:", error);
        if (error.response && error.response.status === 404) {
          helper.swalErrorMessageForWeb("No sponsor profile found. Please contact support.");
        } else {
          helper.swalErrorMessageForWeb("Error loading profile. Please try again.");
        }
      } finally {
        this.loading = false;
      }
    },

    populateForm() {
      if (this.sponsor) {
        this._skipDirtyCheck = true;
        this.form.company_name = this.sponsor.business_name || "";
        this.form.contact_name = this.sponsor.contact_name || "";
        this.form.email = this.sponsor.email || "";
        this.form.contact_number = this.sponsor.contact_number || "";
        this.form.url = this.sponsor.url || "";
        this.form.summary = this.sponsor.summary || "";
        this.form.detail_description = this.sponsor.detail_description || "";
        this.form.message = this.sponsor.message || "";
        this.$nextTick(() => {
          this._skipDirtyCheck = false;
          this.formDirty = false;
        });
      }
    },

    async updateProfile() {
      this.submitted = true;
      this.loading = true;
      this.validationErros = new ErrorHandling();

      try {
        const formData = {
          id: this.sponsor.id,
          company_name: this.form.company_name,
          contact_name: this.form.contact_name,
          email: this.form.email,
          contact_number: this.form.contact_number,
          url: this.form.url,
          summary: this.form.summary,
          detail_description: this.form.detail_description,
          message: this.form.message,
          logo: this.form.logo,
          featured_image: this.form.featured_image,
          remove_logo: this.form.remove_logo,
          remove_featured_image: this.form.remove_featured_image,
        };

        // Only include password fields if they are filled
        if (this.form.current_password || this.form.new_password || this.form.new_password_confirmation) {
          formData.current_password = this.form.current_password;
          formData.new_password = this.form.new_password;
          formData.new_password_confirmation = this.form.new_password_confirmation;
        }

        const response = await axios.post(
          `${process.env.MIX_WEB_API_URL}sponsor/update-profile`,
          formData
        );

        if (response.data.status === "Success") {
          helper.swalSuccessMessageForWeb(response.data.message || "Profile updated successfully!");
          await this.fetchSponsorProfile(); // Refresh the data
          this.form.logo = null;
          this.form.featured_image = null;
          this.form.remove_logo = false;
          this.form.remove_featured_image = false;
        } else {
          helper.swalErrorMessageForWeb(response.data.message || "Failed to update profile");
        }
      } catch (error) {
        if (error.response) {
          if (error.response.status === 422) {
            this.validationErros.record(error.response.data.errors);
          } else if (error.response.data?.status === "Error") {
            helper.swalErrorMessageForWeb(error.response.data.message);
          } else {
            helper.swalErrorMessageForWeb("An error occurred. Please try again.");
          }
        } else {
          helper.swalErrorMessageForWeb("Network error. Please check your connection.");
        }
      } finally {
        this.loading = false;
      }
    },

    resetForm() {
      this.populateForm();
      this.form.logo = null;
      this.form.featured_image = null;
      this.form.remove_logo = false;
      this.form.remove_featured_image = false;
      this.form.current_password = "";
      this.form.new_password = "";
      this.form.new_password_confirmation = "";
      if (this.$refs.filePondLogo) this.$refs.filePondLogo.removeFiles();
      if (this.$refs.filePondFeatured) this.$refs.filePondFeatured.removeFiles();
      this.validationErros = new ErrorHandling();
      this.submitted = false;
      this.showCurrentPassword = false;
      this.showNewPassword = false;
      this.showNewPasswordConfirm = false;
    },

    removeLogo() {
      this.form.remove_logo = true;
      this.sponsor.logo_media = null;
    },

    removeFeaturedImage() {
      this.form.remove_featured_image = true;
      this.sponsor.featured_media = null;
    },

    clearErrors(fieldName) {
      if (this.submitted) {
        this.validationErros.clear(fieldName);
      }
    },

    formatDate(date) {
      if (!date) return "N/A";
      return new Date(date).toLocaleDateString("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric",
      });
    },

    // FilePond Logo handlers
    handleLogoInit() {
      setOptions({
        credits: false,
        server: {
          url: process.env.MIX_ADMIN_API_URL,
          process: "/media/process",
          revert: "/media/revert",
          headers: {
            "X-CSRF-TOKEN": document.head.querySelector('meta[name="csrf-token"]').content,
          },
        },
      });
    },

    handleLogoProcess(error, file) {
      if (!error) {
        this.form.logo = file.serverId;
        this.form.remove_logo = false;
      }
    },

    handleLogoRemove() {
      this.form.logo = null;
    },

    // FilePond Featured Image handlers
    handleFeaturedImageInit() {
      setOptions({
        credits: false,
        server: {
          url: process.env.MIX_ADMIN_API_URL,
          process: "/media/process",
          revert: "/media/revert",
          headers: {
            "X-CSRF-TOKEN": document.head.querySelector('meta[name="csrf-token"]').content,
          },
        },
      });
    },

    handleFeaturedImageProcess(error, file) {
      if (!error) {
        this.form.featured_image = file.serverId;
        this.form.remove_featured_image = false;
      }
    },

    handleFeaturedImageRemove() {
      this.form.featured_image = null;
    },

    checkNewPasswordMatch() {
      if (this.form.new_password && this.form.new_password_confirmation) {
        if (this.form.new_password !== this.form.new_password_confirmation) {
          this.validationErros.record({
            new_password_confirmation: ["Passwords do not match"]
          });
        } else {
          this.validationErros.clear("new_password_confirmation");
        }
      }
    },

    getPaymentMethodDisplay(paymentMethod) {
      if (!paymentMethod) {
        return 'Credit Card'; // Default to Credit Card for backward compatibility
      }

      // Handle different payment method formats
      const method = paymentMethod.toLowerCase();

      if (method === 'stripe' || method.includes('stripe')) {
        return 'Credit Card (Stripe)';
      } else if (method === 'paypal' || method.includes('paypal')) {
        return 'PayPal';
      } else if (method === 'card' || method === 'credit_card') {
        return 'Credit Card';
      }

      // Capitalize first letter for any other method
      return paymentMethod.charAt(0).toUpperCase() + paymentMethod.slice(1);
    },
    handlePhoneInput(fieldName) {
      // Remove any characters that aren't + or numbers
      let cleanValue = this.form[fieldName].replace(/[^0-9+]/g, '');

      // Limit to 15 characters
      if (cleanValue.length > 15) {
        cleanValue = cleanValue.substring(0, 15);
      }

      this.form[fieldName] = cleanValue;
      this.clearErrors(fieldName);
    },

    validatePhoneKeypress(event) {
      const char = event.key;
      const input = event.target;
      const value = input.value || '';

      // Allow: backspace, delete, tab, escape, enter (navigation keys)
      if (
        event.key === 'Backspace' ||
        event.key === 'Delete' ||
        event.key === 'Tab' ||
        event.key === 'Escape' ||
        event.key === 'Enter' ||
        event.key === 'ArrowLeft' ||
        event.key === 'ArrowRight'
      ) {
        return;
      }

      // Check if already at 15 character limit
      if (value.length >= 15) {
        event.preventDefault();
        return;
      }

      // Allow + or numbers (0-9)
      if (char !== '+' && !/^[0-9]$/.test(char)) {
        event.preventDefault();
      }
    },

    async openUpgradeModal() {
      this.upgradeModalOpen = true;
      this.upgradePreview = null;
      this.upgradeForm.new_amount = this.sponsor.sponsorship_amount ? parseFloat(this.sponsor.sponsorship_amount) : null;
      this.upgradeForm.new_frequency = this.sponsor.frequency || "monthly";
      this.upgradeForm.cardholder_name = this.sponsor.contact_name || "";
      this.upgradeForm.payment_method_id = null;
      if (!this.stripe && process.env.MIX_STRIPE_PUBLIC_KEY) {
        this.stripe = await loadStripe(process.env.MIX_STRIPE_PUBLIC_KEY);
        if (this.stripe) {
          this.stripeElements = this.stripe.elements();
          this.stripeCardElement = this.stripeElements.create("card");
        }
      }
      this.$nextTick(() => this.mountUpgradeStripeElement());
    },

    closeUpgradeModal() {
      this.upgradeModalOpen = false;
      this.upgradePreview = null;
      if (this.stripeCardElement) {
        try {
          this.stripeCardElement.unmount();
        } catch (e) {}
      }
    },

    mountUpgradeStripeElement() {
      const mountPoint = this.$refs.upgradeStripeCard;
      if (!mountPoint || !this.stripeCardElement) return;
      try {
        this.stripeCardElement.unmount();
      } catch (e) {}
      try {
        this.stripeCardElement.mount(mountPoint);
      } catch (e) {
        console.error("Stripe card mount error:", e);
      }
    },

    async loadUpgradePreview() {
      if (!this.upgradeForm.new_amount || !this.sponsor) return;
      this.upgradePreviewLoading = true;
      try {
        const { data } = await axios.post(
          `${process.env.MIX_WEB_API_URL}sponsor/upgrade-preview`,
          {
            sponsor_id: this.sponsor.id,
            new_amount: this.upgradeForm.new_amount,
            new_frequency: this.upgradeForm.new_frequency,
          }
        );
        if (data.status === "Success" && data.data) {
          this.upgradePreview = data.data;
          this.$nextTick(() => this.mountUpgradeStripeElement());
        } else {
          helper.swalErrorMessageForWeb(data.message || "Could not load upgrade preview.");
        }
      } catch (err) {
        const msg = err.response?.data?.message || err.message || "Could not load upgrade preview.";
        helper.swalErrorMessageForWeb(msg);
      } finally {
        this.upgradePreviewLoading = false;
      }
    },

    async confirmUpgrade() {
      if (!this.upgradePreview || !this.sponsor) return;
      this.upgradeSubmitting = true;
      try {
        let paymentMethodId = this.upgradeForm.payment_method_id;
        if (this.upgradePreview.amount_due_today > 0) {
          if (!this.upgradeForm.cardholder_name) {
            helper.swalErrorMessageForWeb("Please enter cardholder name.");
            this.upgradeSubmitting = false;
            return;
          }
          if (!this.stripe || !this.stripeCardElement) {
            helper.swalErrorMessageForWeb("Card element is not ready. Please try again.");
            this.upgradeSubmitting = false;
            return;
          }
          const { error, paymentMethod } = await this.stripe.createPaymentMethod({
            type: "card",
            card: this.stripeCardElement,
            billing_details: { name: this.upgradeForm.cardholder_name },
          });
          if (error) {
            helper.swalErrorMessageForWeb(error.message || "Card validation failed.");
            this.upgradeSubmitting = false;
            return;
          }
          paymentMethodId = paymentMethod.id;
        } else {
          // Amount due is 0 (credit covers full new plan). We still need a payment method for future renewals - use existing default or require card.
          if (!this.stripe || !this.stripeCardElement) {
            helper.swalErrorMessageForWeb("Please enter card details for future renewals.");
            this.upgradeSubmitting = false;
            return;
          }
          const { error, paymentMethod } = await this.stripe.createPaymentMethod({
            type: "card",
            card: this.stripeCardElement,
            billing_details: { name: this.upgradeForm.cardholder_name || this.sponsor.contact_name },
          });
          if (error) {
            helper.swalErrorMessageForWeb(error.message || "Card validation failed.");
            this.upgradeSubmitting = false;
            return;
          }
          paymentMethodId = paymentMethod.id;
        }

        const { data } = await axios.post(
          `${process.env.MIX_WEB_API_URL}sponsor/upgrade-plan`,
          {
            sponsor_id: this.sponsor.id,
            new_amount: this.upgradeForm.new_amount,
            new_frequency: this.upgradeForm.new_frequency,
            payment_method_id: paymentMethodId,
            cardholder_name: this.upgradeForm.cardholder_name || this.sponsor.contact_name,
          }
        );
        if (data.status === "Success") {
          helper.swalSuccessMessageForWeb(data.message || "Plan upgraded successfully.");
          this.closeUpgradeModal();
          await this.fetchSponsorProfile();
        } else {
          helper.swalErrorMessageForWeb(data.message || "Upgrade failed.");
        }
      } catch (err) {
        const msg = err.response?.data?.message || err.message || "Upgrade failed.";
        helper.swalErrorMessageForWeb(msg);
      } finally {
        this.upgradeSubmitting = false;
      }
    },

    async submitDowngradeRequest() {
      if (!this.upgradePreview || !this.upgradePreview.is_downgrade || !this.sponsor) return;
      this.upgradeSubmitting = true;
      try {
        const { data } = await axios.post(
          `${process.env.MIX_WEB_API_URL}sponsor/downgrade-request`,
          {
            sponsor_id: this.sponsor.id,
            new_amount: this.upgradeForm.new_amount,
            new_frequency: this.upgradeForm.new_frequency,
            current_period_end: this.upgradePreview.current_period_end || null,
          }
        );
        if (data.status === "Success") {
          helper.swalSuccessMessageForWeb(data.message || "Downgrade request submitted. It will take effect at the end of your billing period.");
          this.closeUpgradeModal();
        } else {
          helper.swalErrorMessageForWeb(data.message || "Request failed.");
        }
      } catch (err) {
        const msg = err.response?.data?.message || err.message || "Request failed.";
        helper.swalErrorMessageForWeb(msg);
      } finally {
        this.upgradeSubmitting = false;
      }
    },
  },
};
</script>

<style scoped>
/* Custom styles if needed */
</style>
