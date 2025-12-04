<template>
    <div class="relative shadow-md sm:rounded-lg bg-white py-4">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center py-4">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-bold text-primary mb-2" v-if="isLoggedInSponsor">
                        My Sponsorships
                    </h1>
                    <p class="text-gray-600">
                        <template v-if="sponsers && sponsers.length == 0">
                            <span v-if="isLoggedInSponsor">
                                You haven't created any sponsorships yet. Click "Add Another Sponsorship" to get started!
                            </span>
                            <span v-else>
                                {{
                                    sponser_setting &&
                                        sponser_setting.sponser_listing_setting_detail &&
                                        sponser_setting
                                            .sponser_listing_setting_detail[0]
                                        ? sponser_setting
                                            .sponser_listing_setting_detail[0]
                                            .no_sponser_found_text
                                        : "No sponsorships found."
                                }}
                            </span>
                        </template>
                        <template v-else-if="sponsers && sponsers.length > 0">
                            <span v-if="isLoggedInSponsor">
                                Manage and track all your sponsorship contributions
                            </span>
                            <span v-else>
                                {{
                                    sponser_setting &&
                                        sponser_setting.sponser_listing_setting_detail &&
                                        sponser_setting
                                            .sponser_listing_setting_detail[0]
                                        ? sponser_setting
                                            .sponser_listing_setting_detail[0]
                                            .user_has_sponsers_text
                                        : ""
                                }}
                            </span>
                        </template>
                    </p>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <div class="flex items-center justify-between gap-2">
                        <a aria-label="Candian Exporters" 
                            :href="`/${sponsor_become}/become-a-sponsor`"
                            class="button-exp-fill" 
                            v-if="isLoggedInSponsor">
                            {{
                                sponser_setting &&
                                    sponser_setting.sponser_listing_setting_detail &&
                                    sponser_setting
                                        .sponser_listing_setting_detail[0]
                                    ? sponser_setting
                                        .sponser_listing_setting_detail[0]
                                        .add_sponser_btn_text
                                    : "Add Another Sponsorship"
                            }}
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
                                        class="sticky top-0 z-0 bg-primary backdrop-blur backdrop-filter py-3.5 pl-3 pr-3 text-left font-FuturaMdCnBT text-white lg:text-xl md:text-lg text-lg font-normal">
                                        {{
                                            sponser_setting &&
                                                sponser_setting.sponser_listing_setting_detail &&
                                                sponser_setting
                                                    .sponser_listing_setting_detail[0]
                                                ? sponser_setting
                                                    .sponser_listing_setting_detail[0]
                                                    .title_text
                                                : "Sponsorship"
                                        }}
                                    </th>
                                    <th v-if="isLoggedInSponsor"
                                        class="sticky top-0 z-0 bg-primary backdrop-blur backdrop-filter py-3.5 pl-3 pr-3 text-left font-FuturaMdCnBT text-white lg:text-xl md:text-lg text-lg font-normal">
                                        Amount
                                    </th>
                                    <th v-if="isLoggedInSponsor"
                                        class="sticky top-0 z-0 bg-primary backdrop-blur backdrop-filter py-3.5 pl-3 pr-3 text-left font-FuturaMdCnBT text-white lg:text-xl md:text-lg text-lg font-normal">
                                        Status
                                    </th>
                                    <th v-if="isLoggedInSponsor"
                                        class="sticky top-0 z-0 bg-primary backdrop-blur backdrop-filter py-3.5 pl-3 pr-3 text-center font-FuturaMdCnBT text-white lg:text-xl md:text-lg text-lg font-normal">
                                        {{
                                            sponser_setting &&
                                            sponser_setting.sponser_listing_setting_detail &&
                                            sponser_setting
                                                .sponser_listing_setting_detail[0]
                                                ? sponser_setting
                                                      .sponser_listing_setting_detail[0]
                                                      .action_text
                                                : "Actions"
                                        }}
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="flex-1 text-gray-700 sm:flex-none">
                                <tr v-for="sponser in sponsers" :key="sponser.id" class="even:bg-gray-50 odd:bg-white">
                                    <td class="p-2 md:p-3 relative border-none">
                                        <div class="flex items-center gap-3">
                                            <div v-if="sponser.logo_media" class="w-12 h-12 flex-shrink-0">
                                                <img 
                                                    :src="`/${sponser.logo_media.path}`" 
                                                    :alt="sponser.business_name"
                                                    class="w-full h-full object-contain rounded"
                                                />
                                            </div>
                                            <div>
                                                <div class="font-semibold">{{ sponser.business_name }}</div>
                                                <div v-if="sponser.summary" class="text-sm text-gray-500 line-clamp-1">
                                                    {{ sponser.summary }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td v-if="isLoggedInSponsor" class="p-2 md:p-3 relative border-none">
                                        <span class="font-medium text-primary">
                                            ${{ formatAmount(sponser.sponsorship_amount) }}
                                        </span>
                                    </td>
                                    <td v-if="isLoggedInSponsor" class="p-2 md:p-3 relative border-none">
                                        <div class="flex flex-col gap-1">
                                            <span
                                                class="px-2 py-1 rounded-full text-xs font-medium inline-block w-fit"
                                                :class="{
                                                    'bg-green-100 text-green-800': sponser.status === 'active',
                                                    'bg-yellow-100 text-yellow-800': sponser.status === 'pending',
                                                    'bg-gray-100 text-gray-800': sponser.status === 'inactive',
                                                }"
                                            >
                                                {{ sponser.status }}
                                            </span>
                                            <span
                                                v-if="sponser.payment_status"
                                                class="px-2 py-1 rounded-full text-xs font-medium inline-block w-fit"
                                                :class="{
                                                    'bg-green-100 text-green-800': sponser.payment_status === 'paid',
                                                    'bg-yellow-100 text-yellow-800': sponser.payment_status === 'pending',
                                                }"
                                            >
                                                {{ sponser.payment_status }}
                                            </span>
                                        </div>
                                    </td>
                                    <td v-if="isLoggedInSponsor" class="p-2 md:p-3 border-none">
                                        <div class="flex gap-2 justify-center">
                                            <a :href="`/${sponsor_become}/user/sponsor-settings/${sponser.id}`"
                                                class="px-3 py-1.5 bg-primary text-white rounded hover:bg-opacity-90 text-sm">
                                                {{sponser_setting?.sponser_listing_setting_detail?.[0]?.edit_button_text || 'Edit'}}
                                            </a>
                                            <a :href="`/sponsor-detail/${sponser.slug}`"
                                                target="_blank"
                                                class="px-3 py-1.5 border border-gray-300 text-gray-700 rounded hover:bg-gray-50 text-sm">
                                                View
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div v-if="pagination"
                        class="flex items-center justify-between mt-6 bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                        <!-- Pagination Info -->
                        <div class="text-sm text-gray-600">
                            Showing <span class="font-medium">{{ pagination.from }}</span> to <span
                                class="font-medium">{{
                                pagination.to }}</span> of <span class="font-medium">{{ pagination.total }}</span>
                            entries
                        </div>

                        <!-- Pagination Controls -->
                        <div class="flex items-center space-x-1">
                            <!-- Previous Button -->
                            <button @click="fetchSponsers(pagination.prev_page_url)"
                                :disabled="!pagination.prev_page_url"
                                class="px-3 py-1 rounded border border-gray-300 text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 transition">
                                Previous
                            </button>

                            <!-- Page Numbers - Explicitly filter out unwanted labels -->
                            <template v-for="link in pagination.links" :key="link.label">
                                <button v-if="link.url && isNumeric(link.label)" @click="fetchSponsers(link.url)"
                                    :class="{
                                        'px-3 py-1 rounded border transition': true,
                                        'border-blue-500 bg-blue-500 text-white': link.active,
                                        'border-gray-300 text-gray-700 hover:bg-gray-50': !link.active
                                    }">
                                    {{ link.label }}
                                </button>
                            </template>

                            <!-- Next Button -->
                            <button @click="fetchSponsers(pagination.next_page_url)"
                                :disabled="!pagination.next_page_url"
                                class="px-3 py-1 rounded border border-gray-300 text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 transition">
                                Next
                            </button>
                        </div>
                    </div>
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
        isLoggedInSponsor() {
            if (!this.logged_in_user || this.logged_in_user === 'null') return false;
            try {
                const user = JSON.parse(this.logged_in_user);
                return user && user.type === 'sponsor';
            } catch {
                return false;
            }
        }
    },
    data() {
        return {
            quickSearch: null,
            sponser_setting: null,
            sponsers: [],
            pagination: {
                current_page: 1,
                last_page: 1,
                links: [],
                meta: {},
            },
        };
    },
    methods: {
        isNumeric(label) {
            return /^\d+$/.test(label.trim());
        },
        formatAmount(amount) {
            if (!amount) return '0.00';
            return parseFloat(amount).toFixed(2);
        },
        fetchSponsers(page_url) {
            this.$store.dispatch("events/fetchSponser", {
                url: page_url,
                type: "web",
            });
        },
        updateLimit(value) {
            this.$store.commit("events/setLimit", value);
            this.$store.dispatch("events/fetchSponsers", {
                type: "web",
            });
        },
        quickSearchFilter: _.debounce(function () {
            // this.$store.commit("events/setSearchParam", this.quickSearch);
            this.$store.dispatch("events/fetchSponsers", {
                type: "web",
            });
        }, 500),
        // async fetchSponsers(pageUrl = null) {
        //     this.loading = true;
        //     try {
        //         const url = pageUrl || `${process.env.MIX_WEB_API_URL}sponsers`;
        //         const response = await axios.get(url);

        //         if (response.data.status === "Success") {
        //             this.sponsers = response.data.data;
        //             this.pagination = {
        //                 current_page: response.data.meta.current_page,
        //                 last_page: response.data.meta.last_page,
        //                 from: response.data.meta.from,
        //                 to: response.data.meta.to,
        //                 total: response.data.meta.total,
        //                 links: response.data.meta.links,
        //                 next_page_url: response.data.links.next,
        //                 prev_page_url: response.data.links.prev,
        //             };
        //         } else {
        //             console.error(
        //                 "API returned error status:",
        //                 response.data.message
        //             );
        //         }
        //     } catch (error) {
        //         console.error("Error fetching sponsors:", error);
        //         if (error.response) {
        //             console.error("Response data:", error.response.data);
        //             console.error("Status code:", error.response.status);
        //         } else if (error.request) {
        //             console.error("No response received");
        //         } else {
        //             console.error("Error:", error.message);
        //         }
        //     } finally {
        //         this.loading = false;
        //     }
        // },
        async fetchSponsers(pageUrl = null) {
            this.loading = true;
            try {
                const user = JSON.parse(this.logged_in_user);
                let url = pageUrl || `${process.env.MIX_WEB_API_URL}sponsers`;

                // If user is logged in, filter sponsors by their customer_id
                if (user && user.id) {
                    url += (url.includes('?') ? '&' : '?') + `customer_id=${user.id}`;
                }

                const response = await axios.get(url);

                if (response.data.status === "Success") {
                    this.sponsers = response.data.data;
                    this.pagination = {
                        current_page: response.data.meta.current_page,
                        last_page: response.data.meta.last_page,
                        from: response.data.meta.from,
                        to: response.data.meta.to,
                        total: response.data.meta.total,
                        links: response.data.meta.links,
                        next_page_url: response.data.links.next,
                        prev_page_url: response.data.links.prev,
                    };
                } else {
                    console.error(
                        "API returned error status:",
                        response.data.message
                    );
                }
            } catch (error) {
                console.error("Error fetching sponsors:", error);
                if (error.response) {
                    console.error("Response data:", error.response.data);
                    console.error("Status code:", error.response.status);
                } else if (error.request) {
                    console.error("No response received");
                } else {
                    console.error("Error:", error.message);
                }
            } finally {
                this.loading = false;
            }
        },
    },
    created() {
        this.$store.commit("events/setLimit", 1000);
        this.$store.commit("events/setSortBy", "id");
        this.$store.commit("events/setSortType", "desc");
        // this.$store.dispatch("events/fetchSponsers", {
        //     type: 'web'
        // });
        this.$store
            .dispatch("events/fetchSponserListingSetting", {
                page_id: this.page_id,
            })
            .then((res) => {
                if (res.data.status == "Success") {
                    this.sponser_setting = res.data.data;
                }
            });
    },
    mounted() {
        this.fetchSponsers();
        console.log("Sponsor URL:", this.sponsor_become);
    },
    watch: {
        quickSearch: function () {
            this.quickSearchFilter();
        },
    },
    props: [
        "sponsor_become",
        "url",
        "page_id",
        "upgrade_url",
        "logged_in_user",
    ],
};
</script>

<style scoped>
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
