<template>
  <div class="w-[30rem]">
    <form @submit.prevent="() => roomTypeForm.post(route('admin.room-types.store'))">
      <h1 class="mb-2 text-3xl font-bold">Create Room Type</h1>
      <div class="gap-x-2 flex mb-2">
        <div class=" flex flex-col w-full">
          <label for="checkin">Room Type</label>
          <InputText type="text" v-model="roomTypeForm.name" autofocus />
        </div>
      </div>
      <div class="flex justify-end">
        <Button label="Create" outlined type="submit" />
      </div>
    </form>

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
    nameForm.post(route('room-type.store'), {
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