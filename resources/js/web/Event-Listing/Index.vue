<template>
    <div class="rounded-lg bg-gradient-to-r from-indigo-300 via-purple-300 to-pink-300 p-0.5 hover:-translate-y-2 transition-all duration-500 ease-in-out relative" :id="
            event && JSON.parse(event) ? `event-${JSON.parse(event)['id']}` : ''
        ">
    <div
        class="group flex flex-col h-full pb-6 pt-4 text-sm rounded-lg shadow bg-white relative z-0"

    >
        <div
            v-if="page == 'advance_search'"
            class="flex justify-end absolute -top-3 -right-3 h-6 w-6 bg-white rounded-full"
            @click.prevent="removeEvents(JSON.parse(event)['id'], 'events')"
        >
            <img
                class="h-6 cursor-pointer"
                src="/assets/icons/19-X-inside-circle-2.png"
                alt="Candian Exporters"
            />
        </div>

        <div class="flex-1">
            <div
                class="h-60 flex justify-center bg-gray-50 p-1 items-center rounded px-6"
            >
                <a aria-label="Candian Exporters" :href="url" class="">
                    <template v-if="JSON.parse(event)['media_path']">
                        <img
                            class="h-60 rounded aspect-video object-cover w-full"
                            :src="
                                JSON.parse(event)['media_path']
                                    ? JSON.parse(event)['media_path']
                                    : ''
                            "
                            alt="Candian Exporters"
                        />
                    </template>
                    <template v-else>
                        <img
                            class="h-60 rounded aspect-video object-contain w-full"
                            src="/assets/images/logocircle.png"
                            alt="Candian Exporters"
                        />
                    </template>
                </a>
            </div>
            <div class="content mt-3">
                <div class="px-6">
                    <a
                        aria-label="Candian Exporters"
                        :href="url"
                        class="card-heading flex-auto"
                        >{{
                            JSON.parse(event)["event_detail"] &&
                            JSON.parse(event)["event_detail"][0]
                                ? JSON.parse(event)["event_detail"][0]["title"]
                                : ""
                        }}
                    </a>
                    <p class="text-base mt-1">
                        {{
                            JSON.parse(event)["event_detail"] &&
                            JSON.parse(event)["event_detail"][0]
                                ? JSON.parse(event)["event_detail"][0]["short_description"]
                                : ""
                        }}
                    </p>
                    <p class="text-sm mt-1">
                        {{
                            JSON.parse(event)["event_detail"] &&
                            JSON.parse(event)["event_detail"][0]
                                ? JSON.parse(event)["event_detail"][0]["city"]
                                : ""
                        }},
                        {{
                            JSON.parse(event)["event_detail"] &&
                            JSON.parse(event)["event_detail"][0]
                                ? JSON.parse(event)["event_detail"][0][
                                      "country"
                                  ]
                                : ""
                        }}
                    </p>
                    <p class="text-base mt-1">
                        {{ JSON.parse(event)["start_date"] }} -
                        {{ JSON.parse(event)["end_date"] }}
                    </p>
                </div>
                <div>
                    <table class="w-full mb-0 mt-4 flex-1 border-none">
                        <thead></thead>
                        <tbody class="border-none">
                            <!-- <tr class="border-none even:bg-white odd:bg-gray-100">
                                <td
                                    class="align-top text-base md:text-base lg:text-lg text-primary whitespace-nowrap border-none px-6 py-2"
                                >
                                    {{
                                        event_detail_setting &&
                                        JSON.parse(event_detail_setting)
                                            ? JSON.parse(event_detail_setting)[
                                                  "event_date_text"
                                              ]
                                            : ""
                                    }}
                                </td>
                                <td
                                    class="align-top text-base md:text-base lg:text-lg text-slate-600 pl-4 border-none px-6 py-2"
                                >
                                    {{ JSON.parse(event)["start_date"] }} -
                                    {{ JSON.parse(event)["end_date"] }}
                                </td>
                            </tr>
                            <tr class="border-none even:bg-white odd:bg-gray-100">
                                <td
                                    class="align-top text-base md:text-base lg:text-lg text-primary whitespace-nowrap border-none px-6 py-2"
                                >
                                    {{
                                        event_detail_setting &&
                                        JSON.parse(event_detail_setting)
                                            ? JSON.parse(event_detail_setting)[
                                                  "venue_text"
                                              ]
                                            : ""
                                    }}
                                </td>
                                <td
                                    class="align-top text-base md:text-base lg:text-lg text-slate-600 pl-4 border-none px-6 py-2"
                                >
                                    {{
                                        JSON.parse(event)["event_detail"] &&
                                        JSON.parse(event)["event_detail"][0]
                                            ? JSON.parse(event)[
                                                  "event_detail"
                                              ][0]["venue"]
                                            : ""
                                    }}
                                </td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="flex-end px-6">
            <div class="flex items-center gap-2 justify-between">
                <a
                    aria-label="Candian Exporters"
                    :href="url"
                    class="can-exp-a btn btn-link after:bg-secondary duration-500 ease-in-out flex items-center gap-1"
                >
                    {{
                        JSON.parse(home_page_setting)[
                            "section5_event_detail_button_text"
                        ]
                    }}
                </a>
                <a
                    aria-label="Candian Exporters"
                    :href="JSON.parse(event)['event_website']"
                    target="_blank"
                    class="can-exp-a btn btn-link after:bg-secondary duration-500 ease-in-out flex items-center gap-1 fix-url"
                    onclick="fixUrls()"
                >
                    {{
                        JSON.parse(home_page_setting)[
                            "section5_website_button_text"
                        ]
                    }}
                </a>
            </div>
        </div>
    </div>
     </div>
</template>

<script>
export default {
    props: [
        "event",
        "home_page_setting",
        "url",
        "event_detail_setting",
        "page",
        "lang",
    ],
    methods: {
        removeEvents(eventId, type) {
            this.$swal
                .fire({
                    text: "Are you sure you want to remove this listing from your search results?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    showCloseButton: true,
                    customClass: {
                        confirmButton:
                            "inline-flex items-center button-exp-fill",
                        cancelButton:
                            "inline-flex items-center bg-red-500 hover:bg-red-600 button-exp-fill cursor-pointer border-red-500",
                    },
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        axios
                            .post(
                                `${process.env.MIX_APP_URL}/remove-exports-from-search`,
                                {
                                    id: eventId,
                                    type: type,
                                }
                            )
                            .then((res) => {
                                document
                                    .querySelector(`#event-${eventId}`)
                                    .classList.add("hidden");
                            });
                    }
                });
        },
    },
};
</script>
