import '../css/app.css';
import '../css/landingpage.css';
import '../css/custom.css';
import '../css/loginlanding.css';

// Limitless CSS
import '../../public/assets/css/bootstrap.css';
import '../../public/assets/css/core.css';
import '../../public/assets/css/components.css';
import '../../public/assets/css/colors.css';
import '../../public/assets/css/icons/icomoon/styles.css';

// Limitless JS
import '../../public/assets/js/core/libraries/jquery.min.js';
import '../../public/assets/js/core/libraries/bootstrap.min.js';
import '../../public/assets/js/plugins/loaders/blockui.min.js';
import '../../public/assets/js/core/app.js';

// Vue + Inertia
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import type { DefineComponent } from 'vue';

// Layouts
import AdminLayout from '@/layouts/Layout.vue';
import PublicLayout from '@/layouts/PublicLayout.vue';

// Vue Select styles
import "vue3-select-component/styles";

// Vue Toastify styles
import 'vue3-toastify/dist/index.css';

const appName = import.meta.env.VITE_APP_NAME || 'SIP Posyandu';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),

    resolve: (name) => {
        const pages = import.meta.glob<DefineComponent>('./pages/**/*.vue');

        const page = resolvePageComponent(
            `./pages/${name}.vue`,
            pages
        );

        page.then((module) => {
            const lower = name.toLowerCase();

            const publicPages = [
                'welcome',
                'auth/login',
                'auth/loginlanding'
            ];

            if (publicPages.includes(lower)) {
                module.default.layout = PublicLayout;
            } else {
                module.default.layout = AdminLayout;
            }
        });

        return page;
    },

    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
});