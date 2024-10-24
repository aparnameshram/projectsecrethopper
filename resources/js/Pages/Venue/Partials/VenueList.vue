<script setup>

import { Head, router } from '@inertiajs/vue3';
import ActionLinks from './ActionLinks.vue';
import DefaultPagination from '@/Components/DefaultPagination.vue';
import { useTemplateRef, onMounted, watch } from 'vue'
import EditVenueForm from './EditVenueForm.vue';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
defineProps(['venues'])
const editVenueForm = useTemplateRef('editVenueForm')
const editForm = ref('')
const openModel = () => {
    alert('here in open model from watch callback')
    alert(editForm)
    editVenueForm.openModel()
    //console.log(editVenueForm.statval.value)
    //console.log(this.$refs.editVenueForm)

}
const openEditVenueModal = (venue) => {
    alert('here in open edit venue modal')
    console.log(venue)
    //openModel()
    editForm.value = venue
    //console.log(editVenueForm.stat.value)

}

const showGroups = (venue) => {
   /*router.visit(
    route('group.show',venue.id),{
        method: 'get',
        replace: true
    }
    )*/
   alert('here')
}
watch(editForm, openModel)
</script>
<template>
<EditVenueForm ref="editVenueForm"></EditVenueForm>
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
            <ActionLinks :venue="venue" ref="actionLink" @open-edit-venue-form="openEditVenueModal"></ActionLinks>
        </td>
    </tr>
    </tbody>
    </table>
    <DefaultPagination :pagination="venues" />

</template>
