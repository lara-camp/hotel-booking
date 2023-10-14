<template>
  <div class="min-w-[22rem]">
    <div class="flex flex-col mb-3">
      <label for="RoomNumber" class=" text-xl">Room Number</label>
      <p>{{ dialogRef.data.roomNumber }}</p>
    </div>
    <div class="flex flex-col mb-3">
      <label for="RoomNumber" class=" text-xl">Guest Name</label>
      <p>{{ reservationForm.guest_name }}</p>
    </div>
    <div class="flex flex-col mb-3">
      <label for="RoomNumber" class=" text-xl">Total Number of Person</label>
      <p>{{ reservationForm.total_person }}</p>
    </div>
    <div class="flex flex-col mb-3">
      <label for="RoomNumber" class=" text-xl">Reserve From</label>
      <p>{{ reservationForm.from_date.toLocaleDateString("en") }}</p>
    </div>
    <div class="flex flex-col mb-3">
      <label for="RoomNumber" class=" text-xl">Reserve To</label>
      <p>{{ reservationForm.to_date.toLocaleDateString("en") }}</p>
    </div>
    <div class="flex flex-col mb-3">
      <label for="RoomNumber" class=" text-xl">Total Price</label>
      <p>{{ dialogRef.data.totalPrice }}</p>
    </div>
    <div class=" mt-3">
      <Button label="Reserve" outlined @click="submitForm" :loading="reservationForm.processing" />
    </div>
  </div>
</template>

<script setup>
  import Button from "primevue/button";
  import formatDate from "@/functions/formatDate"
  import { inject } from "vue";
  import { useToast } from "primevue/usetoast";

  const dialogRef = inject('dialogRef');

  const { form: reservationForm } = dialogRef.value.data;

  const toast = useToast();
  function submitForm() {
    reservationForm.transform((data) => ({
      ...data,
      from_date: formatDate(data.from_date),
      to_date: formatDate(data.to_date)
    })).post(route("user.reserve"), {
      onSuccess: () => {
        toast.add({ severity: 'success', summary: 'Success', detail: 'Added Reservation Successfully', life: 3000 })
        dialogRef.value.close();
      },
      onError: () => {
        toast.add({ severity: 'error', summary: 'Cannot Reserve Room', detail: "Cannot reserve your rooms because you didn't fill your information correctly.", life: 3000 })
        dialogRef.value.close();
      }
    })
  }
</script>
