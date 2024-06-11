<template>
  <AuthenticatedLayout>
    <header class="bg-white py-3 px-4 sm:px-4 md:px-6">
      <div class="container mx-auto max-w-6xl">
        <nav class="py-4 pl-2 flex items-center justify-between max-w-6xl">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900">
              {{ project.project_name }}
            </h1>
            <ul class="flex items-center space-x-4 overflow-hidden">
              <li>
                <a class="text-gray-400 hover:text-gray-500">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    aria-hidden="true"
                    class="h-5 w-5 flex-shrink-0"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M9.293 2.293a1 1 0 0 1 1.414 0l7 7A1 1 0 0 1 17 11h-1v6a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-6H3a1 1 0 0 1-.707-1.707l7-7Z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </a>
              </li>
              <li>
                <a class="text-gray-400 hover:text-gray-500">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    aria-hidden="true"
                    class="h-5 w-5 flex-shrink-0 text-gray-400"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </a>
              </li>
              <li>
                <a
                  class="ml-2 whitespace-nowrap text-sm font-medium text-gray-500 hover:text-gray-700"
                  href="https://app.superiorgroup.com.au/projects/943ca432-9a3d-42dc-93e1-b30dc2d0ab5f"
                  >{{ project.project_name }}</a
                >
              </li>
            </ul>
          </div>
          <Link class="mx-2">
            <PrimaryButton>Edit</PrimaryButton>
          </Link>
        </nav>
      </div>
    </header>

    <div class="hidden sm:block max-w-7xl mx-auto px-4 py-4 sm:px-6 md:px-8">
      <div class="border-b border-gray-200">
        <nav class="-mb-px flex">
          <TabLink
            v-for="tab in tabs"
            :key="tab.name"
            :href="route(tab.routeName, { project: project.id })"
            :active="route().current(tab.routeName, { project: project.id })"
          >
            {{ tab.name }}
          </TabLink>
        </nav>
      </div>
      <div
        class="lg:grid-cols-2 mx-auto grid max-w-full grid-cols-1 gap-6 lg:grid-flow-col-dense mt-8"
      >
        <div class="lg:col-span-1 lg:col-start-1 space-y-6">
          <section aria-labelledby="project-information-title">
            <div class="bg-white shadow sm:rounded-lg">
              <div class="px-4 py-5 sm:px-6">
                <div class="flex items-center justify-between">
                  <h2 class="text-lg font-medium leading-6 text-gray-900">
                    Project summary
                  </h2>
                  <span></span>
                </div>
              </div>
              <div class="border-t border-gray-200 py-5 pl-4 pr-2 sm:pl-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6">
                  <div>
                    <dt class="text-xs font-medium uppercase text-gray-400">
                      Project number
                    </dt>
                    <dd class="text-md mt-1 text-gray-900">
                      {{ project.project_number }}
                    </dd>
                  </div>
                  <div>
                    <dt class="text-xs font-medium uppercase text-gray-400">
                      Status
                    </dt>
                    <dd class="text-md mt-1 text-gray-900">
                      <PrimaryBadge v-if="project.is_active">
                        Active
                      </PrimaryBadge>
                      <GrayBadge v-else> Inactive </GrayBadge>
                    </dd>
                  </div>
                  <div>
                    <dt class="text-xs font-medium uppercase text-gray-400">
                      Subsidiary
                    </dt>
                    <dd class="text-md mt-1 text-gray-900">
                      {{ project.subsidiary }}
                    </dd>
                  </div>
                  <div>
                    <dt class="text-xs font-medium uppercase text-gray-400">
                      Daily QR code (Pre-starts)
                    </dt>
                    <dd class="text-md mt-1 text-gray-900"><span>No</span></dd>
                  </div>
                  <div>
                    <dt class="text-xs font-medium uppercase text-gray-400">
                      Labour used
                    </dt>
                    <dd class="text-md mt-1 text-gray-900">
                      <div class="mb-1 text-sm dark:text-white">
                        283,027 of 183,360 hours used
                      </div>
                      <div
                        class="h-2.5 w-full rounded-full bg-gray-200 dark:bg-gray-700"
                      >
                        <div
                          class="h-2.5 rounded-full bg-red-500"
                          style="width: 100%"
                        ></div>
                      </div>
                    </dd>
                  </div>
                  <div>
                    <dt class="text-xs font-medium uppercase text-gray-400">
                      Average hourly rate
                    </dt>
                    <dd class="text-md mt-1 text-gray-900">
                      ${{ project.average_hourly_rate }}
                    </dd>
                  </div>
                  <div>
                    <dt class="text-xs font-medium uppercase text-gray-400">
                      Estimated labour costs
                    </dt>
                    <dd class="text-md mt-1 text-gray-900">
                      ${{
                        project.estimated_hours * project.average_hourly_rate
                      }}
                    </dd>
                  </div>
                  <div>
                    <dt class="text-xs font-medium uppercase text-gray-400">
                      Labour costs
                    </dt>
                    <dd class="text-md mt-1 text-gray-900">$19,811,890.00</dd>
                  </div>
                  <div>
                    <dt class="text-xs font-medium uppercase text-gray-400">
                      Deadline
                    </dt>
                    <dd class="text-md mt-1 text-gray-900">
                      <span>{{ project.deadline }}</span>
                    </dd>
                  </div>
                  <div>
                    <dt class="text-xs font-medium uppercase text-gray-400">
                      Timezone
                    </dt>
                    <dd class="text-md mt-1 text-gray-900">
                      Australia/{{ project.timezone }}
                    </dd>
                  </div>
                  <div>
                    <dt class="text-xs font-medium uppercase text-gray-400">
                      Last updated
                    </dt>
                    <dd class="text-md mt-1 text-gray-900">
                      {{ project.updated_at }}
                    </dd>
                  </div>
                  <div>
                    <dt class="text-xs font-medium uppercase text-gray-400">
                      Created
                    </dt>
                    <dd class="text-md mt-1 text-gray-900">
                      {{ project.created_at }}
                    </dd>
                  </div>
                </dl>
              </div>
            </div>
          </section>
        </div>
        <div class="lg:col-span-2 lg:col-start-2 space-y-6">
          <section aria-labelledby="project-notes">
            <div class="bg-white shadow sm:rounded-lg">
              <div class="px-4 py-5 sm:px-6">
                <div class="flex items-center justify-between">
                  <h2 class="text-lg font-medium leading-6 text-gray-900">
                    Notes
                  </h2>
                  <span></span>
                </div>
              </div>
              <div class="border-t border-gray-200 py-6 pl-4 pr-2 sm:pl-6">
                <ul role="list" class="space-y-4">
                  <li>
                    {{ project.notes }}
                  </li>
                </ul>
              </div>
            </div>
          </section>
          <section aria-labelledby="project-leading-hands">
            <div class="bg-white shadow sm:rounded-lg">
              <div class="px-4 py-5 sm:px-6">
                <div class="flex items-center justify-between">
                  <h2 class="text-lg font-medium leading-6 text-gray-900">
                    Leading hands
                  </h2>
                  <span></span>
                </div>
              </div>
              <div class="border-t border-gray-200 py-6 pl-4 pr-2 sm:pl-6">
                <ul role="list" class="space-y-4">
                  <li>
                    <div class="flex"><span>Nothing found</span></div>
                  </li>
                </ul>
              </div>
            </div>
          </section>
          <section aria-labelledby="project-hsr-duties">
            <div class="bg-white shadow sm:rounded-lg">
              <div class="px-4 py-5 sm:px-6">
                <div class="flex items-center justify-between">
                  <h2 class="text-lg font-medium leading-6 text-gray-900">
                    HSR duties
                  </h2>
                  <span></span>
                </div>
              </div>
              <div class="border-t border-gray-200 py-6 pl-4 pr-2 sm:pl-6">
                <ul role="list" class="space-y-4">
                  <li>
                    <div class="flex"><span>Nothing found</span></div>
                  </li>
                </ul>
              </div>
            </div>
          </section>
          <section aria-labelledby="project-union-delegates">
            <div class="bg-white shadow sm:rounded-lg">
              <div class="px-4 py-5 sm:px-6">
                <div class="flex items-center justify-between">
                  <h2 class="text-lg font-medium leading-6 text-gray-900">
                    Union delegates
                  </h2>
                  <span></span>
                </div>
              </div>
              <div class="border-t border-gray-200 py-6 pl-4 pr-2 sm:pl-6">
                <ul role="list" class="space-y-4">
                  <li>
                    <div class="flex"><span>Nothing found</span></div>
                  </li>
                </ul>
              </div>
            </div>
          </section>
          <section aria-labelledby="project-members">
            <div class="bg-white shadow sm:rounded-lg">
              <div class="px-4 py-5 sm:px-6">
                <div class="flex items-center justify-between">
                  <h2 class="text-lg font-medium leading-6 text-gray-900">
                    All team members
                  </h2>
                  <span></span>
                </div>
              </div>
              <div class="border-t border-gray-200 py-6 pl-4 pr-2 sm:pl-6">
                <ul role="list" class="space-y-4">
                  <li>
                    <div class="flex">
                      <span class="flex -space-x-1 overflow-hidden xl:inline"
                        ><a
                          class="inline-block h-8 w-8 rounded-full ring-2 ring-white"
                          href="https://app.superiorgroup.com.au/users/137"
                          ><span
                            class="h-8 w-8 inline-flex items-center justify-center rounded-full hover:ring-gray-200"
                            title="Ryan Gundry"
                            ><img
                              src="/storage/avatar-137.jpg"
                              class="rounded-full" /></span></a
                        ><a
                          class="inline-block h-8 w-8 rounded-full ring-2 ring-white"
                          href="https://app.superiorgroup.com.au/users/15"
                          ><span
                            class="h-8 w-8 inline-flex items-center justify-center rounded-full hover:ring-gray-200"
                            title="Corey Gill"
                            ><img
                              src="/storage/avatar-15.jpg"
                              class="rounded-full" /></span></a
                        ><a
                          class="inline-block h-8 w-8 rounded-full ring-2 ring-white"
                          href="https://app.superiorgroup.com.au/users/124"
                          ><span
                            class="h-8 w-8 inline-flex items-center justify-center rounded-full hover:ring-gray-200"
                            title="Steven Gow (Deleted user)"
                            ><img
                              src="/storage/avatar-124.jpg"
                              class="rounded-full" /></span></a
                        ><a
                          class="inline-block h-8 w-8 rounded-full ring-2 ring-white"
                          href="https://app.superiorgroup.com.au/users/261"
                          ><span
                            class="h-8 w-8 inline-flex items-center justify-center rounded-full hover:ring-gray-200"
                            title="Lilli Oniper (Deleted user)"
                            ><img
                              src="/storage/avatar-261.jpg"
                              class="rounded-full" /></span></a></span
                      ><span
                        ><a
                          class="text-xs px-2.5 py-1.5 bg-gray-100 text-gray-900 hover:bg-gray-200 focus:ring-gray-200 items-center justify-center rounded-md border border-transparent font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto ml-2 hidden xl:block"
                          href="https://app.superiorgroup.com.au/project-members/943ca432-9a3d-42dc-93e1-b30dc2d0ab5f"
                        >
                          Show all - 4</a
                        ><a
                          class="text-xs px-2.5 py-1.5 bg-gray-100 text-gray-900 hover:bg-gray-200 focus:ring-gray-200 inline-flex items-center justify-center rounded-md border border-transparent font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto xl:hidden"
                          href="https://app.superiorgroup.com.au/project-members/943ca432-9a3d-42dc-93e1-b30dc2d0ab5f"
                        >
                          View members - 4</a
                        ></span
                      >
                    </div>
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
import { Link } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TabLink from "@/Components/TabLink.vue";
import PrimaryBadge from "@/Components/PrimaryBadge.vue";
import GrayBadge from "@/Components/GrayBadge.vue";
const props = defineProps({
  project: Object,
});

const tabs = [
  { name: "Summary", routeName: "project.show" },
  { name: "Members", routeName: "project.edit" },
  { name: "Buildings and tasks", routeName: "project.edit" },
  { name: "Contracts", routeName: "project.edit" },
  { name: "Pay rates", routeName: "project.edit" },
  { name: "Pay rate addons", routeName: "project.edit" },
  { name: "Absentee and injury alerts", routeName: "project.edit" },
];
</script>
  
