<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
  href: {
    type: String,
    required: true,
  },
  active: {
    type: Boolean,
  },
});

const classes = computed(() =>
  props.active
    ? "text-blue-600 hover:text-blue-900 border-indigo-500 text-indigo-600 w-1/4 border-b-2 px-1 py-4 text-center text-sm font-medium"
    : "text-blue-600 hover:text-blue-900 border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 w-1/4 border-b-2 px-1 py-4 text-center text-sm font-medium"
);
</script>

<template>
  <Link :href="href" :class="classes">
    <slot />
  </Link>
</template>
