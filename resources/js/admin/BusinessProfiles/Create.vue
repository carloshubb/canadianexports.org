<template>
  <AppLayout>
    <div class="relative shadow-md sm:rounded-lg bg-white py-4">
      <header class="pt-4">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <h3 class="can-exp-h3 text-primary">
              {{ isFormEdit ? "Edit" : "Create" }} business profile
            </h3>
            <router-link :to="{ name: 'admin.business-profiles.index' }"
              class="inline-flex items-center button-exp-fill">
              Back
            </router-link>
          </div>
        </div>
      </header>
      <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
        <input type="hidden" :value="limit" />
        <div class="text-sm font-medium text-gray-500 border-b border-gray-200">
          <ul class="block sm:flex flex-wrap mb-2 overflow-x-auto gap-1 space-y-2 md:space-y-0">
            <li class="mr-2">
              <a @click.prevent="activeTab = 'registration-package'" href="#" :class="[
                'inline-block rounded font-FuturaMdCnBT px-5 py-2 lg:text-lg md:text-base sm:text-base text-base hover:bg-blue-100 border border-primary text-center hover:border-blue-500 hover:text-blue-600',
                activeTab == 'registration-package'
                  ? 'bg-blue-600 text-white'
                  : '',
                validationErros.has(`registration_package_id`) ||
                  validationErros.has(`payment_frequency`)
                  ? 'bg-red-600 border-red-600 text-white hover:text-white rounded hover:bg-red-600 hover:border-red-600'
                  : '',
              ]">Registration package</a>
            </li>
            <li class="mr-2">
              <a @click.prevent="activeTab = 'user-profile'" href="#" :class="[
                'inline-block rounded font-FuturaMdCnBT px-5 py-2 lg:text-lg md:text-base sm:text-base text-base hover:bg-blue-100 border border-primary text-center hover:border-blue-500 hover:text-blue-600',
                activeTab == 'user-profile' ? 'bg-blue-600 text-white' : '',
                validationErros.has(`name`) || validationErros.has(`email`) || validationErros.has(`password`) || validationErros.has(`password_confirmation`)
                  ? 'bg-red-600 border-red-600 text-white hover:text-white rounded hover:bg-red-600 hover:border-red-600'
                  : '',
              ]">User Profile</a>
            </li>
            <li class="mr-2">
              <a @click.prevent="activeTab = 'profile'" href="#" :class="[
                'inline-block rounded font-FuturaMdCnBT px-5 py-2 lg:text-lg md:text-base sm:text-base text-base hover:bg-blue-100 border border-primary text-center hover:border-blue-500 hover:text-blue-600',
                activeTab == 'profile' ? 'bg-blue-600 text-white' : '',
                validationErros.has(`company_name`) ||
                  validationErros.has(`company_email`) ||
                  validationErros.has(`website`) ||
                  validationErros.has(`company_phone`) ||
                  //   validationErros.has(`cta_btn`) ||
                  //   validationErros.has(`cta_link`) ||
                  validationErros.has(`short_description`) ||
                  validationErros.has(`description`) ||
                  validationErros.has(`mailing_address`) ||
                  validationErros.has(`keywords`)
                  ? 'bg-red-600 border-red-600 text-white hover:text-white rounded hover:bg-red-600 hover:border-red-600'
                  : '',
              ]">Profile (required)</a>
            </li>
            <li class="mr-2">
              <a @click.prevent="activeTab = 'categories'" href="#" :class="[
                'inline-block rounded font-FuturaMdCnBT px-5 py-2 lg:text-lg md:text-base sm:text-base text-base hover:bg-blue-100 border border-primary text-center hover:border-blue-500 hover:text-blue-600 rounded',
                activeTab == 'categories' ? 'bg-blue-600 text-white' : '',
                validationErros.has(`business_categories_id`)
                  ? 'bg-red-600 border-red-600 text-white hover:text-white rounded hover:bg-red-600 hover:border-red-600'
                  : '',
              ]">Categories (required)</a>
            </li>
            <li class="mr-2">
              <a @click.prevent="activeTab = 'media'" href="#" :class="[
                'inline-block rounded font-FuturaMdCnBT px-5 py-2 lg:text-lg md:text-base sm:text-base text-base hover:bg-blue-100 border border-primary text-center hover:border-blue-500 hover:text-blue-600',
                activeTab == 'media' ? 'bg-blue-600 text-white' : '',
                validationErros.has(`logo`) || validationErros.has(`video`)
                  ? 'bg-red-600 border-red-600 text-white hover:text-white rounded hover:bg-red-600 hover:border-red-600'
                  : '',
              ]">Media (optional)</a>
            </li>
            <li class="mr-2">
              <a @click.prevent="activeTab = 'social_media'" href="#" :class="[
                'inline-block rounded font-FuturaMdCnBT px-5 py-2 lg:text-lg md:text-base sm:text-base text-base hover:bg-blue-100 border border-primary text-center hover:border-blue-500 hover:text-blue-600',
                activeTab == 'social_media' ? 'bg-blue-600 text-white' : '',
                validationErros.has(`facebook`) ||
                  validationErros.has(`twitter`) ||
                  validationErros.has(`youtube`) ||
                  validationErros.has(`linkedin`)
                  ? 'bg-red-600 border-red-600 text-white hover:text-white rounded hover:bg-red-600 hover:border-red-600'
                  : '',
              ]">Social media (optional)</a>
            </li>
          </ul>
        </div>
        <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6"
          :class="activeTab == 'profile' ? 'block' : 'hidden'">
          <div class="relative z-0 w-full group">
            <label for="company_name">Company name</label>
            <input type="text" name="company_name" id="company_name"
              class="can-exp-input w-full block border border-gray-300 rounded" placeholder=" "
              @input="updateForm('company_name', $event.target.value)" :value="form && form.has('company_name') ? form.get('company_name') : ''
                " />

            <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('company_name')"
              v-text="validationErros.get('company_name')"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="company_email">Company email</label>
            <input type="email" name="company_email" id="company_email"
              class="can-exp-input w-full block border border-gray-300 rounded" placeholder=" "
              @input="updateForm('company_email', $event.target.value)" :value="form && form.has('company_email')
                  ? form.get('company_email')
                  : ''
                " />

            <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('company_email')"
              v-text="validationErros.get('company_email')"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="website">Website</label>
            <input type="text" name="website" id="website"
              class="can-exp-input w-full block border border-gray-300 rounded"
              @input="updateForm('website', $event.target.value)"
              :value="form && form.has('website') ? form.get('website') : ''" />

            <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('website')"
              v-text="validationErros.get('website')"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="company_phone">Company phone</label>
            <input type="text" name="company_phone" id="company_phone"
              class="can-exp-input w-full block border border-gray-300 rounded" placeholder=" "
              @input="updateForm('company_phone', $event.target.value)" :value="form && form.has('company_phone')
                  ? form.get('company_phone')
                  : ''
                " />

            <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('company_phone')"
              v-text="validationErros.get('company_phone')"></p>
          </div>
          <!-- <div class="relative z-0 w-full group">
            <label for="cta_btn">Cta Btn</label>
            <input
              type="text"
              name="cta_btn"
              id="cta_btn"
              class="can-exp-input w-full block border border-gray-300 rounded"
              placeholder=" "
              @input="updateForm('cta_btn', $event.target.value)"
              :value="
                form && form.has('cta_btn')
                  ? form.get('cta_btn')
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="validationErros.has('cta_btn')"
              v-text="validationErros.get('cta_btn')"
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="cta_link">Cta link</label>
            <input
              type="text"
              name="cta_link"
              id="cta_link"
              class="can-exp-input w-full block border border-gray-300 rounded"
              placeholder=" "
              @input="updateForm('cta_link', $event.target.value)"
              :value="
                form && form.has('cta_link')
                  ? form.get('cta_link')
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="validationErros.has('cta_link')"
              v-text="validationErros.get('cta_link')"
            ></p>
          </div> -->
          <div class="relative z-0 w-full group">
            <label for="short_description">Short description</label>
            <textarea name="short_description" id="short_description"
              class="can-exp-input w-full block border border-gray-300 rounded" placeholder=" "
              @input="updateForm('short_description', $event.target.value)" v-text="form && form.has('short_description')
                  ? form.get('short_description')
                  : ''
                "></textarea>

            <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('short_description')"
              v-text="validationErros.get('short_description')"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="description">Description</label>
            <textarea name="description" id="description"
              class="can-exp-input w-full block border border-gray-300 rounded" placeholder=" "
              @input="updateForm('description', $event.target.value)" v-text="form && form.has('description') ? form.get('description') : ''
                "></textarea>

            <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('description')"
              v-text="validationErros.get('description')"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="mailing_address">Mailing address</label>
            <textarea name="mailing_address" id="mailing_address"
              class="can-exp-input w-full block border border-gray-300 rounded" placeholder=" "
              @input="updateForm('mailing_address', $event.target.value)" v-text="form && form.has('mailing_address')
                  ? form.get('mailing_address')
                  : ''
                "></textarea>

            <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('mailing_address')"
              v-text="validationErros.get('mailing_address')"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="keywords">Keywords</label>
            <textarea name="keywords" id="keywords" class="can-exp-input w-full block border border-gray-300 rounded"
              placeholder=" " @input="updateForm('keywords', $event.target.value)"
              v-text="form && form.has('keywords') ? form.get('keywords') : ''"></textarea>

            <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('keywords')"
              v-text="validationErros.get('keywords')"></p>
          </div>
        </div>
        <div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-3 py-3 mb-6"
            :class="activeTab == 'categories' ? 'block' : 'hidden'">
            <p class="mt-2 text-sm text-red-400 col-span-2" v-if="validationErros.has('business_categories_id')"
              v-text="validationErros.get('business_categories_id')"></p>
            <div class="flex items-center" v-for="business_category in business_categories" :key="business_category.id">
              <input :id="`business-category-${business_category.id}`" type="checkbox" :value="business_category.id"
                class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary" @input="
                  updateBusinessCategories(
                    $event.target.checked,
                    business_category.id
                  )
                  " :checked="form &&
                    form.has('business_categories_id') &&
                    JSON.parse(form.get('business_categories_id')).indexOf(
                      business_category.id
                    ) != -1
                    ? true
                    : false
                  " />
              <label :for="`business-category-${business_category.id}`" class="ml-2 text-gray-900">{{
                business_category.business_category_detail &&
                  business_category.business_category_detail[0]
                  ? business_category.business_category_detail[0].name
                  : ""
              }}</label>
            </div>
          </div>
        </div>

        <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6"
          :class="activeTab == 'registration-package' ? 'block' : 'hidden'">
          <div class="relative z-0 w-full group">
            <label for="registration_package_id"> Package </label>
            <select id="registration_package_id" class="can-exp-input w-full block border border-gray-300 rounded"
              @input="
                updatePackageForm(
                  'registration_package_id',
                  $event.target.value
                )
                ">
              <option value="">Select package...</option>
              <option :value="p.id" v-for="p in packages" :key="p.id" :selected="form &&
                form.has('registration_package_id') &&
                form.get('registration_package_id') == p.id
                ">
                {{ p?.registration_package_detail?.[0]?.name }}
              </option>
            </select>

            <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('registration_package_id')"
              v-text="validationErros.get('registration_package_id')"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="payment_frequency"> Payment frequency </label>
            <select id="payment_frequency" class="can-exp-input w-full block border border-gray-300 rounded"
              @input="updateForm('payment_frequency', $event.target.value)">
              <option value="">Select payment frequency...</option>
              <option value="monthly" :selected="form &&
                form.has('payment_frequency') &&
                form.get('payment_frequency') == 'monthly'
                ">
                Monthly
              </option>
              <option value="quarterly" :selected="form &&
                form.has('payment_frequency') &&
                form.get('payment_frequency') == 'quarterly'
                ">
                Quarterly
              </option>
              <option value="semi_annually" :selected="form &&
                form.has('payment_frequency') &&
                form.get('payment_frequency') == 'semi_annually'
                ">
                Semi annually
              </option>
              <option value="annually" :selected="form &&
                form.has('payment_frequency') &&
                form.get('payment_frequency') == 'annually'
                ">
                Annually
              </option>
            </select>

            <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('payment_frequency')"
              v-text="validationErros.get('payment_frequency')"></p>
          </div>
          <!-- <div class="relative z-0 w-full group" v-if="isFormEdit">
  <label for="visitor_count">Visitor Count</label>
  <input
    id="visitor_count"
    type="text"
    class="can-exp-input w-full block border border-gray-300 rounded bg-gray-100 cursor-not-allowed"
    :value="form.get('visitor_count')"
    disabled
  />
