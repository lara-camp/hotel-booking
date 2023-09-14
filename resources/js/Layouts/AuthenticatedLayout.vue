<script setup>
    import { ref } from 'vue';

    const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <header class=" bg-white" v-if="$slots.header">
            <slot name="header" />
        </header>

        <!-- Page Content -->
        <main>
            <slot />
        </main>
    </div>
</template>
