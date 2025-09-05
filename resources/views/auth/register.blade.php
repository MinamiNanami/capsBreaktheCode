<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Jariel's Peak</title>
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

        .register-card {
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
            text-align: center;
            line-height: 1.2;
        }

        .title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #2E7D32;
            margin-bottom: 2rem;
            text-align: center;
            letter-spacing: 1px;
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
            width: 1.2rem;
            height: 1.2rem;
            pointer-events: none;
            z-index: 1;
        }

        .input-field {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.75rem;
            border: 2px solid #E0E0E0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: white;
            box-sizing: border-box;
        }

        .input-field:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        }

        .input-field::placeholder {
            color: #9E9E9E;
        }

        .error-message {
            color: #f44336;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        .register-btn {
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
            margin-bottom: 1.5rem;
        }

        .register-btn:hover {
            background: linear-gradient(135deg, #43A047, #4CAF50);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
        }

        .login-text {
            text-align: center;
            font-size: 0.875rem;
            color: #666;
        }

        .login-link {
            color: #4CAF50;
            text-decoration: none;
            font-weight: 500;
        }

        .login-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-card">
            <!-- Logo Placeholder -->
            <img src="{{ asset('images/logo.png') }}" alt="Jariel's Peak Logo" class="logo" style="object-fit: cover;">

            <!-- Title -->
            <div class="title">REGISTER</div>

            <!-- Registration Form -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="name" class="input-field" placeholder="Full Name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" class="input-field" placeholder="Email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" class="input-field" placeholder="Password" required>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password_confirmation" class="input-field" placeholder="Confirm Password" required>
                    @error('password_confirmation')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Register Button -->
                <button type="submit" class="register-btn">REGISTER</button>

                <!-- Login Redirect -->
                <div class="login-text">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="login-link">Login</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
