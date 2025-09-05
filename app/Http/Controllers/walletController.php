<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    // Show all users and their wallet balances
    public function index()
    {
        $users = User::all();
        return view('wallet', compact('users'));
    }

    // Handle wallet update
    public function update(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric'
        ]);

        $user = User::findOrFail($request->user_id);
        $user->wallet_balance += $request->amount;
        $user->save();

        return back()->with('success', 'Wallet updated successfully.');
    }

    
}
