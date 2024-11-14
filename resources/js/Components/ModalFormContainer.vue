<script setup>
</script>
<template>
    <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
        <div class="grid grid-cols-6 gap-4 min-h-full items-start justify-left p-4 text-left sm:items-center sm:p-0">
            <div class="col-span-6">
                <h3 class="text-lg font-semibold text-left">
                    <slot name="title"></slot>
                </h3>
            </div>
            <slot></slot>
        </div>
    </div>
</template>
