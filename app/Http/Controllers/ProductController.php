<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Helpers\CustomHelper;


class ProductController extends Controller
{
    private $_request;
    private $_modal;

    public function __construct(Request $request, Product $modal)
    {
        $this->_request = $request;
        $this->_modal = $modal;
    }


    function index()
    {
        $categories = Category::all();
        return view('product.index', compact('categories'));
    }



    public function productsByCategory($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::where('category', $id)->latest()->get(); // ya category_id

        $wishlistProductIds = auth()->check()
            ? Wishlist::where('user_id', auth()->id())->pluck('product_id')->toArray()
            : [];

        return view('product.category', compact('category', 'products', 'wishlistProductIds'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('product.create', compact('categories'));
    }

    public function store()
    {
        try {
            $validatedData = $this->_request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'category' => 'required|exists:categories,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:8000',
                'discount' => 'nullable|numeric|min:0|max:100', // Assuming discount is a percentage

            ]);

            // Upload image if provided
            $imagePath = CustomHelper::uploadImage($this->_request);
            if ($imagePath) {
                $validatedData['image'] = $imagePath;
            }

            $product = CustomHelper::add($this->_modal, $validatedData);

            return response()->json(['message' => 'Product created successfully.', 'product' => $product]);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    function show($id)
    {

        $product = CustomHelper::get_id($this->_modal, $id);
        $wishlistProductIds = auth()->check()
            ? Wishlist::where('user_id', auth()->id())->pluck('product_id')->toArray()
            : [];


        // 
        $product = $this->_modal::with('ratings')->findOrFail($id);

        // Breakdown logic
        $totalRatings = $product->ratings->count();
        $breakdown = [];

        for ($i = 5; $i >= 1; $i--) {
            $count = $product->ratings->where('rating', $i)->count();
            $percentage = $totalRatings > 0 ? round(($count / $totalRatings) * 100) : 0;

            $breakdown[$i] = [
                'count' => $count,
                'percentage' => $percentage
            ];
        }
        return view('product.show', compact('product', 'wishlistProductIds', 'product', 'breakdown', 'totalRatings'));
    }
}
