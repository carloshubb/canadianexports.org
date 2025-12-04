<template>
    <div>
        <div class="lg:col-start-3 lg:row-end-1">
            <div class="rounded-lg bg-gray-50 shadow-sm ring-1 ring-gray-900/5">
                <dl class="flex flex-wrap">
                    <div class="flex-auto px-6 py-4">
                        <h3 class="text-md leading-tight text-gray-900">Pages</h3>
                    </div>
                    <div class="w-full gap-x-4 border-t border-gray-900/5 px-6">
                        <div class="h-40 overflow-y-auto border rounded p-4 mt-2">
                            <ul v-for="page in pages" :key="page.id" class="space-y-2">
                                <li class="gap-2 items-center flex">
                                    <input type="checkbox" name="pages" @click="updateSelectedPages($event.target.checked, page)"
                                        :id="`page_${page.id}`"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" />
                                    <label
                                        :for="`page_${page.id}`">{{ page . page_detail && page . page_detail[0] ? page . page_detail[0] . name : '' }}</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </dl>
                <div class="mt-6 flex justify-end border-t border-gray-900/5 px-6 py-4">
                    <button type="button" class="inline-flex items-center gap-x-1.5 rounded-md bg-primary px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary"
                    @click.prevent="addToMenu()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ml-0.5 h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                        </svg>
                        Add to menu
                    </button>
                </div>
            </div>
        </div>

        <!-- <div class="lg:col-start-3 lg:row-end-1 mt-8">
            <div class="rounded-lg bg-gray-50 shadow-sm ring-1 ring-gray-900/5">
                <dl class="flex flex-wrap">
                    <div class="flex-auto px-6 py-4">
                        <h3 class="text-md leading-tight text-gray-900">Custom link</h3>
                    </div>
                    <div class="w-full gap-x-4 border-t border-gray-900/5 px-6">
                        <div class="grid md:grid-cols-1 md:gap-2">
                            <div class="relative z-0 w-full group mt-2">
                                <label for="link" class="block text-sm font-medium leading-6 text-gray-900">URL</label>
                                    <div class="mt-2">
                                        <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                            <input type="text" name="link" id="link" class="block flex-1 border-0 bg-transparent py-1.5 pl-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="" v-model="custom_link">
                                        </div>
                                    </div>
                            </div>
                            <div class="relative z-0 w-full group mt-2">
                                <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Page name</label>
                                    <div class="mt-2">
                                        <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                            <input type="text" name="name" id="name" class="block flex-1 border-0 bg-transparent py-1.5 pl-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="" v-model="custom_name">
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </dl>
                <div class="mt-6 flex justify-end border-t border-gray-900/5 px-6 py-4">
                    <button type="button" class="inline-flex items-center gap-x-1.5 rounded-md bg-primary px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary"
                    @click.prevent="addNewItemInMenu">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ml-0.5 h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                        </svg>
                        Add to menu
                    </button>
                </div>
            </div>
        </div> -->
    </div>
</template>
<script>
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            pages: (state) => state.pages.pages,
        })
    },
    data(){
        return {
            selectedPages: [],
            custom_name: null,
            custom_link: null,
        }
    },
    created(){
        this.selectedPages = [];
        this.custom_name = null;
        this.custom_link = null;
    },
    methods:{
        updateSelectedPages(value, page){
            if(value){
                this.selectedPages.push({
                    id:Math.floor(Math.random() * 1000000),
                    page_id:page.id,
                    name:page.page_detail[0].name,
                    slug:`${page.slug}`,
                });
            }
            else{
                this.selectedPages.map((res, index) => {
                    if(res.page_id == page.id){
                        // delete res[index]
                        this.selectedPages.splice(index, 1);
                        return true;
                    }
                });
            }
        },
        addToMenu(){
            this.selectedPages.map(res => {
                this.$emit('addMenuItem', res.id, res.page_id, res.name, res.slug)
            });
            document.querySelectorAll('input[name=pages]').forEach(el => el.checked = false);
            this.selectedPages = []
        },
        addNewItemInMenu(){
            if(this.custom_name == null || this.custom_name == '' || this.custom_link == null || this.custom_link == ''){
                helper.swalErrorMessage("Name and link is required.");
                return false;
            }
            this.$emit('addMenuItem', Math.floor(Math.random() * 1000000), null, this.custom_name, this.custom_link)
        }
    }
};
</script>
