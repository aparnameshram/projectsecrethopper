<script setup>
defineEmits(['increaseBy'])

</script>
<template>
    <button class=" font-bold bg-slate-100 p-5 " @click="$emit('increaseBy', 1)">
        Increase by 1
    </button>
</template>
