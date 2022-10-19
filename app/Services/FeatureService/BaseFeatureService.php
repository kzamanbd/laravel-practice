<?php


namespace App\Services\FeatureService;


use App\Models\Feature;
use App\Services\Contracts\FeatureServiceContract;
use App\Services\PermissionService\PermissionService;
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
     * @param int $id
     * @return Feature|Collection
     */
    public function show(int $id): Feature
    {
        return Feature::findOrFail($id);
    }

    /**
     * Create a new feature
     *
     * @param string $slug Feature slug
     * @param string|null $description
     * @return Feature Created feature
     */
    public function store(string $slug, ?string $description = null): Feature
    {
        $name = $this->availableFeatureItemsToCreate()[$slug]['name'];

        $feature = Feature::create([
            'name' => $name,
            'slug' => $slug,
            'description' => $description
        ]);

        // generate permissions for features
        (new PermissionService())->generateAllPermissions();

        return $feature;
    }

    /**
     * Soft delete feature
     *
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function softDelete(int $id): bool
    {
        return Feature::findOrFail($id)->delete();
    }

    /**
     * Available all feature items
     *
     * @return array
     */
    public function allFeatureItems(): array
    {
        return config('features.available');
    }

    /**
     * Available feature items to create feature
     *
     * @return array
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
