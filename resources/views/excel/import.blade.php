<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mt-4">
                @if(session()->has('success'))
                    <div class="alert flex flex-row items-center bg-purple-300 p-5 rounded border-b-2 border-purple-300 py-6">
                        <div class="alert-icon flex items-center bg-purple-100 border-2 border-purple-500 justify-center h-10 w-10 flex-shrink-0 rounded-full">
                        <span class="text-purple-500">
                            <svg fill="currentColor" viewBox="0 0 20 20" class="h-6 w-6">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </span>
                        </div>
                        <div class="alert-content ml-4">
                            <div class="alert-title font-semibold text-lg text-purple-800">
                                Success
                            </div>
                            <div class="alert-description text-sm text-purple-600">
                                {{ session('success') }}
                            </div>
                        </div>
                    </div>
                @endif

                <div class="flex items-center">
                    <form action="{{ route('submit-excel') }}" method="post" class="py-6" enctype="multipart/form-data">
                        @csrf
                        <x-auth-validation-errors class="mb-4" :errors="$errors"></x-auth-validation-errors>
                        <input type="file" name="file" class="text-sm sm:text-base border rounded placeholder-gray-400 focus:border-indigo-400 focus:outline-none py-2 px-2" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                        <button class="bg-white text-gray-800 font-bold rounded border-b-2 border-purple-500 hover:border-purple-600 hover:bg-purple-500 hover:text-white shadow-md py-2 px-6 inline-flex items-center focus:outline-none">
                            <span class="mr-2">Preview</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-upload" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383z"/>
                                <path fill-rule="evenodd" d="M7.646 4.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V14.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3z"/>
                            </svg>
                        </button>
                    </form>
                    @if(isset($data))
                        <form action="{{ route('upload-confirm') }}" method="post" class="ml-2">
                            @csrf
                            <input type="hidden" value="{{ json_encode($data) }}" name="data">
                            <button class="bg-white text-gray-800 font-bold rounded border-b-2 border-purple-500 hover:border-purple-600 hover:bg-purple-500 hover:text-white shadow-md py-2 px-6 inline-flex items-center focus:outline-none">
                                <span class="mr-2">Upload</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-upload" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383z"/>
                                    <path fill-rule="evenodd" d="M7.646 4.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V14.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3z"/>
                                </svg>
                            </button>
                        </form>
                    @endif
                </div>
                <div class="py-2">
                    <h3>File Extension must be .xlsx file</h3>
                    <a href="{{ asset('docs/data.xlsx') }}" download class="underline">Simple file download</a>
                </div>
            </div>
            @if(isset($data))
                <div class="flex flex-col">
                    <div class="py-2 flex justify-between items-center">
                        <h2 class="text-2xl font-semibold leading-tight">about {{ count($data) }} records found.</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <div class="py-2 align-middle inline-block w-full">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-200 text-black">
                                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                                        <th class="text-left px-2 py-1 text-sm border-2 border-left border-gray-200">
                                            SL
                                        </th>
                                        <th class="text-left px-2 py-1 text-sm border-2 border-left border-gray-200">
                                            E-TIN
                                        </th>

                                        <th class="text-left px-2 py-1 text-sm border-2 border-left border-gray-200">
                                            TIN Date
                                        </th>
                                        <th class="text-left px-2 py-1 text-sm border-2 border-left border-gray-200">
                                            Name
                                        </th>
                                        <th class="text-left px-2 py-1 text-sm border-2 border-left border-gray-200">
                                            Mobile
                                        </th>

                                        <th class="text-left px-2 py-1 text-sm border-2 border-left border-gray-200">
                                            Address
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-300">
                                    @foreach($data as $row)
                                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                                            <td class="px-2 py-1 whitespace-nowrap text-sm border-2 border-left border-gray-200">
                                                {{ $loop->iteration }}.
                                            </td>
                                            <td class="px-2 py-1 text-left whitespace-nowrap text-sm border-2 border-left border-gray-200">
                                                {{ $row['e_tin'] ?? 'N/A' }}
                                            </td>
                                            <td class="px-2 py-1 text-left whitespace-nowrap text-sm border-2 border-left border-gray-200">
                                                {{ $row['tin_date'] ?? 'N/A' }}
                                            </td>
                                            <td class="px-2 py-1 text-left whitespace-nowrap text-sm border-2 border-left border-gray-200">
                                                {{ $row['asses_name'] ?? 'N/A' }}
                                            </td>
                                            <td class="px-2 py-1 text-left whitespace-nowrap text-sm border-2 border-left border-gray-200">
                                                {{ $row['mobile'] ? \Illuminate\Support\Str::substr($row['mobile'], -11) : 'N/A' }}
                                            </td>
                                            <td class="px-2 py-1 text-left whitespace-nowrap text-sm border-2 border-left border-gray-200">
                                                {{ $row['address'] ?? 'N/A' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

</x-app-layout>
