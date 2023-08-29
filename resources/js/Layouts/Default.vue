<template>
  <header class="absolute inset-x-0 top-0 z-50 flex h-16 border-b border-gray-900/10">
    <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
      <div class="flex flex-1 items-center gap-x-6">
        <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company" />
      </div>
    </div>
  </header>

  <main>

    <header class="relative isolate pt-16">
      <div class="absolute inset-0 -z-10 overflow-hidden" aria-hidden="true">
        <div class="absolute left-16 top-full -mt-16 transform-gpu opacity-50 blur-3xl xl:left-1/2 xl:-ml-80">
          <div class="aspect-[1154/678] w-[72.125rem] bg-gradient-to-br from-[#FF80B5] to-[#9089FC]" style="clip-path: polygon(100% 38.5%, 82.6% 100%, 60.2% 37.7%, 52.4% 32.1%, 47.5% 41.8%, 45.2% 65.6%, 27.5% 23.4%, 0.1% 35.3%, 17.9% 0%, 27.7% 23.4%, 76.2% 2.5%, 74.2% 56%, 100% 38.5%)" />
        </div>
        <div class="absolute inset-x-0 bottom-0 h-px bg-gray-900/5" />
      </div>

      <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mx-auto flex max-w-2xl items-center justify-between gap-x-8 lg:mx-0 lg:max-w-none">
          Welcome, {{ userName }}!

          <div class="flex items-center gap-x-6">
            <button @click="fillData" class="text-sm font-medium text-gray-900 hover:text-gray-700">Fill Data</button>
            <button @click="logout" class="text-sm font-medium text-gray-900 hover:text-gray-700">Log out</button>
          </div>
        </div>
      </div>
    </header>

    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
      <slot />
    </div>
  </main>
</template>


<script>
import api from '../Services/api.js'

export default {
  name: 'DashboardPage',

  props: {
    user: Object,
  },

  data() {
    return {
      userName: null,
      userId: null
    }
  },

  beforeMount() {
    this.verifyLogin();
    this.getUserData();
  },

  methods: {
    verifyLogin() {
      return api.verifyLogin();
    },

    getUserData() {
      const res = api.getUserData();
      this.userName = res.userName;
      this.userId = res.userId;
    },

    logout() {
      api.logout();
    },

    fillData() {
      api.fillData();
    },
  },
}

</script>
