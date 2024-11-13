<script setup>
import dayjs from 'dayjs';
import utc from 'dayjs/plugin/utc'
import customParseFormat from 'dayjs/plugin/customParseFormat'
import DeleteLink from '@/Components/DeleteLink.vue'
import EditLink from '@/Components/EditLink.vue';
import ViewLink from '@/Components/ViewLink.vue';
import { useModal } from '@/Components/Modal.js';
import Modal from '@/Components/Modal.vue';
import TimeslotEditForm from './TimeslotEditForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { router, useForm } from '@inertiajs/vue3';
import { useGroupStore } from '../Store/Group';

dayjs.extend(utc);
dayjs.extend(customParseFormat);
const props = defineProps(['timeslots'])
const group = useGroupStore()
//edit user
const model =  useModal()

const openEdit = (timeslot, index) => {
    model.timeslot=timeslot
    model.index = index
    model.showModal();
}

//delete user
const deleteModel = useModal()
const openDelete = (timeslot, index) => {
    deleteModel.timeslot = timeslot
    deleteModel.index = index
    deleteModel.showModal()
}

const form = useForm({})

const deleteTimeslot = (timeslot) => {
    if (timeslot.id !== null) {
        form.delete(route('timeslot.delete', timeslot.id),{
            onSuccess:() => {
                form.reset()
                router.reload({ only: ['timeslots'] })
            }
        })
    } else {
        //remove timeslot from group store
        group.removeTimeslot(deleteModel.index)
    }
    deleteModel.hideModal()
}
function getClaimedUsers(user)
{
    return [user.first_name,user.last_name].join(" ");

}
</script>
<template>
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
            <tr v-for="(item, index) in props.timeslots" :key="index" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ dayjs(item['date']).format('YYYY-MM-DD') }}
                </th>
                <td class="px-6 py-4">
                    {{ item['start_time'] }}
                </td>
                <td class="px-6 py-4">
                    {{ item['end_time'] }}
                </td>
                <td class="px-6 py-4">
                    {{ (item['attachecd_users'].length > 0) ? 'Claimed' : '-' }}
                </td>
                <td class="px-6 py-4">
                    <span v-if="(item['attachecd_users'].length > 0 )">
                       {{ item['attachecd_users'].map(getClaimedUsers) }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-start">
                    <div class="px-2">
                        <DeleteLink
                            @click.prevent="openDelete(item,index)"
                            as="button"
                        />
                    </div>
                    <div class="px-2">
                        <EditLink
                            v-show="item['id'] != null"
                            @click.prevent="openEdit(item, index)"
                        />
                    </div>
                </div>
                </td>
            </tr>
        </TransitionGroup>
        </tbody>
    </table>

    <!-- Edit user-->
    <Modal :show="model.show.value" @close="model.hideModal" >
        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8 flex flex-col">
                <h2>Updated</h2>
                <!-- include user edit  form component -->
                <TimeslotEditForm :timeslot="model.timeslot" :store-index="model.index" @close="model.hideModal"/>
                <!-- end form-->
            </div>
        </div>
    </Modal>

    <!-- Delete user -->
    <Modal :show="deleteModel.show.value" @close="deleteModel.hideModal" >
        <div class="p-6">
            <h2
                class="text-lg font-medium text-gray-900"
            >
                Are you sure you want to delete timeslot from this group ? updated

            </h2>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="deleteModel.hideModal">
                    Cancel
                </SecondaryButton>
                <DangerButton
                    class="ms-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="deleteTimeslot(deleteModel.timeslot)"
                >
                    Delete
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
