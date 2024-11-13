<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { CTimePicker } from '@coreui/vue-pro';
import { CDatePicker } from '@coreui/vue-pro';
import { useGroupStore } from '../Store/Group';
import dayjs from 'dayjs';
import utc from 'dayjs/plugin/utc'
import customParseFormat from 'dayjs/plugin/customParseFormat'
import TimeslotList from './TimeslotList.vue';

dayjs.extend(utc);
dayjs.extend(customParseFormat);
//initialize group store
const group = useGroupStore()

//timeslot form
const form = useForm({
    date: '',
    start_time: '5:00:00',
    end_time: '08:00:00'

});

//function to validate timeslot data and to insert timeslot data to group store
function insertTimeslot() {
    form.post(route('timeslot.validate') , {
        preserveScroll: true,
        onSuccess: () => {
            //format date start time and end time
            let tDate  = dayjs(new Date(form.date)).format('YYYY-MM-DD')
            group.insertTimeslot({id:null,date:tDate, start_time: form.start_time, end_time:form.end_time})
        }
    })
}

</script>
<template>
<div  class="bg-white p-4 shadow sm:rounded-lg sm:p-8 " >
    <form>
    <div class="grid grid-cols-6 gap-4 min-h-full items-start justify-left p-4 text-left sm:items-center sm:p-0">
        <div class="col-span-2">
            <div class="mt-4">

                <CDatePicker
                    label="Date"
                    id="date"
                    type="date"
                    class="mt-1 block w-full"
                    v-model:date="form.date"
                    required
                />
                <InputError class="mt-2" :message="form.errors.date" />
            </div>
        </div>
        <div class="col-span-1">
            <div class="mt-4">

                <CTimePicker label="Start Time"  v-model:time="form.start_time" />
                <InputError class="mt-2" :message="form.errors.start_time" />
            </div>
        </div>
        <div class="col-span-1">
            <div class="mt-4">


                <CTimePicker label="End Time"  v-model:time="form.end_time" />
                <InputError class="mt-2" :message="form.errors.end_time" />
            </div>
        </div>
        <div class="col-span-1">
            <div class="mt-4">
           <InputLabel class="form-label" value="Add Window"/>
            <PrimaryButton
            class="mt-1 ms-4"
            :class="{ 'opacity-25': form.processing }"

            @click.prevent="insertTimeslot"
        >
            Add
        </PrimaryButton>
        </div>
        </div>
        <div class="col-span-1"></div>
    </div>
    </form>
    <div v-if="group.timeslots.length" class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <TimeslotList :timeslots="group.timeslots" />
    </div>

</div>

</template>
