<template>
  <AppLayout>
    <div class="relative shadow-md sm:rounded-lg bg-white py-4">
      <header class="pt-4">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <h3 class="can-exp-h3 text-primary">{{ isEdit ? 'Edit' : 'Create' }} Webinar</h3>
            <router-link :to="{ name: 'admin.webinars.index'}" class="button-exp-fill">
              Back
            </router-link>
          </div>
        </div>
      </header>

      <form class="px-4 md:px-6 lg:px-8" @submit.prevent="submit">
        <div class="grid my-5 grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Title -->
          <div>
            <label for="title">Title *</label>
            <input 
              id="title" 
              type="text" 
              class="can-exp-input w-full block border border-gray-300 rounded" 
              v-model="form.title"
              @input="generateSlug"
            />
            <p class="mt-2 text-sm text-red-400" v-if="errors.title" v-text="errors.title"></p>
          </div>

          <!-- Slug -->
          <div>
            <label for="slug">Slug *</label>
            <input 
              id="slug" 
              type="text" 
              class="can-exp-input w-full block border border-gray-300 rounded" 
              v-model="form.slug"
            />
            <p class="mt-2 text-sm text-red-400" v-if="errors.slug" v-text="errors.slug"></p>
          </div>

          <!-- Scheduled Date Time -->
          <div>
            <label for="scheduled_at">Scheduled Date & Time *</label>
            <input 
              id="scheduled_at" 
              type="datetime-local" 
              class="can-exp-input w-full block border border-gray-300 rounded" 
              v-model="form.scheduled_at"
            />
            <p class="mt-2 text-sm text-red-400" v-if="errors.scheduled_at" v-text="errors.scheduled_at"></p>
          </div>

          <!-- Duration -->
          <div>
            <label for="duration_minutes">Duration (minutes) *</label>
            <input 
              id="duration_minutes" 
              type="number" 
              min="15" 
              max="480"
              class="can-exp-input w-full block border border-gray-300 rounded" 
              v-model="form.duration_minutes"
            />
            <p class="mt-2 text-sm text-red-400" v-if="errors.duration_minutes" v-text="errors.duration_minutes"></p>
          </div>

          <!-- Presenter Name -->
          <div>
            <label for="presenter_name">Presenter Name</label>
            <input 
              id="presenter_name" 
              type="text" 
              class="can-exp-input w-full block border border-gray-300 rounded" 
              v-model="form.presenter_name"
            />
          </div>

          <!-- Meeting Platform -->
          <div>
            <label for="meeting_platform">Meeting Platform</label>
            <select 
              id="meeting_platform" 
              class="can-exp-input w-full block border border-gray-300 rounded" 
              v-model="form.meeting_platform"
            >
              <option value="zoom">Zoom</option>
              <option value="teams">Microsoft Teams</option>
              <option value="youtube">YouTube Live</option>
              <option value="custom">Custom</option>
            </select>
          </div>

          <!-- Meeting Link -->
          <div class="md:col-span-2">
            <label for="meeting_link">Meeting Link</label>
            <input 
              id="meeting_link" 
              type="url" 
              class="can-exp-input w-full block border border-gray-300 rounded" 
              v-model="form.meeting_link"
              placeholder="https://zoom.us/j/..."
            />
            <p class="mt-2 text-sm text-red-400" v-if="errors.meeting_link" v-text="errors.meeting_link"></p>
          </div>

          <!-- Max Attendees -->
          <div>
            <label for="max_attendees">Max Attendees (leave empty for unlimited)</label>
            <input 
              id="max_attendees" 
              type="number" 
              min="1"
              class="can-exp-input w-full block border border-gray-300 rounded" 
              v-model="form.max_attendees"
            />
          </div>

          <!-- Status -->
          <div>
            <label for="status">Status *</label>
            <select 
              id="status" 
              class="can-exp-input w-full block border border-gray-300 rounded" 
              v-model="form.status"
            >
              <option value="draft">Draft</option>
              <option value="published">Published</option>
              <option value="completed">Completed</option>
              <option value="cancelled">Cancelled</option>
            </select>
          </div>

          <!-- Webinar Type -->
          <div>
            <label for="webinar_type">Webinar Type *</label>
            <select 
              id="webinar_type" 
              class="can-exp-input w-full block border border-gray-300 rounded" 
              v-model="form.webinar_type"
            >
              <option value="live_interactive">Live Interactive (Q&A + Chat enabled)</option>
              <option value="live_viewonly">Live View-Only (No interaction)</option>
              <option value="recorded">Recorded/On-Demand</option>
            </select>
            <p class="mt-1 text-sm text-gray-500">
              <template v-if="form.webinar_type === 'live_interactive'">Attendees can ask questions and chat in real-time</template>
              <template v-else-if="form.webinar_type === 'live_viewonly'">Attendees can only watch, no interaction</template>
              <template v-else>Pre-recorded webinar available on-demand</template>
            </p>
          </div>

          <!-- Interaction Settings (shown for live_interactive) -->
          <div class="md:col-span-2 bg-gray-50 p-4 rounded-lg" v-if="form.webinar_type === 'live_interactive'">
            <h4 class="font-medium mb-3">Interaction Settings</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              <label class="flex items-center">
                <input 
                  type="checkbox" 
                  class="mr-2" 
                  v-model="form.allow_qa"
                />
                <span>Enable Q&A (questions to presenter)</span>
              </label>
              <label class="flex items-center">
                <input 
                  type="checkbox" 
                  class="mr-2" 
                  v-model="form.allow_chat"
                />
                <span>Enable Public Chat Room</span>
              </label>
              <label class="flex items-center">
                <input 
                  type="checkbox" 
                  class="mr-2" 
                  v-model="form.allow_private_messages"
                />
                <span>Enable Private Messages</span>
              </label>
            </div>
            <p class="mt-2 text-sm text-gray-500">Private messages are visible only to sender, presenter, and admin</p>
          </div>

          <!-- Description -->
          <div class="md:col-span-2">
            <label for="description">Description</label>
            <textarea 
              id="description" 
              rows="4" 
              class="can-exp-input w-full block border border-gray-300 rounded" 
              v-model="form.description"
            ></textarea>
          </div>

          <!-- Presenter Bio -->
          <div class="md:col-span-2">
            <label for="presenter_bio">Presenter Bio</label>
            <textarea 
              id="presenter_bio" 
              rows="3" 
              class="can-exp-input w-full block border border-gray-300 rounded" 
              v-model="form.presenter_bio"
            ></textarea>
          </div>

          <!-- Cover Image -->
          <div class="md:col-span-2">
            <label for="cover_image">Cover Image</label>
            <FilePond
              name="cover_image"
              class-name="my-pond"
              accepted-file-types="image/*"
              credits="false"
              labelIdle="<span class='cursor-pointer'>Drag & Drop cover image or <span class='filepond--label-action'>Browse</span></span>"
              ref="cover_image"
              v-bind:files="coverImageFiles"
              @init="handleCoverImageInit"
              @processfile="handleCoverImageProcess"
              @removefile="handleCoverImageRemoveFile"
            />
            <p class="mt-1 text-sm text-gray-500">Recommended size: 1200x630px</p>
          </div>

          <!-- Presenter Image -->
          <div class="md:col-span-2">
            <label for="presenter_image">Presenter Image</label>
            <FilePond
              name="presenter_image"
              class-name="my-pond"
              accepted-file-types="image/*"
              credits="false"
              labelIdle="<span class='cursor-pointer'>Drag & Drop presenter image or <span class='filepond--label-action'>Browse</span></span>"
              ref="presenter_image"
              v-bind:files="presenterImageFiles"
              @init="handlePresenterImageInit"
              @processfile="handlePresenterImageProcess"
              @removefile="handlePresenterImageRemoveFile"
            />
          </div>

          <!-- Recording -->
          <div class="md:col-span-2">
            <label class="flex items-center">
              <input 
                type="checkbox" 
                class="mr-2" 
                v-model="form.is_recorded"
              />
              <span>This webinar will be recorded</span>
            </label>
          </div>

          <!-- Recording URL -->
          <div class="md:col-span-2" v-if="form.is_recorded || form.webinar_type === 'recorded'">
            <label for="recording_url">Recording URL</label>
            <input 
              id="recording_url" 
              type="url" 
              class="can-exp-input w-full block border border-gray-300 rounded" 
              v-model="form.recording_url"
              placeholder="https://..."
            />
          </div>

          <!-- Embed Code -->
          <div class="md:col-span-2" v-if="form.webinar_type === 'recorded'">
            <label for="embed_code">Embed Code (optional)</label>
            <textarea 
              id="embed_code" 
              rows="3" 
              class="can-exp-input w-full block border border-gray-300 rounded font-mono text-sm" 
              v-model="form.embed_code"
              placeholder="<iframe src='...'></iframe>"
            ></textarea>
            <p class="mt-1 text-sm text-gray-500">Paste YouTube/Vimeo embed code for on-demand viewing</p>
          </div>

          <!-- Keywords -->
          <div class="md:col-span-2">
            <label for="keywords">Keywords (comma separated)</label>
            <input 
              id="keywords" 
              type="text" 
              class="can-exp-input w-full block border border-gray-300 rounded" 
              v-model="keywordsInput" 
              @blur="applyKeywords"
            />
          </div>

          <!-- Meta Title -->
          <div>
            <label for="meta_title">Meta Title</label>
            <input 
              id="meta_title" 
              type="text" 
              class="can-exp-input w-full block border border-gray-300 rounded" 
              v-model="form.meta_title"
            />
          </div>

          <!-- Meta Description -->
          <div class="md:col-span-2">
            <label for="meta_description">Meta Description</label>
            <textarea 
              id="meta_description" 
              rows="2" 
              class="can-exp-input w-full block border border-gray-300 rounded" 
              v-model="form.meta_description"
            ></textarea>
          </div>
        </div>

        <button type="submit" class="button-exp-fill" :disabled="loading">
          {{ loading ? 'Saving...' : 'Save Webinar' }}
        </button>
      </form>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "../Layouts/App.vue";
