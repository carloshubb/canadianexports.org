<template>
  <div>
    <!-- Loading State -->
    <div v-if="loading" class="text-center py-12">
      <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-primary"></div>
      <p class="mt-4 text-gray-600">Loading...</p>
    </div>

    <!-- Show edit form if only 1 sponsorship -->
    <div v-else-if="sponsorships.length === 1">
      <div class="mb-4 flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-primary mb-2">Sponsor Profile</h1>
          <p class="text-gray-600">Edit your sponsorship information</p>
        </div>
        <a
          :href="`/${becomeSponsorSlug}`"
          class="button-exp-fill"
        >
          + Add Another Sponsorship
        </a>
      </div>
      <sponsor-profile-edit :sponsorship-id="sponsorships[0].id"></sponsor-profile-edit>
    </div>

    <!-- Show list if multiple sponsorships -->
    <div v-else-if="sponsorships.length > 1">
      <sponsorships-list 
        :initial-sponsorships="sponsorships"
        :become-sponsor-slug="becomeSponsorSlug" 
        :sponsor-settings-slug="sponsorSettingsSlug"
      ></sponsorships-list>
    </div>

    <!-- No sponsorships -->
    <div v-else class="text-center py-12">
      <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
      </svg>
      <h3 class="mt-4 text-lg font-medium text-gray-900">No sponsorships yet</h3>
      <p class="mt-2 text-gray-500">Get started by creating your first sponsorship.</p>
      <div class="mt-6">
        <a
          :href="`/${becomeSponsorSlug}`"
          class="button-exp-fill"
        >
          Create Your First Sponsorship
        </a>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import helper from "../../helper";
import SponsorProfileEdit from "./SponsorProfileEdit.vue";
import SponsorshipsList from "./SponsorshipsList.vue";

export default {
  name: "SponsorManagement",
  components: {
    SponsorProfileEdit,
    SponsorshipsList,
  },
  props: {
    becomeSponsorSlug: {
      type: String,
      default: 'user/sponsor-settings/add'
    },
    sponsorSettingsSlug: {
      type: String,
      default: 'user/sponsor-settings'
    }
  },
  data() {
    return {
      sponsorships: [],
      loading: false,
    };
  },
  mounted() {
    this.fetchSponsorships();
  },
  methods: {
    async fetchSponsorships() {
      this.loading = true;
      try {
        const response = await axios.get(`${process.env.MIX_WEB_API_URL}sponsor/profile`);
        if (response.data.status === "Success") {
          this.sponsorships = response.data.data;
        } else {
          helper.swalErrorMessageForWeb("Unable to load sponsorships");
        }
      } catch (error) {
        console.error("Error fetching sponsorships:", error);
        if (error.response && error.response.status === 404) {
          // No sponsorships yet - this is OK
          this.sponsorships = [];
        } else {
          helper.swalErrorMessageForWeb("Error loading sponsorships. Please try again.");
        }
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>

