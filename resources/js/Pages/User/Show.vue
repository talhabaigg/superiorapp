<template>
  <AuthenticatedLayout>
    <header class="bg-gray-100 py-3 px-4 sm:px-4 md:px-6">
      <div class="container mx-auto">
        <nav class="py-2 pl-2 flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900">
              {{ user.name }}
            </h1>
            <div>
              <Breadcrumb :crumbs="crumbspage" />
            </div>
          </div>
          <Link href="/profile" class="mx-2">
            <PrimaryButton>Edit</PrimaryButton>
          </Link>
        </nav>
      </div>
    </header>
    <div class="px-4 py-4 sm:px-6 md:px-8">
      <div
        class="lg:grid-cols-2 mx-auto grid max-w-full grid-cols-1 gap-6 lg:grid-flow-col-dense mt-6"
      >
        <div class="lg:col-span-1 lg:col-start-1 space-y-6">
          <section aria-labelledby="user-information-title">
            <div class="bg-white shadow-lg sm:rounded-lg">
              <div class="col-span-1 flex">
                <div
                  class="flex w-16 flex-shrink-0 items-center justify-center text-lg font-medium leading-6 text-white sm:rounded-tl-lg"
                >
                  <span
                    class="h-10 w-10 inline-flex items-center justify-center rounded-full hover:ring-gray-200"
                    ><img :src="getAvatarUrl(user.avatar)" class="rounded-full"
                  /></span>
                </div>
                <div
                  class="flex flex-1 items-center justify-between bg-white sm:rounded-tr-lg"
                >
                  <div class="flex-1 truncate px-4 px-4 py-2 py-5 sm:px-6">
                    <h2 class="text-lg font-medium leading-6 text-gray-900">
                      About <span class="sr-only">{{ user.name }}</span>
                    </h2>
                  </div>
                </div>
              </div>
              <div class="border-t border-gray-200 py-5 pl-4 pr-2 sm:pl-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6">
                  <div>
                    <dt class="text-xs font-medium uppercase text-gray-400">
                      Employee type
                    </dt>
                    <dd class="text-md mt-1 text-gray-900">
                      {{ user.employee_type }}
                    </dd>
                  </div>
                  <!----><!---->
                  <div>
                    <dt class="text-xs font-medium uppercase text-gray-400">
                      Email address
                    </dt>
                    <dd class="text-md mt-1 text-gray-900">
                      <a
                        href="mailto:talha@superiorgroup.com.au"
                        class="text-blue-600 hover:text-blue-900"
                        >{{ user.email }}</a
                      >
                    </dd>
                  </div>
                  <div>
                    <dt class="text-xs font-medium uppercase text-gray-400">
                      Phone
                    </dt>
                    <dd class="text-md mt-1 text-gray-900">
                      <a
                        href="tel:+61-55967500"
                        class="text-blue-600 hover:text-blue-900"
                        >{{ user.phone_number }}</a
                      >
                    </dd>
                  </div>
                  <div>
                    <dt class="text-xs font-medium uppercase text-gray-400">
                      Permissions
                    </dt>
                    <dd class="text-md mt-1 text-gray-900">
                      <span
                        class="bg-gray-100 text-gray-900 inline-flex items-center rounded-md px-1.5 py-0.5 text-xs font-medium mb-1 mr-1"
                        >-</span
                      >
                    </dd>
                  </div>
                </dl>
              </div>
            </div>
          </section>
        </div>
        <div class="lg:col-span-2 lg:col-start-2 space-y-6">
          <section aria-labelledby="user-projects">
            <div class="bg-white shadow-lg sm:rounded-lg">
              <div class="px-4 py-5 sm:px-6">
                <div class="flex items-center justify-between">
                  <h2 class="text-lg font-medium leading-6 text-gray-900">
                    Projects
                  </h2>
                  <span></span>
                </div>
              </div>
              <div class="border-t border-gray-200 py-6 pl-4 pr-2 sm:pl-6">
                <ul role="list">
                  <div v-if="user.projects">
                    <li
                      v-for="project in user.projects"
                      :key="project.id"
                      class="my-2"
                    >
                      <Link :href="route('project.show', project.id)">
                        <SecondaryButton>{{
                          project.project_name
                        }}</SecondaryButton>
                      </Link>
                    </li>
                  </div>
                  <li v-else>No projects assigned</li>
                </ul>
              </div>
            </div>
          </section>
          <section aria-labelledby="user-timesheets">
            <div class="bg-white shadow-lg sm:rounded-lg">
              <div class="px-4 py-5 sm:px-6">
                <div class="flex items-center justify-between">
                  <h2 class="text-lg font-medium leading-6 text-gray-900">
                    Timesheets
                  </h2>
                  <span></span>
                </div>
              </div>
              <div class="border-t border-gray-200 py-6 pl-4 pr-2 sm:pl-6">
                <ul role="list" class="space-y-4">
                  <li>
                    <a
                      class="text-blue-600 hover:text-blue-900"
                      href="https://app.superiorgroup.com.au/time-sheets/423/2024-06-28"
                    >
                      This weeks timesheet
                    </a>
                  </li>
                  <li v-for="timesheet in user.timesheets" :key="timesheet.id">
                    <a class="text-blue-600 hover:text-blue-900 mr-2">{{
                      timesheet.date
                    }}</a>
                  </li>
                </ul>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
  
  <script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
});

const crumbspage = ref([
  { label: "Home", href: "/dashboard" },
  { label: "Users", href: "/users" },
  { label: `${props.user.name}`, href: `/users/${props.user.id}` },
]);

const getAvatarUrl = (avatarPath) => {
  if (!avatarPath) return "";
  return `${window.location.origin}/${avatarPath}`;
};
</script>
  