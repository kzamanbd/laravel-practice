<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Role') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <form class="w-full" action="{{ route('role.update', $role->id) }}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="rounded shadow py-3 px-4 w-full bg-white dark:bg-gray-800">
                            <div class="w-full px-3">
                                <label for="grid-first-name1" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                    Name
                                </label>
                                <input name="name" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-first-name1" type="text" placeholder="Role Name" required value="{{ old('name', $role->name) }}" />
                            </div>
                            <div class="w-full px-3 mt-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                    Description
                                </label>
                                <textarea name="description" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" rows="6" placeholder="Description">{{ old('description', $role->description) }}</textarea>
                            </div>
                        </div>



                        <div class="flex items-center justify-center mt-4">
                            <div class="rounded shadow py-3 px-4 w-full bg-white dark:bg-gray-800">
                                <h1 class="focus:outline-none text-lg font-bold text-gray-800 dark:text-gray-100 leading-5 pt-2 mb-4 text-center flex items-center justify-center">
                                    <span>Permissions</span>
                                    <span class="material-icons cursor-pointer">sync</span>
                                </h1>

                                <div class="grid grid-cols-3 gap-2">
                                    @foreach($menus as $menu)
                                        <div class="relative shadow rounded bg-purple-100 border-1 border-purple-400"
                                             x-data="{ isAllChecked: false }"
                                             x-init="() => {
                                                    let checked = true
                                                    const children = $refs.permissions.children
                                                    for(let i = 0; i < children.length; i++){
                                                         if(! children[i].firstChild.nextSibling.checked){
                                                            checked = false;
                                                            break;
                                                         }
                                                    }
                                                    isAllChecked = checked
                                                }"
                                        >
                                            <div class="rounded text-white bg-purple-500 flex items-center border-b-2 border-purple-600">
                                                <p class="px-4 py-2">
                                                    <label class="inline-flex items-center">
                                                        <input type="checkbox" class="form-checkbox h-4 w-4 text-purple-600 rounded focus:outline-none focus:ring focus:border-blue-300"
                                                           x-ref="selectAllPermissions"
                                                           x-on:click="
                                                               const children = event.target.parentElement.parentElement.parentElement.nextElementSibling.children;
                                                               for(let i = 0; i < children.length; i++){
                                                                 children[i].children[0].checked = event.target.checked
                                                               }
                                                           "
                                                           x-bind:checked="isAllChecked"
                                                        />
                                                        <span class="ml-2">{{ $menu->name }}</span>
                                                    </label>
                                                </p>
                                            </div>
                                            <div class="px-4 py-2" x-ref="permissions">
                                                @foreach($permissions as $permission)
                                                    @continue(\Illuminate\Support\Str::of($permission->name)->beforeLast('-') != $menu->slug)
                                                    <label class="block">
                                                        <input type="checkbox" id="permission-{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}" {!! in_array($permission->id, $role->permissions->pluck('id')->all()) ? 'checked' : '' !!} class="form-checkbox h-4 w-4 text-purple-600 rounded focus:outline-none focus:ring focus:border-blue-300"
                                                               x-on:click="
                                                                   let allChecked = true
                                                                   const allPermissions = event.target.parentElement.parentElement.children
                                                                   for(let i = 0; i < allPermissions.length; i++){
                                                                       const checkbox = allPermissions[i].children[0]
                                                                       if(!checkbox.checked){
                                                                            allChecked = false
                                                                            break
                                                                       }
                                                                   }
                                                                   $refs.selectAllPermissions.checked = allChecked
                                                               "
                                                        />
                                                        <span class="ml-2 text-gray-700">{{ \Illuminate\Support\Str::of($permission->name)->afterLast('-')->replace('_', ' ')->ucfirst() }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
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
