<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use GlobalStatus,Searchable;

    protected $guarded = ['id'];

    protected $casts = [
        'extra_service' => 'array'
    ];

    public function service()
    {
    	return $this->belongsTo(Service::class);
    }

    public function software()
    {
    	return $this->belongsTo(Software::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function disputer()
    {
        return $this->belongsTo(User::class, 'disputer_id');
    }

    public function workFiles()
    {
        return $this->hasMany(WorkFile::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    // Scope
    public function scopeCheckServiceBookingData($query, $orderNumber)
    {
        return $query->where('order_number', $orderNumber)->where('service_id', '!=', 0);
    }

    public function scopePending($query)
    {
        return $query->where('status', Status::BOOKING_PENDING);
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

    public function scopeRefunded($query)
    {
        return $query->where('working_status', Status::BOOKING_REFUNDED);
    }

    public function scopeExpired($query)
    {
        return $query->where('status', Status::BOOKING_EXPIRED);
    }

    public function scopeIncomplete($query)
    {
        return $query->where('bookings.service_id', '!=', 0)->whereIn('bookings.status', [Status::BOOKING_UNPAID, Status::BOOKING_PAID, Status::BOOKING_PENDING]);
    }
}
