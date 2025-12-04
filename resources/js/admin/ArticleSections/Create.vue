<template>
  <AppLayout>
    <div class="relative shadow-md sm:rounded-lg bg-white py-4">
      <header class="pt-4">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <h3 class="can-exp-h3 text-primary"> {{ isEdit ? 'Edit' : 'Create' }} article section </h3>
            <router-link :to="{ name: 'admin.article-sections.index'}" class="button-exp-fill">
              Back
            </router-link>
          </div>
        </div>
      </header>
      <form class="px-4 md:px-6 lg:px-8" @submit.prevent="submit">
        <div class="grid my-5 grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="name">Name</label>
            <input id="name" type="text" class="can-exp-input w-full block border border-gray-300 rounded"
                   v-model="form.name"/>
            <p class="mt-2 text-sm text-red-400" v-if="errors.name" v-text="errors.name"></p>
          </div>
          <div>
            <label for="slug">Slug</label>
            <input id="slug" type="text" class="can-exp-input w-full block border border-gray-300 rounded"
                   v-model="form.slug"/>
            <p class="mt-2 text-sm text-red-400" v-if="errors.slug" v-text="errors.slug"></p>
          </div>
          <div class="md:col-span-2">
            <label for="description">Description</label>
            <textarea id="description" rows="3" class="can-exp-input w-full block border border-gray-300 rounded"
                      v-model="form.description"></textarea>
          </div>
          <div class="md:col-span-2">
            <label for="cover_image">Cover Image</label>
            <FilePond
              name="cover_image"
              class-name="my-pond"
              accepted-file-types="image/*"
              credits="false"
              labelIdle="<span class='cursor-pointer'>Drag & Drop your cover image or <span class='filepond--label-action'>Browse</span></span>"
              ref="cover_image"
              v-bind:files="coverImageFiles"
              @init="handleCoverImageInit"
              @processfile="handleCoverImageProcess"
              @removefile="handleCoverImageRemoveFile"
            />
            <p class="mt-1 text-sm text-gray-500">
              Upload a cover image for this section (recommended size: 1200x400px)
            </p>
            <p class="mt-2 text-sm text-red-400" v-if="errors.cover_image" v-text="errors.cover_image"></p>
          </div>
          <div>
            <label for="parent_id">Section Type</label>
            <select id="parent_id" class="can-exp-input w-full block border border-gray-300 rounded"
                    v-model="form.parent_id">
              <option :value="null">Main Section (no parent)</option>
              <optgroup label="Make this a Subsection of:">
                <option v-for="s in mainSections" :key="s.id" :value="s.id">{{ s.name }}</option>
              </optgroup>
            </select>
            <p class="mt-1 text-sm text-gray-500">
              Choose "Main Section" to create a top-level section, or select a parent to create a subsection.
            </p>
          </div>
          <div>
            <label for="position">Position</label>
            <input id="position" type="number" min="0" class="can-exp-input w-full block border border-gray-300 rounded"
                   v-model.number="form.position"/>
          </div>
          <div>
            <label for="is_active">Active</label>
            <select id="is_active" class="can-exp-input w-full block border border-gray-300 rounded"
                    v-model.number="form.is_active">
              <option :value="1">Active</option>
              <option :value="0">Inactive</option>
            </select>
          </div>
        </div>
        <button type="submit" class="button-exp-fill" :disabled="loading">Save</button>
      </form>
    </div>
  </AppLayout>
  
</template>

<script>
import AppLayout from "../Layouts/App.vue";
import axios from "axios";
// Import FilePond
import vueFilePond, { setOptions } from "vue-filepond";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js";
import FilePondPluginImagePreview from "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview
);

