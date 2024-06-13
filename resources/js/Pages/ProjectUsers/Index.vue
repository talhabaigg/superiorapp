<template>
  <ProjectLayout :project="project">
    <div>
      <div class="m-2">
        <form @submit.prevent="addUser">
          <select v-model="newUserId">
            <option v-for="user in allUsers" :key="user.id" :value="user.id">
              {{ user.name }}
            </option>
          </select>
          <button type="submit">Add User</button>
        </form>
      </div>

      <div
        class="mt-2 relative overflow-x-auto mx-auto max-w-7xl rounded-lg sm:block overflow-y-hidden"
      >
        <table
          class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
        >
          <thead class="bg-gray-300">
            <tr>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              ></th>
              <th
                scope="col"
                class="py-3 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
              >
                Name
              </th>
              <th
                scope="col"
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                Employee type
              </th>

              <th
                scope="col"
                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell"
              >
                Email
              </th>
              <th
                scope="col"
                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell"
              >
                Mobile
              </th>
              <th
                scope="col"
                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell"
              >
                Travel zone
              </th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 bg-white">
            <tr v-for="user in users" :key="user.id">
              <td
                class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap"
              >
                <img
                  :src="getAvatarUrl(user.avatar)"
                  alt="Avatar"
                  class="h-8 w-8 rounded-full"
                />
              </td>
              <td
                class="w-full max-w-0 overflow-hidden whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6"
              >
                <div>
                  <div
                    v-if="user.is_active === 1"
                    class="text-blue-600 hover:text-blue-900"
                  >
                    {{ user.name }}
                  </div>
                  <div
                    v-else
                    class="text-blue-600 hover:text-blue-900 line-through"
                  >
                    {{ user.name }} (Deleted user)
                  </div>
                </div>
              </td>
              <td
                class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap"
              >
                {{ user.employee_type }}
              </td>

              <td>
                <div class="text-blue-600 hover:text-blue-900">
                  {{ user.email }}
                </div>
              </td>
              <td>
                <div class="text-blue-600 hover:text-blue-900">
                  {{ user.phone_number }}
                </div>
              </td>
              <td>
                <div
                  class="px-3 py-4 text-sm text-gray-500 sm:table-cell whitespace-nowrap"
                >
                  No travel zone set
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- <h2>Assigned Users</h2> -->
      <!-- <ul>
        <li v-for="user in users" :key="user.id">
          {{ user.name }}
          <button @click="removeUser(user.id)">Remove</button>
        </li>
      </ul> -->
    </div>
  </ProjectLayout>
</template>
    
  <script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import ProjectLayout from "@/Pages/Project/ProjectLayout.vue";

const getAvatarUrl = (avatarPath) => {
  if (!avatarPath) return "";
  return `${window.location.origin}/${avatarPath}`;
};

// Props
const props = defineProps({
  users: {
    type: Array,
    required: true,
  },
  project: {
    type: Object,
    required: true,
  },
  allUsers: {
    type: Array,
    required: true,
  },
});

// Reactive state
const newUserId = ref(null);

// Inertia form
const form = useForm({
  project_id: props.project.id,
  user_id: null,
});

// Methods
const addUser = () => {
  form.user_id = newUserId.value;
  form.post(route("project-users.store", { project: props.project.id }), {
    onSuccess: () => {
      newUserId.value = null; // Reset the select field
    },
  });
};

const removeUser = (userId) => {
  form.delete(
    route("project-users.destroy", { project: props.project.id, user: userId }),
    {
      onSuccess: () => {
        // Handle success, like updating the user list or showing a message
      },
    }
  );
};
</script>
  