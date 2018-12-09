import api from './axios';
import mutations from '../consts/mutationConsts';

export default {

    [mutations.GET_PROJECTS] (context) {

        api(context.state.token).get('/' + context.state.org + '/projects').then((res) => {

            context.commit(mutations.SAVE_PROJECTS, res.data.data);

        }).catch((res) => {
            console.log(res);
        });

    },

    [mutations.GET_PROJECT] (context, project) {

        api(context.state.token).get('/' + context.state.org + '/' + project + '/project').then((res) => {

            context.commit(mutations.SAVE_PROJECT, res.data.data);

        }).catch((res) => {
            console.log(res);
        });

    },

    [mutations.GET_PROJECT_USERS] (context, project) {

        api(context.state.token).get('/' + context.state.org + '/' + project + '/users').then((res) => {

            context.commit(mutations.SAVE_PROJECT_USERS, res.data.data);

        }).catch((res) => {
            console.log(res);
        });

    }

}