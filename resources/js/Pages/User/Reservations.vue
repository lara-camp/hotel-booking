<template>
  <div class="md:max-w-[75rem] max-w-2xl flex-col items-center justify-center mx-auto min-h-[10rem] px-3">
    <div class="flex justify-between mb-3">
      <h1 class=" text-5xl font-bold text-indigo-600">My Recent Reservations</h1>
      <Link href="/">
      <Button label="Back" outlined />
      </Link>
    </div>
    <div class="">
      <DataTable :value="mutatedReservations" tableStyle="min-width: 50rem">
        <template #empty>
          <h1 class="text-lg font-semibold text-center">You haven't reserved a room yet.</h1>
        </template>
        <Column field="guest_name" header="Guest Name"></Column>
        <Column field="total_person" header="Total Person"></Column>
        <Column field="total_price" header="Total Price"></Column>
        <Column field="from_date" header="Reserved From"></Column>
        <Column field="to_date" header="Reserved To"></Column>
        <Column field="checkin_time" header="Check In"></Column>
        <Column field="checkout_time" header="Check Out"></Column>
        <Column field="created_at" header="Created Date"></Column>
      </DataTable>
    </div>
  </div>
</template>

<script setup>
  import LayoutButton from '@/Components/IndexLayout.vue/LayoutButton.vue';
  import Button from 'primevue/button';
  import Column from 'primevue/column';
  import DataTable from 'primevue/datatable';
  import { computed } from 'vue';
  const props = defineProps({
    reservations: Array
  })
  const mutatedReservations = computed(function () {
    return props.reservations.map((item) => {
      return {
        ...item,
        checkin_time: item.checkin_time ? (new Date(item.checkin_time)).toLocaleString("en") : "-",
        checkout_time: item.checkout_time ? (new Date(item.checkout_time)).toLocaleString("en") : "-",
        created_at: (new Date(item.created_at)).toLocaleString("en")
      }
    })
  })
</script>
<script>
  import IndexLayout from '@/Layouts/IndexLayout.vue';
  import { Link } from '@inertiajs/vue3';

  export default {
    layout: IndexLayout
  }
</script>
