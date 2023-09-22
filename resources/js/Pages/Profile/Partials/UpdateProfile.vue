<template>
  <section>
    <form @submit.prevent="submitForm" class="flex space-x-3">
      <div class="w-1/2">
        <header class="mb-3">
          <h2 class="text-lg font-medium text-gray-900">Profile Information</h2>

          <p class="mt-1 text-sm text-gray-600">
            Update your account's profile information and email address.
          </p>
        </header>
        <div class="flex flex-col mb-2">
          <label for="name">Name</label>
          <InputText id="name" v-model="form.name" size="small" />
          <InlineMessage v-if="form.errors.name" severity="error" class="mt-2">{{ form.errors.name }}</InlineMessage>
        </div>
        <div class="flex flex-col mb-2">
          <label for="email">Email</label>
          <InputText id="email" v-model="form.email" size="small" />
          <InlineMessage v-if="form.errors.email" severity="error" class="mt-2">{{ form.errors.email }}</InlineMessage>
        </div>
        <div class="">
          <Button label="Save" icon="pi pi-save" outlined :disabled="form.processing" type="submit" />
          <InlineMessage v-if="form.errors.email" severity="error" class="mt-2">{{ form.errors.email }}</InlineMessage>
        </div>
      </div>
      <div class="relative w-1/2 h-auto max-h-[18rem] bg-slate-200/50 rounded">
        <input type="file" accept="image/jpeg,image/png" class="hidden" id="profilePicture" ref="profilePictureInputRef"
          @input="handleProfileInput">
        <img class="object-cover w-full h-full rounded" :src="form.profile_img" alt=""
          v-if="form.profile_img && !previewProfilePhoto">
        <img class="object-cover w-full h-full rounded" :src="previewProfilePhoto" alt="" v-if="previewProfilePhoto">
        <div class="flex flex-col justify-center w-full h-full text-center"
          v-if="!previewProfilePhoto && !form.profile_img">
          <p class="">There is no profile image.</p>
        </div>
        <Button icon="pi pi-pencil" class="!absolute bottom-0 left-0 bg-indigo-700 hover:bg-indigo-700"
          @click="() => profilePictureInputRef.click()" />
      </div>
    </form>
  </section>
  <Toast position="bottom-right" />
</template>

<script setup>
  import { useForm, usePage } from '@inertiajs/vue3';
  import Button from 'primevue/button';
  import InlineMessage from 'primevue/inlinemessage';
  import InputText from 'primevue/inputtext';
  import Toast from 'primevue/toast';
  import { useToast } from 'primevue/usetoast';
  import { ref } from "vue";

  const toast = useToast();

  defineProps({
    mustVerifyEmail: {
      type: Boolean,
    },
    status: {
      type: String,
    },
  });

  const user = usePage().props.auth.user;

  const form = useForm({
    name: user.name,
    email: user.email,
    profile_img: user.profile_img
  });

  function submitForm() {
    form.patch(route('profile.update'), {
      onSuccess() {
        toast.add({
          severity: "success",
          summary: "Success",
          detail: "Profile is updated successfully",
          life: 3000
        })
      }
    })
  }

  // Profile Picture
  const previewProfilePhoto = ref(null);
  const profilePictureInputRef = ref();
  function handleProfileInput(event) {
    const target = event.target;
    const file = target.files;

    previewProfilePhoto.value = URL.createObjectURL(file[0]);
    form.profile_img = file[0];
  }
</script>

<style lang="scss" scoped></style>