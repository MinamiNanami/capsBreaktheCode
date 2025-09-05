<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;

class TransactionController extends Controller
{
    public function index()
    {
        // Eager load items and their product info
        $sales = Sale::with('items.product')->orderBy('created_at','desc')->get();
        return view('transactions', compact('sales'));
    }

    public function show(Sale $sale)
    {
        $sale->load('items.product'); // optional if you need a separate show page
        return view('transactions.show', compact('sale'));
    }
}
    