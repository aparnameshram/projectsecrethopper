<script setup>
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';

import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

import { computed } from 'vue';
import SelectInput from '@/Components/SelectInput.vue';
import { usePage } from '@inertiajs/vue3'
import TimezoneList from '@/Components/TimezoneList.vue';
import { defineEmits } from 'vue';

const props = defineProps(['user'])

const selectOptions = computed(() => usePage().props.selectOptions)
const emit = defineEmits(['close'])
const form = useForm({
    id:props.user.id,
    first_name:props.user.first_name,
    last_name:props.user.last_name,
    phone:props.user.phone,
    email:props.user.email,
    user_profile:{
        gender:props.user.user_profile.gender,
        timezone:props.user.user_profile.timezone,
        address:props.user.user_profile.address,
        date_signed:props.user.user_profile.date_signed
    }
})

const submit = () => {
    if (props.user.id !== null)  {
        form.patch(route('user.update', props.user.id),{
            onSuccess:() => {
                emit('close')
                form.reset()
            }
        })
    } else {
        form.post(route('user.save'),{
            onSuccess:() => {
                emit('close')
                form.reset()
            }
        })
    }
}
</script>

<template>
<!-- include group form component -->
<form name="edit" @submit.prevent="submit">
    <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
        <div class="grid grid-cols-6 gap-4 min-h-full items-start justify-left p-4 text-left sm:items-center sm:p-0">
            <div class="col-span-6">
                <h3 class="text-lg font-semibold text-left">Update Shopper</h3>
            </div>
            <div class="mt-2 grid col-span-1 ">
                <InputLabel for="first_name" value="First Name" />
            </div>
            <div class="mt-2 grid col-span-5 text-left">
                <TextInput
                    id="first_name"
                    type="text"
                    class="mt-1 block"
                    v-model="form.first_name"
                    required
                    autofocus
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.first_name" />
            </div>

            <div class="mt-2 grid col-span-1 ">
                <InputLabel for="last_name" value="Last Name" />
            </div>
            <div class="mt-2 grid col-span-5 text-left">
                <TextInput id="last_name" type="text" class="mt-1 block" v-model="form.last_name" required autofocus
                    autocomplete="name"  />

                <InputError class="mt-2" :message="form.errors.last_name" />
            </div>

            <div class="mt-2 grid col-span-1 ">
                <InputLabel for="email" value="Email" />
            </div>
            <div class="mt-2 grid col-span-5 text-left">
                <TextInput id="email" type="email" class="mt-1 block" v-model="form.email" required autofocus
                    autocomplete="name"  />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-2 grid col-span-1 ">
                <InputLabel for="phone" value="Phone" />
            </div>
            <div class="mt-2 grid col-span-5 text-left">
                <TextInput
                    id="phone"
                    type="phone"
                    class="mt-1 block"
                    v-model="form.phone"
                    required
                    autofocus
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.phone" />
            </div>

            <div class="mt-2 grid col-span-1 ">
                <InputLabel for="gender" value="Gender" />
            </div>
            <div class="mt-2 grid col-span-5 text-left">
                <SelectInput
                    id="gender"
                    type="select"
                    class="mt-1 block w-full"
                    v-model="form.user_profile.gender"
                    required
                    autofocus

                    :options="selectOptions.gender"
                />
                <InputError class="mt-2" :message="form.errors.gender" />
            </div>


            <div class="mt-2 grid col-span-1 ">
                <InputLabel for="address" value="address" />
            </div>
            <div class="mt-2 grid col-span-5 text-left">
                <TextInput id="address" type="text" class="mt-1 block  " v-model="form.user_profile.address" required autofocus
                    autocomplete="name"  />

                <InputError class="mt-2" :message="form.errors.address" />
            </div>

            <div class="mt-2 grid col-span-1 ">
                <InputLabel for="timezone" value="timezone" />
            </div>
            <div class="mt-2 grid col-span-5 text-left">
                <TimezoneList
                    id="timezone"
                    class="mt-1 block w-full"
                    v-model="form.user_profile.timezone"
                    required
                    autofocus

                    :options="selectOptions.timezone"
                />
                <InputError class="mt-2" :message="form.errors.timezone" />
            </div>


            <div class="mt-2 grid col-span-1 ">
                <InputLabel for="date_signed" value="date_signed" />
            </div>
            <div class="mt-2 grid col-span-5 text-left">
                <TextInput id="date_signed" type="text" class="mt-1 block  " v-model="form.user_profile.date_signed" required autofocus
                    autocomplete="name"  />

                <InputError class="mt-2" :message="form.errors.date_signed" />
            </div>

            <div class="mt-2 grid col-span-6">

                <div class="flex justify-center">
                    <PrimaryButton
                        @click.prevent="submit"
                        class="ms-4"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Save
                    </PrimaryButton>
                    <PrimaryButton
                        @click="$emit('close')"
                        class="ms-4"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Cancel
                    </PrimaryButton>
                </div>
            </div>
        </div>
    </div>
    </form>

</template>
