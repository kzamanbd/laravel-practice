<?php


namespace App\Services\MenuService;


use App\Models\Menu;
use App\Services\Contracts\MenuServiceContract;
use App\Services\PermissionService\PermissionService;
use Illuminate\Support\Collection;

abstract class BaseMenuService implements MenuServiceContract
{
    /**
     * Created menu items
     *
     * @return Menu[]|Collection
     */
    public function createdMenuItems(): Collection
    {
        return Menu::all();
    }

    /**
     * Menu details
     *
     * @param int $id
     * @return Menu|Collection
     */
    public function show(int $id): Menu
    {
        return Menu::findOrFail($id);
    }

    /**
     * Create a new menu
     *
     * @param string $slug Menu slug
     * @param string|null $description
     * @return Menu Created menu
     */
    public function store(string $slug, ?string $description = null): Menu
    {
        $name = $this->availableMenuItemsToCreate()[$slug]['name'];

        $menu = Menu::create([
            'name' => $name,
            'slug' => $slug,
            'description' => $description
        ]);

        // generate permissions for menus
        (new PermissionService())->generateAllPermissions();

        return $menu;
    }

    /**
     * Soft delete menu
     *
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function softDelete(int $id): bool
    {
        return Menu::findOrFail($id)->delete();
    }

    /**
     * Available all menu items
     *
     * @return array
     */
    public function allMenuItems(): array
    {
        return config('menus.available');
    }

    /**
     * Available menu items to create menu
     *
     * @return array
     */
    public function availableMenuItemsToCreate(): array
    {
        $created_menus =  $this->createdMenuItems()->pluck('slug')->toArray();

        $all_menus = collect($this->allMenuItems());

        return $all_menus->filter(function ($menu, $index) use ($created_menus){
           return !in_array($index, $created_menus);
        })->toArray();
    }
}
