<template>
    <AppLayout>
      <div class="relative shadow-md sm:rounded-lg bg-white py-4">
        <header class="pt-4">
          <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
              <h3 class="can-exp-h3 text-primary">
                {{ isFormEdit ? "Edit" : "Create" }} financingProgram
              </h3>
              <router-link
                :to="{ name: 'admin.financingPrograms.index' }"
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
                    validationErros.has(`name_title.name_title_${language.id}`) ||
                    validationErros.has(`business_name.business_name_${language.id}`) ||
                    validationErros.has(`zipcode.zipcode_${language.id}`) ||
                    validationErros.has(`needs_intentions.needs_intentions_${language.id}`) ||
                    validationErros.has(`company_ownership.company_ownership_${language.id}`) ||
                    validationErros.has(`revenue_last_year.revenue_last_year_${language.id}`) ||
                    validationErros.has(`full_time_employees.full_time_employees_${language.id}`) ||
                    validationErros.has(`incorporation.incorporation_${language.id}`) ||
                    validationErros.has(`email.email_${language.id}`)
                      ? 'bg-red-600 border-red-600 text-white hover:text-white rounded hover:bg-red-600 hover:border-red-600'
                      : '',
                  ]"
                  >{{ language.name }}</a
                >
              </li>
            </ul>
          </div>

          <div
            class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6"
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
              <label for="business_name">Your business name</label>
              <input
                type="text"
                name="business_name"
                id="business_name"
                class="can-exp-input w-full block border border-gray-300 rounded"
                placeholder=" "
                @input="handleBusinessNameInput($event.target.value, language)"
                :value="
                  form['business_name'] && form['business_name'][`business_name_${language.id}`]
                    ? form['business_name'][`business_name_${language.id}`]
                    : ''
                "
              />
              <p
                class="mt-2 text-sm text-red-400"
                v-if="validationErros.has(`business_name.business_name_${language.id}`)"
                v-text="validationErros.get(`business_name.business_name_${language.id}`)"
              ></p>
            </div>
            <div class="relative z-0 w-full group">
              <label for="name">Your name and title </label>
              <input
                type="text"
                name="name_title"
                id="name_title"
                class="can-exp-input w-full block border border-gray-300 rounded"
                placeholder=" "
                @input="handleNameTitleInput($event.target.value, language)"
                :value="
                  form['name_title'] && form['name_title'][`name_title_${language.id}`]
                    ? form['name_title'][`name_title_${language.id}`]
                    : ''
                "
              />
              <p
                class="mt-2 text-sm text-red-400"
                v-if="validationErros.has(`name_title.name_title_${language.id}`)"
                v-text="validationErros.get(`name_title.name_title_${language.id}`)"
              ></p>
            </div>
            <div class="relative z-0 w-full group">
              <label for="email">Email</label>
              <input
                type="text"
                name="email"
                id="email"
                class="can-exp-input w-full block border border-gray-300 rounded"
                placeholder=" "
                @input="handleEmailInput($event.target.value, language)"
                :value="
                  form['email'] && form['email'][`email_${language.id}`]
                    ? form['email'][`email_${language.id}`]
                    : ''
                "
              />
              <p
                class="mt-2 text-sm text-red-400"
                v-if="validationErros.has(`email.email_${language.id}`)"
                v-text="validationErros.get(`email.email_${language.id}`)"
              ></p>
            </div>
            <div class="relative z-0 w-full group col-span-2">
              <label for="zipcode">Postal Code</label>
              <textarea
                name="zipcode"
                id="zipcode"
                class="can-exp-input w-full block border border-gray-300 rounded"
                placeholder=" "
                @input="handleZipcodeInput($event.target.value, language)"
                v-text="
                  form['zipcode'] && form['zipcode'][`zipcode_${language.id}`]
                    ? form['zipcode'][`zipcode_${language.id}`]
                    : ''
                "
              ></textarea>
              <p
                class="mt-2 text-sm text-red-400"
                v-if="validationErros.has(`zipcode.zipcode_${language.id}`)"
                v-text="validationErros.get(`zipcode.zipcode_${language.id}`)"
              ></p>
            </div>
            
            <div class="relative z-0 w-full group col-span-2">
              <label for="incorporation">Year of incorporation</label>
              <textarea
                name="incorporation"
                id="incorporation"
                class="can-exp-input w-full block border border-gray-300 rounded"
                placeholder=" "
                @input="handleIncorporationInput($event.target.value, language)"
                v-text="
                  form['incorporation'] && form['incorporation'][`incorporation_${language.id}`]
                    ? form['incorporation'][`incorporation_${language.id}`]
                    : ''
                "
              ></textarea>
              <p
                class="mt-2 text-sm text-red-400"
                v-if="validationErros.has(`incorporation.incorporation_${language.id}`)"
                v-text="validationErros.get(`incorporation.incorporation_${language.id}`)"
              ></p>
            </div>
            <div class="relative z-0 w-full group col-span-2">
              <label for="full_time_employees">Number of full-time employees</label>
              <textarea
                name="full_time_employees"
                id="full_time_employees"
                class="can-exp-input w-full block border border-gray-300 rounded"
                placeholder=" "
                @input="handleFullTimeEmployeesInput($event.target.value, language)"
                v-text="
                  form['full_time_employees'] && form['full_time_employees'][`full_time_employees_${language.id}`]
                    ? form['full_time_employees'][`full_time_employees_${language.id}`]
                    : ''
                "
              ></textarea>
              <p
                class="mt-2 text-sm text-red-400"
                v-if="validationErros.has(`full_time_employees.full_time_employees_${language.id}`)"
                v-text="validationErros.get(`full_time_employees.full_time_employees_${language.id}`)"
              ></p>
            </div>
            <div class="relative z-0 w-full group col-span-2">
              <label for="revenue_last_year">Revenue last year</label>
              <textarea
                name="revenue_last_year"
                id="revenue_last_year"
                class="can-exp-input w-full block border border-gray-300 rounded"
                placeholder=" "
                @input="handleRevenueLastYearInput($event.target.value, language)"
                v-text="
                  form['revenue_last_year'] && form['revenue_last_year'][`revenue_last_year_${language.id}`]
                    ? form['revenue_last_year'][`revenue_last_year_${language.id}`]
                    : ''
                "
              ></textarea>
              <p
                class="mt-2 text-sm text-red-400"
                v-if="validationErros.has(`revenue_last_year.revenue_last_year_${language.id}`)"
                v-text="validationErros.get(`revenue_last_year.revenue_last_year_${language.id}`)"
              ></p>
            </div>
            <div class="relative z-0 w-full group col-span-2">
              <label for="company_ownership">Company ownership</label>
              <textarea
                name="company_ownership"
                id="company_ownership"
                class="can-exp-input w-full block border border-gray-300 rounded"
                placeholder=" "
                @input="handleCompanyOwnershipInput($event.target.value, language)"
                v-text="
                  form['company_ownership'] && form['company_ownership'][`company_ownership_${language.id}`]
                    ? form['company_ownership'][`company_ownership_${language.id}`]
                    : ''
                "
              ></textarea>
              <p
                class="mt-2 text-sm text-red-400"
                v-if="validationErros.has(`company_ownership.company_ownership_${language.id}`)"
                v-text="validationErros.get(`company_ownership.company_ownership_${language.id}`)"
              ></p>
            </div>
            <div class="relative z-0 w-full group col-span-2">
              <label for="needs_intentions">Needs and intentions</label>
              <textarea
                name="needs_intentions"
                id="needs_intentions"
                class="can-exp-input w-full block border border-gray-300 rounded"
                placeholder=" "
                @input="handleNeedsIntentionsInput($event.target.value, language)"
                v-text="
                  form['needs_intentions'] && form['needs_intentions'][`needs_intentions_${language.id}`]
                    ? form['needs_intentions'][`needs_intentions_${language.id}`]
                    : ''
                "
              ></textarea>
              <p
                class="mt-2 text-sm text-red-400"
                v-if="validationErros.has(`needs_intentions.needs_intentions_${language.id}`)"
                v-text="validationErros.get(`needs_intentions.needs_intentions_${language.id}`)"
              ></p>
            </div>
          </div>

          <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
          <div class="relative z-0 w-full group">
            <label for="business_categories">Primary industry</label>
            <multiselect
              v-model="form.business_categories"
              :options="business_categories"
              :multiple="true"
              :close-on-select="false"
              track-by="id"
              label="category_name"
              placeholder="Select business categories..."
              @input="handleInput($event, 'business_categories')"
            ></multiselect>

            <p
              class="mt-2 text-sm text-red-400"
              v-if="validationErros.has('business_categories')"
              v-text="validationErros.get('business_categories')"
            ></p>
          </div>
        </div>

          <button type="submit" class="button-exp-fill" :disabled="loading">
            Submit
          </button>
        </form>
      </div>
    </AppLayout>
  </template>


  <script>
