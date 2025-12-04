<template>
    <AppLayout>
        <div class="relative shadow-md sm:rounded-lg bg-white py-4">
            <header class="pt-4">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h3 class="can-exp-h3 text-primary">
                            {{ isFormEdit ? "Edit" : "Create" }} event
                        </h3>
                        <router-link
                            :to="{ name: 'admin.events.index' }"
                            class="inline-flex items-center button-exp-fill"
                        >
                            Back
                        </router-link>
                    </div>
                </div>
            </header>
            <form
                class="px-4 md:px-6 lg:px-8"
                @submit.prevent="addUpdateForm()"
            >
                <div
                    class="text-sm font-medium text-center text-gray-500 border-gray-200"
                >
                    <ul class="flex flex-wrap mb-2 overflow-x-auto gap-1 gap-1">
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
                                    checkValidationError(
                                        validationErros,
                                        language
                                    )
                                        ? 'bg-red-600 border-red-600 text-white hover:text-white rounded hover:bg-red-600 hover:border-red-600'
                                        : '',
                                ]"
                                >{{ language.name }}</a
                            >
                        </li>
                    </ul>
                </div>
                <hr class="my-2" />
                <div
                    class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6"
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
                        <label for="title" class="">Title</label>
                        <input
                            type="text"
                            name="title"
                            id="title"
                            class="can-exp-input block w-full rounded border border-gray-300"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'title'
                                )
                            "
                            :value="
                                form['title'] &&
                                form['title'][`title_${language.id}`]
                                    ? form['title'][`title_${language.id}`]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `title.title_${language.id}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `title.title_${language.id}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="country" class="">Country</label>
                        <input
                            type="text"
                            name="country"
                            id="country"
                            class="can-exp-input block w-full rounded border border-gray-300"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'country'
                                )
                            "
                            :value="
                                form['country'] &&
                                form['country'][`country_${language.id}`]
                                    ? form['country'][`country_${language.id}`]
                                    : ''
                            "
                        />

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `country.country_${language.id}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `country.country_${language.id}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="city" class="">City</label>
                        <input
                            type="text"
                            name="city"
                            id="city"
                            class="can-exp-input block w-full rounded border border-gray-300"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'city'
                                )
                            "
                            :value="
                                form['city'] &&
                                form['city'][`city_${language.id}`]
                                    ? form['city'][`city_${language.id}`]
                                    : ''
                            "
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(`city.city_${language.id}`)
                            "
                            v-text="
                                validationErros.get(`city.city_${language.id}`)
                            "
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="street_name" class="">Street name</label>
                        <input
                            type="text"
                            name="street_name"
                            id="street_name"
                            class="can-exp-input block w-full rounded border border-gray-300"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'street_name'
                                )
                            "
                            :value="
                                form['street_name'] &&
                                form['street_name'][
                                    `street_name_${language.id}`
                                ]
                                    ? form['street_name'][
                                          `street_name_${language.id}`
                                      ]
                                    : ''
                            "
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `street_name.street_name_${language.id}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `street_name.street_name_${language.id}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="venue" class="">Venue</label>
                        <input
                            type="text"
                            name="venue"
                            id="venue"
                            class="can-exp-input block w-full rounded border border-gray-300"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'venue'
                                )
                            "
                            :value="
                                form['venue'] &&
                                form['venue'][`venue_${language.id}`]
                                    ? form['venue'][`venue_${language.id}`]
                                    : ''
                            "
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `venue.venue_${language.id}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `venue.venue_${language.id}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="product_search" class=""
                            >Keyword</label
                        >
                        <input
                            type="text"
                            name="product_search"
                            id="product_search"
                            class="can-exp-input block w-full rounded border border-gray-300"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'product_search'
                                )
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
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `product_search.product_search_${language.id}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `product_search.product_search_${language.id}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <!-- <input type="text" name="short_description" id="short_description" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " @input="handleInput($event.target.value, language, 'short_description')" :value="form['short_description'] && form['short_description'][`short_description_${language.id}`] ? form['short_description'][`short_description_${language.id}`] : ''" /> -->
                        <label for="short_description" class=""
                            >Short description</label
                        >
                        <textarea
                            id="short_description"
                            rows="4"
                            class="can-exp-input block w-full rounded border border-gray-300"
                            placeholder=""
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

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `short_description.short_description_${language.id}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `short_description.short_description_${language.id}`
                                )
                            "
                        ></p>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <!-- <input type="text" name="description" id="description" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " @input="handleInput($event.target.value, language, 'description')" :value="form['description'] && form['description'][`description_${language.id}`] ? form['description'][`description_${language.id}`] : ''" /> -->
                        <label for="description" class="">Description</label>
                        <textarea
                            id="description"
                            rows="4"
                            class="can-exp-input block w-full rounded border border-gray-300"
                            placeholder=""
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'description'
                                )
                            "
                            v-text="
                                form['description'] &&
                                form['description'][
                                    `description_${language.id}`
                                ]
                                    ? form['description'][
                                          `description_${language.id}`
                                      ]
                                    : ''
                            "
                        ></textarea>

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `description.description_${language.id}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `description.description_${language.id}`
                                )
                            "
                        ></p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 md:gap-6 gap-4">
                    <div class="relative z-0 w-full group">
                        <label for="start_date" class="">Start date</label>
                        <input
                            type="date"
                            name="start_date"
                            id="start_date"
                            class="can-exp-input block w-full rounded border border-gray-300"
                            placeholder=" "
                            :value="form.start_date"
                            @input="
                                updateForm('start_date', $event.target.value)
                            "
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('start_date')"
                            v-text="validationErros.get('start_date')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="end_date" class="">End date</label>
                        <input
                            type="date"
                            name="end_date"
                            id="end_date"
                            class="can-exp-input block w-full rounded border border-gray-300"
                            placeholder=" "
                            :value="form.end_date"
                            @input="updateForm('end_date', $event.target.value)"
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('end_date')"
                            v-text="validationErros.get('end_date')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="event_website" class=""
                            >Event website</label
                        >
                        <input
                            type="text"
                            name="event_website"
                            id="event_website"
                            class="can-exp-input block w-full rounded border border-gray-300"
                            placeholder=" "
                            :value="form.event_website"
                            @input="
                                updateForm('event_website', $event.target.value)
                            "
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('event_website')"
                            v-text="validationErros.get('event_website')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="exibitors_url" class=""
                            >Exibitors url</label
                        >
                        <input
                            type="text"
                            name="exibitors_url"
                            id="exibitors_url"
                            class="can-exp-input block w-full rounded border border-gray-300"
                            placeholder=" "
                            :value="form.exibitors_url"
                            @input="
                                updateForm('exibitors_url', $event.target.value)
                            "
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('exibitors_url')"
                            v-text="validationErros.get('exibitors_url')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="visitors_url" class="">Visitors url</label>
                        <input
                            type="text"
                            name="visitors_url"
                            id="visitors_url"
                            class="can-exp-input block w-full rounded border border-gray-300"
                            placeholder=" "
                            :value="form.visitors_url"
                            @input="
                                updateForm('visitors_url', $event.target.value)
                            "
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('visitors_url')"
                            v-text="validationErros.get('visitors_url')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="press_url" class="">Press url</label>
                        <input
                            type="text"
                            name="press_url"
                            id="press_url"
                            class="can-exp-input block w-full rounded border border-gray-300"
                            placeholder=" "
                            :value="form.press_url"
                            @input="
                                updateForm('press_url', $event.target.value)
                            "
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('press_url')"
                            v-text="validationErros.get('press_url')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="video_url" class="">Embed video</label>
                        <input
                            type="text"
                            name="video_url"
                            id="video_url"
                            class="can-exp-input block w-full rounded border border-gray-300"
                            placeholder=" "
                            :value="form.video_url"
                            @input="
                                updateForm('video_url', $event.target.value)
                            "
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('video_url')"
                            v-text="validationErros.get('video_url')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="facebook_url" class="">Facebook url</label>
                        <input
                            type="text"
                            name="facebook_url"
                            id="facebook_url"
                            class="can-exp-input block w-full rounded border border-gray-300"
                            placeholder=" "
                            :value="form.facebook_url"
                            @input="
                                updateForm('facebook_url', $event.target.value)
                            "
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('facebook_url')"
                            v-text="validationErros.get('facebook_url')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="twitter_url" class="">Twitter url</label>
                        <input
                            type="text"
                            name="twitter_url"
                            id="twitter_url"
                            class="can-exp-input block w-full rounded border border-gray-300"
                            placeholder=" "
                            :value="form.twitter_url"
                            @input="
                                updateForm('twitter_url', $event.target.value)
                            "
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('twitter_url')"
                            v-text="validationErros.get('twitter_url')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="linkedin_url" class="">Linkedin url</label>
                        <input
                            type="text"
                            name="linkedin_url"
                            id="linkedin_url"
                            class="can-exp-input block w-full rounded border border-gray-300"
                            placeholder=" "
                            :value="form.linkedin_url"
                            @input="
                                updateForm('linkedin_url', $event.target.value)
                            "
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('linkedin_url')"
                            v-text="validationErros.get('linkedin_url')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="youtube_url" class="">Youtube url</label>
                        <input
                            type="text"
                            name="youtube_url"
                            id="youtube_url"
                            class="can-exp-input block w-full rounded border border-gray-300"
                            placeholder=" "
                            :value="form.youtube_url"
                            @input="
                                updateForm('youtube_url', $event.target.value)
                            "
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('youtube_url')"
                            v-text="validationErros.get('youtube_url')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="pintrest_url" class="">Pintrest url</label>
                        <input
                            type="text"
                            name="pintrest_url"
                            id="pintrest_url"
                            class="can-exp-input block w-full rounded border border-gray-300"
                            placeholder=" "
                            :value="form.pintrest_url"
                            @input="
                                updateForm('pintrest_url', $event.target.value)
                            "
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('pintrest_url')"
                            v-text="validationErros.get('pintrest_url')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="instagram_url" class=""
                            >Instagram url</label
                        >
                        <input
                            type="text"
                            name="instagram_url"
                            id="instagram_url"
                            class="can-exp-input block w-full rounded border border-gray-300"
                            placeholder=" "
                            :value="form.instagram_url"
                            @input="
                                updateForm('instagram_url', $event.target.value)
                            "
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('instagram_url')"
                            v-text="validationErros.get('instagram_url')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="snapchat_url" class="">Snapchat url</label>
                        <input
                            type="text"
                            name="snapchat_url"
                            id="snapchat_url"
                            class="can-exp-input block w-full rounded border border-gray-300"
                            placeholder=" "
                            :value="form.snapchat_url"
                            @input="
                                updateForm('snapchat_url', $event.target.value)
                            "
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('snapchat_url')"
                            v-text="validationErros.get('snapchat_url')"
                        ></p>
                    </div>
                </div>
                <div v-for="(contact, index) in contacts" :key="index">
                    <div
                        class="grid md:grid-cols-3 md:gap-6 gap-4 mt-6 bg-white shadow rounded-lg p-6"
                    >
                        <div class="relative z-0 w-full group">
                            <label :for="`contact-name-[${index}]`" class=""
                                >Contact name</label
                            >
                            <input
                                type="text"
                                name="contact-name"
                                :id="`contact-name-[${index}]`"
                                class="can-exp-input block w-full rounded border border-gray-300"
                                v-model="contact.name"
                                placeholder="Contact name"
                            />
                            <p
                                class="mt-2 text-sm text-red-400"
                                v-if="
                                    validationErros.has(
                                        `contacts.${index}.name`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `contacts.${index}.name`
                                    )
                                "
                            ></p>
                        </div>
                        <div class="relative z-0 w-full group">
                            <label :for="`contact-email-[${index}]`" class=""
                                >Contact email</label
                            >
                            <input
                                type="text"
                                name="contact-email"
                                :id="`contact-email-[${index}]`"
                                class="can-exp-input block w-full rounded border border-gray-300"
                                v-model="contact.email"
                                placeholder="Contact email"
                            />
                            <p
                                class="mt-2 text-sm text-red-400"
                                v-if="
                                    validationErros.has(
                                        `contacts.${index}.email`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `contacts.${index}.email`
                                    )
                                "
                            ></p>
                        </div>
                        <div class="relative z-0 w-full group">
                            <label :for="`contact-phone-[${index}]`" class=""
                                >Contact phone</label
                            >
                            <input
                                type="text"
                                name="contact-phone"
                                :id="`contact-phone-[${index}]`"
                                class="can-exp-input block w-full rounded border border-gray-300"
                                v-model="contact.phone"
                                placeholder="Contact phone"
                            />
                            <p
                                class="mt-2 text-sm text-red-400"
                                v-if="
                                    validationErros.has(
                                        `contacts.${index}.phone`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `contacts.${index}.phone`
                                    )
                                "
                            ></p>
                        </div>
                        <!-- <div class="relative z-0 w-full group">
                            <label
                                :for="`contact-designation-[${index}]`"
                                class=""
                                >Contact designation</label
                            >
                            <input
                                type="text"
                                name="contact-designation"
                                :id="`contact-designation-[${index}]`"
                                class="can-exp-input block w-full rounded border border-gray-300"
                                v-model="contact.designation"
                                placeholder="Contact designation"
                            />
                            <p
                                class="mt-2 text-sm text-red-400"
                                v-if="
                                    validationErros.has(
                                        `contacts.${index}.designation`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `contacts.${index}.designation`
                                    )
                                "
                            ></p>
                        </div> -->
                        <div class="relative z-0 w-full group">
                            <label :for="`contact-image-[${index}]`" class=""
                                >Profile image (Optional)</label
                            >
                            <input
                                type="file"
                                name="contact-image"
                                :id="`contact-image-[${index}]`"
                                class="can-exp-input block w-full rounded border border-gray-300"
                                @change="uploadImage($event, index)"
                            />
                            <img
                                v-if="contact.image_path"
                                :src="contact.image_path"
                                style="height: 100px; width: 100px"
                                @click="showImageModal(contact.image_path)"
                            />
                            <p
                                class="mt-2 text-sm text-red-400"
                                v-if="
                                    validationErros.has(
                                        `contacts.${index}.image_path`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `contacts.${index}.image_path`
                                    )
                                "
                            ></p>
                        </div>

