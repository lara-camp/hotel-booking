<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import DeleteUserForm from './Partials/DeleteUserForm.vue';
    import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
    import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';

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

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-semibold leading-tight text-gray-800">Profile</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl space-y-6">
                <div class="sm:p-8 sm:rounded-lg p-4 space-x-3 bg-white shadow">
                    <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status" />
                </div>

                <div class="sm:p-8 sm:rounded-lg p-4 bg-white shadow">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div class="sm:p-8 sm:rounded-lg p-4 bg-white shadow">
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script>
    import AdminLayout from "@/Layouts/AdminLayout.vue";
    export default {
        layout: AdminLayout
    }
</script>