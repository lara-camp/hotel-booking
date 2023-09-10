<template>
  <div class="w-[30rem]">
    <h1 class="mb-2 text-3xl font-bold">Filters</h1>
    <div class="gap-x-2 flex mb-2">
      <div class=" flex flex-col w-full">
        <label for="checkin">Reserved From</label>
        <Calendar v-model="dialogRef.data.filterForm.from_date" :minDate="minDate" :manualInput="false" id="checkin" />
      </div>
      <div class="flex flex-col w-full">
        <label for="checkin">Reserved To</label>
        <Calendar v-model="dialogRef.data.filterForm.to_date" :minDate="minDate" :manualInput="false" id="checkout" />
      </div>
    </div>
    <div class="flex justify-end">
      <Button label="Filter" outlined @click="filterPage" />
    </div>
  </div>
</template>

<script setup>
  import Calendar from 'primevue/calendar';
  import Button from 'primevue/button';
  import { reactive, ref } from 'vue';
  import { router } from '@inertiajs/vue3';
  import { inject } from 'vue';

  const minDate = ref(new Date());
  const dialogRef = inject('dialogRef');

  function filterPage() {
    router.visit(route('reservation.index', {
      _query: {
        from_date: dialogRef.value.data.filterForm.from_date,
        to_date: dialogRef.value.data.filterForm.from_date
      }
    }))
  }
</script>