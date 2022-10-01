<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contacts') }}
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
                                <select id="perPage" class="mx-2 form-control min-w-[80px] px-4 py-1.5">
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                                <label for="perPage" class="text-sm text-gray-600">entries</label>
                            </div>

                            <div class="flex items-center space-x-4">
                                <x-button color="light" type="button">
                                    csv
                                </x-button>
                                <x-button color="light" type="button">
                                    Xslx
                                </x-button>
                                <x-button color="light" type="button">
                                    PDF
                                </x-button>

                                <x-button type="button" wire:click="$toggle('openModal')">
                                    Upload
                                </x-button>
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
                                                class="text-left px-3 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                SL
                                            </th>
                                            <th
                                                class="text-left px-3 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Name
                                            </th>
                                            <th
                                                class="text-left px-3 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Mobile
                                            </th>
                                            <th
                                                class="text-left px-3 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                E-TIN
                                            </th>

                                            <th
                                                class="text-left px-3 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                TIN Date
                                            </th>

                                            <th
                                                class="text-left px-3 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Address
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($this->contacts as $item)
                                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                                <td class="px-3 py-2 text-sm">
                                                    {{ $loop->iteration }}.
                                                </td>
                                                <td class="px-3 py-2 text-sm">
                                                    {{ $item->name ?? 'N/A' }}
                                                </td>
                                                <td class="px-3 py-2 text-sm">
                                                    {{ $item->mobile ? \Illuminate\Support\Str::substr($item->mobile, -11) : 'N/A' }}
                                                </td>
                                                <td class="px-3 py-2 text-sm">
                                                    {{ $item->e_tin ?? 'N/A' }}
                                                </td>
                                                <td class="px-3 py-2 text-sm">
                                                    {{ $item->tin_date ?? 'N/A' }}
                                                </td>
                                                <td class="px-3 py-2 text-sm">
                                                    {{ $item->address ?? 'N/A' }}
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
    </div>

    {{-- role create or update modal --}}

    <x-dialog-modal wire:model="openModal" maxWidth="3xl">
        <x-slot name="title">
            Upload File
        </x-slot>

        <x-slot name="content">
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

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

        </x-slot>

        <x-slot name="footer">
            <x-button color="danger" wire:click="$toggle('openModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-button>

            <x-button class="ml-3" wire:loading.attr="disabled">
                Upload
            </x-button>
        </x-slot>
    </x-dialog-modal>

</div>
