<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Role List') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6 bg-white border-b border-gray-200">
                    <strong>Total {{ count($roles) }} records found!</strong>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <a href="{{ route('role.create') }}" class="bg-white mb-2 text-gray-800 font-bold rounded border-b-2 border-purple-500 hover:border-purple-600 hover:bg-purple-500 hover:text-white shadow-md py-2 px-6 inline-flex items-center focus:outline-none" @click="roleCreatingForm">
                        <span class="mr-2">Add Role</span>
                        <span class="material-icons">add</span>
                    </a>

                    <div class="flex flex-col">
                        <div class="overflow-x-auto">
                            <div class="py-2 align-middle inline-block w-full">
                                <div class="overflow-hidden border border-1 border-gray-200 rounded">
                                    <table class="w-full leading-normal">
                                        <thead>
                                        <tr>
                                            <th class="w-6 px-3 py-3 border-b-2 border-gray-200 bg-gray-100 font-semibold text-gray-600 uppercase tracking-wider">
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox" class="form-checkbox h-4 w-4 text-purple-600 rounded" />
                                                    <span class="ml-2 text-gray-700">SL</span>
                                                </label>
                                            </th>
                                            <th class="text-left px-3 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Name
                                            </th>
                                            <th class="text-left px-3 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Description
                                            </th>
                                            <th class="text-center px-3 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($roles as $role)
                                                <tr class="border-b border-gray-200 on-parent-hover-show">
                                                    <td class="px-3 py-2 text-sm">
                                                        <label class="inline-flex items-center">
                                                            <input type="checkbox" class="form-checkbox h-4 w-4 text-purple-600 rounded checked:border-transparent" />
                                                            <span class="ml-2 text-gray-700">{{ $loop->iteration }}</span>
                                                        </label>
                                                    </td>
                                                    <td class="px-3 py-2 text-sm">
                                                        <a href="#" class="flex items-center no-underline hover:underline">
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
                                                    <td class="text-center px-3 py-2 flex justify-center items-center on-hover-show">
                                                        <a href="{{ route('role.show', $role->id) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white rounded-full text-xs h-8 w-8 flex items-center justify-center mr-2 cursor-pointer">
                                                            <span class="material-icons text-base">visibility</span>
                                                        </a>
                                                        <a href="{{ route('role.edit', $role->id) }}" class="bg-purple-500 hover:bg-purple-700 text-white rounded-full text-xs h-8 w-8 flex items-center justify-center mr-2 cursor-pointer">
                                                            <span class="material-icons text-base">edit</span>
                                                        </a>
                                                        <div class="bg-red-500 hover:bg-red-700 text-white rounded-full text-xs h-8 w-8 flex items-center justify-center cursor-pointer">
                                                            <span class="material-icons text-base">delete</span>
                                                        </div>
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
    </div>

</x-app-layout>
