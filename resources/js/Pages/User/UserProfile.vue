<template>
    <div class="w-full" >
        <div class="md:flex md:flex-row md:justify-between md:items-center gap-6 mt-2 flex flex-col-reverse">

            <div class="lg: w-2/3 break-words border rounded-md p-4">
                <h1 class="text-center font-medium text-2xl mb-4">About me</h1>
                {{ bio.about_me }}
            </div>
            <div class="flex flex-col items-center lg:w-1/5 lg:mr-20 md:w-2/5 md:h-80 justify-center">
                <div class="md:w-full w-3/5 md:h-64 h-80 border rounded-md md:flex">
                    <img :src="path" alt="" v-if="path" class="w-full md:h-64 h-80 object-contain">
                </div>
                <Link :href="route('user.edit')" class=" font-medium text-blue-200 mt-4">Edit your profile</Link>

            </div>
        </div>
        <div class="w-full flex justify-evenly items-center">
            <div class="border rounded-md p-4">
                <h1 class="text-3xl text-center font-medium text-gray-300 m-4">Experience</h1>
                <p>
                    {{bio.experience}}
                </p>
            </div>
            <div class="border rounded-md p-4">
                <h1 class="text-3xl font-medium text-center text-gray-300 m-4">Education</h1>
                <p>
                    {{bio.education}}
                </p>
            </div>
        </div>
        <div class="flex gap-4 mt-10 items-center justify-center">
            <div class="flex items-center flex-col gap-2">
                <div
                    @click="openCvPdfModal"
                    class=" p-4 border rounded-md hover:bg-gray-500 hover:cursor-pointer transition duration-300 ease-in-out">
                    Your current CV

                </div>

            </div>
            <div class="flex items-center flex-col gap-2">
                <div
                    @click="openCoverLetterPdfModal"
                    class="p-4 border rounded-md hover:bg-gray-500 hover:cursor-pointer transition duration-300 ease-in-out">
                    Your current Cover Letter
                </div>
            </div>
        </div>
        <div class="flex items-center justify-center w-full mt-10 flex-col">
            <h1 class="font-medium text-3xl mb-4">Jobs you have applied for ({{ applications.length }})</h1>
            <div class=" w-3/4">
                <div v-for="application in applications" :key="application.id" class="border rounded-lg border-gray-200 p-4">
                    <div class="flex justify-between">
                        <div class="flex flex-col">
                            <span class="font-medium text-3xl">{{ application.job.title }}</span>
                            <span class="font-light opacity-70 text-xl">{{ application.job.employer.name }}</span>
                        </div>

                        <div class="flex flex-col gap-1">
                            <span
                                class="text-lg font-medium">Applied: {{
                                    useDateFormatting(application.created_at)
                                }} </span>
                            <span
                                class="text-lg font-medium">Number of applicants: {{
                                    countJobs(application.job_ad_id)
                                }}</span>
                        </div>
                    </div>
                    <p class="mt-4 text-center break-all ">{{ formatText(application.job.description) }}</p>
                    <Link :href="route('jobs.show', {job: application.job})" class="mt-4 underline hover:cursor-pointer">View job</Link>
                </div>
            </div>
        </div>


    </div>
    <div v-if="isOpen" class="fixed top-0 left-0 w-full h-full flex items-center justify-center backdrop-blur">
        <div class="p-4 rounded-lg shadow-lg h-full w-1/3">
            <button @click="closePdfModal" class="absolute top-2 right-2 font-medium text-gray-600 hover:text-gray-800">
                Close
            </button>
            <div class="h-full">

                <object :data="pdfLink" type="application/pdf" class="w-full h-full"></object>
            </div>
        </div>
    </div>
</template>
<script setup>
import {ref, defineProps, computed,} from "vue";
import { Link} from "@inertiajs/vue3";
import {useDateFormatting} from '../../Composables/useDateFormatting.js'

const props = defineProps({
    applications: Array,
    jobs: Array,
    bio: Object,
    coverLetter: String,
    cvUrl: String,
    image: String,
})
const path = computed(() => {
    return props.image
})
const pdfLink = ref(null)
console.log(props.image)
const countJobs = (jobId) => {

    return props.jobs.filter((job) => job.job_ad_id === jobId).length;

}
const formatText = (text) => {
    const maxLength = 200;
    const formattedText = text.length > maxLength ? text.substring(0, maxLength) + "..." : text;

    return formattedText;
}
const isOpen = ref(false)
const openCvPdfModal = () => {
    pdfLink.value = props.cvUrl
    isOpen.value = true
}
const openCoverLetterPdfModal = () => {
    pdfLink.value = props.coverLetter
    isOpen.value = true
}
const closePdfModal = () => isOpen.value = false
</script>
