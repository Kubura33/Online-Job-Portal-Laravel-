<template>

    <div class="w-full h-full flex items-center justify-center">

        <div class="w-1/2">
            <form @submit.prevent="send" class="flex flex-col gap-2 mb-10">
                <h1 class="text-2xl font-medium text-red-600 text-center">After inviting the person to the interview,
                    the communication goes through the agreed channel</h1>
                <label for="" class="my-label">From : </label>
                <input type="text" class="my-input hover:cursor-not-allowed" v-model="form.from" disabled>
                <div class="input-error" v-if="form.errors.from">
                    {{ form.errors.from }}
                </div>
                <label for="" class="my-label">To:</label>
                <input type="text" class="my-input hover:cursor-not-allowed" disabled v-model="form.to">
                <div class="input-error" v-if="form.errors.to">
                    {{ form.errors.to }}
                </div>
                <label for="" class="my-label">Regarding the job</label>
                <input type="text" class="my-input" v-model="form.jobTitle">
                <div class="input-error" v-if="form.errors.jobTitle">
                    {{ form.errors.jobTitle }}
                </div>
                <label for="" class="my-label">Mail text</label>
                <resize-textarea v-model="form.text" class="my-input"
                                 placeholder="Please write your email text here..."></resize-textarea>
                <div class="input-error" v-if="form.errors.text">
                    {{ form.errors.text }}
                </div>
                <button class="my-button"> Submit</button>
            </form>
        </div>
    </div>
</template>
<script setup>
import {computed, defineProps} from 'vue'
import {useForm, usePage} from "@inertiajs/vue3";

const page = usePage();
const user = computed(() => page.props.user)
const props = defineProps({
    application: Object,
    candidate: Object,
    jobTitle: String,
})
const form = useForm({
    to: props.candidate.email,
    from: page.props.user.email,
    jobTitle: props.jobTitle,
    application : props.application,
    text: '',
})
const send = () => form.post(route('application.invite'));
</script>
