<template>
    <div>
        <h1 v-if="!user.employer.name" class="text-red-500 mt-8 font-medium text-2xl text-center">Before adding any jobs, you need to input
            information about your company</h1>
        <div class="flex items-center justify-center p-8">
            <form @submit.prevent="done" class="mt-10 w-3/5">
                <div class="flex flex-col gap-4">


                    <label class="my-label" for="company_name">Company name:</label>
                    <input v-model="form.company_name" class="my-input" type="text" id="company_name">
                    <div class="input-error" v-if="form.errors.company_name">
                        {{ form.errors.company_name }}
                    </div>
                    <label class="my-label" for="city">City</label>
                    <input class="my-input" type="text" v-model="form.city" id="city">
                    <div class="input-error" v-if="form.errors.city">
                        {{ form.errors.city }}
                    </div>
                    <label class="my-label" for="address">Address</label>
                    <input class="my-input" type="text" id="address" v-model="form.address">
                    <div class="input-error" v-if="form.errors.address">
                        {{ form.errors.address }}
                    </div>
                    <label class="my-label" for="email">E-mail</label>
                    <input class="my-input" type="text" id="email" v-model="form.email">
                    <div class="input-error" v-if="form.errors.email">
                        {{ form.errors.email }}
                    </div>
                    <label class="my-label" for="phone">Phone</label>

                    <input class="my-input" type="text" id="phone" v-model="form.phone">
                    <div class="input-error" v-if="form.errors.phone">
                        {{ form.errors.phone }}
                    </div>
                    <label class="my-label" for="desc">Company description</label>

                    <resize-textarea class="my-input" v-model="form.company_desc">

                    </resize-textarea>
                    <div class="input-error" v-if="form.errors.name">
                        {{ form.errors.company_desc }}
                    </div>
                    <div >
                        <input type="file" @change="handleFileChange">
                        <img :src="selectedImage ? selectedImage : user.employerImage" alt="" class="w-40 h-36 mt-4">
                    </div>
                    <div class="input-error" v-if="form.errors.image">
                        {{ form.errors.image }}
                    </div>
                    <div class="w-full flex items-center justify-center">
                        <button class="my-button w-64 " type="submit">
                            Done
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</template>
<script setup>
import {useForm, usePage} from "@inertiajs/vue3";
import {computed, ref, toRefs, defineProps} from "vue";
const page = usePage()
const props = defineProps({
    company : Object
})
console.log(props.company)
const user = computed(() => page.props.user)
const form = useForm({
    company_name: props.company.name,
    city: props.company.city,
    address: props.company.address,
    email: props.company.email,
    phone: props.company.phone,
    company_desc: props.company.description,
    image: props.company.image,
})
const selectedImage = ref(null);
const myTextarea = ref(null)
const done = () => form.post(route('company.update'))

const handleFileChange = (event) => {
    const selectedFile = event.target.files[0]
    if (selectedFile) {
        selectedImage.value = URL.createObjectURL(selectedFile)
        form.image=selectedFile
    }

}
</script>
