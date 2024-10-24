<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextareaInput from '@/Components/TextareaInput.vue';
import Checkbox from '@/Components/Checkbox.vue';
import TimeslotAddForm from './Partials/TimeslotAddForm.vue';
import { computed, ref } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { useGroupStore } from './Store/Group';
import ShoppersList from './Partials/ShoppersList.vue';
import PrimaryLink from '@/Components/PrimaryLink.vue';

defineProps(['venue','questionnaire'])
const uniqueInstructions = computed(() => usePage().props.questionnaire.unique_instructions)

function getinviteName(){
    const date = new Date()
    return 'Invite:'+date.toLocaleDateString()
}

let inviteNameStr = ref('')
inviteNameStr = getinviteName()
//initialize group store
const group = useGroupStore()
group.$reset()

//basic group info form
const form = useForm({
    name: inviteNameStr,
    claim_limit:'',
    radius: '10',
    unique_instructions: uniqueInstructions,
    show_in_search:false,
    timeslots:[]
});

//post data to create new group (along with timeslots and assigned users)
function createGroup(venueId) {

    form
    .transform((data) => ({
        ...data,
        timeslots:group.timeslots,
        users:group.users
    }))
    .post(
        route('group.store',venueId),{
            reserveScroll: true,
            onSuccess:(page) => {
                console.log('success')
            },
            onError:(errors) => {
                form.errors = errors
            }
        }
    )

}
</script>
<template>

        <Head title="venue.name" />

        <AuthenticatedLayout>
            <template #header>
                <h2
                    class="text-xl font-semibold leading-tight text-gray-800"
                >
                    Create New Group For {{ venue.name }}
                </h2>
            </template>

            <div class="py-12">
                <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8 flex flex-col">
                    <div class="flex justify-between">
                        <div>
                            <h2 class="font-semibold text-lg mb-5">Groups</h2>

                        </div>
                        <div>
                            <PrimaryLink
                            :href="route('venue.groups',venue.id)"
                            as="button"
                            >
                               Back
                        </PrimaryLink>

                        </div>
                    </div>
                    <form name="createGroup" @submit.prevent="submit">
                    <div  class="bg-white p-4 shadow sm:rounded-lg sm:p-8"  >

                        <div class="grid grid-cols-6 gap-4 min-h-full items-start justify-left p-4 text-left sm:items-center sm:p-0">
                            <div class="col-span-6"><h3 class="text-lg font-semibold text-left">Basic Info</h3></div>
                            <div class="mt-5 grid col-span-1 ">
                                <InputLabel for="name" value="Name" />
                            </div>
                            <div class="mt-5 grid col-span-2 text-left">
                                <TextareaInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block  "
                                    v-model="form.name"
                                    required
                                    autofocus
                                    autocomplete="name"
                                    rows="3"

                                />

                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>
                            <div class="mt-5 col-span-3"></div>


                            <div class="mt-5 grid col-span-1">

                                <InputLabel for="claim_limit" value="Claim Limit" />
                            </div>
                            <div class="mt-5 flex col-span-2">
                                <TextInput
                                id="claim_limit"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.claim_limit"
                                required
                                autofocus
                                autocomplete="claim_limit"
                            />

                            <div><InputError class="mt-2" :message="form.errors.claim_limit" /></div>
                            </div>
                            <div class="mt-5 col-span-3"></div>


                            <div class="mt-5 grid col-span-1">

                                <InputLabel for="radius" value="Radius (In mi)" />
                            </div>
                            <div class="mt-5 flex col-span-2">
                                <TextInput
                                id="radius"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.radius"
                                required
                                autofocus
                                autocomplete="radius"
                            />

                            <div><InputError class="mt-2" :message="form.errors.radius" /></div>
                            </div>
                            <div class="mt-5 col-span-3"></div>

                            <div class="mt-5 grid col-span-1">

                                <InputLabel for="unique_instructions" value="Unique Instructions" />
                            </div>
                            <div class="mt-5 grid col-span-2">
                                <TextareaInput
                                    id="unique_instructions"

                                    class="mt-1 block  "
                                    v-model="form.unique_instructions"
                                    required
                                    autofocus
                                    autocomplete="unique_instructions"
                                    rows="3"
                                />

                                <InputError class="mt-2" :message="form.errors.unique_instructions" />
                            </div>
                            <div class="mt-5 col-span-3"></div>

                            <div class="mt-5 grid col-span-1">

                                <InputLabel for="show_in_search" value="Show in Search" />
                            </div>
                            <div class="mt-5 flex col-span-2">
                                <Checkbox
                                id="show_in_search"
                                v-model:checked="form.show_in_search"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.show_in_search" />
                            </div>
                            <div class="col-span-3"></div>

                        </div>
                    </div>
                    </form>
                    <!-- end group add form-->
                    <!-- timeslot add form starts here-->
                    <div  class="bg-white p-4 shadow sm:rounded-lg sm:p-8 mt-5"  >
                    <div class="grid colums-6 min-h-full items-start justify-left p-4 text-left sm:items-center sm:p-0">
                        <div class="col-span-6">
                            <h3 class="text-lg font-semibold text-left">Timeslots</h3>
                            <TimeslotAddForm ></TimeslotAddForm>
                        </div>
                    </div>
                    </div>
                    <!-- timeslot add form ends here-->
                     <!-- shopper search form starts here-->
                    <ShoppersList></ShoppersList>
                    <!-- shopper search form ends here-->

                    <div class="flex justify-items-end justify-end">
                        <div class="flex"></div>
                        <div class="flex">
                            <PrimaryButton
                                @click.prevent="createGroup(venue.id)"
                                class="ms-4"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Save
                            </PrimaryButton>
                        </div>

                    </div>

                </div>
            </div>
        </AuthenticatedLayout>
</template>