</div> -->

        </div>

        <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6"
          :class="activeTab == 'user-profile' ? 'block' : 'hidden'">
          <div class="relative z-0 w-full group">
            <label for="name">Your name and title</label>
            <input type="text" name="name" id="name" class="can-exp-input w-full block border border-gray-300 rounded"
              placeholder=" " @input="updateForm('name', $event.target.value)"
              :value="form && form.has('name') ? form.get('name') : ''" />

            <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('name')"
              v-text="validationErros.get('name')"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="email">Your email</label>
            <input type="text" name="email" id="email" class="can-exp-input w-full block border border-gray-300 rounded"
              placeholder=" " @input="updateForm('email', $event.target.value)"
              :value="form && form.has('email') ? form.get('email') : ''" />

            <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('email')"
              v-text="validationErros.get('email')"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="password">Password</label>
            <div class="relative">
              <input :type="display_password" name="password" id="password"
                class="can-exp-input w-full block border border-gray-300 rounded" placeholder=" "
                @input="updateForm('password', $event.target.value)" />
              <svg class="w-5 h-5 text-gray-500 absolute top-3 right-3" @click="display_password = 'text'"
                v-if="display_password == 'password'" viewBox="0 0 51 35" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_1249_2209)">
                  <path
                    d="M28.22 0.59C27.73 0.53 27.24 0.49 26.75 0.43H24.2C23.63 0.5 23.06 0.56 22.49 0.63C18.95 1.07 15.69 2.29 12.64 4.13C8.56 6.6 5.23 9.88 2.39 13.68C1.62 14.71 0.93 15.8 0.21 16.86C0.14 16.95 0.07 17.04 0 17.13V17.21C0.69 18.22 1.35 19.25 2.08 20.23C4.89 24.01 8.16 27.31 12.15 29.86C12.19 29.89 12.23 29.91 12.27 29.93C12.33 29.8 12.4 29.69 12.48 29.57L15.51 24.97C14.14 22.86 13.27 20.55 13.11 17.99C12.67 11.02 17.98 5.1 24.95 4.8C26.2 4.75 27.39 4.88 28.54 5.16L31.18 1.16C30.21 0.91 29.23 0.72 28.22 0.59ZM49.22 14.6C46.3 10.58 42.89 7.08 38.68 4.43C38.61 4.55 38.55 4.65 38.48 4.76L35.45 9.37C35.78 9.87 36.07 10.4 36.34 10.94C37.91 14.11 38.37 17.4 37.33 20.82C35.74 26.05 30.92 29.58 24.98 29.58C24.12 29.57 23.24 29.45 22.37 29.24L19.77 33.2C20.51 33.4 21.27 33.55 22.04 33.67C22.64 33.76 23.25 33.83 23.85 33.91H27.11C27.62 33.84 28.13 33.78 28.64 33.71C32.31 33.22 35.68 31.91 38.8 29.93C43.22 27.13 46.74 23.41 49.69 19.12C50.12 18.49 50.54 17.84 50.96 17.21V17.13C50.38 16.29 49.82 15.43 49.22 14.6ZM37.38 3.65C37.34 3.75 37.28 3.85 37.22 3.94L34.46 8.13L20.88 28.78L18.26 32.77L17.98 33.19C17.49 33.93 16.68 34.34 15.85 34.34C15.37 34.34 14.89 34.2 14.46 33.92C13.39 33.21 13.02 31.83 13.56 30.7C13.61 30.6 13.67 30.5 13.73 30.4L16.47 26.24L30.04 5.61L32.69 1.6L32.98 1.15C33.47 0.41 34.28 0 35.1 0C35.58 0 36.07 0.14 36.5 0.42C37.58 1.13 37.93 2.52 37.38 3.65Z"
                    fill="currentcolor" />
                </g>
                <defs>
                  <clipPath id="clip0_1249_2209">
                    <rect width="50.96" height="34.34" fill="currentcolor" />
                  </clipPath>
                </defs>
              </svg>
              <svg class="w-5 h-5 text-gray-500 absolute top-3 right-3" @click="display_password = 'password'"
                v-else-if="display_password == 'text'" viewBox="0 0 51 34" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_1248_2207)">
                  <path
                    d="M50.96 16.7C50.96 16.72 50.96 16.75 50.96 16.77C50.54 17.41 50.13 18.05 49.69 18.68C46.74 22.97 43.22 26.69 38.8 29.49C35.68 31.46 32.31 32.77 28.64 33.26C28.13 33.33 27.62 33.39 27.11 33.46C26.02 33.46 24.94 33.46 23.85 33.46C23.25 33.38 22.64 33.31 22.04 33.22C18.47 32.67 15.19 31.35 12.15 29.41C8.16 26.86 4.89 23.57 2.08 19.78C1.36 18.82 0.69 17.78 0 16.77C0 16.75 0 16.72 0 16.7C0.07 16.61 0.15 16.52 0.21 16.42C0.93 15.36 1.62 14.27 2.39 13.24C5.23 9.44 8.57 6.16 12.65 3.69C15.69 1.85 18.96 0.64 22.5 0.2C23.07 0.13 23.64 0.07 24.21 0C25.06 0 25.91 0 26.76 0C27.25 0.05 27.74 0.1 28.22 0.16C31.57 0.58 34.7 1.67 37.63 3.35C42.33 6.06 46.07 9.81 49.23 14.17C49.82 15 50.38 15.86 50.96 16.7ZM24.98 29.15C30.92 29.15 35.74 25.62 37.33 20.39C38.37 16.97 37.92 13.67 36.34 10.51C35.58 8.98 34.69 7.57 33.14 6.66C30.6 5.17 27.94 4.24 24.96 4.37C17.99 4.68 12.67 10.59 13.12 17.56C13.3 20.43 14.37 22.98 16.03 25.3C16.26 25.62 16.55 25.92 16.87 26.15C19.42 28.02 22.25 29.12 24.98 29.15Z"
                    fill="currentcolor" />
                </g>
                <defs>
                  <clipPath id="clip0_1248_2207">
                    <rect width="50.96" height="33.48" fill="currentcolor" />
                  </clipPath>
                </defs>
              </svg>
            </div>
            <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('password')"
              v-text="validationErros.get('password')"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="password_confirmation">Password confirmation</label>
            <div class="relative">
              <input :type="display_confirm_password" name="password_confirmation" id="password_confirmation"
                class="can-exp-input w-full block border border-gray-300 rounded" placeholder=" " @input="
                  updateForm('password_confirmation', $event.target.value)
                  " />
              <svg class="w-5 h-5 text-gray-500 absolute top-3 right-3" @click="display_confirm_password = 'text'"
                v-if="display_confirm_password == 'password'" viewBox="0 0 51 35" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_1249_2209)">
                  <path
                    d="M28.22 0.59C27.73 0.53 27.24 0.49 26.75 0.43H24.2C23.63 0.5 23.06 0.56 22.49 0.63C18.95 1.07 15.69 2.29 12.64 4.13C8.56 6.6 5.23 9.88 2.39 13.68C1.62 14.71 0.93 15.8 0.21 16.86C0.14 16.95 0.07 17.04 0 17.13V17.21C0.69 18.22 1.35 19.25 2.08 20.23C4.89 24.01 8.16 27.31 12.15 29.86C12.19 29.89 12.23 29.91 12.27 29.93C12.33 29.8 12.4 29.69 12.48 29.57L15.51 24.97C14.14 22.86 13.27 20.55 13.11 17.99C12.67 11.02 17.98 5.1 24.95 4.8C26.2 4.75 27.39 4.88 28.54 5.16L31.18 1.16C30.21 0.91 29.23 0.72 28.22 0.59ZM49.22 14.6C46.3 10.58 42.89 7.08 38.68 4.43C38.61 4.55 38.55 4.65 38.48 4.76L35.45 9.37C35.78 9.87 36.07 10.4 36.34 10.94C37.91 14.11 38.37 17.4 37.33 20.82C35.74 26.05 30.92 29.58 24.98 29.58C24.12 29.57 23.24 29.45 22.37 29.24L19.77 33.2C20.51 33.4 21.27 33.55 22.04 33.67C22.64 33.76 23.25 33.83 23.85 33.91H27.11C27.62 33.84 28.13 33.78 28.64 33.71C32.31 33.22 35.68 31.91 38.8 29.93C43.22 27.13 46.74 23.41 49.69 19.12C50.12 18.49 50.54 17.84 50.96 17.21V17.13C50.38 16.29 49.82 15.43 49.22 14.6ZM37.38 3.65C37.34 3.75 37.28 3.85 37.22 3.94L34.46 8.13L20.88 28.78L18.26 32.77L17.98 33.19C17.49 33.93 16.68 34.34 15.85 34.34C15.37 34.34 14.89 34.2 14.46 33.92C13.39 33.21 13.02 31.83 13.56 30.7C13.61 30.6 13.67 30.5 13.73 30.4L16.47 26.24L30.04 5.61L32.69 1.6L32.98 1.15C33.47 0.41 34.28 0 35.1 0C35.58 0 36.07 0.14 36.5 0.42C37.58 1.13 37.93 2.52 37.38 3.65Z"
                    fill="currentcolor" />
                </g>
                <defs>
                  <clipPath id="clip0_1249_2209">
                    <rect width="50.96" height="34.34" fill="currentcolor" />
                  </clipPath>
                </defs>
              </svg>
              <svg class="w-5 h-5 text-gray-500 absolute top-3 right-3" @click="display_confirm_password = 'password'"
                v-else-if="display_confirm_password == 'text'" viewBox="0 0 51 34" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_1248_2207)">
                  <path
                    d="M50.96 16.7C50.96 16.72 50.96 16.75 50.96 16.77C50.54 17.41 50.13 18.05 49.69 18.68C46.74 22.97 43.22 26.69 38.8 29.49C35.68 31.46 32.31 32.77 28.64 33.26C28.13 33.33 27.62 33.39 27.11 33.46C26.02 33.46 24.94 33.46 23.85 33.46C23.25 33.38 22.64 33.31 22.04 33.22C18.47 32.67 15.19 31.35 12.15 29.41C8.16 26.86 4.89 23.57 2.08 19.78C1.36 18.82 0.69 17.78 0 16.77C0 16.75 0 16.72 0 16.7C0.07 16.61 0.15 16.52 0.21 16.42C0.93 15.36 1.62 14.27 2.39 13.24C5.23 9.44 8.57 6.16 12.65 3.69C15.69 1.85 18.96 0.64 22.5 0.2C23.07 0.13 23.64 0.07 24.21 0C25.06 0 25.91 0 26.76 0C27.25 0.05 27.74 0.1 28.22 0.16C31.57 0.58 34.7 1.67 37.63 3.35C42.33 6.06 46.07 9.81 49.23 14.17C49.82 15 50.38 15.86 50.96 16.7ZM24.98 29.15C30.92 29.15 35.74 25.62 37.33 20.39C38.37 16.97 37.92 13.67 36.34 10.51C35.58 8.98 34.69 7.57 33.14 6.66C30.6 5.17 27.94 4.24 24.96 4.37C17.99 4.68 12.67 10.59 13.12 17.56C13.3 20.43 14.37 22.98 16.03 25.3C16.26 25.62 16.55 25.92 16.87 26.15C19.42 28.02 22.25 29.12 24.98 29.15Z"
                    fill="currentcolor" />
                </g>
                <defs>
                  <clipPath id="clip0_1248_2207">
                    <rect width="50.96" height="33.48" fill="currentcolor" />
                  </clipPath>
                </defs>
              </svg>
            </div>
            <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('password_confirmation')"
              v-text="validationErros.get('password_confirmation')"></p>
          </div>
        </div>

        <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6"
          :class="activeTab == 'media' ? 'block' : 'hidden'">
          <div class="relative z-0 w-full group">
            <label for="media_title">Title of the media section (Max.10 words)</label>
            <textarea name="media_title" id="media_title"
              class="can-exp-input w-full block border border-gray-300 rounded" placeholder=" "
              @input="updateForm('media_title', $event.target.value)" v-text="form && form.has('media_title') ? form.get('media_title') : ''
                "></textarea>

            <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('media_title')"
              v-text="validationErros.get('media_title')"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="media_description">Description of the media section (Max.50 words)</label>
            <textarea name="media_description" id="media_description"
              class="can-exp-input w-full block border border-gray-300 rounded" placeholder=" "
              @input="updateForm('media_description', $event.target.value)" v-text="form && form.has('media_description')
                  ? form.get('media_description')
                  : ''
                "></textarea>
            <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('media_description')"
              v-text="validationErros.get('media_description')"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="video">Welcome video1</label>
            <input type="text" name="video" id="video" class="can-exp-input w-full block border border-gray-300 rounded"
              placeholder=" " @input="updateForm('video', $event.target.value)" :value="form && form.has('video')
                ? form.get('video')
                : ''" />

            <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('video')"
              v-text="validationErros.get('video')"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="logo">Logo</label>
            <FilePond class="cursor-pointer" name="logo" class-name="my-pond" accepted-file-types="image/*"
              credits="false" :labelIdle="`<span class='cursor-pointer'>Drag and drop or browse</span>`" ref="logo"
              v-bind:files="files" @init="handleLogoInit" @processfile="handleLogoProcess"
              @removefile="handleLogoRemoveFile" />

            <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('logo')"
              v-text="validationErros.get('logo')"></p>
          </div>
          <div class="relative w-full mb-3" v-if="max_files > 0">
            <label class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg" for="gallery-images">
              Images (Files must be less than 5MB. Allowed file types: PNG, GIF,
              JPG, JPEG). Maximum number of images allowed:
              {{ max_files }}</label>
            <FilePond name="gallery_images" class-name="my-pond xelent-pond" accepted-file-types="image/*"
              allow-multiple="true" ref="gallery_images" credits="false"
              :labelIdle="`<span class='cursor-pointer'>Drag and drop or browse</span>`" :max-files="max_files"
              :max-parallel-uploads="max_files" v-bind:files="gallery_files" @init="handleGalleryImagesInit"
              @initfile="handleGalleryImagesInitFile" @warning="handleGalleryImagesWarning"
              @processfile="handleGalleryImagesProcess" @removefile="handleGalleryImagesRemoveFile" />

            <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('gallery_images')"
              v-text="validationErros.get('gallery_images')"></p>
          </div>
        </div>

        <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6"
          :class="activeTab == 'social_media' ? 'block' : 'hidden'">
          <div class="relative z-0 w-full group">
            <label for="facebook">Facebook</label>
            <input type="text" name="facebook" id="facebook"
              class="can-exp-input w-full block border border-gray-300 rounded" placeholder=" "
              @input="updateForm('facebook', $event.target.value)"
              :value="form && form.has('facebook') ? form.get('facebook') : ''" />

            <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('facebook')"
              v-text="validationErros.get('facebook')"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="twitter">Twitter</label>
            <input type="text" name="twitter" id="twitter"
              class="can-exp-input w-full block border border-gray-300 rounded" placeholder=" "
              @input="updateForm('twitter', $event.target.value)"
              :value="form && form.has('twitter') ? form.get('twitter') : ''" />

            <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('twitter')"
              v-text="validationErros.get('twitter')"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="youtube">Youtube</label>
            <input type="text" name="youtube" id="youtube"
              class="can-exp-input w-full block border border-gray-300 rounded" placeholder=" "
              @input="updateForm('youtube', $event.target.value)"
              :value="form && form.has('youtube') ? form.get('youtube') : ''" />

            <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('youtube')"
              v-text="validationErros.get('youtube')"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="linkedin">Linkedin</label>
            <input type="text" name="linkedin" id="linkedin"
              class="can-exp-input w-full block border border-gray-300 rounded" placeholder=" "
              @input="updateForm('linkedin', $event.target.value)"
              :value="form && form.has('linkedin') ? form.get('linkedin') : ''" />

            <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('linkedin')"
              v-text="validationErros.get('linkedin')"></p>
          </div>
        </div>

        <button type="submit" class="button-exp-fill" :disabled="loading">
          Submit
        </button>
      </form>
    </div>
  </AppLayout>
