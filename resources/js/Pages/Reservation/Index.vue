<template>
  <DataTable :value="reservations.data" tableStyle="min-width: 50rem" striped-rows class="bg-slate-100/80" :pt="{
    header: (options) => ({
      class: [
        '!py-3 !px-0'
      ]
    })
  }">
    <template #header>
      <div class=" flex justify-between gap-2 mb-3">
        <div class="">
          <span class="text-900 text-5xl font-bold">Reservations</span>
        </div>
        <div class="">
          <Button label="Filter" icon="pi pi-filter" class="mr-3" @click="showFilter" outlined />
          <Link :href="route('admin.reservations.create')">
          <Button label="Create" icon="pi pi-plus" outlined class="mr-3" />
          </Link>
        </div>
      </div>
    </template>
    <Column field="id" header="id"></Column>
    <Column field="room_id" header="Room No">
      <template #body="slotProps">
        <span v-for="(    room, i    ) in     slotProps.data.room_id    " :key="`${slotProps.index}${i}`">
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
          @click="() => router.visit(route('admin.reservations.edit', slotProps.data.id))" />
        <Button aria-label="Delete" icon="pi pi-trash" severity="danger" size="small" outlined
          @click.prevent=" confirmDelete(slotProps.data.id)" :key="`confirmDialog${slotProps.data.id}`" />
      </template>
    </Column>
    <template #footer>
      <div class="flex justify-between">
        <div class="">
          <span>Showing {{ reservations.from }} to {{ reservations.to }} of {{ reservations.total }} results.</span>
        </div>
        <CustomPaginator :current-page="reservations.current_page" :total-pages="reservations.last_page"
          route-name="admin.reservations.index" />
      </div>
    </template>
  </DataTable>
  <Toast position="bottom-right" />
  <DynamicDialog />
  <ConfirmDialog></ConfirmDialog>
</template>

<script setup>
  import CustomPaginator from "@/Components/CustomPaginator.vue";
  import Filter from "@/Components/Filter.vue";
  import { Link, router } from '@inertiajs/vue3';
  import axios from 'axios';
  import Button from 'primevue/button';
  import Column from 'primevue/column';
  import ConfirmDialog from 'primevue/confirmdialog';
  import DataTable from 'primevue/datatable';
  import DynamicDialog from 'primevue/dynamicdialog';
  import Toast from 'primevue/toast';
  import { useConfirm } from "primevue/useconfirm";
  import { useDialog } from 'primevue/usedialog';
  import { useToast } from 'primevue/usetoast';
  import { reactive } from "vue";

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
      icon: 'pi pi-info-circle',
      acceptClass: 'p-button-danger',
      accept: () => {
        axios.delete(route('admin.reservations.destroy', id)).then(data => {
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

  // Filter Dialog
  const dialog = useDialog();
  function showFilter() {
    dialog.open(Filter, {
      data: {
        filterForm
      },
      props: {
        modal: true
      }
    })
  }

  const searchParams = new URLSearchParams(document.location.search);
  const filterForm = reactive({
    from_date: searchParams.get("from_date") ? new Date(searchParams.get("from_date")) : "",
    to_date: searchParams.get("to_date") ? new Date(searchParams.get("to_date")) : ""
  })

  function paginateRouter(prop) {
    router.visit(route('admin.reservations.index', {
      _query: {
        page: prop + 1
      }
    }))
  }
</script>
<script>
  import AdminLayout from "@/Layouts/AdminLayout.vue";
  export default {
    layout: AdminLayout
  }
</script>