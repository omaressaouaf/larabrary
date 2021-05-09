<?php

namespace App\Http\Controllers;

use App\BookOrder;
use App\Http\Requests\CheckoutRequest;
use App\Order;
use App\Book;
use App\Mail\OrderEmail;
use Exception;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Cartalyst\Stripe\Exception\CardErrorException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            clearUnavailableItems();

            if (Cart::instance('default')->count() <= 0) {
                return redirect()->route('cart')->with('error_alert', "You Cannot Checkout  With an Empty Cart");
            }



            return view('pages.checkout.checkout')->with([
                'discount' => $this->getNumbers()->get('discount'),
                'newSubTotal' => $this->getNumbers()->get('newSubTotal'),
                'newTax' => $this->getNumbers()->get('newTax'),
                'newTotal' => $this->getNumbers()->get('newTotal')
            ]);
        } catch (Exception $e) {
            return redirect()->route('cart')->with('error_alert', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CheckoutRequest $request)
    {

        if (Cart::instance('default')->count() <= 0) {
            return redirect()->route('cart')->with('error_alert', "You Cannot Checkout  With an Empty Cart");
        }

        try {

            if ($request->stripeToken) {
                $contents = Cart::instance('default')->content()->map(function ($item) {
                    return $item->model->slug . ', (' . $item->qty . ')';
                })->values()->toJson();
                $charge = Stripe::charges()->create([
                    'amount' => $this->getNumbers()->get('newTotal'),
                    'currency' => 'USD',
                    'source' => $request->stripeToken,
                    'description' => 'Order',
                    'receipt_email' => $request->email,
                    'metadata' => [
                        'contents' => $contents,
                        'total items' => Cart::instance('default')->count(),
                        'discount' => collect(session()->get('coupon'))->toJson()
                    ],
                ]);
                $payment_mode = "stripe";
                $card_holder_name = $request->card_holder_name;
            } else {

                $payment_mode = "cash";
                $card_holder_name = null;
            }



            //insert into orders table
            $order = Order::create([
                'user_id' => auth()->user()->id,
                'billing_email' => $request->email,
                'billing_full_name' => $request->full_name,
                'billing_address' => $request->address,
                'billing_country' => $request->country,
                'billing_state' => $request->state,
                'billing_city' => $request->city,
                'billing_zip' => $request->zip,
                'billing_phone' => $request->phone,
                'billing_card_holder_name' => $card_holder_name,
                'billing_email' => $request->email,
                'billing_subtotal' => $this->getNumbers()->get('newSubTotal'),
                'billing_tax' =>  $this->getNumbers()->get('newTax'),
                'billing_total' =>  $this->getNumbers()->get('newTotal'),
                'billing_discount' =>  $this->getNumbers()->get('discount'),
                'billing_discount_code' =>  $this->getNumbers()->get('code'),
                'payment_mode' => $payment_mode,

            ]);
            //insert into order_book table
            foreach (Cart::content() as $item) {
                BookOrder::create([
                    'order_id' => $order->id,
                    'book_id' => $item->model->id,
                    'quantity' => $item->qty,
                    'book_subtotal' => $item->subtotal()
                ]);
                $book = Book::find($item->model->id);
                $book->stock = $book->stock - $item->qty;
                $book->save();
            }



            if (Auth::check()) {
                deleteCartInstanceDB('default');
            }
            Cart::instance('default')->destroy();
            session()->forget('coupon');

            // Mail::to($request->email)->send(new OrderEmail($order));


            return  redirect()->route('checkout.thankyou')->with('success_alert', "Thank you ! Your order has been successfully proccessed");
        } catch (CardErrorException $e) {
            return  redirect()->back()->with('error_alert', 'Payment has Failed : ' . $e->getMessage());
        } catch (Exception $e) {
            return  redirect()->back()->with('error_alert', 'Unknown Error Occured : Please Try Again ! ');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function thankyou()
    {

        if (!session()->has('success_alert')) {
            return redirect('/cart');
        }
        return view('pages.checkout.thankyou');
    }
    private function getNumbers()
    {
        $tax = config('cart.tax') / 100;
        $discount = session()->get('coupon')['discount'] ?? 0;
        $code = session()->get('coupon')['code'] ?? null;
        $newSubTotal = Cart::instance('default')->subtotal() - $discount;
        $newTax = $newSubTotal * $tax;
        $newTotal = $newSubTotal + $newTax;

        return collect([
            'discount' => $discount,
            'code' => $code,
            'newSubTotal' => $newSubTotal,
            'newTax' => $newTax,
            'newTotal' => $newTotal
        ]);
    }
}
