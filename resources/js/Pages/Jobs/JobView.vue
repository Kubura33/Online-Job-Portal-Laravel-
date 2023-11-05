<template>
    <div>
        <div class="flex flex-col gap-8">
            <div class="flex flex-col gap-4">
                <span class="text-3xl font-medium">{{ job.title }}</span>
                <span class="text-lg font-medium">Location : {{ job.location }}</span>
                <span class="text-lg font-medium">Posted at : {{ date }}</span>
                <span class="text-lg font-medium">Ends at : {{ job.end_of_job_ad }}</span>
            </div>
            <div class="flex gap-8">
                <Link :href="route('jobs.edit', {job: job.id})" class="edit-button w-20 text-center">Edit</Link>
                <span class="delete-button w-20 text-center">Delete</span>
            </div>
        </div>
        <div class="w-full mt-20">
            <div class="mb-10">
                <h1 class="text-center text-2xl font-medium">Users that applied for this job
                    ({{ applications.length }})</h1>
                <ul class="flex flex-col items-center justify-center p-6">
                    <li v-for="application in applications" :key="application.id"
                        class="flex items-center gap-8 border-t-2 p-2">

                        <Link :href="route('user.info', {user: application.user.id})" class="">
                            {{ application.user.name }} has applied for your job on
                            {{ useDateFormatting(application.created_at) }} . Click on this line to open user
                            profile and
                            check out their bio
                        </Link>

                        <div class="flex items-center justify-center gap-4 mb-6" v-if="application.denied === -1">
                            <Link
                                :href="route('application.accept', {application : application , userId : application.user.id})"
                                class="my-button">Invite to an interview
                            </Link>
                            <Link :href="route('application.response', {application : application, type: 1 })"
                                  method="POST"
                                  as="button"
                                  class="px-4 py-2  bg-red-700 rounded-md text-white outline-none focus:ring-4 shadow-lg transform active:scale-x-75 transition-transform text-center  mt-6">
                                Deny application
                            </Link>
                        </div>
                        <div v-else>
                            <p v-if="application.denied === 0" class="text-center font-thin">
                                The application has been accepted. You invited the user to an interview through an
                                e-mail.
                            </p>
                            <p v-else-if="application.denied=== 1" class="text-center  font-thin">
                                The application has been denied.
                            </p>
                        </div>
                    </li>

                </ul>
            </div>
            <div class="border rounded-2xl p-6 bg-gray-300 dark:bg-gray-700 ">
                <h1 class="mb-8 text-center text-4xl font-medium">Description</h1>
                {{
                    job.description
                }}
            </div>
            <div class="border rounded-2xl p-6 bg-gray-300 dark:bg-gray-700 mt-10 ">
                <h1 class="mb-8 text-center text-4xl font-medium">Requierements</h1>
                <div class="flex items-center justify-center text-lg ">
                    <ul class="list-disc w-2/3 flex flex-col gap-4">
                        <li>{{
                                job.requirements
                            }}
                        </li>
                        <li> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt est ipsum modi
                            perspiciatis
                            ut? Eligendi facilis hic porro! A accusantium at cum deleniti deserunt iste maxime optio
                            placeat
                            possimus quae.
                        </li>
                        <li> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt est ipsum modi
                            perspiciatis
                            ut? Eligendi facilis hic porro! A accusantium at cum deleniti deserunt iste maxime optio
                            placeat
                            possimus quae.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import {defineProps} from 'vue'
import {useDateFormatting} from '../../Composables/useDateFormatting.js'
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    job: Object,
    applications: Array,
})
console.log(props.applications)
const date = useDateFormatting(props.job.created_at)
</script>
