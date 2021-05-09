<?php

use Cartalyst\Stripe\Exception\NotFoundException;
use Gloudemans\Shoppingcart\Facades\Cart;
use illuminate\Support\Facades\Auth;


function deleteCartInstanceDB($instance)
{
    Cart::instance($instance)->destroyDB(auth()->id());
}


function refreshCartInstanceDB($instance)
{
    deleteCartInstanceDB($instance);
    Cart::instance($instance)->store(auth()->id());
}

function getCartInstanceDB($instance)
{
    Cart::instance($instance)->restore(auth()->id());
}


function isCartInstanceEmpty($instance)
{
    if (Cart::instance($instance)->count() > 0) {
        return false;
    }
    return true;
}
function clearUnavailableItems()
{
    $check = false;
    foreach (Cart::instance('default')->content() as $item) {
        $id = $item->rowId;
        if (!is_object($item->model)) {
            Cart::instance('default')->remove($id);
            $check = true;
            continue;
        }
        if ($item->model->stock <= 0 || $item->qty > $item->model->stock) {
            $duplicates = Cart::instance('wishlist')->search(function ($cartItem, $rowId) use ($id) {
                return $rowId == $id;
            });
            if ($duplicates->isEmpty()) {
                Cart::instance('wishlist')->add($item->id, $item->name, 1, $item->price)->associate('App\Book');
            }
            Cart::instance('default')->remove($id);
            $check = true;
        }
    }
    foreach (Cart::instance('wishlist')->content() as $item) {
        if (!is_object($item->model)) {
            $id = $item->rowId;
            Cart::instance('wishlist')->remove($id);
            $check = true;
        }
    }

    if ($check) {
        if (Auth::check()) {
            refreshCartInstanceDB('default');
            refreshCartInstanceDB('wishlist');
        }
        if (isCartInstanceEmpty('default')) {
            if (Auth::check()) {
                deleteCartInstanceDB('default');
            }
            Cart::instance("default")->destroy();
        }
        if (isCartInstanceEmpty('wishlist')) {
            if (Auth::check()) {
                deleteCartInstanceDB('wishlist');
            }
            Cart::instance("wishlist")->destroy();
        }

        throw new NotFoundException("Sorry ! Some Books have been removed from your cart due to an instance unavailablity ! You can find them in your wishlist unless they are deleted from the system");
    }
  

}
