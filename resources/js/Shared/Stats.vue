<template>
  <div v-if="statsData">

    <h3 class="text-base font-semibold leading-6 text-gray-900">Last 30 days</h3>
    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
      <div v-for="item in statsData" :key="item.name" class="overflow-hidden rounded-lg px-4 py-5 shadow sm:p-6 bg-gray-50">
        <dt class="truncate text-sm font-medium text-gray-500">{{ item.name }}</dt>
        <dd class="mt-1 text-2xl font-semibold tracking-tight text-gray-900">


          <p v-if="item.id === 1 || item.id === 2 " class="ml-2 text-md font-medium text-gray-900">
            {{ item.stat }}
          </p>

          <p v-if="item.id === 3" v-for="(value, key) in item.stat" :key="key" class="ml-2 text-md font-medium text-gray-900">
            {{ value.item_name }}: {{ value.total }} units
          </p>

        </dd>
      </div>
    </dl>
  </div>
</template>

<script setup>

  defineProps({
    statsData: {
      type: Object,
      required: true,
    },
  })

</script>
