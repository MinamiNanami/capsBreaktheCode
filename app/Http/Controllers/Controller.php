<?php

namespace App\Http\Controllers;

use App\Models\BalanceRequest;
use App\Models\LoadRequest;

abstract class Controller
{
    public function index()
    {
        $loadRequests = LoadRequest::with('user')->get();
        $balanceRequests = BalanceRequest::with('user')->get();

        // Tag each request so you know where it came from
        $loadRequests->each(function ($item) {
            $item->type = 'Load';
        });

        $balanceRequests->each(function ($item) {
            $item->type = 'Balance';
        });

        // Merge both collections
        $requests = $loadRequests->merge($balanceRequests)->sortByDesc('created_at');

        return view('load-approval', compact('requests'));
    }
}
