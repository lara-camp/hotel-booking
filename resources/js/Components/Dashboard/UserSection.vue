<template>
  <div class="hover:bg-white group flex items-center justify-start p-3 transition-colors duration-300 rounded cursor-pointer"
    @click="() => router.visit(route('admin.profile.edit'))">
    <div class="w-12 h-12 ml-6 mr-4">
      <img :src="user.profile_image_path" class="object-cover w-full h-full rounded-full"
        :alt="`Profile image of ${user.name}`" v-if="user.profile_image_path">
      <span class="pi pi-user text-white" v-else></span>
    </div>
    <div class="h-10 leading-10 text-center">
      <p class="group-hover:text-indigo-700 text-xl font-semibold text-white">{{ user.name }}</p>
    </div>
  </div>
</template>

<script setup>
  import { computed } from "vue"
  import { router, usePage } from "@inertiajs/vue3"
  const user = computed(() => usePage().props.auth.user)

</script>

<style lang="scss" scoped></style>