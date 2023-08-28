export const options = (headers = {}, configs = {}) => {
    const token = localStorage.getItem('token-auth');
    return {
        headers: {
            Authorization: `Bearer ${token}`,
            ...headers
        },
        ...configs
    };
};
