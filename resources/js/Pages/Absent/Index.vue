<template>
  <AuthenticatedLayout>
    <header class="bg-gray-100 py-3 px-4 sm:px-4 md:px-6">
      <div class="container mx-auto">
        <nav class="py-2 pl-2 flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900">Absentees</h1>
            <div>
              <Breadcrumb :crumbs="crumbspage" />
            </div>
          </div>
        </nav>
      </div>
    </header>
    <div class="px-4 py-4 sm:px-6 md:px-8">
      <div
        class="-mx-4 mt-8 overflow-y-hidden overflow-x-scroll shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg"
      >
        <table class="min-w-full divide-y divide-gray-300">
          <thead class="bg-gray-100">
            <tr>
              <!---->
              <th
                scope="col"
                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
              >
                Name
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                Projects
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                Employee type
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                Reason
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                Notes
              </th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 bg-white">
            <tr v-for="absent in absentees" :key="absent.id">
              <!---->
              <td
                class="w-full max-w-0 overflow-hidden whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6"
              >
                <Link
                  class="text-blue-600 hover:text-blue-900"
                  :href="`/users/${absent.user.id}`"
                  >{{ absent.user.name }}</Link
                >
                <dl class="text-base sm:hidden">
                  <dt class="sr-only">Employee type</dt>
                  <dd class="mt-1 truncate text-gray-500">
                    {{ absent.user.employee_type }}
                  </dd>
                  <!---->
                </dl>
              </td>
              <td
                class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap"
              >
                <div class="flex flex-wrap">
                  <Link
                    v-for="project in absent.user.projects"
                    :key="project.id"
                    class="text-xs px-2.5 py-1.5 bg-gray-100 text-gray-900 hover:bg-gray-200 focus:ring-gray-200 inline-flex items-center justify-center rounded-md border border-transparent font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto mr-1"
                    :href="`/project/${project.id}`"
                  >
                    {{ project.project_name }}
                  </Link>
                </div>
              </td>
              <td
                class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap"
              >
                {{ absent.user.employee_type }}
              </td>
              <td
                class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap"
              >
                {{ absent.reason }}
              </td>
              <td
                class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap"
              >
                <div>
                  {{ absent.notes }}
                  <div class="text-xs text-gray-400">
                    Created by Talha Baig on {{ absent.created_at }}12,
                    September 2024 7:11am
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { router } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";

// Props passed from backend
const props = defineProps({
  absentees: Object,
});

// Breadcrumbs for navigation
const crumbspage = ref([
  { label: "Home", href: "/dashboard" },
  { label: "Absentees", href: "/absent" },
]);
</script>