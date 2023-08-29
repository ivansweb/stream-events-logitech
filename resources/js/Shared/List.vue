<template>
  <div>
    <ul role="list" class="divide-y divide-gray-100">
      <li v-for="(event, index) in eventsData" :key="index" class="flex justify-between gap-x-6 py-5">
        <div class="flex min-w-0 gap-x-4">
          <div class="min-w-0 flex-auto">
            <p class="text-md font-semibold leading-6 text-gray-900">
              {{ event.message }}
            </p>
          </div>
        </div>
        <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
          <button type="button"
                  class="rounded bg-indigo-50 px-2 py-1 text-xs font-semibold text-indigo-600 shadow-sm hover:bg-indigo-100">
            <span v-if="event.read">
              Mark as unread
            </span>
            <span v-else>
              Mark as read
            </span>

          </button>
          <div class="mt-1 flex items-center gap-x-1.5">
            <div v-show="!event.read" class="flex-none rounded-full bg-emerald-500/20 p-1">
              <div class="h-1.5 w-1.5 rounded-full bg-emerald-500" />
            </div>
            <div v-show="event.read" class="flex-none rounded-full bg-red-500/20 p-1">
              <div class="h-1.5 w-1.5 rounded-full bg-red-500" />
            </div>
            <p class="text-xs leading-5 text-gray-500">Unread</p>
          </div>
        </div>
      </li>
    </ul>
  </div>

</template>

<script setup>

defineProps({
  eventsData: {
    type: Object,
    required: true,
  },
})

</script>