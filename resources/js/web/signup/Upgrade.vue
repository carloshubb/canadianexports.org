<template>
    <div>
        <a aria-label="Candian Exporters" class="cursor-pointer" @click="toggleModal()" v-if="display_type && display_type == 'text'">
            {{ modal_setting && modal_setting . i2b_upgrade_text ? modal_setting . i2b_upgrade_text : (modalSetting && modalSetting['i2b_upgrade_text'] ? modalSetting['i2b_upgrade_text'] : '') }}
        </a>
        <button aria-label="Candian Exporters" type="button" class="button-exp-no-fill" @click="toggleModal()" v-else>
            {{ general_setting && general_setting['upgrade_package_button_text']
                ? general_setting['upgrade_package_button_text']
                : '' }}
        </button>
        <div id="defaultModal" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 bottom-0 m-auto z-[1000] overflow-y-auto" v-if="showModal">
            <div class="fixed inset-0 z-100 bg-gray-500 bg-opacity-75 transition-opacity"
                @click.prevent="toggleModal()"></div>
            <div class="flex min-h-full items-end justify-center p-4 sm:items-center sm:p-0">
                <!-- Modal content -->
                <div
                    class="relative bg-white rounded-lg shadow w-full sm:max-w-4xl top-0 left-0 right-0 bottom-0 m-auto overflow-y-auto">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between py-3 px-3 border-b rounded-t">
                        <h3 class="card-heading text-primary text-gray-900">
                            {{ modal_setting && modal_setting . upgrade_modal_title ? modal_setting . upgrade_modal_title : (modalSetting && modalSetting['upgrade_modal_title'] ? modalSetting['upgrade_modal_title'] : '') }}
                        </h3>
                        <button aria-label="Candian Exporters" type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-base md:text-base lg:text-lg p-1.5 inline-flex items-center"
                            data-modal-hide="defaultModal" @click="toggleModal">
                            <img class="h-6" src="/assets/icons/19-X-inside-circle-2.png" alt="Candian Exporters" />
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-6">
                        <p>
                            {{ modal_setting && modal_setting . upgrade_modal_heading ? modal_setting . upgrade_modal_heading : (modalSetting && modalSetting['upgrade_modal_heading'] ? modalSetting['upgrade_modal_heading'] : '') }}
                        </p>
                        <div class="grid my-5 md:grid-cols-3 md:gap-6 gap-4">
                            <div class="bg-gray-50 rounded-lg h-full border border-gray-100">
                                <h4 class="mb-2 pt-3 px-4">
                                    {{ regPageSetting && regPageSetting . reg_page_setting_detail && regPageSetting . reg_page_setting_detail[0]
                                        ? regPageSetting . reg_page_setting_detail[0] . step1_free_pkg_text
                                        : '' }}
                                </h4>
                                <div class="bg-white h-1.5 w-full">
                                    <div class="bg-primary w-2/5 h-1.5"></div>
                                </div>
                                <ul class="max-w-md space-y-2 px-4 py-6 text-gray-500 list-inside dark:text-gray-400">
                                    <li class="flex items-start cursor-pointer" v-if="registrationPackages"
                                        v-for="registrationPackage in registrationPackages.filter(
                                            (res) => res.package_type == 'free'
                                        )"
                                        :key="registrationPackage.id"
                                        @click="
                                            updateRegPackageId(
                                                registrationPackage
                                            )
                                        ">
                                        <div class="flex items-start gap-2">
                                            <input :id="`package-${registrationPackage.id}`" name="profile_package"
                                                type="radio"
                                                class="mt-1 h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                                :value="registrationPackage.id"
                                                @click="
                                                    updateRegPackageId(
                                                        registrationPackage
                                                    )
                                                "
                                                :checked="form.registration_package_id ==
                                                    registrationPackage.id" />

                                            <label class="block" :for="`package-${registrationPackage.id}`">
                                                {{ registrationPackage . registration_package_detail && registrationPackage . registration_package_detail[0]
                                                    ? registrationPackage . registration_package_detail[0] . amount_pre_text
                                                    : '' }}

                                                ${{ registrationPackage . discount_price > 0
                                                    ? registrationPackage . discount_price
                                                    : registrationPackage . price }}

                                                {{ registrationPackage . registration_package_detail && registrationPackage . registration_package_detail[0]
                                                    ? registrationPackage . registration_package_detail[0] . amount_post_text
                                                    : '' }}
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="bg-gray-50 rounded-lg h-full border border-gray-100">
                                <h4 class="mb-2 px-4 pt-3">
                                    {{ regPageSetting && regPageSetting . reg_page_setting_detail && regPageSetting . reg_page_setting_detail[0]
                                        ? regPageSetting . reg_page_setting_detail[0] . step1_feature_pkg_text
                                        : '' }}
                                </h4>
                                <div class="bg-white h-1.5 w-full">
                                    <div class="bg-primary w-3/5 h-1.5"></div>
                                </div>
                                <ul class="max-w-md space-y-1 px-4 py-6 text-gray-500 list-inside dark:text-gray-400">
                                    <li class="flex items-start cursor-pointer" v-if="registrationPackages"
                                        v-for="registrationPackage in registrationPackages.filter(
                                            (res) =>
                                                res.package_type == 'featured'
                                        )"
                                        :key="registrationPackage.id">
                                        <div class="flex items-start gap-2">
                                            <input :id="`package-${registrationPackage.id}`" name="profile_package"
                                                type="radio"
                                                class="mt-1 h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                                :value="registrationPackage.id"
                                                @click="
                                                    updateRegPackageId(
                                                        registrationPackage
                                                    )
                                                "
                                                :checked="form.registration_package_id ==
                                                    registrationPackage.id" />

                                            <label class="block" :for="`package-${registrationPackage.id}`">
                                                {{ registrationPackage . registration_package_detail && registrationPackage . registration_package_detail[0]
                                                    ? registrationPackage . registration_package_detail[0] . amount_pre_text
                                                    : '' }}

                                                ${{ registrationPackage . discount_price > 0
                                                    ? registrationPackage . discount_price
                                                    : registrationPackage . price }}

                                                {{ registrationPackage . registration_package_detail && registrationPackage . registration_package_detail[0]
                                                    ? registrationPackage . registration_package_detail[0] . amount_post_text
                                                    : '' }}
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="bg-gray-50 rounded-lg h-full border border-gray-100">
                                <h4 class="mb-2 px-4 pt-3">
                                    {{ regPageSetting && regPageSetting . reg_page_setting_detail && regPageSetting . reg_page_setting_detail[0]
                                        ? regPageSetting . reg_page_setting_detail[0] . step1_premium_pkg_text
                                        : '' }}
                                </h4>
                                <div class="bg-white h-1.5 w-full">
                                    <div class="bg-primary w-full h-1.5"></div>
                                </div>
                                <ul class="max-w-md space-y-2 px-4 py-6 text-gray-500 list-inside dark:text-gray-400">
                                    <li class="flex items-start cursor-pointer" v-if="registrationPackages"
                                        v-for="registrationPackage in registrationPackages.filter(
                                            (res) =>
                                                res.package_type == 'premium'
                                        )"
                                        :key="registrationPackage.id">
                                        <div class="flex items-start gap-2">
                                            <input :id="`package-${registrationPackage.id}`" name="profile_package"
                                                type="radio"
                                                class="mt-1 h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                                :value="registrationPackage.id"
                                                @click="
                                                    updateRegPackageId(
                                                        registrationPackage
                                                    )
                                                "
                                                :checked="form.registration_package_id ==
                                                    registrationPackage.id" />

                                            <label class="block" :for="`package-${registrationPackage.id}`">
                                                {{ registrationPackage . registration_package_detail && registrationPackage . registration_package_detail[0]
                                                    ? registrationPackage . registration_package_detail[0] . amount_pre_text
                                                    : '' }}

                                                ${{ registrationPackage . discount_price > 0
                                                    ? registrationPackage . discount_price
                                                    : registrationPackage . price }}

                                                {{ registrationPackage . registration_package_detail && registrationPackage . registration_package_detail[0]
                                                    ? registrationPackage . registration_package_detail[0] . amount_post_text
                                                    : '' }}
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="flex justify-between items-center p-3 border-b">
                            <div class="w-full">
                                <div class="flex items-center">
                                    <input id="stripe" name="registration-package" type="radio"
                                        class="h-4 w-4 border-gray-300 accent-primaryRed"
                                        @click="setPaymentMethod('stripe')"
                                        :checked="form.payment_method == 'stripe'" />
                                    <label for="stripe" class="ml-2 block font-medium text-gray-900">
                                        {{payment_setting && JSON.parse(payment_setting) ? JSON.parse(payment_setting)['pay_with_credit_card_text'] : ''}}
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="paypal" name="registration-package" type="radio"
                                        class="h-4 w-4 border-gray-300 accent-primaryRed"
                                        @click="setPaymentMethod('paypal')"
                                        :checked="form.payment_method == 'paypal'" />
                                    <label for="paypal" class="ml-2 block font-medium text-gray-900">
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
                                <div id="card-element" class="border border-primary rounded p-2 mt-2 mb-2"
                                    v-if="
                                        form.customer_payment_method_id ==
                                            'add_new_card' &&
                                        form.payment_method == 'stripe'
                                    ">
                                    <div class="flex justify-center items-center">
                                        <div class="h-auto bg-white p-3 rounded-lg w-full">
                                            <div class="input_text mt-6 relative">
                                                <label
                                                    class="">{{ payment_setting && payment_setting['cardholder_name_label'] ? payment_setting['cardholder_name_label'] : '' }}</label>
                                                <i class="text-gray-400 fa fa-user"></i>
                                                <input type="text" class="can-exp-input"
                                                    :placeholder="payment_setting &&
                                                        payment_setting[
                                                            'cardholder_name_placeholder'
                                                        ] ?
                                                        payment_setting[
                                                            'cardholder_name_placeholder'
                                                        ] :
                                                        ''"
                                                    v-model="
                                                        form.card_holder_name
                                                    " />
                                                <Error fieldName="card_holder_name"
                                                    :validationErros="validationErros"
                                                    full_width="1" />
                                            </div>
                                            <div class="input_text mt-8 relative">
                                                <label
                                                    class="">{{ payment_setting && payment_setting['card_number_label'] ? payment_setting['card_number_label'] : '' }}</label>
                                                <i class="text-gray-400 fa fa-credit-card"></i>
                                                <input type="text" class="can-exp-input"
                                                    :placeholder="payment_setting &&
                                                        payment_setting[
                                                            'card_number_placeholder'
                                                        ] ?
                                                        payment_setting[
                                                            'card_number_placeholder'
                                                        ] :
                                                        ''"
                                                    v-model="form.card_no"
                                                    @keypress="
                                                        restrictToNumbers(
                                                            $event,
                                                            16
                                                        )
                                                    " />
                                                <Error fieldName="card_no"
                                                    :validationErros="validationErros"
                                                    full_width="1" />
                                            </div>
                                            <div class="input_text mt-2 relative">
                                                <label
                                                    class="">{{ payment_setting && payment_setting['expiry_month_label'] ? payment_setting['expiry_month_label'] : '' }}</label>
                                                    
                                                    <select class="rounded-md px-3 pr-8 py-1 w-full" v-model="form.expiry_month">
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                        </select>
                                                <Error fieldName="expiry_month"
                                                    :validationErros="validationErros"
                                                    full_width="1" />
                                            </div>
                                            <div class="input_text mt-2 relative">
                                                <label
                                                    class="">{{ payment_setting && payment_setting['expiry_year_label'] ? payment_setting['expiry_year_label'] : '' }}</label>
                                                    
                                                    <select class="rounded-md px-3 pr-8 py-1 w-full" v-model="form.expiry_year">
                                                <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
                                        </select>
                                                <Error fieldName="expiry_year"
                                                    :validationErros="validationErros"
                                                    full_width="1" />
                                            </div>
                                            <div class="input_text mt-2 relative">
                                                <label
                                                    class="">{{ payment_setting && payment_setting['cvv_label'] ? payment_setting['cvv_label'] : '' }}</label>
                                                <i class="text-gray-400 fa fa-credit-card"></i>
                                                <input type="text" class="can-exp-input"
                                                    :placeholder="payment_setting &&
                                                        payment_setting[
                                                            'cvv_placeholder'
                                                        ] ?
                                                        payment_setting[
                                                            'cvv_placeholder'
                                                        ] :
                                                        ''"
                                                    v-model="form.cvc"
                                                    @keypress="
                                                        restrictToNumbers(
                                                            $event,
                                                            4
                                                        )
                                                    " />
                                                <Error fieldName="cvc"
                                                    :validationErros="validationErros"
                                                    full_width="1" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between items-center p-3 border-b"
                            v-if="form.payment_method == 'stripe'">
                            <div class="flex items-center gap-2">
                                <label for="cards"
                                    class="block mb-2 text-base md:text-base lg:text-lg font-medium text-gray-900 dark:text-white">Cards</label>
                                <select id="cards" class="can-exp-input"
                                    v-model="form.customer_payment_method_id">
                                    <option :value="customerPaymentMethod.id"
                                        v-for="customerPaymentMethod in customerPaymentMethods"
                                        :key="customerPaymentMethod.id">
                                        {{ customerPaymentMethod . card_no }}
                                    </option>
                                    <option value="add_new_card">
                                        Add new card
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="flex items-center mb-4">
                            <input id="auto-renew" type="checkbox" value=""
                                class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary"
                                v-model="form.is_auto_renew" />
                            <label for="auto-renew" class="ml-2 text-gray-900 text-base md:text-base lg:text-lg">
                                {{ regPageSetting && regPageSetting . reg_page_setting_detail && regPageSetting . reg_page_setting_detail[0]
                                    ? regPageSetting . reg_page_setting_detail[0] . step_1_auto_renew_label
                                    : '' }}
                            </label>
                        </div>
                        <div class="mt-2">
                            <button aria-label="Candian Exporters" href="#" @click.prevent="upgradePackage()"
                                class="button-exp-fill hover:text-white"
                                :disabled="form.registration_package_id ==
                                    selectedPackageId">
                                {{ modal_setting ? modal_setting['upgrade_modal_submit_button_text'] : (modalSetting && modalSetting['upgrade_modal_submit_button_text'] ? modalSetting['upgrade_modal_submit_button_text'] : '') }}
                            </button>
                        </div>
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
        </div>
    </div>
