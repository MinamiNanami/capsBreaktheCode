<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $user->name }} - Jariel's Peak Wallet</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<style>
    /* Jariel's Peak Wallet CSS */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #e8f5e8 0%, #f0f9f0 100%);
        min-height: 100vh;
        color: #2d3748;
    }

    .container {
        display: flex;
        min-height: 100vh;
    }

    /* Sidebar Styles */
    .sidebar {
        width: 280px;
        background: linear-gradient(180deg, #22c55e 0%, #16a34a 100%);
        box-shadow: 4px 0 20px rgba(34, 197, 94, 0.1);
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
    }

    .sidebar::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" patternUnits="userSpaceOnUse" width="100" height="100"><circle cx="20" cy="20" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="40" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="80" r="1.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        pointer-events: none;
    }

    .wallet-summary {
        padding: 2rem 1.5rem;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .wallet-icon {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .wallet-icon i {
        font-size: 1.5rem;
        color: white;
    }

    .wallet-summary h2 {
        color: white;
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .token-balance {
        background: rgba(255, 255, 255, 0.15);
        padding: 1rem;
        border-radius: 12px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .token-balance .amount {
        display: block;
        font-size: 2rem;
        font-weight: 700;
        color: white;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .token-balance .currency {
        font-size: 0.875rem;
        color: rgba(255, 255, 255, 0.8);
        font-weight: 500;
        letter-spacing: 1px;
    }

    .sidebar-nav {
        flex: 1;
        padding: 1rem 0;
        position: relative;
        z-index: 1;
    }

    .sidebar-nav ul {
        list-style: none;
    }

    .sidebar-nav li {
        margin: 0.25rem 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .sidebar-nav li:hover {
        transform: translateX(4px);
    }

    .sidebar-nav li span {
        display: inline-block;
        padding: 0.75rem 1rem;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-weight: 500;
        width: 100%;
    }

    .sidebar-nav li i {
        margin-right: 0.75rem;
        width: 16px;
        text-align: center;
    }

    .sidebar-nav li:hover span,
    .sidebar-nav li.active span {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .sidebar-footer {
        padding: 1rem 1.5rem;
        position: relative;
        z-index: 1;
    }

    .sidebar-footer button {
        width: 100%;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        padding: 0.75rem;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
        backdrop-filter: blur(10px);
    }

    .sidebar-footer button:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }

    .sidebar-footer button i {
        margin-right: 0.5rem;
    }

    /* Main Content */
    .main-content {
        flex: 1;
        padding: 2rem;
        overflow-y: auto;
    }

    .content-section {
        display: none;
    }

    .content-section.active {
        display: block;
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Wallet Card */
    .wallet-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(34, 197, 94, 0.1);
        border: 1px solid rgba(34, 197, 94, 0.1);
        max-width: 400px;
        margin: 0 auto;
        position: relative;
        overflow: hidden;
    }

    .wallet-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #22c55e, #10b981);
    }

    .wallet-card-header h3 {
        color: #1f2937;
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .wallet-card-balance {
        text-align: center;
        margin-bottom: 2rem;
    }

    .wallet-card-balance .amount {
        display: block;
        font-size: 3rem;
        font-weight: 700;
        color: #22c55e;
        margin-bottom: 0.5rem;
    }

    .wallet-card-balance .currency {
        font-size: 1rem;
        color: #6b7280;
        font-weight: 500;
        letter-spacing: 1px;
    }

    .wallet-card-actions {
        text-align: center;
    }

    /* Section Headers */
    h1 {
        color: #1f2937;
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    h1 i {
        color: #22c55e;
    }

    /* Buttons */
    .btn-action {
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
        margin-bottom: 1.5rem;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(34, 197, 94, 0.4);
    }

    .btn-send {
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
    }

    .btn-send:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(34, 197, 94, 0.4);
    }

    .btn-cancel {
        background: #f3f4f6;
        color: #6b7280;
        border: 1px solid #d1d5db;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-right: 0.5rem;
    }

    .btn-cancel:hover {
        background: #e5e7eb;
        transform: translateY(-1px);
    }

    /* Transactions */
    .transactions-list {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(34, 197, 94, 0.1);
    }

    .transactions-list ul {
        list-style: none;
    }

    .transactions-list li {
        padding: 1rem;
        border-bottom: 1px solid #f3f4f6;
        color: #4b5563;
        font-weight: 500;
    }

    .transactions-list li:last-child {
        border-bottom: none;
    }

    .transactions-list li:hover {
        background: #f9fafb;
        border-radius: 6px;
    }

    .transactions-list p {
        color: #6b7280;
        font-style: italic;
        text-align: center;
        padding: 2rem;
    }

    /* Table Styles */
    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        margin-top: 1rem;
    }

    th {
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        color: white;
        padding: 1rem;
        text-align: left;
        font-weight: 600;
    }

    td {
        padding: 1rem;
        border-bottom: 1px solid #f3f4f6;
        color: #4b5563;
    }

    tr:hover td {
        background: #f9fafb;
    }

    tr:last-child td {
        border-bottom: none;
    }

    /* Profile Styles */
    .profile-content {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(34, 197, 94, 0.1);
    }

    .profile-header {
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        color: white;
        padding: 2rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid rgba(255, 255, 255, 0.3);
        background: rgba(255, 255, 255, 0.1);
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-info h2 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .profile-info p {
        color: rgba(255, 255, 255, 0.8);
        font-size: 1rem;
    }

    .profile-details {
        padding: 2rem;
        display: grid;
        gap: 2rem;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    }

    .detail-card {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 1.5rem;
    }

    .detail-card h3 {
        color: #1f2937;
        font-size: 1.125rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #22c55e;
    }

    /* Forms */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        color: #374151;
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #22c55e;
        box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-actions {
        text-align: right;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
        margin-top: 1.5rem;
    }

    /* Modal */
    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: white;
        border-radius: 16px;
        width: 90%;
        max-width: 500px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: modalSlideIn 0.3s ease-out;
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: scale(0.9) translateY(-20px);
        }

        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .modal-header {
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        color: white;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-radius: 16px 16px 0 0;
    }

    .modal-header h3 {
        font-size: 1.25rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .close {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .close:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(90deg);
    }

    .modal form {
        padding: 2rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .container {
            flex-direction: column;
        }

        .sidebar {
            width: 100%;
            order: 2;
            flex-direction: row;
            height: auto;
            padding: 1rem;
        }

        .wallet-summary {
            padding: 1rem;
            flex: 1;
        }

        .sidebar-nav {
            flex: 2;
            padding: 0 1rem;
        }

        .sidebar-nav ul {
            display: flex;
            gap: 0.5rem;
            overflow-x: auto;
        }

        .sidebar-nav li {
            margin: 0;
            white-space: nowrap;
        }

        .sidebar-footer {
            padding: 1rem;
            flex: 1;
        }

        .main-content {
            order: 1;
            padding: 1rem;
        }

        .profile-details {
            grid-template-columns: 1fr;
        }

        .detail-card {
            min-width: unset;
        }

        .wallet-card {
            margin: 0;
            max-width: unset;
        }
    }
</style>

<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="wallet-summary">
                <div class="wallet-icon"><i class="fas fa-wallet"></i></div>
                <h2>{{ $user->name }}'s Wallet</h2>
                <div class="token-balance">
                    <span class="amount">{{ number_format($user->wallet_balance ?? 0, 2) }}</span>
                    <span class="currency">JPT</span>
                </div>
            </div>
            <div class="sidebar-nav">
                <ul>
                    <li class="active" data-section="dashboard"><i class="fas fa-home"></i><span>Dashboard</span></li>
                    <li data-section="transactions"><i class="fas fa-history"></i><span>Transactions</span></li>
                    <li data-section="balance-requests"><i class="fas fa-credit-card"></i><span>Balance Requests</span></li>
                    <li data-section="profile"><i class="fas fa-user"></i><span>Profile</span></li>
                </ul>
            </div>
            <div class="sidebar-footer">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <button id="logoutBtn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i><span>Logout</span>
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Dashboard -->
            <div id="dashboard-section" class="content-section active">
                <div class="wallet-card">
                    <div class="wallet-card-header">
                        <h3>Wallet Overview</h3>
                    </div>
                    <div class="wallet-card-balance">
                        <span class="amount">{{ number_format($user->wallet_balance ?? 0, 2) }}</span>
                        <span class="currency">JPT</span>
                    </div>
                    <div class="wallet-card-actions">
                        <button class="btn-action" onclick="showRequestForm()">
                            <i class="fas fa-plus-circle"></i> Request Balance
                        </button>
                    </div>
                </div>
            </div>

            <!-- Transactions -->
            <div id="transactions-section" class="content-section">
                <h1><i class="fas fa-history"></i> Transaction History</h1>
                <div class="transactions-list full">
                    @if($transactions->isEmpty())
                    <p>No transactions yet.</p>
                    @else
                    <ul>
                        @foreach($transactions as $transaction)
                        <li>
                            {{ $transaction->description }} —
                            {{ number_format($transaction->amount, 2) }} JPT —
                            {{ $transaction->created_at->format('M d, Y') }}
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>

            <!-- Balance Requests -->
            <div id="balance-requests-section" class="content-section">
                <h1><i class="fas fa-credit-card"></i> Balance Requests</h1>
                <button class="btn-action" onclick="showRequestForm()">➕ New Request</button>

                @if($balanceRequests->isEmpty())
                <p>No balance requests yet.</p>
                @else
                <table class="w-full border-collapse border mt-4">
                    <thead>
                        <tr>
                            <th class="border px-2 py-1">Amount</th>
                            <th class="border px-2 py-1">Note</th>
                            <th class="border px-2 py-1">Status</th>
                            <th class="border px-2 py-1">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($balanceRequests as $request)
                        <tr>
                            <td class="border px-2 py-1">{{ number_format($request->amount, 2) }} JPT</td>
                            <td class="border px-2 py-1">{{ $request->note ?? '-' }}</td>
                            <td class="border px-2 py-1">{{ ucfirst($request->status) }}</td>
                            <td class="border px-2 py-1">{{ $request->created_at->format('M d, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>

            <!-- Profile -->
            <div id="profile-section" class="content-section">
                <h1><i class="fas fa-user-circle"></i> Profile</h1>
                <div class="profile-content">
                    <div class="profile-header">
                        <div class="profile-avatar">
                            <img src="{{ asset('images/logo.jpg') }}" alt="Avatar" />
                        </div>
                        <div class="profile-info">
                            <h2>{{ $user->name }}</h2>
                            <p>{{ $user->email }}</p>
                        </div>
                    </div>
                    <div class="profile-details">
                        <div class="detail-card">
                            <h3>Basic Information</h3>
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required />
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required />
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn-send">Save Changes</button>
                                </div>
                            </form>
                        </div>

                        <div class="detail-card">
                            <h3>Change Password</h3>
                            <form action="{{ route('password.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>Current Password</label>
                                    <input type="password" name="current_password" required />
                                </div>
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input type="password" name="password" required />
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn-send">Update Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Balance Request Modal -->
    <div id="requestModal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-credit-card"></i> Request Balance</h3>
                <span class="close" onclick="closeRequestForm()">&times;</span>
            </div>
            <form action="{{ route('balance.request.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Amount (JPT)</label>
                    <input type="number" name="amount" min="1" step="1" required />
                </div>
                <div class="form-group">
                    <label>Note (Optional)</label>
                    <textarea name="note"></textarea>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="closeRequestForm()">Cancel</button>
                    <button type="submit" class="btn-send">Submit Request</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showRequestForm() {
            document.getElementById('requestModal').style.display = 'block';
        }

        function closeRequestForm() {
            document.getElementById('requestModal').style.display = 'none';
        }

        // Sidebar navigation
        document.querySelectorAll('.sidebar-nav ul li').forEach(item => {
            item.addEventListener('click', () => {
                document.querySelectorAll('.content-section').forEach(section => section.classList.remove('active'));
                document.querySelectorAll('.sidebar-nav ul li').forEach(li => li.classList.remove('active'));
                item.classList.add('active');
                const sectionId = item.getAttribute('data-section') + '-section';
                document.getElementById(sectionId).classList.add('active');
            });
        });
    </script>
</body>

</html>