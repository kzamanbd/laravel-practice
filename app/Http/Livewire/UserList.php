<?php

namespace App\Http\Livewire;

use App\Exceptions\PermissionForPropertyIsNotDeclaredInControllerException;
use App\Http\Controllers\PermissionForPropertyValidation;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UserList extends Component
{
    use WithPagination, PermissionForPropertyValidation;

    protected $permission_for = 'user';
    public $userCreateOrUpdateModal = false;
    public $name, $email, $password, $password_confirmation, $roles = [];
    public $editableMode = false, $userId;

    protected $listeners = [
        'deleteConfirmed' => 'deleteConfirmed'
    ];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed|min:8',
        'roles' => 'nullable|array'
    ];


    /**
     * @return LengthAwarePaginator
     */
    public function getUsersProperty(): LengthAwarePaginator
    {
        return User::with(['roles'])->latest()->paginate(30);
    }

    /**
     * @return Collection
     */
    public function getRolesListProperty(): Collection
    {
        return Role::all();
    }

    /**
     * @return void
     * @throws PermissionForPropertyIsNotDeclaredInControllerException
     */
    public function create(): void
    {
        // check permission
        $this->hasPermission('create');
        $this->userCreateOrUpdateModal = true;
    }

    /**
     * @return void
     * @throws PermissionForPropertyIsNotDeclaredInControllerException
     */
    public function store(): void
    {
        $this->validate();
        // check permission
        $this->hasPermission('create');

        $user = new User;
        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = bcrypt($this->password);
        $user->save();
        // assign role
        $user->syncRoles($this->roles);

        $this->reset();
    }

    /**
     * @param $id
     * @return void
     * @throws PermissionForPropertyIsNotDeclaredInControllerException
     */
    public function edit($id): void
    {
        // check permission
        $this->hasPermission('update');
        // fetch user
        $user = User::find($id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->roles = $user->roles->pluck('id')->toArray();
        $this->userCreateOrUpdateModal = true;
        $this->editableMode = true;
        $this->userId = $id;
    }

    /**
     * @return void
     * @throws PermissionForPropertyIsNotDeclaredInControllerException
     */
    public function update(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'roles' => 'nullable|array'
        ]);

        // check permission
        $this->hasPermission('update');

        $user = User::find($this->userId);
        $user->name = $this->name;
        $user->email = $this->email;
        if ($this->password) {
            $user->password = bcrypt($this->password);
        }
        $user->save();
        // assign role
        $user->syncRoles($this->roles);
        $this->reset();
        $this->editableMode = false;
        $this->userCreateOrUpdateModal = false;
    }

    /**
     * @param $id
     * @return void
     */
    public function deleteUser($id): void
    {
        $this->dispatchBrowserEvent('show-delete-confirmation');
        $this->userId = $id;
    }

    /**
     * @return void
     * @throws PermissionForPropertyIsNotDeclaredInControllerException
     */
    public function deleteConfirmed(): void
    {
        // check permission
        $this->hasPermission('delete');
        User::destroy($this->userId);
    }

    /**
     * @return View
     * @throws PermissionForPropertyIsNotDeclaredInControllerException
     */
    public function render(): View
    {
        // check permission
        $this->hasPermission('view');

        return view('livewire.user-list');
    }
}
