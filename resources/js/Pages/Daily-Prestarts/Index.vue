<template>
  <AuthenticatedLayout>
    <header class="bg-gray-100 py-3 px-4 sm:px-4 md:px-6">
      <div class="container mx-auto">
        <nav class="py-2 pl-2 flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900">
              Daily-Prestarts
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
    <div class="p-2 px-8">
      <div
        class="my-2 flex flex-col space-y-2 mx-auto sm:flex-row sm:items-center sm:space-y-0 sm:space-x-4"
      >
        <select
          v-model="selectedWorkday"
          class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm"
        >
          <option value="">Search by work day</option>
          <option
            v-for="(workday, index) in workdays"
            :key="index"
            :value="workday"
          >
            {{ workday }}
          </option>
        </select>
        <select
          v-model="selectedProject"
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
        class="mt-2 relative overflow-x-scroll mx-auto rounded-lg sm:block overflow-y-auto shadow ring-1 ring-black ring-opacity-5"
      >
        <table
          class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
        >
          <thead class="bg-gray-100">
            <tr>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm sm:pl-6 font-semibold text-gray-900 sm:table-cell"
              >
                Work day
              </th>
              <th
                scope="col"
                class="py-3.5 pl-3 pr-3 text-left text-sm font-semibold text-gray-900"
              >
                Project
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                Signed by
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                Absent
              </th>
              <th
                scope="col"
                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 table-cell"
              ></th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 bg-white">
            <tr v-for="prestart in prestarts.data" :key="prestart">
              <td
                class="hidden px-3 py-4 text-sm font-medium text-gray-900 sm:table-cell sm:pl-6 whitespace-nowrap"
              >
                {{ prestart.workdate }}
              </td>
              <td
                class="hidden px-3 py-4 text-sm text-left text-gray-500 sm:table-cell whitespace-nowrap"
              >
                <div v-if="prestart.project">
                  <UnderlineLink :href="`/project/${prestart.project_id}`">
                    {{ prestart.project.project_name }}
                  </UnderlineLink>
                </div>
                <div v-else>No project</div>
                <div>
                  <div v-if="prestart.project">
                    {{ prestart.project.subsidiary }}
                  </div>
                  <div v-else>No project</div>
                </div>
                <div v-if="prestart.foreman">
                  Foreman:
                  <UnderlineLink :href="`/users/${prestart.foreman.id}`">
                    {{ prestart.foreman.name }}
                  </UnderlineLink>
                </div>
              </td>

              <td
                class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap"
              >
                <div class="flex items-center space-x-2">
                  <div class="hidden md:flex -space-x-2">
                    <!-- Filter prestartSigned to include only "Present" statuses -->
                    <div
                      v-for="user in prestart.prestartSigned"
                      :key="user.user.id"
                      @click="handleAbsentData(prestart.prestartAbsent)"
                    >
                      <img
                        :src="getAvatarUrl(user.user.avatar)"
                        alt="Avatar"
                        class="h-8 w-8 rounded-full border-2 border-white"
                      />
                    </div>
                  </div>
                </div>
              </td>
              <td
                class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap"
              >
                <div class="flex items-center space-x-2">
                  <div class="hidden md:flex -space-x-2">
                    <!-- Filter prestartSigned to include only "Present" statuses -->
                    <div
                      v-for="user in prestart.prestartAbsent"
                      :key="user.user.id"
                    >
                      <img
                        :src="getAvatarUrl(user.user.avatar)"
                        alt="Avatar"
                        class="h-8 w-8 rounded-full border-2 border-white"
                      />
                    </div>
                  </div>
                  <div v-if="prestart.prestartAbsent.length > 0">
                    <span
                      ><Link
                        class="text-xs px-2.5 py-1.5 bg-gray-100 text-gray-900 hover:bg-gray-200 focus:ring-gray-200 inline-flex items-center justify-center rounded-md border border-transparent font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto ml-2 hidden xl:block"
                        :href="`/absent/${prestart.id}/manage`"
                      >
                        Manage
                        <span
                          >({{ prestart.prestartAbsent.length }})</span
                        ></Link
                      ></span
                    >
                  </div>
                </div>
              </td>
              <td class="relative">
                <div class="relative w-8 h-8">
                  <Menu
                    as="div"
                    class="h-8 w-8 rounded-full relative inline-block text-left"
                  >
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
                        style="z-index: 50"
                      >
                        <div>
                          <MenuItem
                            v-for="(item, index) in menuItems"
                            :key="index"
                            v-slot="{ active }"
                          >
                            <Link :href="item.link">
                              <button
                                :class="[
                                  active
                                    ? item.activeClass
                                    : item.inactiveClass,
                                  'group flex w-full items-center px-4 py-2 text-sm',
                                ]"
                              >
                                {{ item.text }}
                              </button>
                            </Link>
                          </MenuItem>
                        </div>
                        <div v-if="isWorkdateTodayOrFuture(prestart.workdate)">
                          <MenuItem v-slot="{ active }">
                            <a
                              :href="`/daily-prestarts/${prestart.id}/sign-sheet-template`"
                              target="_blank"
                              rel="noopener noreferrer"
                              class="group flex w-full items-center text-sm"
                            >
                              <button
                                :class="[
                                  active
                                    ? 'bg-gray-100 px-4 py-2 text-gray-700'
                                    : 'text-gray-900 px-4 py-2',
                                  'w-full',
                                ]"
                              >
                                Download sign sheet template
                              </button>
                            </a>
                          </MenuItem>
                        </div>
                        <MenuItem v-slot="{ active }">
                          <a
                            :href="`/daily-prestarts/${prestart.id}/pdf`"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="group flex w-full items-left text-sm"
                          >
                            <button
                              :class="[
                                active
                                  ? 'bg-gray-100 px-4 py-2 text-gray-700 text-left'
                                  : 'text-gray-900 px-4 py-2 text-left',
                                'w-full',
                              ]"
                            >
                              Download PDF
                            </button>
                          </a>
                        </MenuItem>
                        <MenuItem v-slot="{ active }">
                          <Link
                            :href="`/daily-prestart-signed/${prestart.id}/file`"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="group flex w-full items-left text-sm"
                          >
                            <button
                              :class="[
                                active
                                  ? 'bg-gray-100 px-4 py-2 text-gray-700 text-left'
                                  : 'text-gray-900 px-4 py-2 text-left',
                                'w-full',
                              ]"
                            >
                              Upload Signatures
                            </button>
                          </Link>
                        </MenuItem>
                      </MenuItems>
                    </transition>
                  </Menu>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="mt-4 flex justify-between items-center mx-auto">
        <div
          v-if="prestarts.data.length"
          class="w-full flex justify-end mt-8 mb-8"
        >
          <Pagination :links="prestarts.links" />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref, watch, computed } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { Link } from "@inertiajs/vue3";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import Pagination from "@/Components/Pagination.vue";
