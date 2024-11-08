<script setup>
import { usePage } from '@inertiajs/vue3'
import dayjs from 'dayjs';
import customParseFormat from 'dayjs/plugin/customParseFormat'

dayjs.extend(customParseFormat);
const props = usePage().props
</script>
<template>
    <div  class="bg-white p-4 shadow sm:rounded-lg sm:p-8"  >
        <div class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <table class="w-full table-fixed">
                <thead>
                    <tr class="p-0 border-b">
                        <td class="pt-3">
                            <h6>Secret Hops</h6>
                        </td>
                        <td class="pt-3">
                            <h6>Time Window </h6>
                        </td>
                    </tr>
                </thead>
                <tbody v-if="props.claimedTimeslots.length">
                    <tr  v-for="timeslot in props.claimedTimeslots ">
                        <td class="pt-5">
                            <h6>{{ timeslot.group.venue.name }} - {{ timeslot.group.name }}</h6>
                        </td>
                        <td class="pt-5">

                            <h6>{{ dayjs(timeslot.date).format('YYYY-MM-DD')}}   {{ dayjs(timeslot.start_time).format('HH:mm:s A')}} - {{ dayjs(timeslot.end_time).format('HH:mm:s A')}}</h6>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
