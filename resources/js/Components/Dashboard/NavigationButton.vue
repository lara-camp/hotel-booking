<template>
  <Link :href="url" :preserve-state="false">
  <!-- Button for large Device -->
  <div class=" hover:text-indigo-600 hover:bg-white xl:block hidden p-3 mb-2 transition duration-300 cursor-pointer"
    :class="{ 'text-indigo-600 bg-white -mr-3 rounded-l': isCurrentRoute, 'text-white rounded': !isCurrentRoute }">
    <div class="flex items-baseline justify-start">
      <div class="w-1/6 ml-6 mr-4">
        <span :class="[icon]"></span>
      </div>
      <p class=" text-xl font-semibold">
        <slot />
      </p>
    </div>
  </div>
  <!-- Button for small Device -->
  <div
    class="xl:hidden hover:bg-white hover:text-indigo-600 md:px-3 md:py-5 flex items-baseline justify-center px-2 py-4 mb-2 transition-all duration-300 cursor-pointer"
    :class="{ 'text-indigo-600 bg-white -mr-3 rounded-l justify-start': isCurrentRoute, 'text-white rounded': !isCurrentRoute }"
    :title="title">
    <span :class="[icon]"></span>
  </div>
  </Link>
</template>
<script setup>
  import { Link, usePage } from "@inertiajs/vue3";
  import { computed, defineProps } from "vue";
  const props = defineProps({
    icon: String,
    url: String,
    title: {
      required: false,
      default: "title"
    }
  })
  const page = usePage();
  const isCurrentRoute = computed(() => page.url.split("?")[0] === props.url);
</script>
