<template>
  <div class="flex">
    <div class=" flex items-baseline mr-3">
      <label for="checkin" class="mr-3">From</label>
      <Calendar v-model="filterForm.from_date" :manualInput="true" class="h-full" id="checkin" :minDate="minDate" />
    </div>
    <div class=" flex items-baseline mr-3">
      <label for="checkin" class="mr-3">To</label>
      <Calendar v-model="filterForm.to_date" :manualInput="true" class="h-full" id="checkin"
        :minDate="filterForm.from_date || null" />
    </div>
    <div class="">
      <Button label="Search" outlined @click="filterPage" />
    </div>
  </div>
</template>

<script setup>
  import { router } from '@inertiajs/vue3';
  import Button from 'primevue/button';
  import Calendar from 'primevue/calendar';
  import { reactive, ref, watchEffect } from 'vue';

  // Get Date from the query
  const searchParams = new URLSearchParams(document.location.search);

  const filterForm = reactive({
    from_date: searchParams.get("from_date") ? (new Date(searchParams.get("from_date"))) : "",
    to_date: searchParams.get("to_date") ? new Date(searchParams.get("to_date")) : ""
  })

  // Filtering Query

  const minDate = ref(new Date());
  let query = reactive({
    from_date: "",
    to_date: ""
  })
  function filterPage() {
    router.visit(route('index', {
      _query: query
    }))
  }

  // To Mutate from_date and to_date to YYYY-MM-DD format
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
