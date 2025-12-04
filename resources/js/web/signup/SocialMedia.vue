<template>
  <div>
    <div class="my-4">
      <div
        class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-xblue via-primary to-blue-600 rounded-md cursor-pointer">
        <template v-if="profile == '1'">
          <h4 class="text-white" @click.prevent="
            displaySocialMediaSection = !displaySocialMediaSection
            " v-html="JSON.parse(user)?.is_package_amount_paid
              ? regPageSetting?.reg_page_setting_detail?.[0]
                ?.step_6_acc_heading
              : regPageSetting?.reg_page_setting_detail?.[0]?.step_6_heading
              "></h4>
        </template>
        <template v-else>
          <h4 class="text-white" @click.prevent="
            displaySocialMediaSection = !displaySocialMediaSection
            " v-html="regPageSetting?.reg_page_setting_detail?.[0]?.step_6_heading
              "></h4>
        </template>
      </div>
      <div class="my-4" v-if="displaySocialMediaSection">
        <div class="relative w-full mb-4">
          <label class="block text-gray-700 mb-1 text-base md:text-base lg:text-lg" for="facebook">
            {{
              regPageSetting?.reg_page_setting_detail?.[0]
                ?.step_6_facebook_label
            }}
          </label>
          <input type="url" class="can-exp-input" :placeholder="regPageSetting?.reg_page_setting_detail?.[0]
            ?.step_6_facebook_placeholder
            " :value="form && form.has('customer_social_media_facebook')
              ? form.get('customer_social_media_facebook')
              : ''
              " @input="
                updateForm('customer_social_media_facebook', $event.target.value)
                " id="customer_social_media_facebook" />
          <Error fieldName="customer_social_media_facebook" :validationErros="validationErros" />
        </div>
        <div class="relative w-full mb-4">
          <label class="block text-gray-700 mb-1 text-base md:text-base lg:text-lg" for="twitter">
            {{
              regPageSetting?.reg_page_setting_detail?.[0]?.step_6_twitter_label
            }}
          </label>
          <input type="url" class="can-exp-input" :placeholder="regPageSetting?.reg_page_setting_detail?.[0]
            ?.step_6_twitter_placeholder
            " :value="form && form.has('customer_social_media_twitter')
              ? form.get('customer_social_media_twitter')
              : ''
              " @input="
                updateForm('customer_social_media_twitter', $event.target.value)
                " id="customer_social_media_twitter" />
          <Error fieldName="customer_social_media_twitter" :validationErros="validationErros" />
        </div>
        <div class="relative w-full mb-4">
          <label class="block text-gray-700 mb-1 text-base md:text-base lg:text-lg" for="youtube">
            {{
              regPageSetting?.reg_page_setting_detail?.[0]?.step_6_youtube_label
            }}
          </label>
          <input type="url" class="can-exp-input" :placeholder="regPageSetting?.reg_page_setting_detail?.[0]
            ?.step_6_youtube_placeholder
            " :value="form && form.has('customer_social_media_youtube')
              ? form.get('customer_social_media_youtube')
              : ''
              " @input="
                updateForm('customer_social_media_youtube', $event.target.value)
                " id="customer_social_media_youtube" />
          <Error fieldName="customer_social_media_youtube" :validationErros="validationErros" />
        </div>
        <div class="relative w-full mb-4">
          <label class="block text-gray-700 mb-1 text-base md:text-base lg:text-lg" for="linkedin">
            {{
              regPageSetting?.reg_page_setting_detail?.[0]
                ?.step_6_linkedin_label
            }}
          </label>
          <input type="url" class="can-exp-input" :placeholder="regPageSetting?.reg_page_setting_detail?.[0]
            ?.step_6_linkedin_placeholder
            " :value="form && form.has('customer_social_media_linked_in')
              ? form.get('customer_social_media_linked_in')
              : ''
              " @input="
                updateForm('customer_social_media_linked_in', $event.target.value)
                " id="customer_social_media_linked_in" />
          <Error fieldName="customer_social_media_linked_in" :validationErros="validationErros" />
        </div>
        <div class="relative w-full mb-4">
          <label class="block text-gray-700 mb-1 text-base md:text-base lg:text-lg" for="linkedin">
            {{
              regPageSetting?.reg_page_setting_detail?.[0]
                ?.step_6_social_media5_label
            }}
          </label>
          <input type="url" class="can-exp-input" :placeholder="regPageSetting?.reg_page_setting_detail?.[0]
            ?.step_6_social_media5_placeholder
            " :value="form && form.has('customer_social_media_social_media5')
              ? form.get('customer_social_media_social_media5')
              : ''
              " @input="
                updateForm(
                  'customer_social_media_social_media5',
                  $event.target.value
                )
                " id="customer_social_media_social_media5" />
          <Error fieldName="customer_social_media_social_media5" :validationErros="validationErros" />
        </div>
      </div>

      <div class="flex justify-center gap-6 items-start xl:gap-12 px-4 py-8 sm:px-10" v-if="selectedRegistrationPackage && user &&
        (JSON.parse(user)['registration_package_id'] !=
          selectedRegistrationPackage.id ||
          JSON.parse(user)['payment_frequency'] != payment_frequency) && JSON.parse(user)['is_package_amount_paid'] == '1'
      ">
        <div v-if="calTotalPrice() > 0" class="w-full">
          <div class="w-full">
            <div>
              <!--Debit Card-->
              <div class="flex justify-between items-center">
                <div class="w-full">
                  <div class="flex items-center">
                    <input id="stripe" name="registration-package" type="radio"
                      class="h-4 w-4 border-gray-300 accent-primaryRed" @click="setPaymentMethod('stripe')"
                      :checked="payment_method == 'stripe'" />
                    <label for="stripe" class="ml-2 block text-gray-900">
                      {{
                        payment_setting && JSON.parse(payment_setting)
                          ? JSON.parse(payment_setting)[
                          "pay_with_credit_card_text"
                          ]
                          : ""
                      }}
                    </label>
                  </div>
                  <div class="flex items-center">
                    <input id="paypal" name="registration-package" type="radio"
                      class="h-4 w-4 border-gray-300 accent-primaryRed" @click="setPaymentMethod('paypal')"
                      :checked="payment_method == 'paypal'" />
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
                    v-if="calTotalPrice() > 0 && payment_method == 'stripe'">
                    <div class="flex justify-center items-center">
                      <div class="h-auto bg-white p-3 rounded-lg w-full">
                        <div class="input_text mt-6 relative">
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
                              )
                              " id="card_holder_name" />
                          <Error fieldName="card_holder_name" :validationErros="validationErros" full_width="1" />
                        </div>
                        <div class="input_text mt-2 relative">
                          <label class="">{{
                            payment_setting &&
                              JSON.parse(payment_setting) &&
                              JSON.parse(payment_setting)["card_number_label"]
                              ? JSON.parse(payment_setting)["card_number_label"]
                              : ""
                          }}</label>
                          <i class="text-gray-400 fa fa-credit-card"></i>
                          <input type="text" class="can-exp-input" :placeholder="payment_setting &&
                            JSON.parse(payment_setting) &&
                            JSON.parse(payment_setting)[
                            'card_number_placeholder'
                            ]
                            ? JSON.parse(payment_setting)[
                            'card_number_placeholder'
                            ]
                            : ''
                            " @input="updateForm('card_no', $event.target.value)"
                            @keypress="restrictToNumbers($event, 16)" id="card_no" />
                          <Error fieldName="card_no" :validationErros="validationErros" full_width="1" />
                        </div>
                        <div class="input_text mt-2 relative">
                          <label class="">{{
                            payment_setting &&
                              JSON.parse(payment_setting) &&
                              JSON.parse(payment_setting)["expiry_month_label"]
                              ? JSON.parse(payment_setting)[
                              "expiry_month_label"
                              ]
                              : ""
                          }}</label>
                          <select class="can-exp-input" @input="
                            updateForm('expiry_month', $event.target.value)
                            " id="expiry_month">
                            <option value="01" :selected="alreadySelectedMonth('01')">01</option>
                            <option value="02" :selected="alreadySelectedMonth('02')">02</option>
                            <option value="03" :selected="alreadySelectedMonth('03')">03</option>
                            <option value="04" :selected="alreadySelectedMonth('04')">04</option>
                            <option value="05" :selected="alreadySelectedMonth('05')">05</option>
                            <option value="06" :selected="alreadySelectedMonth('06')">06</option>
                            <option value="07" :selected="alreadySelectedMonth('07')">07</option>
                            <option value="08" :selected="alreadySelectedMonth('08')">08</option>
                            <option value="09" :selected="alreadySelectedMonth('09')">09</option>
                            <option value="10" :selected="alreadySelectedMonth('10')">10</option>
                            <option value="11" :selected="alreadySelectedMonth('11')">11</option>
                            <option value="12" :selected="alreadySelectedMonth('12')">12</option>
                          </select>
                          <Error fieldName="expiry_month" :validationErros="validationErros" full_width="1" />
                        </div>

                        <div class="input_text mt-2 relative">
                          <label class="">{{
                            payment_setting &&
                              JSON.parse(payment_setting) &&
                              JSON.parse(payment_setting)["expiry_year_label"]
                              ? JSON.parse(payment_setting)["expiry_year_label"]
                              : ""
                          }}</label>

                          <select class="can-exp-input" @input="
                            updateForm('expiry_year', $event.target.value)
                            " id="expiry_year">
                            <option v-for="year in years" :key="year" :value="year"
                              :selected="alreadySelectedYear(year)">
                              {{ year }}
                            </option>
                          </select>
                          <Error fieldName="expiry_year" :validationErros="validationErros" full_width="1" />
                        </div>

                        <div class="input_text mt-2 relative">
                          <div class="flex justify-between items-center">
                            <div>
                              <label class="">{{
                                payment_setting && JSON.parse(payment_setting)
                                  ? JSON.parse(payment_setting)["cvv_label"]
                                  : ""
                              }}</label>
                              <i class="text-gray-400 fa fa-calendar-o"></i>
                            </div>
                            <div class="relative" @mouseleave="showTooltip = false">
                              <button type="button" @mouseenter="showTooltip = true" class="focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                  stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mt-2">
                                  <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                </svg>
                              </button>
                              <div v-if="showTooltip"
                                class="absolute h-60 w-96 rounded-md bg-white right-0 shadow p-2 z-[1000]">
                                <img class="object-cover w-full h-full" src="/assets/images/img (1).png" alt="" />
                              </div>
                            </div>
                          </div>
                          <input type="text" class="can-exp-input" :placeholder="payment_setting &&
                            JSON.parse(payment_setting) &&
                            JSON.parse(payment_setting)['cvv_placeholder']
                            ? JSON.parse(payment_setting)['cvv_placeholder']
                            : ''
                            " @input="updateForm('cvc', $event.target.value)" @keypress="restrictToNumbers($event, 4)"
                            id="cvc" />
                          <Error fieldName="cvc" :validationErros="validationErros" full_width="1" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="md:w-full mt-6 rounded-lg border bg-white p-4 md:p-6 shadow-md md:mt-0">
          <div class="mb-2 flex justify-between">
            <p class="text-gray-700">{{ JSON.parse(payment_setting)["package_text"] }}</p>
            <p class="text-gray-700 capitalize">
              {{ selectedRegistrationPackage?.package_type }}
            </p>
          </div>
          <div class="mb-2 flex justify-between">
            <p class="text-gray-700">{{ JSON.parse(payment_setting)["payment_frequency_text"] }}</p>
            <p class="text-gray-700 capitalize">
              {{ payment_frequency }}
            </p>
          </div>
          <div class="mb-2 flex justify-between">
            <p class="text-gray-700">{{ JSON.parse(payment_setting)["price_text"] }}</p>
            <p class="text-gray-700 capitalize">${{ packagePrice() }}</p>
          </div>
          <div class="mb-2 flex justify-between" v-if="user &&
            JSON.parse(user)['payment_method'] != 'paypal'
          ">
            <p class="text-gray-700">{{ JSON.parse(payment_setting)["refund_text"] }}</p>
            <p class="text-gray-700 capitalize">${{ calRefundPrice() }}</p>
          </div>
          <hr class="my-4" />
          <div class="flex justify-between">
            <p class="text-lg font-bold">{{ JSON.parse(payment_setting)["total_text"] }}</p>
            <div class="">
              <p class="mb-1 text-lg font-bold capitalize">${{ calTotalPrice() }}</p>
            </div>
          </div>
          <!-- <ListErrors :validationErrors="validationErros" /> -->
          <div class="mb-2 text-center">
            <button class="button-exp-fill mt-6" type="button" @click="processPayment()">
              {{ calTotalPrice() > 0 ? JSON.parse(payment_setting)["confirm_and_pay_btn_text"] :
                JSON.parse(payment_setting)["confirm_and_proceed_btn_text"] }}
            </button>
          </div>
          <div v-if="user &&
            JSON.parse(user)['payment_method'] != 'stripe' && JSON.parse(user)['package_price'] > '0'
          ">
            <p class="text-gray-700">{{ JSON.parse(payment_setting)["refund_instruction_text"] }}</p>
          </div>
        </div>
      </div>
      <template v-else>
        <!-- <ListErrors :validationErrors="validationErros" /> -->
        <div class="mt-10 flex justify-center" v-if="profile == '1' && hide_process_btn == 'no'">
          <button aria-label="Candian Exporters" type="button" @click="updateProfileSetting()" class="button-exp-fill">
            {{
              general_setting && general_setting["process_button_text"]
                ? general_setting["process_button_text"]
                : ""
            }}
          </button>
        </div>
      </template>
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
  <transition name="slide-fade">
    <div id="defaultModal" tabindex="-1" aria-hidden="true"
      class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
      v-if="showModal">
      <div class="relative w-full h-full max-w-2xl md:h-auto flex items-center justify-center"
        ref="elementToDetectClick">
        <!-- Modal content -->
        <div class="container mx-auto">
          <!-- Modal header -->
          <!-- <div
                        class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600"
                    >
                        <div>
                            <h3 class="can-edu-h3 mb-0">
                                Your amount will not be funded if you use paypal payment
                            </h3>
                        </div>
                        <div>
                            <button
                                type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="defaultModal"
                                @click="toggleModal"
                            >
                                <svg
                                    aria-hidden="true"
                                    class="w-5 h-5 text-primary"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    ></path>
                                </svg>
                                <span class="sr-only"></span>
                            </button>
                        </div>
                    </div> -->
          <div class="bg-white py-6 px-10 rounded shadow-lg text-center">
            <p class="text-center can-edu-p ">Your amount will not be funded if you use paypal payment</p>
            <button type="button" class="button-exp-fill mt-4" data-modal-hide="defaultModal" @click="toggleModal">
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>
<script>
import Swal from "sweetalert2";
import { mapState } from "vuex";
import Error from "./../components/Error.vue";
// import ListErrors from "./../components/ListErrors.vue";

