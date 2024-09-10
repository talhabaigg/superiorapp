<template>
  <AuthenticatedLayout>
    <header class="bg-gray-100 py-3 px-4 sm:px-4 md:px-6">
      <div class="container mx-auto">
        <nav class="py-2 pl-2 flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900">
              Upload signatures for {{ prestart.project.project_name }}
            </h1>
            <div>
              <Breadcrumb :crumbs="crumbspage" />
            </div>
          </div>
          <!-- <Link :href="route('daily-prestarts.create')">
            <PrimaryButton>Create Daily Pre-Start</PrimaryButton>
          </Link> -->
        </nav>
      </div>
    </header>
    <div class="max-w-xl mx-auto m-4 p-8 rounded-lg">
      <form @submit.prevent="submitForm">
        <div
          class="-mx-4 mt-8 overflow-y-hidden overflow-x-scroll shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg mb-8"
        >
          <table class="min-w-full divide-y divide-gray-300">
            <tr>
              <th
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                Name
              </th>
              <th
                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell"
              >
                Onsite, sick or other
              </th>
            </tr>
            <tbody>
              <tr
                class="even:bg-gray-50"
                v-for="user in prestart.project.users"
                :key="user.id"
              >
                <td
                  class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell"
                >
                  {{ user.name }}
                </td>
                <td
                  class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell"
                >
                  <div
                    class="mt-2 space-y-4 sm:flex sm:items-center sm:space-x-10 sm:space-y-0"
                  >
                    <div class="flex items-center">
                      <input
                        class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600 disabled:opacity-50"
                        type="radio"
                        v-model="signatures[user.id]"
                        :value="'onsite'"
                      />
                      <label
                        class="ml-3 block text-sm font-medium leading-6 text-gray-900"
                        >Onsite</label
                      >
                    </div>
                    <div class="flex items-center">
                      <input
                        class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600 disabled:opacity-50"
                        type="radio"
                        v-model="signatures[user.id]"
                        :value="'sick'"
                      />
                      <label
                        class="ml-3 block text-sm font-medium leading-6 text-gray-900"
                        >Sick</label
                      >
                    </div>
                    <div class="flex items-center">
                      <input
                        class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600 disabled:opacity-50"
                        type="radio"
                        v-model="signatures[user.id]"
                        :value="'other'"
                      />
                      <label
                        class="ml-3 block text-sm font-medium leading-6 text-gray-900"
                        >Other</label
                      >
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="mt-2">
          <div class="flex w-full items-center justify-center">
            <label
              for="pdfFile"
              class="dark:hover:bg-bray-800 flex h-32 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100"
            >
              <div class="flex flex-col items-center justify-center pb-3 pt-2">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  aria-hidden="true"
                  class="h-10 w-10 text-gray-500"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z"
                  ></path>
                </svg>
                <p class="mb-2 text-sm text-gray-500">
                  Upload Prestart PDF here
                </p>
              </div>
              <input
                id="pdfFile"
                class="hidden"
                type="file"
                @change="handleFileUpload"
              />
            </label>
          </div>
          <!-- Display the selected file -->
          <div v-if="pdfFileName" class="mt-4 text-left">
            <h5 class="mb-2 font-bold text-left">Files to upload</h5>
            <div class="mb-2 flex items-center justify-between text-sm">
              <div class="flex">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  aria-hidden="true"
                  data-slot="icon"
                  class="mr-2 h-6 w-6"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"
                  ></path>
                </svg>
                <div>{{ pdfFileName }}</div>
              </div>
              <div class="text-right">
                <button
                  @click="clearFile"
                  type="button"
                  class="text-xs px-2.5 py-1.5 bg-red-500 text-white hover:bg-red-600 focus:ring-red-400 inline-flex items-center justify-center rounded-md border border-transparent font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    aria-hidden="true"
                    data-slot="icon"
                    class="h-4 w-4"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                    ></path>
                  </svg>
                </button>
              </div>
            </div>
            <!-- <p class="text-sm text-gray-700">
              Selected file: <strong>{{ pdfFileName }}</strong>
            </p> -->
          </div>
        </div>
        <div class="mt-4 flex justify-start items-center space-x-2">
          <PrimaryButton type="submit">Upload signatures</PrimaryButton>
          <UnderlineLink :href="route('daily-prestarts.index')"
            >Cancel</UnderlineLink
          >
        </div>
      </form>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { router } from "@inertiajs/vue3";
import UnderlineLink from "@/Components/UnderlineLink.vue";

const crumbspage = ref([
  { label: "Home", href: "/dashboard" },
  { label: "Daily-Prestarts", href: "/daily-prestarts" },
  {
    label: "Upload signatures",
    href: "/daily-prestarts",
  },
]);

const props = defineProps({
  prestart: Object,
});

// Reactive object to store signatures
const signatures = ref({});
const pdfFile = ref(null); // Store the uploaded file
const pdfFileName = ref(null);

// Function to clear the selected file
const clearFile = () => {
  pdfFile.value = null;
  pdfFileName.value = null;
};

// Function to handle file input
const handleFileUpload = (event) => {
  const file = event.target.files[0];
  if (file) {
    pdfFile.value = file; // Store the file object
    pdfFileName.value = file.name; // Update the file name to display
  }
};

// Function to submit the form
const submitForm = () => {
  const formData = new FormData();
  formData.append("prestart_id", props.prestart.id);

  Object.entries(signatures.value).forEach(([userId, signature]) => {
    formData.append(`signatures[${userId}]`, signature);
  });

  if (pdfFile.value) {
    formData.append("pdf_file", pdfFile.value); // Append the file object to the form data
  }

  // Use Inertia's post method and pass the FormData object
  router.post("/prestart-signed/save", formData, {
    forceFormData: true, // Ensures the request is sent as multipart/form-data
  });
};
</script>
