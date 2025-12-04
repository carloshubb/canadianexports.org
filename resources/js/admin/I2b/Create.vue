<template>
    <AppLayout>
        <div class="relative shadow-md sm:rounded-lg bg-white py-4">
            <header class="pt-4">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h3 class="can-exp-h3 text-primary">
                            {{ isFormEdit ? "Edit" : "Create" }} inquiry to buy
                        </h3>
                        <router-link
                            :to="{ name: 'admin.i2b.index' }"
                            class="button-exp-fill"
                        >
                            Back
                        </router-link>
                    </div>
                </div>
            </header>
            <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
                <div
                    class="text-sm font-medium text-center text-gray-500 border-b border-gray-200"
                >
                    <ul class="flex flex-wrap mb-2 overflow-x-auto gap-1 mt-4">
                        <li
                            class="mr-2"
                            v-for="language in languages"
                            :key="language.id"
                        >
                            <a
                                @click.prevent="changeLanguageTab(language)"
                                href="#"
                                :class="[
                                    'inline-block rounded font-FuturaMdCnBT px-5 py-2 lg:text-lg md:text-base sm:text-base text-base hover:bg-blue-100 border border-primary text-center hover:border-blue-500 hover:text-blue-600',
                                    (activeTab == null &&
                                        language.is_default) ||
                                    activeTab == language.id
                                        ? 'bg-blue-600 text-white'
                                        : '',
                                    validationErros.has(
                                        `name.name_${language.id}`
                                    ) ||
                                    validationErros.has(
                                        `country_name.country_name_${language.id}`
                                    )
                                        ? 'bg-red-600 border-red-600 text-white hover:text-white rounded hover:bg-red-600 hover:border-red-600'
                                        : '',
                                ]"
                                >{{ language.name }}</a
                            >
                        </li>
                    </ul>
                </div>

                <div
                    class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2  lg:grid-cols-2 gap-6 "
                    v-for="language in languages"
                    :key="language.id"
                    :class="
                        (activeTab == null && language.is_default) ||
                        activeTab == language.id
                            ? 'block'
                            : 'hidden'
                    "
                >
                    <div class="relative z-0 w-full group">
                        <label for="name">Name</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" "
                            @input="
                                handleNameInput($event.target.value, language)
                            "
                            :value="
                                form['name'] &&
                                form['name'][`name_${language.id}`]
                                    ? form['name'][`name_${language.id}`]
                                    : ''
                            "
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(`name.name_${language.id}`)
                            "
                            v-text="
                                validationErros.get(`name.name_${language.id}`)
                            "
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="country_name">Country name</label>
                        <input
                            type="text"
                            name="country_name"
                            id="country_name"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" "
                            @input="
                                handleCountryNameInput(
                                    $event.target.value,
                                    language
                                )
                            "
                            :value="
                                form['country_name'] &&
                                form['country_name'][
                                    `country_name_${language.id}`
                                ]
                                    ? form['country_name'][
                                          `country_name_${language.id}`
                                      ]
                                    : ''
                            "
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `country_name.country_name_${language.id}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `country_name.country_name_${language.id}`
                                )
                            "
                        ></p>
                    </div>
                </div>
                <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2  lg:grid-cols-2 gap-6 ">
                    <div class="relative z-0 w-full group">
                        <label for="email">Email</label>
                        <input
                            type="text"
                            name="email"
                            id="email"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    'email'
                                )
                            "
                            :value="
                                form['email']
                                    ? form['email']
                                    : ''
                            "
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has(`email`)"
                            v-text="validationErros.get(`email`)"
                        ></p>
                    </div>
                    <!-- <div class="relative z-0 w-full group">
                        <label for="business_category">Business category 1</label>
                        <select
                            @input="
                                handleInput(
                                    $event.target.value,
                                    'business_category_id'
                                )
                            "
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            id="business_category"
                        >
                            <option value="">
                                Select business category...
                            </option>
                            <option
                                v-for="business_category in business_categories"
                                :key="business_category.id"
                                :value="business_category.id"
                                :selected="
                                    business_category.id ==
                                    form.business_category_id
                                "
                            >
                                {{
                                    business_category.business_category_detail &&
                                    business_category
                                        .business_category_detail[0]
                                        ? business_category
                                              .business_category_detail[0].name
                                        : ""
                                }}
                            </option>
                        </select>

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('business_category_id')"
                            v-text="validationErros.get('business_category_id')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="business_category_2">Business category 2</label>
                        <select
                            @input="
                                handleInput(
                                    $event.target.value,
                                    'business_category_id_2'
                                )
                            "
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            id="business_category_2"
                        >
                            <option value="">
                                Select business category...
                            </option>
                            <option
                                v-for="business_category in business_categories"
                                :key="business_category.id"
                                :value="business_category.id"
                                :selected="
                                    business_category.id ==
                                    form.business_category_id_2
                                "
                            >
                                {{
                                    business_category.business_category_detail &&
                                    business_category
                                        .business_category_detail[0]
                                        ? business_category
                                              .business_category_detail[0].name
                                        : ""
                                }}
                            </option>
                        </select>

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('business_category_id_2')"
                            v-text="validationErros.get('business_category_id_2')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="business_category_3">Business category 3</label>
                        <select
                            @input="
                                handleInput(
                                    $event.target.value,
                                    'business_category_id_3'
                                )
                            "
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            id="business_category_3"
                        >
                            <option value="">
                                Select business category...
                            </option>
                            <option
                                v-for="business_category in business_categories"
                                :key="business_category.id"
                                :value="business_category.id"
                                :selected="
                                    business_category.id ==
                                    form.business_category_id_3
                                "
                            >
                                {{
                                    business_category.business_category_detail &&
                                    business_category
                                        .business_category_detail[0]
                                        ? business_category
                                              .business_category_detail[0].name
                                        : ""
                                }}
                            </option>
                        </select>

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('business_category_id_3')"
                            v-text="validationErros.get('business_category_id_3')"
                        ></p>
                    </div> -->

                    <div class="relative z-0 w-full group">
    <label for="business_category">Business category 1</label>
    <select
        @input="handleInput($event.target.value, 'business_category_id')"
        class="can-exp-input w-full block border border-gray-300 rounded"
        id="business_category"
    >
        <option value="">Select business category...</option>
        <option
            v-for="business_category in business_categories
                .filter(category => category.id !== form.business_category_id_2 && category.id !== form.business_category_id_3)
                .sort((a, b) => {
                    const nameA = a.business_category_detail && a.business_category_detail[0] ? a.business_category_detail[0].name.toLowerCase() : '';
                    const nameB = b.business_category_detail && b.business_category_detail[0] ? b.business_category_detail[0].name.toLowerCase() : '';
                    return nameA.localeCompare(nameB);
                })"
            :key="business_category.id"
            :value="business_category.id"
            :selected="business_category.id == form.business_category_id"
        >
            {{
                business_category.business_category_detail &&
                business_category.business_category_detail[0]
                    ? business_category.business_category_detail[0].name
                    : ""
            }}
        </option>
    </select>

    <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('business_category_id')" v-text="validationErros.get('business_category_id')"></p>
</div>

<div class="relative z-0 w-full group">
    <label for="business_category_2">Business category 2</label>
    <select
        @input="handleInput($event.target.value, 'business_category_id_2')"
        class="can-exp-input w-full block border border-gray-300 rounded"
        id="business_category_2"
    >
        <option value="">Select business category...</option>
        <option
            v-for="business_category in business_categories
                .filter(category => category.id !== form.business_category_id && category.id !== form.business_category_id_3)
                .sort((a, b) => {
                    const nameA = a.business_category_detail && a.business_category_detail[0] ? a.business_category_detail[0].name.toLowerCase() : '';
                    const nameB = b.business_category_detail && b.business_category_detail[0] ? b.business_category_detail[0].name.toLowerCase() : '';
                    return nameA.localeCompare(nameB);
                })"
            :key="business_category.id"
            :value="business_category.id"
            :selected="business_category.id == form.business_category_id_2"
        >
            {{
                business_category.business_category_detail &&
                business_category.business_category_detail[0]
                    ? business_category.business_category_detail[0].name
                    : ""
            }}
        </option>
    </select>

    <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('business_category_id_2')" v-text="validationErros.get('business_category_id_2')"></p>
</div>

<div class="relative z-0 w-full group">
    <label for="business_category_3">Business category 3</label>
    <select
        @input="handleInput($event.target.value, 'business_category_id_3')"
        class="can-exp-input w-full block border border-gray-300 rounded"
        id="business_category_3"
    >
        <option value="">Select business category...</option>
        <option
            v-for="business_category in business_categories
                .filter(category => category.id !== form.business_category_id && category.id !== form.business_category_id_2)
                .sort((a, b) => {
                    const nameA = a.business_category_detail && a.business_category_detail[0] ? a.business_category_detail[0].name.toLowerCase() : '';
                    const nameB = b.business_category_detail && b.business_category_detail[0] ? b.business_category_detail[0].name.toLowerCase() : '';
                    return nameA.localeCompare(nameB);
                })"
            :key="business_category.id"
            :value="business_category.id"
            :selected="business_category.id == form.business_category_id_3"
        >
            {{
                business_category.business_category_detail &&
                business_category.business_category_detail[0]
                    ? business_category.business_category_detail[0].name
                    : ""
            }}
        </option>
    </select>

    <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('business_category_id_3')" v-text="validationErros.get('business_category_id_3')"></p>
</div>



                    <div class="relative z-0 w-full group">
                        <label for="deadline_date">Deadline date</label>
                        <input
                            type="date"
                            name="deadline_date"
                            id="deadline_date"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    'deadline_date'
                                )
                            "
                            :value="
                                form['deadline_date']
                                    ? form['deadline_date']
                                    : ''
                            "
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has(`deadline_date`)"
                            v-text="validationErros.get(`deadline_date`)"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="estimated_value">Estimated value</label>
                        <input
                            type="text"
                            name="estimated_value"
                            id="estimated_value"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    'estimated_value'
                                )
                            "
                            :value="
                                form['estimated_value']
                                    ? form['estimated_value']
                                    : ''
                            "
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has(`estimated_value`)"
                            v-text="validationErros.get(`estimated_value`)"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="pdf_1">PDF 1</label>
                        <input
                            type="file"
                            name="pdf_1"
                            id="pdf_1"
                            class="can-exp-input w-full block border border-gray-300 rounded px-3 py-1.5 focus:ring-blue-600 focus:ring-1 focus:outline-blue-600 focus:border-blue-600"
                            placeholder=" "
                            accept="application/pdf"
                            @input="handleImage($event, 'pdf_1')"
                        />
                        <a :href="form.pdf_1" target="_blank" v-if="form.pdf_1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                            </svg>
                        </a>
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has(`pdf_1`)"
                            v-text="validationErros.get(`pdf_1`)"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="pdf_2">PDF 2</label>
                        <input
                            type="file"
                            name="pdf_2"
                            id="pdf_2"
                            class="can-exp-input w-full block border border-gray-300 rounded px-3 py-1.5 focus:ring-blue-600 focus:ring-1 focus:outline-blue-600 focus:border-blue-600"
                            placeholder=" "
                            accept="application/pdf"
                            @input="handleImage($event, 'pdf_2')"
                        />
                        <a :href="form.pdf_2" target="_blank" v-if="form.pdf_2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                            </svg>
                        </a>
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has(`pdf_2`)"
                            v-text="validationErros.get(`pdf_2`)"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="pdf_3">PDF 3</label>
                        <input
                            type="file"
                            name="pdf_3"
                            id="pdf_3"
                            class="can-exp-input w-full block border border-gray-300 rounded px-3 py-1.5 focus:ring-blue-600 focus:ring-1 focus:outline-blue-600 focus:border-blue-600"
                            placeholder=" "
                            accept="application/pdf"
                            @input="handleImage($event, 'pdf_3')"
                        />
                        <a :href="form.pdf_3" target="_blank" v-if="form.pdf_3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                            </svg>
                        </a>
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has(`pdf_3`)"
                            v-text="validationErros.get(`pdf_3`)"
                        ></p>
                    </div>
                </div>

                <button type="submit" class="button-exp-fill" :disabled="loading">Submit</button>

                <!-- <div class="mt-4">
                    <button @click="toggleDivs" class="w-full flex justify-between items-center bg-gray-50 border border-gray-200 rounded-md py-2 px-4">
                        <span>English</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 01-1.06 0l-7.5-7.5a.75.75 0 011.06-1.06L12 14.69l6.97-6.97a.75.75 0 111.06 1.06l-7.5 7.5z" clip-rule="evenodd" />
                        </svg>

                    </button>

                    <div v-if="showDiv1" class="bg-gray-50 shadow p-3 rounded-md mt-2 border border-gray-200">
                        <div class="grid my-5 md:grid-cols-2 gap-4" v-for="language in languages" :key="language.id"
                            :class="(activeTab == null && language.is_default) || activeTab == language.id ? 'block' : 'hidden'">
                            <div class="relative z-0 w-full group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name"
                                    class="can-exp-input w-full block border border-gray-300 rounded"
                                    placeholder=" " @input="handleNameInput($event.target.value, language)"
                                    :value="form['name'] && form['name'][`name_${language.id}`] ? form['name'][`name_${language.id}`] : ''" />
                                <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`name.name_${language.id}`)"
                                    v-text="validationErros.get(`name.name_${language.id}`)"></p>
                            </div>
                            <div class="relative z-0 w-full group">
                                <label for="country_name">Country name</label>
                                <input type="text" name="country_name" id="country_name"
                                    class="can-exp-input w-full block border border-gray-300 rounded"
                                    placeholder=" " @input="handleCountryNameInput($event.target.value, language)"
                                    :value="form['country_name'] && form['country_name'][`country_name_${language.id}`] ? form[
                                        'country_name'][`country_name_${language.id}`] : ''" />
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`country_name.country_name_${language.id}`)"
                                    v-text="validationErros.get(`country_name.country_name_${language.id}`)"></p>
                            </div>
                        </div>
                        <div class="grid my-5 md:grid-cols-2 gap-4">
                            <div class="relative z-0 w-full group">
                                <label for="name">Name</label>
                                <select @input="handleInput($event.target.value, 'business_category_id')"
                                    class="can-exp-input w-full block border border-gray-300 rounded">
                                    <option value="">Select Business category...</option>
                                    <option v-for="business_category in business_categories" :key="business_category.id"
                                        :value="business_category.id" :selected="business_category.id == form.business_category_id">
                                        {{ business_category . business_category_detail && business_category . business_category_detail[0] ? business_category . business_category_detail[0] . name : '' }}
                                    </option>
                                </select>

                                <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('name')"
                                    v-text="validationErros.get('name')"></p>
                            </div>
                            <div class="relative z-0 w-full group">
                                <label for="deadline_date">Deadline date</label>
                                <input type="date" name="deadline_date" id="deadline_date"
                                    class="can-exp-input w-full block border border-gray-300 rounded"
                                    placeholder=" " @input="handleInput($event.target.value, 'deadline_date')"
                                    :value="form['deadline_date'] ? form['deadline_date'] : ''" />
                                <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`deadline_date`)"
                                    v-text="validationErros.get(`deadline_date`)"></p>
                            </div>
                            <div class="relative z-0 w-full group">
                                <label for="estimated_value">Estimated value</label>
                                <input type="text" name="estimated_value" id="estimated_value"
                                    class="can-exp-input w-full block border border-gray-300 rounded"
                                    placeholder=" " @input="handleInput($event.target.value, 'estimated_value')"
                                    :value="form['estimated_value'] ? form['estimated_value'] : ''" />
                                <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`estimated_value`)"
                                    v-text="validationErros.get(`estimated_value`)"></p>
                            </div>
                            <div class="relative z-0 w-full group">
                                <label for="pdf_1">PDF 1</label>
                                <input type="file" name="pdf_1" id="pdf_1"
                                    class="can-exp-input w-full block border border-gray-300 rounded"
                                    placeholder=" " @input="handleInput($event.target.value, 'pdf_1')"
                                    :value="form['pdf_1'] ? form['pdf_1'] : ''" />
                                <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`pdf_1`)"
                                    v-text="validationErros.get(`pdf_1`)"></p>
                            </div>
                            <div class="relative z-0 w-full group">
                                <label for="pdf_2">PDF 2</label>
                                <input type="file" name="pdf_2" id="pdf_2"
                                    class="can-exp-input w-full block border border-gray-300 rounded"
                                    placeholder=" " @input="handleInput($event.target.value, 'pdf_2')"
                                    :value="form['pdf_2'] ? form['pdf_2'] : ''" />
                                <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`pdf_2`)"
                                    v-text="validationErros.get(`pdf_2`)"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button @click="toggleDivs2" class="w-full flex justify-between items-center bg-gray-50 border border-gray-200 rounded-md py-2 px-4">
                        <span>Spanish</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 01-1.06 0l-7.5-7.5a.75.75 0 011.06-1.06L12 14.69l6.97-6.97a.75.75 0 111.06 1.06l-7.5 7.5z" clip-rule="evenodd" />
                        </svg>

                    </button>

                    <div v-if="showDiv2" class="bg-gray-50 shadow p-3 rounded-md mt-2 border border-gray-200">
                        <div class="grid my-5 md:grid-cols-2 gap-4" v-for="language in languages" :key="language.id"
                            :class="(activeTab == null && language.is_default) || activeTab == language.id ? 'block' : 'hidden'">
                            <div class="relative z-0 w-full group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name"
                                    class="can-exp-input w-full block border border-gray-300 rounded"
                                    placeholder=" " @input="handleNameInput($event.target.value, language)"
                                    :value="form['name'] && form['name'][`name_${language.id}`] ? form['name'][`name_${language.id}`] : ''" />
                                <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`name.name_${language.id}`)"
                                    v-text="validationErros.get(`name.name_${language.id}`)"></p>
                            </div>
                            <div class="relative z-0 w-full group">
                                <label for="country_name">Country name</label>
                                <input type="text" name="country_name" id="country_name"
                                    class="can-exp-input w-full block border border-gray-300 rounded"
                                    placeholder=" " @input="handleCountryNameInput($event.target.value, language)"
                                    :value="form['country_name'] && form['country_name'][`country_name_${language.id}`] ? form[
                                        'country_name'][`country_name_${language.id}`] : ''" />
                                <p class="mt-2 text-sm text-red-400"
                                    v-if="validationErros.has(`country_name.country_name_${language.id}`)"
                                    v-text="validationErros.get(`country_name.country_name_${language.id}`)"></p>
                            </div>
                        </div>
                        <div class="grid my-5 md:grid-cols-2 gap-4">
                            <div class="relative z-0 w-full group">
                                <label for="name">Name</label>
                                <select @input="handleInput($event.target.value, 'business_category_id')"
                                    class="can-exp-input w-full block border border-gray-300 rounded">
                                    <option value="">Select Business category...</option>
                                    <option v-for="business_category in business_categories" :key="business_category.id"
                                        :value="business_category.id" :selected="business_category.id == form.business_category_id">
                                        {{ business_category . business_category_detail && business_category . business_category_detail[0] ? business_category . business_category_detail[0] . name : '' }}
                                    </option>
                                </select>

                                <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('name')"
                                    v-text="validationErros.get('name')"></p>
                            </div>
                            <div class="relative z-0 w-full group">
                                <label for="deadline_date">Deadline date</label>
                                <input type="date" name="deadline_date" id="deadline_date"
                                    class="can-exp-input w-full block border border-gray-300 rounded"
                                    placeholder=" " @input="handleInput($event.target.value, 'deadline_date')"
                                    :value="form['deadline_date'] ? form['deadline_date'] : ''" />
                                <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`deadline_date`)"
                                    v-text="validationErros.get(`deadline_date`)"></p>
                            </div>
                            <div class="relative z-0 w-full group">
                                <label for="estimated_value">Estimated value</label>
                                <input type="text" name="estimated_value" id="estimated_value"
                                    class="can-exp-input w-full block border border-gray-300 rounded"
                                    placeholder=" " @input="handleInput($event.target.value, 'estimated_value')"
                                    :value="form['estimated_value'] ? form['estimated_value'] : ''" />
                                <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`estimated_value`)"
                                    v-text="validationErros.get(`estimated_value`)"></p>
                            </div>
                            <div class="relative z-0 w-full group">
                                <label for="pdf_1">PDF 1</label>
                                <input type="file" name="pdf_1" id="pdf_1"
                                    class="can-exp-input w-full block border border-gray-300 rounded"
                                    placeholder=" " @input="handleInput($event.target.value, 'pdf_1')"
                                    :value="form['pdf_1'] ? form['pdf_1'] : ''" />
                                <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`pdf_1`)"
                                    v-text="validationErros.get(`pdf_1`)"></p>
                            </div>
                            <div class="relative z-0 w-full group">
                                <label for="pdf_2">PDF 2</label>
                                <input type="file" name="pdf_2" id="pdf_2"
                                    class="can-exp-input w-full block border border-gray-300 rounded"
                                    placeholder=" " @input="handleInput($event.target.value, 'pdf_2')"
                                    :value="form['pdf_2'] ? form['pdf_2'] : ''" />
                                <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`pdf_2`)"
                                    v-text="validationErros.get(`pdf_2`)"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="button-exp-fill mt-4 w-full text-center">Submit</button> -->
            </form>
        </div>
    </AppLayout>
</template>

<script>
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            loading: (state) => state.i2b.loading,
            isFormEdit: (state) => state.i2b.isFormEdit,
            form: (state) => state.i2b.form,
            validationErros: (state) => state.i2b.validationErros,
            languages: (state) => state.languages.languages,
            business_categories: (state) =>
                state.business_categories.business_categories,
        }),
    },
    data() {
        return {
            activeTab: null,
            showDiv1: false,
            showDiv2: false,
        };
    },
    methods: {
        handleImage(e, field) {
            var file = new FormData();
            file.append("file", e.target.files[0]);
            file.append("upload_dir", 'i2b');
            file.append("type", 'only_pdf');
            axios
                .post(`${process.env.MIX_ADMIN_API_URL}media/image_again_upload`, file)
                .then((res) => {
                    this.handleInput(res?.data, field);
                }).catch((error) => {
                    if (error.response && error.response.status == 422) {
                        let obj = {};
                        obj[field] = error.response.data.errors['file'];
                            this.$store.commit('i2b/setValidationErros', obj);
                        }
                    });
        },
        toggleDivs() {
            this.showDiv1 = !this.showDiv1;
        },
        toggleDivs2() {
            this.showDiv2 = !this.showDiv2;
        },
        handleNameInput(value, language) {
            this.$store.commit("i2b/updateName", {
                name: value,
                id: language.id,
            });
        },
        handleCountryNameInput(value, language) {
            this.$store.commit("i2b/updateCountryName", {
                country_name: value,
                id: language.id,
            });
        },
        handleInput(value, fieldName) {
            this.$store.commit("i2b/updateForm", {
                fieldName: fieldName,
                value: value,
            });
        },
        addUpdateForm() {
            this.$store
                .dispatch("i2b/addUpdateForm")
                .then(() => this.$router.push({ name: "admin.i2b.index" }));
        },
        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
        fetchI2() {
            if (this.$route.params.id) {
                let id = this.$route.params.id;
                this.$store.commit("i2b/setIsFormEdit", 1);
                this.$store
                    .dispatch("i2b/fetchI2", {
                        id: id,
                        url: `${process.env.MIX_ADMIN_API_URL}i2b/${id}?withI2bDetail=1`,
                    })
                    .then((res) => {
                        let data =
                            res.data.data && res.data.data.i2b_detail
                                ? res.data.data.i2b_detail
                                : [];
                        this.handleInput(
                            res.data.data.business_category_id,
                            "business_category_id"
                        );
                        this.handleInput(
                            res.data.data.business_category_id_2,
                            "business_category_id_2"
                        );
                        this.handleInput(
                            res.data.data.business_category_id_3,
                            "business_category_id_3"
                        );
                        this.handleInput(
                            res.data.data.deadline_date_val,
                            "deadline_date"
                        );
                        this.handleInput(
                            res.data.data.email,
                            "email"
                        );
                        this.handleInput(
                            res.data.data.estimated_value,
                            "estimated_value"
                        );
                        this.handleInput(res.data.data.pdf_1, "pdf_1");
                        this.handleInput(res.data.data.pdf_2, "pdf_2");
                        this.handleInput(res.data.data.pdf_3, "pdf_3");
                        let obj = {};
                        data.map((res) => {
                            obj["name_" + res.language_id] = res.name;
                        });
                        this.$store.commit("i2b/setName", obj);

                        obj = {};
                        data.map((res) => {
                            obj["country_name_" + res.language_id] =
                                res.country_name;
                        });
                        this.$store.commit("i2b/setCountryName", obj);
                    });
            }
        },
    },
    created() {
        this.$store.commit("i2b/resetForm");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                data.map((res) => {
                    obj["name_" + res.id] = "";
                });
                this.$store.commit("i2b/setName", obj);
                obj = {};
                data.map((res) => {
                    obj["country_name_" + res.id] = "";
                });
                this.$store.commit("i2b/setCountryName", obj);
                this.fetchI2();
                this.$store.dispatch(
                    "business_categories/fetchBusinessCategories",
                    {
                        url: `${process.env.MIX_ADMIN_API_URL}business-categories?getAll=1`,
                    }
                );
            });
    },
};
</script>

