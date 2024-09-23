<template>
  <AuthenticatedLayout>
    <header class="bg-gray-100 py-3 px-4 sm:px-4 md:px-6">
      <div class="container mx-auto">
        <nav class="py-2 pl-2 flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900">
              Import project tasks for all buildings in
              {{ project.project_name }}
            </h1>
            <div>
              <Breadcrumb :crumbs="crumbspage" />
            </div>
          </div>
          <!-- <Link :href="route('cost-codes.create')" class="mx-2">
                <PrimaryButton>Create cost code</PrimaryButton>
              </Link> -->
        </nav>
      </div>
    </header>
    <div class="p-2 px-8">
      <div class="px-4 py-4 sm:px-6 md:px-8">
        <form class="mx-auto mt-8 max-w-lg" @submit.prevent="uploadCSV">
          <p class="mb-6">
            Import multiple tasks for all buildings into your project at one
            time. The buildings/tasks must be in the format shown in the
            <a
              class="text-blue-500 hover:underline"
              href="/example/project-buildings.xlsx"
              target="_blank"
            >
              Excel template
            </a>
            . There should be 4 columns in the file 'Building ID', 'Code',
            'Description', 'Wages assigned'. If your file has the same code as
            an existing 'Task' the data will be updated.
          </p>
          <p class="mb-2"></p>

          <div class="flex w-full items-center justify-center py-2">
            <label
              for="dailyPrestartActivityFiles"
              class="dark:hover:bg-bray-800 flex h-32 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:border-gray-500 dark:hover:bg-gray-600"
            >
              <div class="flex flex-col items-center justify-center pb-3 pt-2">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  aria-hidden="true"
                  data-slot="icon"
                  class="h-10 w-10 text-gray-500 dark:text-gray-400"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z"
                  ></path>
                </svg>
                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                  Upload buldings and tasks file here
                </p>
                <!---->
              </div>
              <input
                id="dailyPrestartActivityFiles"
                @change="handleFileChange"
                multiple=""
                class="hidden"
                type="file"
            /></label>
          </div>
          <div class="flex">
            <button
              @click="uploadCSV"
              type="submit"
              class="text-sm px-4 py-2 bg-blue-500 text-white hover:bg-blue-600 focus:ring-blue-400 inline-flex items-center justify-center rounded-md border border-transparent font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto"
            >
              Import buildings and tasks</button
            ><Link
              class="text-blue-600 hover:text-blue-900 ml-6 mt-2"
              :href="route('cost-codes.index')"
              >Cancel</Link
            >
          </div>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
      <script setup>
import { ref, watch, computed } from "vue";
import { Link, usePage, router } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import UnderlineLink from "@/Components/UnderlineLink.vue";

const props = defineProps({
  project: {
    type: Object,
    required: true,
  },
});
const crumbspage = ref([
  { label: "Home", href: "/dashboard" },
  { label: "Project", href: "/project" },
  { label: "Import buildings and tasks", href: "/cost-codes/create" },
]);

const csvFile = ref(null);

const handleFileChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    csvFile.value = file; // Store the file object
  }
};

// Function to submit the form
const uploadCSV = () => {
  const formData = new FormData();

  if (csvFile.value) {
    formData.append("csv_file", csvFile.value); // Append the file object to the form data
    formData.append("project_id", props.project.id);
  }

  // Use Inertia's post method and pass the FormData object
  router.post(route("buildings.import"), formData, {
    forceFormData: true, // Ensures the request is sent as multipart/form-data
  });
};
</script>