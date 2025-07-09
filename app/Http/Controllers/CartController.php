<?php

namespace App\Http\Controllers;

use App\Helpers\CustomHelper;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //

    private $_request;
    private $_modal;

    public function __construct(Request $request, Product $modal)
    {
        $this->_request = $request;
        $this->_modal = $modal;
    }


    // public function index()
    // {
    //     $cart = Cart::with('product') // eager load product if needed
    //         ->where('user_id', $userId = auth()->id())
    //         ->get();

    //     // Mark all as seen
    //     Cart::where('user_id', $userId)->update(['seen' => true]);
    //     return view('cart.index', compact('cart'));
    // }


    public function index()
    {
        // Mark all unseen cart items as seen
        Cart::where('user_id', auth()->id())->where('seen', false)->update(['seen' => true]);

        $cart = Cart::with('product')->where('user_id', auth()->id())->get();

        return view('cart.index', compact('cart'));
    }


    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);


        $product = CustomHelper::get_id($this->_modal, $productId); // ✅ call to helper


        $existing = Cart::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            // Update quantity only; price stays same
            $existing->quantity += 1;
            $existing->seen = false; // Mark as unseen again
            $existing->save();
        } else {
            // Save current price snapshot
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $productId,
                'name' => $product->name,
                'description' => $product->description,
                'image' => $product->image,
                'quantity' => 1,
                'price' => $product->price,
                'discount'   => $product->discount ?? 0, // pulled from DB dynamically
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $cart->quantity = $request->quantity;
        $cart->seen = false;
        $cart->save();

        return redirect()->route('cart.index');
    }
}
