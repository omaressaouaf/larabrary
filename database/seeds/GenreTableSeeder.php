<?php

use Illuminate\Database\Seeder;
use App\Genre;

class GenreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genre = new Genre();
        $genre->name ="romance";
        $genre->slug="romance";
        $genre->save();

        $genre = new Genre();
        $genre->name ="action";
        $genre->slug="action";
        $genre->save();


        $genre = new Genre();
        $genre->name ="fantasy";
        $genre->slug="fantasy";
        $genre->save();

        $genre = new Genre();
        $genre->name ="horror";
        $genre->slug="horror";
        $genre->save();

        $genre = new Genre();
        $genre->name ="history";
        $genre->slug="history";
        $genre->save();
    }
}
