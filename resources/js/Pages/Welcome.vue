<script setup>
  import SearchRooms from "@/Components/Welcome/SearchRooms.vue";
  import WelcomeFiler from "@/Components/Welcome/WelcomeFilter.vue";
  import { Head } from '@inertiajs/vue3';

  defineProps({
    errors: Object,
    roomTypes: Object,
    popularRoomTypes: Object,
    searchRooms: {
      required: false
    }
  });

  const searchParams = new URLSearchParams(document.location.search);

</script>
<template>
  <Head title="Welcome" />
  <div class="bg-slate-100 p-3 rounded">
    <div class="md:max-w-[75rem] max-w-2xl flex-col min-h-[80vh] items-center justify-center mx-auto py-24  px-3">
      <div class="mb-20">
        <h1 class=" mb-3 text-6xl font-bold">Welcome to <span class="text-6xl font-extrabold text-indigo-600">Laracamp
            Hotel</span></h1>
        <h2 class="text-3xl font-normal">We offer the world-class hospitality with luxury experience.</h2>
      </div>
      <WelcomeFiler :room-types="roomTypes"/>
      <SearchRooms :search-rooms="searchRooms" :errors="errors" v-if="searchRooms && searchRooms.length !== 0" />
      <h1 class="my-16 text-2xl font-semibold text-center"
        v-else-if="searchParams.get('to_date') || searchParams.get('from_date')">No room is found</h1>
    </div>
  </div>
</template>
<script>
  import IndexLayout from '@/Layouts/IndexLayout.vue';

  export default {
    layout: IndexLayout
  }
</script>
