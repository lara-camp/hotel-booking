<template>
  <DataTable :value="props.reservations" tableStyle="min-width: 50rem" paginator :rows="5"
    :rows-per-page-options="[5, 10, 15]">
    <template #header>
      <div class="align-items-center justify-content-between flex flex-wrap gap-2">
        <span class="text-900 text-2xl font-bold">Reservations</span>
      </div>
    </template>
    <Column field="id" header="id" sortable></Column>
    <Column field="room_id" header="Room No">
      <template #body="slotProps">
        <span v-for="(room, i) in slotProps.data.room_id" :key="`${slotProps.index}${i}`">
          <template v-if="i < slotProps.data.room_id.length - 1">
            {{ room }},
          </template>
          <template v-else>
            {{ room }}
          </template>
        </span>
      </template>
    </Column>
    <Column header="Total Person" field="total_person">
    </Column>
    <Column field="total_price" header="Price" sortable>
      <template #body="slotProps">
        {{ formatCurrency(slotProps.data.total_price) }}
      </template>
    </Column>
    <Column field="from_date" sortable header="Reserved From">
      <template #body="slotProps">
        {{ getDate(slotProps.data.from_date) }}
      </template>
    </Column>
    <Column field="to_date" sortable header="Reserved From">
      <template #body="slotProps">
        {{ getDate(slotProps.data.to_date) }}
      </template>
    </Column>
    <Column field="checkin_time" sortable header="Checkin Time">
      <template #body="slotProps">
        {{ getDateTime(slotProps.data.checkin_time) }}
      </template>
    </Column>
    <Column field="checkout_time" sortable header="Checkout Time">
      <template #body="slotProps">
        {{ getDateTime(slotProps.data.checkout_time) }}
      </template>
    </Column>
    <Column header="Actions">
      <template #body="slotProps">
        <Button icon="pi pi-pencil" aria-label="Submit" size="small" outlined class="mr-2"
          @click="() => router.visit(`/reservation/edit/${slotProps.data.id}`)" />
        <Button aria-label="Delete" icon="pi pi-trash" severity="danger" size="small" outlined
          @click.prevent=" confirmDelete(slotProps.data.id)" :key="`confirmDialog${slotProps.data.id}`" />
      </template>
    </Column>
    <template #footer> In total there are {{ props.reservations ? props.reservations.length : 0 }} reservations
    </template>
  </DataTable>
  <Toast position="bottom-right" />
  <ConfirmDialog></ConfirmDialog>
</template>

<script setup>
  import { router } from '@inertiajs/vue3';
  import axios from 'axios';
  import Button from 'primevue/button';
  import Column from 'primevue/column';
  import ConfirmDialog from 'primevue/confirmdialog';
  import DataTable from 'primevue/datatable';
  import Toast from 'primevue/toast';
  import { useConfirm } from "primevue/useconfirm";
  import { useToast } from 'primevue/usetoast';

  const props = defineProps({
    reservations: Array
  })

  // Formatting the data strings
  function formatCurrency(currency) {
    return currency.toLocaleString('en-US', { style: 'currency', currency: 'MMK' });
  }
  function getDate(date) {
    let newDate = new Date(date);
    return newDate.toLocaleDateString();
  }
  function getDateTime(date) {
    let newDate = new Date(date);
    return newDate.toLocaleString();
  }

  // Delete Confirmation And Actions
  const confirm = useConfirm();
  const toast = useToast();
  function confirmDelete(id) {
    confirm.require({
      message: `Are you sure you want to delete reservation #${id}?`,
      header: `Delete Reservation #${id}`,
      accept: () => {
        axios.delete(`/reservation/${id}`).then(data => {
          toast.add({
            severity: "success",
            summary: "Deleted successfully",
            detail: `Reservation #${id} is deleted successfully`
          })
        })
      }
    })
  }
</script>
<script>
  import IndexLayout from "../../Layouts/IndexLayout.vue";
  export default {
    layout: IndexLayout
  }
</script>