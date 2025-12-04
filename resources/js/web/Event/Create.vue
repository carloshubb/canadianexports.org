<template>
    <div class="space-y-6">
        <form
            class="text-base md:text-base lg:text-lg"
            @submit.prevent="recaptcha()"
        >
            <!-- <div class="text-center text-gray-500 border-b border-gray-200">
                <ul
                    class="flex flex-wrap mb-2 overflow-x-auto gap-1 list-none p-0"
                >
                    <li
                        class="mr-2"
                        v-for="language in JSON.parse(languages)"
                        :key="language.id"
                    >
                        <a
                            aria-label="Candian Exporters"
                            @click.prevent="changeLanguageTab(language)"
                            href="#"
                            :class="[
                                'inline-block rounded font-FuturaMdCnBT px-5 py-2 lg:text-lg md:text-base sm:text-base text-base hover:bg-blue-100 border border-primary text-center hover:border-blue-500 hover:text-blue-600',
                                (activeTab == null && language.is_default) ||
                                activeTab == language.id
                                    ? 'bg-blue-600 text-white'
                                    : '',
                                checkValidationError(validationErros, language)
                                    ? 'bg-red-600 border-red-600 text-white hover:text-white rounded hover:bg-red-600 hover:border-red-600'
                                    : '',
                            ]"
                            >{{ language.name }}</a
                        >
                    </li>
                </ul>
            </div> -->
            <div
                class="px-4 my-6 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-primary to-secondary rounded-md"
            >
                <h4 class="text-center card-heading text-white">
                    {{ JSON.parse(eventsetting).create_event_tab_heading }}
                </h4>
            </div>

            <div
                class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6"
                v-for="language in JSON.parse(languages)"
                :key="language.id"
                :class="
                    (activeTab == null && language.is_default) ||
                    activeTab == language.id
                        ? 'block'
                        : 'hidden'
                "
            >
                <div class="relative z-0 w-full group">
                    <label for="title" class="text-base md:text-base lg:text-lg"
                        >{{ JSON.parse(eventsetting).title_label }}
                        <span class="text-red-500">*</span></label
                    >
                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        placeholder=" "
                        @input="
                            handleInput($event.target.value, language, 'title');
                            clearErrors('title.title_' + language.id);
                        "
                        :value="
                            form['title'] &&
                            form['title'][`title_${language.id}`]
                                ? form['title'][`title_${language.id}`]
                                : ''
                        "
                    />

                    <Error
                        v-if="submitted"
                        :fieldName="`title.title_${language.id}`"
                        :validationErros="validationErros"
                    />
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        for="country"
                        class="text-base md:text-base lg:text-lg"
                        >{{ JSON.parse(eventsetting).country_label }}
                        <span class="text-red-500">*</span></label
                    >
                    <input
                        type="text"
                        name="country"
                        id="country"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'country'
                            );
                            clearErrors('country.country_' + language.id);
                        "
                        :value="
                            form['country'] &&
                            form['country'][`country_${language.id}`]
                                ? form['country'][`country_${language.id}`]
                                : ''
                        "
                    />

                    <Error
                        v-if="submitted"
                        :fieldName="`country.country_${language.id}`"
                        :validationErros="validationErros"
                    />
                </div>
                <div class="relative z-0 w-full group">
                    <label for="city" class="text-base md:text-base lg:text-lg"
                        >{{ JSON.parse(eventsetting).city_label }}
                        <span class="text-red-500">*</span></label
                    >
                    <input
                        type="text"
                        name="city"
                        id="city"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        placeholder=" "
                        @input="
                            handleInput($event.target.value, language, 'city');
                            clearErrors('city.city_' + language.id);
                        "
                        :value="
                            form['city'] && form['city'][`city_${language.id}`]
                                ? form['city'][`city_${language.id}`]
                                : ''
                        "
                    />
                    <Error
                        v-if="submitted"
                        :fieldName="`city.city_${language.id}`"
                        :validationErros="validationErros"
                    />
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        for="street_name"
                        class="text-base md:text-base lg:text-lg"
                        >{{ JSON.parse(eventsetting).street_name_label }}</label
                    >
                    <input
                        type="text"
                        name="street_name"
                        id="street_name"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'street_name'
                            );
                            clearErrors(
                                'street_name.street_name_' + language.id
                            );
                        "
                        :value="
                            form['street_name'] &&
                            form['street_name'][`street_name_${language.id}`]
                                ? form['street_name'][
                                      `street_name_${language.id}`
                                  ]
                                : ''
                        "
                    />
                    <Error
                        v-if="submitted"
                        :fieldName="`street_name.street_name_${language.id}`"
                        :validationErros="validationErros"
                    />
                </div>
                <div class="relative z-0 w-full group">
                    <label for="venue" class="text-base md:text-base lg:text-lg"
                        >{{ JSON.parse(eventsetting).venue_label }}
                        </label
                    >
                    <input
                        type="text"
                        name="venue"
                        id="venue"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        placeholder=" "
                        @input="
                            handleInput($event.target.value, language, 'venue');
                            clearErrors('venue.venue_' + language.id);
                        "
                        :value="
                            form['venue'] &&
                            form['venue'][`venue_${language.id}`]
                                ? form['venue'][`venue_${language.id}`]
                                : ''
                        "
                    />
                    <Error
                        v-if="submitted"
                        :fieldName="`venue.venue_${language.id}`"
                        :validationErros="validationErros"
                    />
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        for="product_search"
                        class="text-base md:text-base lg:text-lg"
                        >{{
                            JSON.parse(eventsetting).product_search_label
                        }}</label
                    >
                    <input
                        type="text"
                        name="product_search"
                        id="product_search"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        :placeholder="
                            JSON.parse(eventsetting).product_search_placeholder
                        "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'product_search'
                            );
                            clearErrors(
                                'product_search.product_search_' + language.id
                            );
                        "
                        :value="
                            form['product_search'] &&
                            form['product_search'][
                                `product_search_${language.id}`
                            ]
                                ? form['product_search'][
                                      `product_search_${language.id}`
                                  ]
                                : ''
                        "
                    />
                    <Error
                        v-if="submitted"
                        :fieldName="`product_search.product_search_${language.id}`"
                        :validationErros="validationErros"
                    />
                </div>
                <!-- <div class="relative z-0 w-full group">
                    <label
                        for="short_description"
                        class="text-base md:text-base lg:text-lg"
                        >{{ JSON.parse(eventsetting).short_description_label }}
                        <span class="text-red-500">*</span></label
                    >
                    <textarea
                        id="short_description"
                        rows="4"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        :placeholder="JSON.parse(eventsetting).short_description_placeholder"
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'short_description'
                            )
                        "
                        v-text="
                            form['short_description'] &&
                            form['short_description'][
                                `short_description_${language.id}`
                            ]
                                ? form['short_description'][
                                      `short_description_${language.id}`
                                  ]
                                : ''
                        "
                    ></textarea>
                    <Error
                        :fieldName="`short_description.short_description_${language.id}`"
                        :validationErros="validationErros"
                    />
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <label
                        for="description"
                        class="text-base md:text-base lg:text-lg"
                        >{{ JSON.parse(eventsetting).description_label }}</label
                    >
                    <textarea
                        id="description"
                        rows="4"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        :placeholder="JSON.parse(eventsetting).description_placeholder"
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'description'
                            )
                        "
                        v-text="
                            form['description'] &&
                            form['description'][`description_${language.id}`]
                                ? form['description'][
                                      `description_${language.id}`
                                  ]
                                : ''
                        "
                    ></textarea>
                    <Error
                        :fieldName="`description.description_${language.id}`"
                        :validationErros="validationErros"
                    />
                </div> -->
                <div class="relative z-0 w-full group">
                    <label
                        for="short_description"
                        class="text-base md:text-base lg:text-lg"
                    >
                        {{ JSON.parse(eventsetting).short_description_label }}
                        <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        id="short_description"
                        rows="4"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        :placeholder="
                            JSON.parse(eventsetting)
                                .short_description_placeholder
                        "
                        @input="
                            restrictToLength(
                                $event,
                                30,
                                language,
                                'short_description'
                            );
                            clearErrors(
                                'short_description.short_description_' +
                                    language.id
                            );
                        "
                        v-text="
                            form['short_description'] &&
                            form['short_description'][
                                `short_description_${language.id}`
                            ]
                                ? form['short_description'][
                                      `short_description_${language.id}`
                                  ]
                                : ''
                        "
                    ></textarea>
                    <Error
                        v-if="submitted"
                        :fieldName="`short_description.short_description_${language.id}`"
                        :validationErros="validationErros"
                    />
                </div>

                <!-- Description (Max 300 Words) -->
                <div class="relative z-0 w-full mb-6 group">
                    <label
                        for="description"
                        class="text-base md:text-base lg:text-lg"
                    >
                        {{ JSON.parse(eventsetting).description_label }}
                        <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        id="description"
                        rows="4"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        :placeholder="
                            JSON.parse(eventsetting).description_placeholder
                        "
                        @input="
                            restrictToLength(
                                $event,
                                300,
                                language,
                                'description'
                            );
                            clearErrors(
                                'description.description_' + language.id
                            );
                        "
                        v-text="
                            form['description'] &&
                            form['description'][`description_${language.id}`]
                                ? form['description'][
                                      `description_${language.id}`
                                  ]
                                : ''
                        "
                    ></textarea>
                    <Error
                        v-if="submitted"
                        :fieldName="`description.description_${language.id}`"
                        :validationErros="validationErros"
                    />
                </div>
            </div>

            <div class="grid md:grid-cols-2 md:gap-6 gap-4">
                <div class="relative z-0 w-full group">
                    <label
                        for="start_date"
                        class="text-base md:text-base lg:text-lg"
                        >{{ JSON.parse(eventsetting).start_date_label }}
                        <span class="text-red-500">*</span></label
                    >
                    <input
                        type="date"
                        name="start_date"
                        id="start_date"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        placeholder=" "
                        :value="form.start_date"
                        @input="
                            checkDateLength('start_date', $event);
                            clearErrors('start_date.start_date_' + language.id);
                        "
                    />
                    <Error
                        v-if="submitted"
                        fieldName="start_date"
                        :validationErros="validationErros"
                    />
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        for="end_date"
                        class="text-base md:text-base lg:text-lg"
                        >{{ JSON.parse(eventsetting).end_date_label }}
                        <span class="text-red-500">*</span></label
                    >
                    <input
                        type="date"
                        name="end_date"
                        id="end_date"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        placeholder=" "
                        :value="form.end_date"
                        @input="
                            checkDateLength('end_date', $event);
                            clearErrors('end_date.end_date_' + language.id);
                        "
                    />
                    <Error
                        v-if="submitted"
                        fieldName="end_date"
                        :validationErros="validationErros"
                    />
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        for="event_website"
                        class="text-base md:text-base lg:text-lg"
                        >{{ JSON.parse(eventsetting).event_website_label }}
                        <span class="text-red-500">*</span></label
                    >
                    <textarea
                        rows="2"
                        name="event_website"
                        id="event_website"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        :placeholder="
                            JSON.parse(eventsetting).event_website_placeholder
                        "
                        :value="form.event_website"
                        @input="
                            updateForm('event_website', $event.target.value);
                            clearErrors('event_website');
                        "
                    ></textarea>
                    <Error
                        v-if="submitted"
                        fieldName="event_website"
                        :validationErros="validationErros"
                    />
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        for="exibitors_url"
                        class="text-base md:text-base lg:text-lg"
                        >{{
                            JSON.parse(eventsetting).exibitors_url_label
                        }}</label
                    >
                    <textarea
                        rows="2"
                        name="exibitors_url"
                        id="exibitors_url"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        :placeholder="
                            JSON.parse(eventsetting).exibitors_url_placeholder
                        "
                        :value="form.exibitors_url"
                        @input="
                            updateForm('exibitors_url', $event.target.value);
                            clearErrors(
                                'exibitors_url.exibitors_url_' + language.id
                            );
                        "
                    ></textarea>
                    <Error
                        v-if="submitted"
                        fieldName="exibitors_url"
                        :validationErros="validationErros"
                    />
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        for="visitors_url"
                        class="text-base md:text-base lg:text-lg"
                        >{{ JSON.parse(eventsetting).visitors_label }}</label
                    >
                    <input
                        type="text"
                        name="visitors_url"
                        id="visitors_url"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        :placeholder="
                            JSON.parse(eventsetting).visitors_placeholder
                        "
                        :value="form.visitors_url"
                        @input="
                            updateForm('visitors_url', $event.target.value);
                            clearErrors(
                                'visitors_url.visitors_url_' + language.id
                            );
                        "
                    />
                    <Error
                        this.submitted="true;"
                        fieldName="visitors_url"
                        :validationErros="validationErros"
                    />
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        for="press_url"
                        class="text-base md:text-base lg:text-lg"
                        >{{ JSON.parse(eventsetting).press_url_label }}</label
                    >
                    <input
                        type="text"
                        name="press_url"
                        id="press_url"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        :placeholder="
                            JSON.parse(eventsetting).press_url_placeholder
                        "
                        :value="form.press_url"
                        @input="
                            updateForm('press_url', $event.target.value);
                            clearErrors('press_url.press_url_' + language.id);
                        "
                    />
                    <Error
                        v-if="submitted"
                        fieldName="press_url"
                        :validationErros="validationErros"
                    />
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        for="video_url"
                        class="text-base md:text-base lg:text-lg"
                        >{{ JSON.parse(eventsetting).video_url_label }}</label
                    >
                    <textarea
                        rows="2"
                        name="video_url"
                        id="video_url"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        :placeholder="
                            JSON.parse(eventsetting).video_url_placeholder
                        "
                        :value="form.video_url"
                        @input="
                            updateForm('video_url', $event.target.value);
                            clearErrors('vedio_url.vedio_url_' + language.id);
                        "
                    ></textarea>
                    <Error
                        v-if="submitted"
                        fieldName="video_url"
                        :validationErros="validationErros"
                    />
                </div>
                <div class="relative z-0 w-full group"></div>
            </div>
            <div
                class="px-4 my-6 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-primary to-secondary rounded-md"
            >
                <h4 class="text-center card-heading text-white">
                    {{ JSON.parse(eventsetting).contact_info_tab_heading }}
                </h4>
            </div>
            <div v-for="(contact, index) in contacts" :key="index">
                <div
                    class="grid md:grid-cols-3 md:gap-6 gap-4 mt-6 bg-white shadow rounded-lg p-6"
                >
                    <div class="relative z-0 w-full group">
                        <label
                            :for="`contact-name-[${index}]`"
                            class="text-base md:text-base lg:text-lg"
                        >
                            {{ JSON.parse(eventsetting).contact_name_label }}
                            <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="contact-name"
                            :id="`contact-name-[${index}]`"
                            class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                            v-model="contact.name"
                            placeholder=""
                            @input="
                                updateContact(
                                    index,
                                    'name',
                                    $event.target.value
                                );
                                clearErrors(`contacts.${index}.name`);
                            "
                        />
                        <Error
                            :fieldName="`contacts.${index}.name`"
                            :validationErros="validationErros"
                        />
                    </div>

                    <!-- Contact Email -->
                    <div class="relative z-0 w-full group">
                        <label
                            :for="`contact-email-[${index}]`"
                            class="text-base md:text-base lg:text-lg"
                        >
                            {{ JSON.parse(eventsetting).contact_email_label }}
                            <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="contact-email"
                            :id="`contact-email-[${index}]`"
                            class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                            v-model="contact.email"
                            placeholder=""
                            @input="
                                updateContact(
                                    index,
                                    'email',
                                    $event.target.value
                                );
                                clearErrors(`contacts.${index}.email`);
                            "
                        />
                        <Error
                            :fieldName="`contacts.${index}.email`"
                            :validationErros="validationErros"
                        />
                    </div>

                    <!-- Contact Phone -->
                    <div class="relative z-0 w-full group">
                        <label
                            :for="`contact-phone-[${index}]`"
                            class="text-base md:text-base lg:text-lg"
                        >
                            {{ JSON.parse(eventsetting).contact_phone_label }}
                            <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="contact-phone"
                            :id="`contact-phone-[${index}]`"
                            class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                            v-model="contact.phone"
                            placeholder=""
                            @input="
                                updateContact(
                                    index,
                                    'phone',
                                    $event.target.value
                                );
                                clearErrors(`contacts.${index}.phone`);
                            "
                        />
                        <Error
                            :fieldName="`contacts.${index}.phone`"
                            :validationErros="validationErros"
                        />
                    </div>

                    <!-- Contact Designation -->
                    <!-- <div class="relative z-0 w-full group">
                        <label
                            :for="`contact-designation-[${index}]`"
                            class="text-base md:text-base lg:text-lg"
                        >
                            {{
                                JSON.parse(eventsetting)
                                    .contact_designation_label
                            }}
                            <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="contact-designation"
                            :id="`contact-designation-[${index}]`"
                            class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                            v-model="contact.designation"
                            placeholder=""
                            @input="
                                updateContact(
                                    index,
                                    'designation',
                                    $event.target.value
                                );
                                clearErrors(`contacts.${index}.designation`);
                            "
                        />
                        <Error
                            :fieldName="`contacts.${index}.designation`"
                            :validationErros="validationErros"
                        />
                    </div> -->

                    <!-- Contact Image -->
                    <!-- <div class="relative z-0 w-full group">
                        <label
                            :for="`contact-image-[${index}]`"
                            class="text-base md:text-base lg:text-lg"
                        >
                            {{ JSON.parse(eventsetting).profile_image_label }}
                            <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="file"
                            name="contact-image"
                            :id="`contact-image-[${index}]`"
                            class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                            @change="uploadImage($event, index)"
                            @input="clearErrors(`contacts.${index}.image_path`)"
                        />
                        <img
                            v-if="contact.image_path"
                            :src="contact.image_path"
                            style="height: 100px; width: 100px"
                        />
                        <Error
                            :fieldName="`file`"
                            :validationErros="validationErros"
                        />
                        <Error
                            :fieldName="`contacts.${index}.image_path`"
                            :validationErros="validationErros"
                        />
                    </div> -->
                    <div class="relative z-0 w-full group">
    <label :for="`contact-image-[${index}]`" class="text-base md:text-base lg:text-lg">
        {{ JSON.parse(eventsetting).profile_image_label }}
        <!-- Removed the required asterisk -->
    </label>
    <input
        type="file"
        name="contact-image"
        :id="`contact-image-[${index}]`"
        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
        @change="uploadImage($event, index)"
        @input="clearErrors(`contacts.${index}.image_path`)"
    />
    <div v-if="contact.image_path" class="mt-2">
        <img
            :src="contact.image_path"
            class="h-40 w-40 object-cover rounded-lg cursor-pointer hover:opacity-80 transition-opacity"
            @click="showImagePopup(contact.image_path)"
        />
    </div>
    <Error
        :fieldName="`file`"
        :validationErros="validationErros"
    />
    <Error
        :fieldName="`contacts.${index}.image_path`"
        :validationErros="validationErros"
    />
