<template>
  <AuthenticatedLayout>
    <header class="bg-gray-100 py-3">
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
    <div class="px-8">
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
          <option v-for="type in employeeTypes" :key="type" :value="type">
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
        class="mt-2 relative overflow-x-scroll mx-auto rounded-lg sm:block overflow-y-hidden border shadow-md"
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
            <tr v-for="user in filteredUsers" :key="user.id">
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
import { ref, computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

// Define props
const props = defineProps({
  users: {
    type: Object,
  },
});
const crumbspage = ref([
  { label: "Home", href: "/dashboard" },
  { label: "Users", href: "/users" },
]);
// Reactive state for search and filter
const searchQuery = ref("");
const selectedEmployeeType = ref("");
const selectedSubsidiaryType = ref("Superior Walls & Ceilings");
const selectedStatusType = ref("1");

// Reactive state for pagination
const currentPage = ref(1);
const itemsPerPage = ref(9);

const getUniqueEmployeeTypes = (users) => {
  const employeeTypes = users.data.map((user) => user.employee_type);
  return [...new Set(employeeTypes)];
};
const employeeTypes = ref(getUniqueEmployeeTypes(props.users));
// Computed property to filter users based on search query and selected employee type
const filteredUsers = computed(() => {
  return props.users.data.filter((user) => {
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
// const paginatedUsers = computed(() => {
//   const start = (currentPage.value - 1) * itemsPerPage.value;
//   const end = start + itemsPerPage.value;
//   return filteredUsers.value.slice(start, end);
// });

// // Computed property for total pages
// const totalPages = computed(() => {
//   return Math.ceil(filteredUsers.value.length / itemsPerPage.value);
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

const resetFields = () => {
  searchQuery.value = "";
  selectedEmployeeType.value = "";
  selectedStatusType.value = "1";
};
</script>
  
