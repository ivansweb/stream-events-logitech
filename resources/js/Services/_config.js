import axios from 'axios';

const baseURL = process.env.APP_URL + '/api';
const token = localStorage.getItem('token-auth');

export default () => axios.create({
    baseURL: baseURL,
    withCredentials : true,
    headers         : {
        "Accept"                       : 'application/json',
        'Content-Type'                 : 'application/json',
        "Access-Control-Allow-Origin"  : "*",
        "Access-Control-Allow-Methods" : "GET, POST, PUT, DELETE",
        "Authorization" : `Bearer ${token}`
    }
});
