<div>
    <x-slot name="title">Open AI</x-slot>

    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Open AI
            </h2>
            <x-primary-button class="!p-0">
                @if ($customData)
                    <a class="px-4 py-2" href="{{ route('open-ai') }}" wire:navigate>
                        Chat With LLM
                    </a>
                @else
                    <a class="px-4 py-2" href="{{ route('open-ai', ['action' => 'custom']) }}" wire:navigate>
                        Custom Data
                    </a>
                @endif
            </x-primary-button>
        </div>
    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
            @if ($customData)
                <livewire:open-ai.custom-manager />
            @else
                <livewire:open-ai.chat-bot />
            @endif
        </div>
    </div>


</div>
