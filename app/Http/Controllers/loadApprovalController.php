<?php

namespace App\Http\Controllers;

use App\Models\LoadRequest;
use App\Models\BalanceRequest;
use Illuminate\Http\Request;

class LoadApprovalController extends Controller
{
    public function index()
    {
        // Fetch Load Requests
        $loadRequests = LoadRequest::with('user')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($request) {
                $request->type = 'Load';
                return $request;
            });

        // Fetch Balance Requests
        $balanceRequests = BalanceRequest::with('user')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($request) {
                $request->type = 'Balance';
                return $request;
            });

        // Merge and sort both collections by date descending
        $requests = $loadRequests->merge($balanceRequests)->sortByDesc('created_at');

        return view('load_approval', compact('requests'));
    }

    public function approve($id, Request $request)
    {
        $type = $request->query('type');

        if ($type === 'Load') {
            $req = LoadRequest::findOrFail($id);
            $req->status = 'approved';
            $req->save();

            $user = $req->user;
            $user->wallet_balance += $req->amount;
            $user->save();

            return back()->with('success', 'Load approved and added to wallet.');
        }

        if ($type === 'Balance') {
            $req = BalanceRequest::findOrFail($id);
            $req->status = 'approved';
            $req->save();

            $user = $req->user;
            $user->wallet_balance += $req->amount;
            $user->save();

            return back()->with('success', 'Balance approved and added to wallet.');
        }

        return back()->with('error', 'Invalid request type.');
    }

    public function reject($id, Request $request)
    {
        $type = $request->query('type');

        if ($type === 'Load') {
            $req = LoadRequest::findOrFail($id);
            $req->status = 'rejected';
            $req->save();

            return back()->with('error', 'Load request rejected.');
        }

        if ($type === 'Balance') {
            $req = BalanceRequest::findOrFail($id);
            $req->status = 'rejected';
            $req->save();

            return back()->with('error', 'Balance request rejected.');
        }

        return back()->with('error', 'Invalid request type.');
    }
}
