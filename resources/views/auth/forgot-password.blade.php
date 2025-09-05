<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | Jariel's Peak</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background-image: url("{{ asset('images/bg.jpg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 1rem;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 400px;
        }

        .logo {
            width: 120px;
            height: 120px;
            background-color: #f0f0f0;
            border: 2px dashed #ccc;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 0.75rem;
            color: #999;
        }

        .title {
            font-size: 1.25rem;
            font-weight: bold;
            color: #2E7D32;
            text-align: center;
            margin-bottom: 1.5rem;
            letter-spacing: 0.5px;
        }

        .description {
            font-size: 0.9rem;
            color: #555;
            text-align: center;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #4CAF50;
            z-index: 1;
        }

        .input-field {
            width: 85%;
            padding: 0.75rem 1rem 0.75rem 2.75rem;
            border: 2px solid #E0E0E0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: white;
        }

        .input-field:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        }

        .error-message {
            color: #f44336;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        .success-message {
            background-color: #E8F5E8;
            color: #2E7D32;
            padding: 0.75rem;
            border-radius: 8px;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .submit-btn {
            width: 100%;
            background: linear-gradient(135deg, #4CAF50, #66BB6A);
            border: none;
            border-radius: 8px;
            padding: 0.875rem;
            color: white;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, #43A047, #4CAF50);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <!-- Logo -->
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo" style="object-fit: cover;">

            <!-- Title -->
            <div class="title">FORGOT PASSWORD</div>

            <!-- Description -->
            <div class="description">
                Forgot your password? Enter your email and we’ll send you a link to reset it.
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="success-message">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Reset Form -->
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email -->
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" class="input-field" placeholder="Email Address" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit -->
                <button type="submit" class="submit-btn">
                    Email Password Reset Link
                </button>
            </form>
        </div>
    </div>
</body>
</html>
