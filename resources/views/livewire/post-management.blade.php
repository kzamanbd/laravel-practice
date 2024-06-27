<div>
    <x-slot name="title">Posts</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
            <div class="p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg space-y-4">
                <textarea rows="5" id="editor" class="form-control" wire:ignore></textarea>
            </div>
        </div>
    </div>

    <x-slot name="head">
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
    </x-slot>
    <x-slot name="script">
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
        <script>
          const quill = new Quill('#editor', {
            theme: 'snow'
          });
        </script>
    </x-slot>
</div>
