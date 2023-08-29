<template>

  <Stats :statsData="stats.data" />
  <pre>
    {{ stats }}
  </pre>

  <div class="mx-auto mt-4 grid max-w-2xl grid-cols-1 grid-rows-1 items-start gap-x-8 gap-y-8 lg:mx-0 lg:max-w-none lg:grid-cols-3">

    <div class="lg:col-start-3 lg:row-end-1">

    </div>

    <div class="-mx-4 px-4 py-8 shadow-lg bg-white ring-1 ring-gray-500/5 sm:mx-0 sm:rounded-lg sm:px-8 sm:pb-14 lg:col-span-2 lg:row-span-2 lg:row-end-2 xl:px-16 xl:pb-20 xl:pt-16">

    </div>

  </div>

</template>

<script>
import api from '../Services/api.js';
import Stats from '../Shared/Stats.vue';

export default {
  name: 'DashboardPage',

  components: {
    Stats
  },

  data() {
    return {
      userId: null,
      stats: {
        loading: false,
        error: null,
        data: null,
      },
    }
  },

  async created() {
    this.userId = localStorage.getItem('userId');
    await this.getStats();
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
  },
}

</script>
