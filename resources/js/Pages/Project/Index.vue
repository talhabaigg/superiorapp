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
  <div class="mt-2 relative overflow-x-auto mx-auto max-w-6xl rounded-lg hidden sm:block ">

    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 ">
      <thead class="md:bg-gray-300">
        <tr>
          <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell">Status</th>
          <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
          <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell">Labour costs</th>
          <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell">Members</th>
          <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"></th>
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
          <td>
            <div class="w-24 bg-gray-200 rounded-full h-4">
              <div class="h-full rounded-full bg-red-500" style="width: 50%"></div>
            </div>
          </td>
          <td class="hidden sm:table-cell">
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
              <button type="button" class="w-8 h-8 rounded-full flex items-center justify-center hover:bg-gray-200" @click="toggleDropdown(project.id)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="12" cy="5" r="2" fill="currentColor"/>
                  <circle cx="12" cy="12" r="2" fill="currentColor"/>
                  <circle cx="12" cy="19" r="2" fill="currentColor"/>
                </svg>
              </button>
              <transition
                enter-active-class="transition ease-out duration-200"
                enter-from-class="opacity-0 translate-y-1"
                enter-to-class="opacity-100 translate-y-0"
                leave-active-class="transition ease-in duration-150"
                leave-from-class="opacity-100 translate-y-0"
                leave-to-class="opacity-0 translate-y-1"
              >
                <div v-if="openDropdown === project.id" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-20">
                  <div v-for="link in dropDownLinks" :key="link.name" class="">
                    
                    <Link :href="`/${link.route}/${project.id}`" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                
                      <span class="text-s">{{ link.name }}</span>
                    </Link>
                  </div>
                </div>
              </transition>
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