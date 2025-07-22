<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //

    protected $guarded = [];

    protected $table = 'products';


    function category()
    {
        return $this->belongsTo(Category::class, 'category', 'id');
    }

    function carts()
    {
        return $this->hasMany(Cart::class);
    }
    function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }
    function ratings()
    {
        return $this->hasMany(Rating::class);
    }
    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }
}
