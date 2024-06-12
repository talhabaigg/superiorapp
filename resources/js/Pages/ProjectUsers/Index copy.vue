<template>
  <ProjectLayout :project="project">
    <div>
      <h1>{{ project.project_name }}</h1>
      <h2>Assigned Users</h2>
      <ul>
        <li v-for="user in users" :key="user.id">
          {{ user.name }}
          <button @click="removeUser(user.id)">Remove</button>
        </li>
      </ul>
      <form @submit.prevent="addUser">
        <select v-model="newUserId">
          <option v-for="user in allUsers" :key="user.id" :value="user.id">
            {{ user.name }}
          </option>
        </select>
        <button type="submit">Add User</button>
      </form>
    </div>
  </ProjectLayout>
</template>
    
  <script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import ProjectLayout from "@/Pages/Project/ProjectLayout.vue";

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
  