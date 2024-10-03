<template>
  <AuthenticatedLayout>
    <header class="bg-gray-100 py-3 px-4 sm:px-4 md:px-6">
      <div class="container mx-auto">
        <nav class="py-2 pl-2 flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900">
              Edit - {{ user.name }}
            </h1>
            <div>
              <Breadcrumb :crumbs="crumbspage" />
            </div>
          </div>
        </nav>
      </div>
    </header>
    <div class="px-4 py-4 sm:px-6 md:px-8">
      <form class="mx-auto mt-8 max-w-lg" @submit.prevent="submitForm">
        <div class="mb-6">
          <div class="flex items-center justify-between">
            <label class="block text-sm font-medium text-gray-700">
              <span>Name</span>
            </label>
          </div>
          <div id="name" class="mt-1">
            <input
              class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
              autocomplete="off"
              autofocus
              required
              type="text"
              v-model="form.name"
            />
          </div>
        </div>

        <div class="mb-6">
          <div class="flex items-center justify-between">
            <label class="block text-sm font-medium text-gray-700">
              <span>Email</span>
            </label>
          </div>
          <div id="email" class="mt-1">
            <input
              class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
              autocomplete="off"
              required
              type="email"
              v-model="form.email"
            />
          </div>
        </div>

        <div class="mb-6">
          <div class="flex items-center justify-between">
            <label class="block text-sm font-medium text-gray-700">
              <span>Mobile</span>
            </label>
          </div>
          <div id="mobile" class="mt-1">
            <input
              class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
              autocomplete="off"
              required
              type="tel"
              v-model="form.phone_number"
            />
          </div>
        </div>

        <div class="mb-6">
          <div class="flex items-center justify-between">
            <label class="block text-sm font-medium text-gray-700">
              <span>Birthday</span>
            </label>
          </div>
          <div id="birthday" class="mt-1">
            <input
              class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
              autocomplete="off"
              type="date"
              v-model="form.birthday"
            />
          </div>
        </div>

        <div class="mb-6">
          <div class="flex items-center justify-between">
            <label class="block text-sm font-medium text-gray-700">
              <span>Employee type</span>
            </label>
          </div>
          <select
            class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm mt-1"
            v-model="form.employee_type"
          >
            <option value="">Select employee type</option>
            <option
              v-for="option in employee_types"
              :key="option.id"
              :value="option.name"
            >
              {{ option.name }}
            </option>
          </select>
        </div>

        <div class="mb-6">
          <div class="flex items-center justify-between">
            <label class="block text-sm font-medium text-gray-700">
              <span>Superior Walls &amp; Ceilings ID</span>
            </label>
            <span class="text-sm text-gray-500">Optional</span>
          </div>
          <div class="mt-1">
            <input
              class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
              autocomplete="off"
              type="text"
              v-model="form.superior_id"
            />
          </div>
        </div>

        <div class="mb-6">
          <div class="flex items-center justify-between">
            <label class="block text-sm font-medium text-gray-700">
              <span>Greenline ID</span>
            </label>
            <span class="text-sm text-gray-500">Optional</span>
          </div>
          <div class="mt-1">
            <input
              class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
              autocomplete="off"
              type="text"
              v-model="form.greenline_id"
            />
          </div>
        </div>

        <div class="flex items-center space-x-2 mb-6">
          <input
            id="connector"
            type="checkbox"
            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
            v-model="form.is_connector"
          />
          <label for="connector" class="ml-2 block text-sm text-gray-900">
            Connector or ASIST worker
          </label>
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">
            <span>Additional permissions</span>
          </label>
        </div>
        <div class="flex items-center space-x-2 mb-4">
          <input
            id="select-all"
            type="checkbox"
            :checked="allSelected"
            @change="toggleSelectAll"
            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
          />
          <label for="select-all" class="ml-2 block text-sm text-gray-900">
            Select All
          </label>
        </div>

        <div
          v-for="permission in permissions"
          :key="permission.id"
          class="flex items-center space-x-2 mb-4"
        >
          <input
            :id="permission.id"
            type="checkbox"
            v-model="form.userPermissions"
            :value="permission.name"
            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
          />
          <label :for="permission.id" class="ml-2 block text-sm text-gray-900">
            {{ permission.name }}
          </label>
        </div>

        <div class="flex">
          <button
            type="submit"
            class="text-sm px-4 py-2 bg-blue-500 text-white hover:bg-blue-600 focus:ring-blue-400 inline-flex items-center justify-center rounded-md border border-transparent font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto"
          >
            Save
          </button>
          <Link
            class="text-blue-600 hover:text-blue-900 ml-6 mt-2"
            :href="route('users.index')"
            >Cancel</Link
          >
        </div>
      </form>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref, computed } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import Breadcrumb from "@/Components/Breadcrumb.vue";

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
  employee_types: {
    type: Array,
    required: true,
  },
  permissions: {
    type: Array,
    required: true,
  },
  userPermissions: {
    type: Array,
    required: true,
  },
});

const crumbspage = ref([
  { label: "Home", href: "/dashboard" },
  { label: "Users", href: "/users" },
  { label: `${props.user.name}`, href: `/users/${props.user.id}` },
  { label: "Edit", href: "" },
]);

const form = useForm({
  name: props.user.name || "",
  email: props.user.email || "",
  employee_type: props.user.employee_type || "",
  phone_number: props.user.phone_number || "",
  superior_id: props.user.superior_id || "",
  greenline_id: props.user.greenline_id || "",
  userPermissions: props.userPermissions || [],
  is_connector: props.user.is_connector || false,
});

const submitForm = () => {
  // Submit the form to the Laravel backend
  form.put(route("users.update", props.user.id));
};

const allSelected = computed(() =>
  props.permissions.every((permission) =>
    form.userPermissions.includes(permission.name)
  )
);

// Toggle "Select All" functionality
const toggleSelectAll = () => {
  if (allSelected.value) {
    form.userPermissions = [];
  } else {
    form.userPermissions = props.permissions.map(
      (permission) => permission.name
    );
  }
};
</script>

<style scoped>
/* Add any additional styles here */
</style>