import { mapState, mapActions } from 'vuex';
  import Multiselect from 'vue-multiselect';
  export default {
    components: {
    Multiselect,
  },
    computed: {
      ...mapState({
        loading: (state) => state.financingPrograms.loading,
        isFormEdit: (state) => state.financingPrograms.isFormEdit,
        form: (state) => state.financingPrograms.form,
        validationErros: (state) => state.financingPrograms.validationErros,
        languages: (state) => state.languages.languages,
        business_categories: (state) => state.business_categories.business_categories,
      }),
    },
    data() {
      return {
        activeTab: null,
        business_categories: [],
      };
    },
    methods: {
        ...mapActions(['fetchFinancingProgram', 'addUpdateForm']),
      handleNameTitleInput(value, language) {
        this.$store.commit("financingPrograms/updateNameTitle", {
          name_title: value,
          id: language.id,
        });
      },
      handleBusinessNameInput(value, language) {
        this.$store.commit("financingPrograms/updateBusinessName", {
          business_name: value,
          id: language.id,
        });
      },
      handleEmailInput(value, language) {
        this.$store.commit("financingPrograms/updateEmail", {
          email: value,
          id: language.id,
        });
      },
      handleNeedsIntentionsInput(value, language) {
        this.$store.commit("financingPrograms/updateNeedsIntentions", {
          needs_intentions: value,
          id: language.id,
        });
      },
      handleCompanyOwnershipInput(value, language) {
        this.$store.commit("financingPrograms/updateCompanyOwnership", {
          company_ownership: value,
          id: language.id,
        });
      },
      handleRevenueLastYearInput(value, language) {
        this.$store.commit("financingPrograms/updateRevenueLastYear", {
            revenue_last_year: value,
          id: language.id,
        });
      },
      handleFullTimeEmployeesInput(value, language) {
        this.$store.commit("financingPrograms/updateFullTimeEmployees", {
            full_time_employees: value,
          id: language.id,
        });
      },
      handleIncorporationInput(value, language) {
        this.$store.commit("financingPrograms/updateIncorporation", {
            incorporation: value,
          id: language.id,
        });
      },
      handleZipcodeInput(value, language) {
        this.$store.commit("financingPrograms/updateZipcode", {
          zipcode: value,
          id: language.id,
        });
      },
      handleInput(value, fieldName) {
        this.$store.commit("financingPrograms/updateForm", {
          fieldName: fieldName,
          value: value,
        });
      },
      addUpdateForm() {
      const payload = {
        ...this.form,
        business_categories: this.form.business_categories.map(category => ({
          id: category.id,
          category_name: category.category_name,
        })),
      };

      this.$store.dispatch("financingPrograms/addUpdateForm", payload)
        .then(() => {
          this.$router.push({ name: "admin.financingPrograms.index" });
        })
        .catch(error => {
          console.error("Error submitting form:", error);
        });
    },
      changeLanguageTab(language) {
        this.activeTab = language.id;
      },
      fetchFinancingProgram() {
        if (this.$route.params.id) {
          let id = this.$route.params.id;
          this.$store.commit("financingPrograms/setIsFormEdit", 1);
          this.$store
            .dispatch("financingPrograms/fetchFinancingProgram", {
              id: id,
              url: `${process.env.MIX_ADMIN_API_URL}financingPrograms/${id}?withFinancingProgramDetail=1`,
            })
            .then((res) => {
                console.log(res);
              let data =
                res.data.data && res.data.data.financing_program_details
                  ? res.data.data.financing_program_details
                  : [];
            //   this.handleInput(
            //     res.data.data.business_category_id,
            //     "business_category_id"
            //   );
            if (data[0].primary_industry) {
                try {
                this.form.business_categories = JSON.parse(data[0].primary_industry);
                console.log(this.form.business_categories);
                } catch (error) {
                console.error("Error parsing primary_industry:", error);
                }
            }
            //   this.handleInput(res.data.data.company_name, "company_name");
              let obj = {};
              data.map((res) => {
                obj["name_title_" + res.language_id] = res.name_title;
              });
              this.$store.commit("financingPrograms/setNameTitle", obj);

              obj = {};
              data.map((res) => {
                obj["business_name_" + res.language_id] = res.business_name;
              });
              this.$store.commit("financingPrograms/setBusinessName", obj);

              obj = {};
              data.map((res) => {
                obj["email_" + res.language_id] = res.email;
              });
              this.$store.commit("financingPrograms/setEmail", obj);

              obj = {};
              data.map((res) => {
                obj["zipcode_" + res.language_id] = res.zipcode;
              });
              this.$store.commit("financingPrograms/setZipcode", obj);
              obj = {};
              data.map((res) => {
                obj["incorporation_" + res.language_id] = res.incorporation;
              });
              this.$store.commit("financingPrograms/setIncorporation", obj);
              obj = {};
              data.map((res) => {
                obj["company_ownership_" + res.language_id] = res.company_ownership;
              });
              this.$store.commit("financingPrograms/setCompanyOwnership", obj);
              obj = {};
              data.map((res) => {
                obj["needs_intentions_" + res.language_id] = res.needs_intentions;
              });
              this.$store.commit("financingPrograms/setNeedsIntentions", obj);
              obj = {};
              data.map((res) => {
                obj["full_time_employees_" + res.language_id] = res.full_time_employees;
              });
              this.$store.commit("financingPrograms/setFullTimeEmployees", obj);
              obj = {};
              data.map((res) => {
                obj["revenue_last_year_" + res.language_id] = res.revenue_last_year;
              });
              this.$store.commit("financingPrograms/setRevenueLastYear", obj);
            });
        }
      },
    },
    created() {
      this.$store.commit("financingPrograms/resetForm");
      this.$store
        .dispatch("languages/fetchLanguages", {
          url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
        })
        .then((res) => {
          let data = res.data.data;
          let obj = {};
          data.map((res) => {
            obj["name_title_" + res.id] = "";
          });
          this.$store.commit("financingPrograms/setNameTitle", obj);
          obj = {};
          data.map((res) => {
            obj["business_name_" + res.id] = "";
          });
          this.$store.commit("financingPrograms/setBusinessName", obj);
          obj = {};
          data.map((res) => {
            obj["email_" + res.id] = "";
          });
          this.$store.commit("financingPrograms/setEmail", obj);
          obj = {};
          data.map((res) => {
            obj["zipcode_" + res.id] = "";
          });
          this.$store.commit("financingPrograms/setZipcode", obj);
          obj = {};
          data.map((res) => {
            obj["revenue_last_year_" + res.id] = "";
          });
          this.$store.commit("financingPrograms/setRevenueLastYear", obj);
          obj = {};
          data.map((res) => {
            obj["full_time_employees_" + res.id] = "";
          });
          this.$store.commit("financingPrograms/setFullTimeEmployees", obj);
          obj = {};
          data.map((res) => {
            obj["incorporation_" + res.id] = "";
          });
          this.$store.commit("financingPrograms/setIncorporation", obj);
          obj = {};
          data.map((res) => {
            obj["company_ownership_" + res.id] = "";
          });
          this.$store.commit("financingPrograms/setCompanyOwnership", obj);
          obj = {};
          data.map((res) => {
            obj["needs_intentions_" + res.id] = "";
          });
          this.$store.commit("financingPrograms/setNeedsIntentions", obj);
          this.fetchFinancingProgram();
          this.$store.dispatch("business_categories/fetchBusinessCategories", {
        url: `${process.env.MIX_ADMIN_API_URL}business-categories?getAll=1`,
    });
        });
    },
    mounted() {
        const apiUrl = `${process.env.MIX_WEB_API_URL}business-categories`;
  axios.get(apiUrl)
    .then(response => {
      this.business_categories = response.data;
    })
    .catch(error => {
      console.error("Error fetching business categories:", error);
    });
}

  };
  </script>
  <style src="vue-multiselect/dist/vue-multiselect.css"></style>
