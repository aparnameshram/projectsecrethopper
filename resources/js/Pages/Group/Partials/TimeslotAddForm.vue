<script setup>
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { CTimePicker } from '@coreui/vue-pro';
import { CDatePicker } from '@coreui/vue-pro';
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3';
import { defineEmits } from 'vue'
import { useGroupStore } from '../Store/Group';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import TimeslotEditForm from './TimeslotEditForm.vue';
import dayjs from 'dayjs';
import utc from 'dayjs/plugin/utc'
import customParseFormat from 'dayjs/plugin/customParseFormat'
import { router } from '@inertiajs/vue3'

dayjs.extend(utc);
dayjs.extend(customParseFormat);
//initialize group store
const group = useGroupStore()
const confirmingTimeslotDeletion = ref(false)
const timeslotDeleteIndex = ref('')
const timeslotDeleteId = ref('')
const showEditForm = ref(false)
const timeslotEditId = ref('')
//timeslot form
const form = useForm({
    date: '',
    start_time: '5:00:00 PM',
    end_time: '08:00:00 PM'

});
let timeslot = ref('') //variable to hold timeslot deatails on which edit/delete operation to be performed
//function to validate timeslot data and to insert timeslot data to group store
function insertTimeslot() {
    form.post(route('timeslot.validate') , {
        preserveScroll: true,
        onSuccess: () => {
            //format date start time and end time
            let tDate  = dayjs(new Date(form.date)).format('YYYY-MM-DD')
            let startStr = tDate + ' '+form.start_time
            let endStr = tDate + ' '+form.end_time

            let sTime = dayjs(startStr)
            let eTime = dayjs(endStr)

            //group.insertTimeslot({id:null,date:form.date.toISOString().split('T')[0], start_time: form.start_time, end_time:form.end_time})
            group.insertTimeslot({id:null,date:tDate, start_time: sTime, end_time:eTime})

        }
    })
}

//remove timeslot from store
function removeTimeslot(index) {
    group.removeTimeslot(index)
}

/**
 * open confirm deletion model based on the check if the timeslot is already saved in db ,
 * if timeslot created on the fly but yet to be saved just delete it from dom
 *
 **/
const confirmTimeslotDeletion = (index, timeslottodatele = null) => {
    if (timeslottodatele != null) {
        timeslot =  timeslottodatele
    } else {
        //timeslot = group.getTimeslot(index)
        timeslot = {}
    }
    timeslotDeleteIndex.value = index;
    if (timeslot.id != null) {
        confirmingTimeslotDeletion.value = true;
        //timeslotDeleteId = id
    } else {
        removeTimeslot(timeslotDeleteIndex)
    }
    //wait nextTick()
};

const deleteTimeslot = () => {
    form.delete(route('timeslot.delete',timeslot.id), {
        preserveScroll: true,
        onSuccess: () => {
            removeTimeslot(timeslotDeleteIndex)
            router.reload({ only: ['timeslots'] })
            closeModal()
            timeslot = {}
            timeslotDeleteIndex
        },
    });
};

const closeModal = () => {
    confirmingTimeslotDeletion.value = false;

};

function editTimeslot(index) {

    showEditForm.value = true

    timeslot = group.getTimeslot(index)
    timeslotEditId.value = timeslot.id
}

const closeEditModal = () => {
    showEditForm.value = false
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
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Claimed by
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                <TransitionGroup>
                <tr v-for="(item, index) in group.timeslots" :key="index" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ dayjs(item['date']).format('YYYY-MM-DD') }}
                    </th>
                    <td class="px-6 py-4">
                        {{ dayjs(item['start_time']).format('HH:mm:s A') }}
                    </td>
                    <td class="px-6 py-4">
                        {{ dayjs(item['end_time']).format('HH:mm:s A') }}
                    </td>
                    <td class="px-6 py-4">
                        -
                    </td>
                    <td class="px-6 py-4">
                        -
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-start">
                        <div class="px-2">
                        <a
                            @click="confirmTimeslotDeletion(index, item)"
                            as="button"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                            <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        </div>
                        <div class="px-2">
                        <a
                            v-show="item['id'] != null"
                            @click.prevent="editTimeslot(index)"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                            <path d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z" />
                            <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z" />
                            </svg>

                        </a>
                        </div>
                    </div>
                    </td>
                </tr>
            </TransitionGroup>
            </tbody>
            </table>
    </div>

</div>
<Modal :show="confirmingTimeslotDeletion" @close="closeModal" >
    <div class="p-6">
        <h2
            class="text-lg font-medium text-gray-900"
        >
            Are you sure you want to delete timeslot from this group?
            {{  timeslot }}
        </h2>


        <div class="mt-6 flex justify-end">
            <SecondaryButton @click="closeModal">
                Cancel
            </SecondaryButton>

            <DangerButton
                class="ms-3"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="deleteTimeslot()"
            >
                Delete
            </DangerButton>
        </div>
    </div>
</Modal>

<TimeslotEditForm
    :show-edit-form="showEditForm"
    :timeslot-edit-id="timeslotEditId"
    @close-edit-modal="closeEditModal"
    :timeslot="timeslot"

    :key="timeslot.id"
/>
<h4>Timeslot :  {{ timeslot }} </h4>
</template>
