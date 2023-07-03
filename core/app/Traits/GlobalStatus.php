<?php

namespace App\Traits;

use App\Constants\Status;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait GlobalStatus
{
    public static function changeStatus($id, $column = 'status')
    {
        $modelName = get_class();
        $query     = $modelName::findOrFail($id);
        if ($query->$column == Status::ENABLE) {
            $query->$column = Status::DISABLE;
        } else {
            $query->$column = Status::ENABLE;
        }
        $message       = keyToTitle($column) . ' changed successfully';

        $query->save();
        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';
            if ($this->status == Status::ENABLE) {
                $html = '<span class="badge badge--success">' . trans('Enabled') . '</span>';
            } else {
                $html = '<span><span class="badge badge--warning">' . trans('Disabled') . '</span></span>';
            }
            return $html;
        });
    }

    public function customStatusBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';

            if ($this->status == Status::APPROVED) {
                $html = '<span class="badge badge--success">' . trans("Approved") . '</span>';
            } elseif ($this->status == Status::PENDING) {
                $html = '<span class="badge badge--warning">' . trans("Pending") . '</span> <br> ' . diffforhumans($this->updated_at);
            } elseif ($this->status == Status::CLOSED) {
                $html = '<span class="badge badge--primary">' . trans("Closed") . '</span>';
            } else {
                $html = '<span class="badge badge--danger">' . trans("Canceled") . '</span>';
            }

            return $html;
        });
    }

    public function bookingStatusBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';

            if ($this->status == Status::BOOKING_PENDING) {
                $html = '<span class="badge badge--warning">' . trans("Pending") . '</span>';
            } elseif ($this->status == Status::BOOKING_APPROVED) {
                $html = '<span class="badge badge--success">' . trans("Approved") . '</span> ';
            } elseif ($this->status == Status::BOOKING_REFUNDED) {
                $html = '<span class="badge badge--danger">' . trans("Refunded") . '</span>';
            } elseif ($this->status == Status::BOOKING_EXPIRED) {
                $html = '<span class="badge badge--danger">' . trans("Expired") . '</span>';
            }

            return $html;
        });
    }

    public function workingStatusBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';

            if ($this->working_status == Status::WORKING_COMPLETED) {
                $html = '<span class="badge badge--success">' . trans("Completed") . '</span>';
            } elseif ($this->working_status == Status::WORKING_DELIVERED) {
                $html = '<span class="badge badge--primary">' . trans("Delivered") . '</span>';
            } elseif ($this->working_status == Status::WORKING_INPROGRESS) {
                $html = '<span class="badge badge--info">' . trans("Inprogress") . '</span>';
            } elseif ($this->working_status == Status::WORKING_EXPIRED) {
                $html = '<span class="badge badge--danger">' . trans("Expired") . '</span>';
            } elseif ($this->working_status == Status::WORKING_DISPUTED) {
                $html = '<span class="badge badge--warning">' . trans("Disputed") . '</span> <button class="btn-info btn-rounded text-white  badge disputeShow" data-bs-toggle="tooltip" data-bs-placement="top" title="' . trans("Dispute Reason") . '" data-dispute="' . $this->reason . '"><i class="fa fa-info"></i></button>';
            } else {
                $html = '<span class="badge badge--warning">' . trans("N/A") . '</span>';
                return $html;
            }

            $html .= '<br>' . diffforhumans($this->updated_at);

            return $html;
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status', Status::ENABLE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', Status::DISABLE);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', Status::YES);
    }

    public function scopeUserActiveCheck($query)
    {
        return $query->whereHas('user', function ($user) {
            $user->active();
        });
    }

    public function scopeNotAuthUser($query)
    {
        return $query->whereHas('user', function ($user) {
            $user->active()->where('id', '!=', auth()->id());
        });
    }

    public function scopeCheckData($query)
    {
        return $query->whereHas('category', function ($category) {
            $category->active();
        })->whereHas('subCategory', function ($subCategory) {
            $subCategory->active();
        });
    }

    public function scopePending($query)
    {
        return $query->where('status', Status::PENDING);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', Status::APPROVED);
    }

    public function scopeCanceled($query)
    {
        return $query->where('status', Status::CANCELED);
    }

    public function scopeClosed($query)
    {
        return $query->where('status', Status::CLOSED);
    }


}
