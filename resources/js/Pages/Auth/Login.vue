<template>
    <div class="relative mb-12">
        <div class="w-full flex items-center justify-center align-middle h-full">
            <form @submit.prevent="login" class="mx-auto grid gap-2 mt-40 max-xl:w-3/6 w-2/6">


                <label class="my-label" for="email">E-mail</label>
                <input class="my-input" v-model="form.email" type="email" name="email" id="email">
                <div class="input-error" v-if="form.errors.email">
                    {{ form.errors.email }}
                </div>

                <label class="my-label" for="password">Password</label>
                <input class="my-input" type="password" name="password" v-model="form.password" id="password">
                <div class="input-error" v-if="form.errors.password">
                    {{ form.errors.password }}
                </div>

                <button
                    type="submit"
                    class="px-4 py-2  bg-blue-600 rounded-md text-white outline-none focus:ring-4 shadow-lg transform active:scale-x-75 transition-transform mx-5 flex mt-6 h-10"
                >


                    <span class="mx-auto">Login</span>
                </button>
                <div class="flex items-center justify-center mt-4"><span class="hover:cursor-pointer" @click="click">Forgot your password?</span></div>
            </form>
        </div>
        <div v-show="isClicked" class="w-full h-full z-20 absolute top-0 left-0 bg-gray-200 flex items-center justify-center backdrop-blur-2xl">
            <form action="" class="flex flex-col gap-2 w-96 text-center">
                <label for="resetemail" class="my-label">Input your email, so we could reset your passsword</label>
                <input type="email" id="resetemail" class="my-input">
                <button class="my-button"><span class="mx-auto">Reset password</span></button>
                <div class="flex items-center justify-center mt-4"><span class="hover:cursor-pointer" @click="click">Cancel</span></div>

            </form>
        </div>
    </div>
</template>
<script setup>
import {useForm} from "@inertiajs/vue3";
import {ref} from "vue";

const isClicked = ref(false);
const click = () => {
    isClicked.value = !isClicked.value;
}
const form = useForm({
    email: null,
    password: null,
})
const login = () => form.post(route('login.store'))
</script>
