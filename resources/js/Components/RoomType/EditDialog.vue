<template>
  <div class="w-[30rem]">
    <h1 class="mb-2 text-3xl font-bold">Edit Room Type #{{ dialogRef.data.id }}</h1>
    <div class="gap-x-2 flex mb-2">
      <div class=" flex flex-col w-full">
        <label for="checkin">Room Type</label>
        <InputText type="text" v-model="roomTypeForm.name" />
      </div>
    </div>
    <div class="flex justify-end">
      <Button label="Filter" outlined @click="() => roomTypeForm.putW(route('roomtype.update', dialogRef.data.id))" />
    </div>
  </div>
</template>
<script setup>
  import InputText from 'primevue/inputtext';
  import Button from 'primevue/button';
  import { useForm } from '@inertiajs/vue3';
  import { inject } from 'vue';

  const dialogRef = inject('dialogRef');

  const roomTypeForm = useForm({
    name: dialogRef.value.data.name
  });

</script>