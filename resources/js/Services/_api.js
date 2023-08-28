import axios from 'axios';

const baseURL = process.env.APP_URL + '/api';

export const api = () => axios.create({
    baseURL: baseURL,
    withCredentials : true,
    headers         : {
        "Accept"                       : 'application/json',
        'Content-Type'                 : 'application/json',
        "Access-Control-Allow-Origin"  : "*",
        "Access-Control-Allow-Methods" : "GET, POST, PUT"
    }
});
