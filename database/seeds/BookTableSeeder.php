<?php

use App\Book;
use App\User;
use App\Genre;
use App\Image;
use Illuminate\Database\Seeder;

class BookTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $books = factory(App\Book::class, 100)->create()->each(function ($book) {
            $book->save();
            $genres = Genre::inRandomOrder()->take(2)->get();
            $book->genres()->saveMany($genres);
        });
        // $book = new Book();
        // $book->title = "book1";
        // $book->slug = "book-1";
        // $book->description = "this is book 1";
        // $book->price = 10.2;
        // $book->stock = 31;
        // $book->user_id = 1;
        // $book->save();
        // $book->genres()->attach(1);

        // $book = new Book();
        // $book->title = "book2";
        // $book->slug = "book-2";
        // $book->description = "this is book 2";
        // $book->price = 20;
        // $book->stock = 14;
        // $book->user_id = 2;
        // $book->save();
        // $book->genres()->attach(2);

        // $book = new Book();
        // $book->title = "book3";
        // $book->slug = "book-3";
        // $book->description = "this is book 3";
        // $book->price = 15.50;
        // $book->stock = 34;
        // $book->user_id = 2;
        // $book->save();
        // $book->genres()->attach(3);

        // $book = new Book();
        // $book->title = "book4";
        // $book->slug = "book-4";
        // $book->description = "this is book 4";
        // $book->price = 34.50;
        // $book->stock = 51;
        // $book->user_id = 2;
        // $book->save();
        // $book->genres()->attach(4);


        // $book = new Book();
        // $book->title = "book5";
        // $book->slug = "book-5";
        // $book->description = "this is book 5";
        // $book->price = 76.70;
        // $book->stock = 11;
        // $book->user_id = 2;
        // $book->save();
        // $book->genres()->attach(5);


        // $book = new Book();
        // $book->title = "book6";
        // $book->slug = "book-6";
        // $book->description = "this is book 6";
        // $book->price = 31.50;
        // $book->stock = 16;
        // $book->user_id = 2;
        // $book->save();
        // $book->genres()->attach(5);

        // $book = new Book();
        // $book->title = "book7";
        // $book->slug = "book-7";
        // $book->description = "this is book 7";
        // $book->price = 141.50;
        // $book->stock = 16;
        // $book->user_id = 2;
        // $book->save();
        // $book->genres()->attach(5);

        // $book = new Book();
        // $book->title = "book8";
        // $book->slug = "book-8";
        // $book->description = "this is book 8";
        // $book->price = 81.50;
        // $book->stock = 16;
        // $book->user_id = 2;
        // $book->save();
        // $book->genres()->attach(5);

        // $book = new Book();
        // $book->title = "book9";
        // $book->slug = "book-9";
        // $book->description = "this is book 9";
        // $book->price = 34.50;
        // $book->stock = 16;
        // $book->user_id = 2;
        // $book->save();
        // $book->genres()->attach(5);


        // $book = new Book();
        // $book->title = "book10";
        // $book->slug = "book-10";
        // $book->description = "this is book 10";
        // $book->price = 167.50;
        // $book->stock = 16;
        // $book->user_id = 2;
        // $book->save();
        // $book->genres()->attach(5);
        // $book->genres()->attach(1);
    }
}
