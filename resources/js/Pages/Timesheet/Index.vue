<template>
  <AuthenticatedLayout>
    <header class="bg-gray-100 py-3 px-4 sm:px-4 md:px-6">
      <div class="container mx-auto">
        <nav class="py-2 pl-2 flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900">
              <!-- {{ project.project_name }} -->
            </h1>
            <div>
              <Breadcrumb :crumbs="crumbspage" />
            </div>
          </div>
          <Link href="#" class="mx-2">
            <PrimaryButton>Manage timesheet</PrimaryButton>
          </Link>
        </nav>
      </div>
    </header>

    <div class="hidden sm:block mx-auto px-4 py-4 sm:px-6 md:px-8">
      <div class="flex items-center space-x-4">
        <select
          id="week-ending"
          v-model="selectedWeekEnding"
          class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
        >
          <option v-for="date in weekEndingOptions" :key="date" :value="date">
            Fri {{ date }}
          </option>
        </select>
        <select
          id="user-type"
          v-model="selectedUserType"
          class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
        >
          <option value="">Select user type</option>
          <option value="1">Active</option>
          <option value="0">Inactive</option>
        </select>
        <select
          id="project-name"
          v-model="selectedProject"
          class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
        >
          <option value="">Select by project</option>
          <option
            v-for="project in projects"
            :key="project.id"
            :value="project.id"
          >
            {{ project.project_name }}
          </option>
        </select>

        <select
          id="employee-type"
          v-model="selectedEmployeeType"
          class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
        >
          <option value="">Select by employee type</option>
          <option v-for="type in employeeTypes" :key="type" :value="type">
            {{ type }}
          </option>
        </select>
      </div>
      <div
        class="mt-2 relative overflow-x-auto mx-auto rounded-lg sm:block overflow-y-auto shadow ring-1 ring-black ring-opacity-5 shadow-lg"
      >
        <table
          class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
        >
          <thead class="bg-gray-100">
            <tr>
              <th
                v-for="header in tableHeaders"
                :key="header.name"
                class="hidden px-3 py-5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                {{ header.name }}
              </th>
              <th
                v-for="date in weekDates"
                :key="date"
                class="px-4 py-2 text-xs text-gray-400"
              >
                {{ date }}
              </th>
              <th class="px-2">Total</th>
              <th class="px-2">Notes</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 bg-white">
            <tr v-for="user in users" :key="user.id">
              <td
                class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap"
              >
                <PrimaryBadge v-if="user.is_active">Active</PrimaryBadge>
                <GrayBadge v-else>Inactive</GrayBadge>
              </td>
              <td
                class="w-full max-w-0 overflow-hidden whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6"
              >
                <UnderlineLink>{{ user.name }}</UnderlineLink>
              </td>
              <td
                class="w-full max-w-0 overflow-hidden whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6"
              >
                {{ user.superior_id }}
              </td>
              <td class="px-4">265-65</td>
              <td class="px-4">26.03</td>
              <td class="px-4">No contracts</td>
              <td
                v-for="date in weekDates"
                :key="date"
                class="text-black text-right"
              >
                <div
                  v-if="user.hours_worked[date]"
                  class="bg-orange-400 py-4 pr-2 shadow-lg text-white"
                >
                  {{ user.hours_worked[date] }}
                </div>
              </td>
              <td></td>
              <td>
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                  aria-hidden="true"
                  data-slot="icon"
                  class="h-8 w-8 cursor-pointer text-blue-500"
                >
                  <path
                    fill-rule="evenodd"
                    d="M3.43 2.524A41.29 41.29 0 0 1 10 2c2.236 0 4.43.18 6.57.524 1.437.231 2.43 1.49 2.43 2.902v5.148c0 1.413-.993 2.67-2.43 2.902a41.102 41.102 0 0 1-3.55.414c-.28.02-.521.18-.643.413l-1.712 3.293a.75.75 0 0 1-1.33 0l-1.713-3.293a.783.783 0 0 0-.642-.413 41.108 41.108 0 0 1-3.55-.414C1.993 13.245 1 11.986 1 10.574V5.426c0-1.413.993-2.67 2.43-2.902Z"
                    clip-rule="evenodd"
                  ></path>
                </svg>
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
import { Link } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import PrimaryBadge from "@/Components/PrimaryBadge.vue";
import GrayBadge from "@/Components/GrayBadge.vue";
import UnderlineLink from "@/Components/UnderlineLink.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import dayjs from "dayjs";

// Props
const props = defineProps({
  users: {
    type: Array,
    required: true,
  },
  weekDates: {
    type: Array,
    required: true,
  },
  weekEnding: {
    type: String,
    required: true,
  },
  selectedUserType: {
    type: String,
    default: "",
  },
  projectName: {
    type: String,
    default: "",
  },
  projects: {
    type: Array,
    required: true,
  },
  employeeTypes: {
    type: Array,
    required: true,
  },
  employeeType: {
    type: String,
  },
});

const crumbspage = ref([
  { label: "Home", href: "/dashboard" },
  { label: "Timesheets", href: "/time-sheets" },
]);

const tableHeaders = [
  { name: "Approved" },
  { name: "Name" },
  { name: "Employee ID" },
  { name: "Cost code" },
  { name: "Total gross claim" },
  { name: "Contract bonus" },
];

// Generate week ending options
const generateWeekEndingOptions = () => {
  const options = [];
  const today = dayjs();
  const currentWeekEnding = today.day(5); // Get the Friday of the current week
  options.push(currentWeekEnding.format("DD-MM-YYYY"));

  for (let i = 1; i <= 50; i++) {
    options.push(currentWeekEnding.subtract(i, "week").format("DD-MM-YYYY"));
  }

  return options;
};

const weekEndingOptions = ref(generateWeekEndingOptions());
const selectedWeekEnding = ref(props.weekEnding);
const selectedUserType = ref(props.selectedUserType || "");
const selectedProject = ref(props.projectName || "");
const selectedEmployeeType = ref(props.employeeType || "");

const getTimesheetRoute = (date, userType, project, employeeType) => {
  return route("timesheet.index", {
    week_ending: date,
    usertype: userType,
    projectName: project,
    employeeType: employeeType,
  });
};

// Watch selectedWeekEnding, selectedUserType, and selectedProject, and navigate to the new route on change
watch(
  [selectedWeekEnding, selectedUserType, selectedProject, selectedEmployeeType],
  ([newDate, newUserType, newProjectName, newEmployeeType]) => {
    router.get(
      getTimesheetRoute(newDate, newUserType, newProjectName, newEmployeeType)
    );
  }
);
</script>
