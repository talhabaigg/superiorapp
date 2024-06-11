<template>
  <AuthenticatedLayout>
    <div class="p-2">
      <header class="bg-gray-100 py-3 rounded-lg">
        <div class="container mx-auto max-w-7xl">
          <nav class="p-4 flex items-center justify-between">
            <div>
              <h1 class="text-2xl font-semibold text-gray-900">Team</h1>
            </div>
            <Link :href="route('users.create')">
              <div
                class="text-xs px-2.5 py-1.5 bg-blue-500 text-white hover:bg-blue-600 focus:ring-blue-400 inline-flex items-center justify-center rounded-md border border-transparent font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto"
              >
                Create User
              </div>
            </Link>
          </nav>
        </div>
      </header>
      <div
        class="my-2 flex flex-col space-y-2 mx-auto max-w-6xl sm:flex-row sm:items-center sm:space-y-0 sm:space-x-4"
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
          <option value="Plasterer">Plasterer</option>
          <option value="Leading Hand">Leading Hand</option>
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
        class="mt-2 relative overflow-x-auto mx-auto max-w-7xl rounded-lg sm:block overflow-y-hidden"
      >
        <table
          class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
        >
          <thead class="bg-gray-300">
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
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 bg-white">
            <tr v-for="user in paginatedUsers" :key="user.id">
              <td
                class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap"
              >
                <img
                  :src="user.avatar"
                  alt="Avatar"
                  class="h-8 w-8 rounded-full"
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
                    {{ user.name }}
                  </div>
                  <div
                    v-else
                    class="text-blue-600 hover:text-blue-900 line-through"
                  >
                    {{ user.name }} (Deleted user)
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
            </tr>
          </tbody>
        </table>
      </div>
      <div class="flex justify-between items-center p-4 mx-auto max-w-7xl">
        <button
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
        </button>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
  
  <script setup>
import { ref, computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

// Define props
const props = defineProps({
  users: {
    type: Array,
    default: () => [],
  },
});

// Reactive state for search and filter
const searchQuery = ref("");
const selectedEmployeeType = ref("");
const selectedSubsidiaryType = ref("Superior Walls & Ceilings");
const selectedStatusType = ref("1");

// Reactive state for pagination
const currentPage = ref(1);
const itemsPerPage = ref(9);

// Computed property to filter users based on search query and selected employee type
const filteredUsers = computed(() => {
  return props.users.filter((user) => {
    const matchesSearchQuery = user.name
      .toLowerCase()
      .includes(searchQuery.value.toLowerCase());
    const matchesEmployeeType =
      selectedEmployeeType.value === "" ||
      user.employee_type === selectedEmployeeType.value;
    const matchesStatusType =
      selectedStatusType.value === "" ||
      user.is_active.toString() === selectedStatusType.value;
    return matchesSearchQuery && matchesEmployeeType && matchesStatusType;
  });
});

// Computed property for paginated users
const paginatedUsers = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value;
  const end = start + itemsPerPage.value;
  return filteredUsers.value.slice(start, end);
});

// Computed property for total pages
const totalPages = computed(() => {
  return Math.ceil(filteredUsers.value.length / itemsPerPage.value);
});

// Methods for pagination
const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};

const resetFields = () => {
  searchQuery.value = "";
  selectedEmployeeType.value = "";
  selectedStatusType.value = "1";
};
</script>
  
