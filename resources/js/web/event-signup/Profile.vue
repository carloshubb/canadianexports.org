<template>
    <form class="lg:w-full" @submit.prevent="recaptcha()">
        <!-- Event dashboard welcome (Premium / Featured) -->
        <div v-if="eventDashboardDescription" class="bg-white px-4 sm:px-10 rounded-lg sm:pt-20 w-full max-w-full min-w-0 mt-20 mb-6">
            <h2 class="font-FuturaMdCnBT text-gray-900 break-words">Welcome back {{ eventDashboardFirstName }},</h2>
            <p class="font-FuturaMdCnBT text-gray-900 break-words whitespace-normal" style="line-height: 1.6; word-wrap: break-word;" v-html="eventDashboardDescription"></p>
        </div>
        <div class="my-4">
            <!-- Step 1: Select Your Package -->
            <div
                class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-primary to-secondary rounded-md cursor-pointer my-6">
                <h4 class="text-center card-heading text-white">
                    {{ JSON.parse(event_detail)["package_section_heading"] ?? 'Select Your Package' }}
                </h4>
            </div>
            <div class="w-full">
                <div class="bg-gray-50">
                    <div class="mx-auto max-w-7xl px-6 lg:px-8">
                        <div v-if="showDowngradeMessage"
                            class="mx-auto mt-4 max-w-2xl rounded-lg border border-amber-300 bg-amber-50 px-4 py-3 text-sm text-amber-800"
                            role="alert">
                            Membership downgrades cannot be processed automatically. Please contact us to adjust your
                            plan.
                        </div>
                        <div
                            class="isolate mx-auto mt-10 grid max-w-md grid-cols-1 gap-8 lg:mx-auto lg:max-w-3xl md:grid-cols-2 lg:grid-cols-2">
                            <div v-if="premiumPackage"
                                class="rounded-3xl p-6 xl:p-6 bg-white overflow-hidden transition-all duration-200"
                                :class="[
                                    effectivePackageType === 'premium'
                                        ? 'border-[3px] border-red-600 opacity-100'
                                        : 'border border-gray-300 opacity-55',
                                    isDowngradeOption('premium') ? 'cursor-not-allowed' : 'cursor-pointer'
                                ]" :title="isDowngradeOption('premium') ? downgradeTooltipText : null"
                                @click.prevent="onPackageSelect(premiumPackage)">
                                <div
                                    class="w-full mb-6 rounded-t-xl rounded-b-none bg-red-600 py-2.5 flex items-center justify-center">
                                    <span class="text-white font-semibold text-lg">Premium</span>
                                </div>
                                <div class="flex flex-col items-center justify-center text-center gap-y-2">
                                    <p v-if="premiumPackage?.is_default"
                                        class="rounded-full bg-red-600/10 px-2.5 py-1 text-xs font-semibold leading-5 text-red-600">
                                        Most popular
                                    </p>
                                </div>
                                <p class="mt-4 text-sm leading-6 text-gray-600">
                                    {{
                                        premiumPackage
                                            ?.registration_package_detail?.[0]
                                            ?.short_description
                                    }}
                                </p>
                                <p class="mt-6 flex items-baseline gap-x-1 justify-center">
                                    <span class="text-4xl font-bold tracking-tight text-gray-900 lg:mt-6">
                                        ${{ premiumPackage?.event_price }}
                                    </span>
                                </p>
                                <ul role="list" class="mt-8 space-y-3 text-sm leading-6 text-gray-600 xl:mt-10 p-0"
                                    v-if="
                                        premiumPackage?.registration_package_feature
                                    ">
                                    <li class="flex gap-x-3"
                                        v-for="features in premiumPackage?.registration_package_feature"
                                        :key="features.id">
                                        <svg class="h-6 w-5 flex-none text-[#006EB7]" viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span v-html="formatFeatureName(features?.name)"></span>
                                    </li>
                                </ul>
                            </div>

                            <div v-if="featuredPackage"
                                class="rounded-3xl p-6 xl:p-6 bg-white overflow-hidden transition-all duration-200"
                                :class="[
                                    effectivePackageType === 'featured'
                                        ? 'border-[3px] border-[#800000] opacity-100'
                                        : 'border border-gray-100 opacity-55',
                                    isDowngradeOption('featured') ? 'cursor-not-allowed' : 'cursor-pointer'
                                ]" :title="isDowngradeOption('featured') ? downgradeTooltipText : null"
                                @click.prevent="onPackageSelect(featuredPackage)">
                                <div
                                    class="w-full mb-6 rounded-t-xl rounded-b-none bg-[#800000] py-2.5 flex items-center justify-center">
                                    <span class="font-semibold text-lg text-[#C9A227]">Featured</span>
                                </div>
                                <div class="flex flex-col items-center justify-center text-center gap-y-1">
                                    <p class="rounded-full bg-red-600/10 px-2.5 py-1 text-xs font-semibold leading-5 text-red-600 mt-1"
                                        v-if="featuredPackage?.is_default">
                                        Most popular
                                    </p>
                                </div>
                                <p class="mt-4 text-sm leading-6 text-gray-600">
                                    {{
                                        featuredPackage
                                            ?.registration_package_detail?.[0]
                                            ?.short_description
                                    }}
                                </p>
                                <p class="mt-6 flex items-baseline gap-x-1 justify-center">
                                    <span class="text-4xl font-bold tracking-tight text-gray-900">
                                        ${{ featuredPackage?.event_price }}
                                    </span>
                                </p>
                                <ul role="list" class="mt-8 space-y-3 text-sm leading-6 text-gray-600 xl:mt-10 p-0"
                                    v-if="
                                        featuredPackage?.registration_package_feature
                                    ">
                                    <li class="flex gap-x-3"
                                        v-for="features in featuredPackage?.registration_package_feature"
                                        :key="features.id">
                                        <svg class="h-6 w-5 flex-none text-[#006EB7]" viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span v-html="formatFeatureName(features?.name)"></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <Error v-if="submitted" fieldName="package_id" :validationErros="validationErros" full_width="1" />
            </div>
            <!-- 2 of 4 - Organizer & Contact Information-->
            <div
                class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-primary to-secondary rounded-md cursor-pointer my-6">
                <h4 class="text-white">
                    {{ JSON.parse(event_detail)["profile_section_heading"] }}
                </h4>
            </div>
            <div class="mb-6">
                <div class="relative w-full border border-gray-200 rounded-lg p-6 bg-white shadow-sm">
                    <h5 class="text-primary font-FuturaMdCnBT mb-4 text-lg md:text-xl lg:text-2xl">Your Profile</h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="relative w-full mb-3">
                            <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="name">{{
                                JSON.parse(event_detail)["name_label"] }} <span class="text-red-500">*</span></label>
                            <input @input="clearErrors('name')" type="text" class="can-exp-input" name="name" id="name"
                                v-model="form.name" />
                            <Error v-if="submitted" fieldName="name" :validationErros="validationErros"
                                full_width="1" />
                        </div>
                        <div class="relative w-full mb-3">
                            <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="email">{{
                                JSON.parse(event_detail)["email_label"] }} <span class="text-red-500">*</span></label>
                            <input @input="clearErrors('email')" type="email" class="can-exp-input" name="email"
                                id="email" v-model="form.email" @blur="checkEmailValidation($event.target.value)" />
                            <Error v-if="submitted" fieldName="email" :validationErros="validationErros"
                                full_width="1" />
                        </div>
                    </div>
                </div>
                <div class="mb-6">
                    <div class="border border-gray-200 mt-6 rounded-lg p-6 bg-white shadow-sm">
                        <h5 class="text-primary font-FuturaMdCnBT mb-4 text-lg md:text-xl lg:text-2xl">The Organizer
                        </h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="relative w-full mb-3">
                                <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg"
                                    for="business-name">{{
                                        JSON.parse(event_detail)["business_name_label"] || 'Organizer Name' }}</label>
                                <input @input="clearErrors('business_name')" type="text" class="can-exp-input"
                                    name="business-name" id="business-name" v-model="form.business_name" />
                                <Error v-if="submitted" fieldName="business_name" :validationErros="validationErros"
                                    full_width="1" />
                            </div>
                            <div class="relative w-full mb-3">
                                <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg"
                                    for="organizer_website">Organizer Website</label>
                                <input @input="clearErrors('organizer_website')" type="url" class="can-exp-input"
                                    name="organizer_website" id="organizer_website" v-model="form.organizer_website" />
                                <Error v-if="submitted" fieldName="organizer_website" :validationErros="validationErros"
                                    full_width="1" />
                            </div>
                            <div class="relative w-full mb-3">
                                <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg"
                                    for="organizer_phone">Phone<span class="text-red-500">*</span></label>
                                <input type="text" class="can-exp-input" name="organizer_phone" id="organizer_phone"
                                    v-model="form.organizer_phone" maxlength="16"
                                    @input="handleOrganizerPhoneInput($event.target.value)"
                                    @keypress="validateOrganizerPhoneKeypress" />
                                <Error v-if="submitted" fieldName="organizer_phone" :validationErros="validationErros"
                                    full_width="1" />
                            </div>
                            <div class="relative w-full mb-3 md:col-span-2">
                                <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg"
                                    for="mailing_address">Mailing
                                    Address</label>
                                <input @input="clearErrors('mailing_address')" type="text" class="can-exp-input"
                                    name="mailing_address" id="mailing_address" v-model="form.mailing_address" />
                                <Error v-if="submitted" fieldName="mailing_address" :validationErros="validationErros"
                                    full_width="1" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-6">
                    <div class="border border-gray-200 rounded-lg p-6 bg-white shadow-sm">
                        <h5 class="text-primary font-FuturaMdCnBT mb-4 text-lg md:text-xl lg:text-2xl">Contact Person
                        </h5>
                        <div v-for="(contact, index) in contacts" :key="index">
                            <div class="grid md:grid-cols-2 md:gap-6 gap-4 mt-6 bg-white shadow rounded-lg p-6">
                                <div class="relative z-0 w-full group">
                                    <label :for="`contact-name-[${index}]`"
                                        class="text-base md:text-base lg:text-lg">Full Name and
                                        Title <span class="text-red-500">*</span></label>
                                    <input type="text" name="contact-name" :id="`contact-name-[${index}]`"
                                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                                        v-model="contact.name"
                                        @input="updateContact(index, 'name', $event.target.value); clearErrors(`contacts.${index}.name`);" />
                                    <Error :fieldName="`contacts.${index}.name`" :validationErros="validationErros" />
                                </div>
                                <div class="relative z-0 w-full group">
                                    <label :for="`contact-phone-[${index}]`"
                                        class="text-base md:text-base lg:text-lg">Contact Phone
                                        <span class="text-gray-500 text-xs">(If different from the business
                                            phone)</span></label>
                                    <input type="text" name="contact-phone" :id="`contact-phone-[${index}]`"
                                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                                        v-model="contact.phone" maxlength="15"
                                        @input="handleContactPhoneInput(index, $event.target.value)"
                                        @keypress="validatePhoneKeypress" />
                                    <Error :fieldName="`contacts.${index}.phone`" :validationErros="validationErros" />
                                </div>
                                <div class="relative z-0 w-full group">
                                    <label :for="`contact-email-[${index}]`"
                                        class="text-base md:text-base lg:text-lg">Email <span
                                            class="text-gray-500 text-xs">(If different from the login email)</span>
                                    </label>
                                    <input type="text" name="contact-email" :id="`contact-email-[${index}]`"
                                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                                        v-model="contact.email"
                                        @input="updateContact(index, 'email', $event.target.value); clearErrors(`contacts.${index}.email`);" />
                                    <Error :fieldName="`contacts.${index}.email`" :validationErros="validationErros" />
                                </div>
                                <div class="relative z-0 w-full group">
                                    <label class="text-base md:text-base lg:text-lg inline-flex items-center gap-1">
                                        Contact Person's Photo
                                        <span class="relative inline-flex flex-shrink-0">
                                            <span
                                                class="inline-flex items-center justify-center w-4 h-4 rounded-full bg-gray-400 text-white text-xs font-bold cursor-pointer flex-shrink-0"
                                                aria-label="Photo tip"
                                                @click.stop="toggleContactPhotoTooltip(index)">!</span>
                                            <div v-if="contactPhotoTooltipIndex === index"
                                                class="absolute left-0 top-full mt-1 z-50 min-w-[200px] max-w-[280px] px-3 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg shadow-lg"
                                                @click.stop>Adding a photo helps other delegates and attendees recognize
                                                you at the
                                                event!</div>
                                        </span>
                                    </label>
                                    <input type="file" name="contact-image" :id="`contact-image-[${index}]`"
                                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                                        @change="uploadImage($event, index)"
                                        @input="clearErrors(`contacts.${index}.image_path`)" />
                                    <div v-if="contact.image_path" class="mt-2"><img :src="contact.image_path"
                                            class="h-40 w-40 object-cover rounded-lg cursor-pointer hover:opacity-80 transition-opacity"
                                            @click="showImagePopup(contact.image_path)" /></div>
                                    <Error :fieldName="`contacts.${index}.image_path`"
                                        :validationErros="validationErros" />
                                </div>
                                <div v-if="contacts.length > 1" class="relative z-0 w-full group">
                                    <button type="button" class="button-exp-fill mt-7"
                                        @click.prevent="deleteContact(index)">{{
                                            JSON.parse(eventsetting).delete_btn_text }}</button>
                                </div>
                            </div>
                        </div>
                        <div class="text-right mt-2">
                            <button type="button" class="button-exp-fill" @click.prevent="addContact">{{
                                JSON.parse(eventsetting).add_new_contact_btn_text }}</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: Event Details -->
            <div
                class="px-4 my-6 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-primary to-secondary rounded-md">
                <h4 class="text-white">
                    {{ JSON.parse(event_detail)["event_section_heading"] || 'Step 3 of 5 - Create your event' }}
                </h4>
            </div>
            <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6"
                v-for="language in languagesList" :key="language.id"
                :class="(activeTab == null && language.is_default) || activeTab == language.id ? 'block' : 'hidden'">
                <div class="relative z-0 w-full group">
                    <label for="title" class="text-base md:text-base lg:text-lg">
                        {{ JSON.parse(eventsetting).title_label }}
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        placeholder=" "
                        @input="handleInput($event.target.value, language, 'title'); clearErrors('title.title_' + language.id);"
                        :value="form['title'] && form['title'][`title_${language.id}`] ? form['title'][`title_${language.id}`] : ''" />
                    <Error v-if="submitted" :fieldName="`title.title_${language.id}`"
                        :validationErros="validationErros" />
                </div>
                <div class="relative z-0 w-full group">
                    <label for="country" class="text-base md:text-base lg:text-lg">
                        {{ JSON.parse(eventsetting).country_label }}
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="country" id="country"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        placeholder=" "
                        @input="handleInput($event.target.value, language, 'country'); clearErrors('country.country_' + language.id);"
                        :value="form['country'] && form['country'][`country_${language.id}`] ? form['country'][`country_${language.id}`] : ''" />
                    <Error v-if="submitted" :fieldName="`country.country_${language.id}`"
                        :validationErros="validationErros" />
                </div>
                <div class="relative z-0 w-full group">
                    <label for="city" class="text-base md:text-base lg:text-lg">
                        {{ JSON.parse(eventsetting).city_label }}
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="city" id="city"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        placeholder=" "
                        @input="handleInput($event.target.value, language, 'city'); clearErrors('city.city_' + language.id);"
                        :value="form['city'] && form['city'][`city_${language.id}`] ? form['city'][`city_${language.id}`] : ''" />
                    <Error v-if="submitted" :fieldName="`city.city_${language.id}`"
                        :validationErros="validationErros" />
                </div>
                <div class="relative z-0 w-full group">
                    <label for="street_name" class="text-base md:text-base lg:text-lg">
                        {{ JSON.parse(eventsetting).street_name_label }}
                    </label>
                    <input type="text" name="street_name" id="street_name"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        placeholder=" "
                        @input="handleInput($event.target.value, language, 'street_name'); clearErrors('street_name.street_name_' + language.id);"
                        :value="form['street_name'] && form['street_name'][`street_name_${language.id}`] ? form['street_name'][`street_name_${language.id}`] : ''" />
                    <Error v-if="submitted" :fieldName="`street_name.street_name_${language.id}`"
                        :validationErros="validationErros" />
                </div>
                <div class="relative z-0 w-full group">
                    <label for="venue" class="text-base md:text-base lg:text-lg">
                        {{ JSON.parse(eventsetting).venue_label }}
                    </label>
                    <input type="text" name="venue" id="venue"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        placeholder=" "
                        @input="handleInput($event.target.value, language, 'venue'); clearErrors('venue.venue_' + language.id);"
                        :value="form['venue'] && form['venue'][`venue_${language.id}`] ? form['venue'][`venue_${language.id}`] : ''" />
                    <Error v-if="submitted" :fieldName="`venue.venue_${language.id}`"
                        :validationErros="validationErros" />
                </div>
                <div class="relative z-0 w-full group">
                    <label for="product_search" class="text-base md:text-base lg:text-lg">
                        {{ JSON.parse(eventsetting).product_search_label }}
                    </label>
                    <input type="text" name="product_search" id="product_search"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        :placeholder="JSON.parse(eventsetting).product_search_placeholder"
                        @input="handleInput($event.target.value, language, 'product_search'); clearErrors('product_search.product_search_' + language.id);"
                        :value="form['product_search'] && form['product_search'][`product_search_${language.id}`] ? form['product_search'][`product_search_${language.id}`] : ''" />
                    <Error v-if="submitted" :fieldName="`product_search.product_search_${language.id}`"
                        :validationErros="validationErros" />
                </div>
            </div>
            <div class="mt-6">
                <div class="relative z-0 w-full group grid md:grid-cols-2 md:gap-6 gap-4" v-for="language in languagesList"
                    :key="'desc-' + language.id"
                    :class="(activeTab == null && language.is_default) || activeTab == language.id ? 'block' : 'hidden'">
                    <div>
                        <label for="short_description" class="text-base md:text-base lg:text-lg">
                            {{ JSON.parse(eventsetting).short_description_label }}
                            <span class="text-red-500">*</span>
                            <span class="ml-1 text-[0.85em] text-gray-600">(Max. 30 words)</span>
                        </label>
                        <textarea id="short_description" rows="4"
                            class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                            :placeholder="JSON.parse(eventsetting).short_description_placeholder"
                            @input="restrictToLength($event, 30, language, 'short_description'); clearErrors('short_description.short_description_' + language.id);"
                            :value="form['short_description'] && form['short_description'][`short_description_${language.id}`] ? form['short_description'][`short_description_${language.id}`] : ''"></textarea>
                        <Error v-if="submitted" :fieldName="`short_description.short_description_${language.id}`"
                            :validationErros="validationErros" />
                    </div>
                    <div>
                        <label for="description" class="text-base md:text-base lg:text-lg">
                            {{ JSON.parse(eventsetting).description_label }}
                            <span class="text-red-500">*</span>
                            <span class="ml-1 text-[0.85em] text-gray-600">(Max. 300 words)</span>
                        </label>
                        <textarea id="description" rows="4"
                            class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                            :placeholder="JSON.parse(eventsetting).description_placeholder"
                            @input="restrictToLength($event, 300, language, 'description'); clearErrors('description.description_' + language.id);"
                            :value="form['description'] && form['description'][`description_${language.id}`] ? form['description'][`description_${language.id}`] : ''"></textarea>
                        <Error v-if="submitted" :fieldName="`description.description_${language.id}`"
                            :validationErros="validationErros" />
                    </div>
                </div>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6 gap-4 mt-6">
                <div class="relative z-0 w-full group">
                    <label for="start_date" class="text-base md:text-base lg:text-lg">
                        {{ JSON.parse(eventsetting).start_date_label }}
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="start_date" id="start_date"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        :value="form.start_date"
                        @input="checkDateLength('start_date', $event); clearErrors('start_date');" />
                    <Error v-if="submitted" fieldName="start_date" :validationErros="validationErros" />
                </div>
                <div class="relative z-0 w-full group">
                    <label for="end_date" class="text-base md:text-base lg:text-lg">
                        {{ JSON.parse(eventsetting).end_date_label }}
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="end_date" id="end_date"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        :value="form.end_date" @input="checkDateLength('end_date', $event); clearErrors('end_date');" />
                    <Error v-if="submitted" fieldName="end_date" :validationErros="validationErros" />
                </div>
                <div class="relative z-0 w-full group">
                    <label for="event_website" class="text-base md:text-base lg:text-lg">
                        {{ JSON.parse(eventsetting).event_website_label }}
                        <span class="text-red-500">*</span>
                    </label>
                    <textarea rows="2" name="event_website" id="event_website"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        :placeholder="JSON.parse(eventsetting).event_website_placeholder" :value="form.event_website"
                        @input="updateForm('event_website', $event.target.value); clearErrors('event_website');"></textarea>
                    <Error v-if="submitted" fieldName="event_website" :validationErros="validationErros" />
                </div>
                <div class="relative z-0 w-full group">
                    <label for="exibitors_url" class="text-base md:text-base lg:text-lg">
                        {{ JSON.parse(eventsetting).exibitors_url_label }}
                    </label>
                    <textarea rows="2" name="exibitors_url" id="exibitors_url"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        :placeholder="JSON.parse(eventsetting).exibitors_url_placeholder" :value="form.exibitors_url"
                        @input="updateForm('exibitors_url', $event.target.value); clearErrors('exibitors_url');"></textarea>
                    <Error v-if="submitted" fieldName="exibitors_url" :validationErros="validationErros" />
                </div>
                <div class="relative z-0 w-full group">
                    <label for="visitors_url" class="text-base md:text-base lg:text-lg">
                        {{ JSON.parse(eventsetting).visitors_label }}
                    </label>
                    <input type="text" name="visitors_url" id="visitors_url"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        :placeholder="JSON.parse(eventsetting).visitors_placeholder" :value="form.visitors_url"
                        @input="updateForm('visitors_url', $event.target.value); clearErrors('visitors_url');" />
                    <Error v-if="submitted" fieldName="visitors_url" :validationErros="validationErros" />
                </div>
                <div class="relative z-0 w-full group">
                    <label for="press_url" class="text-base md:text-base lg:text-lg">
                        {{ JSON.parse(eventsetting).press_url_label }}
                    </label>
                    <input type="text" name="press_url" id="press_url"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        :placeholder="JSON.parse(eventsetting).press_url_placeholder" :value="form.press_url"
                        @input="updateForm('press_url', $event.target.value); clearErrors('press_url');" />
                    <Error v-if="submitted" fieldName="press_url" :validationErros="validationErros" />
                </div>

                <div class="relative z-0 w-full group flex flex-col">
                    <label for="video_url" class="text-base md:text-base lg:text-lg">{{
                        JSON.parse(eventsetting).video_url_label }}</label>
                    <textarea rows="2" name="video_url" id="video_url"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600 resize-y"
                        :title="JSON.parse(eventsetting).video_url_placeholder" :placeholder="JSON.parse(eventsetting).video_url_placeholder
                            " :value="form.video_url" @input="
                                    updateForm('video_url', $event.target.value);
                                clearErrors('video_url');
                                "></textarea>
                    <Error v-if="submitted" fieldName="video_url" :validationErros="validationErros" />
                </div>

                <!-- event media -->
                <div class="w-full">
                    <label for="" class="text-base md:text-base lg:text-lg  truncate">Main Event Image <span
                            class="ml-1 text-[0.95em] text-gray-600">(PNG, GIF, JPG, or JPEG format · 30 MB
                            max)</span><span class="text-red-500">*</span></label>
                    <div class="relative z-0 w-full mb-6 group">
                        <template v-if="
                            current_user &&
                            JSON.parse(current_user)?.registration_package?.package_type == 'featured'
                        ">
                            <FilePond
                                labelIdle='<span class="cursor-pointer">Drag & Drop your files or <span class="filepond--label-action"> Browse </span></span>'
                                class="cursor-pointer" name="gallery_image" ref="gallery_image" class-name="my-pond"
                                credits="false" accepted-file-types="image/*" allow-multiple="true"
                                @init="handleGalleryImagesInit" @processfile="handleGalleryImagesProcess"
                                @removefile="handleGalleryImagesRemoveFile" v-bind:files="gallery_files"
                                @addfile="clearErrors('gallery_images')" />
                        </template>
                        <template v-else>
                            <FilePond
                                labelIdle='<span class="cursor-pointer">Drag & Drop your files or <span class="filepond--label-action"> Browse </span></span>'
                                class="cursor-pointer" name="gallery_image" ref="gallery_image" class-name="my-pond"
                                credits="false" accepted-file-types="image/*" @init="handleGalleryImagesInit"
                                @processfile="handleGalleryImagesProcess" @removefile="handleGalleryImagesRemoveFile"
                                v-bind:files="gallery_files" @addfile="clearErrors('gallery_images')" />
                        </template>
                    </div>
                    <Error fieldName="gallery_images" :validationErros="validationErros" />
                </div>
            </div>

            <!-- CTA fields for Premium/Featured packages only - Moved to bottom of Step 3 -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6"
                v-if="form.package_type && form.package_type !== 'free'">
                <div class="relative z-0 w-full group">
                    <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg"
                        for="cta_btn">CTA(Call-to-Action)
                        Button
                        <span class="ml-1 text-[0.85em] text-gray-600">(Max. 5 words)</span>
                    </label>
                    <input type="text"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        placeholder="The button text that guides the user's next action; e.g., Learn More."
                        name="cta_btn" id="cta_btn" v-model="form.cta_btn" @input="restrictToCTAWords" />
                    <Error v-if="submitted" fieldName="cta_btn" :validationErros="validationErros" />
                </div>
                <div class="relative z-0 w-full group">
                    <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="cta_link">CTA
                        Link</label>
                    <input @input="clearErrors('cta_link')" type="text"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        placeholder="https://example.com" name="cta_link" id="cta_link" v-model="form.cta_link" />
                    <Error v-if="submitted" fieldName="cta_link" :validationErros="validationErros" />
                </div>
            </div>

            <!-- Social Media (Optional) -->
            <div
                class="px-4 my-6 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-primary to-secondary rounded-md">
                <h4 class="text-center card-heading text-white">
                    {{ JSON.parse(event_detail)["media_section_heading"] ?? 'Social Media (Optional)' }}
                </h4>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6 gap-4">
                <div class="relative z-0 w-full group">
                    <label for="facebook_url" class="text-base md:text-base lg:text-lg">{{
                        JSON.parse(eventsetting).facebook_url_label
                    }}</label>
                    <input type="text" name="facebook_url" id="facebook_url"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        placeholder=" " :value="form.facebook_url" @input="
                            updateForm('facebook_url', $event.target.value);
                            clearErrors('facebook_url');
                            " />
                    <Error v-if="submitted" fieldName="facebook_url" :validationErros="validationErros" />
                </div>
                <div class="relative z-0 w-full group">
                    <label for="twitter_url" class="text-base md:text-base lg:text-lg">{{
                        JSON.parse(eventsetting).twitter_url_label }}</label>
                    <input type="text" name="twitter_url" id="twitter_url"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        placeholder=" " :value="form.twitter_url" @input="
                            updateForm('twitter_url', $event.target.value);
                            clearErrors('twitter_url');
                            " />
                    <Error v-if="submitted" fieldName="twitter_url" :validationErros="validationErros" />
                </div>
                <div class="relative z-0 w-full group">
                    <label for="linkedin_url" class="text-base md:text-base lg:text-lg">{{
                        JSON.parse(eventsetting).linkedin_url_label
                    }}</label>
                    <input type="text" name="linkedin_url" id="linkedin_url"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        placeholder=" " :value="form.linkedin_url" @input="
                            updateForm('linkedin_url', $event.target.value);
                            clearErrors('linkedin_url');
                            " />
                    <Error v-if="submitted" fieldName="linkedin_url" :validationErros="validationErros" />
                </div>
                <div class="relative z-0 w-full group">
                    <label for="youtube_url" class="text-base md:text-base lg:text-lg">{{
                        JSON.parse(eventsetting).youtube_url_label }}</label>
                    <input type="text" name="youtube_url" id="youtube_url"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        placeholder=" " :value="form.youtube_url" @input="
                            updateForm('youtube_url', $event.target.value);
                            clearErrors('youtube_url');
                            " />
                    <Error v-if="submitted" fieldName="youtube_url" :validationErros="validationErros" />
                </div>
                <div class="relative z-0 w-full group">
                    <label for="pintrest_url" class="text-base md:text-base lg:text-lg">{{
                        JSON.parse(eventsetting).pintrest_url_label
                    }}</label>
                    <input type="text" name="pintrest_url" id="pintrest_url"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        placeholder=" " :value="form.pintrest_url" @input="
                            updateForm('pintrest_url', $event.target.value);
                            clearErrors('pintrest_url');
                            " />
                    <Error v-if="submitted" fieldName="pintrest_url" :validationErros="validationErros" />
                </div>
                <div class="relative z-0 w-full group">
                    <label for="instagram_url" class="text-base md:text-base lg:text-lg">{{
                        JSON.parse(eventsetting).instagram_url_label
                    }}</label>
                    <input type="text" name="instagram_url" id="instagram_url"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        placeholder=" " :value="form.instagram_url" @input="
                            updateForm('instagram_url', $event.target.value);
                            clearErrors('instagram_url');
                            " />
                    <Error v-if="submitted" fieldName="instagram_url" :validationErros="validationErros" />
                </div>
                <div class="relative z-0 w-full group">
                    <label for="snapchat_url" class="text-base md:text-base lg:text-lg">{{
                        JSON.parse(eventsetting).snapchat_url_label
                    }}</label>
                    <input type="text" name="snapchat_url" id="snapchat_url"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        placeholder=" " :value="form.snapchat_url" @input="
                            updateForm('snapchat_url', $event.target.value);
                            clearErrors('snapchat_url');
                            " />
                    <Error v-if="submitted" fieldName="snapchat_url" :validationErros="validationErros" />
                </div>
            </div>

            <!-- Photo Gallery (Premium / Featured) -->
            <div v-if="showPhotoGallery" class="mt-6">
                <div
                    class="px-4 my-6 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-primary to-secondary rounded-md">
                    <h4 class="text-center card-heading text-white">
                        Photo Gallery
                    </h4>
                </div>
                <div class="border border-gray-200 rounded-lg p-6 bg-white shadow-sm">
                    <label for="photo_gallery_images"
                        class="text-base md:text-base lg:text-lg font-medium block mb-2" id="photo_gallery_images">
                        {{ photoGallerySectionTitle }}
                    </label>
                    <div class="relative z-0 w-full mb-6 group">
                        <FilePond name="photo_gallery_image" :ref="el => { if (el) photoGalleryPond = el }"
                            class-name="my-pond"
                            labelIdle='<span class="cursor-pointer">Drag & Drop your files or <span class="filepond--label-action"> Browse </span></span>'
                            :max-files="effectivePackageType === 'featured' ? 20 : 8" :max-file-size="10 * 1024 * 1024"
                            accepted-file-types="image/png, image/gif, image/jpeg, image/jpg" credits="false"
                            allow-multiple="true" v-bind:files="photo_gallery_files"
                            :server="photoGalleryServerConfig" @init="handlePhotoGalleryInit"
                            @processfile="handlePhotoGalleryProcess" @removefile="handlePhotoGalleryRemoveFile"
                            @addfile="clearErrors('photo_gallery_images')" />
                    </div>
                    <Error fieldName="photo_gallery_images" :validationErros="validationErros" />
                </div>
            </div>        


            <!-- Payment Method Section -->
            <div class="px-4 my-6 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-primary to-secondary rounded-md"
                v-if="form.order_amount > 0">
                <h4 class="text-white">
                    {{ payment_setting && JSON.parse(payment_setting) ?
                        JSON.parse(payment_setting)["payment_method_text"] || "Payment Method" : "Payment Method" }}
                </h4>
            </div>

            <div class="flex justify-center gap-6 items-stretch xl:gap-12 px-4 py-8 sm:px-10"
                v-if="form.order_amount > 0">
                <div class="w-full flex">
                    <div class="h-full w-full rounded-lg border bg-white p-4 md:p-6 shadow-md flex flex-col">
                        <div>
                            <div class="flex justify-between items-center md:p-3">
                                <div class="w-full">
                                    <div class="flex items-center">
                                        <input id="stripe" name="payment-method" type="radio"
                                            class="h-4 w-4 border-gray-300 accent-primaryRed"
                                            @click="setPaymentMethod('stripe')"
                                            :checked="form.payment_method == 'stripe'" />
                                        <label for="stripe" class="ml-2 block text-gray-900">
                                            {{
                                                payment_setting &&
                                                    JSON.parse(payment_setting)
                                                    ? JSON.parse(payment_setting)[
                                                    "pay_with_credit_card_text"
                                                    ]
                                                    : ""
                                            }}
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="paypal" name="payment-method" type="radio"
                                            class="h-4 w-4 border-gray-300 accent-primaryRed"
                                            @click="setPaymentMethod('paypal')"
                                            :checked="form.payment_method == 'paypal'" />
                                        <label for="paypal" class="ml-2 block text-gray-900">
                                            <svg viewBox="0 0 157 44" fill="none" xmlns="http://www.w3.org/2000/svg"
                                                class="w-16 h-16 text-[#635BFF]">
                                                <g clip-path="url(#clip0_6_187)">
                                                    <path
                                                        d="M6.89999 2C7.29999 0.3 7.79999 0 9.49999 0C11.5 0 13.5 0 15.6 0C18.2 0.1 20.8 0.1 23.4 0.3C24.9 0.4 26.4 0.9 27.8 1.5C31.1 2.9 32.9 6.5 32.3 10.3C31.5 16 27.9 19.1 22.6 20.7C20.1 21.4 17.6 21.6 15 21.7C14.6 21.7 14.3 21.7 13.9 21.7C11.8 21.8 11 22.4 10.4 24.4C9.79999 26.7 9.09999 28.9 8.49999 31.2C8.19999 32.4 7.89999 32.6 6.59999 32.6C4.79999 32.6 2.99999 32.6 1.29999 32.4C0.0999947 32.3 -0.200005 31.9 0.0999947 30.7L6.89999 2ZM15.3 15.6C17 15.6 19.3 14.9 21 14.1C22.3 13.5 23 12.5 23.2 11.1C23.6 8.9 22.9 7.2 21.2 6.6C19.4 5.9 17.4 5.8 15.5 6.2C14.8 6.4 14.3 6.8 14.2 7.5C13.7 9.3 13.2 11.1 12.9 12.9C12.5 15.1 13 15.6 15.3 15.6ZM59.6 40.3C59.2 41 58.8 41.7 58.5 42.4C58.3 43 58.6 43.5 59.2 43.5C60.8 43.5 62.5 43.5 64.1 43.5C65.6 43.5 66.6 42.9 67.4 41.7C68 40.7 68.6 39.6 69.2 38.6C75.2 28.5 81.2 18.3 87.2 8.2C87.4 7.9 87.5 7.7 87.7 7.3C85.7 7.3 83.9 7.4 82 7.3C80 7.2 78.7 8.1 77.7 9.8C75.3 14 72.9 18.1 70.5 22.2C70.3 22.5 70.1 22.8 69.8 23.1C69.7 23.1 69.7 23 69.6 23C69.5 22.7 69.4 22.3 69.4 22C68.7 17.7 68 13.4 67.3 9.1C67.1 8.1 66.3 7.3 65.2 7.3C63.9 7.3 62.5 7.4 61.2 7.3C59.4 7.2 59.1 8.1 59.3 9.5L63 33.2C63.1 33.7 63 34.2 62.7 34.6L59.6 40.3ZM44.9 32.7C45.1 31.7 45.2 31 45.4 30.1C44.9 30.4 44.6 30.6 44.3 30.8C42.1 32 40 33 37.6 33.4C33.8 34 30.2 31.9 29.4 28.4C28.7 25.5 29.8 22.3 32.3 20.5C34.6 18.8 37.3 18.1 40 17.7C42.6 17.3 45.1 17 47.7 16.8C48.5 16.7 48.6 16.4 48.6 15.7C48.4 13.9 47.2 12.9 45 12.7C42.2 12.5 39.4 13.2 36.7 13.9C36.2 14 35.7 14.2 35.1 14.4C35.1 14.1 35 13.9 35 13.7C35.1 12.4 35.1 11.1 35.2 9.9C35.2 9.4 35.3 8.9 35.9 8.7C41 7.6 46.1 7 51.3 8.1C51.6 8.2 52 8.3 52.3 8.4C55.8 9.6 57 11.5 56.3 15.1C55.3 20.1 54.2 25.2 53.1 30.2C53 30.7 52.8 31.2 52.6 31.7C52.2 32.4 51.6 32.9 50.8 32.9C48.9 32.7 47 32.7 44.9 32.7ZM47.4 21C46.4 21.1 45.4 21.1 44.6 21.3C43 21.6 41.5 21.9 40 22.3C38.6 22.7 37.9 23.8 37.6 25.2C37.3 26.8 38 27.9 39.6 28.2C41.8 28.6 43.8 28 45.6 27C45.9 26.8 46.2 26.6 46.3 26.3C46.6 24.5 47 22.8 47.4 21Z"
                                                        fill="#162E53" />
                                                    <path
                                                        d="M91.7 1.4C92.1 0.3 92.6 0 93.7 0C95.9 0 98.1 0 100.3 0C102.9 0.1 105.5 0.1 108.1 0.3C109.6 0.5 111.1 0.9 112.5 1.5C115.7 2.8 117.5 6.3 117.1 9.9C116.5 15.3 113.1 19.2 107.3 20.6C105 21.2 102.5 21.3 100.1 21.6C99.6 21.7 99.1 21.6 98.5 21.6C96.5 21.7 95.7 22.3 95.1 24.2C94.5 26.4 93.8 28.7 93.2 30.9C92.8 32.2 92.6 32.4 91.2 32.4C89.5 32.4 87.9 32.4 86.2 32.3C84.6 32.2 84.4 31.8 84.7 30.3L91.7 1.4ZM102.3 5.9C101.7 6 100.9 6 100.2 6.2C99.7 6.4 99.2 6.8 99 7.2C98.4 9.3 97.9 11.4 97.5 13.5C97.2 15 97.7 15.4 99.2 15.5C101.4 15.6 103.5 15 105.5 14.1C107.1 13.4 107.8 12.2 108 10.5C108.2 8 107.2 6.6 104.8 6.1C104 6 103.2 6 102.3 5.9ZM119.7 14.1C119.8 13 119.8 11.9 119.9 10.8C120.1 8.3 119.8 8.7 122.3 8.2C126.2 7.4 130.1 7.1 134.1 7.6C135.2 7.7 136.4 8 137.4 8.4C140.5 9.5 141.7 11.5 141.1 14.7C140.1 19.8 138.9 24.9 137.8 30C137.7 30.5 137.5 31.1 137.2 31.5C136.8 32 136.2 32.6 135.7 32.6C133.7 32.7 131.6 32.7 129.5 32.7C129.7 31.8 129.8 31 130 30.2C129.3 30.6 128.7 31 128 31.3C125.9 32.4 123.7 33.5 121.3 33.5C117.8 33.6 115.1 31.9 114.1 29C113.1 26 114.2 22.4 116.9 20.5C119.2 18.8 121.9 18.1 124.6 17.7C127.2 17.3 129.7 17.1 132.3 16.8C132.9 16.7 133.2 16.5 133.1 15.8C133 14 131.7 12.9 129.5 12.7C126.5 12.5 123.6 13.2 120.8 14C120.5 14.1 120.2 14.2 120 14.2C120 14.2 119.9 14.1 119.7 14.1ZM132 21C131.1 21.1 130.2 21.1 129.4 21.2C127.8 21.5 126.2 21.7 124.7 22.2C123.4 22.6 122.5 23.5 122.2 24.9C121.8 26.7 122.5 27.8 124.3 28.1C126.4 28.4 128.4 27.9 130.2 26.8C130.5 26.6 130.8 26.3 130.9 25.9C131.3 24.4 131.6 22.7 132 21ZM156.3 0.1C154.3 0.1 152.5 0.1 150.6 0.1C149 0.1 148.6 0.4 148.2 2L142 30.1C141.6 31.8 141.9 32.2 143.7 32.2C144.9 32.2 146.2 32.3 147.4 32.3C148.9 32.3 149.2 32.1 149.5 30.6L156.3 0.1Z"
                                                        fill="#1E6196" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_6_187">
                                                        <rect width="156.3" height="43.5" fill="white" />
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                        </label>
                                    </div>
                                    <div id="card-element" class="border border-primary rounded p-2 mt-2"
                                        v-if="form.order_amount > 0 && form.payment_method == 'stripe'">
                                        <div class="flex justify-center items-center">
                                            <div class="h-auto bg-white p-3 rounded-lg w-full">
                                                <div class="input_text relative profile-card-field">
                                                    <label class="">{{
                                                        payment_setting &&
                                                            JSON.parse(payment_setting) &&
                                                            JSON.parse(payment_setting)["cardholder_name_label"]
                                                            ? JSON.parse(payment_setting)[
                                                            "cardholder_name_label"
                                                            ]
                                                            : ""
                                                    }}</label>
                                                    <i class="text-gray-400 fa fa-user"></i>
                                                    <input type="text" class="can-exp-input profile-card-input" :placeholder="payment_setting &&
                                                        JSON.parse(payment_setting) &&
                                                        JSON.parse(payment_setting)[
                                                        'cardholder_name_placeholder'
                                                        ]
                                                        ? JSON.parse(payment_setting)[
                                                        'cardholder_name_placeholder'
                                                        ]
                                                        : ''
                                                        " @input="
                                                            updateForm(
                                                                'card_holder_name',
                                                                $event.target.value
                                                            );
                                                        clearErrors('card_holder_name');
                                                        " id="card_holder_name" />
                                                    <Error fieldName="card_holder_name"
                                                        :validationErros="validationErros" full_width="1" />
                                                </div>
                                                <div class="input_text mt-2 relative profile-card-field">
                                                    <label class="">Card Details</label>
                                                    <div ref="stripeCard" class="can-exp-input profile-card-input profile-card-stripe-wrap"></div>
                                                    <Error fieldName="payment_method_id"
                                                        :validationErros="validationErros" full_width="1" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Order Summary -->
                <div class="w-full mt-6 rounded-lg border bg-white p-4 md:p-6 shadow-md md:mt-0 flex flex-col h-full">
                    <div class="mb-2 flex justify-between">
                        <p class="text-gray-700">{{ payment_setting && JSON.parse(payment_setting) ?
                            JSON.parse(payment_setting)["package_text"] : "Package" }}</p>
                        <p class="text-gray-700 capitalize">
                            {{ selectedEventPackage?.package_type || '' }}
                        </p>
                    </div>
                    <div class="mb-2 flex justify-between">
                        <p class="text-gray-700">{{ payment_setting && JSON.parse(payment_setting) ?
                            JSON.parse(payment_setting)["price_text"] : "Price" }}</p>
                        <p class="text-gray-700 capitalize">${{ form.order_amount || 0 }}</p>
                    </div>
                    <hr class="my-4" />
                    <div class="flex justify-between">
                        <p class="text-lg font-bold">{{ payment_setting && JSON.parse(payment_setting) ?
                            JSON.parse(payment_setting)["total_text"] : "Total" }}</p>
                        <div class="">
                            <p class="mb-1 text-lg font-bold capitalize">${{ form.order_amount || 0 }}</p>
                        </div>
                    </div>
                    <div class="text-center mt-auto">
                        <button class="button-exp-fill mt-6 font-bold" type="button" @click="recaptcha()"
                            :disabled="form.order_amount > 0 && !upgradePaymentFieldsFilled"
                            :class="{ 'opacity-50 cursor-not-allowed': form.order_amount > 0 && !upgradePaymentFieldsFilled }">
                            {{ form.order_amount > 0 ? "Upgrade & Pay Now" :
                                (payment_setting && JSON.parse(payment_setting) ?
                                    JSON.parse(payment_setting)["confirm_and_proceed_btn_text"] : "Update") }}
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex" v-if="form.order_amount == 0">
                <div class="">
                    <Error v-if="submitted" fieldName="captcha" :validationErros="validationErros" full_width="1" />
                </div>
            </div>

            <div class="pt-5 border-t border-gray-200" v-if="form.order_amount == 0">
                <div class="flex justify-center">
                    <button aria-label="Candian Exporters" type="submit" class="button-exp-fill font-bold"
                        id="send-message"
                        :disabled="!profileFormHasChanges"
                        :class="{ 'opacity-50 cursor-not-allowed': !profileFormHasChanges }">
                        {{ payment_setting && JSON.parse(payment_setting) ?
                            JSON.parse(payment_setting)["confirm_and_proceed_btn_text"] || "Update" : "Update"
                        }}
                    </button>
                </div>
            </div>
        </div>
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
</template>

