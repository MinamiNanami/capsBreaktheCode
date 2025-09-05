<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        /* ==============================
           Admin Panel Layout with Gradient & Modern Design
        ============================== */
        body,
        html {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 30%, #d1fae5 70%, #bbf7d0 100%);
        }

        body {
            display: flex;
            min-height: 100vh;
        }

        /* ------------------------------
           Sidebar
        -------------------------------- */
        .sidebar {
            width: 16rem;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(15px);
            height: 100vh;
            box-shadow: 2px 0 12px rgba(34, 197, 94, 0.1);
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(34, 197, 94, 0.1);
        }

        .sidebar-header {
            padding: 1rem;
            border-bottom: 1px solid rgba(34, 197, 94, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sidebar-header h2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #15803d;
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            padding: 1rem;
            gap: 0.5rem;
            flex-grow: 1;
        }

        .sidebar-menu li {
            list-style: none;
        }

        .sidebar-menu a,
        .sidebar-menu button {
            display: block;
            padding: 0.5rem 0.75rem;
            border-radius: 0.75rem;
            text-decoration: none;
            color: #15803d;
            font-weight: 500;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.1);
        }

        .sidebar-menu a:hover,
        .sidebar-menu button:hover {
            background: linear-gradient(135deg, #86efac, #4ade80);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(34, 197, 94, 0.25);
        }

        .sidebar-menu .icon {
            margin-right: 0.5rem;
        }

        /* ------------------------------
           Main content
        -------------------------------- */
        main {
            flex: 1;
            padding: 2rem;
            overflow-x: auto;
        }

        /* ------------------------------
           Tables
        -------------------------------- */
        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 8px 25px rgba(34, 197, 94, 0.08);
            border-radius: 0.75rem;
            overflow: hidden;
        }

        table th,
        table td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid rgba(34, 197, 94, 0.08);
            color: #374151;
        }

        table th {
            background: rgba(220, 252, 231, 0.5);
            font-weight: 600;
            color: #15803d;
        }

        table tr:hover {
            background: rgba(134, 239, 172, 0.15);
        }

        /* ------------------------------
           Buttons
        -------------------------------- */
        button,
        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        button.primary,
        .btn-primary {
            background: linear-gradient(135deg, #86efac, #4ade80);
            color: white;
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.15);
        }

        button.primary:hover,
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(34, 197, 94, 0.25);
            background: linear-gradient(135deg, #4ade80, #22c55e);
        }

        button.danger,
        .btn-danger {
            background: #ef4444;
            color: #ffffff;
        }

        button.danger:hover,
        .btn-danger:hover {
            background: #b91c1c;
        }

        /* ------------------------------
           Forms / Inputs
        -------------------------------- */
        input,
        select,
        textarea {
            padding: 0.5rem 0.75rem;
            border: 2px solid #dcfce7;
            border-radius: 12px;
            width: 100%;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #4ade80;
            background: white;
        }

        /* ------------------------------
           Modals
        -------------------------------- */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(31, 41, 55, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 50;
        }

        .modal.hidden {
            display: none;
        }

        .modal-content {
            background: rgba(255, 255, 255, 0.95);
            padding: 2rem;
            border-radius: 1rem;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 15px 35px rgba(34, 197, 94, 0.1);
            position: relative;
        }

        .close-btn {
            position: absolute;
            top: 0.5rem;
            right: 0.75rem;
            font-size: 1.25rem;
            cursor: pointer;
        }

        .filter-bar {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .user-controls {
            margin-bottom: 1rem;
        }

        .table-container {
            overflow-x: auto;
        }
    </style>
</head>

<body>
    @include('partials.sidebar')

    <main>
        @yield('content')
    </main>
</body>

</html>