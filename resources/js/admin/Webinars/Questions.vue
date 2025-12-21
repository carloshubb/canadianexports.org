<template>
  <AppLayout>
    <div class="relative shadow-md sm:rounded-lg bg-white py-4">
      <header class="pt-4">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <div>
              <h3 class="can-exp-h3 text-primary">Q&A Management</h3>
              <p class="text-gray-600" v-if="webinar">{{ webinar.title }}</p>
            </div>
            <router-link :to="{ name: 'admin.webinars.index' }" class="button-exp-fill">
              Back to Webinars
            </router-link>
          </div>
        </div>
      </header>

      <!-- Filters -->
      <div class="px-4 sm:px-6 lg:px-8 py-4 border-b">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <select v-model="filter" @change="loadQuestions" class="can-exp-input border border-gray-300 rounded">
            <option value="all">All Questions</option>
            <option value="pending">Pending Approval</option>
            <option value="approved">Approved</option>
            <option value="answered">Answered</option>
            <option value="featured">Featured</option>
          </select>
        </div>
      </div>

      <!-- Questions List -->
      <div class="px-4 sm:px-6 lg:px-8 py-4">
        <div v-if="loading" class="text-center py-8">Loading questions...</div>
        <div v-else-if="!questions.length" class="text-center py-8 text-gray-500">
          No questions found
        </div>
        <div v-else class="space-y-4">
          <div 
            v-for="question in questions" 
            :key="question.id" 
            class="border rounded-lg p-4"
            :class="{
              'border-yellow-300 bg-yellow-50': question.status === 'pending',
              'border-green-300 bg-green-50': question.is_featured,
              'border-gray-200': question.status !== 'pending' && !question.is_featured
            }"
          >
            <div class="flex justify-between items-start mb-2">
              <div>
                <span class="font-medium">{{ question.asker_name }}</span>
                <span class="text-gray-500 text-sm ml-2">({{ question.asker_email }})</span>
                <span v-if="question.is_anonymous" class="text-xs bg-gray-200 px-2 py-0.5 rounded ml-2">Anonymous</span>
              </div>
              <div class="flex items-center gap-2">
                <span class="text-sm text-gray-500">{{ formatDate(question.created_at) }}</span>
                <span :class="getStatusClass(question.status)" class="px-2 py-0.5 rounded text-xs">
                  {{ question.status }}
                </span>
              </div>
            </div>
            
            <p class="text-gray-800 mb-3">{{ question.question }}</p>
            
            <div v-if="question.answer" class="bg-blue-50 border-l-4 border-blue-400 p-3 mb-3">
              <p class="text-sm font-medium text-blue-800">Answer:</p>
              <p class="text-gray-700">{{ question.answer }}</p>
            </div>

            <div class="flex flex-wrap gap-2 items-center">
              <span class="text-sm text-gray-500">
                <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/>
                </svg>
                {{ question.upvotes }} upvotes
              </span>

              <!-- Action Buttons -->
              <template v-if="question.status === 'pending'">
                <button @click="approveQuestion(question.id)" class="text-green-600 hover:underline text-sm">
                  Approve
                </button>
                <button @click="rejectQuestion(question.id)" class="text-red-600 hover:underline text-sm">
                  Reject
                </button>
              </template>

              <button 
                v-if="!question.is_answered" 
                @click="openAnswerModal(question)" 
                class="text-blue-600 hover:underline text-sm"
              >
                Answer
              </button>

              <button 
                v-if="!question.is_answered" 
                @click="markAnsweredLive(question.id)" 
                class="text-purple-600 hover:underline text-sm"
              >
                Mark Answered Live
              </button>

              <button @click="toggleFeatured(question.id)" class="text-orange-600 hover:underline text-sm">
                {{ question.is_featured ? 'Unfeature' : 'Feature' }}
              </button>

              <button @click="deleteQuestion(question.id)" class="text-red-600 hover:underline text-sm">
                Delete
              </button>
            </div>
          </div>
        </div>

        <!-- Pagination -->
        <div v-if="pagination.last_page > 1" class="mt-4 flex justify-between items-center">
          <div class="text-sm text-gray-700">
            Page {{ pagination.current_page }} of {{ pagination.last_page }}
          </div>
          <div class="flex gap-2">
            <button
              @click="changePage(pagination.current_page - 1)"
              :disabled="pagination.current_page === 1"
              class="px-3 py-1 border rounded disabled:opacity-50"
            >
              Previous
            </button>
            <button
              @click="changePage(pagination.current_page + 1)"
              :disabled="pagination.current_page === pagination.last_page"
              class="px-3 py-1 border rounded disabled:opacity-50"
            >
              Next
            </button>
          </div>
        </div>
      </div>

      <!-- Answer Modal -->
      <div v-if="showAnswerModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-lg w-full mx-4">
          <h4 class="text-lg font-medium mb-4">Answer Question</h4>
          <p class="text-gray-600 mb-4">"{{ selectedQuestion?.question }}"</p>
          <textarea 
            v-model="answerText" 
            rows="4" 
            class="w-full border border-gray-300 rounded p-2 mb-4"
            placeholder="Type your answer..."
          ></textarea>
          <div class="flex justify-end gap-2">
            <button @click="closeAnswerModal" class="px-4 py-2 border rounded">Cancel</button>
            <button @click="submitAnswer" class="px-4 py-2 bg-blue-600 text-white rounded" :disabled="!answerText.trim()">
              Submit Answer
            </button>
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
  name: 'AdminWebinarsQuestions',
  components: { AppLayout },
  data() {
    return {
      webinar: null,
      questions: [],
      loading: false,
      filter: 'all',
      pagination: {
        current_page: 1,
        last_page: 1,
      },
      showAnswerModal: false,
      selectedQuestion: null,
      answerText: '',
    };
  },
  methods: {
    async loadQuestions(page = 1) {
      this.loading = true;
      try {
        const { data } = await axios.get(
          `${process.env.MIX_ADMIN_API_URL}webinars/${this.$route.params.id}/questions`,
          { params: { page, filter: this.filter } }
        );
        
        if (data.success) {
          this.questions = data.data.data || [];
          this.pagination = {
            current_page: data.data.current_page || 1,
            last_page: data.data.last_page || 1,
          };
        }
      } catch (error) {
        console.error('Failed to load questions:', error);
        this.$swal('Error', 'Failed to load questions', 'error');
      } finally {
        this.loading = false;
      }
    },
    async loadWebinar() {
      try {
        const { data } = await axios.get(`${process.env.MIX_ADMIN_API_URL}webinars/${this.$route.params.id}`);
        this.webinar = data.success ? data.data : data.data || data;
      } catch (error) {
        console.error('Failed to load webinar:', error);
      }
    },
    async approveQuestion(id) {
      try {
        await axios.post(`${process.env.MIX_ADMIN_API_URL}webinar-questions/${id}/approve`);
        this.$swal('Success', 'Question approved', 'success');
        this.loadQuestions(this.pagination.current_page);
      } catch (error) {
        this.$swal('Error', 'Failed to approve question', 'error');
      }
    },
    async rejectQuestion(id) {
      try {
        await axios.post(`${process.env.MIX_ADMIN_API_URL}webinar-questions/${id}/reject`);
        this.$swal('Success', 'Question rejected', 'success');
        this.loadQuestions(this.pagination.current_page);
      } catch (error) {
        this.$swal('Error', 'Failed to reject question', 'error');
      }
    },
    openAnswerModal(question) {
      this.selectedQuestion = question;
      this.answerText = question.answer || '';
      this.showAnswerModal = true;
    },
    closeAnswerModal() {
      this.showAnswerModal = false;
      this.selectedQuestion = null;
      this.answerText = '';
    },
    async submitAnswer() {
      if (!this.selectedQuestion || !this.answerText.trim()) return;
      
      try {
        await axios.post(`${process.env.MIX_ADMIN_API_URL}webinar-questions/${this.selectedQuestion.id}/answer`, {
          answer: this.answerText,
        });
        this.$swal('Success', 'Answer submitted', 'success');
        this.closeAnswerModal();
        this.loadQuestions(this.pagination.current_page);
      } catch (error) {
        this.$swal('Error', 'Failed to submit answer', 'error');
      }
    },
    async markAnsweredLive(id) {
      try {
        await axios.post(`${process.env.MIX_ADMIN_API_URL}webinar-questions/${id}/mark-answered`);
        this.$swal('Success', 'Question marked as answered live', 'success');
        this.loadQuestions(this.pagination.current_page);
      } catch (error) {
        this.$swal('Error', 'Failed to update question', 'error');
      }
    },
    async toggleFeatured(id) {
      try {
        await axios.post(`${process.env.MIX_ADMIN_API_URL}webinar-questions/${id}/toggle-featured`);
        this.loadQuestions(this.pagination.current_page);
      } catch (error) {
        this.$swal('Error', 'Failed to update question', 'error');
      }
    },
    async deleteQuestion(id) {
      if (!confirm('Are you sure you want to delete this question?')) return;
      
      try {
        await axios.delete(`${process.env.MIX_ADMIN_API_URL}webinar-questions/${id}`);
        this.$swal('Success', 'Question deleted', 'success');
        this.loadQuestions(this.pagination.current_page);
      } catch (error) {
        this.$swal('Error', 'Failed to delete question', 'error');
      }
    },
    changePage(page) {
      if (page >= 1 && page <= this.pagination.last_page) {
        this.loadQuestions(page);
      }
    },
    formatDate(dateString) {
      return new Date(dateString).toLocaleString();
    },
    getStatusClass(status) {
      const classes = {
        pending: 'bg-yellow-200 text-yellow-800',
        approved: 'bg-green-200 text-green-800',
        answered: 'bg-blue-200 text-blue-800',
        rejected: 'bg-red-200 text-red-800',
      };
      return classes[status] || 'bg-gray-200 text-gray-800';
    },
  },
  mounted() {
    this.loadWebinar();
    this.loadQuestions();
  },
};
</script>

