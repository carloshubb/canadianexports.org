<template>
  <div
    class="my-5"
    v-for="language in languages"
    :key="language.id"
    :class="{
      block: shouldShowLanguage(language),
      hidden: !shouldShowLanguage(language),
    }"
  >
    <div
      v-if="hasStaticTranslationDetail(language)"
      class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6"
    >
      <div
        v-for="(field, index) in [
          'message_1',
          'message_2',
          'message_3',
          'message_7',
          'message_8',
          'message_15',
          'message_17',
          'message_18',
          'message_19',
          'message_19_a',
          'message_20',
          'message_21',
          'message_22',
          'message_23',
          'message_24',
          'message_25',
          'message_26',
          'message_27',
          'message_28',
          'message_29',
          'message_30',
          'message_31',
          'message_32',
          'message_33',
          'message_34',
          'message_35_a',
          'message_35_b',
          'message_36',
          'message_37',
          'message_38',
          'message_39',
          'message_40',
          'message_41',
          'message_42',
          'message_43',
        //   'message_44_a',
        //   'message_44_b',
          'message_45',
          'message_46',
          'message_47',
          'message_48',
          'message_49',
          'message_50',
          'message_51',
          'message_52',
          'message_54',
          'message_55',
          'message_56',
          'message_57',
          'message_58',
          'message_59',
          'message_60',
          'message_61',
          'message_62',
          'message_65',
        //   'message_64',
          'message_66',
        ]"
        :key="field"
        class="relative z-0 w-full group"
      >
        <label :for="`${generateFieldId(field, language)}`">{{index + 1 }}{{ ". " }}{{
          getDisplayText(field, language)
        }}</label>
        <textarea
          type="text"
          :name="`${generateFieldName(field, language)}`"
          :id="`${generateFieldId(field, language)}`"
          class="can-exp-input w-full block border border-gray-300 rounded"
          placeholder=" "
          @input="
            handleInput($event.target.value, language, field, 'updateForm')
          "
          :value="getFieldValue(field, language)"
        >
        </textarea>
        <p
          class="mt-2 text-sm text-red-400"
          v-if="hasValidationError(field, language)"
          v-text="getValidationError(field, language)"
        ></p>
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
      static_translation: (state) =>
        state.static_translation.static_translation,
      validationErrors: (state) => state.static_translation.validationErros,
      languages: (state) => state.languages.languages,
    }),
  },
  props: ["selectedLanguageId"],
  methods: {
    shouldShowLanguage(language) {
      return (
        (this.selectedLanguageId == null && language.is_default) ||
        language.id == this.selectedLanguageId
      );
    },
    hasStaticTranslationDetail(language) {
      const trans = this.static_translation.static_translation_detail;
      return trans.some((res) => res.language_id === language.id);
    },
    generateFieldId(field, language) {
      return `${this.staticTranslationByField(
        this.staticTranslationByLang(language),
        field,
        "key"
      )}_${language.id}`;
    },
    generateFieldName(field, language) {
      return `${this.staticTranslationByField(
        this.staticTranslationByLang(language),
        field,
        "key"
      )}_${language.id}`;
    },
    getDisplayText(field, language) {
      return this.staticTranslationByField(
        this.staticTranslationByLang(language),
        field,
        "display_text"
      );
    },
    handleInput(value, language, key, mutationName) {
      this.$store.commit(`static_translation/${mutationName}`, {
        value,
        id: language.id,
        key,
      });
    },
    getFieldValue(field, language) {
      const formKey = this.staticTranslationByField(
        this.staticTranslationByLang(language),
        field,
        "key"
      );
      const inputKey = `${formKey}_${language.id}`;
      return this.form[formKey]?.[inputKey] || "";
    },
    hasValidationError(field, language) {
      const key = `${this.staticTranslationByField(
        this.staticTranslationByLang(language),
        field,
        "key"
      )}.${field}_${this.selectedLanguageId}`;
      return this.validationErrors.has(key);
    },
    getValidationError(field, language) {
      const key = `${this.staticTranslationByField(
        this.staticTranslationByLang(language),
        field,
        "key"
      )}.${field}_${this.selectedLanguageId}`;
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