export default {
  name: 'AdminArticleSectionsCreate',
  components: { AppLayout, FilePond },
  data() {
    return {
      loading: false,
      form: {
        name: '',
        slug: '',
        description: '',
        cover_image: '',
        parent_id: null,
        position: 0,
        is_active: 1,
      },
      errors: {},
      flatSections: [],
      coverImageFiles: [],
    };
  },
  computed: {
    isEdit() {
      return !!this.$route.params.id;
    },
    // Only show main sections (parent_id = null) as options for parent selection
    // When editing, exclude the current section to prevent it from being its own parent
    mainSections() {
      return this.flatSections
        .filter(s => !s.parent_id || s.parent_id === null)
        .filter(s => !this.isEdit || s.id !== parseInt(this.$route.params.id));
    }
  },
  methods: {
    async loadSections() {
      const url = `${process.env.MIX_ADMIN_API_URL}article-sections?per_page=1000`;
      const { data } = await axios.get(url);
      this.flatSections = (data?.data?.data) || [];
    },
    async loadOne() {
      if (!this.isEdit) return;
      const url = `${process.env.MIX_ADMIN_API_URL}article-sections/${this.$route.params.id}`;
      const { data } = await axios.get(url);
      const s = data?.data || {};
      this.form = {
        name: s.name || '',
        slug: s.slug || '',
        description: s.description || '',
        cover_image: s.cover_image || '',
        parent_id: s.parent_id || null,
        position: s.position || 0,
        is_active: s.is_active ? 1 : 0,
      };
      
      // Load existing cover image for FilePond preview
      if (s.cover_image) {
        this.convertImgUrlToBase64(s.cover_image, 'image/jpeg');
      }
    },
    convertImgUrlToBase64(url, type) {
      const vm = this;
      const image = new Image();
      image.crossOrigin = 'Anonymous';
      
      // Encode special characters in filename
      const pathParts = url.split('/');
      const encodedParts = pathParts.map(part => encodeURIComponent(part));
      const encodedUrl = encodedParts.join('/');
      
      // Ensure the URL is absolute (files are in public/, NO /storage/ prefix)
      const fullUrl = url.startsWith('http') ? encodedUrl : `${window.location.origin}/${encodedUrl}`;
      
      image.onload = function() {
        const canvas = document.createElement('canvas');
        canvas.width = image.width;
        canvas.height = image.height;
        canvas.getContext('2d').drawImage(this, 0, 0);
        
        const dataUrl = canvas.toDataURL(type);
        vm.coverImageFiles = [{
          source: dataUrl,
          options: {
            type: 'local'
          }
        }];
      };
      image.onerror = function() {
        console.warn('Failed to load image for preview:', fullUrl);
        // Try without base64 conversion as fallback
        vm.coverImageFiles = [{
          source: fullUrl,
          options: {
            type: 'local'
          }
        }];
      };
      image.src = fullUrl;
    },
    async submit() {
      this.loading = true;
      this.errors = {};
      try {
        const payload = { ...this.form };
        if (payload.parent_id === null) delete payload.parent_id;
        const url = this.isEdit
          ? `${process.env.MIX_ADMIN_API_URL}article-sections/${this.$route.params.id}`
          : `${process.env.MIX_ADMIN_API_URL}article-sections`;
        const method = this.isEdit ? 'put' : 'post';
        await axios[method](url, payload);
        this.$router.push({ name: 'admin.article-sections.index' });
      } catch (e) {
        if (e.response && e.response.status === 422) {
          const errs = e.response.data?.errors || {};
          this.errors = Object.fromEntries(Object.entries(errs).map(([k,v]) => [k, v[0]]));
        }
      } finally {
        this.loading = false;
      }
    },
    handleCoverImageInit() {
      setOptions({
        credits: false,
        server: {
          url: process.env.MIX_ADMIN_API_URL,
          process: (
            fieldName,
            file,
            metadata,
            load,
            error,
            progress,
            abort,
            transfer,
            options
          ) => {
            const formData = new FormData();
            formData.append("media", file, file.name);
            formData.append("is_temp_media", 1);
            formData.append("type", "section-cover");

            const request = new XMLHttpRequest();
            request.open("POST", `${process.env.MIX_ADMIN_API_URL}media/process`);
            request.setRequestHeader(
              "X-CSRF-TOKEN",
              document.head.querySelector('meta[name="csrf-token"]').content
            );

            request.upload.onprogress = (e) => {
              progress(e.lengthComputable, e.loaded, e.total);
            };
            request.onload = function () {
              if (request.status >= 200 && request.status < 300) {
                load(request.responseText);
              } else {
                error("Upload failed");
              }
            };

            request.send(formData);

            return {
              abort: () => {
                request.abort();
                abort();
              },
            };
          },
          revert: (uniqueFileId, load, error) => {
            const formData = new FormData();
            formData.append("media", uniqueFileId);

            const request = new XMLHttpRequest();
            request.open("POST", `${process.env.MIX_ADMIN_API_URL}media/revert`);
            request.setRequestHeader(
              "X-CSRF-TOKEN",
              document.head.querySelector('meta[name="csrf-token"]').content
            );

            request.send(formData);

            return {
              abort: () => {
                request.abort();
                abort();
              },
            };
          },
          headers: {
            "X-CSRF-TOKEN": document.head.querySelector(
              'meta[name="csrf-token"]'
            ).content,
          },
        },
      });
    },
    handleCoverImageProcess(error, file) {
      if (error) {
        console.error('Upload error:', error);
        return;
      }
      // Store the server response (file path) in form
      this.form.cover_image = file.serverId;
      // Clear error if exists
      if (this.errors.cover_image) {
        delete this.errors.cover_image;
      }
    },
    handleCoverImageRemoveFile(error, file) {
      // Clear the cover_image from form when file is removed
      this.form.cover_image = '';
    }
  },
  async created() {
    await this.loadSections();
    await this.loadOne();
  }
}
</script>


