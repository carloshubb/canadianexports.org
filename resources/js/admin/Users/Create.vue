<template>
    <AppLayout>
        <div class="relative shadow-md sm:rounded-lg bg-white py-4">
            <header class="pt-4">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h3 class="can-exp-h3 text-primary">
                            {{ isFormEdit ? "Edit" : "Create" }} user
                        </h3>
                        <router-link
                            :to="{ name: 'admin.users.index' }"
                            class="button-exp-fill"
                        >
                            Back
                        </router-link>
                    </div>
                </div>
            </header>
            <form
                class="px-4 md:px-6 lg:px-8"
                @submit.prevent="addUpdateForm()"
            >
                <div
                    class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6"
                >
                    <div class="relative z-0 w-full group">
                        <label for="name">Name</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" "
                            :value="form.name"
                            @input="updateForm('name', $event.target.value)"
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('name')"
                            v-text="validationErros.get('name')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="email">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" "
                            :value="form.email"
                            @input="updateForm('email', $event.target.value)"
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('email')"
                            v-text="validationErros.get('email')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="password">Password</label>
                        <div class="relative">
                            <input
                                :type="display_password"
                                name="password"
                                id="password"
                                class="can-exp-input w-full block border border-gray-300 rounded"
                                placeholder=" "
                                :value="form.password"
                                @input="
                                    updateForm('password', $event.target.value)
                                "
                            />
                            <svg
                            class="w-5 h-5 text-gray-500 absolute top-3 right-3"
                                @click="display_password = 'text'"
                                v-if="display_password == 'password'"
                viewBox="0 0 51 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_1249_2209)">
                <path d="M28.22 0.59C27.73 0.53 27.24 0.49 26.75 0.43H24.2C23.63 0.5 23.06 0.56 22.49 0.63C18.95 1.07 15.69 2.29 12.64 4.13C8.56 6.6 5.23 9.88 2.39 13.68C1.62 14.71 0.93 15.8 0.21 16.86C0.14 16.95 0.07 17.04 0 17.13V17.21C0.69 18.22 1.35 19.25 2.08 20.23C4.89 24.01 8.16 27.31 12.15 29.86C12.19 29.89 12.23 29.91 12.27 29.93C12.33 29.8 12.4 29.69 12.48 29.57L15.51 24.97C14.14 22.86 13.27 20.55 13.11 17.99C12.67 11.02 17.98 5.1 24.95 4.8C26.2 4.75 27.39 4.88 28.54 5.16L31.18 1.16C30.21 0.91 29.23 0.72 28.22 0.59ZM49.22 14.6C46.3 10.58 42.89 7.08 38.68 4.43C38.61 4.55 38.55 4.65 38.48 4.76L35.45 9.37C35.78 9.87 36.07 10.4 36.34 10.94C37.91 14.11 38.37 17.4 37.33 20.82C35.74 26.05 30.92 29.58 24.98 29.58C24.12 29.57 23.24 29.45 22.37 29.24L19.77 33.2C20.51 33.4 21.27 33.55 22.04 33.67C22.64 33.76 23.25 33.83 23.85 33.91H27.11C27.62 33.84 28.13 33.78 28.64 33.71C32.31 33.22 35.68 31.91 38.8 29.93C43.22 27.13 46.74 23.41 49.69 19.12C50.12 18.49 50.54 17.84 50.96 17.21V17.13C50.38 16.29 49.82 15.43 49.22 14.6ZM37.38 3.65C37.34 3.75 37.28 3.85 37.22 3.94L34.46 8.13L20.88 28.78L18.26 32.77L17.98 33.19C17.49 33.93 16.68 34.34 15.85 34.34C15.37 34.34 14.89 34.2 14.46 33.92C13.39 33.21 13.02 31.83 13.56 30.7C13.61 30.6 13.67 30.5 13.73 30.4L16.47 26.24L30.04 5.61L32.69 1.6L32.98 1.15C33.47 0.41 34.28 0 35.1 0C35.58 0 36.07 0.14 36.5 0.42C37.58 1.13 37.93 2.52 37.38 3.65Z" fill="currentcolor"/>
                </g>
                <defs>
                <clipPath id="clip0_1249_2209">
                <rect width="50.96" height="34.34" fill="currentcolor"/>
                </clipPath>
                </defs>
                </svg>
                <svg
                class="w-5 h-5 text-gray-500 absolute top-3 right-3"
                                @click="display_password = 'password'"
                                v-else-if="display_password == 'text'"
                viewBox="0 0 51 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_1248_2207)">
                <path d="M50.96 16.7C50.96 16.72 50.96 16.75 50.96 16.77C50.54 17.41 50.13 18.05 49.69 18.68C46.74 22.97 43.22 26.69 38.8 29.49C35.68 31.46 32.31 32.77 28.64 33.26C28.13 33.33 27.62 33.39 27.11 33.46C26.02 33.46 24.94 33.46 23.85 33.46C23.25 33.38 22.64 33.31 22.04 33.22C18.47 32.67 15.19 31.35 12.15 29.41C8.16 26.86 4.89 23.57 2.08 19.78C1.36 18.82 0.69 17.78 0 16.77C0 16.75 0 16.72 0 16.7C0.07 16.61 0.15 16.52 0.21 16.42C0.93 15.36 1.62 14.27 2.39 13.24C5.23 9.44 8.57 6.16 12.65 3.69C15.69 1.85 18.96 0.64 22.5 0.2C23.07 0.13 23.64 0.07 24.21 0C25.06 0 25.91 0 26.76 0C27.25 0.05 27.74 0.1 28.22 0.16C31.57 0.58 34.7 1.67 37.63 3.35C42.33 6.06 46.07 9.81 49.23 14.17C49.82 15 50.38 15.86 50.96 16.7ZM24.98 29.15C30.92 29.15 35.74 25.62 37.33 20.39C38.37 16.97 37.92 13.67 36.34 10.51C35.58 8.98 34.69 7.57 33.14 6.66C30.6 5.17 27.94 4.24 24.96 4.37C17.99 4.68 12.67 10.59 13.12 17.56C13.3 20.43 14.37 22.98 16.03 25.3C16.26 25.62 16.55 25.92 16.87 26.15C19.42 28.02 22.25 29.12 24.98 29.15Z" fill="currentcolor"/>
                </g>
                <defs>
                <clipPath id="clip0_1248_2207">
                <rect width="50.96" height="33.48" fill="currentcolor"/>
                </clipPath>
                </defs>
                </svg>

                        </div>
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('password')"
                            v-text="validationErros.get('password')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="password_confirmation"
                            >Password confirmation</label
                        >
                        <div class="relative">
                            <input
                                :type="display_confirm_password"
                                name="password_confirmation"
                                id="password_confirmation"
                                class="can-exp-input w-full block border border-gray-300 rounded"
                                placeholder=" "
                                :value="form.password_confirmation"
                                @input="
                                    updateForm(
                                        'password_confirmation',
                                        $event.target.value
                                    )
                                "
                            />
                            <svg
                            class="w-5 h-5 text-gray-500 absolute top-3 right-3"
                                @click="display_confirm_password = 'text'"
                                v-if="display_confirm_password == 'password'"
                viewBox="0 0 51 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_1249_2209)">
                <path d="M28.22 0.59C27.73 0.53 27.24 0.49 26.75 0.43H24.2C23.63 0.5 23.06 0.56 22.49 0.63C18.95 1.07 15.69 2.29 12.64 4.13C8.56 6.6 5.23 9.88 2.39 13.68C1.62 14.71 0.93 15.8 0.21 16.86C0.14 16.95 0.07 17.04 0 17.13V17.21C0.69 18.22 1.35 19.25 2.08 20.23C4.89 24.01 8.16 27.31 12.15 29.86C12.19 29.89 12.23 29.91 12.27 29.93C12.33 29.8 12.4 29.69 12.48 29.57L15.51 24.97C14.14 22.86 13.27 20.55 13.11 17.99C12.67 11.02 17.98 5.1 24.95 4.8C26.2 4.75 27.39 4.88 28.54 5.16L31.18 1.16C30.21 0.91 29.23 0.72 28.22 0.59ZM49.22 14.6C46.3 10.58 42.89 7.08 38.68 4.43C38.61 4.55 38.55 4.65 38.48 4.76L35.45 9.37C35.78 9.87 36.07 10.4 36.34 10.94C37.91 14.11 38.37 17.4 37.33 20.82C35.74 26.05 30.92 29.58 24.98 29.58C24.12 29.57 23.24 29.45 22.37 29.24L19.77 33.2C20.51 33.4 21.27 33.55 22.04 33.67C22.64 33.76 23.25 33.83 23.85 33.91H27.11C27.62 33.84 28.13 33.78 28.64 33.71C32.31 33.22 35.68 31.91 38.8 29.93C43.22 27.13 46.74 23.41 49.69 19.12C50.12 18.49 50.54 17.84 50.96 17.21V17.13C50.38 16.29 49.82 15.43 49.22 14.6ZM37.38 3.65C37.34 3.75 37.28 3.85 37.22 3.94L34.46 8.13L20.88 28.78L18.26 32.77L17.98 33.19C17.49 33.93 16.68 34.34 15.85 34.34C15.37 34.34 14.89 34.2 14.46 33.92C13.39 33.21 13.02 31.83 13.56 30.7C13.61 30.6 13.67 30.5 13.73 30.4L16.47 26.24L30.04 5.61L32.69 1.6L32.98 1.15C33.47 0.41 34.28 0 35.1 0C35.58 0 36.07 0.14 36.5 0.42C37.58 1.13 37.93 2.52 37.38 3.65Z" fill="currentcolor"/>
                </g>
                <defs>
                <clipPath id="clip0_1249_2209">
                <rect width="50.96" height="34.34" fill="currentcolor"/>
                </clipPath>
                </defs>
                </svg>
                <svg
                class="w-5 h-5 text-gray-500 absolute top-3 right-3"
                                @click="display_confirm_password = 'password'"
                                v-else-if="display_confirm_password == 'text'"
                viewBox="0 0 51 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_1248_2207)">
                <path d="M50.96 16.7C50.96 16.72 50.96 16.75 50.96 16.77C50.54 17.41 50.13 18.05 49.69 18.68C46.74 22.97 43.22 26.69 38.8 29.49C35.68 31.46 32.31 32.77 28.64 33.26C28.13 33.33 27.62 33.39 27.11 33.46C26.02 33.46 24.94 33.46 23.85 33.46C23.25 33.38 22.64 33.31 22.04 33.22C18.47 32.67 15.19 31.35 12.15 29.41C8.16 26.86 4.89 23.57 2.08 19.78C1.36 18.82 0.69 17.78 0 16.77C0 16.75 0 16.72 0 16.7C0.07 16.61 0.15 16.52 0.21 16.42C0.93 15.36 1.62 14.27 2.39 13.24C5.23 9.44 8.57 6.16 12.65 3.69C15.69 1.85 18.96 0.64 22.5 0.2C23.07 0.13 23.64 0.07 24.21 0C25.06 0 25.91 0 26.76 0C27.25 0.05 27.74 0.1 28.22 0.16C31.57 0.58 34.7 1.67 37.63 3.35C42.33 6.06 46.07 9.81 49.23 14.17C49.82 15 50.38 15.86 50.96 16.7ZM24.98 29.15C30.92 29.15 35.74 25.62 37.33 20.39C38.37 16.97 37.92 13.67 36.34 10.51C35.58 8.98 34.69 7.57 33.14 6.66C30.6 5.17 27.94 4.24 24.96 4.37C17.99 4.68 12.67 10.59 13.12 17.56C13.3 20.43 14.37 22.98 16.03 25.3C16.26 25.62 16.55 25.92 16.87 26.15C19.42 28.02 22.25 29.12 24.98 29.15Z" fill="currentcolor"/>
                </g>
                <defs>
                <clipPath id="clip0_1248_2207">
                <rect width="50.96" height="33.48" fill="currentcolor"/>
                </clipPath>
                </defs>
                </svg>

                        </div>
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('password_confirmation')"
                            v-text="
                                validationErros.get('password_confirmation')
                            "
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="package_id"> Package </label>
                        <select
                            id="package_id"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            @input="
                                updateForm('package_id', $event.target.value)
                            "
                            :value="
                                form && form.package_id ? form.package_id : ''
                            "
                        >
                            <option value="">Select package...</option>
                            <option
                                :value="p.id"
                                v-for="p in packages"
                                :key="p.id"
                                :selected="
                                    form && form.package_id
                                        ? form.package_id
                                        : '' == p.id
                                "
                            >
                                {{ p?.registration_package_detail?.[0]?.name }}
                            </option>
                        </select>

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('package_id')"
                            v-text="validationErros.get('package_id')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="payment_frequency"> Payment frequency </label>
                        <select
                            id="payment_frequency"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            @input="
                                updateForm('payment_frequency', $event.target.value)
                            "
                        >
                            <option value="">Select payment frequency...</option>
                            <option value="monthly" :selected="form.payment_frequency == 'monthly'">Monthly</option>
                            <option value="quarterly" :selected="form.payment_frequency == 'quarterly'">Quarterly</option>
                            <option value="semi_annually" :selected="form.payment_frequency == 'semi_annually'">Semi annually</option>
                            <option value="annually" :selected="form.payment_frequency == 'annually'">Annually</option>
                        </select>

                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('payment_frequency')"
                            v-text="validationErros.get('payment_frequency')"
                        ></p>
                    </div>
                </div>
                <button
                    type="submit"
                    class="button-exp-fill mt-5"
                    :disabled="loading"
                >
                    Submit
                </button>
            </form>
        </div>
    </AppLayout>
