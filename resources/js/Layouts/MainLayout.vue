<template>
    <div class="flex flex-col min-h-screen ">
        <header>
            <nav class="bg-white border-gray-200 px-4 lg:px-6 py-2.5 dark:bg-gray-800">
                <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">

                    <span
                        class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">Online job portal</span>

                    <div class="flex items-center lg:order-2">
                        <div v-if="!user">
                            <Link :href="route('login.create')"
                                  class="text-gray-800 dark:text-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">
                                Log in
                            </Link>
                            <Link :href="route('register.create')"
                                  class="text-gray-800 dark:text-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">
                                Register
                            </Link>
                        </div>
                        <div v-else>
                            <Link :href="route('notifications.index')" class="inline-block relative top-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                <span v-if="user.notificationCount.length"
                                      class="animate-ping absolute top-1 right-0.5 block h-1 w-1 rounded-full ring-2 ring-green-400 bg-green-600"></span>
                            </Link>
                            <Link
                                :href="user.role === 0 ? route('user.index') : route('company.profile')"
                                class="text-gray-800 dark:text-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800 hover:cursor-pointer">
                                {{ user.name }} {{ user.lastname }} {{isMenuOpen}}
                            </Link>
                            <Link :href="route('login.destroy')" as="button" method="post"
                                  class="text-gray-800 dark:text-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800 hover:cursor-pointer">
                                Logout
                            </Link>
                        </div>
                        <button
                            @click="toggleMenu"
                            :aria-expanded="isMenuOpen.toString()"
                            data-collapse-toggle="mobile-menu-2" type="button"
                            class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                            aria-controls="mobile-menu-2">
                            <span class="sr-only">Open main menu</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <ul
                            :class="isMenuOpen ? 'flex' : 'hidden'"
                            class="
                                  flex-col
                                  mt-8
                                  space-y-4
                                  md:flex md:space-y-0 md:flex-row md:items-center md:space-x-10 md:mt-0
                                "
                        >
                            <li class="text-gray-100 hover:text-indigo-400">Home</li>
                            <li class="text-gray-100 hover:text-indigo-400">About</li>
                            <li class="text-gray-100 hover:text-indigo-400">Blogs</li>
                            <li class="text-gray-100 hover:text-indigo-400">Contact Us</li>
                        </ul>
                    </div>
                    <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1"
                         id="mobile-menu-2">
                        <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                            <li>
                                <Link :href="route('jobs.index')"
                                      class="block py-2 pr-4 pl-3 text-white rounded bg-primary-700 lg:bg-transparent lg:text-primary-700 lg:p-0 dark:text-white">
                                    Home
                                </Link>
                            </li>
                            <li>
                                <Link :href="route('company.index')"
                                      class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">
                                    Company
                                </Link>
                            </li>
                            <!--                        <li>-->
                            <!--                            <Link :href="route()" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Marketplace</Link>-->
                            <!--                        </li>-->
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <div class="w-full p-2" onclick="this.remove()" v-if="success">
            <div class=" mt-2 bg-green-600 mx-12 border rounded-xl text-lg p-2 h-10 font-medium ">{{ success }}</div>
        </div>
        <div class="w-full p-2" onclick="this.remove()" v-if="error">
            <div class=" mt-2 bg-red-600 mx-12 border rounded-xl text-lg p-2 h-10 font-medium ">{{ error }}</div>
        </div>
        <main class="container mx-auto p-4 w-full bg-white flex-grow dark:bg-gray-700 text-gray-100">
            <slot>

            </slot>
        </main>
        <footer class="w-full bg-teal-100 ">
            <div class=" bg-gray-900">
                <div class="max-w-2xl mx-auto text-white py-10">
                    <div class="text-center">
                        <h3 class="text-3xl mb-3"> Mindset without discipline is useless</h3>
                        <p> Work hard. All day, every day. Good things will come </p>

                    </div>
                    <div class="mt-28 flex flex-col md:flex-row md:justify-between items-center text-sm text-gray-400">
                        <p class="order-2 md:order-1 mt-8 md:mt-0"> &copy; Beautiful Footer, 2021. </p>
                        <div class="order-1 md:order-2">
                            <span class="px-2">About us</span>
                            <span class="px-2 border-l">Contact us</span>
                            <span class="px-2 border-l">Privacy Policy</span>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>
<script setup>
import {Link, usePage} from '@inertiajs/vue3';
import {computed, ref} from 'vue';

const page = usePage();
const user = computed(() => page.props.user);
const success = computed(() => page.props.flash.success);
const error = computed(() => page.props.flash.error);

const isMenuOpen = ref(false);
const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value
}
</script>
