<template>
    <div class="relative shadow-md sm:rounded-lg bg-white py-4">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center py-4">
                <div class="sm:flex-auto">
                    <p class="text-primary">
                        <template v-if="events && events.length == 0">
                            {{ event_setting && event_setting.event_listing_setting_detail &&
                                event_setting.event_listing_setting_detail[0] ?
                                event_setting.event_listing_setting_detail[0].no_event_found_text : '' }}
                        </template>
                        <template v-else-if="events && events.length > 0">
                            {{ event_setting && event_setting.event_listing_setting_detail &&
                                event_setting.event_listing_setting_detail[0] ?
                                event_setting.event_listing_setting_detail[0].user_has_events_text : '' }}
                        </template>
                    </p>
                </div>
                <!-- <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <div class="flex items-center justify-between gap-2">
                        <a aria-label="Candian Exporters" :href="upgrade_url" class="button-exp-no-fill" v-if="JSON.parse(logged_in_user)?.type === 'event'">
                            {{event_setting?.event_listing_setting_detail?.[0]?.upgrade_profile_btn_text ?? 'Upgrade profile'}}
                        </a>
                        <a aria-label="Candian Exporters" :href="url" class="button-exp-fill" v-if="JSON.parse(logged_in_user)?.events_remaining !== '0'">
                            {{event_setting && event_setting.event_listing_setting_detail && event_setting.event_listing_setting_detail[0] ? event_setting.event_listing_setting_detail[0].add_event_btn_text : ''}}
                        </a>
                    </div>
                </div> -->
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <div class="flex items-center justify-between gap-2">
                        <a aria-label="Candian Exporters" :href="upgrade_url" class="button-exp-no-fill"
                            v-if="JSON.parse(logged_in_user)?.type === 'event'">
                            {{ event_setting?.event_listing_setting_detail?.[0]?.upgrade_profile_btn_text ??
                                'Upgrade profile' }}
                        </a>
                        <a href="#" class="button-exp-fill" @click.prevent="handleAddEventClick"
                            v-if="JSON.parse(logged_in_user)?.events_remaining !== '0'">
                            {{ event_setting && event_setting.event_listing_setting_detail &&
                                event_setting.event_listing_setting_detail[0] ?
                                event_setting.event_listing_setting_detail[0].add_event_btn_text : '' }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <div class="space-y-2">
                    <div class="bg-white shadow-lg hover:shadow-xl rounded-md overflow-x-auto">
                        <table
                            class="table overflow-x-auto table-auto w-full leading-normal text-base md:text-base lg:text-lg">
                            <thead class="text-white">
                                <tr class="hidden md:table-row">
                                    <th
                                        class="sticky top-0 z-0  bg-primary backdrop-blur backdrop-filter py-3.5 pl-3 pr-3 text-left font-FuturaMdCnBT text-white lg:text-xl md:text-lg text-lg font-normal">
                                        {{ event_setting && event_setting.event_listing_setting_detail &&
                                            event_setting.event_listing_setting_detail[0] ?
                                            event_setting.event_listing_setting_detail[0].title_text : '' }}
                                    </th>
                                    <th
                                        class="sticky top-0 z-0  bg-primary backdrop-blur backdrop-filter py-3.5 pl-3 pr-3 text-left font-FuturaMdCnBT text-white lg:text-xl md:text-lg text-lg font-normal text-center">
                                        {{ event_setting && event_setting.event_listing_setting_detail &&
                                            event_setting.event_listing_setting_detail[0] ?
                                            event_setting.event_listing_setting_detail[0].action_text : '' }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="flex-1 text-gray-700 sm:flex-none">
                                <tr v-for="event in events" :key="event.id" class="even:bg-gray-50 odd:bg-white">
                                    <td class="p-2 md:p-3 relative border-none">
                                        <!-- <label
                                                    class="text-gray-500 font-FuturaMdCnBT md:hidden text-xl"
                                                    for="">{{event_setting && event_setting.event_listing_setting_detail && event_setting.event_listing_setting_detail[0] ? event_setting.event_listing_setting_detail[0].title_text : ''}}
                                                </label> -->
                                        <div class="flex items-center gap-2 text-gray-900">
                                            <div class="w-10 h-10 rounded-full"> <img v-if="event.media"
                                                    class="w-10 h-10 rounded-full" :src="`/${event.media.path}`"
                                                    alt="event" />
                                            </div>
                                            <a class="whitespace-nowrap" :href="event.show_page">{{ event.event_detail
                                                &&
                                                event.event_detail[0] ? event.event_detail[0].title : '' }}</a>
                                        </div>
                                    </td>
                                    <td class="p-2 md:p-3 border-none">
                                        <div class="w-fit mx-auto">
                                            <a :href="`${url}?id=${event.id}&slug=${event.slug}`"
                                                class="button-exp-fill flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor"
                                                    class="-ml-0.5 w-4 h-4 mr-2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                                <span class="text-white">
                                                    {{ event_setting && event_setting.event_listing_setting_detail &&
                                                        event_setting.event_listing_setting_detail[0] ?
                                                        event_setting.event_listing_setting_detail[0].edit_button_text :
                                                        '' }}
                                                </span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <!-- <div class="px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6" v-if="pagination">
                        <div class="flex justify-between items-center w-full">
                            <div>
                                <p class="text-sm text-gray-700" v-if="pagination.current_page">
                                    Page {{ pagination . current_page }} of {{ pagination . last_page }}
                                </p>
                            </div>
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination" v-if="pagination.next_page_url || pagination.prev_page_url">
                                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50" v-bind:class="[{disabled: !pagination.prev_page_url}]" @click="fetchEvents(pagination.prev_page_url)">
                                        <span class="sr-only">Previous</span>
                                        <svg class="h-5 w-5" x-description="Heroicon name: solid/chevron-left"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50" v-bind:class="[{disabled: !pagination.next_page_url}]" @click="fetchEvents(pagination.next_page_url)">
                                        <span class="sr-only">Next</span>
                                        <svg class="h-5 w-5" x-description="Heroicon name: solid/chevron-right"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                </nav>
                            </div>
                        </div>
                    </div> -->






                </div>
            </div>
        </div>
    </div>
</template>
<script>
import _ from "lodash";
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            form: (state) => state.events.form,
            events: (state) => state.events.events,
            pagination: (state) => state.events.pagination,
            validationErros: (state) => state.events.validationErros,
            searchParam: (state) => state.events.searchParam,
            loading: (state) => state.events.loading,
        }),
    },
    data() {
        return {
            quickSearch: null,
            event_setting: null,
        };
    },
    methods: {
        handleAddEventClick() {
            const user = JSON.parse(this.logged_in_user);
            const langAbbr = this.$root.lang?.abbreviation || 'en'; // Adjust based on how you store language

            if (user && !user.is_package_amount_paid) {
                // Redirect unpaid users to review confirmation
                window.location.href = `${process.env.MIX_APP_URL}/${langAbbr}/user/review-confirmation`;
            } else {
                // Allow paid users to proceed to event creation
                window.location.href = this.url;
            }
        },

        fetchEvents(page_url) {
            this.$store.dispatch("events/fetchEvents", { url: page_url, type: 'web' });
        },
        updateLimit(value) {
            this.$store.commit("events/setLimit", value);
            this.$store.dispatch("events/fetchEvents", {
                type: 'web'
            });
        },
        quickSearchFilter: _.debounce(function () {
            this.$store.commit("events/setSearchParam", this.quickSearch);
            this.$store.dispatch("events/fetchEvents", {
                type: 'web'
            });
        }, 500),
    },
    created() {
        this.$store.commit("events/setLimit", 1000);
        this.$store.commit("events/setSortBy", "id");
        this.$store.commit("events/setSortType", "desc");
        this.$store.dispatch("events/fetchEvents", {
            type: 'web'
        });
        this.$store.dispatch("events/fetchEventListingSetting", {
            page_id: this.page_id
        }).then(res => {
            if (res.data.status == 'Success') {
                this.event_setting = res.data.data
            }
        });
    },
    watch: {
        quickSearch: function () {
            this.quickSearchFilter();
        },
    },
    props: ['url', 'page_id', 'upgrade_url', 'logged_in_user']
};
</script>
