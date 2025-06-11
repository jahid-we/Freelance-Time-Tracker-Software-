import { createApp, h } from 'vue';
import { createInertiaApp, router } from '@inertiajs/vue3';
import axios from 'axios';
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import NProgress from 'nprogress';
import '../css/nprogress-custom.css';

// ✅ Set token in Axios headers if exists in localStorage
const token = localStorage.getItem('auth_token');
if (token) {
  axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
    return pages[`./Pages/${name}.vue`];
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .mount(el);
  },
});

// ✅ NProgress loader
router.on('start', () => NProgress.start());
router.on('finish', () => NProgress.done());
