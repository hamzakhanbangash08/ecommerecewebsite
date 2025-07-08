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
}
