<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class BookOrder extends Model
{
    protected $table = "book_order";
    protected $fillable = ['order_id', 'book_id', 'quantity', 'book_subtotal'];
    public function scopeBestSellingBooks($query)
    {

        return DB::table('Book_Order')->rightJoin('books', 'books.id', '=', 'Book_Order.book_id')
            ->leftJoin('images', 'books.id', '=', 'images.book_id')
            ->join('users', 'users.id', '=', 'books.user_id')
            ->select(
                'books.id',
                'books.title',
                'books.slug',
                'books.price',
                'users.name as authorname',
                'Book_Order.book_id',
                'images.name as imagePath',
                DB::raw('SUM(Book_Order.quantity) as total')
            )
            ->groupBy('books.id', 'books.price', 'Book_Order.book_id', 'books.title', 'books.slug', 'authorname')
            ->orderBy('total', 'desc');
    }
}
