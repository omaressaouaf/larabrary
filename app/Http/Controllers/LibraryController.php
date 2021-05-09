<?php

namespace App\Http\Controllers;

use App\Book;
use App\BookOrder;
use App\Genre;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request as FacadesRequest;


class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Best selling books
        $bestSellingBooks = BookOrder::BestSellingBooks()->limit(3)->get();
        $pagination = 9;
        $genres = Genre::all();

        if (request()->genre) { //if the request has genre get parameter
            $books = Book::with('genres')->whereHas('genres', function ($query) {
                $query->where('slug', request()->genre);
            });
            $genreName = Genre::where('slug', request()->genre)->firstOrFail()->name;
        } else { //if it does not take 12
            $books = Book::take($pagination);
            $genreName = "featured";
        }

        if (request()->price == "low_high") { //if the request has price get parameter low_high
            $books = $books->orderBy('price')->paginate($pagination);
        } elseif (request()->price == 'high_low') {  //if the request has price get parameter high_low
            $books = $books->orderBy('price', 'desc')->paginate($pagination);
        } else {  //if it does not take all paginated
            $books = $books->orderBy('id', 'desc')->paginate($pagination);
        }

        return view('pages.library.library')->with([
            'books' => $books,
            'genres' => $genres,
            'genreName' => $genreName,
            'bestSellingBooks' => $bestSellingBooks
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $book = Book::where('slug', $slug)->firstOrFail();
        $genreIds = $book->genres->pluck('id');
        $mightLike = Book::where('id', '!=', $book->id)->whereHas('genres.books', function ($q) use ($genreIds) {
            $q->whereIn('books.id', $genreIds);
        })->take(4)->get();
        if ($mightLike->count() == 0) {
            $mightLike = Book::inRandomOrder()->take(4)->get();
        }

        return view("pages.library.book")->with([
            "book" => $book,
            "mightLike" => $mightLike
        ]);
    }
    public function search(Request $request)
    {
        $bestSellingBooks = BookOrder::BestSellingBooks()->get();

        if (request()->ajax()) {
            $search_query = $request->input('search_query');
            if ($request->input('auto')) {

                $books = Book::search($search_query)->orderBy('id', 'desc')->take(4)->get();
                return response()->json(view()->make('ajax.books-search-auto-results', array('books' => $books))->render());
            }

            if (request()->price == "low_high") {
                $books =  Book::search($search_query)->orderBy('price')->paginate(9);
            } elseif (request()->price == 'high_low') {
                $books = Book::search($search_query)->orderBy('price', 'desc')->paginate(9);
            } else {
                $books = Book::search($search_query)->orderBy('id', 'desc')->paginate(9);
            }

            return response()->json(view()->make('ajax.books-search-results', array('books' => $books))->render());
        }
        $search_query = $request->input('search_query');
        $validator = validator::make(request()->all(), [
            'search_query' => 'required|min:2',
        ]);
        if ($validator->fails()) {
            return redirect()->route('library')->withErrors($validator);
        }

        $pagination = 9;
        if (request()->price == "low_high") {
            $books =  Book::search($search_query)->orderBy('price')->paginate($pagination);
        } elseif (request()->price == 'high_low') {
            $books = Book::search($search_query)->orderBy('price', 'desc')->paginate($pagination);
        } else {
            $books = Book::search($search_query)->orderBy('id', 'desc')->paginate($pagination);
        }
        $genres = Genre::all();
        return view('pages.library.search')->with([
            'books' => $books,
            'genres' => $genres,
            'bestSellingBooks' => $bestSellingBooks

        ]);
    }
}
