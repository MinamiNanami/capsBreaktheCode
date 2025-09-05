@extends('layouts.admin')

@section('content')
<section id="dashboard" class="content-section active">
    <h1 class="text-2xl font-bold mb-4">Dashboard Summary</h1>

    <div class="dashboard-container grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Left Side: Counts -->
        <div class="dashboard-left">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="card bg-white shadow p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-700">Total Users</h3>
                    <p class="text-xl font-bold text-blue-600">{{ $totalUsers }}</p>
                </div>
                <div class="card bg-white shadow p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-700">Total Products</h3>
                    <p class="text-xl font-bold text-blue-600">{{ $totalProducts }}</p>
                </div>
                <div class="card bg-white shadow p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-700">Total Orders</h3>
                    <p class="text-xl font-bold text-blue-600">{{ $totalOrders }}</p>
                </div>
                <div class="card bg-white shadow p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-700">Total Token Transactions</h3>
                    <p class="text-xl font-bold text-blue-600">{{ number_format($totalTransactions, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Right Side: Sales -->
        <div class="dashboard-right">
            <div class="grid grid-cols-1 gap-4">
                <div class="stat-card bg-white shadow p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-700">Total Sales</h3>
                    <p class="text-xl font-bold text-green-600">₱ {{ number_format($totalSales, 2) }}</p>
                </div>
                <div class="stat-card bg-white shadow p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-700">Best Seller</h3>
                    <p class="text-xl font-bold text-red-600">
                        {{ $bestSeller ? $bestSeller->product_name : '-' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection