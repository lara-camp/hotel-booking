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
          <span class="text-900 text-5xl font-bold text-red-500">Deleted Rooms</span>
        </div>
        <div class="">
        </div>
      </div>
    </template>
    <template #empty>
      <h3 class="text-lg font-normal text-center">No deleted room is found.</h3>
    </template>
    <Column field="id" header="Id"></Column>
    <Column field="room_number" header="Room Number"></Column>
    <Column field="room_type" header="Room Type"></Column>
    <Column field="bed_type" header="Bed type"></Column>
    <Column field="number_of_bed" header="Number of Beds"></Column>
    <Column field="price" header="Price">
      <template #body="slotProps">
        {{ formatCurrency(slotProps.data.price) }}
      </template>
    </Column>
    <Column header="Actions">
      <template #body="slotProps">
        <Button icon="pi pi-undo" aria-label="Submit" size="small" outlined class="mr-2"
          @click="() => restoreSoftDelete('Room', slotProps.data.id, route('admin.rooms.restore', slotProps.data.id), confirm, toast, deleteRoom, router)" />
        <Button aria-label="Delete" icon="pi pi-times" severity="danger" size="small" outlined
          @click.prevent="() => confirmDelete(slotProps.data.id, route('admin.rooms.force-delete', slotProps.data.id))"
          :key="`confirmDialog${slotProps.data.id}`" />
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
</template>

<script setup>
  import CustomPaginator from "@/Components/CustomPaginator.vue";
  import { router, useForm } from "@inertiajs/vue3";
  import Button from 'primevue/button';
  import Column from 'primevue/column';
  import DataTable from 'primevue/datatable';
  import DynamicDialog from 'primevue/dynamicdialog';
  import Toast from 'primevue/toast';
  import { useConfirm } from "primevue/useconfirm";
  import { useToast } from 'primevue/usetoast';

  defineProps({
    rooms: Object
  })

  function formatCurrency(currency) {
    return currency.toLocaleString('en-US', { style: 'currency', currency: 'MMK' });
  }

  // Delete confirmation and actions
  const confirm = useConfirm();
  const toast = useToast();
  const deleteRoom = useForm({});
  function confirmDelete(id, link) {
    confirm.require({
      message: `Are you sure you want to delete room #${id} permanently?`,
      header: `Delete room #${id} permanently`,
      icon: 'pi pi-info-circle',
      acceptClass: 'p-button-danger',
      accept: () => {
        deleteRoom.delete(link, {
          onError() {
            toast.add({
              severity: "error",
              summary: "Cannot Delete",
              detail: `Room #${id} is not deleted`,
              life: 3000,
            })
          },
          onSuccess() {
            toast.add({
              severity: "success",
              summary: "Deleted successfully",
              detail: `Room #${id} is deleted successfully`,
              life: 3000,
            })
            router.reload({ preserveState: true });
          }
        })
      }
    })
  }
</script>
<script>
  import AdminLayout from "@/Layouts/AdminLayout.vue";
  import restoreSoftDelete from "@/functions/restoreSoftDelete";
  export default {
    layout: AdminLayout
  }
</script>
<style lang="scss" scoped></style>