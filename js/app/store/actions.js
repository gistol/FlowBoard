import api from './axios';
import * as types from './mutationConsts';

export default {

    [types.GET_PROJECTS] (context) {

        api(context.state.token).get('/' + context.state.org + '/projects').then((res) => {

            context.commit(types.SAVE_PROJECTS, res.data.data);

        }).catch((res) => {
            console.log(res);
        });

    },

    [types.GET_PROJECT] (context, project) {

        api(context.state.token).get('/' + context.state.org + '/project/' + project).then((res) => {

            context.commit(types.SAVE_PROJECT, res.data.data);

        }).catch((res) => {
            console.log(res);
        });

    }

}