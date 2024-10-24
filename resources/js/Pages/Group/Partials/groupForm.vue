<script setup>

import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import TextareaInput from '@/Components/TextareaInput.vue';
import Checkbox from '@/Components/Checkbox.vue';
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { useGroupStore } from '../Store/Group';


const uniqueInstructions = computed(() => usePage().props.questionnaire.unique_instructions)
const inviteName = computed(() => {
    const date = new Date()
    return 'Invite:'+date.toLocaleDateString()
})
const props = defineProps(['group','action'])
//initialize group store
const group = useGroupStore()

//basic group info form
const form = useForm({
    name: props.group.name,
    claim_limit:props.group.claim_limit,
    radius: props.group.radius,
    unique_instructions: props.group.unique_instructions,
    show_in_search:props.group.show_in_search,
    timeslots:[]
});
</script>
<template>
<form name="create" @submit.prevent="submit">
<div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">

    <div class="grid grid-cols-6 gap-4 min-h-full items-start justify-left p-4 text-left sm:items-center sm:p-0">
        <div class="col-span-6">
            <h3 class="text-lg font-semibold text-left">Basic Info</h3>
        </div>
        <div class="mt-5 grid col-span-1 ">
            <InputLabel for="name" value="Name" />
        </div>
        <div class="mt-5 grid col-span-2 text-left">
            <TextareaInput id="name" type="text" class="mt-1 block  " v-model="form.name" required autofocus
                autocomplete="name" rows="3" />

            <InputError class="mt-2" :message="form.errors.name" />
        </div>
        <div class="mt-5 col-span-3"></div>


        <div class="mt-5 grid col-span-1">

            <InputLabel for="claim_limit" value="Claim Limit" />
        </div>
        <div class="mt-5 flex col-span-2">
            <TextInput id="claim_limit" type="text" class="mt-1 block w-full" v-model="form.claim_limit" required
                autofocus autocomplete="claim_limit" />

            <div>
                <InputError class="mt-2" :message="form.errors.claim_limit" />
            </div>
        </div>
        <div class="mt-5 col-span-3"></div>


        <div class="mt-5 grid col-span-1">

            <InputLabel for="radius" value="Radius (In mi)" />
        </div>
        <div class="mt-5 flex col-span-2">
            <TextInput id="radius" type="text" class="mt-1 block w-full" v-model="form.radius" required autofocus
                autocomplete="radius" />

            <div>
                <InputError class="mt-2" :message="form.errors.radius" />
            </div>
        </div>
        <div class="mt-5 col-span-3"></div>

        <div class="mt-5 grid col-span-1">

            <InputLabel for="unique_instructions" value="Unique Instructions" />
        </div>
        <div class="mt-5 grid col-span-2">
            <TextareaInput id="unique_instructions" class="mt-1 block  " v-model="form.unique_instructions" required
                autofocus autocomplete="unique_instructions" rows="3" />

            <InputError class="mt-2" :message="form.errors.unique_instructions" />
        </div>
        <div class="mt-5 col-span-3"></div>

        <div class="mt-5 grid col-span-1">

            <InputLabel for="show_in_search" value="Show in Search" />
        </div>
        <div class="mt-5 flex col-span-2">
            <Checkbox id="show_in_search" v-model:checked="form.show_in_search" required />

            <InputError class="mt-2" :message="form.errors.show_in_search" />
        </div>
        <div class="col-span-3"></div>

    </div>
</div>
</form>
</template>
