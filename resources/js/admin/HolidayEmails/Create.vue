<template>
    <AppLayout>
        <div class="relative shadow-md sm:rounded-lg bg-white py-4">
            <header class="pt-4">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h3 class="can-exp-h3 text-primary">
                            {{ isFormEdit ? "Edit" : "Create" }} holiday email
                        </h3>
                        <router-link
                            :to="{ name: 'admin.holiday-emails.index' }"
                            class="button-exp-fill"
                        >
                            Back
                        </router-link>
                    </div>
                </div>
            </header>
            <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
                <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2  lg:grid-cols-2 gap-6 ">
                    <div class="relative z-0 w-full group">
                        <label for="name" class="">Name</label>
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
                        <label for="email_subject" class=""
                            >Email subject</label
                        >
                        <input
                            type="text"
                            name="email_subject"
                            id="email_subject"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" "
                            :value="form.email_subject"
                            @input="
                                updateForm('email_subject', $event.target.value)
                            "
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('email_subject')"
                            v-text="validationErros.get('email_subject')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group md:col-span-2">
                        <label for="email_content" class=""
                            >Email content</label
                        >
                        <textarea id="email_content" rows="4" class="can-exp-input block w-full rounded border border-gray-300" v-text="form.email_content" @input="updateForm('email_content', $event.target.value)"></textarea>
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('email_content')"
                            v-text="validationErros.get('email_content')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="holidays_from" class=""
                            >Holidays from</label
                        >
                        <input
                            type="date"
                            name="holidays_from"
                            id="holidays_from"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" "
                            :value="form.holidays_from"
                            @input="
                                updateForm('holidays_from', $event.target.value)
                            "
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('holidays_from')"
                            v-text="validationErros.get('holidays_from')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="holidays_to" class="">Holidays to</label>
                        <input
                            type="date"
                            name="holidays_to"
                            id="holidays_to"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" "
                            :value="form.holidays_to"
                            @input="
                                updateForm('holidays_to', $event.target.value)
                            "
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('holidays_to')"
                            v-text="validationErros.get('holidays_to')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="email_sent_date" class=""
                            >Email sent date</label
                        >
                        <input
                            type="date"
                            name="email_sent_date"
                            id="email_sent_date"
                            class="can-exp-input w-full block border border-gray-300 rounded"
                            placeholder=" "
                            :value="form.email_sent_date"
                            @input="
                                updateForm(
                                    'email_sent_date',
                                    $event.target.value
                                )
                            "
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('email_sent_date')"
                            v-text="validationErros.get('email_sent_date')"
                        ></p>
                    </div>
                </div>

                <button type="submit" class="button-exp-fill" :disabled="loading">Submit</button>
            </form>
        </div>
    </AppLayout>
</template>

<script>
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            loading: (state) => state.holiday_emails.loading,
            form: (state) => state.holiday_emails.form,
            isFormEdit: (state) => state.holiday_emails.isFormEdit,
            validationErros: (state) => state.holiday_emails.validationErros,
        }),
    },
    methods: {
        updateForm(field, value) {
            this.$store.commit("holiday_emails/setForm", {
                [field]: value,
            });
        },
        addUpdateForm() {
            this.$store
                .dispatch("holiday_emails/addUpdateForm")
                .then(() =>
                    this.$router.push({ name: "admin.holiday-emails.index" })
                );
        },
    },
    created() {
        this.$store.commit("holiday_emails/resetForm");
        if (this.$route.params.id) {
            let id = this.$route.params.id;
            this.$store.commit("holiday_emails/setIsFormEdit", 1);
            this.$store
                .dispatch("holiday_emails/fetchHolidayEmail", { id: id })
                .then((res) => {
                    if (res.data.status == "Success") {
                    }
                });
        }
    },
};
</script>

