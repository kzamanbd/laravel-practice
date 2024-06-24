<div>
    <x-slot name="title">Roles</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Role List') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-5">
                <div class="flex justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <label for="perPage" class="text-sm text-gray-600">Show</label>
                            <select id="perPage" class="mx-2 form-control min-w-[80px] px-4 py-1.5">
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                            <label for="perPage" class="text-sm text-gray-600">entries</label>
                        </div>

                        <div class="flex items-center space-x-4">
                            <x-primary-button color="light" type="button">
                                csv
                            </x-primary-button>
                            <x-primary-button color="light" type="button">
                                Xslx
                            </x-primary-button>
                            <x-primary-button color="light" type="button">
                                PDF
                            </x-primary-button>

                            <x-primary-button type="button" wire:click="$dispatch('open-modal', 'role-modal')">
                                Create
                            </x-primary-button>
                        </div>
                    </div>

                    <x-search-input wire:model="searchKey" />
                </div>

                <div class="flex flex-col">
                    <div class="py-2 align-middle inline-block w-full">
                        <div class="border border-1 border-gray-200 rounded">
                            <table class="w-full leading-normal">
                                <thead>
                                    <tr>
                                        <th
                                            class="w-6 px-3 py-3 border-b-2 border-gray-200 bg-gray-100 font-semibold text-gray-600 uppercase tracking-wider">
                                            <label class="inline-flex items-center">
                                                <x-box-input wire:model="selectedPage" />
                                                <span class="ml-2 text-gray-700">SL</span>
                                            </label>
                                        </th>
                                        <th
                                            class="text-left px-3 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Name
                                            <button type="button" wire:click.prevent="sortBy('name')">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 w-3 h-3"
                                                    aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                                    <path
                                                        d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z" />
                                                </svg>
                                            </button>
                                        </th>
                                        <th
                                            class="text-left px-3 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Description
                                        </th>
                                        <th
                                            class="text-center px-3 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($this->roles as $role)
                                        <tr class="border-b border-gray-200 on-parent-hover-show">
                                            <td class="px-3 py-2 text-sm">
                                                <label class="inline-flex items-center">
                                                    <x-box-input wire:model="selectedItem"
                                                        value="{{ $role->id }}" />
                                                    <span class="ml-2 text-gray-700">
                                                        {{ $loop->iteration }}
                                                    </span>
                                                </label>
                                            </td>
                                            <td class="px-3 py-2 text-sm">
                                                <a href="#"
                                                    class="flex items-center no-underline hover:underline">
                                                    <div class="ml-3 d-flex items-center">
                                                        <span class="text-gray-900 whitespace-no-wrap m-0">
                                                            {{ $role->name }}
                                                        </span>
                                                    </div>
                                                </a>
                                            </td>
                                            <td class="px-3 py-2 text-sm">
                                                <span class="text-gray-900 whitespace-no-wrap">
                                                    {{ $role->description }}
                                                </span>
                                            </td>
                                            <td class="px-3 py-2 text-center">
                                                <x-dropdown align="right">
                                                    <x-slot name="trigger">
                                                        <button type="button">
                                                            <span class="material-icons">
                                                                more_vert
                                                            </span>
                                                        </button>
                                                    </x-slot>

                                                    <x-slot name="content">
                                                        <x-dropdown-link href="#"
                                                            wire:click="editItem({{ $role->id }})">
                                                            Edit</x-dropdown-link>
                                                        <x-dropdown-link href="{{ route('role.show', $role->id) }}">
                                                            View</x-dropdown-link>
                                                        <x-dropdown-link href="#"
                                                            wire:click.prevent="deleteItem({{ $role->id }})">
                                                            Delete</x-dropdown-link>
                                                    </x-slot>
                                                </x-dropdown>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- role create or update modal --}}

    <x-modal name="role-modal" maxWidth="3xl" title="{{ $editableMode ? 'Update' : 'Create' }}">

        <form class="p-6" wire:submit="store">

            <div class="form-group">
                <label for="grid-first-name1" class="form-label">
                    Name
                </label>
                <input wire:model="name" class="form-control" id="grid-first-name1" type="text"
                    placeholder="Role Name" required />
            </div>
            <div class="form-group mt-3">
                <label class="form-label">
                    Description
                </label>
                <textarea wire:model="description" class="form-control" rows="6" placeholder="Description"></textarea>
            </div>



            <div class="my-4">
                <h1
                    class="focus:outline-none text-lg font-bold text-gray-800 dark:text-gray-100 leading-5 pt-2 mb-4 text-center flex items-center justify-center">
                    <span>Permissions</span>
                    <span class="material-icons cursor-pointer">sync</span>
                </h1>

                <div class="space-y-4 h-96 overflow-y-auto">
                    @foreach ($this->features as $feature)
                        <div class="form-control">
                            <label class="flex items-center mb-2">
                                <x-box-input />
                                <span class="ml-2">{{ $feature->name }}</span>
                            </label>
                            <div class="flex items-center space-x-2">
                                @foreach ($this->permissionsList as $permission)
                                    @continue(\Illuminate\Support\Str::of($permission->name)->beforeLast('-') != $feature->slug)
                                    <label class="block">
                                        <x-box-input value="{{ $permission->id }}" wire:model="permissions" />
                                        <span class="mr-2 ml-1 text-gray-700">
                                            {{ \Illuminate\Support\Str::of($permission->name)->afterLast('-')->replace('_', ' ')->ucfirst() }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="flex justify-end">
                <x-primary-button color="danger" type="button" wire:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-primary-button>

                <x-primary-button class="ml-3">
                    Save
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</div>
