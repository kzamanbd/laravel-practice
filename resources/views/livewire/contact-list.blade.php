<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contacts') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-5">
                <div class="flex justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <label for="perPage" class="text-sm text-gray-600">Show</label>
                            <select id="perPage" wire:model.live="perPage"
                                class="mx-2 form-control min-w-[80px] px-4 py-1.5">
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <label for="perPage" class="text-sm text-gray-600">entries</label>
                        </div>

                        <div class="flex items-center space-x-4">
                            <x-primary-button color="light" type="button" wire:loading.attr="disabled"
                                wire:click="exportExcel('csv')">
                                csv
                            </x-primary-button>
                            <x-primary-button color="light" type="button" wire:loading.attr="disabled"
                                wire:click="exportExcel('xlsx')">
                                Xslx
                            </x-primary-button>
                            <x-primary-button color="light" type="button">
                                PDF
                            </x-primary-button>

                            @if (count($excelData) > 0)
                                <x-primary-button type="button" wire:click="confirmToImport">
                                    Confirm Upload
                                </x-primary-button>
                            @else
                                <x-primary-button type="button"
                                    x-on:click.prevent="$dispatch('open-modal', 'upload-modal')">
                                    Upload
                                </x-primary-button>
                            @endif
                        </div>
                    </div>

                    <x-search-input wire:model.live.debounce.500ms="searchKey" />
                </div>

                <div class="flex flex-col">
                    <div class="py-2 align-middle inline-block w-full">
                        <div class="border border-1 border-gray-200 rounded">
                            <table class="w-full leading-normal">
                                <thead>
                                    <tr>
                                        <th width="5%"
                                            class="text-left px-3 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            SL
                                        </th>
                                        <th width="20%"
                                            class="text-left px-3 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Name
                                        </th>
                                        <th width="15%"
                                            class="text-center  px-3 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Mobile
                                        </th>
                                        <th width="15%"
                                            class="text-center px-3 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            E-TIN
                                        </th>

                                        <th width="15%"
                                            class="text-center  px-3 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            TIN Date
                                        </th>

                                        <th width="30%"
                                            class="text-left px-3 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Address
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($excelData) > 0)
                                        @foreach ($excelData as $item)
                                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                                <td class="px-3 py-2 text-sm">
                                                    {{ $loop->iteration }}.
                                                </td>
                                                <td class="text-left px-3 py-2 text-sm">
                                                    {{ $item['name'] ?? 'N/A' }}
                                                </td>
                                                <td class="text-center px-3 py-2 text-sm">
                                                    {{ $item['mobile'] ? \Illuminate\Support\Str::substr($item['mobile'], -11) : 'N/A' }}
                                                </td>
                                                <td class="text-center px-3 py-2 text-sm">
                                                    {{ $item['e_tin'] ?? 'N/A' }}
                                                </td>
                                                <td class="text-center px-3 py-2 text-sm">
                                                    {{ $item['tin_date'] ?? 'N/A' }}
                                                </td>
                                                <td class="px-3 py-2 text-sm">
                                                    {{ $item['address'] ?? 'N/A' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        @foreach ($this->contacts as $item)
                                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                                <td class="px-3 py-2 text-sm">
                                                    {{ $loop->iteration }}.
                                                </td>
                                                <td class="px-3 py-2 text-sm">
                                                    {{ $item->name ?? 'N/A' }}
                                                </td>
                                                <td class="text-center px-3 py-2 text-sm">
                                                    {{ $item->mobile ? \Illuminate\Support\Str::substr($item->mobile, -11) : 'N/A' }}
                                                </td>
                                                <td class="text-center px-3 py-2 text-sm">
                                                    {{ $item->e_tin ?? 'N/A' }}
                                                </td>
                                                <td class="text-center px-3 py-2 text-sm">
                                                    {{ $item->tin_date ?? 'N/A' }}
                                                </td>
                                                <td class="px-3 py-2 text-sm">
                                                    {{ $item->address ?? 'N/A' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            @if (empty($excelData))
                                <div class="p-2">
                                    {{ $this->contacts->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-dialog-modal name="upload-modal" maxWidth="3xl">
        <x-slot name="title">
            Upload File
        </x-slot>

        <x-slot name="content">
            <div x-data="{ fileName: null }" class="flex justify-center items-center w-full">
                <label for="dropzone-file"
                    class="flex flex-col justify-center items-center w-full h-64 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <div class="flex flex-col justify-center items-center pt-5 pb-6">
                        <svg aria-hidden="true" class="mb-3 w-10 h-10 text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                            </path>
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                            <span class="font-semibold">Click to upload</span> or drag and drop
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">File Extension must be .xlsx file</p>
                        <p x-text="fileName"></p>
                    </div>
                    <input wire:model="excelFile" x-ref="excelFile"
                        x-on:change="fileName = $refs.excelFile.files[0].name;" id="dropzone-file" type="file"
                        class="hidden" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />
                </label>
            </div>
            <div class="py-2">
                <a href="{{ asset('docs/excel-format.xlsx') }}" download class="underline">Simple file download</a>
            </div>

        </x-slot>
        +
        <x-slot name="footer">
            <x-secondary-button color="danger" x-on:click="$dispatch('close')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-primary-button class="ml-3" wire:loading.attr="disabled" wire:click="upload">
                Upload
            </x-primary-button>
        </x-slot>
    </x-dialog-modal>

</div>
