@extends('layouts.admin')

@section('content')
<section id="wallet-section" class="content-section">
    <h2 class="text-2xl font-bold mb-4">Wallet Management</h2>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            <ul class="list-disc pl-6">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Wallet Table --}}
    <table class="w-full border-collapse border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-2 py-1">User</th>
                <th class="border px-2 py-1">Email</th>
                <th class="border px-2 py-1">Balance</th>
                <th class="border px-2 py-1">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="hover:bg-gray-100">
                <td class="border px-2 py-1">{{ $user->name }}</td>
                <td class="border px-2 py-1">{{ $user->email }}</td>
                <td class="border px-2 py-1">₱ {{ number_format($user->wallet_balance,2) }}</td>
                <td class="border px-2 py-1">
                    <button class="update-wallet-btn px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700"
                        data-id="{{ $user->id }}"
                        data-name="{{ $user->name }}"
                        data-balance="{{ $user->wallet_balance }}">
                        Update Balance
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Update Wallet Modal -->
    <div id="wallet-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="bg-white p-6 rounded-lg w-96 relative">
            <span id="close-wallet-modal" class="absolute top-2 right-3 cursor-pointer text-xl">&times;</span>
            <h3 class="text-xl font-bold mb-4">Update Wallet Balance</h3>
            <form action="{{ route('wallet.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" id="wallet-user-id">

                <label>User:</label>
                <input type="text" id="wallet-user-name" class="border p-2 rounded w-full mb-2" readonly>

                <label>Amount to Add:</label>
                <input type="number" name="amount" id="wallet-amount" class="border p-2 rounded w-full mb-2" required>

                <label>Upload Proof Image:</label>
                <input type="file" name="proof_image" accept="image/*" class="border p-2 rounded w-full mb-4" required>

                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-full">
                    Update
                </button>
            </form>
        </div>
    </div>

    {{-- Modal Script --}}
    <script>
        const walletModal = document.getElementById('wallet-modal');
        const closeWalletModal = document.getElementById('close-wallet-modal');
        const walletUserIdInput = document.getElementById('wallet-user-id');
        const walletUserNameInput = document.getElementById('wallet-user-name');
        const walletAmountInput = document.getElementById('wallet-amount');

        document.querySelectorAll('.update-wallet-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                walletUserIdInput.value = btn.dataset.id;
                walletUserNameInput.value = btn.dataset.name;
                walletAmountInput.value = '';
                walletModal.classList.remove('hidden');
            });
        });

        closeWalletModal.addEventListener('click', () => walletModal.classList.add('hidden'));
        walletModal.addEventListener('click', e => {
            if (e.target === walletModal) walletModal.classList.add('hidden');
        });
    </script>
</section>
@endsection
