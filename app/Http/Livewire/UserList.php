<?php

namespace App\Http\Livewire;

use App\Exceptions\PermissionForPropertyIsNotDeclaredInControllerException;
use App\Exports\UserExport;
use App\Http\Controllers\PermissionForPropertyValidation;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class UserList extends Component
{
    use WithPagination, PermissionForPropertyValidation;

    protected string $permission_for = 'users';
    public $openModal = false;
    public $name, $email, $password, $password_confirmation, $roles = [];
    public $editableMode = false, $userId, $searchKey;

    protected $queryString = ['searchKey' => ['except' => '']];
    public $sortColumnName = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 25;

    public $selectedPage = false;
    public $selectedItem = [];


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
     * @param $value
     * @return void
     */
    public function updatedSelectedPage($value): void
    {
        $this->selectedItem = $value ? $this->users->pluck('id')->toArray() : [];
    }

    /**
     * @return void
     */
    public function updatedSelectedItem(): void
    {
        $this->selectedPage = false;
    }

    /**
     * @param $columnName
     * @return void
     */
    public function sortBy($columnName): void
    {
        if ($this->sortColumnName === $columnName) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortColumnName = $columnName;
    }


    /**
     * @return LengthAwarePaginator
     */
    public function getUsersProperty(): LengthAwarePaginator
    {
        return User::with(['roles'])
            ->where('id', '!=', auth()->id())
            ->where('name', 'like', "%{$this->searchKey}%")
            ->orWhere('email', 'like', "%{$this->searchKey}%")
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->perPage);
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
        $this->openModal = true;
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
    public function editItem($id): void
    {
        // check permission
        $this->hasPermission('update');
        // fetch user
        $user = User::find($id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->roles = $user->roles->pluck('id')->toArray();
        $this->openModal = true;
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
        $this->openModal = false;
    }

    /**
     * @param $id
     * @return void
     */
    public function deleteItem($id): void
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


    public function exportExcel(string $type = 'xlsx')
    {
        $date = now()->format('d-M-Y-H-i-s');
        $filename = "users-{$date}.$type";

        if ($type == 'csv') {
            return Excel::download(new UserExport, $filename, \Maatwebsite\Excel\Excel::CSV);
        } else {
            return Excel::download(new UserExport, $filename, \Maatwebsite\Excel\Excel::XLSX);
        }
    }

    /**
     * @return View
     * @throws PermissionForPropertyIsNotDeclaredInControllerException
     */
    public function render(): View
    {
        // check permission
        $this->hasPermission('view');

        return view('livewire.user-list')->layoutData([
            'title' => 'User List',
        ]);
    }
}
