<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
</script>
<template>
    <div>
        <InputLabel for="search" value="A list of all the Secret hops in your account including their name and address." />

        <TextInput
            id="search"
            type="text"
            class="mt-1 block w-full"
            autofocus
            autocomplete="name"
            v-model="text"
        />
    </div>
</template>
