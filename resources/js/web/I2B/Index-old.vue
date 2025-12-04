<template>
    <div>
      <div
        class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 mt-8 gap-5"
        v-if="inquiries"
      >
        <div
          class="group rounded-md shadow hover:-translate-y-2 transition-all duration-500 ease-in-out relative z-0"
          :class="is_home_page ? 'bg-white' : 'bg-white'"
          :id="`i2b-${inquiry.id}`"
          v-for="inquiry in JSON.parse(inquiries)"
          :key="inquiry.id"
        >
          <div
            v-if="page == 'advance_search'"
            class="absolute top-6"
            :class="
              lang && JSON.parse(lang) && JSON.parse(lang)['direction'] == 'ltr'
                ? 'right-2'
                : 'left-2'
            "
            @click.prevent="removeI2b(inquiry.id, 'i2b')"
          >
            <img
              class="h-6 cursor-pointer md:mt-2"
              src="/assets/icons/19-X-inside-circle-2.png"
              alt="Candian Exporters"
            />
          </div>
          <div class="content flex flex-col h-full">
            <div class="flex-1">
              <a
                aria-label="Candian Exporters"
                href="#"
                @click.prevent="
                  displayI2BModal(
                    inquiry.id,
                    inquiry['i2b_detail'] && inquiry['i2b_detail'][0]
                      ? inquiry['i2b_detail'][0]['name']
                      : ''
                  )
                "
                class="flex card-heading pt-6 px-6"
                >{{
                  inquiry["i2b_detail"] && inquiry["i2b_detail"][0]
                    ? inquiry["i2b_detail"][0]["name"]
                    : ""
                }}</a
              >

              <div class="w-full">
                <table class="mt-4 border-none w-full">
                  <tbody class="border-none">
                    <tr class="mt-2 border-none even:bg-white odd:bg-gray-50">
                      <td
                        class="pt-2 px-4 py-2 align-top text-base md:text-base lg:text-lg text-primary whitespace-nowrap border-none"
                      >
                        {{
                          JSON.parse(home_page_setting_detail)[
                            "section2_category_label"
                          ]
                        }}
                      </td>
                      <td
                        class="pt-2 px-4 py-2 align-top text-base md:text-base lg:text-lg text-slate-600 pl-2 border-none"
                      >
                        {{ inquiry["business_category_name"] }}
                      </td>
                    </tr>
                    <tr class="mt-2 border-none even:bg-white odd:bg-gray-50">
                      <td
                        class="pt-2 px-4 py-2 align-top text-base md:text-base lg:text-lg text-primary whitespace-nowrap border-none"
                      >
                        {{
                          JSON.parse(home_page_setting_detail)[
                            "section2_country_label"
                          ]
                        }}
                      </td>
                      <td
                        class="pt-2 px-4 py-2 align-top text-base md:text-base lg:text-lg text-slate-600 pl-2 border-none"
                      >
                        {{
                          inquiry["i2b_detail"] && inquiry["i2b_detail"][0]
                            ? inquiry["i2b_detail"][0]["country_name"]
                            : ""
                        }}
                      </td>
                    </tr>
                    <tr class="mt-2 border-none even:bg-white odd:bg-gray-50">
                      <td
                        class="pt-2 px-4 py-2 align-top text-base md:text-base lg:text-lg text-primary whitespace-nowrap border-none"
                      >
                        {{
                          JSON.parse(home_page_setting_detail)[
                            "section2_deadline_label"
                          ]
                        }}
                      </td>
                      <td
                        class="pt-2 px-4 py-2 align-top text-base md:text-base lg:text-lg text-slate-600 pl-2 border-none"
                      >
                        {{ inquiry["deadline_date"] }}
                      </td>
                    </tr>
                    <tr class="mt-2 border-none even:bg-white odd:bg-gray-50">
                      <td
                        class="pt-2 px-4 py-2 align-top text-base md:text-base lg:text-lg text-primary whitespace-nowrap border-none"
                      >
                        {{
                          JSON.parse(home_page_setting_detail)[
                            "section2_estimated_value_label"
                          ]
                        }}
                      </td>
                      <td
                        class="pt-2 px-4 py-2 align-top text-base md:text-base lg:text-lg text-slate-600 pl-2 border-none"
                      >
                        ${{ inquiry["estimated_value"] }}
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <hr class="" />
            <div class="mt-4 pb-6 px-6 flex-end" v-if="display_all_i2b">
              <a
                aria-label="Candian Exporters"
                :href="
                  JSON.parse(home_page_setting_detail)['section2_button_url']
                "
                class="can-exp-a btn btn-link after:bg-secondary duration-500 ease-in-out flex items-center gap-1 w-fit"
                @click.prevent="
                  displayI2BModal(
                    inquiry.id,
                    inquiry['i2b_detail'] && inquiry['i2b_detail'][0]
                      ? inquiry['i2b_detail'][0]['name']
                      : ''
                  )
                "
                >{{
                  JSON.parse(home_page_setting_detail)["section2_i2b_button_text"]
                }}
              </a>
            </div>
          </div>
        </div>
      </div>

      <div
        class="fixed top-0 left-0 right-0 bottom-0 m-auto z-[1000] overflow-y-auto"
        aria-labelledby="modal-title"
        role="dialog"
        aria-modal="true"
        v-if="isI2BModalDisplayed"
      >
        <div
          class="fixed inset-0 z-100 bg-gray-500 bg-opacity-75 transition-opacity"
          @click.prevent="hideI2BModal()"
        ></div>

        <div class="overflow-y-auto">
          <div
            class="flex min-h-full items-end justify-center p-4 sm:items-center sm:p-0"
          >
            <div
              class="relative transform overflow-y-auto rounded-lg bg-white shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-4xl"
            >
              <div class="bg-white p-4">
                <div class="sm:items-start">
                  <div class="sm:mt-0">
                    <div
                      class="flex items-center justify-between pb-2 border-b rounded-t"
                    >
                      <h3 class="card-heading text-primary" id="modal-title">
                        {{
                          JSON.parse(modal_setting)
                            ? JSON.parse(modal_setting)["greeting_text"]
                            : ""
                        }}

  {{
                          customer.name || ''
                        }},
                      </h3>
                      <button
                        aria-label="Candian Exporters"
                        @click.prevent="hideI2BModal()"
                        type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg p-1.5 inline-flex items-center"
                        data-modal-hide="defaultModal"
                      >
                        <img
                          class="h-6"
                          src="/assets/icons/19-X-inside-circle-2.png"
                          alt="Candian Exporters"
                        />
                        <span class="sr-only">Close modal</span>
                      </button>
                    </div>
                    <div class="" v-if="isUserLoggedIn">
                      <div class="">
                        <p class="can-exp-p py-2">
                          {{
                            JSON.parse(modal_setting)
                              ? JSON.parse(modal_setting)["free_package_text"]
                              : ""
                          }}
                        </p>
                      </div>


                      <div
                        v-if="
                          customer &&
                          (customer.i2b_remaining <= 0 ||
                            customer.i2b_remaining == null ||
                            customer.is_package_expire == '1')
                        "
                      >
                        <div class="mt-2">
                          <p
                            class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg gap-1"
                          >
                            <Upgrade
                              :user="customer"
                              display_type="text"
                              :modal_setting="JSON.parse(modal_setting)"
                            />

                            {{
                              JSON.parse(modal_setting)
                                ? JSON.parse(modal_setting)["i2b_package_text"]
                                : ""
                            }}
                          </p>
                        </div>
                        <!-- <div class="mt-2">
                                                  <p class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg">Packages</p>
                                              </div> -->
                        <div class="mt-2">
                          <div
                            class="relative w-full mb-3 flex gap-2 items-center"
                            v-for="i2bPackage in i2bPackages"
                            :key="i2bPackage.id"
                          >
                            <input
                              type="radio"
                              :id="`i2b_package_${i2bPackage.id}`"
                              name="i2b_package_id"
                              class="h-4 w-4 border-gray-300 accent-primaryRed"
                              @click="updateI2BPackage(i2bPackage)"
                            />
                            <label
                              class="block font-medium text-gray-900"
                              :for="`i2b_package_${i2bPackage.id}`"
                              >{{
                                i2bPackage.registration_package_detail &&
                                i2bPackage.registration_package_detail[0]
                                  ? i2bPackage.registration_package_detail[0]
                                      .amount_pre_text
                                  : ""
                              }}
                              - ${{
                                i2bPackage.discount_price > 0
                                  ? i2bPackage.discount_price
                                  : i2bPackage.price
                              }}
                              -
                              {{
                                i2bPackage.registration_package_detail &&
                                i2bPackage.registration_package_detail[0]
                                  ? i2bPackage.registration_package_detail[0]
                                      .amount_post_text
                                  : ""
                              }}</label
                            >
                          </div>
                          <Error
                            fieldName="package_id"
                            :validationErros="validationErros"
                            full_width="1"
                          />
                        </div>
                        <div
                          class="flex justify-between items-center p-3 border-b"
                        >
                          <div class="w-full">
                            <div class="flex items-center">
                              <input
                                id="stripe"
                                name="registration-package"
                                type="radio"
                                class="h-4 w-4 border-gray-300 accent-primaryRed"
                                @click="setPaymentMethod('stripe')"
                                :checked="form.payment_method == 'stripe'"
                              />
                              <label for="stripe" class="ml-2 block text-gray-900"
                                >
                                          {{payment_setting ? payment_setting['pay_with_credit_card_text'] : ''}}
                                      </label>
                            </div>
                            <div class="flex items-center">
                              <input
                                id="paypal"
                                name="registration-package"
                                type="radio"
                                class="h-4 w-4 border-gray-300 accent-primaryRed"
                                @click="setPaymentMethod('paypal')"
                                :checked="form.payment_method == 'paypal'"
                              />
                              <label for="paypal" class="ml-2 block text-gray-900"
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
                                  </defs></svg></label>
                            </div>
                            <div
                              id="card-element"
                              class="border border-primary rounded p-2 mt-2 mb-2"
                              v-if="
                                form.customer_payment_method_id ==
                                  'add_new_card' &&
                                form.payment_method == 'stripe'
                              "
                            >
                              <div class="flex justify-center items-center">
                                <div
                                  class="h-auto bg-white p-3 rounded-lg w-full"
                                >
                                  <div class="input_text mt-6 relative">
                                    <label class="">{{
                                      payment_setting
                                        ? payment_setting["cardholder_name_label"]
                                        : ""
                                    }}</label>
                                    <i class="text-gray-400 fa fa-user"></i>
                                    <input
                                      type="text"
                                      class="can-exp-input"
                                      :placeholder="
                                        payment_setting
                                          ? payment_setting[
                                              'cardholder_name_placeholder'
                                            ]
                                          : ''
                                      "
                                      v-model="form.card_holder_name"
                                    />
                                    <Error
                                      fieldName="card_holder_name"
                                      :validationErros="validationErros"
                                      full_width="1"
                                    />
                                  </div>
                                  <div class="input_text mt-2 relative">
                                    <label class="">{{
                                      payment_setting
                                        ? payment_setting["card_number_label"]
                                        : ""
                                    }}</label>
                                    <i
                                      class="text-gray-400 fa fa-credit-card"
                                    ></i>
                                    <input
                                      type="text"
                                      class="can-exp-input"
                                      :placeholder="
                                        payment_setting
                                          ? payment_setting[
                                              'card_number_placeholder'
                                            ]
                                          : ''
                                      "
                                      v-model="form.card_no"
                                      @keypress="restrictToNumbers($event, 16)"
                                    />
                                    <Error
                                      fieldName="card_no"
                                      :validationErros="validationErros"
                                      full_width="1"
                                    />
                                  </div>
                                  <div class="input_text mt-2 relative">
                                    <label class="">{{
                                      payment_setting
                                        ? payment_setting["expiry_month_label"]
                                        : ""
                                    }}</label>

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
                                    <Error
                                      fieldName="expiry_month"
                                      :validationErros="validationErros"
                                      full_width="1"
                                    />
                                  </div>
                                  <div class="input_text mt-2 relative">
                                    <label class="">{{
                                      payment_setting
                                        ? payment_setting["expiry_year_label"]
                                        : ""
                                    }}</label>
                                    <select class="rounded-md px-3 pr-8 py-1 w-full" v-model="form.expiry_year">
                                                  <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
                                          </select>
                                    <Error
                                      fieldName="expiry_year"
                                      :validationErros="validationErros"
                                      full_width="1"
                                    />
                                  </div>
                                  <div class="input_text mt-2 relative">
                                    <label class="">{{
                                      payment_setting
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
                                        payment_setting
                                          ? payment_setting['cvv_placeholder']
                                          : ''
                                      "
                                      v-model="form.cvc"
                                      @keypress="restrictToNumbers($event, 4)"
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
                        <div
                          class="flex justify-between items-center p-3 border-b"
                          v-if="form.payment_method == 'stripe'"
                        >
                          <div class="flex items-center gap-2">
                            <label
                              for="cards"
                              class="block mb-2 text-base md:text-base lg:text-lg font-medium text-gray-900 dark:text-white"
                              >Cards</label
                            >
                            <select
                              id="cards"
                              class="can-exp-input"
                              v-model="form.customer_payment_method_id"
                            >
                              <option
                                :value="customerPaymentMethod.id"
                                v-for="customerPaymentMethod in customerPaymentMethods"
                                :key="customerPaymentMethod.id"
                              >
                                {{ customerPaymentMethod.card_no }}
                              </option>
                              <option value="add_new_card">Add new card</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="mt-2 mb-4">
                        <Error
                          fieldName="captcha"
                          :validationErros="validationErros"
                          full_width="1"
                        />
                      </div>
                      <div class="mt-2 flex items-center justify-center">
                        <button
                          aria-label="Candian Exporters"
                          type="submit"
                          class="button-exp-fill"
                          @click="reCAPTCHA()"
                        >
                          {{
                            JSON.parse(modal_setting)
                              ? JSON.parse(modal_setting)[
                                  "i2b_modal_submit_button_text"
                                ]
                              : ""
                          }}
                        </button>
                      </div>
                    </div>
                    <div v-else-if="!isUserLoggedIn">
                      <div>
                        <p class="can-exp-p py-2">
                          {{
                            JSON.parse(modal_setting)
                              ? JSON.parse(modal_setting)["i2b_modal_body_text"]
                              : ""
                          }}
                        </p>
                      </div>

                      <p class="text-right mt-3">
                        <span class="text-red-500">*</span>
                        <span class="text-red-500">{{
                          JSON.parse(modal_setting)
                            ? JSON.parse(modal_setting)["required_feild_text"]
                            : ""
                        }}</span>
                      </p>
                      <form @submit.prevent="loginCustomer()">
                        <div
                          class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-4"
                        >
                          <div class="w-full">
                            <label
                              for="email"
                              class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg"
                              >{{
                                JSON.parse(login_page_setting_detail)[
                                  "email_label"
                                ]
                              }}
                              <span class="text-red-500">*</span></label
                            >
                            <div>
                              <input
                                type="text"
                                class="can-exp-input"
                                id="email"
                                name="email"
                                placeholder=""
                                autofocus=""
                                v-model="login_form.email"
                              />
                            </div>
                            <Error
                              fieldName="email"
                              :validationErros="validationErros"
                              full_width="1"
                            />
                          </div>
                          <div class="w-full">
                            <label
                              for="password"
                              class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg"
                              >{{
                                JSON.parse(login_page_setting_detail)[
                                  "password_label"
                                ]
                              }}
                              <span class="text-red-500">*</span></label
                            >
                            <div class="mt-2 relative">
                              <input
                                class="can-exp-input"
                                id="password"
                                :type="display_password"
                                name="password"
                                autocomplete="current-password"
                                v-model="login_form.password"
                              />
                              <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-5 h-5 text-gray-500 absolute top-3"
                                :class="
                                  lang &&
                                  JSON.parse(lang) &&
                                  JSON.parse(lang)['direction'] == 'ltr'
                                    ? 'right-3'
                                    : 'left-3'
                                "
                                @click="display_password = 'text'"
                                v-if="display_password == 'password'"
                              >
                                <path
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"
                                />
                              </svg>
                              <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-5 h-5 text-gray-500 absolute top-3"
                                :class="
                                  lang &&
                                  JSON.parse(lang) &&
                                  JSON.parse(lang)['direction'] == 'ltr'
                                    ? 'right-3'
                                    : 'left-3'
                                "
                                @click="display_password = 'password'"
                                v-else-if="display_password == 'text'"
                              >
                                <path
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"
                                />
                                <path
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                />
                              </svg>
                            </div>
                            <Error
                              fieldName="password"
                              :validationErros="validationErros"
                              full_width="1"
                            />
                          </div>
                        </div>
                        <div class="mt-5 flex items-center justify-end gap-4">
                          <a
                            aria-label="Candian Exporters"
                            :href="register_url"
                            class="button-exp-no-fill"
                            >{{
                              JSON.parse(modal_setting)
                                ? JSON.parse(modal_setting)["signup_button_text"]
                                : ""
                            }}</a
                          >
                          <button
                            aria-label="Candian Exporters"
                            type="submit"
                            class="button-exp-fill"
                          >
                            {{
                              JSON.parse(login_page_setting_detail)[
                                "signin_btn_text"
                              ]
                            }}
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
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
  </template>

  <script>
  import Error from "./../components/Error.vue";
  import Upgrade from "../signup/Upgrade";
  import ErrorHandling from "../../ErrorHandling";
  import axios from "axios";
  import { mapState } from "vuex";
  export default {
    props: [
      "inquiries",
      "home_page_setting_detail",
      "display_all_i2b",
      "login_page_setting_detail",
      "inquiry_id",
      "register_url",
      "modal_setting",
      "user",
      "lang",
      "page",
      "is_home_page",
    ],
    computed: {
      ...mapState({
        customerPaymentMethods: (state) => state.signup.customerPaymentMethods,
      }),
      years() {
              const currentYear = new Date().getFullYear();
              return Array.from({ length: 16 }, (_, index) => currentYear + index);
          },
    },
    components: {
      Error,
      Upgrade,
    },
    data() {
      return {
        display_password: "password",
        loading: false,
        reCAPTCHA_site_key: process.env.MIX_reCAPTCHA_site_key,
        selectedI2bPackage: null,
        selectedPaymentMethod: "stripe",
        i2BOrder: {
          price: 0,
          id: null,
        },
        order: {
          price: 0,
          id: null,
        },
        stripe: null,
        cardElement: null,
        isI2BModalDisplayed: 0,
        isUpgradeModalDisplayed: 0,
        isUpgradeI2BModalDisplayed: 0,
        paymentMethodId: null,
        inquiryId: null,
        isUserLoggedIn: false,
        customer: [],
        payment_setting: [],
        customerPackages: [],
        i2bPackages: [],
        validationErros: new ErrorHandling(),
        login_form: {
          email: "",
          password: "",
          inquiry_id: "",
        },
        form: {
          company_name: "",
          company_email: "",
          inquiry_detail: "",
          package_id: "",
          inquiry_id: "",
          customer_inquiry_id: "",
          payment_method: "stripe",
          customer_payment_method_id: "",
          card_holder_name: "",
          card_no: "",
          expiry_month: ("0" + (new Date().getMonth() + 1)).slice(-2),
                  expiry_year: new Date().getFullYear(),
          cvc: "",
          order_amount: 0,
        },
      };
    },
    methods: {
      resetValues() {
        this.form.company_name = "";
        this.form.company_email = "";
        this.form.inquiry_detail = "";
        this.form.package_id = "";
        this.form.inquiry_id = "";
        this.form.customer_inquiry_id = "";
        this.validationErros = new ErrorHandling();
        this.login_form.email = "";
        this.login_form.password = "";
        this.login_form.inquiry_id = "";
        this.selectedI2bPackage = null;
        this.selectedPaymentMethod = "stripe";
        this.i2BOrder.price = 0;
        this.i2BOrder.id = null;
        this.order.price = 0;
        this.order.id = null;
        this.stripe = null;
        this.cardElement = null;
        this.isI2BModalDisplayed = 0;
        this.isUpgradeModalDisplayed = 0;
        this.isUpgradeI2BModalDisplayed = 0;
        this.paymentMethodId = null;
        this.inquiryId = null;
        this.isUserLoggedIn = false;
        this.customer = [];
        this.customerPackages = [];
        this.i2bPackages = [];
      },
      displayI2BModal(i2bId, i2bName) {
        this.resetValues();
        this.loading = 1;
        axios
          .post(`${process.env.MIX_APP_URL}/get-logged-in-user`)
          .then((res) => {
            this.isI2BModalDisplayed = 1;
            this.inquiryId = i2bId;
            this.loading = 0;
            if (res.data.status == "Success") {
              this.isUserLoggedIn = true;
              this.customer = res.data.data.customer;
              this.payment_setting = res.data.data.payment_setting;
              axios
                .get(
                  `${process.env.MIX_APP_URL}/get-registration-packages?getPayToGoPackagesOnly=1`
                )
                .then((res) => {
                  if (res.data.status == "Success") {
                    this.i2bPackages = res.data.data;
                    this.form.inquiry_detail = i2bName;
                  }
                });
            } else {
              this.isUserLoggedIn = false;
            }
          })
          .finally(() => (this.loading = false));
      },
      loginCustomer() {
        this.loading = true;
        this.login_form.inquiry_id = this.inquiryId;
        axios
          .post(`${process.env.MIX_APP_URL}/logged-in-user`, this.login_form)
          .then((res) => {
            this.loading = 0;
            if (res.data.status == "Success") {
              location.reload();
            } else {
              helper.swalErrorMessageForWeb(res.data.message);
              this.isUserLoggedIn = false;
            }
          })
          .catch((error) => {
            this.loading = false;
            this.validationErros = new ErrorHandling();
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
      hideI2BModal() {
        this.isI2BModalDisplayed = 0;
        this.inquiryId = null;
      },
      async setPaymentMethod(value) {
        this.form.payment_method = value;
      },
      updateI2BPackage(i2bPackage) {
        this.selectedI2bPackage = i2bPackage;
        this.form.package_id = i2bPackage.id;
        this.form.order_amount =
          i2bPackage.discount_price > 0
            ? i2bPackage.discount_price
            : i2bPackage.price;
      },
      async recaptcha() {
        this.loading = 1;
        await this.$recaptchaLoaded();
        const token = await this.$recaptcha("submit");
        axios
          .post(`${process.env.MIX_WEB_API_URL}verifyRecaptcha`, {
            token: token,
          })
          .then((res) => {
            if (res.data.status == "Success") {
              this.saveForm();
            } else if (res.data.status == "Error") {
              this.loading = 0;
              this.validationErros.record({
                captcha: [res.data.message],
              });
            }
          });
      },
      saveForm() {
        this.savePremiumInquiry();
      },
      savePremiumInquiry() {
        this.form.inquiry_id = this.inquiryId;
        this.loading = true;
        axios
          .post(`${process.env.MIX_APP_URL}/save-inquiry`, this.form)
          .then((res) => {
            this.loading = false;
            if (res.data.status == "Success") {
              if (res?.data?.data?.type == "paypal") {
                window.location.href = res?.data?.data?.redirect_url;
              } else {
                helper.swalSuccessMessageForWeb(res.data.message);
                this.hideI2BModal();
              }
            } else if (res.data.status == "Error") {
              helper.swalErrorMessageForWeb(res.data.message);
            }
          })
          .catch((error) => {
            this.loading = false;
            this.validationErros = new ErrorHandling();
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
      restrictToNumbers(event, allowedLength) {
        const keyCode = event.which ? event.which : event.keyCode;
        const valid = keyCode >= 48 && keyCode <= 57; // Check if the key code is between 0 and 9
        const maxLengthReached = event.target.value.length >= allowedLength;

        if (!valid || maxLengthReached) {
          event.preventDefault();
        }
        return true;
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
                this.form.customer_payment_method_id = p_method[0]["id"];
              }
            }
          });
      },
      removeI2b(i2bId, type) {
        axios
          .post(`${process.env.MIX_APP_URL}/remove-exports-from-search`, {
            id: i2bId,
            type: type,
          })
          .then((res) => {
            document.querySelector(`#i2b-${i2bId}`).classList.add("hidden");
          });
      },
    },
    created() {
      if (this.inquiry_id) {
        this.displayI2BModal(this.inquiry_id, null);
      }
      this.fetchPaymentMethods();
    },
  };
  </script>
