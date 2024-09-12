<template>
  <AuthenticatedLayout>
    <header class="bg-gray-100 py-3 px-4 sm:px-4 md:px-6">
      <div class="container mx-auto">
        <nav class="py-2 pl-2 flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900">
              Report absentees for {{ props.prestart.workdate }} on
              {{ props.prestart.project.project_name }}
            </h1>
            <div>
              <Breadcrumb :crumbs="crumbspage" />
            </div>
          </div>
        </nav>
      </div>
    </header>

    <div class="px-4 py-4 sm:px-6 md:px-8">
      <!-- Form submit handler -->
      <form @submit.prevent="submitForm">
        <div
          class="-mx-4 mt-8 overflow-y-hidden overflow-x-scroll shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg"
        >
          <table class="min-w-full divide-y divide-gray-300">
            <tr>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              ></th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                Name
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell whitespace-nowrap"
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
            <tbody class="divide-y divide-gray-200 bg-white">
              <!-- Loop through absent users -->
              <tr
                class="even:bg-gray-50"
                v-for="user in prestart.prestart_absent"
                :key="user.user.id"
              >
                <td
                  class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell"
                >
                  <span
                    class="h-10 w-10 inline-flex items-center justify-center rounded-full hover:ring-gray-200 h-8 w-8"
                    ><img
                      :src="getAvatarUrl(user.user.avatar)"
                      alt="Avatar"
                      class="h-8 w-8 rounded-full border-2 border-white"
                  /></span>
                </td>
                <td
                  class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell"
                >
                  {{ user.user.name }}
                </td>
                <td
                  class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell"
                >
                  {{ user.user.employee_type }}
                </td>
                <td
                  class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell"
                >
                  <!-- Bind reason select -->
                  <select
                    v-model="user.reason"
                    class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm"
                  >
                    <option value="null">Select reason</option>
                    <option value="3">Annual Leave</option>
                    <option value="17">Attending Training</option>
                    <option value="14">Daily Laser Allowance</option>
                    <option value="12">Employment Ended</option>
                    <option value="15">Hourly Insulation Allowance</option>
                    <option value="18">Industrial Action</option>
                    <option value="16">Marker/Setter Out Allowance</option>
                    <option value="8">Night works</option>
                    <option value="11">Other</option>
                    <option value="9">Other project</option>
                    <option value="5">RDO Taken</option>
                    <option value="4">Sick Leave</option>
                    <option value="10">Training (General)</option>
                    <option value="1">Training at TAFE</option>
                    <option value="13">Unpaid Leave</option>
                  </select>
                </td>
                <td
                  class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell"
                >
                  <!-- Bind notes input -->
                  <input
                    v-model="user.notes"
                    class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
                    autocomplete="off"
                    type="text"
                  />
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="mt-4">
          <PrimaryButton type="submit">Submit Absentees</PrimaryButton>
        </div>
      </form>
    </div>
  </AuthenticatedLayout>
</template>
  
  <script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { router } from "@inertiajs/vue3";

// Props passed from backend
const props = defineProps({
  prestart: Object,
});

// Function to get avatar URL
const getAvatarUrl = (avatarPath) => {
  if (!avatarPath) return "";
  return `${window.location.origin}/${avatarPath}`;
};

// Breadcrumbs for navigation
const crumbspage = ref([
  { label: "Home", href: "/dashboard" },
  { label: props.prestart.project.project_name, href: "/project" },
  { label: "Report absentees", href: "/daily-prestarts" },
]);

// Submit form handler
const submitForm = () => {
  // Prepare data to submit
  const formData = {
    prestart_id: props.prestart.id,
    absentees: props.prestart.prestart_absent.map((user) => ({
      user_id: user.user.id,
      reason: user.reason,
      notes: user.notes,
    })),
  };

  // Send data to store route
  router.post(route("prestart.absentees.store"), formData);
};
</script>
  