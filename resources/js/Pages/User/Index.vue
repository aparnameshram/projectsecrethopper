<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm , Link} from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'
import { ref } from 'vue';
import { watch } from 'vue';
import { useModal } from '@/Components/Modal';
import EditForm from './Partials/EditForm.vue';
import { userModal } from './Composables/User.js';
import Modal from '@/Components/Modal.vue';
import SearchFilter from './Partials/SearchFilter.vue';
import UserList from './Partials/UserList.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps(['users','limit','selectOptions'])

//ref(form)
const name = ref('')
const limit = ref(props.limit)
const getUsers = async(newX) => {
    try {
        router.visit(route('users'), {
            method:'get',
            data:{
                name : name.value,
                limit : limit.value
            },
            only: ['users'],
            preserveState: true,

        })
    } catch (error) {
        //console.log('Error! Could not reach the API. ' + error);

    } finally {
        //console.log('in finally')
    }

}

 //create user
const createModel =  useModal()
const userObj = userModal()
const openCreate = () => {
    userObj.createEmptyUser()
    createModel.user = userObj.user
    createModel.showModal();
}

watch(name, getUsers)
watch(limit,getUsers)

</script>
<template>
    <Head title="Shoppers" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Shoppers
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8 flex flex-col">
                <div class="flex justify-between">
                    <div>
                        <h2 class="font-semibold text-lg mb-5">Shoppers</h2>
                    </div>
                    <div>
                        <PrimaryButton @click.prevent="openCreate">
                            Add Shopper
                        </PrimaryButton>
                    </div>
                </div>
                <!-- search bar  start -->
                 <SearchFilter
                    v-model:name="name"
                    v-model:limit="limit"
                 />
                 <!-- search bar end -->
                <div  class="bg-white p-4 shadow sm:rounded-lg sm:p-8"  >
                <!-- User listing start-->
                <UserList :users="props.users"></UserList>
                <!-- end listing-->
            </div>
            </div>
        </div>
    </AuthenticatedLayout>

 <!-- create user-->
 <Modal :show="createModel.show.value" @close="createModel.hideModal" >
    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8 flex flex-col">
            <!-- include user edit  form component -->
            <EditForm :user="createModel.user.value"  @close="createModel.hideModal"></EditForm>
            <!-- end form-->
        </div>
    </div>
</Modal>

</template>
