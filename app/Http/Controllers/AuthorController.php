<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = Role::where('name', 'author')->first()->users()->paginate(10);
        return view('pages.ourAuthors.index')->with('authors', $authors);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $author = User::findOrFail($id);
        $authorBooks = $author->books()->paginate(4);
        $authorSalesCount = DB::table('book_order')
            ->join('books', 'book_order.book_id', '=', 'books.id')
            ->join('users', 'users.id', '=', 'books.user_id')
            // ->select(DB::raw('COUNT(book_order.id) as total')) //we can select count by raw or use query builder aggregate function count
            ->where('users.id', $id)->distinct()->count('book_order.order_id');

        return view('pages.ourAuthors.show')->with([
            'author' => $author,
            'authorBooks' => $authorBooks,
            'authorSalesCount' => $authorSalesCount
        ]);
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
}
