<div>
    <x-slot name="title">Job Batching</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Job Batching') }}
        </h2>
    </x-slot>


    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
            <div class="p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg space-y-4">
                <x-primary-button type="button" wire:click="downloadContacts">
                    <span wire:loading.remove wire:target="downloadContacts">Download</span>
                    <span wire:loading wire:target="downloadContacts">Downloading...</span>
                </x-primary-button>

                <form wire:submit="submitBatching" enctype="multipart/form-data">
                    <div class="text-gray-900 dark:text-gray-100" x-data="{ uploading: false, progress: 0 }"
                        x-on:livewire-upload-start="uploading = true"
                        x-on:livewire-upload-finish="uploading = false; progress = 0;"
                        x-on:livewire-upload-progress="progress = $event.detail.progress">

                        <div class="flex items-center justify-center w-full" wire:loading.attr="disabled">
                            <label for="dropzone-file"
                                class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                            class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF
                                    </p>
                                </div>
                                <input id="dropzone-file" type="file" class="hidden" wire:model="file" />
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('file')" />

                        <div x-show="uploading" class="w-full bg-gray-200 rounded-full dark:bg-gray-700 mb-4">
                            <div class="bg-primary-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                                :style="`width: ${progress}%`" x-text="progress + '%'"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
