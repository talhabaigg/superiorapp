<template>
  <AuthenticatedLayout>
    <header class="bg-gray-100 py-3 px-4 sm:px-4 md:px-6">
      <div class="container mx-auto">
        <nav class="py-2 pl-2 flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900">Submit new req</h1>
            <div>
              <Breadcrumb :crumbs="crumbspage" />
            </div>
          </div>
          <div class="flex items-center justify-between">
            <Link :href="route('cost-codes.create')" class="mx-2">
              <PrimaryButton>Create item code</PrimaryButton>
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
                        <Link :href="`/materialitems/upload`">
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
    <div class="px-8">
      <div class="px-4 py-2 sm:px-6 md:px-8">
        <form
          class="mx-auto mt-8 max-w-lg md:max-w-3xl p-4 shadow-md rounded-2xl"
          @submit.prevent="submitForm"
        >
          <div class="grid grid-cols-1 md:gap-1 gap-2 md:grid-cols-2">
            <div class="mb-1">
              <div class="flex items-center justify-between">
                <label class="block text-sm font-medium text-gray-700">
                  <span>Data required</span>
                </label>
              </div>
              <div id="birthday" class="mt-1">
                <input
                  class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
                  autocomplete="off"
                  type="date"
                />
              </div>
            </div>

            <div class="mb-1">
              <div class="flex items-center justify-between">
                <label class="block text-sm font-medium text-gray-700">
                  <span>Select supplier</span>
                </label>
              </div>
              <div id="name" class="mt-1">
                <select
                  class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm disabled:opacity-50"
                  id="timeSheet_0_payroll_code_id"
                  v-model="selectedSupplier"
                >
                  <option value="">Select supplier name</option>
                  <option
                    v-for="supplier in suppliers"
                    :key="supplier"
                    :value="supplier"
                  >
                    {{ supplier }}
                  </option>
                </select>
              </div>
            </div>

            <div class="mb-1">
              <div class="flex items-center justify-between">
                <label class="block text-sm font-medium text-gray-700">
                  <span>Select Project</span>
                </label>
              </div>
              <div id="name" class="mt-1">
                <select
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
            </div>

            <div class="mb-1">
              <div class="flex items-center justify-between">
                <label class="block text-sm font-medium text-gray-700">
                  <span>Site Reference</span>
                </label>
              </div>
              <div id="name" class="mt-1">
                <input
                  class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
                  autocomplete="off"
                  required
                  type="text"
                />
              </div>
            </div>

            <div class="mb-1">
              <div class="flex items-center justify-between">
                <label class="block text-sm font-medium text-gray-700">
                  <span>Delivery Contact</span>
                </label>
              </div>
              <div id="name" class="mt-1">
                <input
                  class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
                  autocomplete="off"
                  required
                  type="text"
                />
              </div>
            </div>

            <div class="mb-1">
              <div class="flex items-center justify-between">
                <label class="block text-sm font-medium text-gray-700">
                  <span>Pickup by</span>
                </label>
              </div>
              <div id="name" class="mt-1">
                <input
                  class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
                  autocomplete="off"
                  required
                  type="text"
                />
              </div>
            </div>

            <div class="mb-1">
              <div class="flex items-center justify-between">
                <label class="block text-sm font-medium text-gray-700">
                  <span>Requested by</span>
                </label>
              </div>
              <div id="name" class="mt-1">
                <input
                  class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
                  autocomplete="off"
                  required
                  type="text"
                />
              </div>
            </div>

            <div class="mb-1">
              <div class="flex items-center justify-between">
                <label class="block text-sm font-medium text-gray-700">
                  <span>Deliver to</span>
                </label>
              </div>
              <div id="name" class="mt-1">
                <input
                  class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
                  autocomplete="off"
                  required
                  type="text"
                />
              </div>
            </div>

            <div class="mb-6 md:col-span-2">
              <div class="flex items-center justify-between">
                <label class="block text-sm font-medium text-gray-700">
                  <span>Notes</span>
                </label>
              </div>
              <div id="name" class="mt-1">
                <textarea
                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                  rows="3"
                ></textarea>
              </div>
            </div>
          </div>
          <div v-if="isComboBoxDisabled" class="text-red-600 font-bold">
            **Select supplier before adding items.
          </div>
          <div
            class="grid grid-cols-2 md:gap-1 gap-2 md:grid-cols-5 md:outline-none"
            v-for="(line, index) in lineItems"
            :key="index"
          >
            <!-- Item Code Search Field -->
            <div class="mb-1">
              <div class="flex items-center justify-between">
                <label class="block text-sm font-medium text-gray-700">
                  <span>Item code</span>
                </label>
              </div>
              <div id="name" class="mt-1">
                <div class="top-16">
                  <Combobox
                    v-model="line.selectedItem"
                    :disabled="isComboBoxDisabled"
                  >
                    <div class="relative mt-1">
                      <div
                        class="relative w-full cursor-default overflow-hidden rounded-lg bg-white outline-gray-300 shadow-sm placeholder:text-gray-300 text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75 focus-visible:ring-offset-2 focus-visible:ring-offset-teal-300 sm:text-sm"
                      >
                        <ComboboxInput
                          class="w-full border-none py-2 pl-3 pr-10 text-sm leading-5 text-gray-900 focus:ring-0"
                          :displayValue="(item) => (item ? item.code : '')"
                          @input="query = $event.target.value"
                          v-model="line.item_code"
                          placeholder="Search by item code.."
                        />
                        <ComboboxButton
                          class="absolute inset-y-0 right-0 flex items-center pr-2"
                          @onclick="populateFields(line, index)"
                        >
                          <ChevronUpDownIcon
                            class="h-5 w-5 text-gray-400"
                            aria-hidden="true"
                          />
                        </ComboboxButton>
                      </div>
                      <TransitionRoot
                        leave="transition ease-in duration-100"
                        leaveFrom="opacity-100"
                        leaveTo="opacity-0"
                        @after-leave="query = ''"
                      >
                        <ComboboxOptions
                          class="absolute z-50 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black/5 focus:outline-none sm:text-sm"
                        >
                          <div
                            v-if="filteredItems.length === 0 && query !== ''"
                            class="relative cursor-default select-none px-4 py-2 text-gray-700"
                          >
                            Nothing found.
                          </div>

                          <ComboboxOption
                            v-for="item in filteredItems"
                            :key="item.id"
                            :value="item"
                            @click="populateFields(line, item)"
                            class="mt-1 px-4 max-h-60 w-full overflow-auto bg-white py-1 text-base sm:text-sm hover:bg-gray-300"
                          >
                            {{ item.code }}
                          </ComboboxOption>
                        </ComboboxOptions>
                      </TransitionRoot>
                    </div>
                  </Combobox>
                </div>
              </div>
            </div>

            <!-- Description Field (Auto-populated) -->
            <div class="mb-1 col-span-2">
              <div class="flex items-center justify-between">
                <label class="block text-sm font-medium text-gray-700">
                  <span>Description</span>
                </label>
              </div>
              <div id="description" class="mt-1">
                <div class="top-16">
                  <Combobox v-model="line.selectedItem">
                    <div class="relative mt-1">
                      <div
                        class="relative w-full cursor-default overflow-hidden rounded-lg bg-white outline-gray-300 shadow-sm placeholder:text-gray-300 text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75 focus-visible:ring-offset-2 focus-visible:ring-offset-teal-300 sm:text-sm"
                      >
                        <ComboboxInput
                          class="w-full border-none py-2 pl-3 pr-10 text-sm leading-5 text-gray-900 focus:ring-0"
                          :displayValue="
                            (item) => (item ? item.description : '')
                          "
                          @input="query = $event.target.value"
                          v-model="line.description"
                          placeholder="Search by description.."
                        />
                        <ComboboxButton
                          class="absolute inset-y-0 right-0 flex items-center pr-2"
                          @onclick="populateFields(line, index)"
                        >
                          <ChevronUpDownIcon
                            class="h-5 w-5 text-gray-400"
                            aria-hidden="true"
                          />
                        </ComboboxButton>
                      </div>
                      <TransitionRoot
                        leave="transition ease-in duration-100"
                        leaveFrom="opacity-100"
                        leaveTo="opacity-0"
                        @after-leave="query = ''"
                      >
                        <ComboboxOptions
                          class="absolute z-50 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black/5 focus:outline-none sm:text-sm"
                        >
                          <div
                            v-if="filteredItems.length === 0 && query !== ''"
                            class="relative cursor-default select-none px-4 py-2 text-gray-700"
                          >
                            Nothing found.
                          </div>

                          <ComboboxOption
                            v-for="item in filteredItems"
                            :key="item.id"
                            :value="item"
                            @click="populateFields(line, item)"
                            class="mt-1 px-4 max-h-60 w-full overflow-auto bg-white py-1 text-base sm:text-sm hover:bg-gray-300"
                          >
                            {{ item.description }}
                          </ComboboxOption>
                        </ComboboxOptions>
                      </TransitionRoot>
                    </div>
                  </Combobox>
                </div>
              </div>
            </div>

            <!-- Quantity Field (Auto-populated) -->
            <div class="mb-1">
              <div class="flex items-center justify-between">
                <label class="block text-sm font-medium text-gray-700">
                  <span>Qty (ea)</span>
                </label>
              </div>
              <div id="qty" class="mt-1">
                <input
                  class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
                  autocomplete="off"
                  type="number"
                  v-model="line.qty"
                />
              </div>
            </div>

            <!-- Cost Field (Auto-populated) -->
            <div class="mb-1">
              <div class="flex items-center justify-between">
                <label class="block text-sm font-medium text-gray-700">
                  <span>Cost (ea)</span>
                </label>
              </div>
              <div id="cost" class="mt-1">
                <input
                  class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
                  autocomplete="off"
                  v-model="line.cost"
                  type="number"
                />
              </div>
            </div>
          </div>

          <!-- Add/Remove Line Buttons -->
          <div>
            <button
              type="button"
              @click="addline"
              class="text-sm px-4 py-2 bg-gray-100 text-gray-900 hover:bg-gray-200 focus:ring-gray-200 inline-flex items-center justify-center rounded-md border border-transparent font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto mr-2"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                aria-hidden="true"
                class="mr-2 h-4 w-4"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M12 4.5v15m7.5-7.5h-15"
                />
              </svg>
              Line
            </button>
            <button
              type="button"
              @click="removeline"
              class="text-sm px-4 py-2 bg-gray-100 text-gray-900 hover:bg-gray-200 focus:ring-gray-200 inline-flex items-center justify-center rounded-md border border-transparent font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto mr-2"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                aria-hidden="true"
                class="mr-2 h-4 w-4"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M5 12h14"
                />
              </svg>
              Line
            </button>
          </div>
          <div class="mt-2"><PrimaryButton>Submit</PrimaryButton></div>
        </form>
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
import {
  Combobox,
  ComboboxInput,
  ComboboxButton,
  ComboboxOptions,
  ComboboxOption,
  TransitionRoot,
} from "@headlessui/vue";

