<?php

namespace App\Http\Controllers;

use App\Book;
use App\Role;
use App\User;
use App\BookOrder;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function landing()
    {

        $bestSellingBooks = BookOrder::BestSellingBooks()->limit(8)->get();
        // Appending star Rating the the array objects
        foreach ($bestSellingBooks as $bestBook) {
            $starRating = Book::find($bestBook->id)->calculateStarRating();
            $bestBook->starRating = $starRating;
        }
        $someAuthors = Role::where('name', 'author')->first()->users()->inRandomOrder()->take(3)->get();
        return view('pages.landing')->with([
            'bestSellingBooks' => $bestSellingBooks,
            'someAuthors' => $someAuthors
        ]);
    }
    public function about()
    {

        return view('pages.about');
    }
    public function admin()
    {
        return view('pages.admin.index');
    }
}
