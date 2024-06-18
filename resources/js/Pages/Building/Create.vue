<template>
  <form class="mx-auto mt-8 max-w-lg" data-sharkid="__form__0">
    <div class="mb-6">
      <div class="flex items-center justify-between" for="building">
        <label class="block text-sm font-medium text-gray-700"
          ><span>Building name</span></label
        ><!---->
      </div>
      <div id="building" class="mt-1">
        <input
          class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
          autocomplete="off"
          autofocus=""
          required=""
          type="text"
          step=""
          min=""
          max=""
          data-sharkid="__0"
        /><!---->
      </div>
      <div class="mt-2" style="display: none">
        <p class="mt-2 text-sm text-red-600"></p>
      </div>
    </div>
    <div class="mb-6">
      <!---->
      <div class="mt-2" style="display: none">
        <p class="mt-2 text-sm text-red-600"></p>
      </div>
    </div>
    <div class="flex">
      <button
        type="submit"
        class="text-sm px-4 py-2 bg-blue-500 text-white hover:bg-blue-600 focus:ring-blue-400 inline-flex items-center justify-center rounded-md border border-transparent font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto"
      >
        Create building</button
      ><a
        class="text-blue-600 hover:text-blue-900 ml-6 mt-2"
        href="https://app.staging.superiorgroup.com.au/project-buildings/939bad50-c043-437a-8f8a-58b9c64f5131"
        >Cancel</a
      >
    </div>
  </form>
</template>
<script setup>
</script>