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
