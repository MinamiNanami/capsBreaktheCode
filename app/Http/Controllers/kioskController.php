<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;

class KioskController extends Controller
{
    // Show products
    public function index()
    {
        $products = Product::where('status', 'Available')->get();
        return view('kiosk', compact('products'));
    }

    // Checkout and save transaction
    public function checkout(Request $request)
    {
        // Validate input
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'order_method' => 'required|string|in:Takeout,Dine-in',
            'table_number' => 'nullable|string',
            'payment_method' => 'required|string',
        ]);

        // Ensure table number if Dine-in
        if ($request->order_method === 'Dine-in' && empty($request->table_number)) {
            return response()->json([
                'success' => false,
                'message' => 'Table number is required for Dine-in orders.'
            ]);
        }

        DB::beginTransaction();

        try {
            // Calculate total
            $total = 0;
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['id']);
                $total += $product->price * $item['quantity'];
            }

            // Save sale
            $sale = Sale::create([
                'customer_name' => $request->customer_name ?? null,
                'service' => $request->service ?? 'Kiosk Sale',
                'order_method' => $request->order_method,
                'table_number' => $request->order_method === 'Dine-in' ? $request->table_number : null,
                'payment_method' => $request->payment_method,
                'total' => $total,
                'discount' => 0,
            ]);

            // Save sale items and decrement stock
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['id']);
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $item['quantity'],
                    'subtotal' => $product->price * $item['quantity'],
                ]);

                // Reduce product stock
                $product->decrement('stock', $item['quantity']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaction completed successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to complete transaction: ' . $e->getMessage()
            ], 500);
        }
    }
}
