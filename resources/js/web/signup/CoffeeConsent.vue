<template>
    <div>
        <div class="flex items-start pb-4">
            <input 
                id="coffee_consent" 
                type="checkbox" 
                class="h-4 w-4 mt-1 rounded border-gray-300 text-primary focus:ring-primary" 
                @input="updateForm('coffee_consent', $event.target.checked)"
                :checked="form.coffee_consent"
            >
            <label for="coffee_consent" class="ml-2 text-gray-900 text-base md:text-base lg:text-lg">
                I agree to allow Canadian Exports to inform the Kindness Partner who contributed to my Coffee. Only my business name, category, province, and the service received will be shared.
            </label>
        </div>
        <Error fieldName="coffee_consent" :validationErros="validationErros" />
    </div>
</template>

<script>
import { mapState } from "vuex";
import Error from './../components/Error.vue';

export default {
    components: {
        Error
    },
    computed: {
        ...mapState({
            form: (state) => state.signup.form,
            validationErros: (state) => state.signup.validationErros,
        })
    },
    methods: {
        updateForm(field, value) {
            this.$store.commit('signup/setForm', {
                field: [field], 
                value: value
            });
            this.$store.commit("signup/removeValidationErros", {
                field: [field],
            });
        },
    },
    created() {
        this.$store.commit('signup/setForm', {
            field: 'coffee_consent', 
            value: false
        });
    }
}
</script>