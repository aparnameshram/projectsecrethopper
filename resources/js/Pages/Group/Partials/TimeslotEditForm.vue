<script setup>
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { CTimePicker } from '@coreui/vue-pro';
import { CDatePicker } from '@coreui/vue-pro';
import { ref, watchEffect } from 'vue'
import { defineEmits } from 'vue'
import { useGroupStore } from '../Store/Group';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

//initialize group store
const groupStore = useGroupStore()
const props = defineProps(['showEditForm','timeslotEditId','timeslot','storeIndex'])
const emit = defineEmits(['close'])


const timeslot = props.timeslot
const editTimeslot = ref(props.showEditForm)

const form = useForm({
    date:timeslot.date,
    start_time: timeslot.start_time,
    end_time: timeslot.end_time
})

function submitEditForm(){
    form.patch(route('timeslot.update',timeslot.id) , {
        preserveScroll: true,
        onFinish: () => {
            router.reload({
                only: ['timeslots'],
                onFinish: () => {
                    groupStore.insertAllTimeslots(usePage().props.timeslots)
                    console.log('done')
                }
            })
            emit('close')
        }
    })
}
</script>
<template>
    <!-- timeslot edit form starts here -->
    <form>
        <div class="flex-col gap-4 min-h-full items-start justify-left p-4 text-left sm:items-center sm:p-0">
            <div class="">
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
            <div class="">
                <div class="mt-4">

                    <CTimePicker label="Start Time" v-model:time="form.start_time" />
                    <InputError class="mt-2" :message="form.errors.start_time" />
                </div>
            </div>
            <div class="">
                <div class="mt-4">


                    <CTimePicker label="End Time" v-model:time="form.end_time" />
                    <InputError class="mt-2" :message="form.errors.end_time" />
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="emit('close')">
                    Cancel
                </SecondaryButton>

                <PrimaryButton
                class="mt-1 ms-4"
                :class="{ 'opacity-25': form.processing }"
                @click.prevent="submitEditForm"

            >
                Edit
            </PrimaryButton>
            </div>
        </div>
        </form>
    <!-- timeslot edit form ends here -->

</template>