import UnderlineLink from "@/Components/UnderlineLink.vue";
import { router } from "@inertiajs/vue3";
const props = defineProps({
  workdays: Object,
  projects_completed: Object,
  projects_active: Object,
  prestarts: Object,
  filters: Object,
  workdate: Object,
  project: Object,
});
const crumbspage = ref([
  { label: "Home", href: "/dashboard" },
  { label: "Daily-Prestarts", href: "/daily-prestarts" },
]);
const getAvatarUrl = (avatarPath) => {
  if (!avatarPath) return "";
  return `${window.location.origin}/${avatarPath}`;
};
const selectedWorkday = ref(props.workdate || "");
const selectedProject = ref(props.project || "");

const resetFields = () => {
  selectedWorkday.value = "";
  selectedProject.value = "";
  props.workdate.value = "";
  props.project.value = "";
};

// Function to check if the workdate is today or in the future
const isWorkdateTodayOrFuture = (workdate) => {
  const today = new Date();
  const prestartDate = new Date(workdate);

  // Check if the workdate is today or in the future
  return prestartDate >= today.setHours(0, 0, 0, 0);
};
const handleAbsentData = (prestartAbsent) => {
  console.log(prestartAbsent);
};
const menuItemcActiveclass = "text-gray-900 text-left hover:bg-gray-100";
const menuItemRedActiveclass = "bg-gray-100 text-red-600";
const menuItemcInactiveclass = "text-gray-900 text-left";
const menuItemRedInactiveclass = "text-red-600";
const menuItems = [
  {
    text: "QR Login Scanner",
    link: "/qr-login",
    activeClass: menuItemcActiveclass,
    inactiveClass: menuItemcInactiveclass,
  },

  {
    text: "Delete",
    link: "",
    activeClass: menuItemRedActiveclass,
    inactiveClass: menuItemRedInactiveclass,
  },
];

const getPrestartIndex = (workdate, project) => {
  return route("daily-prestarts.index", {
    workdate: workdate || undefined,
    project: project || undefined,
  });
};

// Watch `selectedWorkday` and navigate to the new route on change
watch([selectedWorkday, selectedProject], ([newDate, newProject]) => {
  if (newDate || newProject) {
    router.get(getPrestartIndex(newDate, newProject));
  } else {
    // If no date or project is selected, remove the filters
    router.get(getPrestartIndex(null, null));
  }
});
</script>