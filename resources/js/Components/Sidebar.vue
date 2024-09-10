<template>
  <div class="relative h-screen">
    <!-- Sidebar -->
    <div
      :class="[
        'h-screen overflow-y-auto bg-gray-900 text-white flex flex-col p-4 transition-transform duration-300 z-50',
        { 'transform -translate-x-full': isCollapsed },
        isCollapsed ? 'w-0' : 'w-80 lg:w-64',
        isMobile ? 'fixed' : 'fixed lg:relative',
      ]"
    >
      <!-- Logo -->
      <div class="mb-6 ml-3 flex justify-start rounded-md bg-gray-100 p-2">
        <ApplicationLogo class="block h-9 w-auto fill-current" />
        <h2 class="text-bold text-gray-700 text-3xl ml-4">Superior</h2>
      </div>

      <!-- Navigation Links -->
      <nav>
        <ul>
          <!-- Main Links -->
          <li v-for="link in mainLinks" :key="link.name" class="mb-1">
            <Link
              :href="`/${link.route}`"
              class="flex items-center space-x-3 p-2 rounded hover:bg-gray-700 cursor-pointer font-semibold leading-6 text-gray-400 hover:text-white"
            >
              <div class="text-xl">
                <iconify-icon :icon="link.icon"></iconify-icon>
              </div>
              <span class="text-s">{{ link.name }}</span>
            </Link>
          </li>

          <!-- Separator -->
          <li class="mt-6 mb-2">
            <span class="text-xs font-semibold leading-6 text-gray-400"
              >Administration</span
            >
          </li>

          <!-- Administration Links -->
          <li v-for="link in adminLinks" :key="link.name" class="mb-1">
            <Link
              :href="`/${link.route}`"
              class="flex items-center space-x-3 p-2 rounded hover:bg-gray-700 cursor-pointer font-semibold leading-6 text-gray-400 hover:text-white"
            >
              <div class="text-xl">
                <iconify-icon :icon="link.icon"></iconify-icon>
              </div>
              <span class="text-s">{{ link.name }}</span>
            </Link>
          </li>
        </ul>
        <ul class="flex flex-1 flex-col">
          <li v-if="user" class="text-left rounded-lg">
            <a
              class="flex items-center py-3 px-3 text-sm font-semibold leading-6 text-white hover:bg-gray-700 rounded"
              :href="route('users.show', user.id)"
            >
              <img
                :src="getAvatarUrl(user.avatar)"
                alt="Avatar"
                class="h-8 w-8 rounded-full"
              />
              <span class="sr-only">Your profile</span>
              <span class="px-3" aria-hidden="true">{{ user.name }}</span></a
            >
          </li>
          <li class="hidden sm:block">
            <Link
              :href="route('logout')"
              method="post"
              as="button"
              class="flex w-full items-center gap-x-4 px-6 py-3 text-sm font-semibold leading-6 text-white hover:bg-gray-700 rounded"
              >Sign out</Link
            >
          </li>
        </ul>
      </nav>
    </div>

    <!-- Main content overlay backdrop -->
    <div
      v-if="!isCollapsed && isMobile"
      @click="toggleSidebar"
      class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"
    ></div>

    <!-- Toggle Button -->
    <button
      v-if="isCollapsed"
      @click="toggleSidebar"
      class="lg:hidden fixed top-4 left-4 hover:bg-gray-700 hover:text-white text-gray-700 p-2 ml-1 rounded focus:outline-none z-50"
    >
      <iconify-icon :icon="'mdi:menu'"></iconify-icon>
    </button>

    <!-- Close Button -->
    <button
      v-if="!isCollapsed && isMobile"
      @click="toggleSidebar"
      class="lg:hidden fixed top-4 left-[calc(23rem-2.5rem)] hover:bg-gray-700 text-white p-2 rounded focus:outline-none z-50"
    >
      <iconify-icon :icon="'mdi:close'"></iconify-icon>
    </button>
  </div>
</template>
  
  <script setup>
import { ref, onMounted, onUnmounted } from "vue";
import { Icon as IconifyIcon } from "@iconify/vue";
import { Link, usePage } from "@inertiajs/vue3";

import ApplicationLogo from "@/Components/ApplicationLogo.vue";

const props = defineProps({
  user: {
    type: Object,
    required: false,
  },
});
const logout = () => {
  Inertia.post(route("logout"));
};

const isCollapsed = ref(true);
const isMobile = ref(window.innerWidth < 1024);

function toggleSidebar() {
  isCollapsed.value = !isCollapsed.value;
}

function handleResize() {
  isMobile.value = window.innerWidth < 1024;
  if (isMobile.value) {
    isCollapsed.value = true;
  } else {
    isCollapsed.value = false;
  }
}

onMounted(() => {
  handleResize();
  window.addEventListener("resize", handleResize);
});

onUnmounted(() => {
  window.removeEventListener("resize", handleResize);
});

const getAvatarUrl = (avatarPath) => {
  if (!avatarPath) return "";
  return `${window.location.origin}/${avatarPath}`;
};

// Static data for sidebar links
const mainLinks = [
  { name: "Projects", icon: "ph:building", route: "project" },
  // { name: "Absentees", icon: "mdi:smiley-sad-outline", route: "" },
  {
    name: "Timesheets",
    icon: "mdi:clock-outline",
    route: "time-sheets",
  },
  // { name: "Payroll", icon: "clarity:dollar-solid", route: "" },
  {
    name: "Daily Pre-starts",
    icon: "mdi:calendar-check-outline",
    route: "daily-prestarts",
  },
  // { name: "Toolbox Talks", icon: "mdi:toolbox-outline", route: "" },
  // { name: "Quality Assurance", icon: "mdi:check-decagram-outline", route: "" },
  // { name: "SDS Register", icon: "mdi:book-lock-outline", route: "" },
  { name: "Team", icon: "mdi:account-group-outline", route: "users" },
  // { name: "SWMS", icon: "mdi:account-group-outline", route: "swms" },
];

const adminLinks = [
  // { name: "Cost codes", icon: "mdi:cc", route: "cost-code" },
  // {
  //   name: "Employee types",
  //   icon: "mdi:account-tie-outline",
  //   route: "employee-type",
  // },
  // { name: "Base pay rates", icon: "mdi:cash-multiple", route: "base-pay-rate" },
  // {
  //   name: "Base payroll addons",
  //   icon: "mdi:cash-plus",
  //   route: "base-payroll-addon",
  // },
  // { name: "Payroll codes", icon: "mdi:barcode", route: "payroll-code" },
  // {
  //   name: "Application history",
  //   icon: "mdi:history",
  //   route: "application-history",
  // },
];
</script>
  
  <style scoped>
/* Add any additional styling here */
</style>