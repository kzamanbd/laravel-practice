<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class ApiTokenManager extends Component
{
    public static $defaultPermissions = ['read'];

    public $permissionsList = ['create', 'read', 'update', 'delete'];

    /**
     * The permissions that exist within the application.
     *
     * @var array
     */
    public static $permissions = [];

    /**
     * The create API token form state.
     *
     * @var array
     */
    public $createApiTokenForm = [
        'name' => '',
        'permissions' => [],
    ];

    /**
     * The plain text token value.
     *
     * @var string|null
     */
    public $plainTextToken;

    /**
     * The token that is currently having its permissions managed.
     *
     * @var \Laravel\Sanctum\PersonalAccessToken|null
     */
    public $managingPermissionsFor;

    /**
     * The update API token form state.
     *
     * @var array
     */
    public $updateApiTokenForm = [
        'permissions' => [],
    ];

    /**
     * The ID of the API token being deleted.
     *
     * @var int
     */
    public $apiTokenIdBeingDeleted;

    /**
     * Mount the component.
     *
     * @return void
     */
    public function mount()
    {
        $this->createApiTokenForm['permissions'] = self::$defaultPermissions;
    }

    /**
     * Return the permissions in the given list that are actually defined permissions for the application.
     *
     * @return array
     */
    public static function validPermissions(array $permissions)
    {
        return array_values(array_intersect($permissions, static::$permissions));
    }

    /**
     * Create a new API token.
     *
     * @return void
     */
    public function createApiToken()
    {
        $this->resetErrorBag();

        Validator::make([
            'name' => $this->createApiTokenForm['name'],
        ], [
            'name' => ['required', 'string', 'max:255'],
        ])->validateWithBag('createApiToken');

        $this->displayTokenValue($this->user->createToken(
            $this->createApiTokenForm['name'],
            $this->createApiTokenForm['permissions']
        ));

        $this->createApiTokenForm['name'] = '';
        $this->createApiTokenForm['permissions'] = self::$defaultPermissions;

        $this->dispatch('created');
    }

    /**
     * Display the token value to the user.
     *
     * @param  \Laravel\Sanctum\NewAccessToken  $token
     * @return void
     */
    protected function displayTokenValue($token)
    {
        $this->dispatch('open-modal', 'displayingToken');

        $this->plainTextToken = explode('|', $token->plainTextToken, 2)[1];

        $this->dispatch('showing-token-modal');
    }

    /**
     * Allow the given token's permissions to be managed.
     *
     * @param  int  $tokenId
     * @return void
     */
    public function manageApiTokenPermissions($tokenId)
    {
        $this->dispatch('open-modal', 'managingApiTokenPermissions');

        $this->managingPermissionsFor = $this->user->tokens()->where(
            'id',
            $tokenId
        )->firstOrFail();

        $this->updateApiTokenForm['permissions'] = $this->managingPermissionsFor->abilities;
    }

    /**
     * Update the API token's permissions.
     *
     * @return void
     */
    public function updateApiToken()
    {
        $this->managingPermissionsFor->forceFill([
            'abilities' => $this->updateApiTokenForm['permissions'],
        ])->save();

        $this->dispatch('close-modal', 'managingApiTokenPermissions');
    }

    /**
     * Confirm that the given API token should be deleted.
     *
     * @param  int  $tokenId
     * @return void
     */
    public function confirmApiTokenDeletion($tokenId)
    {
        $this->dispatch('open-modal', 'confirmingApiTokenDeletion');

        $this->apiTokenIdBeingDeleted = $tokenId;
    }

    /**
     * Delete the API token.
     *
     * @return void
     */
    public function deleteApiToken()
    {
        $this->user->tokens()->where('id', $this->apiTokenIdBeingDeleted)->first()->delete();

        $this->user->load('tokens');

        $this->dispatch('close-modal', 'confirmingApiTokenDeletion');

        $this->managingPermissionsFor = null;
    }

    /**
     * Get the current user of the application.
     *
     * @return mixed
     */
    public function getUserProperty()
    {
        return Auth::user();
    }

    public function render()
    {
        return view('livewire.api-token-manager');
    }
}
