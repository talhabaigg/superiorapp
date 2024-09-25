<template>
  <AuthenticatedLayout>
    <header class="bg-gray-100 py-3 px-4 sm:px-4 md:px-6">
      <div class="container mx-auto">
        <nav class="py-2 pl-2 flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900">
              Timesheet - {{ formatDate(date) }} for {{ user.name }}
            </h1>
            <div>
              <Breadcrumb :crumbs="crumbspage" />
            </div>
          </div>
        </nav>
      </div>
    </header>
    <div class="px-4 py-4 sm:px-6 md:px-8">
      <h3 class="mb-2 font-medium">Hours - {{ formatDate(date) }}</h3>

      <div class="mb-6 rounded border bg-gray-50 p-4">
        <form @submit.prevent="submit">
          <div class="mb-6">
            <div class="mb-2">
              <select
                class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm disabled:opacity-50"
                id="timeSheet_0_payroll_code_id"
                value="6"
              >
                <option value="">Select payroll code</option>
                <option class="capitalize" value="3">Annual Leave</option>
                <option class="capitalize" value="7">Bonus</option>
                <option class="capitalize" value="12">
                  Daily Laser Allowance
                </option>
                <option class="capitalize" value="13">
                  Hourly Insulation Allowance
                </option>
                <option class="capitalize" value="11">Other</option>
                <option class="capitalize" value="2">Public Holiday</option>
                <option class="capitalize" value="5">RDO Taken</option>
                <option class="capitalize" value="4">Sick Leave</option>
                <option class="capitalize" value="6">Standard Pay</option>
                <option class="capitalize" value="1">Training at TAFE</option>
              </select>
            </div>
            <div class="mb-2 grid grid-cols-2">
              <select
                class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm rounded-none rounded-l border-r-0 disabled:opacity-50"
                v-model="form.start_time.hour"
              >
                <option value="">Select hour</option>
                <option v-for="hour in hours" :key="hour" :value="hour">
                  {{ formatHour(hour) }}
                </option></select
              ><select
                class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm rounded-none rounded-r disabled:opacity-50"
                id="timeSheet_0_clock_in_minute"
                value="30"
                v-model="form.start_time.minute"
              >
                <option value="">Select minute</option>
                <option v-for="minute in minutes" :key="minute" :value="minute">
                  {{ minute }}
                </option>
              </select>
            </div>
            <div class="mb-2 grid grid-cols-2">
              <select
                class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm rounded-none rounded-l border-r-0 disabled:opacity-50"
                v-model="form.end_time.hour"
              >
                <option value="">Select hour</option>
                <option v-for="hour in hours" :key="hour" :value="hour">
                  {{ formatHour(hour) }}
                </option></select
              ><select
                class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm rounded-none rounded-r disabled:opacity-50"
                id="timeSheet_0_clock_out_minute"
                v-model="form.end_time.minute"
              >
                <option value="">Select minute</option>
                <option v-for="minute in minutes" :key="minute" :value="minute">
                  {{ minute }}
                </option>
              </select>
            </div>

            <!-- <div class="mt-2" style="display: none">
            <p class="mt-2 text-sm text-red-600"></p>
          </div>
          <div class="mt-2" style="display: none">
            <p class="mt-2 text-sm text-red-600"></p>
          </div>
          <div class="mt-2" style="display: none">
            <p class="mt-2 text-sm text-red-600"></p>
          </div>
          <div class="mt-2" style="display: none">
            <p class="mt-2 text-sm text-red-600"></p>
          </div>
          <div class="mt-2" style="display: none">
            <p class="mt-2 text-sm text-red-600"></p>
          </div> -->
          </div>
          <!-- <div class="mt-4">
            <PrimaryButton type="submit" :disabled="form.processing"
              >Save Timesheet</PrimaryButton
            >
          </div> -->
        </form>
        <div>
          <div class="mb-3 inline-flex align-top">
            <h3 class="mt-1 font-medium">Assign tasks to hours</h3>
            <!---->
          </div>
          <!---->
          <div v-for="(task, index) in tasks" :key="index">
            <div>
              <div
                class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-4 md:mb-4"
                id="timeSheet_0_projectTaskTime_0"
              >
                <div class="">
                  <select
                    class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm disabled:opacity-50"
                    v-model="task.selectedProjectId"
                    :disabled="index > 0"
                  >
                    <option value="">Select project</option>
                    <option
                      v-for="project in user.projects"
                      :key="project.id"
                      :value="project.id"
                      class="capitalize"
                    >
                      {{ project.project_name }}
                    </option>
                  </select>
                </div>
                <div>
                  <select
                    class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm disabled:opacity-50"
                    v-model="task.selectedBuildingId"
                  >
                    <option value="">Select building</option>
                    <option
                      v-for="building in filteredBuildings(
                        task.selectedProjectId
                      )"
                      :key="building.id"
                      :value="building.id"
                      class="capitalize"
                    >
                      {{ building.name }}
                    </option>
                  </select>
                </div>
                <div>
                  <select
                    class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm disabled:opacity-50"
                    v-model="task.code"
                  >
                    <option value="">Select task</option>
                    <option
                      v-for="task in filteredTasks(
                        task.selectedProjectId,
                        task.selectedBuildingId
                      )"
                      :key="task.id"
                      :value="task.id"
                      class="capitalize"
                    >
                      {{ task.code }}
                    </option>
                  </select>
                </div>
                <div>
                  <div id="hours" class="disabled:opacity-50">
                    <input
                      class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
                      autocomplete="off"
                      placeholder="Hours worked"
                      required=""
                      type="number"
                      step="0.25"
                      min="0"
                      max=""
                      value=""
                      v-model="task.hours"
                    /><!---->
                  </div>
                </div>
              </div>
              <!-- <div class="mt-2" style="display: none">
                <p class="mt-2 text-sm text-red-600"></p>
              </div>
              <div class="mt-2" style="display: none">
                <p class="mt-2 text-sm text-red-600"></p>
              </div>
              <div class="mt-2" style="display: none">
                <p class="mt-2 text-sm text-red-600"></p>
              </div>
              <div class="mt-2" style="display: none">
                <p class="mt-2 text-sm text-red-600"></p>
              </div> -->
            </div>
          </div>
          <div v-if="isHoursMismatch" class="text-red-500 font-bold">
            Assigned hours higher than shift hours
          </div>
          <div class="my-6 flex">
            <div class="none flex">
              <button
                type="button"
                class="text-sm px-4 py-2 bg-white text-gray-900 hover:bg-gray-100 focus:ring-white inline-flex items-center justify-center rounded-md border border-transparent font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto mr-2 flex disabled:opacity-50"
                @click="addTask"
                :disabled="isAddTaskDisabled"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  aria-hidden="true"
                  data-slot="icon"
                  class="mr-2 h-4 w-4"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 4.5v15m7.5-7.5h-15"
                  ></path>
                </svg>
                Task</button
              ><button
                type="button"
                @click="removeTask"
                :disabled="isTaskbuttondisabled"
                class="text-sm px-4 py-2 bg-white text-gray-900 hover:bg-gray-100 focus:ring-white inline-flex items-center justify-center rounded-md border border-transparent font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto flex disabled:opacity-50"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  aria-hidden="true"
                  data-slot="icon"
                  class="mr-2 h-4 w-4"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M5 12h14"
                  ></path>
                </svg>
                Task
              </button>
            </div>

            <div class="flex-auto whitespace-nowrap text-right items-center">
              <span :class="{ 'text-red-500': isHoursMismatch }">
                {{ totalTaskHours }}
              </span>
              / {{ shiftHours }}
              <span> assigned</span>
            </div>
          </div>
          <div class="mb-6">
            <div class="flex items-center justify-between" for="laser">
              <label class="block text-sm font-medium text-gray-700"
                ><span>Laser allowance</span></label
              ><!---->
            </div>
            <div
              class="mt-2 space-y-4 sm:flex sm:items-center sm:space-x-10 sm:space-y-0"
            >
              <div class="flex items-center">
                <input
                  id="timeSheet_0_laser_yes"
                  class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600 disabled:opacity-50"
                  name="laser"
                  type="radio"
                  value="true"
                /><label
                  class="ml-3 block text-sm font-medium leading-6 text-gray-900"
                  for="timeSheet_0_laser_yes"
                >
                  Yes
                </label>
              </div>
              <div class="flex items-center">
                <input
                  id="timeSheet_0_laser_no"
                  class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600 disabled:opacity-50"
                  name="laser"
                  type="radio"
                  value="false"
                /><label
                  class="ml-3 block text-sm font-medium leading-6 text-gray-900"
                  for="timeSheet_0_laser_no"
                >
                  No
                </label>
              </div>
            </div>
            <div class="mt-2" style="display: none">
              <p class="mt-2 text-sm text-red-600"></p>
            </div>
          </div>
          <div class="mb-6">
            <div
              class="flex items-center justify-between"
              for="timeSheet_0_marker"
            >
              <label class="block text-sm font-medium text-gray-700"
                ><span>Marker/setter out allowance (In hours)</span></label
              ><!---->
            </div>
            <div id="timeSheet_0_marker" class="disabled:opacity-50">
              <input
                v-model.number="form.marker_allowance"
                class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
                autocomplete="off"
                placeholder="Hours spent working on marker/setter out"
                required=""
                type="number"
                step="0.25"
                min="0"
                max="5"
              /><!---->
            </div>
            <div class="mt-2" style="display: none">
              <p class="mt-2 text-sm text-red-600"></p>
            </div>
          </div>
          <div class="mb-6">
            <div
              class="flex items-center justify-between"
              for="timeSheet_0_insulation"
            >
              <label class="block text-sm font-medium text-gray-700"
                ><span>Insulation allowance (In hours)</span></label
              ><!---->
            </div>
            <div id="timeSheet_0_insulation">
              <input
                v-model.number="form.insulation_allowance"
                class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
                autocomplete="off"
                placeholder="Hours spent working with insulation"
                required=""
                type="number"
                step="0.25"
                min="0"
                max="0"
              /><!---->
            </div>
            <div class="mt-2" style="display: none">
              <p class="mt-2 text-sm text-red-600"></p>
            </div>
          </div>
        </div>
        <h3 class="font-medium">Notes</h3>
        <div class="grid grid-cols-12 content-center gap-4">
          <div class="col-span-11">
            <div class="mt-1">
              <textarea
                placeholder="Optional notes"
                class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                value=""
                v-model="form.notes"
              ></textarea>
            </div>
            <!---->
          </div>
          <div><!----></div>
        </div>
        <div class="mt-2" style="display: none">
          <p class="mt-2 text-sm text-red-600"></p>
        </div>
      </div>
      <div class="my-6 flex">
        <div class="none flex">
          <button
            type="button"
            class="text-sm px-4 py-2 bg-gray-100 text-gray-900 hover:bg-gray-200 focus:ring-gray-200 inline-flex items-center justify-center rounded-md border border-transparent font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto mr-2 flex disabled:opacity-50"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              aria-hidden="true"
              data-slot="icon"
              class="mr-2 h-4 w-4"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 4.5v15m7.5-7.5h-15"
              ></path>
            </svg>
            Hours</button
          ><button
            type="button"
            class="text-sm px-4 py-2 bg-gray-100 text-gray-900 hover:bg-gray-200 focus:ring-gray-200 inline-flex items-center justify-center rounded-md border border-transparent font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto flex disabled:opacity-50"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              aria-hidden="true"
              data-slot="icon"
              class="mr-2 h-4 w-4"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M5 12h14"
              ></path>
            </svg>
            Hours
          </button>
        </div>
      </div>
      <div class="mt-8 space-x-2">
        <PrimaryButton
          @click="submit"
          :disabled="form.processing"
          type="button"
          class="text-lg px-4 py-2 bg-blue-500 text-white hover:bg-blue-600 focus:ring-blue-400 inline-flex items-center justify-center rounded-md border border-transparent font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto mr-2 disabled:opacity-50"
        >
          Save</PrimaryButton
        >
        <UnderlineLink :href="route('timesheet.index')">Cancel</UnderlineLink>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref, computed, watch, onMounted } from "vue";
