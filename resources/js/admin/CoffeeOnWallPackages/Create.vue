<template>
  <AppLayout>
    <div class="relative shadow-md sm:rounded-lg bg-white py-4">
      <header class="pt-4">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <h1 class="can-exp-h3 mb-0 text-primary">
              {{ isFormEdit ? "Edit" : "Create" }} coffee on wall package
            </h1>
            <router-link
              :to="{ name: 'admin.coffee_on_wall_packages.index' }"
              class="button-exp-fill"
            >
              Back
            </router-link>
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
                @click.prevent="changeLanguageTab(language)"
                href="#"
                :class="[
                  'inline-block rounded font-FuturaMdCnBT px-5 py-2 lg:text-lg md:text-base sm:text-base text-base hover:bg-blue-100 border border-primary text-center hover:border-blue-500 hover:text-blue-600',
                  (activeTab == null && language.is_default) ||
                  activeTab == language.id
                    ? 'bg-blue-600 text-white'
                    : '',
                  validationErros.has(`name.name_${language.id}`) ||
                  validationErros.has(
                    `short_description.short_description_${language.id}`
                  )
                    ? 'bg-red-600 border-red-600 text-white hover:text-white rounded hover:bg-red-600 hover:border-red-600'
                    : '',
                ]"
                >{{ language.name }}</a
              >
            </li>
          </ul>
        </div>

        <div
          class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 md:gap-6"
          v-for="language in languages"
          :key="language.id"
          :class="
            (activeTab == null && language.is_default) ||
            activeTab == language.id
              ? 'block'
              : 'hidden'
          "
        >
          <div class="relative z-0 w-full group">
            <label for="name">Name</label>
            <input
              type="text"
              name="name"
              id="name"
              class="can-exp-input w-full block border border-gray-300 rounded"
              placeholder=" "
              @input="handleNameInput($event.target.value, language)"
              :value="
                form['name'] && form['name'][`name_${language.id}`]
                  ? form['name'][`name_${language.id}`]
                  : ''
              "
            />
            <p
              class="mt-2 text-sm text-red-400"
              v-if="validationErros.has(`name.name_${language.id}`)"
              v-text="validationErros.get(`name.name_${language.id}`)"
            ></p>
          </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4 md:gap-6">
          <div class="relative z-0 w-full group">
            <label for="price">Price</label>
            <input
              type="number"
              name="price"
              id="price"
              class="can-exp-input w-full block border border-gray-300 rounded"
              placeholder=" "
              :value="form.price"
              @input="updateForm('price', $event.target.value)"
            />
            <p
              class="mt-2 text-sm text-red-400"
              v-if="validationErros.has('price')"
              v-text="validationErros.get('price')"
            ></p>
          </div>
        </div>

        <div class="relative z-0 w-full group mt-8">
            <fieldset>
                <legend class="sr-only">Set as default</legend>
                <div class="flex items-center mb-4">
                    <input
                        id="is_default"
                        name="is_default"
                        type="checkbox"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                        v-model="is_default"
                    />
                    <label
                        for="is_default"
                        class="ml-2 text-sm font-medium text-gray-900"
                        >Set as default</label
                    >
                </div>
            </fieldset>
            <p
                class="mt-2 text-sm text-red-400"
                v-if="validationErros.has('is_default')"
                v-text="validationErros.get('is_default')"
            ></p>
        </div>

        <button type="submit" class="button-exp-fill mt-5" :disabled="loading">
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
      loading: (state) => state.coffee_wall_packages.loading,
      isFormEdit: (state) => state.coffee_wall_packages.isFormEdit,
      form: (state) => state.coffee_wall_packages.form,
      validationErros: (state) => state.coffee_wall_packages.validationErros,
      languages: (state) => state.languages.languages,
      general_setting: (state) => state.general_setting.general_setting,
    }),
    is_default: {
      get: function () {
        return this.$store.state.coffee_wall_packages.form.is_default;
      },
      set: function (val) {
        this.$store.commit("coffee_wall_packages/setForm", {
          is_default: val,
        });
      },
    },
  },
  data() {
    return {
      activeTab: null,
    };
  },
  methods: {
    updateForm(field, value) {
      this.$store.commit("coffee_wall_packages/setForm", {
        [field]: value,
      });
      if (field == "type" && value == 'event') {
        if(this.form.package_type == 'free'){
          this.$store.commit("coffee_wall_packages/setForm", {
            package_type: null,
          });
        }
        this.$store.commit("coffee_wall_packages/setForm", {
          quarterly_price: null,
        });
        this.$store.commit("coffee_wall_packages/setForm", {
          semi_annually_price: null,
        });
        this.$store.commit("coffee_wall_packages/setForm", {
          annually_price: null,
        });
      }
      else if (field == "type") {
        this.$store.commit("coffee_wall_packages/setForm", {
          event_price: null,
        });
      }
      if (field == "monthly_price") {
        if(isNaN(value)){
          value = 0;
        }
        this.$store.commit("coffee_wall_packages/setForm", {
          quarterly_price: (value*3*0.9/3).toFixed(2),
        });
        this.$store.commit("coffee_wall_packages/setForm", {
          semi_annually_price: (value*6*0.8/6).toFixed(2),
        });
        this.$store.commit("coffee_wall_packages/setForm", {
          annually_price: (value*12*0.7/12).toFixed(2),
        });
      }
      if (field == "package_validity_months" || field == "package_type") {
        let packageSetting = null;
        if (this.form.package_type == "free") {
          packageSetting = this.general_setting.filter(
            (res) => res.key == "free_package_price_per_month"
          );
        } else if (this.form.package_type == "featured") {
          packageSetting = this.general_setting.filter(
            (res) => res.key == "featured_package_price_per_month"
          );
        } else if (this.form.package_type == "premium") {
          packageSetting = this.general_setting.filter(
            (res) => res.key == "premium_package_price_per_month"
          );
        }

        if (packageSetting && packageSetting[0]) {
          this.$store.commit("coffee_wall_packages/setForm", {
            price:
              packageSetting[0]["value"] * this.form.package_validity_months,
          });
        } else {
          this.$store.commit("coffee_wall_packages/setForm", {
            price: 0,
          });
        }
      }
    },
    handleNameInput(value, language) {
      this.$store.commit("coffee_wall_packages/updateName", {
        name: value,
        id: language.id,
      });
    },
    handleShortDescInput(value, language) {
      this.$store.commit("coffee_wall_packages/updateShortDescriptionText", {
        short_description: value,
        id: language.id,
      });
    },
    addUpdateForm() {
      this.$store
        .dispatch("coffee_wall_packages/addUpdateForm")
        .then(() =>
          this.$router.push({ name: "admin.coffee_on_wall_packages.index" })
        );
    },
    changeLanguageTab(language) {
      this.activeTab = language.id;
    },
    fetchRegistrationPackage() {
      if (this.$route.params.id) {
        let id = this.$route.params.id;
        this.$store.commit("coffee_wall_packages/setIsFormEdit", 1);
        this.$store
          .dispatch("coffee_wall_packages/fetchRegistrationPackage", {
            id: id,
            url: `${process.env.MIX_ADMIN_API_URL}coffee-wall-packages/${id}?withRegistrationPackageDetail=1&withRegistrationPackageFeature=1`,
          })
          .then((res) => {
            let data =
              res.data.data && res.data.data.coffee_wall_package_detail
                ? res.data.data.coffee_wall_package_detail
                : [];
            let obj = {};
            data.map((res) => {
              obj["name_" + res.language_id] = res.name;
            });
            this.$store.commit("coffee_wall_packages/setName", obj);
            obj = {};
            data.map((res) => {
              obj["short_description_" + res.language_id] =
                res.short_description;
            });
            this.$store.commit(
              "coffee_wall_packages/setShortDescriptionText",
              obj
            );
            this.$store.commit("coffee_wall_packages/setForm", {
                is_default: Number(res.data.data.is_default) === 1,
            });
          });
      }
    },
    addNewFeature(languageId, value = null) {
      this.$store.commit("coffee_wall_packages/addNewFeature", {
        languageId: languageId,
        value: value || "",
      });
    },
    removeFeature(languageId, index) {
      this.$store.commit("coffee_wall_packages/removeFeature", {
        languageId: languageId,
        index: index,
      });
    },
    handleFeatureInput(languageId, value, index) {
      this.$store.commit("coffee_wall_packages/handleFeatureInput", {
        languageId: languageId,
        value: value,
        index: index,
      });
    },
  },
  created() {
    this.$store.commit("coffee_wall_packages/resetForm");
    this.$store
      .dispatch("languages/fetchLanguages", {
        url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
      })
      .then((res) => {
        let data = res.data.data;
        let obj = {};
        data.map((res) => {
          obj["name_" + res.id] = "";
        });
        this.$store.commit("coffee_wall_packages/setName", obj);
        obj = {};
        data.map((res) => {
          obj["short_description_" + res.id] = "";
        });
        this.$store.commit(
          "coffee_wall_packages/setShortDescriptionText",
          obj
        );
        this.fetchRegistrationPackage();
        this.$store.dispatch("general_setting/fetchGeneralSetting", {
          url: `${process.env.MIX_ADMIN_API_URL}general-setting?onlyPackageSetting=1`,
        });
      });
  },
};
</script>
