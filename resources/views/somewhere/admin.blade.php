<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - Jariel's Peak</title>
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}" />
    <style>
        #image-preview {
            max-width: 100px;
            display: none;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="admin-container">

        <!-- Notification Container -->
        <div id="notification-container"></div>

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Jariel's Peak</h2>
                <button id="mobile-menu-toggle" class="mobile-menu-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
            <ul class="sidebar-menu">
                <li class="active" data-section="dashboard"><a href="#">Dashboard Summary</a></li>
                <li data-section="users-section"><a href="#">Manage Users</a></li>
                <li data-section="product-management"><a href="#">Manage Products</a></li>
                <li data-section="pos"><a href="#">Sales Dashboard</a></li>
                <li data-section="transactions"><a href="#">Transactions</a></li>
                <li data-section="inventory"><a href="#">Inventory Management</a></li>
                <li data-section="wallet"><a href="#">Wallet Management</a></li>
                <li data-section="load-approval"><a href="#">Load Request Approval</a></li>
                <li data-section="blockchain-section">
                    <a href="#">
                        <span class="icon">🪙</span>
                        <span>Blockchain & Tokens</span>
                    </a>
                </li>
                <li data-section="logout">
                    <a href="#">
                        <span class="icon">🚪</span>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">

            <!-- Dashboard Section -->
            <section id="dashboard" class="content-section active">
                <h1>Dashboard Summary</h1>
                <div class="dashboard-container">
                    <div class="dashboard-left">
                        <div class="cards">
                            <div class="card">
                                <h3>Total Users</h3>
                                <p id="total-users">0</p>
                            </div>
                            <div class="card">
                                <h3>Total Products</h3>
                                <p id="total-products">0</p>
                            </div>
                            <div class="card">
                                <h3>Total Orders</h3>
                                <p id="total-orders">0</p>
                            </div>
                            <div class="card">
                                <h3>Total Token Transactions</h3>
                                <p id="total-transactions">0</p>
                            </div>
                        </div>
                    </div>

                    <div class="dashboard-right">
                        <div class="dashboard-stats">
                            <div class="stat-card">
                                <h3>Total Sales</h3>
                                <p id="total-sales-dashboard">₱0.00</p>
                            </div>
                            <div class="stat-card">
                                <h3>Best Seller</h3>
                                <p id="best-seller">-</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Manage Users Section -->
            <section id="users-section" class="content-section hidden">
                <h2>Manage Users</h2>

                <div class="filter-bar">
                    <label for="roleFilter">Filter by Role:</label>
                    <select id="roleFilter">
                        <option value="all">All</option>
                        <option value="admin">Admin</option>
                        <option value="wallet">Wallet</option>
                        <option value="customer">Customer (Kiosk)</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>

                <div class="user-controls">
                    <button id="create-user-btn">+ Create User</button>
                </div>

                <div class="table-container">
                    <table id="usersTable">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody">
                            <!-- Dynamic rows go here -->
                        </tbody>
                    </table>
                </div>

                <!-- Create User Modal -->
                <div id="create-user-modal" class="modal hidden">
                    <div class="modal-content">
                        <span class="close-btn" id="close-user-modal">&times;</span>
                        <h3>Create New User</h3>
                        <form id="create-user-form">
                            <label for="fullname">Full Name:</label>
                            <input type="text" id="fullname" name="fullname" required />

                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required />

                            <label for="username">Username:</label>
                            <input type="text" id="username" name="username" required />

                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" required />

                            <label for="role">Role:</label>
                            <select id="role" name="role" required>
                                <option value="">Select Role</option>
                                <option value="kiosk">Kiosk</option>
                                <option value="staff">Staff</option>
                                <option value="admin">Admin</option>
                            </select>

                            <button type="submit">Create Account</button>
                        </form>
                    </div>
                </div>
            </section>

            <!-- Manage Products Section -->
            <section id="product-management" class="content-section hidden">
                <h2>Manage Products</h2>

                <div class="product-controls">
                    <button id="add-product-btn">+ Add Product</button>
                    <img id="image-preview" alt="Image Preview">
                </div>

                <div class="table-container">
                    <table id="productTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="product-table-body">
                            <!-- Dynamic product rows will go here -->
                        </tbody>
                    </table>
                </div>

                <!-- Product Modal -->
                <div id="product-modal" class="modal hidden">
                    <div class="modal-content">
                        <span class="close-btn" id="close-product-modal">&times;</span>
                        <h3 id="modal-title">Add Product</h3>
                        <form id="product-form" enctype="multipart/form-data">
                            <input type="hidden" name="product_id" id="product-id" />

                            <label>
                                Name:
                                <input type="text" name="name" id="product-name" required />
                            </label>
                            <label>
                                Description:
                                <textarea name="description" id="product-description" rows="3" placeholder="Enter product description..."></textarea>
                            </label>
                            <label>
                                Price:
                                <input type="number" name="price" id="product-price" step="0.01" min="0" required />
                            </label>
                            <label>
                                Category:
                                <select name="category" id="product-category" required>
                                    <option value="">Select Category</option>
                                    <option value="food">Food</option>
                                    <option value="drinks">Drinks</option>
                                    <option value="snacks">Snacks</option>
                                    <option value="desserts">Desserts</option>
                                </select>
                            </label>
                            <label>
                                Status:
                                <select name="status" id="product-status" required>
                                    <option value="Available">Available</option>
                                    <option value="Unavailable">Unavailable</option>
                                </select>
                            </label>
                            <label>
                                Image:
                                <input type="file" name="image" id="newProductImage" accept="image/*">
                            </label>

                            <button type="submit">Save Product</button>
                        </form>
                    </div>
                </div>
            </section>

            <!-- Rest of sections (POS, Transactions, Inventory, Wallet, Load Approval, Blockchain, Logout) -->
            <!-- Keep your original content intact here -->

        </main>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productTableBody = document.getElementById('product-table-body');
            const productModal = document.getElementById('product-modal');
            const addProductBtn = document.getElementById('add-product-btn');
            const closeProductModal = document.getElementById('close-product-modal');
            const productForm = document.getElementById('product-form');
            const imageInput = document.getElementById('newProductImage');
            const imagePreview = document.getElementById('image-preview');
            let editProductId = null;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            addProductBtn.addEventListener('click', () => {
                productForm.reset();
                imagePreview.style.display = 'none';
                editProductId = null;
                productModal.classList.remove('hidden');
            });

            closeProductModal.addEventListener('click', () => {
                productModal.classList.add('hidden');
            });

            imageInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(evt) {
                        imagePreview.src = evt.target.result;
                        imagePreview.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                }
            });

            function loadProducts() {
                fetch('{{ route("products") }}')
                    .then(res => res.json())
                    .then(data => renderProducts(data));
            }

            function renderProducts(products) {
                productTableBody.innerHTML = '';
                products.forEach((p, i) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${i+1}</td>
                        <td>${p.name}</td>
                        <td>${p.category}</td>
                        <td>₱${parseFloat(p.price).toFixed(2)}</td>
                        <td>${p.image ? `<img src="/storage/${p.image}" style="max-width:50px;">` : '-'}</td>
                        <td>${p.status}</td>
                        <td>
                            <button class="edit-btn" data-id="${p.id}">Edit</button>
                            <button class="delete-btn" data-id="${p.id}">Delete</button>
                        </td>
                    `;
                    productTableBody.appendChild(row);
                });

                document.querySelectorAll('.edit-btn').forEach(btn => {
                    btn.addEventListener('click', () => editProduct(btn.dataset.id));
                });
                document.querySelectorAll('.delete-btn').forEach(btn => {
                    btn.addEventListener('click', () => deleteProduct(btn.dataset.id));
                });
            }

            function editProduct(id) {
                fetch(`/admin/products/${id}`)
                    .then(res => res.json())
                    .then(p => {
                        document.getElementById('product-name').value = p.name;
                        document.getElementById('product-description').value = p.description;
                        document.getElementById('product-price').value = p.price;
                        document.getElementById('product-category').value = p.category;
                        document.getElementById('product-status').value = p.status;
                        if (p.image) {
                            imagePreview.src = `/storage/${p.image}`;
                            imagePreview.style.display = 'block';
                        } else {
                            imagePreview.style.display = 'none';
                        }
                        editProductId = p.id;
                        productModal.classList.remove('hidden');
                    });
            }

            function deleteProduct(id) {
                if (!confirm('Are you sure you want to delete this product?')) return;
                fetch(`/admin/products/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                }).then(() => loadProducts());
            }

            productForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(productForm);
                let url = '{{ route("products.store") }}';
                if (editProductId) {
                    url = `/admin/products/${editProductId}`;
                }

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData
                    }).then(res => res.json())
                    .then(() => {
                        loadProducts();
                        productModal.classList.add('hidden');
                    });
            });

            loadProducts();
        });
    </script>
    <script src="{{ asset('js/admin-script.js') }}"></script>
    <script src="{{ asset('js/sales_dashboard.js') }}"></script>
</body>

</html>