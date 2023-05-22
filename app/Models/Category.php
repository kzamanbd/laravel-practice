<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    // get sub menu by parent id recursive children
    public function children(): HasMany
    {
        return $this->hasMany($this, 'parent_id')->with('children');
    }
}
