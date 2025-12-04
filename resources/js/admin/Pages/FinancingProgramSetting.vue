<template>
  <div
    class="my-5"
    v-for="language in languages"
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
                      <span class="text-sm font-medium">Form settings</span>
                      <span class="text-sm font-medium text-gray-500"
                        >Financing programs form setting e.g. label & error
                        messages</span
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
      <div class="p-4 bg-gray-50 border-t" v-show="collapseStates[0]">
        <div
          class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
        >
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`required_fields_text_${selectedLanguage}`"
              >Required fields text</label
            >
            <input
              type="text"
              :name="`required_fields_text_${selectedLanguage}`"
              :id="`required_fields_text_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'required_fields_text',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['required_fields_text'] &&
                form['required_fields_text'][
                  `required_fields_text_${selectedLanguage}`
                ]
                  ? form['required_fields_text'][
                      `required_fields_text_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `required_fields_text.required_fields_text_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `required_fields_text.required_fields_text_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`zipcode_label_${selectedLanguage}`"
              >Label for zipcode</label
            >
            <input
              type="text"
              :name="`zipcode_label_${selectedLanguage}`"
              :id="`zipcode_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'zipcode_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['zipcode_label'] &&
                form['zipcode_label'][`zipcode_label_${selectedLanguage}`]
                  ? form['zipcode_label'][`zipcode_label_${selectedLanguage}`]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `zipcode_label.zipcode_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `zipcode_label.zipcode_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`zipcode_placeholder_${selectedLanguage}`"
              >Placeholder for zipcode</label
            >
            <input
              type="text"
              :name="`zipcode_placeholder_${selectedLanguage}`"
              :id="`zipcode_placeholder_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'zipcode_placeholder',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['zipcode_placeholder'] &&
                form['zipcode_placeholder'][
                  `zipcode_placeholder_${selectedLanguage}`
                ]
                  ? form['zipcode_placeholder'][
                      `zipcode_placeholder_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `zipcode_placeholder.zipcode_placeholder_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `zipcode_placeholder.zipcode_placeholder_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`zipcode_error_${selectedLanguage}`"
              >Error for zipcode</label
            >
            <input
              type="text"
              :name="`zipcode_error_${selectedLanguage}`"
              :id="`zipcode_error_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'zipcode_error',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['zipcode_error'] &&
                form['zipcode_error'][`zipcode_error_${selectedLanguage}`]
                  ? form['zipcode_error'][`zipcode_error_${selectedLanguage}`]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `zipcode_error.zipcode_error_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `zipcode_error.zipcode_error_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`business_name_label_${selectedLanguage}`"
              >Label for business name</label
            >
            <input
              type="text"
              :name="`business_name_label_${selectedLanguage}`"
              :id="`business_name_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'business_name_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['business_name_label'] &&
                form['business_name_label'][`business_name_label_${selectedLanguage}`]
                  ? form['business_name_label'][`business_name_label_${selectedLanguage}`]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `business_name_label.business_name_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `business_name_label.business_name_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`business_name_placeholder_${selectedLanguage}`"
              >Placeholder for business name</label
            >
            <input
              type="text"
              :name="`business_name_placeholder_${selectedLanguage}`"
              :id="`business_name_placeholder_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'business_name_placeholder',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['business_name_placeholder'] &&
                form['business_name_placeholder'][
                  `business_name_placeholder_${selectedLanguage}`
                ]
                  ? form['business_name_placeholder'][
                      `business_name_placeholder_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `business_name_placeholder.business_name_placeholder_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `business_name_placeholder.business_name_placeholder_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`business_name_error_${selectedLanguage}`"
              >Error for business name</label
            >
            <input
              type="text"
              :name="`business_name_error_${selectedLanguage}`"
              :id="`business_name_error_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'business_name_error',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['business_name_error'] &&
                form['business_name_error'][`business_name_error_${selectedLanguage}`]
                  ? form['business_name_error'][`business_name_error_${selectedLanguage}`]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `business_name_error.business_name_error_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `business_name_error.business_name_error_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`name_title_label_${selectedLanguage}`"
              >Label for name title</label
            >
            <input
              type="text"
              :name="`name_title_label_${selectedLanguage}`"
              :id="`name_title_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'name_title_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['name_title_label'] &&
                form['name_title_label'][`name_title_label_${selectedLanguage}`]
                  ? form['name_title_label'][`name_title_label_${selectedLanguage}`]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `name_title_label.name_title_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `name_title_label.name_title_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`name_title_placeholder_${selectedLanguage}`"
              >Placeholder for name title</label
            >
            <input
              type="text"
              :name="`name_title_placeholder_${selectedLanguage}`"
              :id="`name_title_placeholder_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'name_title_placeholder',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['name_title_placeholder'] &&
                form['name_title_placeholder'][
                  `name_title_placeholder_${selectedLanguage}`
                ]
                  ? form['name_title_placeholder'][
                      `name_title_placeholder_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `name_title_placeholder.name_title_placeholder_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `name_title_placeholder.name_title_placeholder_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`name_title_error_${selectedLanguage}`"
              >Error for name title</label
            >
            <input
              type="text"
              :name="`name_title_error_${selectedLanguage}`"
              :id="`name_title_error_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'name_title_error',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['name_title_error'] &&
                form['name_title_error'][`name_title_error_${selectedLanguage}`]
                  ? form['name_title_error'][`name_title_error_${selectedLanguage}`]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `name_title_error.name_title_error_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `name_title_error.name_title_error_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`email_label_${selectedLanguage}`"
              >Label for email</label
            >
            <input
              type="text"
              :name="`email_label_${selectedLanguage}`"
              :id="`email_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'email_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['email_label'] &&
                form['email_label'][`email_label_${selectedLanguage}`]
                  ? form['email_label'][`email_label_${selectedLanguage}`]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `email_label.email_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `email_label.email_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`email_placeholder_${selectedLanguage}`"
              >Placeholder for email</label
            >
            <input
              type="text"
              :name="`email_placeholder_${selectedLanguage}`"
              :id="`email_placeholder_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'email_placeholder',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['email_placeholder'] &&
                form['email_placeholder'][
                  `email_placeholder_${selectedLanguage}`
                ]
                  ? form['email_placeholder'][
                      `email_placeholder_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `email_placeholder.email_placeholder_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `email_placeholder.email_placeholder_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`email_error_${selectedLanguage}`"
              >Error for email</label
            >
            <input
              type="text"
              :name="`email_error_${selectedLanguage}`"
              :id="`email_error_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'email_error',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['email_error'] &&
                form['email_error'][`email_error_${selectedLanguage}`]
                  ? form['email_error'][`email_error_${selectedLanguage}`]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `email_error.email_error_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `email_error.email_error_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`incorporation_label_${selectedLanguage}`"
              >Label for year of incorporation</label
            >
            <input
              type="text"
              :name="`incorporation_label_${selectedLanguage}`"
              :id="`incorporation_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'incorporation_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['incorporation_label'] &&
                form['incorporation_label'][
                  `incorporation_label_${selectedLanguage}`
                ]
                  ? form['incorporation_label'][
                      `incorporation_label_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `incorporation_label.incorporation_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `incorporation_label.incorporation_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`incorporation_placeholder_${selectedLanguage}`"
              >Placeholder for year of incorporation</label
            >
            <input
              type="text"
              :name="`incorporation_placeholder_${selectedLanguage}`"
              :id="`incorporation_placeholder_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'incorporation_placeholder',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['incorporation_placeholder'] &&
                form['incorporation_placeholder'][
                  `incorporation_placeholder_${selectedLanguage}`
                ]
                  ? form['incorporation_placeholder'][
                      `incorporation_placeholder_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `incorporation_placeholder.incorporation_placeholder_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `incorporation_placeholder.incorporation_placeholder_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`incorporation_error_${selectedLanguage}`"
              >Error for year of incorporation</label
            >
            <input
              type="text"
              :name="`incorporation_error_${selectedLanguage}`"
              :id="`incorporation_error_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'incorporation_error',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['incorporation_error'] &&
                form['incorporation_error'][
                  `incorporation_error_${selectedLanguage}`
                ]
                  ? form['incorporation_error'][
                      `incorporation_error_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `incorporation_error.incorporation_error_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `incorporation_error.incorporation_error_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`full_time_employees_label_${selectedLanguage}`"
              >Label for # of full time employees</label
            >
            <input
              type="text"
              :name="`full_time_employees_label_${selectedLanguage}`"
              :id="`full_time_employees_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'full_time_employees_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['full_time_employees_label'] &&
                form['full_time_employees_label'][
                  `full_time_employees_label_${selectedLanguage}`
                ]
                  ? form['full_time_employees_label'][
                      `full_time_employees_label_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `full_time_employees_label.full_time_employees_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `full_time_employees_label.full_time_employees_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`full_time_employees_placeholder_${selectedLanguage}`"
              >Placeholder for # of full time employees</label
            >
            <input
              type="text"
              :name="`full_time_employees_placeholder_${selectedLanguage}`"
              :id="`full_time_employees_placeholder_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'full_time_employees_placeholder',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['full_time_employees_placeholder'] &&
                form['full_time_employees_placeholder'][
                  `full_time_employees_placeholder_${selectedLanguage}`
                ]
                  ? form['full_time_employees_placeholder'][
                      `full_time_employees_placeholder_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `full_time_employees_placeholder.full_time_employees_placeholder_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `full_time_employees_placeholder.full_time_employees_placeholder_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`full_time_employees_error_${selectedLanguage}`"
              >Error for # of full time employees</label
            >
            <input
              type="text"
              :name="`full_time_employees_error_${selectedLanguage}`"
              :id="`full_time_employees_error_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'full_time_employees_error',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['full_time_employees_error'] &&
                form['full_time_employees_error'][
                  `full_time_employees_error_${selectedLanguage}`
                ]
                  ? form['full_time_employees_error'][
                      `full_time_employees_error_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `full_time_employees_error.full_time_employees_error_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `full_time_employees_error.full_time_employees_error_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`revenue_last_year_label_${selectedLanguage}`"
              >Label for revenue last year</label
            >
            <input
              type="text"
              :name="`revenue_last_year_label_${selectedLanguage}`"
              :id="`revenue_last_year_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'revenue_last_year_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['revenue_last_year_label'] &&
                form['revenue_last_year_label'][
                  `revenue_last_year_label_${selectedLanguage}`
                ]
                  ? form['revenue_last_year_label'][
                      `revenue_last_year_label_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `revenue_last_year_label.revenue_last_year_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `revenue_last_year_label.revenue_last_year_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`revenue_last_year_placeholder_${selectedLanguage}`"
              >Placeholder for revenue last year</label
            >
            <input
              type="text"
              :name="`revenue_last_year_placeholder_${selectedLanguage}`"
              :id="`revenue_last_year_placeholder_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'revenue_last_year_placeholder',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['revenue_last_year_placeholder'] &&
                form['revenue_last_year_placeholder'][
                  `revenue_last_year_placeholder_${selectedLanguage}`
                ]
                  ? form['revenue_last_year_placeholder'][
                      `revenue_last_year_placeholder_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `revenue_last_year_placeholder.revenue_last_year_placeholder_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `revenue_last_year_placeholder.revenue_last_year_placeholder_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`revenue_last_year_error_${selectedLanguage}`"
              >Error for revenue last year</label
            >
            <input
              type="text"
              :name="`revenue_last_year_error_${selectedLanguage}`"
              :id="`revenue_last_year_error_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'revenue_last_year_error',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['revenue_last_year_error'] &&
                form['revenue_last_year_error'][
                  `revenue_last_year_error_${selectedLanguage}`
                ]
                  ? form['revenue_last_year_error'][
                      `revenue_last_year_error_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `revenue_last_year_error.revenue_last_year_error_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `revenue_last_year_error.revenue_last_year_error_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`company_ownership_label_${selectedLanguage}`"
              >Label for company ownership</label
            >
            <input
              type="text"
              :name="`company_ownership_label_${selectedLanguage}`"
              :id="`company_ownership_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'company_ownership_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['company_ownership_label'] &&
                form['company_ownership_label'][
                  `company_ownership_label_${selectedLanguage}`
                ]
                  ? form['company_ownership_label'][
                      `company_ownership_label_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `company_ownership_label.company_ownership_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `company_ownership_label.company_ownership_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`company_ownership_placeholder_${selectedLanguage}`"
              >Placeholder for company ownership</label
            >

            <input
            type="text"
            :name="`company_ownership_placeholder_${selectedLanguage}`"
              :id="`company_ownership_placeholder_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'company_ownership_placeholder',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['company_ownership_placeholder'] &&
                form['company_ownership_placeholder'][
                  `company_ownership_placeholder_${selectedLanguage}`
                ]
                  ? form['company_ownership_placeholder'][
                      `company_ownership_placeholder_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `company_ownership_placeholder.company_ownership_placeholder_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `company_ownership_placeholder.company_ownership_placeholder_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`company_ownership_error_${selectedLanguage}`"
              >Error for company ownership</label
            >
            <input
              type="text"
              :name="`company_ownership_error_${selectedLanguage}`"
              :id="`company_ownership_error_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'company_ownership_error',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['company_ownership_error'] &&
                form['company_ownership_error'][
                  `company_ownership_error_${selectedLanguage}`
                ]
                  ? form['company_ownership_error'][
                      `company_ownership_error_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `company_ownership_error.company_ownership_error_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `company_ownership_error.company_ownership_error_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`needs_intentions_label_${selectedLanguage}`"
              >Label for needs and intentions</label
            >
            <input
              type="text"
              :name="`needs_intentions_label_${selectedLanguage}`"
              :id="`needs_intentions_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'needs_intentions_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['needs_intentions_label'] &&
                form['needs_intentions_label'][
                  `needs_intentions_label_${selectedLanguage}`
                ]
                  ? form['needs_intentions_label'][
                      `needs_intentions_label_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `needs_intentions_label.needs_intentions_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `needs_intentions_label.needs_intentions_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`needs_intentions_placeholder_${selectedLanguage}`"
              >Placeholder for needs and intentions</label
            >
            <input
              type="text"
              :name="`needs_intentions_placeholder_${selectedLanguage}`"
              :id="`needs_intentions_placeholder_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'needs_intentions_placeholder',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['needs_intentions_placeholder'] &&
                form['needs_intentions_placeholder'][
                  `needs_intentions_placeholder_${selectedLanguage}`
                ]
                  ? form['needs_intentions_placeholder'][
                      `needs_intentions_placeholder_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `needs_intentions_placeholder.needs_intentions_placeholder_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `needs_intentions_placeholder.needs_intentions_placeholder_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`needs_intentions_error_${selectedLanguage}`"
              >Error for needs and intentions</label
            >
            <input
              type="text"
              :name="`needs_intentions_error_${selectedLanguage}`"
              :id="`needs_intentions_error_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'needs_intentions_error',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['needs_intentions_error'] &&
                form['needs_intentions_error'][
                  `needs_intentions_error_${selectedLanguage}`
                ]
                  ? form['needs_intentions_error'][
                      `needs_intentions_error_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `needs_intentions_error.needs_intentions_error_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `needs_intentions_error.needs_intentions_error_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`primary_industry_label_${selectedLanguage}`"
              >Label for business categories</label
            >
            <input
              type="text"
              :name="`primary_industry_label_${selectedLanguage}`"
              :id="`primary_industry_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'primary_industry_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['primary_industry_label'] &&
                form['primary_industry_label'][
                  `primary_industry_label_${selectedLanguage}`
                ]
                  ? form['primary_industry_label'][
                      `primary_industry_label_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `primary_industry_label.primary_industry_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `primary_industry_label.primary_industry_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`primary_industry_placeholder_${selectedLanguage}`"
              >Placeholder for business categories</label
            >
            <input
              type="text"
              :name="`primary_industry_placeholder_${selectedLanguage}`"
              :id="`primary_industry_placeholder_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'primary_industry_placeholder',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['primary_industry_placeholder'] &&
                form['primary_industry_placeholder'][
                  `primary_industry_placeholder_${selectedLanguage}`
                ]
                  ? form['primary_industry_placeholder'][
                      `primary_industry_placeholder_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `primary_industry_placeholder.primary_industry_placeholder_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `primary_industry_placeholder.primary_industry_placeholder_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`primary_industry_error_${selectedLanguage}`"
              >Error for business categories</label
            >
            <input
              type="text"
              :name="`primary_industry_error_${selectedLanguage}`"
              :id="`primary_industry_error_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'primary_industry_error',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['primary_industry_error'] &&
                form['primary_industry_error'][
                  `primary_industry_error_${selectedLanguage}`
                ]
                  ? form['primary_industry_error'][
                      `primary_industry_error_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `primary_industry_error.primary_industry_error_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `primary_industry_error.primary_industry_error_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`submit_button_text_${selectedLanguage}`"
              >Submit button text</label
            >
            <input
              type="text"
              :name="`submit_button_text_${selectedLanguage}`"
              :id="`submit_button_text_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'submit_button_text',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['submit_button_text'] &&
                form['submit_button_text'][
                  `submit_button_text_${selectedLanguage}`
                ]
                  ? form['submit_button_text'][
                      `submit_button_text_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `submit_button_text.submit_button_text_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `submit_button_text.submit_button_text_${selectedLanguage}`
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
import { mapState } from "vuex";
export default {
  props: ["selectedLanguage"],
  computed: {
    ...mapState({
      form: (state) => state.pages.form,
      validationErros: (state) => state.pages.validationErros,
      languages: (state) => state.languages.languages,
    }),
  },
  data() {
    return {
      collapseStates: [true, false, false, false, false, false, false],
    };
  },
  methods: {
    handleInput(value, language, key, mutationName) {
      // console.log(value, key, language, mutationName);
      this.$store.commit(`pages/${mutationName}`, {
        value: value,
        id: language.id,
        key,
      });
    },
    addUpdateForm() {
      this.$store.dispatch("pages/addUpdateForm").then((res) => {
        if (res.data.status == "Success") {
          this.$emit("addUpdateFormParent");
        }
      });
    },
    fetchPageSetting() {
      this.$store
        .dispatch("pages/fetchPage", {
          url: `${process.env.MIX_ADMIN_API_URL}financing-program-setting?withFinancingProgramSettingDetail=1&findByPageId=${this.form.id}`,
        })
        .then((res) => {
          let data =
            res.data.data && res.data.data.financing_program_setting_detail
              ? res.data.data.financing_program_setting_detail
              : [];

          let obj = {};
          data.map((res) => {
            obj["required_fields_text_" + res.language_id] = res.required_fields_text;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "required_fields_text",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["zipcode_label_" + res.language_id] = res.zipcode_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "zipcode_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["zipcode_placeholder_" + res.language_id] =
              res.zipcode_placeholder;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "zipcode_placeholder",
            value: obj,
          });


          obj = {};
          data.map((res) => {
            obj["business_name_label_" + res.language_id] = res.business_name_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "business_name_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["business_name_placeholder_" + res.language_id] =
              res.business_name_placeholder;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "business_name_placeholder",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["business_name_error_" + res.language_id] = res.business_name_error;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "business_name_error",
            value: obj,
          });


          obj = {};
          data.map((res) => {
            obj["name_title_label_" + res.language_id] = res.name_title_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "name_title_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["name_title_placeholder_" + res.language_id] =
              res.name_title_placeholder;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "name_title_placeholder",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["name_title_error_" + res.language_id] = res.name_title_error;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "name_title_error",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["email_label_" + res.language_id] = res.email_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "email_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["email_placeholder_" + res.language_id] =
              res.email_placeholder;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "email_placeholder",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["email_error_" + res.language_id] = res.email_error;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "email_error",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["incorporation_label_" + res.language_id] =
              res.incorporation_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "incorporation_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["incorporation_placeholder_" + res.language_id] =
              res.incorporation_placeholder;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "incorporation_placeholder",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["incorporation_error_" + res.language_id] =
              res.incorporation_error;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "incorporation_error",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["full_time_employees_label_" + res.language_id] =
              res.full_time_employees_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "full_time_employees_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["full_time_employees_placeholder_" + res.language_id] =
              res.full_time_employees_placeholder;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "full_time_employees_placeholder",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["full_time_employees_error_" + res.language_id] =
              res.full_time_employees_error;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "full_time_employees_error",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["revenue_last_year_label_" + res.language_id] =
              res.revenue_last_year_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "revenue_last_year_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["revenue_last_year_placeholder_" + res.language_id] =
              res.revenue_last_year_placeholder;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "revenue_last_year_placeholder",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["revenue_last_year_error_" + res.language_id] =
              res.revenue_last_year_error;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "revenue_last_year_error",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["company_ownership_label_" + res.language_id] =
              res.company_ownership_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "company_ownership_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["company_ownership_placeholder_" + res.language_id] =
              res.company_ownership_placeholder;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "company_ownership_placeholder",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["company_ownership_error_" + res.language_id] =
              res.company_ownership_error;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "company_ownership_error",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["needs_intentions_label_" + res.language_id] =
              res.needs_intentions_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "needs_intentions_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["needs_intentions_placeholder_" + res.language_id] =
              res.needs_intentions_placeholder;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "needs_intentions_placeholder",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["needs_intentions_error_" + res.language_id] =
              res.needs_intentions_error;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "needs_intentions_error",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["primary_industry_label_" + res.language_id] =
              res.primary_industry_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "primary_industry_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["primary_industry_placeholder_" + res.language_id] =
              res.primary_industry_placeholder;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "primary_industry_placeholder",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["primary_industry_error_" + res.language_id] =
              res.primary_industry_error;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "primary_industry_error",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["submit_button_text_" + res.language_id] =
              res.submit_button_text;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "submit_button_text",
            value: obj,
          });
        });
    },
    checkValidationError(validationErros, language) {
      return (
        validationErros.has(`required_fields_text.name_label_${language.id}`) ||
        validationErros.has(`zipcode_label.name_error_${language.id}`) ||
        validationErros.has(
          `zipcode_placeholder.zipcode_placeholder_${language.id}`
        ) ||
        validationErros.has(`zipcode_error.zipcode_error_${language.id}`) || validationErros.has(`business_name_label.business_name_error_${language.id}`) ||
        validationErros.has(
          `business_name_placeholder.business_name_placeholder_${language.id}`
        ) ||
        validationErros.has(`business_name_error.business_name_error_${language.id}`) ||
        validationErros.has(`name_title_label.name_title_error_${language.id}`) ||
        validationErros.has(
          `name_title_placeholder.name_title_placeholder_${language.id}`
        ) ||
        validationErros.has(`name_title_error.name_title_error_${language.id}`) ||
        validationErros.has(`email_label.email_error_${language.id}`) ||
        validationErros.has(
          `email_placeholder.email_placeholder_${language.id}`
        ) ||
        validationErros.has(`email_error.email_error_${language.id}`) ||
        validationErros.has(
          `incorporation_label.incorporation_label_${language.id}``incorporation_placeholder.incorporation_placeholder_${language.id}`
        ) ||
        validationErros.has(
          `incorporation_error.incorporation_error_${language.id}`
        ) ||
        validationErros.has(
          `full_time_employees_label.full_time_employees_label_${language.id}`
        ) ||
        validationErros.has(
          `full_time_employees_placeholder.full_time_employees_placeholder_${language.id}`
        ) ||
        validationErros.has(
          `full_time_employees_error.full_time_employees_error_${language.id}`
        ) ||
        validationErros.has(
          `revenue_last_year_label.revenue_last_year_label_${language.id}``revenue_last_year_placeholder.revenue_last_year_placeholder_${language.id}`
        ) ||
        validationErros.has(
          `revenue_last_year_error.revenue_last_year_error_${language.id}`
        ) ||
        validationErros.has(
          `company_ownership_label.company_ownership_label_${language.id}`
        ) ||
        validationErros.has(
          `company_ownership_placeholder.company_ownership_placeholder_${language.id}`
        ) ||
        validationErros.has(
          `company_ownership_error.company_ownership_error_${language.id}`
        ) ||
        validationErros.has(
          `needs_intentions_label.needs_intentions_label_${language.id}`
        ) ||
        validationErros.has(
          `needs_intentions_placeholder.needs_intentions_placeholder_${language.id}`
        ) ||
        validationErros.has(
          `needs_intentions_error.needs_intentions_error_${language.id}`
        ) ||
        validationErros.has(
          `primary_industry_label.primary_industry_label_${language.id}`
        ) ||
        validationErros.has(
          `primary_industry_placeholder.primary_industry_placeholder_${language.id}`
        ) ||
        validationErros.has(
          `primary_industry_error.primary_industry_error_${language.id}`
        ) ||
        validationErros.has(
          `submit_button_text.submit_button_text_${language.id}`
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
          obj["required_fields_text_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "required_fields_text",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["zipcode_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "zipcode_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["zipcode_placeholder_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "zipcode_placeholder",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["zipcode_error_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "zipcode_error",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["business_name_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "business_name_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["business_name_placeholder_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "business_name_placeholder",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["business_name_error_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "business_name_error",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["name_title_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "name_title_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["name_title_placeholder_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "name_title_placeholder",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["name_title_error_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "name_title_error",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["email_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "email_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["email_placeholder_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "email_placeholder",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["email_error_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "email_error",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["incorporation_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "incorporation_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["incorporation_placeholder_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "incorporation_placeholder",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["incorporation_error_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "incorporation_error",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["full_time_employees_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "full_time_employees_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["full_time_employees_placeholder_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "full_time_employees_placeholder",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["full_time_employees_error_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "full_time_employees_error",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["revenue_last_year_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "revenue_last_year_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["revenue_last_year_placeholder_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "revenue_last_year_placeholder",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["revenue_last_year_error_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "revenue_last_year_error",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["company_ownership_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "company_ownership_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["company_ownership_placeholder_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "company_ownership_placeholder",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["company_ownership_error_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "company_ownership_error",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["needs_intentions_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "needs_intentions_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["needs_intentions_placeholder_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "needs_intentions_placeholder",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["needs_intentions_error_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "needs_intentions_error",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["primary_industry_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "primary_industry_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["primary_industry_placeholder_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "primary_industry_placeholder",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["primary_industry_error_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "primary_industry_error",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["submit_button_text_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "submit_button_text",
          value: obj,
        });

        if (this.$route.params.id) {
          this.fetchPageSetting();
        }
      });
  },
};
</script>
