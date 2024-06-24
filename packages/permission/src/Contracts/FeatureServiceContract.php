<?php

namespace DraftScripts\Permission\Contracts;


use DraftScripts\Permission\Models\Feature;
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
     */
    public function store(string $slug, ?string $description = null): Feature;

    /**
     * Available all feature items
     */
    public function allFeatureItems(): array;

    /**
     * Available feature items to create feature
     */
    public function availableFeatureItemsToCreate(): array;
}
