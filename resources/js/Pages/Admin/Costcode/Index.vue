<template>
  <AuthenticatedLayout>
    <header class="bg-gray-100 py-3 px-4 sm:px-4 md:px-6 relative z-50">
      <div class="container mx-auto">
        <nav class="py-2 pl-2 flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900">Cost codes</h1>
            <div>
              <Breadcrumb :crumbs="crumbspage" />
            </div>
          </div>
          <div class="flex items-center justify-between">
            <Link :href="route('cost-codes.create')" class="mx-2">
              <PrimaryButton>Create cost code</PrimaryButton>
            </Link>
            <!-- <button @click="exportToCSV" class="btn btn-primary">
              Export to CSV
            </button> -->
            <div class="w-8 h-8">
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
                        <Link :href="`/costcodes/upload`">
                          <button
                            :class="[
                              active
                                ? 'bg-gray-100 text-gray-700'
                                : 'text-gray-900',
                              'group flex w-full items-center px-4 py-2 text-sm',
                            ]"
                          >
                            Import
                          </button></Link
                        >
                      </MenuItem>
                      <MenuItem v-slot="{ active }">
                        <button
                          @click="exportToCSV"
                          :class="[
                            active
                              ? 'bg-gray-100 text-gray-700'
                              : 'text-gray-900',
                            'group flex w-full items-center px-4 py-2 text-sm',
                          ]"
                        >
                          Export CSV
                        </button>
                      </MenuItem>
                    </div>
                  </MenuItems>
                </transition>
              </Menu>
            </div>
          </div>
        </nav>
      </div>
    </header>
    <div class="p-2 px-8">
      <div
        class="mt-2 relative overflow-x-scroll mx-auto rounded-lg sm:block overflow-y-auto border shadow-md"
      >
        <table class="min-w-full divide-y divide-gray-300">
          <thead class="bg-gray-100">
            <tr>
              <th
                scope="col"
                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
              >
                Code
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                Description
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                Unit
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                Category 1
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                Category 2
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                Category 3
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                Category 4
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                Last Update
              </th>
              <th
                scope="col"
                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
              >
                <span class="sr-only">Edit</span>
              </th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 bg-white">
            <tr v-for="code in costcodes" :key="code.id">
              <td
                class="w-full max-w-0 overflow-hidden whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6"
              >
                {{ code.code }}
              </td>
              <td
                class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap"
              >
                {{ code.description }}
              </td>
              <td
                class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap"
              >
                {{ code.unit }}
              </td>
              <td
                class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap"
              >
                {{ code.category_1 }}
              </td>
              <td
                class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap"
              >
                {{ code.category_2 }}
              </td>
              <td
                class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap"
              >
                {{ code.category_3 }}
              </td>
              <td
                class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap"
              >
                {{ code.category_4 }}
              </td>
              <td
                class="hidden px-3 py-4 text-xs text-gray-500 sm:table-cell whitespace-nowrap"
              >
                <div class="flex items-center space-x-1">
                  <div>Created by</div>
                  <div>
                    <img
                      :src="code.creator.avatar"
                      alt="Avatar"
                      class="h-8 w-8 rounded-full"
                    />
                  </div>
                </div>
              </td>
              <td class="pr-4 text-right">
                <div data-headlessui-state="">
                  <button
                    id="headlessui-menu-button-3"
                    type="button"
                    aria-haspopup="menu"
                    aria-expanded="false"
                    data-headlessui-state=""
                    class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-transparent bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                  >
                    <span class="sr-only">Open options</span
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                      aria-hidden="true"
                      data-slot="icon"
                      class="h-5 w-5"
                    >
                      <path
                        d="M10 3a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM10 8.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM11.5 15.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z"
                      ></path>
                    </svg>
                  </button>
                  <div
                    style="
                      position: absolute;
                      z-index: 9999;
                      inset: 0px auto auto 0px;
                      transform: translate(0px, 0px);
                    "
                  >
                    <!---->
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
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
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
const crumbspage = ref([
  { label: "Home", href: "/dashboard" },
  { label: "Cost Codes", href: "/cost-codes" },
]);
// Define props
const props = defineProps({
  costcodes: {
    type: Object,
  },
});

const exportToCSV = () => {
  // Define CSV headers
  const headers = [
    "Code",
    "Description",
    "Unit",
    "Category 1",
    "Category 2",
    "Category 3",
    "Category 4",
  ];

  // Define the CSV content
  let csvContent = "data:text/csv;charset=utf-8,";
  csvContent += headers.join(",") + "\n";

  props.costcodes.forEach((code) => {
    const row = [
      code.code,
      code.description,
      code.unit,
      code.category_1,
      code.category_2,
      code.category_3,
      code.category_4,
    ].join(",");

    csvContent += row + "\n";
  });

  // Create a link element
  const link = document.createElement("a");
  link.setAttribute("href", encodeURI(csvContent));
  link.setAttribute("download", "cost_codes.csv");
  link.click();
};
</script>