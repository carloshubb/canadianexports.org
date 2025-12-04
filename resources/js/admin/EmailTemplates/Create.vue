<template>
  <AppLayout>
    <div class="relative shadow-md sm:rounded-lg bg-white py-4">
      <header class="pt-4">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <h1 class="can-exp-h3 mb-0 text-primary">
              {{ isEdit ? 'Edit' : 'Create' }} Email Template
            </h1>
            <router-link
              :to="{ name: 'admin.email-templates.index' }"
              class="button-exp-fill"
            >
              Back
            </router-link>
          </div>
        </div>
      </header>
      <form class="px-4 md:px-6 lg:px-8" @submit.prevent="save">
        <div class="grid my-4 grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 md:gap-6">
          <div class="relative z-0 w-full group">
            <label for="key">Key</label>
            <input
              type="text"
              name="key"
              id="key"
              class="can-exp-input w-full block border border-gray-300 rounded"
              placeholder="e.g. contact_us_admin"
              v-model.trim="form.key"
              :disabled="isEdit"
            />
            <p class="mt-2 text-sm text-gray-500">
              Use this unique key in code to load the template (lowercase with underscores)
            </p>
          </div>

          <div class="relative z-0 w-full group">
            <label for="name">Name</label>
            <input
              type="text"
              name="name"
              id="name"
              class="can-exp-input w-full block border border-gray-300 rounded"
              placeholder="Template display name"
              v-model.trim="form.name"
            />
          </div>
        </div>

        <div class="relative z-0 w-full group">
          <label for="subject">Subject</label>
          <input
            type="text"
            name="subject"
            id="subject"
            class="can-exp-input w-full block border border-gray-300 rounded"
            placeholder="Email subject (supports {{ placeholders }})"
            v-model.trim="form.subject"
          />
          <p class="mt-2 text-sm text-gray-500">
            Email subject line. You can use variables like <code>&#123;&#123; name &#125;&#125;</code>, <code>&#123;&#123; email &#125;&#125;</code>, etc.
          </p>
        </div>

        <div class="relative z-0 w-full group mt-4">
          <label for="body_html">Body (Full Blade Template Support)</label>
          <textarea
            name="body_html"
            id="body_html"
            rows="15"
            class="can-exp-input w-full block border border-gray-300 rounded font-mono text-sm"
            placeholder="Supports full Blade syntax: @component('mail::message')...@endcomponent"
            v-model="form.body_html"
            style="font-family: 'Courier New', 'Consolas', monospace; font-size: 13px;"
          ></textarea>
        </div>

        <div class="relative z-0 w-full group mt-4">
          <fieldset>
            <div class="flex items-center">
              <input
                id="is_active"
                name="is_active"
                type="checkbox"
                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                v-model="form.is_active"
              />
              <label
                for="is_active"
                class="ml-2 text-sm font-medium text-gray-900"
              >
                Active
              </label>
            </div>
            <p class="mt-1 text-sm text-gray-500">
              Inactive templates will fallback to default Blade templates
            </p>
          </fieldset>
        </div>

        <div class="flex items-center gap-4 mt-8">
          <button
            type="submit"
            class="button-exp-fill"
            :disabled="saving"
          >
            {{ saving ? 'Saving...' : 'Save Template' }}
          </button>
          <button
            type="button"
            class="button-exp-no-fill"
            @click="preview"
            :disabled="!form.body_html"
          >
            Preview
          </button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script>
import axios from 'axios';

export default {
  name: 'EmailTemplatesCreate',
  data() {
    return {
      saving: false,
      isEdit: !!this.$route.params.id,
      form: {
        key: '',
        name: '',
        subject: '',
        body_html: '',
        is_active: true,
      },
    };
  },
  mounted() {
    if (this.isEdit) {
      this.fetch();
    }
  },
  methods: {
    async fetch() {
      try {
        const { data } = await axios.get(
          `${process.env.MIX_ADMIN_API_URL}email-templates/${this.$route.params.id}`
        );
        const tpl = data.data;
        this.form = {
          key: tpl.key,
          name: tpl.name,
          subject: tpl.subject,
          body_html: tpl.body_html,
          is_active: tpl.is_active,
        };
      } catch (error) {
        window.helper.swalErrorMessage(
          error?.response?.data?.message || 'Failed to load template'
        );
        this.$router.push({ name: 'admin.email-templates.index' });
      }
    },
    async save() {
      if (!this.form.key || !this.form.name || !this.form.subject || !this.form.body_html) {
        window.helper.swalErrorMessage('Please fill in all required fields');
        return;
      }

      this.saving = true;
      try {
        if (this.isEdit) {
          await axios.put(
            `${process.env.MIX_ADMIN_API_URL}email-templates/${this.$route.params.id}`,
            this.form
          );
          window.helper.swalSuccessMessage('Template updated successfully');
        } else {
          await axios.post(`${process.env.MIX_ADMIN_API_URL}email-templates`, this.form);
          window.helper.swalSuccessMessage('Template created successfully');
        }
        this.$router.push({ name: 'admin.email-templates.index' });
      } catch (error) {
        if (error.response && error.response.status === 422) {
          const errors = error.response.data.errors;
          const firstError = Object.values(errors)[0][0];
          window.helper.swalErrorMessage(firstError || 'Validation failed');
        } else {
          window.helper.swalErrorMessage(
            error?.response?.data?.message || 'Failed to save template'
          );
        }
      } finally {
        this.saving = false;
      }
    },
    preview() {
      if (!this.form.body_html) return;
      const w = window.open('', '_blank');
      w.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
          <title>Email Preview</title>
          <style>
            body { font-family: Arial, sans-serif; padding: 20px; }
          </style>
        </head>
        <body>
          ${this.form.body_html}
        </body>
        </html>
      `);
      w.document.close();
    },
  },
};
</script>

<style scoped>
code {
  @apply bg-gray-100 px-1.5 py-0.5 rounded text-xs font-mono;
}
</style>
