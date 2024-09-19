<template>
  <AuthenticatedLayout>
    <header class="bg-gray-100 py-3 px-4 sm:px-4 md:px-6">
      <div class="container mx-auto">
        <nav class="py-2 pl-2 flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900">
              Edit daily pre-start
            </h1>
            <div>
              <Breadcrumb :crumbs="crumbspage" />
            </div>
          </div>
          <Link :href="route('daily-prestarts.create')">
            <PrimaryButton>Create Daily Pre-Start</PrimaryButton>
          </Link>
        </nav>
      </div>
    </header>
    <div class="max-w-xl mx-auto m-4 p-8 rounded-lg">
      <form @submit.prevent="submitForm">
        <div class="grid grid-cols-1 gap-6">
          <h4 class="mb-3 text-lg font-bold">Daily pre-start basics</h4>
          <div>
            <label class="block text-sm font-medium text-gray-700"
              >Work date</label
            >
            <input
              type="date"
              v-model="form.prestart.workdate"
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700"
              >Project</label
            >
            <select
              v-model="form.prestart.project_id"
              class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm"
            >
              <option value="">Search by project</option>
              <!-- <option value="1">Active</option>
          <option value="0">Inactive</option> -->
              <optgroup label="Active projects">
                <option
                  v-for="(project, index) in projects_active"
                  :key="index"
                  :value="project.id"
                >
                  {{ project.project_name }}
                </option>
              </optgroup>
              <optgroup label="Completed projects">
                <option
                  v-for="(project, index) in projects_completed"
                  :key="index"
                  :value="project.id"
                >
                  {{ project.project_name }}
                </option>
              </optgroup>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700"
              >Foreman</label
            >
            <select
              v-model="form.prestart.foreman_id"
              class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm"
            >
              <option value="">Please select a foreman</option>
              <option
                v-for="(foreman, index) in foremen"
                :key="index"
                :value="foreman.id"
              >
                {{ foreman.name }}
              </option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700"
              >Weather</label
            >
            <input
              type="text"
              v-model="form.prestart.weather"
              placeholder="Describe the weather"
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700"
              >Weather impact</label
            >
            <input
              type="text"
              v-model="form.prestart.weather_impact"
              placeholder="Describe the weather impact"
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            />
          </div>
          <div class="flex items-center">
            <input
              type="checkbox"
              :true-value="1"
              :false-value="0"
              class="h-4 w-4 text-blue-600 border-gray-300 rounded"
            />
            <label for="completed" class="ml-2 block text-sm text-gray-900"
              >Include COVID warning on daily pre-start</label
            >
          </div>
          <hr class="mb-4 mt-2" />
          <h4 class="mb-6 text-lg font-bold">
            General site works / activities
          </h4>
          <p class="">
            Program, high risk activities, inspections, exclusion zones, work
            permits, deliveries, etc.
          </p>
          <div
            v-for="(activity, index) in prestart.activities"
            :key="index"
            class="flex items-center space-x-1"
          >
            <TextInput
              type="text"
              :placeholder="`${index + 1}. Describe the site works / activity`"
              class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
              v-model="activity.name"
            />
          </div>
          <!-- <PrimaryButton type="button" @click="addActivity"
            >Add Income</PrimaryButton
          > -->
          <div>
            <button
              type="button"
              @click="addActivity"
              class="text-sm px-4 py-2 bg-gray-100 text-gray-900 hover:bg-gray-200 focus:ring-gray-200 inline-flex items-center justify-center rounded-md border border-transparent font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto mr-2"
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
              Activity
            </button>
            <button
              type="button"
              @click="removeActivity"
              :disabled="isButtonDisabled"
              class="text-sm px-4 py-2 bg-gray-100 text-gray-900 hover:bg-gray-200 focus:ring-gray-200 inline-flex items-center justify-center rounded-md border border-transparent font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto mr-2"
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
              Activity
            </button>
          </div>

          <div modelvalue="[object Object]" class="mb-6">
            <div class="flex w-full items-center justify-center">
              <label
                for="dailyPrestartActivityFiles"
                class="dark:hover:bg-bray-800 flex h-32 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:border-gray-500 dark:hover:bg-gray-600"
              >
                <div
                  class="flex flex-col items-center justify-center pb-3 pt-2"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    aria-hidden="true"
                    data-slot="icon"
                    class="h-10 w-10 text-gray-500 dark:text-gray-400"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z"
                    ></path>
                  </svg>
                  <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                    Upload general site works / activity files here
                  </p>
                  <!---->
                </div>
                <input
                  id="dailyPrestartActivityFiles"
                  multiple=""
                  class="hidden"
                  type="file"
              /></label>
            </div>
            <hr class="mb-4 mt-8" />
            <div class="py-4">
              <h4 class="mb-6 text-lg font-bold">
                Safety concerns / incidents
              </h4>
              <p class="">Items to be raised from the previous day.</p>
              <div
                v-for="(incident, index) in prestart.incidents"
                :key="index"
                class="flex items-center space-x-1 py-3"
              >
                <TextInput
                  type="text"
                  :placeholder="`${
                    index + 1
                  }. Describe the safety concern / incident`"
                  class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
                  v-model="incident.name"
                />
              </div>
              <!-- <PrimaryButton type="button" @click="addActivity"
            >Add Income</PrimaryButton
          > -->
              <div class="py-3">
                <button
                  type="button"
                  @click="addIncident"
                  class="text-sm px-4 py-2 bg-gray-100 text-gray-900 hover:bg-gray-200 focus:ring-gray-200 inline-flex items-center justify-center rounded-md border border-transparent font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto mr-2"
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
                  Incident
                </button>
                <button
                  type="button"
                  @click="removeIncident"
                  :disabled="isIncidentButtonDisabled"
                  class="text-sm px-4 py-2 bg-gray-100 text-gray-900 hover:bg-gray-200 focus:ring-gray-200 inline-flex items-center justify-center rounded-md border border-transparent font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto mr-2"
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
                  Incident
                </button>
              </div>

              <div modelvalue="[object Object]" class="mt-2">
                <div class="flex w-full items-center justify-center">
                  <label
                    for="dailyPrestartActivityFiles"
                    class="dark:hover:bg-bray-800 flex h-32 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:border-gray-500 dark:hover:bg-gray-600"
                  >
                    <div
                      class="flex flex-col items-center justify-center pb-3 pt-2"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        aria-hidden="true"
                        data-slot="icon"
                        class="h-10 w-10 text-gray-500 dark:text-gray-400"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z"
                        ></path>
                      </svg>
                      <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                        Upload builders daily pre-start file here
                      </p>
                      <!---->
                    </div>
                    <input
                      id="dailyPrestartActivityFiles"
                      multiple=""
                      class="hidden"
                      type="file"
                  /></label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="flex justify-start items-center space-x-2">
          <PrimaryButton type="submit">Update daily pre-start</PrimaryButton>

          <UnderlineLink :href="route('daily-prestarts.index')"
            >Cancel</UnderlineLink
          >
        </div>
      </form>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Link } from "@inertiajs/inertia-vue3";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { ref, watch, computed } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import UnderlineLink from "@/Components/UnderlineLink.vue";

const props = defineProps({
  projects_completed: Array,
  projects_active: Array,
  foremen: Array,
  prestart: Object,
});

const crumbspage = ref([
  { label: "Home", href: "/dashboard" },
  { label: "Daily-Prestarts", href: "/daily-prestarts" },
  { label: "Edit", href: "/daily-prestarts/create" },
]);

const activities = ref(props.prestart.activities || [{ name: "" }]);
const incidents = ref(props.prestart.incidents || [{ name: "" }]);

const isButtonDisabled = computed(() => activities.value.length === 1);
const isIncidentButtonDisabled = computed(() => incidents.value.length === 1);

const addActivity = () => {
  activities.value.push({ name: "" });
};
const removeActivity = () => {
  if (activities.value.length > 1) {
    activities.value.splice(activities.value.length - 1, 1);
  }
};

const addIncident = () => {
  incidents.value.push({ name: "" });
};
const removeIncident = () => {
  if (incidents.value.length > 1) {
    incidents.value.splice(incidents.value.length - 1, 1);
  }
};

// Initialize the form using useForm
const form = useForm({
  prestart: {
    workdate: props.prestart.workdate || new Date().toISOString().substr(0, 10), // Default to today's date
    foreman_id: props.prestart.foreman_id || "",
    weather: props.prestart.weather || "",
    weather_impact: props.prestart.weather_impact || "",
    project_id: props.prestart.project_id || "", // Added project_id here since it's part of prestart
  },
  activities: activities.value,
  incidents: incidents.value,
});

const submitForm = () => {
  form.activities = activities.value.map((activity) => ({
    name: activity.name,
  }));

  form.incidents = incidents.value.map((incident) => ({
    name: incident.name,
  }));

  form.daily_prestart = props.prestart ? props.prestart.id : "";

  // Submit the form to the Laravel backend
  form.put(route("daily-prestarts.update", props.prestart.id));
};
</script>
