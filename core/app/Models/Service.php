<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use Searchable, GlobalStatus;

    protected $casts = [
        'tag'         => 'array',
        'features'    => 'array',
        'extra_image' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function extraServices()
    {
        return $this->hasMany(ExtraService::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

}
