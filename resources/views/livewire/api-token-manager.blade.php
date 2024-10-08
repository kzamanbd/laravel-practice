<div>
    <x-slot name="title">API Tokens</x-slot>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('API Tokens') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Generate API Token -->
            <x-form-section submit="createApiToken">
                <x-slot name="title">
                    {{ __('Create API Token') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('API tokens allow third-party services to authenticate with our application on your behalf.') }}
                </x-slot>

                <x-slot name="form">
                    <!-- Token Name -->
                    <div class="col-span-6 sm:col-span-4">
                        <x-input-label for="name" value="{{ __('Token Name') }}" />
                        <x-text-input id="name" type="text" class="block w-full mt-1"
                            wire:model="createApiTokenForm.name" autofocus />
                        <x-input-error :messages="$errors->get('createApiTokenForm.name')" class="mt-2" />
                    </div>

                    <!-- Token Permissions -->

                    <div class="col-span-6">
                        <x-input-label for="permissions" value="{{ __('Permissions') }}" />

                        <div class="grid grid-cols-1 gap-4 mt-2 md:grid-cols-2">
                            @foreach ($permissionsList as $permission)
                                <label for="add_permission_{{ $permission }}" class="flex items-center">
                                    <x-box-input wire:model="createApiTokenForm.permissions" :value="$permission"
                                        id="add_permission_{{ $permission }}" />
                                    <span class="ml-2 text-sm text-gray-600">{{ $permission }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                </x-slot>

                <x-slot name="actions">
                    <x-action-message class="mr-3" on="created">
                        {{ __('Created.') }}
                    </x-action-message>

                    <x-primary-button>
                        {{ __('Create') }}
                    </x-primary-button>
                </x-slot>
            </x-form-section>

            <!-- Generated API Token -->
            @if ($this->user->tokens->isNotEmpty())
                <x-section-border />

                <!-- Manage API Tokens -->
                <div class="mt-10 sm:mt-0">
                    <x-action-section>
                        <x-slot name="title">
                            {{ __('Manage API Tokens') }}
                        </x-slot>

                        <x-slot name="description">
                            {{ __('You may delete any of your existing tokens if they are no longer needed.') }}
                        </x-slot>

                        <!-- API Token List -->
                        <x-slot name="content">
                            <div class="space-y-6">
                                @foreach ($this->user->tokens->sortBy('name') as $token)
                                    <div class="flex items-center justify-between">
                                        <div class="break-all">
                                            {{ $token->name }}
                                        </div>

                                        <div class="flex items-center ml-2">
                                            @if ($token->last_used_at)
                                                <div class="text-sm text-gray-400">
                                                    {{ __('Last used') }}
                                                    {{ $token->last_used_at->diffForHumans() }}
                                                </div>
                                            @endif


                                            <button class="ml-6 text-sm text-gray-400 underline cursor-pointer"
                                                wire:click="manageApiTokenPermissions({{ $token->id }})">
                                                {{ __('Permissions') }}
                                            </button>


                                            <button class="ml-6 text-sm text-red-500 cursor-pointer"
                                                wire:click="confirmApiTokenDeletion({{ $token->id }})">
                                                {{ __('Delete') }}
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </x-slot>
                    </x-action-section>
                </div>
            @endif

            <!-- Token Value Modal -->
            <x-modal name="displayingToken">
                <div class="p-6">
                    <x-slot name="title">
                        {{ __('API Token') }}
                    </x-slot>


                    <div>
                        {{ __('Please copy your new API token. For your security, it won\'t be shown again.') }}
                    </div>

                    <x-text-input x-ref="plaintextToken" type="text" readonly :value="$plainTextToken"
                        class="w-full px-4 py-2 my-4 font-mono text-sm text-gray-500 break-all bg-gray-100 rounded"
                        autofocus autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
                        @showing-token-modal.window="setTimeout(() => $refs.plaintextToken.select(), 250)" />


                    <x-secondary-button wire:click="$dispatch('close-modal','displayingToken')"
                        wire:loading.attr="disabled">
                        {{ __('Close') }}
                    </x-secondary-button>
                </div>
            </x-modal>

            <!-- API Token Permissions Modal -->
            <x-modal name="managingApiTokenPermissions">
                <div class="p-6">
                    <x-slot name="title">
                        {{ __('API Token Permissions') }}
                    </x-slot>

                    <div class="grid grid-cols-1 gap-4 mb-3 md:grid-cols-2">
                        @foreach ($permissionsList as $permission)
                            <label for="update_permission_{{ $permission }}" class="flex items-center">
                                <x-box-input wire:model.defer="updateApiTokenForm.permissions" :value="$permission"
                                    id="update_permission_{{ $permission }}" />
                                <span class="ml-2 text-sm text-gray-600">{{ $permission }}</span>
                            </label>
                        @endforeach
                    </div>


                    <x-secondary-button wire:click="$dispatch('close-modal','managingApiTokenPermissions')"
                        wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-primary-button class="ml-3" wire:click="updateApiToken" wire:loading.attr="disabled">
                        {{ __('Save') }}
                    </x-primary-button>
                </div>
            </x-modal>

            <!-- Delete Token Confirmation Modal -->
            <x-modal name="confirmingApiTokenDeletion">
                <div class="p-6">
                    <x-slot name="title">
                        {{ __('Delete API Token') }}
                    </x-slot>

                    <h2 class="mb-3 text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Are you sure you would like to delete this API token?') }}
                    </h2>

                    <x-secondary-button wire:click="$dispatch('close-modal','confirmingApiTokenDeletion')"
                        wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-danger-button class="ml-3" wire:click="deleteApiToken" wire:loading.attr="disabled">
                        {{ __('Delete') }}
                    </x-danger-button>
                </div>
            </x-modal>
        </div>
    </div>
</div>
