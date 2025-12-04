<template>
    <AppLayout>
        <div class="relative shadow-md sm:rounded-lg bg-white py-4">
            <header class="pt-4">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h3 class="can-exp-h3 text-primary"> {{user ? user.name : ''}}  {{user ? `(${user.email})` : ''}} </h3>
                        <router-link :to="{ name: 'admin.users.index' }"
                            class="button-exp-fill">
                            Back
                        </router-link>
                    </div>
                </div>
            </header>

            <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 p-4">

                <div class="bg-white rounded divide-y space-y-3 p-4 shadow border h-full">
                    <h3 class="can-exp-h3 text-primary">Business categories</h3>
                        <div class="flex justify-between items-center pt-2 gap-4">
                            <p class="">Business categories</p>
                            <p>
                                <template v-if="user">
                                    <template v-for="business_category in user.customer_business_category">
                                        {{ business_category.business_category && business_category.business_category.business_category_detail && business_category.business_category.business_category_detail[0] ? business_category.business_category.business_category_detail[0].name+ ',' : '' }}
                                    </template>
                                </template>
                            </p>
                        </div>

                </div>

                <div class="">
                        <div class="bg-white rounded divide-y space-y-3 p-4 shadow border h-full">
                        <h3 class="can-exp-h3 text-primary">Customer packages</h3>
                            <div class="flex justify-between items-center pt-2 gap-4">
                                <p class="">Package name</p>
                                <p class="">{{user && user.registration_package && user.registration_package.registration_package_detail && user.registration_package.registration_package_detail[0] ? user.registration_package.registration_package_detail[0].name : ''}}</p>
                            </div>
                            <div class="flex justify-between items-center pt-2 gap-4">
                                <p class="">Package price</p>
                                <p class="">${{user.package_price}}</p>
                            </div>
                            <div class="flex justify-between items-center pt-2 gap-4">
                                <p class="">Payment frequency</p>
                                <p class="">{{user.payment_frequency}}</p>
                            </div>

                            <div class="flex justify-between items-center pt-2 gap-4">
                                <p class="">Package subscribed date</p>
                                <p class="">{{user ? user.package_subscribed_date : ''}}</p>
                            </div>

                            <div class="flex justify-between items-center pt-2 gap-4">
                                <p class="">Package expiry date</p>
                                <p class="">{{user ? user.package_expiry_date : ''}}</p>
                            </div>

                            <div class="flex justify-between items-center pt-2 gap-4">
                                <p class="">Payment status</p>
                                <p class="">{{user && user.is_package_amount_paid ? 'complete': 'pending'}}</p>
                            </div>

                            <div class="flex justify-between items-center pt-2 gap-4">
                                <p class="">Events allowed</p>
                                <p class="">{{user && user.events_allowed ? user.events_allowed : (user && user.registration_package && user.registration_package ? user.registration_package.events_allowed : '')}}</p>
                            </div>

                            <div class="flex justify-between items-center pt-2 gap-4">
                                <p class="">Events remaining</p>
                                <p class="">{{user && user.events_remaining ? user.events_remaining : (user && user.registration_package && user.registration_package ? user.registration_package.events_allowed : '')}}</p>
                            </div>

                        </div>
                </div>

                <div class="">
                    <div class="bg-white rounded divide-y space-y-3 p-4 shadow border h-full">
                    <h3 class="can-exp-h3 text-primary">Customer profile</h3>
                            <div class="flex justify-between items-center pt-2 gap-4">
                                <p class="">Company name</p>
                                <p class="">{{user && user.customer_profile ? user.customer_profile.company_name : ''}}</p>
                            </div>

                            <div class="flex justify-between items-center pt-2 gap-4">
                                <p class="">Company email</p>
                                <p class="">{{user && user.customer_profile ? user.customer_profile.company_email : ''}}</p>
                            </div>

                            <div class="flex justify-between items-center pt-2 gap-4">
                                <p class="">Short description</p>
                                <p class="">{{user && user.customer_profile ? user.customer_profile.short_description : ''}}</p>
                            </div>

                            <div class="flex justify-between items-center pt-2 gap-4">
                                <p class="">Description</p>
                                <p class="">{{user && user.customer_profile ? user.customer_profile.description : ''}}</p>
                            </div>

                            <div class="flex justify-between items-center pt-2 gap-4">
                                <p class="">Phone</p>
                                <p class="">{{user && user.customer_profile ? user.customer_profile.phone : ''}}</p>
                            </div>

                            <div class="flex justify-between items-center pt-2 gap-4 gap-4">
                                <p class="">Website</p>
                                <p class="">{{user && user.customer_profile ? user.customer_profile.website : ''}}</p>
                            </div>

                            <div class="flex justify-between items-center pt-2 gap-4">
                                <p class="">Keywords</p>
                                <p class="">{{user && user.customer_profile ? user.customer_profile.keywords : ''}}</p>
                            </div>

                            <div class="flex justify-between items-center pt-2 gap-4">
                                <p class="">Address</p>
                                <p class="">{{user && user.customer_profile ? user.customer_profile.address : ''}}</p>
                            </div>

                        </div>
                </div>

                <div class="">
                <div class="bg-white rounded divide-y space-y-3 p-4 shadow border h-full">
                <h3 class="can-exp-h3 text-primary">Customer social media</h3>
                        <div class="flex justify-between items-center pt-2 gap-4">
                            <p class="">Facebook</p>
                            <p class="">{{user && user.customer_social_media ? user.customer_social_media.facebook : ''}}</p>
                        </div>

                        <div class="flex justify-between items-center pt-2 gap-4">
                            <p class="">Google</p>
                            <p class="">{{user && user.customer_social_media ? user.customer_social_media.google : ''}}</p>
                        </div>

                        <div class="flex justify-between items-center pt-2 gap-4">
                            <p class="">LinkedIn</p>
                            <p class="">{{user && user.customer_social_media ? user.customer_social_media.linked_in : ''}}</p>
                        </div>

                        <div class="flex justify-between items-center pt-2 gap-4">
                            <p class="">Twitter</p>
                            <p class="">{{user && user.customer_social_media ? user.customer_social_media.twitter : ''}}</p>
                        </div>

                        <div class="flex justify-between items-center pt-2 gap-4">
                            <p class="">Youtube</p>
                            <p class="">{{user && user.customer_social_media ? user.customer_social_media.youtube : ''}}</p>
                        </div>



                    </div>
                </div>


                <div class="">
                    <div class="bg-white rounded divide-y space-y-3 p-4 shadow border h-full">
                        <h3 class="can-exp-h3 text-primary">Customer media</h3>
                        <template v-if="user && user.customer_media && user.customer_media.customer_gallery_images">
                            <div class="flex justify-between items-center pt-2 gap-4" v-for="customer_gallery_images in user.customer_media.customer_gallery_images" :key="customer_gallery_images.customer_media_id">
                                <img :src="customer_gallery_images.media ? customer_gallery_images.media.full_path : ''" />
                            </div>
                        </template>
                        </div>
                </div>

            </div>

        </div>
    </AppLayout>
