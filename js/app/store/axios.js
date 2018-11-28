import axios from 'axios';

let version = 'v1';

export default (token) => axios.create({
    baseURL: (
        //eslint-disable-next-line no-undef
        process.env.NODE_ENV === 'production' ?
            'https://api.flowboard.app/' + version :
            'http://api.flowboard.local/' + version
    ),
    headers: {
        'Authentication': token
    }
});