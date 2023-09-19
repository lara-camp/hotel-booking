<template>
  <div class="flex justify-start p-3">
    <div class="w-1/6 ml-6 mr-4">
      <img :src="user.profile_img" :alt="`Profile image of ${user.name}`" v-if="user.profile_img">
    </div>
    <div class="">
      <p class="text-xl font-semibold text-white">{{ user.name }}</p>
    </div>
  </div>
</template>

<script setup>
  import { computed } from "vue"
  import { usePage } from "@inertiajs/vue3"
  const user = computed(() => usePage().props.auth.user)

</script>

<style lang="scss" scoped></style>