<template>
  <AppLayout>
    <div class="relative shadow-md sm:rounded-lg bg-white py-4">
      <header class="pt-4">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <h3 class="can-exp-h3 text-primary"> {{ isEdit ? 'Edit' : 'Create' }} article </h3>
            <router-link :to="{ name: 'admin.articles.index'}" class="button-exp-fill">
              Back
            </router-link>
          </div>
        </div>
      </header>
      <form class="px-4 md:px-6 lg:px-8" @submit.prevent="submit">
        <div class="grid my-5 grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="title">Title</label>
            <input id="title" type="text" class="can-exp-input w-full block border border-gray-300 rounded" v-model="form.title"/>
            <p class="mt-2 text-sm text-red-400" v-if="errors.title" v-text="errors.title"></p>
          </div>
          <div>
            <label for="slug">Slug</label>
            <input id="slug" type="text" class="can-exp-input w-full block border border-gray-300 rounded" v-model="form.slug"/>
            <p class="mt-2 text-sm text-red-400" v-if="errors.slug" v-text="errors.slug"></p>
          </div>
          <div>
            <label for="section_id">Section</label>
            <select id="section_id" class="can-exp-input w-full block border border-gray-300 rounded" v-model="form.section_id">
              <option value="">Select section...</option>
              <option v-for="s in sections" :key="s.id" :value="s.id">{{ s.name }}</option>
            </select>
            <p class="mt-2 text-sm text-red-400" v-if="errors.section_id" v-text="errors.section_id"></p>
          </div>
          <div>
            <label for="template">Template</label>
            <select id="template" class="can-exp-input w-full block border border-gray-300 rounded" v-model="form.template">
              <option value="standard">Standard</option>
              <option value="image_left">Image left</option>
              <option value="image_right">Image right</option>
              <option value="media_bottom">Media bottom</option>
            </select>
          </div>
          <div>
            <label for="status">Status</label>
            <select id="status" class="can-exp-input w-full block border border-gray-300 rounded" v-model="form.status">
              <option value="draft">Draft</option>
              <option value="published">Published</option>
            </select>
          </div>
          <div>
            <label for="published_at">Published at</label>
            <input id="published_at" type="datetime-local" class="can-exp-input w-full block border border-gray-300 rounded" v-model="form.published_at"/>
          </div>
          <div class="md:col-span-2">
            <label for="summary">Summary</label>
            <textarea id="summary" rows="2" class="can-exp-input w-full block border border-gray-300 rounded" v-model="form.summary"></textarea>
          </div>
          <div class="md:col-span-2" v-if="ready">
            <label for="body">Body</label>
            <editor :id="'body'" :ref="'body'" :initial-value="form.body" :tinymce-script-src="tinymceScriptSrc" :init="editorConfig"
                    @keyup="syncEditor()" @mouseleave="syncEditor()"/>
            <p class="mt-2 text-sm text-red-400" v-if="errors.body" v-text="errors.body"></p>
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
              Upload a cover image for this article (recommended size: 1200x630px)
            </p>
            <p class="mt-2 text-sm text-red-400" v-if="errors.cover_image" v-text="errors.cover_image"></p>
          </div>
          <div>
            <label for="video_url">Video URL</label>
            <input id="video_url" type="text" class="can-exp-input w-full block border border-gray-300 rounded" v-model="form.video_url"/>
          </div>
          <div class="md:col-span-2">
            <label for="keywords">Keywords (comma separated)</label>
            <input id="keywords" type="text" class="can-exp-input w-full block border border-gray-300 rounded" v-model="keywordsInput" @blur="applyKeywords"/>
          </div>
          <div>
            <label for="meta_title">Meta title</label>
            <input id="meta_title" type="text" class="can-exp-input w-full block border border-gray-300 rounded" v-model="form.meta_title"/>
          </div>
          <div class="md:col-span-2">
            <label for="meta_description">Meta description</label>
            <textarea id="meta_description" rows="2" class="can-exp-input w-full block border border-gray-300 rounded" v-model="form.meta_description"></textarea>
          </div>
        </div>
        <button type="submit" class="button-exp-fill" :disabled="loading">Save</button>
      </form>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "../Layouts/App.vue";
import Editor from "@tinymce/tinymce-vue";
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
  name: 'AdminArticlesCreate',
  components: { AppLayout, editor: Editor, FilePond },
  data(){
    return {
      loading: false,
      ready: false,
      sections: [],
      form: {
        title: '', slug: '', section_id: '', summary: '', body: '',
        template: 'standard', cover_image: '', video_url: '', keywords: [],
        status: 'draft', published_at: '', meta_title: '', meta_description: ''
      },
      keywordsInput: '',
      errors: {},
      coverImageFiles: [],
      editorConfig: {
        height: 350,
        menubar: false,
        plugins: "anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount fullscreen code",
        toolbar: "undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | code | fullscreen",
        base_url: '/plugins/tinymce',
        suffix: '.min'
      },
      tinymceScriptSrc: '/plugins/tinymce/tinymce.min.js',
    };
  },
  computed: {
    isEdit(){ return !!this.$route.params.id; }
  },
  methods: {
    applyKeywords(){
      if(!this.keywordsInput) { this.form.keywords = []; return; }
      this.form.keywords = this.keywordsInput.split(',').map(s => s.trim()).filter(Boolean);
    },
    syncEditor(){
      const ed = window.tinymce?.get('body');
      if(ed){ this.form.body = ed.getContent(); }
    },
    async loadSections(){
      const url = `${process.env.MIX_ADMIN_API_URL}article-sections?per_page=1000&only_active=1`;
      const { data } = await axios.get(url);
      this.sections = (data?.data?.data) || [];
    },
    async loadOne(){
      if(!this.isEdit) return;
      const url = `${process.env.MIX_ADMIN_API_URL}articles/${this.$route.params.id}`;
      const { data } = await axios.get(url);
      const a = data?.data || {};
      this.form = {
        title: a.title || '', slug: a.slug || '', section_id: a.section_id || '', summary: a.summary || '', body: a.body || '',
        template: a.template || 'standard', cover_image: a.cover_image || '', video_url: a.video_url || '', keywords: a.keywords || [],
        status: a.status || 'draft', published_at: a.published_at ? a.published_at.replace(' ', 'T').slice(0,16) : '', meta_title: a.meta_title || '', meta_description: a.meta_description || ''
      };
      this.keywordsInput = (this.form.keywords || []).join(', ');
      
      // Load existing cover image for FilePond preview
      if (a.cover_image) {
        this.convertImgUrlToBase64(a.cover_image, 'image/jpeg');
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
    async submit(){
      this.loading = true; this.errors = {};
      try{
        const payload = { ...this.form };
        if(!payload.published_at) delete payload.published_at;
        const url = this.isEdit
          ? `${process.env.MIX_ADMIN_API_URL}articles/${this.$route.params.id}`
          : `${process.env.MIX_ADMIN_API_URL}articles`;
        const method = this.isEdit ? 'put' : 'post';
        await axios[method](url, payload);
        this.$router.push({ name: 'admin.articles.index' });
      }catch(e){
        if(e.response && e.response.status === 422){
          const errs = e.response.data?.errors || {};
          this.errors = Object.fromEntries(Object.entries(errs).map(([k,v]) => [k, v[0]]));
        }
      }finally{
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
            formData.append("type", "article-cover");

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
  async created(){
    await this.loadSections();
    await this.loadOne();
    this.ready = true;
  }
}
</script>