</template>

<script>
import { mapState } from "vuex";
// Import filepond
import vueFilePond, { setOptions } from "vue-filepond";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js";
import FilePondPluginImagePreview from "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview
);

export default {
  components: {
    FilePond,
  },
  computed: {
    ...mapState({
      loading: (state) => state.business_profiles.loading,
      isFormEdit: (state) => state.business_profiles.isFormEdit,
      form: (state) => state.business_profiles.form,
      limit: (state) => state.business_profiles.limit,
      validationErros: (state) => state.business_profiles.validationErros,
      business_categories: (state) =>
        state.business_categories.business_categories,
    }),
  },
  data() {
    return {
      activeTab: "registration-package",
      addNewUser: false,
      customers: [],
      packages: [],
      max_files: 0,
      gallery_files: [],
      files: [],
      display_password: "password",
      display_confirm_password: "password",
    };
  },
  methods: {
    updateMedia(field, value) {
      if (field == "video") {
        this.$store.commit("business_profiles/setForm", {
          field: [field],
          value: value,
        });
      } else {
        if (value[0]) {
          this.$store.commit("business_profiles/setForm", {
            field: [field],
            value: value[0],
          });
        }
      }
    },
    updateBusinessCategories(checked, value) {
      let type = checked ? "add" : "remove";
      let totalBusinessCategiroes = 0;
      if (this.form && this.form.has("business_categories_id")) {
        let business_categories_id = this.form.get("business_categories_id");
        totalBusinessCategiroes = JSON.parse(business_categories_id).length;
      }
      if (totalBusinessCategiroes > 2) {
        this.$store.commit("business_profiles/setBusinessCategoriesForm", {
          value: value,
          type: "remove",
        });
        this.$store.commit("business_profiles/updateValidationErros", {
          field: "business_categories_id",
          message:
            "Please limit your selection to a maximum of 3 business categories.",
        });
        document.getElementById(`business-category-${value}`).checked = false;
        return false;
      } else {
        this.$store.commit("business_profiles/setBusinessCategoriesForm", {
          value: value,
          type: type,
        });
      }
    },
    updatePackageForm(field, value) {
      let p = this.packages.filter((res) => {
        return value == res.id;
      });
      this.$store.commit("business_profiles/setForm", {
        field: "registration_package_id",
        value: p?.[0]?.id,
      });
      this.max_files = p?.[0]?.images_allowed || 0;
    },
    updateForm(field, value) {
      if (field === "name") value = value.replace(/[^a-zA-Z\s-]/g, '');
      this.$store.commit("business_profiles/setForm", {
        field: [field],
        value: value,
      });
    },
    addUpdateForm() {
      this.updateForm("add_new_user", this.addNewUser ? this.addNewUser : null);
      this.$store
        .dispatch("business_profiles/addUpdateForm")
        .then(() =>
          this.$router.push({ name: "admin.business-profiles.index" })
        );
    },
    handleLogoInit() {
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
      this.updateForm("logo", file.serverId);
      this.$store.commit("business_profiles/removeValidationErros", {
        field: "logo",
      });
    },
    handleLogoRemoveFile(error, file) {
      this.updateForm("logo", "");
    },
    handleGalleryImagesInit() {
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
    handleGalleryImagesInitFile(file) {
      this.$store.commit("business_profiles/removeValidationErros", {
        field: "gallery_images",
      });
    },
    handleGalleryImagesWarning(error, file, status) {
      if (error.code === 0) {
        this.$store.commit("business_profiles/updateValidationErros", {
          field: "gallery_images",
          message: `Please limit the number of your images to ${this.max_files}`,
        });
      }
    },
    handleGalleryImagesProcess(error, file) {
      this.$store.commit("business_profiles/setGalleryImages", {
        type: "add",
        value: JSON.parse(file.serverId)[0],
      });
      this.$store.commit("business_profiles/removeValidationErros", {
        field: "gallery_images",
      });
    },
    handleGalleryImagesRemoveFile(error, file) {
      // console.log('handleGalleryImagesRemoveFile', error);
      if (this.$route.params.id) {
        if (file.getMetadata() && file.getMetadata().serverId) {
          this.$store.commit("business_profiles/setGalleryImages", {
            type: "remove",
            value: file.getMetadata().serverId,
          });
        }
      } else {
        this.$store.commit("business_profiles/setGalleryImages", {
          type: "remove",
          value: JSON.parse(file.serverId)[0],
        });
      }
    },
  },
  created() {
    this.$store.commit("business_profiles/resetForm");
    this.$store.dispatch("business_categories/fetchBusinessCategories", {
      url: `${process.env.MIX_ADMIN_API_URL}business-categories?getAll=1`,
    });
    this.$store.dispatch("users/fetchUsersWithNoProfile").then((res) => {
      if (res?.data?.status == "Success") {
        this.customers = res.data.data;
        this.$store
          .dispatch("registration_packages/fetchRegistrationPackages", {
            url: `${process.env.MIX_ADMIN_API_URL}registration-packages?getProfilePackagesOnly=1&getAll=1`,
          })
          .then((result) => {
            if (result?.data?.status == "Success") {
              this.packages = result.data.data;
              if (this.$route.params.id) {
                let id = this.$route.params.id;
                this.$store.commit("business_profiles/setIsFormEdit", 1);
                this.$store
                  .dispatch("business_profiles/fetchBusinessProfile", {
                    url: `${process.env.MIX_ADMIN_API_URL}business-profiles/${id}?withCustomerBusinessCategory=1&withCustomerMedia=1&withCustomerSocialMedia=1&withCustomer=1`,
                  })
                  .then((res) => {
                    if (res.data.status == "Success") {
                      let customerProfile = res.data.data;
                      this.updateForm("id", customerProfile.id);
                      this.updateForm(
                        "mailing_address",
                        customerProfile.address
                      );
                      this.updateForm(
                        "company_email",
                        customerProfile.company_email
                      );
                      this.updateForm(
                        "company_name",
                        customerProfile.company_name
                      );
                      this.updateForm(
                        "description",
                        customerProfile.description
                      );
                      this.updateForm("keywords", customerProfile.keywords);
                      this.updateForm("company_phone", customerProfile.phone);
                      this.updateForm(
                        "short_description",
                        customerProfile.short_description
                      );
                      this.updateForm("website", customerProfile.website);
                      //   this.updateForm("cta_link", customerProfile.cta_link);
                      //   this.updateForm("cta_btn", customerProfile.cta_btn);
                      if (customerProfile.customer_business_categories) {
                        customerProfile.customer_business_categories.map(
                          (res) => {
                            this.updateBusinessCategories(
                              1,
                              res.business_category_id
                            );
                          }
                        );
                      }
                      this.updateMedia(
                        "video",
                        customerProfile?.customer_media?.video
                        || ""
                      );

                      this.updateForm(
                        "facebook",
                        customerProfile?.customer_social_media?.facebook
                        || ""
                      );
                      //   this.updateForm("visitor_count", customerProfile?.visitor_count || 0);

                      this.updateForm(
                        "linkedin",
                        customerProfile?.customer_social_media?.linked_in
                        || ""
                      );
                      this.updateForm(
                        "twitter",
                        customerProfile?.customer_social_media?.twitter
                        || ""
                      );
                      this.updateForm(
                        "youtube",
                        customerProfile?.customer_social_media?.youtube
                        || ""
                      );
                      this.updateForm(
                        "customer_id",
                        customerProfile?.customer_id
                      );
                      this.updateForm("name", customerProfile?.customer?.name || '');
                      this.updateForm(
                        "email",
                        customerProfile?.customer?.email || ''
                      );
                      this.updatePackageForm(
                        "registration_package_id",
                        customerProfile?.customer?.registration_package_id ||
                        null
                      );
                      this.updateForm(
                        "payment_frequency",
                        customerProfile?.customer?.payment_frequency || null
                      );
                      this.$store.commit("business_profiles/setLimit", 100);

                      this.gallery_files = [];
                      this.files = [];
                      this.updateForm(
                        "media_title",
                        customerProfile?.customer_media?.title || ''
                      );
                      this.updateForm(
                        "media_description",
                        customerProfile?.customer_media?.description || ''
                      );
                      if (
                        customerProfile?.customer_media &&
                        customerProfile?.customer_media?.customer_logo
                      ) {
                        this.files.push({
                          source:
                            customerProfile?.customer_media?.customer_logo
                              .base64,
                          options: {
                            type: "local",
                            metadata: {
                              poster:
                                customerProfile?.customer_media?.customer_logo
                                  .base64,
                            },
                          },
                        });
                        this.updateForm(
                          "customer_media_logo",
                          JSON.stringify([
                            customerProfile?.customer_media?.customer_logo
                              ?.path,
                          ])
                        );
                      }
                      if (
                        customerProfile?.customer_media &&
                        customerProfile?.customer_media?.customer_gallery_images
                      ) {
                        let images =
                          customerProfile?.customer_media
                            ?.customer_gallery_images;
                        images.map((image) => {
                          if (image.media) {
                            this.gallery_files.push({
                              source: image.media.base64,
                              options: {
                                type: "local",
                                metadata: {
                                  serverId: image.media.path,
                                  poster: image.media.base64,
                                },
                              },
                            });
                          }
                        });
                        this.$store.commit(
                          "business_profiles/resetGalleryImages"
                        );
                        images.map((image) => {
                          if (image.media) {
                            this.$store.commit(
                              "business_profiles/setGalleryImages",
                              {
                                type: "add",
                                value: image.media.path,
                              }
                            );
                          }
                        });
                      }
                    }
                  });
              }
            }
          });
      }
    });
  },
};
</script>
<style scoped>
/**
 * FilePond Custom Styles
 */
.filepond--drop-label {
  color: #4c4e53;
}

.filepond--label-action {
  text-decoration-color: #babdc0;
}

.filepond--panel-root {
  border-radius: 2em;
  background-color: #edf0f4;
  height: 1em;
}

.filepond--item-panel {
  background-color: #595e68;
}

.filepond--drip-blob {
  background-color: #7f8a9a;
}
</style>
