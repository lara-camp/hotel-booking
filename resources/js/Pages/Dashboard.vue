<template>
  <Head title="Dashboard" />
  <h1 class="text-900 mb-6 text-5xl font-bold">Dashboard</h1>
  <div class="max-w-7xl">
    <div class="mb-9 flex flex-wrap w-full gap-3">
      <div
        class="bg-slate-100/80 hover:bg-slate-200/80 lg:w-1/3 flex-1 w-1/2 p-3 transition-colors duration-300 rounded shadow">
        <h1 class="mb-3 text-2xl font-bold text-center">Total Guest This Month</h1>
        <h2 class="text-5xl font-semibold text-center text-indigo-500">
          {{ Number(monthlyGuests).toLocaleString("en") }}
        </h2>
      </div>
      <div
        class="bg-slate-100/80 hover:bg-slate-200/80 lg:w-1/3 flex-1 w-1/2 p-3 transition-colors duration-300 rounded shadow">
        <h1 class="mb-3 text-2xl font-bold text-center">Total Number Of Rooms</h1>
        <h2 class="text-5xl font-semibold text-center text-indigo-500">
          {{ totalRooms }}
        </h2>
      </div>
      <div
        class="bg-slate-100/80 hover:bg-slate-200/80 lg:w-1/3 lg:flex-1 w-full p-3 transition-colors duration-300 rounded shadow">
        <h1 class="mb-3 text-2xl font-bold text-center">Total Earned This Month</h1>
        <h2 class="text-5xl font-semibold text-center text-indigo-500">
          {{ Number(monthlyAmount).toLocaleString('en', { currency: "MMK" }) }} MMK
        </h2>
      </div>
    </div>
    <div class="flex flex-wrap w-full gap-3">
      <AvailableRoomType :available-room-types="todayAvailableRoomTypes"
        class=" md:w-1/3 bg-slate-100/80 hover:bg-slate-200/80 flex-1 w-full p-3 transition-colors duration-300 rounded shadow" />
      <AvailableRoom
        :available-rooms="{ 'Available Rooms': props.todayAvailableRooms?.length, 'Reserved Rooms': props.todayReservedRooms?.length }"
        class="md:w-1/3 bg-slate-100/80 hover:bg-slate-200/80 flex-1 w-full p-3 transition-colors duration-300 rounded shadow" />
      <ReservationByRole
        class="md:w-1/3 bg-slate-100/80 hover:bg-slate-200/80 flex-1 w-full p-3 transition-colors duration-300 rounded shadow"
        :reservation-by-role="{ 'User': props.userReservedReservations, 'Admin': props.adminReservedReservations }" />
      <PopularRoomType :popular-room-types="monthlyPopularRoomTypes"
        class="bg-slate-100/80 hover:bg-slate-200/80 w-full p-3 transition-colors duration-300 rounded shadow" />
    </div>
  </div>
</template>
<script setup>
  import AvailableRoom from '@/Components/Dashboard/AvailableRoom.vue';
  import AvailableRoomType from '@/Components/Dashboard/AvailableRoomType.vue';
  import PopularRoomType from '@/Components/Dashboard/PopularRoomType.vue';
  import ReservationByRole from '@/Components/Dashboard/ReservationByRole.vue';
  import { Head } from '@inertiajs/vue3';

  const props = defineProps({
    todayAvailableRoomTypes: Object,
    todayAvailableRooms: Array,
    todayReservedRooms: Array,
    monthlyPopularRoomTypes: Object,
    monthlyGuests: String,
    monthlyAmount: String,
    totalRooms: Number,
    adminReservedReservations: Number,
    userReservedReservations: Number
  })

</script>
<script>
  import AdminLayout from "@/Layouts/AdminLayout.vue";
  export default {
    layout: AdminLayout
  }
</script>
