<script setup lang="ts">
    import {
        Menu,
        MenuButton,
        MenuItems,
        MenuItem,
        Tab,
        TabGroup,
        TabList,
        TabPanels,
        TabPanel
    } from '@headlessui/vue';
    // @ts-ignore
    import ChatHeadMenu from '../components/ChatHeadMenu.vue';
    import EmptyState from '../components/EmptyState.vue';
    // @ts-ignore
    import UserProfile from '../components/UserProfile.vue';
    // @ts-ignore
    import SendMessage from '../components/SendMessage.vue';
    import Simplebar from 'simplebar-vue';
    import { groupBy } from 'lodash';
    import { ref, computed, inject } from 'vue';
    import { User, Conversation } from '../types';

    const http = inject('http') as any;
    const authUser = ref({} as User);
    const conversations = ref([] as Conversation[]);
    const users = ref([] as User[]);
    const inputMessage = ref<HTMLInputElement | null>(null);
    const selectedUser = ref<User | null>(null);
    const searchKey = ref('');
    const form = ref<{
        conversation_id: number | null;
        to_user_id: number | null;
    }>({
        conversation_id: null,
        to_user_id: null
    });
    const selectedConversation = ref(null) as any;
    const chat = ref({
        chatMenu: false,
        chatUser: false
    });

    const fetchCurrentUser = async () => {
        selectedConversation.value = null;
        try {
            const { data: response } = await http.get('/initialize');
            authUser.value = response.user;
            conversations.value = response.conversations || [];
            users.value = response.users || [];
        } catch (error) {
            console.log(error);
        }
    };

    fetchCurrentUser();

    const groupByMessages = computed(function () {
        if (selectedConversation.value?.messages?.length) {
            return groupBy(selectedConversation.value.messages, 'msg_group');
        }
        return null;
    });

    const filteredConversations = computed(() => {
        setTimeout(() => {
            const element = document.querySelector('.chat-users') as HTMLElement;
            if (element) {
                element.scrollTop = 0;
            }
        });

        return conversations.value.filter((d: Conversation) => {
            return d.participant.name.toLowerCase().includes(searchKey.value.toLowerCase());
        });
    });

    const filteredUsers = computed(() => {
        return users.value.filter((d: User) => {
            return d.name.toLowerCase().includes(searchKey.value.toLowerCase());
        });
    });

    const selectedNewUser = (user: User): void => {
        selectedUser.value = user;
        chat.value.chatUser = true;
        chat.value.chatMenu = false;
        inputMessage.value?.focus();
        form.value.to_user_id = user.id;
        form.value.conversation_id = null;
        const item = {
            participant: {
                name: user.name,
                avatar_path: user.avatar_path
            },
            last_msg_at: 'now',
            is_active: true
        } as Conversation;
        selectedConversation.value = item;
    };

    const selectedItem = async (item: Conversation) => {
        try {
            const { data: response } = await http.get(`/message?uuid=${item.uuid}`);
            selectedConversation.value = response.conversation;

            form.value.to_user_id = null;
            form.value.conversation_id = item.id;
            chat.value.chatUser = true;
            chat.value.chatMenu = false;
            scrollToBottom();
        } catch (error) {
            console.log(error);
        }
    };

    const sendMessage = async (message: string) => {
        if (!message.trim()) {
            return;
        }
        try {
            const { data: response } = await http.post('message', {
                ...form.value,
                message
            });
            console.log(response);
            if (response.conversation) {
                selectedConversation.value = response.conversation;
            } else {
                selectedConversation.value.messages.push(response.message);
            }
            scrollToBottom();
        } catch (error) {
            console.log(error);
        }
    };

    function scrollToBottom(): void {
        if (selectedConversation.value) {
            setTimeout(() => {
                const element = document.querySelector(
                    '#chat-box .simplebar-content'
                ) as HTMLElement;

                element?.scrollIntoView({
                    behavior: 'smooth',
                    block: 'end'
                });
                inputMessage.value?.focus();
            });
        }
    }

    const toggleHandler = () => {
        chat.value.chatMenu = !chat.value.chatMenu;
    };
</script>

