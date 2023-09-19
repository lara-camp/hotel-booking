<template>
  <div class="w-[30rem]">
    <h1 class="mb-2 text-3xl font-bold">Create Room Type</h1>
    <div class="gap-x-2 flex mb-2">
      <div class=" flex flex-col w-full">
        <label for="checkin">Room Type</label>
<<<<<<< HEAD
        <InputText type="text" v-model="roomTypeForm.name" autofocus />
      </div>
    </div>
    <div class="flex justify-end">
      <Button label="Create" outlined @click="() => roomTypeForm.post(route('admin.room-types.store'))" />
=======
        <InputText type="text" v-model="nameForm.name" />
        <InlineMessage v-if="nameForm.errors.name" severity="error" class="mt-2">
          {{ nameForm.errors.name }}
        </InlineMessage>
      </div>
    </div>
    <div class="flex justify-end">
      <Button label="Create" outlined @click="submitForm" />
>>>>>>> 62227741f91b968a22e8274f687adc60a43b72ec
    </div>
  </div>
  <Toast position="bottom-right" />
</template>
<script setup>
  import { useForm, router } from '@inertiajs/vue3';
  import Button from 'primevue/button';
  import InlineMessage from 'primevue/inlinemessage';
  import InputText from 'primevue/inputtext';
  import Toast from "primevue/toast";
  import { useToast } from "primevue/usetoast";
  import { inject } from 'vue';

  const toast = useToast();

  const nameForm = useForm({
    name: ""
  })

  const dialogRef = inject("dialogRef");
  function submitForm() {
    nameForm.post(route('roomtype.store'), {
      onSuccess() {
        toast.add({
          severity: "success",
          summary: "Create Success",
          detail: "Room type is created successfully",
          life: 3000,
        })
        router.reload({ preserveState: true });
        dialogRef.value.close();
      }
    })
  }
</script>