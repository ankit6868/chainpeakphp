<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\{
    GlobalStatus,
    Searchable,
};
use Illuminate\Database\Eloquent\{
    Model,
    Casts\Attribute,
};

class Coupon extends Model
{
    use Searchable, GlobalStatus;

    public function typeBadge(): Attribute
    {
        return new Attribute(function() {
            $html = '';

            if ($this->type == 1) {
                $html = '<span class="badge badge--success">' . trans("Fixed") . '</span>';
            } else {
                $html = '<span class="badge badge--primary">' . trans("Percentage") . '</span>';
            }
            return $html;
        });
    }
    public function valueData(): Attribute
    {
        return new Attribute(function() {
            $html = '';

            if ($this->type == Status::FIXED) {
                $html = showAmount($this->value) . ' ' . trans(gs()->cur_text);
            } else {
                $html = showAmount($this->value) . ' ' . '%';
            }
            return $html;
        });
    }
}
