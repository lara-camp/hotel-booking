<template>
  <DataTable :value="room_types.data" tableStyle="min-width: 50rem" striped-rows v-memo="[room_types]">
    <template #header>
      <div class="flex justify-between gap-2">
        <div class="">
          <span class="text-900 text-2xl font-bold">Room Type</span>
        </div>
        <Button label="Create" icon="pi pi-plus" @click="showCreate" outlined />
      </div>
    </template>
    <Column field="id" header="id"></Column>
    <Column field="name" header="Type"></Column>
    <Column header="Actions">
      <template #body="slotProps">
        <Button icon="pi pi-pencil" aria-label="Submit" size="small" outlined class="mr-2"
          @click="() => editDialog(slotProps.data.name, slotProps.data.id)" />
        <Button aria-label="Delete" icon="pi pi-trash" severity="danger" size="small" outlined
          @click.prevent="() => confirmDelete(slotProps.data.id)" :key="`confirmDialog${slotProps.data.id}`" />
      </template>
    </Column>
    <template #footer>
      <div class="flex justify-between">
        <div class="">
          <span>Showing {{ room_types.from }} to {{ room_types.to }} of {{ room_types.total }} results.</span>
        </div>
        <CustomPaginator :current-page="room_types.current_page" :total-pages="room_types.last_page"
          route-name="roomtype.index" />
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
  import { useDialog } from 'primevue/usedialog';
  import { useToast } from "primevue/usetoast";
  import { defineAsyncComponent } from "vue";

  const toast = useToast();

  const props = defineProps({
    room_types: Object,
    errors: Object
  })

  // Create Dialog
  const dialog = useDialog();
  const CreateDialog = defineAsyncComponent(() => import("../../Components/RoomType/CreateDialog.vue"))
  function showCreate() {
    dialog.open(CreateDialog)
  }

  // Edit Dialog
  const EditDialog = defineAsyncComponent(() => import("../../Components/RoomType/EditDialog.vue"));
  function editDialog(name, id) {
    dialog.open(EditDialog, {
      data: {
        name,
        id
      }
    })
  }

  // Delete confirmation and actions
  const confirm = useConfirm();
  const deleteRoomType = useForm({});
  function confirmDelete(id) {
    confirm.require({
      message: `Are you sure you want to delete room type #${id}?`,
      header: `Delete room type #${id}`,
      accept: () => {
        deleteRoomType.delete(route('roomtype.destroy', id), {
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