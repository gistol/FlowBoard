import Vue from 'vue/dist/vue';
import Vuex from 'vuex';

Vue.use(Vuex);

//eslint-disable-next-line no-undef
Vue.config.performance = process.env.NODE_ENV !== 'production';
//eslint-disable-next-line no-undef
if (process.env.NODE_ENV === 'production') {
    Vue.config.devtools = false;
    Vue.config.debug = false;
    Vue.config.silent = true;
}

export default new Vuex.Store({
    modules: {}
});