<template>
  <div class=" flex h-screen">
    <!-- Left side bar -->
    <div class="w-1/6 p-3 m-3 bg-indigo-600 rounded">
      <!-- Logo -->
      <div class=" mb-6">
        <Link class="text-5xl font-extrabold text-center text-white" href="/">Laracamp Booking</Link>
      </div>
      <!-- Options -->
      <div class="">
        <NavigationButton route-name="roomtype.index" icon="pi pi-calendar">Reservations</NavigationButton>
        <NavigationExpand>
          <template #default>
            Rooms
          </template>
          <template #contents>
            <NavigationButton icon="pi pi-user" route-name="room.index">View</NavigationButton>
            <NavigationButton icon=" pi pi-plus" route-name="room.create">Create</NavigationButton>
          </template>
        </NavigationExpand>
        <NavigationButton route-name="roomtype.index" icon="pi pi-calendar">Reservations</NavigationButton>
      </div>
    </div>
    <div class="w-5/6">
      <slot />
    </div>
  </div>
</template>
<script setup>
  import { Link, usePage } from '@inertiajs/vue3';
  import Button from 'primevue/button';
  import { computed } from 'vue';
  import { router } from '@inertiajs/vue3';
  import NavigationButton from "../Components/Dashboard/NavigationButton.vue"
  import NavigationExpand from '@/Components/Dashboard/NavigationExpand.vue';


  const user = computed(() => usePage().props.auth.user)
</script>