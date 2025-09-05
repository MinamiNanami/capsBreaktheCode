<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BalanceRequest;

class BalanceRequestController extends Controller
{
    public function store(Request $request, $userId)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'note' => 'nullable|string|max:255',
        ]);

        BalanceRequest::create([
            'user_id' => $userId,
            'amount' => $request->amount,
            'note' => $request->note,
            'status' => 'pending', // default status
        ]);

        return redirect()->back()->with('success', 'Balance request submitted successfully.');
    }
}
