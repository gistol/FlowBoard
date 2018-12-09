import axios from 'axios';

let version = 'v1';

export default (token) => {

    const instance = axios.create({
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

    instance.interceptors.response.use((response) => response, (error) => {
        if (error.response.status === 401) window.location.href = 'http://authentication.flowboard.local/login';
        // Do something with response error
        return Promise.reject(error);
    });

    return instance;
}