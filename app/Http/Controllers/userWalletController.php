<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\BalanceRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserWalletController extends Controller
{
    /**
     * Display the authenticated user's wallet dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        // Check if user is logged in
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        // Role-based access control: only users with role 'wallet' can access
        if ($user->role !== 'wallet') {
            abort(403, 'Unauthorized access');
        }

        // Load relationships
        $transactions = $user->transactions()->latest()->get();
        $balanceRequests = $user->balanceRequests()->latest()->get();

        return view('user_wallet', compact('user', 'transactions', 'balanceRequests'));
    }

    /**
     * Handle the submission of a new balance request.
     */
    public function storeRequest(Request $request)
    {
        $user = Auth::user();

        // Check if user is logged in
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        // Role check again to be safe
        if ($user->role !== 'wallet') {
            abort(403, 'Unauthorized access');
        }

        // Validate input
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'note' => 'nullable|string|max:255',
        ]);

        // Create balance request
        BalanceRequest::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'note' => $request->note,
            'status' => 'pending',
        ]);

        return redirect()->route('user_wallet')->with('success', 'Balance request submitted!');
    }
}
