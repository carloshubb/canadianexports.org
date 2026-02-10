<template>
  <AppLayout>
    <div class="relative shadow-md sm:rounded-lg bg-white py-4">
      <header class="pt-4">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <div class="sm:flex-auto">
              <h1 class="can-exp-h3 mb-0 text-primary">
                {{ isFormEdit ? "Edit" : "Create" }} page
              </h1>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
              <router-link :to="{ name: 'admin.pages.index' }" class="button-exp-fill">
                Back to list of pages
              </router-link>
            </div>
          </div>
        </div>
      </header>

      <!-- Excel multi-language section: only when a template is selected -->
      <div v-if="form.template != null && form.template !== ''" class="px-4 md:px-6 lg:px-8 mt-6 mb-6">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-lg p-6 shadow-sm">
          <div class="flex items-center mb-4">
            <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
            </svg>
            <h4 class="text-xl font-bold text-gray-800">Multi-language Excel – template settings</h4>
          </div>
          <p class="text-sm text-gray-600 mb-4">
            Download an Excel file with all template fields and one column per language. Edit the values, then upload to
            update all translations at once.
          </p>
          <p v-if="!form.id" class="text-sm text-amber-700 bg-amber-50 border border-amber-200 rounded p-3 mb-4">
            Save the page first to enable download and upload.
          </p>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- File Upload -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                Upload Excel file <span class="text-red-500">*</span>
              </label>
              <input type="file" ref="excelFile" @change="handleFileChange" accept=".xlsx,.xls"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                :class="{ 'border-red-500': excelValidationErrors.excel_file }"
                :disabled="!form.id" />
              <p v-if="excelValidationErrors.excel_file" class="text-red-500 text-xs mt-1">
                {{ excelValidationErrors.excel_file }}
              </p>
              <p class="text-xs text-gray-500 mt-1">Supported: .xlsx, .xls (Max: 5MB)</p>
            </div>

            <!-- Upload Button -->
            <div class="flex items-end">
              <button type="button" @click="uploadExcelFile" :disabled="excelUploading || !form.id"
                class="w-full px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 flex items-center justify-center">
                <svg v-if="excelUploading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                  </path>
                </svg>
                <span v-if="excelUploading">Uploading...</span>
                <span v-else>
                  <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                  </svg>
                  Upload Excel
                </span>
              </button>
            </div>
          </div>

          <!-- Download Template Link -->
          <div class="mt-4 pt-4 border-t border-blue-200">
            <div class="flex items-center justify-between">
              <div class="flex items-center text-sm text-gray-600">
                <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="font-medium">Download current template fields with all languages.</span>
              </div>
              <a v-if="form.id"
                :href="`${mixAdminApiUrl}page-setting-detail/export-xls?page_id=${form.id}&template=${encodeURIComponent(form.template)}`"
                target="_blank"
                class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Download Excel
              </a>
              <span v-else class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-500 text-sm rounded-lg cursor-not-allowed">
                Save page to download
              </span>
            </div>
          </div>

          <!-- Excel Validation Errors Display -->
          <div v-if="excelErrors.length > 0" class="mt-4 bg-red-50 border-l-4 border-red-500 p-4 rounded">
            <div class="flex items-start">
              <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <div class="flex-1">
                <h5 class="text-red-800 font-semibold mb-2">Validation errors:</h5>
                <ul class="list-disc list-inside space-y-1">
                  <li v-for="(error, index) in excelErrors" :key="index" class="text-sm text-red-700">
                    {{ typeof error === 'string' ? error : `Row ${error.row}: ${error.attribute} - ${(error.errors || []).join(', ')}` }}
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Excel multi-language section -->
      <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
        <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200">
          <ul class="flex flex-wrap mb-2 overflow-x-auto gap-1 mt-4">
            <li class="mr-2" v-for="language in languages" :key="language.id">
              <a @click.prevent="changeLanguageTab(language)" href="#" :class="[
                'inline-block rounded font-FuturaMdCnBT px-5 py-2 lg:text-lg md:text-base sm:text-base text-base hover:bg-blue-100 border border-primary text-center hover:border-blue-500 hover:text-blue-600',
                (selectedLanguageId == null && language.is_default) ||
                  selectedLanguageId == language.id
                  ? 'bg-blue-600 text-white'
                  : '',
                validationErros.has(`name.name_${language.id}`)
                  ? 'bg-red-600 border-red-600 text-white hover:text-white rounded hover:bg-red-600 hover:border-red-600'
                  : '',
              ]">{{ language.name }}</a>
            </li>
          </ul>
        </div>

        <div class="mx-auto grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 mt-4"
          v-for="(language, languageIndex) in languages" :key="language.id" :class="(selectedLanguageId == null && language.is_default) ||
            selectedLanguageId == language.id
            ? 'block'
            : 'hidden'
            ">
          <div class="col-span-6 sm:col-span-3">
            <div class="rounded-lg bg-gray-50 shadow-sm ring-1 ring-gray-900/5">
              <dl class="flex flex-wrap">
                <div class="flex-auto pl-6 pt-6">
                  <span class="text-sm font-semibold leading-6 text-gray-900">Page Settings</span>
                </div>

                <div class="mt-4 w-full border-t border-gray-900/5 px-6 pt-4">
                  <div>
                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Page name</label>
                    <div class="mt-2">
                      <input type="text" name="name" id="name" autocomplete="page-name"
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        placeholder=" " @input="
                          handleInput($event.target.value, language, 'name')
                          " :value="form['name'] && form['name'][`name_${language.id}`]
                            ? form['name'][`name_${language.id}`]
                            : ''
                            " :disabled="isFormEdit" />
                      <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`name.name_${language.id}`)"
                        v-text="validationErros.get(`name.name_${language.id}`)"></p>
                    </div>
                  </div>
                  <div class="mt-4">
                    <div class="flex items-center justify-between">
                      <label for="template" class="block text-sm font-medium leading-6 text-gray-900">Page template
                        (optional)</label>
                      <fieldset v-if="
                        form.template == 'register_template' ||
                        form.template == 'login_template' ||
                        form.template == 'event_signup_template' ||
                        form.template == 'event_create_template' ||
                        form.template == 'event_listing_template' ||
                        form.template == 'sponser_listing_template' ||
                        form.template == 'magazine_template' ||
                        form.template == 'close_account_template'
                      ">
                        <legend class="sr-only">Set as default page</legend>
                        <div class="flex items-center">
                          <input id="set_as_default_page" name="set_as_default_page" type="checkbox" value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                            :checked="set_as_default_page" v-model="set_as_default_page" />
                          <label for="set_as_default_page" class="ml-2 text-sm font-medium text-gray-900">Set as default
                            page</label>
                        </div>
                      </fieldset>
                    </div>
                    <div class="mt-2">
                      <select id="template" name="template" autocomplete="template-name"
                        class="inline-block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        @input="updateTemplate($event.target.value, 'template')">
                        <option value="">Select template</option>
                        <option v-for="template in sortedTemplates" :key="template.id" :value="template.id"
                          :selected="form.template == template.id">
                          {{ template.name }}
                        </option>
                      </select>
                      <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`template`)"
                        v-text="validationErros.get(`template`)"></p>
                    </div>

                    <div class="flex-none self-end py-4">
                      <dt class="sr-only">Set as home page</dt>
                      <dd
                        class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                        <div class="flex items-center">
                          <input id="is_home_page" name="is_home_page" type="checkbox" value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                            :checked="is_home_page" v-model="is_home_page" />
                          <label for="is_home_page" class="ml-2 text-sm font-medium text-gray-900">Set as home
                            page</label>
                        </div>
                      </dd>
                    </div>
                    <div class="rounded-md bg-blue-50 p-4 mb-7">
                      <div class="flex">
                        <div class="flex-shrink-0">
                          <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z"
                              clip-rule="evenodd" />
                          </svg>
                        </div>
                        <div class="ml-3 flex-1 md:flex md:justify-between">
                          <p class="text-sm text-blue-700">
                            Choose between detailed template customization or
                            simple page setup to best suit your content needs.
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 my-4">
                      <div>
                        <label for="template" class="block text-sm font-medium leading-6 text-gray-900">After header
                          banner (optional)</label>
                        <div class="mt-2">
                          <multiselect v-model="selectedAfterHeaderWidgetId" @select="updateAfterHeaderWidgetId"
                            @remove="updateAfterHeaderWidgetId" :options="widgets" :multiple="false"
                            :close-on-select="false" :clear-on-select="false" :preserve-search="true"
                            placeholder="Select header banner" label="name" track-by="id" :preselect-first="false">
                            <template #selection="{ values, search, isOpen }">
                              <span class="multiselect__single" v-if="values.length" v-show="!isOpen">{{ values.length
                              }} banner selected</span>
                            </template>
                          </multiselect>
                          <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`after_header_widget_id`)"
                            v-text="validationErros.get(`after_header_widget_id`)
                              "></p>
                        </div>
                      </div>
                      <div>
                        <label for="template" class="block text-sm font-medium leading-6 text-gray-900">Before footer
                          banner
                          (optional)</label>
                        <div class="mt-2">
                          <multiselect v-model="selectedBeforeFooterWidgetId" @select="updateBeforeFooterWidgetId"
                            @remove="updateBeforeFooterWidgetId" :options="widgets" :multiple="false"
                            :close-on-select="false" :clear-on-select="false" :preserve-search="true"
                            placeholder="Select footer banner" label="name" track-by="id" :preselect-first="false">
                            <template #selection="{ values, search, isOpen }">
                              <span class="multiselect__single" v-if="values.length" v-show="!isOpen">{{ values.length
                              }} banner selected</span>
                            </template>
                          </multiselect>
                          <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`after_footer_widget_id`)"
                            v-text="validationErros.get(`after_footer_widget_id`)
                              "></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </dl>
            </div>
          </div>

          <div class="col-span-6 sm:col-span-3">
            <div class="rounded-lg bg-gray-50 shadow-sm ring-1 ring-gray-900/5">
              <dl class="flex flex-wrap">
                <div class="flex-auto pl-6 pt-6">
                  <span class="text-sm font-semibold leading-6 text-gray-900">SEO Settings</span>
                </div>
                <div class="mt-4 w-full border-t border-gray-900/5 px-6 pt-4">
                  <div class="relative z-0 w-full group">
                    <label class="block text-sm font-medium leading-6 text-gray-900"
                      :for="`description_${selectedLanguageId}`">Meta description</label>
                    <textarea name="description" id="description" rows="2"
                      class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                      placeholder=" " @input="
                        handleInput(
                          $event.target.value,
                          language,
                          'description'
                        )
                        " v-text="form['description'] &&
                          form['description'][`description_${language.id}`]
                          ? form['description'][`description_${language.id}`]
                          : ''
                          "></textarea>
                    <p class="mt-2 text-sm text-red-400" v-if="
                      validationErros.has(
                        `description.description_${selectedLanguageId}`
                      )
                    " v-text="validationErros.get(
                      `description.description_${selectedLanguageId}`
                    )
                      "></p>
                  </div>
                  <div class="mt-4">
                    <label class="block text-sm font-medium leading-6 text-gray-900"
                      :for="`meta_keywords_${selectedLanguageId}`">Meta keywords</label>
                    <textarea name="meta_keywords" id="meta_keywords" rows="2"
                      class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                      placeholder=" " @input="
                        handleInput(
                          $event.target.value,
                          language,
                          'meta_keywords'
                        )
                        " v-text="form['meta_keywords'] &&
                          form['meta_keywords'][`meta_keywords_${language.id}`]
                          ? form['meta_keywords'][
                          `meta_keywords_${language.id}`
                          ]
                          : ''
                          "></textarea>
                    <p class="mt-2 text-sm text-red-400" v-if="
                      validationErros.has(
                        `meta_keywords.meta_keywords_${selectedLanguageId}`
                      )
                    " v-text="validationErros.get(
                      `meta_keywords.meta_keywords_${selectedLanguageId}`
                    )
                      "></p>
                  </div>
                  <div class="mt-4 mb-4">
                    <label class="block text-sm font-medium leading-6 text-gray-900" for="facebook_media_id">Facebook
                      image</label>
                    <FilePond
                      labelIdle='<span class="cursor-pointer">Drag & drop or <span class="filepond--label-action"> Browse </span></span>'
                      class="cursor-pointer" name="facebook_media" class-name="my-pond" accepted-file-types="image/*"
                      credits="false" ref="facebook_media" v-bind:files="facebook" @init="handleFacebookInit"
                      @processfile="handleFacebookProcess" @removefile="handleFacebookRemoveFile" />
                    <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`facebook_media_id`)"
                      v-text="validationErros.get(`facebook_media_id`)"></p>
                  </div>
                </div>
              </dl>
            </div>
          </div>

          <div class="mt-4 col-span-6 relative">
            <div class="relative z-0 w-full group" v-if="
              (form.template == 'become_sponsor_template' ||
                form.template == 'online_business_directory_template' ||
                form.template == 'financing_program_template' ||
                form.template == 'contact_for_rates_template' ||
                form.template == 'scam_alert_template' ||
                form.template == 'close_account_template' ||
                form.template == 'event_create_template' ||
                form.template == 'event_listing_template' ||
                form.template == 'sponser_listing_template' ||
                form.template == 'event_template' ||
                form.template == 'event_signup_template' ||
                //   form.template == 'event_template' ||
                form.template == 'faq_exporter_template' ||
                form.template == 'faq_importer_template' ||
                form.template == 'info_letter_template' ||
                form.template == 'inquiries_to_buy_template' ||
                form.template == 'sponsor_listing' ||
                form.template == 'rates_template' ||
                form.template == 'magazine_template' ||
                form.template == 'testimonial_template' ||
                form.template == 'success_stories_template' ||
                form.template == '' ||
                form.template == 'null' ||
                form.template == null) &&
              isDataLoaded
            ">
              <label class="block text-sm font-medium leading-6 text-gray-900"
                :for="`page_detail_${selectedLanguageId}`">Page
                description (In most cases this will appear at top of the
                page)</label>
              <editor @mouseleave="handleSelectionChange(language, 'page_detail')"
                @keyup="handleSelectionChange(language, 'page_detail')" :ref="`page_detail_${language.id}`"
                :id="`page_detail_${language.id}`" :initial-value="form[`page_detail`][`page_detail_${language?.id}`]
                  " :tinymce-script-src="tinymceScriptSrc" :init="editorConfig" />
              <p class="mt-2 text-sm text-red-400" v-if="
                validationErros.has(
                  `page_detail.page_detail_${selectedLanguageId}`
                )
              " v-text="validationErros.get(
                `page_detail.page_detail_${selectedLanguageId}`
              )
                "></p>
            </div>
            <div class="relative mt-4 z-0 w-full group col-span-6"
              v-if="form.template == 'event_create_template' && isDataLoaded">
              <label class="block text-sm font-medium leading-6 text-gray-900"
                :for="`edit_page_detail_${selectedLanguageId}`">Page description for edit</label>

              <editor @mouseleave="
                handleSelectionChange(language, 'edit_page_detail')
                " @keyup="handleSelectionChange(language, 'edit_page_detail')" :ref="`edit_page_detail_${language.id}`"
                :id="`edit_page_detail_${language.id}`" :initial-value="form[`edit_page_detail`][`edit_page_detail_${language?.id}`]
                  " :tinymce-script-src="tinymceScriptSrc" :init="editorConfig" />
              <p class="mt-2 text-sm text-red-400" v-if="
                validationErros.has(
                  `edit_page_detail.edit_page_detail_${selectedLanguageId}`
                )
              " v-text="validationErros.get(
                `edit_page_detail.edit_page_detail_${selectedLanguageId}`
              )
                "></p>
            </div>
          </div>

          <!-- <div class="relative z-0 w-full group">
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('is_home_page')"
                            v-text="validationErros.get('is_home_page')"
                        ></p>
                    </div> -->
        </div>

        <!-- <template v-if="form.template == 'home_template'">
                    <HomePageSetting  :selectedLanguage="selectedLanguageId" />
                </template> -->

        <div v-if="form.template == 'home_template'">
          <HomePageSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="selectedLanguageId" />
        </div>
        <div v-else-if="form.template == 'register_template'">
          <RegisterPageSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="selectedLanguageId" />
        </div>
        <div v-else-if="form.template == 'login_template'">
          <LoginPageSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="selectedLanguageId" />
        </div>
        <div v-else-if="form.template == 'about_us_template'">
          <AboutUsPageSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="selectedLanguageId" />
        </div>
        <div v-else-if="form.template == 'contact_us_template'">
          <ContactUsSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="selectedLanguageId" />
        </div>
        <div v-else-if="form.template == 'inquiries_to_buy_template'">
          <I2BSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="selectedLanguageId" />
        </div>
        <div v-else-if="form.template == 'event_template'">
          <EventSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="selectedLanguageId" />
        </div>
        <div v-else-if="form.template == 'comments_template'">
          <CommentsSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="selectedLanguageId" />
        </div>
        <div v-else-if="form.template == 'close_account_template'">
          <CloseAccountSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="selectedLanguageId" />
        </div>
        <div v-else-if="form.template == 'event_listing_template'">
          <EventListingSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="selectedLanguageId" />
        </div>
        <div v-else-if="form.template == 'sponser_listing_template'">
          <SponserListingSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="selectedLanguageId" />
        </div>
        <div v-else-if="form.template == 'rates_template'">
          <RatesSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="selectedLanguageId" />
        </div>
        <div v-else-if="form.template == 'advertiser_page_template'">
          <AdvertiserSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="selectedLanguageId" />
        </div>
        <div v-else-if="form.template == 'forget_page_template'">
          <ForgetPageSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="selectedLanguageId" />
        </div>
        <div v-else-if="form.template == 'become_sponsor_template'">
          <BecomeSponsorSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="selectedLanguageId" />
        </div>
        <div v-else-if="form.template == 'online_business_directory_template'">
          <OnlineBusinessDirectorySetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="selectedLanguageId" />
        </div>
        <div v-else-if="form.template == 'financing_program_template'">
          <FinancingProgramSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="selectedLanguageId" />
        </div>
        <div v-else-if="form.template == 'contact_for_rates_template'">
          <ContactForRateSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="selectedLanguageId" />
        </div>
        <div v-else-if="form.template == 'scam_alert_template'">
          <ScamAlertSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="selectedLanguageId" />
        </div>
        <div v-else-if="form.template == 'testimonial_template'">
          <TestimonialSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="selectedLanguageId" />
        </div>
        <div v-else-if="form.template == 'success_stories_template'">
          <SuccessStoriesSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="selectedLanguageId" />
        </div>
        <div v-else-if="form.template == 'faq_exporter_template'">
          <FaqExporterSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="selectedLanguageId" />
        </div>
        <div v-else-if="form.template == 'faq_importer_template'">
          <FaqImporterSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="selectedLanguageId" />
        </div>
        <div v-else-if="form.template == 'one_more_thing_template'">
          <OneMoreThingSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="selectedLanguageId" />
        </div>
        <div v-else-if="form.template == 'exporting_fair_template'">
          <ExportingFairSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="selectedLanguageId" />
        </div>
        <div v-else-if="form.template == 'info_letter_template'">
          <InfoLetterSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="selectedLanguageId" />
        </div>
        <div v-else-if="form.template == 'sponsor_listing'">
          <SponsorPageSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="selectedLanguageId" />
        </div>
        <div v-else-if="form.template == 'event_signup_template'">
          <EventSignupSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="selectedLanguageId" />
        </div>
        <div v-else-if="form.template == 'event_create_template'">
          <EventCreateSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="selectedLanguageId" />
        </div>
        <div class="flex justify-end mt-4">
          <button type="submit" class="inline-flex items-center gap-x-2 button-exp-fill" :disabled="loading">
            <svg class="-ml-0.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                clip-rule="evenodd" />
            </svg>
            Save page
          </button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script>
