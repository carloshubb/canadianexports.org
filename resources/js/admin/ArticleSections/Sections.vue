<template>
  <AppLayout>
    <div class="relative shadow-md sm:rounded-lg bg-white py-4">
      <header class="pt-4">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <h3 class="can-exp-h3 text-primary"> Article sections </h3>
            <router-link :to="{ name: 'admin.article-sections.create'}" class="button-exp-fill">
              Create Section
            </router-link>
          </div>
        </div>
      </header>
      <div class="px-4 md:px-6 lg:px-8 mt-4">
        <div class="-mx-4 sm:-mx-0">
          <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
              <thead class="bg-gradient-to-l from-blue-500 to-blue-400">
                <tr>
                  <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Cover</th>
                  <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Name</th>
                  <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Slug</th>
                  <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Type</th>
                  <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Position</th>
                  <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Active</th>
                  <th class="relative py-3.5 pl-3 pr-4 sm:pr-4"><span class="sr-only">Actions</span></th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                <!-- Main Sections with their Subsections -->
                <template v-for="mainSection in mainSections" :key="'main-' + mainSection.id">
                  <!-- Main Section Row -->
                  <tr class="bg-blue-50 hover:bg-blue-100 transition">
                    <td class="px-3 py-3">
                      <div v-if="mainSection.cover_image" class="w-16 h-16 rounded overflow-hidden border border-gray-300 bg-white">
                        <img :src="getImageUrl(mainSection.cover_image)" :alt="mainSection.name" class="w-full h-full object-cover">
                      </div>
                      <div v-else class="w-16 h-16 rounded bg-gray-200 flex items-center justify-center border border-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                      </div>
                    </td>
                    <td class="px-3 py-3 text-sm font-semibold text-gray-900">
                      <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 text-blue-600">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
                        </svg>
                        {{ mainSection.name }}
                      </div>
                    </td>
                    <td class="px-3 py-3 text-sm text-gray-700 font-medium">{{ mainSection.slug }}</td>
                    <td class="px-3 py-3 text-sm">
                      <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                        Main Section
                      </span>
                    </td>
                    <td class="px-3 py-3 text-sm text-gray-700">{{ mainSection.position }}</td>
                    <td class="px-3 py-3 text-sm">
                      <span v-if="mainSection.is_active" class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                        Active
                      </span>
                      <span v-else class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                        Inactive
                      </span>
                    </td>
                    <td class="relative flex justify-end py-4 pl-3 pr-4 text-right text-sm font-medium">
                      <div class="flex items-center space-x-4">
                        <router-link :to="{ name: 'admin.article-sections.edit', params: { id: mainSection.id } }" class="text-gray-500 hover:text-gray-700" title="Edit">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                          </svg>
                        </router-link>
                        <a href="#" class="text-red-500 hover:text-red-700 cursor-pointer" @click.prevent="destroy(mainSection)" title="Delete">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                          </svg>
                        </a>
                      </div>
                    </td>
                  </tr>
                  
                  <!-- Subsections under this Main Section -->
                  <tr v-for="subSection in getSubsections(mainSection.id)" :key="'sub-' + subSection.id" class="bg-white hover:bg-gray-50 transition">
                    <td class="px-3 py-2">
                      <div v-if="subSection.cover_image" class="w-12 h-12 rounded overflow-hidden border border-gray-300 bg-white ml-8">
                        <img :src="getImageUrl(subSection.cover_image)" :alt="subSection.name" class="w-full h-full object-cover">
                      </div>
                      <div v-else class="w-12 h-12 rounded bg-gray-100 flex items-center justify-center border border-gray-200 ml-8">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-300">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                      </div>
                    </td>
                    <td class="px-3 py-2 text-sm text-gray-900 pl-12">
                      <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2 text-gray-400">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        {{ subSection.name }}
                      </div>
                    </td>
                    <td class="px-3 py-2 text-sm text-gray-600">{{ subSection.slug }}</td>
                    <td class="px-3 py-2 text-sm">
                      <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-700">
                        Subsection
                      </span>
                    </td>
                    <td class="px-3 py-2 text-sm text-gray-600">{{ subSection.position }}</td>
                    <td class="px-3 py-2 text-sm">
                      <span v-if="subSection.is_active" class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                        Active
                      </span>
                      <span v-else class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                        Inactive
                      </span>
                    </td>
                    <td class="relative flex justify-end py-3 pl-3 pr-4 text-right text-sm font-medium">
                      <div class="flex items-center space-x-4">
                        <router-link :to="{ name: 'admin.article-sections.edit', params: { id: subSection.id } }" class="text-gray-500 hover:text-gray-700" title="Edit">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                          </svg>
                        </router-link>
                        <a href="#" class="text-red-500 hover:text-red-700 cursor-pointer" @click.prevent="destroy(subSection)" title="Delete">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                          </svg>
                        </a>
                      </div>
                    </td>
                  </tr>
                </template>

                <!-- Sections without parent (orphaned/standalone) if any besides main sections -->
                <template v-if="orphanedSections.length > 0">
                  <tr class="bg-gray-100">
                    <td colspan="7" class="px-3 py-2 text-sm font-semibold text-gray-600">
                      Sections without articles or subsections
                    </td>
                  </tr>
                  <tr v-for="section in orphanedSections" :key="'orphan-' + section.id" class="hover:bg-gray-50 transition">
                    <td class="px-3 py-2">
                      <div v-if="section.cover_image" class="w-14 h-14 rounded overflow-hidden border border-gray-300 bg-white">
                        <img :src="getImageUrl(section.cover_image)" :alt="section.name" class="w-full h-full object-cover">
                      </div>
                      <div v-else class="w-14 h-14 rounded bg-gray-100 flex items-center justify-center border border-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-gray-300">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                      </div>
                    </td>
                    <td class="px-3 py-2 text-sm text-gray-900">{{ section.name }}</td>
                    <td class="px-3 py-2 text-sm text-gray-600">{{ section.slug }}</td>
                    <td class="px-3 py-2 text-sm">
                      <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                        Standalone
                      </span>
                    </td>
                    <td class="px-3 py-2 text-sm text-gray-600">{{ section.position }}</td>
                    <td class="px-3 py-2 text-sm">
                      <span v-if="section.is_active" class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                        Active
                      </span>
                      <span v-else class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                        Inactive
                      </span>
                    </td>
                    <td class="relative flex justify-end py-3 pl-3 pr-4 text-right text-sm font-medium">
                      <div class="flex items-center space-x-4">
                        <router-link :to="{ name: 'admin.article-sections.edit', params: { id: section.id } }" class="text-gray-500 hover:text-gray-700" title="Edit">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                          </svg>
                        </router-link>
                        <a href="#" class="text-red-500 hover:text-red-700 cursor-pointer" @click.prevent="destroy(section)" title="Delete">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                          </svg>
                        </a>
                      </div>
                    </td>
                  </tr>
                </template>
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
  name: 'AdminArticleSectionsIndex',
  components: { AppLayout },
  data(){
    return {
      sections: [],
    };
  },
  computed: {
    // Main sections are those without a parent_id
    mainSections(){
      return this.sections
        .filter(s => !s.parent_id || s.parent_id === null)
        .sort((a, b) => {
          // Sort by position first, then by name
          if (a.position !== b.position) {
            return a.position - b.position;
          }
          return a.name.localeCompare(b.name);
        });
    },
    // Get all subsections
    allSubsections(){
      return this.sections.filter(s => s.parent_id && s.parent_id !== null);
    },
    // Orphaned sections (shouldn't happen, but just in case)
    orphanedSections(){
      // These are subsections whose parent_id doesn't exist in the sections list
      return this.allSubsections.filter(sub => {
        const parentExists = this.sections.some(s => s.id === sub.parent_id);
        return !parentExists;
      });
    }
  },
  methods: {
    // Get subsections for a specific parent section
    getSubsections(parentId){
      return this.sections
        .filter(s => s.parent_id === parentId)
        .sort((a, b) => {
          // Sort by position first, then by name
          if (a.position !== b.position) {
            return a.position - b.position;
          }
          return a.name.localeCompare(b.name);
        });
    },
    // Helper method to get proper image URL
    getImageUrl(path) {
      if (!path) return '';
      // If it's already a full URL, return as is
      if (path.startsWith('http')) return path;
      
      // Split path to encode each segment properly
      const pathParts = path.split('/');
      const encodedParts = pathParts.map(part => encodeURIComponent(part));
      const encodedPath = encodedParts.join('/');
      
      // Files are in public/ folder, so use direct path (NO /storage/ prefix)
      return `/${encodedPath}`;
    },
    async fetchList(){
      const url = `${process.env.MIX_ADMIN_API_URL}article-sections?per_page=1000`;
      const { data } = await axios.get(url);
      this.sections = (data?.data?.data) || [];
    },
    async destroy(section){
      const hasSubsections = this.getSubsections(section.id).length > 0;
      
      if (hasSubsections) {
        if (!confirm(`This section has ${this.getSubsections(section.id).length} subsection(s). Deleting it will also affect these subsections. Continue?`)) {
          return;
        }
      } else {
        if (!confirm('Delete this section?')) return;
      }
      
      try {
        await axios.delete(`${process.env.MIX_ADMIN_API_URL}article-sections/${section.id}`);
        await this.fetchList();
      } catch (error) {
        if (error.response && error.response.status === 422) {
          alert('Cannot delete this section. It may have articles assigned to it.');
        } else {
          alert('An error occurred while deleting the section.');
        }
      }
    }
  },
  async created(){
    await this.fetchList();
  }
}
</script>