</template>

<script>
import Error from "./../components/Error.vue";
import ErrorHandling from "../../ErrorHandling";
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            regPageSetting: (state) => state.signup.regPageSetting,
            selectedPackageId: (state) => state.signup.selectedPackageId,
            registrationPackages: (state) => state.signup.registrationPackages,
            customerPaymentMethods: (state) =>
                state.signup.customerPaymentMethods,
            payment_setting: (state) => state.signup.payment_setting,
        }),
        years() {
            const currentYear = new Date().getFullYear();
            return Array.from({ length: 16 }, (_, index) => currentYear + index);
        },
    },
    components: {
        Error,
    },
    data() {
        return {
            general_setting: null,
            modalSetting: null,
            showModal: false,
            loading: false,
            form: {
                is_auto_renew: true,
                card_holder_name: null,
                card_no: null,
                expiry_month: ("0" + (new Date().getMonth() + 1)).slice(-2),
                expiry_year: new Date().getFullYear(),
                cvc: null,
                orderAmount: 0,
                payment_method: "stripe",
                customer_payment_method_id: null,
                registration_package_id: null,
            },
            validationErros: new ErrorHandling(),
        };
    },
    methods: {
        clearForm() {
            this.form.is_auto_renew = true;
            this.form.card_holder_name = null;
            this.form.card_no = null;
            this.form.expiry_month = ("0" + (new Date().getMonth() + 1)).slice(-2);
            this.form.expiry_year = new Date().getFullYear();
            this.form.cvc = null;
            this.form.orderAmount = 0;
            this.form.payment_method = "stripe";
            this.form.registration_package_id = null;
            this.validationErros = new ErrorHandling();
        },
        toggleModal() {
            this.showModal = !this.showModal;
            if (this.showModal) {
                this.fetchPaymentMethods();
                this.getMountedData();
            }
            this.clearForm();
        },
        updateRegPackageId(registrationPackage) {
            this.form.orderAmount = registrationPackage.discount_price
                ? registrationPackage.discount_price
                : registrationPackage.price;
            this.form.registration_package_id = registrationPackage.id;
        },
        upgradePackage() {
            if (this.form.registration_package_id == this.selectedPackageId) {
                return;
            }
            this.loading = true;
            this.$store
                .dispatch("signup/upgradePackage", this.form)
                .then((response) => {
                    this.loading = false;
                    if (response.data.status == "Success") {
                        if (response?.data?.data?.type == "paypal") {
                            window.location.href =
                                response?.data?.data?.redirect_url;
                        } else {
                            this.toggleModal();
                            this.clearForm();
                            this.$store.commit(
                                "signup/setSelectedPackageId",
                                response.data.data.id
                            );
                            this.updateRegPackageId(response.data.data);
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        }
                    } else {
                        helper.swalErrorMessageForWeb(response.data.message);
                    }
                })
                .catch((error) => {
                    this.validationErros = new ErrorHandling();
                    this.loading = false;
                    if (error.response && error.response.status == 422) {
                        this.validationErros.record(error.response.data.errors);
                    } else if (
                        error.response &&
                        error.response.data &&
                        error.response.data.status == "Error"
                    ) {
                        helper.swalErrorMessageForWeb(error.response.data.message);
                    }
                })
                .finally(() => (this.loading = false));
        },
        async setPaymentMethod(value) {
            this.form.payment_method = value;
        },
        fetchPaymentMethods() {
            this.$store
                .dispatch("signup/fetchCustomerPaymentMethods", {
                    url: `${process.env.MIX_WEB_API_URL}customer-payment-methods`,
                })
                .then((response) => {
                    if (response.data.status == "Success") {
                        let p_method = response.data.data.methods.filter(
                            (res) => res.is_default == 1
                        );
                        if (p_method && p_method[0]) {
                            this.form.customer_payment_method_id =
                                p_method[0]["id"];
                        }
                    }
                });
        },
        getMountedData() {
            this.$store.commit(
                "signup/setSelectedPackageId",
                this.user.registration_package_id
            );
            this.$store
                .dispatch("signup/fetchRegistrationPackages", {
                    url: `${process.env.MIX_WEB_API_URL}get-registration-packages?getPackagesOnly=1`,
                })
                .then((res) => {
                    this.$store.dispatch("signup/fetchRegPageSetting", {
                        url: `${process.env.MIX_WEB_API_URL}get-reg-page-setting?getDefaultPageSetting=1`,
                    });
                    this.form.registration_package_id =
                        this.user.registration_package_id;
                });
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
    props: ["user", "display_type", "modal_setting"],
    created() {
        this.$store
                        .dispatch("signup/fetchStaticSetting", {
                            url: `${process.env.MIX_WEB_API_URL}get-static-setting?getGeneralSetting=1`,
                        })
                        .then((res) => {
                            if (res.data.status == "Success") {
                                this.general_setting = res.data.data;

                                this.$store
                                    .dispatch("signup/fetchStaticSetting", {
                                        url: `${process.env.MIX_WEB_API_URL}get-static-setting?GetUpgradeModalSetting=1`,
                                    })
                                    .then((res) => {
                                        if (res.data.status == "Success") {
                                            this.modalSetting =
                                                res.data.data;
                                        }
                                    });
                            }
                        });
    },
};
</script>
