<template>
  <div>
    <!-- Language button at bottom right of footer -->
    <div class="relative">
      <button
        class="inline-flex items-center gap-2 h-10 px-3 rounded-lg bg-secondary bg-opacity-90 hover:bg-opacity-100 cursor-pointer transition-all shadow-lg"
        @click="toggleLanguageModal"
      >
        <!-- Globe icon -->
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="18"
          height="18"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
          class="text-white"
        >
          <circle cx="12" cy="12" r="10"></circle>
          <line x1="2" y1="12" x2="22" y2="12"></line>
          <path
            d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"
          ></path>
        </svg>
        <!-- Language abbreviation -->
        <span class="font-semibold text-white text-sm">
          {{ currentLanguageAbbr }}
        </span>
      </button>
    </div>
    <!-- Main modal -->
    <div
      id="defaultModal"
      tabindex="-1"
      aria-hidden="true"
      class="fixed top-0 left-0 right-0 bottom-0 m-auto z-10 overflow-y-auto"
      v-if="showModal"
    >
      <div
        class="fixed inset-0 z-100 bg-gray-500 bg-opacity-75 transition-opacity"
        @click.prevent="toggleLanguageModal()"
      ></div>
      <div
        class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
      >
        <!-- Modal content -->
        <div
          class="relative bg-white rounded-lg shadow w-full sm:max-w-2xl top-0 left-0 right-0 bottom-0 m-auto"
        >
          <!-- Modal header -->
          <div
            class="flex items-center justify-between py-3 px-3 border-b rounded-t"
          >
            <h3 class="card-heading text-primary text-gray-900">
              {{
                general_setting && general_setting["language_modal_heading"]
                  ? general_setting["language_modal_heading"]
                  : __("language_modal_heading")
              }}
            </h3>
            <button
              :aria-label="__('Canadian Exporters')"
              type="button"
              class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 inline-flex items-center"
              data-modal-hide="defaultModal"
              @click="toggleLanguageModal"
            >
              <img
                class="h-6"
                src="/assets/icons/19-X-inside-circle-2.png"
                :alt="__('Canadian Exporters')"
              />
              <span class="sr-only">{{ __("Close modal") }}</span>
            </button>
          </div>
          <!-- Modal body -->
          <div class="p-6 space-y-6">
            <div class="grid grid-cols-3 md:grid-cols-6 gap-4">
              <div
                v-for="(language, key) in sortedLanguages"
                :key="key"
                class="text-center"
              >
                <a
                  :aria-label="__('Canadian Exporters')"
                  :href="`/set-language/${language?.id}?url=${current_url}&url_params=${url_params}`"
                  class="flex flex-col items-center gap-2 p-3 rounded-lg hover:bg-gray-100 transition-colors"
                >
                  <span class="font-semibold text-gray-900 text-lg">
                    {{ getLanguageAbbr(language) }}
                  </span>
                  <span class="text-sm text-gray-600">
                    {{ language?.name }}
                  </span>
                  <span
                    v-if="language.is_default != 1"
                    class="text-xs text-gray-500"
                  >
                    {{ language?.native_name }}
                  </span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { useTranslation } from "@/Utils/i18n";

export default {
  props: ["languages", "current_url", "url_params"],
  setup() {
    const { __ } = useTranslation();
    return { __ };
  },
  data() {
    return {
      showModal: false,
      general_setting: null,
    };
  },
  computed: {
    // Sort languages by abbreviation alphabetically
    sortedLanguages() {
      if (!this.languages || !Array.isArray(this.languages)) {
        return [];
      }
      return [...this.languages].sort((a, b) => {
        const abbrA = this.getLanguageAbbr(a).toUpperCase();
        const abbrB = this.getLanguageAbbr(b).toUpperCase();
        return abbrA.localeCompare(abbrB);
      });
    },
    // Get current language abbreviation
    currentLanguageAbbr() {
      const currentLang = this.getCurrentLanguage();
      return this.getLanguageAbbr(currentLang);
    },
  },
  created() {
    this.$store
      .dispatch("signup/fetchStaticSetting", {
        url: `${process.env.MIX_WEB_API_URL}get-static-setting?getGeneralSetting=1`,
      })
      .then((res) => {
        if (res.data.status == "Success") {
          this.general_setting = res.data.data;
        }
      });
  },
  methods: {
    toggleLanguageModal() {
      this.showModal = !this.showModal;
    },
    // Get language abbreviation (two letters, uppercase, English alphabet only)
    getLanguageAbbr(language) {
      if (!language || !language.abbreviation) {
        return "EN";
      }
      // Extract first two English alphabet letters, convert to uppercase
      const letters = language.abbreviation
        .toUpperCase()
        .match(/[A-Z]/g) || [];
      
      // Take first two letters
      let abbr = letters.slice(0, 2).join("");
      
      // If we don't have 2 letters, use default
      if (abbr.length < 2) {
        abbr = "EN";
      }
      return abbr;
    },
    // Get current active language
    getCurrentLanguage() {
      if (!this.languages || !Array.isArray(this.languages)) {
        return null;
      }
      // Try to get language from URL path
      const path = window.location.pathname;
      const pathParts = path.split("/").filter((p) => p);
      
      // Check if first part of path matches any language abbreviation
      if (pathParts.length > 0) {
        const pathLang = pathParts[0].toUpperCase();
        const foundLang = this.languages.find((lang) => {
          const langAbbr = this.getLanguageAbbr(lang);
          return langAbbr === pathLang;
        });
        if (foundLang) {
          return foundLang;
        }
      }
      
      // Fallback to default language
      const defaultLang = this.languages.find((lang) => lang.is_default == 1);
      return defaultLang || this.languages[0] || null;
    },
  },
};
</script>
