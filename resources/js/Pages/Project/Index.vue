<template>
      <AuthenticatedLayout>
  <header class="bg-white py-3">
    <div class="container mx-auto">
      <nav class="p-4 flex items-center justify-between">
        <div>
          <h1 class="text-2xl font-semibold text-gray-900">
            Projects
          </h1>
        </div>
        <Link :href="route('project.create')">
          <div class="text-xs px-2.5 py-1.5 bg-blue-500 text-white hover:bg-blue-600 focus:ring-blue-400 inline-flex items-center justify-center rounded-md border border-transparent font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto">
            Create Project
          </div>
        </Link>
      </nav>
    </div>
  </header>
  <div class="p-2">
  <div class="mt-2 relative overflow-x-auto mx-auto max-w-6xl rounded-lg  sm:block overflow-y-hidden">

    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 ">
      <thead class="bg-gray-300">
        <tr>
          <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell">Status</th>
          <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
          <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell">Labour costs</th>
          <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell">Members</th>
          <th scope="col" class=" px-3 py-3.5 text-left text-sm font-semibold text-gray-900 table-cell"></th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 bg-white ">
        <tr v-for="project in projects" :key="project.id">
          <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap">
            <span class="bg-blue-500 text-white inline-flex items-center rounded-md px-1.5 py-0.5 text-xs font-medium">Active</span>
          </td>
          <td class="w-full max-w-0 overflow-hidden whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6">
            <div class="text-blue-600 hover:text-blue-900">{{ project.project_name }}</div>
            <div class="text-sm text-gray-500">{{ project.subsidiary }}</div>
          </td>
          <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap">
            <div class="mb-1 text-base  dark:text-white">45% labour used</div>
            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
            
              <div class="bg-blue-600 h-2.5 rounded-full" style="width: 45%"></div>
            </div>


          </td>
          <td class="hidden sm:table-cell ">
            <div class="flex items-center space-x-2">
              <div class="avatar bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center">RG</div>
              <div class="avatar bg-green-500 text-white rounded-full w-8 h-8 flex items-center justify-center">CG</div>
              <div class="avatar bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center">SG</div>
              <div class="avatar bg-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center">LO</div>
              <div class="text-sm text-gray-500">Show all</div>
            </div>
          </td>
          <td class="relative">
            <div class="relative w-8 h-8">
              <Menu as="div" class="h-8 w-8   rounded-full relative inline-block text-left">
              <MenuButton type="button" class="w-8 h-8 rounded-full flex items-center justify-center hover:bg-gray-200">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="12" cy="5" r="2" fill="currentColor"/>
                  <circle cx="12" cy="12" r="2" fill="currentColor"/>
                  <circle cx="12" cy="19" r="2" fill="currentColor"/>
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
                            class="absolute right-0 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
                            style="z-index: 9999;" >
                            <div class="px-1 py-1">
                              <MenuItem v-slot="{ active }">
                                <Link :href="`/project/${project.id}`"> 
                                    <button
                                    :class="[
                                    active ? 'bg-gray-100 text-gray-700' : 'text-gray-900',
                                    'group flex w-full items-center px-4 py-2 text-sm',
                                    ]"
                                >
                                    Profile
                                </button>
                                </Link>
                                </MenuItem>
                            </div>
                        </MenuItems>
              </transition>
              </Menu>
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
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
// Define props
const props = defineProps({
  projects: Array,
});

// Reactive state
const openDropdown = ref(null);

// Methods
const toggleDropdown = (projectId) => {
  if (openDropdown.value === projectId) {
    openDropdown.value = null;
  } else {
    openDropdown.value = projectId;
  }
};

const dropDownLinks = [
  { name: 'QR login scanner', icon: 'mdi:folder-outline', route: 'project' },
  { name: 'QR Cards PDF', icon: 'mdi:folder-outline', route: 'swms' },
  { name: 'Summary', icon: 'mdi:folder-outline', route: 'project' },
  { name: 'View SWMS', icon: 'mdi:folder-outline', route: 'swms' },
];
</script>