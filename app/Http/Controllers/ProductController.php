<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Auth\Events\Validated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    private $_request = null;
    private $_modal = null;
    private $_view = null;

    public function __construct(Request $request, Product $modal,  $var = null)
    {

        $this->_request = $request;
        $this->_modal = $modal;
        $this->_view = $var;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        $categories = Category::all();
        return view('product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        //

        $validatedData = $this->_request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:8000',
        ]);

        // Handle file upload if an image is provided
        // Image store directly in public/images
        if ($this->_request->hasFile('image')) {
            $file = $this->_request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName(); // unique name
            $path = public_path('images'); // absolute path: /project-root/public/images
            $file->move($path, $filename);

            // Save relative path in DB
            $validatedData['image'] = 'images/' . $filename;
        }

        // Create the product
        $product = $this->model::create($validatedData);

        // Redirect to the product index or show page with a success message
        // return redirect()->route('product.index')->with('success', 'Product created successfully.');

        // Alternatively, you can return a view or JSON response
        // return view('product.index', compact('product'));

        return response()->json(['message' => 'Product created successfully.', 'product' => $product]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
