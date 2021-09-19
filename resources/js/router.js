import VueRouter from "vue-router";
import Vue from "vue";

import Home from './components/Home.vue'
import Update from './components/Update.vue'

Vue.use(VueRouter);

const routes = [{
        name: 'home',
        path: '/',
        component: Home
    },

    {
        name: 'update',
        path: '/update-book/:id',
        component: Update
    }
];

let router = new VueRouter({
    routes,
    mode: "history"
});

export default router;