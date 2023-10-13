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
    popularRoomTypes: Object,
    searchRooms: {
      required: false
    }
  });
</script>
<template>
  <Head title="Welcome" />
  <div class="bg-slate-100 p-3 rounded">
    <div class="md:max-w-[75rem] max-w-2xl flex-col min-h-[80vh] items-center justify-center mx-auto py-24  px-3">
      <div class="mb-20">
        <h1 class=" mb-3 text-6xl font-bold">Welcome to <span class="text-6xl font-extrabold text-indigo-600">Laracamp Hotel</span></h1>
        <h2 class="text-3xl font-normal">We offer the world-class hospitality with luxury experience.</h2>
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
