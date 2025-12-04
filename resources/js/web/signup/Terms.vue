<template>
    <div>
        <div class="flex items-start pb-4">
            <input tabindex="-1" id="is_agree" type="checkbox" class="h-4 w-4 mt-1 rounded border-gray-300 text-primary focus:ring-primary" @input="updateForm('is_agree', $event.target.checked)">
            <label for="is_agree" class="ml-2 text-gray-900 text-base md:text-base lg:text-lg" v-html="regPageSetting && regPageSetting.reg_page_setting_detail && regPageSetting.reg_page_setting_detail[0] ? regPageSetting.reg_page_setting_detail[0].terms_and_conditions_label : ''">
            </label>
        </div>
        <Error fieldName="is_agree" :validationErros="validationErros" />
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
    methods:{
        updateForm(field, value){
            this.$store.commit('signup/setForm', {
                field: [field], value: value
            });
            this.$store.commit("signup/removeValidationErros", {
                field: [field],
            });
        },
    },
    created(){
        this.$store.commit('signup/setForm', {
                field: 'is_agree', value: false
            });
    }
}
</script>
