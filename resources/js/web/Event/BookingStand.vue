<template>
    <a
        aria-label="Candian Exporters"
        @click.prevent="showModal = 1"
        class="button-exp-fill cursor-pointer"
        >{{
            event_detail_setting && JSON.parse(event_detail_setting)
                ? JSON.parse(event_detail_setting)["book_a_stand_text"]
                : ""
        }}</a
    >
    <div
        id="defaultModal"
        tabindex="-1"
        aria-hidden="true"
        class="fixed top-0 left-0 right-0 bottom-0 m-auto z-10 overflow-y-auto"
        v-if="showModal"
    >
        <div
            class="fixed inset-0 z-100 bg-gray-500 bg-opacity-75 transition-opacity"
            @click.prevent="toggleModal()"
        ></div>
        <div class="flex min-h-full items-end justify-center p-4 sm:p-0">
            <!-- Modal content -->
            <div
                class="relative bg-white rounded-lg shadow w-full sm:max-w-2xl top-0 left-0 right-0 bottom-0 m-auto"
            >
                <!-- Modal header -->
                <div
                    class="flex items-center justify-between py-3 px-3 border-b rounded-t"
                >
                    <h3 class="card-heading text-primary text-gray-900">
                        {{
                            event_detail_setting &&
                            JSON.parse(event_detail_setting)
                                ? JSON.parse(event_detail_setting)[
                                      "book_a_stand_modal_title"
                                  ]
                                : ""
                        }}
                    </h3>
                    <button
                        aria-label="Candian Exporters"
                        type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 inline-flex items-center"
                        data-modal-hide="defaultModal"
                        @click="toggleModal"
                    >
                        <img
                            class="h-6"
                            src="/assets/icons/19-X-inside-circle-2.png"
                            alt="Candian Exporters"
                        />
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <form @submit.prevent="recaptcha()">
                        <div class="w-full mt-2">
                            <div
                                class="flex flex-col sm:flex-col md:flex-row lg:flex-row gap-4"
                            >
                                <div class="w-full">
                                    <label
                                        for="name"
                                        class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg"
                                    >
                                        {{
                                            event_detail_setting &&
                                            JSON.parse(event_detail_setting)
                                                ? JSON.parse(
                                                      event_detail_setting
                                                  )["book_a_stand_modal_name"]
                                                : ""
                                        }}
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <div>
                                        <input
                                            type="text"
                                            class="can-exp-input"
                                            id="name"
                                            name="name"
                                            placeholder=""
                                            autofocus=""
                                            v-model="form.name"
                                        />
                                    </div>
                                    <Error
                                        class="w-full"
                                        fieldName="name"
                                        :validationErros="validationErros"
                                    />
                                </div>
                                <div class="w-full">
                                    <label
                                        for="email"
                                        class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg"
                                        >{{
                                            event_detail_setting &&
                                            JSON.parse(event_detail_setting)
                                                ? JSON.parse(
                                                      event_detail_setting
                                                  )["book_a_stand_modal_email"]
                                                : ""
                                        }}
                                        <span class="text-red-500"
                                            >*</span
                                        ></label
                                    >
                                    <div>
                                        <input
                                            type="text"
                                            class="can-exp-input"
                                            id="email"
                                            name="email"
                                            placeholder=""
                                            v-model="form.email"
                                        />
                                    </div>
                                    <Error
                                        class="w-full"
                                        fieldName="email"
                                        :validationErros="validationErros"
                                    />
                                </div>
                            </div>
                            <div class="w-full group mt-4">
                                <label
                                    for="message"
                                    class="block text-gray-700 mb-2 text-base md:text-base lg:text-lg"
                                    >{{
                                        event_detail_setting &&
                                        JSON.parse(event_detail_setting)
                                            ? JSON.parse(event_detail_setting)[
                                                  "book_a_stand_modal_message"
                                              ]
                                            : ""
                                    }}
                                    <span class="text-red-500">*</span></label
                                >
                                <textarea
                                    id="message"
                                    rows="4"
                                    class="can-exp-input w-full block border rounded"
                                    placeholder=""
                                    v-model="form.message"
                                ></textarea>
                                <Error
                                    fieldName="message"
                                    :validationErros="validationErros"
                                />
                            </div>
                            <div class="w-full group mt-4">
                                <Error
                                    fieldName="captcha"
                                    :validationErros="validationErros"
                                />
                            </div>
                        </div>
                        <div class="mt-5 flex items-center justify-end gap-4">
                            <button
                                aria-label="Candian Exporters"
                                type="submit"
                                class="button-exp-fill"
                            >
                                {{
                                    event_detail_setting &&
                                    JSON.parse(event_detail_setting)
                                        ? JSON.parse(event_detail_setting)[
                                              "book_a_stand_modal_submit_btn"
                                          ]
                                        : ""
                                }}
                            </button>
                        </div>
                    </form>
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
import { load } from "recaptcha-v3";
import axios from "axios";
import ErrorHandling from "../../ErrorHandling";
import Error from "./../components/Error.vue";
export default {
    props: ["event_id", "submit_url", "event_detail_setting"],
    components: {
        Error,
    },
    data() {
        return {
            loading: false,
            showModal: false,
            form: {
                event_id: null,
                name: null,
                email: null,
                message: null,
            },
            validationErros: new ErrorHandling(),
            reCAPTCHA_site_key: process.env.MIX_reCAPTCHA_site_key,
        };
    },
    methods: {
        clearForm() {
            this.form.event_id = null;
            this.form.name = null;
            this.form.email = null;
            this.form.message = null;
        },
        toggleModal() {
            this.clearForm();
            this.showModal = !this.showModal;
        },
        async recaptcha() {
            this.loading = 1;
            load(process.env.MIX_reCAPTCHA_site_key).then((recaptcha) => {
                recaptcha.showBadge()
                recaptcha.execute("submit").then((token) => {
                    axios
                        .post(`${process.env.MIX_WEB_API_URL}verifyRecaptcha`, {
                            token: token,
                        })
                        .then((res) => {
                            setTimeout(() => {
                                recaptcha.hideBadge()
                            }, 3000);
                            if (res.data.status == "Success") {
                                this.submitForm();
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
        submitForm() {
            this.loading = 1;
            this.form.event_id = this.event_id;
            axios
                .post(this.submit_url, this.form)
                .then((res) => {
                    if (res.data.status == "Success") {
                        helper.swalSuccessMessageForWeb(res.data.message);
                        this.clearForm();
                        this.toggleModal();
                    } else {
                        helper.swalErrorMessageForWeb(res.data.message);
                    }
                    this.loading = 0;
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
    },
};
</script>
