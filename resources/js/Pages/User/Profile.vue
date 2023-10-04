<script setup>
  import UpdatePasswordForm from "@/Pages/Profile/Partials/UpdatePasswordForm.vue";
  import UpdateProfile from "@/Pages/Profile/Partials/UpdateProfile.vue";
  import Logout from "@/Pages/Profile/Partials/Logout.vue";
  defineProps({
    mustVerifyEmail: {
      type: Boolean,
    },
    status: {
      type: String,
    },
  });
</script>

<template>
  <Head title="Profile" />
  <div class="py-3">
    <div class=" max-w-2xl md:max-w-[75rem] mx-auto space-y-6">
      <h2 class="p-3 text-4xl font-bold leading-tight text-gray-800">Profile</h2>
      <div class=" bg-slate-100/80 p-3 rounded shadow">
        <UpdateProfile />
      </div>

      <div class="bg-slate-100/80 p-3 rounded shadow">
        <UpdatePasswordForm class="max-w-xl" />
      </div>
      <div class="bg-slate-100/80 p-3 rounded shadow">
        <Logout />
      </div>
    </div>
  </div>
</template>
<script>
  import IndexLayout from "@/Layouts/IndexLayout.vue";
  export default {
    layout: IndexLayout
  }
</script>