<template>
  <AuthenticatedLayout>
    <header class="bg-gray-100 py-3 px-4 sm:px-4 md:px-6">
      <div class="container mx-auto">
        <nav class="py-2 pl-2 flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900">Cost codes</h1>
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
        <form class="mx-auto mt-8 max-w-lg" @submit.prevent="create">
          <div class="mb-6">
            <div class="flex items-center justify-between" for="code">
              <label class="block text-sm font-medium text-gray-700"
                ><span>Code</span></label
              ><!---->
            </div>
            <div id="code" class="mt-1">
              <input
                class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
                autocomplete="off"
                autofocus=""
                required=""
                type="text"
                step=""
                min=""
                max=""
                v-model="form.code"
              /><!---->
            </div>
            <div class="mt-2" style="display: none">
              <p class="mt-2 text-sm text-red-600"></p>
            </div>
          </div>
          <div class="mb-6">
            <div class="flex items-center justify-between" for="description">
              <label class="block text-sm font-medium text-gray-700"
                ><span>Description</span></label
              ><!---->
            </div>
            <div id="description" class="mt-1">
              <input
                class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
                autocomplete="off"
                required=""
                type="text"
                step=""
                min=""
                max=""
                v-model="form.description"
              /><!---->
            </div>
            <div class="mt-2" style="display: none">
              <p class="mt-2 text-sm text-red-600"></p>
            </div>
          </div>
          <div class="mb-6">
            <div class="flex items-center justify-between" for="unit">
              <label class="block text-sm font-medium text-gray-700"
                ><span>Unit</span></label
              ><span class="text-sm text-gray-500" id="email-optional"
                >Optional</span
              >
            </div>
            <div id="unit" class="mt-1">
              <input
                class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
                autocomplete="off"
                type="text"
                step=""
                min=""
                max=""
                v-model="form.unit"
              /><!---->
            </div>
            <div class="mt-2" style="display: none">
              <p class="mt-2 text-sm text-red-600"></p>
            </div>
          </div>
          <div class="mb-6">
            <div class="flex items-center justify-between" for="category_1">
              <label class="block text-sm font-medium text-gray-700"
                ><span>Category 1</span></label
              ><span class="text-sm text-gray-500" id="email-optional"
                >Optional</span
              >
            </div>
            <div id="category_1" class="mt-1">
              <input
                class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
                autocomplete="off"
                type="text"
                step=""
                min=""
                max=""
                v-model="form.category_1"
              /><!---->
            </div>
            <div class="mt-2" style="display: none">
              <p class="mt-2 text-sm text-red-600"></p>
            </div>
          </div>
          <div class="mb-6">
            <div class="flex items-center justify-between" for="category_2">
              <label class="block text-sm font-medium text-gray-700"
                ><span>Category 2</span></label
              ><span class="text-sm text-gray-500" id="email-optional"
                >Optional</span
              >
            </div>
            <div id="category_2" class="mt-1">
              <input
                class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
                autocomplete="off"
                type="text"
                step=""
                min=""
                max=""
                v-model="form.category_2"
              /><!---->
            </div>
            <div class="mt-2" style="display: none">
              <p class="mt-2 text-sm text-red-600"></p>
            </div>
          </div>
          <div class="mb-6">
            <div class="flex items-center justify-between" for="category_3">
              <label class="block text-sm font-medium text-gray-700"
                ><span>Category 3</span></label
              ><span class="text-sm text-gray-500" id="email-optional"
                >Optional</span
              >
            </div>
            <div id="category_3" class="mt-1">
              <input
                class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
                autocomplete="off"
                type="text"
                step=""
                min=""
                max=""
                v-model="form.category_3"
              /><!---->
            </div>
            <div class="mt-2" style="display: none">
              <p class="mt-2 text-sm text-red-600"></p>
            </div>
          </div>
          <div class="mb-6">
            <div class="flex items-center justify-between" for="category_4">
              <label class="block text-sm font-medium text-gray-700"
                ><span>Category 4</span></label
              ><span class="text-sm text-gray-500" id="email-optional"
                >Optional</span
              >
            </div>
            <div id="category_4" class="mt-1">
              <input
                class="block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 sm:text-sm"
                autocomplete="off"
                type="text"
                step=""
                min=""
                max=""
                v-model="form.category_4"
              /><!---->
            </div>
            <div class="mt-2" style="display: none">
              <p class="mt-2 text-sm text-red-600"></p>
            </div>
          </div>

          <div class="flex justify-start items-center space-x-2">
            <PrimaryButton type="submit">Create cost code</PrimaryButton>

            <UnderlineLink :href="route('cost-codes.index')"
              >Cancel</UnderlineLink
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
const crumbspage = ref([
  { label: "Home", href: "/dashboard" },
  { label: "Cost Codes", href: "/cost-codes" },
  { label: "Create", href: "/cost-codes/create" },
]);

const form = useForm({
  code: "",
  description: "",
  unit: "",
  category_1: "",
  category_2: "",
  category_3: "",
  category_4: "",
});

const create = () => {
  form.post(route("cost-codes.store"));
};
</script>