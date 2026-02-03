<template>
    <form class="lg:w-full" @submit.prevent="recaptcha()">
        <div class="my-4">
            <div
                class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-primary to-secondary rounded-md cursor-pointer my-6">
                <h4 class="text-white">
                    {{ JSON.parse(event_detail)["profile_section_heading"] }}
                </h4>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="relative w-full mb-3">
                    <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="name">{{
                        JSON.parse(event_detail)["name_label"] }}
                        <span class="text-red-500">*</span></label>
                    <input @input="clearErrors('name')" type="text" class="can-exp-input" placeholder="" name="name"
                        id="name" v-model="form.name" />
                    <Error v-if="submitted" fieldName="name" :validationErros="validationErros" full_width="1" />
                </div>
                <div class="relative w-full mb-3">
                    <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="business-name">{{
                        JSON.parse(event_detail)["business_name_label"]
                    }}</label>
                    <input @input="clearErrors('business-name')" type="text" class="can-exp-input" placeholder=""
                        name="business-name" id="business-name" v-model="form.business_name" />
                    <Error v-if="submitted" fieldName="business_name" :validationErros="validationErros"
                        full_width="1" />
                </div>
                <div class="relative w-full mb-3">
                    <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="email">{{
                        JSON.parse(event_detail)["email_label"] }}
                        <span class="text-red-500">*</span></label>
                    <input @input="clearErrors('email')" type="email" disabled class="can-exp-input" placeholder=""
                        name="email" id="email" v-model="form.email"
                        @blur="checkEmailValidation($event.target.value)" />
                    <Error v-if="submitted" fieldName="email" :validationErros="validationErros" full_width="1" />
                </div>
            </div>
            <div
                class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-primary to-secondary rounded-md cursor-pointer my-6">
                <h4 class="text-white">
                    {{ JSON.parse(event_detail)["package_section_heading"] }}
                </h4>
            </div>
            <div class="w-full">
                <div class="bg-gray-50">
                    <div class="mx-auto max-w-7xl px-6 lg:px-8">
                        <div
                            class="isolate mx-auto mt-10 grid max-w-md grid-cols-1 gap-8 lg:mx-auto lg:max-w-3xl md:grid-cols-2 lg:grid-cols-2">
                            <div class="rounded-3xl p-6 xl:p-6 border bg-white cursor-pointer" :class="form.package_type == 'premium'
                                    ? 'ring-2 ring-[#006EB7]'
                                    : ''
                                " @click.prevent="
                                    updatePackageForm(premiumPackage)
                                    ">
                                <div class="flex items-center lg:justify-between gap-x-4">
                                    <h3 id="tier-startup" class="text-xl leading-8 text-blue-600">
                                        {{
                                            premiumPackage
                                                ?.registration_package_detail?.[0]
                                                ?.name
                                        }}
                                    </h3>
                                    <p class="rounded-full bg-red-600/10 px-2.5 py-1 text-xs font-semibold leading-5 text-red-600"
                                        v-if="premiumPackage?.is_default">
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
                                    <span class="text-4xl font-bold tracking-tight text-gray-900">
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

                            <div class="rounded-3xl p-6 xl:p-6 border bg-white cursor-pointer" :class="form.package_type == 'featured'
                                    ? 'ring-2 ring-[#006EB7]'
                                    : ''
                                " @click.prevent="
                                    updatePackageForm(featuredPackage)
                                    ">
                                <div class="flex items-center lg:justify-between gap-x-4">
                                    <h3 id="tier-startup" class="text-xl leading-8 text-blue-600">
                                        {{
                                            featuredPackage
                                                ?.registration_package_detail?.[0]
                                                ?.name
                                        }}
                                    </h3>
                                    <p class="rounded-full bg-red-600/10 px-2.5 py-1 text-xs font-semibold leading-5 text-red-600"
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

            <!-- Step 3: Event Details -->
            <div
                class="px-4 my-6 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-primary to-secondary rounded-md">
                <h4 class="text-white">
                    {{ JSON.parse(event_detail)["event_section_heading"] || 'Step 3 of 5 - Create your event' }}
                </h4>
            </div>
            <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6"
                v-for="language in JSON.parse(languages)" :key="language.id"
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
            </div>

            <!-- CTA fields for Premium/Featured packages only - Moved to bottom of Step 3 -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6"
                v-if="form.package_type && form.package_type !== 'free'">
                <div class="relative z-0 w-full group">
                    <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg"
                        for="cta_btn">CTA(Call-to-Action) Button
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

            <!-- Step 4: Event Description -->
            <div
                class="px-4 my-6 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-primary to-secondary rounded-md">
                <h4 class="text-white">
                    {{ JSON.parse(event_detail)["contact_section_heading"] ?? 'Step 4 of 5 - Contact information' }}
                </h4>
            </div>
            <div class="grid my-5 grid-cols-1 sm:grid-cols-1 gap-6" v-for="language in JSON.parse(languages)"
                :key="'desc-' + language.id"
                :class="(activeTab == null && language.is_default) || activeTab == language.id ? 'block' : 'hidden'">
                <div class="relative z-0 w-full group">
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
                <div class="relative z-0 w-full mb-6 group">
                    <label for="description" class="text-base md:text-base lg:text-lg">
                        {{ JSON.parse(eventsetting).description_label }}
                        <span class="text-red-500">*</span>
                        <span class="ml-1 text-[0.85em] text-gray-600">(Max. 300 words)</span>
                    </label>
                    <textarea id="description" rows="6"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        :placeholder="JSON.parse(eventsetting).description_placeholder"
                        @input="restrictToLength($event, 300, language, 'description'); clearErrors('description.description_' + language.id);"
                        :value="form['description'] && form['description'][`description_${language.id}`] ? form['description'][`description_${language.id}`] : ''"></textarea>
                    <Error v-if="submitted" :fieldName="`description.description_${language.id}`"
                        :validationErros="validationErros" />
                </div>
            </div>

            <!-- Step 5: Event Media -->
            <div
                class="px-4 my-6 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-primary to-secondary rounded-md">
                <h4 class="text-white">
                    {{ JSON.parse(event_detail)["media_section_heading"] ?? 'Step 5 of 5 - Social media (Optional)' }}
                </h4>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6 gap-4 my-5">
                <div class="relative z-0 w-full group">
                    <label for="video_url" class="text-base md:text-base lg:text-lg">
                        {{ JSON.parse(eventsetting).video_url_label }}
                    </label>
                    <textarea rows="2" name="video_url" id="video_url"
                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                        :placeholder="JSON.parse(eventsetting).video_url_placeholder" :value="form.video_url"
                        @input="updateForm('video_url', $event.target.value); clearErrors('video_url');"></textarea>
                    <Error v-if="submitted" fieldName="video_url" :validationErros="validationErros" />
                </div>
            </div>

            <div v-for="(contact, index) in contacts" :key="index" class="mb-6">
                <div class="grid md:grid-cols-3 md:gap-6 gap-4 mt-6 bg-white shadow rounded-lg p-6">
                    <div class="relative z-0 w-full group">
                        <label :for="`contact-name-${index}`" class="text-base md:text-base lg:text-lg">
                            {{ JSON.parse(eventsetting).contact_name_label }}
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="contact-name" :id="`contact-name-${index}`"
                            class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                            v-model="contact.name" placeholder=""
                            @input="updateContact(index, 'name', $event.target.value); clearErrors(`contacts.${index}.name`);" />
                        <Error v-if="submitted" :fieldName="`contacts.${index}.name`"
                            :validationErros="validationErros" />
                    </div>
                    <div class="relative z-0 w-full group">
                        <label :for="`contact-email-${index}`" class="text-base md:text-base lg:text-lg">
                            {{ JSON.parse(eventsetting).contact_email_label }}
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="contact-email" :id="`contact-email-${index}`"
                            class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                            v-model="contact.email" placeholder=""
                            @input="updateContact(index, 'email', $event.target.value); clearErrors(`contacts.${index}.email`);" />
                        <Error v-if="submitted" :fieldName="`contacts.${index}.email`"
                            :validationErros="validationErros" />
                    </div>
                    <div class="relative z-0 w-full group">
                        <label :for="`contact-phone-${index}`" class="text-base md:text-base lg:text-lg">
                            {{ JSON.parse(eventsetting).contact_phone_label }}
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="contact-phone" :id="`contact-phone-${index}`"
                            class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                            v-model="contact.phone" placeholder=""
                            @input="updateContact(index, 'phone', $event.target.value); clearErrors(`contacts.${index}.phone`);" />
                        <Error v-if="submitted" :fieldName="`contacts.${index}.phone`"
                            :validationErros="validationErros" />
                    </div>
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
                                                <div class="input_text relative">
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
                                                    <input type="text" class="can-exp-input" :placeholder="payment_setting &&
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
                                                <div class="input_text mt-2 relative">
                                                    <label class="">Card details</label>
                                                    <div ref="stripeCard" class="can-exp-input"></div>
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
                        <button class="button-exp-fill mt-6 font-bold" type="button" @click="recaptcha()">
                            {{ form.order_amount > 0 ? (payment_setting && JSON.parse(payment_setting) ?
                                JSON.parse(payment_setting)["confirm_and_pay_btn_text"] : "Confirm and Pay") :
                                (payment_setting && JSON.parse(payment_setting) ?
                            JSON.parse(payment_setting)["confirm_and_proceed_btn_text"] : "Confirm and Pay") }}
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
                    <button aria-label="Candian Exporters" type="submit" class="button-exp-fill font-bold" id="send-message">
                        {{ payment_setting && JSON.parse(payment_setting) ?
                            JSON.parse(payment_setting)["confirm_and_pay_btn_text"] || "Confirm and Pay" : "Confirm and Pay"
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
        };
    },
    mounted() {
        // Load form data from localStorage
        const savedForm = localStorage.getItem("event_signup_form");
        if (savedForm) {
            this.form = JSON.parse(savedForm);
        }
    },
    watch: {
        form: {
            handler(newForm) {
                // Save form data to localStorage on change
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

                this.state.form.title = obj;
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
                    this.form.package_type = user.registration_package.package_type || 0;
                    this.form.order_amount = user.registration_package.event_price || 0;
                }
            },
            immediate: true // Watcher ko turant run karne ke liye
        },
        'form.payment_method': {
            handler(newMethod) {
                // Remount Stripe Elements when switching back to Stripe
                if (newMethod === 'stripe') {
                    this.$nextTick(() => {
                        // Small delay to ensure DOM is ready
                        setTimeout(() => {
                            const mountPoint = this.$refs.stripeCard;
                            if (mountPoint && this.cardElement && this.stripe) {
                                try {
                                    // Try to unmount first if already mounted
                                    this.cardElement.unmount();
                                } catch (e) {
                                    // Element not mounted, that's okay
                                }

                                try {
                                    // Mount to the DOM
                                    this.cardElement.mount(mountPoint);
                                    this.setupStripeCardChangeListener();
                                    console.log('Stripe Element remounted successfully');
                                } catch (e) {
                                    console.error('Error mounting Stripe Element:', e);
                                    // If mounting fails, recreate the element
                                    this.cardElement = this.elements.create('card');
                                    this.cardElement.mount(mountPoint);
                                    this.setupStripeCardChangeListener();
                                }
                            } else if (mountPoint && this.stripe && !this.cardElement) {
                                // Card element doesn't exist, create and mount it
                                this.elements = this.stripe.elements();
                                this.cardElement = this.elements.create('card');
                                this.cardElement.mount(mountPoint);
                                this.setupStripeCardChangeListener();
                                console.log('Stripe Element created and mounted');
                            }
                        }, 100);
                    });
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
        setupStripeCardChangeListener() {
            if (this.cardElement) {
                this.cardElement.off('change');
                this.cardElement.on('change', () => {
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
            this.form.contacts = this.contacts;
            this.loading = 1;

            // When using Stripe, create PaymentMethod on frontend and send id only
            let payload = this.form;
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
                    payload = { ...this.form, payment_method_id: paymentMethod.id };
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
        updatePackageForm(event_package) {
            this.form.package_id = event_package.id;
            this.form.package_type = event_package.package_type;
            this.form.order_amount = event_package.event_price;
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

        // Initialize Stripe Elements (same pattern as Coffee on Wall)
        (async () => {
            try {
                this.stripe = await loadStripe(process.env.MIX_STRIPE_PUBLIC_KEY);
                if (this.stripe) {
                    this.elements = this.stripe.elements();
                    this.cardElement = this.elements.create('card');
                    this.$nextTick(() => {
                        const mountPoint = this.$refs.stripeCard;
                        if (mountPoint && this.cardElement) {
                            try {
                                this.cardElement.mount(mountPoint);
                                this.setupStripeCardChangeListener();
                            } catch (e) {
                                // If already mounted or fails, recreate and mount
                                console.error('Error mounting Stripe:', e);
                            }
                        }
                    });
                }
            } catch (e) {
                console.error('Error loading Stripe:', e); //
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
</style>