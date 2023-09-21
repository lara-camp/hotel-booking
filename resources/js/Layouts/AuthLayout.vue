<template>
  <div class="flex justify-center min-w-full min-h-screen bg-indigo-600">
    <div
      class=" md:w-1/3 md:mx-0 min-h-[20rem] self-center w-full mx-3 bg-white border rounded shadow-xl p-3 group my-20">
      <div class="flex flex-col items-start mb-3">
        <Link
          class=" group-hover:text-indigo-700 text-5xl font-extrabold text-center text-indigo-600 transition-colors duration-300"
          href="/">
        Laracamp
        </Link>
        <Link
          class=" group-hover:text-indigo-700 text-5xl font-extrabold text-center text-indigo-600 transition-colors duration-300"
          href="/">
        Booking
        </Link>
      </div>
      <div class="">
        <slot />
      </div>
    </div>
  </div>
</template>
<script setup>
  import { Link } from "@inertiajs/vue3";
</script>