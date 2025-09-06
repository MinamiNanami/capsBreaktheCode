<?php

namespace App\Http\Controllers;

use App\Models\BalanceRequest;
use Illuminate\Http\Request;

class BalanceApprovalController extends Controller
{
    public function approve($id)
    {
        $request = BalanceRequest::findOrFail($id);
        $request->status = 'approved';
        $request->save();

        // Add to user's wallet
        $user = $request->user;
        $user->wallet_balance += $request->amount;
        $user->save();

        return back()->with('success', 'Balance approved and added to wallet.');
    }

    public function reject($id)
    {
        $request = BalanceRequest::findOrFail($id);
        $request->status = 'rejected';
        $request->save();

        return back()->with('error', 'Balance request rejected.');
    }
}
    