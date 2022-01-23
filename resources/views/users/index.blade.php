<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold flex justify-between text-xl text-gray-800 leading-tight">
            <span>All Users List</span>
            <a href="{{ route('send.notification') }}">Send Notification</a>
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <form action="" method="get" class="p-6 bg-white border-b border-gray-200 flex justify-between items-center">
                    <strong>Total {{ count($users) }} records found!</strong>
                    <input name="search" value="{{ request()->search ?? '' }}" class="w-64 text-sm border rounded appearance-none p-2 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray" placeholder="Jane Doe">
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <div class="flex justify-between">
                        <a href="{{ route('user.create') }}" class="bg-white mb-2 text-sm text-gray-800 font-bold rounded border-b-2 border-purple-500 hover:border-purple-600 hover:bg-purple-500 hover:text-white shadow-md py-2 px-6 inline-flex items-center focus:outline-none">
                            <span class="mr-2">Add User</span>
                            <span class="material-icons">add</span>
                        </a>
                    </div>

                    <div class="flex flex-col">
                        <div class="overflow-x-auto">
                            <div class="py-2 align-middle inline-block w-full">
                                <div class="overflow-hidden border border-1 border-gray-200 rounded">
                                    <div class="p-2">
                                        {{ $users->links() }}
                                    </div>
                                    <table class="w-full leading-normal p-2">
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
                                                    Email
                                                </th>
                                                <th class="text-left px-3 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                    Roles
                                                </th>
                                                <th class="text-center px-3 py-3 border-b-2 border-gray-200 bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($users as $user)
                                                <tr class="border-b border-gray-200 on-parent-hover-show">
                                                    <td class="px-3 py-2 text-sm">
                                                        <label class="inline-flex items-center">
                                                            <input type="checkbox" class="form-checkbox h-4 w-4 text-purple-600 rounded checked:border-transparent" />
                                                            <span class="ml-2 text-gray-700">{{ $loop->index + $users->firstItem() }}</span>
                                                        </label>
                                                    </td>
                                                    <td class="px-3 py-2 text-sm">
                                                        <a href="#" class="flex items-center no-underline hover:underline">
                                                            <div class="flex-shrink-0 w-10 h-10 hidden sm:table-cell">
                                                                <img class="w-full h-full rounded-full" src="https://ui-avatars.com/api/?name={{ $user->name }}&color=7F9CF5&background=EBF4FF" alt="" />
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
                                                    
                                                    <td class="text-center px-3 py-2 flex justify-center items-center on-hover-show">
                                                        <a href="{{ route('user.show', $user->id) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white rounded-full text-xs h-8 w-8 flex items-center justify-center mr-2 cursor-pointer">
                                                            <span class="material-icons text-base">visibility</span>
                                                        </a>
                                                        <a href="{{ route('user.edit', $user->id) }}" class="bg-purple-500 hover:bg-purple-700 text-white rounded-full text-xs h-8 w-8 flex items-center justify-center mr-2 cursor-pointer">
                                                            <span class="material-icons text-base">edit</span>
                                                        </a>
                                                        <a href="{{ route('user.index') }}" onclick="if(confirm('Are you sure,\nYou want to delete this record?')){event.preventDefault();document.getElementById('user-{{ $user->id }}').submit();} else {event.preventDefault();}" class="bg-red-500 hover:bg-red-700 text-white rounded-full text-xs h-8 w-8 flex items-center justify-center cursor-pointer">
                                                            <span class="material-icons text-base">delete</span>
                                                            <form action="{{ route('user.destroy', $user->id) }}" method="post" id="user-{{ $user->id }}" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                    
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center px-3 py-2">
                                                    <div class="flex items-center justify-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200">
                                                            <g id="Group_2280" data-name="Group 2280" transform="translate(-860 -403)">
                                                              <circle id="Ellipse_495" data-name="Ellipse 495" cx="100" cy="100" r="100" transform="translate(860 403)" fill="#eff0f5"/>
                                                              <g id="Group_2279" data-name="Group 2279" transform="translate(-16.503 -16.363)">
                                                                <g id="Group_2278" data-name="Group 2278" transform="translate(932 475)">
                                                                  <path id="Path_7062" data-name="Path 7062" d="M27.716.2V34.736H.2v54.19H64.5v0H89.207V.2ZM19.574,83.311H8.062V77.7H19.574Zm0-12.354H8.062V65.341H19.574Zm0-12.635H8.062V52.706H19.574Zm0-12.354H8.062V40.351H19.574ZM43.44,83.311H31.928V77.7H43.44Zm0-12.354H31.928V65.341H43.44Zm0-12.635H31.928V52.706H43.44Zm0-12.354H31.928V40.351H43.44ZM83.311,64.779H51.021V34.736H33.332V5.816H83.591V64.779Z" transform="translate(-0.2 -0.2)" fill="#9aa3ab"/>
                                                                  <rect id="Rectangle_2574" data-name="Rectangle 2574" width="11.512" height="5.616" transform="translate(63.175 11.793)" fill="#9aa3ab"/>
                                                                  <rect id="Rectangle_2575" data-name="Rectangle 2575" width="11.512" height="5.616" transform="translate(63.175 25.27)" fill="#9aa3ab"/>
                                                                  <rect id="Rectangle_2576" data-name="Rectangle 2576" width="11.512" height="5.616" transform="translate(63.175 39.028)" fill="#9aa3ab"/>
                                                                  <rect id="Rectangle_2577" data-name="Rectangle 2577" width="11.512" height="5.616" transform="translate(63.175 52.506)" fill="#9aa3ab"/>
                                                                  <rect id="Rectangle_2578" data-name="Rectangle 2578" width="11.512" height="5.616" transform="translate(41.275 11.793)" fill="#9aa3ab"/>
                                                                  <rect id="Rectangle_2579" data-name="Rectangle 2579" width="11.512" height="5.616" transform="translate(41.275 25.27)" fill="#9aa3ab"/>
                                                                </g>
                                                                <path id="Path_7063" data-name="Path 7063" d="M7.756,20.524h5.211V12.968h7.556V7.756H12.968V.2H7.756V7.756H.2v5.211H7.756Z" transform="translate(988.803 541.64)" fill="#eff0f5"/>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Create user -->
</x-app-layout>
