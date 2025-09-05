<!-- resources/views/layouts/sidebar.blade.php -->
<aside class="sidebar w-64 bg-white h-screen shadow-md">
    <div class="sidebar-header p-4 flex justify-between items-center border-b">
        <h2 class="text-xl font-bold">Jariel's Peak</h2>
    </div>

    <ul class="sidebar-menu flex flex-col p-4 gap-2">
        <li>
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 hover:bg-blue-200 rounded">Dashboard Summary</a>
        </li>
        <li>
            <a href="{{ route('users') }}" class="block px-3 py-2 hover:bg-blue-200 rounded">Manage Users</a>
        </li>
        <li>
            <a href="{{ route('products') }}" class="block px-3 py-2 hover:bg-blue-200 rounded">Manage Products</a>
        </li>
        <li>
            <a href="{{ route('pos') }}" class="block px-3 py-2 hover:bg-blue-200 rounded">Sales Dashboard</a>
        </li>
        <li>
            <a href="{{ route('transactions.index') }}" class="block px-3 py-2 hover:bg-blue-200 rounded">Transactions</a>
        </li>
        <li>
            <a href="{{ route('inventory') }}" class="block px-3 py-2 hover:bg-blue-200 rounded">Inventory Management</a>
        </li>
        <li>
            <a href="{{ route('wallet') }}" class="block px-3 py-2 hover:bg-blue-200 rounded">Wallet Management</a>
        </li>
        <li>
            <a href="{{ route('load-approval') }}" class="block px-3 py-2 hover:bg-blue-200 rounded">Load Request Approval</a>
        </li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-3 py-2 hover:bg-red-200 rounded">
                    <span class="icon">🚪</span> Logout
                </button>
            </form>
        </li>
    </ul>
</aside>
