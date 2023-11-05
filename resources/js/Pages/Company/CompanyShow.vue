<template>
    <div class="w-full h-full">
        <div class="flex justify-between">
            <div class="flex flex-col text-xl p-4">
                <span class="font-medium text-3xl mb-4">{{company.name}}</span>
                <span>Address: {{company.city}} , {{company.address}}</span>
                <span>E-mail: {{company.email}}</span>
                <span>Phone: {{company.phone}}</span>

            </div>
            <div class="flex items-end justify-end">
                <img :src="company.imageUrl" alt="" class="w-1/2">
            </div>
        </div>
        <div class="mt-10">
            <h1 class="text-center text-2xl font-medium">Description</h1>
            <p class="p-4 text-xl">
                {{company.description}}
            </p>
        </div>
    </div>
</template>
<script setup>
import {defineProps} from 'vue'

defineProps({
    company: Object
})
</script>
