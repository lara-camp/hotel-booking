<script setup>
  import WelcomeFiler from "@/Components/Welcome/WelcomeFilter.vue";
  import { Head } from '@inertiajs/vue3';

  defineProps({
    canLogin: {
      type: Boolean,
    },
    canRegister: {
      type: Boolean,
    },
    errors: Object,
    popularRoomTypes: Array,
    searchRooms: {
      required: false
    }
  });
</script>
<template>
  <Head title="Welcome" />
  <div class="bg-slate-100 p-3 rounded">
    <div class="md:max-w-[75rem] max-w-2xl flex-col items-center justify-center mx-auto p-3">
      <div class="my-24">
        <h1 class=" mb-3 text-6xl font-bold">Welcome to Laracamp Hotel</h1>
        <h2 class="text-4xl font-normal">Reserve your room</h2>
      </div>
      <WelcomeFiler />
      <SearchRooms :search-rooms="searchRooms" :errors="errors" v-if="searchRooms"/>
    </div>
  </div>
</template>
<script>
  import IndexLayout from '@/Layouts/IndexLayout.vue';
  import SearchRooms from "@/Components/Welcome/SearchRooms.vue";

  export default {
    layout: IndexLayout
  }
</script>