</div>

<!-- Add this popup modal at the bottom of your template -->
<div v-if="popupImage" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75">
    <div class="relative max-w-4xl max-h-full">
        <img :src="popupImage" class="max-w-full max-h-screen" />
        <button
            @click="popupImage = null"
            class="absolute top-4 right-4 text-white text-2xl hover:text-gray-300"
        >
            &times;
        </button>
    </div>
</div>

                    <!-- Delete Contact Button -->
                    <div v-if="index !== 0" class="relative z-0 w-full group">
                        <button
                            type="button"
                            class="button-exp-fill mt-7"
                            @click.prevent="deleteContact(index)"
                        >
                            {{ JSON.parse(eventsetting).delete_btn_text }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <button
                    type="button"
                    class="button-exp-fill mt-7"
                    @click.prevent="addContact"
                >
                    {{ JSON.parse(eventsetting).add_new_contact_btn_text }}
                </button>
            </div>
            <div
                class="px-4 my-6 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-primary to-secondary rounded-md"
            >
                <h4 class="text-center card-heading text-white">
                    {{ JSON.parse(eventsetting).social_media_tab_heading }}
                </h4>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6 gap-4">
                <div class="relative z-0 w-full group">
                    <label
                        for="facebook_url"
                        class="text-base md:text-base lg:text-lg"
                        >{{
                            JSON.parse(eventsetting).facebook_url_label
                        }}</label
                    >
                    <input
                        type="text"
                        name="facebook_url"
                        id="facebook_url"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        placeholder=" "
                        :value="form.facebook_url"
                        @input="
                            updateForm('facebook_url', $event.target.value);
                            clearFieldError('facebook_url');
                        "
                    />
                    <Error
                        v-if="submitted"
                        fieldName="facebook_url"
                        :validationErros="validationErros"
                    />
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        for="twitter_url"
                        class="text-base md:text-base lg:text-lg"
                        >{{ JSON.parse(eventsetting).twitter_url_label }}</label
                    >
                    <input
                        type="text"
                        name="twitter_url"
                        id="twitter_url"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        placeholder=" "
                        :value="form.twitter_url"
                        @input="
                            updateForm('twitter_url', $event.target.value);
                            clearFieldError('twitter_url');
                        "
                    />
                    <Error
                        v-if="submitted"
                        fieldName="twitter_url"
                        :validationErros="validationErros"
                    />
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        for="linkedin_url"
                        class="text-base md:text-base lg:text-lg"
                        >{{
                            JSON.parse(eventsetting).linkedin_url_label
                        }}</label
                    >
                    <input
                        type="text"
                        name="linkedin_url"
                        id="linkedin_url"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        placeholder=" "
                        :value="form.linkedin_url"
                        @input="
                            updateForm('linkedin_url', $event.target.value);
                            clearFieldError('linkedin_url');
                        "
                    />
                    <Error
                        v-if="submitted"
                        fieldName="linkedin_url"
                        :validationErros="validationErros"
                    />
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        for="youtube_url"
                        class="text-base md:text-base lg:text-lg"
                        >{{ JSON.parse(eventsetting).youtube_url_label }}</label
                    >
                    <input
                        type="text"
                        name="youtube_url"
                        id="youtube_url"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        placeholder=" "
                        :value="form.youtube_url"
                        @input="
                            updateForm('youtube_url', $event.target.value);
                            clearFieldError('youtube_url');
                        "
                    />
                    <Error
                        v-if="submitted"
                        fieldName="youtube_url"
                        :validationErros="validationErros"
                    />
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        for="pintrest_url"
                        class="text-base md:text-base lg:text-lg"
                        >{{
                            JSON.parse(eventsetting).pintrest_url_label
                        }}</label
                    >
                    <input
                        type="text"
                        name="pintrest_url"
                        id="pintrest_url"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        placeholder=" "
                        :value="form.pintrest_url"
                        @input="
                            updateForm('pintrest_url', $event.target.value);
                            clearFieldError('pintrest_url');
                        "
                    />
                    <Error
                        v-if="submitted"
                        fieldName="pintrest_url"
                        :validationErros="validationErros"
                    />
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        for="instagram_url"
                        class="text-base md:text-base lg:text-lg"
                        >{{
                            JSON.parse(eventsetting).instagram_url_label
                        }}</label
                    >
                    <input
                        type="text"
                        name="instagram_url"
                        id="instagram_url"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        placeholder=" "
                        :value="form.instagram_url"
                        @input="
                            updateForm('instagram_url', $event.target.value);
                            clearFieldError('instagram_url');
                        "
                    />
                    <Error
                        v-if="submitted"
                        fieldName="instagram_url"
                        :validationErros="validationErros"
                    />
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        for="snapchat_url"
                        class="text-base md:text-base lg:text-lg"
                        >{{
                            JSON.parse(eventsetting).snapchat_url_label
                        }}</label
                    >
                    <input
                        type="text"
                        name="snapchat_url"
                        id="snapchat_url"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        placeholder=" "
                        :value="form.snapchat_url"
                        @input="
                            updateForm('snapchat_url', $event.target.value);
                            clearFieldError('snapchat_url');
                        "
                    />
                    <Error
                        v-if="submitted"
                        fieldName="snapchat_url"
                        :validationErros="validationErros"
                    />
                </div>
                <!-- event media -->
                <div class="w-full">
                    <label for=""
                        >Event Main Image <span class="text-red-500">*</span></label
                    >
                    <div class="relative z-0 w-full mb-6 group">
                        <template
                            v-if="
                                current_user &&
                                JSON.parse(current_user)[
                                    'registration_package'
                                ] &&
                                JSON.parse(current_user)[
                                    'registration_package'
                                ]['package_type'] == 'featured'
                            "
                        >
                            <FilePond
                                labelIdle='<span class="cursor-pointer">Drag & Drop your files or <span class="filepond--label-action"> Browse </span></span>'
                                class="cursor-pointer"
                                name="gallery_image"
                                ref="gallery_image"
                                class-name="my-pond"
                                credits="false"
                                accepted-file-types="image/*"
                                allow-multiple="true"
                                @init="handleGalleryImagesInit"
                                @processfile="handleGalleryImagesProcess"
                                @removefile="handleGalleryImagesRemoveFile"
                                v-bind:files="gallery_files"
                                @addfile="clearErrors('gallery_images')"
                            />
                        </template>
                        <template v-else>
                            <FilePond
                                labelIdle='<span class="cursor-pointer">Drag & Drop your files or <span class="filepond--label-action"> Browse </span></span>'
                                class="cursor-pointer"
                                name="gallery_image"
                                ref="gallery_image"
                                class-name="my-pond"
                                credits="false"
                                accepted-file-types="image/*"
                                @init="handleGalleryImagesInit"
                                @processfile="handleGalleryImagesProcess"
                                @removefile="handleGalleryImagesRemoveFile"
                                v-bind:files="gallery_files"
                                @addfile="clearErrors('gallery_images')"
                            />
                        </template>
                    </div>
                    <Error
                        fieldName="gallery_images"
                        :validationErros="validationErros"
                    />
                </div>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6 my-6">
                <!-- event packages -->
                <div
                    class="w-full"
                    v-if="
                        JSON.parse(current_user)['events_remaining'] <= 0 ||
                        JSON.parse(current_user)['events_remaining'] == null
                    "
                >
                    <div
                        class="flex items-center"
                        v-for="registrationPackage in registrationPackages"
                        :key="registrationPackage.id"
                    >
                        <input
                            :id="`package-${registrationPackage.id}`"
                            :value="registrationPackage.id"
                            name="registration-package"
                            type="radio"
                            class="h-4 w-4 border-gray-300 accent-primaryRed"
                            @click="
                                updateForm(
                                    'registration_package_id',
                                    $event.target.value,
                                    registrationPackage.price
                                )
                            "
                            :checked="
                                form.registration_package_id ==
                                registrationPackage.id
                            "
                        />
                        <label
                            :for="`package-${registrationPackage.id}`"
                            class="ml-2 block text-gray-900"
                        >
                            {{
                                registrationPackage.registration_package_detail &&
                                registrationPackage
                                    .registration_package_detail[0]
                                    ? registrationPackage
                                          .registration_package_detail[0]
                                          .amount_pre_text
                                    : ""
                            }}

                            ${{
                                registrationPackage.discount_price &&
                                registrationPackage.discount_price > 0
                                    ? registrationPackage.discount_price
                                    : registrationPackage.price
                            }}

                            {{
                                registrationPackage.registration_package_detail &&
                                registrationPackage
                                    .registration_package_detail[0]
                                    ? registrationPackage
                                          .registration_package_detail[0]
                                          .amount_post_text
                                    : ""
                            }}
                        </label>
                    </div>
                    <Error
                        fieldName="registration_package_id"
                        :validationErros="validationErros"
                    />
                    <div
                        class="flex flex-col space-y-3 mt-6"
                        v-if="form.order_amount > 0"
                    >
                        <div class="flex space-x-4">
                            <div class="flex items-center">
                                <input
                                    id="stripe"
                                    value="stripe"
                                    name="payment-method"
                                    type="radio"
                                    class="h-4 w-4 border-gray-300 accent-primaryRed"
                                    @click="
                                        updateForm('payment_method', 'stripe')
                                    "
                                    :checked="form.payment_method == 'stripe'"
                                />
                                <label
                                    for="stripe"
                                    class="ml-2 block text-gray-900"
                                >
                                    {{
                                        payment_setting
                                            ? payment_setting[
                                                  "pay_with_credit_card_text"
                                              ]
                                            : ""
                                    }}
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input
                                    id="paypal"
                                    value="paypal"
                                    name="payment-method"
                                    type="radio"
                                    class="h-4 w-4 border-gray-300 accent-primaryRed"
                                    @click="
                                        updateForm('payment_method', 'paypal')
                                    "
                                    :checked="form.payment_method == 'paypal'"
                                />
                                <label
                                    for="paypal"
                                    class="ml-2 block text-gray-900"
                                    ><svg
                                        viewBox="0 0 157 44"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-16 h-16 text-[#635BFF]"
                                    >
                                        <g clip-path="url(#clip0_6_187)">
                                            <path
                                                d="M6.89999 2C7.29999 0.3 7.79999 0 9.49999 0C11.5 0 13.5 0 15.6 0C18.2 0.1 20.8 0.1 23.4 0.3C24.9 0.4 26.4 0.9 27.8 1.5C31.1 2.9 32.9 6.5 32.3 10.3C31.5 16 27.9 19.1 22.6 20.7C20.1 21.4 17.6 21.6 15 21.7C14.6 21.7 14.3 21.7 13.9 21.7C11.8 21.8 11 22.4 10.4 24.4C9.79999 26.7 9.09999 28.9 8.49999 31.2C8.19999 32.4 7.89999 32.6 6.59999 32.6C4.79999 32.6 2.99999 32.6 1.29999 32.4C0.0999947 32.3 -0.200005 31.9 0.0999947 30.7L6.89999 2ZM15.3 15.6C17 15.6 19.3 14.9 21 14.1C22.3 13.5 23 12.5 23.2 11.1C23.6 8.9 22.9 7.2 21.2 6.6C19.4 5.9 17.4 5.8 15.5 6.2C14.8 6.4 14.3 6.8 14.2 7.5C13.7 9.3 13.2 11.1 12.9 12.9C12.5 15.1 13 15.6 15.3 15.6ZM59.6 40.3C59.2 41 58.8 41.7 58.5 42.4C58.3 43 58.6 43.5 59.2 43.5C60.8 43.5 62.5 43.5 64.1 43.5C65.6 43.5 66.6 42.9 67.4 41.7C68 40.7 68.6 39.6 69.2 38.6C75.2 28.5 81.2 18.3 87.2 8.2C87.4 7.9 87.5 7.7 87.7 7.3C85.7 7.3 83.9 7.4 82 7.3C80 7.2 78.7 8.1 77.7 9.8C75.3 14 72.9 18.1 70.5 22.2C70.3 22.5 70.1 22.8 69.8 23.1C69.7 23.1 69.7 23 69.6 23C69.5 22.7 69.4 22.3 69.4 22C68.7 17.7 68 13.4 67.3 9.1C67.1 8.1 66.3 7.3 65.2 7.3C63.9 7.3 62.5 7.4 61.2 7.3C59.4 7.2 59.1 8.1 59.3 9.5L63 33.2C63.1 33.7 63 34.2 62.7 34.6L59.6 40.3ZM44.9 32.7C45.1 31.7 45.2 31 45.4 30.1C44.9 30.4 44.6 30.6 44.3 30.8C42.1 32 40 33 37.6 33.4C33.8 34 30.2 31.9 29.4 28.4C28.7 25.5 29.8 22.3 32.3 20.5C34.6 18.8 37.3 18.1 40 17.7C42.6 17.3 45.1 17 47.7 16.8C48.5 16.7 48.6 16.4 48.6 15.7C48.4 13.9 47.2 12.9 45 12.7C42.2 12.5 39.4 13.2 36.7 13.9C36.2 14 35.7 14.2 35.1 14.4C35.1 14.1 35 13.9 35 13.7C35.1 12.4 35.1 11.1 35.2 9.9C35.2 9.4 35.3 8.9 35.9 8.7C41 7.6 46.1 7 51.3 8.1C51.6 8.2 52 8.3 52.3 8.4C55.8 9.6 57 11.5 56.3 15.1C55.3 20.1 54.2 25.2 53.1 30.2C53 30.7 52.8 31.2 52.6 31.7C52.2 32.4 51.6 32.9 50.8 32.9C48.9 32.7 47 32.7 44.9 32.7ZM47.4 21C46.4 21.1 45.4 21.1 44.6 21.3C43 21.6 41.5 21.9 40 22.3C38.6 22.7 37.9 23.8 37.6 25.2C37.3 26.8 38 27.9 39.6 28.2C41.8 28.6 43.8 28 45.6 27C45.9 26.8 46.2 26.6 46.3 26.3C46.6 24.5 47 22.8 47.4 21Z"
                                                fill="#162E53"
                                            />
                                            <path
                                                d="M91.7 1.4C92.1 0.3 92.6 0 93.7 0C95.9 0 98.1 0 100.3 0C102.9 0.1 105.5 0.1 108.1 0.3C109.6 0.5 111.1 0.9 112.5 1.5C115.7 2.8 117.5 6.3 117.1 9.9C116.5 15.3 113.1 19.2 107.3 20.6C105 21.2 102.5 21.3 100.1 21.6C99.6 21.7 99.1 21.6 98.5 21.6C96.5 21.7 95.7 22.3 95.1 24.2C94.5 26.4 93.8 28.7 93.2 30.9C92.8 32.2 92.6 32.4 91.2 32.4C89.5 32.4 87.9 32.4 86.2 32.3C84.6 32.2 84.4 31.8 84.7 30.3L91.7 1.4ZM102.3 5.9C101.7 6 100.9 6 100.2 6.2C99.7 6.4 99.2 6.8 99 7.2C98.4 9.3 97.9 11.4 97.5 13.5C97.2 15 97.7 15.4 99.2 15.5C101.4 15.6 103.5 15 105.5 14.1C107.1 13.4 107.8 12.2 108 10.5C108.2 8 107.2 6.6 104.8 6.1C104 6 103.2 6 102.3 5.9ZM119.7 14.1C119.8 13 119.8 11.9 119.9 10.8C120.1 8.3 119.8 8.7 122.3 8.2C126.2 7.4 130.1 7.1 134.1 7.6C135.2 7.7 136.4 8 137.4 8.4C140.5 9.5 141.7 11.5 141.1 14.7C140.1 19.8 138.9 24.9 137.8 30C137.7 30.5 137.5 31.1 137.2 31.5C136.8 32 136.2 32.6 135.7 32.6C133.7 32.7 131.6 32.7 129.5 32.7C129.7 31.8 129.8 31 130 30.2C129.3 30.6 128.7 31 128 31.3C125.9 32.4 123.7 33.5 121.3 33.5C117.8 33.6 115.1 31.9 114.1 29C113.1 26 114.2 22.4 116.9 20.5C119.2 18.8 121.9 18.1 124.6 17.7C127.2 17.3 129.7 17.1 132.3 16.8C132.9 16.7 133.2 16.5 133.1 15.8C133 14 131.7 12.9 129.5 12.7C126.5 12.5 123.6 13.2 120.8 14C120.5 14.1 120.2 14.2 120 14.2C120 14.2 119.9 14.1 119.7 14.1ZM132 21C131.1 21.1 130.2 21.1 129.4 21.2C127.8 21.5 126.2 21.7 124.7 22.2C123.4 22.6 122.5 23.5 122.2 24.9C121.8 26.7 122.5 27.8 124.3 28.1C126.4 28.4 128.4 27.9 130.2 26.8C130.5 26.6 130.8 26.3 130.9 25.9C131.3 24.4 131.6 22.7 132 21ZM156.3 0.1C154.3 0.1 152.5 0.1 150.6 0.1C149 0.1 148.6 0.4 148.2 2L142 30.1C141.6 31.8 141.9 32.2 143.7 32.2C144.9 32.2 146.2 32.3 147.4 32.3C148.9 32.3 149.2 32.1 149.5 30.6L156.3 0.1Z"
                                                fill="#1E6196"
                                            />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_6_187">
                                                <rect
                                                    width="156.3"
                                                    height="43.5"
                                                    fill="white"
                                                />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </label>
                            </div>
                        </div>
                        <div
                            class="flex justify-between items-center p-3 border-b"
                            v-if="customerPaymentMethods.length > 0"
                        >
                            <div class="flex items-center">
                                <label
                                    for="cards"
                                    class="block mb-2 text-gray-900 dark:text-white"
                                    >Cards</label
                                >
                                <select
                                    id="cards"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    @input="
                                        updateForm(
                                            'customer_payment_method_id',
                                            $event.target.value
                                        )
                                    "
                                >
                                    <option
                                        :value="customerPaymentMethod.id"
                                        v-for="customerPaymentMethod in customerPaymentMethods"
                                        :key="customerPaymentMethod.id"
                                    >
                                        {{ customerPaymentMethod.card_no }}
                                    </option>
                                    <option value="add_new_card">
                                        Add new card
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div
                            id="card-element"
                            class="border border-primary rounded p-2 mb-2"
                            v-if="
                                form.customer_payment_method_id ==
                                    'add_new_card' &&
                                form.order_amount > 0 &&
                                form.payment_method == 'stripe'
                            "
                        >
                            <div class="flex justify-center items-center">
                                <div
                                    class="h-auto bg-white p-3 rounded-lg w-full"
                                >
                                    <div class="input_text mt-6 relative">
                                        <label class="">{{
                                            payment_setting &&
                                            payment_setting[
                                                "cardholder_name_label"
                                            ]
                                                ? payment_setting[
                                                      "cardholder_name_label"
                                                  ]
                                                : ""
                                        }}</label>
                                        <i class="text-gray-400 fa fa-user"></i>
                                        <input
                                            type="text"
                                            class="can-exp-input"
                                            :placeholder="
                                                payment_setting &&
                                                payment_setting[
                                                    'cardholder_name_placeholder'
                                                ]
                                                    ? payment_setting[
                                                          'cardholder_name_placeholder'
                                                      ]
                                                    : ''
                                            "
                                            @input="
                                                updateForm(
                                                    'card_holder_name',
                                                    $event.target.value
                                                )
                                            "
                                        />
                                        <Error
                                            fieldName="card_holder_name"
                                            :validationErros="validationErros"
                                            full_width="1"
                                        />
                                    </div>
                                    <div class="input_text mt-2 relative">
                                        <label class="">{{
                                            payment_setting &&
                                            payment_setting["card_number_label"]
                                                ? payment_setting[
                                                      "card_number_label"
                                                  ]
                                                : ""
                                        }}</label>
                                        <i
                                            class="text-gray-400 fa fa-credit-card"
                                        ></i>
                                        <input
                                            type="text"
                                            class="can-exp-input"
                                            :placeholder="
                                                payment_setting &&
                                                payment_setting[
                                                    'card_number_placeholder'
                                                ]
                                                    ? payment_setting[
                                                          'card_number_placeholder'
                                                      ]
                                                    : ''
                                            "
                                            @input="
                                                updateForm(
                                                    'card_no',
                                                    $event.target.value
                                                )
                                            "
                                            @keypress="
                                                restrictToNumbers($event, 16)
                                            "
                                        />
                                        <Error
                                            fieldName="card_no"
                                            :validationErros="validationErros"
                                            full_width="1"
                                        />
                                    </div>
                                    <div class="input_text mt-2 relative">
                                        <label class="">{{
                                            payment_setting &&
                                            payment_setting[
                                                "expiry_month_label"
                                            ]
                                                ? payment_setting[
                                                      "expiry_month_label"
                                                  ]
                                                : ""
                                        }}</label>

                                        <select
                                            class="rounded-md px-3 pr-8 py-1 w-full"
                                            @input="
                                                updateForm(
                                                    'expiry_month',
                                                    $event.target.value
                                                )
                                            "
                                        >
                                            <option
                                                value="01"
                                                :selected="
                                                    form.expiry_year == '01'
                                                        ? 'selected'
                                                        : ''
                                                "
                                            >
                                                01
                                            </option>
                                            <option
                                                value="02"
                                                :selected="
                                                    form.expiry_year == '02'
                                                        ? 'selected'
                                                        : ''
                                                "
                                            >
                                                02
                                            </option>
                                            <option
                                                value="03"
                                                :selected="
                                                    form.expiry_year == '03'
                                                        ? 'selected'
                                                        : ''
                                                "
                                            >
                                                03
                                            </option>
                                            <option
                                                value="04"
                                                :selected="
                                                    form.expiry_year == '04'
                                                        ? 'selected'
                                                        : ''
                                                "
                                            >
                                                04
                                            </option>
                                            <option
                                                value="05"
                                                :selected="
                                                    form.expiry_year == '05'
                                                        ? 'selected'
                                                        : ''
                                                "
                                            >
                                                05
                                            </option>
                                            <option
                                                value="06"
                                                :selected="
                                                    form.expiry_year == '06'
                                                        ? 'selected'
                                                        : ''
                                                "
                                            >
                                                06
                                            </option>
                                            <option
                                                value="07"
                                                :selected="
                                                    form.expiry_year == '07'
                                                        ? 'selected'
                                                        : ''
                                                "
                                            >
                                                07
                                            </option>
                                            <option
                                                value="08"
                                                :selected="
                                                    form.expiry_year == '08'
                                                        ? 'selected'
                                                        : ''
                                                "
                                            >
                                                08
                                            </option>
                                            <option
                                                value="09"
                                                :selected="
                                                    form.expiry_year == '09'
                                                        ? 'selected'
                                                        : ''
                                                "
                                            >
                                                09
                                            </option>
                                            <option
                                                value="10"
                                                :selected="
                                                    form.expiry_year == '10'
                                                        ? 'selected'
                                                        : ''
                                                "
                                            >
                                                10
                                            </option>
                                            <option
                                                value="11"
                                                :selected="
                                                    form.expiry_year == '11'
                                                        ? 'selected'
                                                        : ''
                                                "
                                            >
                                                11
                                            </option>
                                            <option
                                                value="12"
                                                :selected="
                                                    form.expiry_year == '12'
                                                        ? 'selected'
                                                        : ''
                                                "
                                            >
                                                12
                                            </option>
                                        </select>
                                        <Error
                                            fieldName="expiry_month"
                                            :validationErros="validationErros"
                                            full_width="1"
                                        />
                                    </div>
                                    <div class="input_text mt-2 relative">
                                        <label class="">{{
                                            payment_setting &&
                                            payment_setting["expiry_year_label"]
                                                ? payment_setting[
                                                      "expiry_year_label"
                                                  ]
                                                : ""
                                        }}</label>
                                        <select
                                            class="rounded-md px-3 pr-8 py-1 w-full"
                                            @input="
                                                updateForm(
                                                    'expiry_year',
                                                    $event.target.value
                                                )
                                            "
                                        >
                                            <option
                                                v-for="year in years"
                                                :key="year"
                                                :value="year"
                                                :selected="
                                                    year == form.expiry_year
                                                        ? 'selected'
                                                        : ''
                                                "
                                            >
                                                {{ year }}
                                            </option>
                                        </select>

                                        <Error
                                            fieldName="expiry_year"
                                            :validationErros="validationErros"
                                            full_width="1"
                                        />
                                    </div>
                                    <div class="input_text mt-2 relative">
                                        <label class="">{{
                                            payment_setting &&
                                            payment_setting["cvv_label"]
                                                ? payment_setting["cvv_label"]
                                                : ""
                                        }}</label>
                                        <i
                                            class="text-gray-400 fa fa-credit-card"
                                        ></i>
                                        <input
                                            type="text"
                                            class="can-exp-input"
                                            :placeholder="
                                                payment_setting &&
                                                payment_setting[
                                                    'cvv_placeholder'
                                                ]
                                                    ? payment_setting[
                                                          'cvv_placeholder'
                                                      ]
                                                    : ''
                                            "
                                            @input="
                                                updateForm(
                                                    'cvc',
                                                    $event.target.value
                                                )
                                            "
                                            @keypress="
                                                restrictToNumbers($event, 4)
                                            "
                                        />
                                        <Error
                                            fieldName="cvc"
                                            :validationErros="validationErros"
                                            full_width="1"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <button aria-label="Candian Exporters" @click="createOrder">Pay with PayPal</button> -->
            <Error
                fieldName="payment_method"
                :validationErros="validationErros"
            />
            <Error
                fieldName="paymentMethodId"
                :validationErros="validationErros"
            />
            <div class="mb-4">
                <div class="flex items-start pb-4">
                    <input
                        id="agree"
                        type="checkbox"
                        class="h-4 w-4 mt-1 rounded border-gray-300 text-primary focus:ring-primary"
                        @input="
                            updateForm('is_agree', $event.target.checked);
                            clearErrors('is_agree');
                        "
                    />
                    <label
                        for="agree"
                        class="ml-2 text-gray-900 text-base md:text-base lg:text-lg text-left"
                        v-html="
                            JSON.parse(eventsetting)
                                ? JSON.parse(eventsetting)
                                      .terms_and_conditions_label
                                : ''
                        "
                    ></label>
                </div>
                <Error
                    v-if="submitted"
                    fieldName="is_agree"
                    :validationErros="validationErros"
                />
            </div>

            <Error
                v-if="submitted"
                fieldName="captcha"
                :validationErros="validationErros"
            />
            <!-- <ListErrors :validationErrors="validationErros" /> -->
            <button
                aria-label="Candian Exporters"
                type="submit"
                class="inline-flex items-center button-exp-fill mt-4"
            >
                {{ JSON.parse(eventsetting).button_text }}
            </button>
            <div
                class="my-4"
                v-html="
                    JSON.parse(eventsetting)
                        ? JSON.parse(eventsetting).post_submit_button_text
                        : ''
                "
            ></div>
        </form>
        <div v-if="loading">
            <div id="form_preloader">
                <div id="form_status">
                    <div class="form_spinner">
                        <div class="form-double-bounce1"></div>
                        <div class="form-double-bounce2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { load } from "recaptcha-v3";
// Import filepond
import vueFilePond, { setOptions } from "vue-filepond";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js";
import FilePondPluginImagePreview from "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview
);
import Error from "./../components/Error.vue";
import ErrorHandling from "../../ErrorHandling";
// import ListErrors from "./../components/ListErrors.vue";

import { mapState } from "vuex";
export default {
    props: [
        "languages",
        "eventsetting",
        "url",
        "page_id",
        "current_user",
        "default_lang",
        "event_id",
    ],
    computed: {
        ...mapState({
            isFormEdit: (state) => state.events.isFormEdit,
            form: (state) => state.events.form,
            registrationPackages: (state) => state.signup.registrationPackages,
            customerPaymentMethods: (state) =>
                state.signup.customerPaymentMethods,
        }),
        years() {
            const currentYear = new Date().getFullYear();
            return Array.from(
                { length: 16 },
                (_, index) => currentYear + index
            );
        },
    },
    mounted() {
        if (this.event_id) {
            this.fetchEvent(this.event_id);
        } else {
            // this.addContact(1);
        }
    },
    data() {
        return {
            activeTab: null,
            id: null,
            loading: false,
            gallery_files: [],
            payment_setting: null,
            reCAPTCHA_site_key: process.env.MIX_reCAPTCHA_site_key,
            contacts: [],
            submitted: false,
            validationErros: new ErrorHandling(),
            popupImage: null,
        };
    },
    methods: {
        // focusOnFirstErrorInput(errors) {
        //     // Find the first error field
        //     const titleErrorKey = Object.keys(errors).find(key => key.startsWith('title'));
        //     if (titleErrorKey) {
        //         // Select the input field and focus on it
        //         const titleErrorInput = document.querySelector(`[id="title"]`);
        //         if (titleErrorInput) {
        //             titleErrorInput.focus();
        //         }
        //     } else {
        //         const countryErrorKey = Object.keys(errors).find(key => key.startsWith('country'));
        //         if (countryErrorKey) {
        //             // Select the input field and focus on it
        //             const countryErrorInput = document.querySelector(`[id="country"]`);
        //             if (countryErrorInput) {
        //                 countryErrorInput.focus();
        //             }
        //         } else {
        //             const venueErrorKey = Object.keys(errors).find(key => key.startsWith('venue'));
        //             if (venueErrorKey) {
        //                 // Select the input field and focus on it
        //                 const venueErrorInput = document.querySelector(`[id="venue"]`);
        //                 if (venueErrorInput) {
        //                     venueErrorInput.focus();
        //                 }
        //             } else {
        //                 const short_descriptionErrorKey = Object.keys(errors).find(key => key.startsWith('short_description'));
        //                 if (short_descriptionErrorKey) {
        //                     // Select the input field and focus on it
        //                     const short_descriptionErrorInput = document.querySelector(`[id="short_description"]`);
        //                     if (short_descriptionErrorInput) {
        //                         short_descriptionErrorInput.focus();
        //                     }
        //                 }
        //             }
        //         }
        //     }

        //     const firstErrorField = Object.keys(errors)[0];

        //     const firstErrorInput = document.querySelector(`[id="${firstErrorField}"]`);
        //     if (firstErrorInput) {
        //         firstErrorInput.focus();
        //     }
        // },
        focusOnFirstErrorInput(errors) {
    // Define the order of fields to check
    const fieldOrder = [
        'title', 'country', 'city', 'street_name', 'venue',
        'product_search', 'short_description', 'description','video_url','press_url','visitors_url',
        'contact-name', 'contact-email', 'contact-phone', 'exibitors_url','event_website','end_date',
        'facebook_url', 'twitter_url', 'linkedin_url', 'start_date',
        'youtube_url', 'pintrest_url', 'instagram_url',
        'snapchat_url', 'gallery_images'
    ];

    // Iterate through the field order and focus on the first error field
    for (const field of fieldOrder) {
        const errorKey = Object.keys(errors).find(key => key.startsWith(field));
        if (errorKey) {
            const errorInput = document.querySelector(`[id="${field}"]`);
            if (errorInput) {
                errorInput.focus();
                break; // Stop after focusing on the first error field
            }
        }
    }

    // If no specific field is found, focus on the first error field in the errors object
    if (!errorKey) {
        const firstErrorField = Object.keys(errors)[0];
        const firstErrorInput = document.querySelector(`[id="${firstErrorField}"]`);
        if (firstErrorInput) {
            firstErrorInput.focus();
        }
    }
},

        clearErrors(fieldName) {
            if (this.submitted) {
                this.validationErros.clear(fieldName);
            }
        },
        showImagePopup(imageUrl) {
        this.popupImage = imageUrl;
    },

        restrictToLength(event, maxWords, language, fieldName) {
            let inputValue = event.target.value.trim();

            // Match words while allowing phrases in quotes
            let wordsArray = inputValue.match(/"[^"]+"|\S+/g) || [];

            if (wordsArray.length > maxWords) {
                wordsArray = wordsArray.slice(0, maxWords); // Keep only maxWords
                event.target.value = wordsArray.join(" "); // Rejoin words with spaces
            }

            // Update the form with the new truncated value
            this.handleInput(event.target.value, language, fieldName);
        },

        addContact(setUserName = false) {
            let name =
                setUserName && this.current_user
                    ? JSON.parse(this.current_user)?.name
                    : null;
            this.contacts.push({
                id: null,
                name: name || null,
                email: null,
                phone: null,
                // designation: null,
                image_path: null,
            });
            // if(email){
            //     let checking_event = JSON.parse(localStorage.getItem("eventContacts")) || [];
            //     let find_event = checking_event.find(res => { return res.email != email});
            //     if(!find_event && email){
            //         localStorage.setItem("eventContacts", JSON.stringify(this.contacts));
            //     }
            // }
        },

        deleteContact(index) {
            this.contacts.splice(index, 1);

            localStorage.setItem(
                "eventContacts",
                JSON.stringify(this.contacts)
            );
        },
        updateContact(index, field, value) {
            this.contacts[index][field] = value;
            localStorage.setItem(
                "eventContacts",
                JSON.stringify(this.contacts)
            );
        },
        uploadImage(e, index) {
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios
                .post("/api/web/media/image_again_upload", file)
                .then((res) => {
                    this.$store.commit("events/setEmptyError");
                    this.contacts[index].image_path = res?.data;
                })
                .catch((error) => {
                    this.$store.commit(
                        "events/setValidationErros",
                        error.response.data.errors
                    );
                });
        },
        fetchPaymentMethods() {
            this.$store
                .dispatch("signup/fetchCustomerPaymentMethods", {
                    url: `${process.env.MIX_WEB_API_URL}customer-payment-methods`,
                })
                .then((response) => {
                    if (response.data.status == "Success") {
                        this.payment_setting =
                            response.data.data.payment_setting;
                        if (response.data.data.methods.length == 0) {
                            this.updateForm(
                                "customer_payment_method_id",
                                "add_new_card"
                            );
                        }
                        let p_method = response.data.data.methods.filter(
                            (res) => res.is_default == 1
                        );
                        if (p_method && p_method[0]) {
                            this.updateForm(
                                "customer_payment_method_id",
                                p_method[0]["id"]
                            );
                        }
                    }
                });
        },
        handleInput(value, language, fieldName) {
            this.$store.commit("events/updateEvent", {
                key: fieldName,
                id: language.id,
                value: value,
            });

            const formData =
                JSON.parse(localStorage.getItem("eventFormData")) || {};
            formData[`${fieldName}_${language.id}`] = value;
            localStorage.setItem("eventFormData", JSON.stringify(formData));
        },
        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
        // checkDateLength(field, event) {
        //     let value = event.target.value;

        //     // Check if the value is in the correct format (YYYY-MM-DD)
        //     let dateParts = value.split('-');

        //     // Ensure there are 3 parts (year, month, day)
        //     if (dateParts.length === 3) {
        //         // Limit the year part to 4 digits
        //         if (dateParts[0].length > 4) {
        //             dateParts[0] = dateParts[0].slice(0, 4);
        //         }

        //         if (dateParts[1].length > 2) {
        //             dateParts[1] = dateParts[1].slice(0, 2); // Limit month to 2 digits
        //         }

        //         if (dateParts[2].length > 2) {
        //             dateParts[2] = dateParts[2].slice(0, 2); // Limit day to 2 digits
        //         }

        //         // Rejoin the parts and set the value back
        //         event.target.value = dateParts.join('-');
        //     }

        //     // Call the form update method
        //     this.updateForm(field, event.target.value);
        // },

        checkDateLength(field, event) {
            let value = event.target.value;

            // Check if the value is in the correct format (YYYY-MM-DD)
            let dateParts = value.split("-");
            if (dateParts.length === 3) {
                if (dateParts[0].length > 4) {
                    dateParts[0] = dateParts[0].slice(0, 4);
                }

                if (dateParts[1].length > 2) {
                    dateParts[1] = dateParts[1].slice(0, 2);
                }

                if (dateParts[2].length > 2) {
                    dateParts[2] = dateParts[2].slice(0, 2);
                }

                // Rejoin the parts and set the value back
                event.target.value = dateParts.join("-");
            }

            this.updateForm(field, event.target.value);

            this.$store.commit("events/clearValidationError", field);
        },
        updateForm(field, value, price = 0) {
            this.$store.commit("events/setEvent", {
                key: field,
                value: value,
            });

            const formData =
                JSON.parse(localStorage.getItem("eventFormData")) || {};
            formData[field] = value;
            localStorage.setItem("eventFormData", JSON.stringify(formData));

            if (field === "registration_package_id") {
                this.$store.commit("events/setEvent", {
                    key: "order_amount",
                    value: price,
                });
            }
        },
        async addUpdateForm() {
            this.addEvent();
        },

        handleGalleryImagesInit() {
            setOptions({
                credits: false,
                server: {
                    url: process.env.MIX_APP_URL,
                    process: (
                        fieldName,
                        file,
                        metadata,
                        load,
                        error,
                        progress,
                        abort,
                        transfer,
                        options
                    ) => {
                        const formData = new FormData();
                        formData.append("media", file, file.name);
                        formData.append("is_temp_media", 1);
                        formData.append("type", "media_id");

                        const request = new XMLHttpRequest();
                        request.open(
                            "POST",
                            `${process.env.MIX_APP_URL}/media/process`
                        );
                        request.setRequestHeader(
                            "X-CSRF-TOKEN",
                            document.head.querySelector(
                                'meta[name="csrf-token"]'
                            ).content
                        );

                        request.upload.onprogress = (e) => {
                            progress(e.lengthComputable, e.loaded, e.total);
                        };
                        request.onload = function () {
                            if (request.status >= 200 && request.status < 300) {
                                load(request.responseText);
                            } else {
                                error("oh no");
                            }
                        };

                        request.send(formData);

                        return {
                            abort: () => {
                                request.abort();
                                abort();
                            },
                        };
                    },
                    revert: (uniqueFileId, load, error) => {
                        const formData = new FormData();
                        formData.append("media", uniqueFileId);

                        const request = new XMLHttpRequest();
                        request.open(
                            "POST",
                            `${process.env.MIX_APP_URL}/media/revert`
                        );
                        request.setRequestHeader(
                            "X-CSRF-TOKEN",
                            document.head.querySelector(
                                'meta[name="csrf-token"]'
                            ).content
                        );

                        request.send(formData);

                        return {
                            abort: () => {
                                request.abort();
                                abort();
                            },
                        };
                    },
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                    },
                },
            });
        },
        handleGalleryImagesProcess(error, file) {
            this.$store.commit("events/setGalleryImages", {
                type: "add",
                value: JSON.parse(file.serverId)[0],
            });
        },
        handleGalleryImagesRemoveFile(error, file) {
            if (this.$route.params.id) {
                if (file.getMetadata() && file.getMetadata().serverId) {
                    this.$store.commit("events/setGalleryImages", {
                        type: "remove",
                        value: file.getMetadata().serverId,
                    });
                }
            } else {
                this.$store.commit("events/setGalleryImages", {
                    type: "remove",
                    value: JSON.parse(file.serverId)[0],
                });
            }
        },
        fetchEvent(id) {
            this.$store.commit("events/setIsFormEdit", 1);
            this.$store
                .dispatch("events/fetchEvent", {
                    url: `${process.env.MIX_WEB_API_URL}events/${id}?withEventDetail=1&withEventContacts=1`,
                })
                .then((res) => {
                    if (res.data.status == "Success") {
                        if (res.data.data && res.data.data.event_media) {
                            let images = res.data.data.event_media;
                            images.map((image) => {
                                if (image.media) {
                                    this.gallery_files.push({
                                        source: image.media.base64,
                                        options: {
                                            type: "local",
                                            metadata: {
                                                serverId: image.media.path,
                                                poster: image.media.base64,
                                            },
                                        },
                                    });
                                    setOptions({ files: this.gallery_files });
                                }
                            });
                            this.$store.commit("events/resetGalleryImages");
                            images.map((image) => {
                                if (image.media) {
                                    this.$store.commit(
                                        "events/setGalleryImages",
                                        {
                                            type: "add",
                                            value: image.media.path,
                                        }
                                    );
                                }
                            });
                        }
                        this.updateForm("start_date", res.data.data.start_date);
                        this.updateForm("end_date", res.data.data.end_date);
                        this.updateForm(
                            "event_website",
                            res.data.data.event_website
                        );
                        this.updateForm(
                            "exibitors_url",
                            res.data.data.exibitors_url
                        );
                        this.updateForm(
                            "visitors_url",
                            res.data.data.visitors_url
                        );
                        this.updateForm("press_url", res.data.data.press_url);
                        this.updateForm("video_url", res.data.data.video_url);
                        this.updateForm(
                            "facebook_url",
                            res.data.data.facebook_url
                        );
                        this.updateForm(
                            "twitter_url",
                            res.data.data.twitter_url
                        );
                        this.updateForm(
                            "linkedin_url",
                            res.data.data.linkedin_url
                        );
                        this.updateForm(
                            "youtube_url",
                            res.data.data.youtube_url
                        );
                        this.updateForm(
                            "pintrest_url",
                            res.data.data.pintrest_url
                        );
                        this.updateForm(
                            "instagram_url",
                            res.data.data.instagram_url
                        );
                        this.updateForm(
                            "snapchat_url",
                            res.data.data.snapchat_url
                        );

                        let data =
                            res.data.data && res.data.data.event_detail
                                ? res.data.data.event_detail
                                : [];
                        let event_contacts =
                            res?.data?.data?.event_contacts || [];
                        let obj = {};
                        data.map((res) => {
                            obj["title_" + res.language_id] = res.title;
                        });
                        this.$store.commit("events/setEvent", {
                            key: "title",
                            value: obj,
                        });

                        obj = {};
                        data.map((res) => {
                            obj["country_" + res.language_id] = res.country;
                        });
                        this.$store.commit("events/setEvent", {
                            key: "country",
                            value: obj,
                        });

                        obj = {};
                        data.map((res) => {
                            obj["city_" + res.language_id] = res.city;
                        });
                        this.$store.commit("events/setEvent", {
                            key: "city",
                            value: obj,
                        });

                        obj = {};
                        data.map((res) => {
                            obj["street_name_" + res.language_id] =
                                res.street_name;
                        });
                        this.$store.commit("events/setEvent", {
                            key: "street_name",
                            value: obj,
                        });

                        obj = {};
                        data.map((res) => {
                            obj["venue_" + res.language_id] = res.venue;
                        });
                        this.$store.commit("events/setEvent", {
                            key: "venue",
                            value: obj,
                        });

                        obj = {};
                        data.map((res) => {
                            obj["product_search_" + res.language_id] =
                                res.product_search;
                        });
                        this.$store.commit("events/setEvent", {
                            key: "product_search",
                            value: obj,
                        });

                        obj = {};
                        data.map((res) => {
                            obj["short_description_" + res.language_id] =
                                res.short_description;
                        });
                        this.$store.commit("events/setEvent", {
                            key: "short_description",
                            value: obj,
                        });

                        obj = {};
                        data.map((res) => {
                            obj["description_" + res.language_id] =
                                res.description;
                        });
                        this.$store.commit("events/setEvent", {
                            key: "description",
                            value: obj,
                        });
                        event_contacts.map((res, index) => {
                            this.contacts[index] = {};
                            this.contacts[index].name = res.name;
                            this.contacts[index].email = res.email;
                            this.contacts[index].phone = res.phone;
                            // this.contacts[index].designation = res.designation;
                            this.contacts[index].image_path = res.image_path;
                        });
                    }
                });
        },
        async setPaymentMethod(value) {
            this.form.payment_method = value;
        },
        async recaptcha() {
            this.submitted = true;
            this.loading = 1;
            load(process.env.MIX_reCAPTCHA_site_key).then((recaptcha) => {
                recaptcha.showBadge();
                recaptcha.execute("submit").then((token) => {
                    axios
                        .post(`${process.env.MIX_WEB_API_URL}verifyRecaptcha`, {
                            token: token,
                        })
                        .then((res) => {
                            setTimeout(() => {
                                recaptcha.hideBadge();
                            }, 3000);
                            if (res.data.status == "Success") {
                                this.addUpdateForm();
                            } else if (res.data.status == "Error") {
                                this.loading = 0;
                                this.$store.commit(
                                    "events/recordValidationError",
                                    {
                                        field: "captcha",
                                        error: res.data.message,
                                    }
                                );
                            }
                        });
                });
            });
        },
        addEvent() {
            this.$store.commit("events/setContact", this.contacts);
            this.$store.commit("events/setEvent", {
                key: "page_id",
                value: this.page_id,
            });
            this.loading = 1;
            let url = `${process.env.MIX_APP_URL}/process-payment`;
            if (this.event_id) {
                url = `${process.env.MIX_APP_URL}/process-payment/${this.event_id}`;
            }
            axios
                .post(url, this.form)
                .then((response) => {
                    this.loading = 0;
                    if (response.data.status == "Success") {
                        localStorage.removeItem("eventContacts");
                        localStorage.removeItem("eventFormData");

                        if (response?.data?.data?.type == "paypal") {
                            window.location.href =
                                response?.data?.data?.redirect_url;
                        } else {
                            this.$store.commit("events/resetForm");
                            helper.swalSuccessMessageForWeb(response.data.message).then(() => {
                                window.location.href = this.url;
                                resolve(res);
                            });
                        }
                    } else {
                        helper.swalErrorMessageForWeb(response.data.message);
                    }
                })
                .catch((error) => {
                    this.loading = 0;
                    this.validationErros = new ErrorHandling();
                    if (error.response && error.response.status == 422) {
                        this.validationErros.record(error.response.data.errors);
                        this.focusOnFirstErrorInput(error.response.data.errors);
                    } else if (
                        error.response &&
                        error.response.data &&
                        error.response.data.status == "Error"
                    ) {
                        helper.swalErrorMessageForWeb(
                            error.response.data.message
                        );
                    }
                });
        },
        checkValidationError(validationErros, language) {
            return (
                validationErros.has(`title.title_${language.id}`) ||
                validationErros.has(`country.country_${language.id}`) ||
                validationErros.has(`city.city_${language.id}`) ||
                validationErros.has(`street_name.street_name_${language.id}`) ||
                validationErros.has(`venue.venue_${language.id}`) ||
                validationErros.has(
                    `product_search.product_search_${language.id}`
                ) ||
                validationErros.has(
                    `short_description.short_description_${language.id}`
                ) ||
                validationErros.has(`description.description_${language.id}`)
            );
        },
        restrictToNumbers(event, allowedLength) {
            const keyCode = event.which ? event.which : event.keyCode;
            const valid = keyCode >= 48 && keyCode <= 57; // Check if the key code is between 0 and 9
            const maxLengthReached = event.target.value.length >= allowedLength;

            if (!valid || maxLengthReached) {
                event.preventDefault();
            }
            return true;
        },
    },
    components: {
        FilePond,
        Error,
        // ListErrors,
    },
    created() {
        this.gallery_files = [];
        this.activeTab = JSON.parse(this.default_lang)["id"];
        this.$store.commit("events/resetForm");
        this.contacts = [];
        const savedContacts =
            JSON.parse(localStorage.getItem("eventContacts")) || [];
        if (savedContacts.length > 0) {
            this.contacts = savedContacts;
        } else {
            this.addContact(1);
        }

        const savedFormData =
            JSON.parse(localStorage.getItem("eventFormData")) || {};
        for (const [field, value] of Object.entries(savedFormData)) {
            if (field.startsWith("title_")) {
                const languageId = field.split("_")[1];
                this.$store.commit("events/updateEvent", {
                    key: "title",
                    id: languageId,
                    value: value,
                });
            } else if (field.startsWith("country_")) {
                const languageId = field.split("_")[1];
                this.$store.commit("events/updateEvent", {
                    key: "country",
                    id: languageId,
                    value: value,
                });
            } else if (field.startsWith("city_")) {
                const languageId = field.split("_")[1];
                this.$store.commit("events/updateEvent", {
                    key: "city",
                    id: languageId,
                    value: value,
                });
            } else if (field.startsWith("street_name_")) {
                const languageId = field.split("_")[2];
                this.$store.commit("events/updateEvent", {
                    key: "street_name",
                    id: languageId,
                    value: value,
                });
            } else if (field.startsWith("venue_")) {
                const languageId = field.split("_")[1];
                this.$store.commit("events/updateEvent", {
                    key: "venue",
                    id: languageId,
                    value: value,
                });
            } else if (field.startsWith("product_search_")) {
                const languageId = field.split("_")[2];
                this.$store.commit("events/updateEvent", {
                    key: "product_search",
                    id: languageId,
                    value: value,
                });
            } else if (field.startsWith("short_description_")) {
                const languageId = field.split("_")[2];
                this.$store.commit("events/updateEvent", {
                    key: "short_description",
                    id: languageId,
                    value: value,
                });
            } else if (field.startsWith("description_")) {
                const languageId = field.split("_")[1];
                this.$store.commit("events/updateEvent", {
                    key: "description",
                    id: languageId,
                    value: value,
                });
            } else {
                this.$store.commit("events/setEvent", {
                    key: field,
                    value: value,
                });
            }
        }
        this.$store
            .dispatch("signup/fetchRegistrationPackages", {
                url: `${process.env.MIX_APP_URL}/get-registration-packages?getPayToGoPackagesOnly=1`,
            })
            .then((res) => {
                if (res.data.status == "Success") {
                    this.fetchPaymentMethods();
                    this.registrationPackages.map((registrationPackage) => {
                        if (registrationPackage.is_default == "1") {
                            this.updateForm(
                                "registration_package_id",
                                registrationPackage.id
                            );
                            return true;
                        }
                    });
                }
            });
    },
};
</script>

<style scoped>
/**
 * FilePond Custom Styles
 */
.filepond--drop-label {
    color: #4c4e53;
}

.filepond--label-action {
    text-decoration-color: #babdc0;
}

.filepond--panel-root {
    border-radius: 2em;
    background-color: #edf0f4;
    height: 1em;
}

.filepond--item-panel {
    background-color: #595e68;
}

.filepond--drip-blob {
    background-color: #7f8a9a;
}

.paypal-button {
    height: 25px !important;
    width: 100px !important;
}
</style>
