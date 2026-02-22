<template>
  <div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-2xl font-bold text-primary">{{ t('my_webinars_heading') }}</h2>
      <button @click="showCreateModal = true" class="button-exp-fill">
        {{ t('host_webinar_button_my') }}
      </button>
    </div>

    <!-- Filters -->
    <div class="mb-4 flex gap-4">
      <select v-model="filter" @change="loadWebinars" class="can-exp-input border border-gray-300 rounded">
        <option value="all">{{ t('all_webinars_filter') }}</option>
        <option value="draft">{{ t('draft_filter') }}</option>
        <option value="published">{{ t('published_filter') }}</option>
        <option value="completed">{{ t('completed_filter') }}</option>
        <option value="cancelled">{{ t('cancelled_filter') }}</option>
      </select>
    </div>

    <!-- Webinars List -->
    <div v-if="loading" class="text-center py-8">{{ t('loading_text') }}</div>
    <div v-else-if="!webinars.length" class="text-center py-8 text-gray-500">
      <p class="mb-4">{{ t('no_webinars_created_message') }}</p>
      <button @click="showCreateModal = true" class="button-exp-fill">
        {{ t('create_first_webinar_button') }}
      </button>
    </div>
    <div v-else class="grid gap-6 md:grid-cols-2">
      <div
        v-for="webinar in webinars"
        :key="webinar.id"
        class="border border-gray-200 rounded-lg overflow-hidden bg-gray-50"
      >
        <!-- Cover Image -->
        <div v-if="webinar.cover_image_url || webinar.cover_image" class="h-48 overflow-hidden">
          <img :src="webinar.cover_image_url || parseImagePath(webinar.cover_image)" :alt="webinar.title" class="w-full h-full object-cover" />
        </div>

        <div class="p-5">
          <div class="flex items-start justify-between mb-2">
            <h3 class="text-xl font-semibold text-primary">{{ webinar.title }}</h3>
            <span :class="getStatusClass(webinar.status)" class="text-xs px-2 py-1 rounded">
              {{ webinar.status }}
            </span>
          </div>

          <div class="text-sm text-gray-700 space-y-1 mb-4">
            <p><span class="font-semibold">{{ t('date_label') }}</span> {{ formatDate(webinar.scheduled_at) }}</p>
            <p><span class="font-semibold">{{ t('type_label') }}</span> {{ getTypeLabel(webinar.webinar_type) }}</p>
            <p><span class="font-semibold">{{ t('registrations_count_label') }}</span> {{ webinar.registrations_count || 0 }}</p>
          </div>

          <div class="flex gap-2 mt-4">
            <button @click="editWebinar(webinar)" class="flex-1 button-exp-fill text-sm">
              {{ t('edit_button') }}
            </button>
            <button @click="viewRegistrations(webinar.id)" class="flex-1 button-exp-fill text-sm">
              {{ t('registrations_button') }}
            </button>
            <button @click="viewQuestions(webinar.id)" class="flex-1 button-exp-fill text-sm" v-if="webinar.allow_qa">
              {{ t('qa_button') }}
            </button>
            <button @click="deleteWebinar(webinar.id)" class="text-red-600 hover:underline text-sm">
              {{ t('delete_button') }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Create/Edit Modal (pt-[7.5rem] keeps modal below fixed navbar #topnav ~120px) -->
    <div v-if="showCreateModal || editingWebinar" class="fixed inset-0 bg-black bg-opacity-50 z-[110] overflow-y-auto pt-[7.5rem] pb-8 px-4">
      <div class="bg-white rounded-lg max-w-4xl w-full max-h-[calc(100vh-8rem)] overflow-y-auto mx-auto shadow-xl">
        <div class="p-6">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">{{ editingWebinar ? t('edit_webinar_heading') : t('create_webinar_heading') }}</h3>
            <button @click="closeModal" class="text-gray-500 hover:text-gray-700">✕</button>
          </div>

          <form @submit.prevent="saveWebinar" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium mb-1">{{ t('title_label') }} *</label>
                <input v-model="form.title" type="text" class="can-exp-input w-full" required />
              </div>

              <div>
                <label class="block text-sm font-medium mb-1">{{ t('webinar_type_label') }} *</label>
                <select v-model="form.webinar_type" class="can-exp-input w-full" required>
                  <option value="live_interactive">{{ t('type_live_interactive_my') }}</option>
                  <option value="live_viewonly">{{ t('type_live_viewonly_my') }}</option>
                  <option value="recorded">{{ t('type_recorded_my') }}</option>
                </select>
              </div>

              <div>
                <label class="block text-sm font-medium mb-1">{{ t('scheduled_label') }} *</label>
                <input v-model="form.scheduled_at" type="datetime-local" class="can-exp-input w-full" required />
              </div>

              <div>
                <label class="block text-sm font-medium mb-1">{{ t('duration_label_my') }} *</label>
                <input v-model.number="form.duration_minutes" type="number" min="15" max="480" class="can-exp-input w-full" required />
              </div>

              <div>
                <label class="block text-sm font-medium mb-1">{{ t('presenter_name_label') }}</label>
                <input v-model="form.presenter_name" type="text" class="can-exp-input w-full" />
              </div>

              <div>
                <label class="block text-sm font-medium mb-1">{{ t('meeting_platform_label') }}</label>
                <select v-model="form.meeting_platform" class="can-exp-input w-full">
                  <option value="zoom">Zoom</option>
                  <option value="teams">Microsoft Teams</option>
                  <option value="youtube">YouTube Live</option>
                  <option value="custom">Custom</option>
                </select>
              </div>

              <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">{{ t('meeting_link_label') }}</label>
                <input v-model="form.meeting_link" type="url" class="can-exp-input w-full" placeholder="https://zoom.us/j/..." />
              </div>

              <div>
                <label class="block text-sm font-medium mb-1">{{ t('max_attendees_label') }}</label>
                <input v-model.number="form.max_attendees" type="number" min="1" class="can-exp-input w-full" />
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">{{ t('description_label') }}</label>
              <textarea v-model="form.description" rows="4" class="can-exp-input w-full"></textarea>
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">{{ t('presenter_bio_label') }}</label>
              <textarea v-model="form.presenter_bio" rows="3" class="can-exp-input w-full"></textarea>
            </div>

            <!-- Interaction Settings -->
            <div v-if="form.webinar_type === 'live_interactive'" class="bg-gray-50 p-4 rounded-lg">
              <h4 class="font-medium mb-3">{{ t('interaction_settings_heading') }}</h4>
              <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <label class="flex items-center">
                  <input type="checkbox" v-model="form.allow_qa" class="mr-2" />
                  <span>{{ t('enable_qa_label') }}</span>
                </label>
                <label class="flex items-center">
                  <input type="checkbox" v-model="form.allow_chat" class="mr-2" />
                  <span>{{ t('enable_chat_label') }}</span>
                </label>
                <label class="flex items-center">
                  <input type="checkbox" v-model="form.allow_private_messages" class="mr-2" />
                  <span>{{ t('enable_private_messages_label') }}</span>
                </label>
              </div>
            </div>

            <!-- Recording fields for recorded webinars -->
            <div v-if="form.webinar_type === 'recorded'">
              <div>
                <label class="block text-sm font-medium mb-1">{{ t('recording_url_label') }}</label>
                <input v-model="form.recording_url" type="url" class="can-exp-input w-full" />
              </div>
              <div>
                <label class="block text-sm font-medium mb-1">{{ t('embed_code_label') }}</label>
                <textarea v-model="form.embed_code" rows="3" class="can-exp-input w-full font-mono text-sm" placeholder="<iframe src='...'></iframe>"></textarea>
              </div>
            </div>

            <div class="flex justify-end gap-2 pt-4">
              <button type="button" @click="closeModal" class="px-4 py-2 border rounded">{{ t('cancel_button') }}</button>
              <button type="submit" class="button-exp-fill" :disabled="saving">
                {{ saving ? t('saving_text') : t('save_webinar_button') }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Registrations Modal -->
    <div v-if="showRegistrations" class="fixed inset-0 bg-black bg-opacity-50 z-[110] overflow-y-auto pt-[7.5rem] pb-8 px-4">
      <div class="bg-white rounded-lg max-w-3xl w-full max-h-[calc(100vh-8rem)] overflow-y-auto mx-auto shadow-xl">
        <div class="p-6">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">{{ t('registrations_heading') }}</h3>
            <button @click="showRegistrations = false" class="text-gray-500 hover:text-gray-700">✕</button>
          </div>
          <div v-if="loadingRegistrations" class="text-center py-8">{{ t('loading_text') }}</div>
          <div v-else-if="!registrations.length" class="text-center py-8 text-gray-500">{{ t('no_registrations_message') }}</div>
          <div v-else class="space-y-2">
            <div v-for="reg in registrations" :key="reg.id" class="border rounded p-3">
              <p class="font-medium">{{ reg.name }}</p>
              <p class="text-sm text-gray-600">{{ reg.email }}</p>
              <p class="text-sm text-gray-600">{{ reg.company }}</p>
              <p class="text-xs text-gray-500 mt-1">Registered: {{ formatDate(reg.registered_at) }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Questions Modal -->
    <div v-if="showQuestions" class="fixed inset-0 bg-black bg-opacity-50 z-[110] overflow-y-auto pt-[7.5rem] pb-8 px-4">
      <div class="bg-white rounded-lg max-w-3xl w-full max-h-[calc(100vh-8rem)] overflow-y-auto mx-auto shadow-xl">
        <div class="p-6">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">{{ t('qa_heading') }}</h3>
            <button @click="showQuestions = false" class="text-gray-500 hover:text-gray-700">✕</button>
          </div>
          <div v-if="loadingQuestions" class="text-center py-8">{{ t('loading_text') }}</div>
          <div v-else-if="!questions.length" class="text-center py-8 text-gray-500">{{ t('no_questions_message_my') }}</div>
          <div v-else class="space-y-4">
            <div v-for="q in questions" :key="q.id" class="border rounded p-4">
              <div class="flex justify-between mb-2">
                <span class="font-medium">{{ q.asker_name }}</span>
                <span class="text-xs text-gray-500">{{ formatDate(q.created_at) }}</span>
              </div>
              <p class="mb-2">{{ q.question }}</p>
              <div v-if="q.answer" class="bg-blue-50 p-2 rounded">
                <p class="text-sm"><strong>{{ t('answer_label') }}</strong> {{ q.answer }}</p>
              </div>
              <div v-else class="text-sm text-gray-500">{{ t('not_answered_message') }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";


export default {
  name: "MyWebinars",
  props: {
    webinarSetting: {
      type: Object,
      default: () => ({}),
    },
  },
  computed: {
    t() {
      const s = this.webinarSetting || {};
      console.log(s);
      
      return (key) => s[key] ?? this.defaultLabels()[key] ?? key;
    },
    defaultLabels() {
      return {
        my_webinars_heading: "My Webinars",
        host_webinar_button_my: "+ Host a Webinar",
        all_webinars_filter: "All Webinars",
        draft_filter: "Draft",
        published_filter: "Published",
        completed_filter: "Completed",
        cancelled_filter: "Cancelled",
        loading_text: "Loading...",
        no_webinars_created_message: "You haven't created any webinars yet.",
        create_first_webinar_button: "Create Your First Webinar",
        edit_button: "Edit",
        registrations_button: "Registrations",
        qa_button: "Q&A",
        delete_button: "Delete",
        edit_webinar_heading: "Edit Webinar",
        create_webinar_heading: "Create Webinar",
        title_label: "Title",
        webinar_type_label: "Webinar Type",
        scheduled_label: "Scheduled Date & Time",
        duration_label_my: "Duration (minutes)",
        presenter_name_label: "Presenter Name",
        meeting_platform_label: "Meeting Platform",
        meeting_link_label: "Meeting Link",
        max_attendees_label: "Max Attendees (leave empty for unlimited)",
        description_label: "Description",
        presenter_bio_label: "Presenter Bio",
        interaction_settings_heading: "Interaction Settings",
        enable_qa_label: "Enable Q&A",
        enable_chat_label: "Enable Chat",
        enable_private_messages_label: "Enable Private Messages",
        recording_url_label: "Recording URL",
        embed_code_label: "Embed Code (optional)",
        cancel_button: "Cancel",
        save_webinar_button: "Save Webinar",
        saving_text: "Saving...",
        registrations_heading: "Registrations",
        no_registrations_message: "No registrations yet",
        qa_heading: "Q&A",
        no_questions_message_my: "No questions yet",
        answer_label: "Answer:",
        not_answered_message: "Not answered yet",
        type_live_interactive_my: "Live Interactive",
        type_live_viewonly_my: "Live View-Only",
        type_recorded_my: "Recorded/On-Demand",
        delete_confirm_message: "Are you sure you want to delete this webinar?",
        date_label: "Date:",
        type_label: "Type:",
        registrations_count_label: "Registrations:",
      };
    },
  },
  data() {
    return {
      webinars: [],
      loading: false,
      filter: "all",
      showCreateModal: false,
      editingWebinar: null,
      saving: false,
      showRegistrations: false,
      registrations: [],
      loadingRegistrations: false,
      showQuestions: false,
      questions: [],
      loadingQuestions: false,
      form: {
        title: "",
        description: "",
        presenter_name: "",
        presenter_bio: "",
        scheduled_at: "",
        duration_minutes: 60,
        meeting_link: "",
        meeting_platform: "zoom",
        max_attendees: null,
        webinar_type: "live_interactive",
        allow_qa: true,
        allow_chat: true,
        allow_private_messages: true,
        recording_url: "",
        embed_code: "",
      },
    };
  },
  mounted() {
    this.loadWebinars();
  },
  methods: {
    async loadWebinars() {
      this.loading = true;
      try {
        const params = this.filter !== "all" ? { status: this.filter } : {};
        const { data } = await axios.get(`${process.env.MIX_WEB_API_URL}member/webinars`, { params });
        if (data.success) {
          this.webinars = data.data.data || data.data || [];
        }
      } catch (error) {
        console.error("Failed to load webinars:", error);
        const message = error.response?.data?.message || error.message || "Failed to load webinars";
        if (this.$swal) {
          this.$swal("Error", message, "error");
        }
      } finally {
        this.loading = false;
      }
    },
    editWebinar(webinar) {
      this.editingWebinar = webinar;
      this.form = {
        title: webinar.title || "",
        description: webinar.description || "",
        presenter_name: webinar.presenter_name || "",
        presenter_bio: webinar.presenter_bio || "",
        scheduled_at: webinar.scheduled_at ? new Date(webinar.scheduled_at).toISOString().slice(0, 16) : "",
        duration_minutes: webinar.duration_minutes || 60,
        meeting_link: webinar.meeting_link || "",
        meeting_platform: webinar.meeting_platform || "zoom",
        max_attendees: webinar.max_attendees || null,
        webinar_type: webinar.webinar_type || "live_interactive",
        allow_qa: webinar.allow_qa !== undefined ? webinar.allow_qa : true,
        allow_chat: webinar.allow_chat !== undefined ? webinar.allow_chat : true,
        allow_private_messages: webinar.allow_private_messages !== undefined ? webinar.allow_private_messages : true,
        recording_url: webinar.recording_url || "",
        embed_code: webinar.embed_code || "",
      };
      this.showCreateModal = true;
    },
    closeModal() {
      this.showCreateModal = false;
      this.editingWebinar = null;
      this.form = {
        title: "",
        description: "",
        presenter_name: "",
        presenter_bio: "",
        scheduled_at: "",
        duration_minutes: 60,
        meeting_link: "",
        meeting_platform: "zoom",
        max_attendees: null,
        webinar_type: "live_interactive",
        allow_qa: true,
        allow_chat: true,
        allow_private_messages: true,
        recording_url: "",
        embed_code: "",
      };
    },
    async saveWebinar() {
      this.saving = true;
      try {
        const url = this.editingWebinar
          ? `${process.env.MIX_WEB_API_URL}member/webinars/${this.editingWebinar.id}`
          : `${process.env.MIX_WEB_API_URL}member/webinars`;
        const method = this.editingWebinar ? "put" : "post";

        const { data } = await axios[method](url, this.form);

        if (data.success) {
          if (this.$swal) {
            this.$swal("Success", data.message || "Webinar saved successfully", "success");
          }
          this.closeModal();
          this.loadWebinars();
        }
      } catch (error) {
        console.error("Failed to save webinar:", error);
        if (this.$swal) {
          this.$swal("Error", error.response?.data?.message || "Failed to save webinar", "error");
        }
      } finally {
        this.saving = false;
      }
    },
    async deleteWebinar(id) {
      if (!confirm(this.t('delete_confirm_message'))) return;

      try {
        const { data } = await axios.delete(`${process.env.MIX_WEB_API_URL}member/webinars/${id}`);
        if (data.success) {
          if (this.$swal) {
            this.$swal("Success", "Webinar deleted successfully", "success");
          }
          this.loadWebinars();
        }
      } catch (error) {
        if (this.$swal) {
          this.$swal("Error", error.response?.data?.message || "Failed to delete webinar", "error");
        }
      }
    },
    async viewRegistrations(webinarId) {
      this.showRegistrations = true;
      this.loadingRegistrations = true;
      try {
        const { data } = await axios.get(`${process.env.MIX_WEB_API_URL}member/webinars/${webinarId}/registrations`);
        if (data.success) {
          this.registrations = data.data.data || data.data || [];
        }
      } catch (error) {
        console.error("Failed to load registrations:", error);
      } finally {
        this.loadingRegistrations = false;
      }
    },
    async viewQuestions(webinarId) {
      this.showQuestions = true;
      this.loadingQuestions = true;
      try {
        const { data } = await axios.get(`${process.env.MIX_WEB_API_URL}member/webinars/${webinarId}/questions`);
        if (data.success) {
          this.questions = data.data.data || data.data || [];
        }
      } catch (error) {
        console.error("Failed to load questions:", error);
      } finally {
        this.loadingQuestions = false;
      }
    },
    formatDate(dateString) {
      if (!dateString) return "";
      const date = new Date(dateString);
      return date.toLocaleDateString() + " " + date.toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" });
    },
    getStatusClass(status) {
      const classes = {
        draft: "bg-gray-200 text-gray-800",
        published: "bg-green-200 text-green-800",
        completed: "bg-blue-200 text-blue-800",
        cancelled: "bg-red-200 text-red-800",
      };
      return classes[status] || "";
    },
    getTypeLabel(type) {
      const labels = {
        live_interactive: this.t("type_live_interactive_my"),
        live_viewonly: this.t("type_live_viewonly_my"),
        recorded: this.t("type_recorded_my"),
      };
      return labels[type] || type;
    },
    parseImagePath(imagePath) {
      if (!imagePath) return null;
      try {
        let path = null;
        
        // If it's a JSON string (array), parse it
        if (typeof imagePath === "string" && imagePath.startsWith("[")) {
          const parsed = JSON.parse(imagePath);
          if (Array.isArray(parsed) && parsed.length > 0) {
            path = parsed[0];
          }
        }
        // If it's already an array
        else if (Array.isArray(imagePath) && imagePath.length > 0) {
          path = imagePath[0];
        }
        // If it's a plain string path
        else if (typeof imagePath === "string" && imagePath.length > 0) {
          path = imagePath;
        }
        
        if (!path) return null;
        
        // Normalize slashes
        path = path.replace(/\\/g, "/");
        
        // Remove leading slash
        path = path.replace(/^\/+/, "");
        
        // If path is already a full URL, return as is
        if (path.startsWith("http://") || path.startsWith("https://")) {
          return path;
        }
        
        // For temp media files (media/temp/...)
        // These are saved directly to web-accessible path on VPS
        // So they should be accessed as /media/temp/... not /storage/media/temp/...
        if (path.startsWith("media/temp/")) {
          // Return direct path (VPS/Hostinger)
          // The backend accessor should handle this correctly, but this ensures consistency
          return "/" + path;
        }
        
        // For other media files
        if (path.startsWith("media/")) {
          // Try direct path first (VPS), then storage path (local)
          // Since we can't check file existence in Vue, we'll try direct path first
          // If it doesn't work, the backend accessor should provide the correct URL
          return "/" + path;
        }
        
        // If already starts with storage/, use as is
        if (path.startsWith("storage/")) {
          return "/" + path;
        }
        
        // Default: ensure it starts with /
        return path.startsWith("/") ? path : "/" + path;
      } catch (e) {
        console.error("Error parsing image path:", e);
      }
      return null;
    },
  },
};
</script>

