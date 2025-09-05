<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total users
        $totalUsers = User::count();

        // Total products
        $totalProducts = Product::count();

        // Total orders
        $totalOrders = Sale::count();

        // Total token transactions (optional, change if you have a table for token tx)
        $totalTransactions = DB::table('load_requests')->count();

        // Total sales amount
        $totalSales = Sale::sum('total');

        // Best seller product (joining sale_items with products)
        $bestSeller = DB::table('sale_items')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->selectRaw('products.name as product_name, SUM(sale_items.quantity) as total_qty')
            ->groupBy('products.name')
            ->orderByDesc('total_qty')
            ->first();

        return view('dashboard', [
            'totalUsers' => $totalUsers,
            'totalProducts' => $totalProducts,
            'totalOrders' => $totalOrders,
            'totalTransactions' => $totalTransactions,
            'totalSales' => $totalSales,
            'bestSeller' => $bestSeller,
        ]);
    }
}