</template>

<script>

    import { mapState } from 'vuex'
    export default {
        computed:{
            ...mapState({
                user: state => state.users.user,
            }),
        },
        // created(){
        //     if(this.$route.params.id){
        //         let id = this.$route.params.id;
        //         this.$store.dispatch('users/fetchUser', {url: `${process.env.MIX_ADMIN_API_URL}users/${id}?getRegistrationPackage=1&getCustomerBusinessCategory=1&getCustomerMedia=1&getCustomerProfile=1&getCustomerSocialMedia=1`}).then(res => {
        //             if(res.data.status == 'Success'){
        //                 this.$store.commit('users/setUser', res.data.data);
        //             }
        //         });
        //     }
        // },
    created() {
        if (!this.$route.params.id) {
            // Redirect or handle missing ID case
            this.$router.push({ name: 'admin.users.index' });
            return;
        }

        let id = this.$route.params.id;
        this.$store.dispatch('users/fetchUser', { url: `${process.env.MIX_ADMIN_API_URL}users/${id}?getRegistrationPackage=1&getCustomerBusinessCategory=1&getCustomerMedia=1&getCustomerProfile=1&getCustomerSocialMedia=1` })
            .then(res => {
                if (res.data.status == 'Success') {
                    this.$store.commit('users/setUser', res.data.data);
                }
            })
            .catch(error => {
                // Handle error
                console.error(error);
                this.$router.push({ name: 'admin.users.index' });
            });
    },
    watch: {
        '$route.params.id': {
            immediate: true,
            handler(newId) {
                if (newId) {
                    this.$store.dispatch('users/fetchUser', { url: `${process.env.MIX_ADMIN_API_URL}users/${newId}?getRegistrationPackage=1&getCustomerBusinessCategory=1&getCustomerMedia=1&getCustomerProfile=1&getCustomerSocialMedia=1` })
                        .then(res => {
                            if (res.data.status == 'Success') {
                                this.$store.commit('users/setUser', res.data.data);
                            }
                        });
                }
            }
        }
    },

    };
</script>
