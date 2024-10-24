<script setup>
defineEmits(['increaseBy'])
</script>
<template>
<h1 class="font-bold"> This text is from level 2 child</h1>
<button class=" font-bold bg-slate-100 p-5 " @click="$emit('increaseBy', 1)">
    Increase by 1
</button>
</template>
