<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import utc from 'dayjs/plugin/utc'
import customParseFormat from 'dayjs/plugin/customParseFormat'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import useForm from '@inertiajs/vue3';
dayjs.extend(utc);
dayjs.extend(customParseFormat);
const props = defineProps(['group','timeslots'])
//timeslot form
const form = useForm({
    canClaim: true
});
</script>
<template>
    <Head title="group.name" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                {{ group.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8 flex flex-col">
                <form>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Date
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Start Time
                            </th>
                            <th scope="col" class="px-6 py-3">
                                End Time
                            </th>

                            <th scope="col" class="px-6 py-3">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <TransitionGroup>
                        <tr v-for="(item, index) in props.timeslots" :key="item.id" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ dayjs(item.date).format('YYYY-MM-DD') }}
                            </th>
                            <td class="px-6 py-4">
                                {{ dayjs(item.start_time).format('HH:mm:s A') }}
                            </td>
                            <td class="px-6 py-4">
                                {{ dayjs(item.end_time).format('HH:mm:s A') }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center justify-start">

                                <div class="px-2">
                                    <PrimaryButton

                                    class="ms-4"

                                >
                                    Claim
                                </PrimaryButton>
                                </div>
                            </div>
                            </td>
                        </tr>
                    </TransitionGroup>
                    </tbody>
                </table>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>

</template>
