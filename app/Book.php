<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Book extends Model
{
    use SearchableTrait;
    /**
         * Searchable rules.
         *
         * @var array
         */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'books.title' => 10,
            'books.description' => 7,
            'books.slug' => 5,
            'users.name' => 10,



        ],
        'joins' => [
            'users' => ['users.id', 'books.user_id'],
        ],
    ];
    public function user()
    {
        return $this->belongsTo('App\User')->withDefault([
            'name' => 'Anonymous',
        ]);;
    }
    public function genres()
    {
        return $this->belongsToMany('App\Genre');
    }
    public function orders()
    {
        return $this->belongsToMany('App\Order', 'book_order', 'book_id', 'order_id')->withPivot(['quantity', 'book_subtotal']);
    }
    public function reviews()
    {
        return $this->hasMany('App\Review');
    }
    public function calculateStarRating()
    {
        $count = $this->reviews()->count();
        if (empty($count)) {
            return 0;
        }
        $sum = $this->reviews()->sum('rating');
        $average = $sum / $count;
        return $average;
    }
    public function images()
    {
        return $this->hasMany('App\Image');
    }

}
