<div>
    <x-slot name="title">Permission Dashboard</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold flex justify-between text-xl text-gray-800 leading-tight">
            <span>Permission Dashboard</span>
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-5">
                <div class="flex justify-between">
                    <div class="flex items-center space-x-4">
                        <x-lara-permission::primary-button  type="button" wire:click="syncPermission">
                            Sync Permission
                        </x-lara-permission::primary-button>

                        <x-lara-permission::primary-button  type="button" wire:click="syncFeature">
                            Sync Feature
                        </x-lara-permission::primary-button>

                        <x-lara-permission::primary-button type="button" wire:click="syncRole">
                            Sync Role
                        </x-lara-permission::primary-button>

                        <x-lara-permission::primary-button type="button" wire:click="assignPermission">
                            Assign Permission
                        </x-lara-permission::primary-button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