<!-- Image Modal -->
<transition name="fade">
    <div v-if="isImageModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-75" @click.self="closeImageModal">
        <div class="relative max-w-4xl max-h-full">
            <button
                @click="closeImageModal"
                class="absolute -top-10 right-0 text-white text-3xl hover:text-gray-300 focus:outline-none"
            >
                &times;
            </button>
            <img :src="modalImageSrc" class="max-w-full max-h-[90vh] rounded-lg shadow-xl" />
        </div>
    </div>
</transition>
                        <div class="relative z-0 w-full group" v-if="index > 0">
                            <button
                                type="button"
                                class="button-exp-fill mt-7"
                                @click.prevent="deleteContact(index)"
                            >
                                Delete
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
                        Add Contact
                    </button>
                </div>
                <div class="grid md:grid-cols-4 md:gap-6 mt-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <FilePond
                            labelIdle='<span class="cursor-pointer">Drag & Drop your files or <span class="filepond--label-action"> Browse </span></span>'
                            class="cursor-pointer"
                            name="gallery_image"
                            credits="false"
                            ref="gallery_image"
                            allow-multiple="true"
                            class-name="my-pond"
                            accepted-file-types="image/*"
                            @init="handleGalleryImagesInit"
                            @processfile="handleGalleryImagesProcess"
                            @removefile="handleGalleryImagesRemoveFile"
                            v-bind:files="gallery_files"
                        />
                    </div>
                    <p
                        class="mt-2 text-sm text-red-400"
                        v-if="validationErros.has('gallery_images')"
                        v-text="validationErros.get('gallery_images')"
                    ></p>
                </div>

                <div class="relative z-0 w-full group" v-if="isFeaturedPackage">
        <label for="featured" class="flex items-center space-x-3 cursor-pointer text-gray-700 font-medium">
            <input
                type="checkbox"
                id="featured"
                :checked="form.featured"
                @change="updateFeatured($event.target.checked)"
                class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
            />
            Mark as Home Page
        </label>
    </div>

                <button
                    type="submit"
                    class="inline-flex items-center button-exp-fill"
                    :disabled="loading"
                >
                    Submit
                </button>
            </form>
        </div>
    </AppLayout>
