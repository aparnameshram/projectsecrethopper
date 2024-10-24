<script setup>

import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { computed, ref } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { useGroupStore } from '../Store/Group';
import { router } from '@inertiajs/vue3'
import DefaultPagination from '@/Components/DefaultPagination.vue';
import { Inertia } from '@inertiajs/inertia'
//import {Inertia}

//user filter form
const form = useForm({
    name: '',
    radius: '',
    limit:'',
    selectall:false,
    selected:[]
});

const getUsers = async() => {
    try {
        Inertia.reload({
            only: ['users'],
            data:{
                name : form.name,
                limit : form.limit
            },
            preserveState: true,
            preserveScroll:true
        })
        /*router.visit(route('user.getUsers'), {
            method:'get',
            data:{
                name : form.name,
                limit : form.limit
            },
            only: ['users'],
            preserveState: true,
            preserveScroll:true
        })*/
    } catch (error) {
        console.log('Error! Could not reach the API. ' + error);

    } finally {

    }
}
const users = computed(() => usePage().props.users)
//const users = getUsers()
//const venue = computed(() => usePage().props.venue)
const configs =  usePage().props.selectOptions

//initialize group store
const groupStore = useGroupStore()

//filter through object to get lable
const drinker_type = (filterValue) => {
    const drinker = configs.drinkerType;
    let label = filterValue
    Object.keys(drinker).forEach(function(index) {

        if (drinker[index].value == filterValue) {
            label =  drinker[index].label
        }

    })
    return label
}

//add or remove user from store
const selectUser = (e) => {
  if (e.target.checked) {
    groupStore.insertUser(e.target.value)
  } else {
    groupStore.removeUser(e.target.value)
  }
}

//add or remove all users in/from store
const selectAllUsers = computed({
    get: function () {
        return users ? form.selected.length == users.length : false;
    },
    set: function (value) {

        var selected = [];
        if (value) {
            users.value.data.forEach(function (user) {
                selected.push(user.id);
            });
        }
        form.selected = selected;
        //group.users = selected;
        groupStore.users = selected
    }
})

//get users list(filtered / sorted)
/*const getUsers = async(venue) => {
    try {
        router.visit(route('group.create',venue.id), {
            method:'get',
            data:{
                name : form.name,
                limit : form.limit
            },
            only: ['users'],
            preserveState: true,
            preserveScroll:true
        })
    } catch (error) {
        console.log('Error! Could not reach the API. ' + error);

    } finally {

    }
}*/

</script>
<template>
    <div  class="bg-white p-4 shadow sm:rounded-lg sm:p-8 mt-5"  >
        <!-- shoppers list -->
        <div v-if="groupStore.existingUsers.length" class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Sign Up
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Level
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Gender
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <TransitionGroup>
                    <tr v-for="(user, index) in groupStore.existingUsers" :key="index" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ user.first_name +" "+ user.last_name }}
                        </th>
                        <td class="px-6 py-4">
                            {{ (user.user_profile.date_signed) ? user.user_profile.date_signed : ''}}
                        </td>
                        <td class="px-6 py-4">
                            {{ (user.user_profile.drinker_type) ? drinker_type(user.user_profile.drinker_type) : ''}}
                        </td>
                        <td class="px-6 py-4">
                            {{ (user.user_profile.gender) ? user.user_profile.gender : ''}}
                        </td>

                        <td class="px-6 py-4">
                            <a
                                @click="removeUser(index)"
                                as="button"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                </TransitionGroup>
                </tbody>
                </table>
        </div>
        <!-- shopers list ends here -->
        <div class="grid colums-6 min-h-full items-start justify-left p-4 text-left sm:items-center sm:p-0">
            <div class="col-span-6">
                <span class=" text-left">
                    Enter the search radius (in miles) and the limit for the number of shoppers returned. Note, clicking 'Update' will refresh the list of shoppers without saving any selections. Updating the shopper list will take more time depending on the shopper limit entered.
                </span>
            </div>
        </div>

        <form>
            <div class="grid grid-cols-6 gap-4 min-h-full items-start justify-left p-4 text-left sm:items-center sm:p-0">
                <div class="col-span-2">
                    <div class="mt-4">


                        <TextInput
                            label="Radius"
                            id="radius"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.radius"
                            placeholder="Search Radius(mi)"
                        />
                        <InputError class="mt-2" :message="form.errors.radius" />
                    </div>
                </div>
                <div class="col-span-1">
                    <div class="mt-4">

                        <TextInput
                            label="Shopper Limit"
                            id="shopper_limit"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.limit"
                            placeholder="Shopper Limit"
                        />
                        <InputError class="mt-2" :message="form.errors.limit" />
                    </div>
                </div>
                <div class="col-span-1">
                    <div class="mt-4">


                        <TextInput
                            label="Name"
                            id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.name"
                            placeholder="Search by Name"
                        />
                        <InputError class="mt-2" :message="form.errors.name" />

                    </div>
                </div>
                <div class="col-span-1">
                    <div class="mt-4">
                    <PrimaryButton
                    @click.prevent="getUsers()"
                    class="mt-1 ms-4"
                    :class="{ 'opacity-25': form.processing }"
                >
                    Filter
                </PrimaryButton>
                </div>
                </div>
                <div class="col-span-1"></div>
            </div>
            </form>
            <!-- shopper list start here-->
            <div  class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Distance
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Select
                                <input type="checkbox" name="selectall" v-model="selectAllUsers"/>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Sign Up
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Sample Length
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Last Visit
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Level
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Gender
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr v-for="(user, index) in users.data" :key="index" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                -
                            </th>
                            <td class="px-6 py-4">
                                <input type="checkbox" :name="user[index]"  v-model="form.selected" :value="user.id" number @click="selectUser"/>
                            </td>
                            <td class="px-6 py-4">
                                {{ user.first_name +" "+ user.last_name }}
                            </td>
                            <td class="px-6 py-4">
                               {{ (user.user_profile.date_signed) ? user.user_profile.date_signed : ''}}
                            </td>
                            <td class="px-6 py-4">
                                -
                            </td>
                            <td class="px-6 py-4">

                            </td>
                            <td class="px-6 py-4">
                                {{ (user.user_profile.drinker_type) ? drinker_type(user.user_profile.drinker_type) : ''}}
                            </td>
                            <td class="px-6 py-4">
                                {{ (user.user_profile.gender) ? user.user_profile.gender : ''}}
                            </td>
                        </tr>

                    </tbody>
                    </table>

                    <DefaultPagination :pagination="users" />
            </div>
            <!-- shopper list ends here-->


    </div>
</template>
