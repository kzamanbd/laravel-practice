<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('upload.base64') }}" method="post" enctype="multipart/form-data"
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @csrf
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                    {{ csrf_token() }}
                    <div>
                        <input type="file" name="file" id="file">
                        <input type="submit" value="Upload" class="border p-2 cursor-pointer">
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
