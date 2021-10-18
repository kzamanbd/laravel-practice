<?php


namespace App\Services\Contracts;


use App\Models\Menu;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

interface MenuServiceContract
{
    /**
     * Created menu items
     *
     * @return Menu[]|Collection
     */
    public function createdMenuItems(): Collection;

    /**
     *      * Create a new menu

     *
     * @param string $slug
     * @param string|null $description
     * @return Menu
     */
    public function store(string $slug, ?string $description = null): Menu;

    /**
     * Available all menu items
     *
     * @return array
     */
    public function allMenuItems(): array;

    /**
     * Available menu items to create menu
     *
     * @return array
     */
    public function availableMenuItemsToCreate(): array;
}
