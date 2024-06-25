<div>
    <x-slot name="title">Users</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold flex justify-between text-xl text-gray-800 leading-tight">
            <span>Users List</span>
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-5">
                <div class="flex justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <label for="perPage" class="text-sm text-gray-600">Show</label>
                            <select wire:model.live="perPage" id="perPage"
                                class="mx-2 form-control min-w-[80px] px-4 py-1.5">
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                            <label for="perPage" class="text-sm text-gray-600">entries</label>
                        </div>

                        <div class="flex items-center space-x-4">
                            <x-lara-permission::button color="light" type="button" wire:click="exportExcel('csv')">
                                csv
                            </x-lara-permission::button>
                            <x-lara-permission::button color="light" type="button" wire:click="exportExcel('xlsx')">
                                Xslx
                            </x-lara-permission::button>
                            <x-lara-permission::button color="light" type="button">
                                PDF
                            </x-lara-permission::button>

                            <x-lara-permission::button type="button"
                                wire:click="$dispatch('open-modal', 'create-modal')">
                                Create
                            </x-lara-permission::button>
                            <x-lara-permission::button color="light" type="button" wire:click="sendNotification">
                                Send Notification
                            </x-lara-permission::button>
                        </div>
                    </div>

                    <x-lara-permission::search-input wire:model.live.debounce.500ms="searchKey" />
                </div>

                <div class="flex flex-col">
                    <div class="py-2 align-middle inline-block w-full">
                        <div class="border border-1 border-gray-200 rounded">
                            <div class="p-2">
                                {{ $this->users->links('lara-permission::tailwind') }}
                            </div>
                            <table class="w-full leading-normal p-2">
                                <thead>
                                    <tr>
                                        <th width="5%"
                                            class="text-left px-3 py-3 border-b-2 border-gray-200 bg-gray-100 font-semibold text-gray-600 uppercase tracking-wider">
                                            <label class="inline-flex items-center">
                                                <x-box-input wire:model.live="selectedPage" type="checkbox" />
                                                <span class="ml-2 text-gray-700">SL</span>
                                            </label>
                                        </th>
                                        <th width="30%"
                                            class="text-left px-3 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            <button class="flex items-center" type="button"
                                                wire:click.prevent="sortBy('name')">
                                                <span>Name</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 w-3 h-3"
                                                    aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                                    <path
                                                        d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z" />
                                                </svg>
                                            </button>
                                        </th>
                                        <th width="25%"
                                            class="text-left px-3 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            <button class="flex items-center" type="button"
                                                wire:click.prevent="sortBy('email')">
                                                <span>Email</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 w-3 h-3"
                                                    aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                                    <path
                                                        d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z" />
                                                </svg>
                                            </button>
                                        </th>
                                        <th width="20%"
                                            class="text-left px-3 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Roles
                                        </th>
                                        <th width="20%"
                                            class="text-center px-3 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($selectedItem))
                                        <tr class="border-b border-gray-200 on-parent-hover-show">
                                            <td colspan="5" class="text-center px-3 py-2">
                                                You have selected <strong>{{ count($selectedItem) }}</strong> users.
                                                <button class="text-red-500 hover:text-red-700">Delete</button>
                                                them?
                                            </td>
                                        </tr>
                                    @endif
                                    @forelse($this->users as $user)
                                        <tr class="border-b border-gray-200 on-parent-hover-show">
                                            <td class="px-3 py-2 text-sm">
                                                <label class="inline-flex items-center">
                                                    <x-box-input wire:model.live="selectedItem" type="checkbox"
                                                        name="select" value="{{ $user->id }}" />
                                                    <span
                                                        class="ml-2 text-gray-700">{{ $loop->index + $this->users->firstItem() }}</span>
                                                </label>
                                            </td>
                                            <td class="px-3 py-2 text-sm">
                                                <a href="#"
                                                    class="flex items-center no-underline hover:underline">
                                                    <div class="flex-shrink-0 w-10 h-10 hidden sm:table-cell">
                                                        <img class="w-full h-full rounded-full"
                                                            src="https://ui-avatars.com/api/?name={{ $user->name }}&color=7F9CF5&background=EBF4FF"
                                                            alt="" />
                                                    </div>
                                                    <div class="ml-3 d-flex items-center">
                                                        <span class="text-gray-900 whitespace-no-wrap m-0">
                                                            {{ $user->name }}
                                                        </span>
                                                    </div>
                                                </a>
                                            </td>
                                            <td class="px-3 py-2 text-sm">
                                                <span class="text-gray-900 whitespace-no-wrap">
                                                    {{ $user->email }}
                                                </span>
                                            </td>
                                            <td class="px-3 py-2 text-sm">
                                                <span class="text-gray-900 whitespace-no-wrap">
                                                    {{ count($user->roles) > 0 ? $user->roles->pluck('name')->join(', ') : 'No Role' }}
                                                </span>
                                            </td>

                                            <td class="px-3 py-2 text-sm text-center">
                                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                                    <x-lara-permission::button
                                                        wire:click="editItem({{ $user->id }})"
                                                        class="rounded-r-none" color="light">
                                                        Edit
                                                    </x-lara-permission::button>
                                                    @if (Route::has('lara-permission.user.show'))
                                                        <x-lara-permission::button as="a" wire:navigate
                                                            href="{{ route('lara-permission.user.show', $user->id) }}"
                                                            class="rounded-none">
                                                            View
                                                        </x-lara-permission::button>
                                                    @endif
                                                    <x-lara-permission::button color="danger"
                                                        wire:click="deleteItem({{ $user->id }})"
                                                        class="rounded-l-none">
                                                        Delete
                                                    </x-lara-permission::button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center px-3 py-2">
                                                <x-lara-permission::empty-state />
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-lara-permission::modal name="create-modal" maxWidth="3xl"
        title="{{ $editableMode ? 'Update' : 'Create' }} User">

        <form class="p-6" wire:submit="store">

            <div class="flex flex-wrap mb-6">
                <div class="w-full md:w-1/2 pr-4 mb-6 md:mb-0">
                    <label class="form-label">
                        Name
                    </label>
                    <input wire:model="name" class="form-control" type="text" placeholder="Jane" />
                    <x-lara-permission::input-error :messages="$errors->get('name')" />
                </div>
                <div class="w-full md:w-1/2 px-3">
                    <label class="form-label">
                        Email
                    </label>
                    <input wire:model="email" class="form-control" type="email" placeholder="example@mail.com"
                        required />
                </div>
            </div>
            <div class="flex flex-wrap mb-6">
                <div class="w-full md:w-1/2 pr-4 mb-6 md:mb-0">
                    <label class="form-label">
                        Password
                    </label>
                    <input wire:model="password" class="form-control" type="password" placeholder="Password" />
                </div>
                <div class="w-full md:w-1/2 px-3">
                    <label class="form-label">
                        Confirm Password
                    </label>
                    <input wire:model="password_confirmation" class="form-control" type="password"
                        placeholder="Confirm Password" />
                </div>
            </div>
            <div class="bg-purple-100 rounded border-l-4 border-purple-500 text-purple-700 p-5 mt-3" role="alert">
                <p class="font-bold">Set user roles</p>
                <p>Something not ideal might be happening.</p>
            </div>


            <!-- component -->
            <div class="mb-4">
                <h2 class="text-gray-700 text-2xl mt-3 text-center text-uppercase">Roles</h2>
                <div class="mt-2 grid grid-cols-3 gap-2">
                    @foreach ($this->rolesList as $role)
                        <div class="rounded bg-purple-100 border border-1 border-purple-500 p-5">
                            <label class="inline-flex items-center">
                                <input type="checkbox" wire:model="roles" value="{{ $role->name }}"
                                    class="form-checkbox h-4 w-4 text-purple-600 rounded" />
                                <span class="ml-2 text-gray-700">{{ $role->name }}</span>
                            </label>
                            <p class="text-sm">{{ $role->description }}</p>
                        </div>
                    @endforeach
                </div>
            </div>


            <div class="flex justify-end">
                <x-lara-permission::button color="danger" type="button"
                    wire:click="$dispatch('close-modal', 'create-modal')">
                    {{ __('Cancel') }}
                </x-lara-permission::button>

                <x-lara-permission::button class="ml-3">
                    Save
                </x-lara-permission::button>
            </div>
        </form>
    </x-lara-permission::modal>
</div>
