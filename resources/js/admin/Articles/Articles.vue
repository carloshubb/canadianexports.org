<template>
  <AppLayout>
    <div class="relative shadow-md sm:rounded-lg bg-white py-4">
      <header class="pt-4">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <h3 class="can-exp-h3 text-primary"> Articles </h3>
            <router-link :to="{ name: 'admin.articles.create'}" class="button-exp-fill">
              Create
            </router-link>
          </div>
        </div>
      </header>
      <div class="px-4 md:px-6 lg:px-8 mt-4">
        <div class="flex gap-3 mb-4">
          <input type="text" placeholder="Search title/summary" class="can-exp-input border border-gray-300 rounded" v-model="filters.q" @keyup.enter="fetchList"/>
          <select class="can-exp-input border border-gray-300 rounded" v-model="filters.section_id" @change="fetchList">
            <option value="">All sections</option>
            <option v-for="s in sections" :key="s.id" :value="s.id">{{ s.name }}</option>
          </select>
          <select class="can-exp-input border border-gray-300 rounded" v-model="filters.status" @change="fetchList">
            <option value="">All status</option>
            <option value="draft">Draft</option>
            <option value="published">Published</option>
          </select>
          <button class="button-exp-fill" @click="fetchList">Filter</button>
        </div>
        <div class="-mx-4 sm:-mx-0 mt-4">
          <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
              <thead class="bg-gradient-to-l from-blue-500 to-blue-400">
                <tr>
                  <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Cover</th>
                  <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Title</th>
                  <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Section</th>
                  <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                  <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Published</th>
                  <th class="relative py-3.5 pl-3 pr-4 sm:pr-4"><span class="sr-only">Actions</span></th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                <tr v-for="a in items" :key="a.id" class="hover:shadow-lg">
                  <td class="px-3 py-2">
                    <div v-if="a.cover_image" class="w-16 h-16 rounded overflow-hidden border border-gray-300 bg-white">
                      <img :src="getImageUrl(a.cover_image)" :alt="a.title" class="w-full h-full object-cover">
                    </div>
                    <div v-else class="w-16 h-16 rounded bg-gray-100 flex items-center justify-center border border-gray-200">
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                      </svg>
                    </div>
                  </td>
                  <td class="px-3 py-2 text-sm text-gray-900">{{ a.title }}</td>
                  <td class="px-3 py-2 text-sm text-gray-900">{{ a.section?.name }}</td>
                  <td class="px-3 py-2 text-sm text-gray-900">{{ a.status }}</td>
                  <td class="px-3 py-2 text-sm text-gray-900">{{ a.published_at ? formatDate(a.published_at) : '-' }}</td>
                  <td class="relative flex justify-end py-4 pl-3 pr-4 text-right text-sm font-medium">
                    <div class="flex items-center space-x-4">
                      <router-link :to="{ name: 'admin.articles.edit', params: { id: a.id } }" class="text-gray-500 hover:text-gray-700" data-tooltip="Edit">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                      </router-link>
                      <a href="#" class="text-red-500 hover:text-red-700 cursor-pointer" @click.prevent="destroy(a)" data-tooltip="Delete">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                      </a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
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
  name: 'AdminArticlesIndex',
  components: { AppLayout },
  data(){
    return {
      items: [],
      sections: [],
      filters: { q: '', section_id: '', status: '' },
    };
  },
  methods: {
    formatDate(value){
      try{
        // Accepts 'YYYY-MM-DD HH:MM:SS' or ISO; outputs date-only in locale
        const norm = value?.replace(' ', 'T');
        const d = new Date(norm);
        if (isNaN(d.getTime())) return value?.slice(0,10) || value;
        return d.toLocaleDateString();
      }catch(e){
        return value?.slice(0,10) || value;
      }
    },
    getImageUrl(path) {
      if (!path) return '';
      if (path.startsWith('http')) return path;
      
      // Split path to encode each segment properly
      const pathParts = path.split('/');
      const encodedParts = pathParts.map(part => encodeURIComponent(part));
      const encodedPath = encodedParts.join('/');
      
      // Files are in public/ folder, so use direct path
      return `/${encodedPath}`;
    },
    async loadSections(){
      const url = `${process.env.MIX_ADMIN_API_URL}article-sections?per_page=1000&only_active=1`;
      const { data } = await axios.get(url);
      this.sections = (data?.data?.data) || [];
    },
    async fetchList(){
      const params = {};
      if(this.filters.q) params.q = this.filters.q;
      if(this.filters.section_id) params.section_id = this.filters.section_id;
      if(this.filters.status) params.status = this.filters.status;
      const url = `${process.env.MIX_ADMIN_API_URL}articles`;
      const { data } = await axios.get(url, { params });
      this.items = (data?.data?.data) || [];
    },
    async destroy(article){
      if(!confirm('Delete this article?')) return;
      await axios.delete(`${process.env.MIX_ADMIN_API_URL}articles/${article.id}`);
      await this.fetchList();
    }
  },
  async created(){
    await this.loadSections();
    await this.fetchList();
  }
}
</script>


