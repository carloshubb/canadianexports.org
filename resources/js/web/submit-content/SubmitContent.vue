<template>
  <div class="submit-content text-center" style="margin-top: 100px;" >
    <div class="w-full text-center text-4xl mb-8 ">
      <h1 class="text-center   font-bold text-primary mb-4">Submit Content</h1>
      <p class="w-full text-lg text-gray-700">
        As a Sponsor, your content receives priority placement. Use this page to submit industry insights, company news, and trade-related media to be featured across the Canadian Exports network.
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto mb-12">

      <!-- Submit Article -->
      <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow border border-gray-100 overflow-hidden">
        <div class="p-6">
          <div class="flex items-center gap-3 mb-3">
            <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-primary">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
              </svg>
            </div>
            <h2 class="text-xl font-semibold text-gray-900">Submit Article</h2>
          </div>
          <p class="text-gray-600 text-sm mb-4">Share your industry insights and company news as articles.</p>
          <button @click="showArticleModal = true" class="button-exp-fill w-full sm:w-auto">
            Submit Article
          </button>
        </div>
      </div>

      <!-- Submit Video -->
      <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow border border-gray-100 overflow-hidden">
        <div class="p-6">
          <div class="flex items-center gap-3 mb-3">
            <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-primary">
                <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
              </svg>
            </div>
            <h2 class="text-xl font-semibold text-gray-900">Submit Video</h2>
          </div>
          <p class="text-gray-600 text-sm mb-4">Submit your YouTube videos to be featured on the network.</p>
          <button @click="showVideoModal = true" class="button-exp-fill w-full sm:w-auto">
            Submit Video
          </button>
        </div>
      </div>

      <!-- Submit Webinar -->
      <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow border border-gray-100 overflow-hidden">
        <div class="p-6">
          <div class="flex items-center gap-3 mb-3">
            <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-primary">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
              </svg>
            </div>
            <h2 class="text-xl font-semibold text-gray-900">Submit Webinar</h2>
          </div>
          <p class="text-gray-600 text-sm mb-4">Create and manage your webinars.</p>
          <a :href="myWebinarsUrl" class="button-exp-fill inline-block">
            Submit Webinar
          </a>
        </div>
      </div>

      <!-- Submit Event -->
      <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow border border-gray-100 overflow-hidden">
        <div class="p-6">
          <div class="flex items-center gap-3 mb-3">
            <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-primary">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
              </svg>
            </div>
            <h2 class="text-xl font-semibold text-gray-900">Submit Event</h2>
          </div>
          <p class="text-gray-600 text-sm mb-4">Create your events to be featured across the network.</p>
          <button @click="handleEventClick" class="button-exp-fill w-full sm:w-auto">
            Submit Event
          </button>
        </div>
      </div>
    </div>

    <!-- Success Popup -->
    <div v-if="showSuccessModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4" @click.self="showSuccessModal = false">
      <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-8 text-center">
        <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-10 text-green-600">
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
          </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Submission Received!</h3>
        <p class="text-gray-600 mb-6">Thank you for sharing your content. Our editors are reviewing it for the CaExp network, and you will be notified as soon as it is live.</p>
        <button @click="showSuccessModal = false" class="button-exp-fill">Got it!</button>
      </div>
    </div>

    <!-- Event Info Popup (Premium free, Featured paid) -->
    <div v-if="showEventInfoModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4" @click.self="showEventInfoModal = false">
      <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-8">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Submit Event</h3>
        <p class="text-gray-600 mb-4" v-html="'As a Sponsor, you receive <strong>Premium Events for free</strong>. Featured Events require additional payment.'"></p>
        <div class="flex gap-3">
          <button @click="goToEventCreate" class="button-exp-fill flex-1">Continue to Event</button>
          <button @click="showEventInfoModal = false" class="button-exp-no-fill flex-1">Cancel</button>
        </div>
      </div>
    </div>

    <!-- Article Modal -->
    <div v-if="showArticleModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4 overflow-y-auto">
      <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full my-8 max-h-[90vh] overflow-y-auto">
        <div class="p-6">
          <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-900">Submit Article</h3>
            <button @click="closeArticleModal" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
          </div>
          <form @submit.prevent="submitArticle">
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium mb-1">Section *</label>
                <select v-model="articleForm.section_id" class="can-exp-input w-full" required>
                  <option value="">Select section...</option>
                  <option v-for="s in articleSections" :key="s.id" :value="s.id">{{ s.name }}</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium mb-1">Title *</label>
                <input v-model="articleForm.title" type="text" class="can-exp-input w-full" required />
              </div>
              <div>
                <label class="block text-sm font-medium mb-1">Summary</label>
                <textarea v-model="articleForm.summary" rows="2" class="can-exp-input w-full"></textarea>
              </div>
              <div>
                <label class="block text-sm font-medium mb-1">Body *</label>
                <textarea v-model="articleForm.body" rows="8" class="can-exp-input w-full" required></textarea>
              </div>
              <div>
                <label class="block text-sm font-medium mb-1">Cover Image</label>
                <FilePond
                  ref="articleCoverPond"
                  name="media"
                  class-name="my-pond"
                  accepted-file-types="image/*"
                  credits="false"
                  :label-idle="'Drag & Drop or Browse'"
                  :server="filePondServer"
                  @processfile="onArticleCoverProcess"
                  @removefile="articleForm.cover_image = null"
                />
              </div>
            </div>
            <div class="flex gap-3 mt-6">
              <button type="submit" class="button-exp-fill" :disabled="articleSubmitting">
                {{ articleSubmitting ? 'Submitting...' : 'Submit Article' }}
              </button>
              <button type="button" @click="closeArticleModal" class="button-exp-no-fill">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Video Modal -->
    <div v-if="showVideoModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-xl shadow-xl max-w-lg w-full">
        <div class="p-6">
          <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-900">Submit Video</h3>
            <button @click="closeVideoModal" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
          </div>
          <form @submit.prevent="submitVideo">
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium mb-1">Video Title *</label>
                <input v-model="videoForm.title" type="text" class="can-exp-input w-full" required />
              </div>
              <div>
                <label class="block text-sm font-medium mb-1">Short Summary *</label>
                <p class="text-xs text-gray-500 mb-1">Briefly describe the video content</p>
                <textarea v-model="videoForm.summary" rows="3" class="can-exp-input w-full" required></textarea>
              </div>
              <div>
                <label class="block text-sm font-medium mb-1">YouTube Link *</label>
                <input
                  v-model="videoForm.youtube_url"
                  type="text"
                  class="can-exp-input w-full"
                  :class="{ 'border-red-500': videoYoutubeError }"
                  :placeholder="'Paste your YouTube URL here. We currently only accept YouTube videos.'"
                  required
                />
                <p v-if="videoYoutubeError" class="text-red-500 text-sm mt-1">Please provide a valid YouTube URL.</p>
              </div>
            </div>
            <div class="flex gap-3 mt-6">
              <button type="submit" class="button-exp-fill" :disabled="videoSubmitting">
                {{ videoSubmitting ? 'Submitting...' : 'Submit Video' }}
              </button>
              <button type="button" @click="closeVideoModal" class="button-exp-no-fill">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
