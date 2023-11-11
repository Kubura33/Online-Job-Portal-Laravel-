<template>
    <div>
        <h1 v-if="!description" class="text-center text-red-500 text-4xl font-medium">
            Before applying to jobs, you will need to add information about your profile
        </h1>
        <form @submit.prevent="submitUserDescription" class="w-full">
            <div class="flex flex-col gap-2 lg:w-1/2 mx-auto mt-6">
                <div class=" md:w-full w-3/5 md:h-64 h-80  md:flex items-center justify-center">
                    <div class="w-3/5 md:h-64 h-80 border rounded-md">
                    <img :src="selectedImage" v-if="selectedImage" alt="" class="w-full  md:h-64 h-full object-contain">
                    <img :src="image" alt="" v-else-if="image" class="w-full md:h-64 h-full object-contain">
                    </div>
                </div>
                <input
                    class="relative m-0 block w-full min-w-0 flex-auto cursor-pointer rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-xs font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-100 dark:focus:border-primary"
                    id="formFileSm"
                    type="file"
                    accept="image/*"
                    @change="handleFileChange"
                />
                <label for="education" class="my-label">Education</label>
                <input type="text" class="my-input" id="education" v-model="descriptionForm.education">
                <label for="experience" class="my-label">Experience</label>
                <input type="text" class="my-input" id="experience" v-model="descriptionForm.experience">
                <label for="CV" class="my-label">Please upload your CV</label>
                <input
                    type="file"
                    class="relative m-0 block w-full min-w-0 flex-auto cursor-pointer rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-xs font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-300 dark:focus:border-primary"
                    id="CV"
                    @change="addCvToForm"
                >
                <label for="CoverLettter" class="my-label">Cover letter(optional)</label>
                <input
                    type="file"
                    class="relative m-0 block w-full min-w-0 flex-auto cursor-pointer rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-xs font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-300 dark:focus:border-primary"
                    id="CoverLetter"
                    @change="addCoverLetterToForm"
                >
                <label for="about" class="my-label">Tell us about yourself</label>
                <textarea name="" id="about" cols="30" rows="10" v-model="descriptionForm.about"
                          class="my-input"></textarea>


                <button class="my-button">
                    Submit
                </button>

            </div>
        </form>
    </div>
</template>
<script setup>

import {useForm} from "@inertiajs/vue3";
import {ref} from "vue";

const selectedImage = ref(null)
const props = defineProps({
    description: Object,
    image: String,
    cv: String,
    coverLetter: String

})
const descriptionForm = useForm({
    profile_image: props.image ?? '',
    experience: props.description ? props.description.experience : '',
    education: props.description ? props.description.education : '',
    cv: props.cv ?? '',
    coverLetter: props.coverLetter ?? '',
    about: props.description ? props.description.about_me : null,
})


const handleFileChange = (event) => {
    const selectedFile = event.target.files[0]
    if (selectedFile) {
        selectedImage.value = URL.createObjectURL(selectedFile)
        descriptionForm.profile_image = selectedFile
    }
}

const addCvToForm = (event) => {
    const CV = event.target.files[0]
    if (CV) {
        descriptionForm.cv = CV
    }
}
const addCoverLetterToForm = (event) => {
    const coverLetter = event.target.files[0]
    if (coverLetter) {
        descriptionForm.coverLetter = coverLetter
    }
}
const submitUserDescription = () => descriptionForm.post(route('description.store'))
</script>
