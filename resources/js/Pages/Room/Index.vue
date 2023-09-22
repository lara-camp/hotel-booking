<template>
  <DataTable :value="rooms.data" class="bg-slate-100/80" tableStyle="min-width: 50rem" striped-rows :pt="{
    header: (options) => ({
      class: [
        '!py-3 !px-0'
      ]
    })
  }">
    <template #header>
      <div class="flex justify-between gap-2 mb-3">
        <div class="">
          <span class="text-900 text-5xl font-bold">Rooms</span>
        </div>
        <Button label="Create" icon="pi pi-plus" outlined @click="() => router.visit(route('room.create'))" />
      </div>
    </template>
    <Column field="id" header="Id"></Column>
    <Column field="room_number" header="Room Number"></Column>
    <Column field="roomtype.name" header="Room Type"></Column>
    <Column field="bed_type" header="Bed type"></Column>
    <Column field="number_of_bed" header="Number of Beds"></Column>
    <Column field="price" header="Price">
      <template #body="slotProps">
        {{ formatCurrency(slotProps.data.price) }}
      </template>
    </Column>
    <Column field="available" header="Availability"></Column>
    <Column header="Actions">
      <template #body="slotProps">
        <Button icon="pi pi-pencil" aria-label="Submit" size="small" outlined class="mr-2"
          @click="() => router.visit(route('room.edit', slotProps.data.id))" />
        <Button aria-label="Delete" icon="pi pi-trash" severity="danger" size="small" outlined
          @click.prevent=" confirmDelete(slotProps.data.id)" :key="`confirmDialog${slotProps.data.id}`" />
      </template>
    </Column>
    <template #footer>
      <div class="flex justify-between">
        <div class="">
          <span>Showing {{ rooms.from }} to {{ rooms.to }} of {{ rooms.total }} results.</span>
        </div>
        <CustomPaginator :current-page="rooms.current_page" :total-pages="rooms.last_page" route-name="room.index" />
      </div>
    </template>
  </DataTable>
  <Toast position="bottom-right" />
  <DynamicDialog />
  <ConfirmDialog></ConfirmDialog>
</template>

<script setup>
  import Filter from "@/Components/Filter.vue";
  import { Link, router } from '@inertiajs/vue3';
  import axios from 'axios';
  import Button from 'primevue/button';
  import Column from 'primevue/column';
  import ConfirmDialog from 'primevue/confirmdialog';
  import DataTable from 'primevue/datatable';
  import CustomPaginator from "@/Components/CustomPaginator.vue";
  import DynamicDialog from 'primevue/dynamicdialog';
  import Toast from 'primevue/toast';
  import { useConfirm } from "primevue/useconfirm";
  import { useDialog } from 'primevue/usedialog';
  import { useToast } from 'primevue/usetoast';
  import { reactive } from "vue";

  const props = defineProps({
    rooms: Object
  })

  function formatCurrency(currency) {
    return currency.toLocaleString('en-US', { style: 'currency', currency: 'MMK' });
  }

  const toast = useToast();
  const confirm = useConfirm();
  function confirmDelete(id) {
    confirm.require({
      message: `Are you sure you want to delete room #${id}`,
      header: `Delete room #${id}.`,
      icon: 'pi pi-info-circle',
      acceptClass: 'p-button-danger',
      accept() {
        axios.delete(route('room.destroy', id)).then(data => {
          toast.add({
            severity: "success",
            summary: "Deleted successfully",
            detail: `Room #${id} is deleted successfully`,
            life: 3000,
          })
        })
      }
    })
  }
</script>
<script>
  import AdminLayout from "@/Layouts/AdminLayout.vue";
  export default {
    layout: AdminLayout
  }
</script>