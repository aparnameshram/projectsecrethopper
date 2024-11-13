<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import utc from 'dayjs/plugin/utc'
import customParseFormat from 'dayjs/plugin/customParseFormat'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
dayjs.extend(utc);
dayjs.extend(customParseFormat);
const props = defineProps(['data'])
//timeslot form
/*const form = useForm({
    canClaim: props.canClaim
});*/

</script>
<template>
    <Head title="Secret Hops" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Secret Hops
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8 flex flex-col">
                <form>
                <table v-for="venue in props.data" class="border-1 w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Secret Hops
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-6 py-4 bg-white">
                                <h6>{{ venue.name }}</h6>
                                <p> {{ venue.address }}</p>
                            </td>
                            <td class="px-6 py-4 bg-white">
                                <a><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/>
                                </svg></a>
                            </td>
                        </tr>
                        <tr v-for="group in venue.groups">
                            <Transition>
                            <td class="px-6 py-4" >
                                <table class="mx-2 w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-70 dark:bg-gray-700 dark:text-gray-400">
                                        <tr class="bg-gray-50 gap-y-1">
                                            <th class="px-6 py-3 col-span-4">{{ group.name}}</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>

                                    </thead>
                                    <tr v-for="timeslot in group.timeslots" class="bg-white border-y-1">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ timeslot.date }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ timeslot.start_time }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ timeslot.end_time }}
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-start">

                                            <div class="px-2">
                                                <PrimaryButton

                                                :class="{ 'opacity-25': !group.canClaimTimeslot }"
                                                :disabled="!group.canClaimTimeslot"
                                            >
                                                Claim
                                            </PrimaryButton>
                                            </div>
                                        </div>
                                        </td>

                                    </tr>
                                </table>
                            </td>
                        </Transition>
                        </tr>

                    </tbody>
                </table>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>

</template>
