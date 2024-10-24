<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
const props = defineProps({
  listitems: {
    type:object
  }
})
console.log(listitems)
</script>

<template>
    <ul>
        <li v-for="item in listitems">
            {{ item.name }}  : <span>id</span> {{ item.id }}
        </li>
    </ul>
</template>
