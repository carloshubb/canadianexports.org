<template>
    <AppLayout>
        <header class="py-4 bg-white mt-8">
            <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <h1 class="text-3xl font-bold text-blue-600"> Registration page setting </h1>
                </div>
            </div>
        </header>
        <form class="py-4 px-4 bg-white" @submit.prevent="addUpdateForm()">

            <div
                class="text-sm font-medium text-center text-gray-500 border-b border-gray-200">
                <ul class="flex flex-wrap mb-2 overflow-x-auto gap-1 mt-4">
                    <li class="mr-2" v-for="language in languages" :key="language.id">
                        <a @click.prevent="changeLanguageTab(language)" href="#"
                            :class="['inline-block rounded font-FuturaMdCnBT px-5 py-2 lg:text-lg md:text-base sm:text-base text-base hover:bg-blue-100 border border-primary text-center hover:border-blue-500 hover:text-blue-600',
                                ((activeTab == null && language.is_default) || activeTab == language.id ?
                                    'bg-blue-600 text-white' : ''
                                    , checkValidationError(validationErros, language) ? 'bg-red-600 border-red-600 text-white hover:text-white rounded hover:bg-red-600 hover:border-red-600' : '')]">{{ language . name }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="my-5" v-for="language in languages" :key="language.id"
                :class="(activeTab == null && language.is_default) || activeTab == language.id ? 'block' : 'hidden'">
                <div class="border rounded w-full" :class="collapseStates[0] ? 'bg-gray-50' : ''">
                    <div class="flex justify-between bg-blue-600 text-white p-4 cursor-pointer"
                        @click.prevent="collapseStates[0] = !collapseStates[0]">
                        <h2 class="text-lg font-medium">Register my business</h2>
                        <svg class="w-5 h-5 fill-current text-gray-500" viewBox="0 0 20 20">
                            <path d="M6 9l4 4 4-4"></path>
                        </svg>
                    </div>
                    <div class="p-4 bg-gray-100 border-t" v-show="collapseStates[0]">
                        <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2  lg:grid-cols-2 gap-6 ">
                            <div class="relative z-0 w-full mb-6 group">
                                <label :for="`page_title_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Title of the page</label>
                                <div class="mt-2">
                                    <div class="mt-5 ckeditorText" :id="`page_title_${language.id}`"></div>
                                    <p class="mt-2 text-sm text-red-400"
                                        v-if="validationErros.has(`page_title.page_title_${language.id}`)"
                                        v-text="validationErros.get(`page_title.page_title_${language.id}`)">
                                    </p>
                                </div>
                            </div>

                                <!-- <input type="text" :name="`page_title_${language.id}`"
                                    :id="`page_title_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updatePageTitle')"
                                    :value="form['page_title'] && form['page_title'][`page_title_${language.id}`] ? form[
                                        'page_title'][`page_title_${language.id}`] : ''" /> -->
                                <!-- <label :for="`page_title_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Page
                                    title</label> -->

                            <div class="relative z-0 w-full mb-6 group">
                                <label :for="`page_description_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Description for registration page</label>
                                <div class="mt-2">
                                    <div class="mt-5 ckeditorText" :id="`page_description_${language.id}`"></div>
                                    <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`page_description.page_description_${language.id}`)"
                                    v-text="validationErros.get(`page_description.page_description_${language.id}`)">
                                    </p>
                                </div>
                            </div>

                                <!-- <input type="text" :name="`page_description_${language.id}`"
                                    :id="`page_description_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updatePageDescription')"
                                    :value="form['page_description'] && form['page_description'][
                                        `page_description_${language.id}`
                                    ] ? form['page_description'][`page_description_${language.id}`] : ''" /> -->
                        </div>
                    </div>
                </div>
                <div class="border rounded w-full" :class="collapseStates[1] ? 'bg-gray-50' : ''">
                    <div class="flex justify-between bg-blue-600 text-white p-4 cursor-pointer"
                        @click.prevent="collapseStates[1] = !collapseStates[1]">
                        <h2 class="text-lg font-medium">1 of 4 - Registration package</h2>
                        <svg class="w-5 h-5 fill-current text-gray-500" viewBox="0 0 20 20">
                            <path d="M6 9l4 4 4-4"></path>
                        </svg>
                    </div>
                    <div class="p-4 bg-gray-100 border-t" v-show="collapseStates[1]">
                        <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2  lg:grid-cols-2 gap-6 ">
                            <div class="relative z-0 w-full mb-6 group">
                                <label :for="`step_1_heading_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Section Heading</label>
                                <div class="mt-2">
                                    <div class="mt-5 ckeditorText" :id="`step_1_heading_${language.id}`"></div>
                                    <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`step_1_heading.step_1_heading_${language.id}`)"
                                v-text="validationErros.get(`step_1_heading.step_1_heading_${language.id}`)">
                                    </p>
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <label :for="`step_1_acc_heading_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Registration package heading</label>
                                <div class="mt-2">
                                    <div class="mt-5 ckeditorText" :id="`step_1_acc_heading_${language.id}`"></div>
                                    <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`step_1_acc_heading.step_1_acc_heading_${language.id}`)"
                                v-text="validationErros.get(`step_1_acc_heading.step_1_acc_heading_${language.id}`)">
                                    </p>
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-6">
                                <label :for="`step1_free_pkg_text_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Free package text</label>
                                <div class="mt-2">
                                    <input type="text" :name="`step1_free_pkg_text_${language.id}`" :id="`step1_free_pkg_text_${language.id}`" autocomplete="family-name" placeholder=" " class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" @input="handleInput($event.target.value, language, 'updateStep1FreePkgText')" :value="form['step1_free_pkg_text'] && form['step1_free_pkg_text'][
                                        `step1_free_pkg_text_${language.id}`
                                    ] ? form['step1_free_pkg_text'][`step1_free_pkg_text_${language.id}`] :
                                    ''">
                                    <p class="mt-2 text-sm text-red-400"
                                        v-if="validationErros.has(`step1_free_pkg_text.step1_free_pkg_text_${language.id}`)"
                                        v-text="validationErros.get(`step1_free_pkg_text.step1_free_pkg_text_${language.id}`)">
                                    </p>
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-6">
                                <label :for="`step1_feature_pkg_text_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Feature package text</label>
                                <div class="mt-2">
                                    <input type="text" :name="`step1_feature_pkg_text_${language.id}`" :id="`step1_feature_pkg_text_${language.id}`" autocomplete="family-name" placeholder=" " class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" @input="handleInput($event.target.value, language, 'updateStep1FeaturePkgText')" :value="form['step1_feature_pkg_text'] && form['step1_feature_pkg_text'][
                                        `step1_feature_pkg_text_${language.id}`
                                    ] ? form['step1_feature_pkg_text'][`step1_feature_pkg_text_${language.id}`] :
                                    ''">
                                    <p class="mt-2 text-sm text-red-400"
                                        v-if="validationErros.has(`step1_feature_pkg_text.step1_feature_pkg_text_${language.id}`)"
                                        v-text="validationErros.get(`step1_feature_pkg_text.step1_feature_pkg_text_${language.id}`)">
                                    </p>
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-6">
                                <label :for="`step1_premium_pkg_text_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Premium package text</label>
                                <div class="mt-2">
                                    <input type="text" :name="`step1_premium_pkg_text_${language.id}`" :id="`step1_premium_pkg_text_${language.id}`" autocomplete="family-name" placeholder=" " class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" @input="handleInput($event.target.value, language, 'updateStep1PremiumPkgText')" :value="form['step1_premium_pkg_text'] && form['step1_premium_pkg_text'][
                                        `step1_premium_pkg_text_${language.id}`
                                    ] ? form['step1_premium_pkg_text'][`step1_premium_pkg_text_${language.id}`] :
                                    ''">
                                    <p class="mt-2 text-sm text-red-400"
                                        v-if="validationErros.has(`step1_premium_pkg_text.step1_premium_pkg_text_${language.id}`)"
                                        v-text="validationErros.get(`step1_premium_pkg_text.step1_premium_pkg_text_${language.id}`)">
                                    </p>
                                </div>
                            </div>

                                <!-- <input type="text" :name="`step_1_heading_${language.id}`"
                                    :id="`step_1_heading_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updatePageDescription')"
                                    :value="form['page_description'] && form['page_description'][
                                        `step_1_heading_${language.id}`
                                    ] ? form['page_description'][`step_1_heading_${language.id}`] : ''" /> -->

                            <div class="relative z-0 w-full mb-6 group">
                                <label :for="`step_1_description_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Section Description</label>
                                <div class="mt-2">
                                    <div class="mt-5 ckeditorText" :id="`step_1_description_${language.id}`"></div>
                                    <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`step_1_description.step_1_description_${language.id}`)"
                                v-text="validationErros.get(`step_1_description.step_1_description_${language.id}`)">
                                    </p>
                                </div>
                            </div>

                                <!-- <input type="text" :name="`step_1_description_${language.id}`"
                                    :id="`step_1_description_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep1Description')"
                                    :value="form['step_1_description'] && form['step_1_description'][
                                        `step_1_description_${language.id}`
                                    ] ? form['step_1_description'][`step_1_description_${language.id}`] : ''" /> -->

                            <div class="relative z-0 w-full mb-6">
                                <label :for="`step_1_auto_renew_label_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Auto renew label</label>
                                <div class="mt-2">
                                    <input type="text" :name="`step_1_auto_renew_label_${language.id}`" :id="`step_1_auto_renew_label_${language.id}`" autocomplete="family-name" placeholder=" " class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" @input="handleInput($event.target.value, language, 'updateStep1AutoRenewLabel')" :value="form['step_1_auto_renew_label'] && form['step_1_auto_renew_label'][
                                        `step_1_auto_renew_label_${language.id}`
                                    ] ? form['step_1_auto_renew_label'][`step_1_auto_renew_label_${language.id}`] :
                                    ''">
                                    <p class="mt-2 text-sm text-red-400"
                                        v-if="validationErros.has(`step_1_auto_renew_label.step_1_auto_renew_label_${language.id}`)"
                                        v-text="validationErros.get(`step_1_auto_renew_label.step_1_auto_renew_label_${language.id}`)">
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border rounded w-full" :class="collapseStates[2] ? 'bg-gray-50' : ''">
                    <div class="flex justify-between bg-blue-600 text-white p-4 cursor-pointer"
                        @click.prevent="collapseStates[2] = !collapseStates[2]">
                        <h2 class="text-lg font-medium">2 of 4 - User Profile</h2>
                        <svg class="w-5 h-5 fill-current text-gray-500" viewBox="0 0 20 20">
                            <path d="M6 9l4 4 4-4"></path>
                        </svg>
                    </div>
                    <div class="p-4 bg-gray-100 border-t" v-show="collapseStates[2]">
                        <div class="grid my-5 grid-cols-1 md:grid-cols-3 md:gap-6">
                            <div class="relative z-0 w-full mb-6 col-span-3">
                                <label :for="`step_2_heading_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Section Heading</label>
                                <div class="mt-2">
                                    <div class="mt-5 ckeditorText" :id="`step_2_heading_${language.id}`"></div>
                                    <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`step_2_heading.step_2_heading_${language.id}`)"
                                v-text="validationErros.get(`step_2_heading.step_2_heading_${language.id}`)">
                                    </p>
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-6 col-span-3">
                                <label :for="`step_2_acc_heading_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">User Profile Heading</label>
                                <div class="mt-2">
                                    <div class="mt-5 ckeditorText" :id="`step_2_acc_heading_${language.id}`"></div>
                                    <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`step_2_acc_heading.step_2_acc_heading_${language.id}`)"
                                v-text="validationErros.get(`step_2_acc_heading.step_2_acc_heading_${language.id}`)">
                                    </p>
                                </div>
                            </div>

                            <div class="relative z-0 w-full mb-6 col-span-3">
                                <label :for="`step_2_acc_description_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">User Profile description</label>
                                <div class="mt-2">
                                    <div class="mt-5 ckeditorText" :id="`step_2_acc_description_${language.id}`"></div>
                                    <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`step_2_acc_description.step_2_acc_description_${language.id}`)"
                                v-text="validationErros.get(`step_2_acc_description.step_2_acc_description_${language.id}`)">
                                    </p>
                                </div>
                            </div>
                    <!-- <input type="text" :name="`step_2_heading_${language.id}`"
                        :id="`step_2_heading_${language.id}`"
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        placeholder=" "
                        @input="handleInput($event.target.value, language, 'updateStep2Heading')"
                        :value="form['step_2_heading'] && form['step_2_heading'][`step_2_heading_${language.id}`] ?
                            form['step_2_heading'][`step_2_heading_${language.id}`] : ''" /> -->
                            <div class="relative z-0 w-full mb-6">
                                <label :for="`step_2_name_label_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Label for name</label>
                                <div class="mt-2">
                                    <input type="text" :name="`step_2_name_label_${language.id}`"
                                :id="`step_2_name_label_${language.id}`"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                placeholder=" "
                                @input="handleInput($event.target.value, language, 'updateStep2NameLabel')"
                                :value="form['step_2_name_label'] && form['step_2_name_label'][
                                    `step_2_name_label_${language.id}`
                                ] ? form['step_2_name_label'][`step_2_name_label_${language.id}`] : ''" />
                                    <p class="mt-2 text-sm text-red-400"
                                        v-if="validationErros.has(`step_2_name_label.step_2_name_label_${language.id}`)"
                                v-text="validationErros.get(`step_2_name_label.step_2_name_label_${language.id}`)">
                                    </p>
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-6">
                                <label :for="`step_2_name_error_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Error message for name</label>
                                <div class="mt-2">
                                    <input type="text" :name="`step_2_name_error_${language.id}`"
                                :id="`step_2_name_error_${language.id}`"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                placeholder=" "
                                @input="handleInput($event.target.value, language, 'updateStep2NameError')"
                                :value="form['step_2_name_error'] && form['step_2_name_error'][
                                    `step_2_name_error_${language.id}`
                                ] ? form['step_2_name_error'][`step_2_name_error_${language.id}`] : ''" />
                                    <p class="mt-2 text-sm text-red-400"
                                        v-if="validationErros.has(`step_2_name_error.step_2_name_error_${language.id}`)"
                                v-text="validationErros.get(`step_2_name_error.step_2_name_error_${language.id}`)">
                                    </p>
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-6">
                                <label :for="`step_2_name_placeholder_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Placeholder for name</label>
                                <div class="mt-2">
                                    <input type="text" :name="`step_2_name_placeholder_${language.id}`"
                                :id="`step_2_name_placeholder_${language.id}`"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                placeholder=" "
                                @input="handleInput($event.target.value, language, 'updateStep2NamePlaceholder')"
                                :value="form['step_2_name_placeholder'] && form['step_2_name_placeholder'][
                                        `step_2_name_placeholder_${language.id}`
                                    ] ? form['step_2_name_placeholder'][`step_2_name_placeholder_${language.id}`] :
                                    ''" />
                                    <p class="mt-2 text-sm text-red-400"
                                        v-if="validationErros.has(`step_2_name_placeholder.step_2_name_placeholder_${language.id}`)"
                                v-text="validationErros.get(`step_2_name_placeholder.step_2_name_placeholder_${language.id}`)">
                                    </p>
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-6">
                                <label :for="`step_2_email_label_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Label for email</label>
                                <div class="mt-2">
                                    <input type="text" :name="`step_2_email_label_${language.id}`"
                                :id="`step_2_email_label_${language.id}`"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                placeholder=" "
                                @input="handleInput($event.target.value, language, 'updateStep2EmailLabel')"
                                :value="form['step_2_email_label'] && form['step_2_email_label'][
                                    `step_2_email_label_${language.id}`
                                ] ? form['step_2_email_label'][`step_2_email_label_${language.id}`] : ''" />
                                    <p class="mt-2 text-sm text-red-400"
                                        v-if="validationErros.has(`step_2_email_label.step_2_email_label_${language.id}`)"
                                v-text="validationErros.get(`step_2_email_label.step_2_email_label_${language.id}`)">
                                    </p>
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-6">
                                <label :for="`step_2_email_error_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Error message for email</label>
                                <div class="mt-2">
                                    <input type="text" :name="`step_2_email_error_${language.id}`"
                                :id="`step_2_email_error_${language.id}`"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                placeholder=" "
                                @input="handleInput($event.target.value, language, 'updateStep2EmailError')"
                                :value="form['step_2_email_error'] && form['step_2_email_error'][
                                    `step_2_email_error_${language.id}`
                                ] ? form['step_2_email_error'][`step_2_email_error_${language.id}`] : ''" />
                                    <p class="mt-2 text-sm text-red-400"
                                        v-if="validationErros.has(`step_2_email_error.step_2_email_error_${language.id}`)"
                                v-text="validationErros.get(`step_2_email_error.step_2_email_error_${language.id}`)">
                                    </p>
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-6">
                                <label :for="`step_2_email_placeholder_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Placeholder for email</label>
                                <div class="mt-2">
                                    <input type="text" :name="`step_2_email_placeholder_${language.id}`"
                                :id="`step_2_email_placeholder_${language.id}`"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                placeholder=" "
                                @input="handleInput($event.target.value, language, 'updateStep2EmailPlaceholder')"
                                :value="form['step_2_email_placeholder'] && form['step_2_email_placeholder'][
                                        `step_2_email_placeholder_${language.id}`
                                    ] ? form['step_2_email_placeholder'][
                                    `step_2_email_placeholder_${language.id}`] : ''" />
                                    <p class="mt-2 text-sm text-red-400"
                                        v-if="validationErros.has(`step_2_email_placeholder.step_2_email_placeholder_${language.id}`)"
                                v-text="validationErros.get(`step_2_email_placeholder.step_2_email_placeholder_${language.id}`)">
                                    </p>
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-6">
                                <label :for="`step_2_password_label_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Label for password</label>
                                <div class="mt-2">
                                    <input type="text" :name="`step_2_password_label_${language.id}`"
                                :id="`step_2_password_label_${language.id}`"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                placeholder=" "
                                @input="handleInput($event.target.value, language, 'updateStep2PasswordLabel')"
                                :value="form['step_2_password_label'] && form['step_2_password_label'][
                                    `step_2_password_label_${language.id}`
                                ] ? form['step_2_password_label'][`step_2_password_label_${language.id}`] : ''" />
                                    <p class="mt-2 text-sm text-red-400"
                                        v-if="validationErros.has(`step_2_password_label.step_2_password_label_${language.id}`)"
                                v-text="validationErros.get(`step_2_password_label.step_2_password_label_${language.id}`)">
                                    </p>
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-6">
                                <label :for="`step_2_password_error_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Error message for password</label>
                                <div class="mt-2">
                                    <input type="text" :name="`step_2_password_error_${language.id}`"
                                :id="`step_2_password_error_${language.id}`"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                placeholder=" "
                                @input="handleInput($event.target.value, language, 'updateStep2PasswordError')"
                                :value="form['step_2_password_error'] && form['step_2_password_error'][
                                    `step_2_password_error_${language.id}`
                                ] ? form['step_2_password_error'][`step_2_password_error_${language.id}`] : ''" />
                                    <p class="mt-2 text-sm text-red-400"
                                        v-if="validationErros.has(`step_2_password_error.step_2_password_error_${language.id}`)"
                                v-text="validationErros.get(`step_2_password_error.step_2_password_error_${language.id}`)">
                                    </p>
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-6">
                                <label :for="`step_2_password_placeholder_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Placeholder for password</label>
                                <div class="mt-2">
                                    <input type="text" :name="`step_2_password_placeholder_${language.id}`"
                                :id="`step_2_password_placeholder_${language.id}`"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                placeholder=" "
                                @input="handleInput($event.target.value, language, 'updateStep2PasswordPlaceholder')"
                                :value="form['step_2_password_placeholder'] && form['step_2_password_placeholder'][
                                    `step_2_password_placeholder_${language.id}`
                                ] ? form['step_2_password_placeholder'][
                                    `step_2_password_placeholder_${language.id}`
                                ] : ''" />
                                    <p class="mt-2 text-sm text-red-400"
                                        v-if="validationErros.has(`step_2_password_placeholder.step_2_password_placeholder_${language.id}`)"
                                v-text="validationErros.get(`step_2_password_placeholder.step_2_password_placeholder_${language.id}`)">
                                    </p>
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-6">
                                <label :for="`step_2_confirm_password_label_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Label for confirm password</label>
                                <div class="mt-2">
                                    <input type="text" :name="`step_2_confirm_password_label_${language.id}`"
                                :id="`step_2_confirm_password_label_${language.id}`"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                placeholder=" "
                                @input="handleInput($event.target.value, language, 'updateStep2ConfirmPasswordLabel')"
                                :value="form['step_2_confirm_password_label'] && form['step_2_confirm_password_label'][
                                    `step_2_confirm_password_label_${language.id}`
                                ] ? form['step_2_confirm_password_label'][
                                    `step_2_confirm_password_label_${language.id}`
                                ] : ''" />
                                    <p class="mt-2 text-sm text-red-400"
                                        v-if="validationErros.has(`step_2_confirm_password_label.step_2_confirm_password_label_${language.id}`)"
                                v-text="validationErros.get(`step_2_confirm_password_label.step_2_confirm_password_label_${language.id}`)">
                                    </p>
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-6">
                                <label :for="`step_2_confirm_password_error_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Error message for confirm password</label>
                                <div class="mt-2">
                                    <input type="text" :name="`step_2_confirm_password_error_${language.id}`"
                                :id="`step_2_confirm_password_error_${language.id}`"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                placeholder=" "
                                @input="handleInput($event.target.value, language, 'updateStep2ConfirmPasswordError')"
                                :value="form['step_2_confirm_password_error'] && form['step_2_confirm_password_error'][
                                    `step_2_confirm_password_error_${language.id}`
                                ] ? form['step_2_confirm_password_error'][
                                    `step_2_confirm_password_error_${language.id}`
                                ] : ''" />
                                    <p class="mt-2 text-sm text-red-400"
                                        v-if="validationErros.has(`step_2_confirm_password_error.step_2_confirm_password_error_${language.id}`)"
                                v-text="validationErros.get(`step_2_confirm_password_error.step_2_confirm_password_error_${language.id}`)">
                                    </p>
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-6">
                                <label :for="`step_2_confirm_password_placeholder_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Placeholder for confirm password</label>
                                <div class="mt-2">
                                    <input type="text" :name="`step_2_confirm_password_placeholder_${language.id}`"
                                :id="`step_2_confirm_password_placeholder_${language.id}`"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                placeholder=" "
                                @input="handleInput($event.target.value, language, 'updateStep2ConfirmPasswordPlaceholder')"
                                :value="form['step_2_confirm_password_placeholder'] && form[
                                    'step_2_confirm_password_placeholder'][
                                    `step_2_confirm_password_placeholder_${language.id}`
                                ] ? form['step_2_confirm_password_placeholder'][
                                    `step_2_confirm_password_placeholder_${language.id}`
                                ] : ''" />
                                    <p class="mt-2 text-sm text-red-400"
                                        v-if="validationErros.has(`step_2_confirm_password_placeholder.step_2_confirm_password_placeholder_${language.id}`)"
                                v-text="validationErros.get(`step_2_confirm_password_placeholder.step_2_confirm_password_placeholder_${language.id}`)">
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border rounded w-full" :class="collapseStates[3] ? 'bg-gray-50' : ''">
                    <div class="flex justify-between bg-blue-600 text-white p-4 cursor-pointer"
                        @click.prevent="collapseStates[3] = !collapseStates[3]">
                        <h2 class="text-lg font-medium">3 of 4 - Select your business categories (industry sectors)
                        </h2>
                        <svg class="w-5 h-5 fill-current text-gray-500" viewBox="0 0 20 20">
                            <path d="M6 9l4 4 4-4"></path>
                        </svg>
                    </div>
                    <div class="p-4 bg-gray-100 border-t" v-show="collapseStates[3]">
                        <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2  lg:grid-cols-2 gap-6 ">
                            <div class="relative z-0 w-full mb-6">
                                <label :for="`step_3_heading_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Section Heading</label>
                                <div class="mt-2">
                                    <div class="mt-5 ckeditorText" :id="`step_3_heading_${language.id}`"></div>
                                    <p class="mt-2 text-sm text-red-400"
                                        v-if="validationErros.has(`step_3_heading.step_3_heading_${language.id}`)"
                                    v-text="validationErros.get(`step_3_heading.step_3_heading_${language.id}`)">
                                    </p>
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-6">
                                <label :for="`step_3_acc_heading_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Business categories heading</label>
                                <div class="mt-2">
                                    <div class="mt-5 ckeditorText" :id="`step_3_acc_heading_${language.id}`"></div>
                                    <p class="mt-2 text-sm text-red-400"
                                        v-if="validationErros.has(`step_3_acc_heading.step_3_acc_heading_${language.id}`)"
                                    v-text="validationErros.get(`step_3_acc_heading.step_3_acc_heading_${language.id}`)">
                                    </p>
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-6">
                                <label :for="`step_3_description_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Section description</label>
                                <div class="mt-2">
                                    <div class="mt-5 ckeditorText" :id="`step_3_description_${language.id}`"></div>
                                    <p class="mt-2 text-sm text-red-400"
                                        v-if="validationErros.has(`step_3_description.step_3_description_${language.id}`)"
                                    v-text="validationErros.get(`step_3_description.step_3_description_${language.id}`)">
                                    </p>
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-6">
                                <label :for="`step_3_business_categories_label_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Label for business categories</label>
                                <div class="mt-2">
                                    <input type="text" :name="`step_3_business_categories_label_${language.id}`"
                                    :id="`step_3_business_categories_label_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep3BusinessCategoriesLabel')"
                                    :value="form['step_3_business_categories_label'] && form['step_3_business_categories_label']
                                        [`step_3_business_categories_label_${language.id}`] ? form[
                                            'step_3_business_categories_label'][
                                            `step_3_business_categories_label_${language.id}`
                                        ] : ''" />
                                    <p class="mt-2 text-sm text-red-400"
                                        v-if="validationErros.has(`step_3_business_categories_label.step_3_business_categories_label_${language.id}`)"
                                    v-text="validationErros.get(`step_3_business_categories_label.step_3_business_categories_label_${language.id}`)">
                                    </p>
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-6">
                                <label :for="`step_3_business_categories_error_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Error message for business categories</label>
                                <div class="mt-2">
                                    <input type="text" :name="`step_3_business_categories_error_${language.id}`"
                                    :id="`step_3_business_categories_error_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep3BusinessCategoriesError')"
                                    :value="form['step_3_business_categories_error'] && form['step_3_business_categories_error']
                                        [`step_3_business_categories_error_${language.id}`] ? form[
                                            'step_3_business_categories_error'][
                                            `step_3_business_categories_error_${language.id}`
                                        ] : ''" />
                                    <p class="mt-2 text-sm text-red-400"
                                        v-if="validationErros.has(`step_3_business_categories_error.step_3_business_categories_error_${language.id}`)"
                                    v-text="validationErros.get(`step_3_business_categories_error.step_3_business_categories_error_${language.id}`)">
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border rounded w-full" :class="collapseStates[4] ? 'bg-gray-50' : ''">
                    <div class="flex justify-between bg-blue-600 text-white p-4 cursor-pointer"
                        @click.prevent="collapseStates[4] = !collapseStates[4]">
                        <h2 class="text-lg font-medium">4 of 4 - Business Profile</h2>
                        <svg class="w-5 h-5 fill-current text-gray-500" viewBox="0 0 20 20">
                            <path d="M6 9l4 4 4-4"></path>
                        </svg>
                    </div>
                    <div class="p-4 bg-gray-100 border-t" v-show="collapseStates[4]">
                        <div class="grid my-5 grid-cols-1 md:grid-cols-3 md:gap-6">
                            <div class="relative z-0 w-full mb-6 col-span-3">
                                <label :for="`step_4_heading_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Section Heading</label>
                                <div class="mt-2">
                                    <div class="mt-5 ckeditorText" :id="`step_4_heading_${language.id}`"></div>
                                    <p class="mt-2 text-sm text-red-400"
                                        v-if="validationErros.has(`step_4_heading.step_4_heading_${language.id}`)"
                                    v-text="validationErros.get(`step_4_heading.step_4_heading_${language.id}`)">
                                    </p>
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-6 col-span-3">
                                <label :for="`step_4_acc_heading_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Business Profile heading</label>
                                <div class="mt-2">
                                    <div class="mt-5 ckeditorText" :id="`step_4_acc_heading_${language.id}`"></div>
                                    <p class="mt-2 text-sm text-red-400"
                                        v-if="validationErros.has(`step_4_acc_heading.step_4_acc_heading_${language.id}`)"
                                    v-text="validationErros.get(`step_4_acc_heading.step_4_acc_heading_${language.id}`)">
                                    </p>
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-6">
                                <label :for="`step_4_name_label_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Label for name</label>
                                <div class="mt-2">
                                    <input type="text" :name="`step_4_name_label_${language.id}`"
                                    :id="`step_4_name_label_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4NameLabel')"
                                    :value="form['step_4_name_label'] && form['step_4_name_label'][
                                        `step_4_name_label_${language.id}`
                                    ] ? form['step_4_name_label'][`step_4_name_label_${language.id}`] : ''" />
                                    <p class="mt-2 text-sm text-red-400"
                                        v-if="validationErros.has(`step_4_name_label.step_4_name_label_${language.id}`)"
                                    v-text="validationErros.get(`step_4_name_label.step_4_name_label_${language.id}`)">
                                    </p>
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-6">
                                <label :for="`step_4_name_error_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Error message for name</label>
                                <div class="mt-2">
                                    <input type="text" :name="`step_4_name_error_${language.id}`"
                                    :id="`step_4_name_error_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4NameError')"
                                    :value="form['step_4_name_error'] && form['step_4_name_error'][
                                        `step_4_name_error_${language.id}`
                                    ] ? form['step_4_name_error'][`step_4_name_error_${language.id}`] : ''" />
                                    <p class="mt-2 text-sm text-red-400"
                                        v-if="validationErros.has(`step_4_name_error.step_4_name_error_${language.id}`)"
                                    v-text="validationErros.get(`step_4_name_error.step_4_name_error_${language.id}`)">
                                    </p>
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-6">
                                <label :for="`step_4_name_placeholder_${language.id}`" class="block text-sm font-medium leading-6 text-gray-900">Pleaceholder for name</label>
                                <div class="mt-2">
                                    <input type="text" :name="`step_4_name_placeholder_${language.id}`"
                                    :id="`step_4_name_placeholder_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4NamePlaceholder')"
                                    :value="form['step_4_name_placeholder'] && form['step_4_name_placeholder'][
                                            `step_4_name_placeholder_${language.id}`
                                        ] ? form['step_4_name_placeholder'][`step_4_name_placeholder_${language.id}`] :
                                        ''" />
                                    <p class="mt-2 text-sm text-red-400"
                                        v-if="validationErros.has(`step_4_name_placeholder.step_4_name_placeholder_${language.id}`)"
                                    v-text="validationErros.get(`step_4_name_placeholder.step_4_name_placeholder_${language.id}`)">
                                    </p>
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_4_email_label_${language.id}`"
                                    :id="`step_4_email_label_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4EmailLabel')"
                                    :value="form['step_4_email_label'] && form['step_4_email_label'][
                                        `step_4_email_label_${language.id}`
                                    ] ? form['step_4_email_label'][`step_4_email_label_${language.id}`] : ''" />
                                <label :for="`step_4_email_label_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email
                                    label</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_4_email_label.step_4_email_label_${language.id}`)"
                                    v-text="validationErros.get(`step_4_email_label.step_4_email_label_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_4_email_error_${language.id}`"
                                    :id="`step_4_email_error_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4EmailError')"
                                    :value="form['step_4_email_error'] && form['step_4_email_error'][
                                        `step_4_email_error_${language.id}`
                                    ] ? form['step_4_email_error'][`step_4_email_error_${language.id}`] : ''" />
                                <label :for="`step_4_email_error_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email
                                    error</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_4_email_error.step_4_email_error_${language.id}`)"
                                    v-text="validationErros.get(`step_4_email_error.step_4_email_error_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_4_email_placeholder_${language.id}`"
                                    :id="`step_4_email_placeholder_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4EmailPlaceholder')"
                                    :value="form['step_4_email_placeholder'] && form['step_4_email_placeholder'][
                                            `step_4_email_placeholder_${language.id}`
                                        ] ? form['step_4_email_placeholder'][
                                        `step_4_email_placeholder_${language.id}`] : ''" />
                                <label :for="`step_4_email_placeholder_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email
                                    placeholder</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_4_email_placeholder.step_4_email_placeholder_${language.id}`)"
                                    v-text="validationErros.get(`step_4_email_placeholder.step_4_email_placeholder_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_4_cta_link_label_${language.id}`"
                                    :id="`step_4_cta_link_label_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4CtaLinkLabel')"
                                    :value="form['step_4_cta_link_label'] && form['step_4_cta_link_label'][
                                        `step_4_cta_link_label_${language.id}`
                                    ] ? form['step_4_cta_link_label'][`step_4_cta_link_label_${language.id}`] : ''" />
                                <label :for="`step_4_cta_link_label_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Cta Link
                                    label</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_4_cta_link_label.step_4_cta_link_label_${language.id}`)"
                                    v-text="validationErros.get(`step_4_cta_link_label.step_4_cta_link_label_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_4_cta_link_error_${language.id}`"
                                    :id="`step_4_cta_link_error_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4CtaLinkError')"
                                    :value="form['step_4_cta_link_error'] && form['step_4_cta_link_error'][
                                        `step_4_cta_link_error_${language.id}`
                                    ] ? form['step_4_cta_link_error'][`step_4_cta_link_error_${language.id}`] : ''" />
                                <label :for="`step_4_cta_link_error_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Cta link
                                    error</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_4_cta_link_error.step_4_cta_link_error_${language.id}`)"
                                    v-text="validationErros.get(`step_4_cta_link_error.step_4_cta_link_error_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_4_cta_link_placeholder_${language.id}`"
                                    :id="`step_4_cta_link_placeholder_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4CtaLinkPlaceholder')"
                                    :value="form['step_4_cta_link_placeholder'] && form['step_4_cta_link_placeholder'][
                                            `step_4_cta_link_placeholder_${language.id}`
                                        ] ? form['step_4_cta_link_placeholder'][
                                        `step_4_cta_link_placeholder_${language.id}`] : ''" />
                                <label :for="`step_4_cta_link_placeholder_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Cta Link
                                    placeholder</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_4_cta_link_placeholder.step_4_cta_link_placeholder_${language.id}`)"
                                    v-text="validationErros.get(`step_4_cta_link_placeholder.step_4_cta_link_placeholder_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_4_cta_btn_label_${language.id}`"
                                    :id="`step_4_cta_btn_label_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4CtaBtnLabel')"
                                    :value="form['step_4_cta_btn_label'] && form['step_4_cta_btn_label'][
                                        `step_4_cta_btn_label_${language.id}`
                                    ] ? form['step_4_cta_btn_label'][`step_4_cta_btn_label_${language.id}`] : ''" />
                                <label :for="`step_4_cta_btn_label_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Cta Btn
                                    label</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_4_cta_btn_label.step_4_cta_btn_label_${language.id}`)"
                                    v-text="validationErros.get(`step_4_cta_btn_label.step_4_cta_btn_label_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_4_cta_btn_error_${language.id}`"
                                    :id="`step_4_cta_btn_error_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4CtaBtnError')"
                                    :value="form['step_4_cta_btn_error'] && form['step_4_cta_Btn_error'][
                                        `step_4_cta_btn_error_${language.id}`
                                    ] ? form['step_4_cta_btn_error'][`step_4_cta_btn_error_${language.id}`] : ''" />
                                <label :for="`step_4_cta_btn_error_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Cta Btn
                                    error</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_4_cta_btn_error.step_4_cta_btn_error_${language.id}`)"
                                    v-text="validationErros.get(`step_4_cta_btn_error.step_4_cta_btn_error_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_4_cta_btn_placeholder_${language.id}`"
                                    :id="`step_4_cta_btn_placeholder_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4CtaBtnPlaceholder')"
                                    :value="form['step_4_cta_btn_placeholder'] && form['step_4_cta_btn_placeholder'][
                                            `step_4_cta_btn_placeholder_${language.id}`
                                        ] ? form['step_4_cta_btn_placeholder'][
                                        `step_4_cta_btn_placeholder_${language.id}`] : ''" />
                                <label :for="`step_4_cta_btn_placeholder_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Cta Btn
                                    placeholder</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_4_cta_btn_placeholder.step_4_cta_btn_placeholder_${language.id}`)"
                                    v-text="validationErros.get(`step_4_cta_btn_placeholder.step_4_cta_btn_placeholder_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_4_address_label_${language.id}`"
                                    :id="`step_4_address_label_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4AddressLabel')"
                                    :value="form['step_4_address_label'] && form['step_4_address_label'][
                                        `step_4_address_label_${language.id}`
                                    ] ? form['step_4_address_label'][`step_4_address_label_${language.id}`] : ''" />
                                <label :for="`step_4_address_label_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Address
                                    label</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_4_address_label.step_4_address_label_${language.id}`)"
                                    v-text="validationErros.get(`step_4_address_label.step_4_address_label_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_4_address_error_${language.id}`"
                                    :id="`step_4_address_error_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4AddressError')"
                                    :value="form['step_4_address_error'] && form['step_4_address_error'][
                                        `step_4_address_error_${language.id}`
                                    ] ? form['step_4_address_error'][`step_4_address_error_${language.id}`] : ''" />
                                <label :for="`step_4_address_error_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Address
                                    error</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_4_address_error.step_4_address_error_${language.id}`)"
                                    v-text="validationErros.get(`step_4_address_error.step_4_address_error_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_4_address_placeholder_${language.id}`"
                                    :id="`step_4_address_placeholder_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4AddressPlaceholder')"
                                    :value="form['step_4_address_placeholder'] && form['step_4_address_placeholder'][
                                        `step_4_address_placeholder_${language.id}`
                                    ] ? form['step_4_address_placeholder'][
                                        `step_4_address_placeholder_${language.id}`
                                    ] : ''" />
                                <label :for="`step_4_address_placeholder_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Address
                                    placeholder</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_4_address_placeholder.step_4_address_placeholder_${language.id}`)"
                                    v-text="validationErros.get(`step_4_address_placeholder.step_4_address_placeholder_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_4_phone_label_${language.id}`"
                                    :id="`step_4_phone_label_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4PhoneLabel')"
                                    :value="form['step_4_phone_label'] && form['step_4_phone_label'][
                                        `step_4_phone_label_${language.id}`
                                    ] ? form['step_4_phone_label'][`step_4_phone_label_${language.id}`] : ''" />
                                <label :for="`step_4_phone_label_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Phone
                                    label</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_4_phone_label.step_4_phone_label_${language.id}`)"
                                    v-text="validationErros.get(`step_4_phone_label.step_4_phone_label_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_4_phone_error_${language.id}`"
                                    :id="`step_4_phone_error_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4PhoneError')"
                                    :value="form['step_4_phone_error'] && form['step_4_phone_error'][
                                        `step_4_phone_error_${language.id}`
                                    ] ? form['step_4_phone_error'][`step_4_phone_error_${language.id}`] : ''" />
                                <label :for="`step_4_phone_error_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Phone
                                    error</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_4_phone_error.step_4_phone_error_${language.id}`)"
                                    v-text="validationErros.get(`step_4_phone_error.step_4_phone_error_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_4_phone_placeholder_${language.id}`"
                                    :id="`step_4_phone_placeholder_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4PhonePlaceholder')"
                                    :value="form['step_4_phone_placeholder'] && form['step_4_phone_placeholder'][
                                            `step_4_phone_placeholder_${language.id}`
                                        ] ? form['step_4_phone_placeholder'][
                                        `step_4_phone_placeholder_${language.id}`] : ''" />
                                <label :for="`step_4_phone_placeholder_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Phone
                                    placeholder</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_4_phone_placeholder.step_4_phone_placeholder_${language.id}`)"
                                    v-text="validationErros.get(`step_4_phone_placeholder.step_4_phone_placeholder_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_4_website_label_${language.id}`"
                                    :id="`step_4_website_label_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4WebsiteLabel')"
                                    :value="form['step_4_website_label'] && form['step_4_website_label'][
                                        `step_4_website_label_${language.id}`
                                    ] ? form['step_4_website_label'][`step_4_website_label_${language.id}`] : ''" />
                                <label :for="`step_4_website_label_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Website
                                    label</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_4_website_label.step_4_website_label_${language.id}`)"
                                    v-text="validationErros.get(`step_4_website_label.step_4_website_label_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_4_website_error_${language.id}`"
                                    :id="`step_4_website_error_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4WebsiteError')"
                                    :value="form['step_4_website_error'] && form['step_4_website_error'][
                                        `step_4_website_error_${language.id}`
                                    ] ? form['step_4_website_error'][`step_4_website_error_${language.id}`] : ''" />
                                <label :for="`step_4_website_error_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Website
                                    error</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_4_website_error.step_4_website_error_${language.id}`)"
                                    v-text="validationErros.get(`step_4_website_error.step_4_website_error_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_4_website_placeholder_${language.id}`"
                                    :id="`step_4_website_placeholder_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4WebsitePlaceholder')"
                                    :value="form['step_4_website_placeholder'] && form['step_4_website_placeholder'][
                                        `step_4_website_placeholder_${language.id}`
                                    ] ? form['step_4_website_placeholder'][
                                        `step_4_website_placeholder_${language.id}`
                                    ] : ''" />
                                <label :for="`step_4_website_placeholder_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Website
                                    placeholder</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_4_website_placeholder.step_4_website_placeholder_${language.id}`)"
                                    v-text="validationErros.get(`step_4_website_placeholder.step_4_website_placeholder_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_4_short_description_label_${language.id}`"
                                    :id="`step_4_short_description_label_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4ShortDescriptionLabel')"
                                    :value="form['step_4_short_description_label'] && form['step_4_short_description_label'][
                                        `step_4_short_description_label_${language.id}`
                                    ] ? form['step_4_short_description_label'][
                                        `step_4_short_description_label_${language.id}`
                                    ] : ''" />
                                <label :for="`step_4_short_description_label_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Short
                                    description label</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_4_short_description_label.step_4_short_description_label_${language.id}`)"
                                    v-text="validationErros.get(`step_4_short_description_label.step_4_short_description_label_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_4_short_description_error_${language.id}`"
                                    :id="`step_4_short_description_error_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4ShortDescriptionError')"
                                    :value="form['step_4_short_description_error'] && form['step_4_short_description_error'][
                                        `step_4_short_description_error_${language.id}`
                                    ] ? form['step_4_short_description_error'][
                                        `step_4_short_description_error_${language.id}`
                                    ] : ''" />
                                <label :for="`step_4_short_description_error_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Short
                                    description error</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_4_short_description_error.step_4_short_description_error_${language.id}`)"
                                    v-text="validationErros.get(`step_4_short_description_error.step_4_short_description_error_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_4_short_description_placeholder_${language.id}`"
                                    :id="`step_4_short_description_placeholder_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4ShortDescriptionPlaceholder')"
                                    :value="form['step_4_short_description_placeholder'] && form[
                                        'step_4_short_description_placeholder'][
                                        `step_4_short_description_placeholder_${language.id}`
                                    ] ? form['step_4_short_description_placeholder'][
                                        `step_4_short_description_placeholder_${language.id}`
                                    ] : ''" />
                                <label :for="`step_4_short_description_placeholder_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Short
                                    description placeholder</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_4_short_description_placeholder.step_4_short_description_placeholder_${language.id}`)"
                                    v-text="validationErros.get(`step_4_short_description_placeholder.step_4_short_description_placeholder_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_4_description_label_${language.id}`"
                                    :id="`step_4_description_label_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4DescriptionLabel')"
                                    :value="form['step_4_description_label'] && form['step_4_description_label'][
                                            `step_4_description_label_${language.id}`
                                        ] ? form['step_4_description_label'][
                                        `step_4_description_label_${language.id}`] : ''" />
                                <label :for="`step_4_description_label_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Description
                                    label</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_4_description_label.step_4_description_label_${language.id}`)"
                                    v-text="validationErros.get(`step_4_description_label.step_4_description_label_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_4_description_error_${language.id}`"
                                    :id="`step_4_description_error_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4DescriptionError')"
                                    :value="form['step_4_description_error'] && form['step_4_description_error'][
                                            `step_4_description_error_${language.id}`
                                        ] ? form['step_4_description_error'][
                                        `step_4_description_error_${language.id}`] : ''" />
                                <label :for="`step_4_description_error_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Description
                                    error</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_4_description_error.step_4_description_error_${language.id}`)"
                                    v-text="validationErros.get(`step_4_description_error.step_4_description_error_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_4_description_placeholder_${language.id}`"
                                    :id="`step_4_description_placeholder_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4DescriptionPlaceholder')"
                                    :value="form['step_4_description_placeholder'] && form['step_4_description_placeholder'][
                                        `step_4_description_placeholder_${language.id}`
                                    ] ? form['step_4_description_placeholder'][
                                        `step_4_description_placeholder_${language.id}`
                                    ] : ''" />
                                <label :for="`step_4_description_placeholder_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Description
                                    placeholder</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_4_description_placeholder.step_4_description_placeholder_${language.id}`)"
                                    v-text="validationErros.get(`step_4_description_placeholder.step_4_description_placeholder_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_4_keywords_label_${language.id}`"
                                    :id="`step_4_keywords_label_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4KeywordsLabel')"
                                    :value="form['step_4_keywords_label'] && form['step_4_keywords_label'][
                                        `step_4_keywords_label_${language.id}`
                                    ] ? form['step_4_keywords_label'][`step_4_keywords_label_${language.id}`] : ''" />
                                <label :for="`step_4_keywords_label_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Keyword
                                    label</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_4_keywords_label.step_4_keywords_label_${language.id}`)"
                                    v-text="validationErros.get(`step_4_keywords_label.step_4_keywords_label_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_4_keywords_error_${language.id}`"
                                    :id="`step_4_keywords_error_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4KeywordsError')"
                                    :value="form['step_4_keywords_error'] && form['step_4_keywords_error'][
                                        `step_4_keywords_error_${language.id}`
                                    ] ? form['step_4_keywords_error'][`step_4_keywords_error_${language.id}`] : ''" />
                                <label :for="`step_4_keywords_error_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Keyword
                                    error</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_4_keywords_error.step_4_keywords_error_${language.id}`)"
                                    v-text="validationErros.get(`step_4_keywords_error.step_4_keywords_error_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_4_keywords_placeholder_${language.id}`"
                                    :id="`step_4_keywords_placeholder_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep4KeywordsPlaceholder')"
                                    :value="form['step_4_keywords_placeholder'] && form['step_4_keywords_placeholder'][
                                        `step_4_keywords_placeholder_${language.id}`
                                    ] ? form['step_4_keywords_placeholder'][
                                        `step_4_keywords_placeholder_${language.id}`
                                    ] : ''" />
                                <label :for="`step_4_keywords_placeholder_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Keyword
                                    placeholder</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_4_keywords_placeholder.step_4_keywords_placeholder_${language.id}`)"
                                    v-text="validationErros.get(`step_4_keywords_placeholder.step_4_keywords_placeholder_${language.id}`)">
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border rounded w-full" :class="collapseStates[5] ? 'bg-gray-50' : ''">
                    <div class="flex justify-between bg-blue-600 text-white p-4 cursor-pointer"
                        @click.prevent="collapseStates[5] = !collapseStates[5]">
                        <h2 class="text-lg font-medium">Media (Optional)</h2>
                        <svg class="w-5 h-5 fill-current text-gray-500" viewBox="0 0 20 20">
                            <path d="M6 9l4 4 4-4"></path>
                        </svg>
                    </div>
                    <div class="p-4 bg-gray-100 border-t" v-show="collapseStates[5]">
                        <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2  lg:grid-cols-2 gap-6 ">
                            <div class="relative z-0 w-full mb-6 group">
                                <div class="mt-5 ckeditorText" :id="`step_5_heading_${language.id}`"></div>
                                <!-- <input type="text" :name="`step_5_heading_${language.id}`"
                                    :id="`step_5_heading_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep5Heading')"
                                    :value="form['step_5_heading'] && form['step_5_heading'][`step_5_heading_${language.id}`] ?
                                        form['step_5_heading'][`step_5_heading_${language.id}`] : ''" /> -->
                                <label :for="`step_5_heading_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Heading</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_5_heading.step_5_heading_${language.id}`)"
                                    v-text="validationErros.get(`step_5_heading.step_5_heading_${language.id}`)"></p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <div class="mt-5 ckeditorText" :id="`step_5_acc_heading_${language.id}`"></div>
                                <label :for="`step_5_acc_heading_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Heading</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_5_acc_heading.step_5_acc_heading_${language.id}`)"
                                    v-text="validationErros.get(`step_5_acc_heading.step_5_acc_heading_${language.id}`)"></p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_5_title_label_${language.id}`"
                                    :id="`step_5_title_label_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep5TitleLabel')"
                                    :value="form['step_5_title_label'] && form['step_5_title_label'][
                                        `step_5_title_label_${language.id}`
                                    ] ? form['step_5_title_label'][`step_5_title_label_${language.id}`] : ''" />
                                <label :for="`step_5_title_label_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Title input label</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_5_title_label.step_5_title_label_${language.id}`)"
                                    v-text="validationErros.get(`step_5_title_label.step_5_title_label_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_5_title_error_${language.id}`"
                                    :id="`step_5_title_error_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep5TitleError')"
                                    :value="form['step_5_title_error'] && form['step_5_title_error'][
                                        `step_5_title_error_${language.id}`
                                    ] ? form['step_5_title_error'][`step_5_title_error_${language.id}`] : ''" />
                                <label :for="`step_5_title_error_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Title input error</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_5_title_error.step_5_title_error_${language.id}`)"
                                    v-text="validationErros.get(`step_5_title_error.step_5_title_error_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_5_description_label_${language.id}`"
                                    :id="`step_5_description_label_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep5DescriptionLabel')"
                                    :value="form['step_5_description_label'] && form['step_5_description_label'][
                                        `step_5_description_label_${language.id}`
                                    ] ? form['step_5_description_label'][`step_5_description_label_${language.id}`] : ''" />
                                <label :for="`step_5_description_label_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Description input label</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_5_description_label.step_5_description_label_${language.id}`)"
                                    v-text="validationErros.get(`step_5_description_label.step_5_description_label_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_5_description_error_${language.id}`"
                                    :id="`step_5_description_error_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep5DescriptionError')"
                                    :value="form['step_5_description_error'] && form['step_5_description_error'][
                                        `step_5_description_error_${language.id}`
                                    ] ? form['step_5_description_error'][`step_5_description_error_${language.id}`] : ''" />
                                <label :for="`step_5_description_error_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Description input error</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_5_description_error.step_5_description_error_${language.id}`)"
                                    v-text="validationErros.get(`step_5_description_error.step_5_description_error_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_5_logo_label_${language.id}`"
                                    :id="`step_5_logo_label_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep5LogoLabel')"
                                    :value="form['step_5_logo_label'] && form['step_5_logo_label'][
                                        `step_5_logo_label_${language.id}`
                                    ] ? form['step_5_logo_label'][`step_5_logo_label_${language.id}`] : ''" />
                                <label :for="`step_5_logo_label_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Logo
                                    label</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_5_logo_label.step_5_logo_label_${language.id}`)"
                                    v-text="validationErros.get(`step_5_logo_label.step_5_logo_label_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_5_logo_error_${language.id}`"
                                    :id="`step_5_logo_error_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep5LogoError')"
                                    :value="form['step_5_logo_error'] && form['step_5_logo_error'][
                                        `step_5_logo_error_${language.id}`
                                    ] ? form['step_5_logo_error'][`step_5_logo_error_${language.id}`] : ''" />
                                <label :for="`step_5_logo_error_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Logo
                                    error</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_5_logo_error.step_5_logo_error_${language.id}`)"
                                    v-text="validationErros.get(`step_5_logo_error.step_5_logo_error_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_5_logo_placeholder_${language.id}`"
                                    :id="`step_5_logo_placeholder_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep5LogoPlaceholder')"
                                    :value="form['step_5_logo_placeholder'] && form['step_5_logo_placeholder'][
                                            `step_5_logo_placeholder_${language.id}`
                                        ] ? form['step_5_logo_placeholder'][`step_5_logo_placeholder_${language.id}`] :
                                        ''" />
                                <label :for="`step_5_logo_placeholder_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Logo
                                    placeholder</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_5_logo_placeholder.step_5_logo_placeholder_${language.id}`)"
                                    v-text="validationErros.get(`step_5_logo_placeholder.step_5_logo_placeholder_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_5_video_label_${language.id}`"
                                    :id="`step_5_video_label_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep5VideoLabel')"
                                    :value="form['step_5_video_label'] && form['step_5_video_label'][
                                        `step_5_video_label_${language.id}`
                                    ] ? form['step_5_video_label'][`step_5_video_label_${language.id}`] : ''" />
                                <label :for="`step_5_video_label_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Video
                                    label</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_5_video_label.step_5_video_label_${language.id}`)"
                                    v-text="validationErros.get(`step_5_video_label.step_5_video_label_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_5_video_error_${language.id}`"
                                    :id="`step_5_video_error_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep5VideoError')"
                                    :value="form['step_5_video_error'] && form['step_5_video_error'][
                                        `step_5_video_error_${language.id}`
                                    ] ? form['step_5_video_error'][`step_5_video_error_${language.id}`] : ''" />
                                <label :for="`step_5_video_error_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Video
                                    error</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_5_video_error.step_5_video_error_${language.id}`)"
                                    v-text="validationErros.get(`step_5_video_error.step_5_video_error_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_5_video_placeholder_${language.id}`"
                                    :id="`step_5_video_placeholder_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep5VideoPlaceholder')"
                                    :value="form['step_5_video_placeholder'] && form['step_5_video_placeholder'][
                                            `step_5_video_placeholder_${language.id}`
                                        ] ? form['step_5_video_placeholder'][
                                        `step_5_video_placeholder_${language.id}`] : ''" />
                                <label :for="`step_5_video_placeholder_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Video
                                    placeholder</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_5_video_placeholder.step_5_video_placeholder_${language.id}`)"
                                    v-text="validationErros.get(`step_5_video_placeholder.step_5_video_placeholder_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_5_image_1_label_${language.id}`"
                                    :id="`step_5_image_1_label_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep5Image1Label')"
                                    :value="form['step_5_image_1_label'] && form['step_5_image_1_label'][
                                        `step_5_image_1_label_${language.id}`
                                    ] ? form['step_5_image_1_label'][`step_5_image_1_label_${language.id}`] : ''" />
                                <label :for="`step_5_image_1_label_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Image
                                    1 label</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_5_image_1_label.step_5_image_1_label_${language.id}`)"
                                    v-text="validationErros.get(`step_5_image_1_label.step_5_image_1_label_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_5_image_1_error_${language.id}`"
                                    :id="`step_5_image_1_error_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep5Image1Error')"
                                    :value="form['step_5_image_1_error'] && form['step_5_image_1_error'][
                                        `step_5_image_1_error_${language.id}`
                                    ] ? form['step_5_image_1_error'][`step_5_image_1_error_${language.id}`] : ''" />
                                <label :for="`step_5_image_1_error_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Image
                                    1 error</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_5_image_1_error.step_5_image_1_error_${language.id}`)"
                                    v-text="validationErros.get(`step_5_image_1_error.step_5_image_1_error_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_5_image_1_placeholder_${language.id}`"
                                    :id="`step_5_image_1_placeholder_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep5Image1Placeholder')"
                                    :value="form['step_5_image_1_placeholder'] && form['step_5_image_1_placeholder'][
                                        `step_5_image_1_placeholder_${language.id}`
                                    ] ? form['step_5_image_1_placeholder'][
                                        `step_5_image_1_placeholder_${language.id}`
                                    ] : ''" />
                                <label :for="`step_5_image_1_placeholder_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Image
                                    1 placeholder</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_5_image_1_placeholder.step_5_image_1_placeholder_${language.id}`)"
                                    v-text="validationErros.get(`step_5_image_1_placeholder.step_5_image_1_placeholder_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_5_image_2_label_${language.id}`"
                                    :id="`step_5_image_2_label_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep5Image2Label')"
                                    :value="form['step_5_image_2_label'] && form['step_5_image_2_label'][
                                        `step_5_image_2_label_${language.id}`
                                    ] ? form['step_5_image_2_label'][`step_5_image_2_label_${language.id}`] : ''" />
                                <label :for="`step_5_image_2_label_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Image
                                    2 label</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_5_image_2_label.step_5_image_2_label_${language.id}`)"
                                    v-text="validationErros.get(`step_5_image_2_label.step_5_image_2_label_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_5_image_2_error_${language.id}`"
                                    :id="`step_5_image_2_error_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep5Image2Error')"
                                    :value="form['step_5_image_2_error'] && form['step_5_image_2_error'][
                                        `step_5_image_2_error_${language.id}`
                                    ] ? form['step_5_image_2_error'][`step_5_image_2_error_${language.id}`] : ''" />
                                <label :for="`step_5_image_2_error_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Image
                                    2 error</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_5_image_2_error.step_5_image_2_error_${language.id}`)"
                                    v-text="validationErros.get(`step_5_image_2_error.step_5_image_2_error_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_5_image_2_placeholder_${language.id}`"
                                    :id="`step_5_image_2_placeholder_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep5Image2Placeholder')"
                                    :value="form['step_5_image_2_placeholder'] && form['step_5_image_2_placeholder'][
                                        `step_5_image_2_placeholder_${language.id}`
                                    ] ? form['step_5_image_2_placeholder'][
                                        `step_5_image_2_placeholder_${language.id}`
                                    ] : ''" />
                                <label :for="`step_5_image_2_placeholder_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Image
                                    2 placeholder</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_5_image_2_placeholder.step_5_image_2_placeholder_${language.id}`)"
                                    v-text="validationErros.get(`step_5_image_2_placeholder.step_5_image_2_placeholder_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_5_image_3_label_${language.id}`"
                                    :id="`step_5_image_3_label_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep5Image3Label')"
                                    :value="form['step_5_image_3_label'] && form['step_5_image_3_label'][
                                        `step_5_image_3_label_${language.id}`
                                    ] ? form['step_5_image_3_label'][`step_5_image_3_label_${language.id}`] : ''" />
                                <label :for="`step_5_image_3_label_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Image
                                    3 label</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_5_image_3_label.step_5_image_3_label_${language.id}`)"
                                    v-text="validationErros.get(`step_5_image_3_label.step_5_image_3_label_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_5_image_3_error_${language.id}`"
                                    :id="`step_5_image_3_error_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep5Image3Error')"
                                    :value="form['step_5_image_3_error'] && form['step_5_image_3_error'][
                                        `step_5_image_3_error_${language.id}`
                                    ] ? form['step_5_image_3_error'][`step_5_image_3_error_${language.id}`] : ''" />
                                <label :for="`step_5_image_3_error_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Image
                                    3 error</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_5_image_3_error.step_5_image_3_error_${language.id}`)"
                                    v-text="validationErros.get(`step_5_image_3_error.step_5_image_3_error_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_5_image_3_placeholder_${language.id}`"
                                    :id="`step_5_image_3_placeholder_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep5Image3Placeholder')"
                                    :value="form['step_5_image_3_placeholder'] && form['step_5_image_3_placeholder'][
                                        `step_5_image_3_placeholder_${language.id}`
                                    ] ? form['step_5_image_3_placeholder'][
                                        `step_5_image_3_placeholder_${language.id}`
                                    ] : ''" />
                                <label :for="`step_5_image_3_placeholder_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Image
                                    3 placeholder</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_5_image_3_placeholder.step_5_image_3_placeholder_${language.id}`)"
                                    v-text="validationErros.get(`step_5_image_3_placeholder.step_5_image_3_placeholder_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_5_image_4_label_${language.id}`"
                                    :id="`step_5_image_4_label_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep5Image4Label')"
                                    :value="form['step_5_image_4_label'] && form['step_5_image_4_label'][
                                        `step_5_image_4_label_${language.id}`
                                    ] ? form['step_5_image_4_label'][`step_5_image_4_label_${language.id}`] : ''" />
                                <label :for="`step_5_image_4_label_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Image
                                    4 label</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_5_image_4_label.step_5_image_4_label_${language.id}`)"
                                    v-text="validationErros.get(`step_5_image_4_label.step_5_image_4_label_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_5_image_4_error_${language.id}`"
                                    :id="`step_5_image_4_error_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep5Image4Error')"
                                    :value="form['step_5_image_4_error'] && form['step_5_image_4_error'][
                                        `step_5_image_4_error_${language.id}`
                                    ] ? form['step_5_image_4_error'][`step_5_image_4_error_${language.id}`] : ''" />
                                <label :for="`step_5_image_4_error_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Image
                                    4 error</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_5_image_4_error.step_5_image_4_error_${language.id}`)"
                                    v-text="validationErros.get(`step_5_image_4_error.step_5_image_4_error_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_5_image_4_placeholder_${language.id}`"
                                    :id="`step_5_image_4_placeholder_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep5Image4Placeholder')"
                                    :value="form['step_5_image_4_placeholder'] && form['step_5_image_4_placeholder'][
                                        `step_5_image_4_placeholder_${language.id}`
                                    ] ? form['step_5_image_4_placeholder'][
                                        `step_5_image_4_placeholder_${language.id}`
                                    ] : ''" />
                                <label :for="`step_5_image_4_placeholder_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Image
                                    4 placeholder</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_5_image_4_placeholder.step_5_image_4_placeholder_${language.id}`)"
                                    v-text="validationErros.get(`step_5_image_4_placeholder.step_5_image_4_placeholder_${language.id}`)">
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border rounded w-full" :class="collapseStates[6] ? 'bg-gray-50' : ''">
                    <div class="flex justify-between bg-blue-600 text-white p-4 cursor-pointer"
                        @click.prevent="collapseStates[6] = !collapseStates[6]">
                        <h2 class="text-lg font-medium">Social Media (Optional)</h2>
                        <svg class="w-5 h-5 fill-current text-gray-500" viewBox="0 0 20 20">
                            <path d="M6 9l4 4 4-4"></path>
                        </svg>
                    </div>
                    <div class="p-4 bg-gray-100 border-t" v-show="collapseStates[6]">
                        <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2  lg:grid-cols-2 gap-6 ">
                            <div class="relative z-0 w-full mb-6 group">
                                <div class="mt-5 ckeditorText" :id="`step_6_heading_${language.id}`"></div>
                                <!-- <input type="text" :name="`step_6_heading_${language.id}`"
                                    :id="`step_6_heading_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep6Heading')"
                                    :value="form['step_6_heading'] && form['step_6_heading'][`step_6_heading_${language.id}`] ?
                                        form['step_6_heading'][`step_6_heading_${language.id}`] : ''" /> -->
                                <label :for="`step_6_heading_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Heading</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_6_heading.step_6_heading_${language.id}`)"
                                    v-text="validationErros.get(`step_6_heading.step_6_heading_${language.id}`)"></p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <div class="mt-5 ckeditorText" :id="`step_6_acc_heading_${language.id}`"></div>
                                <label :for="`step_6_acc_heading_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Heading</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_6_acc_heading.step_6_acc_heading_${language.id}`)"
                                    v-text="validationErros.get(`step_6_acc_heading.step_6_acc_heading_${language.id}`)"></p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_6_facebook_label_${language.id}`"
                                    :id="`step_6_facebook_label_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep6FacebookLabel')"
                                    :value="form['step_6_facebook_label'] && form['step_6_facebook_label'][
                                        `step_6_facebook_label_${language.id}`
                                    ] ? form['step_6_facebook_label'][`step_6_facebook_label_${language.id}`] : ''" />
                                <label :for="`step_6_facebook_label_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Facebook
                                    label</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_6_facebook_label.step_6_facebook_label_${language.id}`)"
                                    v-text="validationErros.get(`step_6_facebook_label.step_6_facebook_label_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_6_facebook_error_${language.id}`"
                                    :id="`step_6_facebook_error_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep6FacebookError')"
                                    :value="form['step_6_facebook_error'] && form['step_6_facebook_error'][
                                        `step_6_facebook_error_${language.id}`
                                    ] ? form['step_6_facebook_error'][`step_6_facebook_error_${language.id}`] : ''" />
                                <label :for="`step_6_facebook_error_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Facebook
                                    error</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_6_facebook_error.step_6_facebook_error_${language.id}`)"
                                    v-text="validationErros.get(`step_6_facebook_error.step_6_facebook_error_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_6_facebook_placeholder_${language.id}`"
                                    :id="`step_6_facebook_placeholder_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep6FacebookPlaceholder')"
                                    :value="form['step_6_facebook_placeholder'] && form['step_6_facebook_placeholder'][
                                        `step_6_facebook_placeholder_${language.id}`
                                    ] ? form['step_6_facebook_placeholder'][
                                        `step_6_facebook_placeholder_${language.id}`
                                    ] : ''" />
                                <label :for="`step_6_facebook_placeholder_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Facebook
                                    placeholder</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_6_facebook_placeholder.step_6_facebook_placeholder_${language.id}`)"
                                    v-text="validationErros.get(`step_6_facebook_placeholder.step_6_facebook_placeholder_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_6_twitter_label_${language.id}`"
                                    :id="`step_6_twitter_label_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep6TwitterLabel')"
                                    :value="form['step_6_twitter_label'] && form['step_6_twitter_label'][
                                        `step_6_twitter_label_${language.id}`
                                    ] ? form['step_6_twitter_label'][`step_6_twitter_label_${language.id}`] : ''" />
                                <label :for="`step_6_twitter_label_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Twitter
                                    label</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_6_twitter_label.step_6_twitter_label_${language.id}`)"
                                    v-text="validationErros.get(`step_6_twitter_label.step_6_twitter_label_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_6_twitter_error_${language.id}`"
                                    :id="`step_6_twitter_error_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep6TwitterError')"
                                    :value="form['step_6_twitter_error'] && form['step_6_twitter_error'][
                                        `step_6_twitter_error_${language.id}`
                                    ] ? form['step_6_twitter_error'][`step_6_twitter_error_${language.id}`] : ''" />
                                <label :for="`step_6_twitter_error_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Twitter
                                    error</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_6_twitter_error.step_6_twitter_error_${language.id}`)"
                                    v-text="validationErros.get(`step_6_twitter_error.step_6_twitter_error_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_6_twitter_placeholder_${language.id}`"
                                    :id="`step_6_twitter_placeholder_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep6TwitterPlaceholder')"
                                    :value="form['step_6_twitter_placeholder'] && form['step_6_twitter_placeholder'][
                                        `step_6_twitter_placeholder_${language.id}`
                                    ] ? form['step_6_twitter_placeholder'][
                                        `step_6_twitter_placeholder_${language.id}`
                                    ] : ''" />
                                <label :for="`step_6_twitter_placeholder_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Twitter
                                    placeholder</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_6_twitter_placeholder.step_6_twitter_placeholder_${language.id}`)"
                                    v-text="validationErros.get(`step_6_twitter_placeholder.step_6_twitter_placeholder_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_6_youtube_label_${language.id}`"
                                    :id="`step_6_youtube_label_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep6YoutubeLabel')"
                                    :value="form['step_6_youtube_label'] && form['step_6_youtube_label'][
                                        `step_6_youtube_label_${language.id}`
                                    ] ? form['step_6_youtube_label'][`step_6_youtube_label_${language.id}`] : ''" />
                                <label :for="`step_6_youtube_label_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Youtube
                                    label</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_6_youtube_label.step_6_youtube_label_${language.id}`)"
                                    v-text="validationErros.get(`step_6_youtube_label.step_6_youtube_label_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_6_youtube_error_${language.id}`"
                                    :id="`step_6_youtube_error_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep6YoutubeError')"
                                    :value="form['step_6_youtube_error'] && form['step_6_youtube_error'][
                                        `step_6_youtube_error_${language.id}`
                                    ] ? form['step_6_youtube_error'][`step_6_youtube_error_${language.id}`] : ''" />
                                <label :for="`step_6_youtube_error_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Youtube
                                    error</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_6_youtube_error.step_6_youtube_error_${language.id}`)"
                                    v-text="validationErros.get(`step_6_youtube_error.step_6_youtube_error_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_6_youtube_placeholder_${language.id}`"
                                    :id="`step_6_youtube_placeholder_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep6YoutubePlaceholder')"
                                    :value="form['step_6_youtube_placeholder'] && form['step_6_youtube_placeholder'][
                                        `step_6_youtube_placeholder_${language.id}`
                                    ] ? form['step_6_youtube_placeholder'][
                                        `step_6_youtube_placeholder_${language.id}`
                                    ] : ''" />
                                <label :for="`step_6_youtube_placeholder_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Youtube
                                    placeholder</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_6_youtube_placeholder.step_6_youtube_placeholder_${language.id}`)"
                                    v-text="validationErros.get(`step_6_youtube_placeholder.step_6_youtube_placeholder_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_6_linkedin_label_${language.id}`"
                                    :id="`step_6_linkedin_label_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep6LinkedinLabel')"
                                    :value="form['step_6_linkedin_label'] && form['step_6_linkedin_label'][
                                        `step_6_linkedin_label_${language.id}`
                                    ] ? form['step_6_linkedin_label'][`step_6_linkedin_label_${language.id}`] : ''" />
                                <label :for="`step_6_linkedin_label_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Linkedin
                                    label</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_6_linkedin_label.step_6_linkedin_label_${language.id}`)"
                                    v-text="validationErros.get(`step_6_linkedin_label.step_6_linkedin_label_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_6_linkedin_error_${language.id}`"
                                    :id="`step_6_linkedin_error_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep6LinkedinError')"
                                    :value="form['step_6_linkedin_error'] && form['step_6_linkedin_error'][
                                        `step_6_linkedin_error_${language.id}`
                                    ] ? form['step_6_linkedin_error'][`step_6_linkedin_error_${language.id}`] : ''" />
                                <label :for="`step_6_linkedin_error_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Linkedin
                                    error</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_6_linkedin_error.step_6_linkedin_error_${language.id}`)"
                                    v-text="validationErros.get(`step_6_linkedin_error.step_6_linkedin_error_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`step_6_linkedin_placeholder_${language.id}`"
                                    :id="`step_6_linkedin_placeholder_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateStep6LinkedinPlaceholder')"
                                    :value="form['step_6_linkedin_placeholder'] && form['step_6_linkedin_placeholder'][
                                        `step_6_linkedin_placeholder_${language.id}`
                                    ] ? form['step_6_linkedin_placeholder'][
                                        `step_6_linkedin_placeholder_${language.id}`
                                    ] : ''" />
                                <label :for="`step_6_linkedin_placeholder_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Linkedin
                                    placeholder</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`step_6_linkedin_placeholder.step_6_linkedin_placeholder_${language.id}`)"
                                    v-text="validationErros.get(`step_6_linkedin_placeholder.step_6_linkedin_placeholder_${language.id}`)">
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border rounded w-full" :class="collapseStates[7] ? 'bg-gray-50' : ''">
                    <div class="flex justify-between bg-blue-600 text-white p-4 cursor-pointer"
                        @click.prevent="collapseStates[7] = !collapseStates[7]">
                        <h2 class="text-lg font-medium">Other setting</h2>
                        <svg class="w-5 h-5 fill-current text-gray-500" viewBox="0 0 20 20">
                            <path d="M6 9l4 4 4-4"></path>
                        </svg>
                    </div>
                    <div class="p-4 bg-gray-100 border-t" v-show="collapseStates[7]">
                        <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2  lg:grid-cols-2 gap-6 ">
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`terms_and_conditions_label_${language.id}`"
                                    :id="`terms_and_conditions_label_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateTermsAndConditionsLabel')"
                                    :value="form['terms_and_conditions_label'] && form['terms_and_conditions_label'][
                                        `terms_and_conditions_label_${language.id}`
                                    ] ? form['terms_and_conditions_label'][
                                        `terms_and_conditions_label_${language.id}`
                                    ] : ''" />
                                <label :for="`terms_and_conditions_label_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Terms
                                    & conditions label</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`terms_and_conditions_label.terms_and_conditions_label_${language.id}`)"
                                    v-text="validationErros.get(`terms_and_conditions_label.terms_and_conditions_label_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`terms_and_conditions_error_${language.id}`"
                                    :id="`terms_and_conditions_error_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateTermsAndConditionsError')"
                                    :value="form['terms_and_conditions_error'] && form['terms_and_conditions_error'][
                                        `terms_and_conditions_error_${language.id}`
                                    ] ? form['terms_and_conditions_error'][
                                        `terms_and_conditions_error_${language.id}`
                                    ] : ''" />
                                <label :for="`terms_and_conditions_error_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Terms
                                    & conditions error</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`terms_and_conditions_error.terms_and_conditions_error_${language.id}`)"
                                    v-text="validationErros.get(`terms_and_conditions_error.terms_and_conditions_error_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" :name="`submit_button_text_${language.id}`"
                                    :id="`submit_button_text_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateSubmitButtonText')"
                                    :value="form['submit_button_text'] && form['submit_button_text'][
                                        `submit_button_text_${language.id}`
                                    ] ? form['submit_button_text'][`submit_button_text_${language.id}`] : ''" />
                                <label :for="`submit_button_text_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Submit
                                    button text</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`submit_button_text.submit_button_text_${language.id}`)"
                                    v-text="validationErros.get(`submit_button_text.submit_button_text_${language.id}`)">
                                </p>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <div class="mt-5 ckeditorText" :id="`footer_text_${language.id}`"></div>
                                <!-- <input type="text" :name="`footer_text_${language.id}`"
                                    :id="`footer_text_${language.id}`"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder=" "
                                    @input="handleInput($event.target.value, language, 'updateFooterText')"
                                    :value="form['footer_text'] && form['footer_text'][`footer_text_${language.id}`] ? form[
                                        'footer_text'][`footer_text_${language.id}`] : ''" /> -->
                                <label :for="`footer_text_${language.id}`"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Footer
                                    text</label>
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`footer_text.footer_text_${language.id}`)"
                                    v-text="validationErros.get(`footer_text.footer_text_${language.id}`)"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <button type="submit"
                class="button-exp-fill">Submit</button>
        </form>

    </AppLayout>
