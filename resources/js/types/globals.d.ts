import type { route as routeFn } from 'ziggy-js';

declare global {
    const route: typeof routeFn;
    // added window
    interface Window {
        axios: AxiosInstance;
    }
}

