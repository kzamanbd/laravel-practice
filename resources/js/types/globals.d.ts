import type { AxiosInstance } from 'axios';

declare global {
    // added window
    interface Window {
        axios: AxiosInstance;
    }
}
