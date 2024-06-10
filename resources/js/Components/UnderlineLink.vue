<template>
    <Link :href="href" class=" py-4 font-medium text-blue-600 dark:text-blue-500 whitespace-nowrap hover:text-blue-900 hover:underline">
        <slot />
    </Link>
  </template>
  
  <script setup>
  
  import { Link } from '@inertiajs/vue3';
  
  defineProps({
    href: {
        type: String,
    },
});
  </script>