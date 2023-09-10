<template>
  <DataTable :value="props.reservations.data" tableStyle="min-width: 50rem" :rows="5" :rows-per-page-options="[5, 10, 15]"
    striped-rows>
    <template #header>
      <div class="align-items-center justify-content-between flex flex-wrap gap-2">
        <span class="text-900 text-2xl font-bold">Reservations</span>
      </div>
    </template>
    <Column field="id" header="id"></Column>
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
    <Column field="total_price" header="Price">
      <template #body="slotProps">
        {{ formatCurrency(slotProps.data.total_price) }}
      </template>
    </Column>
    <Column field="from_date" header="Reserved From">
      <template #body="slotProps">
        {{ getDate(slotProps.data.from_date) }}
      </template>
    </Column>
    <Column field="to_date" header="Reserved To">
      <template #body="slotProps">
        {{ getDate(slotProps.data.to_date) }}
      </template>
    </Column>
    <Column field="checkin_time" header="Checkin Time">
      <template #body="slotProps">
        {{ getDateTime(slotProps.data.checkin_time) }}
      </template>
    </Column>
    <Column field="checkout_time" header="Checkout Time">
      <template #body="slotProps">
        {{ getDateTime(slotProps.data.checkout_time) }}
      </template>
    </Column>
    <Column header="Actions">
      <template #body="slotProps">
        <Button icon="pi pi-pencil" aria-label="Submit" size="small" outlined class="mr-2"
          @click="() => router.visit(route('reservation.edit', slotProps.data.id))" />
        <Button aria-label="Delete" icon="pi pi-trash" severity="danger" size="small" outlined
          @click.prevent=" confirmDelete(slotProps.data.id)" :key="`confirmDialog${slotProps.data.id}`" />
      </template>
    </Column>
    <template #footer>
      <Paginator :rows="5" :totalRecords="props.reservations.total" :pt="{
        pageButton: ({ props, state, context }) => ({
          class: context.active ? 'bg-primary' : undefined,
          onclick: () => {
            router.visit(route('reservation.index', {
              _query: {
                page: props.page + 1
              }
            }))
          }
        })
      }" :first="props.reservations.data[0].id">
        <template #start="slotProps">
          <span>Showing {{ props.reservations.from }} to {{ props.reservations.to }} of
            {{ props.reservations.total }} reservations</span>
        </template>
      </Paginator>
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
  import Paginator from 'primevue/paginator';
  import Toast from 'primevue/toast';
  import { useConfirm } from "primevue/useconfirm";
  import { useToast } from 'primevue/usetoast';

  const props = defineProps({
    reservations: {
      required: true
    }
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
        axios.delete(route('reservation.destroy', id)).then(data => {
          toast.add({
            severity: "success",
            summary: "Deleted successfully",
            detail: `Reservation #${id} is deleted successfully`,
            life: 3000,
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