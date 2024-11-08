<script setup>
import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue';

import DangerButton from '@/Components/DangerButton.vue';
import PrimaryLink from '@/Components/PrimaryLink.vue';
import Modal from '@/Components/Modal.vue';
import { useModal } from '@/Components/Modal.js';
import {useForm} from '@inertiajs/vue3';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { router } from '@inertiajs/vue3'

const props = usePage().props

const deleteModel = useModal()
    const openDelete = (user) => {
        deleteModel.user = user
        deleteModel.showModal()
    }

    const form = useForm({})

    const deleteUser = (user) => {
        deleteModel.hideModal()
        router.delete(route('user.delete', user.id),
            {
                data:{redirect:'users'},
            })
    }
</script>
<template>
    <div class="flex justify-between">
        <div class="">
           <h4>{{ props.user.first_name + ' ' +props.user.last_name}}</h4>
           <p>{{ props.user.user_profile.address }}</p>
        </div>
        <div class="">
            <div class="mt-6 flex justify-end">

                <DangerButton
                    class="ms-3"
                    :class="{ 'opacity-25':false }"
                    :disabled="false"
                    @click.prevent="openDelete(props.user)"
                >
                    Delete
                </DangerButton>
                <PrimaryLink :href="route('users')">
                    Back
                </PrimaryLink>
            </div>
        </div>
</div>

 <!-- Delete user -->
 <Modal :show="deleteModel.show.value" @close="deleteModel.hideModal" ref="delelteConfirmation">
    <div class="p-6">
        <h2
            class="text-lg font-medium text-gray-900"
        >
            Are you sure you want to delete user {{ deleteModel.user.first_name + ' ' + deleteModel.user.last_name }}?

        </h2>
        <div class="mt-6 flex justify-end">
            <SecondaryButton @click="deleteModel.hideModal">
                Cancel
            </SecondaryButton>
            <DangerButton
                class="ms-3"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click.prevent="deleteUser(deleteModel.user)"
            >
                Delete
            </DangerButton>
        </div>
    </div>
</Modal>
</template>