<template>
    <div class="chat-wrapper">
        <TabGroup as="div" class="card chat-sidebar" :class="chat.chatMenu && '!block'">
            <UserProfile :auth-user="authUser" />

            <div class="relative">
                <input
                    type="search"
                    class="peer form-input pr-9"
                    placeholder="Searching..."
                    v-model="searchKey" />
                <div class="absolute right-2 top-1/2 -translate-y-1/2 peer-focus:text-primary">
                    <svg
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <circle
                            cx="11.5"
                            cy="11.5"
                            r="9.5"
                            stroke="currentColor"
                            stroke-width="1.5"
                            opacity="0.5"></circle>
                        <path
                            d="M18.5 18.5L22 22"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"></path>
                    </svg>
                </div>
            </div>

            <TabList class="flex items-center justify-between text-xs">
                <Tab
                    type="button"
                    class="hover:text-primary focus-visible:outline-none"
                    @click="fetchCurrentUser">
                    <svg
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        class="mx-auto mb-1 h-5 w-5">
                        <path
                            opacity="0.5"
                            d="M13.0867 21.3877L13.7321 21.7697L13.0867 21.3877ZM13.6288 20.4718L12.9833 20.0898L13.6288 20.4718ZM10.3712 20.4718L9.72579 20.8539H9.72579L10.3712 20.4718ZM10.9133 21.3877L11.5587 21.0057L10.9133 21.3877ZM13.5 2.75C13.9142 2.75 14.25 2.41421 14.25 2C14.25 1.58579 13.9142 1.25 13.5 1.25V2.75ZM22.75 10.5C22.75 10.0858 22.4142 9.75 22 9.75C21.5858 9.75 21.25 10.0858 21.25 10.5H22.75ZM2.3806 15.9134L3.07351 15.6264V15.6264L2.3806 15.9134ZM7.78958 18.9915L7.77666 19.7413L7.78958 18.9915ZM5.08658 18.6194L4.79957 19.3123H4.79957L5.08658 18.6194ZM21.6194 15.9134L22.3123 16.2004V16.2004L21.6194 15.9134ZM16.2104 18.9915L16.1975 18.2416L16.2104 18.9915ZM18.9134 18.6194L19.2004 19.3123H19.2004L18.9134 18.6194ZM4.38751 2.7368L3.99563 2.09732V2.09732L4.38751 2.7368ZM2.7368 4.38751L2.09732 3.99563H2.09732L2.7368 4.38751ZM9.40279 19.2098L9.77986 18.5615L9.77986 18.5615L9.40279 19.2098ZM13.7321 21.7697L14.2742 20.8539L12.9833 20.0898L12.4412 21.0057L13.7321 21.7697ZM9.72579 20.8539L10.2679 21.7697L11.5587 21.0057L11.0166 20.0898L9.72579 20.8539ZM12.4412 21.0057C12.2485 21.3313 11.7515 21.3313 11.5587 21.0057L10.2679 21.7697C11.0415 23.0767 12.9585 23.0767 13.7321 21.7697L12.4412 21.0057ZM10.5 2.75H13.5V1.25H10.5V2.75ZM21.25 10.5V11.5H22.75V10.5H21.25ZM2.75 11.5V10.5H1.25V11.5H2.75ZM1.25 11.5C1.25 12.6546 1.24959 13.5581 1.29931 14.2868C1.3495 15.0223 1.45323 15.6344 1.68769 16.2004L3.07351 15.6264C2.92737 15.2736 2.84081 14.8438 2.79584 14.1847C2.75041 13.5189 2.75 12.6751 2.75 11.5H1.25ZM7.8025 18.2416C6.54706 18.2199 5.88923 18.1401 5.37359 17.9265L4.79957 19.3123C5.60454 19.6457 6.52138 19.7197 7.77666 19.7413L7.8025 18.2416ZM1.68769 16.2004C2.27128 17.6093 3.39066 18.7287 4.79957 19.3123L5.3736 17.9265C4.33223 17.4951 3.50486 16.6678 3.07351 15.6264L1.68769 16.2004ZM21.25 11.5C21.25 12.6751 21.2496 13.5189 21.2042 14.1847C21.1592 14.8438 21.0726 15.2736 20.9265 15.6264L22.3123 16.2004C22.5468 15.6344 22.6505 15.0223 22.7007 14.2868C22.7504 13.5581 22.75 12.6546 22.75 11.5H21.25ZM16.2233 19.7413C17.4786 19.7197 18.3955 19.6457 19.2004 19.3123L18.6264 17.9265C18.1108 18.1401 17.4529 18.2199 16.1975 18.2416L16.2233 19.7413ZM20.9265 15.6264C20.4951 16.6678 19.6678 17.4951 18.6264 17.9265L19.2004 19.3123C20.6093 18.7287 21.7287 17.6093 22.3123 16.2004L20.9265 15.6264ZM10.5 1.25C8.87781 1.25 7.6085 1.24921 6.59611 1.34547C5.57256 1.44279 4.73445 1.64457 3.99563 2.09732L4.77938 3.37628C5.24291 3.09223 5.82434 2.92561 6.73809 2.83873C7.663 2.75079 8.84876 2.75 10.5 2.75V1.25ZM2.75 10.5C2.75 8.84876 2.75079 7.663 2.83873 6.73809C2.92561 5.82434 3.09223 5.24291 3.37628 4.77938L2.09732 3.99563C1.64457 4.73445 1.44279 5.57256 1.34547 6.59611C1.24921 7.6085 1.25 8.87781 1.25 10.5H2.75ZM3.99563 2.09732C3.22194 2.57144 2.57144 3.22194 2.09732 3.99563L3.37628 4.77938C3.72672 4.20752 4.20752 3.72672 4.77938 3.37628L3.99563 2.09732ZM11.0166 20.0898C10.8136 19.7468 10.6354 19.4441 10.4621 19.2063C10.2795 18.9559 10.0702 18.7304 9.77986 18.5615L9.02572 19.8582C9.07313 19.8857 9.13772 19.936 9.24985 20.0898C9.37122 20.2564 9.50835 20.4865 9.72579 20.8539L11.0166 20.0898ZM7.77666 19.7413C8.21575 19.7489 8.49387 19.7545 8.70588 19.7779C8.90399 19.7999 8.98078 19.832 9.02572 19.8582L9.77986 18.5615C9.4871 18.3912 9.18246 18.3215 8.87097 18.287C8.57339 18.2541 8.21375 18.2487 7.8025 18.2416L7.77666 19.7413ZM14.2742 20.8539C14.4916 20.4865 14.6287 20.2564 14.7501 20.0898C14.8622 19.936 14.9268 19.8857 14.9742 19.8582L14.2201 18.5615C13.9298 18.7304 13.7204 18.9559 13.5379 19.2063C13.3646 19.4441 13.1864 19.7468 12.9833 20.0898L14.2742 20.8539ZM16.1975 18.2416C15.7862 18.2487 15.4266 18.2541 15.129 18.287C14.8175 18.3215 14.5129 18.3912 14.2201 18.5615L14.9742 19.8582C15.0192 19.832 15.096 19.7999 15.2941 19.7779C15.5061 19.7545 15.7842 19.7489 16.2233 19.7413L16.1975 18.2416Z"
                            fill="currentColor"></path>
                        <circle
                            cx="19"
                            cy="5"
                            r="3"
                            stroke="currentColor"
                            stroke-width="1.5"></circle>
                    </svg>
                    Chats
                </Tab>

                <Tab type="button" class="hover:text-primary focus-visible:outline-none">
                    <svg
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        class="mx-auto mb-1 h-5 w-5">
                        <path
                            d="M5.00659 6.93309C5.04956 5.7996 5.70084 4.77423 6.53785 3.93723C7.9308 2.54428 10.1532 2.73144 11.0376 4.31617L11.6866 5.4791C12.2723 6.52858 12.0372 7.90533 11.1147 8.8278M17.067 18.9934C18.2004 18.9505 19.2258 18.2992 20.0628 17.4622C21.4558 16.0692 21.2686 13.8468 19.6839 12.9624L18.5209 12.3134C17.4715 11.7277 16.0947 11.9628 15.1722 12.8853"
                            stroke="currentColor"
                            stroke-width="1.5"></path>
                        <path
                            opacity="0.5"
                            d="M5.00655 6.93311C4.93421 8.84124 5.41713 12.0817 8.6677 15.3323C11.9183 18.5829 15.1588 19.0658 17.0669 18.9935M15.1722 12.8853C15.1722 12.8853 14.0532 14.0042 12.0245 11.9755C9.99578 9.94676 11.1147 8.82782 11.1147 8.82782"
                            stroke="currentColor"
                            stroke-width="1.5"></path>
                    </svg>
                    Groups
                </Tab>

                <Tab type="button" class="hover:text-primary focus-visible:outline-none">
                    <svg
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        class="mx-auto mb-1 h-5 w-5">
                        <circle
                            cx="10"
                            cy="6"
                            r="4"
                            stroke="currentColor"
                            stroke-width="1.5"></circle>
                        <path
                            opacity="0.5"
                            d="M18 17.5C18 19.9853 18 22 10 22C2 22 2 19.9853 2 17.5C2 15.0147 5.58172 13 10 13C14.4183 13 18 15.0147 18 17.5Z"
                            stroke="currentColor"
                            stroke-width="1.5"></path>
                        <path
                            d="M21 10H19M19 10H17M19 10L19 8M19 10L19 12"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"></path>
                    </svg>
                    Contacts
                </Tab>

                <Tab type="button" class="group hover:text-primary focus-visible:outline-none">
                    <svg
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        class="mx-auto mb-1 h-5 w-5">
                        <path
                            d="M19.0001 9.7041V9C19.0001 5.13401 15.8661 2 12.0001 2C8.13407 2 5.00006 5.13401 5.00006 9V9.7041C5.00006 10.5491 4.74995 11.3752 4.28123 12.0783L3.13263 13.8012C2.08349 15.3749 2.88442 17.5139 4.70913 18.0116C9.48258 19.3134 14.5175 19.3134 19.291 18.0116C21.1157 17.5139 21.9166 15.3749 20.8675 13.8012L19.7189 12.0783C19.2502 11.3752 19.0001 10.5491 19.0001 9.7041Z"
                            stroke="currentColor"
                            stroke-width="1.5"></path>
                        <path
                            opacity="0.5"
                            d="M7.5 19C8.15503 20.7478 9.92246 22 12 22C14.0775 22 15.845 20.7478 16.5 19"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"></path>
                    </svg>
                    Notification
                </Tab>
            </TabList>

            <TabPanels>
                <div class="h-px w-full border-b border-[#e0e6ed] dark:border-[#1b2e4b]"></div>
                <TabPanel>
                    <Simplebar class="chat-users my-2">
                        <button
                            type="button"
                            v-for="item in filteredConversations"
                            :key="item.id"
                            class="chat-user-item"
                            :class="{
                                'bg-gray-100 dark:bg-[#050b14] dark:text-primary text-primary':
                                    selectedConversation?.id === item.id
                            }"
                            @click="selectedItem(item)">
                            <div class="flex-1">
                                <div class="flex items-center">
                                    <div class="relative flex-shrink-0">
                                        <img
                                            :src="item.participant.avatar_path"
                                            class="h-12 w-12 rounded-full object-cover" />

                                        <div
                                            v-if="item.is_active"
                                            class="absolute bottom-0 right-0">
                                            <div class="h-4 w-4 rounded-full bg-success"></div>
                                        </div>
                                    </div>
                                    <div class="mx-3 text-left">
                                        <p class="mb-1 font-semibold">
                                            {{ item.participant.name }}
                                        </p>
                                        <p class="text-white-dark max-w-[185px] truncate text-xs">
                                            {{ item.msg_preview }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="whitespace-nowrap text-xs font-semibold">
                                <p>{{ item.last_msg_at }}</p>
                            </div>
                        </button>
                    </Simplebar>
                </TabPanel>
                <TabPanel>Content 2</TabPanel>
                <TabPanel>
                    <Simplebar class="chat-users my-2">
                        <button
                            type="button"
                            v-for="item in filteredUsers"
                            :key="item.id"
                            class="chat-user-item"
                            :class="{
                                'bg-gray-100 dark:bg-[#050b14] dark:text-primary text-primary':
                                    selectedUser?.id === item.id
                            }"
                            @click="selectedNewUser(item)">
                            <div class="flex-1">
                                <div class="flex items-center">
                                    <div class="relative flex-shrink-0">
                                        <img
                                            :src="item.avatar_path"
                                            class="h-12 w-12 rounded-full object-cover" />

                                        <div v-if="item.active" class="absolute bottom-0 right-0">
                                            <div class="h-4 w-4 rounded-full bg-success"></div>
                                        </div>
                                    </div>
                                    <div class="mx-3 text-left">
                                        <p class="mb-1 font-semibold">{{ item.name }}</p>
                                        <p class="text-white-dark max-w-[185px] truncate text-xs">
                                            {{ item.email }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="whitespace-nowrap text-xs font-semibold">
                                <p>Yesterday 09:31 PM</p>
                            </div>
                        </button>
                    </Simplebar>
                </TabPanel>
                <TabPanel>Content 4</TabPanel>
            </TabPanels>
        </TabGroup>

        <div
            class="chat-overlay"
            :class="chat.chatMenu && '!block lg:!hidden'"
            @click="toggleHandler"></div>

        <div class="card flex-1 p-0">
            <div v-if="selectedConversation" class="relative h-full">
                <ChatHeadMenu @toggle="toggleHandler" :conversation="selectedConversation" />

                <Simplebar
                    class="relative h-full overflow-auto sm:h-[calc(100vh_-_180px)]"
                    id="chat-box">
                    <div
                        v-for="(messages, groupName) in groupByMessages"
                        :key="groupName"
                        class="chat-conversation-box">
                        <div class="m-6 mt-0 block">
                            <h4
                                class="relative border-b border-[#f4f4f4] text-center text-xs dark:border-gray-800">
                                <span class="relative top-2 bg-white px-3 dark:bg-[#0e1726]">
                                    {{ groupName }}
                                </span>
                            </h4>
                        </div>
                        <template v-for="message in messages" :key="message.id">
                            <div
                                class="flex items-start gap-3"
                                :class="{
                                    'justify-end': authUser.id === message.user_id
                                }">
                                <div
                                    class="flex-none"
                                    :class="{
                                        'order-2': authUser.id === message.user_id
                                    }">
                                    <img
                                        :src="message.user.avatar_path"
                                        class="h-10 w-10 rounded-full object-cover" />
                                </div>
                                <div class="space-y-2">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="rounded-md bg-black/10 p-4 py-2 dark:bg-gray-800"
                                            :class="
                                                authUser.id == message.user_id
                                                    ? 'rounded-br-none  !bg-primary text-white'
                                                    : 'rounded-bl-none'
                                            "
                                            v-html="message.message"></div>
                                        <div
                                            :class="{
                                                hidden: authUser.id === message.user_id
                                            }">
                                            <svg
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 hover:text-primary">
                                                <circle
                                                    opacity="0.5"
                                                    cx="12"
                                                    cy="12"
                                                    r="10"
                                                    stroke="currentColor"
                                                    stroke-width="1.5"></circle>
                                                <path
                                                    d="M9 16C9.85038 16.6303 10.8846 17 12 17C13.1154 17 14.1496 16.6303 15 16"
                                                    stroke="currentColor"
                                                    stroke-width="1.5"
                                                    stroke-linecap="round"></path>
                                                <path
                                                    d="M16 10.5C16 11.3284 15.5523 12 15 12C14.4477 12 14 11.3284 14 10.5C14 9.67157 14.4477 9 15 9C15.5523 9 16 9.67157 16 10.5Z"
                                                    fill="currentColor"></path>
                                                <ellipse
                                                    cx="9"
                                                    cy="10.5"
                                                    rx="1"
                                                    ry="1.5"
                                                    fill="currentColor"></ellipse>
                                            </svg>
                                        </div>
                                    </div>
                                    <div
                                        class="text-white-dark text-xs"
                                        :class="{
                                            'text-right ': authUser.id === message.user_id
                                        }">
                                        {{ message.formatted_time }}
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </Simplebar>

                <SendMessage ref="inputMessage" @submit="sendMessage" />
            </div>

            <EmptyState v-else @toggle="toggleHandler" />
        </div>
    </div>
</template>
