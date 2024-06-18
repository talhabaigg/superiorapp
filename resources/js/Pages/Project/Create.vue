<template>
  <AuthenticatedLayout>
    <header class="bg-gray-100 py-3">
      <div class="container mx-auto">
        <nav class="py-4 px-4 flex items-center justify-between mx-auto">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900">Create Project</h1>
          </div>
        </nav>
      </div>
    </header>

    <div class="max-w-xl mx-auto m-4 p-8 rounded-lg">
      <form @submit.prevent="create">
        <div class="grid grid-cols-1 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700"
              >Project name</label
            >
            <input
              type="text"
              v-model="form.project_name"
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            />
            <div v-if="form.errors.project_name" class="input-error">
              {{ form.errors.project_name }}
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700"
              >Abbreviated project name</label
            >
            <input
              type="text"
              v-model="form.abbreviated_project_name"
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            />
            <div
              v-if="form.errors.abbreviated_project_name"
              class="input-error"
            >
              {{ form.errors.abbreviated_project_name }}
            </div>
          </div>

          <div>
            <label
              for="subsidiary"
              class="block text-sm font-medium text-gray-700"
              >Subsidiary</label
            >
            <select
              v-model="form.subsidiary"
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            >
              <option disabled value="">Select a subsidiary</option>
              <option>Greenline</option>
              <option>Superior Walls and Ceilings</option>
              <!-- Add more options here -->
            </select>
            <div v-if="form.errors.subsidiary" class="input-error">
              {{ form.errors.subsidiary }}
            </div>
          </div>

          <div>
            <label
              for="project_number"
              class="block text-sm font-medium text-gray-700"
              >Project number</label
            >
            <input
              v-model="form.project_number"
              type="number"
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            />
            <div v-if="form.errors.project_number" class="input-error">
              {{ form.errors.project_number }}
            </div>
          </div>

          <div>
            <label
              for="description"
              class="block text-sm font-medium text-gray-700"
              >Description<span class="text-gray-500"> (Optional)</span></label
            >
            <textarea
              v-model="form.description"
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
              rows="3"
            ></textarea>
          </div>

          <div>
            <label for="notes" class="block text-sm font-medium text-gray-700"
              >Notes<span class="text-gray-500"> (Optional)</span></label
            >
            <textarea
              v-model="form.notes"
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
              rows="3"
            ></textarea>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700"
              >Timezone</label
            >
            <select
              v-model="form.timezone"
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            >
              <option disabled value="">Select a Timezone</option>
              <option>South Australia</option>
              <option>Queensland</option>
              <option>Northern Territory</option>
              <option>Tasmania</option>
              <option>Victoria</option>
              <option>Western Australia</option>
              <option>New South Wales</option>
              <!-- Add more options here -->
            </select>
            <div v-if="form.errors.timezone" class="input-error">
              {{ form.errors.timezone }}
            </div>
          </div>

          <div>
            <label
              for="average_hourly_rate"
              class="block text-sm font-medium text-gray-700"
              >Average hourly rate</label
            >
            <input
              type="number"
              v-model="form.average_hourly_rate"
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            />
            <div v-if="form.errors.average_hourly_rate" class="input-error">
              {{ form.errors.average_hourly_rate }}
            </div>
          </div>

          <div>
            <label
              for="estimated_hours"
              class="block text-sm font-medium text-gray-700"
              >Estimated hours<span class="text-gray-500">
                (Optional)</span
              ></label
            >
            <input
              type="number"
              v-model="form.estimated_hours"
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            />
            <div v-if="form.errors.estimated_hours" class="input-error">
              {{ form.errors.estimated_hours }}
            </div>
          </div>

          <div>
            <label
              for="deadline"
              class="block text-sm font-medium text-gray-700"
              >Deadline</label
            >
            <input
              type="date"
              v-model="form.deadline"
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            />
            <div v-if="form.errors.deadline" class="input-error">
              {{ form.errors.deadline }}
            </div>
          </div>

          <div class="flex items-center">
            <input
              type="checkbox"
              v-model="form.completed"
              :true-value="1"
              :false-value="0"
              class="h-4 w-4 text-blue-600 border-gray-300 rounded"
            />
            <label for="completed" class="ml-2 block text-sm text-gray-900"
              >Completed</label
            >
          </div>

          <div class="flex items-center">
            <input
              type="checkbox"
              v-model="form.daily_qr_code"
              :true-value="1"
              :false-value="0"
              class="h-4 w-4 text-blue-600 border-gray-300 rounded"
            />
            <label for="daily_qr_code" class="ml-2 block text-sm text-gray-900"
              >Daily QR code (Pre-starts)</label
            >
          </div>

          <div class="flex justify-start items-center space-x-2">
            <PrimaryButton type="submit">Create Project</PrimaryButton>

            <UnderlineLink :href="route('project.index')">Cancel</UnderlineLink>
          </div>
        </div>
      </form>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import UnderlineLink from "@/Components/UnderlineLink.vue";

const form = useForm({
  project_name: "",
  abbreviated_project_name: "",
  subsidiary: "",
  project_number: 0,
  description: "",
  notes: "",
  timezone: "",
  average_hourly_rate: 75,
  estimated_hours: 0,
  deadline: "",
  completed: 0,
  daily_qr_code: 0,
});

const create = () => {
  form.post(route("project.store"));
};
</script>



