<template>
    <div class="w-full flex items-center justify-center align-middle">
        <form @submit.prevent="register" class="mx-auto grid  gap-2 max-xl:w-3/6 w-2/6">
            <span class="text-2xl font-bold text-center mb-6 mt-6">Registration form </span >
            <div class="flex items-center justify-between font-bold text-sm">
                <div class="flex gap-2 items-center">
                    <label for="applicant">Applicant: </label>
                    <input type="radio" value="0" name="role" id="applicant" checked v-model="form.role">
                </div>
                <div class="flex gap-2 items-center">
                    <label for="recruiter">Recruiter:</label>
                    <input type="radio" name="role" id="recruiter" v-model="form.role" value="1">
                </div>
            </div>
            <label class="my-label" for="name">Name</label>
            <input v-model="form.name" class="my-input" type="text" name="name" id="name">
            <div class="input-error" v-if="form.errors.name">
                {{ form.errors.name }}
            </div>
            <label class="my-label" for="lastname">Lastname</label>
            <input v-model="form.lastname" class="my-input" type="text" id="lastname" name="lastname">
            <div class="input-error" v-if="form.errors.lastname">
                {{ form.errors.lastname }}
            </div>
            <label class="my-label" for="email">E-mail</label>
            <input class="my-input" v-model="form.email" type="email" name="email" id="email">
            <div class="input-error" v-if="form.errors.email">
                {{ form.errors.email }}
            </div>
            <label class="my-label" for="phone">Phone number</label>
            <input class="my-input" type="text" v-model="form.phone" id="phone">
            <div class="input-error" v-if="form.errors.phone">
                {{ form.errors.phone }}
            </div>
            <label class="my-label" for="password">Password</label>
            <input class="my-input" type="password" name="password" v-model="form.password" id="password">
            <div class="input-error" v-if="form.errors.password">
                {{ form.errors.password }}
            </div>
            <label class="my-label" for="password_confirmation">Confirm password</label>
            <input class="my-input" type="password" name="password_confirmation" id="password_confirmation"
                   v-model="form.password_confirmation">
            <button
                type="submit"
                class="px-4 py-2  bg-blue-600 rounded-md text-white outline-none focus:ring-4 shadow-lg transform active:scale-x-75 transition-transform mx-5 flex mt-6 h-10"
            >


                <span class="mx-auto">Register</span>
            </button>
        </form>

    </div>
</template>
<script setup>
import {useForm} from "@inertiajs/vue3";
import {Link} from "@inertiajs/vue3";

const form = useForm({
    name: null,
    lastname: null,
    email: null,
    phone: null,
    password: null,
    password_confirmation: null,
    role: null,

})
const register = () => form.post(route('register.store'))
</script>
