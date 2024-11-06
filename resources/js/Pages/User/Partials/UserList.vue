<script setup>
    import { Link, useForm } from '@inertiajs/vue3';
    import DefaultPagination from '@/Components/DefaultPagination.vue';
    import { useModal } from '@/Components/Modal.js';
    import Modal from '@/Components/Modal.vue';
    import EditForm from './EditForm.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    import DangerButton from '@/Components/DangerButton.vue';
    import DeleteLink from '@/Components/DeleteLink.vue'
import EditLink from '@/Components/EditLink.vue';
import ViewLink from '@/Components/ViewLink.vue';

    const props = defineProps(['users'])
    const model =  useModal()

    const openEdit = (user) => {
        model.user=user
        model.showModal();
    }

    const deleteModel = useModal()
    const openDelete = (user) => {
        deleteModel.user = user
        deleteModel.showModal()
    }

    const form = useForm({})

    const deleteUser = (user) => {
        alert(user)
    form.delete(route('user.delete', user.id),{
        onSuccess:() => {
            emit('close')
            form.reset()
        }
    })
}
</script>
<template>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Email
                </th>
                <th scope="col" class="px-6 py-3">
                    Sign Up
                </th>
                <th scope="col" class="px-6 py-3">
                    Sample length
                </th>
                <th scope="col" class="px-6 py-3">
                How did you hear about Secret Hopper
                </th>
                <th scope="col" class="px-6 py-3">
                    Phone
                </th>
                <th scope="col" class="px-6 py-3">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="user in props.users.data" :key="user.id" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ user.first_name}}   {{ user.last_name }}
                </th>
                <td class="px-6 py-4">{{ user.email }}</td>
                <td class="px-6 py-4">{{ user.user_profile.date_signed }}</td>
                <td class="px-6 py-4">{{ "-" }}</td>
                <td class="px-6 py-4">{{ user.user_profile.how_did_hear }}</td>
                <td class="px-6 py-4">{{ user.phone }}</td>
                <td class="px-6 py-4">
                <!-- action links-->
                    <div class="flex items-center justify-start">
                        <div class="px-2">
                            <ViewLink :href="route('user.show',user.id)" />
                        </div>
                        <div class="px-2">
                            <EditLink  @click="openEdit(user)" />
                        </div>
                        <div class="px-2">
                            <DeleteLink  @click="openDelete(user)" />
                        </div>
                    </div>
                <!-- action links end-->
                </td>
            </tr>
        </tbody>
    </table>
    <DefaultPagination :pagination="props.users" />
    <!-- Edit user-->
    <Modal :show="model.show.value" @close="model.hideModal" >
        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8 flex flex-col">
                <!-- include user edit  form component -->
                <EditForm :user="model.user"  @close="model.hideModal"></EditForm>
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
                    @click="deleteUser(deleteModel.user)"
                >
                    Delete
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
