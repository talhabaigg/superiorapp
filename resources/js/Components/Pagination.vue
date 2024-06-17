<template>
  <div class="flex gap-1">
    <Link
      v-for="(link, index) in links"
      :key="index"
      class="py-2 px-4 rounded-md"
      :href="link.url || '#'"
      :class="{
        'border-gray-300 bg-white text-gray-500 hover:bg-gray-50': link.active,
      }"
      v-html="link.label"
    />
  </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
defineProps({ links: Array });
</script>