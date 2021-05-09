<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Coupon;

class CouponController extends Controller
{
    public function store(Request $request)
    {
        $coupon = Coupon::where('code', $request->code)->first();
        if (!$coupon) {
            return redirect()->route('checkout')->with('error_alert', "Invalid coupon Code . Try Another One");
        }
        if ($coupon->discount(Cart::subtotal()) <= Cart::subtotal()) {
            
        }
        session()->put('coupon', [
            'code' => $coupon->code,
            'discount' => $coupon->discount(Cart::subtotal())
        ]);
        return redirect()->route('checkout')->with('success_alert', "Coupon has been Applied Successfully");
    }
    public function destroy()
    {
        session()->forget('coupon');
        return redirect()->route('checkout')->with('success_alert', "Coupon has been Removed");
    }
}
