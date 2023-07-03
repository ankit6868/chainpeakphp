<?php

namespace App\Models;

use App\Traits\{
    GlobalStatus,
    Searchable,
};
use Illuminate\Database\Eloquent\Model;


class Feature extends Model
{
    use Searchable, GlobalStatus;
}
