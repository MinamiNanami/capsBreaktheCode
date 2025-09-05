<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiosk - Jariel's Peak</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 30%, #d1fae5 70%, #bbf7d0 100%);
            min-height: 100vh;
        }

        /* Header Styles */
        .header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(34, 197, 94, 0.1);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            color: #15803d;
            font-size: 2rem;
            font-weight: bold;
            text-shadow: 0 2px 4px rgba(255, 255, 255, 0.5);
        }

        .cart-badge {
            background: rgba(255, 255, 255, 0.95);
            color: #16a34a;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.15);
            border: 1px solid rgba(34, 197, 94, 0.1);
        }

        .cart-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(34, 197, 94, 0.2);
        }

        .cart-count {
            background: #22c55e;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }

        /* Category Buttons */
        .category-container {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin: 2rem 0;
            flex-wrap: wrap;
        }

        .category-btn {
            padding: 12px 24px;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(34, 197, 94, 0.1);
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            font-size: 14px;
            color: #16a34a;
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.1);
        }

        .category-btn.active {
            background: linear-gradient(135deg, #86efac, #4ade80);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(34, 197, 94, 0.25);
        }

        .category-btn:hover:not(.active) {
            background: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(34, 197, 94, 0.2);
            color: #15803d;
            border-color: rgba(34, 197, 94, 0.2);
        }

        /* Product Cards */
        .products-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .product-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(34, 197, 94, 0.08);
            transition: all 0.3s ease;
            position: relative;
            border: 1px solid rgba(34, 197, 94, 0.08);
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(34, 197, 94, 0.15);
            border-color: rgba(34, 197, 94, 0.15);
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .product-image-placeholder {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #22c55e;
            font-size: 14px;
        }

        .product-info {
            padding: 1.5rem;
        }

        .product-name {
            font-size: 1.25rem;
            font-weight: bold;
            color: #15803d;
            margin-bottom: 0.5rem;
        }

        .product-description {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 1rem;
            line-height: 1.4;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #22c55e;
            margin-bottom: 0.5rem;
        }

        .product-category {
            font-size: 12px;
            color: #9ca3af;
            margin-bottom: 1rem;
        }

        .add-to-cart-btn {
            background: linear-gradient(135deg, #86efac, #4ade80);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 50px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .add-to-cart-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(134, 239, 172, 0.4);
            background: linear-gradient(135deg, #4ade80, #22c55e);
        }

        .add-to-cart-btn:active {
            transform: translateY(0);
        }

        /* Cart Panel */
        #cart-panel {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.1);
        }

        #cart-table {
            font-size: 14px;
        }

        #cart-table th {
            background: rgba(220, 252, 231, 0.5);
            color: #15803d;
            font-weight: 600;
            padding: 12px 8px;
        }

        #cart-table td {
            padding: 12px 8px;
            border-bottom: 1px solid rgba(34, 197, 94, 0.08);
        }

        #cart-table input[type="number"] {
            width: 3rem;
            padding: 0.25rem;
            border: 2px solid #dcfce7;
            border-radius: 8px;
            text-align: center;
            transition: all 0.3s ease;
        }

        #cart-table input[type="number"]:focus {
            border-color: #4ade80;
            outline: none;
        }

        .remove-btn {
            color: #dc2626;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .remove-btn:hover {
            color: #991b1b;
            transform: scale(1.1);
        }

        .form-input,
        .form-select {
            width: 100%;
            border: 2px solid #dcfce7;
            border-radius: 12px;
            padding: 12px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-input:focus,
        .form-select:focus {
            border-color: #4ade80;
            outline: none;
            background: white;
        }

        #checkout-btn {
            background: linear-gradient(135deg, #4ade80, #22c55e);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 50px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        #checkout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 222, 128, 0.4);
            background: linear-gradient(135deg, #22c55e, #16a34a);
        }

        #checkout-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Receipt Modal */
        #receipt-modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 50;
        }

        #receipt-modal.hidden {
            display: none;
        }

        #receipt-modal .modal-content {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            width: 400px;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .header {
                padding: 1rem;
            }

            .header h1 {
                font-size: 1.5rem;
            }

            .products-container {
                padding: 0 1rem;
            }

            .category-container {
                margin: 1rem 0;
                gap: 0.5rem;
            }

            .category-btn {
                padding: 8px 16px;
                font-size: 12px;
            }
        }

        /* Make cart sticky on desktop */
        @media (min-width: 768px) {
            #cart-panel {
                position: sticky;
                top: 2rem;
                max-height: calc(100vh - 4rem);
                overflow-y: auto;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <img src="{{ asset('images/logo.png') }}" alt="Jariel's Peak Logo" class="h-20 w-auto">
        <h1> JARIEL'S PEAK</h1>
        <div class="cart-badge">
            🛒 Cart <span class="cart-count" id="cart-count">0</span>
        </div>
    </div>

    <div class="container mx-auto">
        <!-- Category Buttons -->
        <div class="category-container">
            <button class="category-btn active" data-category="all">All</button>
            <button class="category-btn" data-category="Main Dish">Main Dish</button>
            <button class="category-btn" data-category="Exotic Dish / Silog">Exotic Dish / Silog</button>
            <button class="category-btn" data-category="Pancit">Pancit</button>
            <button class="category-btn" data-category="Rice">Rice</button>
            <button class="category-btn" data-category="Vegetables">Vegetables</button>
            <button class="category-btn" data-category="Beverages">Beverages</button>
        </div>

        <div class="md:flex md:gap-8">
            <!-- Products Grid -->
            <div class="md:flex-1 products-container">
                @if($products->isEmpty())
                <p class="text-center text-green-700 text-lg">No products available right now.</p>
                @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="products-grid">
                    @foreach($products as $product)
                    <div class="product-card" data-category="{{ $product->category }}">
                        @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            class="product-image">
                        @else
                        <div class="product-image-placeholder">
                            No Image Available
                        </div>
                        @endif

                        <div class="product-info">
                            <h2 class="product-name">{{ $product->name }}</h2>
                            <p class="product-description">{{ $product->description ?? 'Delicious food item' }}</p>
                            <p class="product-price">₱{{ number_format($product->price, 2) }}</p>
                            <p class="product-category">{{ $product->category }}</p>
                            <button class="add-to-cart-btn" data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                data-price="{{ $product->price }}">
                                ➕ Add to Cart
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Cart Panel -->
            <div id="cart-panel" class="md:w-80 p-6 mt-6 md:mt-0">
                <h2 class="text-2xl font-bold mb-4 text-gray-800">🛒 Your Order</h2>
                <div class="overflow-x-auto">
                    <table class="w-full mb-4" id="cart-table">
                        <thead>
                            <tr>
                                <th class="text-left">Item</th>
                                <th class="text-left">Price</th>
                                <th class="text-left">Qty</th>
                                <th class="text-left">Total</th>
                                <th class="text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="text-right font-bold text-xl text-gray-800 mb-4">
                    Total: ₱<span id="cart-total">0.00</span>
                </div>

                <!-- Order Info -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Order Method</label>
                    <select id="order-method" class="form-select">
                        <option value="Takeout">🥡 Takeout</option>
                        <option value="Dine-in">🍽️ Dine-in</option>
                    </select>
                </div>

                <div class="mb-4" id="table-number-div" style="display:none;">
                    <label class="block text-gray-700 font-semibold mb-2">Table Number</label>
                    <input type="text" id="table-number" class="form-input" placeholder="Enter table number">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Payment Method</label>
                    <select id="payment-method" class="form-select">
                        <option value="Cash">💵 Cash</option>
                        <option value="GCash">📱 GCash</option>
                    </select>
                </div>

                <button id="checkout-btn">
                    🎯 Place Order
                </button>
            </div>
        </div>
    </div>

    <!-- Receipt Modal -->
    <div id="receipt-modal" class="hidden">
        <div class="modal-content">
            <h2 class="text-2xl font-bold text-green-700 mb-4">🧾 Receipt</h2>
            <div id="receipt-content" class="text-gray-800 text-sm mb-4"></div>
            <button id="print-receipt-btn"
                class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded mr-2">🖨️ Print</button>
            <button id="close-receipt-btn"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Close</button>
        </div>
    </div>

    <script>
        // ---------- Category Filter ----------
        const categoryButtons = document.querySelectorAll('.category-btn');
        const products = document.querySelectorAll('#products-grid .product-card');

        categoryButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                categoryButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const selectedCategory = btn.dataset.category;
                products.forEach(product => {
                    product.style.display = (selectedCategory === 'all' || product.dataset.category === selectedCategory) ? 'block' : 'none';
                });
            });
        });

        // ---------- Cart Functionality ----------
        const cart = [];

        function updateCartCount() {
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            document.getElementById('cart-count').textContent = totalItems;
        }

        function renderCart() {
            const tbody = document.querySelector('#cart-table tbody');
            tbody.innerHTML = '';
            let total = 0;

            cart.forEach((item, index) => {
                const subtotal = item.price * item.quantity;
                total += subtotal;

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="font-medium">${item.name}</td>
                    <td>₱${item.price.toFixed(2)}</td>
                    <td>
                        <input type="number" value="${item.quantity}" min="1" data-index="${index}">
                    </td>
                    <td>₱${subtotal.toFixed(2)}</td>
                    <td><span class="remove-btn" data-index="${index}">❌</span></td>
                `;
                tbody.appendChild(tr);
            });

            document.getElementById('cart-total').textContent = total.toFixed(2);

            // Quantity change
            document.querySelectorAll('#cart-table input[type="number"]').forEach(input => {
                input.addEventListener('change', (e) => {
                    const idx = e.target.dataset.index;
                    let val = parseInt(e.target.value);
                    if (isNaN(val) || val < 1) val = 1;
                    cart[idx].quantity = val;
                    renderCart();
                    updateCartCount();
                });
            });

            // Remove item
            document.querySelectorAll('.remove-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const idx = e.target.dataset.index;
                    cart.splice(idx, 1);
                    renderCart();
                    updateCartCount();
                });
            });
        }

        document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                const name = btn.dataset.name;
                const price = parseFloat(btn.dataset.price);

                const existing = cart.find(item => item.id == id);
                if (existing) existing.quantity++;
                else cart.push({ id, name, price, quantity: 1 });

                renderCart();
                updateCartCount();
            });
        });

        // ---------- Order Method ----------
        const orderMethodSelect = document.getElementById('order-method');
        const tableNumberDiv = document.getElementById('table-number-div');

        orderMethodSelect.addEventListener('change', () => {
            tableNumberDiv.style.display = (orderMethodSelect.value === 'Dine-in') ? 'block' : 'none';
        });

        // ---------- Checkout ----------
        const checkoutBtn = document.getElementById('checkout-btn');
        checkoutBtn.addEventListener('click', () => {
            if (cart.length === 0) {
                alert('Your cart is empty!');
                return;
            }

            const orderMethod = orderMethodSelect.value;
            const tableNumber = document.getElementById('table-number').value;
            const paymentMethod = document.getElementById('payment-method').value;

            if (orderMethod === 'Dine-in' && !tableNumber) {
                alert('Please enter table number.');
                return;
            }

            // Generate temporary order number
            const tempOrderNumber = 'JP' + Date.now() + Math.floor(Math.random() * 900 + 100);

            // Show receipt
            showReceipt({
                order_number: tempOrderNumber,
                order_method: orderMethod,
                table_number: orderMethod === 'Dine-in' ? tableNumber : null,
                payment_method: paymentMethod,
                items: [...cart]
            });

            // Clear cart
            cart.length = 0;
            renderCart();
            updateCartCount();
        });

        // ---------- Receipt Modal ----------
        const receiptModal = document.getElementById('receipt-modal');
        const receiptContent = document.getElementById('receipt-content');

        function showReceipt(orderData) {
            let html = '';
            html += `<p><strong>Order Number:</strong> ${orderData.order_number}</p>`;
            html += `<p><strong>Order Method:</strong> ${orderData.order_method}</p>`;
            if (orderData.order_method === 'Dine-in') {
                html += `<p><strong>Table Number:</strong> ${orderData.table_number}</p>`;
            }
            html += `<p><strong>Payment Method:</strong> ${orderData.payment_method}</p>`;
            html += `<hr class="my-2">`;
            html += `<table class="w-full text-left"><thead><tr><th>Item</th><th>Qty</th><th>Total</th></tr></thead><tbody>`;
            orderData.items.forEach(item => {
                html += `<tr><td>${item.name}</td><td>${item.quantity}</td><td>₱${(item.price * item.quantity).toFixed(2)}</td></tr>`;
            });
            html += `</tbody></table><hr class="my-2">`;
            const total = orderData.items.reduce((sum, item) => sum + item.price * item.quantity, 0);
            html += `<p class="font-bold text-right">Total: ₱${total.toFixed(2)}</p>`;
            receiptContent.innerHTML = html;
            receiptModal.classList.remove('hidden');
        }

        document.getElementById('close-receipt-btn').addEventListener('click', () => {
            receiptModal.classList.add('hidden');
        });

        document.getElementById('print-receipt-btn').addEventListener('click', () => {
            const printWindow = window.open('', '', 'height=600,width=400');
            printWindow.document.write('<html><head><title>Receipt</title></head><body >');
            printWindow.document.write(receiptContent.innerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        });
    </script>
</body>

</html>
