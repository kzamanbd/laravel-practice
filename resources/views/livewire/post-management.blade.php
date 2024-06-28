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
                <div x-data="editor('<p>Hello world! :-)</p>')">
                    <template x-if="isLoaded()">
                        <div class="menu">
                            <button @click="toggleHeading({ level: 1 })"
                                :class="{ 'is-active': isActive('heading', { level: 1 }, updatedAt) }">
                                H1
                            </button>
                            <button @click="toggleBold()" :class="{ 'is-active': isActive('bold', updatedAt) }">
                                Bold
                            </button>
                            <button @click="toggleItalic()" :class="{ 'is-active': isActive('italic', updatedAt) }">
                                Italic
                            </button>
                        </div>
                    </template>

                    <div x-ref="element" class="form-control"></div>
                </div>
            </div>
        </div>

    </div>
</div>
