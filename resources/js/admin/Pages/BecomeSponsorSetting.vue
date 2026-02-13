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
                        >Become a sponsor form setting e.g. label & error
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
              :for="`name_label_${selectedLanguage}`"
              >Label for name field</label
            >
            <input
              type="text"
              :name="`name_label_${selectedLanguage}`"
              :id="`name_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'name_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['name_label'] &&
                form['name_label'][`name_label_${selectedLanguage}`]
                  ? form['name_label'][`name_label_${selectedLanguage}`]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(`name_label.name_label_${selectedLanguage}`)
              "
              v-text="
                validationErros.get(`name_label.name_label_${selectedLanguage}`)
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`name_error_${selectedLanguage}`"
              >Error message for name</label
            >
            <input
              type="text"
              :name="`name_error_${selectedLanguage}`"
              :id="`name_error_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'name_error',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['name_error'] &&
                form['name_error'][`name_error_${selectedLanguage}`]
                  ? form['name_error'][`name_error_${selectedLanguage}`]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(`name_error.name_error_${selectedLanguage}`)
              "
              v-text="
                validationErros.get(`name_error.name_error_${selectedLanguage}`)
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`name_placeholder_${selectedLanguage}`"
              >Placeholder for name</label
            >
            <input
              type="text"
              :name="`name_placeholder_${selectedLanguage}`"
              :id="`name_placeholder_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'name_placeholder',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['name_placeholder'] &&
                form['name_placeholder'][`name_placeholder_${selectedLanguage}`]
                  ? form['name_placeholder'][
                      `name_placeholder_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `name_placeholder.name_placeholder_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `name_placeholder.name_placeholder_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`company_name_label_${selectedLanguage}`"
              >Label for company name</label
            >
            <input
              type="text"
              :name="`company_name_label_${selectedLanguage}`"
              :id="`company_name_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'company_name_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['company_name_label'] &&
                form['company_name_label'][
                  `company_name_label_${selectedLanguage}`
                ]
                  ? form['company_name_label'][
                      `company_name_label_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `company_name_label.company_name_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `company_name_label.company_name_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`company_name_error_${selectedLanguage}`"
              >Error message for company name</label
            >
            <input
              type="text"
              :name="`company_name_error_${selectedLanguage}`"
              :id="`company_name_error_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'company_name_error',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['company_name_error'] &&
                form['company_name_error'][
                  `company_name_error_${selectedLanguage}`
                ]
                  ? form['company_name_error'][
                      `company_name_error_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `company_name_error.company_name_error_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `company_name_error.company_name_error_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`company_name_placeholder_${selectedLanguage}`"
              >Placeholder for company name</label
            >
            <input
              type="text"
              :name="`company_name_placeholder_${selectedLanguage}`"
              :id="`company_name_placeholder_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'company_name_placeholder',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['company_name_placeholder'] &&
                form['company_name_placeholder'][
                  `company_name_placeholder_${selectedLanguage}`
                ]
                  ? form['company_name_placeholder'][
                      `company_name_placeholder_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `company_name_placeholder.company_name_placeholder_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `company_name_placeholder.company_name_placeholder_${selectedLanguage}`
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
              :for="`email_error_${selectedLanguage}`"
              >Error message for email</label
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
              :for="`contact_number_label_${selectedLanguage}`"
              >Label for contact number</label
            >
            <input
              type="text"
              :name="`contact_number_label_${selectedLanguage}`"
              :id="`contact_number_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'contact_number_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['contact_number_label'] &&
                form['contact_number_label'][
                  `contact_number_label_${selectedLanguage}`
                ]
                  ? form['contact_number_label'][
                      `contact_number_label_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `contact_number_label.contact_number_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `contact_number_label.contact_number_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`contact_number_error_${selectedLanguage}`"
              >Error message for contact number</label
            >
            <input
              type="text"
              :name="`contact_number_error_${selectedLanguage}`"
              :id="`contact_number_error_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'contact_number_error',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['contact_number_error'] &&
                form['contact_number_error'][
                  `contact_number_error_${selectedLanguage}`
                ]
                  ? form['contact_number_error'][
                      `contact_number_error_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `contact_number_error.contact_number_error_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `contact_number_error.contact_number_error_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`contact_number_placeholder_${selectedLanguage}`"
              >Placeholder for contact number</label
            >
            <input
              type="text"
              :name="`contact_number_placeholder_${selectedLanguage}`"
              :id="`contact_number_placeholder_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'contact_number_placeholder',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['contact_number_placeholder'] &&
                form['contact_number_placeholder'][
                  `contact_number_placeholder_${selectedLanguage}`
                ]
                  ? form['contact_number_placeholder'][
                      `contact_number_placeholder_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `contact_number_placeholder.contact_number_placeholder_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `contact_number_placeholder.contact_number_placeholder_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`message_label_${selectedLanguage}`"
              >Label for message</label
            >
            <input
              type="text"
              :name="`message_label_${selectedLanguage}`"
              :id="`message_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'message_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['message_label'] &&
                form['message_label'][`message_label_${selectedLanguage}`]
                  ? form['message_label'][`message_label_${selectedLanguage}`]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `message_label.message_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `message_label.message_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`message_error_${selectedLanguage}`"
              >Error message for message</label
            >
            <input
              type="text"
              :name="`message_error_${selectedLanguage}`"
              :id="`message_error_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'message_error',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['message_error'] &&
                form['message_error'][`message_error_${selectedLanguage}`]
                  ? form['message_error'][`message_error_${selectedLanguage}`]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `message_error.message_error_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `message_error.message_error_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`message_placeholder_${selectedLanguage}`"
              >Placeholder for message</label
            >

            <textarea
              name="message_placeholder"
              :id="`message_placeholder_${selectedLanguage}`"
              rows="4"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'message_placeholder',
                  'updateHomePageSetting'
                )
              "
              v-text="
                form['message_placeholder'] &&
                form['message_placeholder'][
                  `message_placeholder_${selectedLanguage}`
                ]
                  ? form['message_placeholder'][
                      `message_placeholder_${selectedLanguage}`
                    ]
                  : ''
              "
            ></textarea>

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `message_placeholder.message_placeholder_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `message_placeholder.message_placeholder_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`image_label_${selectedLanguage}`"
              >Label for image</label
            >
            <input
              type="text"
              :name="`image_label_${selectedLanguage}`"
              :id="`image_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'image_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['image_label'] &&
                form['image_label'][`image_label_${selectedLanguage}`]
                  ? form['image_label'][`image_label_${selectedLanguage}`]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `image_label.image_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `image_label.image_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`image_placeholder_${selectedLanguage}`"
              >Placeholder text for Image</label
            >
            <input
              type="text"
              :name="`image_placeholder_${selectedLanguage}`"
              :id="`image_placeholder_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'image_placeholder',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['image_placeholder'] &&
                form['image_placeholder'][
                  `image_placeholder_${selectedLanguage}`
                ]
                  ? form['image_placeholder'][
                      `image_placeholder_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `image_placeholder.image_placeholder_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `image_placeholder.image_placeholder_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`image_error_${selectedLanguage}`"
              >Error message for image</label
            >
            <input
              type="text"
              :name="`image_error_${selectedLanguage}`"
              :id="`image_error_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'image_error',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['image_error'] &&
                form['image_error'][`image_error_${selectedLanguage}`]
                  ? form['image_error'][`image_error_${selectedLanguage}`]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `image_error.image_error_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `image_error.image_error_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`feature_image_label_${selectedLanguage}`"
              >Label for featured image</label
            >
            <input
              type="text"
              :name="`feature_image_label_${selectedLanguage}`"
              :id="`feature_image_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'feature_image_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['feature_image_label'] &&
                form['feature_image_label'][
                  `feature_image_label_${selectedLanguage}`
                ]
                  ? form['feature_image_label'][
                      `feature_image_label_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `feature_image_label.feature_image_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `feature_image_label.feature_image_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`feature_image_error_${selectedLanguage}`"
              >Error message for featured image</label
            >
            <input
              type="text"
              :name="`feature_image_error_${selectedLanguage}`"
              :id="`feature_image_error_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'feature_image_error',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['feature_image_error'] &&
                form['feature_image_error'][
                  `feature_image_error_${selectedLanguage}`
                ]
                  ? form['feature_image_error'][
                      `feature_image_error_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `feature_image_error.feature_image_error_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `feature_image_error.feature_image_error_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`feature_image_placeholder_${selectedLanguage}`"
              >Placeholder for featured image</label
            >
            <input
              type="text"
              :name="`feature_image_placeholder_${selectedLanguage}`"
              :id="`feature_image_placeholder_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'feature_image_placeholder',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['feature_image_placeholder'] &&
                form['feature_image_placeholder'][
                  `feature_image_placeholder_${selectedLanguage}`
                ]
                  ? form['feature_image_placeholder'][
                      `feature_image_placeholder_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `feature_image_placeholder.feature_image_placeholder_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `feature_image_placeholder.feature_image_placeholder_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`summary_label_${selectedLanguage}`"
              >Label for short summary</label
            >
            <input
              type="text"
              :name="`summary_label_${selectedLanguage}`"
              :id="`summary_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'summary_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['summary_label'] &&
                form['summary_label'][`summary_label_${selectedLanguage}`]
                  ? form['summary_label'][`summary_label_${selectedLanguage}`]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `summary_label.summary_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `summary_label.summary_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`summary_error_${selectedLanguage}`"
              >Error message for short summary</label
            >
            <input
              type="text"
              :name="`summary_error_${selectedLanguage}`"
              :id="`summary_error_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'summary_error',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['summary_error'] &&
                form['summary_error'][`summary_error_${selectedLanguage}`]
                  ? form['summary_error'][`summary_error_${selectedLanguage}`]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `summary_error.summary_error_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `summary_error.summary_error_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <!-- <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`summary_placeholder_${selectedLanguage}`"
              >Placeholder for short summary</label
            >
            <input
              type="text"
              :name="`summary_placeholder_${selectedLanguage}`"
              :id="`summary_placeholder_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'summary_placeholder',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['summary_placeholder'] &&
                form['summary_placeholder'][
                  `summary_placeholder_${selectedLanguage}`
                ]
                  ? form['summary_placeholder'][
                      `summary_placeholder_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `summary_placeholder.summary_placeholder_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `summary_placeholder.summary_placeholder_${selectedLanguage}`
                )
              "
            ></p>
          </div> -->

          <div class="relative z-0 w-full group">
  <label
    class="block text-sm font-medium leading-6 text-gray-900"
    :for="`summary_placeholder_${selectedLanguage}`"
    >Placeholder for short summary</label
  >
  <textarea
    :name="`summary_placeholder_${selectedLanguage}`"
    :id="`summary_placeholder_${selectedLanguage}`"
    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
    placeholder=" "
    rows="3"
    @input="
      handleInput(
        $event.target.value,
        language,
        'summary_placeholder',
        'updateHomePageSetting'
      )
    "
    :value="
      form['summary_placeholder'] &&
      form['summary_placeholder'][`summary_placeholder_${selectedLanguage}`]
        ? form['summary_placeholder'][`summary_placeholder_${selectedLanguage}`]
        : ''
    "
  ></textarea>

  <p
    class="mt-2 text-sm text-red-400"
    v-if="
      validationErros.has(
        `summary_placeholder.summary_placeholder_${selectedLanguage}`
      )
    "
    v-text="
      validationErros.get(
        `summary_placeholder.summary_placeholder_${selectedLanguage}`
      )
    "
  ></p>
</div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`detail_description_label_${selectedLanguage}`"
              >Label for detail description</label
            >
            <input
              type="text"
              :name="`detail_description_label_${selectedLanguage}`"
              :id="`detail_description_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'detail_description_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['detail_description_label'] &&
                form['detail_description_label'][
                  `detail_description_label_${selectedLanguage}`
                ]
                  ? form['detail_description_label'][
                      `detail_description_label_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `detail_description_label.detail_description_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `detail_description_label.detail_description_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`detail_description_error_${selectedLanguage}`"
              >Error message for detail description</label
            >
            <input
              type="text"
              :name="`detail_description_error_${selectedLanguage}`"
              :id="`detail_description_error_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'detail_description_error',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['detail_description_error'] &&
                form['detail_description_error'][
                  `detail_description_error_${selectedLanguage}`
                ]
                  ? form['detail_description_error'][
                      `detail_description_error_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `detail_description_error.detail_description_error_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `detail_description_error.detail_description_error_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <!-- <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`detail_description_placeholder_${selectedLanguage}`"
              >Placeholder for detail description</label
            >
            <input
              type="text"
              :name="`detail_description_placeholder_${selectedLanguage}`"
              :id="`detail_description_placeholder_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'detail_description_placeholder',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['detail_description_placeholder'] &&
                form['detail_description_placeholder'][
                  `detail_description_placeholder_${selectedLanguage}`
                ]
                  ? form['detail_description_placeholder'][
                      `detail_description_placeholder_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `detail_description_placeholder.detail_description_placeholder_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `detail_description_placeholder.detail_description_placeholder_${selectedLanguage}`
                )
              "
            ></p>
          </div> -->

          <div class="relative z-0 w-full group">
  <label
    class="block text-sm font-medium leading-6 text-gray-900"
    :for="`detail_description_placeholder_${selectedLanguage}`"
    >Placeholder for detail description</label
  >
  <textarea
    :name="`detail_description_placeholder_${selectedLanguage}`"
    :id="`detail_description_placeholder_${selectedLanguage}`"
    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
    placeholder=" "
    rows="5"
    @input="
      handleInput(
        $event.target.value,
        language,
        'detail_description_placeholder',
        'updateHomePageSetting'
      )
    "
    :value="
      form['detail_description_placeholder'] &&
      form['detail_description_placeholder'][`detail_description_placeholder_${selectedLanguage}`]
        ? form['detail_description_placeholder'][`detail_description_placeholder_${selectedLanguage}`]
        : ''
    "
  ></textarea>

  <p
    class="mt-2 text-sm text-red-400"
    v-if="
      validationErros.has(
        `detail_description_placeholder.detail_description_placeholder_${selectedLanguage}`
      )
    "
    v-text="
      validationErros.get(
        `detail_description_placeholder.detail_description_placeholder_${selectedLanguage}`
      )
    "
  ></p>
</div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`url_label_${selectedLanguage}`"
              >Label for URL</label
            >
            <input
              type="text"
              :name="`url_label_${selectedLanguage}`"
              :id="`url_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'url_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['url_label'] &&
                form['url_label'][`url_label_${selectedLanguage}`]
                  ? form['url_label'][`url_label_${selectedLanguage}`]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(`url_label.url_label_${selectedLanguage}`)
              "
              v-text="
                validationErros.get(`url_label.url_label_${selectedLanguage}`)
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`url_error_${selectedLanguage}`"
              >Error message for url</label
            >
            <input
              type="text"
              :name="`url_error_${selectedLanguage}`"
              :id="`url_error_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'url_error',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['url_error'] &&
                form['url_error'][`url_error_${selectedLanguage}`]
                  ? form['url_error'][`url_error_${selectedLanguage}`]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(`url_error.url_error_${selectedLanguage}`)
              "
              v-text="
                validationErros.get(`url_error.url_error_${selectedLanguage}`)
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`url_placeholder_${selectedLanguage}`"
              >Placeholder for url</label
            >
            <input
              type="text"
              :name="`url_placeholder_${selectedLanguage}`"
              :id="`url_placeholder_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'url_placeholder',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['url_placeholder'] &&
                form['url_placeholder'][`url_placeholder_${selectedLanguage}`]
                  ? form['url_placeholder'][
                      `url_placeholder_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `url_placeholder.url_placeholder_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `url_placeholder.url_placeholder_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`time_to_call_label_${selectedLanguage}`"
              >Time to call label</label
            >
            <input
              type="text"
              :name="`time_to_call_label_${selectedLanguage}`"
              :id="`time_to_call_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'time_to_call_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['time_to_call_label'] &&
                form['time_to_call_label'][
                  `time_to_call_label_${selectedLanguage}`
                ]
                  ? form['time_to_call_label'][
                      `time_to_call_label_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `time_to_call_label.time_to_call_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `time_to_call_label.time_to_call_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`time_to_call_error_${selectedLanguage}`"
              >Time to call error</label
            >
            <input
              type="text"
              :name="`time_to_call_error_${selectedLanguage}`"
              :id="`time_to_call_error_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'time_to_call_error',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['time_to_call_error'] &&
                form['time_to_call_error'][
                  `time_to_call_error_${selectedLanguage}`
                ]
                  ? form['time_to_call_error'][
                      `time_to_call_error_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `time_to_call_error.time_to_call_error_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `time_to_call_error.time_to_call_error_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`time_to_call_am_label_${selectedLanguage}`"
              >Time to call AM option</label
            >
            <input
              type="text"
              :name="`time_to_call_am_label_${selectedLanguage}`"
              :id="`time_to_call_am_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'time_to_call_am_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['time_to_call_am_label'] &&
                form['time_to_call_am_label'][
                  `time_to_call_am_label_${selectedLanguage}`
                ]
                  ? form['time_to_call_am_label'][
                      `time_to_call_am_label_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `time_to_call_am_label.time_to_call_am_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `time_to_call_am_label.time_to_call_am_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`time_to_call_pm_label_${selectedLanguage}`"
              >Time to call PM option</label
            >
            <input
              type="text"
              :name="`time_to_call_pm_label_${selectedLanguage}`"
              :id="`time_to_call_pm_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'time_to_call_pm_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['time_to_call_pm_label'] &&
                form['time_to_call_pm_label'][
                  `time_to_call_pm_label_${selectedLanguage}`
                ]
                  ? form['time_to_call_pm_label'][
                      `time_to_call_pm_label_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `time_to_call_pm_label.time_to_call_pm_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `time_to_call_pm_label.time_to_call_pm_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`appointment_label_${selectedLanguage}`"
              >Appointment label</label
            >
            <input
              type="text"
              :name="`appointment_label_${selectedLanguage}`"
              :id="`appointment_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'appointment_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['appointment_label'] &&
                form['appointment_label'][
                  `appointment_label_${selectedLanguage}`
                ]
                  ? form['appointment_label'][
                      `appointment_label_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `appointment_label.appointment_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `appointment_label.appointment_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`appointment_error_${selectedLanguage}`"
              >Appointment error</label
            >
            <input
              type="text"
              :name="`appointment_error_${selectedLanguage}`"
              :id="`appointment_error_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'appointment_error',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['appointment_error'] &&
                form['appointment_error'][
                  `appointment_error_${selectedLanguage}`
                ]
                  ? form['appointment_error'][
                      `appointment_error_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `appointment_error.appointment_error_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `appointment_error.appointment_error_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`appointment_yes_option_${selectedLanguage}`"
              >Appointment yes option</label
            >
            <input
              type="text"
              :name="`appointment_yes_option_${selectedLanguage}`"
              :id="`appointment_yes_option_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'appointment_yes_option',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['appointment_yes_option'] &&
                form['appointment_yes_option'][
                  `appointment_yes_option_${selectedLanguage}`
                ]
                  ? form['appointment_yes_option'][
                      `appointment_yes_option_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `appointment_yes_option.appointment_yes_option_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `appointment_yes_option.appointment_yes_option_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`appointment_no_option_${selectedLanguage}`"
              >Appointment no option</label
            >
            <input
              type="text"
              :name="`appointment_no_option_${selectedLanguage}`"
              :id="`appointment_no_option_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'appointment_no_option',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['appointment_no_option'] &&
                form['appointment_no_option'][
                  `appointment_no_option_${selectedLanguage}`
                ]
                  ? form['appointment_no_option'][
                      `appointment_no_option_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `appointment_no_option.appointment_no_option_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `appointment_no_option.appointment_no_option_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`appointment_date_label_${selectedLanguage}`"
              >Appointment date label</label
            >
            <input
              type="text"
              :name="`appointment_date_label_${selectedLanguage}`"
              :id="`appointment_date_label_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'appointment_date_label',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['appointment_date_label'] &&
                form['appointment_date_label'][
                  `appointment_date_label_${selectedLanguage}`
                ]
                  ? form['appointment_date_label'][
                      `appointment_date_label_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `appointment_date_label.appointment_date_label_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `appointment_date_label.appointment_date_label_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`appointment_date_error_${selectedLanguage}`"
              >Appointment date error</label
            >
            <input
              type="text"
              :name="`appointment_date_error_${selectedLanguage}`"
              :id="`appointment_date_error_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'appointment_date_error',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['appointment_date_error'] &&
                form['appointment_date_error'][
                  `appointment_date_error_${selectedLanguage}`
                ]
                  ? form['appointment_date_error'][
                      `appointment_date_error_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `appointment_date_error.appointment_date_error_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `appointment_date_error.appointment_date_error_${selectedLanguage}`
                )
              "
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`submit_btn_text_${selectedLanguage}`"
              >Submit button text</label
            >
            <input
              type="text"
              :name="`submit_btn_text_${selectedLanguage}`"
              :id="`submit_btn_text_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  'submit_btn_text',
                  'updateHomePageSetting'
                )
              "
              :value="
                form['submit_btn_text'] &&
                form['submit_btn_text'][`submit_btn_text_${selectedLanguage}`]
                  ? form['submit_btn_text'][
                      `submit_btn_text_${selectedLanguage}`
                    ]
                  : ''
              "
            />

            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `submit_btn_text.submit_btn_text_${selectedLanguage}`
                )
              "
              v-text="
                validationErros.get(
                  `submit_btn_text.submit_btn_text_${selectedLanguage}`
                )
              "
            ></p>
          </div>
        </div>
      </div>
    </div>

    <!-- Sponsorship, account, payment & list labels -->
    <div
      class="border rounded w-full mt-4"
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
                            d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"
                          />
                        </svg>
                      </span>
                    </span>
                    <span class="ml-4 mt-0.5 flex min-w-0 flex-col">
                      <span class="text-sm font-medium">Sponsorship, account, payment & list labels</span>
                      <span class="text-sm font-medium text-gray-500"
                        >Section headings, buttons, status & payment labels</span
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
      <div class="p-4 bg-gray-50 border-t" v-show="collapseStates[1]">
        <div
          class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
        >
          <div
            v-for="item in sponsorshipListFields"
            :key="item.key"
            class="relative z-0 w-full group"
          >
            <label
              class="block text-sm font-medium leading-6 text-gray-900"
              :for="`${item.key}_${selectedLanguage}`"
              v-text="item.label"
            ></label>
            <input
              type="text"
              :name="`${item.key}_${selectedLanguage}`"
              :id="`${item.key}_${selectedLanguage}`"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
              placeholder=" "
              @input="
                handleInput(
                  $event.target.value,
                  language,
                  item.key,
                  'updateHomePageSetting'
                )
              "
              :value="
                form[item.key] && form[item.key][`${item.key}_${selectedLanguage}`]
                  ? form[item.key][`${item.key}_${selectedLanguage}`]
                  : ''
              "
            />
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
      sponsorshipListFields: [
        { key: 'sponsorship_section_heading', label: 'Sponsorship section heading' },
        { key: 'enter_amount_placeholder', label: 'Enter amount placeholder' },
        { key: 'talk_to_us_first_label', label: 'Talk to us first label' },
        { key: 'talk_to_us_first_description', label: 'Talk to us first description' },
        { key: 'no_amounts_message', label: 'No amounts message' },
        { key: 'contact_preferences_heading', label: 'Contact preferences heading' },
        { key: 'best_time_to_call_label', label: 'Best time to call label' },
        { key: 'preferred_date_label', label: 'Preferred date label' },
        { key: 'call_time_morning', label: 'Call time morning' },
        { key: 'call_time_afternoon', label: 'Call time afternoon' },
        { key: 'call_time_evening', label: 'Call time evening' },
        { key: 'account_details_heading', label: 'Account details heading' },
        { key: 'contact_name_placeholder', label: 'Contact name placeholder' },
        { key: 'email_hint', label: 'Email hint' },
        { key: 'password_label', label: 'Password label' },
        { key: 'password_hint', label: 'Password hint' },
        { key: 'confirm_password_label', label: 'Confirm password label' },
        { key: 'optional_text', label: 'Optional text' },
        { key: 'brand_story_heading', label: 'Brand story heading' },
        { key: 'featured_image_hint', label: 'Featured image hint' },
        { key: 'logo_hint', label: 'Logo hint' },
        { key: 'summary_placeholder_long', label: 'Summary placeholder (long)' },
        { key: 'detail_description_placeholder_long', label: 'Detail description placeholder (long)' },
        { key: 'message_placeholder_long', label: 'Message placeholder (long)' },
        { key: 'featured_image_idle', label: 'Featured image idle' },
        { key: 'logo_idle', label: 'Logo idle' },
        { key: 'payment_method_heading', label: 'Payment method heading' },
        { key: 'debit_credit_label', label: 'Debit/credit label' },
        { key: 'cardholder_name_label', label: 'Cardholder name label' },
        { key: 'terms_privacy_label', label: 'Terms & privacy label' },
        { key: 'terms_privacy_label_1', label: 'Terms & privacy label 1' },
        { key: 'terms_privacy_label_2', label: 'Terms & privacy label 2' },
        { key: 'terms_privacy_label_3', label: 'Terms & privacy label 3' },
        { key: 'terms_privacy_label_4', label: 'Terms & privacy label 4' },
        { key: 'terms_privacy_label_5', label: 'Terms & privacy label 5' },
        { key: 'donation_non_refundable_label', label: 'Donation non-refundable label' },
        { key: 'processing_text', label: 'Processing text' },
        { key: 'reactivate_btn_text', label: 'Reactivate button text' },
        { key: 'become_sponsor_btn_text', label: 'Become sponsor button text' },
        { key: 'manage_sponsorship_heading', label: 'Manage sponsorship heading' },
        { key: 'manage_sponsorship_subtitle', label: 'Manage sponsorship subtitle' },
        { key: 'manage_sponsorship_thanks', label: 'Manage sponsorship thanks' },
        { key: 'add_another_sponsorship_btn', label: 'Add another sponsorship button' },
        { key: 'loading_sponsorships', label: 'Loading sponsorships' },
        { key: 'no_sponsorships_heading', label: 'No sponsorships heading' },
        { key: 'no_sponsorships_message', label: 'No sponsorships message' },
        { key: 'create_first_sponsorship_btn', label: 'Create first sponsorship button' },
        { key: 'status_active', label: 'Status active' },
        { key: 'status_pending', label: 'Status pending' },
        { key: 'status_inactive', label: 'Status inactive' },
        { key: 'change_frequency_btn', label: 'Change frequency button' },
        { key: 'collapse_btn', label: 'Collapse button' },
        { key: 'payment_status_paid', label: 'Payment status paid' },
        { key: 'payment_status_pending', label: 'Payment status pending' },
        { key: 'payment_status_not_required', label: 'Payment status not required' },
        { key: 'payment_status_failed', label: 'Payment status failed' },
        { key: 'payment_status_refunded', label: 'Payment status refunded' },
        { key: 'label_amount', label: 'Label amount' },
        { key: 'label_beneficiary', label: 'Label beneficiary' },
        { key: 'label_created', label: 'Label created' },
        { key: 'label_payment_method', label: 'Label payment method' },
        { key: 'edit_btn', label: 'Edit button' },
        { key: 'reactivation_panel_message', label: 'Reactivation panel message' },
        { key: 'next_billing_date_label', label: 'Next billing date label' },
        { key: 'upgrade_btn', label: 'Upgrade button' },
        { key: 'reactivate_heading', label: 'Reactivate heading' },
        { key: 'loading_overlay_text', label: 'Loading overlay text' },
        { key: 'payment_method_ending_in', label: 'Payment method ending in' },
      ],
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
          url: `${process.env.MIX_ADMIN_API_URL}become-sponsor-setting?withBecomeSponsorSettingDetail=1&findByPageId=${this.form.id}`,
        })
        .then((res) => {
          let data =
            res.data.data && res.data.data.become_sponsor_setting_detail
              ? res.data.data.become_sponsor_setting_detail
              : [];

          let obj = {};
          data.map((res) => {
            obj["name_label_" + res.language_id] = res.name_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "name_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["name_error_" + res.language_id] = res.name_error;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "name_error",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["name_placeholder_" + res.language_id] = res.name_placeholder;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "name_placeholder",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["company_name_label_" + res.language_id] =
              res.company_name_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "company_name_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["company_name_error_" + res.language_id] =
              res.company_name_error;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "company_name_error",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["company_name_placeholder_" + res.language_id] =
              res.company_name_placeholder;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "company_name_placeholder",
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
            obj["email_error_" + res.language_id] = res.email_error;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "email_error",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["email_placeholder_" + res.language_id] = res.email_placeholder;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "email_placeholder",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["contact_number_label_" + res.language_id] =
              res.contact_number_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "contact_number_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["contact_number_error_" + res.language_id] =
              res.contact_number_error;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "contact_number_error",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["contact_number_placeholder_" + res.language_id] =
              res.contact_number_placeholder;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "contact_number_placeholder",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["message_label_" + res.language_id] = res.message_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "message_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["message_error_" + res.language_id] = res.message_error;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "message_error",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["message_placeholder_" + res.language_id] =
              res.message_placeholder;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "message_placeholder",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["image_label_" + res.language_id] = res.image_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "image_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["image_placeholder_" + res.language_id] = res.image_placeholder;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "image_placeholder",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["image_error_" + res.language_id] = res.image_error;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "image_error",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["feature_image_label_" + res.language_id] =
              res.feature_image_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "feature_image_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["feature_image_error_" + res.language_id] =
              res.feature_image_error;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "feature_image_error",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["feature_image_placeholder_" + res.language_id] =
              res.feature_image_placeholder;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "feature_image_placeholder",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["summary_label_" + res.language_id] = res.summary_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "summary_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["summary_error_" + res.language_id] = res.summary_error;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "summary_error",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["summary_placeholder_" + res.language_id] =
              res.summary_placeholder;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "summary_placeholder",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["detail_description_label_" + res.language_id] =
              res.detail_description_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "detail_description_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["detail_description_error_" + res.language_id] =
              res.detail_description_error;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "detail_description_error",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["detail_description_placeholder_" + res.language_id] =
              res.detail_description_placeholder;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "detail_description_placeholder",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["url_label_" + res.language_id] = res.url_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "url_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["url_error_" + res.language_id] = res.url_error;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "url_error",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["url_placeholder_" + res.language_id] = res.url_placeholder;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "url_placeholder",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["time_to_call_label_" + res.language_id] =
              res.time_to_call_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "time_to_call_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["time_to_call_error_" + res.language_id] =
              res.time_to_call_error;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "time_to_call_error",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["time_to_call_am_label_" + res.language_id] =
              res.time_to_call_am_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "time_to_call_am_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["time_to_call_pm_label_" + res.language_id] =
              res.time_to_call_pm_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "time_to_call_pm_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["appointment_label_" + res.language_id] = res.appointment_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "appointment_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["appointment_error_" + res.language_id] = res.appointment_error;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "appointment_error",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["appointment_yes_option_" + res.language_id] =
              res.appointment_yes_option;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "appointment_yes_option",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["appointment_no_option_" + res.language_id] =
              res.appointment_no_option;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "appointment_no_option",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["appointment_date_label_" + res.language_id] =
              res.appointment_date_label;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "appointment_date_label",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["appointment_date_error_" + res.language_id] =
              res.appointment_date_error;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "appointment_date_error",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["submit_btn_text_" + res.language_id] = res.submit_btn_text;
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: "submit_btn_text",
            value: obj,
          });

          this.sponsorshipListFields.forEach((item) => {
            obj = {};
            data.map((res) => {
              obj[item.key + "_" + res.language_id] = res[item.key] ?? "";
            });
            this.$store.commit("pages/setHomePageSetting", {
              key: item.key,
              value: obj,
            });
          });
        });
    },
    checkValidationError(validationErros, language) {
      return (
        validationErros.has(`name_label.name_label_${language.id}`) ||
        validationErros.has(`name_error.name_error_${language.id}`) ||
        validationErros.has(
          `name_placeholder.name_placeholder_${language.id}`
        ) ||
        validationErros.has(
          `company_name_label.company_name_label_${language.id}`
        ) ||
        validationErros.has(
          `company_name_error.company_name_error_${language.id}`
        ) ||
        validationErros.has(
          `company_name_placeholder.company_name_placeholder_${language.id}`
        ) ||
        validationErros.has(`email_label.email_label_${language.id}`) ||
        validationErros.has(`email_error.email_error_${language.id}`) ||
        validationErros.has(
          `email_placeholder.email_placeholder_${language.id}`
        ) ||
        validationErros.has(
          `contact_number_label.contact_number_label_${language.id}`
        ) ||
        validationErros.has(
          `contact_number_error.contact_number_error_${language.id}`
        ) ||
        validationErros.has(
          `contact_number_placeholder.contact_number_placeholder_${language.id}`
        ) ||
        validationErros.has(`message_label.message_label_${language.id}`) ||
        validationErros.has(`message_error.message_error_${language.id}`) ||
        validationErros.has(
          `message_placeholder.message_placeholder_${language.id}`
        ) ||
        validationErros.has(`image_label.image_label_${language.id}`) ||
        validationErros.has(
          `image_placeholder.image_placeholder_${language.id}`
        ) ||
        validationErros.has(`image_error.image_error_${language.id}`) ||
        validationErros.has(
          `feature_image_label.feature_image_label_${language.id}`
        ) ||
        validationErros.has(
          `feature_image_error.feature_image_error_${language.id}`
        ) ||
        validationErros.has(
          `feature_image_placeholder.feature_image_placeholder_${language.id}`
        ) ||
        validationErros.has(`summary_label.summary_label_${language.id}`) ||
        validationErros.has(`summary_error.summary_error_${language.id}`) ||
        validationErros.has(
          `summary_placeholder.summary_placeholder_${language.id}`
        ) ||
        validationErros.has(
          `detail_description_label.detail_description_label_${language.id}`
        ) ||
        validationErros.has(
          `detail_description_error.detail_description_error_${language.id}`
        ) ||
        validationErros.has(
          `detail_description_placeholder.detail_description_placeholder_${language.id}`
        ) ||
        validationErros.has(`url_label.url_label_${language.id}`) ||
        validationErros.has(`url_error.url_error_${language.id}`) ||
        validationErros.has(`url_placeholder.url_placeholder_${language.id}`) ||
        validationErros.has(
          `time_to_call_label.time_to_call_label_${language.id}`
        ) ||
        validationErros.has(
          `time_to_call_error.time_to_call_error_${language.id}`
        ) ||
        validationErros.has(
          `time_to_call_am_label.time_to_call_am_label_${language.id}`
        ) ||
        validationErros.has(
          `time_to_call_pm_label.time_to_call_pm_label_${language.id}`
        ) ||
        validationErros.has(
          `appointment_label.appointment_label_${language.id}`
        ) ||
        validationErros.has(
          `appointment_error.appointment_error_${language.id}`
        ) ||
        validationErros.has(
          `appointment_yes_option.appointment_yes_option_${language.id}`
        ) ||
        validationErros.has(
          `appointment_no_option.appointment_no_option_${language.id}`
        ) ||
        validationErros.has(
          `appointment_date_label.appointment_date_label_${language.id}`
        ) ||
        validationErros.has(
          `appointment_date_error.appointment_date_error_${language.id}`
        ) ||
        validationErros.has(`submit_btn_text.submit_btn_text_${language.id}`)
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
          obj["name_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "name_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["name_error_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "name_error",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["name_placeholder_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "name_placeholder",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["company_name_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "company_name_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["company_name_error_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "company_name_error",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["company_name_placeholder_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "company_name_placeholder",
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
          obj["email_error_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "email_error",
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
          obj["contact_number_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "contact_number_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["contact_number_error_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "contact_number_error",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["contact_number_placeholder_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "contact_number_placeholder",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["message_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "message_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["message_error_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "message_error",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["message_placeholder_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "message_placeholder",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["image_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "image_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["image_placeholder_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "image_placeholder",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["image_error_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "image_error",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["feature_image_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "feature_image_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["feature_image_error_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "feature_image_error",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["feature_image_placeholder_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "feature_image_placeholder",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["summary_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "summary_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["summary_error_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "summary_error",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["summary_placeholder_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "summary_placeholder",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["detail_description_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "detail_description_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["detail_description_error_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "detail_description_error",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["detail_description_placeholder_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "detail_description_placeholder",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["url_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "url_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["url_error_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "url_error",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["url_placeholder_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "url_placeholder",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["time_to_call_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "time_to_call_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["time_to_call_error_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "time_to_call_error",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["time_to_call_am_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "time_to_call_am_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["time_to_call_pm_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "time_to_call_pm_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["appointment_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "appointment_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["appointment_error_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "appointment_error",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["appointment_yes_option_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "appointment_yes_option",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["appointment_no_option_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "appointment_no_option",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["appointment_date_label_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "appointment_date_label",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["appointment_date_error_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "appointment_date_error",
          value: obj,
        });

        obj = {};
        data.map((res) => {
          obj["submit_btn_text_" + res.id] = "";
        });
        this.$store.commit("pages/setHomePageSetting", {
          key: "submit_btn_text",
          value: obj,
        });

        this.sponsorshipListFields.forEach((item) => {
          obj = {};
          data.map((res) => {
            obj[item.key + "_" + res.id] = "";
          });
          this.$store.commit("pages/setHomePageSetting", {
            key: item.key,
            value: obj,
          });
        });

        if (this.$route.params.id) {
          this.fetchPageSetting();
        }
      });
  },
};
</script>
