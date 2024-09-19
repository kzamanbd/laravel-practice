<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Database Backup') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
            <div class="p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg space-y-4">
                <div class="flex gap-2 flex-wrap">
                    <x-primary-button wire:click="viewTableStructure">
                        View Table Structure
                    </x-primary-button>
                    <x-primary-button wire:click="exportTableStructure">
                        Export Table Structure to Excel
                    </x-primary-button>
                </div>
                <div class="flex flex-col">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="border rounded-lg overflow-hidden dark:border-neutral-700">
                                @foreach ($tables as $key => $table)
                                    <div class="hs-accordion active" x-data="{ open: false }">
                                        <button @click="open = !open"
                                            class="py-4 inline-flex items-center justify-between gap-x-3 w-full font-semibold text-start text-gray-800 hover:text-gray-500 rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:hs-accordion-active:text-blue-500 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:outline-none dark:focus:text-neutral-400"
                                            aria-expanded="true">
                                            <div class="bg-gray-50 px-4 w-full flex items-center justify-between">
                                                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                                    {{ $key }}
                                                </h2>
                                                <template x-if="open">
                                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="m18 15-6-6-6 6"></path>
                                                    </svg>
                                                </template>
                                                <template x-if="!open">
                                                    <svg class="block size-4" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="m6 9 6 6 6-6"></path>
                                                    </svg>
                                                </template>
                                            </div>
                                        </button>
                                        <div class="w-full overflow-hidden transition-[height] duration-300"
                                            :class="{ 'h-0': !open }" role="region">
                                            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                                                <thead class="bg-gray-50 dark:bg-neutral-700">
                                                    <tr>
                                                        <th scope="col"
                                                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                            Column
                                                        </th>
                                                        <th scope="col"
                                                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                            Data Type
                                                        </th>
                                                        <th scope="col"
                                                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                            Length
                                                        </th>
                                                        <th scope="col"
                                                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                            Nullable
                                                        </th>
                                                        <th scope="col"
                                                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                            Default
                                                        </th>
                                                    </tr>
                                                </thead>
                                                @foreach ($table as $column)
                                                    <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                                        <tr>
                                                            <td class="px-6 py-4 text-sm text-gray-800 ">
                                                                {{ $column['column_name'] }}
                                                            </td>
                                                            <td class="px-6 py-4 text-sm text-gray-800 ">
                                                                {{ $column['data_type'] }}
                                                            </td>
                                                            <td class="px-6 py-4 text-sm text-gray-800 ">
                                                                {{ $column['length'] }}
                                                            </td>
                                                            <td class="px-6 py-4 text-sm text-gray-800 ">
                                                                {{ $column['nullable'] }}
                                                            </td>
                                                            <td class="px-6 py-4 text-sm text-gray-800 ">
                                                                {{ $column['default'] }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
