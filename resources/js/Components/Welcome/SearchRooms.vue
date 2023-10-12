<template>
  <div class="w-full mt-16">
    <DataTable v-model:selection="selectedRooms" class="rounded" :value="rooms" size="large" dataKey="id"
      tableStyle="min-width: 50rem" :pt="{
        thead: {
          class: 'text-xl'
        },

      }">
      <Column selectionMode="multiple" headerStyle="width: 3rem"></Column>
      <Column field="room_number" header="Room Number"></Column>
      <Column field="bed_type" header="Bed Type"></Column>
      <Column field="number_of_bed" header="Number Of Bed"></Column>
      <Column field="room_type.name" header="Room Type"></Column>
      <Column field="price" header="Price"></Column>
    </DataTable>
  </div>
  <div class="mt-6">
    <h1 class="text-2xl font-semibold">Reserve Your Room</h1>
    <form class="flex gap-3">
      <div class=" md:w-1/2 flex flex-col flex-1 flex-shrink-0 w-full">
        <label for="guest_name">Guest Name</label>
        <InputText id="guest_name" v-model="reservationForm.guest_name" :class="{ 'p-invalid': errors.guest_name }"
          class="" />
        <InlineMessage v-if="errors.guest_name" severity="error" class="mt-2">{{ errors.guest_name }}
        </InlineMessage>
      </div>
      <div class=" md:w-1/2 flex flex-col flex-1 flex-shrink-0 w-full">
        <label for="totalPerson">Total Number Of Person</label>
        <InputNumber id="totalPerson" v-model="reservationForm.total_person" :class="{ 'p-invalid': errors.total_person }"
          class="" />
        <InlineMessage v-if="errors.total_person" severity="error" class="mt-2">{{ errors.total_person }}
        </InlineMessage>
      </div>
    </form>
  </div>
</template>

<script setup>
  import { useForm } from "@inertiajs/vue3";
  import Column from "primevue/column";
  import DataTable from "primevue/datatable";
  import InlineMessage from "primevue/inlinemessage";
  import InputText from "primevue/inputtext"
  import InputNumber from "primevue/inputnumber";
  import MultiSelect from "primevue/multiselect";
  import { onMounted, reactive, ref, watchEffect } from "vue";
  const props = defineProps({
    searchRooms: Object,
    errors: Object
  })

  const selectedRooms = ref([]);
  const rooms = ref();

  const reservationForm = useForm({
    room_id: [],
    guest_name: "",
    total_person: 0
  })

  watchEffect(() => {
    reservationForm.room_id = selectedRooms.value.map(room => room.id);
  })

  onMounted(() => {
    rooms.value = Object.values(props.searchRooms);
  })
</script>

<style scoped>
  .p-multiselect .p-multiselect-label.p-placeholder {
    color: black;
  }

  :deep(.p-datatable .p-datatable-tbody > tr.p-highlight) {
    color: rgb(79, 70, 229);
    background: rgba(79, 70, 229, 0.12);
  }

  :deep(.p-datatable .p-datatable-tbody > tr:hover) {
    background-color: rgba(79, 70, 229, 0.05);
    transition: color 300ms;
  }

  :deep(.p-checkbox .p-checkbox-box.p-highlight) {
    border-color: rgb(79, 70, 229);
    color: rgb(79, 70, 229);
  }
</style>
