<?php

namespace DraftScripts\Permission\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Feature extends Model
{
    protected $guarded = [];

    // get sub menu by parent id recursive children
    public function children(): HasMany
    {
        return $this->hasMany($this, 'parent_id')->with('children');
    }
}
