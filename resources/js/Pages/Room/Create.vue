<template>
  <div>
    <h1 class="my-2 text-2xl">Create A New Room</h1>
    <div class="flex flex-col mb-3">
      <label for="roomNumber" class="my-2">room number</label>
      <InputNumber
        v-model="roomForm.room_number"
        id="roomNumber"
        inputId="integeronly"
      />
      <InlineMessage v-if="errors.room_number" severity="error" class="mt-2">{{
        errors.room_number
      }}</InlineMessage>
    </div>

    <div class="flex flex-col">
        <label for="room_type">Room Type</label>
        <Dropdown v-model="roomForm.room_type_id" :options="room_types" optionLabel="title" optionValue="id" filter placeholder="Select Room Type"
                     :maxSelectedLabels="5" class=" w-full" :class="{ 'p-invalid': errors.room_type_id }" />
        <InlineMessage v-if="errors.room_type_id" severity="error" class="mt-2">{{ errors.room_type_id }}</InlineMessage>
    </div>

    <div class="flex flex-col">
      <label for="numOfBeds" class="my-2">number of beds</label>
      <InputNumber
        v-model="roomForm.number_of_bed"
        id="numOfBeds"
        inputId="integeronly"
      />
      <InlineMessage v-if="errors.number_of_bed" severity="error" class="mt-2">{{
        errors.number_of_bed
      }}</InlineMessage>
    </div>
    <div class="flex flex-col">
      <label for="integeronly" class="my-2">price</label>
      <InputNumber v-model="roomForm.price" inputId="integeronly" mode="currency" currency="MMK" />
      <InlineMessage v-if="errors.price" severity="error" class="mt-2">{{
        errors.price
      }}</InlineMessage>
    </div>
    <div class="flex flex-col">
      <label for="bedType" class="my-2">bed type</label>
      <InputText id="bedType" v-model="roomForm.bed_type" />
      <InlineMessage v-if="errors.bed_type" severity="error" class="mt-2">{{
        errors.bed_type
      }}</InlineMessage>
    </div>
    <div class="flex flex-col flex-wrap gap-3 my-2">
      <label for="">status</label>
      <div class="flex gap-3">
        <div class="align-items-center flex">
          <RadioButton v-model="roomForm.status" inputId="available" name="available" :value="true" />
        <label for="availables" class="ml-2">available</label>
      </div>
        <div class="align-items-center flex">
          <RadioButton v-model="roomForm.status" inputId="taken" name="taken" :value="false" />
        <label for="taken" class="ml-2">taken</label>
      </div>
      </div>
      <InlineMessage v-if="errors.status" severity="error" class="mt-2">{{
        errors.status
      }}</InlineMessage>
    </div>
    <div class="my-3">
      <Button label="Create" outlined @click="submitForm" class="px-5" />
    </div>
  </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import Button from "primevue/button";
import InputNumber from "primevue/inputnumber";
import InputText from "primevue/inputtext";
import RadioButton from "primevue/radiobutton";
import InlineMessage from "primevue/inlinemessage";
import { useToast } from "primevue/usetoast";
import Dropdown from "primevue/dropdown";

const props = defineProps({
  errors: Object,
  room_types: Object,
});

  const roomForm = useForm(
  {
    room_number: 0,
    price: 0,
    available: true,
    room_type_id: 0,
    bed_type: "",
    number_of_bed: 0,
  },
  );

const toast = useToast();

function submitForm() {
  roomForm.post(route('admin.rooms.store'), {
    onSuccess: () => toast.add({ severity: "success",summary: "Success",detail: "Created a room successfully",life:3000}),
  });
}
</script>
<style scoped>
label {
  text-transform: uppercase;
  color: #474242;
  font-size: 13px;
}
</style>
