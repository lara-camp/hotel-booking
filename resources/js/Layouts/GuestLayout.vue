<script setup>
    import ApplicationLogo from '@/Components/ApplicationLogo.vue';
    import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="sm:justify-center sm:pt-0  flex flex-col items-center min-h-screen pt-6">
        <div class="sm:max-w-md sm:rounded-lg w-full px-6 py-4 mt-6 overflow-hidden bg-white shadow-md">
            <slot />
        </div>
    </div>
</template>
