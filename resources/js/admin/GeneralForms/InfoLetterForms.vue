<template>
    <AppLayout>
      <div class="relative shadow-md sm:rounded-lg bg-white py-4">
        <div class="px-4 sm:px-6 lg:px-8">
          <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
              <h1 class="can-exp-h3 mb-0 text-primary">Info letter messages</h1>
              <p class="mt-2 text-sm text-gray-700">
                A list of all the form submissions of info letter form
              </p>
            </div>
          </div>
          <div class="mt-8 flow-root">
            <div
              class="flex flex-col md:flex-row items-center justify-between mb-4"
            >
              <div class="-mt-4 sm:mt-0 mb-2 sm:mb-0">
                show
                <select
                  class="rounded-md px-3 pr-8 py-1"
                  @input="updateLimit($event.target.value)"
                >
                  <option value="10" :selected="limit == '10'">10</option>
                  <option value="25" :selected="limit == '25'">25</option>
                  <option value="50" :selected="limit == '50'">50</option>
                  <option value="100" :selected="limit == '100'">100</option>
                </select>
                messages
              </div>
             <div class="flex items-center gap-2">
              <div class="flex gap-2 mt-4 sm:mt-0">
              <button
                class="button-exp-fill"
                :disabled="selectedLetters.length === 0"
                :class="{ 'opacity-50 cursor-not-allowed': selectedLetters.length === 0 }"
                @click="openSendEmailModal"
              >
                Send email
              </button>
            </div>
              <label for="table-search" class="sr-only">Search</label>
              <div class="relative w-full md:w-auto">
                <div
                  class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
                >
                  <svg
                    class="w-5 h-5 text-gray-500"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </div>
                <input
                  type="text"
                  id="table-search-forms"
                  class="block pl-10 w-full md:w-80 bg-white can-exp-input"
                  placeholder="Search"
                  v-model="quickSearch"
                />
              </div>
             </div>
            </div>
            <div class="-mx-4 mt-8 sm:-mx-0">
              <div
                class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg"
              >
                <table class="min-w-full divide-y divide-gray-300">
                  <thead class="bg-gradient-to-l from-blue-500 to-blue-400">
                    <tr>
                      <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                        <input type="checkbox" v-model="selectAll" />
                      </th>
                      <th
                        scope="col"
                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                      >
                        Sender
                      </th>
                      <th
                        scope="col"
                        class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell"
                      >
                        Company name
                      </th>
                      <th
                        scope="col"
                        class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell"
                      >
                        Country
                      </th>
                      <!-- <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                              Business user
                          </th> -->
                      <th
                        scope="col"
                        class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell"
                      >
                        Sent Date
                      </th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-200 bg-white">
                    <tr
                      class="hover:shadow-lg"
                      v-for="info_letter_form in info_letter_forms"
                      :key="info_letter_form.id"
                    >
                    <td class="px-3 py-4">
                      <input
                        type="checkbox"
                        :value="info_letter_form"
                        v-model="selectedLetters"
                      />
                    </td>
                      <td
                        class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-1"
                      >

                        <div class="font-medium text-gray-900">
                          {{ info_letter_form.name }}
                        </div>
                        <div class="mt-1 text-gray-500">
                          {{ info_letter_form.email }}
                        </div>
                        <dl class="font-normal lg:hidden">
                          <dt class="sr-only">Company name</dt>
                          <dd class="mt-1 truncate text-gray-700">
                            {{ info_letter_form.company_name }}
                          </dd>
                          <dt class="sr-only">Country</dt>
                          <dd class="mt-1 truncate text-gray-500">
                            {{ info_letter_form.country }}
                          </dd>
                          <!-- <dt class="sr-only">Business user</dt>
                                      <dd class="mt-1 truncate text-gray-500"> {{ info_letter_form . email_sent_by_user ? info_letter_form . email_sent_by_user.name : '' }}</dd> -->
                          <dt class="sr-only">Sent date</dt>
                          <dd class="mt-1 truncate text-gray-700">
                            {{ formatDate(info_letter_form.created_at) }}
                          </dd>
                        </dl>
                      </td>
                      <td
                        class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell"
                      >
                        <div class="text-gray-900">
                          {{ info_letter_form.company_name }}
                        </div>
                      </td>
                      <td
                        class="hidden w-64 px-3 py-4 text-sm text-gray-500 lg:table-cell"
                      >
                        {{ info_letter_form.country }}
                      </td>
                      <!-- <td class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell">
                                  {{ info_letter_form . email_sent_by_user ? info_letter_form . email_sent_by_user.name : '' }}
                              </td> -->
                      <td
                        class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell"
                      >
                        {{ formatDate(info_letter_form.created_at) }}
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div
                class="px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6"
                v-if="pagination"
              >
                <div class="flex justify-between items-center w-full">
                  <div>
                    <p
                      class="text-sm text-gray-700"
                      v-if="pagination.current_page"
                    >
                      Page {{ pagination.current_page }} of
                      {{ pagination.last_page }}
                    </p>
                  </div>
                  <div>
                    <nav
                      class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                      aria-label="Pagination"
                      v-if="pagination.next_page_url || pagination.prev_page_url"
                    >
                      <a
                        href="#"
                        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                        v-bind:class="[{ disabled: !pagination.prev_page_url }]"
                        @click="fetchInfoLetterForms(pagination.prev_page_url)"
                      >
                        <span class="sr-only">Previous</span>
                        <svg
                          class="h-5 w-5"
                          x-description="Heroicon name: solid/chevron-left"
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 20 20"
                          fill="currentColor"
                          aria-hidden="true"
                        >
                          <path
                            fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd"
                          ></path>
                        </svg>
                      </a>
                      <a
                        href="#"
                        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                        v-bind:class="[{ disabled: !pagination.next_page_url }]"
                        @click="fetchInfoLetterForms(pagination.next_page_url)"
                      >
                        <span class="sr-only">Next</span>
                        <svg
                          class="h-5 w-5"
                          x-description="Heroicon name: solid/chevron-right"
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 20 20"
                          fill="currentColor"
                          aria-hidden="true"
                        >
                          <path
                            fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"
                          ></path>
                        </svg>
                      </a>
                    </nav>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div
      v-if="isEmailModalOpen"
      class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
    >
      <div class="bg-white p-6 rounded-lg max-w-2xl w-full relative">
        <!-- Loader inside the modal -->
        <div v-if="loading" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500">
            <div id="form_preloader">
            <div id="form_status">
              <div class="form_spinner">
                <div class="form-double-bounce1"></div>
                <div class="form-double-bounce2"></div>
              </div>
            </div>
          </div>
            </div>
        </div>

        <!-- Modal Content -->
        <h2 class="card-heading mb-4">
          Send email
        </h2>
        <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-md">
          <p class="text-sm text-blue-800">
            <strong>{{ selectedLetters.length }}</strong> recipient{{ selectedLetters.length !== 1 ? 's' : '' }} selected
          </p>
        </div>
        <textarea
          v-model="emailMessage"
          placeholder="Write your message..."
          class="can-exp-input"
          rows="4"
        ></textarea>
        <input
          type="file"
          @change="attachFile"
          accept=".pdf,.png,.jpg,.jpeg"
          class="mt-4 can-exp-input"
        />
        <div class="mt-4 flex justify-end gap-2">
          <button class="button-exp-no-fill" @click="closeModal">
            Cancel
          </button>
          <button
            class="button-exp-fill"
            @click="sendEmail"
          >
            Send
          </button>
        </div>
      </div>
    </div>
    </AppLayout>
  </template>
  <script>
  import _ from "lodash";
  import { mapState } from "vuex";
  import LoadingTable from "../components/LoadingTable.vue";
  import moment from "moment";
  export default {
    components: {
      LoadingTable,
    },
    computed: {
      ...mapState({
        limit: (state) => state.info_letter_forms.limit,
        form: (state) => state.info_letter_forms.form,
        info_letter_forms: (state) => state.info_letter_forms.info_letter_forms,
        pagination: (state) => state.info_letter_forms.pagination,
        searchParam: (state) => state.info_letter_forms.searchParam,
        loading: (state) => state.info_letter_forms.loading,
      }),
      selectAll: {
        get() {
          return this.info_letter_forms && this.info_letter_forms.length > 0 && 
                 this.selectedLetters.length === this.info_letter_forms.length;
        },
        set(value) {
          if (value) {
            this.selectedLetters = [...this.info_letter_forms];
          } else {
            this.selectedLetters = [];
          }
        }
      }
    },
    data() {
      return {
        quickSearch: null,
        selectedLetters: [],
        isEmailModalOpen: false,
        isBulkEmail: false,
        emailMessage: "",
        attachedFile: null,
        filePath: null,
        loading: false,
      };
    },
    methods: {
      openSendEmailModal() {
        if (this.selectedLetters.length === 0) {
          return; // Don't open modal if no recipients selected
        }
        this.isEmailModalOpen = true;
        this.isBulkEmail = false;
      },
      closeModal() {
        this.isEmailModalOpen = false;
        this.emailMessage = "";
        this.attachedFile = null;
        this.filePath = null;
      },
      attachFile(event) {
        this.attachedFile = event.target.files[0];
      },
      uploadFile(file) {
  const formData = new FormData();
  formData.append("file", file);

  axios
    .post("/api/upload", formData, {
      headers: { "Content-Type": "multipart/form-data" },
      maxContentLength: Infinity,
      maxBodyLength: Infinity,
    })
    .then((response) => {
      this.filePath = response.data.path;
    })
    .catch((error) => {
      console.error("File upload failed:", error);
    });
},

sendEmail() {
  this.loading = true; // Show loader
  const recipients = this.selectedLetters.map((letter) => letter.email);

  if (!recipients || recipients.length === 0) {
    helper.swalErrorMessage("No recipients found to send the email.");
    this.loading = false; // Hide loader
    return;
  }

  const formData = new FormData();
  formData.append("message", this.emailMessage);
  formData.append('file', this.attachedFile);
  formData.append("recipients", JSON.stringify(recipients));

  const Url = `${process.env.MIX_ADMIN_API_URL}send-email`;

  axios
    .post(Url, formData)
    .then((response) => {
      if (response.data.status === "success") {
        helper.swalSuccessMessage(response.data.message || "Email sent successfully!");
        this.selectedLetters = []; // Clear selected letters after successful send
      } else {
        helper.swalErrorMessage(response.data.message || "Failed to send email.");
      }
      this.closeModal();
    })
    .catch((error) => {
      helper.swalErrorMessage(error?.response?.data?.message || "Error sending email.");
    })
    .finally(() => {
      this.loading = false; // Hide loader
    });
},
      formatDate(dateString) {
        return moment(dateString).format("MMMM D, YYYY");
      },
      fetchInfoLetterForms(page_url) {
        this.$store.dispatch("info_letter_forms/fetchInfoLetterForms", {
          url: page_url,
        });
      },
      updateLimit(value) {
        this.$store.commit("info_letter_forms/setLimit", value);
        this.$store.dispatch("info_letter_forms/fetchInfoLetterForms");
      },
      quickSearchFilter: _.debounce(function () {
        this.$store.commit("info_letter_forms/setSearchParam", this.quickSearch);
        this.$store.dispatch("info_letter_forms/fetchInfoLetterForms");
      }, 500),
    },
    created() {
      this.$store.commit("info_letter_forms/setLimit", 100);
      this.$store.commit("info_letter_forms/setSortBy", "name");
      this.$store.commit("info_letter_forms/setSortType", "asc");
      this.$store.commit("info_letter_forms/setSearchParam", "");
      this.$store.dispatch("info_letter_forms/fetchInfoLetterForms");
    },
    watch: {
      quickSearch: function () {
        this.quickSearchFilter();
      },
    },
  };
  </script>
