<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import { Link } from "@inertiajs/vue3";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import { usePage } from "@inertiajs/vue3";
import Sidebar from "@/Components/Sidebar.vue";
const page = usePage();

const getAvatarUrl = (avatarPath) => {
  if (!avatarPath) return "";
  return `${window.location.origin}/${avatarPath}`;
};

console.log(getAvatarUrl);
</script>

<template>
  <div class="flex h-screen">
    <Sidebar :user="$page.props.auth.user" />
    <div class="flex-grow flex flex-col overflow-auto flex-1">
      <div class="min-h-screen">
        <nav
          class="bg-gray-900 lg:bg-white block sm:hidden border-b border-gray-100"
        >
          <!-- Primary Navigation Menu -->
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
              <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 hidden items-center lg:flex">
                  <Link :href="route('dashboard')">
                    <ApplicationLogo
                      class="block h-9 w-auto fill-current text-gray-800"
                    />
                  </Link>
                </div>
                <div class="-me-2 flex items-center lg:hidden">
                  <button
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 focus:outline-none transition duration-150 ease-in-out"
                  >
                    <svg
                      class="h-6 w-6"
                      stroke="currentColor"
                      fill="none"
                      viewBox="0 0 24 24"
                    >
                      <path
                        :class="{
                          hidden: showingNavigationDropdown,
                          'inline-flex': !showingNavigationDropdown,
                        }"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"
                      />
                      <path
                        :class="{
                          hidden: !showingNavigationDropdown,
                          'inline-flex': showingNavigationDropdown,
                        }"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"
                      />
                    </svg>
                  </button>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 lg:flex">
                  <NavLink
                    :href="route('dashboard')"
                    :active="route().current('dashboard')"
                  >
                    Dashboard
                  </NavLink>
                </div>
              </div>

              <div class="hidden lg:flex lg:items-center sm:ms-6">
                <!-- Settings Dropdown -->
                <div class="ms-3 relative">
                  <Dropdown align="right" width="48">
                    <template #trigger>
                      <span class="inline-flex rounded-md">
                        <button
                          type="button"
                          class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                        >
                          {{ $page.props.auth.user.name }}

                          <svg
                            class="ms-2 -me-0.5 h-4 w-4"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                          >
                            <path
                              fill-rule="evenodd"
                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                              clip-rule="evenodd"
                            />
                          </svg>
                        </button>
                      </span>
                    </template>

                    <template #content>
                      <DropdownLink :href="route('profile.edit')">
                        Profile
                      </DropdownLink>
                      <DropdownLink
                        :href="route('logout')"
                        method="post"
                        as="button"
                      >
                        Log Out
                      </DropdownLink>
                    </template>
                  </Dropdown>
                </div>
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
                    <img
                      :src="getAvatarUrl($page.props.auth.user.avatar)"
                      alt="Avatar"
                      class="h-8 w-8 rounded-full"
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
