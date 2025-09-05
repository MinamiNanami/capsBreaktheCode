@extends('layouts.admin')

@section('content')
<section id="pos-section" class="p-6">
    <h2 class="text-2xl font-bold mb-4">POS Dashboard</h2>

    <!-- Add Sale Button -->
    <div class="mb-4">
        <button id="open-sale-modal" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            + Add Sale
        </button>
    </div>

    <!-- Sales Table -->
    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2">Customer</th>
                    <th class="border px-3 py-2">Service</th>
                    <th class="border px-3 py-2">Total</th>
                    <th class="border px-3 py-2">Discount</th>
                    <th class="border px-3 py-2">Created At</th>
                    <th class="border px-3 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                <tr class="hover:bg-gray-100">
                    <td class="border px-3 py-2">{{ $sale->customer_name }}</td>
                    <td class="border px-3 py-2">{{ $sale->service }}</td>
                    <td class="border px-3 py-2">₱ {{ number_format($sale->total,2) }}</td>
                    <td class="border px-3 py-2">₱ {{ number_format($sale->discount,2) }}</td>
                    <td class="border px-3 py-2">{{ $sale->created_at->format('Y-m-d') }}</td>
                    <td class="border px-3 py-2 flex gap-2">
                        <!-- Edit Button -->
                        <button class="edit-btn px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600"
                            data-id="{{ $sale->id }}"
                            data-customer="{{ $sale->customer_name }}"
                            data-service="{{ $sale->service }}"
                            data-total="{{ $sale->total }}"
                            data-discount="{{ $sale->discount }}">
                            Edit
                        </button>

                        <!-- Delete -->
                        <form action="{{ route('pos.destroy', $sale->id) }}" method="POST"
                            onsubmit="return confirm('Delete this sale?')">
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
                    <td colspan="6" class="text-center py-4">No sales yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Add/Edit Sale Modal -->
    <div id="sale-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="bg-white p-6 rounded-lg w-96 relative">
            <span id="close-sale-modal" class="absolute top-2 right-3 cursor-pointer text-xl">&times;</span>
            <h3 id="modal-title" class="text-xl font-bold mb-4">Add Sale</h3>
            <form id="sale-form" method="POST">
                @csrf
                <input type="hidden" name="sale_id" id="sale-id">

                <label>Customer Name:</label>
                <input type="text" name="customer_name" id="customer_name" class="border p-2 rounded w-full mb-2" required>

                <label>Service:</label>
                <input type="text" name="service" id="service" class="border p-2 rounded w-full mb-2" required>

                <label>Total:</label>
                <input type="number" step="0.01" name="total" id="total" class="border p-2 rounded w-full mb-2" required>

                <label>Discount:</label>
                <input type="number" step="0.01" name="discount" id="discount" class="border p-2 rounded w-full mb-2">

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full mt-2">
                    Save Sale
                </button>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('sale-modal');
        const openBtn = document.getElementById('open-sale-modal');
        const closeBtn = document.getElementById('close-sale-modal');
        const form = document.getElementById('sale-form');
        const modalTitle = document.getElementById('modal-title');

        // Open Add Sale modal
        openBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            modalTitle.textContent = 'Add Sale';
            form.action = "{{ route('pos.store') }}";
            form.querySelector('#sale-id').value = '';
            form.reset();

            // remove _method if exists (fresh add mode)
            let methodInput = form.querySelector('input[name="_method"]');
            if (methodInput) methodInput.remove();
        });

        // Open Edit modal
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                modal.classList.remove('hidden');
                modalTitle.textContent = 'Edit Sale';
                const id = btn.dataset.id;
                form.action = `/pos/${id}`;

                // add/ensure _method=PUT for editing
                let methodInput = form.querySelector('input[name="_method"]');
                if (!methodInput) {
                    methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'PUT';
                    form.appendChild(methodInput);
                } else {
                    methodInput.value = 'PUT';
                }

                form.querySelector('#sale-id').value = id;
                form.querySelector('#customer_name').value = btn.dataset.customer;
                form.querySelector('#service').value = btn.dataset.service;
                form.querySelector('#total').value = btn.dataset.total;
                form.querySelector('#discount').value = btn.dataset.discount;
            });
        });

        // Close modal
        closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
        modal.addEventListener('click', e => {
            if (e.target === modal) modal.classList.add('hidden');
        });
    </script>
</section>
@endsection