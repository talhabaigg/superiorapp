<template>
  <AuthenticatedLayout>
    <header class="bg-gray-100 py-3 px-4 sm:px-4 md:px-6">
      <div class="container mx-auto">
        <nav class="py-2 pl-2 flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900">Team</h1>
            <div>
              <Breadcrumb :crumbs="crumbspage" />
            </div>
          </div>
          <Link :href="route('users.create')" class="mx-2">
            <PrimaryButton>Create User</PrimaryButton>
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
          v-model="selectedEmployeeType"
          class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm"
        >
          <option value="">All Employee Types</option>
          <option v-for="type in employee_types" :key="type" :value="type">
            {{ type }}
          </option>
        </select>
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
        class="mt-2 relative overflow-x-scroll mx-auto rounded-lg sm:block overflow-y-auto border shadow-md"
      >
        <table
          class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
        >
          <thead class="bg-gray-100">
            <tr>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              ></th>
              <th
                scope="col"
                class="py-3 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
              >
                Name
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
                Superior ID
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                Greenline ID
              </th>
              <th
                scope="col"
                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell"
              >
                Email
              </th>
              <th
                scope="col"
                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell"
              >
                Mobile
              </th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 bg-white">
            <tr v-for="user in users.data" :key="user.id">
              <td
                class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap"
              >
                <Avatar
                  v-tippy="{
                    content: user.name,
                    delay: [100, 200],
                    inertia: true,
                    placement: 'top',
                    arrow: false,
                    theme: 'light-border',
                    animation: 'shift-away',
                  }"
                  :name="user.name"
                  :bgColor="getColorByEmployeeType(user.employee_type)"
                  size="36px"
                />
              </td>
              <td
                class="w-full max-w-0 overflow-hidden whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6"
              >
                <div>
                  <div
                    v-if="user.is_active === 1"
                    class="text-blue-600 hover:text-blue-900"
                  >
                    <Link :href="route('users.show', user.id)">{{
                      user.name
                    }}</Link>
                  </div>
                  <div
                    v-else
                    class="text-blue-600 hover:text-blue-900 line-through"
                  >
                    <Link :href="route('users.show', user.id)"
                      >{{ user.name }} (Deleted user)</Link
                    >
                  </div>
                </div>
              </td>
              <td
                class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap"
              >
                {{ user.employee_type }}
              </td>
              <td class="hidden sm:table-cell">
                <div
                  class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap"
                >
                  {{ user.superior_id }}
                </div>
              </td>
              <td
                class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap"
              >
                {{ user.greenline_id }}
              </td>
              <td>
                <div class="text-blue-600 hover:text-blue-900">
                  {{ user.email }}
                </div>
              </td>
              <td>
                <a
                  :href="'tel:' + user.phone_number"
                  class="text-blue-600 hover:text-blue-900"
                >
                  {{ user.phone_number }}
                </a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="flex justify-between items-center p-4 mx-auto max-w-7xl">
        <div
          v-if="users.data.length"
          class="w-full flex justify-center mt-8 mb-8"
        >
          <Pagination :links="users.links" />
        </div>
        <!-- <button
          @click="prevPage"
          :disabled="currentPage === 1"
          class="relative inline-flex items-center border px-4 py-2 text-sm font-medium focus:z-20 border-gray-300 bg-white text-gray-500 rounded-l-md disabled:opacity-50"
        >
          Previous
        </button>
        <span class="text-sm text-gray-700 m-2"
          >Page {{ currentPage }} of {{ totalPages }}</span
        >
        <button
          @click="nextPage"
          :disabled="currentPage === totalPages"
          class="relative inline-flex items-center border px-4 py-2 text-sm font-medium focus:z-20 border-gray-300 bg-white text-gray-500 hover:bg-gray-50 rounded-r-md"
        >
          Next
        </button> -->
      </div>
    </div>
  </AuthenticatedLayout>
</template>
  
  <script setup>
import { ref, watch, computed } from "vue";
import { Link, usePage, router } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { getColorByEmployeeType } from "@/Helpers/colorHelpers";
// import Avatar from "vue3-avatar";
import Avatar from "vue-avatar-3";
import { directive as vTippy } from "vue-tippy";
import "tippy.js/themes/light-border.css";
import "tippy.js/animations/shift-away.css";
// Define props
const props = defineProps({
  users: {
    type: Object,
  },
  filters: {
    type: Object,
  },
  employee_types: {
    type: Array,
  },
});
const crumbspage = ref([
  { label: "Home", href: "/dashboard" },
  { label: "Users", href: "/users" },
]);
// Reactive state for search and filter
const searchQuery = ref(props.filters.searchQuery || "");
const selectedEmployeeType = ref(props.filters.selectedEmployeeType || "");
const selectedSubsidiaryType = ref("Superior Walls & Ceilings");
const selectedStatusType = ref(props.filters.selectedStatusType || "");

const getUserIndex = (newQuery, newEmployeeType, newStatusType) => {
  return route("users.index", {
    searchQuery: newQuery,
    selectedEmployeeType: newEmployeeType,
    selectedStatusType: newStatusType,
  });
};

watch([searchQuery, selectedEmployeeType, selectedStatusType], () => {
  router.get(
    getUserIndex(
      searchQuery.value,
      selectedEmployeeType.value,
      selectedStatusType.value
    )
  );
});

const resetFields = () => {
  searchQuery.value = "";
  selectedEmployeeType.value = "";
  selectedStatusType.value = "";
};
</script>
  
