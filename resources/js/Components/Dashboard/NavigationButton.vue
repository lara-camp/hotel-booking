<template>
  <Link :href="route(routeName)">
  <div
    class=" hover:text-indigo-600 hover:bg-white p-3 mb-2 text-white transition-colors duration-300 rounded cursor-pointer">
    <div class="flex items-baseline justify-start">
      <div class="w-1/6 ml-6 mr-4">
        <span :class="[icon]"></span>
      </div>
      <p class=" text-xl font-semibold">
        <slot />
      </p>
    </div>
  </div>
  </Link>
</template>
<script setup>
  import { Link } from "@inertiajs/vue3";
  import { defineProps } from "vue";
  const props = defineProps({
    icon: String,
    routeName: String
  })
</script>
