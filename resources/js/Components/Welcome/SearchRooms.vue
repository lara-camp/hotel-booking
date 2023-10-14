<template>
  <div class="w-full mt-16">
    <DataTable v-model:selection="selectedRooms" class="rounded" :value="rooms" size="large" dataKey="id"
      tableStyle="min-width: 50rem" :pt="{
        thead: {
          class: 'text-xl'
        },

      }">
      <template #empty>
        <h3 class="text-lg font-normal text-center">No room is found.</h3>
      </template>
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
    <form class="gap-y-3" @submit.prevent="openDialog">
      <div class="flex gap-3">
        <div class="md:w-1/3 flex flex-col w-full">
          <label for="room_number">Room Number</label>
          <div class="border-black/40 h-[57.6px] p-4 bg-white border rounded cursor-not-allowed">
            {{ displayRoomNumbers }}
          </div>
        </div>
        <div class=" md:w-1/3 flex flex-col w-full">
          <label for="guest_name">Guest Name</label>
          <InputText id="guest_name" v-model="reservationForm.guest_name" :class="{ 'p-invalid': errors.guest_name }"
            class="" />
          <InlineMessage v-if="errors.guest_name" severity="error" class="mt-2">{{ errors.guest_name }}
          </InlineMessage>
        </div>
        <div class=" md:w-1/3 flex flex-col w-full">
          <label for="totalPerson">Total Number Of Person</label>
          <InputNumber id="totalPerson" v-model="reservationForm.total_person"
            :class="{ 'p-invalid': errors.total_person }" class="" />
          <InlineMessage v-if="errors.total_person" severity="error" class="mt-2">{{ errors.total_person }}
          </InlineMessage>
        </div>
      </div>
      <div class="flex gap-3">
        <div class="md:w-1/3 flex flex-col w-full">
          <label for="reservedFrom">Reserve From</label>
          <Calendar v-model="reservationForm.from_date" :minDate="minDate" :manualInput="false" id="reservedFrom"
            :class="{ 'p-invalid': errors.from_date }" class="w-full" :pt="{
              input: {
                class: 'p-4 rounded'
              }
            }" />
          <InlineMessage v-if="errors.from_date" severity="error" class="mt-2">{{ errors.from_date }}
          </InlineMessage>
        </div>
        <div class="md:w-1/3 flex flex-col w-full">
          <label for="reservedTo">Reserve To</label>
          <Calendar v-model="reservationForm.to_date" :minDate="reservationForm.from_date || null" :manualInput="false"
            id="reservedTo" :class="{ 'p-invalid': errors.to_date }" :pt="{
              input: {
                class: 'p-4 rounded'
              }
            }" />
          <InlineMessage v-if="errors.to_date" severity="error" class="mt-2">{{ errors.to_date }}
          </InlineMessage>
        </div>
        <div class="md:w-1/3 flex flex-col w-full cursor-not-allowed">
          <label for="totalPrice">Total Price</label>
          <div class="border-black/40 h-[57.6px] p-4 bg-white border rounded fontFamily">
            {{ totalPrice }}
          </div>
        </div>
      </div>
      <Button label="Reserve" outlined class="my-3" type="submit" v-if="user" />
      <InlineMessage severity="info" class="font-extralight w-full my-3 bg-white" :icon="null" v-else>Please login or
        register to make a
        reservation.</InlineMessage>
    </form>
  </div>
  <Toast position="bottom-right" />
  <DynamicDialog @success="console.log('success')" @error="console.log('error')" />
</template>

<script setup>
  import { router, useForm, usePage } from "@inertiajs/vue3";
  import Button from "primevue/button";
  import Calendar from "primevue/calendar";
  import DynamicDialog from 'primevue/dynamicdialog';
  import Column from "primevue/column";
  import DataTable from "primevue/datatable";
  import InlineMessage from "primevue/inlinemessage";
  import InputNumber from "primevue/inputnumber";
  import InputText from "primevue/inputtext";
  import { useToast } from "primevue/usetoast";
  import { computed, onMounted, ref, watchEffect } from "vue";
  import formatDate from "../../functions/formatDate";
  import Toast from "primevue/toast";
  import { useDialog } from "primevue/usedialog";
  import { defineAsyncComponent } from "vue";
  import ReservationConfirm from "./ReservationConfirm.vue";
  import { watch } from "vue";

  //   const ReservationConfirm = defineAsyncComponent("./ReservationConfirm.vue");

  const props = defineProps({
    searchRooms: Object,
    errors: Object
  })

  // Get Date from the query
  const searchParams = new URLSearchParams(document.location.search);
  const user = computed(() => usePage().props.auth.user)

  const selectedRooms = ref([]);
  const rooms = ref();
  const reservationForm = useForm({
    room_id: [],
    guest_name: user.value.name,
    total_person: 0,
    from_date: searchParams.get("from_date") ? (new Date(searchParams.get("from_date"))) : "",
    to_date: searchParams.get("to_date") ? new Date(searchParams.get("to_date")) : ""
  })

  const minDate = ref(new Date());

  watchEffect(() => {
    reservationForm.room_id = selectedRooms.value.map(room => room.id);
  })

  onMounted(() => {
    rooms.value = Object.values(props.searchRooms);
  })

  const displayRoomNumbers = computed(() => selectedRooms.value.map((item) => Number(item.room_number)).join(", "))

  // Calculate price per day
  let pricePerDay = computed(() => {
    // return props.searchRooms.filter((item) => reservationForm.room_id.indexOf(item.id) >= 0).reduce((initialPrice, item) => initialPrice + item.price, 0)
    return Object.values(props.searchRooms).filter((item) => reservationForm.room_id.indexOf(item.id) >= 0).reduce((initialPrice, item) => initialPrice + item.price, 0);
  })
  //   Calculate total price
  const totalPrice = computed(() => {
    const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
    const firstDate = new Date(reservationForm.from_date);
    const secondDate = new Date(reservationForm.to_date);
    const diffDays = Math.round(Math.abs((firstDate - secondDate) / oneDay));
    return ((diffDays + 1) * pricePerDay.value).toLocaleString() || 0;
  })

  // Dialog for reservation confirmation
  const dialog = useDialog();
  function openDialog() {
    dialog.open(ReservationConfirm, {
      data: {
        form: reservationForm,
        roomNumber: displayRoomNumbers.value,
        totalPrice: totalPrice.value,
      },
      props: {
        header: "Confirm Your Reservation",
        modal: true,
      }
    })
  }

  watch(reservationForm, () => {
    reservationForm.wasSuccessful && setTimeout(router.reload(), 3000);
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

  :deep(p-multiselect.p-component.p-inputwrapper.p-disabled) {
    background-color: white;
    color: black;
  }

  :deep(.p-inline-message.p-inline-message-info) {
    background-color: rgb(79 70 229);
    color: white;
  }

  :deep(.p-inline-message.p-inline-message-info .p-inline-message-icon) {
    display: none;
  }

  .fontFamily {
    font-family: Roboto, Helvetica Neue Light, Helvetica Neue, Helvetica, Arial, Lucida Grande, sans-serif;
  }
</style>
