import axios from 'axios';
import app from './app'; // import the instance

const instance = axios.create({
    baseURL: '/api'
});

instance.interceptors.request.use(config => {
    app.$Progress.start(); // for every request start the progress
    return config;
});

instance.interceptors.response.use(response => {
    app.$Progress.finish(); // finish when a response is received
    return response;
});

export default instance; // export axios instance to be imported in your app