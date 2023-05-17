<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Feature extends Model
{
    protected $guarded = [];

    // get sub menu by parent id
    public function children(): HasMany
    {
        return $this->child()->with('children');
    }

    // recursive children
    public function child(): HasMany
    {
        return $this->hasMany(Feature::class, 'parent_id');
    }
}
