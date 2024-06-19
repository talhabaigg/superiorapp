<template>
  <AuthenticatedLayout>
    <div class="container mx-auto p-4">
      <h1 class="text-2xl font-bold mb-4">Log Timesheet</h1>
      <form @submit.prevent="submitForm" class="space-y-4">
        <div>
          <label for="user_id" class="block text-sm font-medium text-gray-700"
            >User</label
          >
          <select
            v-model="form.user_id"
            id="user_id"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
          >
            <option v-for="user in users" :key="user.id" :value="user.id">
              {{ user.name }}
            </option>
          </select>
        </div>
        <div>
          <label
            for="project_id"
            class="block text-sm font-medium text-gray-700"
            >Project</label
          >
          <select
            v-model="form.project_id"
            id="project_id"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
          >
            <option
              v-for="project in projects"
              :key="project.id"
              :value="project.id"
            >
              {{ project.project_name }}
            </option>
          </select>
        </div>
        <div>
          <label for="date" class="block text-sm font-medium text-gray-700"
            >Date</label
          >
          <input
            type="date"
            v-model="form.date"
            id="date"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
          />
        </div>
        <div>
          <label
            for="start_time"
            class="block text-sm font-medium text-gray-700"
            >Start Time</label
          >
          <input
            type="time"
            v-model="form.start_time"
            id="start_time"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
          />
        </div>
        <div>
          <label for="end_time" class="block text-sm font-medium text-gray-700"
            >End Time</label
          >
          <input
            type="time"
            v-model="form.end_time"
            id="end_time"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
          />
        </div>
        <div>
          <label
            for="hours_worked"
            class="block text-sm font-medium text-gray-700"
            >Hours Worked</label
          >
          <input
            type="number"
            step="0.01"
            v-model="form.hours_worked"
            id="hours_worked"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
          />
        </div>
        <div>
          <label
            for="description"
            class="block text-sm font-medium text-gray-700"
            >Description</label
          >
          <textarea
            v-model="form.notes"
            id="notes"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
          ></textarea>
        </div>
        <div>
          <PrimaryButton type="submit">Save</PrimaryButton>
        </div>
      </form>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";

// Props received from the backend
const props = defineProps({
  users: Array,
  projects: Array,
});

// Form setup
const form = useForm({
  user_id: "",
  project_id: "",
  date: "",
  start_time: "",
  end_time: "",
  hours_worked: "",
  notes: "",
});

// Form submission
const submitForm = () => {
  form.post(route("timesheet.store"));
};
</script>