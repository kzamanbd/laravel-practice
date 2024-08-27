<div>
    <x-slot name="title">Posts</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
            <form wire:submit="postAction"
                class="p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg space-y-4">
                <textarea wire:model="content" class="w-full h-32 p-2 border border-gray-300 dark:border-gray-700 rounded-lg"
                    placeholder="What's on your mind?"></textarea>
                <x-primary-button type="submit">
                    Save & Publish
                </x-primary-button>
            </form>
        </div>

    </div>
</div>
