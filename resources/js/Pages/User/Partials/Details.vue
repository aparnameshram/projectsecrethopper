<script setup>
import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue';
const props = usePage().props
</script>
<template>
    <!-- main content -->
    <div  class="bg-white p-4 shadow sm:rounded-lg sm:p-8"  >
        <div class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <table class="w-full table-fixed">
                <thead>
                    <tr class="p-5 border-b">
                        <td class="col-span-2">
                            <h4>Shopper Information</h4>
                            Personal details
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="pt-5">
                            <h6>Email Address</h6>
                            {{ props.user.email }}
                        </td>
                        <td class="pt-5">
                            <h6>Timezone</h6>
                            {{ props.user.user_profile.timezone }}
                        </td>
                    </tr>
                    <tr>
                        <td class="pt-5">
                            <h6>Phone</h6>
                            {{ props.user.phone }}
                        </td>
                        <td class="pt-5">
                            <h6>Date of Birth</h6>
                            {{ props.user.user_profile.date_of_birth }}
                        </td>
                    </tr>
                    <tr>
                        <td class="pt-5">
                            <h6>Gender</h6>
                            {{ props.user.user_profile.gender }}
                        </td>
                        <td class="pt-5">
                            <h6>Type of Beer drinker</h6>
                            {{ props.user.user_profile.drinker_type }}
                        </td>
                    </tr>
                    <tr>
                        <td class="pt-5">
                            <h6>Email Notification</h6>
                            -
                        </td>
                        <td class="pt-5">
                            <h6>SMS Notification</h6>
                            -
                        </td>
                    </tr>
                    <tr>
                        <td class="pt-5 col-span-2" colspan="2">
                            <h6>About</h6>
                            {{ props.user.user_profile.qualification_for_hopper }}
                        </td>
                    </tr>
                    <tr>
                        <td class="col-span-2 pt-5" colspan="2">
                            <h6>Recent Experience</h6>
                            {{ props.user.user_profile.recent_experience }}
                        </td>
                    </tr>
                    <tr>
                        <td class="col-span-2 pt-5" colspan="2">
                            <h6>How did you hear about Secret Hopper</h6>
                            {{ props.user.user_profile.how_did_hear }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
