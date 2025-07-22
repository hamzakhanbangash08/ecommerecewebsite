<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Mail\ThankYouUserMail;
use App\Mail\NewRatingAdminMail;
use Illuminate\Support\Facades\Mail;

class RatingController extends Controller
{
    //
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        $rating =  Rating::updateOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $productId],
            ['rating' => $request->rating, 'comment' => $request->comment]
        );


        // Send admin email
        $adminEmail = "admin@example.com"; // ✅ Change to your actual admin email
        Mail::to($adminEmail)->send(new NewRatingAdminMail($rating));

        // Send thank you email to user
        Mail::to(auth()->user()->email)->send(new ThankYouUserMail($rating));


        return back()->with('success', 'Thanks for your rating!');
    }


    // review vote
    // app/Http/Controllers/RatingController.php

    public function vote(Request $request, Rating $rating)
    {
        $request->validate([
            'helpful' => 'required|boolean',
        ]);

        // Prevent duplicate vote from same user
        Review::updateOrCreate(
            ['user_id' => auth()->id(), 'rating_id' => $rating->id],
            ['helpful' => $request->helpful]
        );

        return back()->with('success', 'Thanks for your feedback!');
    }
}
