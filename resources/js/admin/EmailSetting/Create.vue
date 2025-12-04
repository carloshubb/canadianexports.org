<template>
    <AppLayout>
        <div class="relative shadow-md sm:rounded-lg bg-white py-4">
            <header class="pt-4">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h3 class="can-exp-h3 text-primary"> Edit email setting </h3>
                    </div>
                </div>
            </header>
            <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">

                <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2  lg:grid-cols-2 gap-6 ">
                    <div class="relative z-0 w-full group" v-for="reg_package in registration_packages" :key="reg_package.id">
                        <label :for="`package_${reg_package.id}`">{{reg_package.registration_package_detail && reg_package.registration_package_detail[0] ? reg_package.registration_package_detail[0].name : ''}} emails per day</label>
                        <input
                        type="text"
                        :id="`package_${reg_package.id}`"
                        class="can-exp-input w-full block border border-gray-300 rounded"
                        placeholder=" "
                        @input="
                            handleEmailSettingInput($event.target.value, reg_package)
                        "
                        :value="
                            form['no_of_emails'] &&
                            form['no_of_emails'][`no_of_emails_${reg_package.id}`]
                                ? form['no_of_emails'][`no_of_emails_${reg_package.id}`]
                                : ''
                        "
                    />


                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`no_of_emails.no_of_emails_${reg_package.id}`)"
                            v-text="validationErros.get(`no_of_emails.no_of_emails_${reg_package.id}`)"></p>
                    </div>
                    <div class="relative z-0 w-full group" v-for="gsetting in general_setting" :key="gsetting.id">
                        <label :for="`email_setting_${gsetting.id}`">{{gsetting['display_text']}}</label>
                        <input
                        type="text"
                        :id="`email_setting_${gsetting.id}`"
                        class="can-exp-input w-full block border border-gray-300 rounded"
                        placeholder=" "
                        @input="
                            handleEmailFromSettingInput($event.target.value, gsetting)
                        "
                        :value="
                            form['canadian_exporters_emails'] &&
                            form['canadian_exporters_emails'][`canadian_exporters_emails_${gsetting.id}`]
                                ? form['canadian_exporters_emails'][`canadian_exporters_emails_${gsetting.id}`]
                                : ''
                        "
                    />


                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`canadian_exporters_emails.canadian_exporters_emails_${gsetting.id}`)"
                            v-text="validationErros.get(`canadian_exporters_emails.canadian_exporters_emails_${gsetting.id}`)"></p>
                    </div>
                </div>


                <button type="submit" class="button-exp-fill" :disabled="loading">Submit</button>
            </form>
        </div>

    </AppLayout>
</template>


<script>
    import { mapState } from 'vuex'
    export default {
        computed:{
            ...mapState({
                loading: state => state.email_setting.loading,
                form: state => state.email_setting.form,
                validationErros: state => state.email_setting.validationErros,
                registration_packages: state => state.registration_packages.registration_packages,
                general_setting: state => state.general_setting.general_setting,
            }),
        },
        methods: {
            handleEmailFromSettingInput(value, gsetting){
                this.$store.commit('email_setting/updateCanadianExportersEmails', {
                    'canadian_exporters_emails': value,
                    'id': gsetting.id,
                });
            },
            handleEmailSettingInput(value, registration_package){
                this.$store.commit('email_setting/updateNoOfEmails', {
                    'no_of_emails': value,
                    'id': registration_package.id,
                });
            },
            addUpdateForm(){
                this.$store.dispatch('email_setting/addUpdateForm');
            },
            fetchEmailSetting(){
                this.$store.dispatch('email_setting/fetchEmailSetting', {
                    url: `${process.env.MIX_ADMIN_API_URL}email-setting`
                }).then(res => {
                    let data = res.data.data;
                    let obj = {};
                    data.map(res => {
                        obj['no_of_emails_'+res.registration_package_id] = res.no_of_emails;
                    });
                    this.$store.commit('email_setting/setNoOfEmails', obj);
                });
            }
        },
        created(){
            this.$store.commit('email_setting/resetForm');
            this.$store.dispatch('registration_packages/fetchRegistrationPackages', {
                url: `${process.env.MIX_ADMIN_API_URL}registration-packages?getPackagesOnly=1&getAll=1`
            }).then(res => {
                let data = res.data.data;
                let obj = {};
                data.map(res => {
                    obj['no_of_emails_'+res.id] = '';
                });
                this.$store.commit('email_setting/setNoOfEmails', obj);
                this.fetchEmailSetting();
                this.$store.dispatch('general_setting/fetchGeneralSetting', {
                    url: `${process.env.MIX_ADMIN_API_URL}general-setting?onlyEmailSetting=1`
                }).then(res => {
                    let data = res.data.data;
                    let obj = {};
                    data.map(res => {
                        console.log(res);
                        obj['canadian_exporters_emails_'+res.id] = res.value;
                    });
                    this.$store.commit('email_setting/setCanadianExportersEmails', obj);
                });
            });
        }
    };
</script>