import axios from "axios";
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
  name: 'AdminWebinarsCreate',
  components: { AppLayout, FilePond },
  data() {
    return {
      loading: false,
      form: {
        title: '',
        slug: '',
        description: '',
        presenter_name: '',
        presenter_bio: '',
        presenter_image: '',
        scheduled_at: '',
        duration_minutes: 60,
        meeting_link: '',
        meeting_platform: 'zoom',
        cover_image: '',
        max_attendees: null,
        status: 'draft',
        webinar_type: 'live_interactive',
        allow_qa: true,
        allow_chat: true,
        allow_private_messages: true,
        is_recorded: false,
        recording_url: '',
        embed_code: '',
        keywords: [],
        meta_title: '',
        meta_description: '',
      },
      keywordsInput: '',
      errors: {},
      coverImageFiles: [],
      presenterImageFiles: [],
    };
  },
  computed: {
    isEdit() {
      return !!this.$route.params.id;
    },
  },
  methods: {
    generateSlug() {
      if (!this.isEdit && this.form.title) {
        this.form.slug = this.form.title
          .toLowerCase()
          .replace(/[^a-z0-9]+/g, '-')
          .replace(/(^-|-$)/g, '');
      }
    },
    applyKeywords() {
      if (!this.keywordsInput) {
        this.form.keywords = [];
        return;
      }
      this.form.keywords = this.keywordsInput
        .split(',')
        .map(s => s.trim())
        .filter(Boolean);
    },
    async loadWebinar() {
      if (!this.isEdit) return;
      
      try {
        const { data } = await axios.get(`${process.env.MIX_ADMIN_API_URL}webinars/${this.$route.params.id}`);
        const webinar = data.success ? data.data : data.data || data;
        
        this.form = {
          title: webinar.title || '',
          slug: webinar.slug || '',
          description: webinar.description || '',
          presenter_name: webinar.presenter_name || '',
          presenter_bio: webinar.presenter_bio || '',
          presenter_image: webinar.presenter_image || '',
          scheduled_at: webinar.scheduled_at ? webinar.scheduled_at.replace(' ', 'T').slice(0, 16) : '',
          duration_minutes: webinar.duration_minutes || 60,
          meeting_link: webinar.meeting_link || '',
          meeting_platform: webinar.meeting_platform || 'zoom',
          cover_image: webinar.cover_image || '',
          max_attendees: webinar.max_attendees || null,
          status: webinar.status || 'draft',
          webinar_type: webinar.webinar_type || 'live_interactive',
          allow_qa: webinar.allow_qa !== undefined ? webinar.allow_qa : true,
          allow_chat: webinar.allow_chat !== undefined ? webinar.allow_chat : true,
          allow_private_messages: webinar.allow_private_messages !== undefined ? webinar.allow_private_messages : true,
          is_recorded: webinar.is_recorded || false,
          recording_url: webinar.recording_url || '',
          embed_code: webinar.embed_code || '',
          keywords: webinar.keywords || [],
          meta_title: webinar.meta_title || '',
          meta_description: webinar.meta_description || '',
        };
        
        this.keywordsInput = (this.form.keywords || []).join(', ');
        
        // Load existing images
        if (webinar.cover_image) {
          this.coverImageFiles = [{ source: webinar.cover_image, options: { type: 'local' } }];
        }
        if (webinar.presenter_image) {
          this.presenterImageFiles = [{ source: webinar.presenter_image, options: { type: 'local' } }];
        }
      } catch (error) {
        console.error('Failed to load webinar:', error);
        this.$swal('Error', 'Failed to load webinar', 'error');
      }
    },
    async submit() {
      this.loading = true;
      this.errors = {};
      
      try {
        const payload = { ...this.form };
        if (!payload.scheduled_at) delete payload.scheduled_at;
        if (!payload.max_attendees) delete payload.max_attendees;
        
        const url = this.isEdit
          ? `${process.env.MIX_ADMIN_API_URL}webinars/${this.$route.params.id}`
          : `${process.env.MIX_ADMIN_API_URL}webinars`;
        const method = this.isEdit ? 'put' : 'post';
        
        const { data } = await axios[method](url, payload);
        
        if (data.success) {
          this.$swal('Success', data.message || `Webinar ${this.isEdit ? 'updated' : 'created'} successfully`, 'success');
          this.$router.push({ name: 'admin.webinars.index' });
        } else {
          this.$swal('Error', data.message || 'Failed to save webinar', 'error');
        }
      } catch (error) {
        if (error.response && error.response.status === 422) {
          const errs = error.response.data?.errors || {};
          this.errors = Object.fromEntries(
            Object.entries(errs).map(([k, v]) => [k, Array.isArray(v) ? v[0] : v])
          );
        } else {
          const errorMsg = error.response?.data?.message || error.message || 'Failed to save webinar';
          this.$swal('Error', errorMsg, 'error');
        }
      } finally {
        this.loading = false;
      }
    },
    handleCoverImageInit() {
      this.setupFilePond('cover');
    },
    handlePresenterImageInit() {
      this.setupFilePond('presenter');
    },
    setupFilePond(type) {
      setOptions({
        credits: false,
        server: {
          url: process.env.MIX_ADMIN_API_URL,
          process: (fieldName, file, metadata, load, error, progress, abort) => {
            const formData = new FormData();
            formData.append("media", file, file.name);
            formData.append("is_temp_media", 1);
            formData.append("type", `webinar-${type}`);

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
        },
      });
    },
    handleCoverImageProcess(error, file) {
      if (!error) this.form.cover_image = file.serverId;
    },
    handlePresenterImageProcess(error, file) {
      if (!error) this.form.presenter_image = file.serverId;
    },
    handleCoverImageRemoveFile() {
      this.form.cover_image = '';
    },
    handlePresenterImageRemoveFile() {
      this.form.presenter_image = '';
    },
  },
  mounted() {
    this.loadWebinar();
  },
};
</script>