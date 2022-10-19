<?php


namespace App\Services\Contracts;


use App\Models\Feature;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

interface FeatureServiceContract
{
    /**
     * Created feature items
     *
     * @return Feature[]|Collection
     */
    public function createdFeatureItems(): Collection;

    /**
     * Create a new feature
     * @param string $slug
     * @param string|null $description
     * @return Feature
     */
    public function store(string $slug, ?string $description = null): Feature;

    /**
     * Available all feature items
     *
     * @return array
     */
    public function allFeatureItems(): array;

    /**
     * Available feature items to create feature
     *
     * @return array
     */
    public function availableFeatureItemsToCreate(): array;
}
