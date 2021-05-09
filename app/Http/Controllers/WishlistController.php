<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use Gloudemans\Shoppingcart\Exceptions\InvalidRowIDException;

class WishlistController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $duplicates = Cart::instance('wishlist')->search(function ($cartItem, $rowId) use ($request) {
            return $cartItem->id == $request->id;
        });

        if ($duplicates->isNotEmpty()) {
            return redirect()->route('cart')->with('error_alert', "Book is already in your Wishlist . Scroll down :)");
        }


        Cart::instance('wishlist')->add($request->id, $request->title, 1, $request->price)->associate('App\Book');

        if (Auth::check()) {
            refreshCartInstanceDB('wishlist');
        }
        return redirect()->route('cart')->with('success_alert', "Book has been added to your Wishlist . Scroll down :)");
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Cart::instance('wishlist')->remove($id);

            if (Auth::check()) {
                refreshCartInstanceDB('wishlist');
            }
            if (isCartInstanceEmpty('wishlist')) {
                deleteCartInstanceDB('wishlist');
                Cart::instance("wishlist")->destroy();
            }
            return back()->with('success_alert', "Book has been removed from your Wishlist");
        } catch (InvalidRowIDException $e) {
            return back()->with('error_alert', "Invalid Item ");
        } catch (Exception $e) {
            return back()->with('error_alert', "Unknown Error ! try again");
        }
    }
    public function empty()
    {
        if (Auth::check()) {
            deleteCartInstanceDB('wishlist');
        }
        Cart::instance('wishlist')->destroy();
        return back()->with('success_alert', "Your Wishlist has been Cleared ");
    }
    /**
     * move to Wishlist
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function moveToCart($id)
    {
        try {
            $item = Cart::instance('wishlist')->get($id);
            if ($item->model->stock == 0) {
                return redirect()->route('cart')->with('error_alert', "Book is not available now");
            }

            $duplicates = Cart::instance('default')->search(function ($cartItem, $rowId) use ($id) {
                return $rowId == $id;
            });

            if ($duplicates->isNotEmpty()) {
                return redirect()->route('cart')->with('error_alert', "Book is already in your Cart");
            }
            Cart::instance('default')->add($item->id, $item->name, 1, $item->price)->associate('App\Book');
            Cart::instance('wishlist')->remove($id);
            if (Auth::check()) {
                refreshCartInstanceDB('wishlist');
                refreshCartInstanceDB('default');
            }
            if (isCartInstanceEmpty('wishlist')) {
                deleteCartInstanceDB('wishlist');
                Cart::instance("wishlist")->destroy();
            }
            return redirect()->route('cart')->with('success_alert', "Book has been moved to your Cart ");
        } catch (InvalidRowIDException $e) {
            return back()->with('error_alert', "Invalid Item ");
        } catch (Exception $e) {
            return back()->with('error_alert', "Unknown Error ! try again");
        }
    }
}
