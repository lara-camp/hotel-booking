<template>
  <form class="relative w-full md:w-1/2 h-auto max-h-[18rem] bg-slate-200/50 rounded">
    <input type="file" accept="image/jpeg,image/png" class="hidden" id="profilePicture" ref="profilePictureInputRef"
      @input="handleProfileInput">
    <img :src="previewProfilePhoto" :alt="`Profile image of ${user.name}`" class="object-cover w-full h-full rounded"
      v-if="previewProfilePhoto">
    <img :src="user.profile_image_path" :alt="`Profile image of ${user.name}`" class="object-cover w-full h-full rounded"
      v-else-if="user.profile_image_path">
    <div class="flex flex-col justify-center w-full h-full text-center" v-else>
      <p class="">There is no profile image.</p>
    </div>
    <Button icon="pi pi-pencil" class="!absolute bottom-0 left-0 bg-indigo-700 hover:bg-indigo-700"
      @click="() => profilePictureInputRef.click()" />
    <Button icon="pi pi-save" class="!absolute bottom-0 left-16 bg-indigo-700 hover:bg-indigo-700"
      :loading="form.processing" @click="submit" />
  </form>
</template>

<script setup>
  import { useForm, usePage } from "@inertiajs/vue3";
  import Button from 'primevue/button';
  import { ref } from "vue";

  const user = usePage().props.auth.user;

  const form = useForm({
    profile_image: ""
  })

  function submit() {
    form.post(route(user.role_id===1 ? 'admin.profile.updateProfileImage' : 'user.profile.updateProfileImage'), {
      onSuccess() {
        toast.add({
          severity: "success",
          summary: "Success",
          detail: "Profile Image is updated successfully",
          life: 3000
        })
      }
    })
  }

  const previewProfilePhoto = ref(null);
  const profilePictureInputRef = ref();
  function handleProfileInput(event) {
    const target = event.target;
    const file = target.files;

    previewProfilePhoto.value = URL.createObjectURL(file[0]);
    form.profile_image = file[0];
  }
</script>
