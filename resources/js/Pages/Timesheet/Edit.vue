<template>
  <AuthenticatedLayout>
    <header class="bg-gray-100 py-3 px-4 sm:px-4 md:px-6">
      <div class="container mx-auto">
        <nav class="py-2 pl-2 flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900">
              Timesheet for {{ $page.props.auth.user.name }} -
              {{ formatDate(weekDates[0]) }} to {{ formatDate(weekDates[6]) }}
            </h1>
            <div>
              <Breadcrumb :crumbs="crumbspage" />
            </div>
          </div>
        </nav>
      </div>
    </header>
    <div class="px-4 py-4 sm:px-6 md:px-8">
      <div>
        <div class="bg-blue-50 rounded-md p-4 mt-4">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
                aria-hidden="true"
                data-slot="icon"
                class="text-blue-400 h-5 w-5"
              >
                <path
                  fill-rule="evenodd"
                  d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z"
                  clip-rule="evenodd"
                ></path>
              </svg>
            </div>
            <div class="flex-1 md:flex md:justify-between">
              <div class="ml-3">
                <!---->
                <div class="text-blue-700 text-sm">
                  <p>
                    Timesheets for {{ formatDate(weekEnding) }}
                    are unlocked.
                  </p>
                </div>
              </div>
              <p class="mt-3 text-sm md:ml-6 md:mt-0">
                <a
                  class="text-blue-700 text-blue-600 whitespace-nowrap font-medium"
                  href="https://app.staging.superiorgroup.com.au/time-sheet-locks/lock?work_week=2024-09-13"
                  >Lock <span aria-hidden="true">→</span></a
                >
              </p>
            </div>
          </div>
        </div>
        <div class="bg-blue-50 rounded-md p-4 my-4">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
                aria-hidden="true"
                data-slot="icon"
                class="text-blue-400 h-5 w-5"
              >
                <path
                  fill-rule="evenodd"
                  d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z"
                  clip-rule="evenodd"
                ></path>
              </svg>
            </div>
            <div class="flex-1 md:flex md:justify-between">
              <div class="ml-3">
                <!---->
                <div class="text-blue-700 text-sm">
                  <p>
                    Once hours have been 'approved' you can no longer edit or
                    assign them to tasks.
                  </p>
                </div>
              </div>
              <!---->
            </div>
          </div>
        </div>
      </div>
      <div
        class="lg:grid-cols-3 mx-auto grid max-w-full grid-cols-1 gap-6 lg:grid-flow-col-dense mt-8"
      >
        <div class="lg:col-span-2 lg:col-start-1 space-y-6">
          <div class="space-y-4">
            <h3 class="text-lg font-bold">Timesheet</h3>
            <div
              class="-mx-4 mt-8 overflow-y-hidden overflow-x-scroll shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg"
            >
              <table class="min-w-full divide-y divide-gray-300">
                <tr class="bg-gray-700">
                  <th
                    scope="col"
                    class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell text-white"
                  >
                    Approve
                  </th>
                  <th
                    scope="col"
                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 whitespace-nowrap text-white"
                  >
                    Day
                  </th>
                  <th
                    scope="col"
                    class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell whitespace-nowrap text-white"
                  >
                    Payroll
                  </th>
                  <th
                    scope="col"
                    class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell text-right text-white"
                    nowrap=""
                  >
                    Clock in
                  </th>
                  <th
                    scope="col"
                    class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell text-right text-white"
                    nowrap=""
                  >
                    Clock out
                  </th>
                  <th
                    scope="col"
                    class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell text-right text-white"
                  >
                    Hours
                  </th>
                  <th
                    scope="col"
                    class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell whitespace-nowrap text-right text-white"
                  >
                    Laser <span class="hidden lg:inline">allowance</span>
                  </th>
                  <th
                    scope="col"
                    class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell whitespace-nowrap text-right text-white"
                  >
                    Insulation <span class="hidden lg:inline">allowance</span>
                  </th>
                  <th
                    scope="col"
                    class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell whitespace-nowrap text-right text-white"
                  >
                    Marker/setter out
                    <span class="hidden lg:inline">allowance</span>
                  </th>
                  <th
                    scope="col"
                    class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell text-right text-white"
                    nowrap=""
                  >
                    Payable hours
                  </th>
                  <th
                    scope="col"
                    class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
                  ></th>
                  <th
                    scope="col"
                    class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
                  ></th>
                  <th
                    scope="col"
                    class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell w-5 text-center"
                  ></th>
                </tr>
                <tr v-for="date in weekDates" :key="date">
                  <td
                    class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell text-center"
                  ></td>
                  <td
                    class="w-full max-w-0 overflow-hidden whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6"
                  >
                    {{ formatDate(date) }}
                    <div class="flex flex-col space-y-4 sm:hidden"></div>
                  </td>
                  <td
                    class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell"
                  ></td>
                  <td
                    class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell"
                  >
                    {{ timesheets.start_time[date] || "" }}
                  </td>
                  <td
                    class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell"
                  >
                    {{ timesheets.end_time[date] || "" }}
                  </td>
                  <td
                    class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell"
                  >
                    {{ timesheets.hours_worked[date] || "" }}
                  </td>
                  <td
                    class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell"
                  ></td>
                  <td
                    class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell"
                  ></td>
                  <td
                    class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell"
                  ></td>

                  <td
                    class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell"
                  ></td>

                  <td
                    class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell text-right"
                    nowrap=""
                  >
                    <Link
                      :href="`/time-sheets/${user.id}/${date}/manage`"
                      class="text-xs px-2.5 py-1.5 bg-gray-100 text-gray-900 hover:bg-gray-200 focus:ring-gray-200 inline-flex items-center justify-center rounded-md border border-transparent font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto"
                    >
                      Edit timesheet
                    </Link>
                  </td>
                  <td
                    class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell"
                  ></td>
                  <td
                    class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell"
                  ></td>
                </tr>

                <!---->
              </table>
            </div>
            <h3 class="pt-4 text-lg font-bold">
              Contracts assigned for the week
            </h3>
            <div
              class="-mx-4 mt-8 overflow-y-hidden overflow-x-scroll shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg"
            >
              <table class="min-w-full divide-y divide-gray-300">
                <tr class="bg-gray-700">
                  <th
                    scope="col"
                    class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell w-5 whitespace-nowrap text-white"
                  >
                    Approve
                  </th>
                  <th
                    scope="col"
                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 whitespace-nowrap text-white"
                  >
                    Code
                  </th>
                  <th
                    scope="col"
                    class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell whitespace-nowrap text-white"
                  >
                    Description
                  </th>
                  <th
                    scope="col"
                    class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell whitespace-nowrap text-white"
                  >
                    Project
                  </th>
                  <th
                    scope="col"
                    class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell whitespace-nowrap text-right text-white"
                    nowrap=""
                  >
                    Value
                  </th>
                </tr>
                <tr>
                  <td
                    class="w-full max-w-0 overflow-hidden whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6"
                    colspan="5"
                  >
                    No contracts assigned to timesheet
                  </td>
                </tr>
              </table>
            </div>
            <h3 class="pt-4 text-lg font-bold">
              Tasks worked on during the week
            </h3>
            <div
              class="-mx-4 mt-8 overflow-y-hidden overflow-x-scroll shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg"
            >
              <table class="min-w-full divide-y divide-gray-300">
                <tr class="bg-gray-700">
                  <th
                    scope="col"
                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 whitespace-nowrap text-white"
                  >
                    Code
                  </th>
                  <th
                    scope="col"
                    class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell whitespace-nowrap text-white"
                  >
                    Description
                  </th>
                  <th
                    scope="col"
                    class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell whitespace-nowrap text-right text-white"
                  >
                    Contract value
                  </th>
                  <th
                    scope="col"
                    class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell whitespace-nowrap text-right text-white"
                  >
                    Hours
                  </th>
                  <th
                    scope="col"
                    class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell whitespace-nowrap text-right text-white"
                  >
                    Claim
                  </th>
                </tr>
                <tr>
                  <td
                    class="w-full max-w-0 overflow-hidden whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6"
                    colspan="5"
                  >
                    No tasks found for Talha Baig for the project Sat, 07 Sep ~
                    Fri, 13 Sep
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <div class="lg:col-span-1 lg:col-start-3 space-y-6">
          <h3 class="text-lg font-bold">Contractors check on EBA</h3>
          <div class="bg-blue-50 rounded-md p-4">
            <div class="flex">
              <div class="flex-shrink-0">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                  aria-hidden="true"
                  data-slot="icon"
                  class="text-blue-400 h-5 w-5"
                >
                  <path
                    fill-rule="evenodd"
                    d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z"
                    clip-rule="evenodd"
                  ></path>
                </svg>
              </div>
              <div class="flex-1 md:flex md:justify-between">
                <div class="ml-3">
                  <!---->
                  <div class="text-blue-700 text-sm">
                    <p>No pay records found</p>
                  </div>
                </div>
                <!---->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref, watch, computed } from "vue";
import { usePage, Link } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
const page = usePage();
const crumbspage = ref([
  { label: "Home", href: "/dashboard" },
  { label: "Timesheets", href: "/time-sheets" },
  { label: "Week ending Sep 13", href: "/time-sheets" },
  { label: "Timesheet - Talha Baig", href: "/time-sheets" },
]);

const props = defineProps({
  weekEnding: {
    type: String,
    required: false,
  },
  weekDates: {
    type: Array,
    required: true,
  },
  timesheets: {
    type: Object,
  },
  user: {
    type: Object,
  },
});

function formatDate(inputDate) {
  // Parse the input date (assuming format is "DD-MM-YYYY")
  const [day, month, year] = inputDate.split("-");
  const date = new Date(`${year}-${month}-${day}`);

  // Options for formatting
  const options = { weekday: "short", day: "2-digit", month: "short" };

  // Format the date to "Tue, 10 Sep"
  return date.toLocaleDateString("en-GB", options).replace(/,/, "");
}
</script>