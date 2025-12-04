<template>
    <AppLayout>

        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="can-exp-h3 text-primary">Profile</h3>
                <!-- <p class="mt-1 max-w-2xl text-sm text-gray-500">Personal details and application.</p> -->
            </div>
            <div class="border-t border-gray-200">
                <form class="py-4 px-4 bg-white" @submit.prevent="updateProfile()">
                    <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2  lg:grid-cols-2 gap-6 ">
                        <div class="relative z-0 w-full group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name"
                                class="can-exp-input w-full block border border-gray-300 rounded"
                                placeholder=" " :value="loggedInUser?.name" @input="updateForm('name', $event.target.value)" />
                        </div>
                        <div class="relative z-0 w-full group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email"
                                class="can-exp-input w-full block border border-gray-300 rounded"
                                placeholder=" " :value="loggedInUser ? loggedInUser.email : ''" @input="updateForm('email', $event.target.value)" />
                        </div>
                    </div>
                    <div class="grid my-5 md:grid-cols-3 md:gap-6 gap-4">
                        <div class="relative z-0 w-full group">
                            <label for="current_password">Current password</label>
                            <input type="password" name="current_password" id="current_password"
                                class="can-exp-input w-full block border border-gray-300 rounded"
                                placeholder=" " @input="updateForm('current_password', $event.target.value)"
                                :value="form.current_password" />
                            <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('current_password')"
                                v-text="validationErros.get('current_password')"></p>
                        </div>
                        <div class="relative z-0 w-full group">
                            <label for="new_password">New password</label>
                            <input type="password" name="new_password" id="new_password"
                                class="can-exp-input w-full block border border-gray-300 rounded"
                                placeholder=" " @input="updateForm('new_password', $event.target.value)"
                                :value="form.new_password" />
                            <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('new_password')"
                                v-text="validationErros.get('new_password')"></p>
                        </div>
                        <div class="relative z-0 w-full group">
                            <label for="new_password_confirmation">Password confirmation</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                class="can-exp-input w-full block border border-gray-300 rounded"
                                placeholder=" " @input="updateForm('new_password_confirmation', $event.target.value)"
                                :value="form.new_password_confirmation" />
                            <p class="mt-2 text-sm text-red-400" v-if="validationErros.has('new_password_confirmation')"
                                v-text="validationErros.get('new_password_confirmation')"></p>
                        </div>
                    </div>
                    <button type="submit"
                        class="button-exp-fill"
                        :disabled="loading">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" v-if="loading">
                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Save
                    </button>
                </form>
            </div>
        </div>


    </AppLayout>
</template>

<script>
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            loggedInUser: (state) => state.auth.loggedInUser,
            form: (state) => state.auth.form,
            validationErros: (state) => state.auth.validationErros,
            loading: (state) => state.auth.loading,
        })
    },
    methods:{
        updateForm(field, value){
            this.$store.commit('auth/setForm', {
                [field]: value
            });
        },
        updateProfile(){
            this.$store.dispatch('auth/updateUserProfile');
        }
    }
}
</script>
