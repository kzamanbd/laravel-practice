<?php

namespace App\Livewire;

use App\Exports\UserExport;
use App\Http\Controllers\PermissionForPropertyException;
use App\Http\Controllers\PermissionForPropertyValidation;
use App\Mail\AccountVerification;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class UserManagement extends Component
{
    use WithPagination, PermissionForPropertyValidation;

    protected string $permission_for = 'users';

    public $searchKey;

    public $sortColumnName = 'created_at';

    public $sortDirection = 'desc';

    public $perPage = 25;

    public $selectedPage = false;

    public $selectedItem = [];

    protected $queryString = ['searchKey'];

    protected $listeners = [
        'deleteConfirmed' => 'deleteConfirmed',
    ];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed|min:8',
        'roles' => 'nullable|array',
    ];

    public $userId;

    public $name;

    public $email;

    public $password;

    public $password_confirmation;

    public $roles = [];
    public $editableMode = false;

    public function updatedSelectedPage($value): void
    {
        $this->selectedItem = $value ? $this->users->pluck('id')->toArray() : [];
    }

    public function updatedSelectedItem(): void
    {
        $this->selectedPage = false;
    }

    public function sortBy($columnName): void
    {
        if ($this->sortColumnName === $columnName) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortColumnName = $columnName;
    }

    public function getUsersProperty(): LengthAwarePaginator
    {
        return User::with(['roles'])
            ->where('id', '!=', auth()->id())
            ->where('name', 'like', "%{$this->searchKey}%")
            ->orWhere('email', 'like', "%{$this->searchKey}%")
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function getRolesListProperty(): Collection
    {
        return Role::all();
    }


    public function sendNotification(): void
    {
        $users = User::query()->limit(5)->get();
        foreach ($users as $user) {
            Mail::to($user->email)->queue(new AccountVerification($user));
        }

        $this->dispatch('success', 'Notification successfully send.');
    }

    /**
     * @throws PermissionForPropertyException
     */
    public function create(): void
    {
        // check permission
        $this->hasPermission('create');
    }

    /**
     * @throws PermissionForPropertyException
     */
    public function store(): void
    {
        if ($this->editableMode) {
            $this->update();
            return;
        }
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
     * @throws PermissionForPropertyException
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
        $this->editableMode = true;
        $this->userId = $id;
    }

    /**
     * @throws PermissionForPropertyException
     */
    public function update(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'roles' => 'nullable|array',
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
        $this->editableMode = false;
        $this->reset();
    }

    public function deleteItem($id): void
    {
        $this->dispatch('confirm-modal', action: 'deleteUserConfirmed', data: ['userId' => $id]);
        $this->userId = $id;
    }

    #[On('deleteUserConfirmed')]
    public function deleteConfirmed(): void
    {
        // check permission
        $this->hasPermission('delete');
        User::destroy($this->userId);
        $this->dispatch('notify', 'User deleted successfully');
    }

    public function exportExcel(string $type = 'xlsx')
    {
        $date = now()->format('d-M-Y-H-i-s');
        $filename = "users-{$date}.$type";

        if ($type == 'csv') {
            return Excel::download(new UserExport, $filename, 'Csv');
        }

        return Excel::download(new UserExport, $filename, 'Xlsx');
    }


    public function render(): View
    {
        // check permission
        $this->hasPermission('view');

        return view('livewire.users');
    }
}
