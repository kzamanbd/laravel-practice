<div>
    <x-slot name="title">Open AI</x-slot>

    @if (request('action'))
        <livewire:open-ai.custom-manager />
    @else
        <livewire:open-ai.ai-prompt />
    @endif

</div>
