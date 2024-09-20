<template>
  <AuthenticatedLayout>
    <header class="bg-gray-100 py-3 px-4 sm:px-4 md:px-6">
      <div class="container mx-auto">
        <nav class="py-2 pl-2 flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900">Projects</h1>
            <div>
              <Breadcrumb :crumbs="crumbspage" />
            </div>
          </div>
          <Link :href="route('project.create')">
            <PrimaryButton>Create Project</PrimaryButton>
          </Link>
        </nav>
      </div>
    </header>
    <div class="p-2 px-8">
      <div
        class="my-2 flex flex-col space-y-2 mx-auto sm:flex-row sm:items-center sm:space-y-0 sm:space-x-4"
      >
        <input
          v-model="searchQuery"
          type="text"
          placeholder="Search by name"
          class="block w-full rounded-full border border-gray-300 px-4 py-2 placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
        />
        <select
          v-model="selectedSubsidiaryType"
          class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm"
        >
          <option value="">Search by subsidiary</option>
          <option value="Superior Walls & Ceilings">
            Superior Walls & Ceilings
          </option>
          <option value="Greenline">Greenline</option>
        </select>
        <select
          v-model="selectedStatusType"
          class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm"
        >
          <option value="">Search by status</option>
          <option value="1">Active</option>
          <option value="0">Inactive</option>
        </select>
        <div>
          <button
            @click="resetFields"
            class="hidden sm:block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base text-gray-500 hover:text-gray-700 focus:text-blue-500 sm:text-sm"
          >
            Reset
          </button>
        </div>
      </div>
      <div
        class="mt-2 relative overflow-x-auto mx-auto rounded-lg sm:block overflow-y-auto shadow ring-1 ring-black ring-opacity-5"
      >
        <table
          class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
        >
          <thead class="bg-gray-100">
            <tr>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                Status
              </th>
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
                Labour costs
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                Members
              </th>
              <th
                scope="col"
                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 table-cell"
              ></th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 bg-white">
            <tr v-for="project in filteredProjects" :key="project.id">
              <td
                class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap"
              >
                <PrimaryBadge v-if="project.is_active"> Active </PrimaryBadge>
                <GrayBadge v-else> Inactive </GrayBadge>
              </td>
              <td
                class="w-full max-w-0 overflow-hidden whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6"
              >
                <UnderlineLink
                  :href="route('project.show', { project: project.id })"
                  >{{ project.project_name }}
                </UnderlineLink>
                <div class="text-sm text-gray-500">
                  {{ project.subsidiary }}
                </div>
                <div class="block sm:hidden my-1">
                  <PrimaryBadge v-if="project.is_active"> Active </PrimaryBadge>
                  <GrayBadge v-else> Inactive </GrayBadge>
                </div>
              </td>
              <td
                class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap"
              >
                <div class="mb-1 text-sm dark:text-white">
                  {{
                    calculatePercentageSpent(
                      project.estimated_hours,
                      project.timesheets_sum_hours_worked
                    ).toFixed(2)
                  }}% labour used
                </div>
                <div
                  class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700"
                >
                  <div
                    class="bg-blue-600 h-2.5 rounded-full"
                    :class="{
                      'bg-red-600':
                        calculatePercentageSpent(
                          project.estimated_hours,
                          project.timesheets_sum_hours_worked
                        ) > 90,
                      'bg-blue-600':
                        calculatePercentageSpent(
                          project.estimated_hours,
                          project.timesheets_sum_hours_worked
                        ) <= 90,
                    }"
                    :style="{
                      width:
                        Math.min(
                          calculatePercentageSpent(
                            project.estimated_hours,
                            project.timesheets_sum_hours_worked
                          ),
                          100
                        ) + '%',
                    }"
                  ></div>
                </div>
              </td>
              <td
                class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap"
              >
                <div class="flex items-center space-x-2">
                  <div class="hidden md:flex -space-x-2">
                    <!-- <UserAvatars :users="project.users" :limit="5" /> -->
                    <div v-for="user in project.users" :key="user.id">
                      <Avatar
                        :name="user.name"
                        :bgColor="getColorByEmployeeType(user.employee_type)"
                        size="36px"
                        :title="user.name"
                      />
                    </div>
                  </div>
                  <div v-if="project.users.length > 4" class="">
                    <Link
                      :href="route('project-users.index', project.id)"
                      class="text-xs px-2.5 py-1.5 bg-gray-100 text-gray-900 hover:bg-gray-200 focus:ring-gray-200 inline-flex items-center justify-center rounded-md border border-transparent font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto ml-2 hidden sm:block"
                    >
                      SHOW ALL - {{ project.users.length }}
                    </Link>
                  </div>
                </div>
              </td>
              <td class="relative">
                <div class="relative w-8 h-8">
                  <Menu as="div" class="relative inline-block text-left">
                    <MenuButton
                      type="button"
                      class="w-8 h-8 rounded-full flex items-center justify-center hover:bg-gray-200"
                    >
                      <svg
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <circle cx="12" cy="5" r="2" fill="currentColor" />
                        <circle cx="12" cy="12" r="2" fill="currentColor" />
                        <circle cx="12" cy="19" r="2" fill="currentColor" />
                      </svg>
                    </MenuButton>
                    <transition
                      enter-active-class="transition duration-100 ease-out"
                      enter-from-class="transform scale-95 opacity-0"
                      enter-to-class="transform scale-100 opacity-100"
                      leave-active-class="transition duration-75 ease-in"
                      leave-from-class="transform scale-100 opacity-100"
                      leave-to-class="transform scale-95 opacity-0"
                    >
                      <MenuItems
                        class="absolute right-0 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-lg bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
                      >
                        <div>
                          <MenuItem v-slot="{ active }">
                            <Link :href="`/project/${project.id}`">
                              <button
                                :class="[
                                  active
                                    ? 'bg-gray-100 text-gray-700'
                                    : 'text-gray-900',
                                  'group flex w-full items-center px-4 py-2 text-sm',
                                ]"
                              >
                                Profile
                              </button>
                            </Link>
                          </MenuItem>
                          <MenuItem v-slot="{ active }">
                            <button
                              :class="[
                                active
                                  ? 'bg-gray-100 text-red-600'
                                  : 'text-red-600',
                                'group flex w-full items-center px-4 py-2 text-sm',
                              ]"
                              @click="deleteProject(project.id)"
                            >
                              Delete
                            </button>
                          </MenuItem>
                        </div>
                      </MenuItems>
                    </transition>
                  </Menu>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="mt-4 flex justify-between items-center mx-auto">
        <div
          v-if="projects.data.length"
          class="w-full flex justify-end mt-8 mb-8"
        >
          <Pagination :links="projects.links" />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import PrimaryBadge from "@/Components/PrimaryBadge.vue";