<script>
import { load } from "recaptcha-v3";
import { loadStripe } from "@stripe/stripe-js";
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
// import ListErrors from "./../components/ListErrors.vue";
import axios from "axios";
import ErrorHandling from "../../ErrorHandling";
import { mapState } from "vuex";
export default {
    computed: {
        /** Safe list of languages (handles prop as array from :languages='@json()' or JSON string) */
        languagesList() {
            if (!this.languages) return [];
            if (Array.isArray(this.languages)) return this.languages;
            if (typeof this.languages === 'string') {
                try {
                    const p = JSON.parse(this.languages);
                    return Array.isArray(p) ? p : [];
                } catch (e) {
                    return [];
                }
            }
            return [];
        },
        years() {
            const currentYear = new Date().getFullYear();
            return Array.from(
                { length: 16 },
                (_, index) => currentYear + index
            );
        },
        selectedEventPackage() {
            if (!this.form.package_id || !this.packages || this.packages.length === 0) {
                return null;
            }
            return this.packages.find(pkg => pkg.id == this.form.package_id) || null;
        },
        packageTierOrder() {
            return { premium: 0, featured: 1 };
        },
        currentEventPlanTier() {
            const key = (this.initialEventPackageType ?? '').toString().trim().toLowerCase();
            if (key !== 'premium' && key !== 'featured') return null;
            return this.packageTierOrder[key] ?? null;
        },
        /** Normalized package type (lowercase string) for reliable comparison with API data */
        effectivePackageType() {
            const t = (this.form.package_type ?? '').toString().trim().toLowerCase();
            return t === 'premium' || t === 'featured' ? t : '';
        },
        /** First name for event dashboard welcome line */
        eventDashboardFirstName() {
            const name = (this.current_user && typeof this.current_user === 'string')
                ? (() => { try { return JSON.parse(this.current_user)?.name ?? ''; } catch (_) { return ''; } })()
                : (this.current_user?.name ?? '');
            return (typeof name === 'string' && name.trim()) ? name.trim().split(/\s+/)[0] : '';
        },
        /** Event dashboard description (Premium vs Featured); HTML with bold. Shown when package is set. */
        eventDashboardDescription() {
            if (!this.effectivePackageType) return '';
            const texts = {
                premium: 'This is your <strong>Premium Event</strong> page; update your event details here or <strong>reach more attendees</strong> with a Featured upgrade. Need help? <strong>Contact us.</strong>',
                featured: 'Welcome to your <strong>Featured Event</strong> page. Your event is receiving our highest level of visibility. Update your details here, or reach out to our <strong>specialized team</strong> to ensure your event looks perfect.'
            };
            return texts[this.effectivePackageType] || '';
        },
        showPhotoGallery() {
            return this.effectivePackageType === 'premium' || this.effectivePackageType === 'featured';
        },
        /** True when the user has changed any profile/event details from the initial load (for Update button) */
        profileFormHasChanges() {
            if (!this.initialFormSnapshot) return false;
            return JSON.stringify(this.form) !== JSON.stringify(this.initialFormSnapshot);
        },
        /** True when Cardholder name and Stripe card details are both filled (for Upgrade & Pay Now button) */
        upgradePaymentFieldsFilled() {
            const nameFilled = (this.form.card_holder_name || '').trim() !== '';
            return nameFilled && this.stripeCardComplete;
        },
        photoGallerySectionTitle() {
            if (this.effectivePackageType === 'featured') {
                return 'Photo Gallery (Upload up to 20 images. Max 10 MB each. Supports PNG, GIF, or JPG)';
            }
            if (this.effectivePackageType === 'premium') {
                return 'Photo Gallery (Upload up to 8 images. Max 10 MB each. Supports PNG, GIF, or JPG)';
            }
            return 'Photo Gallery';
        },
        photoGalleryServerConfig() {
            const csrf = document.head.querySelector('meta[name="csrf-token"]')?.content;
            return {
                url: process.env.MIX_APP_URL,
                process: (fieldName, file, metadata, load, error, progress, abort) => {
                    const formData = new FormData();
                    formData.append('photo_gallery_image', file, file.name);
                    formData.append('is_temp_media', 1);
                    formData.append('type', 'event_photo_gallery');
                    const request = new XMLHttpRequest();
                    request.open('POST', `${process.env.MIX_APP_URL}/media/process`);
                    if (csrf) request.setRequestHeader('X-CSRF-TOKEN', csrf);
                    request.upload.onprogress = (e) => progress(e.lengthComputable, e.loaded, e.total);
                    request.onload = () => {
                        if (request.status >= 200 && request.status < 300) {
                            load(request.responseText);
                        } else {
                            const err = request.responseText || 'Upload failed';
                            try {
                                const j = JSON.parse(request.responseText);
                                if (j.errors?.['photo_gallery_image']) error(j.errors['photo_gallery_image'][0]);
                                else if (j.message) error(j.message);
                                else error(err);
                            } catch (_) { error(err); }
                        }
                    };
                    request.send(formData);
                    return { abort: () => { request.abort(); abort(); } };
                },
                revert: (uniqueFileId, load, error, progress, abort) => {
                    const formData = new FormData();
                    formData.append('media', uniqueFileId);
                    const request = new XMLHttpRequest();
                    request.open('POST', `${process.env.MIX_APP_URL}/media/revert`);
                    if (csrf) request.setRequestHeader('X-CSRF-TOKEN', csrf);
                    request.onload = () => load();
                    request.send(formData);
                    return { abort: () => { request.abort(); if (abort) abort(); } };
                },
                headers: csrf ? { 'X-CSRF-TOKEN': csrf } : {},
            };
        },
    },
    props: [
        "event_detail",
        "eventsetting",
        "languages",
        "submit_url",
        "page_id",
        "create_page_id",
        "email_validation_url",
        "lang",
        "payment_setting",
        "current_user",
    ],
    components: {
        FilePond,
        Error,
        // ListErrors,
    },
    data() {
        return {
            current_user: null,
            gallery_files: [],
            photo_gallery_files: [],
            photoGalleryPond: null,
            contacts: [],
            activeTab: null,
            stripe: null,
            elements: null,
            cardElement: null,
            form: {
                page_id: this.page_id,
                create_page_id: this.create_page_id,
                card_holder_name: null,
                name: this.current_user.name || "",
                business_name: "",
                email: "",
                package_id: "",
                order_amount: 0,
                payment_method: "stripe",
                package_type: null,
                payment_frequency: "annually",
                cta_btn: "",
                cta_link: "",
                is_agree: false,
                title: {},
                country: {},
                city: {},
                street_name: {},
                venue: {},
                product_search: {},
                short_description: {},
                description: {},
                start_date: null,
                end_date: null,
                event_website: null,
                exibitors_url: null,
                visitors_url: null,
                press_url: null,
                video_url: null,
                facebook_url: null,
                twitter_url: null,
                linkedin_url: null,
                youtube_url: null,
                pintrest_url: null,
                instagram_url: null,
                snapchat_url: null,
                gallery_images: [],
                photo_gallery_images: [],
                contacts: [],
            },
            freePackage: [],
            featuredPackage: [],
            premiumPackage: [],
            packages: [],
            validationErros: new ErrorHandling(),
            reCAPTCHA_site_key: process.env.MIX_reCAPTCHA_site_key,
            loading: false,
            showTooltip: false,
            submitted: false,
            showDowngradeMessage: false,
            downgradeTooltipText:
                "Membership downgrades cannot be processed automatically. Please contact us to adjust your plan.",
            initialEventPackageType: null,
            initialFormSnapshot: null,
            stripeCardComplete: false,
        };
    },
    mounted() {
        // Load form data from localStorage; preserve page_id/create_page_id from props
        const savedForm = localStorage.getItem("event_signup_form");
        console.log("Saved Form Data:", JSON.parse(savedForm));        
        if (savedForm) {
            const parsed = JSON.parse(savedForm);
            this.form = { ...this.form, ...parsed };
            this.form.page_id = this.form.page_id ?? this.page_id;
            this.form.create_page_id = this.form.create_page_id ?? this.create_page_id;
        }
        this.$nextTick(() => {
            this.initialFormSnapshot = JSON.parse(JSON.stringify(this.form));
        });
    },
    watch: {
        form: {
            handler(newForm) {
                // Save form data to localStorage on change
                console.log("Form changed:",JSON.stringify(newForm));                
                localStorage.setItem(
                    "event_signup_form",
                    JSON.stringify(newForm)
                );
            },
            deep: true,
        },
        languages: {
            handler(newLanguages) {
                if (!Array.isArray(newLanguages)) return; // Ensure it's an array

                let obj = {};
                newLanguages.forEach((res) => {
                    obj["title_" + res.id] = "";
                });

                this.form.title = obj;
            },
            immediate: true // Run the handler immediately if `languages` is already available
        },
        current_user: {
            handler(newValue) {
                let user = JSON.parse(newValue);
                console.log("Updated User:", user);
                if (user) {
                    this.form.name = user.name || '';
                    this.form.business_name = user.business_name || '';
                    this.form.email = user.email || '';
                    this.form.package_id = user.registration_package_id || '';
                    this.form.package_type = user.registration_package?.package_type || null;
                    this.form.order_amount = user.registration_package?.event_price || 0;
                    this.initialEventPackageType = user.registration_package?.package_type ?? null;
                    this.form.organizer_website = user.customer_profile?.website ?? '';
                    this.form.organizer_phone = user.customer_profile?.phone ?? '';
                    this.form.mailing_address = user.customer_profile?.address ?? '';
                    this.form.title.title_1 = user.event_detail[0]?.title || '';
                    this.form.title.title_13 = user.event_detail[1]?.title || '';
                    this.form.country.country_1 = user.event_detail[0]?.country || '';
                    this.form.country.country_13 = user.event_detail[1]?.country || '';
                    this.form.city.city_1 = user.event_detail[0]?.city || '';
                    this.form.city.city_13 = user.event_detail[1]?.city || '';
                    this.form.street_name.street_name_1 = user.event_detail[0]?.street_name || '';
                    this.form.street_name.street_name_13 = user.event_detail[1]?.street_name || '';
                    this.form.venue.venue_1 = user.event_detail[0]?.venue || '';
                    this.form.venue.venue_13 = user.event_detail[1]?.venue || '';
                    this.form.product_search.product_search_1 = user.event_detail[0]?.product_search || '';
                    this.form.product_search.product_search_13 = user.event_detail[1]?.product_search || '';
                    this.form.short_description.short_description_1 = user.event_detail[0]?.short_description || '';
                    this.form.short_description.short_description_13 = user.event_detail[1]?.short_description || '';
                    this.form.description.description_1 = user.event_detail[0]?.description || '';
                    this.form.description.description_13 = user.event_detail[1]?.description || '';
                    this.form.start_date = user.event[0]?.start_date || '';
                    this.form.end_date = user.event[0]?.end_date || '';
                    this.form.event_website = user.event[0]?.event_website || '';
                    this.form.exibitors_url = user.event[0]?.exibitors_url || '';
                    this.form.visitors_url = user.event[0]?.visitors_url || '';
                    this.form.press_url = user.event[0]?.press_url || '';
                    this.form.video_url = user.event[0]?.video_url || '';

                    // Populate main gallery and photo gallery from event_media (same logic as Create.vue)
                    const eventMedia = user.event?.[0]?.event_media;
                    if (eventMedia && Array.isArray(eventMedia) && eventMedia.length > 0) {
                        let galleryImages = [];
                        this.gallery_files = [];
                        let photoGalleryImages = [];
                        this.photo_gallery_files = [];
                        eventMedia.forEach((media) => {
                            if (!media.media) return;
                            const type = media.type || 'main';
                            const fileOpt = {
                                source: media.media.id,
                                options: {
                                    type: 'local',
                                    metadata: { serverId: media.media.id }
                                }
                            };
                            if (type === 'gallery') {
                                photoGalleryImages.push(media.media.id);
                                this.photo_gallery_files.push(fileOpt);
                            } else {
                                galleryImages.push(media.media.id);
                                this.gallery_files.push(fileOpt);
                            }
                        });
                        this.form.gallery_images = JSON.stringify(galleryImages);
                        this.form.photo_gallery_images = JSON.stringify(photoGalleryImages);
                    }

                }
            },
            immediate: true // Watcher ko turant run karne ke liye
        },
        'form.payment_method': {
            handler(newMethod) {
                this.stripeCardComplete = false;
                // Remount Stripe Elements when switching back to Stripe
                if (newMethod === 'stripe') {
                    this.mountStripeCardWhenReady();
                }
            }
        },
        /** When order_amount becomes > 0 (e.g. user upgrades from FREE to PREMIUM), payment section appears and we must mount Stripe card then */
        'form.order_amount': {
            handler(newAmount) {
                if (newAmount > 0 && this.form.payment_method === 'stripe') {
                    this.mountStripeCardWhenReady();
                }
            }
        }
    },
    methods: {
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
            this.form[field] = value;
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
        handleInput(value, language, fieldName) {
            this.form[fieldName][`${fieldName}_${language.id}`] =
                value;
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
                designation: null,
                image_path: null,
            });
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
        clearErrors(fieldName) {
            if (this.submitted) {
                this.validationErros.clear(fieldName);
            }
        },
        /** Mount or remount Stripe card element when the payment section is in the DOM (e.g. after selecting Premium). */
        mountStripeCardWhenReady() {
            this.$nextTick(() => {
                setTimeout(() => {
                    const mountPoint = this.$refs.stripeCard;
                    if (!mountPoint || !this.stripe) return;
                    if (this.cardElement) {
                        try {
                            this.cardElement.unmount();
                        } catch (e) {
                            // Element not mounted, that's okay
                        }
                        try {
                            this.cardElement.mount(mountPoint);
                            this.setupStripeCardChangeListener();
                        } catch (e) {
                            console.error('Error mounting Stripe Element:', e);
                            this.elements = this.elements || this.stripe.elements();
                            this.cardElement = this.elements.create('card');
                            this.cardElement.mount(mountPoint);
                            this.setupStripeCardChangeListener();
                        }
                    } else {
                        this.elements = this.elements || this.stripe.elements();
                        this.cardElement = this.elements.create('card');
                        this.cardElement.mount(mountPoint);
                        this.setupStripeCardChangeListener();
                    }
                }, 100);
            });
        },
        setupStripeCardChangeListener() {
            if (this.cardElement) {
                this.stripeCardComplete = false;
                this.cardElement.off('change');
                this.cardElement.on('change', (e) => {
                    this.stripeCardComplete = !!e.complete;
                    this.validationErros.clear('payment_method_id');
                });
            }
        },
        clearForm() {
            this.form["name"] = "";
            this.form["business_name"] = "";
            this.form["email"] = "";
            this.form["package_type"] = null;
            this.form["payment_frequency"] = "annually";
            this.form["photo_gallery_images"] = [];
            this.photo_gallery_files = [];
            this.gallery_files = [];
            this.validationErros = new ErrorHandling();
            localStorage.removeItem("event_signup_form");
        },
        async recaptcha() {
            this.submitted = true;
            this.loading = 1;
            load(process.env.MIX_reCAPTCHA_site_key).then((recaptcha) => {
                // Badge removed - reCAPTCHA v3 works invisibly
                recaptcha.execute("submit").then((token) => {
                    axios
                        .post(`${process.env.MIX_WEB_API_URL}verifyRecaptcha`, {
                            token: token,
                        })
                        .then((res) => {
                            if (res.data.status == "Success") {
                                this.addUpdateForm();
                            } else if (res.data.status == "Error") {
                                this.loading = 0;
                                this.validationErros.record({
                                    captcha: [res.data.message],
                                });
                            }
                        });
                });
            });
        },
        async addUpdateForm() {
            this.addReg();
        },
        async addReg() {
            this.form.contacts = Array.isArray(this.contacts) ? this.contacts : [];
            this.loading = 1;

            // Build payload: ensure page_id/create_page_id and gallery fields match backend expectations
            let payload = { ...this.form };
            payload.page_id = payload.page_id ?? this.page_id;
            payload.create_page_id = payload.create_page_id ?? this.create_page_id;
            payload.contacts = Array.isArray(payload.contacts) ? payload.contacts : [];
            // Backend expects gallery_images and photo_gallery_images as JSON strings for json_decode
            if (typeof payload.gallery_images !== 'string') {
                payload.gallery_images = payload.gallery_images != null ? JSON.stringify(payload.gallery_images) : null;
            }
            if (typeof payload.photo_gallery_images !== 'string') {
                payload.photo_gallery_images = payload.photo_gallery_images != null ? JSON.stringify(payload.photo_gallery_images) : null;
            }

            // When using Stripe, create PaymentMethod on frontend and send id only
            if (this.form.payment_method === 'stripe' && this.cardElement && this.stripe && this.form.order_amount > 0) {
                try {
                    const { error, paymentMethod } = await this.stripe.createPaymentMethod({
                        type: 'card',
                        card: this.cardElement,
                        billing_details: {
                            name: this.form.card_holder_name || undefined,
                        }
                    });
                    if (error) {
                        this.validationErros.set('payment_method_id', error.message);
                        this.loading = 0;
                        return;
                    }
                    payload = { ...payload, payment_method_id: paymentMethod.id };
                } catch (err) {
                    console.error('Payment error:', err);
                    this.loading = 0;
                    return;
                }
            }

            axios
                .post(this.submit_url, payload)
                .then((res) => {
                    this.loading = 0;
                    if (res.data.status == "Success") {
                        if (res?.data?.data?.type == "paypal") {
                            window.location.href =
                                res?.data?.data?.redirect_url;
                        } else {
                            this.clearForm();
                            window.location.href = res.data.data.redirect_url;
                        }
                    } else {
                        helper.swalErrorMessageForWeb(res.data.message);
                    }
                })
                .catch((error) => {
                    this.loading = 0;
                    this.validationErros = new ErrorHandling();
                    if (error.response && error.response.status == 422) {
                        this.validationErros.record(error.response.data.errors);
                        this.$nextTick(() => this.focusOnFirstErrorInput(error.response.data.errors));
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
        focusOnFirstErrorInput(errors) {
            const errorKeys = new Set(Object.keys(errors));
            const allErrorElements = Array.from(document.querySelectorAll('[data-error-field]'))
                .filter((el) => errorKeys.has(el.getAttribute('data-error-field')));
            const firstErrorEl = allErrorElements[0];
            if (firstErrorEl) {
                firstErrorEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                const input = firstErrorEl.closest('.group')?.querySelector('input, textarea, select');
                if (input) input.focus();
                return;
            }
            const firstErrorKey = Object.keys(errors)[0];
            if (!firstErrorKey) return;
            if (firstErrorKey.startsWith('contacts.')) {
                const m = firstErrorKey.match(/contacts\.(\d+)\.(\w+)/);
                if (m) {
                    const input = document.getElementById(`contact-${m[2]}-[${m[1]}]`);
                    if (input) {
                        input.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        input.focus();
                    }
                }
            } else if (firstErrorKey === 'photo_gallery_images') {
                const el = document.getElementById('photo_gallery_images');
                if (el) el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else {
                const baseName = firstErrorKey.split('.')[0];
                const input = document.getElementById(baseName) || document.querySelector(`[name="${firstErrorKey}"]`);
                if (input) {
                    input.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    input.focus();
                }
            }
        },
        checkEmailValidation(email) {
            if (email == "") {
                return;
            }
            this.loading = 1;
            axios
                .post(this.email_validation_url, {
                    email: email,
                    page_id: this.page_id,
                })
                .then((res) => {
                    this.loading = 0;
                    if (res.data.status == "Success") {
                        this.validationErros.clear("email");
                    }
                })
                .catch((error) => {
                    this.loading = 0;
                    if (error.response && error.response.status == 422) {
                        // console.log(error.response.data.errors && error.response.data.errors['email'] && error.response.data.errors['email'][0] ?  && error.response.data.errors['email'][0] : '');
                        this.validationErros.set(
                            "email",
                            error.response.data.errors &&
                                error.response.data.errors["email"] &&
                                error.response.data.errors["email"][0]
                                ? error.response.data.errors["email"][0]
                                : ""
                        );
                    }
                });
        },
        async setPaymentMethod(value) {
            this.form.payment_method = value;
        },
        updatePackageId(registrationPackage) {
            this.form.order_amount =
                registrationPackage.discount_price != null &&
                    registrationPackage.discount_price != "" &&
                    registrationPackage.discount_price != "" &&
                    registrationPackage.discount_price > 0
                    ? registrationPackage.discount_price
                    : registrationPackage.price;
            this.form.package_id = registrationPackage.id;
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
        isDowngradeOption(packageType) {
            if (this.currentEventPlanTier == null) return false;
            const selectedTier = this.packageTierOrder[packageType] ?? -1;
            return selectedTier < this.currentEventPlanTier;
        },
        onPackageSelect(pkg) {
            if (!pkg?.package_type) return;
            if (this.isDowngradeOption(pkg.package_type)) {
                this.showDowngradeMessage = true;
                setTimeout(() => {
                    this.showDowngradeMessage = false;
                }, 8000);
                return;
            }
            this.showDowngradeMessage = false;
            this.updatePackageForm(pkg);
        },
        updatePackageForm(event_package) {
            this.form.package_id = event_package.id;
            this.form.package_type = event_package.package_type;
            this.form.order_amount = event_package.event_price;
            this.validationErros.clear("package_id");
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
            if (this.form.gallery_images.length == 0) {
                this.form.gallery_images = JSON.stringify([JSON.parse(file.serverId)[0]]);
            } else {
                let gallery_images = JSON.parse(this.form.gallery_images);
                gallery_images.push(JSON.parse(file.serverId)[0]);
                this.form.gallery_images = JSON.stringify(gallery_images);
            }
        },
        handleGalleryImagesRemoveFile(error, file) {
            if (this.$route.params.id) {
                if (file.getMetadata() && file.getMetadata().serverId) {
                    let gallery_images = JSON.parse(this.form.gallery_images);
                    const index = gallery_images.indexOf(file.getMetadata().serverId);
                    if (index > -1) {
                        gallery_images.splice(index, 1);
                        this.form.gallery_images = JSON.stringify(gallery_images);
                    }
                }
            } else {
                let gallery_images = JSON.parse(this.form.gallery_images);
                const index = gallery_images.indexOf(JSON.parse(file.serverId)[0]);
                if (index > -1) {
                    gallery_images.splice(index, 1);
                    this.form.gallery_images = JSON.stringify(gallery_images);
                }
            }
        },
        handlePhotoGalleryInit() {
            // Server config is passed via :server="photoGalleryServerConfig"
        },
        handlePhotoGalleryProcess(error, file) {
            const id = typeof file.serverId === 'string' ? JSON.parse(file.serverId)[0] : (file.serverId && file.serverId[0]);
            if (!this.form.photo_gallery_images || this.form.photo_gallery_images.length === 0) {
                this.form.photo_gallery_images = JSON.stringify([id]);
            } else {
                let arr = JSON.parse(this.form.photo_gallery_images);
                arr.push(id);
                this.form.photo_gallery_images = JSON.stringify(arr);
            }
        },
        handlePhotoGalleryRemoveFile(error, file) {
            let arr = [];
            try {
                arr = JSON.parse(this.form.photo_gallery_images || '[]');
            } catch (_) { }
            const serverId = file.getMetadata()?.serverId ?? (typeof file.serverId === 'string' ? JSON.parse(file.serverId)[0] : file.serverId?.[0]);
            const index = arr.indexOf(serverId);
            if (index > -1) {
                arr.splice(index, 1);
                this.form.photo_gallery_images = JSON.stringify(arr);
            }
        },
        formatFeatureName(name) {
            if (!name) {
                return "";
            }
            return String(name).replace(/\((\d+)\)/g, '<sup class="footnote-indicator">($1)</sup>');
        },
        restrictToCTAWords(event) {
            let inputValue = event.target.value.trim();
            let wordsArray = inputValue.match(/\S+/g) || [];

            if (wordsArray.length > 5) {
                wordsArray = wordsArray.slice(0, 5);
                event.target.value = wordsArray.join(" ");
            }

            this.form.cta_btn = event.target.value;
            this.clearErrors('cta_btn');
        },
        updateTermsAgreement(checked) {
            this.form.is_agree = checked;
            this.clearErrors('is_agree');
        },
    },
    created() {
        this.gallery_files = [];
        this.photo_gallery_files = [];
        this.contacts = [];
        const savedContacts =
            JSON.parse(localStorage.getItem("eventContacts")) || [];
        if (savedContacts.length > 0) {
            this.contacts = savedContacts;
        } else {
            this.addContact(1);
        }
        this.activeTab = JSON.parse(this.lang)["id"];
        this.form.payment_frequency = "annually";

        // Initialize Stripe Elements; mount when payment section is visible (e.g. after upgrading to Premium)
        (async () => {
            try {
                this.stripe = await loadStripe(process.env.MIX_STRIPE_PUBLIC_KEY);
                if (this.stripe) {
                    this.elements = this.stripe.elements();
                    this.cardElement = this.elements.create('card');
                    this.mountStripeCardWhenReady();
                }
            } catch (e) {
                console.error('Error loading Stripe:', e);
            }
        })();
        axios
            .get(
                `${process.env.MIX_APP_URL}/get-registration-packages?getPackagesOnly=1&withPackageFeatures=1&getEventPackagesOnly=1`
            )
            .then((res) => {
                if (res.data.status == "Success") {
                    this.packages = res.data.data;
                    this.freePackage = res.data.data.find(
                        (p) => p.package_type == "free"
                    );
                    this.featuredPackage = res.data.data.find(
                        (p) => p.package_type == "featured"
                    );
                    this.premiumPackage = res.data.data.find(
                        (p) => p.package_type == "premium"
                    );
                    // Only apply default package if user has no package yet (e.g. not set from current_user)
                    const hasPackageAlready = this.form.package_id || (this.form.package_type != null && this.form.package_type !== '');
                    if (!hasPackageAlready) {
                        this.packages.map((registrationPackage) => {
                            if (registrationPackage.is_default == "1") {
                                this.form.package_id = registrationPackage.id;
                                this.form.order_amount =
                                    registrationPackage.event_price;
                                this.form.package_type =
                                    registrationPackage.package_type;
                                return true;
                            }
                        });
                    }
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

.footnote-indicator {
    font-size: 0.75em;
    vertical-align: super;
    line-height: 1;
}

/* Cardholder name and Card details: identical dimensions */
.profile-card-field .profile-card-input,
.profile-card-stripe-wrap {
    min-height: 2.5rem;
    padding: 0.375rem 0.75rem;
    box-sizing: border-box;
}
.profile-card-stripe-wrap {
    display: block;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
}
</style>