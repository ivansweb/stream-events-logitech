import axios from 'axios';

const baseURL = 'https://stream-events.ivansweb.com.br/api';

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
