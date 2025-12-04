<template>
  <AppLayout>
    <div class="relative shadow-md sm:rounded-lg bg-white py-4">
      <header class="pt-4">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <h3 class="can-exp-h3 text-primary">
              {{
                static_translation
                  ? static_translation.display_text
                  : "Edit setting"
              }}
            </h3>
          </div>
        </div>
      </header>
      <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
        <div
          class="text-sm font-medium text-center text-gray-500 border-b border-gray-200"
        >
          <ul class="flex flex-wrap mb-2 overflow-x-auto gap-1 mt-4">
            <li class="mr-2" v-for="language in languages" :key="language.id">
              <a
                @click.prevent="selectedLanguageId = language.id"
                href="#"
                :class="[
                  'inline-block rounded font-FuturaMdCnBT px-5 py-2 lg:text-lg md:text-base sm:text-base text-base hover:bg-blue-100 border border-primary text-center hover:border-blue-500 hover:text-blue-600',
                  (selectedLanguageId == null && language.is_default) ||
                  selectedLanguageId == language.id
                    ? 'bg-blue-600 text-white'
                    : '',
                  validationErros.has(`name.name_${language.id}`)
                    ? 'bg-red-600 border-red-600 text-white hover:text-white rounded hover:bg-red-600 hover:border-red-600'
                    : '',
                ]"
                >{{ language.name }}</a
              >
            </li>
          </ul>
        </div>
        <PackageSummary :selectedLanguageId="selectedLanguageId"  v-if="static_translation?.type == 'package_summary_setting'" />
        <AdvanceSearchSetting :selectedLanguageId="selectedLanguageId"  v-else-if="static_translation?.type == 'advance_search'" />
        <BusinessProfileSetting :selectedLanguageId="selectedLanguageId"  v-else-if="static_translation?.type == 'business_profile_setting'" />
        <CoffeeWallSetting :selectedLanguageId="selectedLanguageId"  v-else-if="static_translation?.type == 'coffee_wall_setting'" />
        <CookiesModalSetting :selectedLanguageId="selectedLanguageId"  v-else-if="static_translation?.type == 'cookies_modal'" />
        <EventDetailSetting :selectedLanguageId="selectedLanguageId"  v-else-if="static_translation?.type == 'event_detail_setting'" />
        <ExportingFairSetting :selectedLanguageId="selectedLanguageId"  v-else-if="static_translation?.type == 'exporting_fair_detail_setting'" />
        <ForgetPasswordSetting :selectedLanguageId="selectedLanguageId"  v-else-if="static_translation?.type == 'forget_password_setting'" />
        <GeneralMessage :selectedLanguageId="selectedLanguageId"  v-else-if="static_translation?.type == 'general_messages'" />
        <I2bModalSetting :selectedLanguageId="selectedLanguageId"  v-else-if="static_translation?.type == 'i2b_modal'" />
        <PaymentSetting :selectedLanguageId="selectedLanguageId"  v-else-if="static_translation?.type == 'payment_setting'" />
        <ResendEmailVerificationSetting :selectedLanguageId="selectedLanguageId"  v-else-if="static_translation?.type == 'resend_email_verification_setting'" />
        <UnsubscribeEmailSetting :selectedLanguageId="selectedLanguageId"  v-else-if="static_translation?.type == 'unsubscribe_email_setting'" />
        <ResetPasswordSetting :selectedLanguageId="selectedLanguageId"  v-else-if="static_translation?.type == 'reset_password_setting'" />
        <StaticTranslation :selectedLanguageId="selectedLanguageId"  v-else-if="static_translation?.type == 'general'" />
        <UpgradeSetting :selectedLanguageId="selectedLanguageId"  v-else-if="static_translation?.type == 'upgrade_modal'" />
        <OnlineBusinessDirectorySearch :selectedLanguageId="selectedLanguageId"  v-else-if="static_translation?.type == 'online_business_directory_search'" />
          <!-- <div
            v-if="
              static_translation && static_translation.static_translation_detail
            "
            class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6"
          >
            <div
              class="relative z-0 w-full group"
              v-for="setting in staticTranslationByLang(language)"
              :key="setting.id"
              :class="trans_type == 'general-messages' ? 'col-span-2' : ''"
            >
              <label :for="`${setting.key}_${language.id}`">{{
                setting.display_text
              }}</label>
              <input
                type="text"
                :name="`${setting.key}_${language.id}`"
                :id="`${setting.key}_${language.id}`"
                class="can-exp-input w-full block border border-gray-300 rounded"
                placeholder=" "
                @input="
                  handleInput(
                    $event.target.value,
                    language,
                    setting.key,
                    'updateForm'
                  )
                "
                :value="
                  form[setting.key] &&
                  form[setting.key][`${setting.key}_${language.id}`]
                    ? form[setting.key][`${setting.key}_${language.id}`]
                    : ''
                "
              />
              <p
                class="mt-2 text-sm text-red-400"
                v-if="
                  validationErros.has(
                    `${setting.key}.${setting.key}_${selectedLanguageId}`
                  )
                "
                v-text="
                  validationErros.get(
                    `${setting.key}.${setting.key}_${selectedLanguageId}`
                  )
                "
              ></p>
            </div>
          </div> -->
        <button type="submit" class="button-exp-fill mt-5" :disabled="loading">
          Submit
        </button>
      </form>
    </div>
  </AppLayout>
