<div>
    <x-slot name="title">Posts</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
            <form wire:submit="postAction"
                class="p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg space-y-4">
                <livewire:tiptap-editor wire:model="content" />
                <x-primary-button type="submit">
                    Save & Publish
                </x-primary-button>
            </form>
        </div>
        <x-slot name="head">
            <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet" />
        </x-slot>
    </div>
</div>