export default {
  components: {
    Error,
    // ListErrors,
  },
  computed: {
    ...mapState({
      form: (state) => state.signup.form,
      regPageSetting: (state) => state.signup.regPageSetting,
      payment_frequency: (state) => state.signup.payment_frequency,
      selectedRegistrationPackage: (state) =>
        state.signup.selectedRegistrationPackage,
      validationErros: (state) => state.signup.validationErros,
    }),
    years() {
      const currentYear = new Date().getFullYear();
      return Array.from({ length: 16 }, (_, index) => currentYear + index);
    },
  },
  data() {
    return {
      showModal: false,
      general_setting: null,
      displaySocialMediaSection: false,
      payment_method: "stripe",
      showTooltip: false,
      loading: false,
    };
  },
  created() {
    if (this.profile == "1") {
      let user = JSON.parse(this.user);
      if (user.is_package_amount_paid) {
        this.displaySocialMediaSection = 1;
      }
      this.$store.dispatch("signup/fetchRegPageSetting", { id: this.page_id });
      this.updateForm(
        "customer_social_media_facebook",
        user?.customer_social_media?.facebook
          ? user?.customer_social_media?.facebook
          : ""
      );
      this.updateForm(
        "customer_social_media_linked_in",
        user?.customer_social_media?.linked_in
          ? user?.customer_social_media?.linked_in
          : ""
      );
      this.updateForm(
        "customer_social_media_social_media5",
        user?.customer_social_media?.social_media5
          ? user?.customer_social_media?.social_media5
          : ""
      );
      this.updateForm(
        "customer_social_media_twitter",
        user?.customer_social_media?.twitter
          ? user?.customer_social_media?.twitter
          : ""
      );
      this.updateForm(
        "customer_social_media_youtube",
        user?.customer_social_media?.youtube
          ? user?.customer_social_media?.youtube
          : ""
      );
      this.$store
        .dispatch("signup/fetchStaticSetting", {
          url: `${process.env.MIX_WEB_API_URL}get-static-setting?getGeneralSetting=1`,
        })
        .then((res) => {
          if (res.data.status == "Success") {
            this.general_setting = res.data.data;
          }
        });
      this.updateForm(
        "expiry_month",
        ("0" + (new Date().getMonth() + 1)).slice(-2)
      );
      this.updateForm("expiry_year", new Date().getFullYear());
    }

    // Retrieve form data from localStorage
    const savedFormData = JSON.parse(localStorage.getItem("formData")) || {};
    for (const [field, value] of Object.entries(savedFormData)) {
      this.updateForm(field, value);
    }
  },
  methods: {
    toggleModal() {
      this.showModal = !this.showModal;
    },
    updateForm(field, value) {
      // Update Vuex store
      this.$store.commit("signup/setForm", {
        field: [field],
        value: value,
      });
      this.$store.commit("signup/removeValidationErros", {
        field: [field],
      });

      // Save form data to localStorage
      const formData = JSON.parse(localStorage.getItem("formData")) || {};
      formData[field] = value;
      localStorage.setItem("formData", JSON.stringify(formData));
    },
    updateSocialMedia() {
      this.$store.dispatch("signup/updateSocialMedia")
        .then((res) => {
          if (res.data.status == "Success") {
            // Clear localStorage on successful submission
            localStorage.removeItem("formData");
            window.location.href = res.data.data.redirect_url;
          }
        })
        .catch((errors) => {
          if (errors.response && errors.response.status == 422) {
            this.focusOnFirstErrorInput(errors.response.data.errors);
          }
        });
    },
    updateProfileSetting() {
      this.$store.dispatch("signup/updateProfileSetting").catch((errors) => {
        if (errors.response && errors.response.status == 422) {
          this.focusOnFirstErrorInput(errors.response.data.errors);
        }
      });
    },
    focusOnFirstErrorInput(errors) {
      // Find the first error field and focus on it
      const firstErrorField = Object.keys(errors)[0];
      if (
        firstErrorField == "business_categories_id" ||
        firstErrorField == "registration_package_id"
      ) {
        const containerDiv = document.getElementById(firstErrorField);
        containerDiv.scrollIntoView();
        return true;
      } else {
        const firstErrorInput = document.querySelector(
          `[id="${firstErrorField}"]`
        );

        if (firstErrorInput) {
          firstErrorInput.focus();
        }
      }
    },
    packagePrice() {
      let price = 0;
      if (this.payment_frequency == "monthly") {
        price = this.selectedRegistrationPackage.monthly_price;
      } else if (this.payment_frequency == "quarterly") {
        price = this.selectedRegistrationPackage.quarterly_price;
      } else if (this.payment_frequency == "semi_annually") {
        price = this.selectedRegistrationPackage.semi_annually_price;
      } else if (this.payment_frequency == "annually") {
        price = this.selectedRegistrationPackage.annually_price;
      }
      return price.toFixed(2);
    },
    calRefundPrice() {
      let price = 0;
      let prevPackagePrice = 0;

      // Get the previous package data
      if (JSON.parse(this.user).payment_frequency === "monthly") {
        prevPackagePrice = JSON.parse(this.user).package_price;
      } else if (JSON.parse(this.user).payment_frequency === "quarterly") {
        prevPackagePrice = JSON.parse(this.user).package_price * 3;
      } else if (JSON.parse(this.user).payment_frequency === "semi_annually") {
        prevPackagePrice = JSON.parse(this.user).package_price * 6;
      } else if (JSON.parse(this.user).payment_frequency === "annually") {
        prevPackagePrice = JSON.parse(this.user).package_price * 12;
      }

      let prevPackageStartDate = new Date(JSON.parse(this.user).package_subscribed_date);
      let prevPackageEndDate = new Date(JSON.parse(this.user).package_expiry_date);

      // Calculate the per-day price of the previous package
      const diffInTime = prevPackageEndDate.getTime() - prevPackageStartDate.getTime();
      const totalDaysOfPrevPackage = diffInTime / (1000 * 3600 * 24);
      const prevPackagePerDayPrice = prevPackagePrice / totalDaysOfPrevPackage;

      // Calculate the remaining days of the previous package
      const today = new Date();
      const remainingDays = (prevPackageEndDate.getTime() - today.getTime()) / (1000 * 3600 * 24);

      // Ensure remaining days are positive
      if (remainingDays > 0) {
        // Calculate the price to be deducted based on remaining days
        price = prevPackagePerDayPrice * remainingDays;
      }

      return price ? Math.round(price).toFixed(2) : '0.00';
    },
    calTotalPrice() {
      let price = 0;
      if (this.payment_frequency == "monthly") {
        price = this.selectedRegistrationPackage.monthly_price;
      } else if (this.payment_frequency == "quarterly") {
        price = this.selectedRegistrationPackage.quarterly_price * 3;
      } else if (this.payment_frequency == "semi_annually") {
        price = this.selectedRegistrationPackage.semi_annually_price * 6;
      } else if (this.payment_frequency == "annually") {
        price = this.selectedRegistrationPackage.annually_price * 12;
      }

      return price.toFixed(2);
    },
    async setPaymentMethod(value) {
      this.payment_method = value;
      if (value == "paypal") {
        this.toggleModal();
      }
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
    showCountdownModal(redirect_url) {
      let timerInterval;
      Swal.fire({
        title: "",
        html: `You will now be redirected to the PayPal website in <b></b> seconds to complete your payment. Once finished, you will be sent back here`,
        timer: 5000,
        timerProgressBar: true,
        allowOutsideClick: false,
        showCancelButton: false,
        cancelButtonText: "Cancel",
        showConfirmButton: true,
        confirmButtonText: "Cancel redirect",
        showCloseButton: false,
        background: "#fff",
        buttonsStyling: false,
        customClass: {
          confirmButton: "button-exp-fill",
        },
        didOpen: () => {
          // Swal.showLoading();
          const timer = Swal.getPopup().querySelector("b");
          timerInterval = setInterval(() => {
            timer.textContent = Math.round(Swal.getTimerLeft() / 1000);
          }, 1000);
        },
        willClose: () => {
          clearInterval(timerInterval);
          Swal.close();
        },
      }).then((result) => {
        /* Read more about handling dismissals below */
        if (result.dismiss === Swal.DismissReason.timer) {
          window.location.href = redirect_url;
        }
      });
    },
    processPayment() {
      this.$store.commit("signup/setForm", {
        field: "payment_method",
        value: this.payment_method,
      });
      this.loading = true;
      let url = `${process.env.MIX_WEB_API_URL}update-profile-setting`;
      axios
        .post(url, this.form)
        .then((response) => {
          if (response.data.status == "Success") {
            if (response?.data?.data?.type == "paypal") {
              // this.showCountdownModal(response?.data?.data?.redirect_url);
              window.location.href = response?.data?.data?.redirect_url;
            } else {
              // helper.swalSuccessMessageForWeb(response.data.message);
              window.location.href = this.url;
            }
          } else {
            helper.swalErrorMessageForWeb(response.data.message);
          }
          this.loading = false;
        })
        .catch((error) => {
          this.loading = 0;
          //   this.validationErros = new ErrorHandling();
          this.$store.commit("signup/setEmptyError");
          if (error.response && error.response.status == 422) {
            this.$store.commit(
              "signup/setValidationErros",
              error.response.data.errors
            );
            // this.validationErros.record(error.response.data.errors);
            this.focusOnFirstErrorInput(error.response.data.errors);
          } else if (
            error.response &&
            error.response.data &&
            error.response.data.status == "Error"
          ) {
            helper.swalErrorMessageForWeb(error.response.data.message);
          }
        });
    },
    alreadySelectedMonth(value) {
      let expiry_month = null;
      if (this.form && this.form.has('expiry_month')) {
        expiry_month = this.form.get('expiry_month');
      }
      return expiry_month == value ? 'selected' : false
    },
    alreadySelectedYear(value) {
      let expiry_year = null;
      if (this.form && this.form.has('expiry_year')) {
        expiry_year = this.form.get('expiry_year');
      }
      return expiry_year == value ? 'selected' : false
    }
  },
  props: ["profile", "user", "page_id", "hide_process_btn", "payment_setting", "url"],
};
</script>
