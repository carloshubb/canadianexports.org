<template>
  <div>
    <div class="mb-4">
      <div class="my-4" v-if="profile && user && !hide_welcome">
        <template v-if="parsedUser?.is_package_amount_paid">
          <h4 class="font-FuturaMdCnBT">{{ regPageSetting?.reg_page_setting_detail?.[0]
            ?.greeting_text ?? 'Welcome back' }} {{ parsedUser?.name }},</h4>
          <p class="font-FuturaMdCnBT" v-html="regPageSetting?.reg_page_setting_detail?.[0]
              ?.step_2_acc_description
            "></p>
        </template>
      </div>
      <div class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-xblue via-primary to-blue-600 rounded-md">
        <h4 class="text-white">2 of 3 - Company & Contact Information</h4>
      </div>

      <div class="my-4 space-y-8">
        <!-- Sub-section 1: Contact Person -->
        <div class="border border-gray-200 rounded-lg p-6 bg-white shadow-sm">
          <h5 class="text-primary font-FuturaMdCnBT mb-4 text-lg md:text-xl lg:text-2xl">
            Contact Person
          </h5>

          <div class="relative w-full mb-8">
            <label class="block  mb-1 text-base md:text-base lg:text-lg font-bold" for="name">
              {{ regPageSetting?.reg_page_setting_detail?.[0]?.step_2_full_name_label || 'Full Name' }}
              <span class="text-red-500">*</span>
            </label>
            <input type="text" id="name" class="can-exp-input min-h-[60px] lg:min-h-full"
              :placeholder="regPageSetting?.reg_page_setting_detail?.[0]?.step_2_full_name_placeholder "
              :value="form && form.has('name') ? form.get('name') : ''"
              @input="updateForm('name', $event.target.value)" ref="name" />
            <Error fieldName="name" :validationErros="validationErros" />
          </div>
          <div class="relative w-full mb-8">
            <label class="block mb-1 text-base md:text-base lg:text-lg font-bold" for="job_title">
              {{ regPageSetting?.reg_page_setting_detail?.[0]?.step_2_job_title_label || 'Job Title' }}
            </label>
            <input type="text" id="job_title" class="can-exp-input min-h-[60px] lg:min-h-full"
              :placeholder="regPageSetting?.reg_page_setting_detail?.[0]?.step_2_job_title_placeholder 
              "
              :value="form && form.has('job_title') ? form.get('job_title') : ''"
              @input="updateForm('job_title', $event.target.value)" />
            <Error fieldName="job_title" :validationErros="validationErros" />
          </div>
          <div class="relative w-full mb-8">
            <label class="block mb-1 text-base md:text-base lg:text-lg font-bold" for="email">
              {{ regPageSetting?.reg_page_setting_detail?.[0]?.step_2_email_label }}
              <span class="text-red-500">*</span>
            </label>
            <input type="text" id="email" class="can-exp-input min-h-[60px] lg:min-h-full"
              :value="form && form.has('email') ? form.get('email') : ''"
              :placeholder="regPageSetting?.reg_page_setting_detail?.[0]?.step_2_email_placeholder"
              @input="updateForm('email', $event.target.value)"
              @change="checkIsEmailValid($event.target.value)"
              ref="email" autocomplete="off"
              :disabled="profile == '1' && user && parsedUser?.is_package_amount_paid == '0'"
              :class="profile == '1' && user && parsedUser?.is_package_amount_paid == '0' ? 'opacity-50 cursor-not-allowed' : ''" />
            <Error fieldName="email" :validationErros="validationErros" />
          </div>
          <div class="relative w-full mb-8" v-if="profile != '1'">
            <label class="block mb-1 text-base md:text-base lg:text-lg font-bold" for="password">
              {{ regPageSetting?.reg_page_setting_detail?.[0]?.step_2_password_label }}
              <span class="ml-1 text-[0.85em] font-normal">(Min. 8 characters. Must contain at least one lowercase and one uppercase)</span>
              <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <input :type="display_password" id="password" class="can-exp-input"
                :placeholder="regPageSetting?.reg_page_setting_detail?.[0]?.step_2_password_placeholder"
                @input="updateForm('password', $event.target.value)" ref="password" />
              <svg class="w-5 h-5 text-gray-500 absolute top-3" :class="parsedLang && parsedLang['direction'] == 'ltr' ? 'right-3' : 'left-3'"
                @click="display_password = 'text'" v-if="display_password == 'password'" viewBox="0 0 51 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_1249_2209)"><path d="M28.22 0.59C27.73 0.53 27.24 0.49 26.75 0.43H24.2C23.63 0.5 23.06 0.56 22.49 0.63C18.95 1.07 15.69 2.29 12.64 4.13C8.56 6.6 5.23 9.88 2.39 13.68C1.62 14.71 0.93 15.8 0.21 16.86C0.14 16.95 0.07 17.04 0 17.13V17.21C0.69 18.22 1.35 19.25 2.08 20.23C4.89 24.01 8.16 27.31 12.15 29.86C12.19 29.89 12.23 29.91 12.27 29.93C12.33 29.8 12.4 29.69 12.48 29.57L15.51 24.97C14.14 22.86 13.27 20.55 13.11 17.99C12.67 11.02 17.98 5.1 24.95 4.8C26.2 4.75 27.39 4.88 28.54 5.16L31.18 1.16C30.21 0.91 29.23 0.72 28.22 0.59ZM49.22 14.6C46.3 10.58 42.89 7.08 38.68 4.43C38.61 4.55 38.55 4.65 38.48 4.76L35.45 9.37C35.78 9.87 36.07 10.4 36.34 10.94C37.91 14.11 38.37 17.4 37.33 20.82C35.74 26.05 30.92 29.58 24.98 29.58C24.12 29.57 23.24 29.45 22.37 29.24L19.77 33.2C20.51 33.4 21.27 33.55 22.04 33.67C22.64 33.76 23.25 33.83 23.85 33.91H27.11C27.62 33.84 28.13 33.78 28.64 33.71C32.31 33.22 35.68 31.91 38.8 29.93C43.22 27.13 46.74 23.41 49.69 19.12C50.12 18.49 50.54 17.84 50.96 17.21V17.13C50.38 16.29 49.82 15.43 49.22 14.6ZM37.38 3.65C37.34 3.75 37.28 3.85 37.22 3.94L34.46 8.13L20.88 28.78L18.26 32.77L17.98 33.19C17.49 33.93 16.68 34.34 15.85 34.34C15.37 34.34 14.89 34.2 14.46 33.92C13.39 33.21 13.02 31.83 13.56 30.7C13.61 30.6 13.67 30.5 13.73 30.4L16.47 26.24L30.04 5.61L32.69 1.6L32.98 1.15C33.47 0.41 34.28 0 35.1 0C35.58 0 36.07 0.14 36.5 0.42C37.58 1.13 37.93 2.52 37.38 3.65Z" fill="currentcolor" /></g>
                <defs><clipPath id="clip0_1249_2209"><rect width="50.96" height="34.34" fill="currentcolor" /></clipPath></defs>
              </svg>
              <svg class="w-5 h-5 text-gray-500 absolute top-3" :class="parsedLang && parsedLang['direction'] == 'ltr' ? 'right-3' : 'left-3'"
                @click="display_password = 'password'" v-else-if="display_password == 'text'" viewBox="0 0 51 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_1248_2207)"><path d="M50.96 16.7C50.96 16.72 50.96 16.75 50.96 16.77C50.54 17.41 50.13 18.05 49.69 18.68C46.74 22.97 43.22 26.69 38.8 29.49C35.68 31.46 32.31 32.77 28.64 33.26C28.13 33.33 27.62 33.39 27.11 33.46C26.02 33.46 24.94 33.46 23.85 33.46C23.25 33.38 22.64 33.31 22.04 33.22C18.47 32.67 15.19 31.35 12.15 29.41C8.16 26.86 4.89 23.57 2.08 19.78C1.36 18.82 0.69 17.78 0 16.77C0 16.75 0 16.72 0 16.7C0.07 16.61 0.15 16.52 0.21 16.42C0.93 15.36 1.62 14.27 2.39 13.24C5.23 9.44 8.57 6.16 12.65 3.69C15.69 1.85 18.96 0.64 22.5 0.2C23.07 0.13 23.64 0.07 24.21 0C25.06 0 25.91 0 26.76 0C27.25 0.05 27.74 0.1 28.22 0.16C31.57 0.58 34.7 1.67 37.63 3.35C42.33 6.06 46.07 9.81 49.23 14.17C49.82 15 50.38 15.86 50.96 16.7ZM24.98 29.15C30.92 29.15 35.74 25.62 37.33 20.39C38.37 16.97 37.92 13.67 36.34 10.51C35.58 8.98 34.69 7.57 33.14 6.66C30.6 5.17 27.94 4.24 24.96 4.37C17.99 4.68 12.67 10.59 13.12 17.56C13.3 20.43 14.37 22.98 16.03 25.3C16.26 25.62 16.55 25.92 16.87 26.15C19.42 28.02 22.25 29.12 24.98 29.15Z" fill="currentcolor" /></g>
                <defs><clipPath id="clip0_1248_2207"><rect width="50.96" height="33.48" fill="currentcolor" /></clipPath></defs>
              </svg>
            </div>
            <Error fieldName="password" :validationErros="validationErros" />
          </div>
          <div class="relative w-full mb-8" v-if="profile != '1'">
            <label class="block mb-1 text-base md:text-base lg:text-lg font-bold" for="confirm-password">
              {{ regPageSetting?.reg_page_setting_detail?.[0]?.step_2_confirm_password_label }}
              <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <input :type="display_confirm_password" id="confirm-password" class="can-exp-input"
                :placeholder="regPageSetting?.reg_page_setting_detail?.[0]?.step_2_confirm_password_placeholder"
                @input="updateForm('password_confirmation', $event.target.value)" @blur="checkPassword()" ref="confirm_password" />
              <svg class="w-5 h-5 text-gray-500 absolute top-3" :class="parsedLang && parsedLang['direction'] == 'ltr' ? 'right-3' : 'left-3'"
                @click="display_confirm_password = 'text'" v-if="display_confirm_password == 'password'" viewBox="0 0 51 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_1249_2209)"><path d="M28.22 0.59C27.73 0.53 27.24 0.49 26.75 0.43H24.2C23.63 0.5 23.06 0.56 22.49 0.63C18.95 1.07 15.69 2.29 12.64 4.13C8.56 6.6 5.23 9.88 2.39 13.68C1.62 14.71 0.93 15.8 0.21 16.86C0.14 16.95 0.07 17.04 0 17.13V17.21C0.69 18.22 1.35 19.25 2.08 20.23C4.89 24.01 8.16 27.31 12.15 29.86C12.19 29.89 12.23 29.91 12.27 29.93C12.33 29.8 12.4 29.69 12.48 29.57L15.51 24.97C14.14 22.86 13.27 20.55 13.11 17.99C12.67 11.02 17.98 5.1 24.95 4.8C26.2 4.75 27.39 4.88 28.54 5.16L31.18 1.16C30.21 0.91 29.23 0.72 28.22 0.59ZM49.22 14.6C46.3 10.58 42.89 7.08 38.68 4.43C38.61 4.55 38.55 4.65 38.48 4.76L35.45 9.37C35.78 9.87 36.07 10.4 36.34 10.94C37.91 14.11 38.37 17.4 37.33 20.82C35.74 26.05 30.92 29.58 24.98 29.58C24.12 29.57 23.24 29.45 22.37 29.24L19.77 33.2C20.51 33.4 21.27 33.55 22.04 33.67C22.64 33.76 23.25 33.83 23.85 33.91H27.11C27.62 33.84 28.13 33.78 28.64 33.71C32.31 33.22 35.68 31.91 38.8 29.93C43.22 27.13 46.74 23.41 49.69 19.12C50.12 18.49 50.54 17.84 50.96 17.21V17.13C50.38 16.29 49.82 15.43 49.22 14.6ZM37.38 3.65C37.34 3.75 37.28 3.85 37.22 3.94L34.46 8.13L20.88 28.78L18.26 32.77L17.98 33.19C17.49 33.93 16.68 34.34 15.85 34.34C15.37 34.34 14.89 34.2 14.46 33.92C13.39 33.21 13.02 31.83 13.56 30.7C13.61 30.6 13.67 30.5 13.73 30.4L16.47 26.24L30.04 5.61L32.69 1.6L32.98 1.15C33.47 0.41 34.28 0 35.1 0C35.58 0 36.07 0.14 36.5 0.42C37.58 1.13 37.93 2.52 37.38 3.65Z" fill="currentcolor" /></g>
                <defs><clipPath id="clip0_1249_2209"><rect width="50.96" height="34.34" fill="currentcolor" /></clipPath></defs>
              </svg>
              <svg class="w-5 h-5 text-gray-500 absolute top-3" :class="parsedLang && parsedLang['direction'] == 'ltr' ? 'right-3' : 'left-3'"
                @click="display_confirm_password = 'password'" v-else-if="display_confirm_password == 'text'" viewBox="0 0 51 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_1248_2207)"><path d="M50.96 16.7C50.96 16.72 50.96 16.75 50.96 16.77C50.54 17.41 50.13 18.05 49.69 18.68C46.74 22.97 43.22 26.69 38.8 29.49C35.68 31.46 32.31 32.77 28.64 33.26C28.13 33.33 27.62 33.39 27.11 33.46C26.02 33.46 24.94 33.46 23.85 33.46C23.25 33.38 22.64 33.31 22.04 33.22C18.47 32.67 15.19 31.35 12.15 29.41C8.16 26.86 4.89 23.57 2.08 19.78C1.36 18.82 0.69 17.78 0 16.77C0 16.75 0 16.72 0 16.7C0.07 16.61 0.15 16.52 0.21 16.42C0.93 15.36 1.62 14.27 2.39 13.24C5.23 9.44 8.57 6.16 12.65 3.69C15.69 1.85 18.96 0.64 22.5 0.2C23.07 0.13 23.64 0.07 24.21 0C25.06 0 25.91 0 26.76 0C27.25 0.05 27.74 0.1 28.22 0.16C31.57 0.58 34.7 1.67 37.63 3.35C42.33 6.06 46.07 9.81 49.23 14.17C49.82 15 50.38 15.86 50.96 16.7ZM24.98 29.15C30.92 29.15 35.74 25.62 37.33 20.39C38.37 16.97 37.92 13.67 36.34 10.51C35.58 8.98 34.69 7.57 33.14 6.66C30.6 5.17 27.94 4.24 24.96 4.37C17.99 4.68 12.67 10.59 13.12 17.56C13.3 20.43 14.37 22.98 16.03 25.3C16.26 25.62 16.55 25.92 16.87 26.15C19.42 28.02 22.25 29.12 24.98 29.15Z" fill="currentcolor" /></g>
                <defs><clipPath id="clip0_1248_2207"><rect width="50.96" height="33.48" fill="currentcolor" /></clipPath></defs>
              </svg>
            </div>
            <Error fieldName="password_confirmation" :validationErros="validationErros" />
          </div>
        </div>

        <!-- Sub-section 2: Company Location & Contact -->
        <div class="border border-gray-200 rounded-lg p-6 bg-white shadow-sm">
          <h5 class="text-primary font-FuturaMdCnBT mb-4 text-lg md:text-xl lg:text-2xl">
          Company Location & Contact</h5>
          <div class="relative w-full mb-8">
            <label class="block mb-1 text-base md:text-base lg:text-lg font-bold" for="customer_profile_company_name">
              {{ regPageSetting?.reg_page_setting_detail?.[0]?.step_4_name_label }}
              <span class="text-red-500">*</span>
            </label>
            <input type="text" id="customer_profile_company_name" class="can-exp-input"
              :placeholder="regPageSetting?.reg_page_setting_detail?.[0]?.step_4_name_placeholder"
              @input="onFieldInput($event, 'customer_profile_company_name')"
              :value="form && form.has('customer_profile_company_name') ? form.get('customer_profile_company_name') : ''" />
            <Error fieldName="customer_profile_company_name" :validationErros="validationErros" />
          </div>
          <div class="relative w-full mb-8">
            <label class="block mb-1 text-base md:text-base lg:text-lg font-bold" for="customer_profile_website">
              {{ regPageSetting?.reg_page_setting_detail?.[0]?.step_4_website_label }}
              <span class="text-red-500">*</span>
            </label>
            <input type="text" id="customer_profile_website" class="can-exp-input"
              :placeholder="regPageSetting?.reg_page_setting_detail?.[0]?.step_4_website_placeholder"
              @input="onFieldInput($event, 'customer_profile_website')"
              :value="form && form.has('customer_profile_website') ? form.get('customer_profile_website') : ''" />
            <Error fieldName="customer_profile_website" :validationErros="validationErros" />
          </div>
          <div class="relative w-full mb-8">
            <label class="block mb-1 text-base md:text-base lg:text-lg font-bold" for="customer_profile_phone">
              {{ regPageSetting?.reg_page_setting_detail?.[0]?.step_4_phone_label }}
              <span class="text-red-500">*</span>
            </label>
            <input type="text" id="customer_profile_phone" class="can-exp-input"
              :placeholder="regPageSetting?.reg_page_setting_detail?.[0]?.step_4_phone_placeholder"
              @input="onFieldInput($event, 'customer_profile_phone')"
              :value="form && form.has('customer_profile_phone') ? form.get('customer_profile_phone') : ''"
              @keypress="restrictToNumbers($event, 16)" />
            <Error fieldName="customer_profile_phone" :validationErros="validationErros" />
          </div>
          <div class="relative w-full mb-8">
            <label class="block mb-1 text-base md:text-base lg:text-lg font-bold" for="customer_profile_address">
              {{ regPageSetting?.reg_page_setting_detail?.[0]?.step_4_address_label }}
              <span class="text-red-500">*</span>
            </label>
            <textarea rows="4" id="customer_profile_address" class="can-exp-input"
              :placeholder="regPageSetting?.reg_page_setting_detail?.[0]?.step_4_address_placeholder"
              @input="handleMailingAddressInput($event)" @blur="clearMailingAddressError"
              :value="form && form.has('customer_profile_address') ? form.get('customer_profile_address') : ''"></textarea>
            <Error fieldName="customer_profile_address" :validationErros="validationErros" />
          </div>
          <!-- <div class="relative w-full mb-8">
            <label class="block text-gray-700 mb-1 text-base md:text-base lg:text-lg" for="customer_profile_company_email">
              {{ regPageSetting?.reg_page_setting_detail?.[0]?.step_4_email_label }}
              <span class="text-red-500">*</span>
            </label>
            <input type="text" id="customer_profile_company_email" class="can-exp-input min-h-[60px] lg:min-h-full"
              :placeholder="regPageSetting?.reg_page_setting_detail?.[0]?.step_4_email_placeholder"
              @input="onFieldInput($event, 'customer_profile_company_email')"
              :value="form && form.has('customer_profile_company_email') ? form.get('customer_profile_company_email') : ''"
              @change="checkIsCompanyEmailValid($event.target.value)" />
            <Error fieldName="customer_profile_company_email" :validationErros="validationErros" />
          </div> -->
        </div>

        <!-- Sub-section 3: Company Profile & Keywords -->
        <div class="border border-gray-200 rounded-lg p-6 bg-white shadow-sm">
          <h5 class="text-primary font-FuturaMdCnBT mb-4 text-lg md:text-xl lg:text-2xl">
            Company Profile & Keywords</h5>
          <div class="relative w-full mb-8">
            <label class="block mb-1 text-base md:text-base lg:text-lg font-bold" for="customer_profile_short_description">
              Short Summary
              <span class="ml-1 text-[0.85em] font-normal">(Max. 30 words)</span>
              <span class="text-red-500">*</span>
            </label>
            <textarea rows="3" id="customer_profile_short_description" class="can-exp-input"
              :placeholder="regPageSetting?.reg_page_setting_detail?.[0]?.step_4_short_description_placeholder"
              @input="onShortDescriptionInput($event)"
              :value="form && form.has('customer_profile_short_description') ? form.get('customer_profile_short_description') : ''"></textarea>
            <Error fieldName="customer_profile_short_description" :validationErros="validationErros" />
          </div>
          <div class="relative w-full mb-8">
            <label class="block mb-1 text-base md:text-base lg:text-lg font-bold" for="customer_profile_description">
              Full Description
              <span class="ml-1 text-[0.85em] font-normal">(Max. 300 words)</span>
              <span class="text-red-500">*</span>
            </label>
            <textarea rows="6" id="customer_profile_description" class="can-exp-input"
              :placeholder="regPageSetting?.reg_page_setting_detail?.[0]?.step_4_description_placeholder"
              @input="onDescriptionInput($event)"
              :value="form && form.has('customer_profile_description') ? form.get('customer_profile_description') : ''"></textarea>
            <Error fieldName="customer_profile_description" :validationErros="validationErros" />
          </div>
          <div class="relative w-full mb-8">
            <label class="block  mb-1 text-base md:text-base lg:text-lg font-bold" for="customer_profile_keywords">
              {{ regPageSetting?.reg_page_setting_detail?.[0]?.step_4_keywords_label }}
              <span class="text-red-500"></span>
            </label>
            <textarea rows="3" id="customer_profile_keywords" class="can-exp-input"
              :placeholder="regPageSetting?.reg_page_setting_detail?.[0]?.step_4_keywords_placeholder"
              @input="onKeywordsInput($event)"
              :value="form && form.has('customer_profile_keywords') ? form.get('customer_profile_keywords') : ''"></textarea>
            <Error fieldName="customer_profile_keywords" :validationErros="validationErros" />
          </div>
          <div class="relative w-full mb-8" v-if="package_type && package_type.toLowerCase() !== 'free'">
            <label class="block  mb-1 text-base md:text-base lg:text-lg font-bold" for="customer_profile_cta_btn">
              CTA(Call-to-Action) Button
              <span class="ml-1 text-[0.85em] font-normal">(Max. 5 words)</span>
            </label>
            <input type="text" id="customer_profile_cta_btn" class="can-exp-input"
              placeholder="The button text that guides the user's next action; e.g., Learn More."
              @input="onFieldInput($event, 'customer_profile_cta_btn')"
              :value="form && form.has('customer_profile_cta_btn') ? form.get('customer_profile_cta_btn') : ''" />
            <Error fieldName="customer_profile_cta_btn" :validationErros="validationErros" />
          </div>
          <div class="relative w-full mb-8" v-if="package_type && package_type.toLowerCase() !== 'free'">
            <label class="block  mb-1 text-base md:text-base lg:text-lg font-bold" for="customer_profile_cta_link">
              {{ regPageSetting?.reg_page_setting_detail?.[0]?.step_4_cta_link_label }}
            </label>
            <input type="text" id="customer_profile_cta_link" class="can-exp-input"
              :placeholder="regPageSetting?.reg_page_setting_detail?.[0]?.step_4_cta_link_placeholder"
              @input="onFieldInput($event, 'customer_profile_cta_link')"
              :value="form && form.has('customer_profile_cta_link') ? form.get('customer_profile_cta_link') : ''" />
            <Error fieldName="customer_profile_cta_link" :validationErros="validationErros" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
