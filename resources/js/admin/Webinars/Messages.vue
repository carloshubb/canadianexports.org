<template>
  <AppLayout>
    <div class="relative shadow-md sm:rounded-lg bg-white py-4">
      <header class="pt-4">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <div>
              <h3 class="can-exp-h3 text-primary">Private Messages</h3>
              <p class="text-gray-600" v-if="webinar">{{ webinar.title }}</p>
            </div>
            <router-link :to="{ name: 'admin.webinars.index' }" class="button-exp-fill">
              Back to Webinars
            </router-link>
          </div>
        </div>
      </header>

      <div class="flex h-[600px] mt-4">
        <!-- Conversations List -->
        <div class="w-1/3 border-r overflow-y-auto">
          <div class="px-4 py-2 border-b bg-gray-50">
            <h4 class="font-medium">Conversations</h4>
          </div>
          <div v-if="loading" class="p-4 text-center text-gray-500">Loading...</div>
          <div v-else-if="!conversations.length" class="p-4 text-center text-gray-500">
            No conversations yet
          </div>
          <div v-else>
            <div 
              v-for="conv in conversations" 
              :key="conv.registration_id" 
              @click="selectConversation(conv)"
              class="p-4 border-b cursor-pointer hover:bg-gray-50"
              :class="{ 'bg-blue-50': selectedConversation?.registration_id === conv.registration_id }"
            >
              <div class="flex justify-between items-start">
                <div>
                  <p class="font-medium">{{ conv.registration?.name || 'Unknown' }}</p>
                  <p class="text-sm text-gray-500">{{ conv.registration?.email }}</p>
                </div>
                <div class="text-right">
                  <span v-if="conv.unread_count > 0" class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">
                    {{ conv.unread_count }}
                  </span>
                  <p class="text-xs text-gray-400">{{ conv.message_count }} messages</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Conversation View -->
        <div class="w-2/3 flex flex-col">
          <template v-if="selectedConversation">
            <!-- Conversation Header -->
            <div class="px-4 py-3 border-b bg-gray-50">
              <p class="font-medium">{{ selectedConversation.registration?.name }}</p>
              <p class="text-sm text-gray-500">{{ selectedConversation.registration?.email }}</p>
            </div>

            <!-- Messages -->
            <div class="flex-1 overflow-y-auto p-4 space-y-4" ref="messagesContainer">
              <div 
                v-for="msg in messages" 
                :key="msg.id" 
                class="flex"
                :class="{ 'justify-end': msg.sender_type !== 'attendee' }"
              >
                <div 
                  class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg"
                  :class="{
                    'bg-gray-200': msg.sender_type === 'attendee',
                    'bg-blue-500 text-white': msg.sender_type !== 'attendee',
                    'opacity-50': msg.status !== 'active'
                  }"
                >
                  <p class="text-sm font-medium mb-1" v-if="msg.sender_type === 'attendee'">{{ msg.sender_name }}</p>
                  <p>{{ msg.message }}</p>
                  <div class="flex justify-between items-center mt-1">
                    <p class="text-xs opacity-75">{{ formatTime(msg.created_at) }}</p>
                    <button 
                      v-if="msg.status === 'active'"
                      @click="deleteMessage(msg.id)" 
                      class="text-xs hover:underline ml-2"
                      :class="{ 'text-red-200': msg.sender_type !== 'attendee', 'text-red-500': msg.sender_type === 'attendee' }"
                    >
                      Delete
                    </button>
                    <span v-else class="text-xs opacity-75">(deleted)</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Reply Input -->
            <div class="p-4 border-t">
              <div class="flex gap-2">
                <input 
                  v-model="replyText" 
                  @keyup.enter="sendReply"
                  type="text" 
                  placeholder="Type your reply..." 
                  class="flex-1 border border-gray-300 rounded px-3 py-2"
                />
                <button @click="sendReply" class="px-4 py-2 bg-blue-600 text-white rounded" :disabled="!replyText.trim()">
                  Send
                </button>
              </div>
            </div>
          </template>
          <div v-else class="flex-1 flex items-center justify-center text-gray-500">
            Select a conversation to view messages
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "../Layouts/App.vue";
import axios from "axios";

export default {
  name: 'AdminWebinarsMessages',
  components: { AppLayout },
  data() {
    return {
      webinar: null,
      conversations: [],
      selectedConversation: null,
      messages: [],
      loading: false,
      loadingMessages: false,
      replyText: '',
    };
  },
  methods: {
    async loadWebinar() {
      try {
        const { data } = await axios.get(`${process.env.MIX_ADMIN_API_URL}webinars/${this.$route.params.id}`);
        this.webinar = data.success ? data.data : data.data || data;
      } catch (error) {
        console.error('Failed to load webinar:', error);
      }
    },
    async loadConversations() {
      this.loading = true;
      try {
        const { data } = await axios.get(
          `${process.env.MIX_ADMIN_API_URL}webinars/${this.$route.params.id}/messages`
        );
        
        if (data.success) {
          this.conversations = data.data.data || data.data || [];
        }
      } catch (error) {
        console.error('Failed to load conversations:', error);
        this.$swal('Error', 'Failed to load conversations', 'error');
      } finally {
        this.loading = false;
      }
    },
    async selectConversation(conv) {
      this.selectedConversation = conv;
      this.loadingMessages = true;
      
      try {
        const { data } = await axios.get(
          `${process.env.MIX_ADMIN_API_URL}webinars/${this.$route.params.id}/messages/${conv.registration_id}`
        );
        
        if (data.success) {
          this.messages = data.data || [];
          this.$nextTick(() => {
            this.scrollToBottom();
          });
          
          // Update unread count locally
          conv.unread_count = 0;
        }
      } catch (error) {
        console.error('Failed to load messages:', error);
        this.$swal('Error', 'Failed to load messages', 'error');
      } finally {
        this.loadingMessages = false;
      }
    },
    async sendReply() {
      if (!this.replyText.trim() || !this.selectedConversation) return;
      
      try {
        const { data } = await axios.post(
          `${process.env.MIX_ADMIN_API_URL}webinars/${this.$route.params.id}/messages/${this.selectedConversation.registration_id}/reply`,
          { message: this.replyText }
        );
        
        if (data.success) {
          this.messages.push(data.data);
          this.replyText = '';
          this.$nextTick(() => {
            this.scrollToBottom();
          });
        }
      } catch (error) {
        this.$swal('Error', 'Failed to send reply', 'error');
      }
    },
    async deleteMessage(messageId) {
      if (!confirm('Delete this message?')) return;
      
      try {
        await axios.delete(
          `${process.env.MIX_ADMIN_API_URL}webinars/${this.$route.params.id}/messages/${messageId}`
        );
        
        // Update message status locally
        const msg = this.messages.find(m => m.id === messageId);
        if (msg) {
          msg.status = 'deleted_by_admin';
        }
      } catch (error) {
        this.$swal('Error', 'Failed to delete message', 'error');
      }
    },
    scrollToBottom() {
      const container = this.$refs.messagesContainer;
      if (container) {
        container.scrollTop = container.scrollHeight;
      }
    },
    formatTime(dateString) {
      return new Date(dateString).toLocaleString();
    },
  },
  mounted() {
    this.loadWebinar();
    this.loadConversations();
  },
};
</script>

