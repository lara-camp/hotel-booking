<template>
  <div class="w-[30rem]">
    <h1 class="mb-2 text-3xl font-bold">Edit Room Type #{{ dialogRef.data.id }}</h1>
    <div class="gap-x-2 flex mb-2">
      <div class=" flex flex-col w-full">
        <label for="checkin">Room Type</label>
        <InputText type="text" v-model="roomTypeForm.name" />
        <InlineMessage v-if="roomTypeForm.errors.name" severity="error" class="mt-2">
          {{ roomTypeForm.errors.name }}
        </InlineMessage>
      </div>
    </div>
    <div class="flex justify-end">
      <Button label="Update" outlined @click="updateRoomType" />
    </div>
  </div>
  <Toast position="bottom-right" />
</template>
<script setup>
  import { useForm } from '@inertiajs/vue3';
  import Button from 'primevue/button';
  import InlineMessage from 'primevue/inlinemessage';
  import InputText from 'primevue/inputtext';
  import Toast from 'primevue/toast';
  import { useToast } from "primevue/usetoast";
  import { inject } from 'vue';

  const toast = useToast();

  const dialogRef = inject('dialogRef');

  const roomTypeForm = useForm({
    name: dialogRef.value.data.name
  });

  function updateRoomType() {
    roomTypeForm.put(route("roomtype.update", dialogRef.value.data.id), {
      onSuccess() {
        toast.add({
          severity: "success",
          summary: "Update Success",
          detail: "Room type is updated successfully",
          life: 3000,
        })
        dialogRef.value.close();
      },
    })
  }
</script>
