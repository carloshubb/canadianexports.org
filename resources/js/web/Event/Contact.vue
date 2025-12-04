<template>
    <p class="button-exp-fill cursor-pointer" @click.prevent="showModal = 1">{{event_detail_setting && JSON.parse(event_detail_setting) ? JSON.parse(event_detail_setting)['contacts_text'] : ''}}</p>
    <div id="defaultModal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 bottom-0 m-auto z-10 overflow-y-auto" v-if="showModal">
        <div class="fixed inset-0 z-100 bg-gray-500 bg-opacity-75 transition-opacity" @click.prevent="toggleModal()"></div>
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow w-full sm:max-w-2xl top-0 left-0 right-0 bottom-0 m-auto">
                <!-- Modal header -->
                <div class="flex items-center justify-between py-3 px-3 border-b rounded-t">
                    <h3 class="card-heading text-primary text-gray-900">{{event_detail_setting && JSON.parse(event_detail_setting) ? JSON.parse(event_detail_setting)['contact_information_modal_title'] : ''}}</h3>
                    <button aria-label="Candian Exporters" type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 inline-flex items-center"
                        data-modal-hide="defaultModal" @click="toggleModal">
                        <img class="h-6" src="/assets/icons/19-X-inside-circle-2.png" alt="Candian Exporters">
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-3 md:p-6 space-y-3">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-left">
                        <div class="flex gap-2 items-start">
                            <div class="pt-2 align-top text-base md:text-base lg:text-lg text-primary">{{event_detail_setting && JSON.parse(event_detail_setting) ? JSON.parse(event_detail_setting)['contact_information_modal_name'] : ''}}</div>
                            <div class="pt-2 align-top text-base md:text-base lg:text-lg text-slate-600">{{JSON.parse(event)['contact_name']}}</div>
                        </div>
                        <div class="flex gap-2 items-start">
                            <div class="pt-2 align-top text-base md:text-base lg:text-lg text-primary">{{event_detail_setting && JSON.parse(event_detail_setting) ? JSON.parse(event_detail_setting)['contact_information_modal_email'] : ''}}</div>
                            <div class="pt-2 align-top text-base md:text-base lg:text-lg text-slate-600">{{JSON.parse(event)['contact_email']}}</div>
                        </div>
                        <div class="flex gap-2 items-start">
                            <div class="pt-2 align-top text-base md:text-base lg:text-lg text-primary">{{event_detail_setting && JSON.parse(event_detail_setting) ? JSON.parse(event_detail_setting)['contact_information_modal_phone'] : ''}}</div>
                            <div class="pt-2 align-top text-base md:text-base lg:text-lg text-slate-600">{{JSON.parse(event)['contact_phone']}}</div>
                        </div>
                        <div class="flex gap-2 items-start">
                            <div class="pt-2 align-top text-base md:text-base lg:text-lg text-primary">{{event_detail_setting && JSON.parse(event_detail_setting) ? JSON.parse(event_detail_setting)['contact_information_modal_designation'] : ''}}</div>
                            <div class="pt-2 align-top text-base md:text-base lg:text-lg text-slate-600">{{JSON.parse(event)['contact_designation']}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["event", "event_detail_setting"],
    data() {
        return {
            showModal: false,
        };
    },
    methods: {
        toggleModal() {
            if(!this.showModal){
                this.clearForm();
            }
            this.showModal = !this.showModal;
        },
    },
};
</script>
