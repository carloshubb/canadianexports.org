<template>
  <AppLayout>
    <div class="relative shadow-md sm:rounded-lg bg-white py-4">
      <header class="pt-4">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <h3 class="can-exp-h3 text-primary">Sponsor Videos</h3>
          </div>
        </div>
      </header>
      <div class="px-4 md:px-6 lg:px-8">
        <div v-if="loading" class="py-8 text-center">Loading...</div>
        <div v-else-if="!videos.length" class="py-8 text-center text-gray-500">No sponsor videos submitted yet.</div>
        <div v-else class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead>
              <tr>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Submitted By</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr v-for="v in videos" :key="v.id">
                <td class="px-4 py-3 text-sm text-gray-900">{{ v.title }}</td>
                <td class="px-4 py-3 text-sm text-gray-600">{{ v.customer?.name || v.customer?.email || '-' }}</td>
                <td class="px-4 py-3">
                  <span :class="getStatusClass(v.status)" class="px-2 py-1 text-xs rounded">{{ v.status }}</span>
                </td>
                <td class="px-4 py-3 text-sm text-gray-600">{{ formatDate(v.created_at) }}</td>
                <td class="px-4 py-3">
                  <button @click="viewVideo(v)" class="text-primary hover:underline text-sm mr-2">View</button>
                  <template v-if="v.status === 'pending'">
                    <button @click="updateStatus(v.id, 'approved')" class="text-green-600 hover:underline text-sm mr-2">Approve</button>
                    <button @click="updateStatus(v.id, 'rejected')" class="text-red-600 hover:underline text-sm">Reject</button>
                  </template>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- View Modal -->
      <div v-if="viewingVideo" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4" @click.self="viewingVideo = null">
        <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
          <div class="p-6">
            <div class="flex justify-between items-start mb-4">
              <h3 class="text-xl font-bold">{{ viewingVideo.title }}</h3>
              <button @click="viewingVideo = null" class="text-gray-500 hover:text-gray-700">×</button>
            </div>
            <p class="text-gray-600 mb-4">{{ viewingVideo.summary }}</p>
            <div v-if="viewingVideo.youtube_url" class="aspect-video mb-4">
              <iframe
                :src="getEmbedUrl(viewingVideo.youtube_url)"
                class="w-full h-full"
                frameborder="0"
                allowfullscreen
              ></iframe>
            </div>
            <p class="text-sm text-gray-500">Submitted by: {{ viewingVideo.customer?.name || viewingVideo.customer?.email }}</p>
            <div v-if="viewingVideo.status === 'pending'" class="mt-4 flex gap-2">
              <button @click="updateStatus(viewingVideo.id, 'approved'); viewingVideo = null" class="button-exp-fill">Approve</button>
              <button @click="updateStatus(viewingVideo.id, 'rejected'); viewingVideo = null" class="button-exp-no-fill border-red-500 text-red-600">Reject</button>
            </div>
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
  name: "SponsorVideosIndex",
  components: { AppLayout },
  data() {
    return {
      videos: [],
      loading: true,
      viewingVideo: null,
    };
  },
  mounted() {
    this.load();
    const id = this.$route.params.id;
    if (id) {
      this.$nextTick(() => this.openVideoById(id));
    }
  },
  methods: {
    async load() {
      this.loading = true;
      try {
        const res = await axios.get(`${process.env.MIX_ADMIN_API_URL}sponsor-videos?per_page=100`);
        const d = res.data?.data;
        this.videos = Array.isArray(d) ? d : (d?.data || []);
      } catch (e) {
        console.error(e);
      } finally {
        this.loading = false;
      }
    },
    async openVideoById(id) {
      try {
        const res = await axios.get(`${process.env.MIX_ADMIN_API_URL}sponsor-videos/${id}`);
        if (res.data?.data) this.viewingVideo = res.data.data;
      } catch (e) {
        console.error(e);
      }
    },
    viewVideo(v) {
      this.viewingVideo = v;
    },
    getEmbedUrl(url) {
      if (!url) return "";
      const m = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&?]+)/);
      const id = m ? m[1] : null;
      return id ? `https://www.youtube.com/embed/${id}` : url;
    },
    getStatusClass(s) {
      if (s === "approved") return "bg-green-100 text-green-800";
      if (s === "rejected") return "bg-red-100 text-red-800";
      return "bg-yellow-100 text-yellow-800";
    },
    formatDate(d) {
      if (!d) return "-";
      return new Date(d).toLocaleDateString();
    },
    async updateStatus(id, status) {
      try {
        await axios.patch(`${process.env.MIX_ADMIN_API_URL}sponsor-videos/${id}`, { status });
        await this.load();
      } catch (e) {
        this.$swal?.fire?.({ icon: "error", title: "Error", text: "Failed to update." });
      }
    },
  },
};
</script>