</template>

<script>
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            loading: (state) => state.users.loading,
            isFormEdit: (state) => state.users.isFormEdit,
            form: (state) => state.users.form,
            validationErros: (state) => state.users.validationErros,
        }),
    },
    data() {
        return {
            display_password: "password",
            display_confirm_password: "password",
            packages: [],
        };
    },
    methods: {
        updateForm(field, value) {
            this.$store.commit("users/updateForm", {
                [field]: value,
            });
        },
        addUpdateForm() {
            this.$store
                .dispatch("users/addUpdateForm")
                .then(() => this.$router.push({ name: "admin.users.index" }));
        },
    },
    created() {
        this.$store.commit("users/resetForm");
        this.$store
            .dispatch("registration_packages/fetchRegistrationPackages", {
                url: `${process.env.MIX_ADMIN_API_URL}registration-packages?getProfilePackagesOnly=1&getAll=1`,
            })
            .then((result) => {
                if (result?.data?.status == "Success") {
                    this.packages = result.data.data;
                }
            });
        if (this.$route.params.id) {
            let id = this.$route.params.id;
            this.$store.commit("users/setIsFormEdit", 1);
            this.$store.dispatch("users/fetchUser", { id: id }).then((res) => {
                if (res.data.status == "Success") {
                    this.updateForm("name", res.data.data.name);
                    this.updateForm("email", res.data.data.email);
                    this.updateForm("package_id", res.data.data.registration_package_id);
                    this.updateForm("payment_frequency", res.data.data.payment_frequency);
                }
            });
        }
    },
};
</script>
