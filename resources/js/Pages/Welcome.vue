<script setup>
  import WelcomeFiler from "@/Components/Welcome/WelcomeFilter.vue";
  import { Head, router } from '@inertiajs/vue3';
  import { reactive, ref } from 'vue';

  defineProps({
    canLogin: {
      type: Boolean,
    },
    canRegister: {
      type: Boolean,
    },
  });
</script>
<template>
  <Head title="Welcome" />
  <div class="h-[1000rem]  bg-slate-100 rounded p-3">
    <div class="md:max-w-[75rem] max-w-2xl flex-col items-center justify-center mx-auto p-3">
      <div class="my-16">
        <h1 class=" mb-3 text-6xl font-bold">Welcome to Laracamp Hotel</h1>
        <h2 class="text-4xl font-normal">Reserve your room</h2>
      </div>
      <WelcomeFiler />
      <div class="h-96 w-full"></div>
    </div>
  </div>
</template>
<script>
  import IndexLayout from '@/Layouts/IndexLayout.vue';

  export default {
    layout: IndexLayout
  }
</script>
