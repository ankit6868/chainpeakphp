<?php

namespace App\Models;

use App\Traits\{
    GlobalStatus,
    Searchable,
};
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use Searchable, GlobalStatus;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
