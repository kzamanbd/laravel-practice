<div class="relative h-[calc(100vh_-_70px)] overflow-y-auto bg-white mx-auto max-w-7xl sm:px-6 lg:px-8 flex flex-col">
    <div class="w-full px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <!-- Title -->
        <div class="text-center">
            <div class="mb-4 flex justify-center items-center">
                <!-- Logo -->
                <a class="flex rounded-md text-xl items-center gap-4 font-semibold focus:outline-none focus:opacity-80"
                    href="/">
                    <span> Open AI</span>
                </a>
                <!-- End Logo -->

                <div class="ms-2">
                    <!-- Templates Dropdown -->
                    <div class="hs-dropdown relative  [--auto-close:inside] inline-flex">
                        <button id="hs-dropdown-preview-navbar" type="button"
                            class="hs-dropdown-toggle  group relative flex justify-center items-center size-8 text-xs rounded-full text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 disabled:opacity-50 disabled:pointer-events-none focus:outline-none">
                            <span class="">
                                <svg class=" size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </span>

                            <span class="absolute -top-0.5 -end-0.5">
                                <span class="relative flex">
                                    <span
                                        class="animate-ping absolute inline-flex size-full rounded-full bg-red-400 dark:bg-red-600 opacity-75"></span>
                                    <span class="relative inline-flex size-2 bg-red-500 rounded-full"></span>
                                    <span class="sr-only">Notification</span>
                                </span>
                            </span>
                        </button>
                    </div>
                    <!-- End Templates Dropdown -->
                </div>
            </div>

            <h1 class="text-3xl font-bold text-gray-800 sm:text-4xl dark:text-white">
                Welcome to Open AI, {{ auth()->user()->name }}!
            </h1>
            <p class="mt-3 text-gray-600 dark:text-neutral-400">
                Your AI-powered copilot for the web, <a class="underline text-primary"
                    href="{{ route('open-ai', ['action' => 'custom']) }}" wire:navigate>
                    Custom Prompt
                </a>
            </p>
        </div>
        <!-- End Title -->

        <ul class="mt-16 space-y-5">
            @foreach ($messages as $key => $message)
                @if ($message['role'] == 'assistant')
                    <livewire:open-ai.replay-message :messages="$messages" :key="$key" :prompt="$messages[$key - 1]" />
                @endif

                @if ($message['role'] == 'user')
                    <livewire:open-ai.own-message :message="$message" :key="$key" />
                @endif
            @endforeach
        </ul>
    </div>

    <div
        class="w-full mx-auto mt-auto sticky bottom-0 z-10 bg-white border-t border-gray-200 pt-2 pb-4 sm:pt-4 sm:pb-6 px-4 sm:px-6 lg:px-0 dark:bg-neutral-900 dark:border-neutral-700">
        <!-- Textarea -->
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-0">
            <div class="flex justify-between items-center mb-3">
                <button type="button"
                    class="inline-flex justify-center items-center gap-x-2 rounded-lg font-medium text-gray-800 hover:text-primary-600 focus:outline-none focus:text-primary-600 text-xs sm:text-sm dark:text-neutral-200 dark:hover:text-primary-500 dark:focus:text-primary-500">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M5 12h14" />
                        <path d="M12 5v14" />
                    </svg>
                    New chat
                </button>

                <button type="button"
                    class="py-1.5 px-2 inline-flex items-center gap-x-2 text-xs font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                    <svg class="size-3" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        viewBox="0 0 16 16">
                        <path
                            d="M5 3.5h6A1.5 1.5 0 0 1 12.5 5v6a1.5 1.5 0 0 1-1.5 1.5H5A1.5 1.5 0 0 1 3.5 11V5A1.5 1.5 0 0 1 5 3.5z" />
                    </svg>
                    Stop generating
                </button>
            </div>

            <!-- Input -->
            <form wire:submit="submit" class="relative">
                <textarea wire:model="body"
                    class="p-4 pb-12 block w-full border-gray-200 rounded-lg text-sm focus:border-primary-500 focus:ring-primary-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                    placeholder="Ask me anything..."></textarea>

                <!-- Toolbar -->
                <div class="absolute bottom-px inset-x-px p-2 rounded-b-lg bg-white dark:bg-neutral-900">
                    <div class="flex justify-between items-center">
                        <!-- Button Group -->
                        <div class="flex items-center">
                            <!-- Mic Button -->
                            <button type="button"
                                class="inline-flex shrink-0 justify-center items-center size-8 rounded-lg text-gray-500 hover:bg-gray-100 focus:z-10 focus:outline-none focus:bg-gray-100 dark:text-neutral-500 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="18" height="18" x="3" y="3" rx="2" />
                                    <line x1="9" x2="15" y1="15" y2="9" />
                                </svg>
                            </button>
                            <!-- End Mic Button -->

                            <!-- Attach Button -->
                            <button type="button"
                                class="inline-flex shrink-0 justify-center items-center size-8 rounded-lg text-gray-500 hover:bg-gray-100 focus:z-10 focus:outline-none focus:bg-gray-100 dark:text-neutral-500 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l8.57-8.57A4 4 0 1 1 18 8.84l-8.59 8.57a2 2 0 0 1-2.83-2.83l8.49-8.48" />
                                </svg>
                            </button>
                            <!-- End Attach Button -->
                        </div>
                        <!-- End Button Group -->

                        <!-- Button Group -->
                        <div class="flex items-center gap-x-1">
                            <!-- Mic Button -->
                            <button type="button"
                                class="inline-flex shrink-0 justify-center items-center size-8 rounded-lg text-gray-500 hover:bg-gray-100 focus:z-10 focus:outline-none focus:bg-gray-100 dark:text-neutral-500 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z" />
                                    <path d="M19 10v2a7 7 0 0 1-14 0v-2" />
                                    <line x1="12" x2="12" y1="19" y2="22" />
                                </svg>
                            </button>
                            <!-- End Mic Button -->

                            <!-- Send Button -->
                            <button type="submit" wire:loading.attr="disabled"
                                class="inline-flex shrink-0 justify-center items-center size-8 rounded-lg text-white bg-primary-600 hover:bg-primary-500 focus:z-10 focus:outline-none focus:bg-primary-500">
                                <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" viewBox="0 0 16 16">
                                    <path
                                        d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z" />
                                </svg>
                            </button>
                            <!-- End Send Button -->
                        </div>
                        <!-- End Button Group -->
                    </div>
                </div>
                <!-- End Toolbar -->
            </form>
            <!-- End Input -->
        </div>
        <!-- End Textarea -->
    </div>
</div>
