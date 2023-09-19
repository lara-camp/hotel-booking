<script setup>
    import { Head } from '@inertiajs/vue3';
    import DeleteUserForm from './Partials/DeleteUserForm.vue';
    import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
    import UpdateProfile from './Partials/UpdateProfile.vue';

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
    <h2 class="text-3xl font-bold leading-tight text-gray-800">Profile</h2>
    <div class="py-12">
        <div class="max-w-7xl space-y-6">

            <div class="sm:p-8 bg-slate-100/80 p-4 rounded shadow">
                <UpdateProfile />
            </div>

            <div class="sm:p-8 bg-slate-100/80 p-4 rounded shadow">
                <UpdatePasswordForm class="max-w-xl" />
            </div>

            <div class="sm:p-8 bg-slate-100/80 p-4 rounded shadow">
                <DeleteUserForm class="max-w-xl" />
            </div>
        </div>
    </div>
</template>
<script>
    import AdminLayout from "@/Layouts/AdminLayout.vue";
    export default {
        layout: AdminLayout
    }
</script>