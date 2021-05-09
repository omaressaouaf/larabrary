<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id', 'book_id', 'headline', 'description', 'rating', 'approved'
    ];
    public function user()
    {
        return   $this->belongsTo('App\User')->withDefault([
            'name' => 'Unknown ',
        ]);
    }
    public function book()
    {
        return  $this->belongsTo('App\Book');
    }
}
