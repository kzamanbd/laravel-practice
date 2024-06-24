<?php

namespace Draftscripts\Permission\Livewire;

use Draftscripts\Permission\Support\FeatureService\FeatureService;
use Draftscripts\Permission\Support\PermissionService\PermissionService;
use Illuminate\Contracts\View\View;
use Spatie\Permission\Models\Role;

class RoleManagement extends PermissionLayout
{
    public $openModal = false;

    public $editableMode = false;

    public $name;

    public $description;

    public $permissions = [];

    public $searchKey;

    public $roleId;

    protected $queryString = ['searchKey' => ['except' => '']];

    public $sortColumnName = 'created_at';

    public $sortDirection = 'desc';

    public $perPage = 25;

    public $selectedPage = false;

    public $selectedItem = [];

    protected $rules = [
        'name' => 'required|string|max:255|unique:roles',
        'description' => 'nullable|string',
        'permissions' => 'nullable|array',
    ];

    protected $listeners = [
        'deleteConfirmed' => 'deleteConfirmed',
    ];

    public function updatedSelectedPage($value): void
    {
        $this->selectedItem = $value ? $this->roles->pluck('id')->toArray() : [];
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

    public function getRolesProperty()
    {
        return Role::query()
            ->where('name', 'like', '%' . $this->searchKey . '%')
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function getFeaturesProperty(FeatureService $featureService)
    {
        return $featureService->createdFeatureItems();
    }

    public function getPermissionsListProperty(PermissionService $permissionService)
    {
        return $permissionService->permissions();
    }

    public function create(): void
    {
        $this->openModal = true;
    }

    public function store(): void
    {
        if ($this->editableMode) {
            $this->update();
            return;
        }

        $this->validate();

        // create a new rule
        $role = Role::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        if (is_array($this->permissions)) {
            // sync permission role
            $role->syncPermissions($this->permissions);
        }

        // reset form
        $this->reset();
        $this->openModal = false;
    }

    public function editItem($id): void
    {
        $this->roleId = $id;
        $this->openModal = true;
        $this->editableMode = true;
        $role = Role::with('permissions')->findOrFail($id);
        $this->name = $role->name;
        $this->description = $role->description;
        $this->permissions = $role->permissions->pluck('id')->toArray();
    }

    public function update(): void
    {

        $this->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $this->roleId,
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
        ]);

        $role = Role::findOrFail($this->roleId);
        $role->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        if (is_array($this->permissions)) {
            // sync permission role
            $role->syncPermissions($this->permissions);
        }

        // reset form
        $this->reset();
        $this->openModal = false;
        $this->editableMode = false;
    }

    public function deleteItem($id): void
    {
        $this->dispatchBrowserEvent('show-delete-confirmation');
        $this->roleId = $id;
    }

    public function deleteConfirmed(): void
    {
        Role::destroy($this->roleId);
    }

    public function render(): View
    {
        return view('lara-permission::livewire.roles');
    }
}