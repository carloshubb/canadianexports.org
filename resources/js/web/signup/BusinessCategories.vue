<template>
    <div>
      <div
        class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-xblue via-primary to-blue-600 rounded-md"
      >
        <template v-if="profile == '1'">
          <h4
            class="text-white"
            v-html="
              JSON.parse(user)?.is_package_amount_paid
                ? regPageSetting?.reg_page_setting_detail?.[0]?.step_3_acc_heading
                : regPageSetting?.reg_page_setting_detail?.[0]?.step_3_heading
            "
          ></h4>
        </template>
        <template v-else>
          <h4
            class="text-white"
            v-html="
              regPageSetting?.reg_page_setting_detail?.[0]?.step_3_heading
            "
          ></h4>
        </template>
      </div>
      <div class="my-4 space-y-4" id="business_categories_id">
        <p
          v-html="
            regPageSetting?.reg_page_setting_detail?.[0]?.step_3_description
          "
        ></p>
        <Error
          fieldName="business_categories_id"
          :validationErros="validationErros"
        />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 py-3 mb-6">
          <div
            class="flex items-center"
            v-for="businessCategory in businessCategories"
            :key="businessCategory.id"
          >
            <input
              :id="`business-category-${businessCategory.id}`"
              type="checkbox"
              :value="businessCategory.id"
              class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary"
              @input="(e) => {
                updateForm(e.target.checked, businessCategory.id);
                clearValidationError('business_categories_id');
              }"
              :disabled="isCheckboxDisabled(businessCategory.id)"
              :checked="
                customer_business_categories &&
                JSON.parse(customer_business_categories).includes(
                  businessCategory.id
                )
              "
            />
            <!-- <input
  :id="`business-category-${businessCategory.id}`"
  type="checkbox"
  :value="businessCategory.id"
  class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary"
  @input="(e) => {
    updateForm(e.target.checked, businessCategory.id);
    clearValidationError('business_categories_id');
  }"
  :disabled="isCheckboxDisabled(businessCategory.id)"
  :checked="selectedBusinessCategiroes.includes(businessCategory.id)"
/> -->
            <label
              :for="`business-category-${businessCategory.id}`"
              class="ml-2"
              :class="
                isCheckboxDisabled(businessCategory.id)
                  ? 'text-gray-400 dark:text-gray-500'
                  : 'text-gray-900 text-base md:text-base lg:text-lg'
              "
            >{{
              businessCategory.category_name
                ? titleCase(businessCategory.category_name)
                : ""
            }}</label>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script>
  import { mapState } from "vuex";
  import Error from "./../components/Error.vue";

  export default {
    props: ["customer_business_categories", "profile", "page_id", "user"],
    computed: {
      ...mapState({
        regPageSetting: (state) => state.signup.regPageSetting,
        validationErros: (state) => state.signup.validationErros,
        businessCategories: (state) => state.signup.businessCategories,
        form: (state) => state.signup.form,
      }),
      isCheckboxDisabled() {
        return (value) => {
          const isSelected = this.selectedBusinessCategiroes.includes(value);
          const exceedsLimit = this.selectedBusinessCategiroes.length >= 3;
          return exceedsLimit && !isSelected;
        };
      },
    },
    data() {
      return {
        selectedBusinessCategiroes: [],
      };
    },
    components: {
      Error,
    },
    created() {
      if (this.profile == "1") {
        if (this.customer_business_categories) {
          JSON.parse(this.customer_business_categories).map((res) => {
            this.updateForm(true, res);
          });
        }
        this.$store.dispatch("signup/fetchBusinessCategories");
      }
    },
//     created() {
//   // Retrieve selected checkboxes from localStorage
//   const storedSelectedCategories = localStorage.getItem("selectedBusinessCategories");
//   if (storedSelectedCategories) {
//     this.selectedBusinessCategiroes = JSON.parse(storedSelectedCategories);
//   }

//   if (this.profile == "1") {
//     if (this.customer_business_categories) {
//       JSON.parse(this.customer_business_categories).map((res) => {
//         this.updateForm(true, res);
//       });
//     }
//     this.$store.dispatch("signup/fetchBusinessCategories");
//   }

//   // Re-check checkboxes based on stored values
//   this.$nextTick(() => {
//     this.selectedBusinessCategiroes.forEach((categoryId) => {
//       const checkbox = document.getElementById(`business-category-${categoryId}`);
//       if (checkbox) {
//         checkbox.checked = true;
//       }
//     });
//   });
// },
    methods: {
      titleCase(str) {
        var splitStr = str.toLowerCase().split(" ");
        for (var i = 0; i < splitStr.length; i++) {
          splitStr[i] =
            splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);
        }
        return splitStr.join(" ");
      },
      clearValidationError(field) {
        this.$store.commit("signup/removeValidationError", field);
      },
      updateForm(checked, value) {
        this.clearValidationError("business_categories_id");

        let type = checked ? "add" : "remove";
        let index = this.selectedBusinessCategiroes.indexOf(value);

        if (type === "add" && index === -1) {
          this.selectedBusinessCategiroes.push(value);
        } else if (type === "remove" && index > -1) {
          this.selectedBusinessCategiroes.splice(index, 1);
        }

        if (this.selectedBusinessCategiroes.length > 3 && type === "add") {
          this.$store.commit("signup/setBusinessCategoriesForm", {
            value: value,
            type: "remove",
          });
          if (document.getElementById(`business-category-${value}`)) {
            document.getElementById(`business-category-${value}`).checked = false;
          }
          return false;
        } else {
          this.$store.commit("signup/setBusinessCategoriesForm", {
            value: value,
            type: type,
          });
        }
      },
//     updateForm(checked, value) {
//   this.clearValidationError("business_categories_id");

//   let type = checked ? "add" : "remove";
//   let index = this.selectedBusinessCategiroes.indexOf(value);

//   if (type === "add" && index === -1) {
//     this.selectedBusinessCategiroes.push(value);
//   } else if (type === "remove" && index > -1) {
//     this.selectedBusinessCategiroes.splice(index, 1);
//   }

//   // Update localStorage with the selected values
//   localStorage.setItem(
//     "selectedBusinessCategories",
//     JSON.stringify(this.selectedBusinessCategiroes)
//   );

//   if (this.selectedBusinessCategiroes.length > 3 && type === "add") {
//     this.$store.commit("signup/setBusinessCategoriesForm", {
//       value: value,
//       type: "remove",
//     });
//     if (document.getElementById(`business-category-${value}`)) {
//       document.getElementById(`business-category-${value}`).checked = false;
//     }
//     return false;
//   } else {
//     this.$store.commit("signup/setBusinessCategoriesForm", {
//       value: value,
//       type: type,
//     });
//   }
// },
    },
//     beforeDestroy() {
//     // Clear localStorage when the component is destroyed (optional)
//     localStorage.removeItem("selectedBusinessCategories");
//   },
  };
  </script>
