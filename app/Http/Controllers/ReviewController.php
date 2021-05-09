<?php

namespace App\Http\Controllers;

use App\Book;
use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        if (request()->ajax()) {

            $book = Book::findOrFail($request->book_id);

            Review::Create([
                'user_id' => auth()->id(),
                'book_id' => $book->id,
                'headline' => $request->headline,
                'description' => $request->description,
                'rating' => $request->rating
            ]);

            return response()->json([
                'message' => 'review has been added'
            ]);
        }
        abort(401);
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
        if (request()->ajax()) {
            $book = Book::findOrFail($request->book_id);
            $review = Review::findOrFail($id)->update([
                'user_id' => auth()->id(),
                'book_id' => $book->id,
                'headline' => $request->headline,
                'description' => $request->description,
                'rating' => $request->rating
            ]);



            return response()->json([
                'message' => 'review has been updated'
            ]);
        }
        abort(401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (request()->ajax()) {
            Review::find($id)->delete();
            return response()->json([
                'message' => 'review has been deleted'
            ]);
        }
        abort(401);
    }
    public function forbook($id)
    {
        if (request()->ajax()) {
            $book = Book::find($id);
            if (!$book) {
                return response()->json([
                    'reviews' => 'Error'

                ]);
            }
            if (auth()->check()) {
                return response()->json([
                    'reviews' => $book->reviews()->with('user')->where('user_id', '!=', auth()->id())->orderBy('id', 'desc')->get(),
                    'currentUserReview' => auth()->user()->reviews()->with('user')->where('book_id', $book->id)->first()
                ]);
            }

            return response()->json([
                'reviews' => $book->reviews()->with('user')->orderBy('id', 'desc')->get()

            ]);
        }
        abort(401);
    }
}
