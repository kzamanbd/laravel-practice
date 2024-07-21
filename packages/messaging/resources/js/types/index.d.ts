export interface User {
    id: number;
    name: string;
    email: string;
    avatar_path: string;
    email_verified_at: string;
    created_at: string;
    active: boolean;
}

export type Message = {
    id: number;
    user_id: number;
    user: User;
    message: string;
    msg_group: string;
    formatted_time: string;
    created_at: string;
};

export type Conversation = {
    id: number;
    uuid: string;
    participant: User;
    msg_preview: string;
    last_msg_at: string;
    messages: Message[];
    is_active: boolean;
};
