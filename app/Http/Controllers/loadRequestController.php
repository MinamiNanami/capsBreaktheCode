<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoadRequest;
use App\Models\User;

class LoadRequestController extends Controller
{
    public function index()
    {
        $requests = LoadRequest::with('user')->orderBy('created_at', 'desc')->get();
        return view('load-approval', compact('requests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount'  => 'required|numeric|min:1',
        ]);

        LoadRequest::create([
            'user_id' => $request->user_id,
            'amount'  => $request->amount,
        ]);

        return back()->with('success', 'Load request submitted. Please wait for admin approval.');
    }

    public function approve($id)
    {
        $load = LoadRequest::findOrFail($id);
        $load->status = 'approved';
        $load->save();

        $user = $load->user;
        $user->wallet_balance += $load->amount;
        $user->save();

        return back()->with('success', 'Load request approved and wallet updated.');
    }

    public function reject($id)
    {
        $load = LoadRequest::findOrFail($id);
        $load->status = 'rejected';
        $load->save();

        return back()->with('success', 'Load request rejected.');
    }
}
