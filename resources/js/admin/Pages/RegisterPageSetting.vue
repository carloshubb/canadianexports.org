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
                                <span class="text-sm font-medium">Header section</span>
                                <span class="text-sm font-medium text-gray-500">Page heading & informative text</span>
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
            <div class="p-4 bg-gray-50 border-t" v-if="collapseStates[0]">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    <div class="col-span-6" v-if="isDataLoaded">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`page_title_${selectedLanguage}`">Title of the page</label>
                        <editor
                            @mouseleave="
                                handleSelectionChange(
                                    language,
                                    'page_title',
                                    'updateHomePageSetting'
                                )
                            "
                            @keyup="
                                handleSelectionChange(
                                    language,
                                    'page_title',
                                    'updateHomePageSetting'
                                )
                            "
                            :ref="`page_title_${language.id}`"
                            :id="`page_title_${language.id}`"
                            :initial-value="form[`page_title`][`page_title_${language?.id}`]
                            "
                            :tinymce-script-src="tinymceScriptSrc"
                            :init="editorConfig"
                        />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `page_title.page_title_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `page_title.page_title_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>

                    <div class="col-span-6" v-if="isDataLoaded">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`page_description_${selectedLanguage}`">Description for registration page</label>
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
            </div>
        </div>
        <div class="border rounded w-full mt-8" :class="collapseStates[1] ? 'bg-blue-50' : ''">
            <div class="lg:border-b lg:border-t lg:border-gray-200 cursor-pointer" @click.prevent="collapseStates[1] = !collapseStates[1]">
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
                                <span class="text-sm font-medium">Step 1 packages section</span>
                                <span class="text-sm font-medium text-gray-500">Registration packages step 1 section settings</span>
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
            <div class="p-4 bg-gray-50 border-t" v-if="collapseStates[1]">
                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_1_heading_${selectedLanguage}`">Section heading</label>
                        <input type="text" :name="`step_1_heading_${selectedLanguage}`"
                            :id="`step_1_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'step_1_heading',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="form['step_1_heading'] &&
                                form['step_1_heading'][
                                    `step_1_heading_${selectedLanguage}`
                                ] ?
                                form['step_1_heading'][
                                    `step_1_heading_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_1_heading.step_1_heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_1_heading.step_1_heading_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_1_acc_heading_${selectedLanguage}`">Registration package heading</label>
                        <input type="text" :name="`step_1_acc_heading_${selectedLanguage}`"
                            :id="`step_1_acc_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'step_1_acc_heading',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="form['step_1_acc_heading'] &&
                                form['step_1_acc_heading'][
                                    `step_1_acc_heading_${selectedLanguage}`
                                ] ?
                                form['step_1_acc_heading'][
                                    `step_1_acc_heading_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_1_acc_heading.step_1_acc_heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_1_acc_heading.step_1_acc_heading_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    </div>
                    <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 mt-4">
                    <div class="col-span-6">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_1_acc_description_${selectedLanguage}`">Section description</label>
                        <input type="text" :name="`step_1_acc_description_${selectedLanguage}`"
                            :id="`step_1_acc_description_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'step_1_acc_description',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="form['step_1_acc_description'] &&
                                form['step_1_acc_description'][
                                    `step_1_acc_description_${selectedLanguage}`
                                ] ?
                                form['step_1_acc_description'][
                                    `step_1_acc_description_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_1_acc_description.step_1_acc_description_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_1_acc_description.step_1_acc_description_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    </div>
                    <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 mt-4">
                    <div class="col-span-6 sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step1_free_pkg_text_${selectedLanguage}`">Free package text</label>
                        <input type="text" :name="`step1_free_pkg_text_${selectedLanguage}`"
                            :id="`step1_free_pkg_text_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'step1_free_pkg_text',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="form['step1_free_pkg_text'] &&
                                form['step1_free_pkg_text'][
                                    `step1_free_pkg_text_${selectedLanguage}`
                                ] ?
                                form['step1_free_pkg_text'][
                                    `step1_free_pkg_text_${selectedLanguage}`
                                ] :
                                ''" />


                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step1_free_pkg_text.step1_free_pkg_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step1_free_pkg_text.step1_free_pkg_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step1_feature_pkg_text_${selectedLanguage}`">Feature package text</label>
                        <input type="text" :name="`step1_feature_pkg_text_${selectedLanguage}`"
                            :id="`step1_feature_pkg_text_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'step1_feature_pkg_text',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="form['step1_feature_pkg_text'] &&
                                form['step1_feature_pkg_text'][
                                    `step1_feature_pkg_text_${selectedLanguage}`
                                ] ?
                                form['step1_feature_pkg_text'][
                                    `step1_feature_pkg_text_${selectedLanguage}`
                                ] :
                                ''" />


                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step1_feature_pkg_text.step1_feature_pkg_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step1_feature_pkg_text.step1_feature_pkg_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step1_premium_pkg_text_${selectedLanguage}`">Premium package text</label>
                        <input type="text" :name="`step1_premium_pkg_text_${selectedLanguage}`"
                            :id="`step1_premium_pkg_text_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'step1_premium_pkg_text',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="form['step1_premium_pkg_text'] &&
                                form['step1_premium_pkg_text'][
                                    `step1_premium_pkg_text_${selectedLanguage}`
                                ] ?
                                form['step1_premium_pkg_text'][
                                    `step1_premium_pkg_text_${selectedLanguage}`
                                ] :
                                ''" />


                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step1_premium_pkg_text.step1_premium_pkg_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step1_premium_pkg_text.step1_premium_pkg_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>

                    <div class="col-span-6 sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_1_auto_renew_label_${selectedLanguage}`">Auto renew label</label>
                        <input type="text" :name="`step_1_auto_renew_label_${selectedLanguage}`"
                            :id="`step_1_auto_renew_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'step_1_auto_renew_label',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="form['step_1_auto_renew_label'] &&
                                form['step_1_auto_renew_label'][
                                    `step_1_auto_renew_label_${selectedLanguage}`
                                ] ?
                                form['step_1_auto_renew_label'][
                                    `step_1_auto_renew_label_${selectedLanguage}`
                                ] :
                                ''" />


                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_1_auto_renew_label.step_1_auto_renew_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_1_auto_renew_label.step_1_auto_renew_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="col-span-6" v-if="isDataLoaded">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_1_description_${selectedLanguage}`">Section description</label>
                        <editor
                            @mouseleave="
                                handleSelectionChange(
                                    language,
                                    'step_1_description',
                                    'updateHomePageSetting'
                                )
                            "
                            @keyup="
                                handleSelectionChange(
                                    language,
                                    'step_1_description',
                                    'updateHomePageSetting'
                                )
                            "
                            :ref="`step_1_description_${language.id}`"
                            :id="`step_1_description_${language.id}`"
                            :initial-value="form[`step_1_description`][`step_1_description_${language?.id}`]
                            "
                            :tinymce-script-src="tinymceScriptSrc"
                            :init="editorConfig"
                        />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_1_description.step_1_description_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_1_description.step_1_description_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="border rounded w-full mt-8" :class="collapseStates[2] ? 'bg-blue-50' : ''">
            <div class="lg:border-b lg:border-t lg:border-gray-200 cursor-pointer" @click.prevent="collapseStates[2] = !collapseStates[2]">
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
                                <span class="text-sm font-medium">Step 2 profile section</span>
                                <span class="text-sm font-medium text-gray-500">User profile step 2 section settings</span>
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
            <div class="p-4 bg-gray-50 border-t" v-if="collapseStates[2]">
                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_2_heading_${selectedLanguage}`">Section heading</label>
                        <input type="text" :name="`step_2_heading_${selectedLanguage}`"
                            :id="`step_2_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'step_2_heading',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="form['step_2_heading'] &&
                                form['step_2_heading'][
                                    `step_2_heading_${selectedLanguage}`
                                ] ?
                                form['step_2_heading'][
                                    `step_2_heading_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_2_heading.step_2_heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_2_heading.step_2_heading_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_2_acc_heading_${selectedLanguage}`">User profile heading</label>
                            <input type="text" :name="`step_2_acc_heading_${selectedLanguage}`"
                                :id="`step_2_acc_heading_${selectedLanguage}`"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                                placeholder=" "
                                @input="
                                    handleInput(
                                        $event.target.value,
                                        language,
                                        'step_2_acc_heading',
                                        'updateHomePageSetting'
                                    )
                                "
                                :value="form['step_2_acc_heading'] &&
                                    form['step_2_acc_heading'][
                                        `step_2_acc_heading_${selectedLanguage}`
                                    ] ?
                                    form['step_2_acc_heading'][
                                        `step_2_acc_heading_${selectedLanguage}`
                                    ] :
                                    ''" />

                            <p class="mt-2 text-sm text-red-400"
                                v-if="
                                    validationErros.has(
                                        `step_2_acc_heading.step_2_acc_heading_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `step_2_acc_heading.step_2_acc_heading_${selectedLanguage}`
                                    )
                                ">
                            </p>
                        </div>
                        <div class="col-span-6" v-if="isDataLoaded">
                            <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_2_acc_description_${selectedLanguage}`">User profile description</label>
                            <editor
                                @mouseleave="
                                    handleSelectionChange(
                                        language,
                                        'step_2_acc_description',
                                        'updateHomePageSetting'
                                    )
                                "
                                @keyup="
                                    handleSelectionChange(
                                        language,
                                        'step_2_acc_description',
                                        'updateHomePageSetting'
                                    )
                                "
                                :ref="`step_2_acc_description_${language.id}`"
                                :id="`step_2_acc_description_${language.id}`"
                                :initial-value="form[`step_2_acc_description`][`step_2_acc_description_${language?.id}`]
                                "
                                :tinymce-script-src="tinymceScriptSrc"
                                :init="editorConfig"
                            />

                            <p class="mt-2 text-sm text-red-400"
                                v-if="
                                    validationErros.has(
                                        `step_2_acc_description.step_2_acc_description_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `step_2_acc_description.step_2_acc_description_${selectedLanguage}`
                                    )
                                ">
                            </p>
                        </div>
                    </div>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 mt-4">
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_2_name_label_${selectedLanguage}`">Label for name</label>
                        <input type="text" :name="`step_2_name_label_${selectedLanguage}`"
                            :id="`step_2_name_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_2_name_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_2_name_label'] &&
                                form['step_2_name_label'][
                                    `step_2_name_label_${selectedLanguage}`
                                ] ?
                                form['step_2_name_label'][
                                    `step_2_name_label_${selectedLanguage}`
                                ] :
                                ''" />


                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_2_name_label.step_2_name_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_2_name_label.step_2_name_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_2_name_error_${selectedLanguage}`">Error message for name</label>
                        <input type="text" :name="`step_2_name_error_${selectedLanguage}`"
                            :id="`step_2_name_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_2_name_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_2_name_error'] &&
                                form['step_2_name_error'][
                                    `step_2_name_error_${selectedLanguage}`
                                ] ?
                                form['step_2_name_error'][
                                    `step_2_name_error_${selectedLanguage}`
                                ] :
                                ''" />


                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_2_name_error.step_2_name_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_2_name_error.step_2_name_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_2_name_placeholder_${selectedLanguage}`">Placeholder for name</label>
                        <input type="text" :name="`step_2_name_placeholder_${selectedLanguage}`"
                            :id="`step_2_name_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_2_name_placeholder',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_2_name_placeholder'] &&
                                form['step_2_name_placeholder'][
                                    `step_2_name_placeholder_${selectedLanguage}`
                                ] ?
                                form['step_2_name_placeholder'][
                                    `step_2_name_placeholder_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_2_name_placeholder.step_2_name_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_2_name_placeholder.step_2_name_placeholder_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_2_email_label_${selectedLanguage}`">Label for email</label>
                        <input type="text" :name="`step_2_email_label_${selectedLanguage}`"
                            :id="`step_2_email_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_2_email_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_2_email_label'] &&
                                form['step_2_email_label'][
                                    `step_2_email_label_${selectedLanguage}`
                                ] ?
                                form['step_2_email_label'][
                                    `step_2_email_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_2_email_label.step_2_email_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_2_email_label.step_2_email_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_2_email_error_${selectedLanguage}`">Error message for email</label>
                        <input type="text" :name="`step_2_email_error_${selectedLanguage}`"
                            :id="`step_2_email_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_2_email_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_2_email_error'] &&
                                form['step_2_email_error'][
                                    `step_2_email_error_${selectedLanguage}`
                                ] ?
                                form['step_2_email_error'][
                                    `step_2_email_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_2_email_error.step_2_email_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_2_email_error.step_2_email_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_2_email_placeholder_${selectedLanguage}`">Placeholder for email</label>
                        <input type="text" :name="`step_2_email_placeholder_${selectedLanguage}`"
                            :id="`step_2_email_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_2_email_placeholder',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_2_email_placeholder'] &&
                                form['step_2_email_placeholder'][
                                    `step_2_email_placeholder_${selectedLanguage}`
                                ] ?
                                form['step_2_email_placeholder'][
                                    `step_2_email_placeholder_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_2_email_placeholder.step_2_email_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_2_email_placeholder.step_2_email_placeholder_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_2_password_label_${selectedLanguage}`">Label for password</label>
                        <input type="text" :name="`step_2_password_label_${selectedLanguage}`"
                            :id="`step_2_password_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_2_password_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_2_password_label'] &&
                                form['step_2_password_label'][
                                    `step_2_password_label_${selectedLanguage}`
                                ] ?
                                form['step_2_password_label'][
                                    `step_2_password_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_2_password_label.step_2_password_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_2_password_label.step_2_password_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_2_password_error_${selectedLanguage}`">Error message for password</label>
                        <input type="text" :name="`step_2_password_error_${selectedLanguage}`"
                            :id="`step_2_password_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_2_password_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_2_password_error'] &&
                                form['step_2_password_error'][
                                    `step_2_password_error_${selectedLanguage}`
                                ] ?
                                form['step_2_password_error'][
                                    `step_2_password_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_2_password_error.step_2_password_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_2_password_error.step_2_password_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_2_password_placeholder_${selectedLanguage}`">Placeholder for
                            password</label>
                        <input type="text" :name="`step_2_password_placeholder_${selectedLanguage}`"
                            :id="`step_2_password_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_2_password_placeholder',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_2_password_placeholder'] &&
                                form['step_2_password_placeholder'][
                                    `step_2_password_placeholder_${selectedLanguage}`
                                ] ?
                                form['step_2_password_placeholder'][
                                    `step_2_password_placeholder_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_2_password_placeholder.step_2_password_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_2_password_placeholder.step_2_password_placeholder_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_2_confirm_password_label_${selectedLanguage}`">Label for confirm
                            password</label>
                        <input type="text" :name="`step_2_confirm_password_label_${selectedLanguage}`"
                            :id="`step_2_confirm_password_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_2_confirm_password_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_2_confirm_password_label'] &&
                                form['step_2_confirm_password_label'][
                                    `step_2_confirm_password_label_${selectedLanguage}`
                                ] ?
                                form['step_2_confirm_password_label'][
                                    `step_2_confirm_password_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_2_confirm_password_label.step_2_confirm_password_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_2_confirm_password_label.step_2_confirm_password_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_2_confirm_password_error_${selectedLanguage}`">Error message for confirm
                            password</label>
                        <input type="text" :name="`step_2_confirm_password_error_${selectedLanguage}`"
                            :id="`step_2_confirm_password_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_2_confirm_password_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_2_confirm_password_error'] &&
                                form['step_2_confirm_password_error'][
                                    `step_2_confirm_password_error_${selectedLanguage}`
                                ] ?
                                form['step_2_confirm_password_error'][
                                    `step_2_confirm_password_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_2_confirm_password_error.step_2_confirm_password_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_2_confirm_password_error.step_2_confirm_password_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_2_confirm_password_placeholder_${selectedLanguage}`">Placeholder for confirm
                            password</label>
                        <input type="text" :name="`step_2_confirm_password_placeholder_${selectedLanguage}`"
                            :id="`step_2_confirm_password_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_2_confirm_password_placeholder',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_2_confirm_password_placeholder'] &&
                                form['step_2_confirm_password_placeholder'][
                                    `step_2_confirm_password_placeholder_${selectedLanguage}`
                                ] ?
                                form['step_2_confirm_password_placeholder'][
                                    `step_2_confirm_password_placeholder_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_2_confirm_password_placeholder.step_2_confirm_password_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_2_confirm_password_placeholder.step_2_confirm_password_placeholder_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_2_profile_image_label_${selectedLanguage}`">Label for profile image</label>
                        <input type="text" :name="`step_2_profile_image_label_${selectedLanguage}`"
                            :id="`step_2_profile_image_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_2_profile_image_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_2_profile_image_label'] &&
                                form['step_2_profile_image_label'][
                                    `step_2_profile_image_label_${selectedLanguage}`
                                ] ?
                                form['step_2_profile_image_label'][
                                    `step_2_profile_image_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_2_profile_image_label.step_2_profile_image_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_2_profile_image_label.step_2_profile_image_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_2_profile_image_placeholder_${selectedLanguage}`">Placeholder for profile image</label>
                        <input type="text" :name="`step_2_profile_image_placeholder_${selectedLanguage}`"
                            :id="`step_2_profile_image_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_2_profile_image_placeholder',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_2_profile_image_placeholder'] &&
                                form['step_2_profile_image_placeholder'][
                                    `step_2_profile_image_placeholder_${selectedLanguage}`
                                ] ?
                                form['step_2_profile_image_placeholder'][
                                    `step_2_profile_image_placeholder_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_2_profile_image_placeholder.step_2_profile_image_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_2_profile_image_placeholder.step_2_profile_image_placeholder_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_2_profile_image_error_${selectedLanguage}`">Error for profile image</label>
                        <input type="text" :name="`step_2_profile_image_error_${selectedLanguage}`"
                            :id="`step_2_profile_image_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_2_profile_image_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_2_profile_image_error'] &&
                                form['step_2_profile_image_error'][
                                    `step_2_profile_image_error_${selectedLanguage}`
                                ] ?
                                form['step_2_profile_image_error'][
                                    `step_2_profile_image_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_2_profile_image_error.step_2_profile_image_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_2_profile_image_error.step_2_profile_image_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>

                </div>
            </div>
        </div>

        <div class="border rounded w-full mt-8" :class="collapseStates[3] ? 'bg-blue-50' : ''">
            <div class="lg:border-b lg:border-t lg:border-gray-200 cursor-pointer" @click.prevent="collapseStates[3] = !collapseStates[3]">
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
                                <span class="text-sm font-medium">Step 3 business categories section</span>
                                <span class="text-sm font-medium text-gray-500">Business categories step 3 section settings</span>
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
            <div class="p-4 bg-gray-50 border-t" v-if="collapseStates[3]">
                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="col-span-6">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_3_heading_${selectedLanguage}`">Section heading</label>
                        <input type="text" :name="`step_3_heading_${selectedLanguage}`"
                            :id="`step_3_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'step_3_heading',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="form['step_3_heading'] &&
                                form['step_3_heading'][
                                    `step_3_heading_${selectedLanguage}`
                                ] ?
                                form['step_3_heading'][
                                    `step_3_heading_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_3_heading.step_3_heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_3_heading.step_3_heading_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="col-span-6" v-if="isDataLoaded">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_3_description_${selectedLanguage}`">Section description</label>
                        <editor
                            @mouseleave="
                                handleSelectionChange(
                                    language,
                                    'step_3_description',
                                    'updateHomePageSetting'
                                )
                            "
                            @keyup="
                                handleSelectionChange(
                                    language,
                                    'step_3_description',
                                    'updateHomePageSetting'
                                )
                            "
                            :ref="`step_3_description_${language.id}`"
                            :id="`step_3_description_${language.id}`"
                            :initial-value="form[`step_3_description`][`step_3_description_${language?.id}`]
                            "
                            :tinymce-script-src="tinymceScriptSrc"
                            :init="editorConfig"
                        />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_3_description.step_3_description_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_3_description.step_3_description_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                </div>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 mt-4">
                        <div>
                            <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_3_acc_heading_${selectedLanguage}`">Business categories heading</label>
                            <input type="text" :name="`step_3_acc_heading_${selectedLanguage}`"
                                :id="`step_3_acc_heading_${selectedLanguage}`"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                                placeholder=" "
                                @input="
                                    handleInput(
                                        $event.target.value,
                                        language,
                                        'step_3_acc_heading',
                                        'updateHomePageSetting'
                                    )
                                "
                                :value="form['step_3_acc_heading'] &&
                                    form['step_3_acc_heading'][
                                        `step_3_acc_heading_${selectedLanguage}`
                                    ] ?
                                    form['step_3_acc_heading'][
                                        `step_3_acc_heading_${selectedLanguage}`
                                    ] :
                                    ''" />

                            <p class="mt-2 text-sm text-red-400"
                                v-if="
                                    validationErros.has(
                                        `step_3_acc_heading.step_3_acc_heading_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `step_3_acc_heading.step_3_acc_heading_${selectedLanguage}`
                                    )
                                ">
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_3_business_categories_label_${selectedLanguage}`">Label for business
                                categories</label>
                            <input type="text" :name="`step_3_business_categories_label_${selectedLanguage}`"
                                :id="`step_3_business_categories_label_${selectedLanguage}`"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                                placeholder=" "
                                @input="
                                    handleInput(
                                        $event.target.value,
                                        language,
                                        'step_3_business_categories_label',
                                        'updateHomePageSetting'
                                    )
                                "
                                :value="form['step_3_business_categories_label'] &&
                                    form['step_3_business_categories_label'][
                                        `step_3_business_categories_label_${selectedLanguage}`
                                    ] ?
                                    form['step_3_business_categories_label'][
                                        `step_3_business_categories_label_${selectedLanguage}`
                                    ] :
                                    ''" />

                            <p class="mt-2 text-sm text-red-400"
                                v-if="
                                    validationErros.has(
                                        `step_3_business_categories_label.step_3_business_categories_label_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `step_3_business_categories_label.step_3_business_categories_label_${selectedLanguage}`
                                    )
                                ">
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_3_business_categories_error_${selectedLanguage}`">Error for business
                                categories</label>
                            <input type="text" :name="`step_3_business_categories_error_${selectedLanguage}`"
                                :id="`step_3_business_categories_error_${selectedLanguage}`"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                                placeholder=" "
                                @input="
                                    handleInput(
                                        $event.target.value,
                                        language,
                                        'step_3_business_categories_error',
                                        'updateHomePageSetting'
                                    )
                                "
                                :value="form['step_3_business_categories_error'] &&
                                    form['step_3_business_categories_error'][
                                        `step_3_business_categories_error_${selectedLanguage}`
                                    ] ?
                                    form['step_3_business_categories_error'][
                                        `step_3_business_categories_error_${selectedLanguage}`
                                    ] :
                                    ''" />

                            <p class="mt-2 text-sm text-red-400"
                                v-if="
                                    validationErros.has(
                                        `step_3_business_categories_error.step_3_business_categories_error_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `step_3_business_categories_error.step_3_business_categories_error_${selectedLanguage}`
                                    )
                                ">
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border rounded w-full mt-8" :class="collapseStates[4] ? 'bg-blue-50' : ''">
                <div class="lg:border-b lg:border-t lg:border-gray-200 cursor-pointer" @click.prevent="collapseStates[4] = !collapseStates[4]">
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
                                <span class="text-sm font-medium">Step 4 business profile section</span>
                                <span class="text-sm font-medium text-gray-500">Business profile step 3 section settings</span>
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
            <div class="p-4 bg-gray-50 border-t" v-if="collapseStates[4]">
                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_heading_${selectedLanguage}`">Section heading</label>
                        <input type="text" :name="`step_4_heading_${selectedLanguage}`"
                            :id="`step_4_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'step_4_heading',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="form['step_4_heading'] &&
                                form['step_4_heading'][
                                    `step_4_heading_${selectedLanguage}`
                                ] ?
                                form['step_4_heading'][
                                    `step_4_heading_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_4_heading.step_4_heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_4_heading.step_4_heading_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_acc_heading_${selectedLanguage}`">Business profile heading</label>
                        <input type="text" :name="`step_4_acc_heading_${selectedLanguage}`"
                            :id="`step_4_acc_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'step_4_acc_heading',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="form['step_4_acc_heading'] &&
                                form['step_4_acc_heading'][
                                    `step_4_acc_heading_${selectedLanguage}`
                                ] ?
                                form['step_4_acc_heading'][
                                    `step_4_acc_heading_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_4_acc_heading.step_4_acc_heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_4_acc_heading.step_4_acc_heading_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_name_label_${selectedLanguage}`">Label for name</label>
                        <input type="text" :name="`step_4_name_label_${selectedLanguage}`"
                            :id="`step_4_name_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_4_name_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_4_name_label'] &&
                                form['step_4_name_label'][
                                    `step_4_name_label_${selectedLanguage}`
                                ] ?
                                form['step_4_name_label'][
                                    `step_4_name_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_4_name_label.step_4_name_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_4_name_label.step_4_name_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_name_error_${selectedLanguage}`">Error message for name</label>
                        <input type="text" :name="`step_4_name_error_${selectedLanguage}`"
                            :id="`step_4_name_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_4_name_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_4_name_error'] &&
                                form['step_4_name_error'][
                                    `step_4_name_error_${selectedLanguage}`
                                ] ?
                                form['step_4_name_error'][
                                    `step_4_name_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_4_name_error.step_4_name_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_4_name_error.step_4_name_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_name_placeholder_${selectedLanguage}`">Pleaceholder for name</label>
                        <input type="text" :name="`step_4_name_placeholder_${selectedLanguage}`"
                            :id="`step_4_name_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_4_name_placeholder',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_4_name_placeholder'] &&
                                form['step_4_name_placeholder'][
                                    `step_4_name_placeholder_${selectedLanguage}`
                                ] ?
                                form['step_4_name_placeholder'][
                                    `step_4_name_placeholder_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_4_name_placeholder.step_4_name_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_4_name_placeholder.step_4_name_placeholder_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_email_label_${selectedLanguage}`">Label for email</label>
                        <input type="text" :name="`step_4_email_label_${selectedLanguage}`"
                            :id="`step_4_email_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_4_email_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_4_email_label'] &&
                                form['step_4_email_label'][
                                    `step_4_email_label_${selectedLanguage}`
                                ] ?
                                form['step_4_email_label'][
                                    `step_4_email_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_4_email_label.step_4_email_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_4_email_label.step_4_email_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_cta_link_${selectedLanguage}`">Label for CTA link</label>
                        <input type="text" :name="`step_4_cta_link_label_${selectedLanguage}`"
                            :id="`step_4_cta_link_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_4_cta_link_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_4_cta_link_label'] &&
                                form['step_4_cta_link_label'][
                                    `step_4_cta_link_label_${selectedLanguage}`
                                ] ?
                                form['step_4_cta_link_label'][
                                    `step_4_cta_link_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_4_cta_link_label.step_4_cta_link_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_4_cta_link_label.step_4_cta_link_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_cta_btn_label_${selectedLanguage}`">Label for CTA button</label>
                        <input type="text" :name="`step_4_cta_btn_label_${selectedLanguage}`"
                            :id="`step_4_cta_btn_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_4_cta_btn_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_4_cta_btn_label'] &&
                                form['step_4_cta_btn_label'][
                                    `step_4_cta_btn_label_${selectedLanguage}`
                                ] ?
                                form['step_4_cta_btn_label'][
                                    `step_4_cta_btn_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_4_cta_btn_label.step_4_cta_btn_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_4_cta_btn_label.step_4_cta_btn_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_email_error_${selectedLanguage}`">Error message for email</label>
                        <input type="text" :name="`step_4_email_error_${selectedLanguage}`"
                            :id="`step_4_email_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_4_email_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_4_email_error'] &&
                                form['step_4_email_error'][
                                    `step_4_email_error_${selectedLanguage}`
                                ] ?
                                form['step_4_email_error'][
                                    `step_4_email_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_4_email_error.step_4_email_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_4_email_error.step_4_email_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_cta_btn_error_${selectedLanguage}`">Error message for cta btn</label>
                        <input type="text" :name="`step_4_cta_btn_error_${selectedLanguage}`"
                            :id="`step_4_cta_btn_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_4_cta_btn_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_4_cta_btn_error'] &&
                                form['step_4_cta_btn_error'][
                                    `step_4_cta_btn_error_${selectedLanguage}`
                                ] ?
                                form['step_4_cta_btn_error'][
                                    `step_4_cta_btn_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_4_cta_btn_error.step_4_cta_btn_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_4_email_cta_btn.step_4_cta_btn_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_cta_link_error_${selectedLanguage}`">Error message for cta link</label>
                        <input type="text" :name="`step_4_cta_link_error_${selectedLanguage}`"
                            :id="`step_4_cta_link_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_4_cta_link_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_4_cta_link_error'] &&
                                form['step_4_cta_link_error'][
                                    `step_4_cta_link_error_${selectedLanguage}`
                                ] ?
                                form['step_4_cta_link_error'][
                                    `step_4_cta_link_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_4_cta_btn_error.step_4_cta_link_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_4_email_cta_btn.step_4_cta_link_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_email_placeholder_${selectedLanguage}`">Placeholder for email</label>
                        <input type="text" :name="`step_4_email_placeholder_${selectedLanguage}`"
                            :id="`step_4_email_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_4_email_placeholder',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_4_email_placeholder'] &&
                                form['step_4_email_placeholder'][
                                    `step_4_email_placeholder_${selectedLanguage}`
                                ] ?
                                form['step_4_email_placeholder'][
                                    `step_4_email_placeholder_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_4_email_placeholder.step_4_email_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_4_email_placeholder.step_4_email_placeholder_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_cta_btn_placeholder_${selectedLanguage}`">Placeholder for cta btn</label>
                        <input type="text" :name="`step_4_cta_btn_placeholder_${selectedLanguage}`"
                            :id="`step_4_cta_btn_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_4_cta_btn_placeholder',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_4_cta_btn_placeholder'] &&
                                form['step_4_cta_btn_placeholder'][
                                    `step_4_cta_btn_placeholder_${selectedLanguage}`
                                ] ?
                                form['step_4_cta_btn_placeholder'][
                                    `step_4_cta_btn_placeholder_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_4_cta_btn_placeholder.step_4_cta_btn_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_4_cta_btn_placeholder.step_4_cta_btn_placeholder_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_cta_link_placeholder_${selectedLanguage}`">Placeholder for cta link</label>
                        <input type="text" :name="`step_4_cta_link_placeholder_${selectedLanguage}`"
                            :id="`step_4_cta_link_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_4_cta_link_placeholder',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_4_cta_link_placeholder'] &&
                                form['step_4_cta_link_placeholder'][
                                    `step_4_cta_link_placeholder_${selectedLanguage}`
                                ] ?
                                form['step_4_cta_link_placeholder'][
                                    `step_4_cta_link_placeholder_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_4_cta_link_placeholder.step_4_cta_link_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_4_cta_link_placeholder.step_4_cta_link_placeholder_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_address_label_${selectedLanguage}`">Label for address</label>
                        <input type="text" :name="`step_4_address_label_${selectedLanguage}`"
                            :id="`step_4_address_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_4_address_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_4_address_label'] &&
                                form['step_4_address_label'][
                                    `step_4_address_label_${selectedLanguage}`
                                ] ?
                                form['step_4_address_label'][
                                    `step_4_address_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_4_address_label.step_4_address_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_4_address_label.step_4_address_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_address_error_${selectedLanguage}`">Error message for address</label>
                        <input type="text" :name="`step_4_address_error_${selectedLanguage}`"
                            :id="`step_4_address_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_4_address_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_4_address_error'] &&
                                form['step_4_address_error'][
                                    `step_4_address_error_${selectedLanguage}`
                                ] ?
                                form['step_4_address_error'][
                                    `step_4_address_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_4_address_error.step_4_address_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_4_address_error.step_4_address_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_address_placeholder_${selectedLanguage}`">Placeholder for address</label>
                        <input type="text" :name="`step_4_address_placeholder_${selectedLanguage}`"
                            :id="`step_4_address_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_4_address_placeholder',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_4_address_placeholder'] &&
                                form['step_4_address_placeholder'][
                                    `step_4_address_placeholder_${selectedLanguage}`
                                ] ?
                                form['step_4_address_placeholder'][
                                    `step_4_address_placeholder_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_4_address_placeholder.step_4_address_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_4_address_placeholder.step_4_address_placeholder_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_phone_label_${selectedLanguage}`">Label for phone</label>
                        <input type="text" :name="`step_4_phone_label_${selectedLanguage}`"
                            :id="`step_4_phone_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_4_phone_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_4_phone_label'] &&
                                form['step_4_phone_label'][
                                    `step_4_phone_label_${selectedLanguage}`
                                ] ?
                                form['step_4_phone_label'][
                                    `step_4_phone_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_4_phone_label.step_4_phone_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_4_phone_label.step_4_phone_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_phone_error_${selectedLanguage}`">Error message for phone</label>
                        <input type="text" :name="`step_4_phone_error_${selectedLanguage}`"
                            :id="`step_4_phone_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_4_phone_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_4_phone_error'] &&
                                form['step_4_phone_error'][
                                    `step_4_phone_error_${selectedLanguage}`
                                ] ?
                                form['step_4_phone_error'][
                                    `step_4_phone_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_4_phone_error.step_4_phone_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_4_phone_error.step_4_phone_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_phone_placeholder_${selectedLanguage}`">Placeholder for phone</label>
                        <input type="text" :name="`step_4_phone_placeholder_${selectedLanguage}`"
                            :id="`step_4_phone_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_4_phone_placeholder',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_4_phone_placeholder'] &&
                                form['step_4_phone_placeholder'][
                                    `step_4_phone_placeholder_${selectedLanguage}`
                                ] ?
                                form['step_4_phone_placeholder'][
                                    `step_4_phone_placeholder_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_4_phone_placeholder.step_4_phone_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_4_phone_placeholder.step_4_phone_placeholder_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_website_label_${selectedLanguage}`">Label for website</label>
                        <input type="text" :name="`step_4_website_label_${selectedLanguage}`"
                            :id="`step_4_website_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_4_website_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_4_website_label'] &&
                                form['step_4_website_label'][
                                    `step_4_website_label_${selectedLanguage}`
                                ] ?
                                form['step_4_website_label'][
                                    `step_4_website_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_4_website_label.step_4_website_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_4_website_label.step_4_website_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_website_error_${selectedLanguage}`">Error message for website</label>
                        <input type="text" :name="`step_4_website_error_${selectedLanguage}`"
                            :id="`step_4_website_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_4_website_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_4_website_error'] &&
                                form['step_4_website_error'][
                                    `step_4_website_error_${selectedLanguage}`
                                ] ?
                                form['step_4_website_error'][
                                    `step_4_website_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_4_website_error.step_4_website_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_4_website_error.step_4_website_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_website_placeholder_${selectedLanguage}`">Placeholder for website</label>
                        <input type="text" :name="`step_4_website_placeholder_${selectedLanguage}`"
                            :id="`step_4_website_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_4_website_placeholder',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_4_website_placeholder'] &&
                                form['step_4_website_placeholder'][
                                    `step_4_website_placeholder_${selectedLanguage}`
                                ] ?
                                form['step_4_website_placeholder'][
                                    `step_4_website_placeholder_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_4_website_placeholder.step_4_website_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_4_website_placeholder.step_4_website_placeholder_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    </div>
                    <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 mt-4">
                        <div class="sm:col-span-3">
                            <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_short_description_label_${selectedLanguage}`">Label for short description</label>
                            <input type="text" :name="`step_4_short_description_label_${selectedLanguage}`"
                                :id="`step_4_short_description_label_${selectedLanguage}`"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                                placeholder=" "
                                @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'step_4_short_description_label',
                                    'updateHomePageSetting'
                                )
                            "
                                :value="form['step_4_short_description_label'] &&
                                    form['step_4_short_description_label'][
                                        `step_4_short_description_label_${selectedLanguage}`
                                    ] ?
                                    form['step_4_short_description_label'][
                                        `step_4_short_description_label_${selectedLanguage}`
                                    ] :
                                    ''" />

                            <p class="mt-2 text-sm text-red-400"
                                v-if="
                                    validationErros.has(
                                        `step_4_short_description_label.step_4_short_description_label_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `step_4_short_description_label.step_4_short_description_label_${selectedLanguage}`
                                    )
                                ">
                            </p>
                        </div>
                        <div class="sm:col-span-3">
                            <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_short_description_error_${selectedLanguage}`">Error message for short description</label>
                            <input type="text" :name="`step_4_short_description_error_${selectedLanguage}`"
                                :id="`step_4_short_description_error_${selectedLanguage}`"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                                placeholder=" "
                                @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'step_4_short_description_error',
                                    'updateHomePageSetting'
                                )
                            "
                                :value="form['step_4_short_description_error'] &&
                                    form['step_4_short_description_error'][
                                        `step_4_short_description_error_${selectedLanguage}`
                                    ] ?
                                    form['step_4_short_description_error'][
                                        `step_4_short_description_error_${selectedLanguage}`
                                    ] :
                                    ''" />

                            <p class="mt-2 text-sm text-red-400"
                                v-if="
                                    validationErros.has(
                                        `step_4_short_description_error.step_4_short_description_error_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `step_4_short_description_error.step_4_short_description_error_${selectedLanguage}`
                                    )
                                ">
                            </p>
                        </div>
                        <div class="sm:col-span-6">
                            <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_short_description_placeholder_${selectedLanguage}`">Placeholder for short description</label>
                                <textarea
                                name="step_4_short_description_placeholder"
                                id="step_4_short_description_placeholder"
                                rows="4"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                                placeholder=" "
                                @input="
                                    handleInput(
                                        $event.target.value,
                                        language,
                                        'step_4_short_description_placeholder',
                                    'updateHomePageSetting'
                                    )
                                "
                                v-text="
                                    form['step_4_short_description_placeholder'] &&
                                    form['step_4_short_description_placeholder'][
                                        `step_4_short_description_placeholder_${selectedLanguage}`
                                    ]
                                        ? form['step_4_short_description_placeholder'][
                                            `step_4_short_description_placeholder_${selectedLanguage}`
                                        ]
                                        : ''
                                "
                            ></textarea>
                            <p class="mt-2 text-sm text-red-400"
                                v-if="
                                    validationErros.has(
                                        `step_4_short_description_placeholder.step_4_short_description_placeholder_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `step_4_short_description_placeholder.step_4_short_description_placeholder_${selectedLanguage}`
                                    )
                                ">
                            </p>
                        </div>
                    <div class="sm:col-span-3">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_description_label_${selectedLanguage}`">Label for description</label>
                        <input type="text" :name="`step_4_description_label_${selectedLanguage}`"
                            :id="`step_4_description_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_4_description_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_4_description_label'] &&
                                form['step_4_description_label'][
                                    `step_4_description_label_${selectedLanguage}`
                                ] ?
                                form['step_4_description_label'][
                                    `step_4_description_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_4_description_label.step_4_description_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_4_description_label.step_4_description_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_description_error_${selectedLanguage}`">Error message for description</label>
                        <input type="text" :name="`step_4_description_error_${selectedLanguage}`"
                            :id="`step_4_description_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_4_description_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_4_description_error'] &&
                                form['step_4_description_error'][
                                    `step_4_description_error_${selectedLanguage}`
                                ] ?
                                form['step_4_description_error'][
                                    `step_4_description_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_4_description_error.step_4_description_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_4_description_error.step_4_description_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-6">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_description_placeholder_${selectedLanguage}`">Placeholder for description</label>
                            <textarea
                            name="step_4_description_placeholder"
                            id="step_4_description_placeholder"
                            rows="4"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'step_4_description_placeholder',
                                'updateHomePageSetting'
                                )
                            "
                            v-text="
                                form['step_4_description_placeholder'] &&
                                form['step_4_description_placeholder'][
                                    `step_4_description_placeholder_${selectedLanguage}`
                                ]
                                    ? form['step_4_description_placeholder'][
                                        `step_4_description_placeholder_${selectedLanguage}`
                                    ]
                                    : ''
                            "
                        ></textarea>

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_4_description_placeholder.step_4_description_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_4_description_placeholder.step_4_description_placeholder_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_keywords_label_${selectedLanguage}`">Label for keywords</label>
                        <input type="text" :name="`step_4_keywords_label_${selectedLanguage}`"
                            :id="`step_4_keywords_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_4_keywords_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_4_keywords_label'] &&
                                form['step_4_keywords_label'][
                                    `step_4_keywords_label_${selectedLanguage}`
                                ] ?
                                form['step_4_keywords_label'][
                                    `step_4_keywords_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_4_keywords_label.step_4_keywords_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_4_keywords_label.step_4_keywords_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_keywords_error_${selectedLanguage}`">Error message for keywords</label>
                        <input type="text" :name="`step_4_keywords_error_${selectedLanguage}`"
                            :id="`step_4_keywords_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_4_keywords_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_4_keywords_error'] &&
                                form['step_4_keywords_error'][
                                    `step_4_keywords_error_${selectedLanguage}`
                                ] ?
                                form['step_4_keywords_error'][
                                    `step_4_keywords_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_4_keywords_error.step_4_keywords_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_4_keywords_error.step_4_keywords_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="sm:col-span-6">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_4_keywords_placeholder_${selectedLanguage}`">Placeholder for keywords</label>
                        <textarea
                            name="step_4_keywords_placeholder"
                            id="step_4_keywords_placeholder"
                            rows="4"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'step_4_keywords_placeholder',
                                'updateHomePageSetting'
                                )
                            "
                            v-text="
                                form['step_4_keywords_placeholder'] &&
                                form['step_4_keywords_placeholder'][
                                    `step_4_keywords_placeholder_${selectedLanguage}`
                                ]
                                    ? form['step_4_keywords_placeholder'][
                                        `step_4_keywords_placeholder_${selectedLanguage}`
                                    ]
                                    : ''
                            "
                        ></textarea>

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_4_keywords_placeholder.step_4_keywords_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_4_keywords_placeholder.step_4_keywords_placeholder_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    </div>

                </div>
                </div>

        <div class="border rounded w-full mt-8" :class="collapseStates[5] ? 'bg-blue-50' : ''">
            <div class="lg:border-b lg:border-t lg:border-gray-200 cursor-pointer" @click.prevent="collapseStates[5] = !collapseStates[5]">
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
                                <span class="text-sm font-medium">Media section</span>
                                <span class="text-sm font-medium text-gray-500">Media section settings</span>
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
            <div class="p-4 bg-gray-50 border-t" v-if="collapseStates[5]">
                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_5_heading_${selectedLanguage}`">Section heading</label>
                        <input type="text" :name="`step_5_heading_${selectedLanguage}`"
                            :id="`step_5_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'step_5_heading',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="form['step_5_heading'] &&
                                form['step_5_heading'][
                                    `step_5_heading_${selectedLanguage}`
                                ] ?
                                form['step_5_heading'][
                                    `step_5_heading_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_5_heading.step_5_heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_5_heading.step_5_heading_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_5_acc_heading_${selectedLanguage}`">Heading</label>
                        <input type="text" :name="`step_5_acc_heading_${selectedLanguage}`"
                            :id="`step_5_acc_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'step_5_acc_heading',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="form['step_5_acc_heading'] &&
                                form['step_5_acc_heading'][
                                    `step_5_acc_heading_${selectedLanguage}`
                                ] ?
                                form['step_5_acc_heading'][
                                    `step_5_acc_heading_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_5_acc_heading.step_5_acc_heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_5_acc_heading.step_5_acc_heading_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="col-span-6">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`pre_media_tab_description_${selectedLanguage}`">Section introduction text</label>
                        <textarea
                            name="pre_media_tab_description"
                            id="pre_media_tab_description"
                            rows="4"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'pre_media_tab_description',
                                'updateHomePageSetting'
                                )
                            "
                            v-text="
                                form['pre_media_tab_description'] &&
                                form['pre_media_tab_description'][
                                    `pre_media_tab_description_${selectedLanguage}`
                                ]
                                    ? form['pre_media_tab_description'][
                                          `pre_media_tab_description_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        ></textarea>

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `pre_media_tab_description.pre_media_tab_description_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `pre_media_tab_description.pre_media_tab_description_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 mt-4">
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_5_title_label_${selectedLanguage}`">Title label</label>
                        <input type="text" :name="`step_5_title_label_${selectedLanguage}`"
                            :id="`step_5_title_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_5_title_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_5_title_label'] &&
                                form['step_5_title_label'][
                                    `step_5_title_label_${selectedLanguage}`
                                ] ?
                                form['step_5_title_label'][
                                    `step_5_title_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_5_title_label.step_5_title_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_5_title_label.step_5_title_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_5_title_error_${selectedLanguage}`">Title error</label>
                        <input type="text" :name="`step_5_title_error_${selectedLanguage}`"
                            :id="`step_5_title_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_5_title_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_5_title_error'] &&
                                form['step_5_title_error'][
                                    `step_5_title_error_${selectedLanguage}`
                                ] ?
                                form['step_5_title_error'][
                                    `step_5_title_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_5_title_error.step_5_title_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_5_title_error.step_5_title_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="col-span-6">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_5_title_placeholder_${selectedLanguage}`">Title placeholder</label>
                        <textarea
                            name="step_5_title_placeholder"
                            id="step_5_title_placeholder"
                            rows="4"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'step_5_title_placeholder',
                                'updateHomePageSetting'
                                )
                            "
                            v-text="
                                form['step_5_title_placeholder'] &&
                                form['step_5_title_placeholder'][
                                    `step_5_title_placeholder_${selectedLanguage}`
                                ]
                                    ? form['step_5_title_placeholder'][
                                          `step_5_title_placeholder_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        ></textarea>

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_5_title_placeholder.step_5_title_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_5_title_placeholder.step_5_title_placeholder_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 mt-4">
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_5_description_label_${selectedLanguage}`">Description label</label>
                        <input type="text" :name="`step_5_description_label_${selectedLanguage}`"
                            :id="`step_5_description_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_5_description_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_5_description_label'] &&
                                form['step_5_description_label'][
                                    `step_5_description_label_${selectedLanguage}`
                                ] ?
                                form['step_5_description_label'][
                                    `step_5_description_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_5_description_label.step_5_description_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_5_description_label.step_5_description_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_5_description_error_${selectedLanguage}`">Description error</label>
                        <input type="text" :name="`step_5_description_error_${selectedLanguage}`"
                            :id="`step_5_description_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_5_description_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_5_description_error'] &&
                                form['step_5_description_error'][
                                    `step_5_description_error_${selectedLanguage}`
                                ] ?
                                form['step_5_description_error'][
                                    `step_5_description_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_5_description_error.step_5_description_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_5_description_error.step_5_description_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="col-span-6">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_5_description_placeholder_${selectedLanguage}`">Description placeholder</label>
                        <textarea
                            name="step_5_description_placeholder"
                            id="step_5_description_placeholder"
                            rows="4"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'step_5_description_placeholder',
                                'updateHomePageSetting'
                                )
                            "
                            v-text="
                                form['step_5_description_placeholder'] &&
                                form['step_5_description_placeholder'][
                                    `step_5_description_placeholder_${selectedLanguage}`
                                ]
                                    ? form['step_5_description_placeholder'][
                                          `step_5_description_placeholder_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        ></textarea>

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_5_description_placeholder.step_5_description_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_5_description_placeholder.step_5_description_placeholder_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 mt-4">
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_5_logo_label_${selectedLanguage}`">Logo label</label>
                        <input type="text" :name="`step_5_logo_label_${selectedLanguage}`"
                            :id="`step_5_logo_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_5_logo_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_5_logo_label'] &&
                                form['step_5_logo_label'][
                                    `step_5_logo_label_${selectedLanguage}`
                                ] ?
                                form['step_5_logo_label'][
                                    `step_5_logo_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_5_logo_label.step_5_logo_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_5_logo_label.step_5_logo_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_5_logo_error_${selectedLanguage}`">Logo error</label>
                        <input type="text" :name="`step_5_logo_error_${selectedLanguage}`"
                            :id="`step_5_logo_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_5_logo_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_5_logo_error'] &&
                                form['step_5_logo_error'][
                                    `step_5_logo_error_${selectedLanguage}`
                                ] ?
                                form['step_5_logo_error'][
                                    `step_5_logo_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_5_logo_error.step_5_logo_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_5_logo_error.step_5_logo_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_5_logo_placeholder_${selectedLanguage}`">Logo placeholder</label>
                        <input type="text" :name="`step_5_logo_placeholder_${selectedLanguage}`"
                            :id="`step_5_logo_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_5_logo_placeholder',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_5_logo_placeholder'] &&
                                form['step_5_logo_placeholder'][
                                    `step_5_logo_placeholder_${selectedLanguage}`
                                ] ?
                                form['step_5_logo_placeholder'][
                                    `step_5_logo_placeholder_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_5_logo_placeholder.step_5_logo_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_5_logo_placeholder.step_5_logo_placeholder_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_5_video_label_${selectedLanguage}`">Video label</label>
                        <input type="text" :name="`step_5_video_label_${selectedLanguage}`"
                            :id="`step_5_video_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_5_video_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_5_video_label'] &&
                                form['step_5_video_label'][
                                    `step_5_video_label_${selectedLanguage}`
                                ] ?
                                form['step_5_video_label'][
                                    `step_5_video_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_5_video_label.step_5_video_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_5_video_label.step_5_video_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_5_video_error_${selectedLanguage}`">Video error</label>
                        <input type="text" :name="`step_5_video_error_${selectedLanguage}`"
                            :id="`step_5_video_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_5_video_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_5_video_error'] &&
                                form['step_5_video_error'][
                                    `step_5_video_error_${selectedLanguage}`
                                ] ?
                                form['step_5_video_error'][
                                    `step_5_video_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_5_video_error.step_5_video_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_5_video_error.step_5_video_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_5_video_placeholder_${selectedLanguage}`">Video placeholder</label>
                        <input type="text" :name="`step_5_video_placeholder_${selectedLanguage}`"
                            :id="`step_5_video_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_5_video_placeholder',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_5_video_placeholder'] &&
                                form['step_5_video_placeholder'][
                                    `step_5_video_placeholder_${selectedLanguage}`
                                ] ?
                                form['step_5_video_placeholder'][
                                    `step_5_video_placeholder_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_5_video_placeholder.step_5_video_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_5_video_placeholder.step_5_video_placeholder_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_5_gallery_image_label_${selectedLanguage}`">Gallery images label</label>
                        <input type="text" :name="`step_5_gallery_image_label_${selectedLanguage}`"
                            :id="`step_5_gallery_image_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_5_gallery_image_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_5_gallery_image_label'] &&
                                form['step_5_gallery_image_label'][
                                    `step_5_gallery_image_label_${selectedLanguage}`
                                ] ?
                                form['step_5_gallery_image_label'][
                                    `step_5_gallery_image_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_5_gallery_image_label.step_5_gallery_image_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_5_gallery_image_label.step_5_gallery_image_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_5_gallery_image_placeholder_${selectedLanguage}`">Gallery images placeholder</label>
                        <input type="text" :name="`step_5_gallery_image_placeholder_${selectedLanguage}`"
                            :id="`step_5_gallery_image_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_5_gallery_image_placeholder',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_5_gallery_image_placeholder'] &&
                                form['step_5_gallery_image_placeholder'][
                                    `step_5_gallery_image_placeholder_${selectedLanguage}`
                                ] ?
                                form['step_5_gallery_image_placeholder'][
                                    `step_5_gallery_image_placeholder_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_5_gallery_image_placeholder.step_5_gallery_image_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_5_gallery_image_placeholder.step_5_gallery_image_placeholder_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_5_gallery_image_error_${selectedLanguage}`">Gallery images error</label>
                        <input type="text" :name="`step_5_gallery_image_error_${selectedLanguage}`"
                            :id="`step_5_gallery_image_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_5_gallery_image_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_5_gallery_image_error'] &&
                                form['step_5_gallery_image_error'][
                                    `step_5_gallery_image_error_${selectedLanguage}`
                                ] ?
                                form['step_5_gallery_image_error'][
                                    `step_5_gallery_image_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_5_gallery_image_error.step_5_gallery_image_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_5_gallery_image_error.step_5_gallery_image_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>

                </div>
            </div>
        </div>

        <div class="border rounded w-full mt-8" :class="collapseStates[6] ? 'bg-gray-50' : ''">
            <div class="lg:border-b lg:border-t lg:border-gray-200 cursor-pointer" @click.prevent="collapseStates[6] = !collapseStates[6]">
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
                                <span class="text-sm font-medium">Social media section</span>
                                <span class="text-sm font-medium text-gray-500">Social media section settings</span>
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
            <div class="p-4 bg-gray-50 border-t" v-if="collapseStates[6]">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_6_heading_${selectedLanguage}`">Heading</label>
                        <input type="text" :name="`step_6_heading_${selectedLanguage}`"
                            :id="`step_6_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'step_6_heading',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="form['step_6_heading'] &&
                                form['step_6_heading'][
                                    `step_6_heading_${selectedLanguage}`
                                ] ?
                                form['step_6_heading'][
                                    `step_6_heading_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_6_heading.step_6_heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_6_heading.step_6_heading_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_6_acc_heading_${selectedLanguage}`">Heading</label>
                        <input type="text" :name="`step_6_acc_heading_${selectedLanguage}`"
                            :id="`step_6_acc_heading_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'step_6_acc_heading',
                                    'updateHomePageSetting'
                                )
                            "
                            :value="form['step_6_acc_heading'] &&
                                form['step_6_acc_heading'][
                                    `step_6_acc_heading_${selectedLanguage}`
                                ] ?
                                form['step_6_acc_heading'][
                                    `step_6_acc_heading_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_6_acc_heading.step_6_acc_heading_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_6_acc_heading.step_6_acc_heading_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_6_facebook_label_${selectedLanguage}`">Facebook label</label>
                        <input type="text" :name="`step_6_facebook_label_${selectedLanguage}`"
                            :id="`step_6_facebook_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_6_facebook_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_6_facebook_label'] &&
                                form['step_6_facebook_label'][
                                    `step_6_facebook_label_${selectedLanguage}`
                                ] ?
                                form['step_6_facebook_label'][
                                    `step_6_facebook_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_6_facebook_label.step_6_facebook_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_6_facebook_label.step_6_facebook_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_6_facebook_error_${selectedLanguage}`">Facebook error</label>
                        <input type="text" :name="`step_6_facebook_error_${selectedLanguage}`"
                            :id="`step_6_facebook_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_6_facebook_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_6_facebook_error'] &&
                                form['step_6_facebook_error'][
                                    `step_6_facebook_error_${selectedLanguage}`
                                ] ?
                                form['step_6_facebook_error'][
                                    `step_6_facebook_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_6_facebook_error.step_6_facebook_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_6_facebook_error.step_6_facebook_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_6_facebook_placeholder_${selectedLanguage}`">Facebook placeholder</label>
                        <input type="text" :name="`step_6_facebook_placeholder_${selectedLanguage}`"
                            :id="`step_6_facebook_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_6_facebook_placeholder',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_6_facebook_placeholder'] &&
                                form['step_6_facebook_placeholder'][
                                    `step_6_facebook_placeholder_${selectedLanguage}`
                                ] ?
                                form['step_6_facebook_placeholder'][
                                    `step_6_facebook_placeholder_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_6_facebook_placeholder.step_6_facebook_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_6_facebook_placeholder.step_6_facebook_placeholder_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_6_twitter_label_${selectedLanguage}`">Twitter label</label>
                        <input type="text" :name="`step_6_twitter_label_${selectedLanguage}`"
                            :id="`step_6_twitter_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_6_twitter_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_6_twitter_label'] &&
                                form['step_6_twitter_label'][
                                    `step_6_twitter_label_${selectedLanguage}`
                                ] ?
                                form['step_6_twitter_label'][
                                    `step_6_twitter_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_6_twitter_label.step_6_twitter_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_6_twitter_label.step_6_twitter_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_6_twitter_error_${selectedLanguage}`">Twitter error</label>
                        <input type="text" :name="`step_6_twitter_error_${selectedLanguage}`"
                            :id="`step_6_twitter_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_6_twitter_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_6_twitter_error'] &&
                                form['step_6_twitter_error'][
                                    `step_6_twitter_error_${selectedLanguage}`
                                ] ?
                                form['step_6_twitter_error'][
                                    `step_6_twitter_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_6_twitter_error.step_6_twitter_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_6_twitter_error.step_6_twitter_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_6_twitter_placeholder_${selectedLanguage}`">Twitter placeholder</label>
                        <input type="text" :name="`step_6_twitter_placeholder_${selectedLanguage}`"
                            :id="`step_6_twitter_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_6_twitter_placeholder',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_6_twitter_placeholder'] &&
                                form['step_6_twitter_placeholder'][
                                    `step_6_twitter_placeholder_${selectedLanguage}`
                                ] ?
                                form['step_6_twitter_placeholder'][
                                    `step_6_twitter_placeholder_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_6_twitter_placeholder.step_6_twitter_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_6_twitter_placeholder.step_6_twitter_placeholder_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_6_youtube_label_${selectedLanguage}`">Youtube label</label>
                        <input type="text" :name="`step_6_youtube_label_${selectedLanguage}`"
                            :id="`step_6_youtube_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_6_youtube_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_6_youtube_label'] &&
                                form['step_6_youtube_label'][
                                    `step_6_youtube_label_${selectedLanguage}`
                                ] ?
                                form['step_6_youtube_label'][
                                    `step_6_youtube_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_6_youtube_label.step_6_youtube_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_6_youtube_label.step_6_youtube_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_6_youtube_error_${selectedLanguage}`">Youtube error</label>
                        <input type="text" :name="`step_6_youtube_error_${selectedLanguage}`"
                            :id="`step_6_youtube_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_6_youtube_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_6_youtube_error'] &&
                                form['step_6_youtube_error'][
                                    `step_6_youtube_error_${selectedLanguage}`
                                ] ?
                                form['step_6_youtube_error'][
                                    `step_6_youtube_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_6_youtube_error.step_6_youtube_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_6_youtube_error.step_6_youtube_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_6_youtube_placeholder_${selectedLanguage}`">Youtube placeholder</label>
                        <input type="text" :name="`step_6_youtube_placeholder_${selectedLanguage}`"
                            :id="`step_6_youtube_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_6_youtube_placeholder',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_6_youtube_placeholder'] &&
                                form['step_6_youtube_placeholder'][
                                    `step_6_youtube_placeholder_${selectedLanguage}`
                                ] ?
                                form['step_6_youtube_placeholder'][
                                    `step_6_youtube_placeholder_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_6_youtube_placeholder.step_6_youtube_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_6_youtube_placeholder.step_6_youtube_placeholder_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_6_linkedin_label_${selectedLanguage}`">Linkedin label</label>
                        <input type="text" :name="`step_6_linkedin_label_${selectedLanguage}`"
                            :id="`step_6_linkedin_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_6_linkedin_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_6_linkedin_label'] &&
                                form['step_6_linkedin_label'][
                                    `step_6_linkedin_label_${selectedLanguage}`
                                ] ?
                                form['step_6_linkedin_label'][
                                    `step_6_linkedin_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_6_linkedin_label.step_6_linkedin_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_6_linkedin_label.step_6_linkedin_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_6_linkedin_error_${selectedLanguage}`">Linkedin error</label>
                        <input type="text" :name="`step_6_linkedin_error_${selectedLanguage}`"
                            :id="`step_6_linkedin_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_6_linkedin_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_6_linkedin_error'] &&
                                form['step_6_linkedin_error'][
                                    `step_6_linkedin_error_${selectedLanguage}`
                                ] ?
                                form['step_6_linkedin_error'][
                                    `step_6_linkedin_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_6_linkedin_error.step_6_linkedin_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_6_linkedin_error.step_6_linkedin_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_6_linkedin_placeholder_${selectedLanguage}`">Linkedin placeholder</label>
                        <input type="text" :name="`step_6_linkedin_placeholder_${selectedLanguage}`"
                            :id="`step_6_linkedin_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_6_linkedin_placeholder',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_6_linkedin_placeholder'] &&
                                form['step_6_linkedin_placeholder'][
                                    `step_6_linkedin_placeholder_${selectedLanguage}`
                                ] ?
                                form['step_6_linkedin_placeholder'][
                                    `step_6_linkedin_placeholder_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_6_linkedin_placeholder.step_6_linkedin_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_6_linkedin_placeholder.step_6_linkedin_placeholder_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>

                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_6_social_media5_label_${selectedLanguage}`">Social media-5 label</label>
                        <input type="text" :name="`step_6_social_media5_label_${selectedLanguage}`"
                            :id="`step_6_social_media5_label_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_6_social_media5_label',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_6_social_media5_label'] &&
                                form['step_6_social_media5_label'][
                                    `step_6_social_media5_label_${selectedLanguage}`
                                ] ?
                                form['step_6_social_media5_label'][
                                    `step_6_social_media5_label_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_6_social_media5_label.step_6_social_media5_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_6_social_media5_label.step_6_social_media5_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_6_social_media5_placeholder_${selectedLanguage}`">Social media-5 placeholder</label>
                        <input type="text" :name="`step_6_social_media5_placeholder_${selectedLanguage}`"
                            :id="`step_6_social_media5_placeholder_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_6_social_media5_placeholder',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_6_social_media5_placeholder'] &&
                                form['step_6_social_media5_placeholder'][
                                    `step_6_social_media5_placeholder_${selectedLanguage}`
                                ] ?
                                form['step_6_social_media5_placeholder'][
                                    `step_6_social_media5_placeholder_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_6_social_media5_placeholder.step_6_social_media5_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_6_social_media5_placeholder.step_6_social_media5_placeholder_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`step_6_social_media5_error_${selectedLanguage}`">Social media-5 Error</label>
                        <input type="text" :name="`step_6_social_media5_error_${selectedLanguage}`"
                            :id="`step_6_social_media5_error_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'step_6_social_media5_error',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['step_6_social_media5_error'] &&
                                form['step_6_social_media5_error'][
                                    `step_6_social_media5_error_${selectedLanguage}`
                                ] ?
                                form['step_6_social_media5_error'][
                                    `step_6_social_media5_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `step_6_social_media5_error.step_6_social_media5_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `step_6_social_media5_error.step_6_social_media5_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>

                </div>
            </div>
        </div>
        <div class="border rounded w-full mt-8" :class="collapseStates[7] ? 'bg-blue-50' : ''">
            <div class="lg:border-b lg:border-t lg:border-gray-200 cursor-pointer" @click.prevent="collapseStates[7] = !collapseStates[7]">
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
                                <span class="text-sm font-medium text-gray-500">General sign up page settings</span>
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
            <div class="p-4 bg-gray-50 border-t" v-if="collapseStates[7]">
                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`greeting_text_${selectedLanguage}`">Greeting text (Welcome back)</label>
                        <input type="text" :name="`greeting_text_${selectedLanguage}`"
                            :id="`greeting_text_${selectedLanguage}`"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" "
                            @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'greeting_text',
                                'updateHomePageSetting'
                            )
                        "
                            :value="form['greeting_text'] &&
                                form['greeting_text'][
                                    `greeting_text_${selectedLanguage}`
                                ] ?
                                form['greeting_text'][
                                    `greeting_text_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `greeting_text.greeting_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `greeting_text.greeting_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`terms_and_conditions_error_${selectedLanguage}`">Terms & conditions
                            error</label>
                        <input type="text" :name="`terms_and_conditions_error_${selectedLanguage}`"
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
                            :value="form['terms_and_conditions_error'] &&
                                form['terms_and_conditions_error'][
                                    `terms_and_conditions_error_${selectedLanguage}`
                                ] ?
                                form['terms_and_conditions_error'][
                                    `terms_and_conditions_error_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `terms_and_conditions_error.terms_and_conditions_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `terms_and_conditions_error.terms_and_conditions_error_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`submit_button_text_${selectedLanguage}`">Submit button text</label>
                        <input type="text" :name="`submit_button_text_${selectedLanguage}`"
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
                            :value="form['submit_button_text'] &&
                                form['submit_button_text'][
                                    `submit_button_text_${selectedLanguage}`
                                ] ?
                                form['submit_button_text'][
                                    `submit_button_text_${selectedLanguage}`
                                ] :
                                ''" />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `submit_button_text.submit_button_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `submit_button_text.submit_button_text_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="col-span-6" v-if="isDataLoaded">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`terms_and_conditions_label_${selectedLanguage}`">Terms & conditions
                            label</label>
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

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `terms_and_conditions_label.terms_and_conditions_label_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `terms_and_conditions_label.terms_and_conditions_label_${selectedLanguage}`
                                )
                            ">
                        </p>
                    </div>
                    <div class="col-span-6" v-if="isDataLoaded">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="`footer_text_${selectedLanguage}`">Footer text</label>
                        <editor
                            @mouseleave="
                                handleSelectionChange(
                                    language,
                                    'footer_text',
                                    'updateHomePageSetting'
                                )
                            "
                            @keyup="
                                handleSelectionChange(
                                    language,
                                    'footer_text',
                                    'updateHomePageSetting'
                                )
                            "
                            :ref="`footer_text_${language.id}`"
                            :id="`footer_text_${language.id}`"
                            :initial-value="form[`footer_text`][`footer_text_${language?.id}`]
                            "
                            :tinymce-script-src="tinymceScriptSrc"
                            :init="editorConfig"
                        />

                        <p class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `footer_text.footer_text_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `footer_text.footer_text_${selectedLanguage}`
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
            collapseStates: [true, false, false, false, false, false, false]
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
        fetchHomePageSetting() {
            this.$store
                .dispatch("pages/fetchPage", {
                    url: `${process.env.MIX_ADMIN_API_URL}registration-page-setting?withRegPageSettingDetail=1&findByPageId=${this.form.id}`,
                })
                .then((res) => {
                    let data = res.data.data && res.data.data.reg_page_setting_detail
                            ? res.data.data.reg_page_setting_detail
                            : [];
                            let obj = {};
                            data.map(res => {

                                obj['page_title_'+res.language_id] = res.page_title;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'page_title',value: obj});
                            obj = {};
                            data.map(res => {

                                obj['page_description_'+res.language_id] = res.page_description;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'page_description',value: obj});
                            obj = {};
                            data.map(res => {

                                obj['step_1_heading_'+res.language_id] = res.step_1_heading;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_1_heading',value: obj});
                            obj = {};
                            data.map(res => {

                                obj['step_1_acc_heading_'+res.language_id] = res.step_1_acc_heading;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_1_acc_heading',value: obj});
                            obj = {};
                            data.map(res => {

                                obj['step_1_acc_description_'+res.language_id] = res.step_1_acc_description;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_1_acc_description',value: obj});
                            obj = {};
                            data.map(res => {

                                obj['step_1_description_'+res.language_id] = res.step_1_description;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_1_description',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_1_auto_renew_label_'+res.language_id] = res.step_1_auto_renew_label;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_1_auto_renew_label',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step1_free_pkg_text_'+res.language_id] = res.step1_free_pkg_text;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step1_free_pkg_text',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step1_feature_pkg_text_'+res.language_id] = res.step1_feature_pkg_text;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step1_feature_pkg_text',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step1_premium_pkg_text_'+res.language_id] = res.step1_premium_pkg_text;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step1_premium_pkg_text',value: obj});
                            obj = {};
                            data.map(res => {

                                obj['step_2_heading_'+res.language_id] = res.step_2_heading;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_2_heading',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_2_acc_heading_'+res.language_id] = res.step_2_acc_heading;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_2_acc_heading',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_2_acc_description_'+res.language_id] = res.step_2_acc_description;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_2_acc_description',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_2_name_label_'+res.language_id] = res.step_2_name_label;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_2_name_label',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_2_name_error_'+res.language_id] = res.step_2_name_error;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_2_name_error',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_2_name_placeholder_'+res.language_id] = res.step_2_name_placeholder;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_2_name_placeholder',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_2_email_label_'+res.language_id] = res.step_2_email_label;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_2_email_label',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_2_email_error_'+res.language_id] = res.step_2_email_error;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_2_email_error',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_2_email_placeholder_'+res.language_id] = res.step_2_email_placeholder;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_2_email_placeholder',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_2_password_label_'+res.language_id] = res.step_2_password_label;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_2_password_label',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_2_password_error_'+res.language_id] = res.step_2_password_error;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_2_password_error',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_2_password_placeholder_'+res.language_id] = res.step_2_password_placeholder;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_2_password_placeholder',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_2_confirm_password_label_'+res.language_id] = res.step_2_confirm_password_label;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_2_confirm_password_label',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_2_confirm_password_error_'+res.language_id] = res.step_2_confirm_password_error;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_2_confirm_password_error',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_2_confirm_password_placeholder_'+res.language_id] = res.step_2_confirm_password_placeholder;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_2_confirm_password_placeholder',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_2_profile_image_label_'+res.language_id] = res.step_2_profile_image_label;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_2_profile_image_label',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_2_profile_image_placeholder_'+res.language_id] = res.step_2_profile_image_placeholder;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_2_profile_image_placeholder',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_2_profile_image_error_'+res.language_id] = res.step_2_profile_image_error;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_2_profile_image_error',value: obj});
                            obj = {};
                            data.map(res => {

                                obj['step_3_heading_'+res.language_id] = res.step_3_heading;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_3_heading',value: obj});
                            obj = {};
                            data.map(res => {

                                obj['step_3_acc_heading_'+res.language_id] = res.step_3_acc_heading;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_3_acc_heading',value: obj});
                            obj = {};
                            data.map(res => {

                                obj['step_3_description_'+res.language_id] = res.step_3_description;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_3_description',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_3_business_categories_label_'+res.language_id] = res.step_3_business_categories_label;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_3_business_categories_label',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_3_business_categories_error_'+res.language_id] = res.step_3_business_categories_error;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_3_business_categories_error',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_3_business_categories_placeholder_'+res.language_id] = res.step_3_business_categories_placeholder;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_3_business_categories_placeholder',value: obj});
                            obj = {};
                            data.map(res => {

                                obj['step_4_heading_'+res.language_id] = res.step_4_heading;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_heading',value: obj});
                            obj = {};
                            data.map(res => {

                                obj['step_4_acc_heading_'+res.language_id] = res.step_4_acc_heading;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_acc_heading',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_name_label_'+res.language_id] = res.step_4_name_label;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_name_label',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_name_error_'+res.language_id] = res.step_4_name_error;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_name_error',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_name_placeholder_'+res.language_id] = res.step_4_name_placeholder;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_name_placeholder',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_email_label_'+res.language_id] = res.step_4_email_label;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_email_label',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_email_error_'+res.language_id] = res.step_4_email_error;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_email_error',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_cta_btn_label_'+res.language_id] = res.step_4_cta_btn_label;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_cta_btn_label',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_cta_btn_error_'+res.language_id] = res.step_4_cta_btn_error;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_cta_btn_error',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_cta_link_label_'+res.language_id] = res.step_4_cta_link_label;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_cta_link_label',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_cta_link_error_'+res.language_id] = res.step_4_cta_link_error;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_cta_link_error',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_email_placeholder_'+res.language_id] = res.step_4_email_placeholder;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_email_placeholder',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_cta_btn_placeholder_'+res.language_id] = res.step_4_cta_btn_placeholder;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_cta_btn_placeholder',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_cta_link_placeholder_'+res.language_id] = res.step_4_cta_link_placeholder;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_cta_link_placeholder',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_address_label_'+res.language_id] = res.step_4_address_label;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_address_label',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_address_error_'+res.language_id] = res.step_4_address_error;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_address_error',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_address_placeholder_'+res.language_id] = res.step_4_address_placeholder;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_address_placeholder',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_phone_label_'+res.language_id] = res.step_4_phone_label;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_phone_label',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_phone_error_'+res.language_id] = res.step_4_phone_error;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_phone_error',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_phone_placeholder_'+res.language_id] = res.step_4_phone_placeholder;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_phone_placeholder',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_website_label_'+res.language_id] = res.step_4_website_label;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_website_label',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_website_error_'+res.language_id] = res.step_4_website_error;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_website_error',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_website_placeholder_'+res.language_id] = res.step_4_website_placeholder;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_website_placeholder',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_short_description_label_'+res.language_id] = res.step_4_short_description_label;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_short_description_label',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_short_description_error_'+res.language_id] = res.step_4_short_description_error;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_short_description_error',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_short_description_placeholder_'+res.language_id] = res.step_4_short_description_placeholder;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_short_description_placeholder',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_description_label_'+res.language_id] = res.step_4_description_label;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_description_label',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_description_error_'+res.language_id] = res.step_4_description_error;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_description_error',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_description_placeholder_'+res.language_id] = res.step_4_description_placeholder;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_description_placeholder',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_keywords_label_'+res.language_id] = res.step_4_keywords_label;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_keywords_label',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_keywords_error_'+res.language_id] = res.step_4_keywords_error;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_keywords_error',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_4_keywords_placeholder_'+res.language_id] = res.step_4_keywords_placeholder;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_4_keywords_placeholder',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['pre_media_tab_description_'+res.language_id] = res.pre_media_tab_description;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'pre_media_tab_description',value: obj});
                            obj = {};
                            data.map(res => {

                                obj['step_5_heading_'+res.language_id] = res.step_5_heading;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_5_heading',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_5_title_label_'+res.language_id] = res.step_5_title_label;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_5_title_label',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_5_title_error_'+res.language_id] = res.step_5_title_error;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_5_title_error',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_5_title_placeholder_'+res.language_id] = res.step_5_title_placeholder;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_5_title_placeholder',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_5_description_label_'+res.language_id] = res.step_5_description_label;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_5_description_label',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_5_description_error_'+res.language_id] = res.step_5_description_error;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_5_description_error',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_5_description_placeholder_'+res.language_id] = res.step_5_description_placeholder;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_5_description_placeholder',value: obj});
                            obj = {};
                            data.map(res => {

                                obj['step_5_acc_heading_'+res.language_id] = res.step_5_acc_heading;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_5_acc_heading',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_5_logo_label_'+res.language_id] = res.step_5_logo_label;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_5_logo_label',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_5_logo_error_'+res.language_id] = res.step_5_logo_error;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_5_logo_error',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_5_logo_placeholder_'+res.language_id] = res.step_5_logo_placeholder;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_5_logo_placeholder',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_5_video_label_'+res.language_id] = res.step_5_video_label;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_5_video_label',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_5_video_error_'+res.language_id] = res.step_5_video_error;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_5_video_error',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_5_video_placeholder_'+res.language_id] = res.step_5_video_placeholder;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_5_video_placeholder',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_5_gallery_image_label_'+res.language_id] = res.step_5_gallery_image_label;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_5_gallery_image_label',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_5_gallery_image_placeholder_'+res.language_id] = res.step_5_gallery_image_placeholder;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_5_gallery_image_placeholder',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_5_gallery_image_error_'+res.language_id] = res.step_5_gallery_image_error;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_5_gallery_image_error',value: obj});
                            obj = {};
                            data.map(res => {

                                obj['step_6_heading_'+res.language_id] = res.step_6_heading;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_6_heading',value: obj});
                            obj = {};
                            data.map(res => {

                                obj['step_6_acc_heading_'+res.language_id] = res.step_6_acc_heading;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_6_acc_heading',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_6_facebook_label_'+res.language_id] = res.step_6_facebook_label;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_6_facebook_label',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_6_facebook_error_'+res.language_id] = res.step_6_facebook_error;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_6_facebook_error',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_6_facebook_placeholder_'+res.language_id] = res.step_6_facebook_placeholder;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_6_facebook_placeholder',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_6_twitter_label_'+res.language_id] = res.step_6_twitter_label;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_6_twitter_label',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_6_twitter_error_'+res.language_id] = res.step_6_twitter_error;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_6_twitter_error',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_6_twitter_placeholder_'+res.language_id] = res.step_6_twitter_placeholder;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_6_twitter_placeholder',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_6_youtube_label_'+res.language_id] = res.step_6_youtube_label;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_6_youtube_label',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_6_youtube_error_'+res.language_id] = res.step_6_youtube_error;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_6_youtube_error',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_6_youtube_placeholder_'+res.language_id] = res.step_6_youtube_placeholder;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_6_youtube_placeholder',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_6_linkedin_label_'+res.language_id] = res.step_6_linkedin_label;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_6_linkedin_label',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_6_linkedin_error_'+res.language_id] = res.step_6_linkedin_error;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_6_linkedin_error',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_6_linkedin_placeholder_'+res.language_id] = res.step_6_linkedin_placeholder;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_6_linkedin_placeholder',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_6_social_media5_label_'+res.language_id] = res.step_6_social_media5_label;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_6_social_media5_label',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_6_social_media5_placeholder_'+res.language_id] = res.step_6_social_media5_placeholder;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_6_social_media5_placeholder',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['step_6_social_media5_error_'+res.language_id] = res.step_6_social_media5_error;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'step_6_social_media5_error',value: obj});
                            obj = {};
                            data.map(res => {

                                obj['terms_and_conditions_label_'+res.language_id] = res.terms_and_conditions_label;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'terms_and_conditions_label',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['terms_and_conditions_error_'+res.language_id] = res.terms_and_conditions_error;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'terms_and_conditions_error',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['greeting_text_'+res.language_id] = res.greeting_text;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'greeting_text',value: obj});
                            obj = {};
                            data.map(res => {
                                obj['submit_button_text_'+res.language_id] = res.submit_button_text;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'submit_button_text',value: obj});
                            obj = {};
                            data.map(res => {

                                obj['footer_text_'+res.language_id] = res.footer_text;
                            });
                            this.$store.commit('pages/setHomePageSetting',{key:'footer_text',value: obj});
                            this.isDataLoaded = 1;
                });
        },
        checkValidationError(validationErros, language) {
            return validationErros.has(`page_title.page_title_${language.id}`) ||
                validationErros.has(`page_description.page_description_${language.id}`) ||
                validationErros.has(`step_1_heading.step_1_heading_${language.id}`) ||
                validationErros.has(`step_1_acc_heading.step_1_acc_heading_${language.id}`) ||
                validationErros.has(`step_1_acc_description.step_1_acc_description_${language.id}`) ||
                validationErros.has(`step_1_description.step_1_description_${language.id}`) ||
                validationErros.has(`step_1_auto_renew_label.step_1_auto_renew_label_${language.id}`) ||
                validationErros.has(`step1_free_pkg_text.step1_free_pkg_text_${language.id}`) ||
                validationErros.has(`step1_feature_pkg_text.step1_feature_pkg_text_${language.id}`) ||
                validationErros.has(`step1_premium_pkg_text.step1_premium_pkg_text_${language.id}`) ||
                validationErros.has(`step_2_heading.step_2_heading_${language.id}`) ||
                validationErros.has(`step_2_acc_heading.step_2_acc_heading_${language.id}`) ||
                validationErros.has(`step_2_acc_description.step_2_acc_description_${language.id}`) ||
                validationErros.has(`step_2_name_label.step_2_name_label_${language.id}`) ||
                validationErros.has(`step_2_name_error.step_2_name_error_${language.id}`) ||
                validationErros.has(`step_2_name_placeholder.step_2_name_placeholder_${language.id}`) ||
                validationErros.has(`step_2_email_label.step_2_email_label_${language.id}`) ||
                validationErros.has(`step_2_email_error.step_2_email_error_${language.id}`) ||
                validationErros.has(`step_2_email_placeholder.step_2_email_placeholder_${language.id}`) ||
                validationErros.has(`step_2_password_label.step_2_password_label_${language.id}`) ||
                validationErros.has(`step_2_password_error.step_2_password_error_${language.id}`) ||
                validationErros.has(`step_2_password_placeholder.step_2_password_placeholder_${language.id}`) ||
                validationErros.has(`step_2_confirm_password_label.step_2_confirm_password_label_${language.id}`) ||
                validationErros.has(`step_2_confirm_password_error.step_2_confirm_password_error_${language.id}`) ||
                validationErros.has(`step_2_confirm_password_placeholder.step_2_confirm_password_placeholder_${language.id}`) ||
                validationErros.has(`step_2_profile_image_label.step_2_profile_image_label_${language.id}`) ||
                validationErros.has(`step_2_profile_image_placeholder.step_2_profile_image_placeholder_${language.id}`) ||
                validationErros.has(`step_2_profile_image_error.step_2_profile_image_error_${language.id}`) ||
                validationErros.has(`step_3_heading.step_3_heading_${language.id}`) ||
                validationErros.has(`step_3_acc_heading.step_3_acc_heading_${language.id}`) ||
                validationErros.has(`step_3_description.step_3_description_${language.id}`) ||
                validationErros.has(`step_3_business_categories_label.step_3_business_categories_label_${language.id}`) ||
                validationErros.has(`step_3_business_categories_error.step_3_business_categories_error_${language.id}`) ||
                validationErros.has(`step_3_business_categories_placeholder.step_3_business_categories_placeholder_${language.id}`) ||
                validationErros.has(`step_3_business_categories_placeholder.step_3_business_categories_placeholder_${language.id}`) ||
                validationErros.has(`step_4_heading.step_4_heading_${language.id}`) ||
                validationErros.has(`step_4_acc_heading.step_4_acc_heading_${language.id}`) ||
                validationErros.has(`step_4_name_label.step_4_name_label_${language.id}`) ||
                validationErros.has(`step_4_name_error.step_4_name_error_${language.id}`) ||
                validationErros.has(`step_4_name_placeholder.step_4_name_placeholder_${language.id}`) ||
                validationErros.has(`step_4_email_label.step_4_email_label_${language.id}`) ||
                validationErros.has(`step_4_email_error.step_4_email_error_${language.id}`) ||
                validationErros.has(`step_4_email_placeholder.step_4_email_placeholder_${language.id}`) ||
                validationErros.has(`step_4_cta_link_label.step_4_cta_link_label_${language.id}`) ||
                validationErros.has(`step_4_cta_link_error.step_4_cta_link_error_${language.id}`) ||
                validationErros.has(`step_4_cta_link_placeholder.step_4_cta_link_placeholder_${language.id}`) ||
                validationErros.has(`step_4_cta_btn_label.step_4_cta_btn_label_${language.id}`) ||
                validationErros.has(`step_4_cta_btn_error.step_4_cta_btn_error_${language.id}`) ||
                validationErros.has(`step_4_cta_btn_placeholder.step_4_cta_btn_placeholder_${language.id}`) ||

                validationErros.has(`step_4_address_label.step_4_address_label_${language.id}`) ||
                validationErros.has(`step_4_address_error.step_4_address_error_${language.id}`) ||
                validationErros.has(`step_4_address_placeholder.step_4_address_placeholder_${language.id}`) ||
                validationErros.has(`step_4_phone_label.step_4_phone_label_${language.id}`) ||
                validationErros.has(`step_4_phone_error.step_4_phone_error_${language.id}`) ||
                validationErros.has(`step_4_phone_placeholder.step_4_phone_placeholder_${language.id}`) ||
                validationErros.has(`step_4_website_label.step_4_website_label_${language.id}`) ||
                validationErros.has(`step_4_website_error.step_4_website_error_${language.id}`) ||
                validationErros.has(`step_4_website_placeholder.step_4_website_placeholder_${language.id}`) ||
                validationErros.has(`step_4_short_description_label.step_4_short_description_label_${language.id}`) ||
                validationErros.has(`step_4_short_description_error.step_4_short_description_error_${language.id}`) ||
                validationErros.has(`step_4_short_description_placeholder.step_4_short_description_placeholder_${language.id}`) ||
                validationErros.has(`step_4_description_label.step_4_description_label_${language.id}`) ||
                validationErros.has(`step_4_description_error.step_4_description_error_${language.id}`) ||
                validationErros.has(`step_4_description_placeholder.step_4_description_placeholder_${language.id}`) ||
                validationErros.has(`step_4_keywords_label.step_4_keywords_label_${language.id}`) ||
                validationErros.has(`step_4_keywords_error.step_4_keywords_error_${language.id}`) ||
                validationErros.has(`step_4_keywords_placeholder.step_4_keywords_placeholder_${language.id}`) ||
                validationErros.has(`pre_media_tab_description.pre_media_tab_description_${language.id}`) ||
                validationErros.has(`step_5_heading.step_5_heading_${language.id}`) ||
                validationErros.has(`step_5_title_label.step_5_title_label_${language.id}`) ||
                validationErros.has(`step_5_title_error.step_5_title_error_${language.id}`) ||
                validationErros.has(`step_5_title_placeholder.step_5_title_placeholder_${language.id}`) ||
                validationErros.has(`step_5_description_label.step_5_description_label_${language.id}`) ||
                validationErros.has(`step_5_description_error.step_5_description_error_${language.id}`) ||
                validationErros.has(`step_5_description_placeholder.step_5_description_placeholder_${language.id}`) ||
                validationErros.has(`step_5_acc_heading.step_5_acc_heading_${language.id}`) ||
                validationErros.has(`step_5_logo_label.step_5_logo_label_${language.id}`) ||
                validationErros.has(`step_5_logo_error.step_5_logo_error_${language.id}`) ||
                validationErros.has(`step_5_logo_placeholder.step_5_logo_placeholder_${language.id}`) ||
                validationErros.has(`step_5_video_label.step_5_video_label_${language.id}`) ||
                validationErros.has(`step_5_video_error.step_5_video_error_${language.id}`) ||
                validationErros.has(`step_5_video_placeholder.step_5_video_placeholder_${language.id}`) ||
                validationErros.has(`step_5_gallery_image_label.step_5_gallery_image_label_${language.id}`) ||
                validationErros.has(`step_5_gallery_image_placeholder.step_5_gallery_image_placeholder_${language.id}`) ||
                validationErros.has(`step_5_gallery_image_error.step_5_gallery_image_error_${language.id}`) ||
                validationErros.has(`step_6_heading.step_6_heading_${language.id}`) ||
                validationErros.has(`step_6_acc_heading.step_6_acc_heading_${language.id}`) ||
                validationErros.has(`step_6_facebook_label.step_6_facebook_label_${language.id}`) ||
                validationErros.has(`step_6_facebook_error.step_6_facebook_error_${language.id}`) ||
                validationErros.has(`step_6_facebook_placeholder.step_6_facebook_placeholder_${language.id}`) ||
                validationErros.has(`step_6_twitter_label.step_6_twitter_label_${language.id}`) ||
                validationErros.has(`step_6_twitter_label.step_6_twitter_label_${language.id}`) ||
                validationErros.has(`step_6_twitter_error.step_6_twitter_error_${language.id}`) ||
                validationErros.has(`step_6_twitter_placeholder.step_6_twitter_placeholder_${language.id}`) ||
                validationErros.has(`step_6_youtube_label.step_6_youtube_label_${language.id}`) ||
                validationErros.has(`step_6_youtube_error.step_6_youtube_error_${language.id}`) ||
                validationErros.has(`step_6_youtube_placeholder.step_6_youtube_placeholder_${language.id}`) ||
                validationErros.has(`step_6_linkedin_label.step_6_linkedin_label_${language.id}`) ||
                validationErros.has(`step_6_linkedin_error.step_6_linkedin_error_${language.id}`) ||
                validationErros.has(`step_6_linkedin_placeholder.step_6_linkedin_placeholder_${language.id}`) ||
                validationErros.has(`step_6_social_media5_label.step_6_social_media5_label_${language.id}`) ||
                validationErros.has(`step_6_social_media5_placeholder.step_6_social_media5_placeholder_${language.id}`) ||
                validationErros.has(`step_6_social_media5_error.step_6_social_media5_error_${language.id}`) ||
                validationErros.has(`terms_and_conditions_label.terms_and_conditions_label_${language.id}`) ||
                validationErros.has(`terms_and_conditions_error.terms_and_conditions_error_${language.id}`) ||
                validationErros.has(`greeting_text.greeting_text_${language.id}`) ||
                validationErros.has(`submit_button_text.submit_button_text_${language.id}`) ||
                validationErros.has(`footer_text.footer_text_${language.id}`);
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
                data.map(res => {
                    obj['page_title_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'page_title',value: obj});
                obj = {};
                data.map(res => {
                    obj['page_description_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'page_description',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_1_heading_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_1_heading',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_1_acc_heading_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_1_acc_heading',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_1_acc_description_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_1_acc_description',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_1_description_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_1_description',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_1_auto_renew_label_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_1_auto_renew_label',value: obj});
                obj = {};
                data.map(res => {
                    obj['step1_free_pkg_text_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step1_free_pkg_text',value: obj});
                obj = {};
                data.map(res => {
                    obj['step1_feature_pkg_text_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step1_feature_pkg_text',value: obj});
                obj = {};
                data.map(res => {
                    obj['step1_premium_pkg_text_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step1_premium_pkg_text',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_2_heading_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_2_heading',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_2_acc_heading_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_2_acc_heading',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_2_acc_description_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_2_acc_description',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_2_name_label_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_2_name_label',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_2_name_error_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_2_name_error',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_2_name_placeholder_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_2_name_placeholder',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_2_email_label_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_2_email_label',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_2_email_error_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_2_email_error',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_2_email_placeholder_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_2_email_placeholder',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_2_password_label_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_2_password_label',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_2_password_error_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_2_password_error',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_2_password_placeholder_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_2_password_placeholder',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_2_confirm_password_label_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_2_confirm_password_label',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_2_confirm_password_error_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_2_confirm_password_error',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_2_confirm_password_placeholder_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_2_confirm_password_placeholder',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_2_profile_image_label_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_2_profile_image_label',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_2_profile_image_placeholder_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_2_profile_image_placeholder',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_2_profile_image_error_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_2_profile_image_error',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_3_heading_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_3_heading',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_3_acc_heading_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_3_acc_heading',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_3_description_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_3_description',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_3_business_categories_label_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_3_business_categories_label',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_3_business_categories_error_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_3_business_categories_error',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_3_business_categories_placeholder_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_3_business_categories_placeholder',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_4_heading_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_4_heading',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_4_acc_heading_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_4_acc_heading',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_4_name_label_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_4_name_label',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_4_name_error_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_4_name_error',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_4_name_placeholder_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_4_name_placeholder',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_4_email_label_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_4_email_label',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_4_email_error_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_4_email_error',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_4_email_placeholder_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_4_email_placeholder',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_4_cta_btn_placeholder_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_4_cta_btn_placeholder',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_4_cta_link_placeholder_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_4_cta_link_placeholder',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_4_address_label_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_4_address_label',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_4_address_error_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_4_address_error',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_4_address_placeholder_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_4_address_placeholder',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_4_phone_label_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_4_phone_label',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_4_phone_error_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_4_phone_error',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_4_phone_placeholder_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_4_phone_placeholder',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_4_website_label_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_4_website_label',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_4_website_error_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_4_website_error',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_4_website_placeholder_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_4_website_placeholder',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_4_short_description_label_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_4_short_description_label',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_4_short_description_error_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_4_short_description_error',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_4_short_description_placeholder_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_4_short_description_placeholder',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_4_description_label_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_4_description_label',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_4_description_error_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_4_description_error',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_4_description_placeholder_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_4_description_placeholder',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_4_keywords_label_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_4_keywords_label',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_4_keywords_error_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_4_keywords_error',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_4_keywords_placeholder_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_4_keywords_placeholder',value: obj});
                obj = {};
                data.map(res => {
                    obj['pre_media_tab_description_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'pre_media_tab_description',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_5_heading_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_5_heading',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_5_title_label_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_5_title_label',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_5_title_error_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_5_title_error',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_5_title_placeholder_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_5_title_placeholder',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_5_description_label_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_5_description_label',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_5_description_error_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_5_description_error',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_5_description_placeholder_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_5_description_placeholder',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_5_acc_heading_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_5_acc_heading',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_5_logo_label_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_5_logo_label',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_5_logo_error_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_5_logo_error',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_5_logo_placeholder_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_5_logo_placeholder',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_5_video_label_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_5_video_label',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_5_video_error_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_5_video_error',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_5_video_placeholder_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_5_video_placeholder',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_5_gallery_image_label_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_5_gallery_image_label',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_5_gallery_image_placeholder_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_5_gallery_image_placeholder',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_5_gallery_image_error_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_5_gallery_image_error',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_6_heading_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_6_heading',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_6_acc_heading_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_6_acc_heading',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_6_facebook_label_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_6_facebook_label',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_6_facebook_error_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_6_facebook_error',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_6_facebook_placeholder_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_6_facebook_placeholder',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_6_twitter_label_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_6_twitter_label',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_6_twitter_error_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_6_twitter_error',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_6_twitter_placeholder_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_6_twitter_placeholder',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_6_youtube_label_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_6_youtube_label',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_6_youtube_error_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_6_youtube_error',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_6_youtube_placeholder_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_6_youtube_placeholder',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_6_linkedin_label_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_6_linkedin_label',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_6_linkedin_error_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_6_linkedin_error',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_6_linkedin_placeholder_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_6_linkedin_placeholder',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_6_social_media5_label_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_6_social_media5_label',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_6_social_media5_placeholder_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_6_social_media5_placeholder',value: obj});
                obj = {};
                data.map(res => {
                    obj['step_6_social_media5_error_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'step_6_social_media5_error',value: obj});
                obj = {};
                data.map(res => {
                    obj['terms_and_conditions_label_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'terms_and_conditions_label',value: obj});
                obj = {};
                data.map(res => {
                    obj['terms_and_conditions_error_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'terms_and_conditions_error',value: obj});
                obj = {};
                data.map(res => {
                    obj['greeting_text_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'greeting_text',value: obj});
                obj = {};
                data.map(res => {
                    obj['submit_button_text_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'submit_button_text',value: obj});
                obj = {};
                data.map(res => {
                    obj['footer_text_'+res.id] = "";
                });
                this.$store.commit('pages/setHomePageSetting',{key:'footer_text',value: obj});
                if(this.$route.params.id){
                    this.fetchHomePageSetting();
                }
                else{
                    this.isDataLoaded = 1;
                }
            });
    },
};
</script>

<style>
.tox-notification { display: none !important }
</style>
