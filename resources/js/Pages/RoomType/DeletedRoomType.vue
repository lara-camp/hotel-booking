<template>
  <DataTable :value="room_types.data" tableStyle="min-width: 50rem" striped-rows v-memo="[room_types]"
    class="bg-slate-100/80" :pt="{
      header: (options) => ({
        class: [
          '!py-3 !px-0'
        ],
      })
    }">
    <template #header>
      <div class="flex justify-between gap-2 mb-3">
        <div class="">
          <span class="text-900 text-5xl font-bold text-red-500">Deleted Room Types</span>
        </div>
        <div class="">
        </div>
      </div>
    </template>
    <Column field="id" header="id"></Column>
    <Column field="name" header="Type"></Column>
    <Column header="Actions">
      <template #body="slotProps">
        <Button icon="pi pi-undo" aria-label="Submit" size="small" outlined class="mr-2"
          @click="() => editDialog(slotProps.data.name, slotProps.data.id)" />
        <Button aria-label="Delete" icon="pi pi-times" severity="danger" size="small" outlined
          @click.prevent="() => confirmDelete(slotProps.data.id, route('room-type.destroy', slotProps.data.id))"
          :key="`confirmDialog${slotProps.data.id}`" />
      </template>
    </Column>
    <template #footer>
      <div class="flex justify-between">
        <div class="">
          <span>Showing {{ room_types.from }} to {{ room_types.to }} of {{ room_types.total }} results.</span>
        </div>
        <CustomPaginator :current-page="room_types.current_page" :total-pages="room_types.last_page"
          route-name="room-type.soft-deleted" />
      </div>
    </template>
  </DataTable>
  <Toast position="bottom-right" />
  <ConfirmDialog></ConfirmDialog>
  <DynamicDialog />
</template>

<script setup>
  import CustomPaginator from "@/Components/CustomPaginator.vue";
  import { router, useForm } from "@inertiajs/vue3";
  import Button from 'primevue/button';
  import Column from 'primevue/column';
  import ConfirmDialog from 'primevue/confirmdialog';
  import DataTable from 'primevue/datatable';
  import DynamicDialog from 'primevue/dynamicdialog';
  import Toast from "primevue/toast";
  import { useConfirm } from "primevue/useconfirm";

  defineProps({
    room_types: Object
  })

  // Delete confirmation and actions
  const confirm = useConfirm();
  const deleteRoomType = useForm({});
  function confirmDelete(id, link) {
    confirm.require({
      message: `Are you sure you want to delete room type #${id} permanently?`,
      header: `Delete room type #${id} permanently`,
      icon: 'pi pi-info-circle',
      acceptClass: 'p-button-danger',
      accept: () => {
        deleteRoomType.delete(link, {
          onError() {
            toast.add({
              severity: "error",
              summary: "Cannot Delete",
              detail: `Room type #${id} is not deleted`,
              life: 3000,
            })
          },
          onSuccess() {
            toast.add({
              severity: "success",
              summary: "Deleted successfully",
              detail: `Room type #${id} is deleted successfully`,
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
  import AdminLayout from '@/Layouts/AdminLayout.vue';
  export default {
    layout: AdminLayout
  }
</script>