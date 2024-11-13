<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import VenueList from './Partials/VenueList.vue';
import { router } from '@inertiajs/vue3'
import { ref } from 'vue';
import { watch } from 'vue';
import VenueForm from './Partials/VenueForm.vue';
import { useModal } from '@/Components/Modal';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';
import SearchInput from './Partials/SearchInput.vue';

const props = defineProps(['venues','limit','selectOptions']);

const loading = ref(false)
const name = ref('')
const limit = ref(props.limit);
const getVenues = async(newX) => {
    try {
        router.visit(route('venues'), {
            method:'get',
            data:{
                search : name.value,
                limit : limit.value
            },
            only: ['venues'],
            preserveState: true,

        })
    } catch (error) {
        console.log('Error! Could not reach the API. ' + error);

    } finally {
    loading.value = false
    }
}

//create venue
const createModel =  useModal()
const openCreate = () => {
    createModel.venue = new Object()
    createModel.showModal();
}
watch(name, getVenues)
watch(limit,getVenues)

</script>

<template>
    <Head title="Secret Hops" />
    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Secret Hops
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8 flex flex-col">
                <div class="flex justify-between">
                    <div>
                        <h2 class="font-semibold text-lg mb-5">Secret Hops</h2>
                        <p>A list of all the Secret hops in your account including their name and address.</p>
                    </div>
                    <div>
                        <PrimaryButton @click.prevent="openCreate">
                            Add Venue
                        </PrimaryButton>
                    </div>
                </div>

                <SearchInput v-model:name="name" v-model:limit="limit" />
                <div  class="bg-white p-4 shadow sm:rounded-lg sm:p-8"  >
                    <VenueList :venues="props.venues" ref="venueList"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <!-- create user-->
 <Modal :show="createModel.show.value" @close="createModel.hideModal" >
    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8 flex flex-col">
            <!-- include user edit  form component -->
            <VenueForm :venue="createModel.venue.value"  @close="createModel.hideModal"></VenueForm>
            <!-- end form-->
        </div>
    </div>
</Modal>
</template>
