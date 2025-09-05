<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;

class StaffController extends Controller
{
    // Show the staff POS page
    public function index()
    {
        $products = Product::all();
        return view('staff', compact('products'));
    }

    // Store a sale from the staff POS
    public function storeSale(Request $request)
    {
        $request->validate([
            'items' => 'required|string', // hidden input with serialized JSON
            'order_method' => 'required|string',
            'table_number' => 'nullable|string',
            'payment_method' => 'required|string',
        ]);

        $items = json_decode($request->items, true);
        if (!$items || count($items) === 0) {
            return redirect()->back()->with('error', 'Cart is empty or invalid.');
        }

        // Calculate total from items
        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $sale = Sale::create([
            'order_method' => $request->order_method,
            'table_number' => $request->order_method === 'Dine-in' ? $request->table_number : null,
            'payment_method' => $request->payment_method,
            'total' => $total, 
        ]);

        foreach ($items as $item) {
            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => ($item['price'] * ($item['quantity'] ?? 1)), // <- add this
            ]);
        }

        return redirect()->back()->with('success', 'Sale recorded successfully!');
    }
}
