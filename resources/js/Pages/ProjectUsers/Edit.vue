<template>
  <AuthenticatedLayout>
    <header class="bg-gray-100 py-3 px-4 sm:px-4 md:px-6">
      <div class="container mx-auto">
        <nav class="py-2 pl-2 flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900">
              Manage project members - {{ project.project_name }}
            </h1>
            <div>
              <Breadcrumb :crumbs="crumbspage" />
            </div>
          </div>
          <!-- <Link :href="route('daily-prestarts.create')">
            <PrimaryButton>Create Daily Pre-Start</PrimaryButton>
          </Link> -->
        </nav>
      </div>
    </header>
    <div class="px-4 py-4 sm:px-6 md:px-8">
      <div class="flex items-center space-x-2 mt-8">
        <input
          id="show_only_project_members"
          type="checkbox"
          class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
        />
        <label
          for="show_only_project_members"
          class="ml-2 block text-sm text-gray-900"
          >Show only project members</label
        >
      </div>
      <form @submit.prevent="submitForm">
        <div
          class="-mx-4 mt-8 overflow-y-hidden overflow-x-scroll shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg"
        >
          <table class="min-w-full divide-y divide-gray-300">
            <tr>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                ID
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                Name
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                Member
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell whitespace-nowrap"
              >
                Travel EBA zone
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell whitespace-nowrap"
              >
                Union delegate
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell whitespace-nowrap"
              >
                HSR duties
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell whitespace-nowrap"
              >
                Block task times
              </th>
            </tr>
            <tbody>
              <tr class="divide-y divide-gray-200 bg-white">
                <td
                  class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell bg-gray-100 font-bold"
                  colspan="7"
                >
                  Foreman
                </td>
              </tr>
              <tr class="" v-for="user in allUsers" :key="user.id">
                <td
                  class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell"
                >
                  {{ user.superior_id }}
                </td>
                <td
                  class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell"
                >
                  {{ user.name }}
                </td>
                <td
                  class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell"
                >
                  <input
                    type="checkbox"
                    v-model="selectedMembers"
                    :value="user.id"
                    class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                  />
                </td>
                <td
                  class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell"
                >
                  <select
                    class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm"
                    id="travelEbaZones_11"
                    name="travelEbaZones[]"
                  >
                    <option value="">Select travel EBA zone</option>
                    <option class="capitalize" value="zone_1">Zone 1</option>
                    <option class="capitalize" value="zone_2">Zone 2</option>
                    <option class="capitalize" value="zone_3">Zone 3</option>
                  </select>
                </td>
                <td
                  class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell"
                >
                  <input
                    id="unionDelegates_11"
                    class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                    name="unionDelegates[]"
                    type="checkbox"
                    value="11"
                  />
                </td>
                <td
                  class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell"
                >
                  <input
                    id="hsrDuties_11"
                    class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                    name="hsrDuties[]"
                    type="checkbox"
                    value="11"
                  />
                </td>
                <td
                  class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell"
                >
                  <input
                    id="blockTaskTimes_11"
                    class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                    name="blockTaskTimes[]"
                    type="checkbox"
                    value="11"
                  />
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="flex justify-start items-center space-x-2">
          <PrimaryButton type="submit"> Update project members </PrimaryButton>

          <UnderlineLink :href="route('project.index')">Cancel</UnderlineLink>
        </div>
      </form>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref, watch, computed } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { Link } from "@inertiajs/vue3";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import Pagination from "@/Components/Pagination.vue";
import UnderlineLink from "@/Components/UnderlineLink.vue";
import { router } from "@inertiajs/vue3";
const props = defineProps({
  project: Object,
  allUsers: Object,
  existingMembers: Array,
});

const crumbspage = ref([
  { label: "Home", href: "/dashboard" },
  { label: props.project.project_name, href: `/project/${props.project.id}` },
  { label: "All members", href: `/project-members/${props.project.id}` },
  {
    label: "Manage project members",
    href: `/project-members/${props.project.id}/edit`,
  },
]);

// Array to store selected user IDs, initialized with existing members
const selectedMembers = ref([...props.existingMembers]);

// Form submission logic
const submitForm = () => {
  // Send selectedMembers array to the backend
  router.post(`/projects/${props.project.id}/users`, {
    members: selectedMembers.value,
  });
};
</script>