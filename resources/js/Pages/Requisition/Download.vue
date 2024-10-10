<template>
  <AuthenticatedLayout>
    <div class="max-w-4xl mt-2 mx-auto p-6 bg-white rounded-lg text-center">
      <h1 class="text-2xl font-bold mb-2 text-gray-800">
        Material Requisition
      </h1>
      <p class="text-lg text-gray-600 mb-4">
        Your PDF has been generated successfully. Click the link below to open
        it:
      </p>
      <a
        :href="pdfUrl ?? pdfUrl"
        target="_blank"
        rel="noopener noreferrer"
        class="inline-block px-4 py-2 bg-blue-600 text-white rounded-md transition duration-200 ease-in-out hover:bg-blue-500"
      >
        Open PDF
      </a>
      <!-- <div class="mt-2">
        Preview PDF
        <PDF
          :page="page"
          :pdf-width="isMobile ? '100%' : '768'"
          :src="pdfUrl"
          class="w-full h-full"
        />
      </div> -->
    </div>
    <div class="w-85"></div>
  </AuthenticatedLayout>
</template>
  
  <script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PDF from "pdf-vue3";
const props = defineProps({
  pdfUrl: {
    type: String,
    // Ensures pdfUrl is passed as a prop
  },
});
</script>
  
  <style scoped>
/* No additional CSS needed, as we are using Tailwind CSS */
</style>
  