<template>
  <section class="flex flex-row space-x-3">
    <form @submit.prevent="submitForm" class="md:w-1/2 block w-full" enctype="multipart/form-data">
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
        <Button label="Save" icon="pi pi-save" outlined :loading="form.processing" type="submit" />
        <InlineMessage v-if="form.errors.email" severity="error" class="mt-2">{{ form.errors.email }}</InlineMessage>
      </div>
    </form>
    <UpdateProfileImage class="lg:w-1/2 w-full" />
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
  import UpdateProfileImage from './UpdateProfileImage.vue';

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
  });

  function submitForm() {
    form.patch(route(user.role_id === 1 ? 'admin.profile.update' : 'user.profile.update'), {
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


</script>

<style lang="scss" scoped></style>
