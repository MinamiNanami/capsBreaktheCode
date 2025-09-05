@extends('layouts.admin')

@section('content')
<section id="load-approval-section" class="content-section">
    <h2 class="text-2xl font-bold mb-4">Requests Approval</h2>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    {{-- Requests Table --}}
    <table class="w-full border-collapse border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-2 py-1">Request ID</th>
                <th class="border px-2 py-1">Type</th>
                <th class="border px-2 py-1">User</th>
                <th class="border px-2 py-1">Email</th>
                <th class="border px-2 py-1">Amount</th>
                <th class="border px-2 py-1">Status</th>
                <th class="border px-2 py-1">Date</th>
                <th class="border px-2 py-1">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $req)
            <tr class="hover:bg-gray-100">
                <td class="border px-2 py-1">{{ $req->id }}</td>
                <td class="border px-2 py-1">{{ $req->type }}</td>
                <td class="border px-2 py-1">{{ $req->user->name }}</td>
                <td class="border px-2 py-1">{{ $req->user->email }}</td>
                <td class="border px-2 py-1">₱ {{ number_format($req->amount, 2) }}</td>
                <td class="border px-2 py-1">
                    @if($req->status === 'pending')
                        <span class="text-yellow-600 font-semibold">Pending</span>
                    @elseif($req->status === 'approved')
                        <span class="text-green-600 font-semibold">Approved</span>
                    @else
                        <span class="text-red-600 font-semibold">Rejected</span>
                    @endif
                </td>
                <td class="border px-2 py-1">{{ $req->created_at->format('Y-m-d H:i') }}</td>
                <td class="border px-2 py-1 flex gap-2">
                    @if($req->status === 'pending')
                        {{-- Approve Form --}}
                        <form action="{{ route('requests.approve', $req->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="type" value="{{ $req->type }}">
                            <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                Approve
                            </button>
                        </form>

                        {{-- Reject Form --}}
                        <form action="{{ route('requests.reject', $req->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="type" value="{{ $req->type }}">
                            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                Reject
                            </button>
                        </form>
                    @else
                        <span class="text-gray-500 italic">No actions</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center py-3 text-gray-500">No requests found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</section>
@endsection
