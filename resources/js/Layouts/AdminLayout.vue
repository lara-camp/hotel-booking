<template>
  <div class=" flex h-screen">
    <!-- Left side bar -->
    <div class=" w-1/6 p-3 m-3 bg-indigo-600 rounded">
      <!-- Logo -->
      <div class=" h-1/6">
        <Link class=" text-5xl font-extrabold text-center text-white transition-colors duration-300" href="/">Laracamp
        Booking</Link>
      </div>
      <!-- Options -->
      <div class="h-5/6 flex flex-col justify-between">
        <div class="">
          <NavigationButton url="/reservation" icon="pi pi-calendar">Reservation</NavigationButton>
          <NavigationButton url="/room" icon="pi pi-home">Room</NavigationButton>
          <NavigationExpand>
            <template #default>
              Rooms
            </template>
            <template #contents>
              <NavigationButton icon="pi pi-home" url="/room">View</NavigationButton>
              <NavigationButton icon=" pi pi-plus" url="/room/create">Create</NavigationButton>
            </template>
          </NavigationExpand>
          <NavigationButton url="/reservation" icon="pi pi-calendar">Reservation</NavigationButton>
          <NavigationButton url="/room-type" icon="pi pi-bars">Room Type</NavigationButton>
          <NavigationButton url="/profile" icon="pi pi-user">Profile</NavigationButton>
        </div>
        <div class="">
          <UserSection />
        </div>
      </div>
    </div>
    <div class="w-5/6 overflow-auto">
      <slot />
    </div>
  </div>
</template>
<script setup>
  import NavigationExpand from '@/Components/Dashboard/NavigationExpand.vue';
  import UserSection from '@/Components/Dashboard/UserSection.vue';
  import { Link, usePage } from '@inertiajs/vue3';
  import { computed } from 'vue';
  import NavigationButton from "../Components/Dashboard/NavigationButton.vue";


  const user = computed(() => usePage().props.auth.user)
</script>