import Error from "./../components/Error.vue";

export default {
  components: { Error },
  props: ["profile", "user", "page_id", "lang", "hide_welcome"],
  data() {
    return {
      display_password: "password",
      display_confirm_password: "password",
    };
  },
  computed: {
    parsedUser() {
      if (!this.user) return {};
      return typeof this.user === "string" ? JSON.parse(this.user || "{}") : this.user;
    },
    parsedLang() {
      if (!this.lang) return null;
      return typeof this.lang === "string" ? JSON.parse(this.lang) : this.lang;
    },
    ...mapState({
      form: (state) => state.signup.form,
      regPageSetting: (state) => state.signup.regPageSetting,
      validationErros: (state) => state.signup.validationErros,
      package_type: (state) => state.signup.package_type,
    }),
  },
  created() {
    if (this.profile == "1" && this.user) {
      let user = typeof this.user === "string" ? JSON.parse(this.user) : this.user;
      this.updateForm("name", user.name);
      this.updateForm("email", user.email);
      this.updateForm("customer_profile_address", user?.customer_profile?.address || "");
      this.updateForm("customer_profile_company_email", user?.customer_profile?.company_email || "");
      this.updateForm("customer_profile_company_name", user?.customer_profile?.company_name || "");
      this.updateForm("customer_profile_description", user?.customer_profile?.description || "");
      this.updateForm("customer_profile_keywords", user?.customer_profile?.keywords || "");
      this.updateForm("customer_profile_phone", user?.customer_profile?.phone || "");
      this.updateForm("customer_profile_short_description", user?.customer_profile?.short_description || "");
      this.updateForm("customer_profile_website", user?.customer_profile?.website || "");
      this.updateForm("customer_profile_cta_link", user?.customer_profile?.cta_link || "");
      this.updateForm("customer_profile_cta_btn", user?.customer_profile?.cta_btn || "");
      if (user?.job_title) this.updateForm("job_title", user.job_title);
    }
    const savedFormData = JSON.parse(localStorage.getItem("formData")) || {};
    for (const [field, value] of Object.entries(savedFormData)) {
      this.updateForm(field, value);
    }
  },
  methods: {
    onFieldInput(e, fieldName) {
      this.handleInput(e.target.value, fieldName);
      this.clearValidationError(fieldName);
    },
    onShortDescriptionInput(e) {
      this.handleInput(e.target.value, "customer_profile_short_description");
      this.clearValidationError("customer_profile_short_description");
      this.restrictToLength(e, 30, "short");
    },
    onDescriptionInput(e) {
      this.handleInput(e.target.value, "customer_profile_description");
      this.clearValidationError("customer_profile_description");
      this.restrictToLength(e, 300, "detailed");
    },
    onKeywordsInput(e) {
      this.handleInput(e.target.value, "customer_profile_keywords");
      this.clearValidationError("customer_profile_keywords");
      this.restrictToKeywords(e);
    },
    updateForm(field, value) {
      this.$store.commit("signup/setForm", { field: [field], value: value });
      this.$store.commit("signup/removeValidationErros", { field: [field] });
      const formData = JSON.parse(localStorage.getItem("formData")) || {};
      formData[field] = value;
      localStorage.setItem("formData", JSON.stringify(formData));
    },
    handleInput(value, fieldName) {
      this.updateForm(fieldName, value);
    },
    clearValidationError(field) {
      this.$store.commit("signup/removeValidationError", field);
    },
    checkPassword() {
      let password = document.getElementById("password")?.value;
      let password_confirmation = document.getElementById("confirm-password")?.value;
      if (password != password_confirmation) {
        axios.get(`${process.env.MIX_WEB_API_URL}get-password-miss-match-error`).then((res) => {
          if (res.data.status == "Error") {
            this.$store.commit("signup/recordValidationError", { field: "password_confirmation", error: res.data.message });
          }
        });
      } else {
        this.$store.commit("signup/removeValidationErros", { field: ["password_confirmation"] });
      }
    },
    checkIsEmailValid(val) {
      if (val == "") return;
      this.$store.dispatch("signup/checkCustomerEmail", { email: val }).then((res) => console.log(res));
    },
    checkIsCompanyEmailValid(val) {
      if (val == "") return;
      this.$store.dispatch("signup/checkCustomerProfileEmail", { customer_profile_company_email: val }).then((res) => console.log(res));
    },
    handleMailingAddressInput(event) {
      this.restrictToLines(event, 5, "customer_profile_address");
    },
    clearMailingAddressError() {
      this.clearValidationError("customer_profile_address");
      this.$store.commit("signup/removeValidationErros", { field: ["customer_profile_address"] });
    },
    restrictToKeywords(event, maxKeywords = 5, maxWordsPerKeyword = 10) {
      let inputValue = event.target.value;
      let keywordsArray = inputValue.split(/\s*,\s*/).filter((kw) => kw.trim() !== "");
      if (keywordsArray.length > maxKeywords) {
        event.target.value = keywordsArray.slice(0, maxKeywords).join(", ");
        return;
      }
      let lastKeyword = keywordsArray[keywordsArray.length - 1] || "";
      let wordsArray = lastKeyword.split(/\s+/);
      if (wordsArray.length > maxWordsPerKeyword) {
        wordsArray = wordsArray.slice(0, maxWordsPerKeyword);
        keywordsArray[keywordsArray.length - 1] = wordsArray.join(" ");
        event.target.value = keywordsArray.join(", ") + ", ";
        setTimeout(() => {
          event.target.selectionStart = event.target.selectionEnd = event.target.value.length;
        }, 0);
        return;
      }
      this.updateForm("customer_profile_keywords", event.target.value);
    },
    restrictToLength(event, maxWords, fieldName) {
      const inputElement = event.target;
      let val = inputElement.value.trim();
      let words = val.split(/\s+/);
      if (words.length > maxWords) {
        const truncatedText = words.slice(0, maxWords).join(" ") + " ";
        this.updateForm(fieldName === "short" ? "customer_profile_short_description" : "customer_profile_description", truncatedText);
        setTimeout(() => {
          inputElement.value = truncatedText;
          inputElement.setSelectionRange(truncatedText.length, truncatedText.length);
        }, 0);
        event.preventDefault();
      } else {
        this.updateForm(fieldName === "short" ? "customer_profile_short_description" : "customer_profile_description", val);
      }
    },
    restrictToLines(event, maxLines, fieldName) {
      const inputElement = event.target;
      const rawValue = inputElement.value || "";
      const normalizedValue = rawValue.replace(/\r\n/g, "\n");
      const lines = normalizedValue.split(/\n/);
      if (lines.length > maxLines) {
        const truncatedValue = lines.slice(0, maxLines).join("\n");
        inputElement.value = truncatedValue;
        this.updateForm(fieldName, truncatedValue);
        this.$store.commit("signup/recordValidationError", {
          field: fieldName,
          error: `Mailing Address must not contain more than ${maxLines} lines.`,
        });
        return;
      }
      this.clearValidationError(fieldName);
      this.$store.commit("signup/removeValidationErros", { field: [fieldName] });
      this.updateForm(fieldName, rawValue);
    },
    restrictToNumbers(event, allowedLength) {
      const keyCode = event.which ? event.which : event.keyCode;
      const inputChar = String.fromCharCode(keyCode);
      const valid = /^\d$|^[\+\-\(\)]$/.test(inputChar);
      const maxLengthReached = event.target.value.length >= allowedLength;
      if (!valid || maxLengthReached) {
        event.preventDefault();
      }
    },
  },
};
</script>
