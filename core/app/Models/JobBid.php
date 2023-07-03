<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class JobBid extends Model
{
    use  GlobalStatus;

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function disputer()
    {
        return $this->belongsTo(User::class, 'disputer_id');
    }

    public function job()
    {
    	return $this->belongsTo(Job::class);
    }

    public function workFiles()
    {
        return $this->hasMany(WorkFile::class);
    }

    public function scopeCompleted($query)
    {
        return $query->where('working_status', Status::WORKING_COMPLETED);
    }

    public function scopeDelivered($query)
    {
        return $query->where('working_status', Status::WORKING_DELIVERED);
    }

    public function scopeInprogress($query)
    {
        return $query->where('working_status', Status::WORKING_INPROGRESS);
    }

    public function scopeDisputed($query)
    {
        return $query->where('working_status', Status::WORKING_DISPUTED);
    }

    public function scopeExpired($query)
    {
        return $query->where('status', Status::BOOKING_EXPIRED);
    }
}
