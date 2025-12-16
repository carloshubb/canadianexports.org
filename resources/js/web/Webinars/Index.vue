<template>
  <div class="relative shadow-md sm:rounded-lg bg-white py-6">
    <div class="px-4 sm:px-6 lg:px-8">
      <div class="mb-6">
        <h2 class="can-exp-h2 text-primary mb-2">
          Upcoming webinars
        </h2>
        <p class="text-gray-600" v-if="!webinars || webinars.length === 0">
          There are currently no upcoming webinars. Please check back later.
        </p>
      </div>

      <div
        v-if="webinars && webinars.length"
        class="grid gap-6 md:grid-cols-2"
      >
        <div
          v-for="webinar in webinars"
          :key="webinar.id"
          class="border border-gray-200 rounded-lg p-5 flex flex-col justify-between bg-gray-50"
        >
          <div>
            <h3 class="text-xl font-semibold text-primary mb-1">
              {{ webinar.title }}
            </h3>
            <p class="text-sm text-gray-600 mb-3">
              <span v-if="webinar.presenter_name">
                With {{ webinar.presenter_name }}
              </span>
            </p>

            <div class="text-sm text-gray-700 space-y-1 mb-4">
              <p>
                <span class="font-semibold">Date &amp; time:</span>
                {{ formatDate(webinar.scheduled_at) }}
              </p>
              <p>
                <span class="font-semibold">Duration:</span>
                {{ webinar.duration_minutes }} minutes
              </p>
              <p>
                <span class="font-semibold">Seats:</span>
                <span v-if="webinar.available_seats === 'Unlimited'">
                  Unlimited
                </span>
                <span v-else>
                  {{ webinar.available_seats }} remaining
                </span>
              </p>
            </div>

            <p
              v-if="webinar.description"
              class="text-sm text-gray-700 mb-4 line-clamp-4"
            >
              {{ webinar.description }}
            </p>
          </div>

          <div class="mt-4 border-t border-gray-200 pt-4">
            <div v-if="isFull(webinar)" class="text-red-600 text-sm mb-2">
              This webinar is fully booked.
            </div>

            <button
              v-if="!isFull(webinar)"
              type="button"
              class="button-exp-fill mb-3"
              @click="toggleForm(webinar.id)"
            >
              {{ activeFormId === webinar.id ? "Close form" : "Register" }}
            </button>

            <form
              v-if="activeFormId === webinar.id && !isFull(webinar)"
              class="space-y-3"
              @submit.prevent="submit(webinar.id)"
            >
              <div class="grid grid-cols-1 gap-3">
                <div>
                  <label class="block text-gray-900 mb-1 text-sm" for="name">
                    Name *
                  </label>
                  <input
                    id="name"
                    type="text"
                    class="can-exp-input w-full"
                    v-model="form.name"
                  />
                  <p
                    v-if="errors.name"
                    class="mt-1 text-xs text-red-500"
                  >
                    {{ errors.name }}
                  </p>
                </div>

                <div>
                  <label class="block text-gray-900 mb-1 text-sm" for="email">
                    Email *
                  </label>
                  <input
                    id="email"
                    type="email"
                    class="can-exp-input w-full"
                    v-model="form.email"
                  />
                  <p
                    v-if="errors.email"
                    class="mt-1 text-xs text-red-500"
                  >
                    {{ errors.email }}
                  </p>
                </div>

                <div>
                  <label class="block text-gray-900 mb-1 text-sm" for="phone">
                    Phone
                  </label>
                  <input
                    id="phone"
                    type="text"
                    class="can-exp-input w-full"
                    v-model="form.phone"
                  />
                  <p
                    v-if="errors.phone"
                    class="mt-1 text-xs text-red-500"
                  >
                    {{ errors.phone }}
                  </p>
                </div>

                <div>
                  <label class="block text-gray-900 mb-1 text-sm" for="company">
                    Company
                  </label>
                  <input
                    id="company"
                    type="text"
                    class="can-exp-input w-full"
                    v-model="form.company"
                  />
                  <p
                    v-if="errors.company"
                    class="mt-1 text-xs text-red-500"
                  >
                    {{ errors.company }}
                  </p>
                </div>
              </div>

              <button
                type="submit"
                class="button-exp-fill"
                :disabled="loading"
              >
                {{ loading ? "Submitting..." : "Submit registration" }}
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "WebinarsIndex",
  props: {
    webinars: {
      type: Array,
      default: () => [],
    },
    registerUrl: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      activeFormId: null,
      loading: false,
      form: {
        name: "",
        email: "",
        phone: "",
        company: "",
      },
      errors: {},
    };
  },
  methods: {
    formatDate(dateString) {
      if (!dateString) return "";
      const date = new Date(dateString);
      if (Number.isNaN(date.getTime())) return dateString;
      return (
        date.toLocaleDateString() +
        " " +
        date.toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" })
      );
    },
    isFull(webinar) {
      if (!webinar) return false;
      if (!webinar.max_attendees) return false;
      if (webinar.available_seats === "Unlimited") return false;
      return Number(webinar.available_seats) <= 0;
    },
    resetForm() {
      this.form = {
        name: "",
        email: "",
        phone: "",
        company: "",
      };
      this.errors = {};
    },
    toggleForm(webinarId) {
      if (this.activeFormId === webinarId) {
        this.activeFormId = null;
        this.resetForm();
      } else {
        this.activeFormId = webinarId;
        this.resetForm();
      }
    },
    async submit(webinarId) {
      this.loading = true;
      this.errors = {};
      try {
        const url = `${this.registerUrl}/${webinarId}/register`;
        const response = await axios.post(url, this.form);

        if (response.data && response.data.success) {
          if (typeof helper !== "undefined" && helper.swalPreSuccessMessageForWeb) {
            helper.swalPreSuccessMessageForWeb(response.data.message);
          } else if (this.$swal) {
            this.$swal("Success", response.data.message, "success");
          }
          this.resetForm();
          this.activeFormId = null;
        } else if (response.data && response.data.message) {
          if (typeof helper !== "undefined" && helper.swalErrorMessageForWeb) {
            helper.swalErrorMessageForWeb(response.data.message);
          } else if (this.$swal) {
            this.$swal("Error", response.data.message, "error");
          }
        }
      } catch (error) {
        if (error.response && error.response.status === 422 && error.response.data.errors) {
          const errs = error.response.data.errors;
          this.errors = Object.fromEntries(
            Object.entries(errs).map(([field, messages]) => [field, messages[0]])
          );
        } else if (
          error.response &&
          error.response.data &&
          error.response.data.message
        ) {
          if (typeof helper !== "undefined" && helper.swalErrorMessageForWeb) {
            helper.swalErrorMessageForWeb(error.response.data.message);
          } else if (this.$swal) {
            this.$swal("Error", error.response.data.message, "error");
          }
        } else {
          console.error("Webinar registration failed", error);
        }
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>


