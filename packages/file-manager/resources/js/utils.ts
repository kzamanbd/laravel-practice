import axios from 'axios';
const token = document.head.querySelector("meta[name='csrf-token']") as HTMLMetaElement;

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

export const http = axios.create({
    baseURL: '/file-manager/api'
});

export const fetchFiles = async (path?: string) => {
    return http.get(`/files`, {
        params: {
            path
        }
    });
};
