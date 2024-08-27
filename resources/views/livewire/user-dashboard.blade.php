<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
            <div class="p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg space-y-4">
                {{ __("You're logged in!") }}
                {{ csrf_token() }}

                <form action="{{ route('upload.base64') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class=" text-gray-900 dark:text-gray-100">
                        <div>
                            <h1>Store Blob File</h1>
                            <input type="file" name="file" id="file">
                            <x-primary-button class="ml-4">
                                {{ __('Upload') }}
                            </x-primary-button>
                        </div>
                        <x-input-error :messages="$errors->get('file')" />
                    </div>
                </form>

                <x-primary-button wire:click="uploadExcel">
                    Upload Excel With Formula
                </x-primary-button>
                <x-primary-button wire:click="connectReverb">
                    Connect Reverb
                </x-primary-button>
            </div>
        </div>
    </div>
</div>
