<?php

namespace App\Models;

use App\Traits\{
    GlobalStatus,
    Searchable,
};
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Searchable, GlobalStatus;

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
