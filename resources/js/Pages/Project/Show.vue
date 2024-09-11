<template>
  <ProjectLayout :project="project">
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
                    ${{ project.estimated_hours * project.average_hourly_rate }}
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
              <div class="flex items-center space-x-2">
                <div class="flex -space-x-2">
                  <div v-for="user in project.users.slice(0, 5)" :key="user.id">
                    <img
                      :src="getAvatarUrl(user.avatar)"
                      alt="Avatar"
                      class="h-8 w-8 rounded-full border-2 border-white"
                    />
                  </div>
                </div>
                <div v-if="project.users.length > 4" class="">
                  <UnderlineLink :href="`/project-members/${project.id}`"
                    ><GrayBadge
                      >SHOW ALL - {{ project.users.length }}</GrayBadge
                    ></UnderlineLink
                  >
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </ProjectLayout>
</template>
  
<script setup>
import PrimaryBadge from "@/Components/PrimaryBadge.vue";
import GrayBadge from "@/Components/GrayBadge.vue";
import ProjectLayout from "@/Pages/Project/ProjectLayout.vue";
import UnderlineLink from "@/Components/UnderlineLink.vue";
const props = defineProps({
  project: Object,
});
const getAvatarUrl = (avatarPath) => {
  if (!avatarPath) return "";
  return `${window.location.origin}/${avatarPath}`;
};

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
  
