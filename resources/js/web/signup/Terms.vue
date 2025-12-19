<template>
    <div>
        <div class="flex items-start pb-4">
            <input tabindex="-1" id="is_agree" type="checkbox"
                class="h-4 w-4 mt-1 rounded border-gray-300 text-primary focus:ring-primary"
                @input="updateForm('is_agree', $event.target.checked)">
            <label for="is_agree" class="ml-2 text-gray-900 text-base md:text-base lg:text-lg"
                v-html="regPageSetting && regPageSetting.reg_page_setting_detail && regPageSetting.reg_page_setting_detail[0] ? regPageSetting.reg_page_setting_detail[0].terms_and_conditions_label : ''">
            </label>
        </div>
        <Error fieldName="is_agree" :validationErros="validationErros" />
        <!-- ⭐ NEW checkbox (Kindness Partner Permission) -->
        <!-- <div class="flex items-start pb-4">
            <input id="is_agree_kindness" type="checkbox"
                class="h-4 w-4 mt-1 rounded border-gray-300 text-primary focus:ring-primary"
                @input="updateForm('is_agree_kindness', $event.target.checked)">
            <label for="is_agree_kindness" class="ml-2 text-gray-900 text-base md:text-base lg:text-lg">
                I agree to allow Canadian Exports to inform the Kindness Partner who contributed to my Coffee.
                Only my business name, category, province, and the service received will be shared.
            </label>
        </div> -->
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
            regPageSetting: (state) => state.signup.regPageSetting,
            validationErros: (state) => state.signup.validationErros,
        })
    },
    methods: {
        updateForm(field, value) {
            // pass field as a string (not an array)

            this.$store.commit('signup/setForm', {
                field: field,
                value: value
            });
            this.$store.commit("signup/removeValidationErros", {
                field: field,
                value: value
            });
            this.$emit("checkbox-updated", { field, value });
            console.log("Updated field:", field, "=", value);
            console.log("Current signup state:", this.$store.state.signup.form);
        },
    },
    created() {
        // initialize both checkboxes in Vuex
        this.$store.commit('signup/setForm', {
            field: 'is_agree', value: false
        });
        this.$store.commit('signup/setForm', {
            field: 'is_agree_kindness', value: false
        });
    }
}
</script>
