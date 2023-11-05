<template>
    <div class="p-8">
        <div class="xl:flex xl:flex-row xl:gap-4 flex flex-col gap-2">
            <div class="xl:h-96 xl:flex-grow  border rounded-md">
                <img v-if="image" :src="image" alt="" class="w-full h-full object-fill">
            </div>
            <div class="xl:h-96  border rounded-md p-6 break-all">
                <h1 class="text-2xl mb-2 font-medium">{{ candidate.name }} {{ candidate.lastname }}</h1>
                {{ candidate.user_description.about_me }}
            </div>
        </div>
        <div class="mt-6 flex flex-col gap-2">
            <div class="text-center border rounded-md p-4">
                <h1>Education</h1>
                {{ candidate.user_description.education }}
            </div>
            <div class="text-center border rounded-md p-4">
                <h1>Experience</h1>
                {{ candidate.user_description.experience }}
            </div>
        </div>
        <div class="xl:flex mt-6 xl:gap-4 xl:flex-row flex flex-col gap-2">
            <div class="flex items-center justify-center">
                <VuePDF :pdf="pdf" text-layer annotation-layer class=""/>
            </div>
            <div class=" flex-grow" style="height: 850px">

                <iframe :src="coverLetter" frameborder="0" class="w-full h-full"></iframe>
            </div>
        </div>


        <div class="w-full h-full mt-10">
            <div v-for="application in applications" :key="application.id" class="border rounded-md border-gray-800">
                <h1 class="text-center text-3xl font-medium">Application for a job {{ application.job.title }}</h1>
                <h3 class="text-center text-lg">Applied on {{useDateFormatting(application.created_at)}}</h3>
                <p class="text-lg font-medium pl-8">
                    {{ application.job.requirements }}
                </p>
                <p v-if="application.denied === -1" class="text-center mt-10 font-thin">If the user fullfills the requierements you can call the
                    candidate to the interview, otherwise deny the application</p>

                <div class="flex items-center justify-center gap-4 mb-10" v-if="application.denied === -1">
                    <Link :href="route('application.accept', {application : application , userId : candidate.id})" class="my-button" >Invite to an interview</Link>
                    <Link :href="route('application.response', {application : application, type: 1 })"
                        class="px-4 py-2  bg-red-700 rounded-md text-white outline-none focus:ring-4 shadow-lg transform active:scale-x-75 transition-transform text-center  mt-6">
                        Deny application
                    </Link>
                </div>
                <div v-else>
                    <p v-if="application.denied === 0" class="text-center mt-10 font-thin">
                        The application has been accepted. You invited the user to an interview through an e-mail.
                    </p>
                    <p v-else-if="application.denied=== 1" class="text-center mt-10 font-thin">
                        The application has been denied.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import {usePDF, VuePDF} from "@tato30/vue-pdf";
import {useDateFormatting} from "@/Composables/useDateFormatting.js";
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    candidate: Object,
    image: String,
    cv: String,
    coverLetter: String,
    applications: Object,
})
const {pdf} = usePDF(props.cv)
const {coverLetterPdf} = usePDF(props.coverLetter)

</script>
