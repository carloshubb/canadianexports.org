<template>
  <AppLayout>
    <div class="relative shadow-md sm:rounded-lg bg-white py-4">
      <header class="pt-4">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <h3 class="can-exp-h3 text-primary">
              {{ isFormEdit ? "Edit" : "Create" }} testimonial
            </h3>
            <router-link
              :to="{ name: 'admin.testimonials.index' }"
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
                  validationErros.has(`place.place_${language.id}`) ||
                  validationErros.has(`email.email_${language.id}`) ||
                  validationErros.has(`comment.comment_${language.id}`)
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
            <label for="name">Name and title</label>
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
            <label for="place">Company name and country</label>
            <input
              type="text"
              name="place"
              id="place"
              class="can-exp-input w-full block border border-gray-300 rounded"
              placeholder=" "
              @input="handlePlaceInput($event.target.value, language)"
              :value="
                form['place'] && form['place'][`place_${language.id}`]
                  ? form['place'][`place_${language.id}`]
                  : ''
              "
            />
            <p
              class="mt-2 text-sm text-red-400"
              v-if="validationErros.has(`place.place_${language.id}`)"
              v-text="validationErros.get(`place.place_${language.id}`)"
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
            <label for="comment">Comment</label>
            <textarea
              name="comment"
              id="comment"
              class="can-exp-input w-full block border border-gray-300 rounded"
              placeholder=" "
              @input="handleCommentInput($event.target.value, language)"
              v-text="
                form['comment'] && form['comment'][`comment_${language.id}`]
                  ? form['comment'][`comment_${language.id}`]
                  : ''
              "
            ></textarea>
            <p
              class="mt-2 text-sm text-red-400"
              v-if="validationErros.has(`comment.comment_${language.id}`)"
              v-text="validationErros.get(`comment.comment_${language.id}`)"
            ></p>
          </div>
        </div>
        <div
          class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6"
        >
          <div class="relative z-0 w-full group">
            <label for="name">Business categories</label>
            <!-- <select
              @input="handleInput($event.target.value, 'business_category_id')"
              class="can-exp-input w-full block border border-gray-300 rounded"
            >
              <option value="">Select business category...</option>
              <option
                v-for="business_category in business_categories"
                :key="business_category.id"
                :value="business_category.id"
                :selected="business_category.id == form.business_category_id"
              >
                {{
                  business_category.business_category_detail &&
                  business_category.business_category_detail[0]
                    ? business_category.business_category_detail[0].name
                    : ""
                }}
              </option>
            </select> -->
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
              v-if="validationErros.has('business_category_id')"
              v-text="validationErros.get('business_category_id')"
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
import { mapState } from "vuex";
import Multiselect from 'vue-multiselect';
export default {
    components: {
    Multiselect,
  },
  computed: {
    ...mapState({
      loading: (state) => state.testimonials.loading,
      isFormEdit: (state) => state.testimonials.isFormEdit,
      form: (state) => state.testimonials.form,
      validationErros: (state) => state.testimonials.validationErros,
      languages: (state) => state.languages.languages,
      business_categories: (state) =>
        state.business_categories.business_categories,
    }),
  },
  data() {
    return {
      activeTab: null,
      business_categories: [],
    };
  },
  methods: {
    handleNameInput(value, language) {
      this.$store.commit("testimonials/updateName", {
        name: value,
        id: language.id,
      });
    },
    handlePlaceInput(value, language) {
      this.$store.commit("testimonials/updatePlace", {
        place: value,
        id: language.id,
      });
    },
    handleEmailInput(value, language) {
      this.$store.commit("testimonials/updateEmail", {
        email: value,
        id: language.id,
      });
    },
    handleCommentInput(value, language) {
      this.$store.commit("testimonials/updateComment", {
        comment: value,
        id: language.id,
      });
    },
    handleInput(value, fieldName) {
      this.$store.commit("testimonials/updateForm", {
        fieldName: fieldName,
        value: value,
      });
    },
    addUpdateForm() {
      this.$store
        .dispatch("testimonials/addUpdateForm")
        .then(() => this.$router.push({ name: "admin.testimonials.index" }));
    },
    changeLanguageTab(language) {
      this.activeTab = language.id;
    },
    fetchTestimonial() {
      if (this.$route.params.id) {
        let id = this.$route.params.id;
        this.$store.commit("testimonials/setIsFormEdit", 1);
        this.$store
          .dispatch("testimonials/fetchTestimonial", {
            id: id,
            url: `${process.env.MIX_ADMIN_API_URL}testimonials/${id}?withTestimonialDetail=1`,
          })
          .then((res) => {
            let data =
              res.data.data && res.data.data.testimonial_detail
                ? res.data.data.testimonial_detail
                : [];
            // this.handleInput(
            //   res.data.data.business_category_id,
            //   "business_category_id"
            // );
            if (data[0].primary_industry) {
                try {
                this.form.business_categories = JSON.parse(data[0].primary_industry);
                console.log(this.form.business_categories);
                } catch (error) {
                console.error("Error parsing primary_industry:", error);
                }
            }
            this.handleInput(res.data.data.company_name, "company_name");
            let obj = {};
            data.map((res) => {
              obj["name_" + res.language_id] = res.name;
            });
            this.$store.commit("testimonials/setName", obj);

            obj = {};
            data.map((res) => {
              obj["place_" + res.language_id] = res.place;
            });
            this.$store.commit("testimonials/setPlace", obj);

            obj = {};
            data.map((res) => {
              obj["email_" + res.language_id] = res.email;
            });
            this.$store.commit("testimonials/setEmail", obj);

            obj = {};
            data.map((res) => {
              obj["comment_" + res.language_id] = res.comment;
            });
            this.$store.commit("testimonials/setComment", obj);
          });
      }
    },
  },
  created() {
    this.$store.commit("testimonials/resetForm");
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
        this.$store.commit("testimonials/setName", obj);
        obj = {};
        data.map((res) => {
          obj["place_" + res.id] = "";
        });
        this.$store.commit("testimonials/setPlace", obj);
        obj = {};
        data.map((res) => {
          obj["email_" + res.id] = "";
        });
        this.$store.commit("testimonials/setEmail", obj);
        obj = {};
        data.map((res) => {
          obj["comment_" + res.id] = "";
        });
        this.$store.commit("testimonials/setComment", obj);
        this.fetchTestimonial();
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
