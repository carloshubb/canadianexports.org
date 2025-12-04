<template>
    <AppLayout>
        <div class="relative shadow-md rounded-md bg-white py-4">
            <header class="pt-4">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row items-center justify-center gap-4 md:justify-between">
                        <h3 class="can-exp-h3 text-primary"> {{isFormEdit ? 'Edit' : 'Create'}} business category </h3>
                        <router-link :to="{ name: 'admin.business_categories.index' }"
                            class="inline-flex items-center button-exp-fill">
                            Back
                        </router-link>
                    </div>
                </div>
            </header>
            <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">

                <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 w-full overflow-x-auto">
                    <ul class="flex mb-2 mt-4">
                        <li class="mr-2" v-for="language in languages" :key="language.id">
                            <a @click.prevent="changeLanguageTab(language)" href="#"
                                :class="['inline-block rounded font-FuturaMdCnBT px-5 py-2 lg:text-lg md:text-base sm:text-base text-base hover:bg-blue-100 border border-primary text-center hover:border-blue-500 hover:text-blue-600',
                                    ((activeTab == null && language.is_default) || activeTab == language.id ?
                                        'bg-blue-600 text-white' : ''), (validationErros.has(
                                        `name.name_${language.id}`) ? 'bg-red-600 border-red-600 text-white hover:text-white rounded hover:bg-red-600 hover:border-red-600' : '')
                                ]">{{ language . name }}</a>
                        </li>
                    </ul>
                </div>


                <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2  lg:grid-cols-2 gap-6 " v-for="language in languages" :key="language.id"
                    :class="(activeTab == null && language.is_default) || activeTab == language.id ? 'block' : 'hidden'">
                    <div class="relative z-0 w-full group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" " @input="handleNameInput($event.target.value, language)"
                            :value="form['name'] && form['name'][`name_${language.id}`] ? form['name'][`name_${language.id}`] : ''" />
                        <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`name.name_${language.id}`)"
                            v-text="validationErros.get(`name.name_${language.id}`)"></p>
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
                loading: state => state.business_categories.loading,
                form: state => state.business_categories.form,
                isFormEdit: state => state.business_categories.isFormEdit,
                validationErros: state => state.business_categories.validationErros,
                languages: state => state.languages.languages,
            }),
        },
        data(){
            return {
                activeTab: null,
            }
        },
        methods: {
            handleNameInput(value, language){
                this.$store.commit('business_categories/updateName', {
                    'name': value,
                    'id': language.id,
                });
            },
            addUpdateForm(){
                this.$store.dispatch('business_categories/addUpdateForm')
                .then(() => this.$router.push({name: 'admin.business_categories.index'}));
            },
            changeLanguageTab(language){
                this.activeTab = language.id;
            },
            fetchBusinessCategory(){
                if(this.$route.params.id){
                    let id = this.$route.params.id;
                    this.$store.commit('business_categories/setIsFormEdit', 1);
                    this.$store.dispatch('business_categories/fetchBusinessCategory', {
                        id: id,
                        url: `${process.env.MIX_ADMIN_API_URL}business-categories/${id}?withBusinessCategoryDetail=1`
                    }).then(res => {
                        let data = res.data.data && res.data.data.business_category_detail ? res.data.data.business_category_detail : [];
                        let obj = {};
                        data.map(res => {
                            obj['name_'+res.language_id] = res.name;
                        });
                        this.$store.commit('business_categories/setName', obj);
                    });
                }
            }
        },
        created(){
            this.$store.commit('business_categories/resetForm');
            this.$store.dispatch('languages/fetchLanguages', {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`
            }).then(res => {
                let data = res.data.data;
                let obj = {};
                data.map(res => {
                    obj['name_'+res.id] = '';
                });
                this.$store.commit('business_categories/setName', obj);
                this.fetchBusinessCategory();
            });
        }
    };
</script>
