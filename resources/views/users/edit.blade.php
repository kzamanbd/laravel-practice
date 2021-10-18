<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <form class="w-full" action="{{ route('user.update', $user->id) }}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full md:w-1/2 pr-4 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                                    Name
                                </label>
                                <input name="name" value="{{ $user->name }}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-first-name1" type="text" placeholder="Jane" required />
                            </div>
                            <div class="w-full md:w-1/2 px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-email">
                                    Email
                                </label>
                                <input
                                    name="email"
                                    value="{{ $user->email }}"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="grid-email"
                                    type="email"
                                    placeholder="Doe"
                                    required
                                />
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full md:w-1/2 pr-4 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
                                    Password
                                </label>
                                <input
                                    name="password"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="grid-password"
                                    type="password"
                                    placeholder="******************"
                                />
                            </div>
                            <div class="w-full md:w-1/2 px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="confirm-password">
                                    Confirm Password
                                </label>
                                <input
                                    name="password_confirmation"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="confirm-password"
                                    type="password"
                                    placeholder="******************"
                                />
                            </div>
                        </div>
                        <div class="bg-purple-100 rounded border-l-4 border-purple-500 text-purple-700 p-5 mt-3" role="alert">
                            <p class="font-bold">Set user roles</p>
                            <p>Something not ideal might be happening.</p>
                        </div>


                        <!-- component -->
                        <div class="block">
                            <h2 class="text-gray-700 text-2xl mt-3 text-center text-uppercase">Roles</h2>
                            <div class="mt-2 grid grid-cols-3 gap-2">
                                @foreach($roles as $role)
                                    <div class="rounded bg-purple-100 border border-1 border-purple-500 p-5">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="roles[]" value="{{ $role->id }}" {{ in_array($role->id, old('roles', $user->roles->pluck('id')->all())) ? 'checked' : '' }} class="form-checkbox h-4 w-4 text-purple-600 rounded" />
                                            <span class="ml-2 text-gray-700">{{ $role->name }}</span>
                                        </label>
                                        <p class="text-sm">{{ $role->description }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <x-button class="mt-3">
                            {{ __('Update') }}
                        </x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
