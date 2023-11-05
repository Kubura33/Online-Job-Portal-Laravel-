<template>
    <div class="w-full h-full grid grid-cols-4 gap-4 p-14">
        <Link :href="route('company.show', {company : company })" v-for="company in companies" class="border rounded-md flex flex-col">
            <div class="w-full h-40">
                <img :src="company.imageUrl" alt="" class="h-full w-full">
            </div>
            <div class="">
                <h1 class="text-center font-medium text-2xl">{{company.name}}</h1>
                <p class="text-sm">
                    {{company.description}}
                </p>
            </div>
        </Link>
    </div>
</template>
<script setup>
import {defineProps} from 'vue'
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    companies: Array,
})
console.log(props.companies)
</script>
