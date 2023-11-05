<template>
    <section class="shadow">
        <article class="border-b dark:border dark:rounded-md" v-for="(job, index) in jobsWithOpen" :key="index">
            <div class="border-l-2 border-transparent ">
                <header
                    class="flex justify-between items-center  p-5 pl-8 pr-8 cursor-pointer select-none"
                    @click="toggleAccordion(index)"
                >
                    <span>
                        Ubisoft
                    </span>
                    <span class="text-grey-darkest font-medium  text-xl ">
            {{ job.title }}
          </span>
                    <div class="w-10 h-10 ">
                        <img :src="job.imagePath" class="w-10 h-10" alt="">
                    </div>

                </header>
            </div>
            <div v-if="job.open" class="p-5 ">
                <div class="mb-4">
                    <h3 class="text-3xl font-medium text-center mb-4">Description</h3>
                    <p>{{ job.description }}</p>
                </div>
                <div>

                </div>
                <div>
                    <h3 class="text-3xl font-medium text-center mb-4">Requierements</h3>
                    <p>{{ job.requirements }}</p>
                </div>
                <div class="flex items-center justify-center p-4 mt-4">

                        <Link :href="route('jobs.apply', {job: job})" class="border rounded-md p-2 bg-sky-400 " method="POST" as="button">Apply for job</Link>


                </div>

            </div>
        </article>

    </section>
    <div v-if="jobs.data.length" class="w-full flex justify-center mt-4 mb-4">
        <Pagination :links="jobs.links"/>

    </div>
</template>

<script setup>
import {ref, defineProps, onMounted} from "vue";
import {Link} from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    jobs: Object
})
const jobsWithOpen = ref([])
onMounted(() => {
    jobsWithOpen.value = props.jobs.data.map(job => ({...job, open: false}))
})
const toggleAccordion = (index) => {
    jobsWithOpen.value[index].open = !jobsWithOpen.value[index].open
};
</script>

