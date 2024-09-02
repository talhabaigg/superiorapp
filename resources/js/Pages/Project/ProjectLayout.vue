<template>
  <AuthenticatedLayout>
    <header class="bg-gray-100 py-3 px-4 sm:px-4 md:px-6">
      <div class="container mx-auto">
        <nav class="py-2 pl-2 flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900">
              {{ project.project_name }}
            </h1>
            <div>
              <Breadcrumb :crumbs="crumbspage" />
            </div>
          </div>
          <Link class="mx-2">
            <PrimaryButton>Edit</PrimaryButton>
          </Link>
        </nav>
      </div>
    </header>

    <div class="hidden sm:block mx-auto px-4 py-4 sm:px-6 md:px-8">
      <div class="border-b border-gray-200">
        <nav class="-mb-px flex">
          <TabLink
            v-for="tab in tabs"
            :key="tab.name"
            :href="route(tab.routeName, { project: project.id })"
            :active="route().current(tab.routeName, { project: project.id })"
          >
            {{ tab.name }}
          </TabLink>
        </nav>
      </div>

      <slot />
    </div>
  </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TabLink from "@/Components/TabLink.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { Icon as IconifyIcon } from "@iconify/vue";
const props = defineProps({
  project: Object,
});

const homeicon = '<iconify-icon icon="mdi:house-outline"></iconify-icon>';
const crumbspage = ref([
  { label: "Home", href: "/dashboard" },
  {
    label: props.project.project_name,
    href: `/project/${props.project.id}`,
  },
]);
const tabs = [
  { name: "Summary", routeName: "project.show" },
  { name: "Members", routeName: "project-users.index" },
  { name: "Buildings and tasks", routeName: "buildings.index" },
  { name: "Contracts", routeName: "project.edit" },
  { name: "Pay rates", routeName: "project.edit" },
  { name: "Pay rate addons", routeName: "project.edit" },
  { name: "Absentee and injury alerts", routeName: "project.edit" },
];
</script>
