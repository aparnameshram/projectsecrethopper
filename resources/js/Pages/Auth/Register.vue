<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import GuestRegisterLayout from '@/Layouts/GuestRegisterLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import SelectInput from '@/Components/SelectInput.vue';
import TextareaInput from '@/Components/TextareaInput.vue';
import TimezoneList from '@/Components/TimezoneList.vue';

defineProps(['selectOptions'])
const form = useForm({
    first_name: '',
    last_name:'',
    email: '',
    password: '',
    password_confirmation: '',
    phone:'',
    date_of_birth:'',
    address:'',
    city:'',
    state:'',
    country:'',
    zip:'',
    timezone:'',
    drinker_type:'',
    how_did_hear:'',
    recent_experience:'',
    qualification_for_hopper:'',
    acknowledge_text:'',
    acknowledge_name:'',
    date_signed:'',
    gender:'',
    practice_report:''
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};



</script>

<template>
    <GuestRegisterLayout>
        <Head title="Register" />
        <div class="flex flex-col w-full flex-grow mx-auto">
            <div class="flex w-full  px-5 py-5 ">
                Please complete the form below
                Do not just write “I love beer.” Show us your writing skills!
                Breweries are looking for shoppers that can pay attention to small details.
                If you do not supply a detailed writing sample, you will not be contacted for openings in your area.
            </div>
        <form @submit.prevent="submit">
            <div class="flex px-5 py-5">
            <div class="grid grid-cols-2 w-full gap-4">
            <div>
                <InputLabel for="first_name" value="First Name" />

                <TextInput
                    id="first_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.first_name"
                    required
                    autofocus
                    autocomplete="first_name"
                />

                <InputError class="mt-2" :message="form.errors.first_name" />
            </div>

            <div>
                <InputLabel for="last_name" value="Last Name" />

                <TextInput
                    id="last_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.last_name"
                    required
                    autofocus
                    autocomplete="last_name"
                />

                <InputError class="mt-2" :message="form.errors.last_name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="phone" value="Phone" />

                <TextInput
                    id="phone"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.phone"
                    required
                    autofocus
                    autocomplete="phone"
                />

                <InputError class="mt-2" :message="form.errors.phone" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    value="Confirm Password"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div>
                <InputLabel for="date_of_birth" value="Date of Birth" />

                <TextInput
                    id="date_of_birth"
                    type="date"
                    class="mt-1 block w-full"
                    v-model="form.date_of_birth"
                    required
                    autofocus
                    autocomplete="date_of_birth"
                />

                <InputError class="mt-2" :message="form.errors.date_of_birth" />
            </div>

            <div>
                <InputLabel for="gender" value="Gender" />

                <SelectInput
                    id="gender"
                    type="select"
                    class="mt-1 block w-full"
                    v-model="form.gender"
                    required
                    autofocus
                    autocomplete="gender"
                    :options="selectOptions.gender"
                />


                <InputError class="mt-2" :message="form.errors.gender" />
            </div>

            <div class="col-span-2">
                <InputLabel for="address" value="Street Address" />

                <TextInput
                    id="address"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.address"
                    required
                    autofocus
                    autocomplete="address"
                />

                <InputError class="mt-2" :message="form.errors.address" />
            </div>
            <div class="col-span-2">
                <div class="grid grid-cols-3 gap-2">

                    <div>
                        <InputLabel for="city" value="City" />

                        <TextInput
                            id="city"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.city"
                            required
                            autofocus
                            autocomplete="city"
                        />

                        <InputError class="mt-2" :message="form.errors.city" />
                    </div>

                    <div>
                        <InputLabel for="state" value="State" />

                        <TextInput
                            id="state"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.state"
                            required
                            autofocus
                            autocomplete="state"
                        />

                        <InputError class="mt-2" :message="form.errors.state" />
                    </div>

                    <div>
                        <InputLabel for="zip" value="Zip" />

                        <TextInput
                            id="zip"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.zip"
                            required
                            autofocus
                            autocomplete="zip"
                        />

                        <InputError class="mt-2" :message="form.errors.zip" />
                    </div>
                 </div>
            </div>
            <div>
                <InputLabel for="country" value="Country" />

                <TextInput
                    id="country"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.country"
                    required
                    autofocus
                    autocomplete="country"
                />

                <InputError class="mt-2" :message="form.errors.country" />
            </div>
            <div>
                <InputLabel for="timezone" value="Timezone" />

                <TimezoneList
                    id="timezone"
                    class="mt-1 block w-full"
                    v-model="form.timezone"
                    required
                    autofocus
                    autocomplete="timezone"
                    :options="selectOptions.timezone"
                />

                <InputError class="mt-2" :message="form.errors.timezone" />
            </div>

            <div class="col-span-2">
                <InputLabel for="drinker_type" value="Type of Beer drinker" />

                <SelectInput
                    id="drinker_type"
                    type="select"
                    class="mt-1 block w-full"
                    v-model="form.drinker_type"
                    required
                    autofocus
                    autocomplete="drinker_type"
                    :options="selectOptions.drinkerType"
                />

                <InputError class="mt-2" :message="form.errors.drinker_type" />
            </div>

            <div class="col-span-2">
                <InputLabel for="how_did_hear" value="How did you hear about Secret Hopper" />

                <TextInput
                    id="how_did_hear"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.how_did_hear"
                    required
                    autofocus
                    autocomplete="how_did_hear"
                />

                <InputError class="mt-2" :message="form.errors.how_did_hear" />
            </div>

            <div class="col-span-2">
                <InputLabel for="recent_experience" value="Please describe a recent experience at a brewery or restaurant. Show off your writing skills!" />

                <TextareaInput
                    id="recent_experience"
                    type="textarea"
                    class="mt-1 block w-full"
                    rows="3"
                    v-model="form.recent_experience"
                    required
                    autofocus
                    autocomplete="recent_experience"
                />

                <InputError class="mt-2" :message="form.errors.recent_experience" />
            </div>

            <div class="col-span-2">
                <InputLabel for="qualification_for_hopper" value="What makes you qualified to be a Secret Hopper? Treat this like a real job application." />

                <TextInput
                    id="qualification_for_hopper"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.qualification_for_hopper"
                    required
                    autofocus
                    autocomplete="qualification_for_hopper"
                />

                <InputError class="mt-2" :message="form.errors.qualification_for_hopper" />
            </div>

            <div class="col-span-2">
                <InputLabel for="acknowledge_text" value="'Please describe a recent experience at a brewery or restaurant. Show off your writing skills!" />

                <TextInput
                    id="acknowledge_text"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.acknowledge_text"
                    required
                    autofocus
                    autocomplete="acknowledge_text"
                />

                <InputError class="mt-2" :message="form.errors.acknowledge_text" />
            </div>

            <div class="col-span-2">
                <InputLabel for="acknowledge_name" value="By typing your name below, you acknowledge that you have read and agree to all terms and conditions in the Independent Contractor Agreement, understand that it may be updated over time, and that it is your responsibility to check this website for the latest version" />

                <TextInput
                    id="acknowledge_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.acknowledge_name"
                    required
                    autofocus
                    autocomplete="acknowledge_name"
                />

                <InputError class="mt-2" :message="form.errors.acknowledge_name" />
            </div>

            <div class="col-span-2">
                <InputLabel for="date_signed" value="Date Signed" />

                <TextInput
                    id="date_signed"
                    type="date"
                    class="mt-1 block w-full"
                    v-model="form.date_signed"
                    required
                    autofocus
                    autocomplete="date_signed"
                />

                <InputError class="mt-2" :message="form.errors.date_signed" />
            </div>

            <div class="col-span-2">
                <InputLabel for="practice_report" value="Up for completing a practice report to see exactly what we\'re looking for?" />

                <input
                    id="yes"
                    type="radio"
                    v-model="form.practice_report"
                    :value="true" />
                    <label for="yes">Yes</label>
                <input
                    type="radio"
                    id="no"
                    v-model="form.practice_report"
                    :value="false" />
                    <label for="no">No</label>
                <InputError class="mt-2" :message="form.errors.practice_report" />
            </div>
            <div class="mt-4 flex items-center justify-end">
                <Link
                    :href="route('login')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Already registered?
                </Link>

                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
                </PrimaryButton>
            </div>
        </div>
    </div>
        </form>
        </div>
    </GuestRegisterLayout>
</template>
