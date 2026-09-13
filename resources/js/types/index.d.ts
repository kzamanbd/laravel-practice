import type { PageProps } from '@inertiajs/core';

export interface Auth {
    user: User;
}

export interface SharedData extends PageProps {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface IFile {
    name: string;
    type: string;
    path: string;
    size: number;
    checked: boolean;
    modified_at: string;
    expanded: boolean;
    children: IFile[];
}
