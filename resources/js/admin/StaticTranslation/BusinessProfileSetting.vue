<template>
    <div class="my-5" v-for="language in languages" :key="language.id" :class="{ 'block': shouldShowLanguage(language), 'hidden': !shouldShowLanguage(language) }">
      <div v-if="hasStaticTranslationDetail(language)" class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="field in ['overview_tab_text', 'media_tab_text', 'contact_tab_text', 'visit_our_website_text', 'contact_tab_heading', 'contact_tab_required_fields_text', 'contact_tab_name_label', 'contact_tab_name_error', 'contact_tab_company_name_label', 'contact_tab_company_name_error', 'contact_tab_email_label', 'contact_tab_email_error', 'contact_tab_message_label', 'contact_tab_message_error', 'contact_tab_send_me_a_copy_text', 'contact_tab_button_text', 'contact_information_heading_text', 'featured_heading_for_listing', 'premium_heading_for_listing', 'basic_heading_for_listing']" :key="field" class="relative z-0 w-full group">
          <label :for="`${generateFieldId(field, language)}`">{{ getDisplayText(field, language) }}</label>
          <input
            type="text"
            :name="`${generateFieldName(field, language)}`"
            :id="`${generateFieldId(field, language)}`"
            class="can-exp-input w-full block border border-gray-300 rounded"
            placeholder=" "
            @input="handleInput($event.target.value, language, field, 'updateForm')"
            :value="getFieldValue(field, language)"
          />
          <p class="mt-2 text-sm text-red-400" v-if="hasValidationError(field, language)" v-text="getValidationError(field, language)"></p>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { mapState } from "vuex";
  
  export default {
    computed: {
      ...mapState({
        form: (state) => state.static_translation.form,
        static_translation: (state) => state.static_translation.static_translation,
        validationErrors: (state) => state.static_translation.validationErros,
        languages: (state) => state.languages.languages,
      }),
    },
    props: ["selectedLanguageId"],
    methods: {
      shouldShowLanguage(language) {
        return (this.selectedLanguageId == null && language.is_default) || language.id == this.selectedLanguageId;
      },
      hasStaticTranslationDetail(language) {
        const trans = this.static_translation.static_translation_detail;
        return trans.some((res) => res.language_id === language.id);
      },
      generateFieldId(field, language) {
        return `${this.staticTranslationByField(this.staticTranslationByLang(language), field, 'key')}_${language.id}`;
      },
      generateFieldName(field, language) {
        return `${this.staticTranslationByField(this.staticTranslationByLang(language), field, 'key')}_${language.id}`;
      },
      getDisplayText(field, language) {
        return this.staticTranslationByField(this.staticTranslationByLang(language), field, 'display_text');
      },
      handleInput(value, language, key, mutationName) {
        this.$store.commit(`static_translation/${mutationName}`, { value, id: language.id, key });
      },
      getFieldValue(field, language) {
        const formKey = this.staticTranslationByField(this.staticTranslationByLang(language), field, 'key');
        const inputKey = `${formKey}_${language.id}`;
        return this.form[formKey]?.[inputKey] || '';
      },
      hasValidationError(field, language) {
        const key = `${this.staticTranslationByField(this.staticTranslationByLang(language), field, 'key')}.${field}_${this.selectedLanguageId}`;
        return this.validationErrors.has(key);
      },
      getValidationError(field, language) {
        const key = `${this.staticTranslationByField(this.staticTranslationByLang(language), field, 'key')}.${field}_${this.selectedLanguageId}`;
        return this.validationErrors.get(key);
      },
      staticTranslationByLang(language) {
        const trans = this.static_translation.static_translation_detail;
        return trans.filter((res) => res.language_id == language.id);
      },
      staticTranslationByField(data, key, field) {
        const trans = data.filter((res) => res.key == key);
        return trans?.[0]?.[field] || null;
      },
    },
  };
  </script>
  