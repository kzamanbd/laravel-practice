<div>
    <x-slot name="header">
        <h2 class="font-semibold flex justify-between text-xl text-gray-800 leading-tight">
            <span>Users List</span>
            <a href="{{ route('send.notification') }}">Send Notification</a>
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-xl sm:rounded-lg">
                <div class="bg-white shadow-sm sm:rounded-lg p-5">
                    <div class="flex justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <label for="perPage" class="text-sm text-gray-600">Show</label>
                                <select wire:model="perPage" id="perPage"
                                    class="mx-2 form-control min-w-[80px] px-4 py-1.5">
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                                <label for="perPage" class="text-sm text-gray-600">entries</label>
                            </div>

                            <div class="flex items-center space-x-4">
                                <x-button color="light" type="button" wire:loading.attr="disabled"
                                    wire:click="exportExcel('csv')">
                                    csv
                                </x-button>
                                <x-button color="light" type="button" wire:loading.attr="disabled"
                                    wire:click="exportExcel('xlsx')">
                                    Xslx
                                </x-button>
                                <x-button color="light" type="button">
                                    PDF
                                </x-button>

                                <x-button type="button" wire:click="create">
                                    Create
                                </x-button>
                            </div>
                        </div>

                        <x-search-input wire:model="searchKey" />
                    </div>

                    <div class="flex flex-col">
                        <div class="py-2 align-middle inline-block w-full">
                            <div class="border border-1 border-gray-200 rounded">
                                <table class="w-full leading-normal p-2">
                                    <thead>
                                        <tr>
                                            <th
                                                class="w-6 px-3 py-3 border-b-2 border-gray-200 bg-gray-100 font-semibold text-gray-600 uppercase tracking-wider">
                                                <label class="inline-flex items-center">
                                                    <x-input-box wire:model="selectedPage" type="checkbox" />
                                                    <span class="ml-2 text-gray-700">SL</span>
                                                </label>
                                            </th>
                                            <th
                                                class="text-left px-3 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                <span>Name</span>
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
                                                <span>Email</span>
                                                <button type="button" wire:click.prevent="sortBy('email')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 w-3 h-3"
                                                        aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                                        <path
                                                            d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z" />
                                                    </svg>
                                                </button>
                                            </th>
                                            <th
                                                class="text-left px-3 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Roles
                                            </th>
                                            <th class="px-3 py-3 border-b-2 border-gray-200 bg-gray-100"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($this->users as $user)
                                            <tr class="border-b border-gray-200 on-parent-hover-show">
                                                <td class="px-3 py-2 text-sm">
                                                    <label class="inline-flex items-center">
                                                        <x-input-box wire:model="selectedItem" type="checkbox"
                                                            name="select" value="{{ $user->id }}" />
                                                        <span
                                                            class="ml-2 text-gray-700">{{ $loop->index + $this->users->firstItem() }}</span>
                                                    </label>
                                                </td>
                                                <td class="px-3 py-2 text-sm">
                                                    <a href="{{ route('user.show', $user->id) }}"
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
                                                        {{ $user->roles->pluck('name')->join(', ') }}
                                                    </span>
                                                </td>

                                                <td class="px-3 py-2 text-sm">
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
                                                                wire:click.prevent="editItem({{ $user->id }})">
                                                                Edit</x-dropdown-link>
                                                            <x-dropdown-link href="{{ route('user.show', $user->id) }}">
                                                                View</x-dropdown-link>
                                                            <x-dropdown-link href="#"
                                                                wire:click.prevent="deleteItem({{ $user->id }})">
                                                                Delete</x-dropdown-link>
                                                        </x-slot>
                                                    </x-dropdown>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center px-3 py-2">
                                                    <div class="flex items-center justify-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="200"
                                                            height="200" viewBox="0 0 200 200">
                                                            <g id="Group_2280" data-name="Group 2280"
                                                                transform="translate(-860 -403)">
                                                                <circle id="Ellipse_495" data-name="Ellipse 495"
                                                                    cx="100" cy="100" r="100"
                                                                    transform="translate(860 403)" fill="#eff0f5" />
                                                                <g id="Group_2279" data-name="Group 2279"
                                                                    transform="translate(-16.503 -16.363)">
                                                                    <g id="Group_2278" data-name="Group 2278"
                                                                        transform="translate(932 475)">
                                                                        <path id="Path_7062" data-name="Path 7062"
                                                                            d="M27.716.2V34.736H.2v54.19H64.5v0H89.207V.2ZM19.574,83.311H8.062V77.7H19.574Zm0-12.354H8.062V65.341H19.574Zm0-12.635H8.062V52.706H19.574Zm0-12.354H8.062V40.351H19.574ZM43.44,83.311H31.928V77.7H43.44Zm0-12.354H31.928V65.341H43.44Zm0-12.635H31.928V52.706H43.44Zm0-12.354H31.928V40.351H43.44ZM83.311,64.779H51.021V34.736H33.332V5.816H83.591V64.779Z"
                                                                            transform="translate(-0.2 -0.2)"
                                                                            fill="#9aa3ab" />
                                                                        <rect id="Rectangle_2574"
                                                                            data-name="Rectangle 2574" width="11.512"
                                                                            height="5.616"
                                                                            transform="translate(63.175 11.793)"
                                                                            fill="#9aa3ab" />
                                                                        <rect id="Rectangle_2575"
                                                                            data-name="Rectangle 2575" width="11.512"
                                                                            height="5.616"
                                                                            transform="translate(63.175 25.27)"
                                                                            fill="#9aa3ab" />
                                                                        <rect id="Rectangle_2576"
                                                                            data-name="Rectangle 2576" width="11.512"
                                                                            height="5.616"
                                                                            transform="translate(63.175 39.028)"
                                                                            fill="#9aa3ab" />
                                                                        <rect id="Rectangle_2577"
                                                                            data-name="Rectangle 2577" width="11.512"
                                                                            height="5.616"
                                                                            transform="translate(63.175 52.506)"
                                                                            fill="#9aa3ab" />
                                                                        <rect id="Rectangle_2578"
                                                                            data-name="Rectangle 2578" width="11.512"
                                                                            height="5.616"
                                                                            transform="translate(41.275 11.793)"
                                                                            fill="#9aa3ab" />
                                                                        <rect id="Rectangle_2579"
                                                                            data-name="Rectangle 2579" width="11.512"
                                                                            height="5.616"
                                                                            transform="translate(41.275 25.27)"
                                                                            fill="#9aa3ab" />
                                                                    </g>
                                                                    <path id="Path_7063" data-name="Path 7063"
                                                                        d="M7.756,20.524h5.211V12.968h7.556V7.756H12.968V.2H7.756V7.756H.2v5.211H7.756Z"
                                                                        transform="translate(988.803 541.64)"
                                                                        fill="#eff0f5" />
                                                                </g>
                                                            </g>
                                                        </svg>
                                                    </div>
                                                    <div class="text-gray-700 pt-2">No data found</div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="p-2">
                                    {{ $this->users->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- user create or update modal --}}

    <x-dialog-modal wire:model="openModal" maxWidth="3xl">
        <x-slot name="title">
            {{ $editableMode ? 'Update' : 'Create' }} User
        </x-slot>

        <x-slot name="content">
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <div class="flex flex-wrap mb-6">
                <div class="w-full md:w-1/2 pr-4 mb-6 md:mb-0">
                    <label class="form-label">
                        Name
                    </label>
                    <input wire:model="name" class="form-control"type="text" placeholder="Jane" required />
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
                    <label class="form-label" for="confirm-password">
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
            <div class="block">
                <h2 class="text-gray-700 text-2xl mt-3 text-center text-uppercase">Roles</h2>
                <div class="mt-2 grid grid-cols-3 gap-2">
                    @foreach ($this->rolesList as $role)
                        <div class="rounded bg-purple-100 border border-1 border-purple-500 p-5">
                            <label class="inline-flex items-center">
                                <input type="checkbox" wire:model="roles" value="{{ $role->id }}"
                                    class="form-checkbox h-4 w-4 text-purple-600 rounded" />
                                <span class="ml-2 text-gray-700">{{ $role->name }}</span>
                            </label>
                            <p class="text-sm">{{ $role->description }}</p>
                        </div>
                    @endforeach
                </div>
            </div>


        </x-slot>

        <x-slot name="footer">
            <x-button color="danger" wire:click="$toggle('openModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-button>

            <x-button wire:click="{{ $editableMode ? 'update' : 'store' }}" class="ml-3"
                wire:loading.attr="disabled">
                {{ $editableMode ? 'Update' : 'Create' }}
            </x-button>
        </x-slot>
    </x-dialog-modal>

</div>