</template>


<script>
import PackageSummary from './PackageSummary';
import AdvanceSearchSetting from './AdvanceSearchSetting';
import BusinessProfileSetting from './BusinessProfileSetting';
import CookiesModalSetting from './CookiesModalSetting';
import EventDetailSetting from './EventDetailSetting';
import ExportingFairSetting from './ExportingFairSetting';
import ForgetPasswordSetting from './ForgetPasswordSetting';
import GeneralMessage from './GeneralMessage';
import I2bModalSetting from './I2bModalSetting';
import PaymentSetting from './PaymentSetting';
import CoffeeWallSetting from './CoffeeWallSetting';
import ResendEmailVerificationSetting from './ResendEmailVerificationSetting';
import UnsubscribeEmailSetting from './UnsubscribeEmailSetting';
import ResetPasswordSetting from './ResetPasswordSetting';
import StaticTranslation from './StaticTranslation';
import UpgradeSetting from './UpgradeSetting';
import OnlineBusinessDirectorySearch from './OnlineBusinessDirectorySearch';
import { mapState } from "vuex";
export default {
    components:{
        PackageSummary,
        AdvanceSearchSetting,
        BusinessProfileSetting,
        CookiesModalSetting,
        EventDetailSetting,
        ExportingFairSetting,
        ForgetPasswordSetting,
        GeneralMessage,
        I2bModalSetting,
        PaymentSetting,
        CoffeeWallSetting,
        ResendEmailVerificationSetting,
        UnsubscribeEmailSetting,
        ResetPasswordSetting,
        StaticTranslation,
        UpgradeSetting,
        OnlineBusinessDirectorySearch
    },
  computed: {
    ...mapState({
      loading: (state) => state.static_translation.loading,
      form: (state) => state.static_translation.form,
      static_translation: (state) =>
        state.static_translation.static_translation,
      validationErros: (state) => state.static_translation.validationErros,
      languages: (state) => state.languages.languages,
    }),
  },
  data() {
    return {
      selectedLanguageId: null,
      trans_type: this.$route.params.type,
    };
  },
  methods: {
    handleInput(value, language, key, mutationName) {
      this.$store.commit(`static_translation/${mutationName}`, {
        value: value,
        id: language.id,
        key,
      });
    },
    addUpdateForm() {
      this.$store.dispatch("static_translation/addUpdateForm");
    },
    staticTranslationByLang(language) {
      let trans = this.static_translation.static_translation_detail;
      if (trans.filter((res) => res.language_id == language.id).length > 0) {
        return trans.filter((res) => res.language_id == language.id);
      } else {
        return trans.filter(
          (res) => res.language_id == this.selectedLanguageId
        );
      }
    },
  },
  created() {
    this.$store.commit("static_translation/resetForm");
    this.$store.commit("static_translation/setForm", {
      key: "type",
      value: this.$route.params.type,
    });
    this.$store
      .dispatch("languages/fetchLanguages", {
        url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
      })
      .then((res) => {
        let languages = res.data.data;
        languages.map((res, i) => {
          if (res.is_default == "1") {
            this.selectedLanguageId = res.id;
          }
        });
        this.$store
          .dispatch("static_translation/fetchStaticTranslation", {
            url: `${process.env.MIX_ADMIN_API_URL}static-translation?findByType=${this.$route.params.type}&withStaticTranslationDetail=1&createStaticTranslationDetail=1`,
          })
          .then((response) => {
            let data =
              response.data.data && response.data.data.static_translation_detail
                ? response.data.data.static_translation_detail
                : [];
            data.map((res) => {
              let obj = {};
              obj[`${res.key}_${res.language_id}`] = res.value;
              this.$store.commit("static_translation/updateForm", {
                key: res.key,
                value: res.value,
                id: res.language_id,
              });
            });
          });
      });
  },
};
</script>
