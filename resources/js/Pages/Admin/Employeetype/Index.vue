<template>
  <AuthenticatedLayout>
    <header class="bg-gray-100 py-3 px-4 sm:px-4 md:px-6 relative z-50">
      <div class="container mx-auto">
        <nav class="py-2 pl-2 flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900">Employee types</h1>
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
                        <Link :href="`/employeetypes/upload`">
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
                Name
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                Cost code
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                Full time
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                Creator
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
            <tr v-for="type in employee_types" :key="type.id">
              <td
                class="w-full max-w-0 overflow-hidden whitespace-nowrap py-1 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6"
              >
                {{ type.name }}
              </td>
              <td
                class="hidden px-3 py-1 text-sm text-gray-500 sm:table-cell whitespace-nowrap"
              >
                {{ type.costcode.code }}
              </td>
              <td
                class="hidden px-3 py-1 text-sm text-gray-500 sm:table-cell whitespace-nowrap"
              >
                {{ type.full_time ? "Yes" : "No" }}
              </td>

              <td
                class="hidden px-3 py-1 text-xs text-gray-500 sm:table-cell whitespace-nowrap"
              >
                <div class="flex items-center space-x-1">
                  <Avatar
                    :name="type.creator.name"
                    :title="type.creator.name"
                    v-tippy="{
                      content: type.creator.name,
                      delay: [100, 200],
                      inertia: true,
                      placement: 'top',
                      arrow: false,
                      theme: 'light-border',
                      animation: 'shift-away',
                    }"
                    :bgColor="
                      getColorByEmployeeType(type.creator.employee_type)
                    "
                    size="36px"
                  />
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
import Avatargenerate from "@/Components/Avatargenerate.vue";
import { getColorByEmployeeType } from "@/Helpers/colorHelpers";
// import Avatar from "vue3-avatar";
import Avatar from "vue-avatar-3";
import { directive as vTippy } from "vue-tippy";
import "tippy.js/themes/light-border.css";
import "tippy.js/animations/shift-away.css";
const crumbspage = ref([
  { label: "Home", href: "/dashboard" },
  { label: "Employee types", href: "/employee-types" },
]);
// Define props
const props = defineProps({
  employee_types: {
    type: Object,
  },
});

const exportToCSV = () => {
  const headers = ["Name", "Cost Code", "Full Time", "Creator"];

  let csvContent = "data:text/csv;charset=utf-8," + headers.join(",") + "\n";

  props.employee_types.forEach((type) => {
    const row = [
      type.name,
      type.costcode?.code || "", // Use optional chaining in case costcode is null
      type.full_time ? "Yes" : "No",
      type.creator.name,
    ].join(",");
    csvContent += row + "\n";
  });

  const link = document.createElement("a");
  link.setAttribute("href", encodeURI(csvContent));
  link.setAttribute("download", "employee_types.csv");
  link.click();
};
</script>