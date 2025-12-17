<template>
    <form class="lg:w-full" @submit.prevent="recaptcha()">

        <div class="bg-white rounded-lg overflow-hidden shadow-3xl my-6 p-8">
            <h1 class="text-primary mb-2">{{ JSON.parse(coffee_wall_setting)["coffee_wall_heading"] ?? 'Coffee on Wall'
                }}</h1>
            <p class="">
                The <span class="font-bold">“The Coffee on the Wall”</span> initiative was inspired by this 
                <a href="https://www.kindspring.org/story/view.php?sid=44089" target="_blank" rel="noopener"
                    class="text-primary underline font-bold underline-none">
                    beautiful story.
                </a>
              
            </p>
            <p class="">
                It's a wonderful example of how a simple act of kindness can change </p>
             <p>the way someone sees the world.</p>

            <div class="text-right mt-4 py-2 text-red-500 text-lg">
                <span class="text-red-500">*</span> {{
                    JSON.parse(coffee_wall_setting)[
                    "coffee_on_wall_required_field"
                    ]
                    ?? ""
                }}
            </div>
            <div class="bg-white rounded-lg overflow-hidden shadow-3xl mb-6">
                <div
                    class="px-4 py-1.5 sm:px-6 text-left bg-gradient-to-r from-primary via-primary to-secondary rounded-t-md">
                    <h4 class="text-white">
                        <!-- Please select amount and frequency * -->
                        {{ JSON.parse(coffee_wall_setting)["select_amount_label"] ?? 'Please select your amount and frequency *' }}
                    </h4>
                </div>
                <div class="p-4">
                    <fieldset
                        class="flex items-center border w-full overflow-hidden bg-white rounded-md md:rounded-lg shadow-sm">
                        <div class="w-full">
                            <label
                                class="w-full block cursor-pointer px-5 py-5 rounded-l-md md:rounded-l-lg text-base md:text-2xl font-FuturaMdCnBT text-center border rounded-none"
                                :class="form.frequency == ''
                                    ? 'text-white bg-primary border-primary'
                                    : 'text-primary bg-white border-gray-300'
                                    ">
                                <input type="radio" name="frequency" value="" class="sr-only" v-model="form.frequency"
                                    @click="
                                        updateFrequency('')
                                        " />
                                <span>
                                    {{
                                        JSON.parse(coffee_wall_setting)[
                                        "one_time_label"
                                        ]
                                        ?? "One time"
                                    }}
                                </span>
                            </label>
                        </div>
                        <div class="w-full">
                            <label
                                class="cursor-pointer w-full block px-5 py-5 text-base md:text-2xl border text-center font-FuturaMdCnBT rounded-none"
                                :class="form.frequency == 'monthly'
                                    ? 'text-white bg-primary border-primary'
                                    : 'text-primary bg-white border-gray-300'
                                    ">
                                <input type="radio" name="frequency" value="monthly" class="sr-only"
                                    v-model="form.frequency" @click="
                                        updateFrequency('monthly')
                                        " />
                                <span>
                                    {{
                                        JSON.parse(coffee_wall_setting)[
                                        "monthly_label"
                                        ]
                                        ?? "Monthly"
                                    }}
                                </span>
                            </label>
                        </div>
                        <div class="w-full">
                            <label
                                class="cursor-pointer w-full block px-5 py-5 rounded-r-md md:rounded-r-lg border text-center text-base md:text-2xl font-FuturaMdCnBT rounded-none"
                                :class="form.frequency == 'quareterly'
                                    ? 'text-white bg-primary border-primary'
                                    : 'text-primary bg-white border-gray-300'
                                    ">
                                <input type="radio" name="frequency" value="quareterly" class="sr-only"
                                    v-model="form.frequency" @click="
                                        updateFrequency('quareterly')
                                        " />
                                <span>
                                    {{
                                        JSON.parse(coffee_wall_setting)[
                                        "quareterly_label"
                                        ]
                                        ?? "Quareterly"
                                    }}
                                </span>
                            </label>
                        </div>
                    </fieldset>
                    <div class="my-4 grid grid-cols-2 md:grid-cols-6 gap-4">
                        <div v-for="registration_package in packages" :key="registration_package.id">
                            <div class="bg-gray-50 rounded-md border shadow text-base md:text-2xl font-FuturaMdCnBT flex items-center justify-center h-12 hover:shadow-md border-gray-100 cursor-pointer peer-checked:border-green-500 peer-checked:border-2 peer-checked:text-green-500 hover:border-2 hover:border-green-500"
                                :class="form.package_id == registration_package.id
                                    ? 'border-2 border-green-500 text-green-500'
                                    : ''
                                    " @click.prevent="
                                        updatePackageForm(registration_package)
                                        ">
                                <!-- <div
                                    class="flex items-center lg:justify-between gap-x-4"
                                >
                                    <h3
                                        id="tier-startup"
                                        class="text-xl leading-8 text-blue-600"
                                    >
                                        {{
                                            registration_package
                                                ?.coffee_wall_package_detail?.[0]
                                                ?.name
                                        }}
                                    </h3>
                                    <p
                                        class="rounded-full bg-red-600/10 px-2.5 py-1 text-xs font-semibold leading-5 text-red-600"
                                        v-if="registration_package?.is_default == '1'"
                                    >
                                        Most popular
                                    </p>
                                </div> -->
                                <p class="mt-4 text-sm leading-6 text-gray-600">
                                    {{
                                        registration_package
                                            ?.coffee_wall_package_detail?.[0]
                                            ?.short_description
                                    }}
                                </p>
                                <span>
                                    ${{ registration_package?.price }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <Error v-if="submitted" fieldName="package_id" :validationErros="validationErros" full_width="1" />
                    <div class="relative flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="absolute left-2 h-7 text-gray-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z">
                            </path>
                        </svg>
                        <input type="text" id="custom_amount" v-model="form.custom_amount"
                            @keypress="restrictToPositiveIntegers" @input="clearPackageSelection"
                            class="block mt-1 border-2 p-2.5 w-full rounded border-gray-200 focus:outline-none focus:border focus:border-blue-600 pl-10 h-12"
                            :placeholder="JSON.parse(coffee_wall_setting)['own_amount_label'] ?? 'Enter your amount'" />
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg overflow-hidden shadow-3xl my-6">
                <div
                    class="px-4 py-1.5 sm:px-6 text-left bg-gradient-to-r from-primary via-primary to-secondary rounded-t-md">
                    <h4 class="text-white">
                        {{ JSON.parse(coffee_wall_setting)["beneficiary_head_text"] ?? 'Beneficiary *' }}
                    </h4>
                </div>
                <div class="p-4">
                    <div class="my-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div v-for="beneficiary in beneficiaries" :key="beneficiary.id">
                            <div class="bg-gray-50 rounded-md border shadow text-base md:text-lg font-FuturaMdCnBT flex items-center justify-center h-12 hover:shadow-md border-gray-100 cursor-pointer hover:border-2 hover:border-green-500"
                                :class="isBeneficiarySelected(beneficiary.id)
                                    ? 'border-2 border-green-500 text-green-500'
                                    : ''
                                    " @click.prevent="
                                        toggleBeneficiary(beneficiary)
                                        ">
                                <span>
                                    {{ beneficiary.name }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <Error v-if="submitted" fieldName="beneficiary_ids" :validationErros="validationErros"
                        full_width="1" />
                </div>
            </div>
            <div class="bg-white rounded-lg overflow-hidden shadow-3xl my-6">
                <div
                    class="px-4 py-1.5 sm:px-6 text-left bg-gradient-to-r from-primary via-primary to-secondary rounded-t-md">
                    <h4 class="text-white">
                        {{ JSON.parse(coffee_wall_setting)["contact_info_head_text"] ?? 'Your conact information' }}
                    </h4>
                </div>
                <div class="flex items-center space-x-1 relative w-full px-4 pt-4 gap-1">
                    <input @input="clearErrors('anonymous')" type="checkbox" class="" placeholder="" name="anonymous"
                        id="anonymous" v-model="form.anonymous" />
                    <label class="block text-gray-900 text-base md:text-base lg:text-lg ml-2 fong-semibold font-bold"
                        for="anonymous">{{
                            JSON.parse(coffee_wall_setting)["anonymous_label"] ?? 'Make donation anonymous' }}
                    </label>
                    <Error v-if="submitted" fieldName="anonymous" :validationErros="validationErros" full_width="1" />
                </div>
                <div v-if="!form.anonymous" class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="relative w-full">
                            <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="name">{{
                                JSON.parse(coffee_wall_setting)["name_label"] ?? 'Your name' }}
                                <span class="text-red-500">*</span>
                            </label>
                            <input @input="clearErrors('name')" type="text" class="can-exp-input" placeholder=""
                                name="name" id="name" v-model="form.name" />
                            <Error v-if="submitted" fieldName="name" :validationErros="validationErros"
                                full_width="1" />
                        </div>
                        <div class="relative w-full">
                            <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg"
                                for="business-name">{{
                                    JSON.parse(coffee_wall_setting)["email_label"] ?? 'Your email'
                                }}
                                <span class="text-red-500">*</span></label>
                            <input @input="clearErrors('business-name')" type="text" class="can-exp-input"
                                placeholder="" name="business-name" id="business-name" v-model="form.email" />
                            <Error v-if="submitted" fieldName="email" :validationErros="validationErros"
                                full_width="1" />
                        </div>
                    </div>
                    <div class="relative w-full">
                        <label class="block text-gray-900 mb-2 text-base md:text-base lg:text-lg" for="phone">{{
                            JSON.parse(coffee_wall_setting)["phone_label"] ?? "Your Phone Number (Optional - We won't call or text unless you ask us to)" }}
                        </label>
                        <input @input="clearErrors('phone')" type="phone" class="can-exp-input" placeholder=""
                            name="phone" id="phone" v-model="form.phone" />
                        <Error v-if="submitted" fieldName="phone" :validationErros="validationErros" full_width="1" />
                    </div>
                    <div class="flex items-start gap-2 relative w-full pt-4">
                        <input @input="clearErrors('notify_when_used')" type="checkbox" name="notify_when_used"
                            id="notify_when_used" v-model="form.notify_when_used" class="mt-1" />

                        <label for="notify_when_used"
                            class="text-gray-900 text-base md:text-base lg:text-lg font-bold inline-flex items-center gap-1">
                            Let me know when my Coffee helps a business

                            <!-- Info icon -->
                            <span class="relative inline-flex items-center group">
                                <span
                                    class="flex items-center justify-center w-4 h-4 text-xs font-bold text-white bg-gray-500 rounded-full cursor-pointer">
                                    !
                                </span>

                                <!-- Tooltip -->
                                <span class="absolute left-1/2 -translate-x-1/2 bottom-full mb-2 
                                            w-72 text-sm text-white bg-gray-800 rounded-md px-3 py-2
                                            opacity-0 group-hover:opacity-100 transition
                                            pointer-events-none z-50 whitespace-normal">
                                    You’ll receive basic information about the buseiness. Some details are shared only if
                                    the business chooses to make them public.
                                </span>
                            </span>
                        </label>


                        <Error v-if="submitted" fieldName="notify_when_used" :validationErros="validationErros"
                            full_width="1" />
                    </div>

                </div>
            </div>
            <div class="bg-white rounded-lg overflow-hidden shadow-3xl my-6">
                <div
                    class="px-4 py-1.5 sm:px-6 text-left bg-gradient-to-r from-primary via-primary to-secondary rounded-t-md">
                    <h4 class="text-white">
                        {{ payment_setting && JSON.parse(payment_setting) ?
                            (JSON.parse(payment_setting)["select_payment_method"] ?? 'Select Payment Method *') : 'Select Payment Method *' }}
                    </h4>
                </div>
                <div class="p-4">
                    <div class="w-full">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex flex-col space-y-3 mt-2" v-if="form.order_amount > 0">
                                <div class="flex space-x-4">
                                    <div class="flex items-center">
                                        <input id="stripe" value="stripe" name="payment-method" type="radio"
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
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="flex items-center">
                                        <input id="paypal" value="paypal" name="payment-method" type="radio"
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
                                                        fill="#1E6196" data-v-470ebd7e=""></path>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_6_187">
                                                        <rect width="156.3" height="43.5" fill="white" />
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                        </label>
                                    </div>
                                </div>
                                <div class="border border-primary rounded p-2 mb-2" v-if="
                                    form.order_amount > 0 &&
                                    form.payment_method == 'stripe'
                                ">
                                    <div class="flex justify-center items-center">
                                        <div class="h-auto bg-white p-3 rounded-lg w-full">
                                            <!-- Cardholder Name -->
                                            <div class="input_text relative mb-4">
                                                <label class="block mb-2 text-sm font-medium">{{
                                                    payment_setting &&
                                                        JSON.parse(payment_setting)
                                                        ? JSON.parse(payment_setting)[
                                                        "cardholder_name_label"
                                                        ]
                                                        : "Cardholder Name"
                                                }}
                                                </label>
                                                <input type="text" class="can-exp-input" :placeholder="payment_setting &&
                                                    JSON.parse(payment_setting)
                                                    ? JSON.parse(
                                                        payment_setting
                                                    )[
                                                    'cardholder_name_placeholder'
                                                    ]
                                                    : 'Enter cardholder name'
                                                    " v-model="form.card_holder_name" />
                                                <Error fieldName="card_holder_name" :validationErros="validationErros"
                                                    full_width="1" />
                                            </div>

                                            <!-- Stripe Card Element -->
                                            <div class="input_text relative mb-4">
                                                <label class="block mb-2 text-sm font-medium">{{
                                                    payment_setting &&
                                                        JSON.parse(payment_setting)
                                                        ? JSON.parse(payment_setting)[
                                                        "card_number_label"
                                                        ]
                                                        : "Card details"
                                                }}</label>
                                                <div ref="stripeCard" class="can-exp-input"></div>
                                                <Error fieldName="payment_method_id" :validationErros="validationErros"
                                                    full_width="1" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="flex items-start space-x-2 relative w-full mt-3">
                                    <input @input="clearErrors('agree_terms')" type="checkbox" class="mt-1" value="1"
                                        placeholder="" name="agree_terms" id="agree_terms" v-model="form.agree_terms" />
                                    <label class="block text-gray-900 text-base md:text-base lg:text-lg"
                                        for="agree_terms">{{ JSON.parse(coffee_wall_setting)["agree_terms_label"] ?? 'By clicking' }}
                                    </label>
                                </div> -->
                            </div>
                        </div>
                        <Error v-if="submitted" fieldName="agree_terms" :validationErros="validationErros"
                            full_width="1" />
                    </div>
                </div>
            </div>
            <div class="mt-8 flex">
                <div class="">
                    <Error v-if="submitted" fieldName="captcha" :validationErros="validationErros" full_width="1" />
                </div>
            </div>

            <!-- Disclaimer Checkboxes -->
            <div class="px-4 space-y-4">
                <!-- Non-refundable Donation Disclaimer -->
                <div class="flex items-start space-x-2">
                    <input @input="clearErrors('non_refundable_agreement')" type="checkbox" class="mt-1"
                        name="non_refundable_agreement" id="non_refundable_agreement"
                        v-model="form.non_refundable_agreement" />
                    <label class="block text-gray-900 text-sm md:text-base" for="non_refundable_agreement">
                        I agree to allow Canadian Exports to inform the Kindness Partner who contributed to my Coffee. Only my business name, category, province, and the service received will be shared.
                    </label>
                </div>
                <Error v-if="submitted" fieldName="non_refundable_agreement" :validationErros="validationErros"
                    full_width="1" />

                <!-- Terms and Conditions & Privacy Policy Agreement -->
                <div class="flex items-start space-x-2">
                    <input @input="clearErrors('terms_privacy_agreement')" type="checkbox" class="mt-1"
                        name="terms_privacy_agreement" id="terms_privacy_agreement"
                        v-model="form.terms_privacy_agreement" />
                    <p>By clicking "<strong>Make Someone's Day</strong>", you agree to our <a
                            href="../../../en/terms-and-conditions" target="_blank" rel="noopener">Terms and
                            Conditions</a>&nbsp;and&nbsp;<a href="../../../en/privacy-policy" target="_blank"
                            rel="noopener">Privacy Policy</a></p>
                </div>
                <Error v-if="submitted" fieldName="terms_privacy_agreement" :validationErros="validationErros"
                    full_width="1" />
            </div>

            <!-- <ListErrors :validationErrors="validationErros" /> -->
            <div class="flex justify-center items-center px-4 mt-6">
                <button type="submit" id="send-message" :disabled="!isFormValid" :class="[
                    'button-exp-fill w-full sm:w-40 md:w-48 lg:w-56 transition-opacity duration-300',
                    !isFormValid ? 'opacity-40 cursor-not-allowed' : 'opacity-100 cursor-pointer'
                ]">
                    {{ JSON.parse(coffee_wall_setting)["pay_label"] ?? 'Pay' }}
                </button>
            </div>

            <!-- FAQ Sections -->
            <div class="mt-12 space-y-4" v-if="faqs.donor.length > 0 || faqs.beneficiary.length > 0">
                <!-- FAQ for Donors -->
                <div v-if="faqs.donor.length > 0" class="bg-white rounded-lg overflow-hidden shadow-3xl">
                    <div @click="toggleFaqSection('donor')"
                        class="px-4 py-3 sm:px-6 text-left bg-gradient-to-r from-primary via-primary to-secondary rounded-t-md cursor-pointer hover:opacity-90 transition-opacity flex justify-between items-center">
                        <h4 class="text-white">FAQ for the Donors</h4>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5 text-white transition-transform duration-300"
                            :class="{ 'rotate-180': isFaqSectionOpen.donor }">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                    <transition name="slide">
                        <div v-show="isFaqSectionOpen.donor" class="p-4 overflow-hidden">
                            <div v-for="(faq, index) in faqs.donor" :key="faq.id" class="last:mb-0">
                                <div @click="toggleFaqItem('donor', index)"
                                    class="flex justify-between items-start cursor-pointer p-3 hover:bg-gray-50 rounded-md transition-colors">
                                    <h5 class="font-medium text-gray-900 flex-1 pr-4">
                                        {{ faq.question }}
                                    </h5>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor"
                                        class="w-5 h-5 text-gray-500 transition-transform duration-300 flex-shrink-0"
                                        :class="{ 'rotate-180': openFaqItems.donor[index] }">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </div>
                                <transition name="slide">
                                    <div v-show="openFaqItems.donor[index]" class="px-3 pb-3 overflow-hidden">
                                        <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{
                                            faq.answer }}</p>
                                    </div>
                                </transition>
                            </div>
                        </div>
                    </transition>
                </div>

                <!-- FAQ for Beneficiaries -->
                <div v-if="faqs.beneficiary.length > 0" class="bg-white rounded-lg overflow-hidden shadow-3xl">
                    <div @click="toggleFaqSection('beneficiary')"
                        class="px-4 py-3 sm:px-6 text-left bg-gradient-to-r from-primary via-primary to-secondary rounded-t-md cursor-pointer hover:opacity-90 transition-opacity flex justify-between items-center">
                        <h4 class="text-white">FAQ for the Beneficiary</h4>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5 text-white transition-transform duration-300"
                            :class="{ 'rotate-180': isFaqSectionOpen.beneficiary }">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                    <transition name="slide">
                        <div v-show="isFaqSectionOpen.beneficiary" class="p-4 overflow-hidden">
                            <div v-for="(faq, index) in faqs.beneficiary" :key="faq.id" class="last:mb-0">
                                <div @click="toggleFaqItem('beneficiary', index)"
                                    class="flex justify-between items-start cursor-pointer p-3 hover:bg-gray-50 rounded-md transition-colors">
                                    <h5 class="font-medium text-gray-900 flex-1 pr-4">
                                        {{ faq.question }}
                                    </h5>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor"
                                        class="w-5 h-5 text-gray-500 transition-transform duration-300 flex-shrink-0"
                                        :class="{ 'rotate-180': openFaqItems.beneficiary[index] }">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </div>
                                <transition name="slide">
                                    <div v-show="openFaqItems.beneficiary[index]" class="px-3 pb-3 overflow-hidden">
                                        <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{
                                            faq.answer }}</p>
                                    </div>
                                </transition>
                            </div>
                        </div>
                    </transition>
                </div>
            </div>

        </div>
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
import Swal from "sweetalert2";
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
        isFormValid() {
            return (
                this.form.amount !== '' &&
                this.form.receiver_name !== '' &&
                this.form.receiver_email !== '' &&
                this.form.frequency !== null &&
                this.form.terms_privacy_agreement === true &&
                this.form.non_refundable_agreement === true
            );
        },
        years() {
            const currentYear = new Date().getFullYear();
            return Array.from(
                { length: 16 },
                (_, index) => currentYear + index
            );
        },
    },
    props: [
        "coffee_wall_setting",
        "languages",
        "submit_url",
        "lang",
        "payment_setting",
    ],
    components: {
        FilePond,
        Error,
        // ListErrors,
    },
    data() {
        return {
            gallery_files: [],
            activeTab: null,
            form: {
                card_holder_name: null,
                name: "",
                email: "",
                phone: "",
                package_id: "",
                beneficiary_ids: [],
                order_amount: 0,
                custom_amount: "",
                frequency: "monthly",
                payment_method: "stripe",
                anonymous: false,
                notify_when_used: false,
                agree_terms: "",
                non_refundable_agreement: false,
                terms_privacy_agreement: false,
            },
            freePackage: [],
            featuredPackage: [],
            premiumPackage: [],
            packages: [],
            beneficiaries: [],
            allBeneficiaryId: null,
            faqs: {
                donor: [],
                beneficiary: []
            },
            isFaqSectionOpen: {
                donor: false,
                beneficiary: false
            },
            openFaqItems: {
                donor: [],
                beneficiary: []
            },
            validationErros: new ErrorHandling(),
            reCAPTCHA_site_key: process.env.MIX_reCAPTCHA_site_key,
            loading: false,
            showTooltip: false,
            submitted: false,
            // Stripe Elements
            stripe: null,
            elements: null,
            cardElement: null,
        };
    },
    mounted() {
        // Load form data from localStorage
        const savedForm = localStorage.getItem("event_signup_form");
        if (savedForm) {
            try {
                const parsedForm = JSON.parse(savedForm);
                if (parsedForm && typeof parsedForm === 'object') {
                    let beneficiaryIds = [];

                    if (Array.isArray(parsedForm.beneficiary_ids)) {
                        beneficiaryIds = parsedForm.beneficiary_ids.map(Number).filter(Boolean);
                    } else if (parsedForm.beneficiary_ids) {
                        beneficiaryIds = [Number(parsedForm.beneficiary_ids)];
                    } else if (parsedForm.beneficiary_id) {
                        beneficiaryIds = [Number(parsedForm.beneficiary_id)];
                    }

                    delete parsedForm.beneficiary_id;

                    this.form = {
                        ...this.form,
                        ...parsedForm,
                        beneficiary_ids: beneficiaryIds,
                    };

                    if (this.form.beneficiary_ids.length === 0 && this.allBeneficiaryId) {
                        this.form.beneficiary_ids = [this.allBeneficiaryId];
                    }

                    this.ensureBeneficiarySelection();
                }
            } catch (error) {
                console.error('Error parsing saved Coffee Wall form data:', error);
            }
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
            },
            immediate: true // Run the handler immediately if `languages` is already available
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
                                    console.log('Stripe Element remounted successfully');
                                } catch (e) {
                                    console.error('Error mounting Stripe Element:', e);
                                    // If mounting fails, recreate the element
                                    this.cardElement = this.elements.create('card');
                                    this.cardElement.mount(mountPoint);
                                }
                            } else if (mountPoint && this.stripe && !this.cardElement) {
                                // Card element doesn't exist, create and mount it
                                this.elements = this.stripe.elements();
                                this.cardElement = this.elements.create('card');
                                this.cardElement.mount(mountPoint);
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
        clearErrors(fieldName) {
            if (this.submitted) {
                this.validationErros.clear(fieldName);
            }
        },
        clearForm() {
            this.form["name"] = "";
            this.form["email"] = "";
            this.form["phone"] = "";
            this.form["card_holder_name"] = null;
            this.form["beneficiary_ids"] = this.allBeneficiaryId ? [this.allBeneficiaryId] : [];

            this.validationErros = new ErrorHandling();
            localStorage.removeItem("event_signup_form");

            // Clear Stripe card element
            if (this.cardElement) {
                this.cardElement.clear();
            }
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
                                this.validationErros.record({
                                    captcha: [res.data.message],
                                });
                            }
                        });
                });
            });
        },
        async addUpdateForm() {
            this.processPayment();
        },
        async processPayment() {
            this.loading = true;

            // When using Stripe, create PaymentMethod on frontend and send id only
            if (this.form.payment_method === 'stripe' && this.form.order_amount > 0 && this.cardElement && this.stripe) {
                try {
                    const { error, paymentMethod } = await this.stripe.createPaymentMethod({
                        type: 'card',
                        card: this.cardElement,
                        billing_details: {
                            name: this.form.card_holder_name,
                            email: this.form.email,
                        }
                    });

                    if (error) {
                        this.validationErros.record({ payment_method_id: [error.message] });
                        helper.swalErrorMessageForWeb(error.message);
                        this.loading = false;
                        return;
                    }

                    // Add payment method ID to form
                    this.form.payment_method_id = paymentMethod.id;
                } catch (error) {
                    console.error('Stripe error:', error);
                    helper.swalErrorMessageForWeb(error.message || 'Payment processing failed');
                    this.loading = false;
                    return;
                }
            }

            // Submit form to backend
            this.addReg();
        },
        addReg() {
            this.loading = 1;
            axios
                .post(this.submit_url, this.form)
                .then((res) => {
                    this.loading = 0;
                    if (res.data.status == "Success") {
                        if (res?.data?.data?.type == "paypal") {
                            // Redirect to PayPal
                            window.location.href =
                                res?.data?.data?.redirect_url;
                        } else {
                            // Stripe or free donation success
                            this.clearForm();

                            // Show success message with redirect
                            Swal.fire({
                                title: 'Success!',
                                text: res.data.message || 'Thank you for your generosity!',
                                icon: 'success',
                                confirmButtonText: 'OK',
                                timer: 3000,
                                timerProgressBar: true,
                                customClass: {
                                    confirmButton: 'button-exp-fill',
                                },
                            }).then(() => {
                                window.location.href = '/';
                            });
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
            this.form.order_amount = event_package.price;
            this.form.custom_amount = "";
        },
        updateFrequency(frequency) {
            this.form.frequency = frequency;
        },
        clearPackageSelection() {
            this.form.package_id = null; // Unselect package when custom amount entered
            this.form.order_amount = this.form.custom_amount; // Unselect package when custom amount entered
        },
        toggleBeneficiary(beneficiary) {
            if (!beneficiary || !beneficiary.id) {
                return;
            }

            const id = Number(beneficiary.id);
            const allId = Number(this.allBeneficiaryId);

            if (!Array.isArray(this.form.beneficiary_ids)) {
                this.form.beneficiary_ids = [];
            }

            // If "All" is selected, reset to only that option.
            if (allId && id === allId) {
                this.form.beneficiary_ids = [allId];
                this.clearErrors('beneficiary_ids');
                return;
            }

            const existingIndex = this.form.beneficiary_ids.findIndex(
                (selectedId) => Number(selectedId) === id
            );

            if (existingIndex > -1) {
                this.form.beneficiary_ids.splice(existingIndex, 1);
            } else {
                this.form.beneficiary_ids.push(id);
            }

            this.form.beneficiary_ids = this.form.beneficiary_ids
                .map((selectedId) => Number(selectedId))
                .filter((value, index, self) => self.indexOf(value) === index);

            // Ensure "All" is deselected when other beneficiaries are chosen.
            if (allId) {
                this.form.beneficiary_ids = this.form.beneficiary_ids.filter(
                    (selectedId) => selectedId !== allId || this.form.beneficiary_ids.length === 1
                );

                if (
                    this.form.beneficiary_ids.length === 0 ||
                    (this.form.beneficiary_ids.length === 1 && this.form.beneficiary_ids[0] === allId)
                ) {
                    this.form.beneficiary_ids = [allId];
                }

                if (this.form.beneficiary_ids.length > 1) {
                    this.form.beneficiary_ids = this.form.beneficiary_ids.filter(
                        (selectedId) => selectedId !== allId
                    );
                }
            }

            if (this.form.beneficiary_ids.length === 0 && allId) {
                this.form.beneficiary_ids = [allId];
            }

            this.ensureBeneficiarySelection();
            this.clearErrors('beneficiary_ids');
        },
        isBeneficiarySelected(id) {
            if (!Array.isArray(this.form.beneficiary_ids)) {
                return false;
            }

            return this.form.beneficiary_ids.map(Number).includes(Number(id));
        },
        ensureBeneficiarySelection() {
            if (!Array.isArray(this.form.beneficiary_ids)) {
                this.form.beneficiary_ids = [];
            }

            this.form.beneficiary_ids = this.form.beneficiary_ids
                .map((id) => Number(id))
                .filter((id, index, self) => !Number.isNaN(id) && self.indexOf(id) === index);

            const allId = Number(this.allBeneficiaryId);

            if (!allId) {
                return;
            }

            const hasAllSelected = this.form.beneficiary_ids.includes(allId);

            if (hasAllSelected && this.form.beneficiary_ids.length > 1) {
                this.form.beneficiary_ids = this.form.beneficiary_ids.filter((id) => id !== allId);
                return;
            }

            if (this.form.beneficiary_ids.length === 0) {
                this.form.beneficiary_ids = [allId];
            }
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
        toggleFaqSection(type) {
            this.isFaqSectionOpen[type] = !this.isFaqSectionOpen[type];
        },
        toggleFaqItem(type, index) {
            this.openFaqItems[type][index] = !this.openFaqItems[type][index];
        },
        restrictToPositiveIntegers(event) {
            const keyCode = event.which ? event.which : event.keyCode;
            // Allow only numbers (0-9), block dots (46), hyphens (45), and other characters
            if (keyCode < 48 || keyCode > 57) {
                event.preventDefault();
                return false;
            }
            return true;
        },
    },
    created() {
        this.gallery_files = [];

        this.activeTab = JSON.parse(this.lang)["id"];
        axios
            .get(
                `${process.env.MIX_APP_URL}/get-coffee-wall-packages`
            )
            .then((res) => {
                if (res.data.status == "Success") {
                    this.packages = res.data.data;
                    // Sort all packages by price ascending (10, 20, 30, 40, 99, 999)
                    // Default package is treated just like any other package
                    this.packages.sort((a, b) => {
                        const aPrice = parseFloat(a.price) || 0;
                        const bPrice = parseFloat(b.price) || 0;
                        return aPrice - bPrice;
                    });
                    this.packages.map((registrationPackage) => {
                        if (registrationPackage.is_default == "1") {
                            this.form.package_id = registrationPackage.id;
                            this.form.order_amount =
                                registrationPackage.price;

                            return true;
                        }
                    });
                }
            });

        // Fetch beneficiaries
        axios
            .get(
                `${process.env.MIX_APP_URL}/get-coffee-wall-beneficiaries`
            )
            .then((res) => {
                if (res.data.status == "Success") {
                    this.beneficiaries = res.data.data;
                    const allBeneficiary = this.beneficiaries.find(
                        (b) => typeof b.name === 'string' && b.name.toLowerCase() === 'all'
                    );
                    this.allBeneficiaryId = allBeneficiary ? Number(allBeneficiary.id) : null;
                    this.ensureBeneficiarySelection();
                }
            });

        // Fetch FAQs
        axios
            .get(`${process.env.MIX_APP_URL}/get-coffee-wall-faqs`)
            .then((res) => {
                if (res.data.status == "Success") {
                    this.faqs.donor = res.data.data.donor || [];
                    this.faqs.beneficiary = res.data.data.beneficiary || [];
                    // Initialize openFaqItems arrays
                    this.openFaqItems.donor = new Array(this.faqs.donor.length).fill(false);
                    this.openFaqItems.beneficiary = new Array(this.faqs.beneficiary.length).fill(false);
                }
            })
            .catch((error) => {
                console.error('Error fetching FAQs:', error);
            });

        // Initialize Stripe Elements (same pattern as ProfilePayment.vue)
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
                console.error('Error loading Stripe:', e);
            }
        })();
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

/* Slide transition for FAQ accordion */
.slide-enter-active {
    transition: all 0.3s ease-out;
}

.slide-leave-active {
    transition: all 0.3s ease-in;
}

.slide-enter-from,
.slide-leave-to {
    max-height: 0;
    opacity: 0;
    padding-top: 0;
    padding-bottom: 0;
}

.slide-enter-to,
.slide-leave-from {
    max-height: 2000px;
    opacity: 1;
}
</style>
