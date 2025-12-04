<template>
  <div
    class="my-5"
    v-for="(language, index) in languages"
    :key="language.id"
    :class="
      (selectedLanguage == null && language.is_default) ||
      language.id == selectedLanguage
        ? 'block'
        : 'hidden'
    "
  >
    <div
      class="border rounded w-full"
      :class="collapseStates[0] ? 'bg-blue-50' : ''"
    >
      <div
        class="lg:border-b lg:border-t lg:border-gray-200 cursor-pointer"
        @click.prevent="collapseStates[0] = !collapseStates[0]"
      >
        <nav class="mx-auto" aria-label="Section">
          <ol
            role="list"
            class="overflow-hidden rounded-md lg:flex lg:rounded-none lg:border-l lg:border-r lg:border-gray-200"
          >
            <li class="relative overflow-hidden lg:flex-1">
              <div
                class="overflow-hidden border border-gray-200 rounded-t-md border-b-0 lg:border-0 flex justify-between items-center"
              >
                <div class="group w-full">
                  <span
                    class="absolute left-0 top-0 h-full w-1 bg-transparent group-hover:bg-primary lg:bottom-0 lg:top-auto lg:h-1 lg:w-full"
                    aria-hidden="true"
                  ></span>
                  <span class="flex items-start px-6 py-2 text-sm font-medium">
                    <span class="flex-shrink-0">
                      <span
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-primary"
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke-width="1.5"
                          stroke="currentColor"
                          class="h-6 w-6 text-white"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z"
                          />
                        </svg>
                      </span>
                    </span>
                    <span class="ml-4 mt-0.5 flex min-w-0 flex-col">
                      <span class="text-sm font-medium">Header settings</span>
                      <span class="text-sm font-medium text-gray-500"
                        >Top header settings</span
                      >
                    </span>
                  </span>
                </div>
                <svg
                  class="w-5 h-5 fill-current text-gray-500"
                  viewBox="0 0 20 20"
                >
                  <path d="M6 9l4 4 4-4"></path>
                </svg>
              </div>
            </li>
          </ol>
        </nav>
      </div>
      <div class="p-4 bg-gray-50 border-t" v-if="collapseStates[0]">
        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
          <div class="col-span-6 sm:col-span-2">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`slider_heading_${selectedLanguage}`"
              >Welcome heading</label
            >
            <input
              type="text"
              :name="`slider_heading_${selectedLanguage}`"
              :id="`slider_heading_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'slider_heading',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['slider_heading'] &&
                form['slider_heading'][`slider_heading_${selectedLanguage}`]
                  ? form['slider_heading'][`slider_heading_${selectedLanguage}`]
                  : ''
              "
            />
            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `slider_heading.slider_heading_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `slider_heading.slider_heading_${selectedLanguage}`
                )
              "
            ></p>
          </div>

          <div class="col-span-6 sm:col-span-2">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`slider_search_placeholder_${selectedLanguage}`"
              >Placeholder for search
            </label>
            <input
              type="text"
              :name="`slider_search_placeholder_${selectedLanguage}`"
              :id="`slider_search_placeholder_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'slider_search_placeholder',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['slider_search_placeholder'] &&
                form['slider_search_placeholder'][
                  `slider_search_placeholder_${selectedLanguage}`
                ]
                  ? form['slider_search_placeholder'][
                      `slider_search_placeholder_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `slider_search_placeholder.slider_search_placeholder_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `slider_search_placeholder.slider_search_placeholder_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="col-span-6 sm:col-span-2">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`slider_advance_search_text_${selectedLanguage}`"
              >Advanced search text</label
            >
            <input
              type="text"
              :name="`slider_advance_search_text_${selectedLanguage}`"
              :id="`slider_advance_search_text_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'slider_advance_search_text',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['slider_advance_search_text'] &&
                form['slider_advance_search_text'][
                  `slider_advance_search_text_${selectedLanguage}`
                ]
                  ? form['slider_advance_search_text'][
                      `slider_advance_search_text_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `slider_advance_search_text.slider_advance_search_text_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `slider_advance_search_text.slider_advance_search_text_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="col-span-6">
            <div class="flex items-center justify-between">
              <div>
                <label
                  class="block text-sm font-medium leading-6 text-gray-900"
                  :for="`slider_image_${selectedLanguage}`"
                  >Header background image</label
                >
                <input
                  :key="`slider_image_${selectedLanguage}`"
                  type="file"
                  :name="`slider_image_${selectedLanguage}`"
                  :id="`slider_image_${selectedLanguage}`"
                  class="block w-full rounded-md border-0 px-1 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                  placeholder=" "
                  @input="
                    handleImage(
                      $event,
                      language,
                      'slider_image',
                      'updateHomePageSetting'
                    )
                  "
                />
                <p
                  class="mt-2 text-sm text-red-400"
                  v-if="
                    validationErros.has(
                      `slider_image.slider_image_${selectedLanguage}`
                    )
                  "
                  v-text="
                    validationErros.get(
                      `slider_image.slider_image_${selectedLanguage}`
                    )
                  "
                ></p>
              </div>
              <div>
                <img
                  class="w-auto sm:w-96 h-36 rounded-md object-cover"
                  v-if="
                    form['slider_image'] &&
                    form['slider_image'][`slider_image_${selectedLanguage}`]
                  "
                  :src="
                    form['slider_image'] &&
                    form['slider_image'][`slider_image_${selectedLanguage}`]
                      ? form['slider_image'][`slider_image_${selectedLanguage}`]
                      : ''
                  "
                />
              </div>
            </div>
          </div>
          <div class="col-span-6 sm:col-span-2" v-if="index == 0">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`header_widget_id_${selectedLanguage}`"
              >Banner</label
            >
            <multiselect
              v-model="selectedHeaderWidgetId"
              @select="updateHeaderWidgetId"
              @remove="updateHeaderWidgetId"
              :options="widgets"
              :multiple="false"
              :close-on-select="false"
              :clear-on-select="false"
              :preserve-search="true"
              placeholder="Select banner"
              label="name"
              track-by="id"
              :preselect-first="false"
            >
              <template #selection="{ values, search, isOpen }">
                <span
                  class="multiselect__single"
                  v-if="values.length"
                  v-show="!isOpen"
                  >{{ values.length }} banner selected</span
                >
              </template>
            </multiselect>

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `header_widget_id.header_widget_id_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `header_widget_id.header_widget_id_${selectedLanguage}`
                )
              "
            ></p>
          </div>
        </div>
      </div>
    </div>
    <div
      class="border rounded w-full mt-8"
      :class="collapseStates[1] ? 'bg-blue-50' : ''"
    >
      <div
        class="lg:border-b lg:border-t lg:border-gray-200 cursor-pointer"
        @click.prevent="collapseStates[1] = !collapseStates[1]"
      >
        <nav class="mx-auto" aria-label="Section">
          <ol
            role="list"
            class="overflow-hidden rounded-md lg:flex lg:rounded-none lg:border-l lg:border-r lg:border-gray-200"
          >
            <li class="relative overflow-hidden lg:flex-1">
              <div
                class="overflow-hidden border border-gray-200 rounded-t-md border-b-0 lg:border-0 flex justify-between items-center"
              >
                <div class="group w-full">
                  <span
                    class="absolute left-0 top-0 h-full w-1 bg-transparent group-hover:bg-primary lg:bottom-0 lg:top-auto lg:h-1 lg:w-full"
                    aria-hidden="true"
                  ></span>
                  <span class="flex items-start px-6 py-2 text-sm font-medium">
                    <span class="flex-shrink-0">
                      <span
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-primary"
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke-width="1.5"
                          stroke="currentColor"
                          class="h-6 w-6 text-white"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z"
                          />
                        </svg>
                      </span>
                    </span>
                    <span class="ml-4 mt-0.5 flex min-w-0 flex-col">
                      <span class="text-sm font-medium"
                        >Business category settings</span
                      >
                      <span class="text-sm font-medium text-gray-500"
                        >Settings for business category section</span
                      >
                    </span>
                  </span>
                </div>
                <svg
                  class="w-5 h-5 fill-current text-gray-500"
                  viewBox="0 0 20 20"
                >
                  <path d="M6 9l4 4 4-4"></path>
                </svg>
              </div>
            </li>
          </ol>
        </nav>
      </div>
      <div class="p-4 bg-gray-50 border-t" v-if="collapseStates[1]">
        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
          <div class="col-span-6 sm:col-span-2">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`section1_heading_${selectedLanguage}`"
              >Section heading</label
            >
            <input
              type="text"
              :name="`section1_heading_${selectedLanguage}`"
              :id="`section1_heading_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'section1_heading',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['section1_heading'] &&
                form['section1_heading'][`section1_heading_${selectedLanguage}`]
                  ? form['section1_heading'][
                      `section1_heading_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `section1_heading.section1_heading_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `section1_heading.section1_heading_${selectedLanguage}`
                )
              "
            ></p>
          </div>

          <div class="col-span-6 sm:col-span-2">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`section1_business_category_${selectedLanguage}`"
              >Category info text
            </label>
            <input
              type="text"
              :name="`section1_business_category_${selectedLanguage}`"
              :id="`section1_business_category_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'section1_business_category',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['section1_business_category'] &&
                form['section1_business_category'][
                  `section1_business_category_${selectedLanguage}`
                ]
                  ? form['section1_business_category'][
                      `section1_business_category_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `section1_business_category.section1_business_category_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `section1_business_category.section1_business_category_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="col-span-6 sm:col-span-2">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`section1_business_category_url_${selectedLanguage}`"
              >Category info URL</label
            >
            <input
              type="text"
              :name="`section1_business_category_url_${selectedLanguage}`"
              :id="`section1_business_category_url_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'section1_business_category_url',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['section1_business_category_url'] &&
                form['section1_business_category_url'][
                  `section1_business_category_url_${selectedLanguage}`
                ]
                  ? form['section1_business_category_url'][
                      `section1_business_category_url_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `section1_business_category_url.section1_business_category_url_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `section1_business_category_url.section1_business_category_url_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="col-span-6" v-if="isDataLoaded">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`section1_description_${selectedLanguage}`"
              >Description</label
            >
            <editor
              @mouseleave="
                handleSelectionChange(
                  language,
                  'section1_description',
                  'updateHomePageSetting'
                )
              "
              @keyup="
                handleSelectionChange(
                  language,
                  'section1_description',
                  'updateHomePageSetting'
                )
              "
              :ref="`section1_description_${language.id}`"
              :id="`section1_description_${language.id}`"
              :initial-value="
                form[`section1_description`][
                  `section1_description_${language?.id}`
                ]
              "
              :tinymce-script-src="tinymceScriptSrc"
              :init="editorConfig"
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `section1_description.section1_description_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `section1_description.section1_description_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div v-if="index == 0" class="col-span-6 sm:col-span-2">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`business_category_widget_id_${selectedLanguage}`"
              >Banner</label
            >
            <multiselect
              v-model="selectedBusinessCategoryWidgetId"
              @select="updateBusinessCategoryWidgetId"
              @remove="updateBusinessCategoryWidgetId"
              :options="widgets"
              :multiple="false"
              :close-on-select="false"
              :clear-on-select="false"
              :preserve-search="true"
              placeholder="Select banner"
              label="name"
              track-by="id"
              :preselect-first="false"
            >
              <template #selection="{ values, search, isOpen }">
                <span
                  class="multiselect__single"
                  v-if="values.length"
                  v-show="!isOpen"
                  >{{ values.length }} banner selected</span
                >
              </template>
            </multiselect>

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `business_category_widget_id.business_category_widget_id_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `business_category_widget_id.business_category_widget_id_${selectedLanguage}`
                )
              "
            ></p>
          </div>
        </div>
      </div>
    </div>

    <div
      class="border rounded w-full mt-8"
      :class="collapseStates[2] ? 'bg-blue-50' : ''"
    >
      <div
        class="lg:border-b lg:border-t lg:border-gray-200 cursor-pointer"
        @click.prevent="collapseStates[2] = !collapseStates[2]"
      >
        <nav class="mx-auto" aria-label="Section">
          <ol
            role="list"
            class="overflow-hidden rounded-md lg:flex lg:rounded-none lg:border-l lg:border-r lg:border-gray-200"
          >
            <li class="relative overflow-hidden lg:flex-1">
              <div
                class="overflow-hidden border border-gray-200 rounded-t-md border-b-0 lg:border-0 flex justify-between items-center"
              >
                <div class="group w-full">
                  <span
                    class="absolute left-0 top-0 h-full w-1 bg-transparent group-hover:bg-primary lg:bottom-0 lg:top-auto lg:h-1 lg:w-full"
                    aria-hidden="true"
                  ></span>
                  <span class="flex items-start px-6 py-2 text-sm font-medium">
                    <span class="flex-shrink-0">
                      <span
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-primary"
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke-width="1.5"
                          stroke="currentColor"
                          class="h-6 w-6 text-white"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z"
                          />
                        </svg>
                      </span>
                    </span>
                    <span class="ml-4 mt-0.5 flex min-w-0 flex-col">
                      <span class="text-sm font-medium"
                        >Inquiries to buy section</span
                      >
                      <span class="text-sm font-medium text-gray-500"
                        >Inquiries to buy section settings</span
                      >
                    </span>
                  </span>
                </div>
                <svg
                  class="w-5 h-5 fill-current text-gray-500"
                  viewBox="0 0 20 20"
                >
                  <path d="M6 9l4 4 4-4"></path>
                </svg>
              </div>
            </li>
          </ol>
        </nav>
      </div>
      <div class="p-4 bg-gray-50 border-t" v-if="collapseStates[2]">
        <div
          class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
        >
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`section2_heading_${selectedLanguage}`"
              >Section heading</label
            >
            <input
              type="text"
              :name="`section2_heading_${selectedLanguage}`"
              :id="`section2_heading_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'section2_heading',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['section2_heading'] &&
                form['section2_heading'][`section2_heading_${selectedLanguage}`]
                  ? form['section2_heading'][
                      `section2_heading_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `section2_heading.section2_heading_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `section2_heading.section2_heading_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`section2_category_label_${selectedLanguage}`"
              >Category label</label
            >
            <input
              type="text"
              :name="`section2_category_label_${selectedLanguage}`"
              :id="`section2_category_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'section2_category_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['section2_category_label'] &&
                form['section2_category_label'][
                  `section2_category_label_${selectedLanguage}`
                ]
                  ? form['section2_category_label'][
                      `section2_category_label_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `section2_category_label.section2_category_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `section2_category_label.section2_category_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`section2_country_label_${selectedLanguage}`"
              >Country label</label
            >
            <input
              type="text"
              :name="`section2_country_label_${selectedLanguage}`"
              :id="`section2_country_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'section2_country_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['section2_country_label'] &&
                form['section2_country_label'][
                  `section2_country_label_${selectedLanguage}`
                ]
                  ? form['section2_country_label'][
                      `section2_country_label_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `section2_country_label.section2_country_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `section2_country_label.section2_country_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`section2_deadline_label_${selectedLanguage}`"
              >Deadline label</label
            >
            <input
              type="text"
              :name="`section2_deadline_label_${selectedLanguage}`"
              :id="`section2_deadline_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'section2_deadline_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['section2_deadline_label'] &&
                form['section2_deadline_label'][
                  `section2_deadline_label_${selectedLanguage}`
                ]
                  ? form['section2_deadline_label'][
                      `section2_deadline_label_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `section2_deadline_label.section2_deadline_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `section2_deadline_label.section2_deadline_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`section2_estimated_value_label_${selectedLanguage}`"
              >Estimated value label</label
            >
            <input
              type="text"
              :name="`section2_estimated_value_label_${selectedLanguage}`"
              :id="`section2_estimated_value_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'section2_estimated_value_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['section2_estimated_value_label'] &&
                form['section2_estimated_value_label'][
                  `section2_estimated_value_label_${selectedLanguage}`
                ]
                  ? form['section2_estimated_value_label'][
                      `section2_estimated_value_label_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `section2_estimated_value_label.section2_estimated_value_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `section2_estimated_value_label.section2_estimated_value_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`section2_i2b_button_text_${selectedLanguage}`"
              >I2B buttom text</label
            >
            <input
              type="text"
              :name="`section2_i2b_button_text_${selectedLanguage}`"
              :id="`section2_i2b_button_text_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'section2_i2b_button_text',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['section2_i2b_button_text'] &&
                form['section2_i2b_button_text'][
                  `section2_i2b_button_text_${selectedLanguage}`
                ]
                  ? form['section2_i2b_button_text'][
                      `section2_i2b_button_text_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `section2_i2b_button_text.section2_i2b_button_text_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `section2_i2b_button_text.section2_i2b_button_text_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`section2_button_text_${selectedLanguage}`"
              >Button text</label
            >
            <input
              type="text"
              :name="`section2_button_text_${selectedLanguage}`"
              :id="`section2_button_text_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'section2_button_text',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['section2_button_text'] &&
                form['section2_button_text'][
                  `section2_button_text_${selectedLanguage}`
                ]
                  ? form['section2_button_text'][
                      `section2_button_text_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `section2_button_text.section2_button_text_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `section2_button_text.section2_button_text_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`section2_button_url_${selectedLanguage}`"
              >Button url</label
            >
            <input
              type="text"
              :name="`section2_button_url_${selectedLanguage}`"
              :id="`section2_button_url_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'section2_button_url',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['section2_button_url'] &&
                form['section2_button_url'][
                  `section2_button_url_${selectedLanguage}`
                ]
                  ? form['section2_button_url'][
                      `section2_button_url_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `section2_button_url.section2_button_url_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `section2_button_url.section2_button_url_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div v-if="index == 0">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`i2b_widget_id_${selectedLanguage}`"
              >Banner</label
            >
            <multiselect
              v-model="selectedI2bWidgetId"
              @select="updateI2bWidgetId"
              @remove="updateI2bWidgetId"
              :options="widgets"
              :multiple="false"
              :close-on-select="false"
              :clear-on-select="false"
              :preserve-search="true"
              placeholder="Select banner"
              label="name"
              track-by="id"
              :preselect-first="false"
            >
              <template #selection="{ values, search, isOpen }">
                <span
                  class="multiselect__single"
                  v-if="values.length"
                  v-show="!isOpen"
                  >{{ values.length }} banner selected</span
                >
              </template>
            </multiselect>

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `i2b_widget_id.i2b_widget_id_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `i2b_widget_id.i2b_widget_id_${selectedLanguage}`
                )
              "
            ></p>
          </div>
        </div>
      </div>
    </div>

    <div
      class="border rounded w-full mt-8"
      :class="collapseStates[3] ? 'bg-blue-50' : ''"
    >
      <div
        class="lg:border-b lg:border-t lg:border-gray-200 cursor-pointer"
        @click.prevent="collapseStates[3] = !collapseStates[3]"
      >
        <nav class="mx-auto" aria-label="Section">
          <ol
            role="list"
            class="overflow-hidden rounded-md lg:flex lg:rounded-none lg:border-l lg:border-r lg:border-gray-200"
          >
            <li class="relative overflow-hidden lg:flex-1">
              <div
                class="overflow-hidden border border-gray-200 rounded-t-md border-b-0 lg:border-0 flex justify-between items-center"
              >
                <div class="group w-full">
                  <span
                    class="absolute left-0 top-0 h-full w-1 bg-transparent group-hover:bg-primary lg:bottom-0 lg:top-auto lg:h-1 lg:w-full"
                    aria-hidden="true"
                  ></span>
                  <span class="flex items-start px-6 py-2 text-sm font-medium">
                    <span class="flex-shrink-0">
                      <span
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-primary"
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke-width="1.5"
                          stroke="currentColor"
                          class="h-6 w-6 text-white"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z"
                          />
                        </svg>
                      </span>
                    </span>
                    <span class="ml-4 mt-0.5 flex min-w-0 flex-col">
                      <span class="text-sm font-medium">Sponsors section</span>
                      <span class="text-sm font-medium text-gray-500"
                        >Sponsors section settings</span
                      >
                    </span>
                  </span>
                </div>
                <svg
                  class="w-5 h-5 fill-current text-gray-500"
                  viewBox="0 0 20 20"
                >
                  <path d="M6 9l4 4 4-4"></path>
                </svg>
              </div>
            </li>
          </ol>
        </nav>
      </div>
      <div class="p-4 bg-gray-50 border-t" v-if="collapseStates[3]">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`section3_heading_${selectedLanguage}`"
              >Section heading</label
            >
            <input
              type="text"
              :name="`section3_heading_${selectedLanguage}`"
              :id="`section3_heading_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'section3_heading',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['section3_heading'] &&
                form['section3_heading'][`section3_heading_${selectedLanguage}`]
                  ? form['section3_heading'][
                      `section3_heading_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `section3_heading.section3_heading_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `section3_heading.section3_heading_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`section3_button_text_${selectedLanguage}`"
              >Become a sponsor button text</label
            >
            <input
              type="text"
              :name="`section3_button_text_${selectedLanguage}`"
              :id="`section3_button_text_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'section3_button_text',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['section3_button_text'] &&
                form['section3_button_text'][
                  `section3_button_text_${selectedLanguage}`
                ]
                  ? form['section3_button_text'][
                      `section3_button_text_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `section3_button_text.section3_button_text_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `section3_button_text.section3_button_text_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`section3_button_url_${selectedLanguage}`"
              >Become a sponsor url</label
            >
            <input
              type="text"
              :name="`section3_button_url_${selectedLanguage}`"
              :id="`section3_button_url_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'section3_button_url',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['section3_button_url'] &&
                form['section3_button_url'][
                  `section3_button_url_${selectedLanguage}`
                ]
                  ? form['section3_button_url'][
                      `section3_button_url_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `section3_button_url.section3_button_url_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `section3_button_url.section3_button_url_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`sponsor_value_button_text_${selectedLanguage}`"
              >We value our sponsors text</label
            >
            <input
              type="text"
              :name="`sponsor_value_button_text_${selectedLanguage}`"
              :id="`sponsor_value_button_text_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'sponsor_value_button_text',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['sponsor_value_button_text'] &&
                form['sponsor_value_button_text'][
                  `sponsor_value_button_text_${selectedLanguage}`
                ]
                  ? form['sponsor_value_button_text'][
                      `sponsor_value_button_text_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `sponsor_value_button_text.sponsor_value_button_text_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `sponsor_value_button_text.sponsor_value_button_text_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`sponsor_value_button_url_${selectedLanguage}`"
              >We value our sponsors text</label
            >
            <input
              type="text"
              :name="`sponsor_value_button_url_${selectedLanguage}`"
              :id="`sponsor_value_button_url_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'sponsor_value_button_url',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['sponsor_value_button_url'] &&
                form['sponsor_value_button_url'][
                  `sponsor_value_button_url_${selectedLanguage}`
                ]
                  ? form['sponsor_value_button_url'][
                      `sponsor_value_button_url_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `sponsor_value_button_url.sponsor_value_button_url_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `sponsor_value_button_url.sponsor_value_button_url_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div v-if="index == 0">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`sponsor_widget_id_${selectedLanguage}`"
              >Banner</label
            >
            <multiselect
              v-model="selectedSponsorWidgetId"
              @select="updateSponsorWidgetId"
              @remove="updateSponsorWidgetId"
              :options="widgets"
              :multiple="false"
              :close-on-select="false"
              :clear-on-select="false"
              :preserve-search="true"
              placeholder="Select banner"
              label="name"
              track-by="id"
              :preselect-first="false"
            >
              <template #selection="{ values, search, isOpen }">
                <span
                  class="multiselect__single"
                  v-if="values.length"
                  v-show="!isOpen"
                  >{{ values.length }} banner selected</span
                >
              </template>
            </multiselect>

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `sponsor_widget_id.sponsor_widget_id_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `sponsor_widget_id.sponsor_widget_id_${selectedLanguage}`
                )
              "
            ></p>
          </div>
        </div>
      </div>
    </div>

    <div
      class="border rounded w-full mt-8"
      :class="collapseStates[4] ? 'bg-blue-50' : ''"
    >
      <div
        class="lg:border-b lg:border-t lg:border-gray-200 cursor-pointer"
        @click.prevent="collapseStates[4] = !collapseStates[4]"
      >
        <nav class="mx-auto" aria-label="Section">
          <ol
            role="list"
            class="overflow-hidden rounded-md lg:flex lg:rounded-none lg:border-l lg:border-r lg:border-gray-200"
          >
            <li class="relative overflow-hidden lg:flex-1">
              <div
                class="overflow-hidden border border-gray-200 rounded-t-md border-b-0 lg:border-0 flex justify-between items-center"
              >
                <div class="group w-full">
                  <span
                    class="absolute left-0 top-0 h-full w-1 bg-transparent group-hover:bg-primary lg:bottom-0 lg:top-auto lg:h-1 lg:w-full"
                    aria-hidden="true"
                  ></span>
                  <span class="flex items-start px-6 py-2 text-sm font-medium">
                    <span class="flex-shrink-0">
                      <span
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-primary"
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke-width="1.5"
                          stroke="currentColor"
                          class="h-6 w-6 text-white"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z"
                          />
                        </svg>
                      </span>
                    </span>
                    <span class="ml-4 mt-0.5 flex min-w-0 flex-col">
                      <span class="text-sm font-medium"
                        >Featured business section</span
                      >
                      <span class="text-sm font-medium text-gray-500"
                        >Featured business section settings</span
                      >
                    </span>
                  </span>
                </div>
                <svg
                  class="w-5 h-5 fill-current text-gray-500"
                  viewBox="0 0 20 20"
                >
                  <path d="M6 9l4 4 4-4"></path>
                </svg>
              </div>
            </li>
          </ol>
        </nav>
      </div>
      <div class="p-4 bg-gray-50 border-t" v-if="collapseStates[4]">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`section4_heading_${selectedLanguage}`"
              >Section heading</label
            >
            <input
              type="text"
              :name="`section4_heading_${selectedLanguage}`"
              :id="`section4_heading_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'section4_heading',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['section4_heading'] &&
                form['section4_heading'][`section4_heading_${selectedLanguage}`]
                  ? form['section4_heading'][
                      `section4_heading_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `section4_heading.section4_heading_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `section4_heading.section4_heading_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              for="number_of_featured_exporters"
              >Number of featured exporters</label
            >
            <input
              type="text"
              id="number_of_featured_exporters"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                updateForm('number_of_featured_exporters', $event.target.value)
              "
              :value="form?.['number_of_featured_exporters'] || ''"
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="validationErros.has('number_of_featured_exporters')"
              v-text="validationErros.get('number_of_featured_exporters')"
            ></p>
          </div>
          <div class="relative z-0 w-full group" v-if="index == 0">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              for="number_of_featured_exporters"
              >Number of featured exporters</label
            >
            <multiselect
              v-model="selectedBusinessCategories"
              @select="updateBusinessCategories"
              @remove="updateBusinessCategories"
              :options="business_profiles"
              :multiple="true"
              :close-on-select="false"
              :clear-on-select="false"
              :preserve-search="true"
              placeholder="Select business profiles"
              label="company_name"
              track-by="id"
              :preselect-first="false"
            >
              <template #selection="{ values, search, isOpen }">
                <span
                  class="multiselect__single"
                  v-if="values.length"
                  v-show="!isOpen"
                  >{{ values.length }} profile selected</span
                >
              </template>
            </multiselect>

            <p
              class="mt-2 text-sm text-red-400"
              v-if="validationErros.has('number_of_featured_exporters')"
              v-text="validationErros.get('number_of_featured_exporters')"
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`contact_for_rates_btn_text_${selectedLanguage}`"
              >Contact for current rates text</label
            >
            <input
              type="text"
              :name="`contact_for_rates_btn_text_${selectedLanguage}`"
              :id="`contact_for_rates_btn_text_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'contact_for_rates_btn_text',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['contact_for_rates_btn_text'] &&
                form['contact_for_rates_btn_text'][
                  `contact_for_rates_btn_text_${selectedLanguage}`
                ]
                  ? form['contact_for_rates_btn_text'][
                      `contact_for_rates_btn_text_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `contact_for_rates_btn_text.contact_for_rates_btn_text_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `contact_for_rates_btn_text.contact_for_rates_btn_text_${selectedLanguage}`
                )
              "
            ></p>
          </div>

          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`contact_for_rates_btn_url_${selectedLanguage}`"
              >Contact for current rates URL</label
            >
            <input
              type="text"
              :name="`contact_for_rates_btn_url_${selectedLanguage}`"
              :id="`contact_for_rates_btn_url_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'contact_for_rates_btn_url',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['contact_for_rates_btn_url'] &&
                form['contact_for_rates_btn_url'][
                  `contact_for_rates_btn_url_${selectedLanguage}`
                ]
                  ? form['contact_for_rates_btn_url'][
                      `contact_for_rates_btn_url_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `contact_for_rates_btn_url.contact_for_rates_btn_url_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `contact_for_rates_btn_url.contact_for_rates_btn_url_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div v-if="index == 0">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`business_widget_id_${selectedLanguage}`"
              >Banner</label
            >
            <multiselect
              v-model="selectedBusinessWidgetId"
              @select="updateBusinessWidgetId"
              @remove="updateBusinessWidgetId"
              :options="widgets"
              :multiple="false"
              :close-on-select="false"
              :clear-on-select="false"
              :preserve-search="true"
              placeholder="Select banner"
              label="name"
              track-by="id"
              :preselect-first="false"
            >
              <template #selection="{ values, search, isOpen }">
                <span
                  class="multiselect__single"
                  v-if="values.length"
                  v-show="!isOpen"
                  >{{ values.length }} banner selected</span
                >
              </template>
            </multiselect>

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `business_widget_id.business_widget_id_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `business_widget_id.business_widget_id_${selectedLanguage}`
                )
              "
            ></p>
          </div>
        </div>
      </div>
    </div>

    <div
      class="border rounded w-full mt-8"
      :class="collapseStates[5] ? 'bg-blue-50' : ''"
    >
      <div
        class="lg:border-b lg:border-t lg:border-gray-200 cursor-pointer"
        @click.prevent="collapseStates[5] = !collapseStates[5]"
      >
        <nav class="mx-auto" aria-label="Section">
          <ol
            role="list"
            class="overflow-hidden rounded-md lg:flex lg:rounded-none lg:border-l lg:border-r lg:border-gray-200"
          >
            <li class="relative overflow-hidden lg:flex-1">
              <div
                class="overflow-hidden border border-gray-200 rounded-t-md border-b-0 lg:border-0 flex justify-between items-center"
              >
                <div class="group w-full">
                  <span
                    class="absolute left-0 top-0 h-full w-1 bg-transparent group-hover:bg-primary lg:bottom-0 lg:top-auto lg:h-1 lg:w-full"
                    aria-hidden="true"
                  ></span>
                  <span class="flex items-start px-6 py-2 text-sm font-medium">
                    <span class="flex-shrink-0">
                      <span
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-primary"
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke-width="1.5"
                          stroke="currentColor"
                          class="h-6 w-6 text-white"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z"
                          />
                        </svg>
                      </span>
                    </span>
                    <span class="ml-4 mt-0.5 flex min-w-0 flex-col">
                      <span class="text-sm font-medium"
                        >Featured events section</span
                      >
                      <span class="text-sm font-medium text-gray-500"
                        >Featured events section settings</span
                      >
                    </span>
                  </span>
                </div>
                <svg
                  class="w-5 h-5 fill-current text-gray-500"
                  viewBox="0 0 20 20"
                >
                  <path d="M6 9l4 4 4-4"></path>
                </svg>
              </div>
            </li>
          </ol>
        </nav>
      </div>
      <div class="p-4 bg-gray-50 border-t" v-if="collapseStates[5]">
        <div
          class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
        >
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`section5_heading_${selectedLanguage}`"
              >Section heading</label
            >
            <input
              type="text"
              :name="`section5_heading_${selectedLanguage}`"
              :id="`section5_heading_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'section5_heading',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['section5_heading'] &&
                form['section5_heading'][`section5_heading_${selectedLanguage}`]
                  ? form['section5_heading'][
                      `section5_heading_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `section5_heading.section5_heading_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `section5_heading.section5_heading_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`section5_event_detail_button_text_${selectedLanguage}`"
              >Event detail button text</label
            >
            <input
              type="text"
              :name="`section5_event_detail_button_text_${selectedLanguage}`"
              :id="`section5_event_detail_button_text_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'section5_event_detail_button_text',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['section5_event_detail_button_text'] &&
                form['section5_event_detail_button_text'][
                  `section5_event_detail_button_text_${selectedLanguage}`
                ]
                  ? form['section5_event_detail_button_text'][
                      `section5_event_detail_button_text_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `section5_event_detail_button_text.section5_event_detail_button_text_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `section5_event_detail_button_text.section5_event_detail_button_text_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`section5_website_button_text_${selectedLanguage}`"
              >Website button text</label
            >
            <input
              type="text"
              :name="`section5_website_button_text_${selectedLanguage}`"
              :id="`section5_website_button_text_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'section5_website_button_text',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['section5_website_button_text'] &&
                form['section5_website_button_text'][
                  `section5_website_button_text_${selectedLanguage}`
                ]
                  ? form['section5_website_button_text'][
                      `section5_website_button_text_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `section5_website_button_text.section5_website_button_text_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `section5_website_button_text.section5_website_button_text_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`section5_see_all_button_text_${selectedLanguage}`"
              >See all events text</label
            >
            <input
              type="text"
              :name="`section5_see_all_button_text_${selectedLanguage}`"
              :id="`section5_see_all_button_text_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'section5_see_all_button_text',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['section5_see_all_button_text'] &&
                form['section5_see_all_button_text'][
                  `section5_see_all_button_text_${selectedLanguage}`
                ]
                  ? form['section5_see_all_button_text'][
                      `section5_see_all_button_text_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `section5_see_all_button_text.section5_see_all_button_text_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `section5_see_all_button_text.section5_see_all_button_text_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`section5_see_all_button_url_${selectedLanguage}`"
              >See all events url</label
            >
            <input
              type="text"
              :name="`section5_see_all_button_url_${selectedLanguage}`"
              :id="`section5_see_all_button_url_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'section5_see_all_button_url',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['section5_see_all_button_url'] &&
                form['section5_see_all_button_url'][
                  `section5_see_all_button_url_${selectedLanguage}`
                ]
                  ? form['section5_see_all_button_url'][
                      `section5_see_all_button_url_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `section5_see_all_button_url.section5_see_all_button_url_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `section5_see_all_button_url.section5_see_all_button_url_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`section5_add_event_text_${selectedLanguage}`"
              >Add new event button text</label
            >
            <input
              type="text"
              :name="`section5_add_event_text_${selectedLanguage}`"
              :id="`section5_add_event_text_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'section5_add_event_text',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['section5_add_event_text'] &&
                form['section5_add_event_text'][
                  `section5_add_event_text_${selectedLanguage}`
                ]
                  ? form['section5_add_event_text'][
                      `section5_add_event_text_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `section5_add_event_text.section5_add_event_text_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `section5_add_event_text.section5_add_event_text_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`section5_add_event_url_${selectedLanguage}`"
              >Add new event button url</label
            >
            <input
              type="text"
              :name="`section5_add_event_url_${selectedLanguage}`"
              :id="`section5_add_event_url_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'section5_add_event_url',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['section5_add_event_url'] &&
                form['section5_add_event_url'][
                  `section5_add_event_url_${selectedLanguage}`
                ]
                  ? form['section5_add_event_url'][
                      `section5_add_event_url_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `section5_add_event_url.section5_add_event_url_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `section5_add_event_url.section5_add_event_url_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div v-if="index == 0">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`events_widget_id_${selectedLanguage}`"
              >Banner</label
            >
            <multiselect
              v-model="selectedEventsWidgetId"
              @select="updateEventsWidgetId"
              @remove="updateEventsWidgetId"
              :options="widgets"
              :multiple="false"
              :close-on-select="false"
              :clear-on-select="false"
              :preserve-search="true"
              placeholder="Select banner"
              label="name"
              track-by="id"
              :preselect-first="false"
            >
              <template #selection="{ values, search, isOpen }">
                <span
                  class="multiselect__single"
                  v-if="values.length"
                  v-show="!isOpen"
                  >{{ values.length }} banner selected</span
                >
              </template>
            </multiselect>

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `events_widget_id.events_widget_id_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `events_widget_id.events_widget_id_${selectedLanguage}`
                )
              "
            ></p>
          </div>
        </div>
      </div>
    </div>

    <div
      class="border rounded w-full mt-8"
      :class="collapseStates[6] ? 'bg-blue-50' : ''"
    >
      <div
        class="lg:border-b lg:border-t lg:border-gray-200 cursor-pointer"
        @click.prevent="collapseStates[6] = !collapseStates[6]"
      >
        <nav class="mx-auto" aria-label="Section">
          <ol
            role="list"
            class="overflow-hidden rounded-md lg:flex lg:rounded-none lg:border-l lg:border-r lg:border-gray-200"
          >
            <li class="relative overflow-hidden lg:flex-1">
              <div
                class="overflow-hidden border border-gray-200 rounded-t-md border-b-0 lg:border-0 flex justify-between items-center"
              >
                <div class="group w-full">
                  <span
                    class="absolute left-0 top-0 h-full w-1 bg-transparent group-hover:bg-primary lg:bottom-0 lg:top-auto lg:h-1 lg:w-full"
                    aria-hidden="true"
                  ></span>
                  <span class="flex items-start px-6 py-2 text-sm font-medium">
                    <span class="flex-shrink-0">
                      <span
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-primary"
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke-width="1.5"
                          stroke="currentColor"
                          class="h-6 w-6 text-white"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z"
                          />
                        </svg>
                      </span>
                    </span>
                    <span class="ml-4 mt-0.5 flex min-w-0 flex-col">
                      <span class="text-sm font-medium">Magazine section</span>
                      <span class="text-sm font-medium text-gray-500"
                        >Canadian Exports magazine section settings</span
                      >
                    </span>
                  </span>
                </div>
                <svg
                  class="w-5 h-5 fill-current text-gray-500"
                  viewBox="0 0 20 20"
                >
                  <path d="M6 9l4 4 4-4"></path>
                </svg>
              </div>
            </li>
          </ol>
        </nav>
      </div>
      <div class="p-4 bg-gray-50 border-t" v-if="collapseStates[6]">
        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
          <div class="col-span-6 sm:col-span-3">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`section6_heading_${selectedLanguage}`"
              >Section heading</label
            >
            <input
              type="text"
              :name="`section6_heading_${selectedLanguage}`"
              :id="`section6_heading_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'section6_heading',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['section6_heading'] &&
                form['section6_heading'][`section6_heading_${selectedLanguage}`]
                  ? form['section6_heading'][
                      `section6_heading_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `section6_heading.section6_heading_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `section6_heading.section6_heading_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="col-span-6 sm:col-span-3">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`section6_see_all_button_${selectedLanguage}`"
              >See all button text</label
            >
            <input
              type="text"
              :name="`section6_see_all_button_${selectedLanguage}`"
              :id="`section6_see_all_button_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'section6_see_all_button',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['section6_see_all_button'] &&
                form['section6_see_all_button'][
                  `section6_see_all_button_${selectedLanguage}`
                ]
                  ? form['section6_see_all_button'][
                      `section6_see_all_button_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `section6_see_all_button.section6_see_all_button_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `section6_see_all_button.section6_see_all_button_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="col-span-6" v-if="isDataLoaded">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`section6_description_${selectedLanguage}`"
              >Description</label
            >
            <editor
              @mouseleave="
                handleSelectionChange(
                  language,
                  'section6_description',
                  'updateHomePageSetting'
                )
              "
              @keyup="
                handleSelectionChange(
                  language,
                  'section6_description',
                  'updateHomePageSetting'
                )
              "
              :ref="`section6_description_${language.id}`"
              :id="`section6_description_${language.id}`"
              :initial-value="
                form[`section6_description`][
                  `section6_description_${language?.id}`
                ]
              "
              :tinymce-script-src="tinymceScriptSrc"
              :init="editorConfig"
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `section6_description.section6_description_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `section6_description.section6_description_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div v-if="index == 0" class="col-span-6 sm:col-span-2">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`magazine_widget_id_${selectedLanguage}`"
              >Banner</label
            >
            <multiselect
              v-model="selectedMagazineWidgetId"
              @select="updateMagazineWidgetId"
              @remove="updateMagazineWidgetId"
              :options="widgets"
              :multiple="false"
              :close-on-select="false"
              :clear-on-select="false"
              :preserve-search="true"
              placeholder="Select banner"
              label="name"
              track-by="id"
              :preselect-first="false"
            >
              <template #selection="{ values, search, isOpen }">
                <span
                  class="multiselect__single"
                  v-if="values.length"
                  v-show="!isOpen"
                  >{{ values.length }} banner selected</span
                >
              </template>
            </multiselect>

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `magazine_widget_id.magazine_widget_id_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `magazine_widget_id.magazine_widget_id_${selectedLanguage}`
                )
              "
            ></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>



<script>
import Multiselect from "vue-multiselect";
import Editor from "@tinymce/tinymce-vue";
import axios from "axios";
import { mapState } from "vuex";
export default {
  props: ["selectedLanguage"],
  computed: {
    ...mapState({
      form: (state) => state.pages.form,
      validationErros: (state) => state.pages.validationErros,
      languages: (state) => state.languages.languages,
      widgets: (state) => state.widgets.widgets,
      business_profiles: (state) => state.business_profiles.business_profiles,
    }),
  },

  components: {
    editor: Editor,
    Multiselect,
  },
  data() {
    return {
      selectedHeaderWidgetId: null,
      selectedBusinessCategoryWidgetId: null,
      selectedI2bWidgetId: null,
      selectedSponsorWidgetId: null,
      selectedBusinessWidgetId: null,
      selectedEventsWidgetId: null,
      selectedMagazineWidgetId: null,
      selectedBusinessCategories: null,
      collapseStates: [true, false, false, false, false, false, false],
      isDataLoaded: false,
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
    updateHeaderWidgetId(selectedWidget) {
      this.$store.commit("pages/setHeaderWidgetId", this.selectedHeaderWidgetId?.id || null);
    },
    updateBusinessCategoryWidgetId(selectedWidget) {
      this.$store.commit(
        "pages/setBusinessCategoryWidgetId",
        this.selectedBusinessCategoryWidgetId?.id || null
      );
    },
    updateI2bWidgetId(selectedWidget) {
      this.$store.commit("pages/setI2bWidgetId", this.selectedI2bWidgetId?.id || null);
    },
    updateSponsorWidgetId(selectedWidget) {
      this.$store.commit("pages/setSponsorWidgetId", this.selectedSponsorWidgetId?.id || null);
    },
    updateBusinessWidgetId(selectedWidget) {
      this.$store.commit("pages/setBusinessWidgetId", this.selectedBusinessWidgetId?.id || null);
    },
    updateEventsWidgetId(selectedWidget) {
      this.$store.commit("pages/setEventsWidgetId", this.selectedEventsWidgetId?.id || null);
    },
    updateMagazineWidgetId(selectedWidget) {
      this.$store.commit("pages/setMagazineWidgetId", this.selectedMagazineWidgetId?.id || null);
    },
    updateBusinessCategories(selectedBusinessCategory) {
      let selectedBusinessCategories = [];
      this.selectedBusinessCategories.map((business_category) => {
        selectedBusinessCategories.push(business_category?.id);
      });
      this.$store.commit(
        "pages/setBusinessCategoriesForm",
        selectedBusinessCategories
      );
    },
    handleSelectionChange(language, key, mutationName) {
      this.handleInput(
        tinymce.get(`${key}_${language.id}`).getContent(),
        language,
        key,
        mutationName
      );
    },
    handleInput(value, language, key, mutationName) {
      // console.log(value, key, language, mutationName);
      this.$store.commit(`pages/${mutationName}`, {
        value: value,
        id: language.id,
        key,
      });
    },
    handleImage(e, language, key, mutationName) {
      // console.log(e.target.files[0], key, language, mutationName);
      var file = new FormData();
      file.append("file", e.target.files[0]);
      axios.post("/api/admin/media/image_again_upload", file).then((res) => {
        this.$store.commit(`pages/${mutationName}`, {
          value: res?.data,
          id: language.id,
          key,
        });
      });
    },
    updateForm(key, value) {
      this.$store.commit("pages/setPageValues", {
        key: key,
        value: value,
      });
    },
    fetchHomePageSetting() {
      this.$store
        .dispatch("pages/fetchPage", {
          url: `${process.env.MIX_ADMIN_API_URL}home-page-setting?withHomePageSettingDetail=1&findByPageId=${this.form.id}`,
        })
        .then((res) => {
          let data = res?.data?.data?.home_page_setting_detail || [];
          let home_page_setting = res?.data?.data || null;
          this.selectedHeaderWidgetId =
            home_page_setting?.header_widget || null;
          this.selectedBusinessCategoryWidgetId =
            home_page_setting?.business_category_widget || null;
          this.selectedI2bWidgetId = home_page_setting?.i2b_widget || null;
          this.selectedSponsorWidgetId =
            home_page_setting?.sponsor_widget || null;
          this.selectedBusinessWidgetId =
            home_page_setting?.business_widget || null;
          this.selectedEventsWidgetId =
            home_page_setting?.events_widget || null;
          this.selectedMagazineWidgetId =
            home_page_setting?.magazine_widget || null;
          this.updateHeaderWidgetId(home_page_setting?.header_widget);
          this.updateBusinessCategoryWidgetId(
            home_page_setting?.business_category_widget
          );
          this.updateI2bWidgetId(home_page_setting?.i2b_widget);
          this.updateSponsorWidgetId(home_page_setting?.sponsor_widget);
          this.updateBusinessWidgetId(home_page_setting?.business_widget);
          this.updateEventsWidgetId(home_page_setting?.events_widget);
          this.updateMagazineWidgetId(home_page_setting?.magazine_widget);
          this.updateForm(
            "number_of_featured_exporters",
            home_page_setting?.number_of_featured_exporters || null
          );
          this.selectedBusinessCategories =
            home_page_setting?.business_profiles;
          this.updateBusinessCategories(null);

          let obj = {};
          data.map((res) => {
            obj["slider_heading_" + res.language_id] = res.slider_heading;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "slider_heading",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["slider_search_placeholder_" + res.language_id] =
              res.slider_search_placeholder;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "slider_search_placeholder",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["slider_advance_search_text_" + res.language_id] =
              res.slider_advance_search_text;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "slider_advance_search_text",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["slider_image_" + res.language_id] = res.slider_image;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "slider_image",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["section1_heading_" + res.language_id] = res.section1_heading;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "section1_heading",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["section1_description_" + res.language_id] =
              res.section1_description;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "section1_description",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["section1_business_category_" + res.language_id] =
              res.section1_business_category;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "section1_business_category",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["section1_business_category_url_" + res.language_id] =
              res.section1_business_category_url;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "section1_business_category_url",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["section2_heading_" + res.language_id] = res.section2_heading;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "section2_heading",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["section2_category_label_" + res.language_id] =
              res.section2_category_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "section2_category_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["section2_country_label_" + res.language_id] =
              res.section2_country_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "section2_country_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["section2_deadline_label_" + res.language_id] =
              res.section2_deadline_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "section2_deadline_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["section2_estimated_value_label_" + res.language_id] =
              res.section2_estimated_value_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "section2_estimated_value_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["section2_i2b_button_text_" + res.language_id] =
              res.section2_i2b_button_text;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "section2_i2b_button_text",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["section2_button_text_" + res.language_id] =
              res.section2_button_text;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "section2_button_text",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["section2_button_url_" + res.language_id] =
              res.section2_button_url;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "section2_button_url",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["section3_heading_" + res.language_id] = res.section3_heading;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "section3_heading",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["section3_button_text_" + res.language_id] =
              res.section3_button_text;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "section3_button_text",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["section3_button_url_" + res.language_id] =
              res.section3_button_url;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "section3_button_url",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["sponsor_value_button_text_" + res.language_id] =
              res.sponsor_value_button_text;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "sponsor_value_button_text",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["sponsor_value_button_url_" + res.language_id] =
              res.sponsor_value_button_url;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "sponsor_value_button_url",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["section4_heading_" + res.language_id] = res.section4_heading;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "section4_heading",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["contact_for_rates_btn_text_" + res.language_id] =
              res.contact_for_rates_btn_text;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "contact_for_rates_btn_text",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["contact_for_rates_btn_url_" + res.language_id] =
              res.contact_for_rates_btn_url;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "contact_for_rates_btn_url",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["section5_heading_" + res.language_id] = res.section5_heading;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "section5_heading",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["section5_event_detail_button_text_" + res.language_id] =
              res.section5_event_detail_button_text;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "section5_event_detail_button_text",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["section5_website_button_text_" + res.language_id] =
              res.section5_website_button_text;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "section5_website_button_text",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["section5_see_all_button_text_" + res.language_id] =
              res.section5_see_all_button_text;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "section5_see_all_button_text",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["section5_see_all_button_url_" + res.language_id] =
              res.section5_see_all_button_url;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "section5_see_all_button_url",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["section5_add_event_text_" + res.language_id] =
              res.section5_add_event_text;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "section5_add_event_text",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["section5_add_event_url_" + res.language_id] =
              res.section5_add_event_url;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "section5_add_event_url",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["section6_heading_" + res.language_id] = res.section6_heading;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "section6_heading",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["section6_description_" + res.language_id] =
              res.section6_description;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "section6_description",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["section6_see_all_button_" + res.language_id] =
              res.section6_see_all_button;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "section6_see_all_button",
            value: obj,
          });
          this.isDataLoaded = 1;
        });
    },
    checkValidationError(validationErros, language) {
      return (
        validationErros.has(`slider_heading.slider_heading_${language.id}`) ||
        validationErros.has(
          `slider_search_placeholder.slider_search_placeholder_${language.id}`
        ) ||
        validationErros.has(
          `slider_advance_search_text.slider_advance_search_text_${language.id}`
        ) ||
        validationErros.has(`slider_image.slider_image_${language.id}`) ||
        validationErros.has(
          `section1_heading.section1_heading_${language.id}`
        ) ||
        validationErros.has(
          `section1_description.section1_description_${language.id}`
        ) ||
        validationErros.has(
          `section1_business_category.section1_business_category_${language.id}`
        ) ||
        validationErros.has(
          `section1_business_category_url.section1_business_category_url_${language.id}`
        ) ||
        validationErros.has(
          `section2_heading.section2_heading_${language.id}`
        ) ||
        validationErros.has(
          `section2_category_label.section2_category_label_${language.id}`
        ) ||
        validationErros.has(
          `section2_country_label.section2_country_label_${language.id}`
        ) ||
        validationErros.has(
          `section2_deadline_label.section2_deadline_label_${language.id}`
        ) ||
        validationErros.has(
          `section2_estimated_value_label.section2_estimated_value_label_${language.id}`
        ) ||
        validationErros.has(
          `section2_i2b_button_text.section2_i2b_button_text_${language.id}`
        ) ||
        validationErros.has(
          `section2_button_text.section2_button_text_${language.id}`
        ) ||
        validationErros.has(
          `section2_button_url.section2_button_url_${language.id}`
        ) ||
        validationErros.has(
          `section3_heading.section3_heading_${language.id}`
        ) ||
        validationErros.has(
          `section3_button_text.section3_button_text_${language.id}`
        ) ||
        validationErros.has(
          `section3_button_url.section3_button_url_${language.id}`
        ) ||
        validationErros.has(
          `sponsor_value_button_text.sponsor_value_button_text_${language.id}`
        ) ||
        validationErros.has(
          `sponsor_value_button_url.sponsor_value_button_url_${language.id}`
        ) ||
        validationErros.has(
          `section4_heading.section4_heading_${language.id}`
        ) ||
        validationErros.has(
          `contact_for_rates_btn_text.contact_for_rates_btn_text_${language.id}`
        ) ||
        validationErros.has(
          `contact_for_rates_btn_url.contact_for_rates_btn_url_${language.id}`
        ) ||
        validationErros.has(
          `section5_heading.section5_heading_${language.id}`
        ) ||
        validationErros.has(
          `section5_event_detail_button_text.section5_event_detail_button_text_${language.id}`
        ) ||
        validationErros.has(
          `section5_website_button_text.section5_website_button_text_${language.id}`
        ) ||
        validationErros.has(
          `section5_see_all_button_text.section5_see_all_button_text_${language.id}`
        ) ||
        validationErros.has(
          `section5_see_all_button_url.section5_see_all_button_url_${language.id}`
        ) ||
        validationErros.has(
          `section5_add_event_text.section5_add_event_text_${language.id}`
        ) ||
        validationErros.has(
          `section5_add_event_url.section5_add_event_url_${language.id}`
        ) ||
        validationErros.has(
          `section6_heading.section6_heading_${language.id}`
        ) ||
        validationErros.has(
          `section6_description.section6_description_${language.id}`
        ) ||
        validationErros.has(
          `section6_see_all_button.section6_see_all_button_${language.id}`
        )
      );
    },
  },
  created() {
    // this.$store.commit("pages/resetForm");
    this.$store
      .dispatch("languages/fetchLanguages", {
        url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
      })
      .then((res) => {
        let data = res.data.data;
        let obj = {};
        data.map((res) => {
          obj["slider_heading_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "slider_heading",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["slider_search_placeholder_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "slider_search_placeholder",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["slider_advance_search_text_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "slider_advance_search_text",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["section1_heading_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "section1_heading",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["section1_description_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "section1_description",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["section1_business_category_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "section1_business_category",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["section1_business_category_url_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "section1_business_category_url",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["section2_heading_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "section2_heading",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["section2_category_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "section2_category_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["section2_country_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "section2_country_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["section2_deadline_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "section2_deadline_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["section2_estimated_value_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "section2_estimated_value_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["section2_i2b_button_text_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "section2_i2b_button_text",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["section2_button_text_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "section2_button_text",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["section2_button_url_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "section2_button_url",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["section3_heading_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "section3_heading",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["section3_button_text_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "section3_button_text",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["section3_button_url_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "section3_button_url",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["sponsor_value_button_text_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "sponsor_value_button_text",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["sponsor_value_button_url_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "sponsor_value_button_url",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["section4_heading_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "section4_heading",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["contact_for_rates_btn_text_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "contact_for_rates_btn_text",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["contact_for_rates_btn_url_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "contact_for_rates_btn_url",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["section5_heading_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "section5_heading",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["section5_event_detail_button_text_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "section5_event_detail_button_text",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["section5_website_button_text_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "section5_website_button_text",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["section5_see_all_button_text_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "section5_see_all_button_text",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["section5_see_all_button_url_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "section5_see_all_button_url",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["section5_add_event_text_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "section5_add_event_text",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["section5_add_event_url_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "section5_add_event_url",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["section6_heading_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "section6_heading",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["section6_description_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "section6_description",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["section6_see_all_button_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "section6_see_all_button",
          value: obj,
        });
        if (this.$route.params.id) {
          this.fetchHomePageSetting();
        } else {
          this.isDataLoaded = 1;
        }
        this.$store.dispatch("business_profiles/fetchBusinessProfiles", {
          url: `${process.env.MIX_ADMIN_API_URL}business-profiles?getAll=1&sortBy=company_name&sortType=asc`,
        });
      });
  },
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>