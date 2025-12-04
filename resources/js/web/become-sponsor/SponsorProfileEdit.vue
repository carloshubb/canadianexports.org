<template>
  <div class="bg-white rounded-lg shadow-lg p-6 md:p-8">

    <!-- Sponsorship Status Card -->
    <div v-if="sponsor" class="bg-gradient-to-r from-blue-50 to-primary/10 border border-primary/30 rounded-lg p-6 mb-6">
      <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
          <h3 class="text-lg font-semibold text-gray-800">Sponsorship Status</h3>
          <div class="flex items-center gap-3 mt-2">
            <span
              class="px-3 py-1 rounded-full text-sm font-medium"
              :class="{
                'bg-green-100 text-green-800': sponsor.status === 'active',
                'bg-yellow-100 text-yellow-800': sponsor.status === 'pending',
                'bg-gray-100 text-gray-800': sponsor.status === 'inactive',
              }"
            >
              {{ sponsor.status === 'active' ? '✓ Active' : sponsor.status === 'pending' ? '⏳ Pending' : 'Inactive' }}
            </span>
            <span
              v-if="sponsor.payment_status"
              class="px-3 py-1 rounded-full text-sm font-medium"
              :class="{
                'bg-green-100 text-green-800': sponsor.payment_status === 'paid',
                'bg-yellow-100 text-yellow-800': sponsor.payment_status === 'pending',
                'bg-blue-100 text-blue-800': sponsor.payment_status === 'not_required',
              }"
            >
              {{ sponsor.payment_status === 'paid' ? '💳 Paid' : sponsor.payment_status === 'pending' ? 'Payment Pending' : 'Contact Request' }}
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
              <input
                type="text"
                id="company_name"
                v-model="form.company_name"
                class="can-exp-input"
                placeholder="Your Company Inc."
                @input="clearErrors('company_name')"
              />
              <Error v-if="submitted" fieldName="company_name" :validationErros="validationErros" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2" for="contact_name">
                Contact Person <span class="text-red-500">*</span>
              </label>
              <input
                type="text"
                id="contact_name"
                v-model="form.contact_name"
                class="can-exp-input"
                placeholder="John Doe"
                @input="clearErrors('contact_name')"
              />
              <Error v-if="submitted" fieldName="contact_name" :validationErros="validationErros" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2" for="email">
                Email Address <span class="text-red-500">*</span>
              </label>
              <input
                type="email"
                id="email"
                v-model="form.email"
                class="can-exp-input"
                placeholder="john@company.com"
                @input="clearErrors('email')"
              />
              <Error v-if="submitted" fieldName="email" :validationErros="validationErros" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2" for="contact_number">
                Contact Number <span class="text-red-500">*</span>
              </label>
              <input
                type="text"
                id="contact_number"
                v-model="form.contact_number"
                class="can-exp-input"
                placeholder="+1 (555) 123-4567"
                @input="clearErrors('contact_number')"
              />
              <Error v-if="submitted" fieldName="contact_number" :validationErros="validationErros" />
            </div>

            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-700 mb-2" for="url">
                Company Website
              </label>
              <input
                type="url"
                id="url"
                v-model="form.url"
                class="can-exp-input"
                placeholder="https://www.yourcompany.com"
                @input="clearErrors('url')"
              />
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
              <textarea
                id="summary"
                v-model="form.summary"
                rows="3"
                class="can-exp-input resize-none"
                placeholder="A brief overview of your company..."
                @input="clearErrors('summary')"
              ></textarea>
              <Error v-if="submitted" fieldName="summary" :validationErros="validationErros" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2" for="detail_description">
                Detailed Description <span class="text-red-500">*</span>
              </label>
              <textarea
                id="detail_description"
                v-model="form.detail_description"
                rows="5"
                class="can-exp-input resize-none"
                placeholder="Tell us more about your company, products, and services..."
                @input="clearErrors('detail_description')"
              ></textarea>
              <Error v-if="submitted" fieldName="detail_description" :validationErros="validationErros" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2" for="message">
                Additional Message
              </label>
              <textarea
                id="message"
                v-model="form.message"
                rows="3"
                class="can-exp-input resize-none"
                placeholder="Any additional information..."
                @input="clearErrors('message')"
              ></textarea>
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
                  <img
                    :src="`/${sponsor.logo_media.path}`"
                    alt="Current Logo"
                    class="w-32 h-32 object-contain border rounded"
                  />
                  <button
                    type="button"
                    @click="removeLogo"
                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600"
                  >
                    ×
                  </button>
                </div>
              </div>

              <FilePond
                ref="filePondLogo"
                name="logo"
                label-idle="<span class='cursor-pointer'>Drag & Drop your logo or Browse</span>"
                accepted-file-types="image/*"
                max-file-size="10MB"
                @init="handleLogoInit"
                @processfile="handleLogoProcess"
                @removefile="handleLogoRemove"
                :files="logo_files"
              />
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
                  <img
                    :src="`/${sponsor.featured_media.path}`"
                    alt="Current Featured Image"
                    class="w-32 h-32 object-cover border rounded"
                  />
                  <button
                    type="button"
                    @click="removeFeaturedImage"
                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600"
                  >
                    ×
                  </button>
                </div>
              </div>

              <FilePond
                ref="filePondFeatured"
                name="featured_image"
                label-idle="<span class='cursor-pointer'>Drag & Drop your featured image or Browse</span>"
                accepted-file-types="image/*"
                max-file-size="10MB"
                @init="handleFeaturedImageInit"
                @processfile="handleFeaturedImageProcess"
                @removefile="handleFeaturedImageRemove"
                :files="featured_image_files"
              />
              <Error v-if="submitted" fieldName="featured_image" :validationErros="validationErros" />
            </div>
          </div>
        </div>
      </div>

      <!-- Change Password -->
      <div class="bg-white rounded-lg overflow-hidden shadow-3xl my-6">
        <div class="px-4 py-3 sm:px-6 text-left bg-gradient-to-r from-primary via-primary to-secondary rounded-t-md">
          <h4 class="text-white">Change Password</h4>
        </div>
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
              <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="current_password">
                Current Password
                <span class="text-xs text-gray-500 ml-2">(Leave blank to keep current password)</span>
              </label>
              <div class="relative">
                <input
                  :type="showCurrentPassword ? 'text' : 'password'"
                  id="current_password"
                  v-model="form.current_password"
                  class="can-exp-input"
                  placeholder="Enter your current password"
                  @input="clearErrors('current_password')"
                />
                <button
                  type="button"
                  class="absolute right-3 top-3 text-gray-500 hover:text-gray-700"
                  @click="showCurrentPassword = !showCurrentPassword"
                >
                  <svg v-if="!showCurrentPassword" class="w-5 h-5" viewBox="0 0 51 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M50.96 16.7C50.96 16.72 50.96 16.75 50.96 16.77C50.54 17.41 50.13 18.05 49.69 18.68C46.74 22.97 43.22 26.69 38.8 29.49C35.68 31.46 32.31 32.77 28.64 33.26C28.13 33.33 27.62 33.39 27.11 33.46C26.02 33.46 24.94 33.46 23.85 33.46C23.25 33.38 22.64 33.31 22.04 33.22C18.47 32.67 15.19 31.35 12.15 29.41C8.16 26.86 4.89 23.57 2.08 19.78C1.36 18.82 0.69 17.78 0 16.77C0 16.75 0 16.72 0 16.7C0.07 16.61 0.15 16.52 0.21 16.42C0.93 15.36 1.62 14.27 2.39 13.24C5.23 9.44 8.57 6.16 12.65 3.69C15.69 1.85 18.96 0.64 22.5 0.2C23.07 0.13 23.64 0.07 24.21 0C25.06 0 25.91 0 26.76 0C27.25 0.05 27.74 0.1 28.22 0.16C31.57 0.58 34.7 1.67 37.63 3.35C42.33 6.06 46.07 9.81 49.23 14.17C49.82 15 50.38 15.86 50.96 16.7ZM24.98 29.15C30.92 29.15 35.74 25.62 37.33 20.39C38.37 16.97 37.92 13.67 36.34 10.51C35.58 8.98 34.69 7.57 33.14 6.66C30.6 5.17 27.94 4.24 24.96 4.37C17.99 4.68 12.67 10.59 13.12 17.56C13.3 20.43 14.37 22.98 16.03 25.3C16.26 25.62 16.55 25.92 16.87 26.15C19.42 28.02 22.25 29.12 24.98 29.15Z" fill="currentColor"/>
                  </svg>
                  <svg v-else class="w-5 h-5" viewBox="0 0 51 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M28.22 0.59C27.73 0.53 27.24 0.49 26.75 0.43H24.2C23.63 0.5 23.06 0.56 22.49 0.63C18.95 1.07 15.69 2.29 12.64 4.13C8.56 6.6 5.23 9.88 2.39 13.68C1.62 14.71 0.93 15.8 0.21 16.86C0.14 16.95 0.07 17.04 0 17.13V17.21C0.69 18.22 1.35 19.25 2.08 20.23C4.89 24.01 8.16 27.31 12.15 29.86C12.19 29.89 12.23 29.91 12.27 29.93C12.33 29.8 12.4 29.69 12.48 29.57L15.51 24.97C14.14 22.86 13.27 20.55 13.11 17.99C12.67 11.02 17.98 5.1 24.95 4.8C26.2 4.75 27.39 4.88 28.54 5.16L31.18 1.16C30.21 0.91 29.23 0.72 28.22 0.59ZM49.22 14.6C46.3 10.58 42.89 7.08 38.68 4.43C38.61 4.55 38.55 4.65 38.48 4.76L35.45 9.37C35.78 9.87 36.07 10.4 36.34 10.94C37.91 14.11 38.37 17.4 37.33 20.82C35.74 26.05 30.92 29.58 24.98 29.58C24.12 29.57 23.24 29.45 22.37 29.24L19.77 33.2C20.51 33.4 21.27 33.55 22.04 33.67C22.64 33.76 23.25 33.83 23.85 33.91H27.11C27.62 33.84 28.13 33.78 28.64 33.71C32.31 33.22 35.68 31.91 38.8 29.93C43.22 27.13 46.74 23.41 49.69 19.12C50.12 18.49 50.54 17.84 50.96 17.21V17.13C50.38 16.29 49.82 15.43 49.22 14.6ZM37.38 3.65C37.34 3.75 37.28 3.85 37.22 3.94L34.46 8.13L20.88 28.78L18.26 32.77L17.98 33.19C17.49 33.93 16.68 34.34 15.85 34.34C15.37 34.34 14.89 34.2 14.46 33.92C13.39 33.21 13.02 31.83 13.56 30.7C13.61 30.6 13.67 30.5 13.73 30.4L16.47 26.24L30.04 5.61L32.69 1.6L32.98 1.15C47 0.41 34.28 0 35.1 0C35.58 0 36.07 0.14 36.5 0.42C37.58 1.13 37.93 2.52 37.38 3.65Z" fill="currentColor"/>
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
                <input
                  :type="showNewPassword ? 'text' : 'password'"
                  id="new_password"
                  v-model="form.new_password"
                  class="can-exp-input"
                  placeholder="Enter new password"
                  @input="clearErrors('new_password')"
                />
                <button
                  type="button"
                  class="absolute right-3 top-3 text-gray-500 hover:text-gray-700"
                  @click="showNewPassword = !showNewPassword"
                >
                  <svg v-if="!showNewPassword" class="w-5 h-5" viewBox="0 0 51 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M50.96 16.7C50.96 16.72 50.96 16.75 50.96 16.77C50.54 17.41 50.13 18.05 49.69 18.68C46.74 22.97 43.22 26.69 38.8 29.49C35.68 31.46 32.31 32.77 28.64 33.26C28.13 33.33 27.62 33.39 27.11 33.46C26.02 33.46 24.94 33.46 23.85 33.46C23.25 33.38 22.64 33.31 22.04 33.22C18.47 32.67 15.19 31.35 12.15 29.41C8.16 26.86 4.89 23.57 2.08 19.78C1.36 18.82 0.69 17.78 0 16.77C0 16.75 0 16.72 0 16.7C0.07 16.61 0.15 16.52 0.21 16.42C0.93 15.36 1.62 14.27 2.39 13.24C5.23 9.44 8.57 6.16 12.65 3.69C15.69 1.85 18.96 0.64 22.5 0.2C23.07 0.13 23.64 0.07 24.21 0C25.06 0 25.91 0 26.76 0C27.25 0.05 27.74 0.1 28.22 0.16C31.57 0.58 34.7 1.67 37.63 3.35C42.33 6.06 46.07 9.81 49.23 14.17C49.82 15 50.38 15.86 50.96 16.7ZM24.98 29.15C30.92 29.15 35.74 25.62 37.33 20.39C38.37 16.97 37.92 13.67 36.34 10.51C35.58 8.98 34.69 7.57 33.14 6.66C30.6 5.17 27.94 4.24 24.96 4.37C17.99 4.68 12.67 10.59 13.12 17.56C13.3 20.43 14.37 22.98 16.03 25.3C16.26 25.62 16.55 25.92 16.87 26.15C19.42 28.02 22.25 29.12 24.98 29.15Z" fill="currentColor"/>
                  </svg>
                  <svg v-else class="w-5 h-5" viewBox="0 0 51 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M28.22 0.59C27.73 0.53 27.24 0.49 26.75 0.43H24.2C23.63 0.5 23.06 0.56 22.49 0.63C18.95 1.07 15.69 2.29 12.64 4.13C8.56 6.6 5.23 9.88 2.39 13.68C1.62 14.71 0.93 15.8 0.21 16.86C0.14 16.95 0.07 17.04 0 17.13V17.21C0.69 18.22 1.35 19.25 2.08 20.23C4.89 24.01 8.16 27.31 12.15 29.86C12.19 29.89 12.23 29.91 12.27 29.93C12.33 29.8 12.4 29.69 12.48 29.57L15.51 24.97C14.14 22.86 13.27 20.55 13.11 17.99C12.67 11.02 17.98 5.1 24.95 4.8C26.2 4.75 27.39 4.88 28.54 5.16L31.18 1.16C30.21 0.91 29.23 0.72 28.22 0.59ZM49.22 14.6C46.3 10.58 42.89 7.08 38.68 4.43C38.61 4.55 38.55 4.65 38.48 4.76L35.45 9.37C35.78 9.87 36.07 10.4 36.34 10.94C37.91 14.11 38.37 17.4 37.33 20.82C35.74 26.05 30.92 29.58 24.98 29.58C24.12 29.57 23.24 29.45 22.37 29.24L19.77 33.2C20.51 33.4 21.27 33.55 22.04 33.67C22.64 33.76 23.25 33.83 23.85 33.91H27.11C27.62 33.84 28.13 33.78 28.64 33.71C32.31 33.22 35.68 31.91 38.8 29.93C43.22 27.13 46.74 23.41 49.69 19.12C50.12 18.49 50.54 17.84 50.96 17.21V17.13C50.38 16.29 49.82 15.43 49.22 14.6ZM37.38 3.65C37.34 3.75 37.28 3.85 37.22 3.94L34.46 8.13L20.88 28.78L18.26 32.77L17.98 33.19C17.49 33.93 16.68 34.34 15.85 34.34C15.37 34.34 14.89 34.2 14.46 33.92C13.39 33.21 13.02 31.83 13.56 30.7C13.61 30.6 13.67 30.5 13.73 30.4L16.47 26.24L30.04 5.61L32.69 1.6L32.98 1.15C47 0.41 34.28 0 35.1 0C35.58 0 36.07 0.14 36.5 0.42C37.58 1.13 37.93 2.52 37.38 3.65Z" fill="currentColor"/>
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
                <input
                  :type="showNewPasswordConfirm ? 'text' : 'password'"
                  id="new_password_confirmation"
                  v-model="form.new_password_confirmation"
                  class="can-exp-input"
                  placeholder="Confirm new password"
                  @input="clearErrors('new_password_confirmation')"
                  @blur="checkNewPasswordMatch"
                />
                <button
                  type="button"
                  class="absolute right-3 top-3 text-gray-500 hover:text-gray-700"
                  @click="showNewPasswordConfirm = !showNewPasswordConfirm"
                >
                  <svg v-if="!showNewPasswordConfirm" class="w-5 h-5" viewBox="0 0 51 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M50.96 16.7C50.96 16.72 50.96 16.75 50.96 16.77C50.54 17.41 50.13 18.05 49.69 18.68C46.74 22.97 43.22 26.69 38.8 29.49C35.68 31.46 32.31 32.77 28.64 33.26C28.13 33.33 27.62 33.39 27.11 33.46C26.02 33.46 24.94 33.46 23.85 33.46C23.25 33.38 22.64 33.31 22.04 33.22C18.47 32.67 15.19 31.35 12.15 29.41C8.16 26.86 4.89 23.57 2.08 19.78C1.36 18.82 0.69 17.78 0 16.77C0 16.75 0 16.72 0 16.7C0.07 16.61 0.15 16.52 0.21 16.42C0.93 15.36 1.62 14.27 2.39 13.24C5.23 9.44 8.57 6.16 12.65 3.69C15.69 1.85 18.96 0.64 22.5 0.2C23.07 0.13 23.64 0.07 24.21 0C25.06 0 25.91 0 26.76 0C27.25 0.05 27.74 0.1 28.22 0.16C31.57 0.58 34.7 1.67 37.63 3.35C42.33 6.06 46.07 9.81 49.23 14.17C49.82 15 50.38 15.86 50.96 16.7ZM24.98 29.15C30.92 29.15 35.74 25.62 37.33 20.39C38.37 16.97 37.92 13.67 36.34 10.51C35.58 8.98 34.69 7.57 33.14 6.66C30.6 5.17 27.94 4.24 24.96 4.37C17.99 4.68 12.67 10.59 13.12 17.56C13.3 20.43 14.37 22.98 16.03 25.3C16.26 25.62 16.55 25.92 16.87 26.15C19.42 28.02 22.25 29.12 24.98 29.15Z" fill="currentColor"/>
                  </svg>
                  <svg v-else class="w-5 h-5" viewBox="0 0 51 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M28.22 0.59C27.73 0.53 27.24 0.49 26.75 0.43H24.2C23.63 0.5 23.06 0.56 22.49 0.63C18.95 1.07 15.69 2.29 12.64 4.13C8.56 6.6 5.23 9.88 2.39 13.68C1.62 14.71 0.93 15.8 0.21 16.86C0.14 16.95 0.07 17.04 0 17.13V17.21C0.69 18.22 1.35 19.25 2.08 20.23C4.89 24.01 8.16 27.31 12.15 29.86C12.19 29.89 12.23 29.91 12.27 29.93C12.33 29.8 12.4 29.69 12.48 29.57L15.51 24.97C14.14 22.86 13.27 20.55 13.11 17.99C12.67 11.02 17.98 5.1 24.95 4.8C26.2 4.75 27.39 4.88 28.54 5.16L31.18 1.16C30.21 0.91 29.23 0.72 28.22 0.59ZM49.22 14.6C46.3 10.58 42.89 7.08 38.68 4.43C38.61 4.55 38.55 4.65 38.48 4.76L35.45 9.37C35.78 9.87 36.07 10.4 36.34 10.94C37.91 14.11 38.37 17.4 37.33 20.82C35.74 26.05 30.92 29.58 24.98 29.58C24.12 29.57 23.24 29.45 22.37 29.24L19.77 33.2C20.51 33.4 21.27 33.55 22.04 33.67C22.64 33.76 23.25 33.83 23.85 33.91H27.11C27.62 33.84 28.13 33.78 28.64 33.71C32.31 33.22 35.68 31.91 38.8 29.93C43.22 27.13 46.74 23.41 49.69 19.12C50.12 18.49 50.54 17.84 50.96 17.21V17.13C50.38 16.29 49.82 15.43 49.22 14.6ZM37.38 3.65C37.34 3.75 37.28 3.85 37.22 3.94L34.46 8.13L20.88 28.78L18.26 32.77L17.98 33.19C17.49 33.93 16.68 34.34 15.85 34.34C15.37 34.34 14.89 34.2 14.46 33.92C13.39 33.21 13.02 31.83 13.56 30.7C13.61 30.6 13.67 30.5 13.73 30.4L16.47 26.24L30.04 5.61L32.69 1.6L32.98 1.15C47 0.41 34.28 0 35.1 0C35.58 0 36.07 0.14 36.5 0.42C37.58 1.13 37.93 2.52 37.38 3.65Z" fill="currentColor"/>
                  </svg>
                </button>
              </div>
              <Error v-if="submitted" fieldName="new_password_confirmation" :validationErros="validationErros" />
            </div>
          </div>
          <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-md">
            <p class="text-sm text-blue-800">
              <strong>Note:</strong> Only fill these fields if you want to change your password. Leave them blank to keep your current password.
            </p>
          </div>
        </div>
      </div>

      <!-- Form Actions -->
      <div class="flex flex-col sm:flex-row gap-3 justify-end">
        <button
          type="button"
          @click="resetForm"
          class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition"
          :disabled="loading"
        >
          Reset Changes
        </button>
        <button
          type="submit"
          class="button-exp-fill"
          :disabled="loading"
        >
          <span v-if="loading" class="flex items-center justify-center">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Updating...
          </span>
          <span v-else>
            Update Profile
          </span>
        </button>
      </div>
    </form>

    <!-- Loading Overlay -->
    <div v-if="loading" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6">
        <div class="flex items-center space-x-3">
          <svg class="animate-spin h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
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
      validationErros: new ErrorHandling(),
      submitted: false,
      showCurrentPassword: false,
      showNewPassword: false,
      showNewPasswordConfirm: false,
    };
  },
  mounted() {
    this.fetchSponsorProfile();
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
        this.form.company_name = this.sponsor.business_name || "";
        this.form.contact_name = this.sponsor.contact_name || "";
        this.form.email = this.sponsor.email || "";
        this.form.contact_number = this.sponsor.contact_number || "";
        this.form.url = this.sponsor.url || "";
        this.form.summary = this.sponsor.summary || "";
        this.form.detail_description = this.sponsor.detail_description || "";
        this.form.message = this.sponsor.message || "";
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
  },
};
</script>

<style scoped>
/* Custom styles if needed */
</style>

