@extends('layouts.admin')

@section('content')
<section id="users-section" class="p-6">
    <h2 class="text-2xl font-bold mb-4">Manage Users</h2>

    <!-- Success Message -->
    @if(session('success'))
    <div class="mb-4 px-4 py-2 bg-green-200 text-green-800 rounded">
        {{ session('success') }}
    </div>
    @endif

    <!-- Filter Bar -->
    <div class="filter-bar flex items-center gap-3 mb-4">
        <form method="GET" action="{{ route('users') }}">
            <label for="roleFilter">Filter by Role:</label>
            <select name="role" id="roleFilter" onchange="this.form.submit()" class="border px-2 py-1 rounded">
                <option value="all" {{ request('role') == 'all' ? 'selected' : '' }}>All</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="wallet" {{ request('role') == 'wallet' ? 'selected' : '' }}>Wallet</option>
                <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer (Kiosk)</option>
                <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Staff</option>
            </select>
        </form>
    </div>

    <!-- Create User Button -->
    <div class="user-controls mb-4">
        <button id="create-user-btn" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            + Create User
        </button>
    </div>

    <!-- Users Table -->
    <div class="table-container overflow-x-auto">
        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2">Full Name</th>
                    <th class="border px-3 py-2">Email</th>
                    <th class="border px-3 py-2">Username</th>
                    <th class="border px-3 py-2">Role</th>
                    <th class="border px-3 py-2">Created At</th>
                    <th class="border px-3 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                <tr class="hover:bg-gray-100">
                    <td class="border px-3 py-2">{{ $u->name }}</td>
                    <td class="border px-3 py-2">{{ $u->email }}</td>
                    <td class="border px-3 py-2">{{ $u->username }}</td>
                    <td class="border px-3 py-2">{{ $u->role }}</td>
                    <td class="border px-3 py-2">{{ $u->created_at->format('Y-m-d') }}</td>
                    <td class="border px-3 py-2">
                        <form action="{{ route('users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Create User Modal -->
    <div id="create-user-modal" class="modal hidden">
        <div class="modal-content">
            <span class="close-btn" id="close-user-modal">&times;</span>
            <h3 class="text-xl font-bold mb-3">Create User</h3>
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="mb-2">
                    <label class="block mb-1">Full Name</label>
                    <input type="text" name="name" required class="w-full border px-2 py-1 rounded">
                </div>
                <div class="mb-2">
                    <label class="block mb-1">Email</label>
                    <input type="email" name="email" required class="w-full border px-2 py-1 rounded">
                </div>
                <div class="mb-2">
                    <label class="block mb-1">Username</label>
                    <input type="text" name="username" required class="w-full border px-2 py-1 rounded">
                </div>
                <div class="mb-2">
                    <label class="block mb-1">Password</label>
                    <input type="password" name="password" required class="w-full border px-2 py-1 rounded">
                </div>
                <div class="mb-3">
                    <label class="block mb-1">Role</label>
                    <select name="role" required class="w-full border px-2 py-1 rounded">
                        <option value="admin">Admin</option>
                        <option value="wallet">Wallet</option>
                        <option value="customer">Customer</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save User</button>
            </form>
        </div>
    </div>

    <style>
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal.hidden {
            display: none;
        }

        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 0.75rem;
            width: 400px;
            max-width: 90%;
            position: relative;
        }

        .close-btn {
            position: absolute;
            top: 0.5rem;
            right: 0.75rem;
            font-size: 1.25rem;
            cursor: pointer;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('create-user-modal');
            const openBtn = document.getElementById('create-user-btn');
            const closeBtn = document.getElementById('close-user-modal');

            openBtn.addEventListener('click', () => modal.classList.remove('hidden'));
            closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
            window.addEventListener('click', (e) => {
                if (e.target === modal) modal.classList.add('hidden');
            });
        });
    </script>
</section>
@endsection