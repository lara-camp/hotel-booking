<template>
  <Link :href="url" :preserve-state="false">
  <div class=" hover:text-indigo-600 hover:bg-white p-3 mb-2 transition-colors duration-300 cursor-pointer"
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
  </Link>
</template>
<script setup>
  import { Link, usePage } from "@inertiajs/vue3";
  import { computed, defineProps } from "vue";
  const props = defineProps({
    icon: String,
    url: String
  })
  const page = usePage();
  const isCurrentRoute = computed(() => page.url === props.url);
</script>
