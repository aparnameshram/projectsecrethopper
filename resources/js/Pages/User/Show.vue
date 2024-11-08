<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, useForm , Link} from '@inertiajs/vue3';
    import { router } from '@inertiajs/vue3'
    import { ref } from 'vue';
    import Details from './Partials/Details.vue';
    import UserHistory from './Partials/UserHistory.vue';
    import { computed } from 'vue';
    import InfoHeader from './Partials/InfoHeader.vue';

    const routes = {
        '/': Details,
        '/history': UserHistory
    }

    const currentPath = ref(window.location.hash)

    window.addEventListener('hashchange', () => {
        currentPath.value = window.location.hash
    })

    const currentView = computed(() => {
        return routes[currentPath.value.slice(1) || '/'] || NotFound
    })

</script>
<template>

    <Head title="Shoppers" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Shoppers
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8 flex flex-col">
                <div class="flex justify-between">
                    <div>
                        <h2 class="font-semibold text-lg mb-5">Shoppers</h2>
                    </div>
                </div>
                <div>
                    <div class="sm:hidden">
                        <label for="tabs" class="sr-only">Select your country</label>
                        <select id="tabs" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option>Shopper Details</option>
                            <option>Visit History</option>

                        </select>
                    </div>
                    <ul class="hidden text-sm font-medium text-center text-gray-500 rounded-lg shadow sm:flex dark:divide-gray-700 dark:text-gray-400">
                        <li class="w-full focus-within:z-10">
                            <a
                                href="#/"
                                class="inline-block w-full p-4 text-gray-900 bg-gray-100 border-r border-gray-200 dark:border-gray-700 rounded-s-lg focus:ring-4 focus:ring-blue-300 active focus:outline-none dark:bg-gray-700 dark:text-white no-underline"
                                aria-current="page"
                            >
                                Shoppers Details
                            </a>
                        </li>
                        <li class="w-full focus-within:z-10">
                            <a
                            href="#/history"
                            class="inline-block w-full p-4 bg-white border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700 no-underline">Visit History</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <InfoHeader />
                    <component :is="currentView" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>
