<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public function findByCode($code)
    {
        return self::where('code', $code)->first();
    }
    public function discount($total)
    {
        return ($this->percent_off / 100) * $total;
    }
}
