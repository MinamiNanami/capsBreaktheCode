<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login | Jariel's Peak</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Inter', sans-serif;
            background-image: url("{{ asset('images/bg.jpg') }}");
        }
        .login-card {
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
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
        }
        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #4CAF50;
        }
        .forgot-link {
            color: #4CAF50;
            text-decoration: none;
            font-weight: 500;
        }
        .forgot-link:hover {
            text-decoration: underline;
        }
        .login-btn {
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
        .login-btn:hover {
            background: linear-gradient(135deg, #43A047, #4CAF50);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
        }
        .signup-text {
            text-align: center;
            font-size: 0.875rem;
            color: #666;
        }
        .signup-link {
            color: #4CAF50;
            text-decoration: none;
            font-weight: 500;
        }
        .signup-link:hover {
            text-decoration: underline;
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
    </style>
</head>
<body>
    <div style="display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 1rem;">
        <div class="login-card">
            <!-- Logo Placeholder -->
            <img src="{{ asset('images/logo.png') }}" alt="Jariel's Peak Logo" class="logo" style="object-fit: cover;" />

            <!-- Title -->
            <div class="title">JARIEL'S PEAK</div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="success-message">{{ session('status') }}</div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        class="input-field @error('email') border-red-500 @enderror"
                        placeholder="Email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    />
                </div>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror

                <!-- Password -->
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="input-field @error('password') border-red-500 @enderror"
                        placeholder="Password"
                        required
                        autocomplete="current-password"
                    />
                </div>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror

                <!-- Remember + Forgot -->
                <div class="remember-forgot">
                    <label class="remember-me" for="remember">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                        <span>Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                    @endif
                </div>

                <!-- Login Button -->
                <button type="submit" class="login-btn">
                    LOGIN
                </button>

                <!-- Sign Up -->
                <div class="signup-text">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="signup-link">Sign up</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
