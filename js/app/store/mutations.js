import Vue from 'vue/dist/vue.min';
import mutations from '../consts/mutationConsts';

export default {

    [mutations.SAVE_TOKEN] (state, token) {

        state.token = token;

    },

    [mutations.SAVE_PROJECTS] (state, projects) {

        Vue.set(state, 'projects', projects);

    },

    [mutations.SAVE_PROJECT] (state, project) {

        Vue.set(state, 'project', project);

    },

    [mutations.SAVE_PROJECT_USERS] (state, users) {

        Vue.set(state, 'projectUsers', users);

    },

    [mutations.SAVE_CREATED_ISSUE] (state, issue) {

        state.project.project.columns[0].issues.push(issue);

    }

}