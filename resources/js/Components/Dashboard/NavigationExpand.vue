<template>
  <div class="bg-indigo-700/90 rounded">
    <div
      class=" hover:text-indigo-600 hover:bg-white duration-300rounded p-3 mb-2 text-white transition-colors rounded cursor-pointer"
      @click="() => isOpened = !isOpened">
      <div class="flex items-baseline justify-start">
        <div class="w-1/6 ml-6 mr-4">
          <span :class="{ 'pi pi-angle-up': isOpened, 'pi pi-angle-down': !isOpened }"></span>
        </div>
        <p class="text-xl font-semibold select-none">
          <slot />
        </p>
      </div>
    </div>
    <div class="w-full" v-show="isOpened">
      <slot name="contents" />
    </div>
  </div>
</template>

<script setup>
  import NavigationButton from './NavigationButton.vue';
  import { defineProps, ref } from 'vue';
  const props = defineProps({
    icon: String,
  })
  const isOpened = ref(false)

</script>
