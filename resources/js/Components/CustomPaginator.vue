<template>
  <div class="gap-x-3 flex">
    <Button icon="pi pi-angle-left" aria-label="Submit" outlined @click="() => goToPage(currentPage - 1)"
      :disabled="currentPage <= 1" />
    <Button :label="`${currentPage}/${totalPages}`" aria-label="Submit" outlined class="p-0 cursor-not-allowed" />
    <Button icon="pi pi-angle-right" aria-label="Submit" outlined @click="() => goToPage(currentPage + 1)"
      :disabled="currentPage >= totalPages" />
  </div>
</template>
<script setup>
  import { router } from '@inertiajs/vue3';
  import Button from 'primevue/button';

  const props = defineProps({
    totalPages: Number,
    currentPage: Number,
    routeName: String
  })

  function goToPage(pageNumber) {
    const searchParams = new URLSearchParams(document.location.search);
    if (pageNumber >= 1 && pageNumber <= props.totalPages) {
      router.visit(route(props.routeName, {
        _query: {
          from_date: searchParams.get("from_date"),
          to_date: searchParams.get("to_date"),
          page: pageNumber
        }
      }))
    }
  }
</script>