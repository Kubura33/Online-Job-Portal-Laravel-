import './bootstrap';
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import MainLayout from './Layouts/MainLayout.vue'
import {ZiggyVue} from 'ziggy'
import ResizeTextarea from 'resize-textarea-vue3'
import '../css/app.css'
import { VuePDF} from '@tato30/vue-pdf'
import '@tato30/vue-pdf/style.css'
createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        const page = pages[`./Pages/${name}.vue`]
        page.default.layout = page.default.layout || MainLayout
        return page
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(ResizeTextarea)
            .use(VuePDF)
            .mount(el)
    },
})
