<?php

namespace DraftScripts\Permission\Livewire;

use DraftScripts\Permission\Exports\UserExport;
use DraftScripts\Permission\Mail\AccountVerification;
use DraftScripts\Permission\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class UserManagement extends PermissionLayout
{
    use WithPagination;

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

    public function store(): void
    {
        if ($this->editableMode) {
            $this->update();
            return;
        }

        $this->validate();

        try {
            $user = new User;
            $user->name = $this->name;
            $user->email = $this->email;
            $user->password = bcrypt($this->password);
            $user->save();
            // assign role
            $user->syncRoles($this->roles);

            $this->reset();
            $this->dispatch('success', 'User Successfully Created.');
            $this->dispatch('close-modal', 'create-modal');
        } catch (\Exception $exception) {
            $this->dispatch('error', $exception->getMessage());
        }
    }

    public function editItem($id): void
    {
        // fetch user
        $user = User::find($id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->roles = $user->roles->pluck('name')->toArray();
        $this->editableMode = true;
        $this->dispatch('open-modal', 'create-modal');
        $this->userId = $id;
    }

    public function update(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'roles' => 'nullable|array',
        ]);

        try {
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
            $this->dispatch('close-modal', 'create-modal');
        } catch (\Exception $exception) {
            $this->dispatch('error', $exception->getMessage());
        }
    }

    public function deleteItem($id): void
    {
        $this->dispatch('confirm-modal', action: 'deleteUserConfirmed', data: ['userId' => $id]);
        $this->userId = $id;
    }

    #[On('deleteUserConfirmed')]
    public function deleteConfirmed(): void
    {
        User::destroy($this->userId);
        $this->dispatch('success', 'User deleted successfully');
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
        return view('lara-permission::livewire.users');
    }
}
