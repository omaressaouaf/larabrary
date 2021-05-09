<?php

use Illuminate\Database\Seeder;
use App\Coupon;

class CouponTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $coupon=new Coupon();
        $coupon->code="abc";
        $coupon->percent_off=60;
        $coupon->save();


        $coupon=new Coupon();
        $coupon->code="def";
        $coupon->percent_off=30;
        $coupon->save();

    }
}