import UnderlineLink from "@/Components/UnderlineLink.vue";
import GrayBadge from "@/Components/GrayBadge.vue";
import { ref, computed } from "vue";
import { Link } from "@inertiajs/vue3";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import Pagination from "@/Components/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import UserAvatars from "@/Components/UserAvatar.vue";
import Avatar from "vue-avatar-3";
import { getColorByEmployeeType } from "@/Helpers/colorHelpers";
// Define props
const props = defineProps({
  projects: Object,
});
// Define employee type colors
// const getColorByEmployeeType = (employeeType) => {
//   const colors = {
//     Plasterer: "#57544f",
//     "Back Office": "white",
//     Foreman: "blue",
//     "Leading Hand": "brown",
//     Painter: "green",
//     "Site Manager": "orange",
//     Laborer: "gray",
//     // Add more employee types and their corresponding colors here
//   };

//   return colors[employeeType] || "transparent"; // Default color if type not found
// };
const crumbspage = ref([
  { label: "Home", href: "/dashboard" },
  { label: "Projects", href: "/project" },
]);

const getAvatarUrl = (avatarPath) => {
  if (!avatarPath) return "";
  return `${window.location.origin}/${avatarPath}`;
};

// Reactive state for search and filter
const searchQuery = ref("");
const selectedSubsidiaryType = ref("");
const selectedStatusType = ref(""); // Ensure it's an empty string for default

// Reactive state for pagination
const currentPage = ref(1);
const itemsPerPage = ref(9);

// Computed property to filter projects based on search query and selected filter types
const filteredProjects = computed(() => {
  return props.projects.data.filter((project) => {
    const matchesSearchQuery = project.project_name
      .toLowerCase()
      .includes(searchQuery.value.toLowerCase());
    const matchesSubsidiaryType =
      selectedSubsidiaryType.value === "" ||
      project.subsidiary === selectedSubsidiaryType.value;
    const matchesStatusType =
      selectedStatusType.value === "" ||
      project.is_active.toString() === selectedStatusType.value; // Convert to string for comparison
    return matchesSearchQuery && matchesSubsidiaryType && matchesStatusType;
  });
});

const resetFields = () => {
  selectedSubsidiaryType.value = "";
  selectedStatusType.value = "";
  searchQuery.value = "";
};

const getProjects = (url) => {
  Inertia.visit(url, {
    only: ["projects"],
    preserveState: true,
  });
};
const deleteProject = (projectId) => {
  if (confirm("Are you sure you want to delete this project?")) {
    Inertia.delete(route("project.destroy", projectId), {
      onSuccess: () => {
        // Handle successful deletion
        console.log("Project deleted successfully");
      },
      onError: (errors) => {
        // Handle errors
        console.error("Deletion errors:", errors);
      },
    });
  }
};
// // Computed property for paginated users
// const paginatedProjects = computed(() => {
//   const start = (currentPage.value - 1) * itemsPerPage.value;
//   const end = start + itemsPerPage.value;
//   return filteredProjects.value.slice(start, end);
// });

// // Computed property for total pages
// const totalPages = computed(() => {
//   return Math.ceil(filteredProjects.value.length / itemsPerPage.value);
// });

// // Methods for pagination
// const prevPage = () => {
//   if (currentPage.value > 1) {
//     currentPage.value--;
//   }
// };

// const nextPage = () => {
//   if (currentPage.value < totalPages.value) {
//     currentPage.value++;
//   }
// };
const dropDownLinks = [
  { name: "QR login scanner", icon: "mdi:folder-outline", route: "project" },
  { name: "QR Cards PDF", icon: "mdi:folder-outline", route: "swms" },
  { name: "Summary", icon: "mdi:folder-outline", route: "project" },
  { name: "View SWMS", icon: "mdi:folder-outline", route: "swms" },
];
// Function to calculate percentage spent
const calculatePercentageSpent = (estimatedHours, hoursWorked) => {
  if (estimatedHours > 0) {
    return (hoursWorked / estimatedHours) * 100;
  }
  return 0;
};
</script>
