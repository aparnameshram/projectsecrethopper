
<script setup>

import { onMounted, ref } from 'vue';

/*const model = defineModel({
    type: String,
    required: true
});*/
const model = defineModel({
    type: String,
    required: true
});

const input = ref(null);

onMounted(() => {

});


//defineExpose({ focus: () => input.value.focus() });
defineProps(['options']);

</script>
<template>
    <div>
        <select
            v-model="model"
            class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        >
            <option v-for="option in options" :value="option.value">
              {{ option.label }}
            </option>
          </select>
    </div>
  </template>

