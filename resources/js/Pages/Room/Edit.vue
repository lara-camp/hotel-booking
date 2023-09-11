<template>
  <div>
    <h1 class="text-2xl my-2">Edit the Room</h1>
    <div class="flex flex-col mb-3">
      <label for="roomnumber" class="my-2">room number</label>
      <InputNumber
        v-model="roomForm.number"
        id="roomnumber"
        inputId="integeronly"
      />
      <InlineMessage v-if="errors.number" severity="error" class="mt-2">{{
        errors.number
      }}</InlineMessage>
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
          <RadioButton v-model="roomForm.available" inputId="available" name="available" :value="true" />
        <label for="availables" class="ml-2">available</label>
      </div>
        <div class="align-items-center flex">
          <RadioButton v-model="roomForm.available" inputId="taken" name="taken" :value="false" />
        <label for="taken" class="ml-2">taken</label>
      </div>
      </div>
      <InlineMessage v-if="errors.available" severity="error" class="mt-2">{{
        errors.available
      }}</InlineMessage>
    </div>
    <div class="my-3">
      <Button label="Update" outlined @click="submitForm" class="px-5" />
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

const props = defineProps({
    id: Number,
    number: Number,
    available: Boolean,
    bed_type: String,
    number_of_bed: Number,
    price: Number,
  errors: Object,
});

  const roomForm = useForm(
  {
    number: props.number,
    price: props.price,
    available: props.available,
    bed_type: props.bed_type,
    number_of_bed: props.number_of_bed
  },
  );

const toast = useToast();

function submitForm() {
  roomForm.put(route("admin.rooms.update", props.id), {
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
