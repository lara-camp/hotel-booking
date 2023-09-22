<script setup>
    import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />
    <div class="py-12">
        <div class="max-w-7xl sm:px-6 lg:px-8 mx-auto">
            <div class="sm:rounded-lg overflow-hidden bg-white shadow-sm">
                <div class="p-6 text-gray-900">You're logged in!</div>
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