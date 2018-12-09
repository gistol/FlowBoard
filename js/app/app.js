//Import Vue
import Vue from 'vue/dist/vue';

//Vue Related imports
import axios from 'axios';
import VueAxios from 'vue-axios';

import VueNotifications from 'vue-notifications';

import miniToastr from 'mini-toastr';

//Get the store and mutations
import store from './store/index';

import VueRouter from 'vue-router';

import App from './App.vue';

import routes from './routes';

import mutations from './consts/mutationConsts';

//eslint-disable-next-line no-undef
if (process.env.NODE_ENV === 'production') {
    Vue.config.devtools = false;
    Vue.config.debug = false;
    Vue.config.silent = true;
}
//eslint-disable-next-line no-undef
Vue.config.performance = process.env.NODE_ENV !== 'production';

// We shall setup types of the messages. ('error' type - red and 'success' - green in mini-toastr)
const toastTypes = {
    success: 'success',
    error: 'error',
    info: 'info',
    warn: 'warn'
};

// This step requires only for mini-toastr, just an initialization
miniToastr.init({
    types: toastTypes
});

miniToastr.setIcon('error', 'i', {'class': 'fa fa-fw fa-times'});
miniToastr.setIcon('info', 'i', {'class': 'fa fa-fw fa-info-circle'});
miniToastr.setIcon('success', 'i', {'class': 'fa fa-fw fa-check'});

// Here we are seting up messages output to `mini-toastr`
// This mean that in case of 'success' message we will call miniToastr.success(message, title, timeout, cb)
// In case of 'error' we will call miniToastr.error(message, title, timeout, cb)
// and etc.
function toast ({title, message, type, timeout, cb}) {
    return miniToastr[type](message, title, timeout, cb);
}

// Here we map vue-notifications method to function abowe (to mini-toastr)
// By default vue-notifications can have 4 methods: 'success', 'error', 'info' and 'warn'
// But you can specify whatever methods you want.
// If you won't specify some method here, output would be sent to the browser's console
const options = {
    success: toast,
    error: toast,
    info: toast,
    warn: toast
};

const router = new VueRouter({
    routes // short for `routes: routes`
});

// Activate plugin
// VueNotifications have auto install but if we want to specify options we've got to do it manually.
Vue.use(VueNotifications, options);

Vue.use(VueAxios, axios);

Vue.use(VueRouter);

let token = document.getElementById('token').getAttribute('content');

new Vue({
    el: '#app',
    store,
    router,
    components: {
        App
    },
    created () {
        this.$store.commit(mutations.SAVE_TOKEN, token)
    },
    template: '<App />'
});