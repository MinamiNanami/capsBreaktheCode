@extends('layouts.admin')

@section('content')
<section id="transactions-section" class="content-section">
    <h2 class="text-2xl font-bold mb-4">Transactions</h2>

    <table class="w-full border-collapse border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-2 py-1">Sale ID</th>
                <th class="border px-2 py-1">Customer</th>
                <th class="border px-2 py-1">Total</th>
                <th class="border px-2 py-1">Discount</th>
                <th class="border px-2 py-1">Order Method</th>
                <th class="border px-2 py-1">Table Number</th>
                <th class="border px-2 py-1">Payment Method</th>
                <th class="border px-2 py-1">Date</th>
                <th class="border px-2 py-1">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr class="hover:bg-gray-100">
                <td class="border px-2 py-1">{{ $sale->id }}</td>
                <td class="border px-2 py-1">{{ $sale->customer_name ?? 'Guest' }}</td>
                <td class="border px-2 py-1">₱ {{ number_format($sale->total,2) }}</td>
                <td class="border px-2 py-1">₱ {{ number_format($sale->discount,2) }}</td>
                <td class="border px-2 py-1">{{ $sale->order_method }}</td>
                <td class="border px-2 py-1">{{ $sale->table_number ?? '-' }}</td>
                <td class="border px-2 py-1">{{ $sale->payment_method }}</td>
                <td class="border px-2 py-1">{{ $sale->created_at->format('Y-m-d H:i') }}</td>
                <td class="border px-2 py-1">
                    <button class="view-btn px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700"
                        data-sale="{{ $sale->id }}">View Items</button>
                </td>
            </tr>

            <!-- Hidden sale items for this sale -->
            <table id="sale-items-{{ $sale->id }}" class="hidden">
                @foreach($sale->items as $item)
                <tr>
                    <td>{{ $item->product->name ?? $item->name ?? 'N/A' }}</td>
                    <td>₱ {{ number_format($item->price,2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₱ {{ number_format($item->subtotal,2) }}</td>
                </tr>
                @endforeach
            </table>
            @endforeach
        </tbody>
    </table>

    <!-- Sale Items Modal -->
    <div id="sale-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="bg-white p-6 rounded-lg w-96 relative">
            <span id="close-sale-modal" class="absolute top-2 right-3 cursor-pointer text-xl">&times;</span>
            <h3 class="text-xl font-bold mb-2">Sale Items</h3>
            <p class="mb-2 text-gray-700">
                <strong>Order Method:</strong> <span id="modal-order-method"></span><br>
                <strong>Table Number:</strong> <span id="modal-table-number"></span><br>
                <strong>Payment Method:</strong> <span id="modal-payment-method"></span>
            </p>
            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-2 py-1">Product</th>
                        <th class="border px-2 py-1">Price</th>
                        <th class="border px-2 py-1">Qty</th>
                        <th class="border px-2 py-1">Subtotal</th>
                    </tr>
                </thead>
                <tbody id="sale-items-body"></tbody>
            </table>
        </div>
    </div>

    <script>
        const saleModal = document.getElementById('sale-modal');
        const saleItemsBody = document.getElementById('sale-items-body');
        const closeSaleModal = document.getElementById('close-sale-modal');

        const modalOrderMethod = document.getElementById('modal-order-method');
        const modalTableNumber = document.getElementById('modal-table-number');
        const modalPaymentMethod = document.getElementById('modal-payment-method');

        document.querySelectorAll('.view-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const saleId = btn.dataset.sale;

                // Get hidden table rows for this sale
                const hiddenTable = document.getElementById(`sale-items-${saleId}`);
                if (hiddenTable) {
                    saleItemsBody.innerHTML = hiddenTable.innerHTML;

                    // Fill modal order info
                    const row = btn.closest('tr');
                    modalOrderMethod.textContent = row.cells[4].textContent;
                    modalTableNumber.textContent = row.cells[5].textContent;
                    modalPaymentMethod.textContent = row.cells[6].textContent;
                } else {
                    saleItemsBody.innerHTML = `<tr><td colspan="4" class="text-center py-2">No items found</td></tr>`;
                    modalOrderMethod.textContent = '';
                    modalTableNumber.textContent = '';
                    modalPaymentMethod.textContent = '';
                }

                saleModal.classList.remove('hidden');
            });
        });

        closeSaleModal.addEventListener('click', () => saleModal.classList.add('hidden'));
        saleModal.addEventListener('click', e => {
            if (e.target === saleModal) saleModal.classList.add('hidden');
        });
    </script>
</section>
@endsection