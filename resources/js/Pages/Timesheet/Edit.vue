<template>
  <AuthenticatedLayout>
    <header class="bg-gray-100 py-3 px-4 sm:px-4 md:px-6">
      <div class="container mx-auto">
        <nav class="py-2 pl-2 flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900">
              Timesheet for {{ $page.props.auth.user.name }}
              {{ weekDates[0] }} to {{ weekDates[6] }}
            </h1>
            <div>
              <Breadcrumb :crumbs="crumbspage" />
            </div>
          </div>
        </nav>
      </div>
    </header>
  </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref, watch, computed } from "vue";
import { usePage, Link } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
const page = usePage();
const crumbspage = ref([
  { label: "Home", href: "/dashboard" },
  { label: "Timesheets", href: "/time-sheets" },
]);

const props = defineProps({
  weekEnding: {
    type: String,
    required: false,
  },
  weekDates: {
    type: Array,
    required: true,
  },
});
</script>