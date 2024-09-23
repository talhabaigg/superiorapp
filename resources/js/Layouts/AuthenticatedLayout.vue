<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import { Link } from "@inertiajs/vue3";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import { usePage } from "@inertiajs/vue3";
import Sidebar from "@/Components/Sidebar.vue";
import { computed, onMounted } from "vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import Avatar from "vue-avatar-3";
import { directive as vTippy } from "vue-tippy";
import "tippy.js/themes/light-border.css";
import "tippy.js/animations/shift-away.css";
import { getColorByEmployeeType } from "@/Helpers/colorHelpers";
const page = usePage();
const flashSuccess = computed(() => page.props.flash.success);
const flashWarning = computed(() => page.props.flash.warning);

const showToastSuccess = () => {
  if (flashSuccess.value) {
    toast.success(flashSuccess.value, {
      autoClose: 5000, // Duration in milliseconds
    });
  }
};

const showToastWarn = () => {
  if (flashWarning.value) {
    toast.warn(flashWarning.value, {
      autoClose: 5000, // Duration in milliseconds
    });
  }
};
const getAvatarUrl = (avatarPath) => {
  if (!avatarPath) return "";
  return `${window.location.origin}/${avatarPath}`;
};

onMounted(() => {
  showToastSuccess();
  showToastWarn();
});
</script>

<template>
  <div class="flex h-screen">
    <Sidebar :user="$page.props.auth.user" />
    <div class="flex-grow flex flex-col overflow-auto flex-1">
      <div class="min-h-screen">
        <nav
          class="bg-gray-900 lg:bg-white block lg:hidden border-b border-gray-100"
        >
          <!-- Primary Navigation Menu -->
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
              <div class="flex">
                <!-- Logo -->

                <div class="-me-2 flex items-center lg:hidden">
                  <button
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 focus:outline-none transition duration-150 ease-in-out"
                  ></button>
                </div>

                <!-- Navigation Links -->
              </div>

              <!-- Menu Drop Down on header - responsive -->

              <Menu
                as="div"
                class="p-3 mt-1 relative inline-block lg:hidden text-left"
              >
                <div>
                  <MenuButton
                    class="flex max-w-xs items-center rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                  >
                    <Avatar
                      v-tippy="{
                        content: $page.props.auth.user.name,
                        delay: [100, 200],
                        inertia: true,
                        placement: 'top',
                        arrow: false,
                        theme: 'light-border',
                        animation: 'shift-away',
                      }"
                      :name="$page.props.auth.user.name"
                      :bgColor="
                        getColorByEmployeeType(
                          $page.props.auth.user.employee_type
                        )
                      "
                      size="36px"
                    />
                  </MenuButton>
                </div>

                <transition
                  enter-active-class="transition duration-100 ease-out"
                  enter-from-class="transform scale-95 opacity-0"
                  enter-to-class="transform scale-100 opacity-100"
                  leave-active-class="transition duration-75 ease-in"
                  leave-from-class="transform scale-100 opacity-100"
                  leave-to-class="transform scale-95 opacity-0"
                >
                  <MenuItems
                    class="absolute right-0 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
                    style="z-index: 9999"
                  >
                    <div class="px-1 py-1">
                      <MenuItem v-slot="{ active }">
                        <Link :href="route('profile.edit')">
                          <button
                            :class="[
                              active
                                ? 'bg-gray-100 text-gray-700'
                                : 'text-gray-900',
                              'group flex w-full items-center px-4 py-2 text-sm',
                            ]"
                          >
                            Profile
                          </button>
                        </Link>
                      </MenuItem>
                      <MenuItem v-slot="{ active }">
                        <Link :href="route('profile.edit')">
                          <button
                            :class="[
                              active
                                ? 'bg-gray-100 text-gray-700'
                                : 'text-gray-900',
                              'group flex w-full items-center px-4 py-2 text-sm',
                            ]"
                          >
                            Upload photo
                          </button>
                        </Link>
                      </MenuItem>

                      <MenuItem v-slot="{ active }">
                        <Link :href="route('logout')" method="post">
                          <button
                            :class="[
                              active
                                ? 'bg-gray-100 text-gray-700'
                                : 'text-gray-900',
                              'group flex w-full items-center px-4 py-2 text-sm',
                            ]"
                          >
                            Sign out
                          </button>
                        </Link>
                      </MenuItem>
                    </div>
                  </MenuItems>
                </transition>
              </Menu>
            </div>
          </div>
        </nav>

        <!-- Page Heading -->
        <header class="shadow" v-if="$slots.header">
          <div class="mx-auto max-w-7xl py-6 px-4 sm:px-6 lg:px-8">
            <slot name="header" />
          </div>
        </header>

        <!-- Page Content -->
        <main>
          <slot />
        </main>
      </div>
    </div>
  </div>
</template>
