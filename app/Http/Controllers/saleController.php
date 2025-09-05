<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;

class SaleController extends Controller
{
    public function index()
    {
        // fetch all sales from DB
        $sales = Sale::orderBy('created_at', 'desc')->get();

        // pass to Blade
        return view('pos', compact('sales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'service'       => 'required|string|max:255',
            'total'         => 'required|numeric',
            'discount'      => 'nullable|numeric',
        ]);

        Sale::create($request->all());

        return redirect()->route('pos')->with('success', 'Sale added successfully!');
    }

    public function update(Request $request, $id)
    {
        $sale = Sale::findOrFail($id);

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'service'       => 'required|string|max:255',
            'total'         => 'required|numeric',
            'discount'      => 'nullable|numeric',
        ]);

        $sale->update($request->all());

        return redirect()->route('pos')->with('success', 'Sale updated successfully!');
    }

    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();

        return redirect()->route('pos')->with('success', 'Sale deleted successfully!');
    }

    public function transactions()
    {
        // Load sales with related items + product
        $sales = Sale::with('items.product')->get();

        return view('transactions', compact('sales'));
    }
}
