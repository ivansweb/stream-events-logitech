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

    async getEvents(id) {
        return (await api().get(`/users/${id}/events`, options())).data;
    },

    async markAs(eventId, read, eventList) {
        if(read){
            const response = await api().put(`/events/${eventId}/mark-as-unread`, {eventId: eventId}, options());
            if(response){
                eventList.forEach(element => {
                    if(element.id == eventId){
                        element.read = false;
                    }
                });
            }
        }else{
            const response = await api().put(`/events/${eventId}/mark-as-read`, {eventId: eventId}, options());
            if(response){

                eventList.forEach(element => {
                    if(element.id == eventId){
                        element.read = true;
                    }
                });
            }
        }

        return eventList;
    },

    async redirectToLogin(provider) {
        window.location.href = (await api().get(`/login/${provider}`)).data;
    },

    async logout() {
        await api().get(`/users/logout`, options());
        localStorage.removeItem('token-auth');
        window.location.href = '/';
    },

    async fillData() {

        await api().get(`/users/fill-data`, options());
        window.location.href = '/';
    },


    async getToken(userId) {
        const response = (await api().post(`/login/get-token`, {userId: userId})).data;

        localStorage.setItem('userId', response.userId);
        localStorage.setItem('userName', response.userName);
        localStorage.setItem('token-auth', response.token);

        window.location.href = '/';
    },

    getUserData() {
        return {
            'userName': localStorage.getItem('userName'),
            'userId': localStorage.getItem('userId'),
        };
    },

    async runSeeders(id) {
        return (await api().get(`/users/${id}/seeder`, options())).data;
    },

};
