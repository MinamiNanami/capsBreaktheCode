<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name')->get();
        return view('inventory', compact('products'));
    }

    public function updateStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'stock' => 'required|integer|min:0'
        ]);

        $product = Product::findOrFail($request->product_id);
        $product->stock = $request->stock;
        $product->save();

        return redirect()->route('inventory')->with('success', 'Stock updated successfully!');
    }
}
