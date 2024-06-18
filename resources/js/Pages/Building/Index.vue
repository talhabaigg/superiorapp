<template>
  <ProjectLayout :project="project">
    <form
      @submit.prevent="addBuilding"
      class="m-2 space-y-2 md:w-1/2 items-center mx-auto"
    >
      <InputLabel>Building Name</InputLabel>
      <TextInput v-model="building_name" />
      <PrimaryButton>Save</PrimaryButton>
    </form>

    <div class="mt-6">
      <div
        v-for="(building, index) in buildings"
        :key="building.id"
        class="mb-4"
      >
        <div
          class="flex justify-between items-center p-4 border-b border-gray-200"
        >
          <div class="flex">
            <h3 class="text-lg font-medium">{{ building.name }}</h3>
            <span
              class="bg-gray-200 text-gray-900 inline-flex items-center rounded-md px-1.5 py-0.5 text-xs font-medium ml-2 whitespace-nowrap"
              >{{ building.tasks?.length || 0 }} tasks</span
            >
          </div>
          <div>
            <Link
              class="text-xs px-2.5 py-1.5 bg-gray-200 text-gray-900 hover:bg-gray-200 focus:ring-gray-200 inline-flex items-center justify-center rounded-md border border-transparent font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto mr-4"
              :href="
                route('buildingtask.create', {
                  project: project.id,
                  building: building.id,
                })
              "
              >Add Task</Link
            >
            <button @click="toggleTasks(index)" class="p-2 focus:outline-none">
              <svg
                :class="{ 'rotate-180': activeBuildingIndex === index }"
                class="w-4 h-4 transform transition-transform"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 9l-7 7-7-7"
                />
              </svg>
            </button>
          </div>
        </div>
        <div v-if="activeBuildingIndex === index" class="p-4">
          <p
            v-if="!building.tasks || building.tasks.length === 0"
            class="text-gray-500"
          >
            No tasks available
          </p>
          <ul v-else>
            <li v-for="task in building.tasks" :key="task.id">
              <div
                class="mb-1 rounded-md border-l-4 border-r-4 border-gray-300 p-2 bg-white"
              >
                <div class="flex relative mr-3">
                  <Link :href="route('buildingtask.toggle', task.id)"
                    ><div v-if="task.completed_at">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        aria-hidden="true"
                        data-slot="icon"
                        class="text-blue-500 cursor-pointer h-8 w-8"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
                          clip-rule="evenodd"
                        ></path>
                      </svg>
                    </div>
                    <div v-else>
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        aria-hidden="true"
                        data-slot="icon"
                        class="text-gray-300 cursor-pointer h-8 w-8"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
                          clip-rule="evenodd"
                        ></path>
                      </svg></div
                  ></Link>

                  <div class="py-1 px-3 flex">
                    <span
                      class="bg-blue-100 text-gray-900 inline-flex items-center rounded-md px-1.5 py-0.5 text-xs font-medium mr-2"
                      >{{ task.code }}</span
                    >
                    <div class="py-0.5">{{ task.description }}</div>
                    <div class="px-1 py-0.5">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        aria-hidden="true"
                        data-slot="icon"
                        class="inline-flex h-6 w-6"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                        ></path>
                      </svg>
                      (0 of 0 hours completed)
                    </div>
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </ProjectLayout>
</template>

<script setup>
import { ref } from "vue";
import { useForm, Link } from "@inertiajs/vue3";
import ProjectLayout from "@/Pages/Project/ProjectLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
  project: {
    type: Object,
    required: true,
  },
  buildings: {
    type: Array,
    required: true,
  },
});

const building_name = ref("");
const activeBuildingIndex = ref(null);

const form = useForm({
  name: "",
  is_active: 0,
});

const addBuilding = () => {
  form.name = building_name.value;
  form.post(route("buildings.store", { project: props.project.id }));
};

const toggleTasks = (index) => {
  activeBuildingIndex.value =
    activeBuildingIndex.value === index ? null : index;
};
</script>