</template>

<script>
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

import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            loading: (state) => state.events.loading,
            isFormEdit: (state) => state.events.isFormEdit,
            form: (state) => state.events.form,
            validationErros: (state) => state.events.validationErros,
            languages: (state) => state.languages.languages,
        }),
        isFeatured: {
            get() {
                return this.form.featured;
            },
            set(value) {
                this.updateForm({ key: "featured", value });
            },
        },
        isFeaturedPackage() {
        console.log('Event Package:', this.form.registration_package);
        console.log('Customer Package:', this.form.customer?.registration_package);
        const eventPackage = this.form.registration_package;
        const customerPackage = this.form.customer?.registration_package;

        return (
            (eventPackage && eventPackage.package_type === 'featured') ||
            (customerPackage && customerPackage.package_type === 'featured')
        );
    }
    },
    data() {
        return {
            activeTab: null,
            files: [],
            gallery_files: [],
            contacts: [ {
                id: null,
                name: null,
                email: null,
                phone: null,
                designation: null,
                image_path: null
            }],
            isImageModalOpen: false,
            modalImageSrc: '',
        };
    },
    methods: {
        showImageModal(imageSrc) {
        this.modalImageSrc = imageSrc;
        this.isImageModalOpen = true;
        // Disable body scroll when modal is open
        document.body.style.overflow = 'hidden';
    },

    closeImageModal() {
        this.isImageModalOpen = false;
        // Re-enable body scroll
        document.body.style.overflow = '';
    },
        scrollToFirstError() {
        // Wait for the DOM to update
        this.$nextTick(() => {
            // Find the first error message element
            const firstError = document.querySelector('.text-red-400');

            if (firstError) {
                // Find the corresponding input field
                let inputField = firstError.previousElementSibling;

                // Sometimes the input might be nested, so we may need to traverse up
                while (inputField && !inputField.classList.contains('can-exp-input')) {
                    inputField = inputField.previousElementSibling;
                }

                if (inputField) {
                    // Scroll to the input field
                    inputField.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });

                    // Focus on the input field
                    inputField.focus();
                } else {
                    // Fallback to scrolling to the error message
                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            }
        });
    },
        validateDates() {
    if (this.form.start_date && this.form.end_date) {
        const startDate = new Date(this.form.start_date);
        const endDate = new Date(this.form.end_date);
        if (endDate < startDate) {
            this.$store.commit('events/recordValidationError', {
                field: 'end_date',
                error: 'The End date cannot be earlier than the Start date'
            });
            return false;
        }
    }
    return true;
},
        updateFeatured(value) {
            this.$store.commit("events/setEvent", {
                key: "featured",
                value: value,
            });
        },
        addContact() {
            this.contacts.push({
                id: null,
                name: null,
                email: null,
                phone: null,
                designation: null,
                image_path: null,
            });
        },
        // deleteContact(index) {
        //     this.contacts.splice(index, 1);
        // },
        deleteContact(index) {
    if (this.contacts.length > 1) { // Only allow deleting if not the first contact
        this.contacts.splice(index, 1);
    }
},
        uploadImage(e, index) {
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios
                .post("/api/admin/media/image_again_upload", file)
                .then((res) => {
                    this.contacts[index]["image_path"] = res?.data;
                });
        },
        handleInput(value, language, fieldName) {
            this.$store.commit("events/updateEvent", {
                key: fieldName,
                id: language.id,
                value: value,
            });
        },
        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
        updateForm(field, value) {
            this.$store.commit("events/setEvent", {
                key: field,
                value: value,
            });
        },
        // addUpdateForm() {
        //     this.$store.commit("events/setContact", this.contacts);
        //     this.$store
        //         .dispatch("events/addUpdateForm")
        //         .then(() => this.$router.push({ name: "admin.events.index" }));
        // },
        addUpdateForm() {
        if (!this.validateDates()) {
            this.scrollToFirstError();
            return;
        }

        // Validate at least one contact exists
        if (this.contacts.length === 0) {
            this.$store.commit('events/setValidationErros', {
                'contacts': ['At least one contact person is required']
            });
            this.scrollToFirstError();
            return;
        }

        // Validate each contact has required fields
        let hasContactErrors = false;
        this.contacts.forEach((contact, index) => {
            if (!contact.name || !contact.email || !contact.phone) {
                hasContactErrors = true;
                if (!contact.name) {
                    this.$store.commit('events/recordValidationError', {
                        field: `contacts.${index}.name`,
                        error: 'The name field is required'
                    });
                }
                if (!contact.email) {
                    this.$store.commit('events/recordValidationError', {
                        field: `contacts.${index}.email`,
                        error: 'The email field is required'
                    });
                }
                if (!contact.phone) {
                    this.$store.commit('events/recordValidationError', {
                        field: `contacts.${index}.phone`,
                        error: 'The phone field is required'
                    });
                }
            }
        });

        if (hasContactErrors) {
            this.scrollToFirstError();
            return;
        }

        this.$store.commit("events/setContact", this.contacts);
        this.$store
            .dispatch("events/addUpdateForm")
            .then(() => this.$router.push({ name: "admin.events.index" }))
            .catch(error => {
                if (error.response && error.response.status === 422) {
                    this.scrollToFirstError();
                }
            });
    },
        handleGalleryImagesInit() {
            setOptions({
                credits: false,
                server: {
                    url: process.env.MIX_ADMIN_API_URL,
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
                            `${process.env.MIX_ADMIN_API_URL}media/process`
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
                            `${process.env.MIX_ADMIN_API_URL}media/revert`
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
            // this.$store.commit('events/setForm', {
            //     'media_id': file.serverId
            // });
            this.$store.commit("events/setGalleryImages", {
                type: "add",
                value: JSON.parse(file.serverId)[0],
            });
        },
        handleGalleryImagesRemoveFile(error, file) {
            // this.$store.commit('events/setForm', {
            //     'media_id': null
            // });
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
        fetchEvent() {
            let id = this.$route.params.id;
            this.$store.commit("events/setIsFormEdit", 1);
            this.$store
                .dispatch("events/fetchEvent", {
                    url: `${process.env.MIX_ADMIN_API_URL}events/${id}?withEventDetail=1&withEventContacts=1`,
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
                        // this.updateForm("featured", res.data.data.featured);
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
                            this.contacts[index].designation = res.designation;
                            this.contacts[index].image_path = res.image_path;
                        });
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
    },
    components: {
        FilePond,
    },
    created() {
        this.gallery_files = [];
        setOptions({ files: [] });
        this.$store.commit("events/resetForm");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                data.map((res) => {
                    obj["title_" + res.id] = "";
                });
                this.$store.commit("events/setEvent", {
                    key: "title",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["country_" + res.id] = "";
                });
                this.$store.commit("events/setEvent", {
                    key: "country",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["city_" + res.id] = "";
                });
                this.$store.commit("events/setEvent", {
                    key: "city",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["street_name_" + res.id] = "";
                });
                this.$store.commit("events/setEvent", {
                    key: "street_name",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["venue_" + res.id] = "";
                });
                this.$store.commit("events/setEvent", {
                    key: "venue",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["product_search_" + res.id] = "";
                });
                this.$store.commit("events/setEvent", {
                    key: "product_search",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["short_description_" + res.id] = "";
                });
                this.$store.commit("events/setEvent", {
                    key: "short_description",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["description_" + res.id] = "";
                });
                this.$store.commit("events/setEvent", {
                    key: "description",
                    value: obj,
                });
                if (this.$route.params.id) {
                    this.$store.commit("events/setEvent", {
                        key: "id",
                        value: this.$route.params.id,
                    });
                    this.fetchEvent();
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
</style>
