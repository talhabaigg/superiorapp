<template>
  <ProjectLayout :project="project">
    <form
      @submit.prevent="createTask"
      class="space-y-4 md:w-1/2 items-center mx-auto"
    >
      <h1 class="text-2xl font-bold mb-4 mt-2">
        Add Task for {{ building.name }}
      </h1>
      <div>
        <InputLabel for="code">Task Code</InputLabel>
        <TextInput id="code" v-model="form.code" class="mt-2 block w-full" />
      </div>
      <div>
        <InputLabel for="description">Description</InputLabel>
        <TextInput
          id="description"
          v-model="form.description"
          class="mt-1 block w-full"
        />
      </div>
      <div>
        <InputLabel for="wages_assigned">Wages Assigned</InputLabel>
        <TextInput
          id="wages_assigned"
          v-model="form.wages_assigned"
          type="number"
          class="mt-1 block w-full"
        />
      </div>
      <div>
        <InputLabel for="completed_at">Completion Date</InputLabel>
        <TextInput
          id="completed_at"
          v-model="form.completed_at"
          type="date"
          class="mt-1 block w-full"
        />
      </div>
      <PrimaryButton class="mt-4">Create Task</PrimaryButton>
    </form>
  </ProjectLayout>
</template>

<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import ProjectLayout from "@/Pages/Project/ProjectLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
  project: {
    type: Object,
    required: true,
  },
  building: {
    type: Object,
    required: true,
  },
});

const form = useForm({
  code: "",
  description: "",
  wages_assigned: "",
  completed_at: "",
});

const createTask = () => {
  form.post(
    route("buildingtasks.store", {
      project: props.project.id,
      building: props.building.id,
    }),
    {
      onSuccess: () => {
        form.reset(); // Clear the form after successful submission
      },
    }
  );
};
</script>
