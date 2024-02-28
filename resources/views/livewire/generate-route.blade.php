<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Route') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form wire:submit.prevent="generateRouteList">
                <label>
                    <div>Route List</div>
                    <textarea rows="10" wire:model="content" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                </label>
                <x-primary-button type="submit">Generate</x-primary-button>
            </form>
            @isset($routes)
                <div class="space-y-4">
                    <div class="font-semibold text-lg">Generated Routes ({{ count($routes) }})</div>
                    <div class="space-y-2">
                        @foreach($routes as $route)
                            <div class="flex justify-between">
                                {{ $route }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endisset
        </div>
    </div>
</div>
