<template>
  <Head :title="`${status} : ${title}`"></Head>
  <div
    class="md:w-1/3 ring-2 flex flex-col justify-center self-center w-full min-h-[10rem] p-3 mx-3 bg-white rounded shadow-xl leading-[10rem]">
    <h1 class=" text-9xl font-extrabold text-center text-red-600">
      {{ status }}
    </h1>
    <h1 class="text-3xl font-semibold text-center text-red-600">{{ title }}</h1>
  </div>
</template>

<script setup>
  import { Head } from "@inertiajs/vue3";
  import { computed } from 'vue';

  const props = defineProps({
    status: Number
  })
  const title = computed(() => {
    return { 503: 'Service Error', 404: "The Thing You Are Looking For Is Not Found.", 403: "Error" }[props.status] || "Something Went Wrong"
  })
</script>
<script>
  import ErrorLayout from '@/Layouts/ErrorLayout.vue';
  export default {
    layout: ErrorLayout
  }
</script>
<style lang="scss" scoped></style>