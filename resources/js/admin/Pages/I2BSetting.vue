<template>
    <div class="my-5" v-for="language in languages" :key="language.id"
        :class="(selectedLanguage == null && language.is_default) ||
        language.id == selectedLanguage ?
            'block' :
            'hidden'">
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
                                <span class="text-sm font-medium">Page settings</span>
                                <span class="text-sm font-medium text-gray-500">Inquiry to buy page settings</span>
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
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`search_label_${selectedLanguage}`">Label for search</label>
                        <input type="text" :name="`search_label_${selectedLanguage}`"
                            :id="`search_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'search_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['search_label'] &&
                                form['search_label'][
                                    `search_label_${selectedLanguage}`
                                ] ?
                                form['search_label'][
                                    `search_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `search_label.search_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `search_label.search_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`search_placeholder_${selectedLanguage}`">Placeholder for search</label>
                        <input type="text" :name="`search_placeholder_${selectedLanguage}`"
                            :id="`search_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'search_placeholder',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['search_placeholder'] &&
                                form['search_placeholder'][
                                    `search_placeholder_${selectedLanguage}`
                                ] ?
                                form['search_placeholder'][
                                    `search_placeholder_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `search_placeholder.search_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `search_placeholder.search_placeholder_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`search_error_${selectedLanguage}`">Error message for search</label>
                        <input type="text" :name="`search_error_${selectedLanguage}`"
                            :id="`search_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'search_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['search_error'] &&
                                form['search_error'][
                                    `search_error_${selectedLanguage}`
                                ] ?
                                form['search_error'][
                                    `search_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `search_error.search_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `search_error.search_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`business_categories_label_${selectedLanguage}`">Label for business category</label>
                        <input type="text" :name="`business_categories_label_${selectedLanguage}`"
                            :id="`business_categories_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'business_categories_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['business_categories_label'] &&
                                form['business_categories_label'][
                                    `business_categories_label_${selectedLanguage}`
                                ] ?
                                form['business_categories_label'][
                                    `business_categories_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `business_categories_label.business_categories_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `business_categories_label.business_categories_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`business_categories_placeholder_${selectedLanguage}`">Placeholder for business category</label>
                        <input type="text" :name="`business_categories_placeholder_${selectedLanguage}`"
                            :id="`business_categories_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'business_categories_placeholder',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['business_categories_placeholder'] &&
                                form['business_categories_placeholder'][
                                    `business_categories_placeholder_${selectedLanguage}`
                                ] ?
                                form['business_categories_placeholder'][
                                    `business_categories_placeholder_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `business_categories_placeholder.business_categories_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `business_categories_placeholder.business_categories_placeholder_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`business_categories_error_${selectedLanguage}`">Error message for business category</label>
                        <input type="text" :name="`business_categories_error_${selectedLanguage}`"
                            :id="`business_categories_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'business_categories_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['business_categories_error'] &&
                                form['business_categories_error'][
                                    `business_categories_error_${selectedLanguage}`
                                ] ?
                                form['business_categories_error'][
                                    `business_categories_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `business_categories_error.business_categories_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `business_categories_error.business_categories_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`business_categories_all_text_${selectedLanguage}`">All business categories text</label>
                        <input type="text" :name="`business_categories_all_text_${selectedLanguage}`"
                            :id="`business_categories_all_text_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'business_categories_all_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['business_categories_all_text'] &&
                                form['business_categories_all_text'][
                                    `business_categories_all_text_${selectedLanguage}`
                                ] ?
                                form['business_categories_all_text'][
                                    `business_categories_all_text_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `business_categories_all_text.business_categories_all_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `business_categories_all_text.business_categories_all_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`country_label_${selectedLanguage}`">Label for country</label>
                        <input type="text" :name="`country_label_${selectedLanguage}`"
                            :id="`country_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'country_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['country_label'] &&
                                form['country_label'][
                                    `country_label_${selectedLanguage}`
                                ] ?
                                form['country_label'][
                                    `country_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `country_label.country_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `country_label.country_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`country_placeholder_${selectedLanguage}`">Placeholder for country</label>
                        <input type="text" :name="`country_placeholder_${selectedLanguage}`"
                            :id="`country_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'country_placeholder',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['country_placeholder'] &&
                                form['country_placeholder'][
                                    `country_placeholder_${selectedLanguage}`
                                ] ?
                                form['country_placeholder'][
                                    `country_placeholder_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `country_placeholder.country_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `country_placeholder.country_placeholder_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`country_error_${selectedLanguage}`">Error message for country</label>
                        <input type="text" :name="`country_error_${selectedLanguage}`"
                            :id="`country_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'country_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['country_error'] &&
                                form['country_error'][
                                    `country_error_${selectedLanguage}`
                                ] ?
                                form['country_error'][
                                    `country_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `country_error.country_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `country_error.country_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`country_all_text_${selectedLanguage}`">All country text</label>
                        <input type="text" :name="`country_all_text_${selectedLanguage}`"
                            :id="`country_all_text_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'country_all_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['country_all_text'] &&
                                form['country_all_text'][
                                    `country_all_text_${selectedLanguage}`
                                ] ?
                                form['country_all_text'][
                                    `country_all_text_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `country_all_text.country_all_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `country_all_text.country_all_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`search_button_text_${selectedLanguage}`">Search button text</label>
                        <input type="text" :name="`search_button_text_${selectedLanguage}`"
                            :id="`search_button_text_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'search_button_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['search_button_text'] &&
                                form['search_button_text'][
                                    `search_button_text_${selectedLanguage}`
                                ] ?
                                form['search_button_text'][
                                    `search_button_text_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `search_button_text.search_button_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `search_button_text.search_button_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`title_heading_${selectedLanguage}`">Title heading</label>
                        <input type="text" :name="`title_heading_${selectedLanguage}`"
                            :id="`title_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'title_heading',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['title_heading'] &&
                                form['title_heading'][
                                    `title_heading_${selectedLanguage}`
                                ] ?
                                form['title_heading'][
                                    `title_heading_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `title_heading.title_heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `title_heading.title_heading_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`industry_heading_${selectedLanguage}`">Industry heading</label>
                        <input type="text" :name="`industry_heading_${selectedLanguage}`"
                            :id="`industry_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'industry_heading',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['industry_heading'] &&
                                form['industry_heading'][
                                    `industry_heading_${selectedLanguage}`
                                ] ?
                                form['industry_heading'][
                                    `industry_heading_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `industry_heading.industry_heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `industry_heading.industry_heading_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`country_heading_${selectedLanguage}`">Country heading</label>
                        <input type="text" :name="`country_heading_${selectedLanguage}`"
                            :id="`country_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'country_heading',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['country_heading'] &&
                                form['country_heading'][
                                    `country_heading_${selectedLanguage}`
                                ] ?
                                form['country_heading'][
                                    `country_heading_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `country_heading.country_heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `country_heading.country_heading_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`deadline_heading_${selectedLanguage}`">Deadline heading</label>
                        <input type="text" :name="`deadline_heading_${selectedLanguage}`"
                            :id="`deadline_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'deadline_heading',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['deadline_heading'] &&
                                form['deadline_heading'][
                                    `deadline_heading_${selectedLanguage}`
                                ] ?
                                form['deadline_heading'][
                                    `deadline_heading_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `deadline_heading.deadline_heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `deadline_heading.deadline_heading_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`estimated_value_heading_${selectedLanguage}`">Estimated value heading</label>
                        <input type="text" :name="`estimated_value_heading_${selectedLanguage}`"
                            :id="`estimated_value_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'estimated_value_heading',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['estimated_value_heading'] &&
                                form['estimated_value_heading'][
                                    `estimated_value_heading_${selectedLanguage}`
                                ] ?
                                form['estimated_value_heading'][
                                    `estimated_value_heading_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `estimated_value_heading.estimated_value_heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `estimated_value_heading.estimated_value_heading_${selectedLanguage}`
                                )
                            ">
                        </p>
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
            this.$store.commit(`pages/${mutationName}`, {
                value: value,
                id: language.id,
                key,
            });
        },
        addUpdateForm() {
            this.$store.dispatch("pages/addUpdateForm").then(res =>{
                if(res.data.status == 'Success'){

            this.$emit('addUpdateFormParent');
                }
            });
        },
        fetchPageSetting() {
            this.$store
                .dispatch("pages/fetchPage", {
                    url: `${process.env.MIX_ADMIN_API_URL}i2b-setting?withI2BSettingDetail=1&findByPageId=${this.form.id}`,
                })
                .then((res) => {
                    let data = res.data.data && res.data.data.i2b_setting_detail
                            ? res.data.data.i2b_setting_detail
                            : [];

                    let obj = {};
                    data.map((res) => {
                        obj["search_label_" + res.language_id] = res.search_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "search_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["search_placeholder_" + res.language_id] = res.search_placeholder;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "search_placeholder",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["search_error_" + res.language_id] = res.search_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "search_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["business_categories_label_" + res.language_id] = res.business_categories_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "business_categories_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["business_categories_placeholder_" + res.language_id] = res.business_categories_placeholder;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "business_categories_placeholder",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["business_categories_error_" + res.language_id] = res.business_categories_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "business_categories_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["business_categories_all_text_" + res.language_id] = res.business_categories_all_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "business_categories_all_text",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["country_label_" + res.language_id] = res.country_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "country_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["country_placeholder_" + res.language_id] = res.country_placeholder;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "country_placeholder",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["country_error_" + res.language_id] = res.country_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "country_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["country_all_text_" + res.language_id] = res.country_all_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "country_all_text",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["search_button_text_" + res.language_id] = res.search_button_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "search_button_text",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["title_heading_" + res.language_id] = res.title_heading;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "title_heading",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["industry_heading_" + res.language_id] = res.industry_heading;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "industry_heading",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["country_heading_" + res.language_id] = res.country_heading;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "country_heading",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["deadline_heading_" + res.language_id] = res.deadline_heading;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "deadline_heading",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["estimated_value_heading_" + res.language_id] = res.estimated_value_heading;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "estimated_value_heading",
                        value: obj,
                    });
                });
        },
        checkValidationError(validationErros, language) {
            return (
                validationErros.has(`search_label.search_label_${language.id}`) ||
                validationErros.has(`search_placeholder.search_placeholder_${language.id}`) ||
                validationErros.has(`search_error.search_error_${language.id}`) ||
                validationErros.has(`business_categories_label.business_categories_label_${language.id}`) ||
                validationErros.has(`business_categories_placeholder.business_categories_placeholder_${language.id}`) ||
                validationErros.has(`business_categories_error.business_categories_error_${language.id}`) ||
                validationErros.has(`business_categories_all_text.business_categories_all_text_${language.id}`) ||
                validationErros.has(`country_label.country_label_${language.id}`) ||
                validationErros.has(`country_placeholder.country_placeholder_${language.id}`) ||
                validationErros.has(`country_error.country_error_${language.id}`) ||
                validationErros.has(`country_all_text.country_all_text_${language.id}`) ||
                validationErros.has(`search_button_text.search_button_text_${language.id}`) ||
                validationErros.has(`title_heading.title_heading_${language.id}`) ||
                validationErros.has(`industry_heading.industry_heading_${language.id}`) ||
                validationErros.has(`country_heading.country_heading_${language.id}`) ||
                validationErros.has(`deadline_heading.deadline_heading_${language.id}`) ||
                validationErros.has(`estimated_value_heading.estimated_value_heading_${language.id}`)
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
                    obj["search_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "search_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["search_placeholder_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "search_placeholder",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["search_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "search_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["business_categories_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "business_categories_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["business_categories_placeholder_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "business_categories_placeholder",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["business_categories_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "business_categories_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["business_categories_all_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "business_categories_all_text",
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
                    obj["country_placeholder_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "country_placeholder",
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
                    obj["country_all_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "country_all_text",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["search_button_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "search_button_text",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["title_heading_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "title_heading",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["industry_heading_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "industry_heading",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["country_heading_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "country_heading",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["deadline_heading_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "deadline_heading",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["estimated_value_heading_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "estimated_value_heading",
                    value: obj,
                });

                if(this.$route.params.id){
                    this.fetchPageSetting();
                }
            });
    },
};
</script>
