<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    //
    protected $guarded = [];

    protected $casts = [
        'user_id' => 'integer',
        'product_id' => 'integer',
        'rating' => 'integer',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
    public function scopeForProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    public function reviewVotes()
    {
        return $this->hasMany(Review::class);
    }

    public function helpfulCount()
    {
        return $this->reviewVotes()->where('helpful', true)->count();
    }

    public function notHelpfulCount()
    {
        return $this->reviewVotes()->where('helpful', false)->count();
    }
}
