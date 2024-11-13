<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import PrimaryLink from '@/Components/PrimaryLink.vue';
import EditLink from '@/Components/EditLink.vue';

defineProps(['groups','venue'])

</script>
<template>
    <Head title="venue.name" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                {{ venue.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8 flex flex-col">
                <div class="flex justify-between">
                    <div>
                        <h2 class="font-semibold text-lg mb-5">Groups</h2>
                    </div>
                    <div>
                        <PrimaryLink :href="route('group.create',venue.id)">
                            Add Group
                        </PrimaryLink>
                    </div>
                </div>

                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8"  >
                    <table class="table-fixed border-spacing-2 mt-5 w-full place-content-start mb-5">
                        <thead>
                          <tr class="font-bold text-md shadow-sm p-6 bg-slate-50/80 rounded-lg">
                            <th>Name</th>
                            <th>Updated</th>
                            <th>Radius (In mi)</th>
                            <th>Claimed Limit</th>
                            <th>Shoppers</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody >
                            <tr v-for="group in groups" class="mt-5 gap-y-3 p-5">
                                <td class="pl-5 py-3">
                                    {{ group.name }}
                                </td>
                                <td class="pl-5 py-3">
                                    {{ group.updated_at }}
                                </td>
                                <td class="pl-5 py-3">
                                    {{ group.radius }}
                                </td>
                                <td class="pl-5 py-3">
                                    {{ group.claim_limit }}
                                </td>
                                <td class="pl-5 py-3">
                                    {{ group.users_count }}
                                </td>
                                <td class="pl-5 py-3">
                                    <EditLink :href="route('group.edit',group.id)"/>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
