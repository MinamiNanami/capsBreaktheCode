<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TokenTransaction;

class BlockchainController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get(); // Users with token balances
        $transactions = TokenTransaction::orderBy('created_at','desc')->take(50)->get(); // Last 50 transactions
        return view('blockchain', compact('users','transactions'));
    }

    public function mint(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1'
        ]);

        $user = User::find($request->user_id);
        $user->token_balance = ($user->token_balance ?? 0) + $request->amount;
        $user->save();

        TokenTransaction::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'type' => 'mint'
        ]);

        return redirect()->route('blockchain')->with('success','Tokens minted successfully!');
    }
}
