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
import { watch } from 'vue';

//initialize group store
const group = useGroupStore()
const props = defineProps(['showEditForm','timeslotEditId'])
const emit = defineEmits(['closeEditModal'])

const timeslotEditIndex = ref('')

const editTimeslot = ref(props.showEditForm)

const form = useForm({
    date: '',
    start_time: '5:00:00 PM',
    end_time: '08:00:00 PM'

});

</script>
<template>

    <Modal :show="props.showEditForm" @close="emit('closeEditModal')" >
        <div class="p-6">
            <h2
                class="text-lg font-medium text-gray-900"
            >
                Are you sure you want to edit timeslot from this group?
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

                                <CTimePicker label="Start Time" locale="en-US" v-model:time="form.start_time" />
                                <InputError class="mt-2" :message="form.errors.start_time" />
                            </div>
                        </div>
                        <div class="">
                            <div class="mt-4">


                                <CTimePicker label="End Time" locale="en-US" v-model:time="form.end_time" />
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
