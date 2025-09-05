<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;

class POSController extends Controller
{
    public function index()
    {
        $products = Product::where('status','Available')->get();
        return view('pos', compact('products'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $total = 0;
        foreach($request->items as $item){
            $total += $item['price'] * $item['quantity'];
        }
        $total -= $request->discount ?? 0;

        $sale = Sale::create([
            'customer_name' => $request->customer_name,
            'total' => $total,
            'discount' => $request->discount ?? 0,
        ]);

        foreach($request->items as $item){
            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);

            // Decrease product stock
            $product = Product::find($item['product_id']);
            $product->stock -= $item['quantity'];
            $product->save();
        }

        return redirect()->route('pos')->with('success','Sale completed successfully!');
    }
}
