<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import SelectInput from '@/Components/SelectInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import testChild from '@/Components/testChild.vue';
import level1Child from '@/Components/level1Child.vue';
import { ref } from 'vue';

defineProps(['listitems']);
const form = useForm({
    'gender' :''
})
const submit = () => {
    form.post(route('process'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
const count = ref('')

const increaseCount = (n) => {
  count.value += n
  alert(count.value);
}
</script>

<template>
   <h1>hello world</h1>
   <ul>
    <li v-for="item in listitems">
        {{ item.name }}  : <span>id</span> {{ item.id }}
    </li>
</ul>
<h1>slect option form</h1>
<form @submit.prevent="submit">

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
        :options="listitems"
    />


    <InputError class="mt-2" :message="form.errors.gender" />
</div>
<PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Log in
                </PrimaryButton>
</form>
<level1Child @increase-by="increaseCount" />
</template>
