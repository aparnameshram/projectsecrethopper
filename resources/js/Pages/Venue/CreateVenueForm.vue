<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
defineProps(['showPopup'])
const form = useForm({
    name: '',
    address: '',
    city: '',
    state: '',
    zip: '',
    timezone: '',
    radius: '',
    country: '',
    status: '',
    questionnaire_link: '',
    unique_instructions: ''
});

const submit = () => {
    form.post(route('venue.create'), {
       // onFinish: () => form.reset('password'),
    });
};
</script>
<template>
    <div v-show="showPopup" class="fixed inset-0 flex items-center
    justify-center bg-gray-900
    bg-opacity-50 transition-opacity
    duration-300">
    <form @submit.prevent="submit">
        <div>
            <InputLabel for="name" value="Name" />

            <TextInput
                id="name"
                type="name"
                class="mt-1 block w-full"
                v-model="form.name"
                required
                autofocus
                autocomplete="name"
            />

            <InputError class="mt-2" :message="form.errors.name" />
        </div>
        <div>
            <InputLabel for="address" value="Address" />

            <TextInput
                id="address"
                type="address"
                class="mt-1 block w-full"
                v-model="form.address"
                required
                autofocus
                autocomplete="address"
            />

            <InputError class="mt-2" :message="form.errors.address" />
        </div>
    </form>
</div>
</template>
