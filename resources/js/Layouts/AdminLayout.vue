<template>
  <div class=" flex">
    <!-- Left side bar -->
    <div class=" xl:block xl:w-1/6 sticky top-3 left-3 hidden h-[97vh] m-3 p-3 bg-indigo-600 rounded">
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
          <NavigationButton url="/room-type" icon="pi pi-bars">Room Type</NavigationButton>
          <NavigationButton url="/profile" icon="pi pi-user">Profile</NavigationButton>
        </div>
        <div class="">
          <UserSection />
        </div>
      </div>
    </div>
    <!-- Left side bar for small -->
    <div class="xl:hidden block w-1/12 p-3 bg-indigo-600 rounded h-[97vh] m-3 sticky top-3 left-3">
      <div class="h-1/6">
        <Link class="block w-full text-5xl font-extrabold text-center text-white transition-colors duration-300" href="/">
        LB
        </Link>
      </div>
      <div class="h-5/6 flex flex-col justify-between">
        <div class="">
          <NavigationButton url="/reservation" icon="pi pi-calendar" title="Reservation">Reservation
          </NavigationButton>
          <NavigationButton url="/room" icon="pi pi-home" title="Room">Room</NavigationButton>
          <NavigationButton url="/profile" icon="pi pi-user" title="Profile">Profile</NavigationButton>
        </div>
      </div>
    </div>
    <div class="xl:w-5/6 w-11/12 p-3 overflow-auto">
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