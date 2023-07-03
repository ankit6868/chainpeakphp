<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{

    public function service()
    {
    	return $this->belongsTo(Service::class);
    }

    public function software()
    {
    	return $this->belongsTo(Software::class);
    }
}
