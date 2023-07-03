<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'access_permissions' => 'array'
    ];

    use GlobalStatus;

    public function access($permission)
    {
        return  in_array(titleToKey($permission), $this->access_permissions ?? []);
    }
}
