@extends('layouts.admin')

@section('content')
<section id="inventory-section" class="content-section">
    <h2 class="text-2xl font-bold mb-4">Inventory Management</h2>

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

    {{-- Products Table --}}
    <table class="w-full border-collapse border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-2 py-1">Name</th>
                <th class="border px-2 py-1">Category</th>
                <th class="border px-2 py-1">Price</th>
                <th class="border px-2 py-1">Stock</th>
                <th class="border px-2 py-1">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr class="hover:bg-gray-100">
                <td class="border px-2 py-1">{{ $product->name }}</td>
                <td class="border px-2 py-1">{{ $product->category }}</td>
                <td class="border px-2 py-1">₱ {{ number_format($product->price,2) }}</td>
                <td class="border px-2 py-1">{{ $product->stock }}</td>
                <td class="border px-2 py-1">
                    <button
                        class="update-stock-btn px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700"
                        data-id="{{ $product->id }}"
                        data-name="{{ $product->name }}"
                        data-stock="{{ $product->stock }}">
                        Update Stock
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Update Stock Modal --}}
    <div id="stock-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="bg-white p-6 rounded-lg w-96 relative shadow-lg">
            <span id="close-stock-modal" class="absolute top-2 right-3 cursor-pointer text-xl">&times;</span>
            <h3 class="text-xl font-bold mb-4">Update Stock</h3>
            <form action="{{ route('inventory.updateStock') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" id="stock-product-id">

                <label class="block mb-1 text-sm font-semibold">Product:</label>
                <input type="text" id="stock-product-name" class="border p-2 rounded w-full mb-3 bg-gray-100" readonly>

                <label class="block mb-1 text-sm font-semibold">Stock:</label>
                <input type="number" name="stock" id="stock-quantity" class="border p-2 rounded w-full mb-4" min="0" required>

                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-full">
                    Update
                </button>
            </form>
        </div>
    </div>

    {{-- Modal Script --}}
    <script>
        const stockModal = document.getElementById('stock-modal');
        const closeStockModal = document.getElementById('close-stock-modal');
        const productIdInput = document.getElementById('stock-product-id');
        const productNameInput = document.getElementById('stock-product-name');
        const stockQuantityInput = document.getElementById('stock-quantity');

        document.querySelectorAll('.update-stock-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                productIdInput.value = btn.dataset.id;
                productNameInput.value = btn.dataset.name;
                stockQuantityInput.value = btn.dataset.stock;
                stockModal.classList.remove('hidden');
            });
        });

        closeStockModal.addEventListener('click', () => stockModal.classList.add('hidden'));
        stockModal.addEventListener('click', e => {
            if (e.target === stockModal) stockModal.classList.add('hidden');
        });
    </script>
</section>
@endsection