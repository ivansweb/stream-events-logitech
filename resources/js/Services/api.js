import { options } from './_config';
import { api } from './_api';

export default {

    async verifyLogin() {
        const token = localStorage.getItem('token-auth');
        if (!token) {
            window.location.href = '/login';
        }
    },

    async getStats(id) {
        return (await api().get(`/users/${id}/stats`, options())).data;
    },

    async redirectToLogin(provider) {
        window.location.href = (await api().get(`/login/${provider}`)).data;
    },

    async getToken(userId) {
        const response = (await api().post(`/login/get-token`, {userId: userId})).data;

        localStorage.setItem('userId', response.userId);
        localStorage.setItem('token-auth', response.token);

        window.location.href = '/';
    },

};
