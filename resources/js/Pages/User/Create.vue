<template>
  <AuthenticatedLayout>
    <header class="bg-gray-100 py-3 px-4 sm:px-4 md:px-6">
      <div class="container mx-auto">
        <nav class="py-2 pl-2 flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900">Create user</h1>
            <div>
              <Breadcrumb :crumbs="crumbspage" />
            </div>
          </div>
        </nav>
      </div>
    </header>
    <div class="px-4 py-4 sm:px-6 md:px-8">
      <form class="mx-auto mt-8 max-w-lg" @submit.prevent="submitForm">
        <div class="mb-6">
          <div class="flex items-center justify-between" for="title">
            <label class="block text-sm font-medium text-gray-700"
              ><span>Name</span></label
            ><!---->
          </div>
          <div id="name" class="mt-1">
            <input
              class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
              autocomplete="off"
              autofocus=""
              required=""
              type="text"
              step=""
              min=""
              max=""
              v-model="form.name"
            /><!---->
          </div>
          <div v-if="form.errors.name" class="mt-2 text-sm text-red-600">
            {{ form.errors.name }}
          </div>
        </div>
        <div class="mb-6">
          <div class="flex items-center justify-between" for="email">
            <label class="block text-sm font-medium text-gray-700"
              ><span>Email</span></label
            ><!---->
          </div>
          <div id="email" class="mt-1">
            <input
              class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
              autocomplete="off"
              required=""
              type="email"
              step=""
              min=""
              max=""
              v-model="form.email"
            /><!---->
          </div>
          <div v-if="form.errors.email" class="mt-2 text-sm text-red-600">
            {{ form.errors.email }}
          </div>
        </div>
        <div class="mb-6">
          <div class="flex items-center justify-between" for="mobile">
            <label class="block text-sm font-medium text-gray-700"
              ><span>Mobile</span></label
            ><!---->
          </div>
          <div id="mobile" class="mt-1">
            <input
              class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
              autocomplete="off"
              required=""
              type="tel"
              step=""
              min=""
              max=""
              v-model="form.phone_number"
            /><!---->
          </div>
          <div
            v-if="form.errors.phone_number"
            class="mt-2 text-sm text-red-600"
          >
            {{ form.errors.phone_number }}
          </div>
        </div>
        <div class="mb-6">
          <div class="flex items-center justify-between" for="birthday">
            <label class="block text-sm font-medium text-gray-700"
              ><span>Birthday</span></label
            ><!---->
          </div>
          <div id="birthday" class="mt-1">
            <input
              class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
              autocomplete="off"
              type="date"
              step=""
              min=""
              max="2009-10-02"
            /><!---->
          </div>
          <div v-if="form.errors.birthday" class="mt-2 text-sm text-red-600">
            {{ form.errors.birthday }}
          </div>
        </div>
        <div class="mb-6">
          <div class="flex items-center justify-between" for="employee_type_id">
            <label class="block text-sm font-medium text-gray-700"
              ><span>Employee type</span></label
            ><!---->
          </div>
          <select
            class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm mt-1"
            id="employee_type_id"
            v-model="form.employee_type"
          >
            <option value="">Select employee type</option>
            <option
              v-for="option in employee_types"
              :key="option.id"
              :value="option.name"
            >
              {{ option.name }}
            </option>
          </select>
          <div
            v-if="form.errors.employee_type"
            class="mt-2 text-sm text-red-600"
          >
            {{ form.errors.employee_type }}
          </div>
        </div>
        <div class="mb-6">
          <div
            class="flex items-center justify-between"
            for="employee_id_superior"
          >
            <label class="block text-sm font-medium text-gray-700"
              ><span>Superior Walls &amp; Ceilings ID</span></label
            ><span class="text-sm text-gray-500" id="email-optional"
              >Optional</span
            >
          </div>
          <div id="employee_id_superior" class="mt-1">
            <input
              class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
              autocomplete="off"
              type="text"
              step=""
              min=""
              max=""
              v-model="form.superior_id"
            /><!---->
          </div>
          <div v-if="form.errors.superior_id" class="mt-2 text-sm text-red-600">
            {{ form.errors.superior_id }}
          </div>
        </div>
        <div class="mb-6">
          <div
            class="flex items-center justify-between"
            for="employee_id_greenline"
          >
            <label class="block text-sm font-medium text-gray-700"
              ><span>Greenline ID</span></label
            ><span class="text-sm text-gray-500" id="email-optional"
              >Optional</span
            >
          </div>
          <div id="employee_id_greenline" class="mt-1">
            <input
              class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
              autocomplete="off"
              type="text"
              step=""
              min=""
              max=""
              v-model="form.greenline_id"
            /><!---->
          </div>
          <div
            v-if="form.errors.greenline_id"
            class="mt-2 text-sm text-red-600"
          >
            {{ form.errors.greenline_id }}
          </div>
        </div>
        <div class="flex items-center space-x-2 mb-6">
          <input
            id="connector"
            type="checkbox"
            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
          /><label for="connector" class="ml-2 block text-sm text-gray-900"
            >Connector or ASIST worker
          </label>
        </div>
        <div class="mb-6">
          <div class="flex items-center justify-between" for="projects">
            <label class="block text-sm font-medium text-gray-700">
              <span>Assign to projects</span>
            </label>
            <span class="text-sm text-gray-500" id="email-optional"
              >Optional</span
            >
          </div>

          <!-- Display selected projects as chips -->
          <div class="flex flex-wrap gap-2 mt-2">
            <template v-for="(project, index) in selectedProjects" :key="index">
              <div
                class="flex items-center px-2 py-1 text-xs bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-full cursor-pointer"
                @click="removeProject(project)"
              >
                <span class="mr-2">{{ project.project_name }}</span>
                <span class="text-blue-700 cursor-pointer">×</span>
              </div>
            </template>
          </div>

          <div
            class="mt-1 block w-full overflow-auto rounded-md border border-gray-300 bg-white p-3 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm mt-1"
          >
            <button
              id="headlessui-listbox-button-v-2"
              type="button"
              aria-haspopup="listbox"
              aria-expanded="false"
              class="w-full border-b pb-2 text-left"
            >
              <span>Select projects</span>
            </button>
            <ul
              aria-multiselectable="true"
              aria-orientation="vertical"
              role="listbox"
              tabindex="0"
              class="mt-2 block h-32 w-full overflow-scroll bg-white text-base sm:text-sm"
            >
              <li
                v-for="project in projects"
                :key="project"
                @click="toggleProject(project)"
                class="block p-1 hover:bg-gray-200 cursor-pointer"
              >
                {{ project.project_name }}
              </li>
            </ul>
          </div>

          <div class="mt-2" style="display: none">
            <p class="mt-2 text-sm text-red-600"></p>
          </div>
        </div>

        <div class="flex items-center justify-between">
          <label class="block text-sm font-medium text-gray-700"
            ><span>Additional permissions</span></label
          ><span class="text-sm text-gray-500" id="email-optional"
            >Optional</span
          >
        </div>
        <div
          v-for="permission in permissions"
          :key="permission.id"
          class="flex items-center space-x-2 mb-4"
        >
          <input
            :id="permission.id"
            type="checkbox"
            v-model="form.userPermissions"
            :value="permission.name"
            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
          />
          <label :for="permission.id" class="ml-2 block text-sm text-gray-900">
            {{ permission.name }}
          </label>
        </div>

        <div class="flex">
          <button
            type="submit"
            class="text-sm px-4 py-2 bg-blue-500 text-white hover:bg-blue-600 focus:ring-blue-400 inline-flex items-center justify-center rounded-md border border-transparent font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto"
          >
            Save</button
          ><Link
            class="text-blue-600 hover:text-blue-900 ml-6 mt-2"
            :href="route('users.index')"
            >Cancel</Link
          >
        </div>
      </form>
    </div>
  </AuthenticatedLayout>