</template>

<script>
    import { mapState } from 'vuex'
    export default {
        computed:{
            ...mapState({
                form: state => state.reg_page_setting.form,
                validationErros: state => state.reg_page_setting.validationErros,
                languages: state => state.languages.languages,
            }),
        },
        data(){
            return {
                activeTab: null,
                collapseStates: [true, false, false, false, false, false, false]
            }
        },
        methods: {
            handleInput(value, language, mutationName){
                this.$store.commit(`reg_page_setting/${mutationName}`, {
                    'value': value,
                    'id': language.id,
                });
            },
            addUpdateForm(){
                this.$store.dispatch('reg_page_setting/addUpdateForm');
            },
            changeLanguageTab(language){
                this.activeTab = language.id;
            },
            fetchRegistrationPageSetting(){
                    this.$store.dispatch('reg_page_setting/fetchRegistrationPageSetting', {
                        url: `${process.env.MIX_ADMIN_API_URL}registration-page-setting`
                    }).then(res => {
                        let data = res.data.data && res.data.data.reg_page_setting_detail ? res.data.data.reg_page_setting_detail : [];
                        let obj = {};
                        data.map(res => {
                            CKEDITOR.instances['page_title_'+res.language_id].setData(res.page_title);
                            obj['page_title_'+res.language_id] = res.page_title;
                        });
                        this.$store.commit('reg_page_setting/setPageTitle', obj);
                        obj = {};
                        data.map(res => {
                            CKEDITOR.instances['page_description_'+res.language_id].setData(res.page_description);
                            obj['page_description_'+res.language_id] = res.page_description;
                        });
                        this.$store.commit('reg_page_setting/setPageDescription', obj);
                        obj = {};
                        data.map(res => {
                            CKEDITOR.instances['step_1_heading_'+res.language_id].setData(res.step_1_heading);
                            obj['step_1_heading_'+res.language_id] = res.step_1_heading;
                        });
                        this.$store.commit('reg_page_setting/setStep1Heading', obj);
                        obj = {};
                        data.map(res => {
                            CKEDITOR.instances['step_1_acc_heading_'+res.language_id].setData(res.step_1_acc_heading);
                            obj['step_1_acc_heading_'+res.language_id] = res.step_1_acc_heading;
                        });
                        this.$store.commit('reg_page_setting/setStep1AccHeading', obj);
                        obj = {};
                        data.map(res => {
                            CKEDITOR.instances['step_1_description_'+res.language_id].setData(res.step_1_description);
                            obj['step_1_description_'+res.language_id] = res.step_1_description;
                        });
                        this.$store.commit('reg_page_setting/setStep1Description', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_1_auto_renew_label_'+res.language_id] = res.step_1_auto_renew_label;
                        });
                        this.$store.commit('reg_page_setting/setStep1AutoRenewLabel', obj);
                        obj = {};
                        data.map(res => {
                            obj['step1_free_pkg_text_'+res.language_id] = res.step1_free_pkg_text;
                        });
                        this.$store.commit('reg_page_setting/setStep1FreePkgText', obj);
                        obj = {};
                        data.map(res => {
                            obj['step1_feature_pkg_text_'+res.language_id] = res.step1_feature_pkg_text;
                        });
                        this.$store.commit('reg_page_setting/setStep1FeaturePkgText', obj);
                        obj = {};
                        data.map(res => {
                            obj['step1_premium_pkg_text_'+res.language_id] = res.step1_premium_pkg_text;
                        });
                        this.$store.commit('reg_page_setting/setStep1PremiumPkgText', obj);
                        obj = {};
                        data.map(res => {
                            CKEDITOR.instances['step_2_heading_'+res.language_id].setData(res.step_2_heading);
                            obj['step_2_heading_'+res.language_id] = res.step_2_heading;
                        });
                        this.$store.commit('reg_page_setting/setStep2Heading', obj);
                        obj = {};
                        data.map(res => {
                            CKEDITOR.instances['step_2_acc_heading_'+res.language_id].setData(res.step_2_acc_heading);
                            obj['step_2_acc_heading_'+res.language_id] = res.step_2_acc_heading;
                        });
                        obj = {};
                        data.map(res => {
                            CKEDITOR.instances['step_2_acc_description_'+res.language_id].setData(res.step_2_acc_description);
                            obj['step_2_acc_description_'+res.language_id] = res.step_2_acc_description;
                        });
                        this.$store.commit('reg_page_setting/setStep2AccHeading', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_2_name_label_'+res.language_id] = res.step_2_name_label;
                        });
                        this.$store.commit('reg_page_setting/setStep2NameLabel', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_2_name_error_'+res.language_id] = res.step_2_name_error;
                        });
                        this.$store.commit('reg_page_setting/setStep2NameError', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_2_name_placeholder_'+res.language_id] = res.step_2_name_placeholder;
                        });
                        this.$store.commit('reg_page_setting/setStep2NamePlaceholder', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_2_email_label_'+res.language_id] = res.step_2_email_label;
                        });
                        this.$store.commit('reg_page_setting/setStep2EmailLabel', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_2_email_error_'+res.language_id] = res.step_2_email_error;
                        });
                        this.$store.commit('reg_page_setting/setStep2EmailError', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_2_email_placeholder_'+res.language_id] = res.step_2_email_placeholder;
                        });
                        this.$store.commit('reg_page_setting/setStep2EmailPlaceholder', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_2_password_label_'+res.language_id] = res.step_2_password_label;
                        });
                        this.$store.commit('reg_page_setting/setStep2PasswordLabel', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_2_password_error_'+res.language_id] = res.step_2_password_error;
                        });
                        this.$store.commit('reg_page_setting/setStep2PasswordError', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_2_password_placeholder_'+res.language_id] = res.step_2_password_placeholder;
                        });
                        this.$store.commit('reg_page_setting/setStep2PasswordPlaceholder', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_2_confirm_password_label_'+res.language_id] = res.step_2_confirm_password_label;
                        });
                        this.$store.commit('reg_page_setting/setStep2ConfirmPasswordLabel', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_2_confirm_password_error_'+res.language_id] = res.step_2_confirm_password_error;
                        });
                        this.$store.commit('reg_page_setting/setStep2ConfirmPasswordError', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_2_confirm_password_placeholder_'+res.language_id] = res.step_2_confirm_password_placeholder;
                        });
                        this.$store.commit('reg_page_setting/setStep2ConfirmPasswordPlaceholder', obj);
                        obj = {};
                        data.map(res => {
                            CKEDITOR.instances['step_3_heading_'+res.language_id].setData(res.step_3_heading);
                            obj['step_3_heading_'+res.language_id] = res.step_3_heading;
                        });
                        this.$store.commit('reg_page_setting/setStep3Heading', obj);
                        obj = {};
                        data.map(res => {
                            CKEDITOR.instances['step_3_acc_heading_'+res.language_id].setData(res.step_3_acc_heading);
                            obj['step_3_acc_heading_'+res.language_id] = res.step_3_acc_heading;
                        });
                        this.$store.commit('reg_page_setting/setStep3AccHeading', obj);
                        obj = {};
                        data.map(res => {
                            CKEDITOR.instances['step_3_description_'+res.language_id].setData(res.step_3_description);
                            obj['step_3_description_'+res.language_id] = res.step_3_description;
                        });
                        this.$store.commit('reg_page_setting/setStep3Description', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_3_business_categories_label_'+res.language_id] = res.step_3_business_categories_label;
                        });
                        this.$store.commit('reg_page_setting/setStep3BusinessCategoriesLabel', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_3_business_categories_error_'+res.language_id] = res.step_3_business_categories_error;
                        });
                        this.$store.commit('reg_page_setting/setStep3BusinessCategoriesError', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_3_business_categories_placeholder_'+res.language_id] = res.step_3_business_categories_placeholder;
                        });
                        this.$store.commit('reg_page_setting/setStep3BusinessCategoriesPlaceholder', obj);
                        obj = {};
                        data.map(res => {
                            CKEDITOR.instances['step_4_heading_'+res.language_id].setData(res.step_4_heading);
                            obj['step_4_heading_'+res.language_id] = res.step_4_heading;
                        });
                        this.$store.commit('reg_page_setting/setStep4Heading', obj);
                        obj = {};
                        data.map(res => {
                            CKEDITOR.instances['step_4_acc_heading_'+res.language_id].setData(res.step_4_acc_heading);
                            obj['step_4_acc_heading_'+res.language_id] = res.step_4_acc_heading;
                        });
                        this.$store.commit('reg_page_setting/setStep4AccHeading', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_name_label_'+res.language_id] = res.step_4_name_label;
                        });
                        this.$store.commit('reg_page_setting/setStep4NameLabel', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_name_error_'+res.language_id] = res.step_4_name_error;
                        });
                        this.$store.commit('reg_page_setting/setStep4NameError', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_name_placeholder_'+res.language_id] = res.step_4_name_placeholder;
                        });
                        this.$store.commit('reg_page_setting/setStep4NamePlaceholder', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_email_label_'+res.language_id] = res.step_4_email_label;
                        });
                        this.$store.commit('reg_page_setting/setStep4EmailLabel', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_email_error_'+res.language_id] = res.step_4_email_error;
                        });
                        this.$store.commit('reg_page_setting/setStep4EmailError', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_email_placeholder_'+res.language_id] = res.step_4_email_placeholder;
                        });
                        this.$store.commit('reg_page_setting/setStep4EmailPlaceholder', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_cta_link_label_'+res.language_id] = res.step_4_cta_link_label;
                        });
                        this.$store.commit('reg_page_setting/setStep4CtaLinkLabel', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_cta_link_error_'+res.language_id] = res.step_4_cta_link_error;
                        });
                        this.$store.commit('reg_page_setting/setStepCtaLinkError', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_cta_link_placeholder_'+res.language_id] = res.step_4_cta_link_placeholder;
                        });
                        this.$store.commit('reg_page_setting/setStep4CtaLinkPlaceholder', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_cta_btn_label_'+res.language_id] = res.step_4_cta_btn_label;
                        });
                        this.$store.commit('reg_page_setting/setStep4CtaBtnLabel', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_cta_btn_error_'+res.language_id] = res.step_4_cta_btn_error;
                        });
                        this.$store.commit('reg_page_setting/setStep4CtaBtnError', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_cta_btn_placeholder_'+res.language_id] = res.step_4_cta_btn_placeholder;
                        });
                        this.$store.commit('reg_page_setting/setStep4CtaBtnPlaceholder', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_address_label_'+res.language_id] = res.step_4_address_label;
                        });
                        this.$store.commit('reg_page_setting/setStep4AddressLabel', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_address_error_'+res.language_id] = res.step_4_address_error;
                        });
                        this.$store.commit('reg_page_setting/setStep4AddressError', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_address_placeholder_'+res.language_id] = res.step_4_address_placeholder;
                        });
                        this.$store.commit('reg_page_setting/setStep4AddressPlaceholder', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_phone_label_'+res.language_id] = res.step_4_phone_label;
                        });
                        this.$store.commit('reg_page_setting/setStep4PhoneLabel', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_phone_error_'+res.language_id] = res.step_4_phone_error;
                        });
                        this.$store.commit('reg_page_setting/setStep4PhoneError', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_phone_placeholder_'+res.language_id] = res.step_4_phone_placeholder;
                        });
                        this.$store.commit('reg_page_setting/setStep4PhonePlaceholder', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_website_label_'+res.language_id] = res.step_4_website_label;
                        });
                        this.$store.commit('reg_page_setting/setStep4WebsiteLabel', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_website_error_'+res.language_id] = res.step_4_website_error;
                        });
                        this.$store.commit('reg_page_setting/setStep4WebsiteError', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_website_placeholder_'+res.language_id] = res.step_4_website_placeholder;
                        });
                        this.$store.commit('reg_page_setting/setStep4WebsitePlaceholder', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_short_description_label_'+res.language_id] = res.step_4_short_description_label;
                        });
                        this.$store.commit('reg_page_setting/setStep4ShortDescriptionLabel', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_short_description_error_'+res.language_id] = res.step_4_short_description_error;
                        });
                        this.$store.commit('reg_page_setting/setStep4ShortDescriptionError', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_short_description_placeholder_'+res.language_id] = res.step_4_short_description_placeholder;
                        });
                        this.$store.commit('reg_page_setting/setStep4ShortDescriptionPlaceholder', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_description_label_'+res.language_id] = res.step_4_description_label;
                        });
                        this.$store.commit('reg_page_setting/setStep4DescriptionLabel', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_description_error_'+res.language_id] = res.step_4_description_error;
                        });
                        this.$store.commit('reg_page_setting/setStep4DescriptionError', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_description_placeholder_'+res.language_id] = res.step_4_description_placeholder;
                        });
                        this.$store.commit('reg_page_setting/setStep4DescriptionPlaceholder', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_keywords_label_'+res.language_id] = res.step_4_keywords_label;
                        });
                        this.$store.commit('reg_page_setting/setStep4KeywordsLabel', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_keywords_error_'+res.language_id] = res.step_4_keywords_error;
                        });
                        this.$store.commit('reg_page_setting/setStep4KeywordsError', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_4_keywords_placeholder_'+res.language_id] = res.step_4_keywords_placeholder;
                        });
                        this.$store.commit('reg_page_setting/setStep4KeywordsPlaceholder', obj);
                        obj = {};
                        data.map(res => {
                            CKEDITOR.instances['step_5_heading_'+res.language_id].setData(res.step_5_heading);
                            obj['step_5_heading_'+res.language_id] = res.step_5_heading;
                        });
                        this.$store.commit('reg_page_setting/setStep5Heading', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_5_title_label_'+res.language_id] = res.step_5_title_label;
                        });
                        this.$store.commit('reg_page_setting/setStep5TitleLabel', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_5_title_error_'+res.language_id] = res.step_5_title_error;
                        });
                        this.$store.commit('reg_page_setting/setStep5TitleError', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_5_description_label_'+res.language_id] = res.step_5_description_label;
                        });
                        this.$store.commit('reg_page_setting/setStep5DescriptionLabel', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_5_description_error_'+res.language_id] = res.step_5_description_error;
                        });
                        this.$store.commit('reg_page_setting/setStep5DescriptionError', obj);
                        obj = {};
                        data.map(res => {
                            CKEDITOR.instances['step_5_acc_heading_'+res.language_id].setData(res.step_5_acc_heading);
                            obj['step_5_acc_heading_'+res.language_id] = res.step_5_acc_heading;
                        });
                        this.$store.commit('reg_page_setting/setStep5AccHeading', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_5_logo_label_'+res.language_id] = res.step_5_logo_label;
                        });
                        this.$store.commit('reg_page_setting/setStep5LogoLabel', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_5_logo_error_'+res.language_id] = res.step_5_logo_error;
                        });
                        this.$store.commit('reg_page_setting/setStep5LogoError', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_5_logo_placeholder_'+res.language_id] = res.step_5_logo_placeholder;
                        });
                        this.$store.commit('reg_page_setting/setStep5LogoPlaceholder', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_5_video_label_'+res.language_id] = res.step_5_video_label;
                        });
                        this.$store.commit('reg_page_setting/setStep5VideoLabel', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_5_video_error_'+res.language_id] = res.step_5_video_error;
                        });
                        this.$store.commit('reg_page_setting/setStep5VideoError', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_5_video_placeholder_'+res.language_id] = res.step_5_video_placeholder;
                        });
                        this.$store.commit('reg_page_setting/setStep5VideoPlaceholder', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_5_image_1_label_'+res.language_id] = res.step_5_image_1_label;
                        });
                        this.$store.commit('reg_page_setting/setStep5Image1Label', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_5_image_1_error_'+res.language_id] = res.step_5_image_1_error;
                        });
                        this.$store.commit('reg_page_setting/setStep5Image1Error', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_5_image_1_placeholder_'+res.language_id] = res.step_5_image_1_placeholder;
                        });
                        this.$store.commit('reg_page_setting/setStep5Image1Placeholder', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_5_image_2_label_'+res.language_id] = res.step_5_image_2_label;
                        });
                        this.$store.commit('reg_page_setting/setStep5Image2Label', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_5_image_2_error_'+res.language_id] = res.step_5_image_2_error;
                        });
                        this.$store.commit('reg_page_setting/setStep5Image2Error', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_5_image_2_placeholder_'+res.language_id] = res.step_5_image_2_placeholder;
                        });
                        this.$store.commit('reg_page_setting/setStep5Image2Placeholder', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_5_image_3_label_'+res.language_id] = res.step_5_image_3_label;
                        });
                        this.$store.commit('reg_page_setting/setStep5Image3Label', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_5_image_3_error_'+res.language_id] = res.step_5_image_3_error;
                        });
                        this.$store.commit('reg_page_setting/setStep5Image3Error', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_5_image_3_placeholder_'+res.language_id] = res.step_5_image_3_placeholder;
                        });
                        this.$store.commit('reg_page_setting/setStep5Image3Placeholder', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_5_image_4_label_'+res.language_id] = res.step_5_image_4_label;
                        });
                        this.$store.commit('reg_page_setting/setStep5Image4Label', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_5_image_4_error_'+res.language_id] = res.step_5_image_4_error;
                        });
                        this.$store.commit('reg_page_setting/setStep5Image4Error', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_5_image_4_placeholder_'+res.language_id] = res.step_5_image_4_placeholder;
                        });
                        this.$store.commit('reg_page_setting/setStep5Image4Placeholder', obj);
                        obj = {};
                        data.map(res => {
                            CKEDITOR.instances['step_6_heading_'+res.language_id].setData(res.step_6_heading);
                            obj['step_6_heading_'+res.language_id] = res.step_6_heading;
                        });
                        this.$store.commit('reg_page_setting/setStep6Heading', obj);
                        obj = {};
                        data.map(res => {
                            CKEDITOR.instances['step_6_acc_heading_'+res.language_id].setData(res.step_6_acc_heading);
                            obj['step_6_acc_heading_'+res.language_id] = res.step_6_acc_heading;
                        });
                        this.$store.commit('reg_page_setting/setStep6AccHeading', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_6_facebook_label_'+res.language_id] = res.step_6_facebook_label;
                        });
                        this.$store.commit('reg_page_setting/setStep6FacebookLabel', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_6_facebook_error_'+res.language_id] = res.step_6_facebook_error;
                        });
                        this.$store.commit('reg_page_setting/setStep6FacebookError', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_6_facebook_placeholder_'+res.language_id] = res.step_6_facebook_placeholder;
                        });
                        this.$store.commit('reg_page_setting/setStep6FacebookPlaceholder', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_6_twitter_label_'+res.language_id] = res.step_6_twitter_label;
                        });
                        this.$store.commit('reg_page_setting/setStep6TwitterLabel', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_6_twitter_error_'+res.language_id] = res.step_6_twitter_error;
                        });
                        this.$store.commit('reg_page_setting/setStep6TwitterError', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_6_twitter_placeholder_'+res.language_id] = res.step_6_twitter_placeholder;
                        });
                        this.$store.commit('reg_page_setting/setStep6TwitterPlaceholder', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_6_youtube_label_'+res.language_id] = res.step_6_youtube_label;
                        });
                        this.$store.commit('reg_page_setting/setStep6YoutubeLabel', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_6_youtube_error_'+res.language_id] = res.step_6_youtube_error;
                        });
                        this.$store.commit('reg_page_setting/setStep6YoutubeError', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_6_youtube_placeholder_'+res.language_id] = res.step_6_youtube_placeholder;
                        });
                        this.$store.commit('reg_page_setting/setStep6YoutubePlaceholder', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_6_linkedin_label_'+res.language_id] = res.step_6_linkedin_label;
                        });
                        this.$store.commit('reg_page_setting/setStep6LinkedinLabel', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_6_linkedin_error_'+res.language_id] = res.step_6_linkedin_error;
                        });
                        this.$store.commit('reg_page_setting/setStep6LinkedinError', obj);
                        obj = {};
                        data.map(res => {
                            obj['step_6_linkedin_placeholder_'+res.language_id] = res.step_6_linkedin_placeholder;
                        });
                        this.$store.commit('reg_page_setting/setStep6LinkedinPlaceholder', obj);
                        obj = {};
                        data.map(res => {
                            obj['terms_and_conditions_label_'+res.language_id] = res.terms_and_conditions_label;
                        });
                        this.$store.commit('reg_page_setting/setTermsAndConditionsLabel', obj);
                        obj = {};
                        data.map(res => {
                            obj['terms_and_conditions_error_'+res.language_id] = res.terms_and_conditions_error;
                        });
                        this.$store.commit('reg_page_setting/setTermsAndConditionsError', obj);
                        obj = {};
                        data.map(res => {
                            obj['submit_button_text_'+res.language_id] = res.submit_button_text;
                        });
                        this.$store.commit('reg_page_setting/setSubmitButtonText', obj);
                        obj = {};
                        data.map(res => {
                            CKEDITOR.instances['footer_text_'+res.language_id].setData(res.footer_text);
                            obj['footer_text_'+res.language_id] = res.footer_text;
                        });
                        this.$store.commit('reg_page_setting/setFooterText', obj);
                    });
            },
            checkValidationError(validationErros, language){
                return validationErros.has(`page_title.page_title_${language.id}`) ||
                validationErros.has(`page_description.page_description_${language.id}`) ||
                validationErros.has(`step_1_heading.step_1_heading_${language.id}`) ||
                validationErros.has(`step_1_acc_heading.step_1_acc_heading_${language.id}`) ||
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
                validationErros.has(`step_4_cta_btn_label.step_4_cta_btn_label_${language.id}`) ||
                validationErros.has(`step_4_cta_btn_error.step_4_cta_btn_error_${language.id}`) ||
                validationErros.has(`step_4_cta_btn_placeholder.step_4_cta_btn_placeholder_${language.id}`) ||
                validationErros.has(`step_4_cta_link_label.step_4_cta_link_label_${language.id}`) ||
                validationErros.has(`step_4_cta_link_error.step_4_cta_link_error_${language.id}`) ||
                validationErros.has(`step_4_cta_link_placeholder.step_4_cta_link_placeholder_${language.id}`) ||
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
                validationErros.has(`step_5_heading.step_5_heading_${language.id}`) ||
                validationErros.has(`step_5_title_label.step_5_title_label_${language.id}`) ||
                validationErros.has(`step_5_title_error.step_5_title_error_${language.id}`) ||
                validationErros.has(`step_5_description_label.step_5_description_label_${language.id}`) ||
                validationErros.has(`step_5_description_error.step_5_description_error_${language.id}`) ||
                validationErros.has(`step_5_acc_heading.step_5_acc_heading_${language.id}`) ||
                validationErros.has(`step_5_logo_label.step_5_logo_label_${language.id}`) ||
                validationErros.has(`step_5_logo_error.step_5_logo_error_${language.id}`) ||
                validationErros.has(`step_5_logo_placeholder.step_5_logo_placeholder_${language.id}`) ||
                validationErros.has(`step_5_video_label.step_5_video_label_${language.id}`) ||
                validationErros.has(`step_5_video_error.step_5_video_error_${language.id}`) ||
                validationErros.has(`step_5_video_placeholder.step_5_video_placeholder_${language.id}`) ||
                validationErros.has(`step_5_image_1_label.step_5_image_1_label_${language.id}`) ||
                validationErros.has(`step_5_image_1_error.step_5_image_1_error_${language.id}`) ||
                validationErros.has(`step_5_image_1_placeholder.step_5_image_1_placeholder_${language.id}`) ||
                validationErros.has(`step_5_image_2_label.step_5_image_2_label_${language.id}`) ||
                validationErros.has(`step_5_image_2_error.step_5_image_2_error_${language.id}`) ||
                validationErros.has(`step_5_image_2_placeholder.step_5_image_2_placeholder_${language.id}`) ||
                validationErros.has(`step_5_image_3_label.step_5_image_3_label_${language.id}`) ||
                validationErros.has(`step_5_image_3_error.step_5_image_3_error_${language.id}`) ||
                validationErros.has(`step_5_image_3_placeholder.step_5_image_3_placeholder_${language.id}`) ||
                validationErros.has(`step_5_image_4_label.step_5_image_4_label_${language.id}`) ||
                validationErros.has(`step_5_image_4_error.step_5_image_4_error_${language.id}`) ||
                validationErros.has(`step_5_image_4_placeholder.step_5_image_4_placeholder_${language.id}`) ||
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
                validationErros.has(`terms_and_conditions_label.terms_and_conditions_label_${language.id}`) ||
                validationErros.has(`terms_and_conditions_error.terms_and_conditions_error_${language.id}`) ||
                validationErros.has(`submit_button_text.submit_button_text_${language.id}`) ||
                validationErros.has(`footer_text.footer_text_${language.id}`);
            },
            createEditorInstance(name, lang, mutationName){
                let ctx = this;
                CKEDITOR.replace(name, {
                    allowedContent:true
                })
                setTimeout(() => {
                    if(CKEDITOR?.instances[name]){
                        CKEDITOR.instances[name].on('change',function(){
                            let value  = CKEDITOR.instances[name].getData();
                            ctx.$store.commit('reg_page_setting/'+mutationName, {
                                'value': value,
                                'id': lang.id,
                            });
                        });
                    }

                }, 1000);
            }
        },
        created(){
            this.$store.commit('reg_page_setting/resetForm');
            this.$store.dispatch('languages/fetchLanguages', {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`
            }).then(res => {
                let data = res.data.data;
                let obj = {};
                data.map(res => {
                    obj['page_title_'+res.id] = '';
                    this.createEditorInstance('page_title_'+res.id, res, 'updatePageTitle');
                });
                this.$store.commit('reg_page_setting/setPageTitle', obj);
                obj = {};
                data.map(res => {
                    obj['page_description_'+res.id] = '';
                    this.createEditorInstance('page_description_'+res.id, res, 'updatePageDescription');
                });
                this.$store.commit('reg_page_setting/setPageDescription', obj);
                obj = {};
                data.map(res => {
                    obj['step_1_heading_'+res.id] = '';
                    this.createEditorInstance('step_1_heading_'+res.id, res, 'updateStep1Heading');
                });
                this.$store.commit('reg_page_setting/setStep1Heading', obj);
                obj = {};
                data.map(res => {
                    obj['step_1_acc_heading_'+res.id] = '';
                    this.createEditorInstance('step_1_acc_heading_'+res.id, res, 'updateStep1AccHeading');
                });
                this.$store.commit('reg_page_setting/setStep1AccHeading', obj);
                obj = {};
                data.map(res => {
                    obj['step_1_description_'+res.id] = '';
                    this.createEditorInstance('step_1_description_'+res.id, res, 'updateStep1Description');
                });
                this.$store.commit('reg_page_setting/setStep1Description', obj);
                obj = {};
                data.map(res => {
                    obj['step_1_auto_renew_label_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep1AutoRenewLabel', obj);
                obj = {};
                data.map(res => {
                    obj['step1_free_pkg_text_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep1FreePkgText', obj);
                obj = {};
                data.map(res => {
                    obj['step1_feature_pkg_text_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep1FeaturePkgText', obj);
                obj = {};
                data.map(res => {
                    obj['step1_premium_pkg_text_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep1PremiumPkgText', obj);
                obj = {};
                data.map(res => {
                    obj['step_2_heading_'+res.id] = '';
                    this.createEditorInstance('step_2_heading_'+res.id, res, 'updateStep2Heading');
                });
                this.$store.commit('reg_page_setting/setStep2Heading', obj);
                obj = {};
                data.map(res => {
                    obj['step_2_acc_heading_'+res.id] = '';
                    this.createEditorInstance('step_2_acc_heading_'+res.id, res, 'updateStep2AccHeading');
                });
                this.$store.commit('reg_page_setting/setStep2AccHeading', obj);
                data.map(res => {
                    obj['step_2_acc_description_'+res.id] = '';
                    this.createEditorInstance('step_2_acc_description_'+res.id, res, 'updateStep2AccHeading');
                });
                this.$store.commit('reg_page_setting/setStep2AccHeading', obj);
                obj = {};
                data.map(res => {
                    obj['step_2_name_label_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep2NameLabel', obj);
                obj = {};
                data.map(res => {
                    obj['step_2_name_error_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep2NameError', obj);
                obj = {};
                data.map(res => {
                    obj['step_2_name_placeholder_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep2NamePlaceholder', obj);
                obj = {};
                data.map(res => {
                    obj['step_2_email_label_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep2EmailLabel', obj);
                obj = {};
                data.map(res => {
                    obj['step_2_email_error_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep2EmailError', obj);
                obj = {};
                data.map(res => {
                    obj['step_2_email_placeholder_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep2EmailPlaceholder', obj);
                obj = {};
                data.map(res => {
                    obj['step_2_password_label_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep2PasswordLabel', obj);
                obj = {};
                data.map(res => {
                    obj['step_2_password_error_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep2PasswordError', obj);
                obj = {};
                data.map(res => {
                    obj['step_2_password_placeholder_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep2PasswordPlaceholder', obj);
                obj = {};
                data.map(res => {
                    obj['step_2_confirm_password_label_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep2ConfirmPasswordLabel', obj);
                obj = {};
                data.map(res => {
                    obj['step_2_confirm_password_error_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep2ConfirmPasswordError', obj);
                obj = {};
                data.map(res => {
                    obj['step_2_confirm_password_placeholder_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep2ConfirmPasswordPlaceholder', obj);
                obj = {};
                data.map(res => {
                    obj['step_3_heading_'+res.id] = '';
                    this.createEditorInstance('step_3_heading_'+res.id, res, 'updateStep3Heading');
                });
                this.$store.commit('reg_page_setting/setStep3Heading', obj);
                obj = {};
                data.map(res => {
                    obj['step_3_acc_heading_'+res.id] = '';
                    this.createEditorInstance('step_3_acc_heading_'+res.id, res, 'updateStep3AccHeading');
                });
                this.$store.commit('reg_page_setting/setStep3Heading', obj);
                obj = {};
                data.map(res => {
                    obj['step_3_description_'+res.id] = '';
                    this.createEditorInstance('step_3_description_'+res.id, res, 'updateStep3Description');
                });
                this.$store.commit('reg_page_setting/setStep3Description', obj);
                obj = {};
                data.map(res => {
                    obj['step_3_business_categories_label_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep3BusinessCategoriesLabel', obj);
                obj = {};
                data.map(res => {
                    obj['step_3_business_categories_error_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep3BusinessCategoriesError', obj);
                obj = {};
                data.map(res => {
                    obj['step_3_business_categories_placeholder_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep3BusinessCategoriesPlaceholder', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_heading_'+res.id] = '';
                    this.createEditorInstance('step_4_heading_'+res.id, res, 'updateStep4Heading');
                });
                this.$store.commit('reg_page_setting/setStep4Heading', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_acc_heading_'+res.id] = '';
                    this.createEditorInstance('step_4_acc_heading_'+res.id, res, 'updateStep4AccHeading');
                });
                this.$store.commit('reg_page_setting/setStep4AccHeading', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_name_label_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4NameLabel', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_name_error_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4NameError', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_name_placeholder_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4NamePlaceholder', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_email_label_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4EmailLabel', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_email_error_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4EmailError', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_email_placeholder_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4EmailPlaceholder', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_cta_btn_label_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4CtaBtnLabel', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_cta_btn_error_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4CtaBtnError', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_cta_btn_placeholder_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4CtaBtnPlaceholder', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_cta_link_label_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4CtaLinkLabel', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_cta_link_error_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4CtaLinkError', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_cta_link_placeholder_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4CtaLinkPlaceholder', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_address_label_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4AddressLabel', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_address_error_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4AddressError', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_address_placeholder_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4AddressPlaceholder', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_phone_label_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4PhoneLabel', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_phone_error_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4PhoneError', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_phone_placeholder_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4PhonePlaceholder', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_website_label_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4WebsiteLabel', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_website_error_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4WebsiteError', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_website_placeholder_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4WebsitePlaceholder', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_short_description_label_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4ShortDescriptionLabel', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_short_description_error_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4ShortDescriptionError', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_short_description_placeholder_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4ShortDescriptionPlaceholder', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_description_label_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4DescriptionLabel', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_description_error_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4DescriptionError', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_description_placeholder_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4DescriptionPlaceholder', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_keywords_label_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4KeywordsLabel', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_keywords_error_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4KeywordsError', obj);
                obj = {};
                data.map(res => {
                    obj['step_4_keywords_placeholder_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep4KeywordsPlaceholder', obj);
                obj = {};
                data.map(res => {
                    obj['step_5_heading_'+res.id] = '';
                    this.createEditorInstance('step_5_heading_'+res.id, res, 'updateStep5Heading');
                });
                this.$store.commit('reg_page_setting/setStep5Heading', obj);
                obj = {};
                data.map(res => {
                    obj['step_5_title_label_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep5TitleLabel', obj);
                obj = {};
                data.map(res => {
                    obj['step_5_title_error_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep5TitleError', obj);
                obj = {};
                data.map(res => {
                    obj['step_5_description_label_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep5DescriptionLabel', obj);
                obj = {};
                data.map(res => {
                    obj['step_5_description_error_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep5DescriptionError', obj);
                obj = {};
                data.map(res => {
                    obj['step_5_acc_heading_'+res.id] = '';
                    this.createEditorInstance('step_5_acc_heading_'+res.id, res, 'updateStep5AccHeading');
                });
                this.$store.commit('reg_page_setting/setStep5AccHeading', obj);
                obj = {};
                data.map(res => {
                    obj['step_5_logo_label_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep5LogoLabel', obj);
                obj = {};
                data.map(res => {
                    obj['step_5_logo_error_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep5LogoError', obj);
                obj = {};
                data.map(res => {
                    obj['step_5_logo_placeholder_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep5LogoPlaceholder', obj);
                obj = {};
                data.map(res => {
                    obj['step_5_video_label_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep5VideoLabel', obj);
                obj = {};
                data.map(res => {
                    obj['step_5_video_error_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep5VideoError', obj);
                obj = {};
                data.map(res => {
                    obj['step_5_video_placeholder_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep5VideoPlaceholder', obj);
                obj = {};
                data.map(res => {
                    obj['step_5_image_1_label_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep5Image1Label', obj);
                obj = {};
                data.map(res => {
                    obj['step_5_image_1_error_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep5Image1Error', obj);
                obj = {};
                data.map(res => {
                    obj['step_5_image_1_placeholder_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep5Image1Placeholder', obj);
                obj = {};
                data.map(res => {
                    obj['step_5_image_2_label_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep5Image2Label', obj);
                obj = {};
                data.map(res => {
                    obj['step_5_image_2_error_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep5Image2Error', obj);
                obj = {};
                data.map(res => {
                    obj['step_5_image_2_placeholder_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep5Image2Placeholder', obj);
                obj = {};
                data.map(res => {
                    obj['step_5_image_3_label_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep5Image3Label', obj);
                obj = {};
                data.map(res => {
                    obj['step_5_image_3_error_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep5Image3Error', obj);
                obj = {};
                data.map(res => {
                    obj['step_5_image_3_placeholder_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep5Image3Placeholder', obj);
                obj = {};
                data.map(res => {
                    obj['step_5_image_4_label_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep5Image4Label', obj);
                obj = {};
                data.map(res => {
                    obj['step_5_image_4_error_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep5Image4Error', obj);
                obj = {};
                data.map(res => {
                    obj['step_5_image_4_placeholder_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep5Image4Placeholder', obj);
                obj = {};
                data.map(res => {
                    obj['step_6_heading_'+res.id] = '';
                    this.createEditorInstance('step_6_heading_'+res.id, res, 'updateStep6Heading');
                });
                this.$store.commit('reg_page_setting/setStep6Heading', obj);
                obj = {};
                data.map(res => {
                    obj['step_6_acc_heading_'+res.id] = '';
                    this.createEditorInstance('step_6_acc_heading_'+res.id, res, 'updateStep6AccHeading');
                });
                this.$store.commit('reg_page_setting/setStep6AccHeading', obj);
                obj = {};
                data.map(res => {
                    obj['step_6_facebook_label_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep6FacebookLabel', obj);
                obj = {};
                data.map(res => {
                    obj['step_6_facebook_error_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep6FacebookError', obj);
                obj = {};
                data.map(res => {
                    obj['step_6_facebook_placeholder_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep6FacebookPlaceholder', obj);
                obj = {};
                data.map(res => {
                    obj['step_6_twitter_label_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep6TwitterLabel', obj);
                obj = {};
                data.map(res => {
                    obj['step_6_twitter_error_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep6TwitterError', obj);
                obj = {};
                data.map(res => {
                    obj['step_6_twitter_placeholder_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep6TwitterPlaceholder', obj);
                obj = {};
                data.map(res => {
                    obj['step_6_youtube_label_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep6YoutubeLabel', obj);
                obj = {};
                data.map(res => {
                    obj['step_6_youtube_error_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep6YoutubeError', obj);
                obj = {};
                data.map(res => {
                    obj['step_6_youtube_placeholder_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep6YoutubePlaceholder', obj);
                obj = {};
                data.map(res => {
                    obj['step_6_linkedin_label_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep6LinkedinLabel', obj);
                obj = {};
                data.map(res => {
                    obj['step_6_linkedin_error_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep6LinkedinError', obj);
                obj = {};
                data.map(res => {
                    obj['step_6_linkedin_placeholder_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setStep6LinkedinPlaceholder', obj);
                obj = {};
                data.map(res => {
                    obj['terms_and_conditions_label_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setTermsAndConditionsLabel', obj);
                obj = {};
                data.map(res => {
                    obj['terms_and_conditions_error_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setTermsAndConditionsError', obj);
                obj = {};
                data.map(res => {
                    obj['submit_button_text_'+res.id] = '';
                });
                this.$store.commit('reg_page_setting/setSubmitButtonText', obj);
                obj = {};
                data.map(res => {
                    obj['footer_text_'+res.id] = '';
                    this.createEditorInstance('footer_text_'+res.id, res, 'updateFooterText');
                });
                this.$store.commit('reg_page_setting/setFooterText', obj);
                this.fetchRegistrationPageSetting();
            });
        },
        // mounted() {
        //     let ckEditorScript = document.createElement('script')
        //     ckEditorScript.setAttribute('src', `${process.env.MIX_APP_URL}/plugins/ckeditor5/ckeditor.js`)
        //     document.head.appendChild(ckEditorScript)
        // },
    };
</script>
