<script setup>
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    const name = defineModel('name')
    const limit = defineModel('limit')
</script>
<template>
<div class="flex justify-between">
    <div>
        <InputLabel for="searchText" value="A list of all the Secret hops in your account including their name and address." />
        <TextInput
            id="searchText"
            type="text"
            class="mt-1 block w-full"
            autocomplete="name"
            v-model="name"
        />
    </div>
    <div>
        <select
            id="limit"
            v-model="limit"
            class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        >
            <option>10</option>
            <option>25</option>
            <option>50</option>
        </select>
    </div>
</div>
</template>

