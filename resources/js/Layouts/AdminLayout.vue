<template>
  <div class=" flex">
    <!-- Left side bar -->
    <div class=" xl:block xl:w-1/6 sticky top-3 left-3 hidden h-[97vh] m-3 p-3 bg-indigo-600 rounded">
      <!-- Logo -->
      <div class=" h-1/6">
        <Link class=" text-5xl font-extrabold text-center text-white transition-colors duration-300" :href="route('admin.index')">Laracamp
        Booking</Link>
      </div>
      <!-- Options -->
      <div class="h-5/6 flex flex-col justify-between">
        <div class="">
          <NavigationButton url="/admin" icon="pi pi-home">Home</NavigationButton>
          <NavigationButton url="/admin/reservations" icon="pi pi-calendar">Reservations</NavigationButton>
          <NavigationButton url="/admin/rooms" icon="pi pi-inbox">Rooms</NavigationButton>
          <NavigationButton url="/admin/room-types" icon="pi pi-bars">Room Types</NavigationButton>
          <NavigationExpand>
            <template #default>
              Profile
            </template>
            <template #contents>
              <NavigationButton icon="pi pi-user" url="/admin/profile">View</NavigationButton>
              <div
                class="hover:text-indigo-600 hover:bg-white xl:block hidden p-3 mb-2 text-white transition duration-300 rounded cursor-pointer"
                @click="confirmLogout">
                <div class="flex items-baseline justify-start">
                  <div class="w-1/6 ml-6 mr-4">
                    <span class="pi pi-sign-out"></span>
                  </div>
                  <p class="text-xl font-semibold">
                    Logout
                  </p>
                </div>
              </div>
              <div
                class="xl:hidden hover:bg-white hover:text-indigo-600 flex items-baseline justify-center px-3 py-4 mb-2 transition-all duration-300 cursor-pointer">
                <span class="pi pi-sign-out"></span>
              </div>
            </template>
          </NavigationExpand>
        </div>
        <div class="">
          <UserSection />
        </div>
      </div>
    </div>
    <!-- Left side bar for small -->
    <div class="xl:hidden block w-1/12 p-3 bg-indigo-600 rounded h-[97vh] m-3 sticky top-3 left-3">
      <div class="h-1/6">
        <Link class="block w-full text-5xl font-extrabold text-center text-white transition-colors duration-300" :href="route('admin.index')">
        LB
        </Link>
      </div>
      <div class="h-5/6 flex flex-col justify-between">
        <div class="">
          <NavigationButton url="/admin" icon="pi pi-home">Home</NavigationButton>
          <NavigationButton url="/admin/reservations" icon="pi pi-calendar" title="Reservation">
            Reservation
          </NavigationButton>
          <NavigationButton url="/admin/rooms" icon="pi pi-inbox" title="Room">Room</NavigationButton>
          <NavigationButton url="/admin/room-types" icon="pi pi-bars">Room Types</NavigationButton>
          <NavigationButton url="/admin/profile" icon="pi pi-user" title="Profile">Profile</NavigationButton>
        </div>
        <div class="hover:bg-white md:p-3 transition-colors duration-300 rounded cursor-pointer" @click="()=>router.visit(route('admin.profile.edit'))">
          <div class="">
            <img :src="user.profile_image_path" class="object-cover w-full h-full rounded-full" alt="">
          </div>
        </div>
      </div>
    </div>
    <div class="xl:w-5/6 w-11/12 p-3 m-3 overflow-auto">
      <slot />
    </div>
  </div>
  <ConfirmDialog />
</template>
<script setup>
  import NavigationExpand from '@/Components/Dashboard/NavigationExpand.vue';
  import UserSection from '@/Components/Dashboard/UserSection.vue';
  import { Link, router, usePage } from '@inertiajs/vue3';
  import ConfirmDialog from 'primevue/confirmdialog';
  import { useConfirm } from 'primevue/useconfirm';
  import { computed } from 'vue';
  import NavigationButton from "../Components/Dashboard/NavigationButton.vue";

  const user = computed(() => usePage().props.auth.user)

  const confirm = useConfirm();
  function confirmLogout() {
    confirm.require({
      icon: 'pi pi-info-circle',
      acceptClass: 'p-button-danger',
      message: 'Are you sure you want to logout?',
      icon: 'pi pi-exclamation-triangle',
      accept: () => {
        router.post(route('logout'));
      },
    });
  };
</script>
