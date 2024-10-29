<script setup>
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { CTimePicker } from '@coreui/vue-pro';
import { CDatePicker } from '@coreui/vue-pro';
import { ref, watchEffect } from 'vue'
import { Link } from '@inertiajs/vue3';
import { defineEmits } from 'vue'
import { useGroupStore } from '../Store/Group';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { watch } from 'vue';

//initialize group store
const groupStore = useGroupStore()
const props = defineProps(['showEditForm','timeslotEditId','timeslot'])
const emit = defineEmits(['closeEditModal'])

const timeslotEditIndex = ref('')
const timeslot = props.timeslot
const editTimeslot = ref(props.showEditForm)

const form = useForm({
    date:timeslot.date,
    start_time: timeslot.start_time,
    end_time: timeslot.end_time
})

function submitEditForm(){
    form
    .transform((data) => ({
        ...data,
        ...groupStore.getTimeslotFormatedDateTime(form)
    }))
    .patch(route('timeslot.update',timeslot.id) , {

        preserveScroll: true,
        onSuccess: () => {
            //router.reload({ only: ['timeslots'] })
            emit('closeEditModal')
        }
    })
}
</script>
<template>

    <Modal :show="props.showEditForm" @close="emit('closeEditModal')" @open="onEnter">
        <div class="p-6">
            <h2
                class="text-lg font-medium text-gray-900"
            >
                Are you sure you want to edit timeslot from this group? <br />
                timeslot : {{ timeslot }}
            </h2>

            <div class="mt-6 flex justify-center">
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
                            <SecondaryButton @click="emit('closeEditModal')">
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
            </div>
        </div>
    </Modal>



</template>
