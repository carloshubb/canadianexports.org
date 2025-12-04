<template>
    <div class="my-5" v-for="language in languages"
        :key="language.id"
        :class="(selectedLanguage == null && language.is_default) || language.id == selectedLanguage ? 'block' : 'hidden'">
        <div class="border rounded w-full" :class="collapseStates[0] ? 'bg-blue-50' : ''">
            <div class="lg:border-b lg:border-t lg:border-gray-200 cursor-pointer" @click.prevent="collapseStates[0] = !collapseStates[0]">
                <nav class="mx-auto" aria-label="Section">
                    <ol role="list" class="overflow-hidden rounded-md lg:flex lg:rounded-none lg:border-l lg:border-r lg:border-gray-200">
                    <li class="relative overflow-hidden lg:flex-1">
                        <div class="overflow-hidden border border-gray-200 rounded-t-md border-b-0 lg:border-0 flex justify-between items-center">
                        <div class="group w-full">
                            <span class="absolute left-0 top-0 h-full w-1 bg-transparent group-hover:bg-primary lg:bottom-0 lg:top-auto lg:h-1 lg:w-full" aria-hidden="true"></span>
                            <span class="flex items-start px-6 py-2 text-sm font-medium">
                            <span class="flex-shrink-0">
                                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-white">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                                    </svg>
                                </span>
                            </span>
                            <span class="ml-4 mt-0.5 flex min-w-0 flex-col">
                                <span class="text-sm font-medium">Form settings</span>
                                <span class="text-sm font-medium text-gray-500">Event create page & form settings</span>
                            </span>
                            </span>
                        </div>
                        <svg class="w-5 h-5 fill-current text-gray-500" viewBox="0 0 20 20">
                            <path d="M6 9l4 4 4-4"></path>
                        </svg>
                        </div>
                    </li>
                    </ol>
                </nav>
            </div>
            <div class="p-4 bg-gray-50 border-t" v-show="collapseStates[0]">
                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`create_event_tab_heading_${selectedLanguage}`"
                            >Label for create event heading</label
                        >
                        <input
                            type="text"
                            :name="`create_event_tab_heading_${selectedLanguage}`"
                            :id="`create_event_tab_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'create_event_tab_heading',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['create_event_tab_heading'] &&
                                form['create_event_tab_heading'][
                                    `create_event_tab_heading_${selectedLanguage}`
                                ]
                                    ? form['create_event_tab_heading'][
                                          `create_event_tab_heading_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `create_event_tab_heading.create_event_tab_heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `create_event_tab_heading.create_event_tab_heading_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`title_label_${selectedLanguage}`">Label for title</label>
                        <input
                            type="text"
                            :name="`title_label_${selectedLanguage}`"
                            :id="`title_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="handleInput($event.target.value,language,'title_label','updateHomePageSetting')"
                            :value="form['title_label'] && form['title_label'][ `title_label_${selectedLanguage}`] ? form['title_label'][ `title_label_${selectedLanguage}` ] : '' "/>
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`title_label.title_label_${selectedLanguage}`)"
                            v-text="validationErros.get(`title_label.title_label_${selectedLanguage}`)"></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`title_error_${selectedLanguage}`">Error message for title</label>
                        <input
                            type="text"
                            :name="`title_error_${selectedLanguage}`"
                            :id="`title_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="handleInput($event.target.value,language,'title_error','updateHomePageSetting')"
                            :value="form['title_error'] && form['title_error'][ `title_error_${selectedLanguage}`] ? form['title_error'][ `title_error_${selectedLanguage}` ] : '' "/>
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`title_error.title_error_${selectedLanguage}`)"
                            v-text="validationErros.get(`title_error.title_error_${selectedLanguage}`)"></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`country_label_${selectedLanguage}`">Label for country</label>
                        <input
                            type="text"
                            :name="`country_label_${selectedLanguage}`"
                            :id="`country_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput( $event.target.value, language, 'country_label', 'updateHomePageSetting')"
                            :value="form['country_label'] && form['country_label'][`country_label_${selectedLanguage}` ] ? form['country_label'][ `country_label_${selectedLanguage}`] : '' "/>
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has (`country_label.country_label_${selectedLanguage}`)"
                            v-text="validationErros.get(`country_label.country_label_${selectedLanguage}`)"></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`country_error_${selectedLanguage}`">Error message for country</label>
                        <input
                            type="text"
                            :name="`country_error_${selectedLanguage}`"
                            :id="`country_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="handleInput($event.target.value,language,'country_error','updateHomePageSetting')"
                            :value="form['country_error'] && form['country_error'][ `country_error_${selectedLanguage}` ] ? form['country_error'][ `country_error_${selectedLanguage}` ] : '' "/>

                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`country_error.country_error_${selectedLanguage}`) " v-text="validationErros.get(`country_error.country_error_${selectedLanguage}`) "></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`city_label_${selectedLanguage}`">Label for city</label>
                        <input
                            type="text"
                            :name="`city_label_${selectedLanguage}`"
                            :id="`city_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="handleInput($event.target.value,language,'city_label','updateHomePageSetting')"
                            :value="form['city_label'] &&form['city_label'][`city_label_${selectedLanguage}`]? form['city_label'][`city_label_${selectedLanguage}`] : ''"/>
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`city_label.city_label_${selectedLanguage}`) " v-text=" validationErros.get( `city_label.city_label_${selectedLanguage}` )"></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`city_error_${selectedLanguage}`">Error message for city</label
                        >
                        <input
                            type="text"
                            :name="`city_error_${selectedLanguage}`"
                            :id="`city_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'city_error',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['city_error'] &&
                                form['city_error'][
                                    `city_error_${selectedLanguage}`
                                ]
                                    ? form['city_error'][
                                          `city_error_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `city_error.city_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `city_error.city_error_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`street_name_label_${selectedLanguage}`"
                            >Label for street</label
                        >
                        <input
                            type="text"
                            :name="`street_name_label_${selectedLanguage}`"
                            :id="`street_name_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'street_name_label',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['street_name_label'] &&
                                form['street_name_label'][
                                    `street_name_label_${selectedLanguage}`
                                ]
                                    ? form['street_name_label'][
                                          `street_name_label_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `street_name_label.street_name_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `street_name_label.street_name_label_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`street_name_error_${selectedLanguage}`"
                            >Error message for street</label
                        >
                        <input
                            type="text"
                            :name="`street_name_error_${selectedLanguage}`"
                            :id="`street_name_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'street_name_error',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['street_name_error'] &&
                                form['street_name_error'][
                                    `street_name_error_${selectedLanguage}`
                                ]
                                    ? form['street_name_error'][
                                          `street_name_error_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `street_name_error.street_name_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `street_name_error.street_name_error_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`venue_label_${selectedLanguage}`"
                            >Label for Venue</label
                        >
                        <input
                            type="text"
                            :name="`venue_label_${selectedLanguage}`"
                            :id="`venue_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'venue_label',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['venue_label'] &&
                                form['venue_label'][
                                    `venue_label_${selectedLanguage}`
                                ]
                                    ? form['venue_label'][
                                          `venue_label_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `venue_label.venue_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `venue_label.venue_label_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`venue_error_${selectedLanguage}`"
                            >Error message for venue</label
                        >
                        <input
                            type="text"
                            :name="`venue_error_${selectedLanguage}`"
                            :id="`venue_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'venue_error',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['venue_error'] &&
                                form['venue_error'][
                                    `venue_error_${selectedLanguage}`
                                ]
                                    ? form['venue_error'][
                                          `venue_error_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `venue_error.venue_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `venue_error.venue_error_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`product_search_label_${selectedLanguage}`"
                            >Label for product search</label
                        >
                        <input
                            type="text"
                            :name="`product_search_label_${selectedLanguage}`"
                            :id="`product_search_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'product_search_label',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['product_search_label'] &&
                                form['product_search_label'][
                                    `product_search_label_${selectedLanguage}`
                                ]
                                    ? form['product_search_label'][
                                          `product_search_label_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `product_search_label.product_search_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `product_search_label.product_search_label_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`product_search_placeholder_${selectedLanguage}`"
                            >Placeholder for product search</label
                        >
                        <input
                            type="text"
                            :name="`product_search_placeholder_${selectedLanguage}`"
                            :id="`product_search_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'product_search_placeholder',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['product_search_placeholder'] &&
                                form['product_search_placeholder'][
                                    `product_search_placeholder_${selectedLanguage}`
                                ]
                                    ? form['product_search_placeholder'][
                                          `product_search_placeholder_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `product_search_placeholder.product_search_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `product_search_placeholder.product_search_placeholder_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`product_search_error_${selectedLanguage}`"
                            >Error message for product search</label
                        >
                        <input
                            type="text"
                            :name="`product_search_error_${selectedLanguage}`"
                            :id="`product_search_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'product_search_error',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['product_search_error'] &&
                                form['product_search_error'][
                                    `product_search_error_${selectedLanguage}`
                                ]
                                    ? form['product_search_error'][
                                          `product_search_error_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `product_search_error.product_search_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `product_search_error.product_search_error_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`short_description_label_${selectedLanguage}`"
                            >Label for short description</label
                        >
                        <input
                            type="text"
                            :name="`short_description_label_${selectedLanguage}`"
                            :id="`short_description_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'short_description_label',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['short_description_label'] &&
                                form['short_description_label'][
                                    `short_description_label_${selectedLanguage}`
                                ]
                                    ? form['short_description_label'][
                                          `short_description_label_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `short_description_label.short_description_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `short_description_label.short_description_label_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`short_description_placeholder_${selectedLanguage}`"
                            >Placeholder for short description</label
                        >
                        <input
                            type="text"
                            :name="`short_description_placeholder_${selectedLanguage}`"
                            :id="`short_description_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'short_description_placeholder',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['short_description_placeholder'] &&
                                form['short_description_placeholder'][
                                    `short_description_placeholder_${selectedLanguage}`
                                ]
                                    ? form['short_description_placeholder'][
                                          `short_description_placeholder_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `short_description_placeholder.short_description_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `short_description_placeholder.short_description_placeholder_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900"
                            :for="`short_description_error_${selectedLanguage}`"
                            >Error message for short description</label
                        >
                        <input
                            type="text"
                            :name="`short_description_error_${selectedLanguage}`"
                            :id="`short_description_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'short_description_error',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['short_description_error'] &&
                                form['short_description_error'][
                                    `short_description_error_${selectedLanguage}`
                                ]
                                    ? form['short_description_error'][
                                          `short_description_error_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `short_description_error.short_description_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `short_description_error.short_description_error_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`description_label_${selectedLanguage}`"
                            >Label for description</label
                        >
                        <input
                            type="text"
                            :name="`description_label_${selectedLanguage}`"
                            :id="`description_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'description_label',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['description_label'] &&
                                form['description_label'][
                                    `description_label_${selectedLanguage}`
                                ]
                                    ? form['description_label'][
                                          `description_label_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `description_label.description_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `description_label.description_label_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`description_placeholder_${selectedLanguage}`"
                            >Placeholder for description</label
                        >
                        <input
                            type="text"
                            :name="`description_placeholder_${selectedLanguage}`"
                            :id="`description_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'description_placeholder',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['description_placeholder'] &&
                                form['description_placeholder'][
                                    `description_placeholder_${selectedLanguage}`
                                ]
                                    ? form['description_placeholder'][
                                          `description_placeholder_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `description_placeholder.description_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `description_placeholder.description_placeholder_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`description_error_${selectedLanguage}`"
                            >Error message for description</label
                        >
                        <input
                            type="text"
                            :name="`description_error_${selectedLanguage}`"
                            :id="`description_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'description_error',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['description_error'] &&
                                form['description_error'][
                                    `description_error_${selectedLanguage}`
                                ]
                                    ? form['description_error'][
                                          `description_error_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `description_error.description_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `description_error.description_error_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`start_date_label_${selectedLanguage}`"
                            >Label for start date</label
                        >
                        <input
                            type="text"
                            :name="`start_date_label_${selectedLanguage}`"
                            :id="`start_date_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'start_date_label',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['start_date_label'] &&
                                form['start_date_label'][
                                    `start_date_label_${selectedLanguage}`
                                ]
                                    ? form['start_date_label'][
                                          `start_date_label_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `start_date_label.start_date_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `start_date_label.start_date_label_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`start_date_error_${selectedLanguage}`"
                            >Error message for start date</label
                        >
                        <input
                            type="text"
                            :name="`start_date_error_${selectedLanguage}`"
                            :id="`start_date_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'start_date_error',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['start_date_error'] &&
                                form['start_date_error'][
                                    `start_date_error_${selectedLanguage}`
                                ]
                                    ? form['start_date_error'][
                                          `start_date_error_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `start_date_error.start_date_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `start_date_error.start_date_error_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`end_date_label_${selectedLanguage}`"
                            >Label for end date</label
                        >
                        <input
                            type="text"
                            :name="`end_date_label_${selectedLanguage}`"
                            :id="`end_date_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'end_date_label',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['end_date_label'] &&
                                form['end_date_label'][
                                    `end_date_label_${selectedLanguage}`
                                ]
                                    ? form['end_date_label'][
                                          `end_date_label_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `end_date_label.end_date_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `end_date_label.end_date_label_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`end_date_error_${selectedLanguage}`"
                            >Error message for end date</label
                        >
                        <input
                            type="text"
                            :name="`end_date_error_${selectedLanguage}`"
                            :id="`end_date_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'end_date_error',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['end_date_error'] &&
                                form['end_date_error'][
                                    `end_date_error_${selectedLanguage}`
                                ]
                                    ? form['end_date_error'][
                                          `end_date_error_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `end_date_error.end_date_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `end_date_error.end_date_error_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`event_website_label_${selectedLanguage}`"
                            >Label for event URL</label
                        >
                        <input
                            type="text"
                            :name="`event_website_label_${selectedLanguage}`"
                            :id="`event_website_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'event_website_label',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['event_website_label'] &&
                                form['event_website_label'][
                                    `event_website_label_${selectedLanguage}`
                                ]
                                    ? form['event_website_label'][
                                          `event_website_label_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `event_website_label.event_website_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `event_website_label.event_website_label_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`event_website_placeholder_${selectedLanguage}`"
                            >Placeholder for event URL</label
                        >
                        <input
                            type="text"
                            :name="`event_website_placeholder_${selectedLanguage}`"
                            :id="`event_website_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'event_website_placeholder',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['event_website_placeholder'] &&
                                form['event_website_placeholder'][
                                    `event_website_placeholder_${selectedLanguage}`
                                ]
                                    ? form['event_website_placeholder'][
                                          `event_website_placeholder_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `event_website_placeholder.event_website_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `event_website_placeholder.event_website_placeholder_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`event_website_error_${selectedLanguage}`"
                            >Error message for event URL</label
                        >
                        <input
                            type="text"
                            :name="`event_website_error_${selectedLanguage}`"
                            :id="`event_website_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'event_website_error',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['event_website_error'] &&
                                form['event_website_error'][
                                    `event_website_error_${selectedLanguage}`
                                ]
                                    ? form['event_website_error'][
                                          `event_website_error_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `event_website_error.event_website_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `event_website_error.event_website_error_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`exibitors_url_label_${selectedLanguage}`"
                            >Label for exibitors URL</label
                        >
                        <input
                            type="text"
                            :name="`exibitors_url_label_${selectedLanguage}`"
                            :id="`exibitors_url_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'exibitors_url_label',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['exibitors_url_label'] &&
                                form['exibitors_url_label'][
                                    `exibitors_url_label_${selectedLanguage}`
                                ]
                                    ? form['exibitors_url_label'][
                                          `exibitors_url_label_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `exibitors_url_label.exibitors_url_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `exibitors_url_label.exibitors_url_label_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`exibitors_url_placeholder_${selectedLanguage}`"
                            >Placeholder for exibitors URL</label
                        >
                        <input
                            type="text"
                            :name="`exibitors_url_placeholder_${selectedLanguage}`"
                            :id="`exibitors_url_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'exibitors_url_placeholder',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['exibitors_url_placeholder'] &&
                                form['exibitors_url_placeholder'][
                                    `exibitors_url_placeholder_${selectedLanguage}`
                                ]
                                    ? form['exibitors_url_placeholder'][
                                          `exibitors_url_placeholder_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `exibitors_url_placeholder.exibitors_url_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `exibitors_url_placeholder.exibitors_url_placeholder_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`exibitors_url_error_${selectedLanguage}`"
                            >Error message for exibitors URL</label
                        >
                        <input
                            type="text"
                            :name="`exibitors_url_error_${selectedLanguage}`"
                            :id="`exibitors_url_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'exibitors_url_error',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['exibitors_url_error'] &&
                                form['exibitors_url_error'][
                                    `exibitors_url_error_${selectedLanguage}`
                                ]
                                    ? form['exibitors_url_error'][
                                          `exibitors_url_error_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `exibitors_url_error.exibitors_url_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `exibitors_url_error.exibitors_url_error_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`visitors_label_${selectedLanguage}`"
                            >Label for visitors URL</label
                        >
                        <input
                            type="text"
                            :name="`visitors_label_${selectedLanguage}`"
                            :id="`visitors_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'visitors_label',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['visitors_label'] &&
                                form['visitors_label'][
                                    `visitors_label_${selectedLanguage}`
                                ]
                                    ? form['visitors_label'][
                                          `visitors_label_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `visitors_label.visitors_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `visitors_label.visitors_label_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`visitors_placeholder_${selectedLanguage}`"
                            >Placeholder for visitors URL</label
                        >
                        <input
                            type="text"
                            :name="`visitors_placeholder_${selectedLanguage}`"
                            :id="`visitors_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'visitors_placeholder',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['visitors_placeholder'] &&
                                form['visitors_placeholder'][
                                    `visitors_placeholder_${selectedLanguage}`
                                ]
                                    ? form['visitors_placeholder'][
                                          `visitors_placeholder_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `visitors_placeholder.visitors_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `visitors_placeholder.visitors_placeholder_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`visitors_error_${selectedLanguage}`"
                            >Error message for visitors URL</label
                        >
                        <input
                            type="text"
                            :name="`visitors_error_${selectedLanguage}`"
                            :id="`visitors_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'visitors_error',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['visitors_error'] &&
                                form['visitors_error'][
                                    `visitors_error_${selectedLanguage}`
                                ]
                                    ? form['visitors_error'][
                                          `visitors_error_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `visitors_error.visitors_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `visitors_error.visitors_error_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`press_url_label_${selectedLanguage}`"
                            >Label for press URL</label
                        >
                        <input
                            type="text"
                            :name="`press_url_label_${selectedLanguage}`"
                            :id="`press_url_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'press_url_label',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['press_url_label'] &&
                                form['press_url_label'][
                                    `press_url_label_${selectedLanguage}`
                                ]
                                    ? form['press_url_label'][
                                          `press_url_label_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `press_url_label.press_url_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `press_url_label.press_url_label_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`press_url_placeholder_${selectedLanguage}`"
                            >Placeholder for press URL</label
                        >
                        <input
                            type="text"
                            :name="`press_url_placeholder_${selectedLanguage}`"
                            :id="`press_url_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'press_url_placeholder',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['press_url_placeholder'] &&
                                form['press_url_placeholder'][
                                    `press_url_placeholder_${selectedLanguage}`
                                ]
                                    ? form['press_url_placeholder'][
                                          `press_url_placeholder_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `press_url_placeholder.press_url_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `press_url_placeholder.press_url_placeholder_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`press_url_error_${selectedLanguage}`"
                            >Error message for press URL</label
                        >
                        <input
                            type="text"
                            :name="`press_url_error_${selectedLanguage}`"
                            :id="`press_url_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'press_url_error',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['press_url_error'] &&
                                form['press_url_error'][
                                    `press_url_error_${selectedLanguage}`
                                ]
                                    ? form['press_url_error'][
                                          `press_url_error_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `press_url_error.press_url_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `press_url_error.press_url_error_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <!-- <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`logo_label_${selectedLanguage}`"
                            >Label for logo</label
                        >
                        <input
                            type="text"
                            :name="`logo_label_${selectedLanguage}`"
                            :id="`logo_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'logo_label',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['logo_label'] &&
                                form['logo_label'][
                                    `logo_label_${selectedLanguage}`
                                ]
                                    ? form['logo_label'][
                                          `logo_label_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `logo_label.logo_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `logo_label.logo_label_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`logo_error_${selectedLanguage}`"
                            >Error message for logo</label
                        >
                        <input
                            type="text"
                            :name="`logo_error_${selectedLanguage}`"
                            :id="`logo_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'logo_error',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['logo_error'] &&
                                form['logo_error'][
                                    `logo_error_${selectedLanguage}`
                                ]
                                    ? form['logo_error'][
                                          `logo_error_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `logo_error.logo_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `logo_error.logo_error_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div> -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`contact_info_tab_heading_${selectedLanguage}`"
                            >Label for contact infomation heading</label
                        >
                        <input
                            type="text"
                            :name="`contact_info_tab_heading_${selectedLanguage}`"
                            :id="`contact_info_tab_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'contact_info_tab_heading',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['contact_info_tab_heading'] &&
                                form['contact_info_tab_heading'][
                                    `contact_info_tab_heading_${selectedLanguage}`
                                ]
                                    ? form['contact_info_tab_heading'][
                                          `contact_info_tab_heading_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `contact_info_tab_heading.contact_info_tab_heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `contact_info_tab_heading.contact_info_tab_heading_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`contact_name_label_${selectedLanguage}`"
                            >Label for contact name</label
                        >
                        <input
                            type="text"
                            :name="`contact_name_label_${selectedLanguage}`"
                            :id="`contact_name_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'contact_name_label',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['contact_name_label'] &&
                                form['contact_name_label'][
                                    `contact_name_label_${selectedLanguage}`
                                ]
                                    ? form['contact_name_label'][
                                          `contact_name_label_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `contact_name_label.contact_name_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `contact_name_label.contact_name_label_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`contact_name_error_${selectedLanguage}`"
                            >Error message for contact name</label
                        >
                        <input
                            type="text"
                            :name="`contact_name_error_${selectedLanguage}`"
                            :id="`contact_name_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'contact_name_error',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['contact_name_error'] &&
                                form['contact_name_error'][
                                    `contact_name_error_${selectedLanguage}`
                                ]
                                    ? form['contact_name_error'][
                                          `contact_name_error_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `contact_name_error.contact_name_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `contact_name_error.contact_name_error_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`contact_email_label_${selectedLanguage}`"
                            >Label for contact email</label
                        >
                        <input
                            type="text"
                            :name="`contact_email_label_${selectedLanguage}`"
                            :id="`contact_email_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'contact_email_label',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['contact_email_label'] &&
                                form['contact_email_label'][
                                    `contact_email_label_${selectedLanguage}`
                                ]
                                    ? form['contact_email_label'][
                                          `contact_email_label_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `contact_email_label.contact_email_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `contact_email_label.contact_email_label_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`contact_email_error_${selectedLanguage}`"
                            >Error message for contact email</label
                        >
                        <input
                            type="text"
                            :name="`contact_email_error_${selectedLanguage}`"
                            :id="`contact_email_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'contact_email_error',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['contact_email_error'] &&
                                form['contact_email_error'][
                                    `contact_email_error_${selectedLanguage}`
                                ]
                                    ? form['contact_email_error'][
                                          `contact_email_error_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `contact_email_error.contact_email_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `contact_email_error.contact_email_error_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`contact_phone_label_${selectedLanguage}`"
                            >Label for contact phone</label
                        >
                        <input
                            type="text"
                            :name="`contact_phone_label_${selectedLanguage}`"
                            :id="`contact_phone_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'contact_phone_label',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['contact_phone_label'] &&
                                form['contact_phone_label'][
                                    `contact_phone_label_${selectedLanguage}`
                                ]
                                    ? form['contact_phone_label'][
                                          `contact_phone_label_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `contact_phone_label.contact_phone_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `contact_phone_label.contact_phone_label_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`contact_phone_error_${selectedLanguage}`"
                            >Error message for contact phone</label
                        >
                        <input
                            type="text"
                            :name="`contact_phone_error_${selectedLanguage}`"
                            :id="`contact_phone_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'contact_phone_error',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['contact_phone_error'] &&
                                form['contact_phone_error'][
                                    `contact_phone_error_${selectedLanguage}`
                                ]
                                    ? form['contact_phone_error'][
                                          `contact_phone_error_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `contact_phone_error.contact_phone_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `contact_phone_error.contact_phone_error_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900"
                            :for="`contact_designation_label_${selectedLanguage}`"
                            >Label for contact designation</label
                        >
                        <input
                            type="text"
                            :name="`contact_designation_label_${selectedLanguage}`"
                            :id="`contact_designation_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'contact_designation_label',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['contact_designation_label'] &&
                                form['contact_designation_label'][
                                    `contact_designation_label_${selectedLanguage}`
                                ]
                                    ? form['contact_designation_label'][
                                          `contact_designation_label_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `contact_designation_label.contact_designation_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `contact_designation_label.contact_designation_label_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900"
                            :for="`contact_designation_error_${selectedLanguage}`"
                            >Error message for contact designation</label
                        >
                        <input
                            type="text"
                            :name="`contact_designation_error_${selectedLanguage}`"
                            :id="`contact_designation_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'contact_designation_error',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['contact_designation_error'] &&
                                form['contact_designation_error'][
                                    `contact_designation_error_${selectedLanguage}`
                                ]
                                    ? form['contact_designation_error'][
                                          `contact_designation_error_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `contact_designation_error.contact_designation_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `contact_designation_error.contact_designation_error_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900"
                            :for="`profile_image_label_${selectedLanguage}`"
                            >Label for profile image</label
                        >
                        <input
                            type="text"
                            :name="`profile_image_label_${selectedLanguage}`"
                            :id="`profile_image_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'profile_image_label',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['profile_image_label'] &&
                                form['profile_image_label'][
                                    `profile_image_label_${selectedLanguage}`
                                ]
                                    ? form['profile_image_label'][
                                          `profile_image_label_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `profile_image_label.profile_image_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `profile_image_label.profile_image_label_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900"
                            :for="`profile_image_error_${selectedLanguage}`"
                            >Error message for profile image</label
                        >
                        <input
                            type="text"
                            :name="`profile_image_error_${selectedLanguage}`"
                            :id="`profile_image_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'profile_image_error',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['profile_image_error'] &&
                                form['profile_image_error'][
                                    `profile_image_error_${selectedLanguage}`
                                ]
                                    ? form['profile_image_error'][
                                          `profile_image_error_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `profile_image_error.profile_image_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `profile_image_error.profile_image_error_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`delete_btn_text_${selectedLanguage}`"
                            >Delete button text</label
                        >
                        <input
                            type="text"
                            :name="`delete_btn_text_${selectedLanguage}`"
                            :id="`delete_btn_text_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'delete_btn_text',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['delete_btn_text'] &&
                                form['delete_btn_text'][
                                    `delete_btn_text_${selectedLanguage}`
                                ]
                                    ? form['delete_btn_text'][
                                          `delete_btn_text_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `delete_btn_text.delete_btn_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `delete_btn_text.delete_btn_text_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`add_new_contact_btn_text_${selectedLanguage}`"
                            >Add new contact button text</label
                        >
                        <input
                            type="text"
                            :name="`add_new_contact_btn_text_${selectedLanguage}`"
                            :id="`add_new_contact_btn_text_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'add_new_contact_btn_text',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['add_new_contact_btn_text'] &&
                                form['add_new_contact_btn_text'][
                                    `add_new_contact_btn_text_${selectedLanguage}`
                                ]
                                    ? form['add_new_contact_btn_text'][
                                          `add_new_contact_btn_text_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `add_new_contact_btn_text.add_new_contact_btn_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `add_new_contact_btn_text.add_new_contact_btn_text_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`social_media_tab_heading_${selectedLanguage}`"
                            >Social media heading</label
                        >
                        <input
                            type="text"
                            :name="`social_media_tab_heading_${selectedLanguage}`"
                            :id="`social_media_tab_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'social_media_tab_heading',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['social_media_tab_heading'] &&
                                form['social_media_tab_heading'][
                                    `social_media_tab_heading_${selectedLanguage}`
                                ]
                                    ? form['social_media_tab_heading'][
                                          `social_media_tab_heading_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `social_media_tab_heading.social_media_tab_heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `social_media_tab_heading.social_media_tab_heading_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`facebook_url_label_${selectedLanguage}`"
                            >Label for facebook URL</label
                        >
                        <input
                            type="text"
                            :name="`facebook_url_label_${selectedLanguage}`"
                            :id="`facebook_url_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'facebook_url_label',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['facebook_url_label'] &&
                                form['facebook_url_label'][
                                    `facebook_url_label_${selectedLanguage}`
                                ]
                                    ? form['facebook_url_label'][
                                          `facebook_url_label_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `facebook_url_label.facebook_url_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `facebook_url_label.facebook_url_label_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`facebook_url_error_${selectedLanguage}`"
                            >Error message for facebook URL</label
                        >
                        <input
                            type="text"
                            :name="`facebook_url_error_${selectedLanguage}`"
                            :id="`facebook_url_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'facebook_url_error',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['facebook_url_error'] &&
                                form['facebook_url_error'][
                                    `facebook_url_error_${selectedLanguage}`
                                ]
                                    ? form['facebook_url_error'][
                                          `facebook_url_error_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `facebook_url_error.facebook_url_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `facebook_url_error.facebook_url_error_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`twitter_url_label_${selectedLanguage}`"
                            >Label for twitter URL</label
                        >
                        <input
                            type="text"
                            :name="`twitter_url_label_${selectedLanguage}`"
                            :id="`twitter_url_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'twitter_url_label',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['twitter_url_label'] &&
                                form['twitter_url_label'][
                                    `twitter_url_label_${selectedLanguage}`
                                ]
                                    ? form['twitter_url_label'][
                                          `twitter_url_label_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `twitter_url_label.twitter_url_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `twitter_url_label.twitter_url_label_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`twitter_url_error_${selectedLanguage}`"
                            >Error message for twitter URL</label
                        >
                        <input
                            type="text"
                            :name="`twitter_url_error_${selectedLanguage}`"
                            :id="`twitter_url_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'twitter_url_error',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['twitter_url_error'] &&
                                form['twitter_url_error'][
                                    `twitter_url_error_${selectedLanguage}`
                                ]
                                    ? form['twitter_url_error'][
                                          `twitter_url_error_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `twitter_url_error.twitter_url_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `twitter_url_error.twitter_url_error_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`linkedin_url_label_${selectedLanguage}`"
                            >Label for linkedin URL</label
                        >
                        <input
                            type="text"
                            :name="`linkedin_url_label_${selectedLanguage}`"
                            :id="`linkedin_url_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'linkedin_url_label',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['linkedin_url_label'] &&
                                form['linkedin_url_label'][
                                    `linkedin_url_label_${selectedLanguage}`
                                ]
                                    ? form['linkedin_url_label'][
                                          `linkedin_url_label_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `linkedin_url_label.linkedin_url_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `linkedin_url_label.linkedin_url_label_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`linkedin_url_error_${selectedLanguage}`"
                            >Error message for linkedin URL</label
                        >
                        <input
                            type="text"
                            :name="`linkedin_url_error_${selectedLanguage}`"
                            :id="`linkedin_url_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'linkedin_url_error',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['linkedin_url_error'] &&
                                form['linkedin_url_error'][
                                    `linkedin_url_error_${selectedLanguage}`
                                ]
                                    ? form['linkedin_url_error'][
                                          `linkedin_url_error_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `linkedin_url_error.linkedin_url_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `linkedin_url_error.linkedin_url_error_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`youtube_url_label_${selectedLanguage}`"
                            >Label for youtube URL</label
                        >
                        <input
                            type="text"
                            :name="`youtube_url_label_${selectedLanguage}`"
                            :id="`youtube_url_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'youtube_url_label',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['youtube_url_label'] &&
                                form['youtube_url_label'][
                                    `youtube_url_label_${selectedLanguage}`
                                ]
                                    ? form['youtube_url_label'][
                                          `youtube_url_label_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `youtube_url_label.youtube_url_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `youtube_url_label.youtube_url_label_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`youtube_url_error_${selectedLanguage}`"
                            >Error message for youtube URL</label
                        >
                        <input
                            type="text"
                            :name="`youtube_url_error_${selectedLanguage}`"
                            :id="`youtube_url_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'youtube_url_error',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['youtube_url_error'] &&
                                form['youtube_url_error'][
                                    `youtube_url_error_${selectedLanguage}`
                                ]
                                    ? form['youtube_url_error'][
                                          `youtube_url_error_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `youtube_url_error.youtube_url_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `youtube_url_error.youtube_url_error_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`pintrest_url_label_${selectedLanguage}`"
                            >Label for pintrest URL</label
                        >
                        <input
                            type="text"
                            :name="`pintrest_url_label_${selectedLanguage}`"
                            :id="`pintrest_url_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'pintrest_url_label',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['pintrest_url_label'] &&
                                form['pintrest_url_label'][
                                    `pintrest_url_label_${selectedLanguage}`
                                ]
                                    ? form['pintrest_url_label'][
                                          `pintrest_url_label_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `pintrest_url_label.pintrest_url_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `pintrest_url_label.pintrest_url_label_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`pintrest_url_error_${selectedLanguage}`"
                            >Error message for pintrest URL</label
                        >
                        <input
                            type="text"
                            :name="`pintrest_url_error_${selectedLanguage}`"
                            :id="`pintrest_url_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'pintrest_url_error',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['pintrest_url_error'] &&
                                form['pintrest_url_error'][
                                    `pintrest_url_error_${selectedLanguage}`
                                ]
                                    ? form['pintrest_url_error'][
                                          `pintrest_url_error_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `pintrest_url_error.pintrest_url_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `pintrest_url_error.pintrest_url_error_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`instagram_url_label_${selectedLanguage}`"
                            >Label for instagram URL</label
                        >
                        <input
                            type="text"
                            :name="`instagram_url_label_${selectedLanguage}`"
                            :id="`instagram_url_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'instagram_url_label',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['instagram_url_label'] &&
                                form['instagram_url_label'][
                                    `instagram_url_label_${selectedLanguage}`
                                ]
                                    ? form['instagram_url_label'][
                                          `instagram_url_label_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `instagram_url_label.instagram_url_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `instagram_url_label.instagram_url_label_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`instagram_url_error_${selectedLanguage}`"
                            >Error message for instagram URL</label
                        >
                        <input
                            type="text"
                            :name="`instagram_url_error_${selectedLanguage}`"
                            :id="`instagram_url_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'instagram_url_error',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['instagram_url_error'] &&
                                form['instagram_url_error'][
                                    `instagram_url_error_${selectedLanguage}`
                                ]
                                    ? form['instagram_url_error'][
                                          `instagram_url_error_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `instagram_url_error.instagram_url_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `instagram_url_error.instagram_url_error_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`snapchat_url_label_${selectedLanguage}`"
                            >Label for snapchat URL</label
                        >
                        <input
                            type="text"
                            :name="`snapchat_url_label_${selectedLanguage}`"
                            :id="`snapchat_url_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'snapchat_url_label',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['snapchat_url_label'] &&
                                form['snapchat_url_label'][
                                    `snapchat_url_label_${selectedLanguage}`
                                ]
                                    ? form['snapchat_url_label'][
                                          `snapchat_url_label_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `snapchat_url_label.snapchat_url_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `snapchat_url_label.snapchat_url_label_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`snapchat_url_error_${selectedLanguage}`"
                            >Error message for snapchat URL</label
                        >
                        <input
                            type="text"
                            :name="`snapchat_url_error_${selectedLanguage}`"
                            :id="`snapchat_url_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'snapchat_url_error',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['snapchat_url_error'] &&
                                form['snapchat_url_error'][
                                    `snapchat_url_error_${selectedLanguage}`
                                ]
                                    ? form['snapchat_url_error'][
                                          `snapchat_url_error_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `snapchat_url_error.snapchat_url_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `snapchat_url_error.snapchat_url_error_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <!-- <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`gallery_image_label_${selectedLanguage}`">Gallery image label</label>
                        <input type="text" :name="`gallery_image_label_${selectedLanguage}`"
                            :id="`gallery_image_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'gallery_image_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['gallery_image_label'] &&
                                form['gallery_image_label'][
                                    `gallery_image_label_${selectedLanguage}`
                                ] ?
                                form['gallery_image_label'][
                                    `gallery_image_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `gallery_image_label.gallery_image_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `gallery_image_label.gallery_image_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div> -->
                    <!-- <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`gallery_image_error_${selectedLanguage}`">Gallery image error</label>
                        <input type="text" :name="`gallery_image_error_${selectedLanguage}`"
                            :id="`gallery_image_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'gallery_image_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['gallery_image_error'] &&
                                form['gallery_image_error'][
                                    `gallery_image_error_${selectedLanguage}`
                                ] ?
                                form['gallery_image_error'][
                                    `gallery_image_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `gallery_image_error.gallery_image_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `gallery_image_error.gallery_image_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div> -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`video_url_label_${selectedLanguage}`"
                            >Label for video</label
                        >
                        <input
                            type="text"
                            :name="`video_url_label_${selectedLanguage}`"
                            :id="`video_url_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'video_url_label',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['video_url_label'] &&
                                form['video_url_label'][
                                    `video_url_label_${selectedLanguage}`
                                ]
                                    ? form['video_url_label'][
                                          `video_url_label_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `video_url_label.video_url_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `video_url_label.video_url_label_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`video_url_placeholder_${selectedLanguage}`"
                            >Placeholder for video</label
                        >
                        <input
                            type="text"
                            :name="`video_url_placeholder_${selectedLanguage}`"
                            :id="`video_url_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'video_url_placeholder',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['video_url_placeholder'] &&
                                form['video_url_placeholder'][
                                    `video_url_placeholder_${selectedLanguage}`
                                ]
                                    ? form['video_url_placeholder'][
                                          `video_url_placeholder_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `video_url_placeholder.video_url_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `video_url_placeholder.video_url_placeholder_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`video_url_error_${selectedLanguage}`"
                            >Error message for video</label
                        >
                        <input
                            type="text"
                            :name="`video_url_error_${selectedLanguage}`"
                            :id="`video_url_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'video_url_error',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['video_url_error'] &&
                                form['video_url_error'][
                                    `video_url_error_${selectedLanguage}`
                                ]
                                    ? form['video_url_error'][
                                          `video_url_error_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `video_url_error.video_url_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `video_url_error.video_url_error_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900"
                            :for="`terms_and_conditions_error_${selectedLanguage}`"
                            >Error message for terms & conditions</label
                        >
                        <input
                            type="text"
                            :name="`terms_and_conditions_error_${selectedLanguage}`"
                            :id="`terms_and_conditions_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'terms_and_conditions_error',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['terms_and_conditions_error'] &&
                                form['terms_and_conditions_error'][
                                    `terms_and_conditions_error_${selectedLanguage}`
                                ]
                                    ? form['terms_and_conditions_error'][
                                          `terms_and_conditions_error_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `terms_and_conditions_error.terms_and_conditions_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `terms_and_conditions_error.terms_and_conditions_error_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`button_text_${selectedLanguage}`"
                            >Submit button text</label
                        >
                        <input
                            type="text"
                            :name="`button_text_${selectedLanguage}`"
                            :id="`button_text_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'button_text',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="
                                form['button_text'] &&
                                form['button_text'][
                                    `button_text_${selectedLanguage}`
                                ]
                                    ? form['button_text'][
                                          `button_text_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `button_text.button_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `button_text.button_text_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
                    <div
                        class="sm:col-span-6"
                        v-if="isDataLoaded"
                    >
                        <label class="block text-sm font-medium leading-6 text-gray-900"
                            :for="`terms_and_conditions_label_${selectedLanguage}`"
                            >Terms & conditions text</label
                        >
                        <editor
                            @mouseleave="
                                handleSelectionChange(
                                    language,
                                    'terms_and_conditions_label',
                                    'updateHomePageSetting'
                                )
                            "
                            @keyup="
                                handleSelectionChange(
                                    language,
                                    'terms_and_conditions_label',
                                    'updateHomePageSetting'
                                )
                            "
                            :ref="`terms_and_conditions_label_${language.id}`"
                            :id="`terms_and_conditions_label_${language.id}`"
                            :initial-value="form[`terms_and_conditions_label`][`terms_and_conditions_label_${language?.id}`]
                            "
                            :tinymce-script-src="tinymceScriptSrc"
                            :init="editorConfig"
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `terms_and_conditions_label.terms_and_conditions_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `terms_and_conditions_label.terms_and_conditions_label_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>



                    <div
                        class="sm:col-span-6"
                        v-if="
                            isDataLoaded
                        "
                    >
                        <label class="block text-sm font-medium leading-6 text-gray-900"
                            :for="`post_submit_button_text_${selectedLanguage}`"
                            >Text after submit button</label
                        >
                        <editor
                            @mouseleave="
                                handleSelectionChange(
                                    language,
                                    'post_submit_button_text',
                                    'updateHomePageSetting'
                                )
                            "
                            @keyup="
                                handleSelectionChange(
                                    language,
                                    'post_submit_button_text',
                                    'updateHomePageSetting'
                                )
                            "
                            :ref="`post_submit_button_text_${language.id}`"
                            :id="`post_submit_button_text_${language.id}`"
                            :initial-value="form[`post_submit_button_text`][`post_submit_button_text_${language?.id}`]"
                            :tinymce-script-src="tinymceScriptSrc"
                            :init="editorConfig"
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `post_submit_button_text.post_submit_button_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `post_submit_button_text.post_submit_button_text_${selectedLanguage}`
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
import Editor from "@tinymce/tinymce-vue";
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
    components: {
        editor: Editor,
    },
    data() {
        return {
            isDataLoaded: false,
            collapseStates: [true, false, false, false, false, false, false],
            editorConfig: {
        height: 250,
        menubar: false,
        plugins:
          "anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount fullscreen code",
        toolbar:
          "undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | code | fullscreen",
          base_url: '/plugins/tinymce',
          suffix: '.min'
      },
      tinymceScriptSrc: '/plugins/tinymce/tinymce.min.js',
        };
    },
    methods: {
        handleSelectionChange(language, key, mutationName) {
            this.handleInput(
                tinymce.get(`${key}_${language.id}`).getContent(),
                language,
                key,
                mutationName
            );
        },
        handleInput(value, language, key, mutationName) {
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
                    url: `${process.env.MIX_ADMIN_API_URL}event-create-setting?withEventCreateSettingDetail=1&findByPageId=${this.form.id}`,
                })
                .then((res) => {
                    let data =
                        res.data.data &&
                        res.data.data.event_create_setting_detail
                            ? res.data.data.event_create_setting_detail
                            : [];

                    let obj = {};
                    data.map((res) => {
                        obj["create_event_tab_heading_" + res.language_id] = res.create_event_tab_heading;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "create_event_tab_heading",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["title_label_" + res.language_id] = res.title_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "title_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["title_error_" + res.language_id] = res.title_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "title_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["country_label_" + res.language_id] =
                            res.country_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "country_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["country_error_" + res.language_id] =
                            res.country_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "country_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["city_label_" + res.language_id] = res.city_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "city_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["city_error_" + res.language_id] = res.city_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "city_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["street_name_label_" + res.language_id] =
                            res.street_name_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "street_name_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["street_name_error_" + res.language_id] =
                            res.street_name_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "street_name_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["venue_label_" + res.language_id] = res.venue_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "venue_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["venue_error_" + res.language_id] = res.venue_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "venue_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["product_search_label_" + res.language_id] =
                            res.product_search_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "product_search_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["product_search_placeholder_" + res.language_id] =
                            res.product_search_placeholder;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "product_search_placeholder",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["product_search_error_" + res.language_id] =
                            res.product_search_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "product_search_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["short_description_label_" + res.language_id] =
                            res.short_description_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "short_description_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["short_description_placeholder_" + res.language_id] =
                            res.short_description_placeholder;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "short_description_placeholder",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["short_description_error_" + res.language_id] =
                            res.short_description_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "short_description_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["description_label_" + res.language_id] =
                            res.description_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "description_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["description_placeholder_" + res.language_id] =
                            res.description_placeholder;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "description_placeholder",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["description_error_" + res.language_id] =
                            res.description_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "description_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["start_date_label_" + res.language_id] =
                            res.start_date_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "start_date_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["start_date_error_" + res.language_id] =
                            res.start_date_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "start_date_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["end_date_label_" + res.language_id] =
                            res.end_date_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "end_date_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["end_date_error_" + res.language_id] =
                            res.end_date_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "end_date_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["event_website_label_" + res.language_id] =
                            res.event_website_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "event_website_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["event_website_placeholder_" + res.language_id] =
                            res.event_website_placeholder;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "event_website_placeholder",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["event_website_error_" + res.language_id] =
                            res.event_website_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "event_website_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["exibitors_url_label_" + res.language_id] =
                            res.exibitors_url_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "exibitors_url_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["exibitors_url_placeholder_" + res.language_id] =
                            res.exibitors_url_placeholder;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "exibitors_url_placeholder",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["exibitors_url_error_" + res.language_id] =
                            res.exibitors_url_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "exibitors_url_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["visitors_label_" + res.language_id] =
                            res.visitors_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "visitors_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["visitors_placeholder_" + res.language_id] =
                            res.visitors_placeholder;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "visitors_placeholder",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["visitors_error_" + res.language_id] =
                            res.visitors_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "visitors_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["press_url_label_" + res.language_id] =
                            res.press_url_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "press_url_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["press_url_placeholder_" + res.language_id] =
                            res.press_url_placeholder;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "press_url_placeholder",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["press_url_error_" + res.language_id] =
                            res.press_url_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "press_url_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["logo_label_" + res.language_id] = res.logo_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "logo_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["logo_error_" + res.language_id] = res.logo_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "logo_error",
                        value: obj,
                    });
                    // obj = {};
                    // data.map((res) => {
                    //     obj["gallery_image_label_" + res.language_id] = res.gallery_image_label;
                    // });
                    // this.$store.commit("pages/setHomePageSetting", {
                    //     key: "gallery_image_label",
                    //     value: obj,
                    // });
                    // obj = {};
                    // data.map((res) => {
                    //     obj["gallery_image_error_" + res.language_id] = res.gallery_image_error;
                    // });
                    // this.$store.commit("pages/setHomePageSetting", {
                    //     key: "gallery_image_error",
                    //     value: obj,
                    // });
                    obj = {};
                    data.map((res) => {
                        obj["video_url_label_" + res.language_id] =
                            res.video_url_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "video_url_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["video_url_placeholder_" + res.language_id] =
                            res.video_url_placeholder;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "video_url_placeholder",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["contact_info_tab_heading_" + res.language_id] =
                            res.contact_info_tab_heading;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "contact_info_tab_heading",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["contact_name_label_" + res.language_id] =
                            res.contact_name_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "contact_name_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["contact_name_error_" + res.language_id] =
                            res.contact_name_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "contact_name_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["contact_email_label_" + res.language_id] =
                            res.contact_email_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "contact_email_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["contact_email_error_" + res.language_id] =
                            res.contact_email_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "contact_email_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["contact_phone_label_" + res.language_id] =
                            res.contact_phone_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "contact_phone_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["contact_phone_error_" + res.language_id] =
                            res.contact_phone_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "contact_phone_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["contact_designation_label_" + res.language_id] =
                            res.contact_designation_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "contact_designation_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["contact_designation_error_" + res.language_id] =
                            res.contact_designation_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "contact_designation_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["profile_image_label_" + res.language_id] =
                            res.profile_image_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "profile_image_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["profile_image_error_" + res.language_id] =
                            res.profile_image_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "profile_image_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["delete_btn_text_" + res.language_id] =
                            res.delete_btn_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "delete_btn_text",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["add_new_contact_btn_text_" + res.language_id] =
                            res.add_new_contact_btn_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "add_new_contact_btn_text",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["social_media_tab_heading_" + res.language_id] =
                            res.social_media_tab_heading;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "social_media_tab_heading",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["facebook_url_label_" + res.language_id] =
                            res.facebook_url_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "facebook_url_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["facebook_url_error_" + res.language_id] =
                            res.facebook_url_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "facebook_url_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["twitter_url_label_" + res.language_id] =
                            res.twitter_url_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "twitter_url_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["twitter_url_error_" + res.language_id] =
                            res.twitter_url_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "twitter_url_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["linkedin_url_label_" + res.language_id] =
                            res.linkedin_url_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "linkedin_url_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["linkedin_url_error_" + res.language_id] =
                            res.linkedin_url_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "linkedin_url_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["youtube_url_label_" + res.language_id] =
                            res.youtube_url_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "youtube_url_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["youtube_url_error_" + res.language_id] =
                            res.youtube_url_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "youtube_url_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["pintrest_url_label_" + res.language_id] =
                            res.pintrest_url_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "pintrest_url_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["pintrest_url_error_" + res.language_id] =
                            res.pintrest_url_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "pintrest_url_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["instagram_url_label_" + res.language_id] =
                            res.instagram_url_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "instagram_url_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["instagram_url_error_" + res.language_id] =
                            res.instagram_url_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "instagram_url_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["snapchat_url_label_" + res.language_id] =
                            res.snapchat_url_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "snapchat_url_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["snapchat_url_error_" + res.language_id] =
                            res.snapchat_url_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "snapchat_url_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["video_url_error_" + res.language_id] =
                            res.video_url_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "video_url_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["button_text_" + res.language_id] = res.button_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "button_text",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["terms_and_conditions_label_" + res.language_id] =
                            res.terms_and_conditions_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "terms_and_conditions_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["terms_and_conditions_error_" + res.language_id] =
                            res.terms_and_conditions_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "terms_and_conditions_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["post_submit_button_text_" + res.language_id] =
                            res.post_submit_button_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "post_submit_button_text",
                        value: obj,
                    });
                    this.isDataLoaded = 1;
                });
        },
        checkValidationError(validationErros, language) {
            return (
                validationErros.has(`create_event_tab_heading.create_event_tab_heading_${language.id}`) ||
                validationErros.has(`title_label.title_label_${language.id}`) ||
                validationErros.has(`title_error.title_error_${language.id}`) ||
                validationErros.has(
                    `country_label.country_label_${language.id}`
                ) ||
                validationErros.has(
                    `country_error.country_error_${language.id}`
                ) ||
                validationErros.has(`city_label.city_label_${language.id}`) ||
                validationErros.has(`city_error.city_error_${language.id}`) ||
                validationErros.has(
                    `street_name_label.street_name_label_${language.id}`
                ) ||
                validationErros.has(
                    `street_name_error.street_name_error_${language.id}`
                ) ||
                validationErros.has(`venue_label.venue_label_${language.id}`) ||
                validationErros.has(`venue_error.venue_error_${language.id}`) ||
                validationErros.has(
                    `product_search_label.product_search_label_${language.id}`
                ) ||
                validationErros.has(
                    `product_search_placeholder.product_search_placeholder_${language.id}`
                ) ||
                validationErros.has(
                    `product_search_error.product_search_error_${language.id}`
                ) ||
                validationErros.has(
                    `short_description_label.short_description_label_${language.id}`
                ) ||
                validationErros.has(
                    `short_description_placeholder.short_description_placeholder_${language.id}`
                ) ||
                validationErros.has(
                    `short_description_error.short_description_error_${language.id}`
                ) ||
                validationErros.has(
                    `description_label.description_label_${language.id}`
                ) ||
                validationErros.has(
                    `description_placeholder.description_placeholder_${language.id}`
                ) ||
                validationErros.has(
                    `description_error.description_error_${language.id}`
                ) ||
                validationErros.has(
                    `start_date_label.start_date_label_${language.id}`
                ) ||
                validationErros.has(
                    `start_date_error.start_date_error_${language.id}`
                ) ||
                validationErros.has(
                    `end_date_label.end_date_label_${language.id}`
                ) ||
                validationErros.has(
                    `end_date_error.end_date_error_${language.id}`
                ) ||
                validationErros.has(
                    `event_website_label.event_website_label_${language.id}`
                ) ||
                validationErros.has(
                    `event_website_placeholder.event_website_placeholder_${language.id}`
                ) ||
                validationErros.has(
                    `event_website_error.event_website_error_${language.id}`
                ) ||
                validationErros.has(
                    `exibitors_url_label.exibitors_url_label_${language.id}`
                ) ||
                validationErros.has(
                    `exibitors_url_placeholder.exibitors_url_placeholder_${language.id}`
                ) ||
                validationErros.has(
                    `exibitors_url_error.exibitors_url_error_${language.id}`
                ) ||
                validationErros.has(
                    `visitors_label.visitors_label_${language.id}`
                ) ||
                validationErros.has(
                    `visitors_placeholder.visitors_placeholder_${language.id}`
                ) ||
                validationErros.has(
                    `visitors_error.visitors_error_${language.id}`
                ) ||
                validationErros.has(
                    `press_url_label.press_url_label_${language.id}`
                ) ||
                validationErros.has(
                    `press_url_placeholder.press_url_placeholder_${language.id}`
                ) ||
                validationErros.has(
                    `press_url_error.press_url_error_${language.id}`
                ) ||
                validationErros.has(`logo_label.logo_label_${language.id}`) ||
                validationErros.has(`logo_error.logo_error_${language.id}`) ||
                validationErros.has(
                    `video_url_label.video_url_label_${language.id}`
                ) ||
                validationErros.has(
                    `video_url_placeholder.video_url_placeholder_${language.id}`
                ) ||
                validationErros.has(
                    `video_url_error.video_url_error_${language.id}`
                ) ||
                validationErros.has(
                    `contact_info_tab_heading.contact_info_tab_heading_${language.id}`
                ) ||
                validationErros.has(
                    `contact_name_label.contact_name_label_${language.id}`
                ) ||
                validationErros.has(
                    `contact_name_error.contact_name_error_${language.id}`
                ) ||
                validationErros.has(
                    `contact_email_label.contact_email_label_${language.id}`
                ) ||
                validationErros.has(
                    `contact_email_error.contact_email_error_${language.id}`
                ) ||
                validationErros.has(
                    `contact_phone_label.contact_phone_label_${language.id}`
                ) ||
                validationErros.has(
                    `contact_phone_error.contact_phone_error_${language.id}`
                ) ||
                validationErros.has(
                    `contact_designation_label.contact_designation_label_${language.id}`
                ) ||
                validationErros.has(
                    `contact_designation_error.contact_designation_error_${language.id}`
                ) ||
                validationErros.has(
                    `profile_image_label.profile_image_label_${language.id}`
                ) ||
                validationErros.has(
                    `profile_image_error.profile_image_error_${language.id}`
                ) ||
                validationErros.has(
                    `delete_btn_text.delete_btn_text_${language.id}`
                ) ||
                validationErros.has(
                    `add_new_contact_btn_text.add_new_contact_btn_text_${language.id}`
                ) ||
                validationErros.has(
                    `social_media_tab_heading.social_media_tab_heading_${language.id}`
                ) ||
                validationErros.has(
                    `facebook_url_label.facebook_url_label_${language.id}`
                ) ||
                validationErros.has(
                    `facebook_url_error.facebook_url_error_${language.id}`
                ) ||
                validationErros.has(
                    `twitter_url_label.twitter_url_label_${language.id}`
                ) ||
                validationErros.has(
                    `twitter_url_error.twitter_url_error_${language.id}`
                ) ||
                validationErros.has(
                    `linkedin_url_label.linkedin_url_label_${language.id}`
                ) ||
                validationErros.has(
                    `linkedin_url_error.linkedin_url_error_${language.id}`
                ) ||
                validationErros.has(
                    `youtube_url_label.youtube_url_label_${language.id}`
                ) ||
                validationErros.has(
                    `youtube_url_error.youtube_url_error_${language.id}`
                ) ||
                validationErros.has(
                    `pintrest_url_label.pintrest_url_label_${language.id}`
                ) ||
                validationErros.has(
                    `pintrest_url_error.pintrest_url_error_${language.id}`
                ) ||
                validationErros.has(
                    `instagram_url_label.instagram_url_label_${language.id}`
                ) ||
                validationErros.has(
                    `instagram_url_error.instagram_url_error_${language.id}`
                ) ||
                validationErros.has(
                    `snapchat_url_label.snapchat_url_label_${language.id}`
                ) ||
                validationErros.has(
                    `snapchat_url_error.snapchat_url_error_${language.id}`
                ) ||
                validationErros.has(`button_text.button_text_${language.id}`) ||
                validationErros.has(
                    `terms_and_conditions_label.terms_and_conditions_label_${language.id}`
                ) ||
                validationErros.has(
                    `terms_and_conditions_error.terms_and_conditions_error_${language.id}`
                ) ||
                validationErros.has(
                    `post_submit_button_text.post_submit_button_text_${language.id}`
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
                    obj["create_event_tab_heading_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "create_event_tab_heading",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["title_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "title_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["title_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "title_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["country_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "country_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["country_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "country_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["city_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "city_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["city_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "city_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["city_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "city_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["city_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "city_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["street_name_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "street_name_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["street_name_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "street_name_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["venue_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "venue_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["venue_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "venue_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["product_search_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "product_search_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["product_search_placeholder_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "product_search_placeholder",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["product_search_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "product_search_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["short_description_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "short_description_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["short_description_placeholder_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "short_description_placeholder",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["short_description_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "short_description_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["description_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "description_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["description_placeholder_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "description_placeholder",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["description_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "description_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["start_date_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "start_date_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["start_date_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "start_date_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["end_date_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "end_date_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["end_date_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "end_date_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["event_website_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "event_website_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["event_website_placeholder_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "event_website_placeholder",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["event_website_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "event_website_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["exibitors_url_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "exibitors_url_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["exibitors_url_placeholder_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "exibitors_url_placeholder",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["exibitors_url_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "exibitors_url_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["visitors_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "visitors_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["visitors_placeholder_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "visitors_placeholder",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["visitors_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "visitors_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["press_url_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "press_url_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["press_url_placeholder_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "press_url_placeholder",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["press_url_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "press_url_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["logo_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "logo_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["logo_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "logo_error",
                    value: obj,
                });
                // obj = {};
                // data.map((res) => {
                //     obj["gallery_image_label_" + res.id] = "";
                // });
                // this.$store.commit("pages/setHomePageSetting", {
                //     key: "gallery_image_label",
                //     value: obj,
                // });
                // obj = {};
                // data.map((res) => {
                //     obj["gallery_image_error_" + res.id] = "";
                // });
                // this.$store.commit("pages/setHomePageSetting", {
                //     key: "gallery_image_error",
                //     value: obj,
                // });
                obj = {};
                data.map((res) => {
                    obj["video_url_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "video_url_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["video_url_placeholder_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "video_url_placeholder",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["video_url_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "video_url_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["contact_name_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "contact_name_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["contact_info_tab_heading_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "contact_info_tab_heading",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["contact_name_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "contact_name_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["contact_email_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "contact_email_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["contact_email_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "contact_email_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["contact_phone_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "contact_phone_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["contact_phone_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "contact_phone_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["contact_designation_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "contact_designation_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["contact_designation_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "contact_designation_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["profile_image_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "profile_image_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["profile_image_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "profile_image_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["delete_btn_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "delete_btn_text",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["add_new_contact_btn_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "add_new_contact_btn_text",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["social_media_tab_heading_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "social_media_tab_heading",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["facebook_url_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "facebook_url_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["facebook_url_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "facebook_url_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["twitter_url_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "twitter_url_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["twitter_url_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "twitter_url_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["linkedin_url_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "linkedin_url_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["linkedin_url_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "linkedin_url_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["youtube_url_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "youtube_url_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["youtube_url_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "youtube_url_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["pintrest_url_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "pintrest_url_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["pintrest_url_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "pintrest_url_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["instagram_url_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "instagram_url_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["instagram_url_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "instagram_url_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["snapchat_url_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "snapchat_url_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["snapchat_url_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "snapchat_url_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["button_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "button_text",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["terms_and_conditions_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "terms_and_conditions_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["terms_and_conditions_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "terms_and_conditions_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["post_submit_button_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "post_submit_button_text",
                    value: obj,
                });

                if (this.$route.params.id) {
                    this.fetchPageSetting();
                }
                else{
                    this.isDataLoaded = 1
                }
            });
    },
};
</script>
<style>
.tox-notification { display: none !important }
</style>
