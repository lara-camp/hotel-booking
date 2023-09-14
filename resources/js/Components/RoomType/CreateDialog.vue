<template>
  <div class="w-[30rem]">
    <h1 class="mb-2 text-3xl font-bold">Create Room Type</h1>
    <div class="gap-x-2 flex mb-2">
      <div class=" flex flex-col w-full">
        <label for="checkin">Room Type</label>
        <InputText type="text" v-model="name" />
      </div>
    </div>
    <div class="flex justify-end">
      <Button label="Create" outlined @click="submitRoomTypeForm" />
    </div>
  </div>
  <Toast position="bottom-right" />
</template>
<script setup>
  import InputText from 'primevue/inputtext';
  import Button from 'primevue/button';
  import Toast from "primevue/toast";
  import { useToast } from "primevue/usetoast";
  import { router, useForm } from '@inertiajs/vue3';
  import { ref } from 'vue';
  import axios from 'axios';
  import { inject } from 'vue';

  const toast = useToast();
  const name = ref("");

  const dialogRef = inject("dialogRef")

  function submitRoomTypeForm() {
    axios.post(route('roomtype.store'), {
      data: {
        name: name.value
      }
    }).then(response => {
      dialogRef.value.close();
      toast.add({
        life: 3000,
        severity: "success",
        summary: "Created successfully",
        detail: "A room type is created successfully",
      })
      router.reload();
    })
  }
</script>