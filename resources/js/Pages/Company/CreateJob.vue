<template>
    <div class="w-full">
        <h1 class="text-center mt-6 text-4xl text-indigo-600 font-medium">Add job</h1>
        <form class="mx-auto w-2/4 mt-10" @submit.prevent="addJob">
            <div class="flex flex-col gap-2">
                <label class="my-label" for="">Job title</label>
                <input class="my-input" v-model="form.title" type="text">
                <label class="my-label" for="">Requirements</label>
                <textarea class="my-input" v-model="form.requirements"></textarea>
                <label class="my-label" for="">Job description</label>
                <textarea class="my-input" type="text" v-model="form.description"></textarea>
                <label for="location" class="my-label">Location: </label>
                <input type="text" id="location" class="my-input" v-model="form.location">
                <label class="my-label" for="">Job AD end date</label>
                <input class="my-input" type="date" v-model="form.end_of_job_ad">
                <div class="w-full flex items-center justify-center">
                    <button
                        class="border-2  w-60 mt-4 border-blue-600 rounded-lg px-3 py-2 text-blue-400 cursor-pointer hover:bg-blue-600 hover:text-blue-200">
                        Add
                    </button>
                </div>
            </div>
        </form>

    </div>
</template>
<script setup>
import {useForm} from "@inertiajs/vue3";
const form = useForm({
    title: null,
    requirements: null,
    location: null,
    end_of_job_ad: null,
    description: null,
})
const addJob = () => form.post(route('jobs.store'))
</script>
