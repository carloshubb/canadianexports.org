<template>
  <div>
    <div class="fixed bottom-32 md:bottom-14 right-3 z-20">
      <span
        class="inline-flex h-10 w-fit px-2 items-center justify-center rounded-full bg-secondary bg-opacity-40 cursor-pointer"
        @click="toggleLanguageModal"
      >
        <span class="font-semibold text-white">
          {{ general_setting?.["language_button_text"] || "" }}
        </span>
      </span>
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
                  : ""
              }}
            </h3>
            <button
              aria-label="Candian Exporters"
              type="button"
              class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 inline-flex items-center"
              data-modal-hide="defaultModal"
              @click="toggleLanguageModal"
            >
              <img
                class="h-6"
                src="/assets/icons/19-X-inside-circle-2.png"
                alt="Candian Exporters"
              />
              <span class="sr-only">Close modal</span>
            </button>
          </div>
          <!-- Modal body -->
          <div class="p-6 space-y-6">
            <div class="grid grid-cols-3 md:grid-cols-6 gap-2">
              <div v-for="(language, key) in languages" :key="key">
                <a
                  aria-label="Candian Exporters"
                  :href="`/set-language/${language?.id}?url=${current_url}&url_params=${url_params}`"
                >
                  <img
                    :src="language?.flag_icon?.full_path"
                    style="width: 32px; height: 32px"
                    class="mx-auto"
                  />
                  {{ language?.name }}
                  <span v-if="language.is_default != 1"
                    >,{{ language?.native_name }}
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
export default {
  props: ["languages", "current_url", "url_params"],
  data() {
    return {
      showModal: false,
      general_setting: null,
    };
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
  },
};
</script>
