<template>
  <AuthenticatedLayout>
    <header class="bg-gray-100 py-3 px-4 sm:px-4 md:px-6">
      <div class="container mx-auto">
        <nav class="py-2 pl-2 flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900">Labour budgets</h1>
            <div>
              <Breadcrumb :crumbs="crumbspage" />
            </div>
          </div>
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
          <option value="">Search by week</option>
          <option v-for="date in weekEndingOptions" :key="date" :value="date">
            Fri {{ date }}
          </option>
        </select>

        <div class="w-full flex space-x-2">
          <select
            id="week-ending"
            v-model="selectedStartdate"
            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
          >
            <option value="">From week</option>
            <option v-for="date in weekEndingOptions" :key="date" :value="date">
              Fri {{ date }}
            </option>
          </select>
          <select
            id="week-ending"
            v-model="selectedEnddate"
            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
          >
            <option value="">To week</option>
            <option v-for="date in weekEndingOptions" :key="date" :value="date">
              Fri {{ date }}
            </option>
          </select>
        </div>

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
        class="mt-2 relative mx-auto rounded-lg sm:block shadow ring-1 ring-black ring-opacity-5 overflow-x-scroll"
      >
        <table class="min-w-full divide-y divide-gray-300">
          <thead class="bg-gray-100">
            <tr>
              <th
                scope="col"
                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
              >
                <span>WEEK</span>
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                EMPLOYEE
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                Contract No.
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                Hours
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                Claim
              </th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 bg-white">
            <tr
              style="border-top: 4px solid rgb(243, 244, 246)"
              v-for="item in results"
              :key="item.id"
            >
              <td
                class="w-full max-w-0 overflow-hidden whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6 whitespace-nowrap"
              >
                <span v-if="startFrom && selectedEnddate"
                  >{{ startFrom }} - {{ selectedEnddate }}</span
                >
              </td>
              <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell">
                {{ item.user_name }}
              </td>
              <td
                class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap"
              >
                {{ item.code }}
              </td>
              <td
                class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap"
              >
                {{ item.hours }}
              </td>
              <td
                class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap"
              >
                Claim
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
import { ref, watch, computed } from "vue";
import { router } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import PrimaryBadge from "@/Components/PrimaryBadge.vue";
import GrayBadge from "@/Components/GrayBadge.vue";
import UnderlineLink from "@/Components/UnderlineLink.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import dayjs from "dayjs";
import { formatDate } from "@/Helpers/formatDate"; // Adjust the path accordingly
const crumbspage = ref([
  { label: "Home", href: "/dashboard" },
  { label: "Labour budgets", href: "/labour-budgets" },
]);

const props = defineProps({
  weekEnding: {
    type: String,
  },
  startFrom: {
    type: String,
    required: true,
  },
  selectedEnddate: {
    type: String,
    required: true,
  },
  projectId: {
    type: Number,
    default: "",
  },
  projects: {
    type: Array,
    required: true,
  },

  results: {
    type: Object,
  },
  weekEnding: {
    type: Object,
  },
});

const generateWeekEndingOptions = () => {
  const options = [];
  const today = dayjs();
  const currentWeekEnding = today.day(5); // Get the Friday of the current week
  options.push(currentWeekEnding.format("DD-MM-YYYY"));

  for (let i = 1; i <= 150; i++) {
    options.push(currentWeekEnding.subtract(i, "week").format("DD-MM-YYYY"));
  }

  return options;
};
const weekEndingOptions = ref(generateWeekEndingOptions());
const selectedWeekEnding = ref(props.weekEnding || "");
const selectedProject = ref(props.projectId || "");
const selectedStartdate = ref(props.startFrom || "");
const selectedEnddate = ref(props.selectedEnddate || "");
const resetFields = () => {
  selectedWeekEnding.value = "";
  selectedStartdate.value = "";
  selectedEnddate.value = "";
  selectedProject.value = "";
};
const getLabourRoute = (weekEnding, startDate, endDate, project) => {
  return route("labour-budgets.index", {
    week_ending: weekEnding,
    startFrom: startDate,
    selectedEnddate: endDate,
    projectId: project,
  });
};
// Watch selectedWeekEnding, selectedUserType, and selectedProject, and navigate to the new route on change
watch(
  [selectedWeekEnding, selectedStartdate, selectedEnddate, selectedProject],
  ([newWeekEnding, newStartdate, newEnddate, newProject]) => {
    router.get(
      getLabourRoute(newWeekEnding, newStartdate, newEnddate, newProject)
    );
  }
);
</script>