const crumbspage = ref([
  { label: "Home", href: "/dashboard" },
  { label: "Material Requisition", href: "/cost-codes" },
  { label: "Create", href: "/cost-codes" },
]);
// Define props
const props = defineProps({
  items: {
    type: Object,
  },
  suppliers: {
    type: Array,
  },
  projects_completed: Object,
  projects_active: Object,
});
const lineItems = ref([{ item_code: "", description: "", qty: "", cost: "" }]);
const addline = () => {
  lineItems.value.push({
    item_code: "",
    description: "",
    qty: "",
    cost: "",
  });
};
const removeline = () => {
  lineItems.value.splice(lineItems.value.length - 1, 1);
};
// Function to populate fields based on the selected item from the search
const populateFields = (line, index) => {
  if (line.selectedItem) {
    line.description = line.selectedItem.description;
    line.qty = line.selectedItem.qty;
    line.cost = line.selectedItem.cost;
  }
};
const items = ref(props.items);

const filteredItems = computed(() => {
  // Return all items if no supplier is selected
  if (!selectedSupplier.value) return [];

  // Filter items based on the supplier_name and the query
  return items.value.filter((item) => {
    const matchesSupplier = item.supplier_name === selectedSupplier.value;
    const matchesQuery =
      !query.value ||
      item.code.toLowerCase().includes(query.value.toLowerCase()) ||
      item.description.toLowerCase().includes(query.value.toLowerCase());

    return matchesSupplier && matchesQuery;
  });
});

const query = ref("");
const selectedSupplier = ref("");
const isComboBoxDisabled = computed(() => {
  return !selectedSupplier.value; // Disable if no supplier is selected
});
</script>