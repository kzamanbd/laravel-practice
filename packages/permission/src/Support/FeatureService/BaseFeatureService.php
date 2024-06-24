<?php

namespace DraftScripts\Permission\Support\FeatureService;


use DraftScripts\Permission\Contracts\FeatureServiceContract;
use DraftScripts\Permission\Support\PermissionService\PermissionService;
use DraftScripts\Permission\Models\Feature;
use Illuminate\Support\Collection;

abstract class BaseFeatureService implements FeatureServiceContract
{
    /**
     * Created feature items
     *
     * @return Feature[]|Collection
     */
    public function createdFeatureItems(): Collection
    {
        return Feature::all();
    }

    /**
     * Feature details
     *
     * @return Feature|Collection
     */
    public function show(int $id): Feature
    {
        return Feature::findOrFail($id);
    }

    /**
     * Create a new feature
     *
     * @param  string  $slug Feature slug
     * @return Feature Created feature
     */
    public function store(string $slug, ?string $description = null): Feature
    {
        $name = $this->availableFeatureItemsToCreate()[$slug]['name'];

        $feature = Feature::create([
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
        ]);

        // generate permissions for features
        (new PermissionService())->generateAllPermissions();

        return $feature;
    }

    /**
     * Soft delete feature
     *
     * @throws \Exception
     */
    public function softDelete(int $id): bool
    {
        return Feature::findOrFail($id)->delete();
    }

    /**
     * Available all feature items
     */
    public function allFeatureItems(): array
    {
        return config('lara-features.available');
    }

    /**
     * Available feature items to create feature
     */
    public function availableFeatureItemsToCreate(): array
    {
        $created_features = $this->createdFeatureItems()->pluck('slug')->toArray();

        $all_features = collect($this->allFeatureItems());

        return $all_features->filter(function ($feature, $index) use ($created_features) {
            return !in_array($index, $created_features);
        })->toArray();
    }
}
