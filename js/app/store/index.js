import Vuex from 'vuex'
import Vue from 'vue/dist/vue'

import actions from './actions';
import getters from './getters';
import mutations from './mutations';

Vue.use(Vuex);

//  eslint-disable-next-line no-undef
Vue.config.performance = process.env.NODE_ENV !== 'production';
//  eslint-disable-next-line no-undef
if (process.env.NODE_ENV === 'production') {
    Vue.config.devtools = false;
    Vue.config.debug = false;
    Vue.config.silent = true;
}

export default new Vuex.Store({
    state: {
        token: '',
        org: 'flowboard',
        project: {},
        projects: false,
        issue: false,
        projectUsers: false
    },
    mutations: mutations,
    actions: actions,
    getters: getters
});
