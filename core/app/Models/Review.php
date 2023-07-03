<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function service()
    {
    	return $this->belongsTo(Service::class);
    }

    public function software()
    {
    	return $this->belongsTo(Software::class);
    }
}