import Multiselect from "vue-multiselect";
import Editor from "@tinymce/tinymce-vue";
import { mapState } from "vuex";
import HomePageSetting from "./HomePageSetting.vue";
import RegisterPageSetting from "./RegisterPageSetting.vue";
import LoginPageSetting from "./LoginPageSetting.vue";
import AboutUsPageSetting from "./AboutUsPageSetting.vue";
import ContactUsSetting from "./ContactUsSetting.vue";
import I2BSetting from "./I2BSetting.vue";
import EventSetting from "./EventSetting.vue";
import CommentsSetting from "./CommentsSetting.vue";
import CloseAccountSetting from "./CloseAccountSetting.vue";
import EventListingSetting from "./EventListingSetting.vue";
import SponserListingSetting from "./SponserListingSetting.vue";
import RatesSetting from "./RatesSetting.vue";
import AdvertiserSetting from "./AdvertiserSetting.vue";
import ForgetPageSetting from "./ForgetPageSetting.vue";
import BecomeSponsorSetting from "./BecomeSponsorSetting.vue";
import OnlineBusinessDirectorySetting from "./OnlineBusinessDirectorySetting.vue";
import FinancingProgramSetting from "./FinancingProgramSetting.vue";
import OneMoreThingSetting from "./OneMoreThingSetting.vue";
import ExportingFairSetting from "./ExportingFairSetting.vue";
import InfoLetterSetting from "./InfoLetterSetting.vue";
import SponsorPageSetting from "./SponsorPageSetting.vue";
import EventSignupSetting from "./EventSignupSetting.vue";
import EventCreateSetting from "./EventCreateSetting.vue";
// Import filepond
import vueFilePond, { setOptions } from "vue-filepond";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js";
import FilePondPluginImagePreview from "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import ContactForRateSetting from "./ContactForRateSetting.vue";
import ScamAlertSetting from "./ScamAlertSetting.vue";
import TestimonialSetting from "./TestimonialSetting.vue";
import SuccessStoriesSetting from "./SuccessStoriesSetting.vue";
import FaqExporterSetting from "./FaqExporterSetting.vue";
import FaqImporterSetting from "./FaqImporterSetting.vue";
import axios from "axios";
const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview
);
export default {
  computed: {
    ...mapState({
      loading: (state) => state.pages.loading,
      isFormEdit: (state) => state.pages.isFormEdit,
      form: (state) => state.pages.form,
      validationErros: (state) => state.pages.validationErros,
      languages: (state) => state.languages.languages,
      widgets: (state) => state.widgets.widgets,
    }),
    mixAdminApiUrl() {
      return process.env.MIX_ADMIN_API_URL || '';
    },
    is_home_page: {
      get: function () {
        return this.$store.state.pages.form.is_home_page;
      },
      set: function (val) {
        this.updateTemplate(val, "is_home_page");
      },
    },
    set_as_default_page: {
      get: function () {
        return this.$store.state.pages.form.set_as_default_page;
      },
      set: function (val) {
        this.updateTemplate(val, "set_as_default_page");
      },
    },
    sortedTemplates() {
      const sortedArray = [...this.templates];

      // Sort the array based on the name property
      sortedArray.sort((a, b) => {
        const nameA = a.name.toLowerCase();
        const nameB = b.name.toLowerCase();

        // Compare the names based on the current sorting order
        if (nameA < nameB) {
          return this.isAscendingOrder ? -1 : 1;
        }
        if (nameA > nameB) {
          return this.isAscendingOrder ? 1 : -1;
        }
        return 0;
      });

      return sortedArray;
    },
  },
  components: {
    editor: Editor,
    HomePageSetting,
    AboutUsPageSetting,
    RegisterPageSetting,
    LoginPageSetting,
    ContactUsSetting,
    I2BSetting,
    EventSetting,
    CommentsSetting,
    CloseAccountSetting,
    EventListingSetting,
    SponserListingSetting,
    RatesSetting,
    AdvertiserSetting,
    ForgetPageSetting,
    InfoLetterSetting,
    SponsorPageSetting,
    EventSignupSetting,
    EventCreateSetting,
    BecomeSponsorSetting,
    OnlineBusinessDirectorySetting,
    FinancingProgramSetting,
    ContactForRateSetting,
    ScamAlertSetting,
    TestimonialSetting,
    SuccessStoriesSetting,
    FaqExporterSetting,
    FaqImporterSetting,
    OneMoreThingSetting,
    ExportingFairSetting,
    FilePond,
    Multiselect,
  },
  data() {
    return {
      isDataLoaded: false,
      selectedAfterHeaderWidgetId: null,
      selectedBeforeFooterWidgetId: null,
      facebook: [],
      // Excel multi-language (template setting detail)
      excelForm: {
        selectedFile: null
      },
      excelErrors: [],
      excelUploading: false,
      excelValidationErrors: {},
      selectedLanguageId: null,
      isDataLoaded: false,
      isAscendingOrder: true,
      templates: [
        {
          id: "login_template",
          name: "Login template",
        },
        {
          id: "register_template",
          name: "Register template",
        },
        {
          id: "home_template",
          name: "Home template",
        },
        {
          id: "contact_us_template",
          name: "Contact us template",
        },
        {
          id: "comments_template",
          name: "Comments/Suggestions template",
        },
        {
          id: "close_account_template",
          name: "Close account template",
        },
        {
          id: "rates_template",
          name: "Rates template",
        },
        // {
        //     id: "advertiser_page_template",
        //     name: "Advertiser page template",
        // },
        // {
        //     id: "forget_page_template",
        //     name: "Forget password template",
        // },
        {
          id: "sponsor_listing",
          name: "Sponsors template",
        },
        {
          id: "inquiries_to_buy_template",
          name: "Inquiries to buy template",
        },
        {
          id: "testimonial_template",
          name: "Testimonial template",
        },
        {
          id: "success_stories_template",
          name: "Success stories template",
        },
        {
          id: "event_template",
          name: "Event template",
        },
        {
          id: "one_more_thing_template",
          name: "One more thing template",
        },
        {
          id: "exporting_fair_template",
          name: "Exporting fair template",
        },
        {
          id: "info_letter_template",
          name: "Info letter template",
        },
        {
          id: "event_signup_template",
          name: "Event/Signup template",
        },
        {
          id: "event_create_template",
          name: "Event create template",
        },
        {
          id: "faq_exporter_template",
          name: "FAQ exporter template",
        },
        {
          id: "faq_importer_template",
          name: "FAQ importer template",
        },
        {
          id: "event_listing_template",
          name: "Event listing template",
        }, {
          id: "sponser_listing_template",
          name: "Sponsor listing template",
        },
        {
          id: "become_sponsor_template",
          name: "Become a sponsor template",
        },
        {
          id: "online_business_directory_template",
          name: "Online business directory template",
        },
        {
          id: "financing_program_template",
          name: "Financing program template",
        },
        {
          id: "contact_for_rates_template",
          name: "Contact us for the current rates template",
        },
        {
          id: "scam_alert_template",
          name: "Scam Alert template",
        },
        {
          id: "magazine_template",
          name: "See all magazine template",
        },
      ],
      editorConfig: {
        height: 250,
        menubar: false,
        plugins:
          "anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount fullscreen code",
        toolbar:
          "undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | code | fullscreen",
        base_url: "/plugins/tinymce",
        suffix: ".min",
      },
      tinymceScriptSrc: "/plugins/tinymce/tinymce.min.js",
    };
  },
  methods: {
    updateAfterHeaderWidgetId(selectedWidget) {
      this.$store.commit(
        "pages/setAfterHeaderWidgetForm",
        this.selectedAfterHeaderWidgetId?.id || null
      );
    },
    updateBeforeFooterWidgetId(selectedWidget) {
      this.$store.commit(
        "pages/setBeforeFooterWidgetForm",
        this.selectedBeforeFooterWidgetId?.id || null
      );
    },
    handleSelectionChange(language, key) {
      this.handleInput(
        tinymce.get(`${key}_${language.id}`).getContent(),
        language,
        key
      );
    },
    changeLanguageTab(language) {
      this.selectedLanguageId = language.id;
    },
    handleInput(value, language, inputName) {
      if (inputName === "name") value = value.replace(/[^a-zA-Z\s-]/g, '');
      let obj = {};
      obj[`${inputName}_${language.id}`] = value;
      this.$store.commit("pages/updateHomePageSetting", {
        value: value,
        id: language.id,
        key: inputName,
      });
    },
    updateTemplate(value, inputName) {
      this.$store.commit("pages/setPageValues", {
        value: value,
        key: inputName,
      });
    },
    addUpdateForm() {
      this.$store
        .dispatch("pages/addUpdateForm")
        .then(() => this.$router.push({ name: "admin.pages.index" }));
    },
    handleFileChange(event) {
      const file = event.target.files?.[0];
      this.excelForm.selectedFile = file || null;
      this.excelValidationErrors.excel_file = '';
    },
    async uploadExcelFile() {
      this.excelErrors = [];
      this.excelValidationErrors = {};
      if (!this.form?.id) {
        this.excelValidationErrors.excel_file = 'Save the page first.';
        return;
      }
      if (!this.excelForm.selectedFile) {
        this.excelValidationErrors.excel_file = 'Please select a file.';
        return;
      }
      this.excelUploading = true;
      const formData = new FormData();
      formData.append('page_id', this.form.id);
      formData.append('template', this.form.template);
      formData.append('file', this.excelForm.selectedFile);
      try {
        const res = await axios.post(
          `${process.env.MIX_ADMIN_API_URL}page-setting-detail/import-xls`,
          formData,
          {
            headers: {
              'Content-Type': 'multipart/form-data',
              'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')?.content || '',
            },
          }
        );
        if (res?.data?.status === 'Success') {
          this.excelErrors = [];
          this.excelForm.selectedFile = null;
          if (this.$refs.excelFile) this.$refs.excelFile.value = '';
          this.$store.dispatch('pages/fetchPage', {
            id: this.form.id,
            url: `${process.env.MIX_ADMIN_API_URL}pages/${this.form.id}?withPageDetail=1&withMetaImages=1`,
          }).catch(() => {});
          alert(res?.data?.message || 'Excel imported successfully. Setting details updated.');
        } else {
          this.excelErrors = [res?.data?.message || 'Import failed.'];
        }
      } catch (err) {
        const data = err?.response?.data;
        if (data?.errors) {
          this.excelErrors = Object.entries(data.errors).map(([k, v]) => ({
            row: k,
            attribute: k,
            errors: Array.isArray(v) ? v : [v],
          }));
        } else {
          this.excelErrors = [data?.message || err?.message || 'Upload failed.'];
        }
      } finally {
        this.excelUploading = false;
      }
    },
    fetchPage() {
      if (this.$route.params.id) {
        let id = this.$route.params.id;
        this.$store.commit("pages/setIsFormEdit", 1);
        this.$store
          .dispatch("pages/fetchPage", {
            id: id,
            url: `${process.env.MIX_ADMIN_API_URL}pages/${id}?withPageDetail=1&withMetaImages=1`,
          })
          .then((res) => {
            let data =
              res.data.data && res.data.data.page_detail
                ? res.data.data.page_detail
                : [];
            this.selectedAfterHeaderWidgetId =
              res?.data?.data?.after_header_widget || null;
            this.selectedBeforeFooterWidgetId =
              res?.data?.data?.before_footer_widget || null;
            this.updateAfterHeaderWidgetId(this.selectedAfterHeaderWidgetId);
            this.updateBeforeFooterWidgetId(this.selectedAfterHeaderWidgetId);
            this.updateTemplate(res.data.data.id, "id");
            this.updateTemplate(res.data.data.template, "template");
            this.updateTemplate(res.data.data.is_home_page, "is_home_page");
            if (res.data.data && res.data.data.facebook_media) {
              this.convertFacebookImgUrlToBase64(
                res.data.data.facebook_media.full_path,
                `image/${res.data.data.facebook_media.extension}`
              );
              this.updateTemplate(
                JSON.stringify([res.data.data.facebook_media.path]),
                "facebook_media_id"
              );
            }

            let obj = {};
            data.map((res) => {
              obj["name_" + res.language_id] = res.name;
            });
            this.$store.commit("pages/setHomePageSetting", {
              key: "name",
              value: obj,
            });

            obj = {};
            data.map((res) => {
              obj["description_" + res.language_id] = res.description;
            });
            this.$store.commit("pages/setHomePageSetting", {
              key: "description",
              value: obj,
            });

            obj = {};
            data.map((res) => {
              obj["meta_keywords_" + res.language_id] = res.meta_keywords;
            });
            this.$store.commit("pages/setHomePageSetting", {
              key: "meta_keywords",
              value: obj,
            });

            obj = {};
            data.map((res) => {
              obj["page_detail_" + res.language_id] = res.page_detail;
            });
            this.$store.commit("pages/setHomePageSetting", {
              key: "page_detail",
              value: obj,
            });

            obj = {};
            data.map((res) => {
              obj["edit_page_detail_" + res.language_id] = res.edit_page_detail;
            });
            this.$store.commit("pages/setHomePageSetting", {
              key: "edit_page_detail",
              value: obj,
            });
            this.isDataLoaded = true;
          });
      }
    },
    handleFacebookInit() {
      setOptions({
        credits: false,
        server: {
          url: process.env.MIX_ADMIN_API_URL,
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
            formData.append("type", "pages");

            const request = new XMLHttpRequest();
            request.open(
              "POST",
              `${process.env.MIX_ADMIN_API_URL}media/process`
            );
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
            request.open(
              "POST",
              `${process.env.MIX_ADMIN_API_URL}media/revert`
            );
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
    handleFacebookProcess(error, file) {
      this.updateTemplate(file.serverId, "facebook_media_id");
    },
    handleFacebookRemoveFile(error, file) {
      this.updateTemplate("", "facebook_media_id");
    },

    convertFacebookImgUrlToBase64(url, type) {
      var image = new Image();
      let vm = this;
      image.onload = function () {
        var canvas = document.createElement("canvas");
        canvas.width = image.width;
        canvas.height = image.height;

        canvas.getContext("2d").drawImage(this, 0, 0);

        canvas.toBlob(
          function (source) {
            var newImg = document.createElement("img"),
              url = URL.createObjectURL(source);

            newImg.onload = function () {
              URL.revokeObjectURL(url);
            };

            newImg.src = url;
          },
          type,
          1
        );
        let dataUrl = canvas.toDataURL(type);
        let files = [
          {
            source: dataUrl,
            options: {
              type: "local",
            },
          },
        ];
        // setOptions({files:files});
        vm.facebook = files;
      };
      image.src = url;
    },
  },
  created() {
    this.facebook = [];
    this.$store.commit("pages/resetForm");
    this.$store
      .dispatch("languages/fetchLanguages", {
        url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
      })
      .then((res) => {
        let data = res.data.data;
        let obj = {};
        data.map((res) => {
          if (res.is_default) {
            this.selectedLanguageId = res.id;
          }
          obj["name_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "name",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["description_" + res.id] = "";
          // this.createEditorInstance(
          //     "description_" + res.id,
          //     "description",
          //     res,
          //     "updateHomePageSetting"
          // );
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "description",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["meta_keywords_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "meta_keywords",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["page_detail_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "page_detail",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["edit_page_detail_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "edit_page_detail",
          value: obj,
        });
        if (this.$route.params.id) {
          this.fetchPage();
        } else {
          this.isDataLoaded = true;
        }
        this.$store.dispatch("widgets/fetchWidgets", {
          url: `${process.env.MIX_ADMIN_API_URL}widgets?getAll=1`,
        });
      });
  },
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>