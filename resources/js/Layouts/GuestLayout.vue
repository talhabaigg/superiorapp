<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col justify-start items-center pt-8 sm:pt-4 bg-white">
        <div>
            <Link href="/">
                <ApplicationLogo class="w-16 h-16 fill-current text-gray-500" />
            </Link>
        </div>

        <div class="w-full sm:max-w-md mt-3 px-6 py-4 bg-white overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>

<style scoped>
/* Add any additional styles here */
</style>
