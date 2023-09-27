<script setup>
    import { Head } from '@inertiajs/vue3';
    import Logout from './Partials/Logout.vue';
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
    <h2 class="p-3 text-3xl font-bold leading-tight text-gray-800">Profile</h2>
    <div class="py-3">
        <div class="max-w-7xl space-y-6">

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
    import AdminLayout from "@/Layouts/AdminLayout.vue";
    export default {
        layout: AdminLayout
    }
</script>
