<template>
  <Head title="Deleted Room Types" />
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
    <template #empty>
      <h3 class="text-lg font-normal text-center">No deleted room type is found.</h3>
    </template>
    <Column field="id" header="id"></Column>
    <Column field="name" header="Type"></Column>
    <Column header="Actions">
      <template #body="slotProps">
        <Button icon="pi pi-undo" aria-label="Submit" size="small" outlined class="mr-2"
          @click="() => restoreSoftDelete('Room type', slotProps.data.id, route('admin.room-types.restore', slotProps.data.id), confirm, toast, deleteRoomType, router)" />
      </template>
    </Column>
    <template #footer>
      <div class="flex justify-between">
        <div class="">
          <span>Showing {{ room_types.from }} to {{ room_types.to }} of {{ room_types.total }} results.</span>
        </div>
        <CustomPaginator :current-page="room_types.current_page" :total-pages="room_types.last_page"
          route-name="room-type.archives" />
      </div>
    </template>
  </DataTable>
  <Toast position="bottom-right" />
  <DynamicDialog />
</template>

<script setup>
  import CustomPaginator from "@/Components/CustomPaginator.vue";
  import restoreSoftDelete from "@/functions/restoreSoftDelete";
  import { Head, router, useForm } from "@inertiajs/vue3";
  import Button from 'primevue/button';
  import Column from 'primevue/column';
  import DataTable from 'primevue/datatable';
  import DynamicDialog from 'primevue/dynamicdialog';
  import Toast from "primevue/toast";
  import { useConfirm } from "primevue/useconfirm";
  import { useToast } from "primevue/usetoast";

  defineProps({
    room_types: Object
  })

  // Delete confirmation and actions
  const confirm = useConfirm();
  const toast = useToast();
  const deleteRoomType = useForm({});
</script>
<script>
  import AdminLayout from '@/Layouts/AdminLayout.vue';
  export default {
    layout: AdminLayout
  }
</script>
