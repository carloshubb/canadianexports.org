<template>
    <div class="my-5" v-for="language in languages" :key="language.id"
        :class="(selectedLanguage == null && language.is_default) ||
        language.id == selectedLanguage ?
            'block' :
            'hidden'">
        <div class="border rounded w-full" :class="collapseStates[0] ? 'bg-gray-50' : ''">
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
                                <span class="text-sm font-medium text-gray-500">Event page & form settings</span>
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
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`profile_section_heading_${selectedLanguage}`">Profile section heading</label>
                        <input type="text" :name="`profile_section_heading_${selectedLanguage}`"
                            :id="`profile_section_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'profile_section_heading',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['profile_section_heading'] &&
                                form['profile_section_heading'][
                                    `profile_section_heading_${selectedLanguage}`
                                ] ?
                                form['profile_section_heading'][
                                    `profile_section_heading_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `profile_section_heading.profile_section_heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `profile_section_heading.profile_section_heading_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`name_label_${selectedLanguage}`">Label for Name field</label>
                        <input type="text" :name="`name_label_${selectedLanguage}`"
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
                            :value="form['name_label'] &&
                                form['name_label'][
                                    `name_label_${selectedLanguage}`
                                ] ?
                                form['name_label'][
                                    `name_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `name_label.name_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `name_label.name_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`name_error_${selectedLanguage}`">Error message for name</label>
                        <input type="text" :name="`name_error_${selectedLanguage}`"
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
                            :value="form['name_error'] &&
                                form['name_error'][
                                    `name_error_${selectedLanguage}`
                                ] ?
                                form['name_error'][
                                    `name_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `name_error.name_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `name_error.name_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`business_name_label_${selectedLanguage}`">Label for business name</label>
                        <input type="text" :name="`business_name_label_${selectedLanguage}`"
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
                            :value="form['business_name_label'] &&
                                form['business_name_label'][
                                    `business_name_label_${selectedLanguage}`
                                ] ?
                                form['business_name_label'][
                                    `business_name_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `business_name_label.business_name_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `business_name_label.business_name_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`business_name_error_${selectedLanguage}`">Error message for business name</label>
                        <input type="text" :name="`business_name_error_${selectedLanguage}`"
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
                            :value="form['business_name_error'] &&
                                form['business_name_error'][
                                    `business_name_error_${selectedLanguage}`
                                ] ?
                                form['business_name_error'][
                                    `business_name_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `business_name_error.business_name_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `business_name_error.business_name_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`email_label_${selectedLanguage}`">Label for email</label>
                        <input type="text" :name="`email_label_${selectedLanguage}`"
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
                            :value="form['email_label'] &&
                                form['email_label'][
                                    `email_label_${selectedLanguage}`
                                ] ?
                                form['email_label'][
                                    `email_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `email_label.email_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `email_label.email_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`email_error_${selectedLanguage}`">Error message for email</label>
                        <input type="text" :name="`email_error_${selectedLanguage}`"
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
                            :value="form['email_error'] &&
                                form['email_error'][
                                    `email_error_${selectedLanguage}`
                                ] ?
                                form['email_error'][
                                    `email_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `email_error.email_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `email_error.email_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`password_label_${selectedLanguage}`">Label for password</label>
                        <input type="text" :name="`password_label_${selectedLanguage}`"
                            :id="`password_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'password_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['password_label'] &&
                                form['password_label'][
                                    `password_label_${selectedLanguage}`
                                ] ?
                                form['password_label'][
                                    `password_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `password_label.password_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `password_label.password_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`password_placeholder_${selectedLanguage}`">Placeholder for password</label>
                        <input type="text" :name="`password_placeholder_${selectedLanguage}`"
                            :id="`password_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'password_placeholder',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['password_placeholder'] &&
                                form['password_placeholder'][
                                    `password_placeholder_${selectedLanguage}`
                                ] ?
                                form['password_placeholder'][
                                    `password_placeholder_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `password_placeholder.password_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `password_placeholder.password_placeholder_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`password_error_${selectedLanguage}`">Error message for password</label>
                        <input type="text" :name="`password_error_${selectedLanguage}`"
                            :id="`password_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'password_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['password_error'] &&
                                form['password_error'][
                                    `password_error_${selectedLanguage}`
                                ] ?
                                form['password_error'][
                                    `password_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `password_error.password_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `password_error.password_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`confirm_password_label_${selectedLanguage}`">Label for confirm password</label>
                        <input type="text" :name="`confirm_password_label_${selectedLanguage}`"
                            :id="`confirm_password_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'confirm_password_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['confirm_password_label'] &&
                                form['confirm_password_label'][
                                    `confirm_password_label_${selectedLanguage}`
                                ] ?
                                form['confirm_password_label'][
                                    `confirm_password_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `confirm_password_label.confirm_password_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `confirm_password_label.confirm_password_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`confirm_password_error_${selectedLanguage}`">Error message for confirm password</label>
                        <input type="text" :name="`confirm_password_error_${selectedLanguage}`"
                            :id="`confirm_password_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'confirm_password_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['confirm_password_error'] &&
                                form['confirm_password_error'][
                                    `confirm_password_error_${selectedLanguage}`
                                ] ?
                                form['confirm_password_error'][
                                    `confirm_password_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `confirm_password_error.confirm_password_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `confirm_password_error.confirm_password_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`package_section_heading_${selectedLanguage}`">Heading for package section</label>
                        <input type="text" :name="`package_section_heading_${selectedLanguage}`"
                            :id="`package_section_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'package_section_heading',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['package_section_heading'] &&
                                form['package_section_heading'][
                                    `package_section_heading_${selectedLanguage}`
                                ] ?
                                form['package_section_heading'][
                                    `package_section_heading_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `package_section_heading.package_section_heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `package_section_heading.package_section_heading_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`free_package_text_${selectedLanguage}`">Description for free package</label>
                        <input type="text" :name="`free_package_text_${selectedLanguage}`"
                            :id="`free_package_text_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'free_package_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['free_package_text'] &&
                                form['free_package_text'][
                                    `free_package_text_${selectedLanguage}`
                                ] ?
                                form['free_package_text'][
                                    `free_package_text_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `free_package_text.free_package_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `free_package_text.free_package_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`premium_package_text_${selectedLanguage}`">Description for premium package</label>
                        <input type="text" :name="`premium_package_text_${selectedLanguage}`"
                            :id="`premium_package_text_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'premium_package_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['premium_package_text'] &&
                                form['premium_package_text'][
                                    `premium_package_text_${selectedLanguage}`
                                ] ?
                                form['premium_package_text'][
                                    `premium_package_text_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `premium_package_text.premium_package_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `premium_package_text.premium_package_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`featured_package_text_${selectedLanguage}`">Description for feautred package</label>
                        <input type="text" :name="`featured_package_text_${selectedLanguage}`"
                            :id="`featured_package_text_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'featured_package_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['featured_package_text'] &&
                                form['featured_package_text'][
                                    `featured_package_text_${selectedLanguage}`
                                ] ?
                                form['featured_package_text'][
                                    `featured_package_text_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `featured_package_text.featured_package_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `featured_package_text.featured_package_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`package_error_${selectedLanguage}`">Error message for packages</label>
                        <input type="text" :name="`package_error_${selectedLanguage}`"
                            :id="`package_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'package_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['package_error'] &&
                                form['package_error'][
                                    `package_error_${selectedLanguage}`
                                ] ?
                                form['package_error'][
                                    `package_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `package_error.package_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `package_error.package_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>

                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`event_section_heading_${selectedLanguage}`">Heading for create event section</label>
                        <input type="text" :name="`event_section_heading_${selectedLanguage}`"
                            :id="`event_section_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'event_section_heading',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['event_section_heading'] &&
                                form['event_section_heading'][
                                    `event_section_heading_${selectedLanguage}`
                                ] ?
                                form['event_section_heading'][
                                    `event_section_heading_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `event_section_heading.event_section_heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `event_section_heading.event_section_heading_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>

                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`contact_section_heading_${selectedLanguage}`">Heading for contact information section</label>
                        <input type="text" :name="`contact_section_heading_${selectedLanguage}`"
                            :id="`contact_section_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'contact_section_heading',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['contact_section_heading'] &&
                                form['contact_section_heading'][
                                    `contact_section_heading_${selectedLanguage}`
                                ] ?
                                form['contact_section_heading'][
                                    `contact_section_heading_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `contact_section_heading.contact_section_heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `contact_section_heading.contact_section_heading_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>

                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`media_section_heading_${selectedLanguage}`">Heading for social media section</label>
                        <input type="text" :name="`media_section_heading_${selectedLanguage}`"
                            :id="`media_section_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'media_section_heading',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['media_section_heading'] &&
                                form['media_section_heading'][
                                    `media_section_heading_${selectedLanguage}`
                                ] ?
                                form['media_section_heading'][
                                    `media_section_heading_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `media_section_heading.media_section_heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `media_section_heading.media_section_heading_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>

                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`button_text_${selectedLanguage}`">Submit button text</label>
                        <input type="text" :name="`button_text_${selectedLanguage}`"
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
                            :value="form['button_text'] &&
                                form['button_text'][
                                    `button_text_${selectedLanguage}`
                                ] ?
                                form['button_text'][
                                    `button_text_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `button_text.button_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `button_text.button_text_${selectedLanguage}`
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
            // console.log(value, key, language, mutationName);
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
                    url: `${process.env.MIX_ADMIN_API_URL}event-signup-setting?withEventSignupSettingDetail=1&findByPageId=${this.form.id}`,
                })
                .then((res) => {
                    let data = res.data.data && res.data.data.event_signup_setting_detail
                            ? res.data.data.event_signup_setting_detail
                            : [];

                    let obj = {};
                    data.map((res) => {
                        obj["profile_section_heading_" + res.language_id] = res.profile_section_heading;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "profile_section_heading",
                        value: obj,
                    });
                    obj = {};
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
                        obj["business_name_label_" + res.language_id] = res.business_name_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "business_name_label",
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
                        obj["password_label_" + res.language_id] = res.password_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "password_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["password_placeholder_" + res.language_id] = res.password_placeholder;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "password_placeholder",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["password_error_" + res.language_id] = res.password_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "password_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["confirm_password_label_" + res.language_id] = res.confirm_password_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "confirm_password_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["confirm_password_error_" + res.language_id] = res.confirm_password_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "confirm_password_error",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["package_section_heading_" + res.language_id] = res.package_section_heading;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "package_section_heading",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["event_section_heading_" + res.language_id] = res.event_section_heading;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "event_section_heading",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["contact_section_heading_" + res.language_id] = res.contact_section_heading;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "contact_section_heading",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["media_section_heading_" + res.language_id] = res.media_section_heading;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "media_section_heading",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["free_package_text_" + res.language_id] = res.free_package_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "free_package_text",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["featured_package_text_" + res.language_id] = res.featured_package_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "featured_package_text",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["premium_package_text_" + res.language_id] = res.premium_package_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "premium_package_text",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["package_error_" + res.language_id] = res.package_error;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "package_error",
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
                });
        },
        checkValidationError(validationErros, language) {
            return (
                validationErros.has(`profile_section_heading.profile_section_heading_${language.id}`) ||
                validationErros.has(`name_label.name_label_${language.id}`) ||
                validationErros.has(`name_error.name_error_${language.id}`) ||
                validationErros.has(`business_name_label.business_name_label_${language.id}`) ||
                validationErros.has(`business_name_error.business_name_error_${language.id}`) ||
                validationErros.has(`email_label.email_label_${language.id}`) ||
                validationErros.has(`email_error.email_error_${language.id}`) ||
                validationErros.has(`password_label.password_label_${language.id}`) ||
                validationErros.has(`password_placeholder.password_placeholder_${language.id}`) ||
                validationErros.has(`password_error.password_error_${language.id}`) ||
                validationErros.has(`confirm_password_label.confirm_password_label_${language.id}`) ||
                validationErros.has(`package_section_heading.package_section_heading_${language.id}`) ||
                validationErros.has(`event_section_heading.event_section_heading_${language.id}`) ||
                validationErros.has(`contact_section_heading.contact_section_heading_${language.id}`) ||
                validationErros.has(`media_section_heading.media_section_heading_${language.id}`) ||
                validationErros.has(`confirm_password_error.confirm_password_error_${language.id}`) ||
                validationErros.has(`free_package_text.free_package_text_${language.id}`) ||
                validationErros.has(`featured_package_text.featured_package_text_${language.id}`) ||
                validationErros.has(`premium_package_text.premium_package_text_${language.id}`) ||
                validationErros.has(`package_error.package_error_${language.id}`) ||
                validationErros.has(`button_text.button_text_${language.id}`)
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
                    obj["profile_section_heading_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "profile_section_heading",
                    value: obj,
                });
                obj = {};
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
                    obj["business_name_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "business_name_label",
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
                    obj["password_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "password_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["password_placeholder_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "password_placeholder",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["password_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "password_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["confirm_password_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "confirm_password_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["confirm_password_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "confirm_password_error",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["package_section_heading_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "package_section_heading",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["event_section_heading_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "event_section_heading",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["contact_section_heading_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "contact_section_heading",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["media_section_heading_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "media_section_heading",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["free_package_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "free_package_text",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["featured_package_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "featured_package_text",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["premium_package_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "premium_package_text",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["package_error_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "package_error",
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

                if(this.$route.params.id){
                    this.fetchPageSetting();
                }
            });
    },
};
</script>
