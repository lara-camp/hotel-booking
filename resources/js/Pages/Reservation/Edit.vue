<template>
  <Head :title="`Edit Reservation #${id}`" />
  <div>
    <h1 class="mb-3 text-5xl font-bold">Edit Reservation #{{ id }}</h1>
    <div class="[&>div]:mt-2">
      <div class="mb-3">
        <h2 class="mb-2 text-3xl font-normal">Room</h2>
        <div class="gap-x-3 flex flex-wrap mb-3">
          <div class="md:w-1/2 flex flex-col flex-1 flex-shrink-0 w-full">
            <label for="room">Room Number</label>
            <MultiSelect v-model="reservationForm.room_id" :options="available_rooms" optionLabel="room_number"
              optionValue="id" filter placeholder="Select rooms" :maxSelectedLabels="5" class=" w-full"
              :class="{ 'p-invalid': errors.room_id }" />
            <InlineMessage v-if="errors.room_id" severity="error" class="mt-2">{{ errors.room_id }}</InlineMessage>
          </div>
          <div class=" md:w-1/2 flex flex-col flex-1 flex-shrink-0 w-full">
            <label for="guest_name">Guest Name</label>
            <InputText id="guest_name" v-model="reservationForm.guest_name" :class="{ 'p-invalid': errors.guest_name }"
              class="" />
            <InlineMessage v-if="errors.guest_name" severity="error" class="mt-2">{{ errors.guest_name }}
            </InlineMessage>
          </div>
          <div class=" md:w-1/2 flex flex-col flex-1 flex-shrink-0 w-full">
            <label for="totalPerson">Total Number Of Person</label>
            <InputNumber id="totalPerson" v-model="reservationForm.total_person"
              :class="{ 'p-invalid': errors.total_person }" class="" />
            <InlineMessage v-if="errors.total_person" severity="error" class="mt-2">{{ errors.total_person }}
            </InlineMessage>
          </div>
          <div class=" flex flex-col flex-shrink-0 w-full">
            <label for="pricePerDay">Price Per Day</label>
            <InputNumber id="pricePerDay" disabled mode="currency" currency="MMK" v-model="pricePerDay" :pt="{
              input: {
                class: '!opacity-100'
              }
            }" />
            <InlineMessage v-if="errors.total_price" severity="error" class="mt-2">{{ errors.total_price }}
            </InlineMessage>
          </div>
        </div>
        <h3 class=" mb-2 text-3xl font-normal">Room Reservation Date</h3>
        <div class="gap-x-3 flex mt-2">
          <div class="flex flex-col w-1/2">
            <label for="reservedFrom">From</label>
            <Calendar v-model="reservationForm.from_date" :minDate="minDate" :manualInput="false" id="reservedFrom"
              :class="{ 'p-invalid': errors.from_date }" class="w-full" :pt="{
                input: {
                  class: 'p-4 rounded'
                }
              }" />
            <InlineMessage v-if="errors.from_date" severity="error" class="mt-2">{{ errors.from_date }}</InlineMessage>
          </div>
          <div class="flex flex-col w-1/2">
            <label for="reservedTo">To</label>
            <Calendar v-model="reservationForm.to_date" :minDate="reservationForm.from_date || null" :manualInput="false"
              id="reservedTo" :class="{ 'p-invalid': errors.to_date }" :pt="{
                input: {
                  class: 'p-4 rounded'
                }
              }" />
            <InlineMessage v-if="errors.to_date" severity="error" class="mt-2">{{ errors.to_date }}</InlineMessage>
          </div>
        </div>
      </div>
      <div class="gap-x-3 flex mt-2">
        <div class="flex flex-col w-1/2">
          <label for="checkin">Checkin</label>
          <Calendar v-model="checkinTime" :minDate="reservationForm.from_date || minDate"
            :maxDate="reservationForm.to_date || null" :manualInput="false" id="checkin" :showTime="true" hourFormat="24"
            :class="{ 'p-invalid': errors.checkin_time }" :disabled="!reservationForm.from_date" :pt="{
              input: {
                class: 'p-4 rounded'
              }
            }" />
          <InlineMessage v-if="errors.checkin_time" severity="error" class="mt-2">{{ errors.checkin_time }}
          </InlineMessage>
        </div>
        <div class=" flex flex-col w-1/2">
          <label for="checkout">Checkout</label>
          <Calendar v-model="checkoutTime" :minDate="checkinTime || null" :manualInput="true" id="checkout"
            :showTime="true" hourFormat="24" :class="{ 'p-invalid': errors.checkout_time }" :disabled="!checkinTime" :pt="{
              input: {
                class: 'p-4 rounded'
              }
            }" />
          <InlineMessage v-if="errors.checkout_time" severity="error" class="mt-2">{{ errors.checkout_time }}
          </InlineMessage>
        </div>
      </div>
      <div class="mb-3">
        <Button label="Update Reservation" outlined @click="submitForm" :loading="reservationForm.processing"/>
      </div>
    </div>
  </div>
</template>

<script setup>
  import { Head, useForm } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Calendar from 'primevue/calendar';
import InlineMessage from 'primevue/inlinemessage';
import InputNumber from 'primevue/inputnumber';
import InputText from 'primevue/inputtext';
import MultiSelect from 'primevue/multiselect';
import { useToast } from "primevue/usetoast";
import { computed, ref, watchEffect } from 'vue';

  const props = defineProps({
    id: Number,
    rooms: Array,
    room_id: Array,
    guest_name: String,
    total_person: Number,
    total_price: Number,
    from_date: String,
    to_date: String,
    checkin_time: String,
    checkout_time: String,
    errors: Object,
  })
  const { rooms, errors, id, ...editProps } = props

  const reservationForm = useForm({
    ...editProps,
    // To change those iso date into js date format, because calendar inputs only display iso date instead of desired one
    checkin_time: "",
    checkout_time: "",
    from_date: new Date(editProps.from_date),
    to_date: new Date(editProps.to_date),
  })

  const toast = useToast();
  function submitForm() {
    reservationForm.put(route("admin.reservations.update", props.id), {
      preserveState: true,
      onSuccess: () => toast.add({ severity: 'success', summary: 'Success', detail: 'Added Reservation Successfully', life: 3000 }),
    })
  }

  //For calculating min date
  const minDate = ref(new Date());

  const checkinTime = ref(editProps.checkin_time ? new Date(editProps.checkin_time) : null);
  const checkoutTime = ref(editProps.checkout_time ? new Date(editProps.checkout_time) : null);

  // Change checkin and checkout time to UTC and save to reservationForm
  watchEffect(() => {
    reservationForm.checkin_time = checkinTime.value ? new Date(checkinTime.value).toISOString() : "";
  })
  watchEffect(() => {
    reservationForm.checkout_time = checkoutTime.value ? new Date(checkoutTime.value).toISOString() : "";
  })

  // Calculate price per day
  let pricePerDay = computed(() => {
    return props.rooms.filter((item) => reservationForm.room_id.indexOf(item.id) >= 0).reduce((initialPrice, item) => initialPrice + item.price, 0)
  })

  // Calculate total price
  watchEffect(() => {
    let fromDate = new Date(reservationForm.from_date);
    let toDate = new Date(reservationForm.to_date)
    let diff = Math.abs(toDate.getTime() - fromDate.getTime())
    let days = diff / (1000 * 60 * 60 * 24);
    reservationForm.total_price = (days + 1) * pricePerDay.value || 0
  })
</script>
<script>
  import AdminLayout from "@/Layouts/AdminLayout.vue";
  export default {
    layout: AdminLayout
  }
</script>
