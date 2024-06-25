<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Show') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="container mx-auto flex items-start justify-center">
                    <div aria-label="group of cards" class="w-full">
                        <!-- Card is full width. Use in 12 col grid for best view. -->
                        <!-- Card code block start -->
                        <div class="flex flex-col lg:flex-row mx-auto bg-white dark:bg-gray-800 rounded shadow">
                            <div class="w-full lg:w-1/2 px-6 flex flex-col items-center py-5">
                                <div
                                    class="w-24 h-24 mb-3 p-2 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                    <img role="img" class="w-full h-full overflow-hidden object-cover rounded-full"
                                        src="https://ui-avatars.com/api/?name={{ $user->name }}&color=7F9CF5&background=EBF4FF"
                                        alt="avatar" />
                                </div>
                                <a tabindex="0"
                                    class="focus:outline-none focus:opacity-75 hover:opacity-75 text-gray-800 dark:text-gray-100 cursor-pointer focus:underline">
                                    <h2 class="text-xl tracking-normal font-medium mb-1">{{ $user->name }}
                                    </h2>
                                </a>
                                <a tabindex="0"
                                    class="items-center cursor-pointer hover:text-indigo-700 focus:underline focus:outline-none focus:text-indigo-700 flex text-gray-600 dark:text-gray-100 text-sm tracking-normal font-normal mb-3 text-center">
                                    <span class="cursor-pointer mr-1 text-gray-600 dark:text-gray-100">
                                        <span class="material-icons text-xl">email</span>
                                    </span>
                                    <span>{{ $user->email }}</span>
                                </a>
                                <p
                                    class="text-gray-600 dark:text-gray-100 text-sm tracking-normal font-normal mb-8 text-center w-10/12">
                                    The more I deal with the work as something that is my own, as something that
                                    is personal, the more successful it is.
                                </p>
                                <div class="flex items-start">
                                    <div class="">
                                        <h2
                                            class="text-gray-600 dark:text-gray-100 text-2xl leading-6 mb-2 text-center">
                                            82</h2>
                                        <a tabindex="0"
                                            class="focus:outline-none focus:underline focus:text-gray-400 text-gray-800 hover:text-gray-400 cursor-pointer">
                                            <p class="dark:text-gray-100 text-sm leading-5">Reviews</p>
                                        </a>
                                    </div>
                                    <div class="mx-6 lg:mx-3 xl:mx-6 px-8 lg:px-4 xl:px-8 border-l border-r">
                                        <h2
                                            class="text-gray-600 dark:text-gray-100 text-2xl leading-6 mb-2 text-center">
                                            28</h2>
                                        <a tabindex="0"
                                            class="focus:outline-none focus:underline focus:text-gray-400 text-gray-800 hover:text-gray-400 cursor-pointer">
                                            <p class="dark:text-gray-100 text-sm leading-5">Projects</p>
                                        </a>
                                    </div>
                                    <div class="">
                                        <h2
                                            class="text-gray-600 dark:text-gray-100 text-2xl leading-6 mb-2 text-center">
                                            42</h2>
                                        <a tabindex="0"
                                            class="focus:outline-none focus:underline focus:text-gray-400 text-gray-800 hover:text-gray-400 cursor-pointer">
                                            <p class="dark:text-gray-100 text-sm leading-5">Approved</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="w-full lg:w-1/2 px-6 border-t-0 border-b-0 lg:border-t-0 lg:border-b-0 lg:border-l lg:border-r-0 border-gray-300 flex flex-col items-center py-5">
                                <div
                                    class="mb-3 w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center cursor-pointer text-indigo-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-stack"
                                        width="48" height="48" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <polyline points="12 4 4 8 12 12 20 8 12 4" />
                                        <polyline points="4 12 12 16 20 12" />
                                        <polyline points="4 16 12 20 20 16" />
                                    </svg>
                                </div>
                                <a tabindex="0"
                                    class="cursor-pointer focus:opacity-75 focus:underline hover:opacity-75 focus:outline-none text-gray-800 dark:text-gray-100 text-xl tracking-normal text-center font-medium mb-1">
                                    Account Info
                                </a>
                                <p
                                    class="text-gray-600 dark:text-gray-100 text-sm tracking-normal font-normal mb-8 text-center w-10/12">
                                    Account create at {{ $user->created_at }} and last updated at
                                    {{ $user->updated_at }}</p>
                                <h1 tabindex="0"
                                    class="focus:outline-none text-lg font-bold text-gray-800 dark:text-gray-100 leading-5 pt-2">
                                    Current Roles</h1>
                                <h2 tabindex="0"
                                    class="focus:outline-none text-sm leading-3 text-gray-600 dark:text-gray-100 my-3">
                                    {{ $user->roles->pluck('name')->join(', ') }}</h2>
                            </div>

                        </div>
                        <div>
                            <div class="flex items-center justify-center mt-5">
                                <div class="rounded shadow py-5 px-6 w-full bg-white dark:bg-gray-800">
                                    <h1 tabindex="0"
                                        class="text-center focus:outline-none text-lg font-bold text-gray-800 dark:text-gray-100 leading-5 pt-2 mb-2">
                                        Permissions</h1>
                                    <div class="grid grid-cols-2 gap-2">
                                        @forelse($features_permissions as $feature => $permissions)
                                            <div class="relative rounded shadow p-5 border border-1 border-gray-300">
                                                <p tabindex="0"
                                                    class="focus:outline-none text-gray-600 dark:text-gray-100 text-sm leading-none pt-2">
                                                    {{ $feature }}</p>
                                                <p tabindex="0"
                                                    class="focus:outline-none text-xs italic pt-1 leading-3 text-gray-400">
                                                    Discussion on the template design</p>
                                                <div class="flex items-center justify-left">
                                                    @forelse($permissions as $permission)
                                                        <div tabindex="0"
                                                            class="focus:outline-none text-green-700 bg-green-100 py-1 px-2 mr-2 rounded text-xs leading-3 mt-2">
                                                            {{ \Illuminate\Support\Str::of($permission->name)->afterLast('-')->replace('_', ' ')->ucfirst() }}
                                                        </div>
                                                    @empty
                                                    @endforelse
                                                </div>
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card code block end -->
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
