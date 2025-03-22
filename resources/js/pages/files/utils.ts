export const http = window.axios;

export const fetchFiles = async (path?: string) => {
    return http.get(`/files`, {
        params: {
            path
        }
    });
};

export const fetchFileContent = async (path: string) => {
    return http.post(`/files/content`, {
        path
    });
};

