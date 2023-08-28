import api from './_config';

export default {

    async verifyLogin() {
        const token = localStorage.getItem('token-auth');
        if (!token) {
            window.location.href = '/login';
        }
    },

    async getStats(id) {
        return (await api().get(`/users/${id}/stats`)).data;
    },

    async redirectToLogin(provider) {
        window.location.href = (await api().get(`/login/${provider}`)).data;
    },

    async getToken(userId) {
        const token = (await api().post(`/login/get-token`, {userId: userId})).data;
        console.log('token', token);
        localStorage.setItem('token-auth', token);
        window.location.href = '/';
    },

};
