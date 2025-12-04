<template>
  <AppLayout>
    <div class="relative shadow-md sm:rounded-lg bg-white py-4">
      <header class="pt-4">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <h1 class="can-exp-h3 mb-0 text-primary">
              {{ isFormEdit ? "Edit" : "Create" }} registration package
            </h1>
            <router-link
              :to="{ name: 'admin.registration_packages.index' }"
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
          <div class="relative z-0 w-full group">
            <label for="short_description">Short description</label>
            <input
              type="text"
              name="short_description"
              id="short_description"
              class="can-exp-input w-full block border border-gray-300 rounded"
              placeholder=" "
              @input="handleShortDescInput($event.target.value, language)"
              :value="
                form['short_description'] &&
                form['short_description'][`short_description_${language.id}`]
                  ? form['short_description'][
                      `short_description_${language.id}`
                    ]
                  : ''
              "
            />
            <p
              class="mt-2 text-sm text-red-400"
              v-if="
                validationErros.has(
                  `short_description.short_description_${language.id}`
                )
              "
              v-text="
                validationErros.get(
                  `short_description.short_description_${language.id}`
                )
              "
            ></p>
          </div>
        </div>
        <div
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
            <label for="features">Features</label>
            <template
              v-for="(features, index) in form['features'][
                `features_${language.id}`
              ]"
              :key="index"
            >
              <div class="mt-4 flex justify-between items-center gap-4">
                <input
                  type="text"
                  name="features"
                  id="features"
                  class="can-exp-input w-full block border border-gray-300 rounded"
                  placeholder=" "
                  @input="
                    handleFeatureInput(language.id, $event.target.value, index)
                  "
                  :value="features"
                />
                <button
                  class="button-exp-fill"
                  type="button"
                  @click="removeFeature(language.id, index)"
                >
                  Remove
                </button>
              </div>
            </template>
            <div class="text-right my-4">
              <button
                class="button-exp-fill"
                type="button"
                @click="addNewFeature(language.id)"
              >
                Add new feature
              </button>
            </div>
            <p
              class="mt-2 text-sm text-red-400"
              v-if="validationErros.has(`features.features_${language.id}`)"
              v-text="
                validationErros.get(
                  `short_description.short_description_${language.id}`
                )
              "
            ></p>
          </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4 md:gap-6">
          <div class="relative z-0 w-full group">
            <div class="flex justify-between items-center">
              <label for="package_type">Package type</label>
              <fieldset>
                <legend class="sr-only">Set as default</legend>
                <div class="flex items-center">
                  <input
                    id="is_default"
                    name="is_default"
                    type="checkbox"
                    value=""
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                    :checked="is_default"
                    v-model="is_default"
                  />
                  <label
                    for="is_default"
                    class="ml-2 text-sm font-medium text-gray-900"
                    >Set as default</label
                  >
                </div>
              </fieldset>
            </div>
            <select
              id="package_type"
              @change="updateForm('package_type', $event.target.value)"
              class="can-exp-input w-full block border border-gray-300 rounded"
            >
              <option value="">Select package type...</option>
              <option value="free" v-if="form.type == 'profile'" :selected="form.package_type == 'free'">
                Free package
              </option>
              <option
                value="featured"
                :selected="form.package_type == 'featured'"
              >
                Featured package
              </option>
              <option
                value="premium"
                :selected="form.package_type == 'premium'"
              >
                Premium package
              </option>
            </select>
            <p
              class="mt-2 text-sm text-red-400"
              v-if="validationErros.has('package_type')"
              v-text="validationErros.get('package_type')"
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="type">Package for</label>
            <select
              id="type"
              @change="updateForm('type', $event.target.value)"
              class="can-exp-input w-full block border border-gray-300 rounded"
            >
              <option value="">Select package for...</option>
              <option value="profile" :selected="form.type == 'profile'">
                Profile package
              </option>
              <option value="event" :selected="form.type == 'event'">
                Event package
              </option>
            </select>
            <p
              class="mt-2 text-sm text-red-400"
              v-if="validationErros.has('type')"
              v-text="validationErros.get('type')"
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="events_allowed">Events allowed</label>
            <input
              type="number"
              name="events_allowed"
              id="events_allowed"
              class="can-exp-input w-full block border border-gray-300 rounded"
              placeholder=" "
              :value="form.events_allowed"
              @input="updateForm('events_allowed', $event.target.value)"
            />
            <p
              class="mt-2 text-sm text-red-400"
              v-if="validationErros.has('events_allowed')"
              v-text="validationErros.get('events_allowed')"
            ></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="images_allowed">Images allowed</label>
            <input
              type="number"
              name="images_allowed"
              id="images_allowed"
              class="can-exp-input w-full block border border-gray-300 rounded"
              placeholder=" "
              :value="form.images_allowed"
              @input="updateForm('images_allowed', $event.target.value)"
            />
            <p
              class="mt-2 text-sm text-red-400"
              v-if="validationErros.has('images_allowed')"
              v-text="validationErros.get('images_allowed')"
            ></p>
          </div>
        </div>
        <template
          v-if="
            form.package_type == 'featured' || form.package_type == 'premium'
          "
        >
          <div class="grid md:grid-cols-2 gap-4 md:gap-6 mt-6" v-if="form.type == 'profile'">
            <div class="relative z-0 w-full group">
              <label for="monthly_price">Monthly Price</label>
              <input
                type="text"
                name="monthly_price"
                id="monthly_price"
                class="can-exp-input w-full block border border-gray-300 rounded"
                placeholder=" "
                :value="form.monthly_price"
                @input="updateForm('monthly_price', $event.target.value)"
              />
              <p
                class="mt-2 text-sm text-red-400"
                v-if="validationErros.has('monthly_price')"
                v-text="validationErros.get('monthly_price')"
              ></p>
            </div>
            <div class="relative z-0 w-full group">
              <label for="quarterly_price">Quarterly price per month</label>
              <input
                type="text"
                name="quarterly_price"
                id="quarterly_price"
                class="can-exp-input w-full block border border-gray-300 rounded"
                placeholder=" "
                :value="form.quarterly_price"
                @input="updateForm('quarterly_price', $event.target.value)"
              />
              <p
                class="mt-2 text-sm text-red-400"
                v-if="validationErros.has('quarterly_price')"
                v-text="validationErros.get('quarterly_price')"
              ></p>
            </div>
            <div class="relative z-0 w-full group">
              <label for="semi_annually_price"
                >Semi annually price per month</label
              >
              <input
                type="text"
                name="semi_annually_price"
                id="semi_annually_price"
                class="can-exp-input w-full block border border-gray-300 rounded"
                placeholder=" "
                :value="form.semi_annually_price"
                @input="updateForm('semi_annually_price', $event.target.value)"
              />
              <p
                class="mt-2 text-sm text-red-400"
                v-if="validationErros.has('semi_annually_price')"
                v-text="validationErros.get('semi_annually_price')"
              ></p>
            </div>
            <div class="relative z-0 w-full group">
              <label for="annually_price">Annually price per month</label>
              <input
                type="text"
                name="annually_price"
                id="annually_price"
                class="can-exp-input w-full block border border-gray-300 rounded"
                placeholder=" "
                :value="form.annually_price"
                @input="updateForm('annually_price', $event.target.value)"
              />
              <p
                class="mt-2 text-sm text-red-400"
                v-if="validationErros.has('annually_price')"
                v-text="validationErros.get('annually_price')"
              ></p>
            </div>
          </div>
          <div class="grid md:grid-cols-2 gap-4 md:gap-6 mt-6" v-else-if="form.type == 'event'">
            <div class="relative z-0 w-full group">
              <label for="event_price">Price</label>
              <input
                type="text"
                name="event_price"
                id="event_price"
                class="can-exp-input w-full block border border-gray-300 rounded"
                placeholder=" "
                :value="form.event_price"
                @input="updateForm('event_price', $event.target.value)"
              />
              <p
                class="mt-2 text-sm text-red-400"
                v-if="validationErros.has('event_price')"
                v-text="validationErros.get('event_price')"
              ></p>
            </div>
          </div>
        </template>

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
      loading: (state) => state.registration_packages.loading,
      isFormEdit: (state) => state.registration_packages.isFormEdit,
      form: (state) => state.registration_packages.form,
      validationErros: (state) => state.registration_packages.validationErros,
      languages: (state) => state.languages.languages,
      general_setting: (state) => state.general_setting.general_setting,
    }),
    is_default: {
      get: function () {
        return this.$store.state.registration_packages.form.is_default;
      },
      set: function (val) {
        this.$store.commit("registration_packages/setForm", {
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
      this.$store.commit("registration_packages/setForm", {
        [field]: value,
      });
      if (field == "type" && value == 'event') {
        if(this.form.package_type == 'free'){
          this.$store.commit("registration_packages/setForm", {
            package_type: null,
          });
        }
        this.$store.commit("registration_packages/setForm", {
          quarterly_price: null,
        });
        this.$store.commit("registration_packages/setForm", {
          semi_annually_price: null,
        });
        this.$store.commit("registration_packages/setForm", {
          annually_price: null,
        });
      }
      else if (field == "type") {
        this.$store.commit("registration_packages/setForm", {
          event_price: null,
        });
      }
      if (field == "monthly_price") {
        if(isNaN(value)){
          value = 0;
        }
        this.$store.commit("registration_packages/setForm", {
          quarterly_price: (value*3*0.9/3).toFixed(2),
        });
        this.$store.commit("registration_packages/setForm", {
          semi_annually_price: (value*6*0.8/6).toFixed(2),
        });
        this.$store.commit("registration_packages/setForm", {
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
          this.$store.commit("registration_packages/setForm", {
            price:
              packageSetting[0]["value"] * this.form.package_validity_months,
          });
        } else {
          this.$store.commit("registration_packages/setForm", {
            price: 0,
          });
        }
      }
    },
    handleNameInput(value, language) {
      this.$store.commit("registration_packages/updateName", {
        name: value,
        id: language.id,
      });
    },
    handleShortDescInput(value, language) {
      this.$store.commit("registration_packages/updateShortDescriptionText", {
        short_description: value,
        id: language.id,
      });
    },
    addUpdateForm() {
      this.$store
        .dispatch("registration_packages/addUpdateForm")
        .then(() =>
          this.$router.push({ name: "admin.registration_packages.index" })
        );
    },
    changeLanguageTab(language) {
      this.activeTab = language.id;
    },
    fetchRegistrationPackage() {
      if (this.$route.params.id) {
        let id = this.$route.params.id;
        this.$store.commit("registration_packages/setIsFormEdit", 1);
        this.$store
          .dispatch("registration_packages/fetchRegistrationPackage", {
            id: id,
            url: `${process.env.MIX_ADMIN_API_URL}registration-packages/${id}?withRegistrationPackageDetail=1&withRegistrationPackageFeature=1`,
          })
          .then((res) => {
            let data =
              res.data.data && res.data.data.registration_package_detail
                ? res.data.data.registration_package_detail
                : [];
            let features =
              res.data.data && res.data.data.registration_package_feature
                ? res.data.data.registration_package_feature
                : [];
            let obj = {};
            data.map((res) => {
              obj["name_" + res.language_id] = res.name;
            });
            this.$store.commit("registration_packages/setName", obj);
            obj = {};
            data.map((res) => {
              obj["short_description_" + res.language_id] =
                res.short_description;
            });
            this.$store.commit(
              "registration_packages/setShortDescriptionText",
              obj
            );

            features.map((feature) => {
              this.addNewFeature(feature.language_id, feature.name);
            });
          });
      }
    },
    addNewFeature(languageId, value = null) {
      this.$store.commit("registration_packages/addNewFeature", {
        languageId: languageId,
        value: value || "",
      });
    },
    removeFeature(languageId, index) {
      this.$store.commit("registration_packages/removeFeature", {
        languageId: languageId,
        index: index,
      });
    },
    handleFeatureInput(languageId, value, index) {
      this.$store.commit("registration_packages/handleFeatureInput", {
        languageId: languageId,
        value: value,
        index: index,
      });
    },
  },
  created() {
    this.$store.commit("registration_packages/resetForm");
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
        this.$store.commit("registration_packages/setName", obj);
        obj = {};
        data.map((res) => {
          obj["short_description_" + res.id] = "";
        });
        this.$store.commit(
          "registration_packages/setShortDescriptionText",
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
