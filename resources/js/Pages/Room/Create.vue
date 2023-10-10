<template>
  <Head title="Create Room" />
  <div>
    <h1 class="my-2 text-5xl font-bold">Create A New Room</h1>
    <div class="flex flex-col mb-3">
      <label for="roomnumber" class="my-2">Room Number</label>
      <InputNumber v-model="roomForm.room_number" id="roomnumber" inputId="integeronly" />
      <InlineMessage v-if="errors.room_number" severity="error" class="mt-2">{{
        errors.room_number
      }}</InlineMessage>
    </div>
    <div class="flex flex-col">
      <label for="numOfBeds" class="my-2">Number Of Beds</label>

      <InputNumber v-model="roomForm.number_of_bed" id="numOfBeds" inputId="integeronly" />
      <InlineMessage v-if="errors.number_of_bed" severity="error" class="mt-2">{{
        errors.number_of_bed
      }}</InlineMessage>
    </div>
    <div class="flex flex-col">
      <label for="integeronly" class="my-2">Price</label>
      <InputNumber v-model="roomForm.price" inputId="integeronly" mode="currency" currency="MMK" />
      <InlineMessage v-if="errors.price" severity="error" class="mt-2">{{
        errors.price
      }}</InlineMessage>
    </div>
    <div class="flex flex-col">
      <label for="bedType" class="my-2">Bed Type</label>
      <InputText id="bedType" v-model="roomForm.bed_type" />
      <InlineMessage v-if="errors.bed_type" severity="error" class="mt-2">{{
        errors.bed_type
      }}</InlineMessage>
    </div>
    <div class="flex flex-col">
      <label for="roomType" class="my-2">Room type</label>
      <Dropdown v-model="roomForm.room_type_id" :options="props.room_type" optionLabel="name"
        placeholder="Select a room type" class="md:w-14rem w-full" option-value="id" />
      <InlineMessage v-if="errors.room_type_id" severity="error" class="mt-2">{{
        errors.room_type_id
      }}</InlineMessage>
    </div>
    <div class="my-3">
      <Button label="Create " outlined @click="submitForm" class="px-5" :loading="roomForm.processing" />
    </div>
  </div>
</template>

<script setup>
  import { useForm, Head } from "@inertiajs/vue3";
  import Button from "primevue/button";
  import Dropdown from 'primevue/dropdown';
  import InlineMessage from "primevue/inlinemessage";
  import InputNumber from "primevue/inputnumber";
  import InputText from "primevue/inputtext";
  import RadioButton from "primevue/radiobutton";
  import { useToast } from "primevue/usetoast";

  const props = defineProps({
    errors: Object,
    room_type: Array
  });

  const roomForm = useForm({
    room_number: 0,
    price: 0,
    room_type_id: 0,
    bed_type: "",
    number_of_bed: 0,
  });

  const toast = useToast();

  function submitForm() {
    roomForm.post(route('admin.rooms.store'), {
      onSuccess: () => toast.add({ severity: "success", summary: "Success", detail: "Created a room successfully", life: 3000 }),
    });
  }
</script >
<script>
  import AdminLayout from "@/Layouts/AdminLayout.vue";
  export default {
    layout: AdminLayout
  }
</script>
<style scoped>
  label {
    text-transform: uppercase;
    color: #474242;
    font-size: 13px;
  }
</style>

