<template>
  <AuthenticatedLayout>
    <header class="bg-white py-3 px-4 sm:px-4 md:px-6">
      <div class="container mx-auto max-w-6xl">
        <nav class="py-4 pl-2 flex items-center justify-between max-w-6xl">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900">
              {{ project.project_name }}
            </h1>
            <ul class="flex items-center space-x-4 overflow-hidden">
              <li>
                <a class="text-gray-400 hover:text-gray-500">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    aria-hidden="true"
                    class="h-5 w-5 flex-shrink-0"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M9.293 2.293a1 1 0 0 1 1.414 0l7 7A1 1 0 0 1 17 11h-1v6a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-6H3a1 1 0 0 1-.707-1.707l7-7Z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </a>
              </li>
              <li>
                <a class="text-gray-400 hover:text-gray-500">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    aria-hidden="true"
                    class="h-5 w-5 flex-shrink-0 text-gray-400"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </a>
              </li>
              <li>
                <a
                  class="ml-2 whitespace-nowrap text-sm font-medium text-gray-500 hover:text-gray-700"
                  href="https://app.superiorgroup.com.au/projects/943ca432-9a3d-42dc-93e1-b30dc2d0ab5f"
                  >{{ project.project_name }}</a
                >
              </li>
            </ul>
          </div>
          <Link class="mx-2">
            <PrimaryButton>Edit</PrimaryButton>
          </Link>
        </nav>
      </div>
    </header>

    <div class="hidden sm:block max-w-7xl mx-auto px-4 py-4 sm:px-6 md:px-8">
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
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TabLink from "@/Components/TabLink.vue";
const props = defineProps({
  project: Object,
});

const tabs = [
  { name: "Summary", routeName: "project.show" },
  { name: "Members", routeName: "project-users.index" },
  { name: "Buildings and tasks", routeName: "project.edit" },
  { name: "Contracts", routeName: "project.edit" },
  { name: "Pay rates", routeName: "project.edit" },
  { name: "Pay rate addons", routeName: "project.edit" },
  { name: "Absentee and injury alerts", routeName: "project.edit" },
];
</script>
