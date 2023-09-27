<template>
  <div class="w-[30rem]">
    <h1 class="mb-2 text-3xl font-bold">Filters</h1>
    <div class="gap-x-2 flex mb-2">
      <div class=" flex flex-col w-full">
        <label for="checkin">Reserved From</label>
        <Calendar v-model="filterForm.from_date" :manualInput="true" id="checkin" />
      </div>
      <div class="flex flex-col w-full">
        <label for="checkin">Reserved To</label>
        <Calendar v-model="filterForm.to_date" :manualInput="true" id="checkout" />
      </div>
    </div>
    <div class="flex justify-end">
      <Button label="Filter" outlined @click="filterPage" />
    </div>
  </div>
</template>

<script setup>
  import { router } from '@inertiajs/vue3';
  import Button from 'primevue/button';
  import Calendar from 'primevue/calendar';
  import { reactive, watchEffect } from 'vue';

  // Get Date from the query
  const searchParams = new URLSearchParams(document.location.search);

  const filterForm = reactive({
    from_date: searchParams.get("from_date") ? (new Date(searchParams.get("from_date"))) : "",
    to_date: searchParams.get("to_date") ? new Date(searchParams.get("to_date")) : ""
  })

  // Filtering Query
  let query = reactive({
    from_date: "",
    to_date: ""
  })
  function filterPage() {
    router.visit(route('admin.reservations.index', {
      _query: query
    }))
  }

  // To Mutate checkin and checkout time to YYYY-MM-DD format
  watchEffect(() => {
    let newDate = new Date(filterForm.from_date);
    let newDateString = `${newDate.getFullYear()}-${newDate.getMonth() + 1 < 10 ? "0" + (newDate.getMonth() + 1) : newDate.getMonth() + 1}-${newDate.getDate() < 10 ? "0" : ""}${newDate.getDate()}`
    query.from_date = filterForm.from_date ? newDateString : null;
  })
  watchEffect(() => {
    let newDate = new Date(filterForm.to_date);
    let newDateString = `${newDate.getFullYear()}-${newDate.getMonth() + 1 < 10 ? "0" + (newDate.getMonth() + 1) : newDate.getMonth() + 1}-${newDate.getDate() < 10 ? "0" : ""}${newDate.getDate()}`
    query.to_date = filterForm.to_date ? newDateString : null;
  })
</script>
