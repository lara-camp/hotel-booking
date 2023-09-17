<template>
  <DataTable :value="room_types.data" tableStyle="min-width: 50rem" striped-rows>
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
          @click.prevent=" confirmDelete(slotProps.data.id)" :key="`confirmDialog${slotProps.data.id}`" />
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
  import Toast from "primevue/toast";
  import CustomPaginator from "@/Components/CustomPaginator.vue";
  import axios from 'axios';
  import Button from 'primevue/button';
  import Column from 'primevue/column';
  import ConfirmDialog from 'primevue/confirmdialog';
  import DataTable from 'primevue/datatable';
  import DynamicDialog from 'primevue/dynamicdialog';
  import { useConfirm } from "primevue/useconfirm";
  import { useDialog } from 'primevue/usedialog';
  import CreateDialog from "../../Components/RoomType/CreateDialog.vue";
  import { useToast } from "primevue/usetoast";
  import EditDialog from "../../Components/RoomType/EditDialog.vue";

  const toast = useToast();

  const props = defineProps({
    room_types: Object
  })

  // Create Dialog
  const dialog = useDialog();
  function showCreate() {
    dialog.open(CreateDialog, {
      data: {
      }
    })
  }

  // Edit Dialog
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
  function confirmDelete(id) {
    confirm.require({
      message: `Are you sure you want to delete room type #${id}?`,
      header: `Delete room type #${id}`,
      accept: () => {
        axios.delete(route('roomtype.destroy', id)).then(data => {
          toast.add({
            severity: "success",
            summary: "Deleted successfully",
            detail: `Room type #${id} is deleted successfully`,
            life: 3000,
          })
        })
      }
    })
  }
</script>