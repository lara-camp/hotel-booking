<template>
  <div class="">
    <header class="drop-shadow-xl sticky inset-0 z-20 bg-white" v-memo="[user]">
      <div class="flex max-w-2xl md:max-w-[75rem] items-center justify-between px-3 h-16 mx-auto ">
        <Link href="/" class="block">
        <h1 class=" dark:text-indigo-500 text-3xl font-extrabold text-indigo-800">Lalable</h1>
        </Link>
        <div class="flex items-center justify-end w-auto">
          <div class="mr-3">

          </div>
          <div class="mr-3" v-if="user">
            <span class="font-bold">{{ user.name }}</span>
          </div>
          <div class="mx-3" v-else>
            <Button @click="router.visit('/login')" outlined label="Login" class="mr-2" />
            <Button @click="router.visit('/register')" outlined label="Register" />
          </div>
        </div>
      </div>
    </header>
    <div class="p-3">
      <slot />
    </div>

  </div>
</template>
<script setup>
  import { Link, router, usePage } from '@inertiajs/vue3';
  import Button from 'primevue/button';
  import { computed } from 'vue';


  const user = computed(() => usePage().props.auth.user)
</script>