const FilePond = vueFilePond();

const YOUTUBE_REGEX = /^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)(\/.*)?$/i;

export default {
  name: "SubmitContent",
  components: { FilePond },
  props: {
    eventCreateUrl: { type: String, default: "#" },
    myWebinarsUrl: { type: String, default: "#" },
  },
  data() {
    return {
      showSuccessModal: false,
      showEventInfoModal: false,
      showArticleModal: false,
      showVideoModal: false,
      articleSections: [],
      articleForm: {
        section_id: "",
        title: "",
        summary: "",
        body: "",
        cover_image: null,
      },
      videoForm: {
        title: "",
        summary: "",
        youtube_url: "",
      },
      articleSubmitting: false,
      videoSubmitting: false,
      videoYoutubeError: false,
      filePondServer: {
        url: process.env.MIX_APP_URL || "",
        process: {
          url: "/media/process",
          method: "POST",
          withCredentials: true,
          headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content || "",
          },
        },
        revert: (uniqueFileId, load, error) => {
          const url = `${process.env.MIX_APP_URL || ""}/media/revert`;
          axios.post(url, { media: uniqueFileId }, {
            headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content || "" },
            withCredentials: true,
          }).then(() => load()).catch(() => error());
        },
      },
    };
  },
  watch: {
    "videoForm.youtube_url"(val) {
      if (!val) this.videoYoutubeError = false;
      else this.videoYoutubeError = !YOUTUBE_REGEX.test(val.trim());
    },
  },
  mounted() {
    this.loadArticleSections();
  },
  methods: {
    async loadArticleSections() {
      try {
        const res = await axios.get(`${process.env.MIX_WEB_API_URL}sponsor/article-sections`, { withCredentials: true });
        if (res.data?.status === "Success") this.articleSections = res.data.data || [];
      } catch (e) {
        console.warn("Could not load article sections", e);
      }
    },
    handleEventClick() {
      this.showEventInfoModal = true;
    },
    goToEventCreate() {
      this.showEventInfoModal = false;
      window.location.href = this.eventCreateUrl;
    },
    closeArticleModal() {
      this.showArticleModal = false;
      this.articleForm = { section_id: "", title: "", summary: "", body: "", cover_image: null };
      if (this.$refs.articleCoverPond) this.$refs.articleCoverPond.removeFiles();
    },
    closeVideoModal() {
      this.showVideoModal = false;
      this.videoForm = { title: "", summary: "", youtube_url: "" };
      this.videoYoutubeError = false;
    },
    onArticleCoverProcess(err, file) {
      if (!err && file?.serverId) this.articleForm.cover_image = typeof file.serverId === "string" ? file.serverId : JSON.stringify(file.serverId);
    },
    async submitArticle() {
      this.articleSubmitting = true;
      try {
        const res = await axios.post(`${process.env.MIX_WEB_API_URL}sponsor/submit-article`, this.articleForm, {
          withCredentials: true,
          headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content || "" },
        });
        if (res.data?.status === "Success") {
          this.closeArticleModal();
          this.showSuccessModal = true;
        } else {
          this.$swal?.fire?.({ icon: "error", title: "Error", text: res.data?.message || "Submission failed." });
        }
      } catch (e) {
        const msg = e.response?.data?.message || e.response?.data?.errors ? JSON.stringify(e.response.data.errors) : "Submission failed.";
        this.$swal?.fire?.({ icon: "error", title: "Error", text: msg });
      } finally {
        this.articleSubmitting = false;
      }
    },
    async submitVideo() {
      const url = this.videoForm.youtube_url?.trim();
      if (!YOUTUBE_REGEX.test(url)) {
        this.videoYoutubeError = true;
        return;
      }
      this.videoYoutubeError = false;
      this.videoSubmitting = true;
      try {
        const res = await axios.post(`${process.env.MIX_WEB_API_URL}sponsor/submit-video`, { ...this.videoForm, youtube_url: url }, {
          withCredentials: true,
          headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content || "" },
        });
        if (res.data?.status === "Success") {
          this.closeVideoModal();
          this.showSuccessModal = true;
        } else {
          this.$swal?.fire?.({ icon: "error", title: "Error", text: res.data?.message || "Submission failed." });
        }
      } catch (e) {
        const msg = e.response?.data?.message || (e.response?.data?.errors?.youtube_url?.[0] || "Please provide a valid YouTube URL.");
        this.$swal?.fire?.({ icon: "error", title: "Error", text: msg });
      } finally {
        this.videoSubmitting = false;
      }
    },
  },
};
</script>
