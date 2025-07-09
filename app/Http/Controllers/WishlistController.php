<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{

    private $_request;
    private $_modal;

    public function __construct(Request $request, Wishlist $modal)
    {
        $this->_request = $request;
        $this->_modal = $modal;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $wishlists = Wishlist::with('product')
            ->where('user_id', auth()->id())
            ->get();

        return view('wishlist.wishlist', compact('wishlists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Wishlist $wishlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wishlist $wishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wishlist $wishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wishlist $wishlist)
    {
        //
    }


    public function toggle(Product $product)
    {
        $user = auth()->user();

        $existing =  $this->_modal::where('user_id', $user->id)->where('product_id', $product->id)->first();

        if ($existing) {
            $existing->delete();
            return back()->with('message', 'Removed from wishlist.');
        }

        Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        return back()->with('message', 'Added to wishlist!');
    }
}
