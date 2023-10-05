<template>
  <div class="">
    <header class="drop-shadow-xl sticky inset-0 top-0 z-20 px-3 m-3 bg-indigo-600 rounded" v-memo="[user]">
      <div class="flex max-w-2xl md:max-w-[75rem] items-center justify-between px-3 min-h-[4rem] mx-auto">
        <Link href="/" class="block">
        <h1 class="text-3xl font-extrabold text-white">Laracamp Booking</h1>
        </Link>
        <div class="flex items-center justify-end w-auto">
          <div class="mr-3">

          </div>
          <div class="flex items-center w-full h-full p-3 mr-3 transition-colors duration-300 rounded cursor-pointer" v-if="user">
            <div class="w-10 h-10 ml-6 mr-4">
              <img :src="user.profile_image_path" class="object-cover w-full h-full rounded-full"
                :alt="`Profile image of ${user.name}`" v-if="user.profile_image_path">
            </div>
            <Link :href="user.role_id === 1 ? route('admin.profile.edit') : route('user.profile')">
            <span class="text-lg font-bold text-white">{{ user.name }}</span>
            </Link>
          </div>
          <div class="mx-3" v-else>
            <LayoutButton @click="router.visit('/login')" class="mr-3">Login</LayoutButton>
            <LayoutButton @click="router.visit('/register')">Register</LayoutButton>
          </div>
        </div>
      </div>
    </header>
    <div class="px-3 rounded">
      <slot />
    </div>

  </div>
</template>
<script setup>
  import LayoutButton from '@/Components/IndexLayout.vue/LayoutButton.vue';
  import { Link, router, usePage } from '@inertiajs/vue3';
  import Button from 'primevue/button';
  import { computed } from 'vue';

  const user = computed(() => usePage().props.auth.user)
</script>
