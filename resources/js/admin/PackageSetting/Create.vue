<template>
    <AppLayout>
        <div class="relative shadow-md sm:rounded-lg bg-white py-4">
            <header class="pt-4">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h3 class="can-exp-h3 text-primary"> Edit package setting </h3>
                    </div>
                </div>
            </header>
            <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
                <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2  lg:grid-cols-2 gap-6 ">
                    <div class="relative z-0 w-full group" v-for="setting in general_setting" :key="setting.id">
                        <label :for="setting.key">{{setting.display_text}}</label>
                        <input type="text" :name="setting.key" :id="setting.key"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" " :value="setting.value" @input="updateForm(setting.key, $event.target.value)" />
                    </div>
                </div>
                <button type="submit"
                    class="button-exp-fill mt-5" :disabled="loading">Submit</button>
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
                url: `${process.env.MIX_ADMIN_API_URL}general-setting?onlyPackageSetting=1`
            });
        },
    };
</script>
