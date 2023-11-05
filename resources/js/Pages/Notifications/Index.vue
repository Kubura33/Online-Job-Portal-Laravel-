<template>
    <div class=" w-full  flex items-center justify-center mt-6" >
        <div class="w-2/3 flex flex-col gap-2">
            <div v-for="notification in notifications" :key="notification.id" :class="[
        'p-4 border rounded-md flex flex-col',
        notification.read_at ? 'opacity-70' : ''
      ]">
                <div class="flex justify-between">
                    <div v-if="user.role===1">
                        User
                        <Link :href="route('user.info', {user: notification.data.user.id})">
                            {{ notification.data.user.name }} {{ notification.data.user.lastname }}
                        </Link>
                        has applied for your job
                        <Link :href="route('jobs.show', {job: notification.data.job_ad})">
                            {{ notification.data.job_ad.title }}
                        </Link>

                    </div>
                    <div v-else-if="user.role===0">
                        {{notification}}
                        Your application for {{notification.data.job_ad.title}} has been <span v-if="notification.data.response===0">accepted</span>
                        <span v-else-if="notification.response===1">denied</span>
                    </div>
                    <Link v-if="!notification.read_at" class="opacity-80"
                          :href="route('notifications.update', {id: notification.id})" method="PUT" as="button"> Mark as
                        read
                    </Link>
                </div>


            </div>
        </div>
    </div>
</template>
<script setup>
import {defineProps} from 'vue'
import {Link, usePage} from "@inertiajs/vue3";

const page = usePage()
const user = page.props.user
const props = defineProps({
    notifications: Object,
})
console.log(props.notifications)
</script>
