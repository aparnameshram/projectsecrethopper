<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Link } from '@inertiajs/vue3';
import PrimaryLink from '@/Components/PrimaryLink.vue';
//mport PrimaryButton from 'vendor/laravel/breeze/stubs/inertia-react/resources/js/Components/PrimaryButton';
import PrimaryButton from '@/Components/PrimaryButton.vue';
//ref('groups')
//const groups = defineProps('groups')
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
                        <PrimaryLink
                        :href="route('group.create',venue.id)"
                        >
                            Add Group
                        </PrimaryLink>
                    </div>
                </div>

                <div  class="bg-white p-4 shadow sm:rounded-lg sm:p-8"  >
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
                                    <Link
                        :href="route('group.edit',group.id)"


                        >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z" />
                        <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z" />
                        </svg>

                        </Link>
                                </td>
                            </tr>

                        </tbody>
                        </table>
                </div>

                </div>
        </div>
    </AuthenticatedLayout>
</template>