import { usePage, Link, useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import UnderlineLink from "@/Components/UnderlineLink.vue";

// Define breadcrumbs for the page navigation

// Define props received from the backend
const props = defineProps({
  date: {
    type: String,
    required: false,
  },
  timesheet: {
    type: Object,
  },
  user: {
    type: Object,
  },
});
console.log(props.timesheet.project_id);
const crumbspage = ref([
  { label: "Home", href: "/dashboard" },
  { label: "Timesheets", href: "/time-sheets" },
  { label: `${props.user.name}'s timesheet`, href: "/time-sheets" },
  { label: "Manage timesheet", href: "/time-sheets" },
]);
const tasks = ref(
  props.timesheet.tasks && props.timesheet.tasks.length > 0
    ? props.timesheet.tasks.map((task) => ({
        selectedProjectId: task.selectedProjectId || "", // Ensure this has a value
        selectedBuildingId: task.selectedBuildingId || "", // Initialize with empty string or a default value
        code: task.code || "", // Ensure code is properly initialized
        hours: task.hours || "", // Ensure hours is properly initialized
      }))
    : [
        {
          selectedProjectId: "", // Default to empty string
          selectedBuildingId: "", // Default to empty string
          code: "", // Default to empty string
          hours: "", // Default to empty string
        },
      ]
);

const tasksData = computed(() => {
  return tasks.value.map((task) => ({
    selectedProjectId: task.selectedProjectId,
    selectedBuildingId: task.selectedBuildingId,
    code: task.code,
    hours: task.hours,
  }));
});
const projectId = computed(() => {
  return tasks.value[0]?.selectedProjectId || "";
});

const form = useForm({
  user_id: props.user.id,

  project_id: projectId || "",
  date: props.date,
  start_time: {
    hour: props.timesheet.start_time.hour || "06",
    minute: props.timesheet.start_time.minute || "30",
  },
  end_time: {
    hour: props.timesheet.end_time.hour || "",
    minute: props.timesheet.end_time.minute || "",
  },
  notes: props.timesheet.notes || "",
  laser_allowance: props.timesheet.laser_allowance || "",
  marker_allowance: props.timesheet.marker_allowance || "",
  insulation_allowance: props.timesheet.insulation_allowance || "",
  tasks: tasksData,
  ...(props.timesheet.timesheet_id
    ? { timesheet_id: props.timesheet.timesheet_id }
    : {}),
});

const errortaskhours = ref("");
// Arrays for hour and minute options
const hours = Array.from({ length: 24 }, (_, i) =>
  i.toString().padStart(2, "0")
);
const minutes = ["00", "15", "30", "45"];

// Formatting hour for display
const formatHour = (hour) => {
  const hourInt = parseInt(hour);
  return hourInt < 12
    ? `${hourInt} am`
    : `${hourInt === 12 ? 12 : hourInt - 12} pm`;
};

const addTask = () => {
  const firstTaskProjectId =
    tasks.value.length > 0 ? tasks.value[0].selectedProjectId : null;
  // Check if the first task's selected project ID is valid
  if (firstTaskProjectId) {
    // Push a new task object into the tasks array if the project ID is not null or empty
    tasks.value.push({
      selectedProjectId: firstTaskProjectId, // Use the selected project ID from the first task
      selectedBuildingId: "",
      code: "",
      hours: "",
    });
  } else {
    // Optionally, you can show a notification or a message that the project must be selected
    console.warn("Cannot add task: The selected project must not be empty.");
  }
};
const removeTask = () => {
  tasks.value.splice(tasks.value.length - 1, 1);
};
const isTaskbuttondisabled = computed(() => tasks.value.length === 1);
// State for the selected project, building, and task
const selectedProject = ref(""); // Holds the selected project ID
const selectedBuilding = ref(""); // Holds the selected building ID
const selectedTask = ref(""); // Holds the selected task ID
// const shiftHours = ref(0);

// Computed property to calculate hours worked
const shiftHours = computed(() => {
  // Get start and end hours and minutes
  const startHour = parseInt(form.start_time.hour, 10);
  const startMinute = parseInt(form.start_time.minute, 10);
  const endHour = parseInt(form.end_time.hour, 10);
  const endMinute = parseInt(form.end_time.minute, 10);

  // If any of the time fields are missing, return 0 hours
  if (
    isNaN(startHour) ||
    isNaN(startMinute) ||
    isNaN(endHour) ||
    isNaN(endMinute)
  ) {
    return 0;
  }

  // Convert start and end time into minutes
  const startTimeInMinutes = startHour * 60 + startMinute;
  const endTimeInMinutes = endHour * 60 + endMinute;

  // Calculate the difference in minutes (handle end time on the next day)
  const totalMinutesWorked =
    endTimeInMinutes >= startTimeInMinutes
      ? endTimeInMinutes - startTimeInMinutes
      : 1440 - startTimeInMinutes + endTimeInMinutes; // 1440 = total minutes in a day

  // Convert total minutes back into hours and minutes
  const totalHours = Math.floor(totalMinutesWorked / 60);
  const remainingMinutes = totalMinutesWorked % 60;

  // Return total hours as a decimal value (e.g., 3.5 hours for 3 hours 30 minutes)
  return totalHours + remainingMinutes / 60;
});

const totalTaskHours = computed(() => {
  // Sum all the hours from the tasks array
  return tasks.value.reduce((sum, task) => sum + (task.hours || 0), 0);
});
const isAddTaskDisabled = computed(() => {
  // Get the selected project ID from the first task
  const firstTaskProjectId = tasks.value[0]?.selectedProjectId;

  // Disable button if the project ID is null or empty
  return !firstTaskProjectId;
});
const isHoursMismatch = computed(() => totalTaskHours.value > shiftHours.value);
// Computed property to filter buildings based on the selected project
const filteredBuildings = (selectedProjectId) => {
  // Return an empty array if no project is selected for this row
  if (!selectedProjectId) return [];

  // Find the project that matches the selected project ID
  const project = props.user.projects.find(
    (project) => project.id === selectedProjectId
  );
  console.log(
    "Filtered Buildings for project:",
    selectedProjectId,
    project ? project.buildings : []
  );

  // Return the buildings associated with the project, or an empty array if not found
  return project ? project.buildings : [];
};

// Computed property to filter tasks based on the selected building
const filteredTasks = (selectedProjectId, selectedBuildingId) => {
  // Return an empty array if no project or building is selected
  if (!selectedProjectId || !selectedBuildingId) return [];

  // Find the selected project
  const project = props.user.projects.find(
    (project) => project.id === selectedProjectId
  );

  // Find the selected building within the project
  const building = project
    ? project.buildings.find((building) => building.id === selectedBuildingId)
    : null;

  // Return the tasks associated with the building, or an empty array if not found
  return building ? building.tasks : [];
};
// Function to handle project selection

// Function to format the date from "DD-MM-YYYY" to "Tue, 10 Sep"
function formatDate(inputDate) {
  // Split the input date into day, month, and year
  const [day, month, year] = inputDate.split("-");

  // Create a new Date object using the parsed values
  const date = new Date(`${year}-${month}-${day}`);

  // Define options for formatting the date
  const options = { day: "2-digit", month: "short" };

  // Return the formatted date string, removing the comma
  return date.toLocaleDateString("en-GB", options).replace(/,/, "");
}

// Submit form data
const submit = () => {
  form.post("/time-sheets/create", {
    onSuccess: () => {
      console.log("Timesheet saved successfully");
    },
    onError: (errors) => {
      console.error("Form submission errors:", errors);
    },
  });
};
</script>