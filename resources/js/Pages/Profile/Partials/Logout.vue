<template>
  <section class="">
    <header class="mb-3">
      <h2 class="text-lg font-medium text-gray-900">Logout And Others</h2>
    </header>
    <Button label="Logout" severity="danger" @click.prevent="confirmLogout" />
  </section>
  <ConfirmDialog />
</template>

<script setup>
  import { router } from '@inertiajs/vue3';
import Button from 'primevue/button';
  import ConfirmDialog from 'primevue/confirmdialog';
  import ConfirmPopup from 'primevue/confirmpopup';
  import { useConfirm } from "primevue/useconfirm";

  const confirm = useConfirm();
  function confirmLogout() {
    confirm.require({
      icon: 'pi pi-info-circle',
      acceptClass: 'p-button-danger',
      message: 'Are you sure you want to proceed?',
      icon: 'pi pi-exclamation-triangle',
      accept: () => {
        router.post(route('logout'));
      },
    });
  };
</script>

<style lang="scss" scoped></style>