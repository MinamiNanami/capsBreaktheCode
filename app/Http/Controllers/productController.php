<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // List all products
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        return view('products', compact('products'));
    }

    // Show create product form
    public function create()
    {
        return view('products.create');
    }

    // Store new product
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            'status' => 'required|string|in:Available,Unavailable',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'price' => $request->price,
            'status' => $request->status,
            'image' => $imagePath
        ]);

        return redirect()->route('products')->with('success', 'Product created successfully.');
    }

    // Delete product
    public function destroy(Product $product)
    {
        if($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect()->route('products')->with('success', 'Product deleted successfully.');
    }
}
