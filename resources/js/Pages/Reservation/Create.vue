<template>
  <div>
    <h1 class="text-3xl font-light">Create New Reservation</h1>
    <div class="[&>div]:mt-2">
      <div class="mb-3">
        <h2 class=" mb-2 text-2xl">Guest</h2>
        <div class="gap-x-3 flex">
          <div class="flex flex-col">
            <label for="name">Name</label>
            <InputText id="name" v-model="reservationForm.name" />
          </div>
          <div class=" flex flex-col">
            <label for="mobilPhone">Mobile Phone</label>
            <InputText id="mobilPhone" v-model="reservationForm.mobile_phone" />
          </div>
          <div class="flex flex-col">
            <label for="email">Email</label>
            <InputText id="email" v-model="reservationForm.email" />
          </div>
        </div>
      </div>
      <div class="mb-3">
        <h2 class="mb-2 text-2xl">Room</h2>
        <div class="gap-x-3 flex mb-2">
          <div class="flex flex-col">
            <label for="room">Room Number</label>
            <Dropdown v-model="reservationForm.room_id" :options="availableRooms" optionLabel="room"
              placeholder="Select a Room" editable />
          </div>
        </div>
        <h3 class=" text-xl">Room Configuration</h3>
        <div class="gap-x-3 flex my-2">
          <div class="flex flex-col">
            <label for="totalPerson">Total Number Of Person</label>
            <InputNumber id="totoalPerson" v-model="reservationForm.total_person" />
          </div>
          <div class="flex flex-col">
            <label for="extraBed">Extra Bed Count</label>
            <InputNumber id="extraBed" v-model="reservationForm.extra_bed" />
          </div>
        </div>
        <h3 class=" text-xl">Room Reservation Date</h3>
        <div class="gap-x-3 flex mt-2">
          <div class="flex flex-col">
            <label for="reservedFrom">From</label>
            <Calendar v-model="reservationForm.reserved_day_from" :minDate="minDate" :manualInput="false"
              id="reservedFrom" />
          </div>
          <div class="flex flex-col">
            <label for="reservedTo">To</label>
            <Calendar v-model="reservationForm.reserved_day_to" :minDate="minDate" :manualInput="false" id="reservedTo" />
          </div>
        </div>
      </div>
      <div class="mb-3">
        <div class="gap-x-3 flex">
          <div class="flex flex-col">
            <label for="checkin">Checkin</label>
            <Calendar v-model="reservationForm.checkin_time" :minDate="minDate" :manualInput="false" id="checkin"
              :showTime="true" hourFormat="24" />
          </div>
          <div class=" flex flex-col">
            <label for="checkout">Checkout</label>
            <Calendar v-model="reservationForm.checkout_time" :minDate="minDate" :manualInput="true" id="checkout"
              :showTime="true" hourFormat="24" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
  import { useForm } from '@inertiajs/vue3';
  import Calendar from 'primevue/calendar';
  import Dropdown from 'primevue/dropdown';
  import InputText from 'primevue/inputtext';
  import InputNumber from 'primevue/inputnumber';

  import { ref } from 'vue';

  const availableRooms = ref([
    { room: '234' },
    { room: '126' },
    { room: '934' },
    { room: '234' },
    { room: '092' }
  ])

  const reservationForm = useForm({
    name: "",
    email: "",
    mobile_phone: "",
    extra_bed: 0,
    room_id: availableRooms.value[0].room,
    reserved_day_from: "",
    reserved_day_to: "",
    checkin_time: "",
    checkout_time: "",
    total_person: 0
  })


  //For calculating min and max date
  const minDate = ref(new Date());

</script>
