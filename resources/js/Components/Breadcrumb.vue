<!-- resources/js/Components/Breadcrumb.vue -->
<template>
  <nav class="text-gray-500 my-4" aria-label="Breadcrumb">
    <ol class="list-none p-0 inline-flex">
      <li
        v-for="(crumb, index) in crumbs"
        :key="index"
        class="flex items-center"
      >
        <Link
          v-if="crumb.href"
          :href="crumb.href"
          class="whitespace-nowrap text-sm font-medium text-gray-500 hover:text-gray-700"
          >{{ crumb.label }}</Link
        >
        <span v-else>{{ crumb.label }}</span>
        <svg
          v-if="index < crumbs.length - 1"
          class="w-4 h-4 mx-2"
          fill="currentColor"
          viewBox="0 0 20 20"
        >
          <path
            d="M9.293 16.293a1 1 0 010-1.414L13.586 10 9.293 5.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"
          />
        </svg>
      </li>
    </ol>
  </nav>
</template>
  
  <script setup>
import { Link } from "@inertiajs/vue3";
import { defineProps } from "vue";

const props = defineProps({
  crumbs: {
    type: Array,
    required: true,
    default: () => [],
  },
});
</script>
  