<script setup>
import DefaultPagination from '@/Components/DefaultPagination.vue';
import { Link } from '@inertiajs/vue3';
import ViewLink from '@/Components/ViewLink.vue';
import EditLink from '@/Components/EditLink.vue';
import DeleteLink from '@/Components/DeleteLink.vue';
import { useModal } from '@/Components/Modal.js';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import VenueForm from './VenueForm.vue';
import { useForm } from '@inertiajs/vue3';

defineProps(['venues'])

//edit user
const model =  useModal()

const openEdit = (venue) => {
    model.venue=venue
    model.showModal();
}

//delete user
const deleteModel = useModal()
const openDelete = (venue) => {
    deleteModel.venue = venue
    deleteModel.showModal()
}

const form = useForm({})

const deleteVenue = (venue) => {
    form.delete(route('venue.delete', venue.id),{
        onSuccess:() => {
            deleteModel.hideModal()
            form.reset()
        }
    })
}

</script>
<template>
<table class="table-fixed border-spacing-2 mt-5 w-full place-content-start mb-5">
    <thead>
      <tr class="font-bold text-md shadow-sm p-6 bg-slate-50/80 rounded-lg">
        <th>Name</th>
        <th class="grow">Address</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody >
    <tr v-for="venue in venues.data" class="mt-5 gap-y-3 p-5">
        <td class="pl-5 py-3">

            <Link :href="route('venue.groups',venue.id)" target="_self">{{venue.name}}</Link>

        </td>
        <td class="pl-5 py-3"><Link :href="route('venue.groups',venue.id)">{{venue.address}}</Link></td>
        <td class="pl-5 py-3"><Link :href="route('venue.groups',venue.id)">{{venue.status}}</Link></td>
        <td class="pl-5 py-3">
            <!--<ActionLinks :venue="venue" ref="actionLink" @open-edit-venue-form="openEditVenueModal"></ActionLinks>-->
            <div class="flex items-center justify-start">
            <div class="px-2">
                <ViewLink :href="route('venue.groups',venue.id)" />
            </div>
            <div class="px-2">
                <EditLink  v-show="$page.props.auth.user.isAdmin" @click="openEdit(venue)" />
            </div>
            <div class="px-2">
                <DeleteLink  v-show="$page.props.auth.user.isAdmin" @click="openDelete(venue)" />
            </div>
            </div>
        </td>
    </tr>
    </tbody>
    </table>
    <DefaultPagination :pagination="venues" />
     <!-- Edit venue-->
     <Modal :show="model.show.value" @close="model.hideModal" >
        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8 flex flex-col">
                <!-- include venue edit  form component -->
                <VenueForm :venue="model.venue"  @close="model.hideModal"></VenueForm>
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
                Are you sure you want to delete venue {{ deleteModel.venue.name  }}?

            </h2>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="deleteModel.hideModal">
                    Cancel
                </SecondaryButton>
                <DangerButton
                    class="ms-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="deleteVenue(deleteModel.venue)"
                >
                    Delete
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
