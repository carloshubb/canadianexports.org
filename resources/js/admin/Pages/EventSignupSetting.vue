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
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`organizer_website_label_${selectedLanguage}`">Label for organizer website</label>
                        <input type="text" :name="`organizer_website_label_${selectedLanguage}`"
                            :id="`organizer_website_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'organizer_website_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['organizer_website_label'] &&
                                form['organizer_website_label'][
                                    `organizer_website_label_${selectedLanguage}`
                                ] ?
                                form['organizer_website_label'][
                                    `organizer_website_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `organizer_website_label.organizer_website_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `organizer_website_label.organizer_website_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`your_profile_heading_${selectedLanguage}`">Your profile heading</label>
                        <input type="text" :name="`your_profile_heading_${selectedLanguage}`"
                            :id="`your_profile_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="handleInput($event.target.value, language, 'your_profile_heading', 'updateHomePageSetting')"
                            :value="form['your_profile_heading']?.[`your_profile_heading_${selectedLanguage}`] ?? ''" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`your_profile_heading.your_profile_heading_${selectedLanguage}`)"
                            v-text="validationErros.get(`your_profile_heading.your_profile_heading_${selectedLanguage}`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`the_organizer_heading_${selectedLanguage}`">The organizer heading</label>
                        <input type="text" :name="`the_organizer_heading_${selectedLanguage}`"
                            :id="`the_organizer_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="handleInput($event.target.value, language, 'the_organizer_heading', 'updateHomePageSetting')"
                            :value="form['the_organizer_heading']?.[`the_organizer_heading_${selectedLanguage}`] ?? ''" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`the_organizer_heading.the_organizer_heading_${selectedLanguage}`)"
                            v-text="validationErros.get(`the_organizer_heading.the_organizer_heading_${selectedLanguage}`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`contact_person_heading_${selectedLanguage}`">Contact person heading</label>
                        <input type="text" :name="`contact_person_heading_${selectedLanguage}`"
                            :id="`contact_person_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="handleInput($event.target.value, language, 'contact_person_heading', 'updateHomePageSetting')"
                            :value="form['contact_person_heading']?.[`contact_person_heading_${selectedLanguage}`] ?? ''" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`contact_person_heading.contact_person_heading_${selectedLanguage}`)"
                            v-text="validationErros.get(`contact_person_heading.contact_person_heading_${selectedLanguage}`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`organizer_phone_label_${selectedLanguage}`">Organizer phone label</label>
                        <input type="text" :name="`organizer_phone_label_${selectedLanguage}`"
                            :id="`organizer_phone_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="handleInput($event.target.value, language, 'organizer_phone_label', 'updateHomePageSetting')"
                            :value="form['organizer_phone_label']?.[`organizer_phone_label_${selectedLanguage}`] ?? ''" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`organizer_phone_label.organizer_phone_label_${selectedLanguage}`)"
                            v-text="validationErros.get(`organizer_phone_label.organizer_phone_label_${selectedLanguage}`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`mailing_address_label_${selectedLanguage}`">Mailing address label</label>
                        <input type="text" :name="`mailing_address_label_${selectedLanguage}`"
                            :id="`mailing_address_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="handleInput($event.target.value, language, 'mailing_address_label', 'updateHomePageSetting')"
                            :value="form['mailing_address_label']?.[`mailing_address_label_${selectedLanguage}`] ?? ''" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`mailing_address_label.mailing_address_label_${selectedLanguage}`)"
                            v-text="validationErros.get(`mailing_address_label.mailing_address_label_${selectedLanguage}`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`contact_name_label_${selectedLanguage}`">Contact name label</label>
                        <input type="text" :name="`contact_name_label_${selectedLanguage}`" :id="`contact_name_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" " @input="handleInput($event.target.value, language, 'contact_name_label', 'updateHomePageSetting')"
                            :value="form['contact_name_label']?.[`contact_name_label_${selectedLanguage}`] ?? ''" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`contact_name_label.contact_name_label_${selectedLanguage}`)" v-text="validationErros.get(`contact_name_label.contact_name_label_${selectedLanguage}`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`contact_phone_label_${selectedLanguage}`">Contact phone label</label>
                        <input type="text" :name="`contact_phone_label_${selectedLanguage}`" :id="`contact_phone_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" " @input="handleInput($event.target.value, language, 'contact_phone_label', 'updateHomePageSetting')"
                            :value="form['contact_phone_label']?.[`contact_phone_label_${selectedLanguage}`] ?? ''" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`contact_phone_label.contact_phone_label_${selectedLanguage}`)" v-text="validationErros.get(`contact_phone_label.contact_phone_label_${selectedLanguage}`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`contact_phone_hint_${selectedLanguage}`">Contact phone hint</label>
                        <input type="text" :name="`contact_phone_hint_${selectedLanguage}`" :id="`contact_phone_hint_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" " @input="handleInput($event.target.value, language, 'contact_phone_hint', 'updateHomePageSetting')"
                            :value="form['contact_phone_hint']?.[`contact_phone_hint_${selectedLanguage}`] ?? ''" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`contact_phone_hint.contact_phone_hint_${selectedLanguage}`)" v-text="validationErros.get(`contact_phone_hint.contact_phone_hint_${selectedLanguage}`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`contact_email_label_${selectedLanguage}`">Contact email label</label>
                        <input type="text" :name="`contact_email_label_${selectedLanguage}`" :id="`contact_email_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" " @input="handleInput($event.target.value, language, 'contact_email_label', 'updateHomePageSetting')"
                            :value="form['contact_email_label']?.[`contact_email_label_${selectedLanguage}`] ?? ''" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`contact_email_label.contact_email_label_${selectedLanguage}`)" v-text="validationErros.get(`contact_email_label.contact_email_label_${selectedLanguage}`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`contact_email_hint_${selectedLanguage}`">Contact email hint</label>
                        <input type="text" :name="`contact_email_hint_${selectedLanguage}`" :id="`contact_email_hint_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" " @input="handleInput($event.target.value, language, 'contact_email_hint', 'updateHomePageSetting')"
                            :value="form['contact_email_hint']?.[`contact_email_hint_${selectedLanguage}`] ?? ''" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`contact_email_hint.contact_email_hint_${selectedLanguage}`)" v-text="validationErros.get(`contact_email_hint.contact_email_hint_${selectedLanguage}`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`contact_photo_label_${selectedLanguage}`">Contact photo label</label>
                        <input type="text" :name="`contact_photo_label_${selectedLanguage}`" :id="`contact_photo_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" " @input="handleInput($event.target.value, language, 'contact_photo_label', 'updateHomePageSetting')"
                            :value="form['contact_photo_label']?.[`contact_photo_label_${selectedLanguage}`] ?? ''" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`contact_photo_label.contact_photo_label_${selectedLanguage}`)" v-text="validationErros.get(`contact_photo_label.contact_photo_label_${selectedLanguage}`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`contact_photo_tooltip_${selectedLanguage}`">Contact photo tooltip</label>
                        <input type="text" :name="`contact_photo_tooltip_${selectedLanguage}`" :id="`contact_photo_tooltip_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" " @input="handleInput($event.target.value, language, 'contact_photo_tooltip', 'updateHomePageSetting')"
                            :value="form['contact_photo_tooltip']?.[`contact_photo_tooltip_${selectedLanguage}`] ?? ''" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`contact_photo_tooltip.contact_photo_tooltip_${selectedLanguage}`)" v-text="validationErros.get(`contact_photo_tooltip.contact_photo_tooltip_${selectedLanguage}`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`main_event_image_label_${selectedLanguage}`">Main event image label</label>
                        <input type="text" :name="`main_event_image_label_${selectedLanguage}`" :id="`main_event_image_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" " @input="handleInput($event.target.value, language, 'main_event_image_label', 'updateHomePageSetting')"
                            :value="form['main_event_image_label']?.[`main_event_image_label_${selectedLanguage}`] ?? ''" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`main_event_image_label.main_event_image_label_${selectedLanguage}`)" v-text="validationErros.get(`main_event_image_label.main_event_image_label_${selectedLanguage}`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`main_event_image_hint_${selectedLanguage}`">Main event image hint</label>
                        <input type="text" :name="`main_event_image_hint_${selectedLanguage}`" :id="`main_event_image_hint_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" " @input="handleInput($event.target.value, language, 'main_event_image_hint', 'updateHomePageSetting')"
                            :value="form['main_event_image_hint']?.[`main_event_image_hint_${selectedLanguage}`] ?? ''" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`main_event_image_hint.main_event_image_hint_${selectedLanguage}`)" v-text="validationErros.get(`main_event_image_hint.main_event_image_hint_${selectedLanguage}`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`photo_gallery_heading_${selectedLanguage}`">Photo gallery heading</label>
                        <input type="text" :name="`photo_gallery_heading_${selectedLanguage}`" :id="`photo_gallery_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" " @input="handleInput($event.target.value, language, 'photo_gallery_heading', 'updateHomePageSetting')"
                            :value="form['photo_gallery_heading']?.[`photo_gallery_heading_${selectedLanguage}`] ?? ''" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`photo_gallery_heading.photo_gallery_heading_${selectedLanguage}`)" v-text="validationErros.get(`photo_gallery_heading.photo_gallery_heading_${selectedLanguage}`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`photo_gallery_label_${selectedLanguage}`">Photo gallery label</label>
                        <input type="text" :name="`photo_gallery_label_${selectedLanguage}`" :id="`photo_gallery_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" " @input="handleInput($event.target.value, language, 'photo_gallery_label', 'updateHomePageSetting')"
                            :value="form['photo_gallery_label']?.[`photo_gallery_label_${selectedLanguage}`] ?? ''" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`photo_gallery_label.photo_gallery_label_${selectedLanguage}`)" v-text="validationErros.get(`photo_gallery_label.photo_gallery_label_${selectedLanguage}`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`photo_gallery_subtitle_featured_${selectedLanguage}`">Photo gallery subtitle (featured)</label>
                        <input type="text" :name="`photo_gallery_subtitle_featured_${selectedLanguage}`" :id="`photo_gallery_subtitle_featured_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" " @input="handleInput($event.target.value, language, 'photo_gallery_subtitle_featured', 'updateHomePageSetting')"
                            :value="form['photo_gallery_subtitle_featured']?.[`photo_gallery_subtitle_featured_${selectedLanguage}`] ?? ''" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`photo_gallery_subtitle_featured.photo_gallery_subtitle_featured_${selectedLanguage}`)" v-text="validationErros.get(`photo_gallery_subtitle_featured.photo_gallery_subtitle_featured_${selectedLanguage}`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`photo_gallery_subtitle_premium_${selectedLanguage}`">Photo gallery subtitle (premium)</label>
                        <input type="text" :name="`photo_gallery_subtitle_premium_${selectedLanguage}`" :id="`photo_gallery_subtitle_premium_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" " @input="handleInput($event.target.value, language, 'photo_gallery_subtitle_premium', 'updateHomePageSetting')"
                            :value="form['photo_gallery_subtitle_premium']?.[`photo_gallery_subtitle_premium_${selectedLanguage}`] ?? ''" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`photo_gallery_subtitle_premium.photo_gallery_subtitle_premium_${selectedLanguage}`)" v-text="validationErros.get(`photo_gallery_subtitle_premium.photo_gallery_subtitle_premium_${selectedLanguage}`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`update_btn_text_${selectedLanguage}`">Update button text</label>
                        <input type="text" :name="`update_btn_text_${selectedLanguage}`" :id="`update_btn_text_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" " @input="handleInput($event.target.value, language, 'update_btn_text', 'updateHomePageSetting')"
                            :value="form['update_btn_text']?.[`update_btn_text_${selectedLanguage}`] ?? ''" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`update_btn_text.update_btn_text_${selectedLanguage}`)" v-text="validationErros.get(`update_btn_text.update_btn_text_${selectedLanguage}`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`privacy_heading_${selectedLanguage}`">Privacy section heading</label>
                        <input type="text" :name="`privacy_heading_${selectedLanguage}`" :id="`privacy_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" " @input="handleInput($event.target.value, language, 'privacy_heading', 'updateHomePageSetting')"
                            :value="form['privacy_heading']?.[`privacy_heading_${selectedLanguage}`] ?? ''" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`privacy_heading.privacy_heading_${selectedLanguage}`)" v-text="validationErros.get(`privacy_heading.privacy_heading_${selectedLanguage}`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`privacy_bullet_1_${selectedLanguage}`">Privacy bullet 1</label>
                        <input type="text" :name="`privacy_bullet_1_${selectedLanguage}`" :id="`privacy_bullet_1_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" " @input="handleInput($event.target.value, language, 'privacy_bullet_1', 'updateHomePageSetting')"
                            :value="form['privacy_bullet_1']?.[`privacy_bullet_1_${selectedLanguage}`] ?? ''" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`privacy_bullet_1.privacy_bullet_1_${selectedLanguage}`)" v-text="validationErros.get(`privacy_bullet_1.privacy_bullet_1_${selectedLanguage}`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`privacy_bullet_2_${selectedLanguage}`">Privacy bullet 2</label>
                        <input type="text" :name="`privacy_bullet_2_${selectedLanguage}`" :id="`privacy_bullet_2_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" " @input="handleInput($event.target.value, language, 'privacy_bullet_2', 'updateHomePageSetting')"
                            :value="form['privacy_bullet_2']?.[`privacy_bullet_2_${selectedLanguage}`] ?? ''" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`privacy_bullet_2.privacy_bullet_2_${selectedLanguage}`)" v-text="validationErros.get(`privacy_bullet_2.privacy_bullet_2_${selectedLanguage}`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`privacy_bullet_3_${selectedLanguage}`">Privacy bullet 3</label>
                        <input type="text" :name="`privacy_bullet_3_${selectedLanguage}`" :id="`privacy_bullet_3_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" " @input="handleInput($event.target.value, language, 'privacy_bullet_3', 'updateHomePageSetting')"
                            :value="form['privacy_bullet_3']?.[`privacy_bullet_3_${selectedLanguage}`] ?? ''" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`privacy_bullet_3.privacy_bullet_3_${selectedLanguage}`)" v-text="validationErros.get(`privacy_bullet_3.privacy_bullet_3_${selectedLanguage}`)"></p>
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
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`organizer_contact_section_heading_${selectedLanguage}`">Organizer & contact section heading</label>
                        <input type="text" :name="`organizer_contact_section_heading_${selectedLanguage}`"
                            :id="`organizer_contact_section_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="handleInput($event.target.value, language, 'organizer_contact_section_heading', 'updateHomePageSetting')"
                            :value="form['organizer_contact_section_heading']?.[`organizer_contact_section_heading_${selectedLanguage}`] ?? ''" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`organizer_contact_section_heading.organizer_contact_section_heading_${selectedLanguage}`)"
                            v-text="validationErros.get(`organizer_contact_section_heading.organizer_contact_section_heading_${selectedLanguage}`)"></p>
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
                        obj["organizer_website_label_" + res.language_id] = res.organizer_website_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "organizer_website_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["your_profile_heading_" + res.language_id] = res.your_profile_heading;
                    });
                    this.$store.commit("pages/setHomePageSetting", { key: "your_profile_heading", value: obj });
                    obj = {};
                    data.map((res) => {
                        obj["the_organizer_heading_" + res.language_id] = res.the_organizer_heading;
                    });
                    this.$store.commit("pages/setHomePageSetting", { key: "the_organizer_heading", value: obj });
                    obj = {};
                    data.map((res) => {
                        obj["contact_person_heading_" + res.language_id] = res.contact_person_heading;
                    });
                    this.$store.commit("pages/setHomePageSetting", { key: "contact_person_heading", value: obj });
                    obj = {};
                    data.map((res) => {
                        obj["organizer_phone_label_" + res.language_id] = res.organizer_phone_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", { key: "organizer_phone_label", value: obj });
                    obj = {};
                    data.map((res) => {
                        obj["mailing_address_label_" + res.language_id] = res.mailing_address_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", { key: "mailing_address_label", value: obj });
                    obj = {};
                    data.map((res) => {
                        obj["contact_name_label_" + res.language_id] = res.contact_name_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", { key: "contact_name_label", value: obj });
                    obj = {};
                    data.map((res) => {
                        obj["contact_phone_label_" + res.language_id] = res.contact_phone_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", { key: "contact_phone_label", value: obj });
                    obj = {};
                    data.map((res) => {
                        obj["contact_phone_hint_" + res.language_id] = res.contact_phone_hint;
                    });
                    this.$store.commit("pages/setHomePageSetting", { key: "contact_phone_hint", value: obj });
                    obj = {};
                    data.map((res) => {
                        obj["contact_email_label_" + res.language_id] = res.contact_email_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", { key: "contact_email_label", value: obj });
                    obj = {};
                    data.map((res) => {
                        obj["contact_email_hint_" + res.language_id] = res.contact_email_hint;
                    });
                    this.$store.commit("pages/setHomePageSetting", { key: "contact_email_hint", value: obj });
                    obj = {};
                    data.map((res) => {
                        obj["contact_photo_label_" + res.language_id] = res.contact_photo_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", { key: "contact_photo_label", value: obj });
                    obj = {};
                    data.map((res) => {
                        obj["contact_photo_tooltip_" + res.language_id] = res.contact_photo_tooltip;
                    });
                    this.$store.commit("pages/setHomePageSetting", { key: "contact_photo_tooltip", value: obj });
                    obj = {}; data.map((res) => { obj["main_event_image_label_" + res.language_id] = res.main_event_image_label; });
                    this.$store.commit("pages/setHomePageSetting", { key: "main_event_image_label", value: obj });
                    obj = {}; data.map((res) => { obj["main_event_image_hint_" + res.language_id] = res.main_event_image_hint; });
                    this.$store.commit("pages/setHomePageSetting", { key: "main_event_image_hint", value: obj });
                    obj = {}; data.map((res) => { obj["photo_gallery_heading_" + res.language_id] = res.photo_gallery_heading; });
                    this.$store.commit("pages/setHomePageSetting", { key: "photo_gallery_heading", value: obj });
                    obj = {}; data.map((res) => { obj["photo_gallery_label_" + res.language_id] = res.photo_gallery_label; });
                    this.$store.commit("pages/setHomePageSetting", { key: "photo_gallery_label", value: obj });
                    obj = {}; data.map((res) => { obj["photo_gallery_subtitle_featured_" + res.language_id] = res.photo_gallery_subtitle_featured; });
                    this.$store.commit("pages/setHomePageSetting", { key: "photo_gallery_subtitle_featured", value: obj });
                    obj = {}; data.map((res) => { obj["photo_gallery_subtitle_premium_" + res.language_id] = res.photo_gallery_subtitle_premium; });
                    this.$store.commit("pages/setHomePageSetting", { key: "photo_gallery_subtitle_premium", value: obj });
                    obj = {}; data.map((res) => { obj["update_btn_text_" + res.language_id] = res.update_btn_text; });
                    this.$store.commit("pages/setHomePageSetting", { key: "update_btn_text", value: obj });
                    obj = {}; data.map((res) => { obj["privacy_heading_" + res.language_id] = res.privacy_heading; });
                    this.$store.commit("pages/setHomePageSetting", { key: "privacy_heading", value: obj });
                    obj = {}; data.map((res) => { obj["privacy_bullet_1_" + res.language_id] = res.privacy_bullet_1; });
                    this.$store.commit("pages/setHomePageSetting", { key: "privacy_bullet_1", value: obj });
                    obj = {}; data.map((res) => { obj["privacy_bullet_2_" + res.language_id] = res.privacy_bullet_2; });
                    this.$store.commit("pages/setHomePageSetting", { key: "privacy_bullet_2", value: obj });
                    obj = {}; data.map((res) => { obj["privacy_bullet_3_" + res.language_id] = res.privacy_bullet_3; });
                    this.$store.commit("pages/setHomePageSetting", { key: "privacy_bullet_3", value: obj });
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
                        obj["organizer_contact_section_heading_" + res.language_id] = res.organizer_contact_section_heading;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "organizer_contact_section_heading",
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
                validationErros.has(`organizer_website_label.organizer_website_label_${language.id}`) ||
                validationErros.has(`your_profile_heading.your_profile_heading_${language.id}`) ||
                validationErros.has(`the_organizer_heading.the_organizer_heading_${language.id}`) ||
                validationErros.has(`contact_person_heading.contact_person_heading_${language.id}`) ||
                validationErros.has(`organizer_phone_label.organizer_phone_label_${language.id}`) ||
                validationErros.has(`mailing_address_label.mailing_address_label_${language.id}`) ||
                validationErros.has(`contact_name_label.contact_name_label_${language.id}`) ||
                validationErros.has(`contact_phone_label.contact_phone_label_${language.id}`) ||
                validationErros.has(`contact_phone_hint.contact_phone_hint_${language.id}`) ||
                validationErros.has(`contact_email_label.contact_email_label_${language.id}`) ||
                validationErros.has(`contact_email_hint.contact_email_hint_${language.id}`) ||
                validationErros.has(`contact_photo_label.contact_photo_label_${language.id}`) ||
                validationErros.has(`contact_photo_tooltip.contact_photo_tooltip_${language.id}`) ||
                validationErros.has(`main_event_image_label.main_event_image_label_${language.id}`) ||
                validationErros.has(`main_event_image_hint.main_event_image_hint_${language.id}`) ||
                validationErros.has(`photo_gallery_heading.photo_gallery_heading_${language.id}`) ||
                validationErros.has(`photo_gallery_label.photo_gallery_label_${language.id}`) ||
                validationErros.has(`photo_gallery_subtitle_featured.photo_gallery_subtitle_featured_${language.id}`) ||
                validationErros.has(`photo_gallery_subtitle_premium.photo_gallery_subtitle_premium_${language.id}`) ||
                validationErros.has(`update_btn_text.update_btn_text_${language.id}`) ||
                validationErros.has(`privacy_heading.privacy_heading_${language.id}`) ||
                validationErros.has(`privacy_bullet_1.privacy_bullet_1_${language.id}`) ||
                validationErros.has(`privacy_bullet_2.privacy_bullet_2_${language.id}`) ||
                validationErros.has(`privacy_bullet_3.privacy_bullet_3_${language.id}`) ||
                validationErros.has(`email_label.email_label_${language.id}`) ||
                validationErros.has(`email_error.email_error_${language.id}`) ||
                validationErros.has(`password_label.password_label_${language.id}`) ||
                validationErros.has(`password_placeholder.password_placeholder_${language.id}`) ||
                validationErros.has(`password_error.password_error_${language.id}`) ||
                validationErros.has(`confirm_password_label.confirm_password_label_${language.id}`) ||
                validationErros.has(`package_section_heading.package_section_heading_${language.id}`) ||
                validationErros.has(`organizer_contact_section_heading.organizer_contact_section_heading_${language.id}`) ||
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
                    obj["organizer_website_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "organizer_website_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["your_profile_heading_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", { key: "your_profile_heading", value: obj });
                obj = {};
                data.map((res) => {
                    obj["the_organizer_heading_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", { key: "the_organizer_heading", value: obj });
                obj = {};
                data.map((res) => {
                    obj["contact_person_heading_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", { key: "contact_person_heading", value: obj });
                obj = {};
                data.map((res) => {
                    obj["organizer_phone_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", { key: "organizer_phone_label", value: obj });
                obj = {};
                data.map((res) => {
                    obj["mailing_address_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", { key: "mailing_address_label", value: obj });
                obj = {};
                data.map((res) => {
                    obj["contact_name_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", { key: "contact_name_label", value: obj });
                obj = {};
                data.map((res) => {
                    obj["contact_phone_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", { key: "contact_phone_label", value: obj });
                obj = {};
                data.map((res) => {
                    obj["contact_phone_hint_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", { key: "contact_phone_hint", value: obj });
                obj = {};
                data.map((res) => {
                    obj["contact_email_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", { key: "contact_email_label", value: obj });
                obj = {};
                data.map((res) => {
                    obj["contact_email_hint_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", { key: "contact_email_hint", value: obj });
                obj = {};
                data.map((res) => {
                    obj["contact_photo_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", { key: "contact_photo_label", value: obj });
                obj = {};
                data.map((res) => {
                    obj["contact_photo_tooltip_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", { key: "contact_photo_tooltip", value: obj });
                ['main_event_image_label','main_event_image_hint','photo_gallery_heading','photo_gallery_label','photo_gallery_subtitle_featured','photo_gallery_subtitle_premium','update_btn_text','privacy_heading','privacy_bullet_1','privacy_bullet_2','privacy_bullet_3'].forEach(k => {
                    obj = {}; data.map((res) => { obj[k + "_" + res.id] = ""; });
                    this.$store.commit("pages/setHomePageSetting", { key: k, value: obj });
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
                    obj["organizer_contact_section_heading_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "organizer_contact_section_heading",
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
