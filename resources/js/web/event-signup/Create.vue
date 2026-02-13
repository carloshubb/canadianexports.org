<template>
    <form class="lg:w-full" @submit.prevent="recaptcha()">
        <div class="my-4">
            <!-- Step 1 of 4: Select Your Package -->
            <div
                class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-primary to-secondary rounded-md cursor-pointer my-6">
                <h4 class="text-center card-heading text-white">
                    {{ JSON.parse(event_detail)["package_section_heading"] ?? "1 of 4 - Select Your Package" }}
                </h4>
            </div>
            <div class="w-full">
                <div class="bg-gray-50">
                    <div class="mx-auto max-w-7xl px-6 lg:px-8">
                        <div v-if="showDowngradeMessage"
                            class="mx-auto mt-4 max-w-2xl rounded-lg border border-amber-300 bg-amber-50 px-4 py-3 text-sm text-amber-800"
                            role="alert">
                            {{ JSON.parse(event_detail)["membership_downgrade_issue_message"] ?? "Membership downgrades cannot be processed automatically. Please contact us to adjust your plan." }}
                        </div>
                        <div
                            class="isolate mx-auto mt-10 grid max-w-md grid-cols-1 gap-8 lg:mx-auto lg:max-w-3xl md:grid-cols-2 lg:grid-cols-2">
                            <div v-if="premiumPackage"
                                class="rounded-3xl p-6 xl:p-6 bg-white overflow-hidden transition-all duration-200"
                                :class="[
                                    form.package_type == 'premium'
                                        ? 'border-[3px] border-red-600 opacity-100'
                                        : 'border border-gray-300 opacity-55',
                                    isDowngradeOption('premium') ? 'cursor-not-allowed' : 'cursor-pointer'
                                ]" :title="isDowngradeOption('premium') ? downgradeTooltipText : null"
                                @click.prevent="onPackageSelect(premiumPackage)">
                                <!-- Premium bar: red bg, white text, rounded top only; full color when selected (card opacity fades when not) -->
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
                                    form.package_type == 'featured'
                                        ? 'border-[3px] border-[#800000] opacity-100'
                                        : 'border border-gray-100 opacity-55',
                                    isDowngradeOption('featured') ? 'cursor-not-allowed' : 'cursor-pointer'
                                ]" :title="isDowngradeOption('featured') ? downgradeTooltipText : null"
                                @click.prevent="onPackageSelect(featuredPackage)">
                                <!-- Featured bar: maroon bg, warm gold text, rounded top only; full color when selected (card opacity fades when not). Unselected frame: very thin light grey -->
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

            <!-- Step 2 of 4: Organizer & Contact Information -->
            <div
                class="px-4 my-6 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-primary to-secondary rounded-md">
                <h4 class="text-center card-heading text-white">{{JSON.parse(event_detail)["organizer_contact_section_heading"] ?? '2 of 4 - Organizer & Contact Information' }}</h4>
            </div>
            <div class="mb-6">
                <div class="border border-gray-200 rounded-lg p-6 bg-white shadow-sm">
                    <h5 class="text-primary font-FuturaMdCnBT mb-4 text-lg md:text-xl lg:text-2xl">{{ JSON.parse(event_detail)["your_profile_heading"] || 'Your Profile' }}</h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="relative w-full mb-3">
                            <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg font-bold" for="name">{{
                                JSON.parse(event_detail)["name_label"] }} <span class="text-red-500">*</span></label>
                            <input @input="clearErrors('name')" type="text" class="can-exp-input" name="name" id="name"
                                v-model="form.name" />
                            <Error v-if="submitted" fieldName="name" :validationErros="validationErros"
                                full_width="1" />
                        </div>
                        <div class="relative w-full mb-3">
                            <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg font-bold" for="email">{{
                                JSON.parse(event_detail)["email_label"] }} <span class="text-red-500">*</span></label>
                            <input @input="clearErrors('email')" type="email" class="can-exp-input" name="email"
                                id="email" v-model="form.email" @blur="checkEmailValidation($event.target.value)" />
                            <Error v-if="submitted" fieldName="email" :validationErros="validationErros"
                                full_width="1" />
                        </div>
                        <template v-if="!event_id">
                            <div class="relative w-full mb-3">
                                <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg font-bold"
                                    for="password">{{ JSON.parse(event_detail)["password_label"] || 'Create Password' }}
                                    <span class="text-xs  font-normal">(Min. 8 characters. Must contain at least one lowercase and
                                        one uppercase)</span> <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input @input="clearErrors('password')" :type="display_password"
                                        class="can-exp-input pr-10" name="password" id="password"
                                        v-model="form.password" />
                                    <span
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 cursor-pointer"
                                        @click="display_password = display_password === 'password' ? 'text' : 'password'"
                                        :title="display_password === 'password' ? 'Show password' : 'Hide password'">
                                        <svg v-if="display_password === 'password'" class="w-5 h-5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        <svg v-else class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                            </path>
                                        </svg>
                                    </span>
                                </div>
                                <Error v-if="submitted" fieldName="password" :validationErros="validationErros"
                                    full_width="1" />
                            </div>
                            <div class="relative w-full mb-3">
                                <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg font-bold"
                                    for="password_confirmation">{{ JSON.parse(event_detail)["confirm_password_label"] ||
                                    'Confirm Password' }} <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input @input="clearErrors('password_confirmation')"
                                        :type="display_confirm_password" class="can-exp-input pr-10"
                                        name="password_confirmation" id="password_confirmation" @blur="checkPassword()"
                                        v-model="form.password_confirmation" />
                                    <span
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 cursor-pointer"
                                        @click="display_confirm_password = display_confirm_password === 'password' ? 'text' : 'password'"
                                        :title="display_confirm_password === 'password' ? 'Show password' : 'Hide password'">
                                        <svg v-if="display_confirm_password === 'password'" class="w-5 h-5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        <svg v-else class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                            </path>
                                        </svg>
                                    </span>
                                </div>
                                <Error v-if="submitted" fieldName="password_confirmation"
                                    :validationErros="validationErros" full_width="1" />
                            </div>
                        </template>
                    </div>
                </div>
                <div class="mb-6">
                    <div class="border border-gray-200 mt-6 rounded-lg p-6 bg-white shadow-sm">
                        <h5 class="text-primary font-FuturaMdCnBT mb-4 text-lg md:text-xl lg:text-2xl">{{ JSON.parse(event_detail)["the_organizer_heading"] || 'The Organizer' }}</h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="relative w-full mb-3">
                                <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg font-bold"
                                    for="business-name">{{
                                        JSON.parse(event_detail)["business_name_label"] || 'Organizer Name' }}</label>
                                <input @input="clearErrors('business_name')" type="text" class="can-exp-input"
                                    name="business-name" id="business-name" v-model="form.business_name" />
                                <Error v-if="submitted" fieldName="business_name" :validationErros="validationErros"
                                    full_width="1" />
                            </div>
                            <div class="relative w-full mb-3">
                                <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg font-bold"
                                    for="organizer_website">{{ JSON.parse(event_detail)["organizer_website_label"] || 'Organizer Website' }}</label>
                                <input @input="clearErrors('organizer_website')" type="url" class="can-exp-input"
                                    name="organizer_website" id="organizer_website" v-model="form.organizer_website" />
                                <Error v-if="submitted" fieldName="organizer_website" :validationErros="validationErros"
                                    full_width="1" />
                            </div>
                            <div class="relative w-full mb-3">
                                <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg font-bold"
                                    for="organizer_phone">{{ JSON.parse(event_detail)["organizer_phone_label"] || 'Phone' }}<span class="text-red-500">*</span></label>
                                <input type="text" class="can-exp-input" name="organizer_phone" id="organizer_phone"
                                    v-model="form.organizer_phone" maxlength="16"
                                    @input="handleOrganizerPhoneInput($event.target.value)"
                                    @keypress="validateOrganizerPhoneKeypress" />
                                <Error v-if="submitted" fieldName="organizer_phone" :validationErros="validationErros"
                                    full_width="1" />
                            </div>
                            <div class="relative w-full mb-3 md:col-span-2">
                                <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg font-bold"
                                    for="mailing_address">{{ JSON.parse(event_detail)["mailing_address_label"] || 'Mailing Address' }}</label>
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
                        <h5 class="text-primary font-FuturaMdCnBT mb-4 text-lg md:text-xl lg:text-2xl">{{ JSON.parse(event_detail)["contact_person_heading"] || 'Contact Person' }}</h5>
                        <div v-for="(contact, index) in contacts" :key="index">
                            <div class="grid md:grid-cols-2 md:gap-6 gap-4 mt-6 bg-white shadow rounded-lg p-6">
                                <div class="relative z-0 w-full group">
                                    <label :for="`contact-name-[${index}]`"
                                        class="text-base md:text-base lg:text-lg font-bold">{{ JSON.parse(event_detail)["contact_name_label"] || 'Full Name and Title' }}<span class="text-red-500">*</span></label>
                                    <input type="text" name="contact-name" :id="`contact-name-[${index}]`"
                                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                                        v-model="contact.name"
                                        @input="updateContact(index, 'name', $event.target.value); clearErrors(`contacts.${index}.name`);" />
                                    <Error :fieldName="`contacts.${index}.name`" :validationErros="validationErros" />
                                </div>
                                <div class="relative z-0 w-full group">
                                    <label :for="`contact-phone-[${index}]`"
                                        class="text-base md:text-base lg:text-lg font-bold">{{ JSON.parse(event_detail)["contact_phone_label"] || 'Contact Phone' }}
                                        <span class="text-gray-500 text-xs  font-normal">{{ JSON.parse(event_detail)["contact_phone_hint"] || '(If different from the business phone)' }}</span></label>
                                    <input type="text" name="contact-phone" :id="`contact-phone-[${index}]`"
                                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                                        v-model="contact.phone" maxlength="15"
                                        @input="handleContactPhoneInput(index, $event.target.value)"
                                        @keypress="validatePhoneKeypress" />
                                    <Error :fieldName="`contacts.${index}.phone`" :validationErros="validationErros" />
                                </div>
                                <div class="relative z-0 w-full group">
                                    <label :for="`contact-email-[${index}]`"
                                        class="text-base md:text-base lg:text-lg font-bold">{{ JSON.parse(event_detail)["contact_email_label"] || 'Email' }} <span
                                            class="text-gray-500 text-xs  font-normal">{{ JSON.parse(event_detail)["contact_email_hint"] || '(If different from the login email)' }}</span>
                                    </label>
                                    <input type="text" name="contact-email" :id="`contact-email-[${index}]`"
                                        class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                                        v-model="contact.email"
                                        @input="updateContact(index, 'email', $event.target.value); clearErrors(`contacts.${index}.email`);" />
                                    <Error :fieldName="`contacts.${index}.email`" :validationErros="validationErros" />
                                </div>
                                <div class="relative z-0 w-full group">
                                    <label class="text-base md:text-base lg:text-lg inline-flex items-center gap-1 font-bold">
                                        {{ JSON.parse(event_detail)["contact_photo_label"] || "Contact Person's Photo" }}
                                        <span class="relative inline-flex flex-shrink-0 font-normal">
                                            <span
                                                class="inline-flex items-center justify-center w-4 h-4 rounded-full bg-gray-400 text-white text-xs font-bold cursor-pointer flex-shrink-0"
                                                aria-label="Photo tip"
                                                @click.stop="toggleContactPhotoTooltip(index)">!</span>
                                            <div v-if="contactPhotoTooltipIndex === index"
                                                class="absolute left-0 top-full mt-1 z-50 min-w-[200px] max-w-[280px] px-3 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg shadow-lg"
                                                @click.stop>{{ JSON.parse(event_detail)["contact_photo_tooltip"] || 'Adding a photo helps other delegates and attendees recognize you at the event!' }}</div>
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

                <div
                    class="px-4 my-6 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-primary to-secondary rounded-md">
                    <h4 class="text-center card-heading text-white">
                        {{ JSON.parse(event_detail)["event_section_heading"] ?? 'Step 3 of 4 - Create Your Event' }}
                    </h4>
                </div>
                <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6"
                    v-for="language in languagesList" :key="language.id" :class="(activeTab == null && language.is_default) ||
                        activeTab == language.id
                        ? 'block'
                        : 'hidden'
                        ">
                    <div class="relative z-0 w-full group">
                        <!---Event Name-->
                        <label for="title" class="text-base md:text-base lg:text-lg font-bold">{{
                            JSON.parse(eventsetting).title_label
                            }}
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title"
                            class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                            placeholder=" " @input="
                                handleInput($event.target.value, language, 'title');
                            clearErrors('title.title_' + language.id);
                            " :value="form['title'] &&
                            form['title'][`title_${language.id}`]
                            ? form['title'][`title_${language.id}`]
                            : ''
                            " />

                        <Error v-if="submitted" :fieldName="`title.title_${language.id}`"
                            :validationErros="validationErros" />
                    </div>
                    <div class="relative z-0 w-full group">
                        <!---Country-->
                        <label for="country" class="text-base md:text-base lg:text-lg font-bold">{{
                            JSON.parse(eventsetting).country_label }}
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="country" id="country"
                            class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                            placeholder=" " @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'country'
                                );
                            clearErrors('country.country_' + language.id);
                            " :value="form['country'] &&
                            form['country'][`country_${language.id}`]
                            ? form['country'][`country_${language.id}`]
                            : ''
                            " />

                        <Error v-if="submitted" :fieldName="`country.country_${language.id}`"
                            :validationErros="validationErros" />
                    </div>
                    <div class="relative z-0 w-full group">
                        <!---City-->
                        <label for="city" class="text-base md:text-base lg:text-lg font-bold">{{
                            JSON.parse(eventsetting).city_label
                            }}
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="city" id="city"
                            class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                            placeholder=" " @input="
                                handleInput($event.target.value, language, 'city');
                            clearErrors('city.city_' + language.id);
                            " :value="form['city'] && form['city'][`city_${language.id}`]
                            ? form['city'][`city_${language.id}`]
                            : ''
                            " />
                        <Error v-if="submitted" :fieldName="`city.city_${language.id}`"
                            :validationErros="validationErros" />
                    </div>
                    <div class="relative z-0 w-full group">
                        <!---Street Name-->
                        <label for="street_name" class="text-base md:text-base lg:text-lg font-bold">{{
                            JSON.parse(eventsetting).street_name_label }}</label>
                        <input type="text" name="street_name" id="street_name"
                            class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                            placeholder=" " @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'street_name'
                                );
                            clearErrors(
                                'street_name.street_name_' + language.id
                            );
                            " :value="form['street_name'] &&
                            form['street_name'][`street_name_${language.id}`]
                            ? form['street_name'][
                            `street_name_${language.id}`
                            ]
                            : ''
                            " />
                        <Error v-if="submitted" :fieldName="`street_name.street_name_${language.id}`"
                            :validationErros="validationErros" />
                    </div>
                    <div class="relative z-0 w-full group">
                        <!---Venue-->
                        <label for="venue" class="text-base md:text-base lg:text-lg font-bold">{{
                            JSON.parse(eventsetting).venue_label
                            }}
                        </label>
                        <input type="text" name="venue" id="venue"
                            class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                            placeholder=" " @input="
                                handleInput($event.target.value, language, 'venue');
                            clearErrors('venue.venue_' + language.id);
                            " :value="form['venue'] &&
                            form['venue'][`venue_${language.id}`]
                            ? form['venue'][`venue_${language.id}`]
                            : ''
                            " />
                        <Error v-if="submitted" :fieldName="`venue.venue_${language.id}`"
                            :validationErros="validationErros" />
                    </div>
                    <div class="relative z-0 w-full group">
                        <!---Product Search-->
                        <label for="product_search" class="text-base md:text-base lg:text-lg font-bold">{{
                            JSON.parse(eventsetting).product_search_label
                            }}</label>
                        <input type="text" name="product_search" id="product_search"
                            class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                            :placeholder="'(Max. 5, separated by commas.)'
                                " @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'product_search'
                                );
                            clearErrors(
                                'product_search.product_search_' + language.id
                            );
                            " :value="form['product_search'] &&
                                form['product_search'][
                                `product_search_${language.id}`
                                ]
                                ? form['product_search'][
                                `product_search_${language.id}`
                                ]
                                : ''
                                " />
                        <Error v-if="submitted" :fieldName="`product_search.product_search_${language.id}`"
                            :validationErros="validationErros" />
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="short_description" class="text-base md:text-base font-bold lg:text-lg">
                            {{ JSON.parse(eventsetting).short_description_label }}
                            <span class="text-red-500">*</span>
                        </label>
                        <textarea id="short_description" rows="4"
                            class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                            :placeholder="JSON.parse(eventsetting)
                                .short_description_placeholder
                                " @input="
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
                            " v-text="form['short_description'] &&
                                form['short_description'][
                                `short_description_${language.id}`
                                ]
                                ? form['short_description'][
                                `short_description_${language.id}`
                                ]
                                : ''
                                "></textarea>
                        <Error v-if="submitted" :fieldName="`short_description.short_description_${language.id}`"
                            :validationErros="validationErros" />
                    </div>

                    <!-- Description (Max 300 Words) -->
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="description" class="text-base md:text-base font-bold lg:text-lg">
                            {{ JSON.parse(eventsetting).description_label }}
                            <span class="text-red-500">*</span>
                        </label>
                        <textarea id="description" rows="4"
                            class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                            :placeholder="JSON.parse(eventsetting).description_placeholder
                                " @input="
                                restrictToLength(
                                    $event,
                                    300,
                                    language,
                                    'description'
                                );
                            clearErrors(
                                'description.description_' + language.id
                            );
                            " v-text="form['description'] &&
                                form['description'][`description_${language.id}`]
                                ? form['description'][
                                `description_${language.id}`
                                ]
                                : ''
                                "></textarea>
                        <Error v-if="submitted" :fieldName="`description.description_${language.id}`"
                            :validationErros="validationErros" />
                    </div>
                </div>
                <div class="grid md:grid-cols-2 md:gap-6 gap-4">
                    <div class="relative w-full group" style="z-index: auto;">
                        <label for="start_date" class="text-base md:text-base lg:text-lg font-bold">{{
                            JSON.parse(eventsetting).start_date_label }}
                            <span class="text-red-500">*</span></label>
                        <VueDatePicker name="start_date" v-model="form.start_date" placeholder="YYYY-MM-DD"
                            model-type="yyyy-MM-dd" :formats="{ input: 'yyyy-MM-dd' }"
                            :time-config="{ enableTimePicker: false }" auto-apply @update:model-value="
                                clearErrors('start_date');
                            $store.commit('signup/setForm', { field: ['start_date'], value: $event });">
                        </VueDatePicker>
                        <div v-if="dateErrors.start_date"
                            class="mt-2 rounded-md border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-600 shadow-sm">
                            {{ dateErrors.start_date }}
                        </div>
                        <Error v-if="submitted" fieldName="start_date" :validationErros="validationErros" />
                    </div>
                    <div class="relative w-full group" style="z-index: auto;">
                        <label for="end_date" class="text-base md:text-base lg:text-lg font-bold">{{
                            JSON.parse(eventsetting).end_date_label }}
                            <span class="text-red-500">*</span></label>
                        <VueDatePicker name="end_date" v-model="form.end_date" placeholder="YYYY-MM-DD"
                            model-type="yyyy-MM-dd" :formats="{ input: 'yyyy-MM-dd' }"
                            :time-config="{ enableTimePicker: false }" auto-apply @update:model-value="
                                clearErrors('end_date');
                            $store.commit('signup/setForm', { field: ['end_date'], value: $event });">
                        </VueDatePicker>

                        <div v-if="dateErrors.end_date"
                            class="mt-2 rounded-md border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-600 shadow-sm">
                            {{ dateErrors.end_date }}
                        </div>
                        <Error v-if="submitted" fieldName="end_date" :validationErros="validationErros" />
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="event_website" class="text-base md:text-base lg:text-lg font-bold ">{{
                            JSON.parse(eventsetting).event_website_label }}
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="event_website" id="event_website"
                            class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                            :placeholder="JSON.parse(eventsetting).event_website_placeholder
                                " :value="form.event_website" @input="
                                updateForm('event_website', $event.target.value);
                            clearErrors('event_website');
                            " />
                        <Error v-if="submitted" fieldName="event_website" :validationErros="validationErros" />
                    </div>
                    <div></div>
                    <div class="relative z-0 w-full group flex flex-col">
                        <label for="exibitors_url" class="text-base md:text-base lg:text-lg font-bold">{{
                            JSON.parse(eventsetting).exibitors_url_label
                            }}</label>
                        <textarea rows="2" name="exibitors_url" id="exibitors_url"
                            class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600 resize-y"
                            :title="JSON.parse(eventsetting).exibitors_url_placeholder" :placeholder="JSON.parse(eventsetting).exibitors_url_placeholder
                                " :value="form.exibitors_url" @input="
                                updateForm('exibitors_url', $event.target.value);
                            clearErrors(
                                'exibitors_url');
                            "></textarea>
                        <Error v-if="submitted" fieldName="exibitors_url" :validationErros="validationErros" />
                    </div>
                    <div class="relative z-0 w-full group flex flex-col">
                        <label for="visitors_url" class="text-base md:text-base lg:text-lg font-bold">{{
                            JSON.parse(eventsetting).visitors_label }}</label>
                        <textarea rows="2" name="visitors_url" id="visitors_url"
                            class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600 resize-y"
                            :title="JSON.parse(eventsetting).visitors_placeholder" :placeholder="JSON.parse(eventsetting).visitors_placeholder
                                " :value="form.visitors_url" @input="
                                updateForm('visitors_url', $event.target.value);
                            clearErrors(
                                'visitors_url'
                            );
                            "></textarea>
                        <Error this.submitted="true;" fieldName="visitors_url" :validationErros="validationErros" />
                    </div>
                    <div class="relative z-0 w-full group flex flex-col">
                        <label for="press_url" class="text-base md:text-base lg:text-lg font-bold">{{
                            JSON.parse(eventsetting).press_url_label }}</label>
                        <textarea rows="2" name="press_url" id="press_url"
                            class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600 resize-y"
                            :title="JSON.parse(eventsetting).press_url_placeholder" :placeholder="JSON.parse(eventsetting).press_url_placeholder
                                " :value="form.press_url" @input="
                                updateForm('press_url', $event.target.value);
                            clearErrors('press_url');
                            "></textarea>
                        <Error v-if="submitted" fieldName="press_url" :validationErros="validationErros" />
                    </div>
                    <div class="relative z-0 w-full group"></div>
                    <div class="relative z-0 w-full group flex flex-col">
                        <label for="video_url" class="text-base md:text-base lg:text-lg font-bold">{{
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
                        <label for="" class="text-base md:text-base lg:text-lg  font-bold  truncate">{{ JSON.parse(event_detail)["main_event_image_label"] || 'Main Event Image' }} <span
                                class="ml-1 font-normal  text-[0.8em] text-gray-600">{{ JSON.parse(event_detail)["main_event_image_hint"] || '(PNG, GIF, JPG, or JPEG format · 30 MB max)' }}</span><span class="text-red-500">*</span></label>
                        <div class="relative z-0 w-full mb-6 group">
                            <template v-if="
                                current_user &&
                                JSON.parse(current_user)?.registration_package?.package_type == 'featured'
                            ">
                                <FilePond
                                    :label-idle="labelIdleGallery"
                                    class="cursor-pointer" name="gallery_image" ref="gallery_image" class-name="my-pond"
                                    credits="false" accepted-file-types="image/*" allow-multiple="true"
                                    @init="handleGalleryImagesInit" @processfile="handleGalleryImagesProcess"
                                    @removefile="handleGalleryImagesRemoveFile" v-bind:files="gallery_files"
                                    @addfile="clearErrors('gallery_images')" />
                            </template>
                            <template v-else>
                                <FilePond
                                    :label-idle="labelIdleGallery"
                                    class="cursor-pointer" name="gallery_image" ref="gallery_image" class-name="my-pond"
                                    credits="false" accepted-file-types="image/*" @init="handleGalleryImagesInit"
                                    @processfile="handleGalleryImagesProcess"
                                    @removefile="handleGalleryImagesRemoveFile" v-bind:files="gallery_files"
                                    @addfile="clearErrors('gallery_images')" />
                            </template>
                        </div>
                        <Error fieldName="gallery_images" :validationErros="validationErros" />
                    </div>


                    <!-- CTA Button Field - Only show for Premium and Featured packages -->
                    <div class="relative z-0 w-full group">
                        <label for="cta_btn" class="text-base md:text-base lg:text-lg font-bold "
                            v-html="ctaBtnLabelFormatted"></label>
                        <input type="text" name="cta_btn" id="cta_btn"
                            class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                            placeholder="'The button text that guides the user\'s next action; e.g., Learn More.'"
                            :value="form.cta_btn"
                            @input="updateForm('cta_btn', $event.target.value); clearErrors('cta_btn');" />
                        <Error v-if="submitted" fieldName="cta_btn" :validationErros="validationErros" />
                    </div>

                    <!-- CTA Link Field - Only show for Premium and Featured packages -->
                    <div class="relative z-0 w-full group">
                        <label for="cta_link" class="text-base md:text-base lg:text-lg font-bold ">
                            CTA URL
                        </label>
                        <input type="text" name="cta_link" id="cta_link"
                            class="can-exp-input w-full block border border-gray-300 rounded focus:border-blue-600"
                            placeholder="See explanation in the footnotes below" :value="form.cta_link"
                            @input="updateForm('cta_link', $event.target.value); clearErrors('cta_link');" />
                        <Error v-if="submitted" fieldName="cta_link" :validationErros="validationErros" />
                    </div>
                </div>
                <div
                    class="px-4 my-6 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-primary to-secondary rounded-md">
                    <h4 class="text-center card-heading text-white">
                        {{ JSON.parse(event_detail)["media_section_heading"] ?? 'Step 4 of 4 - Social Media (Optional)'
                        }}
                    </h4>
                </div>
                <div class="grid md:grid-cols-2 md:gap-6 gap-4">
                    <div class="relative z-0 w-full group">
                        <label for="facebook_url" class="text-base md:text-base lg:text-lg font-bold">{{
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
                        <label for="twitter_url" class="text-base md:text-base lg:text-lg font-bold">{{
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
                        <label for="linkedin_url" class="text-base md:text-base lg:text-lg font-bold">{{
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
                        <label for="youtube_url" class="text-base md:text-base lg:text-lg font-bold">{{
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
                        <label for="pintrest_url" class="text-base md:text-base lg:text-lg font-bold">{{
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
                        <label for="instagram_url" class="text-base md:text-base lg:text-lg font-bold">{{
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
                        <label for="snapchat_url" class="text-base md:text-base lg:text-lg font-bold">{{
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

                <!-- Step 5 of 5: Photo Gallery (Premium 8 / Featured 20 images, max 10 MB each) -->
                <div v-if="showPhotoGallery" class="mt-6">
                    <div
                        class="px-4 my-6 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-primary to-secondary rounded-md">
                        <h4 class="text-center card-heading text-white">
                            {{ JSON.parse(event_detail)["photo_gallery_heading"] || 'Photo Gallery' }}
                        </h4>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-6 bg-white shadow-sm">
                        <label for="photo_gallery_images"
                            class="text-base md:text-base lg:text-lg block mb-2 font-bold"  id="photo_gallery_images">
                            {{ JSON.parse(event_detail)["photo_gallery_label"] || 'Photo Gallery' }} <span class="text-[0.85em] font-normal" v-if="photoGallerySectionSubtitle">{{ photoGallerySectionSubtitle }}</span>
                        </label>
                        <div class="relative z-0 w-full mb-6 group">
                            <FilePond name="photo_gallery_image" :ref="el => { if (el) photoGalleryPond = el }"
                                class-name="my-pond"
                                :label-idle="labelIdleGallery"
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
            </div>
        </div>
        <div class="mt-8 flex">
            <div class="">
                <Error v-if="submitted" fieldName="captcha" :validationErros="validationErros" full_width="1" />
            </div>
        </div>
        <!-- <ListErrors :validationErrors="validationErros1" /> -->

        <div class="mb-4" v-if="!event_id">
            <div class="flex items-start pb-4">
                <input id="agree" type="checkbox" :checked="!!form.is_agree"
                    class="h-4 w-4 mt-1 rounded border-gray-500 text-primary focus:ring-primary" @input="
                        updateForm('is_agree', $event.target.checked);
                    clearErrors('is_agree');
                    " />
                <label for="agree" class="ml-2 text-gray-900 text-base md:text-base lg:text-lg text-left" v-html="JSON.parse(eventsetting)
                    ? JSON.parse(eventsetting)
                        .terms_and_conditions_label
                    : ''
                    "></label>
            </div>
            <Error v-if="submitted" fieldName="is_agree" :validationErros="validationErros" />
        </div>

        <div class="flex justify-center">
            <button v-if="!event_id" aria-label="Candian Exporters" type="submit" :disabled="!form.is_agree" :class="[
                'inline-flex items-center button-exp-fill mt-4 transition-opacity duration-200',
                { 'opacity-40 cursor-not-allowed': !form.is_agree }
            ]">
                {{ JSON.parse(event_detail)["button_text"] }}
            </button>
            <button v-else aria-label="Candian Exporters" type="submit"  :class="[
                'inline-flex items-center button-exp-fill mt-4 transition-opacity duration-200',
               
            ]">
                {{ JSON.parse(event_detail)["update_btn_text"] || 'Update' }}
            </button>
        </div>

        <div class="rounded-md p-3 mt-6 shadow bg-white">
            <div class="flex items-center gap-2">

                <svg height="18" width="18" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 392.517 392.517" xml:space="preserve">
                    <path style="fill:#56ACE0;" d="M353.834,84.962c-0.065-6.012-4.784-11.184-11.507-11.184c0.388,0,0.776,0,0,0
                                c-69.495,1.487-116.752-30.707-138.861-49.002c-4.202-3.491-10.343-3.491-14.545,0c-22.626,18.747-71.37,50.618-138.473,49.002l0,0
                                c-7.176,0.517-11.313,4.202-11.83,11.184c0.065,72.275,15.321,244.622,154.699,284.897c1.875,0.517,3.943,0.517,5.818,0
                                C338.578,329.584,353.77,157.172,353.834,84.962z" />
                    <path style="fill:#194F82;"
                        d="M341.422,51.41c-59.992,1.487-103.37-27.022-123.733-43.895c-12.154-10.02-30.966-10.02-43.055,0
                                C154.4,24.388,111.022,52.962,51.03,51.41h-0.84c-19.717,0.323-33.293,15.127-33.875,33.552
                                c0,77.382,16.873,261.883,170.796,306.295c6.723,1.681,12.8,1.681,18.166,0c153.988-44.412,170.861-228.978,170.925-306.295
                                C376.202,66.99,361.915,51.087,341.422,51.41z M193.382,369.859C53.875,329.584,38.683,157.172,38.618,84.962
                                c0.517-7.046,4.655-10.602,11.83-11.184l0,0c67.103,1.552,115.846-30.19,138.473-49.002c4.202-3.491,10.343-3.491,14.545,0
                                c22.174,18.295,69.495,50.489,138.861,49.002c0.776,0,0.388,0,0,0c6.723,0,11.442,5.172,11.507,11.184
                                c-0.065,72.275-15.321,244.622-154.699,284.897C197.261,370.376,195.127,370.376,193.382,369.859z" />
                    <path style="fill:#FFC10D;"
                        d="M185.042,186.327V80.372c-29.737,18.683-61.737,30.707-95.224,35.556
                                c-5.883,0.84-10.02,6.206-9.503,12.154c1.939,20.493,5.107,40.016,9.568,58.182h95.095v0.065H185.042z" />
                    <g>
                        <path style="fill:#FFFFFF;"
                            d="M185.042,319.952V208.566H96.154C113.996,264.291,143.863,301.592,185.042,319.952z" />
                        <path style="fill:#FFFFFF;"
                            d="M302.958,115.992c-33.616-4.848-65.681-16.873-95.612-35.62v105.891h95.677
                                    c4.396-18.23,7.564-37.689,9.374-58.182C312.913,122.198,308.84,116.832,302.958,115.992z" />
                    </g>
                    <path style="fill:#FFC10D;" d="M207.345,208.566v111.451c41.632-18.36,71.693-55.79,89.471-111.451L207.345,208.566L207.345,208.566
                                z" />
                    <g>
                        <path style="fill:#194F82;"
                            d="M342.327,73.713L342.327,73.713C341.164,73.713,341.81,73.713,342.327,73.713z" />
                        <path style="fill:#194F82;"
                            d="M306.125,93.883c-32.194-4.719-62.966-16.614-91.475-35.362c-10.99-7.24-25.859-7.24-36.848,0
                                    c-28.444,18.747-59.087,30.707-91.152,35.297c-17.648,2.651-30.125,18.554-28.444,36.331
                                    c6.012,64.129,30.384,177.131,125.931,213.527c7.628,2.844,15.774,2.715,24.242,0c96.517-36.655,120.566-149.592,126.255-213.657
                                    C336.25,112.372,323.709,96.469,306.125,93.883z M185.042,319.952c-47.192-21.01-74.02-64.388-88.954-111.127h88.954V319.952z
                                    M185.042,186.457h-95.16c-4.784-19.846-7.822-39.822-9.503-58.44c-0.517-5.947,3.62-11.313,9.503-12.154
                                    c33.487-4.913,65.422-17.002,95.224-35.685v106.279H185.042z M207.345,320.016V208.824h89.535
                                    C282.012,255.564,255.119,299.006,207.345,320.016z M303.087,186.457h-95.741V80.307c29.802,18.747,61.996,30.836,95.612,35.685
                                    c5.883,0.84,10.02,6.206,9.503,12.024C310.715,146.699,307.871,166.61,303.087,186.457z" />
                    </g>
                </svg>
                <p style="color: #3498db; font-family: 'Futura BdCn BT';"><span style="font-size: 18pt;">{{ JSON.parse(event_detail)["privacy_heading"] || 'Protecting your privacy is fundamental to our mission and business:' }}</span></p>

            </div>
            <div class="mt-2 can-exp-p">
                <ul>
                    <li>
                        <p>{{ JSON.parse(event_detail)["privacy_bullet_1"] || 'We never sell your data or information' }}</p>
                    </li>
                    <li>
                        <p>{{ JSON.parse(event_detail)["privacy_bullet_2"] || 'We do not own the content that you upload on our website' }}</p>
                    </li>
                    <li>
                        <p>{{ JSON.parse(event_detail)["privacy_bullet_3"] || 'We never send you junk e-mail' }}</p>
                    </li>
                </ul>
            </div>
        </div>
        <!-- sdkfksflsdf;lsdal;fk -->
        <div class="rounded-md p-3 my-4  shadow bg-white" v-html="JSON.parse(eventsetting)
            ? JSON.parse(eventsetting)['post_submit_button_text']
            : ''
            "></div>

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
    </form>
</template>

<script>
import { load } from "recaptcha-v3";
import helper from "../../helper";

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
import { VueDatePicker } from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
export default {
    computed: {
        labelIdleGallery() {
            return "<span class='cursor-pointer'>" + "Drag & Drop your files or" + " <span class='filepond--label-action'>" + "Browse" + "</span></span>";
        },
        ...mapState({
            form: (state) => state.signup.form,
            regPageSetting: (state) => state.signup.regPageSetting,
            validationErros: (state) => state.signup.validationErros,
            package_type: (state) => state.signup.package_type, // Added package_type from Vuex
        }),


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
        ctaBtnLabelFormatted() {
            const rawLabel =
                this.regPageSetting?.reg_page_setting_detail?.[0]?.step_4_cta_btn_label || "";
            console.log("Raw Label:", this.regPageSetting);

            if (!rawLabel) {
                return "CTA (Call-to-Action) Button Title(Max. 5 words)";
            }

            return rawLabel.replace(/\(5\)/g, '<sup class="footnote-indicator">(5)</sup>');
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
        showPhotoGallery() {
            return this.effectivePackageType === 'premium' || this.effectivePackageType === 'featured';
        },
        downgradeTooltipText() {
            return "Membership downgrades cannot be processed automatically. Please contact us to adjust your plan.";
        },
        photoGallerySectionSubtitle() {
            try {
                const detail = JSON.parse(this.event_detail || '{}');
                if (this.effectivePackageType === 'featured') {
                    return detail.photo_gallery_subtitle_featured || '(Upload up to 20 images. Max 10 MB each. Supports PNG, GIF, or JPG)';
                }
                if (this.effectivePackageType === 'premium') {
                    return detail.photo_gallery_subtitle_premium || '(Upload up to 8 images. Max 10 MB each. Supports PNG, GIF, or JPG)';
                }
            } catch (_) {}
            return '';
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
        "event_id",
        "event_slug",
        "current_user",
    ],
    components: {
        FilePond,
        Error,
        VueDatePicker,
        // ListErrors,
    },
    data() {
        return {
            gallery_files: [],
            photo_gallery_files: [],
            photoGalleryPond: null,
            contacts: [],
            activeTab: null,
            stripe: null,
            elements: null,
            cardElement: null,
            display_password: "password",
            display_confirm_password: "password",
            isEditMode: false,
            isLoggedIn: false,
            form: {
                page_id: this.page_id,
                create_page_id: this.create_page_id,
                card_holder_name: null,
                name: "",
                business_name: "",
                email: "",
                password: "",
                password_confirmation: "",
                job_title: null,
                organizer_website: null,
                organizer_phone: null,
                mailing_address: null,
                package_id: "",
                order_amount: 0,
                payment_method: "stripe",
                package_type: null,
                payment_frequency: "annually",
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
                cta_btn: null,
                cta_link: null,
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
                is_agree: false,
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
            popupImage: null,
            dateErrors: {
                start_date: "",
                end_date: "",
            },
            showDowngradeMessage: false,
            initialEventPackageType: null,
            contactPhotoTooltipIndex: null,
        };
    },
    mounted() {
        //  console.log("------------>",JSON.parse(this.eventsetting)['post_submit_button_text']);
        // Only load form data from localStorage if not in edit mode
        if (!this.isEditMode) {
            const savedForm = localStorage.getItem("event_signup_form");
            if (savedForm) {
                const parsedForm = JSON.parse(savedForm);
                this.form = {
                    ...this.form,
                    ...parsedForm,
                    is_agree: !!parsedForm.is_agree,
                };
            }
        }

        // Fix datepicker popup z-index issue
        this.fixVueDatePickerZIndex();
        document.addEventListener('click', this.closeContactPhotoTooltip);
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
                if (typeof newLanguages === "string") {
                    try {
                        newLanguages = JSON.parse(newLanguages);
                    } catch (error) {
                        console.error("Error parsing JSON:", error);
                        return;
                    }
                }

                if (!Array.isArray(newLanguages)) {
                    console.log("Not an array, returning...");
                    return;
                }

                let obj = {};
                newLanguages.forEach((res) => {
                    obj["title_" + res.id] = "";
                });

                this.form.title = obj;
            },
            immediate: true // Run the handler immediately if `languages` is already available
        }
    },
    methods: {
        fixVueDatePickerZIndex() {
            // Function to apply z-index fix to datepicker popup
            const applyFix = () => {
                const menus = document.querySelectorAll('.dp__outer_menu_wrap, .dp__menu, .dp__menu_transitioned');
                menus.forEach((menu) => {
                    if (menu) {
                        // Only set z-index, don't override position
                        menu.style.setProperty('z-index', '99999', 'important');
                    }
                });
            };

            // Use MutationObserver to watch for datepicker popup being added to DOM
            this.datePickerObserver = new MutationObserver(() => {
                applyFix();
            });

            // Start observing the document body for changes
            this.datePickerObserver.observe(document.body, {
                childList: true,
                subtree: true,
                attributes: true,
                attributeFilter: ['style', 'class']
            });

            // Also set it immediately if popup already exists
            this.$nextTick(() => {
                applyFix();
            });
        },
        showImagePopup(imageUrl) {
            this.popupImage = imageUrl;
        },
        toggleContactPhotoTooltip(index) {
            this.contactPhotoTooltipIndex = this.contactPhotoTooltipIndex === index ? null : index;
        },
        closeContactPhotoTooltip() {
            this.contactPhotoTooltipIndex = null;
        },
        checkDateLength(field, event) {
            let value = event.target.value;

            // Check if the value is in the correct format (YYYY-MM-DD)
            let dateParts = value.split("-");
            // console.log(dateParts);
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

            this.validateAndUpdateDate(field, event);

            this.$store.commit("events/clearValidationError", field);
        },
        validateAndUpdateDate(field, event) {
            const value = event.target.value;

            if (!value) {
                if (this.dateErrors[field] !== undefined) {
                    this.dateErrors[field] = "";
                }
                this.updateForm(field, null);
                return;
            }

            const [yearStr, monthStr, dayStr] = value.split("-");
            const year = Number(yearStr);
            const month = Number(monthStr);
            const day = Number(dayStr);
            const currentYear = new Date().getFullYear();
            const maxYear = currentYear + 5;

            let isValid = true;

            if (
                !Number.isInteger(year) ||
                !Number.isInteger(month) ||
                !Number.isInteger(day)
            ) {
                isValid = false;
            }

            if (isValid && (month < 1 || month > 12)) {
                isValid = false;
            }

            if (isValid && year > maxYear) {
                isValid = false;
            }

            if (isValid) {
                const maxDay = new Date(year, month, 0).getDate();
                if (day < 1 || day > maxDay) {
                    isValid = false;
                }
            }

            if (!isValid) {
                const message = "Please select a valid date";
                if (
                    typeof helper !== "undefined" &&
                    helper &&
                    typeof helper.swalErrorMessageForWeb === "function"
                ) {
                    helper.swalErrorMessageForWeb(message);
                } else if (
                    typeof window !== "undefined" &&
                    window.helper &&
                    typeof window.helper.swalErrorMessageForWeb === "function"
                ) {
                    window.helper.swalErrorMessageForWeb(message);
                }
                if (this.dateErrors[field] !== undefined) {
                    this.dateErrors[field] = message;
                }
                this.validationErros.set(field, message);
                event.target.value = "";
                this.updateForm(field, null);
                return;
            }

            if (this.dateErrors[field] !== undefined) {
                this.dateErrors[field] = "";
            }
            this.validationErros.clear(field);
            this.updateForm(field, value);
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
        formatFeatureName(name) {
            if (!name) {
                return "";
            }
            return String(name).replace(/\((\d+)\)/g, '<sup class="footnote-indicator">($1)</sup>');
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
                // designation: null,
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
            if (field === "name") value = value.replace(/[^a-zA-Z\s-]/g, '');

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
            if (this.dateErrors[fieldName] !== undefined) {
                this.dateErrors[fieldName] = "";
            }
            if (this.submitted) {
                this.validationErros.clear(fieldName);
            }
        },
        clearForm() {
            this.form["name"] = "";
            this.form["business_name"] = "";
            this.form["email"] = "";
            this.form["password"] = "";
            this.form["password_confirmation"] = "";
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
            this.form.contacts = this.contacts;
            this.loading = 1;

            // When using Stripe, create PaymentMethod on frontend and send id only
            let payload = { ...this.form };

            // Map package_id to registration_package_id for process-payment endpoint
            if (payload.package_id && !payload.registration_package_id) {
                payload.registration_package_id = payload.package_id;
            }

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

            // Determine if we're editing or creating
            let requestMethod = 'post';
            let requestUrl = this.submit_url;

            if (this.isEditMode && this.event_id) {
                // For edit mode, use the edit endpoint
                requestMethod = 'post';
                requestUrl = `${process.env.MIX_WEB_API_URL}process-payment/${this.event_id}`;
                payload.event_id = this.event_id;
            }

            axios[requestMethod](requestUrl, payload)
                .then((res) => {
                    this.loading = 0;
                    if (res.data.status == "Success") {
                        if (res?.data?.data?.type == "paypal") {
                            window.location.href =
                                res?.data?.data?.redirect_url;
                        } else {
                            if (!this.isEditMode) {
                                this.clearForm();
                            }
                            window.location.href = res.data.data.redirect_url;
                        }
                    } else {
                        helper.swalErrorMessageForWeb(res.data.message || "An error occurred. Please try again.");
                    }
                })
                .catch((error) => {
                    this.loading = 0;
                    this.validationErros = new ErrorHandling();
                    if (error.response && error.response.status == 422) {
                        this.validationErros.record(error.response.data.errors);
                        this.$nextTick(() => {
                            this.focusOnFirstErrorInput(error.response.data.errors);
                        });
                    } else if (
                        error.response &&
                        error.response.data &&
                        error.response.data.status == "Error"
                    ) {
                        helper.swalErrorMessageForWeb(
                            error.response.data.message || "An error occurred. Please try again."
                        );
                    }
                });
        },
        
        focusOnFirstErrorInput(errors) {
            const errorKeys = new Set(Object.keys(errors));

            // Find the first error element in document order (scrolls to error tooltip)
            const allErrorElements = Array.from(document.querySelectorAll('[data-error-field]'))
                .filter((el) => errorKeys.has(el.getAttribute('data-error-field')));
            const firstErrorEl = allErrorElements[0];

            if (firstErrorEl) {
                firstErrorEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                // Focus the associated input/textarea for better UX
                const input = firstErrorEl.closest('.group')?.querySelector('input, textarea, select');
                if (input) {
                    input.focus();
                }
                return;
            }

            // Fallback: find input by error key (for fields without Error wrapper in view)
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
                if (el) {
                    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
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
            return 1;
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

            // Remount Stripe card element when switching to Stripe
            if (value === 'stripe' && this.cardElement && this.$refs.stripeCard) {
                await this.$nextTick();
                try {
                    // Unmount existing element
                    this.cardElement.unmount();
                    // Remount in the container
                    this.cardElement.mount(this.$refs.stripeCard);
                } catch (e) {
                    console.error('Error remounting Stripe element:', e);
                    // If unmount fails, try mounting directly
                    this.cardElement.mount(this.$refs.stripeCard);
                }
            }
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
        checkPassword() {
            if (this.form.password != this.form.password_confirmation) {
                axios
                    .get(
                        `${process.env.MIX_WEB_API_URL}get-password-miss-match-error`
                    )
                    .then((res) => {
                        if (res.data.status == "Error") {
                            this.validationErros.record({
                                password_confirmation: [res.data.message],
                            });
                        }
                    });
            } else {
                this.validationErros.clear("password_confirmation");
            }
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
            if (!event_package) {
                return;
            }
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
        fetchEvent(id) {
            axios
                .get(
                    `${process.env.MIX_WEB_API_URL}events/${id}?withEventDetail=1&withEventContacts=1&withMedia=1`
                )
                .then((res) => {
                    if (res.data.status == "Success") {
                        const event = res.data.data;

                        // Populate basic event fields
                        this.updateForm("zipcode", event.zipcode);
                        this.updateForm("start_date", event.start_date);
                        this.updateForm("end_date", event.end_date);
                        this.updateForm("event_website", event.event_website);
                        this.updateForm("exibitors_url", event.exibitors_url);
                        this.updateForm("visitors_url", event.visitors_url);
                        this.updateForm("press_url", event.press_url);
                        this.updateForm("video_url", event.video_url);
                        this.updateForm("cta_btn", event.cta_btn);
                        this.updateForm("cta_link", event.cta_link);
                        this.updateForm("facebook_url", event.facebook_url);
                        this.updateForm("twitter_url", event.twitter_url);
                        this.updateForm("linkedin_url", event.linkedin_url);
                        this.updateForm("youtube_url", event.youtube_url);
                        this.updateForm("pintrest_url", event.pintrest_url);
                        this.updateForm("instagram_url", event.instagram_url);
                        this.updateForm("snapchat_url", event.snapchat_url);

                        // Populate event details (multilingual)
                        let eventDetails = event.event_detail;
                        if (eventDetails && eventDetails.length > 0) {
                            let title = {};
                            let country = {};
                            let city = {};
                            let street_name = {};
                            let venue = {};
                            let product_search = {};
                            let short_description = {};
                            let description = {};

                            eventDetails.forEach((detail) => {
                                title[`title_${detail.language_id}`] = detail.title;
                                country[`country_${detail.language_id}`] = detail.country;
                                city[`city_${detail.language_id}`] = detail.city;
                                street_name[`street_name_${detail.language_id}`] = detail.street_name;
                                venue[`venue_${detail.language_id}`] = detail.venue;
                                product_search[`product_search_${detail.language_id}`] = detail.product_search;
                                short_description[`short_description_${detail.language_id}`] = detail.short_description;
                                description[`description_${detail.language_id}`] = detail.description;
                            });

                            this.form.title = title;
                            this.form.country = country;
                            this.form.city = city;
                            this.form.street_name = street_name;
                            this.form.venue = venue;
                            this.form.product_search = product_search;
                            this.form.short_description = short_description;
                            this.form.description = description;

                            console.log("this.form", this.form);

                        }

                        // Populate contacts
                        if (event.event_contacts && event.event_contacts.length > 0) {
                            this.contacts = event.event_contacts.map(contact => ({
                                id: contact.id,
                                name: contact.name,
                                email: contact.email,
                                phone: contact.phone,
                                image_path: contact.image_path,
                            }));
                        }

                        // Populate main gallery and photo gallery (by type); use base64/full_path so FilePond shows images (reference: Media.vue)
                        if (event.event_media && event.event_media.length > 0) {
                            let galleryImages = [];
                            this.gallery_files = [];
                            let photoGalleryImages = [];
                            this.photo_gallery_files = [];

                            event.event_media.forEach((media) => {
                                if (!media.media) return;
                                const type = media.type || 'main';
                                const imageSource = media.media.base64 || media.media.full_path;
                                const path = media.media.path;
                                const fileOpt = {
                                    source: imageSource || path,
                                    options: {
                                        type: 'local',
                                        metadata: {
                                            serverId: path,
                                            poster: imageSource || undefined,
                                        },
                                    },
                                };
                                if (type === 'gallery') {
                                    photoGalleryImages.push(path);
                                    this.photo_gallery_files.push(fileOpt);
                                } else {
                                    galleryImages.push(path);
                                    this.gallery_files.push(fileOpt);
                                }
                            });

                            this.form.gallery_images = JSON.stringify(galleryImages);
                            this.form.photo_gallery_images = JSON.stringify(photoGalleryImages);
                        }

                        // If customer exists, populate user info
                        if (event.customer) {
                            this.form.name = event.customer.name;
                            this.form.business_name = event.customer.business_name;
                            this.form.email = event.customer.email;
                        }

                        // Event package: used for upgrade-only (no downgrade) when editing
                        const eventPackageType = event.package_type || event.registration_package?.package_type;
                        if (eventPackageType) {
                            this.initialEventPackageType = eventPackageType;
                            this.updateForm("package_type", eventPackageType);
                        }
                        if (event.package_id != null) {
                            this.updateForm("package_id", event.package_id);
                        }
                        if (event.registration_package?.id != null) {
                            this.updateForm("package_id", event.registration_package.id);
                        }
                    }
                })
                .catch((error) => {
                    console.error("Error fetching event:", error);
                });
        },
        handleOrganizerPhoneInput(value) {
            // Only allow digits and plus sign; plus only at start
            let clean = (value || '').replace(/[^0-9+]/g, '');
            const hasLeadingPlus = clean.startsWith('+');
            const digits = clean.replace(/\+/g, '');
            const digitsOnly = digits.length > 15 ? digits.substring(0, 15) : digits;
            this.form.organizer_phone = (hasLeadingPlus ? '+' : '') + digitsOnly;
            this.clearErrors('organizer_phone');
        },

        validateOrganizerPhoneKeypress(event) {
            const char = event.key;
            const input = event.target;
            const value = input.value || '';

            if (['Backspace', 'Delete', 'Tab', 'Escape', 'Enter', 'ArrowLeft', 'ArrowRight'].includes(event.key)) {
                return;
            }
            // Allow + only at the start
            if (char === '+') {
                if (value.length > 0) event.preventDefault();
                return;
            }
            // Allow only digits; block if already 15 digits
            if (/^[0-9]$/.test(char)) {
                const digitCount = value.replace(/[^0-9]/g, '').length;
                if (digitCount >= 15) event.preventDefault();
                return;
            }
            event.preventDefault();
        },

        handleContactPhoneInput(index, value) {
            // Remove any characters that aren't + or numbers
            let cleanValue = value.replace(/[^0-9+]/g, '');

            // Limit to 15 characters
            if (cleanValue.length > 15) {
                cleanValue = cleanValue.substring(0, 15);
            }

            // Update the contact
            this.updateContact(index, 'phone', cleanValue);
            this.clearErrors(`contacts.${index}.phone`);
        },

        validatePhoneKeypress(event) {
            const char = event.key;
            const input = event.target;
            const value = input.value || '';

            // Allow: backspace, delete, tab, escape, enter (navigation keys)
            if (
                event.key === 'Backspace' ||
                event.key === 'Delete' ||
                event.key === 'Tab' ||
                event.key === 'Escape' ||
                event.key === 'Enter' ||
                event.key === 'ArrowLeft' ||
                event.key === 'ArrowRight'
            ) {
                return;
            }

            // Check if already at 15 character limit
            if (value.length >= 15) {
                event.preventDefault();
                return;
            }

            // Allow + or numbers (0-9)
            if (char !== '+' && !/^[0-9]$/.test(char)) {
                event.preventDefault();
            }
        },
    },

    created() {
        // Check if we're in edit mode
        if (this.event_id && this.event_id !== 'null' && this.event_id !== '') {
            this.isEditMode = true;
            this.fetchEvent(this.event_id);
        }

        this.gallery_files = [];

        this.contacts = [];
        const savedContacts =
            JSON.parse(localStorage.getItem("eventContacts")) || [];
        if (savedContacts.length > 0 && !this.isEditMode) {
            this.contacts = savedContacts;
        } else if (!this.isEditMode) {
            this.addContact(1);
        }

        this.activeTab = JSON.parse(this.lang)["id"];
        this.form.payment_frequency = "annually";

        // Prefill from signed-in user when creating a new event
        try {
            if (this.current_user) {
                const user = JSON.parse(this.current_user);
                this.isLoggedIn = !!(user && user.id);
            }
            if (!this.isEditMode && this.current_user) {
                const user = JSON.parse(this.current_user);
                if (user) {
                    this.form.name = user.name || this.form.name;
                    this.form.email = user.email || this.form.email;
                    this.form.business_name = user.business_name || this.form.business_name;

                    // Prefill first contact if exists
                    if (this.contacts && this.contacts.length > 0) {
                        if (!this.contacts[0].name) this.contacts[0].name = user.name || this.contacts[0].name;
                        if (!this.contacts[0].email) this.contacts[0].email = user.email || this.contacts[0].email;
                    }
                }
            }
        } catch (e) {
            // ignore JSON parse errors silently
        }

        // Initialize Stripe Elements
        (async () => {
            try {
                this.stripe = await loadStripe(process.env.MIX_STRIPE_PUBLIC_KEY);
                if (this.stripe) {
                    this.elements = this.stripe.elements();
                    this.cardElement = this.elements.create('card');
                    this.$nextTick(() => {
                        const mountPoint = this.$refs.stripeCard;
                        if (mountPoint && this.cardElement) {
                            this.cardElement.mount(mountPoint);
                        }
                    });
                }
            } catch (e) {
                console.error('Failed to initialize Stripe:', e);
            }
        })();

        axios
            .get(
                `${process.env.MIX_APP_URL}/get-registration-packages?getPackagesOnly=1&withPackageFeatures=1&getEventPackagesOnly=1`
            )
            .then((res) => {
                if (res.data.status == "Success") {
                    this.packages = res.data.data;
                    console.log("Packages:", this.packages);
                    this.freePackage = res.data.data.find(
                        (p) => p.package_type == "free"
                    );
                    this.featuredPackage = res.data.data.find(
                        (p) => p.package_type == "featured"
                    );
                    this.premiumPackage = res.data.data.find(
                        (p) => p.package_type == "premium"
                    );

                    // Premium is always selected by default when not in edit mode
                    if (!this.isEditMode && this.premiumPackage) {
                        this.form.package_id = this.premiumPackage.id;
                        this.form.order_amount = this.premiumPackage.event_price;
                        this.form.package_type = "premium";
                    }
                }
            });
    },
    beforeUnmount() {
        document.removeEventListener('click', this.closeContactPhotoTooltip);
        // Clean up the MutationObserver when component is destroyed
        if (this.datePickerObserver) {
            this.datePickerObserver.disconnect();
            this.datePickerObserver = null;
        }
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
    color: #6b7280;
    font-weight: 400;
}
</style>

<style>
/* @vuepic/vue-datepicker popup z-index fix - needs to be global */
.dp__outer_menu_wrap {
    z-index: 99999 !important;
}

.dp__menu {
    z-index: 99999 !important;
}

.dp__menu_transitioned {
    z-index: 99999 !important;
}

/* Ensure popup is above all grid elements and form containers */
body>.dp__outer_menu_wrap {
    z-index: 99999 !important;
}
</style>
