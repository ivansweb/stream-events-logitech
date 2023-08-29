<template>

  <Stats :statsData="stats.data" />

  <div class="mx-auto mt-4 grid max-w-2xl grid-cols-1 grid-rows-1 items-start gap-x-8 gap-y-8 lg:mx-0 lg:max-w-none lg:grid-cols-3">

    <div class="lg:col-start-3 lg:row-end-1 bg-gray-50">
      <!--  TODO: revenue summary   -->
    </div>

    <div v-if="events.data" class="-mx-4  shadow-lg bg-gray-50 ring-1 ring-gray-500/5 sm:mx-0 sm:rounded-lg sm:px-8 sm:pb-14 lg:col-span-2 lg:row-span-2 lg:row-end-2 xl:px-16 xl:pb-20 xl:pt-16">
      <div class="border-b border-gray-200 bg-gray-50 px-4 py-5 sm:px-6">
        <h3 class="text-base font-semibold leading-6 text-gray-900">Events</h3>
      </div>
      <List :eventsData="events.data" :markAs="markAs" />
    </div>

  </div>

</template>

<script>
import api from '../Services/api.js';
import Stats from '../Shared/Stats.vue';
import List from '../Shared/List.vue';

export default {
  name: 'DashboardPage',

  components: {
    Stats, List
  },

  data() {
    return {
      userId: null,
      loadingButton: false,
      stats: {
        loading: false,
        error: null,
        data: null,
      },
      events: {
        loading: false,
        error: null,
        data: null,
      },
    }
  },

  async created() {
    this.userId = localStorage.getItem('userId');
    await this.getStats();
    await this.getEvents();
  },

  methods: {

      async getStats() {
        try {
          this.stats.loading = true;
          this.stats.data = await api.getStats(this.userId);
        } catch (error) {
          console.error(error);
          this.stats.error = error;
        } finally {
          this.stats.loading = false;
        }
      },

    async getEvents() {
      try {
        this.events.loading = true;
        this.events.data = await api.getEvents(this.userId);
      } catch (error) {
        console.error(error);
        this.events.error = error;
      } finally {
        this.events.loading = false;
      }
    },

    async markAs(eventId, read) {
      try {
        this.loadingButton = true;
        this.events.data = await api.markAs(eventId, read, this.events.data);
      } catch (error) {
        console.error(error);
        this.events.error = error;
      } finally {
        this.loadingButton = false;
      }
    },
  },
}

</script>
