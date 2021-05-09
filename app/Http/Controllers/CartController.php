<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use Dotenv\Validator;
use Gloudemans\Shoppingcart\Facades\Cart;
use illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Carbon\Carbon;
use Cartalyst\Stripe\Exception\NotFoundException;
use Exception;
use Gloudemans\Shoppingcart\Exceptions\InvalidRowIDException;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            getCartInstanceDB('default');
            getCartInstanceDB('wishlist');
        }
        try {
            clearUnavailableItems();
            return view('pages.cart');
        } catch (NotFoundException $e) {
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
    public function store(Request $request)
    {
        //ajax call to add an item to the cart without page refresh
        if (request()->ajax()) {
            $item = Book::find($request->id);
            if (!$item) {
                return response()->json([
                    'message' => 'Error Occured Try again',
                    'status' => 0
                ]);
            }
            if ($item->stock <= 0) {
                return response()->json([
                    'message' => 'Book is  currently not available ',
                    'status' => 0
                ]);
            }
            $duplicates = Cart::search(function ($cartItem, $rowId) use ($item) {
                return $cartItem->id == $item->id;
            });

            if ($duplicates->isNotEmpty()) {

                return response()->json([
                    'message' => 'Book is Already in your cart',
                    'status' => 0
                ]);
            }

            $addedItem = Cart::add($item->id, $item->title, 1, $item->price)->associate('App\Book');

            if (Auth::check()) {
                refreshCartInstanceDB('default');
            }

            return response()->json([
                'message' => 'Book added to your cart (' . $addedItem->qty . ')',
                'status' => 1
            ]);
        }
        $item = Book::findOrFail($request->id);
        if ($item->stock <= 0) {
            return redirect()->route('cart')->with('error_alert', "Book is not available now");
        }


        $duplicates = Cart::search(function ($cartItem, $rowId) use ($item) {
            return $cartItem->id == $item->id;
        });

        if ($duplicates->isNotEmpty()) {

            return redirect()->route('cart')->with('error_alert', "Book is Already in your cart");
        }

        $addedItem = Cart::add($request->id, $request->title, 1, $request->price)->associate('App\Book');

        if (Auth::check()) {
            refreshCartInstanceDB('default');
        }


        return redirect()->route('cart')->with('success_alert', "Book has been added to your Cart (" . $addedItem->qty . ")");
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
        try {

            $duplicates = Cart::instance('default')->search(function ($cartItem, $rowId) use ($id) {
                return $rowId == $id;
            });

            if ($duplicates->isEmpty()) {
                session()->flash('error_alert', 'Invalid Item !');
                return response()->json(['success' => false]);
            }
            $allowedQuanity = $duplicates->first()->model->stock;

            $validator = FacadesValidator::make($request->all(), [
                'quantity' => "required|numeric|between:1,$allowedQuanity"
            ]);
            if ($validator->fails()) {
                session()->flash('errors', collect(['requested quantity is not available']));
                return response()->json(['success' => false], 400);
            }
            Cart::update($id, $request->quantity);

            if (Auth::check()) {
                refreshCartInstanceDB('default');
            }

            session()->flash('success_alert', 'Quantity has been updated succesfully');
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            session()->flash('error_alert', 'unknown error Occured ! Try Again');
            return response()->json(['success' => false]);
        }
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
            Cart::remove($id);

            if (Auth::check()) {
                refreshCartInstanceDB('default');
            }
            if (isCartInstanceEmpty('default')) {
                deleteCartInstanceDB('default');
                Cart::instance("default")->destroy();
            }
            return back()->with('success_alert', "Book has been removed from your Cart");
        } catch (InvalidRowIDException $e) {
            return back()->with('error_alert', "Invalid Item ");
        } catch (Exception $e) {
            return back()->with('error_alert', "Unknown Error ! try again");
        }
    }

    public function empty()
    {
        if (Auth::check()) {
            deleteCartInstanceDB('default');
        }
        Cart::destroy();
        return back()->with('success_alert', "Your Cart has been Cleared");
    }
    /**
     * move to Wishlist
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function moveToWishlist($id)
    {
        try {

            $item = Cart::instance('default')->get($id);


            $duplicates = Cart::instance('wishlist')->search(function ($cartItem, $rowId) use ($id) {
                return $rowId === $id;
            });

            if ($duplicates->isNotEmpty()) {
                return redirect()->route('cart')->with('error_alert', "Book is already in your Wishlist . Scroll down :)");
            }

            Cart::instance('wishlist')->add($item->id, $item->name, 1, $item->price)->associate('App\Book');
            Cart::instance('default')->remove($id);
            if (Auth::check()) {
                refreshCartInstanceDB('default');
                refreshCartInstanceDB('wishlist');
            }
            if (isCartInstanceEmpty('default')) {
                deleteCartInstanceDB('default');
                Cart::instance("default")->destroy();
            }

            return redirect()->route('cart')->with('success_alert', "Book has been moved to your Wishlist . Scroll down :)");
        } catch (InvalidRowIDException $e) {
            return back()->with('error_alert', "Invalid Item ");
        } catch (Exception $e) {
            return back()->with('error_alert', "Unknown Error ! try again");
        }
    }
    public function count(Request $request)
    {
        if (request()->ajax()) {
            return response()->json([
                'count' => Cart::instance('default')->count()
            ]);
        }
        abort(401);
    }
}
