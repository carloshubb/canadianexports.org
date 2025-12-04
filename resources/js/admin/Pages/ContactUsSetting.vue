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
                                <span class="text-sm font-medium text-gray-500">Contact us page settings</span>
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
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`page_heading_${selectedLanguage}`">Heading for page</label>
                        <input type="text" :name="`page_heading_${selectedLanguage}`"
                            :id="`page_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'page_heading',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['page_heading'] &&
                                form['page_heading'][
                                    `page_heading_${selectedLanguage}`
                                ] ?
                                form['page_heading'][
                                    `page_heading_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `page_heading.page_heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `page_heading.page_heading_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="col-span-6" v-if="isDataLoaded">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`page_description_${language.id}`">Page description</label>
                        <editor
                            @mouseleave="
                                handleSelectionChange(
                                    language,
                                    'page_description',
                                    'updateHomePageSetting'
                                )
                            "
                            @keyup="
                                handleSelectionChange(
                                    language,
                                    'page_description',
                                    'updateHomePageSetting'
                                )
                            "
                            :ref="`page_description_${language.id}`"
                            :id="`page_description_${language.id}`"
                            :initial-value="form[`page_description`][`page_description_${language?.id}`]
                            "
                            :tinymce-script-src="tinymceScriptSrc"
                            :init="editorConfig"
                        />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `page_description.page_description_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `page_description.page_description_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    </div>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 mt-8">
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`mail_address_label_${selectedLanguage}`">Label for mail address</label>
                        <input type="text" :name="`mail_address_label_${selectedLanguage}`"
                            :id="`mail_address_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'mail_address_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['mail_address_label'] &&
                                form['mail_address_label'][
                                    `mail_address_label_${selectedLanguage}`
                                ] ?
                                form['mail_address_label'][
                                    `mail_address_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `mail_address_label.mail_address_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `mail_address_label.mail_address_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`mail_address_${selectedLanguage}`">Mail address</label>
                        <textarea :name="`mail_address_${selectedLanguage}`"
                            :id="`mail_address_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'mail_address',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['mail_address'] &&
                                form['mail_address'][
                                    `mail_address_${selectedLanguage}`
                                ] ?
                                form['mail_address'][
                                    `mail_address_${selectedLanguage}`
                                ] :
                                ''"></textarea>

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `mail_address.mail_address_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `mail_address.mail_address_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`website_label_${selectedLanguage}`">Label for website</label>
                        <input type="text" :name="`website_label_${selectedLanguage}`"
                            :id="`website_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'website_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['website_label'] &&
                                form['website_label'][
                                    `website_label_${selectedLanguage}`
                                ] ?
                                form['website_label'][
                                    `website_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `website_label.website_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `website_label.website_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`website_${selectedLanguage}`">Website</label>
                        <input type="text" :name="`website_${selectedLanguage}`"
                            :id="`website_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'website',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['website'] &&
                                form['website'][
                                    `website_${selectedLanguage}`
                                ] ?
                                form['website'][
                                    `website_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `website.website_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `website.website_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`toll_free_label_${selectedLanguage}`">Label for toll free</label>
                        <input type="text" :name="`toll_free_label_${selectedLanguage}`"
                            :id="`toll_free_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'toll_free_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['toll_free_label'] &&
                                form['toll_free_label'][
                                    `toll_free_label_${selectedLanguage}`
                                ] ?
                                form['toll_free_label'][
                                    `toll_free_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `toll_free_label.toll_free_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `toll_free_label.toll_free_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`toll_free_${selectedLanguage}`">Toll free</label>
                        <input type="text" :name="`toll_free_${selectedLanguage}`"
                            :id="`toll_free_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'toll_free',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['toll_free'] &&
                                form['toll_free'][
                                    `toll_free_${selectedLanguage}`
                                ] ?
                                form['toll_free'][
                                    `toll_free_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `toll_free.toll_free_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `toll_free.toll_free_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`general_inquires_label_${selectedLanguage}`">Label for general inquiry</label>
                        <input type="text" :name="`general_inquires_label_${selectedLanguage}`"
                            :id="`general_inquires_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'general_inquires_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['general_inquires_label'] &&
                                form['general_inquires_label'][
                                    `general_inquires_label_${selectedLanguage}`
                                ] ?
                                form['general_inquires_label'][
                                    `general_inquires_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `general_inquires_label.general_inquires_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `general_inquires_label.general_inquires_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`general_inquires_${selectedLanguage}`">General inquires</label>
                        <input type="text" :name="`general_inquires_${selectedLanguage}`"
                            :id="`general_inquires_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'general_inquires',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['general_inquires'] &&
                                form['general_inquires'][
                                    `general_inquires_${selectedLanguage}`
                                ] ?
                                form['general_inquires'][
                                    `general_inquires_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `general_inquires.general_inquires_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `general_inquires.general_inquires_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`telephone_label_${selectedLanguage}`">Label for telephone</label>
                        <input type="text" :name="`telephone_label_${selectedLanguage}`"
                            :id="`telephone_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'telephone_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['telephone_label'] &&
                                form['telephone_label'][
                                    `telephone_label_${selectedLanguage}`
                                ] ?
                                form['telephone_label'][
                                    `telephone_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `telephone_label.telephone_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `telephone_label.telephone_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`telephone_${selectedLanguage}`">Telephone</label>
                        <input type="text" :name="`telephone_${selectedLanguage}`"
                            :id="`telephone_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'telephone',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['telephone'] &&
                                form['telephone'][
                                    `telephone_${selectedLanguage}`
                                ] ?
                                form['telephone'][
                                    `telephone_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `telephone.telephone_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `telephone.telephone_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`sales_department_label_${selectedLanguage}`">Label for sales department</label>
                        <input type="text" :name="`sales_department_label_${selectedLanguage}`"
                            :id="`sales_department_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'sales_department_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['sales_department_label'] &&
                                form['sales_department_label'][
                                    `sales_department_label_${selectedLanguage}`
                                ] ?
                                form['sales_department_label'][
                                    `sales_department_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `sales_department_label.sales_department_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `sales_department_label.sales_department_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`sales_department_${selectedLanguage}`">Sales department</label>
                        <input type="text" :name="`sales_department_${selectedLanguage}`"
                            :id="`sales_department_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'sales_department',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['sales_department'] &&
                                form['sales_department'][
                                    `sales_department_${selectedLanguage}`
                                ] ?
                                form['sales_department'][
                                    `sales_department_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `sales_department.sales_department_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `sales_department.sales_department_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`fax_label_${selectedLanguage}`">Label for fax</label>
                        <input type="text" :name="`fax_label_${selectedLanguage}`"
                            :id="`fax_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'fax_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['fax_label'] &&
                                form['fax_label'][
                                    `fax_label_${selectedLanguage}`
                                ] ?
                                form['fax_label'][
                                    `fax_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `fax_label.fax_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `fax_label.fax_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`fax_${selectedLanguage}`">Fax</label>
                        <input type="text" :name="`fax_${selectedLanguage}`"
                            :id="`fax_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'fax',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['fax'] &&
                                form['fax'][
                                    `fax_${selectedLanguage}`
                                ] ?
                                form['fax'][
                                    `fax_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `fax.fax_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `fax.fax_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`job_at_canadian_exporters_label_${selectedLanguage}`">Label for jobs at Canadian Exporter</label>
                        <input type="text" :name="`job_at_canadian_exporters_label_${selectedLanguage}`"
                            :id="`job_at_canadian_exporters_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'job_at_canadian_exporters_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['job_at_canadian_exporters_label'] &&
                                form['job_at_canadian_exporters_label'][
                                    `job_at_canadian_exporters_label_${selectedLanguage}`
                                ] ?
                                form['job_at_canadian_exporters_label'][
                                    `job_at_canadian_exporters_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `job_at_canadian_exporters_label.job_at_canadian_exporters_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `job_at_canadian_exporters_label.job_at_canadian_exporters_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`job_at_canadian_exporters_${selectedLanguage}`">Jobs at Canadian Exporter</label>
                        <input type="text" :name="`job_at_canadian_exporters_${selectedLanguage}`"
                            :id="`job_at_canadian_exporters_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'job_at_canadian_exporters',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['job_at_canadian_exporters'] &&
                                form['job_at_canadian_exporters'][
                                    `job_at_canadian_exporters_${selectedLanguage}`
                                ] ?
                                form['job_at_canadian_exporters'][
                                    `job_at_canadian_exporters_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `job_at_canadian_exporters.job_at_canadian_exporters_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `job_at_canadian_exporters.job_at_canadian_exporters_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`e_mail_label_${selectedLanguage}`">Label for email</label>
                        <input type="text" :name="`e_mail_label_${selectedLanguage}`"
                            :id="`e_mail_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'e_mail_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['e_mail_label'] &&
                                form['e_mail_label'][
                                    `e_mail_label_${selectedLanguage}`
                                ] ?
                                form['e_mail_label'][
                                    `e_mail_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `e_mail_label.e_mail_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `e_mail_label.e_mail_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`e_mail_${selectedLanguage}`">Email</label>
                        <input type="text" :name="`e_mail_${selectedLanguage}`"
                            :id="`e_mail_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'e_mail',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['e_mail'] &&
                                form['e_mail'][
                                    `e_mail_${selectedLanguage}`
                                ] ?
                                form['e_mail'][
                                    `e_mail_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `e_mail.e_mail_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `e_mail.e_mail_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`office_hours_label_${selectedLanguage}`">Label for office hours</label>
                        <input type="text" :name="`office_hours_label_${selectedLanguage}`"
                            :id="`office_hours_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'office_hours_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['office_hours_label'] &&
                                form['office_hours_label'][
                                    `office_hours_label_${selectedLanguage}`
                                ] ?
                                form['office_hours_label'][
                                    `office_hours_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `office_hours_label.office_hours_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `office_hours_label.office_hours_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`office_hours_${selectedLanguage}`">Office hours</label>
                        <input type="text" :name="`office_hours_${selectedLanguage}`"
                            :id="`office_hours_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'office_hours',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['office_hours'] &&
                                form['office_hours'][
                                    `office_hours_${selectedLanguage}`
                                ] ?
                                form['office_hours'][
                                    `office_hours_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `office_hours.office_hours_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `office_hours.office_hours_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`heading_${selectedLanguage}`">Get in touch heading</label>
                        <input type="text" :name="`heading_${selectedLanguage}`"
                            :id="`heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'heading',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['heading'] &&
                                form['heading'][
                                    `heading_${selectedLanguage}`
                                ] ?
                                form['heading'][
                                    `heading_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `heading.heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `heading.heading_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`required_field_text_${selectedLanguage}`">Required field text</label>
                        <input type="text" :name="`required_field_text_${selectedLanguage}`"
                            :id="`required_field_text_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'required_field_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['required_field_text'] &&
                                form['required_field_text'][
                                    `required_field_text_${selectedLanguage}`
                                ] ?
                                form['required_field_text'][
                                    `required_field_text_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `required_field_text.required_field_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `required_field_text.required_field_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`name_label_${selectedLanguage}`">Label for name</label>
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
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`message_label_${selectedLanguage}`">Label for message</label>
                        <input type="text" :name="`message_label_${selectedLanguage}`"
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
                            :value="form['message_label'] &&
                                form['message_label'][
                                    `message_label_${selectedLanguage}`
                                ] ?
                                form['message_label'][
                                    `message_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `message_label.message_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `message_label.message_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`message_error_${selectedLanguage}`">Error message for message</label>
                        <input type="text" :name="`message_error_${selectedLanguage}`"
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
                            :value="form['message_error'] &&
                                form['message_error'][
                                    `message_error_${selectedLanguage}`
                                ] ?
                                form['message_error'][
                                    `message_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `message_error.message_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `message_error.message_error_${selectedLanguage}`
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
            collapseStates: [true, false, false, false, false, false, false],
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
                    url: `${process.env.MIX_ADMIN_API_URL}contact-us-setting?withContactUsSettingDetail=1&findByPageId=${this.form.id}`,
                })
                .then((res) => {
                    let data = res.data.data && res.data.data.contact_us_setting_detail
                            ? res.data.data.contact_us_setting_detail
                            : [];

                    let obj = {};
                    data.map((res) => {
                        obj["page_heading_" + res.language_id] = res.page_heading;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "page_heading",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["page_description_" + res.language_id] = res.page_description;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "page_description",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["mail_address_label_" + res.language_id] = res.mail_address_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "mail_address_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["mail_address_" + res.language_id] = res.mail_address;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "mail_address",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["website_label_" + res.language_id] = res.website_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "website_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["website_" + res.language_id] = res.website;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "website",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["toll_free_label_" + res.language_id] = res.toll_free_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "toll_free_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["toll_free_" + res.language_id] = res.toll_free;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "toll_free",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["general_inquires_label_" + res.language_id] = res.general_inquires_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "general_inquires_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["general_inquires_" + res.language_id] = res.general_inquires;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "general_inquires",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["telephone_label_" + res.language_id] = res.telephone_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "telephone_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["telephone_" + res.language_id] = res.telephone;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "telephone",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["sales_department_label_" + res.language_id] = res.sales_department_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "sales_department_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["sales_department_" + res.language_id] = res.sales_department;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "sales_department",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["fax_label_" + res.language_id] = res.fax_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "fax_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["fax_" + res.language_id] = res.fax;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "fax",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["job_at_canadian_exporters_label_" + res.language_id] = res.job_at_canadian_exporters_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "job_at_canadian_exporters_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["job_at_canadian_exporters_" + res.language_id] = res.job_at_canadian_exporters;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "job_at_canadian_exporters",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["e_mail_label_" + res.language_id] = res.e_mail_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "e_mail_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["e_mail_" + res.language_id] = res.e_mail;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "e_mail",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["office_hours_label_" + res.language_id] = res.office_hours_label;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "office_hours_label",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["office_hours_" + res.language_id] = res.office_hours;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "office_hours",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["heading_" + res.language_id] = res.heading;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "heading",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["required_field_text_" + res.language_id] = res.required_field_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "required_field_text",
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
                        obj["button_text_" + res.language_id] = res.button_text;
                    });
                    this.$store.commit("pages/setHomePageSetting", {
                        key: "button_text",
                        value: obj,
                    });
                    this.isDataLoaded = 1;
                });
        },
        checkValidationError(validationErros, language) {
            return (
                validationErros.has(`page_heading.page_heading_${language.id}`) ||
                validationErros.has(`page_description.page_description_${language.id}`) ||
                validationErros.has(`mail_address_label.mail_address_label_${language.id}`) ||
                validationErros.has(`mail_address.mail_address_${language.id}`) ||
                validationErros.has(`website_label.website_label_${language.id}`) ||
                validationErros.has(`website.website_${language.id}`) ||
                validationErros.has(`toll_free_label.toll_free_label_${language.id}`) ||
                validationErros.has(`toll_free.toll_free_${language.id}`) ||
                validationErros.has(`general_inquires_label.general_inquires_label_${language.id}`) ||
                validationErros.has(`general_inquires.general_inquires_${language.id}`) ||
                validationErros.has(`telephone_label.telephone_label_${language.id}`) ||
                validationErros.has(`telephone.telephone_${language.id}`) ||
                validationErros.has(`sales_department_label.sales_department_label_${language.id}`) ||
                validationErros.has(`sales_department.sales_department_${language.id}`) ||
                validationErros.has(`fax_label.fax_label_${language.id}`) ||
                validationErros.has(`fax.fax_${language.id}`) ||
                validationErros.has(`job_at_canadian_exporters_label.job_at_canadian_exporters_label_${language.id}`) ||
                validationErros.has(`job_at_canadian_exporters.job_at_canadian_exporters_${language.id}`) ||
                validationErros.has(`e_mail_label.e_mail_label_${language.id}`) ||
                validationErros.has(`e_mail.e_mail_${language.id}`) ||
                validationErros.has(`office_hours_label.office_hours_label_${language.id}`) ||
                validationErros.has(`office_hours.office_hours_${language.id}`) ||
                validationErros.has(`heading.heading_${language.id}`) ||
                validationErros.has(`required_field_text.required_field_text_${language.id}`) ||
                validationErros.has(`name_label.name_label_${language.id}`) ||
                validationErros.has(`name_error.name_error_${language.id}`) ||
                validationErros.has(`email_label.email_label_${language.id}`) ||
                validationErros.has(`email_error.email_error_${language.id}`) ||
                validationErros.has(`message_label.message_label_${language.id}`) ||
                validationErros.has(`message_error.message_error_${language.id}`) ||
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
                    obj["page_heading_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "page_heading",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["page_description_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "page_description",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["mail_address_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "mail_address_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["mail_address_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "mail_address",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["website_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "website_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["website_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "website",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["toll_free_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "toll_free_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["toll_free_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "toll_free",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["general_inquires_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "general_inquires_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["general_inquires_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "general_inquires",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["telephone_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "telephone_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["telephone_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "telephone",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["sales_department_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "sales_department_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["sales_department_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "sales_department",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["fax_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "fax_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["fax_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "fax",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["job_at_canadian_exporters_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "job_at_canadian_exporters_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["job_at_canadian_exporters_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "job_at_canadian_exporters",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["e_mail_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "e_mail_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["e_mail_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "e_mail",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["office_hours_label_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "office_hours_label",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["office_hours_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "office_hours",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["heading_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "heading",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["required_field_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "required_field_text",
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
                    obj["button_text_" + res.id] = "";
                });
                this.$store.commit("pages/setHomePageSetting", {
                    key: "button_text",
                    value: obj,
                });

                if(this.$route.params.id){
                    this.fetchPageSetting();
                }
                else{
                    this.isDataLoaded = 1;
                }
            });
    },
};
</script>
