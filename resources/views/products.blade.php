@extends('layouts.admin')

@section('content')
<section id="products-section" class="p-6">
    <h2 class="text-2xl font-bold mb-4">Manage Products</h2>

    <!-- Success Message -->
    @if(session('success'))
    <div class="mb-4 px-4 py-2 bg-green-200 text-green-800 rounded">
        {{ session('success') }}
    </div>
    @endif

    <!-- Add Product Button -->
    <div class="mb-4">
        <button id="open-create-modal" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors duration-200">+ Add Product</button>
    </div>

    <!-- Products Table -->
    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2">Name</th>
                    <th class="border px-3 py-2">Category</th>
                    <th class="border px-3 py-2">Price</th>
                    <th class="border px-3 py-2">Status</th>
                    <th class="border px-3 py-2">Created At</th>
                    <th class="border px-3 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $p)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="border px-3 py-2">{{ $p->name }}</td>
                    <td class="border px-3 py-2">{{ $p->category }}</td>
                    <td class="border px-3 py-2">₱ {{ number_format($p->price,2) }}</td>
                    <td class="border px-3 py-2">
                        <span class="px-2 py-1 text-xs rounded {{ $p->status === 'Available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $p->status }}
                        </span>
                    </td>
                    <td class="border px-3 py-2">{{ $p->created_at->format('Y-m-d') }}</td>
                    <td class="border px-3 py-2">
                        <div class="flex gap-2">
                            <button class="edit-btn px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition-colors duration-200"
                                data-id="{{ $p->id }}"
                                data-name="{{ $p->name }}"
                                data-category="{{ $p->category }}"
                                data-price="{{ $p->price }}"
                                data-status="{{ $p->status }}"
                                data-description="{{ $p->description }}">Edit</button>

                            <form action="{{ route('products.destroy', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition-colors duration-200">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-8 text-gray-500">No products found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

<!-- Modal outside the main section -->
<div id="product-modal" class="fixed inset-0 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black bg-opacity-50" id="modal-backdrop"></div>

        <!-- Modal Content -->
        <div id="modal-content" class="relative bg-white p-6 rounded-lg w-full max-w-md transform transition-all scale-95 opacity-0">
            <button id="close-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl font-semibold">&times;</button>
            <h3 id="modal-title" class="text-xl font-bold mb-6">Add Product</h3>

            <form id="product-form" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product_id" id="product-id">
                <!-- Name -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name:</label>
                    <input type="text" name="name" id="name" class="border border-gray-300 p-2 rounded w-full" required>
                </div>
                <!-- Description -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description:</label>
                    <textarea name="description" id="description" rows="3" class="border border-gray-300 p-2 rounded w-full"></textarea>
                </div>
                <!-- Category -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category:</label>
                    <select name="category" id="category" class="border border-gray-300 p-2 rounded w-full" required>
                        <option value="">-- Select Category --</option>
                        <option value="Main Dish">Main Dish</option>
                        <option value="Exotic Dish / Silog">Exotic Dish / Silog</option>
                        <option value="Pancit">Pancit</option>
                        <option value="Rice">Rice</option>
                        <option value="Vegetables">Vegetables</option>
                        <option value="Beverages">Beverages</option>
                    </select>
                </div>
                <!-- Price -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Price:</label>
                    <input type="number" step="0.01" name="price" id="price" class="border border-gray-300 p-2 rounded w-full" required>
                </div>
                <!-- Status -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status:</label>
                    <select name="status" id="status" class="border border-gray-300 p-2 rounded w-full" required>
                        <option value="Available">Available</option>
                        <option value="Unavailable">Unavailable</option>
                    </select>
                </div>
                <!-- Image -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Image:</label>
                    <input type="file" name="image" id="image" accept="image/*" class="border border-gray-300 p-2 rounded w-full">
                </div>
                <!-- Buttons -->
                <div class="flex gap-2">
                    <button type="button" id="cancel-btn" class="flex-1 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</button>
                    <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('product-modal');
        const modalContent = document.getElementById('modal-content');
        const modalBackdrop = document.getElementById('modal-backdrop');
        const openCreateBtn = document.getElementById('open-create-modal');
        const closeModal = document.getElementById('close-modal');
        const cancelBtn = document.getElementById('cancel-btn');
        const modalTitle = document.getElementById('modal-title');
        const form = document.getElementById('product-form');

        function openProductModal(isEdit = false, btn = null) {
            // Show modal
            modal.classList.remove('hidden');

            // Trigger animations
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);

            if (!isEdit) {
                // Create mode
                modalTitle.textContent = 'Add Product';
                form.action = "{{ route('products.store') }}";
                form.querySelector('#product-id').value = '';
                form.reset();

                // Remove PUT method if exists
                const methodInput = form.querySelector('input[name="_method"]');
                if (methodInput) methodInput.remove();
            } else {
                // Edit mode
                modalTitle.textContent = 'Edit Product';
                const id = btn.dataset.id;
                form.action = "{{ url('products') }}/" + id;

                // Add or update PUT method
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

                // Populate form fields
                form.querySelector('#product-id').value = id;
                form.querySelector('#name').value = btn.dataset.name || '';
                form.querySelector('#description').value = btn.dataset.description || '';
                form.querySelector('#category').value = btn.dataset.category || '';
                form.querySelector('#price').value = btn.dataset.price || '';
                form.querySelector('#status').value = btn.dataset.status || '';
            }

            // Focus first input
            setTimeout(() => {
                form.querySelector('#name').focus();
            }, 300);
        }

        function closeProductModal() {
            // Trigger close animations
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');
            modalBackdrop.classList.remove('bg-opacity-50');
            modalBackdrop.classList.add('bg-opacity-0');
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');

            // Hide modal completely after animation
            setTimeout(() => {
                modal.classList.add('hidden', 'pointer-events-none');
            }, 300);
        }

        // Event listeners
        openCreateBtn.addEventListener('click', () => openProductModal(false));

        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', () => openProductModal(true, btn));
        });

        closeModal.addEventListener('click', closeProductModal);
        cancelBtn.addEventListener('click', closeProductModal);

        modalBackdrop.addEventListener('click', closeProductModal);

        // Close modal on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                closeProductModal();
            }
        });

        // Form validation feedback
        form.addEventListener('submit', (e) => {
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Saving...';

            // Re-enable button after a delay (in case of client-side validation errors)
            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Save';
            }, 3000);
        });
    });
</script>
@endsection