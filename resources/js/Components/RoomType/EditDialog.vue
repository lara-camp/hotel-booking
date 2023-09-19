<template>
  <div class="w-[30rem]">
    <form @submit.prevent="() => roomTypeForm.put(route('admin.room-types.update', dialogRef.data.id))">
      <h1 class="mb-2 text-3xl font-bold">Edit Room Type #{{ dialogRef.data.id }}</h1>
      <div class="gap-x-2 flex mb-2">
        <div class=" flex flex-col w-full">
          <label for="checkin">Room Type</label>
          <InputText type="text" v-model="roomTypeForm.name" autofocus />
        </div>
      </div>
      <input type="hidden" name="page" :value="dialogRef.data.page">
      <div class="flex justify-end">
        <Button label="Update" outlined type="submit" />
      </div>
    </form>
  </div>
</template>
<script setup>
  import InputText from 'primevue/inputtext';
  import Button from 'primevue/button';
  import { useForm } from '@inertiajs/vue3';
  import { inject } from 'vue';

  const dialogRef = inject('dialogRef');

  const roomTypeForm = useForm({
    name: dialogRef.value.data.name,
    page: dialogRef.value.data.page
  });

</script>