/**
 * A global function to restore data from archived
 * @param {string} key The key for string such as headers and texts. Provide with this example "Room type"
 * @param {number} id Id of the data
 * @param {string} link The link for deleting
 * @param {*} confirm From useConfirm
 * @param {import("primevue/toastservice").ToastServiceMethods} toast From useToast
 * @param {import("@inertiajs/vue3").InertiaForm} restoreForm
 */
export default function restoreSoftDelete(key, id, link, confirm, toast, restoreForm,router) {
  confirm.require({
    message: `Are you sure you want to restore ${key.toLowerCase()} #${id}?`,
    header: `Restore ${key.toLowerCase()} #${id}`,
    icon: 'pi pi-info-circle',
    acceptClass: 'p-button-primary',
    accept: () => {
      restoreForm.patch(link, {
        onError() {
          toast.add({
            severity: "error",
            summary: "Cannot Restore",
            detail: `${key} #${id} is not restored.`,
            life: 3000,
          })
        },
        onSuccess() {
          toast.add({
            severity: "success",
            summary: "Restored successfully",
            detail: `${key} #${id} is restored.`,
            life: 3000,
          })
          router.reload({ preserveState: true });
        }
      })
    }
  })
}