<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BalanceRequestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\LoadApprovalController;
use App\Http\Controllers\BlockchainController;
use App\Http\Controllers\LoadRequestController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KioskController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserWalletController;
use App\Models\BalanceRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

// Regular Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');



Route::get('/users', [UserController::class, 'index'])->name('users');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('/products', [ProductController::class, 'index'])->name('products');           // List products
Route::get('/create', [ProductController::class, 'create'])->name('products.create'); // Optional create page
Route::post('/products', [ProductController::class, 'store'])->name('products.store');     // Store product
Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy'); // Delete product



Route::get('/pos', [SaleController::class, 'index'])->name('pos');
Route::post('/pos', [SaleController::class, 'store'])->name('pos.store');
Route::put('/pos/{id}', [SaleController::class, 'update'])->name('pos.update');
Route::delete('/pos/{id}', [SaleController::class, 'destroy'])->name('pos.destroy');

Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::post('transactions', [TransactionController::class, 'store'])->name('transactions.store');
Route::get('/transactions/{sale}', [TransactionController::class, 'show'])->name('transactions.show'); // View sale items

Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
Route::post('/inventory/update-stock', [InventoryController::class, 'updateStock'])->name('inventory.updateStock');

Route::get('/wallet', [WalletController::class, 'index'])->name('wallet');
Route::post('/wallet/update', [WalletController::class, 'update'])->name('wallet.update');

// For individual user wallet view
Route::get('/user_wallet', [UserWalletController::class, 'index'])->name('user_wallet');



Route::post('/load-request', [LoadRequestController::class, 'store'])->name('load-request.store');


Route::get('/load-approval', [LoadApprovalController::class, 'index'])->name('load-approval');
Route::put('/load-approval/{id}/approve', [LoadApprovalController::class, 'approve'])->name('load-approval.approve');
Route::put('/load-approval/{id}/reject', [LoadApprovalController::class, 'reject'])->name('load-approval.reject');

//kiosk

Route::get('/kiosk', [KioskController::class, 'index'])->name('kiosk.index');
Route::post('/kiosk/checkout', [KioskController::class, 'checkout'])->name('kiosk.checkout');

Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
Route::post('/staff/sales', [StaffController::class, 'storeSale'])->name('staff.sales.store');

// Wallet view for regular users
Route::get('/user-wallet', [UserWalletController::class, 'index'])->name('user_wallet');

// Balance request submission
Route::post('/balance-request', [UserWalletController::class, 'storeRequest'])->name('balance.request.store');

// Balance Request
Route::put('/balance-approval/{id}/approve', [BalanceRequestController::class, 'approve'])->name('balance-approval.approve');
Route::put('/balance-approval/{id}/reject', [BalanceRequestController::class, 'reject'])->name('balance-approval.reject');

// Profile update
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

// Approve routes
Route::put('/admin/requests/{id}/approve', [LoadApprovalController::class, 'approve'])->name('requests.approve');

// Reject routes
Route::put('/admin/requests/{id}/reject', [LoadApprovalController::class, 'reject'])->name('requests.reject');



require __DIR__ . '/auth.php';
