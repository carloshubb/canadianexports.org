<template>
    <AppLayout>

        <div class="relative shadow-md sm:rounded-lg bg-white py-4">
            <header class="pt-4">
                <div class="px-8">
                    <h2 class="can-exp-h3 text-primary">General Settings</h2>
                    <p class="text-base text-gray-600">General setting for website pages</p>
                </div>
            </header>
            <form class="px-4 md:px-6 lg:px-8 mt-8" @submit.prevent="addUpdateForm()">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    <div class="relative z-0 w-full group" v-for="setting in general_setting" :key="setting.id">
                        <label class="block text-sm font-medium leading-6 text-gray-900" :for="setting.key">{{setting.display_text}}</label>
                        <input type="text" :name="setting.key" :id="setting.key"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                            placeholder=" " :value="setting.value" @input="updateForm(setting.key, $event.target.value)" />
                    </div>
                </div>
                <div class="mt-8">
                    <button type="submit" class="inline-flex items-center gap-x-2 button-exp-fill" :disabled="loading">
                    <svg class="-ml-0.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                    Save settings
                </button>
                </div>

            </form>
        </div>

    </AppLayout>
</template>

<script>

    import { mapState } from 'vuex'
    export default {
        computed:{
            ...mapState({
                loading: state => state.general_setting.loading,
                form: state => state.general_setting.form,
                general_setting: state => state.general_setting.general_setting,
                validationErros: state => state.general_setting.validationErros,
            }),
        },
        methods: {
            updateForm(field, value){
                this.$store.commit('general_setting/updateForm', {
                    value: value,
                    key: field
                });
            },
            addUpdateForm(){
                this.$store.dispatch('general_setting/addUpdateForm');
            },
        },
        created(){
            this.$store.commit('general_setting/resetForm');
            this.$store.dispatch('general_setting/fetchGeneralSetting', {
                url: `${process.env.MIX_ADMIN_API_URL}general-setting?onlyGeneralSetting=1`
            });
        },
    };
</script>