</template>
  <script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { getColorByEmployeeType } from "@/Helpers/colorHelpers";
// import Avatar from "vue3-avatar";
import Avatar from "vue-avatar-3";
import { directive as vTippy } from "vue-tippy";
import "tippy.js/themes/light-border.css";
import "tippy.js/animations/shift-away.css";
import TextInput from "@/Components/TextInput.vue";
// import Tooltip from "@/Components/Tooltip.vue";
const props = defineProps({
  employee_types: {
    type: Array,
    required: true,
  },
  projects: {
    type: Array,
  },
  permissions: {
    type: Array,
  },
});
const crumbspage = ref([
  { label: "Home", href: "/dashboard" },
  { label: "Users", href: "/users" },

  { label: "Create", href: "" },
]);
const selectedProjects = ref([]);
const form = useForm({
  name: "",
  email: "",
  employee_type: "",
  phone_number: "",
  superior_id: "",
  greenline_id: "",
  userPermissions: [],
  selectedProjects: selectedProjects.value,
});

const submitForm = () => {
  // Submit the form to the Laravel backend
  form.post(route("users.store"));
};

// const projects = [
//   "Stratton Street",
//   "Pavilion - Bilinga",
//   "Queens Wharf - Package B",
//   "Tweed Valley Program Status",
//   "USC Petrie",
//   "300 George Street - Additional Works",
//   "QSAC",
//   "Pacific Parade",
//   "SCUH PMJ Rectification",
//   "HI Reefview Hotel Stage 1",
//   "VOCO Hotel Refurb",
//   "JAY - Test Bulk upload",
// ];

// Reactive array to track selected projects

// Function to toggle project selection
const toggleProject = (project) => {
  if (selectedProjects.value.includes(project)) {
    selectedProjects.value = selectedProjects.value.filter(
      (item) => item !== project
    );
  } else {
    selectedProjects.value.push(project);
  }
  form.selectedProjects = selectedProjects.value;
};

// Function to remove project when chip is clicked
const removeProject = (project) => {
  selectedProjects.value = selectedProjects.value.filter(
    (item) => item !== project
  );
};
</script>