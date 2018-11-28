import Vue from 'vue/dist/vue.min';
import * as types from './mutationConsts';

export default {

    [types.SAVE_TOKEN] (state, token) {

        state.token = token;

    },

    [types.SAVE_PROJECTS] (state, projects) {

        Vue.set(state, 'projects', projects);

    },

    [types.SAVE_PROJECT] (state, project) {

        Vue.set(state, 'project', project);

    },

    [types.SHOW_ISSUE] (state, issue) {

        Vue.set(state, 'issue', issue);

    }

}