<template>
    <Head title="Dashboard" />
    <h1 class="text-900 mb-6 text-5xl font-bold">Dashboard</h1>
    <div class="max-w-7xl">
        <div class="flex w-full">
            <AvailableRoomType :available-room-types="availableRoomTypes" class=" md:w-1/3 w-full" />
            <PopularRoomType :popular-room-types="popularRoomTypes" class=" md:w-2/3 w-full" />
        </div>
    </div>
</template>
<script setup>
    import AvailableRoomType from '@/Components/Dashboard/AvailableRoomType.vue';
    import { Head } from '@inertiajs/vue3';

    const props = defineProps({
        availableRoomTypes: Object,
        popularRoomTypes: Object
    })

</script>
<script>
    import AdminLayout from "@/Layouts/AdminLayout.vue";
    import PopularRoomType from '@/Components/Dashboard/PopularRoomType.vue';
    export default {
        layout: AdminLayout
    }
</script>
