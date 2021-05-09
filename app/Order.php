<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'billing_email', 'billing_full_name',
        'billing_address', 'billing_country', 'billing_state',
        'billing_city', 'billing_zip', 'billing_phone',
        'billing_card_holder_name', 'billing_subtotal', 'billing_tax', 'billing_total',
        'billing_discount', 'billing_discount_code', 'payment_mode', 'shipped'
    ];
    public function user()
    {
        return $this->BelongsTo('App\User')->withDefault([
            'name' => 'unknown'
        ]);
    }
    public function books()
    {
        return $this->belongsToMany('App\Book', 'book_order', 'order_id', 'book_id')->withPivot(['quantity', 'book_subtotal']);
    }
    public  function detailsWithRemovedBooks()
    {

        /*
        this method checks if a deleted book is present in the Order details
        (book_id field in book_order table would be null in this case) .
        if so :  it pushes a new object (the deleted Book) to the $orderDetails collection
        in order to let the user know that his order contains some deleted books (user Friendly) :)
        */
        $BookOrderRelationShipItems = BookOrder::where('order_id', $this->id)->get();
        $orderDetails = $this->books()->with(['user', 'images'])->get();
        foreach ($BookOrderRelationShipItems as $item) {
            if ($item->book_id == null) {
                $orderDetails->push((object)array(
                    'book_download' => null,
                    'created_at' => null,
                    'updated_at' => null,
                    'id' => null,
                    'images' => array(),
                    'pivot' => (object)array(
                        'quantity' => $item->quantity,
                        'book_subtotal' => $item->book_subtotal
                    ),
                    'price' => null,
                    'slug' => 'unknown',
                    'stock' => 0,
                    'title' => 'unknown (could be removed)',
                    'user' => (object)array(
                        'name' => 'unknown Author'
                    ),
                    'user_id' => null,
                ));
            }
        }
        return $orderDetails;
    }
}
