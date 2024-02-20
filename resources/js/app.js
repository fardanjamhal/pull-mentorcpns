import jquery from 'jquery'
window.jQuery = window.jquery = jquery
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { InertiaProgress } from '@inertiajs/progress';
import moment from 'moment';
import VueApexCharts from "vue3-apexcharts";

createInertiaApp({
  resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      //set mixins
      .mixin({
        methods: {
            examTimeRangeChecker: function (start_time, end_time) {
                return new Date() >= new Date(start_time) && new Date() <= new Date(end_time)
            },

            examTimeStartChecker: function (start_time) {
                return new Date() < new Date(start_time)
            },

            examTimeEndChecker: function (end_time) {
                return new Date() > new Date(end_time)
            },
            formatDateWithTime: function (date) {
                return moment(date).format('DD MMMM YYYY H:mm:ss');
            },
            formatDate: function (date) {
                return moment(date).format('DD MMMM YYYY');
            },
            expiredPayment: function (date) {
                return new Date() >= new Date(date)
            },
        },
      })
      .use(plugin)
      .use(VueApexCharts)
      .mount(el)
  },
});

InertiaProgress.init();
