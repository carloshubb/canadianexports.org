<template>
    <section class="mt-8">
        <div class="grid grid-cols-12 bg-white rounded shadow p-6 mb-4 transition-all">
            <div class="col-span-12 md:col-span-4 w-full">
                <a aria-label="Candian Exporters" :href="url" class="h-60 bg-gray-50 p-1 rounded shadow flex justify-center items-center">
                    <template v-if="JSON.parse(event)['media_path']">
                        <img
                        class="h-full object-cover"
                        :src="JSON.parse(event)['media_path']"
                        alt="Candian Exporters"
                    />
                    </template>
                    <template v-else>
                        <img
                            class="h-full object-contain"
                            src="/assets/images/logocircle.png"
                            alt="Candian Exporters"
                        />
                    </template>
                </a>
                    <a aria-label="Candian Exporters" :href="url" class="w-full button-exp-fill mt-2 hidden md:block">{{ JSON.parse(home_page_setting)['section5_event_detail_button_text'] }}</a>
            </div>
            <div class="col-span-12 md:col-span-8 w-full md:px-4 pt-4 md:pt-0">
                <div>
                    <h2 class="text-primary card-heading">{{ JSON.parse(event)['event_detail'] && JSON.parse(event)['event_detail'][0] ? JSON.parse(event)['event_detail'][0]['title'] : '' }}
                    </h2>
                </div>
                <div>
                    <p>{{ JSON.parse(event)['package_type'] === 'featured' ? JSON.parse(event)['event_detail'][0]['short_description'] : '' }}
                    </p>
                </div>
                <table class="border-spacing-y-3 border-separate px-0 text-lg border-none">
                    <tbody class=" border-none">
                        <tr class=" border-none">
                            <td class="text-primary whitespace-nowrap text-base md:text-base lg:text-lg border-none align-top">
                                    {{
                                    event_detail_setting && JSON.parse(event_detail_setting) ? JSON.parse(event_detail_setting)['event_date_text'] : ''
                                    }}
                                </td>
                            <td class="text-base md:text-base lg:text-lg border-none pl-3">
                                    {{ JSON.parse(event)['start_date'] }} - {{ JSON.parse(event)['end_date'] }}
                                </td>
                        </tr>
                        <tr class=" border-none">
                            <td class="text-primary whitespace-nowrap text-base md:text-base lg:text-lg border-none align-top">
                                    {{
                                    event_detail_setting && JSON.parse(event_detail_setting) ? JSON.parse(event_detail_setting)['venue_text'] : ''
                                    }}
                                </td>
                            <td class="text-base md:text-base lg:text-lg border-none pl-3">
                                {{ JSON.parse(event)['event_detail'] && JSON.parse(event)['event_detail'][0] ? JSON.parse(event)['event_detail'][0]['venue'] : '' }}
                                </td>
                        </tr>
                        <tr class=" border-none">
                            <td class="text-primary whitespace-nowrap text-base md:text-base lg:text-lg border-none align-top">
                                    {{
                                    event_detail_setting && JSON.parse(event_detail_setting) ? JSON.parse(event_detail_setting)['location_text'] : ''
                                    }}
                                </td>
                            <td class="text-base md:text-base lg:text-lg border-none pl-3">
                                    {{ JSON.parse(event)['event_detail'] && JSON.parse(event)['event_detail'][0] ? JSON.parse(event)['event_detail'][0]['city'] : '' }}, {{ JSON.parse(event)['event_detail'] && JSON.parse(event)['event_detail'][0] ? JSON.parse(event)['event_detail'][0]['country'] : '' }}
                                </td>
                        </tr>
                    </tbody>
                </table>
                <div class="w-full mt-2 block md:hidden">
                    <a aria-label="Candian Exporters" :href="url" class="w-full button-exp-fill">{{ JSON.parse(home_page_setting)['section5_event_detail_button_text'] }}</a>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
export default {
    props:['event', 'home_page_setting', 'url', 'event_detail_setting'],
}
</script>
