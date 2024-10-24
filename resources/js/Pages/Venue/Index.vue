<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import VenueList from './Partials/VenueList.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import SearchInput from './Partials/SearchInput.vue';
import { router } from '@inertiajs/vue3'
import { ref } from 'vue';
import { watch } from 'vue';

import AddVenueForm from './Partials/AddVenueForm.vue';
import EditVenueForm from './Partials/EditVenueForm.vue';
import { useTemplateRef, onMounted } from 'vue'
import { venueStore } from './venueStore.js';
ref('venues');

defineProps(['venues','limit','selectOptions']);
/*defineEmits({
    openEditVenueForm : (e) => {
        alert(e)
    }
})*/
const question = ref('')
const loading = ref(false)
const pageLimit = ref('');

const getVenues = async(newX) => {
    try {
        router.visit(route('venues'), {
            method:'get',
            data:{
                search : question.value,
                limit : pageLimit.value
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

/*const openEditVenueModal = () => {
    alert('here')
}*/

watch(question, getVenues)
watch(pageLimit,getVenues)



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
                        <AddVenueForm :select-options="selectOptions"></AddVenueForm>

                    </div>
                </div>
                <div class="flex justify-between">
                    <div>
                        <InputLabel for="searchText" value="A list of all the Secret hops in your account including their name and address." />

                        <TextInput
                            id="searchText"
                            type="text"
                            class="mt-1 block w-full"
                            autocomplete="name"
                            v-model="question"
                        />
                    </div>
                    <div>
                        <select
                        id="limit"
                        v-model="pageLimit"
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        :value="limit"
                        >
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                        </select>
                    </div>
                </div>
                <div  class="bg-white p-4 shadow sm:rounded-lg sm:p-8"  >

                    <VenueList :venues="venues" ref="venueList"/>

                </div>

            </div>
        </div>

        <div>


        </div>
    </AuthenticatedLayout>
</template>
