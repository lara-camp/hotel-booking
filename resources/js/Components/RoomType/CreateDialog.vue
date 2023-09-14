<template>
  <div class="w-[30rem]">
    <h1 class="mb-2 text-3xl font-bold">Create Room Type</h1>
    <div class="gap-x-2 flex mb-2">
      <div class=" flex flex-col w-full">
        <label for="checkin">Room Type</label>
        <InputText type="text" v-model="roomTypeForm.name" autofocus />
      </div>
    </div>
    <div class="flex justify-end">
      <Button label="Create" outlined @click="() => roomTypeForm.post(route('admin.room-types.store'))" />
    </div>
  </div>
</template>
<script setup>
  import InputText from 'primevue/inputtext';
  import Button from 'primevue/button';
  import { useForm } from '@inertiajs/vue3';

  const roomTypeForm = useForm({
    name: ""
  });

</script>