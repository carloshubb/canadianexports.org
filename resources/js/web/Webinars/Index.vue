<template>
  <div class="relative shadow-md sm:rounded-lg bg-white py-6">
    <div class="px-4 sm:px-6 lg:px-8">
      <div class="mb-6">
        <div class="flex items-center justify-between">
          <div>
            <h2 class="can-exp-h2 text-primary mb-2">
              Webinars
            </h2>
            <p class="text-gray-600" v-if="!webinars || webinars.length === 0">
              There are currently no webinars available. Please check back later.
            </p>
          </div>
          <a 
            v-if="isLoggedIn" 
            :href="getMyWebinarsUrl()" 
            class="button-exp-fill whitespace-nowrap ml-4"
          >
            + Host a Webinar
          </a>
        </div>
      </div>

      <div
        v-if="webinars && webinars.length"
        class="grid gap-6 md:grid-cols-2"
      >
        <div
          v-for="webinar in webinars"
          :key="webinar.id"
          class="border border-gray-200 rounded-lg overflow-hidden flex flex-col justify-between bg-gray-50"
        >
          <!-- Cover Image -->
          <div v-if="getCoverImage(webinar)" class="h-48 overflow-hidden">
            <img :src="getCoverImage(webinar)" :alt="webinar.title" class="w-full h-full object-cover" />
          </div>

          <div class="p-5">
            <div class="flex items-start justify-between mb-2">
              <h3 class="text-xl font-semibold text-primary">
                {{ webinar.title }}
              </h3>
              <div class="flex gap-1 ml-2">
                <span :class="getTypeClass(webinar.webinar_type)" class="text-xs px-2 py-1 rounded whitespace-nowrap">
                  {{ getTypeLabel(webinar.webinar_type) }}
                </span>
                <span v-if="isPast(webinar)" class="text-xs bg-gray-200 text-gray-700 px-2 py-1 rounded whitespace-nowrap">
                  Past
                </span>
                <span v-else class="text-xs bg-green-200 text-green-700 px-2 py-1 rounded whitespace-nowrap">
                  Upcoming
                </span>
              </div>
            </div>
            
            <!-- Presenter with image -->
            <div class="flex items-center mb-3" v-if="webinar.presenter_name">
              <img 
                v-if="getPresenterImage(webinar)" 
                :src="getPresenterImage(webinar)" 
                :alt="webinar.presenter_name"
                class="w-10 h-10 rounded-full object-cover mr-3"
              />
              <div v-else class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center mr-3">
                <span class="text-gray-600 text-sm font-medium">{{ webinar.presenter_name.charAt(0) }}</span>
              </div>
              <span class="text-sm text-gray-600">With {{ webinar.presenter_name }}</span>
            </div>

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

            <!-- Features badges -->
            <div class="flex flex-wrap gap-1 mb-4" v-if="webinar.webinar_type === 'live_interactive'">
              <span v-if="webinar.allow_qa" class="text-xs bg-purple-100 text-purple-700 px-2 py-0.5 rounded">Q&A</span>
              <span v-if="webinar.allow_chat" class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded">Chat</span>
              <span v-if="webinar.allow_private_messages" class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded">Private Messages</span>
            </div>

            <p
              v-if="webinar.description"
              class="text-sm text-gray-700 mb-4 line-clamp-4"
            >
              {{ webinar.description }}
            </p>
          </div>

          <div class="mt-4 border-t border-gray-200 pt-4 p-5">
            <div v-if="isFull(webinar)" class="text-red-600 text-sm mb-2">
              This webinar is fully booked.
            </div>

            <!-- Tabs for registered users (works for both upcoming and past webinars) -->
            <div v-if="isRegistered(webinar.id)" class="mb-4">
              <div class="text-green-600 text-sm mb-3 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                You {{ isPast(webinar) ? 'were registered' : 'are registered' }} for this webinar
              </div>

              <!-- Webinar interaction tabs (available for registered users on past webinars too) -->
              <div v-if="webinar.webinar_type === 'live_interactive'" class="border rounded-lg">
                <div class="flex border-b">
                  <button 
                    v-if="webinar.allow_qa"
                    @click="setActiveTab(webinar.id, 'qa')"
                    class="flex-1 px-3 py-2 text-sm"
                    :class="getActiveTab(webinar.id) === 'qa' ? 'bg-purple-100 text-purple-700 border-b-2 border-purple-500' : 'text-gray-600 hover:bg-gray-100'"
                  >
                    Q&A
                  </button>
                  <button 
                    v-if="webinar.allow_chat"
                    @click="setActiveTab(webinar.id, 'chat')"
                    class="flex-1 px-3 py-2 text-sm"
                    :class="getActiveTab(webinar.id) === 'chat' ? 'bg-blue-100 text-blue-700 border-b-2 border-blue-500' : 'text-gray-600 hover:bg-gray-100'"
                  >
                    Chat
                  </button>
                  <button 
                    v-if="webinar.allow_private_messages"
                    @click="setActiveTab(webinar.id, 'messages')"
                    class="flex-1 px-3 py-2 text-sm"
                    :class="getActiveTab(webinar.id) === 'messages' ? 'bg-green-100 text-green-700 border-b-2 border-green-500' : 'text-gray-600 hover:bg-gray-100'"
                  >
                    Private Message
                  </button>
                </div>

                <!-- Q&A Panel -->
                <div v-if="getActiveTab(webinar.id) === 'qa' && webinar.allow_qa" class="p-4">
                  <div class="mb-4 max-h-64 overflow-y-auto space-y-3">
                    <div v-if="!questions[webinar.id] || questions[webinar.id].length === 0" class="text-gray-500 text-sm">
                      No questions yet. Be the first to ask!
                    </div>
                    <div v-for="q in questions[webinar.id]" :key="q.id" class="border-b pb-3">
                      <div class="flex justify-between items-start">
                        <p class="text-sm font-medium">{{ q.asker_name }}</p>
                        <span class="text-xs text-gray-500">{{ formatTime(q.created_at) }}</span>
                      </div>
                      <p class="text-sm text-gray-700">{{ q.question }}</p>
                      <div v-if="q.answer" class="mt-2 bg-blue-50 p-2 rounded text-sm">
                        <span class="font-medium">Answer:</span> {{ q.answer }}
                      </div>
                      <div class="mt-1 flex items-center gap-2">
                        <button @click="upvoteQuestion(webinar.id, q.id)" class="text-xs text-gray-500 hover:text-purple-600">
                          👍 {{ q.upvotes }}
                        </button>
                      </div>
                    </div>
                  </div>
                  <form @submit.prevent="submitQuestion(webinar.id)" class="space-y-2">
                    <textarea 
                      v-model="questionForm.question"
                      placeholder="Ask a question..."
                      rows="2"
                      class="w-full border rounded p-2 text-sm"
                    ></textarea>
                    <div class="flex items-center justify-between">
                      <label class="flex items-center text-sm">
                        <input type="checkbox" v-model="questionForm.is_anonymous" class="mr-2">
                        Ask anonymously
                      </label>
                      <button type="submit" class="button-exp-fill text-sm" :disabled="loadingQ">
                        {{ loadingQ ? 'Sending...' : 'Submit Question' }}
                      </button>
                    </div>
                  </form>
                </div>

                <!-- Chat Panel -->
                <div v-if="getActiveTab(webinar.id) === 'chat' && webinar.allow_chat" class="p-4">
                  <div class="mb-4 max-h-64 overflow-y-auto space-y-2" ref="chatContainer">
                    <div v-if="!chatMessages[webinar.id] || chatMessages[webinar.id].length === 0" class="text-gray-500 text-sm">
                      No messages yet. Start the conversation!
                    </div>
                    <div v-for="msg in chatMessages[webinar.id]" :key="msg.id" class="text-sm">
                      <span class="font-medium">{{ msg.sender_name }}:</span>
                      <span class="text-gray-700">{{ msg.message }}</span>
                    </div>
                  </div>
                  <form @submit.prevent="sendChatMessage(webinar.id)" class="flex gap-2">
                    <input 
                      v-model="chatForm.message"
                      type="text"
                      placeholder="Type a message..."
                      class="flex-1 border rounded px-3 py-2 text-sm"
                    />
                    <button type="submit" class="button-exp-fill text-sm" :disabled="loadingChat">
                      Send
                    </button>
                  </form>
                </div>

                <!-- Private Message Panel -->
                <div v-if="getActiveTab(webinar.id) === 'messages' && webinar.allow_private_messages" class="p-4">
                  <div class="mb-4 max-h-64 overflow-y-auto space-y-2">
                    <div v-if="!privateMessages[webinar.id] || privateMessages[webinar.id].length === 0" class="text-gray-500 text-sm">
                      Send a private message to the presenter.
                    </div>
                    <div 
                      v-for="msg in privateMessages[webinar.id]" 
                      :key="msg.id" 
                      class="p-2 rounded text-sm"
                      :class="msg.sender_type === 'attendee' ? 'bg-gray-100' : 'bg-blue-50'"
                    >
                      <p class="text-xs text-gray-500 mb-1">{{ msg.sender_type === 'attendee' ? 'You' : 'Presenter' }} • {{ formatTime(msg.created_at) }}</p>
                      <p>{{ msg.message }}</p>
                    </div>
                  </div>
                  <form @submit.prevent="sendPrivateMessage(webinar.id)" class="space-y-2">
                    <textarea 
                      v-model="messageForm.message"
                      placeholder="Write a private message to the presenter..."
                      rows="2"
                      class="w-full border rounded p-2 text-sm"
                    ></textarea>
                    <button type="submit" class="button-exp-fill text-sm" :disabled="loadingMsg">
                      {{ loadingMsg ? 'Sending...' : 'Send Private Message' }}
                    </button>
                  </form>
                </div>
              </div>
            </div>

            <!-- Past webinars: No registration, but show message if registered -->
            <div v-if="isPast(webinar)" class="mb-4">
              <div v-if="isRegistered(webinar.id)" class="text-green-600 text-sm mb-3 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                You were registered for this webinar
              </div>
              <div v-else class="text-gray-500 text-sm">
                This webinar has already ended. Registration is no longer available.
              </div>
            </div>

            <!-- Upcoming webinars: Show registration button -->
            <button
              v-if="!isPast(webinar) && !isFull(webinar) && !isRegistered(webinar.id)"
              type="button"
              class="button-exp-fill mb-3"
              @click="toggleForm(webinar.id)"
            >
              {{ activeFormId === webinar.id ? "Close form" : "Register" }}
            </button>

            <form
              v-if="!isPast(webinar) && activeFormId === webinar.id && !isFull(webinar) && !isRegistered(webinar.id)"
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
    isLoggedIn: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      activeFormId: null,
      loading: false,
      loadingQ: false,
      loadingChat: false,
      loadingMsg: false,
      form: {
        name: "",
        email: "",
        phone: "",
        company: "",
      },
      errors: {},
      // Registration tracking (stored in localStorage)
      registrations: {},
      // Active tabs per webinar
      activeTabs: {},
      // Q&A data
      questions: {},
      questionForm: {
        question: "",
        is_anonymous: false,
      },
      // Chat data
      chatMessages: {},
      chatForm: {
        message: "",
      },
      chatPollingIntervals: {},
      // Private messages data
      privateMessages: {},
      messageForm: {
        message: "",
      },
    };
  },
  mounted() {
    this.loadRegistrations();
    // Load data for registered webinars
    Object.keys(this.registrations).forEach(webinarId => {
      const webinar = this.webinars.find(w => w.id == webinarId);
      if (webinar) {
        if (webinar.allow_qa) this.loadQuestions(webinarId);
        if (webinar.allow_chat) {
          this.loadChatMessages(webinarId);
          this.startChatPolling(webinarId);
        }
        if (webinar.allow_private_messages) this.loadPrivateMessages(webinarId);
      }
    });
  },
  beforeUnmount() {
    // Clean up chat polling
    Object.values(this.chatPollingIntervals).forEach(interval => clearInterval(interval));
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
    formatTime(dateString) {
      if (!dateString) return "";
      const date = new Date(dateString);
      return date.toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" });
    },
    isFull(webinar) {
      if (!webinar) return false;
      if (!webinar.max_attendees) return false;
      if (webinar.available_seats === "Unlimited") return false;
      return Number(webinar.available_seats) <= 0;
    },
    isPast(webinar) {
      if (!webinar || !webinar.scheduled_at) return false;
      const scheduledDate = new Date(webinar.scheduled_at);
      const endDate = new Date(scheduledDate.getTime() + (webinar.duration_minutes || 60) * 60000);
      return new Date() > endDate;
    },
    isRegistered(webinarId) {
      return !!this.registrations[webinarId];
    },
    loadRegistrations() {
      try {
        const stored = localStorage.getItem('webinar_registrations');
        if (stored) {
          this.registrations = JSON.parse(stored);
        }
      } catch (e) {
        console.error('Failed to load registrations from storage:', e);
      }
    },
    saveRegistration(webinarId, data) {
      this.registrations[webinarId] = data;
      localStorage.setItem('webinar_registrations', JSON.stringify(this.registrations));
    },
    getTypeClass(type) {
      const classes = {
        live_interactive: 'bg-purple-100 text-purple-700',
        live_viewonly: 'bg-blue-100 text-blue-700',
        recorded: 'bg-orange-100 text-orange-700',
      };
      return classes[type] || 'bg-gray-100 text-gray-700';
    },
    getTypeLabel(type) {
      const labels = {
        live_interactive: 'Live Interactive',
        live_viewonly: 'Live',
        recorded: 'On-Demand',
      };
      return labels[type] || type;
    },
    /**
     * Parse image path from database (handles JSON array or string)
     */
    parseImagePath(imagePath) {
      if (!imagePath) return null;
      
      try {
        // If it's a JSON string (array), parse it
        if (typeof imagePath === 'string' && imagePath.startsWith('[')) {
          const parsed = JSON.parse(imagePath);
          if (Array.isArray(parsed) && parsed.length > 0) {
            return '/' + parsed[0].replace(/\\/g, '/');
          }
        }
        // If it's already an array
        if (Array.isArray(imagePath) && imagePath.length > 0) {
          return '/' + imagePath[0].replace(/\\/g, '/');
        }
        // If it's a plain string path
        if (typeof imagePath === 'string' && imagePath.length > 0) {
          return imagePath.startsWith('/') ? imagePath : '/' + imagePath;
        }
      } catch (e) {
        console.error('Error parsing image path:', e);
      }
      return null;
    },
    getCoverImage(webinar) {
      // Use accessor if available, otherwise parse manually
      if (webinar.cover_image_url) {
        return webinar.cover_image_url;
      }
      return this.parseImagePath(webinar.cover_image);
    },
    getPresenterImage(webinar) {
      // Use accessor if available, otherwise parse manually
      if (webinar.presenter_image_url) {
        return webinar.presenter_image_url;
      }
      return this.parseImagePath(webinar.presenter_image);
    },
    getMyWebinarsUrl() {
      // Extract language code from current URL
      const path = window.location.pathname;
      const segments = path.split('/').filter(s => s);
      const langCode = segments[0] || 'en'; // Default to 'en' if not found
      return `/${langCode}/my-webinars`;
    },
    getActiveTab(webinarId) {
      if (!this.activeTabs[webinarId]) {
        const webinar = this.webinars.find(w => w.id === webinarId);
        if (webinar?.allow_qa) return 'qa';
        if (webinar?.allow_chat) return 'chat';
        if (webinar?.allow_private_messages) return 'messages';
      }
      return this.activeTabs[webinarId] || 'qa';
    },
    setActiveTab(webinarId, tab) {
      this.activeTabs[webinarId] = tab;
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
          // Save registration to localStorage
          this.saveRegistration(webinarId, {
            name: this.form.name,
            email: this.form.email,
          });
          
          if (typeof helper !== "undefined" && helper.swalPreSuccessMessageForWeb) {
            helper.swalPreSuccessMessageForWeb(response.data.message);
          } else if (this.$swal) {
            this.$swal("Success", response.data.message, "success");
          }
          this.resetForm();
          this.activeFormId = null;

          // Load interaction data for the webinar
          const webinar = this.webinars.find(w => w.id === webinarId);
          if (webinar) {
            if (webinar.allow_qa) this.loadQuestions(webinarId);
            if (webinar.allow_chat) {
              this.loadChatMessages(webinarId);
              this.startChatPolling(webinarId);
            }
            if (webinar.allow_private_messages) this.loadPrivateMessages(webinarId);
          }
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

    // Q&A Methods
    async loadQuestions(webinarId) {
      try {
        const { data } = await axios.get(`${this.registerUrl}/${webinarId}/questions`);
        if (data.success) {
          this.questions[webinarId] = data.data || [];
        }
      } catch (error) {
        console.error('Failed to load questions:', error);
      }
    },
    async submitQuestion(webinarId) {
      if (!this.questionForm.question.trim()) return;
      
      const reg = this.registrations[webinarId];
      if (!reg) return;

      this.loadingQ = true;
      try {
        const { data } = await axios.post(`${this.registerUrl}/${webinarId}/questions`, {
          name: reg.name,
          email: reg.email,
          question: this.questionForm.question,
          is_anonymous: this.questionForm.is_anonymous,
        });
        
        if (data.success) {
          this.questionForm.question = "";
          this.questionForm.is_anonymous = false;
          // Reload questions
          await this.loadQuestions(webinarId);
          if (this.$swal) {
            this.$swal("Success", data.message || "Question submitted!", "success");
          }
        }
      } catch (error) {
        console.error('Failed to submit question:', error);
        if (this.$swal) {
          this.$swal("Error", error.response?.data?.message || "Failed to submit question", "error");
        }
      } finally {
        this.loadingQ = false;
      }
    },
    async upvoteQuestion(webinarId, questionId) {
      const reg = this.registrations[webinarId];
      if (!reg) return;

      try {
        await axios.post(`${this.registerUrl}/${webinarId}/questions/${questionId}/upvote`, {
          email: reg.email,
        });
        await this.loadQuestions(webinarId);
      } catch (error) {
        console.error('Failed to upvote:', error);
      }
    },

    // Chat Methods
    async loadChatMessages(webinarId) {
      try {
        const { data } = await axios.get(`${this.registerUrl}/${webinarId}/chat`);
        if (data.success) {
          this.chatMessages[webinarId] = data.data || [];
        }
      } catch (error) {
        console.error('Failed to load chat messages:', error);
      }
    },
    startChatPolling(webinarId) {
      // Poll for new messages every 5 seconds
      if (this.chatPollingIntervals[webinarId]) return;
      
      this.chatPollingIntervals[webinarId] = setInterval(async () => {
        const messages = this.chatMessages[webinarId] || [];
        const lastId = messages.length > 0 ? messages[messages.length - 1].id : 0;
        
        try {
          const { data } = await axios.get(`${this.registerUrl}/${webinarId}/chat/new/${lastId}`);
          if (data.success && data.data && data.data.length > 0) {
            this.chatMessages[webinarId] = [...(this.chatMessages[webinarId] || []), ...data.data];
          }
        } catch (error) {
          console.error('Failed to poll chat:', error);
        }
      }, 5000);
    },
    async sendChatMessage(webinarId) {
      if (!this.chatForm.message.trim()) return;
      
      const reg = this.registrations[webinarId];
      if (!reg) return;

      this.loadingChat = true;
      try {
        const { data } = await axios.post(`${this.registerUrl}/${webinarId}/chat`, {
          name: reg.name,
          email: reg.email,
          message: this.chatForm.message,
        });
        
        if (data.success) {
          this.chatForm.message = "";
          // Add message to local state
          if (!this.chatMessages[webinarId]) this.chatMessages[webinarId] = [];
          this.chatMessages[webinarId].push(data.data);
        }
      } catch (error) {
        console.error('Failed to send chat message:', error);
        if (this.$swal) {
          this.$swal("Error", error.response?.data?.message || "Failed to send message", "error");
        }
      } finally {
        this.loadingChat = false;
      }
    },

    // Private Message Methods
    async loadPrivateMessages(webinarId) {
      const reg = this.registrations[webinarId];
      if (!reg) return;

      try {
        const { data } = await axios.post(`${this.registerUrl}/${webinarId}/messages/conversation`, {
          email: reg.email,
        });
        if (data.success) {
          this.privateMessages[webinarId] = data.data || [];
        }
      } catch (error) {
        console.error('Failed to load private messages:', error);
      }
    },
    async sendPrivateMessage(webinarId) {
      if (!this.messageForm.message.trim()) return;
      
      const reg = this.registrations[webinarId];
      if (!reg) return;

      this.loadingMsg = true;
      try {
        const { data } = await axios.post(`${this.registerUrl}/${webinarId}/messages`, {
          name: reg.name,
          email: reg.email,
          message: this.messageForm.message,
        });
        
        if (data.success) {
          this.messageForm.message = "";
          // Reload messages
          await this.loadPrivateMessages(webinarId);
          if (this.$swal) {
            this.$swal("Success", "Message sent!", "success");
          }
        }
      } catch (error) {
        console.error('Failed to send private message:', error);
        if (this.$swal) {
          this.$swal("Error", error.response?.data?.message || "Failed to send message", "error");
        }
      } finally {
        this.loadingMsg = false;
      }
    },
  },
};
</script>


