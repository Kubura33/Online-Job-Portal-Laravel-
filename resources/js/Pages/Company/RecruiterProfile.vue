<template>
    <div class="flex flex-col gap-28">
        <div class="">
            <div class="w-full flex flex-col gap-4 font-medium text-xl">
                <div class="flex flex-row">
                    <div class="w-full flex flex-col gap-4 font-medium text-xl">
                        <span>Recruiter name: {{ user.name }}</span>

                        <span>Company name: {{ user.employer.name }}</span>
                        <span>Company e-mail: {{ user.employer.email }}</span>
                        <span>City: {{ user.employer.city }}</span>
                        <span>Address: {{ user.employer.address }}</span>
                        <span>Phone: {{ user.employer.phone }}</span>
                    </div>
                    <div>
                        <div class="mt-10 w-52 h-36 border rounded-md">
                            <img :src="user.employerImage" class=" w-full h-36 object-contain" >
                        </div>


                        <span class="text-sm text-center">This picture will show on your job ads
                            <br>

                            <Link
                                :href="route('company.edit', {employer: user.employer})"
                            class="hover:cursor-pointer underline text-emerald-600" >Edit company profile</Link>
                        </span>

                    </div>
                </div>
                <!--                <Link class="text-teal-600 underline">Edit company profile</Link>-->
                <div>
                    <h1 class="text-center font-medium text-2xl text-blue-700">Description</h1>
                    <div class="border rounded-xl border-gray-500 bg-gray-200 dark:bg-gray-700 mt-6 p-10 whitespace-break-spaces">
                        {{ user.employer.description }}
                    </div>
                </div>
            </div>

        </div>
        <div class="flex flex-col gap-8">
            <div>
                <h1 class="text-center text-2xl font-medium">Jobs posted({{ jobs.length }}) : </h1>
                <Link :href="route('jobs.create')" class="my-button w-32">Add a job</Link>
            </div>

            <div class="grid grid-cols-1 gap-4  md:grid-cols-3">
                <div v-for="job in jobs" :key="job.id"
                     class="p-6 border rounded-xl bg-blue-100 text-center items-center">
                    <div><span class="text-2xl font-medium">{{ job.title }}</span></div>
                    <div><span class="text-orange-500 font-medium"> {{ job.location }}</span></div>
                    <div><span class="font-medium text-emerald-600">Posted: {{ formatDate(job.created_at) }}</span>
                        <span class="font-bold text-lg">  || </span> <span
                            class="font-medium text-red-600">End date: {{ job.end_of_job_ad }}</span></div>
                    <div>Applied: 0</div>
                    <div class="flex justify-between mt-4">
                        <Link :href="route('jobs.show', {job: job.id})" class="border rounded-md border-stone-700 p-2 bg-purple-500 font-medium">View job</Link>
                        <Link @click="danger" :href="route('jobs.destroy', {job: job.id})" method="delete" as="button" class="delete-button">Delete job</Link>
                    </div>
                </div>
            </div>
        </div>
    </div>



</template>
<script setup>
import {Link, useForm, usePage} from "@inertiajs/vue3";
import {computed, ref, defineProps} from "vue";
import moment from 'moment'

const page = usePage()
const user = computed(() => page.props.user)
const formatDate = (date) => {
    if (date) {
        return moment(String(date)).format('YYYY-MM-DD')
    }
}
const props = defineProps({
    jobs: Array
})
const danger = () => { confirm("Are you sure you want to delete this job?")}
</script>
