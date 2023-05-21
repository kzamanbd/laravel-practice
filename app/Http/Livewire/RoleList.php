<?php

namespace App\Http\Livewire;

use App\Exceptions\PermissionForPropertyIsNotDeclaredInControllerException;
use App\Http\Controllers\PermissionForPropertyValidation;
use App\Services\FeatureService\FeatureService;
use App\Services\PermissionService\PermissionService;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class RoleList extends Component
{
    use PermissionForPropertyValidation;

    protected string $permission_for = 'roles';

    public $openModal = false;
    public $editableMode = false;
    public $name, $description, $permissions = [];

    public $searchKey, $roleId;
    protected $queryString = ['searchKey' => ['except' => '']];
    public $sortColumnName = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 25;
    public $selectedPage = false, $selectedItem = [];

    protected $rules = [
        'name' => 'required|string|max:255|unique:roles',
        'description' => 'nullable|string',
        'permissions' => 'nullable|array',
    ];
    protected $listeners = [
        'deleteConfirmed' => 'deleteConfirmed'
    ];

    /**
     * @param $value
     * @return void
     */
    public function updatedSelectedPage($value): void
    {
        $this->selectedItem = $value ? $this->roles->pluck('id')->toArray() : [];
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

    public function create()
    {
        $this->openModal = true;
    }

    public function store()
    {
        // check permission
        $this->hasPermission('create');

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

    public function editItem($id)
    {
        $this->roleId = $id;
        $this->openModal = true;
        $this->editableMode = true;
        $role = Role::with('permissions')->findOrFail($id);
        $this->name = $role->name;
        $this->description = $role->description;
        $this->permissions = $role->permissions->pluck('id')->toArray();
    }

    public function update()
    {
        // check permission
        $this->hasPermission('update');

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

    /**
     * @param $id
     * @return void
     */
    public function deleteItem($id): void
    {
        $this->dispatchBrowserEvent('show-delete-confirmation');
        $this->roleId = $id;
    }

    /**
     * @return void
     * @throws PermissionForPropertyIsNotDeclaredInControllerException
     */
    public function deleteConfirmed(): void
    {
        // check permission
        $this->hasPermission('delete');
        Role::destroy($this->roleId);
    }

    /**
     * @return View
     * @throws PermissionForPropertyIsNotDeclaredInControllerException
     */
    public function render(): View
    {
        $this->hasPermission('view');

        return view('livewire.role-list')->layoutData([
            'title' => 'Role List',
        ]);
    }
}
