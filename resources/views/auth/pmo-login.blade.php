<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PMO Admin Login - CLSU</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --clsu-green: #009639;
            --clsu-cobra: #1E6031;
            --clsu-yellow: #FFD700;
            --clsu-gold: #E0A70D;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #004d1f 0%, var(--clsu-cobra) 50%, var(--clsu-green) 100%);
            position: relative;
            overflow: hidden;
        }

        /* Animated background elements */
        body::before,
        body::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.15;
            animation: float 20s ease-in-out infinite;
        }

        body::before {
            width: 500px;
            height: 500px;
            background: var(--clsu-yellow);
            top: -200px;
            right: -200px;
            animation-delay: -5s;
        }

        body::after {
            width: 400px;
            height: 400px;
            background: #00ff88;
            bottom: -150px;
            left: -150px;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .login-container {
            width: 100%;
            max-width: 460px;
            padding: 20px;
            position: relative;
            z-index: 1;
            animation: slideUp 0.6s ease-out;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 28px;
            box-shadow: 
                0 30px 90px rgba(0, 0, 0, 0.25),
                0 0 0 1px rgba(255, 255, 255, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.6);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .login-header {
            background: linear-gradient(135deg, var(--clsu-green) 0%, var(--clsu-cobra) 100%);
            padding: 50px 40px 40px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: pulse 8s ease-in-out infinite;
        }
        
        .logo-wrapper {
            position: relative;
            display: inline-block;
            margin-bottom: 24px;
        }

        .logo-wrapper::before {
            content: '';
            position: absolute;
            inset: -8px;
            background: linear-gradient(135deg, var(--clsu-yellow), var(--clsu-gold));
            border-radius: 24px;
            opacity: 0.3;
            filter: blur(12px);
            animation: pulse 3s ease-in-out infinite;
        }

        .login-header img {
            width: 90px;
            height: 90px;
            border-radius: 22px;
            background: white;
            padding: 12px;
            position: relative;
            box-shadow: 
                0 10px 30px rgba(0, 0, 0, 0.2),
                0 0 0 4px rgba(255, 215, 0, 0.3);
            transition: transform 0.3s ease;
        }

        .logo-wrapper:hover img {
            transform: scale(1.05) rotate(5deg);
        }
        
        .login-header h1 {
            font-size: 28px;
            font-weight: 800;
            margin: 0 0 8px 0;
            letter-spacing: -0.5px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        
        .login-header p {
            margin: 0;
            opacity: 0.95;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 0.3px;
            position: relative;
        }
        
        .login-body {
            padding: 45px 40px;
        }
        
        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-label {
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 10px;
            font-size: 14px;
            letter-spacing: 0.2px;
            display: block;
        }
        
        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            transition: color 0.3s;
            pointer-events: none;
        }

        .form-control {
            width: 100%;
            border: 2px solid #e5e7eb;
            border-radius: 14px;
            padding: 14px 16px 14px 48px;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: #f9fafb;
            color: #1a1a1a;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--clsu-green);
            background: white;
            box-shadow: 
                0 0 0 4px rgba(0, 150, 57, 0.1),
                0 4px 12px rgba(0, 150, 57, 0.08);
            transform: translateY(-1px);
        }

        .form-control:focus + .input-icon {
            color: var(--clsu-green);
        }

        .form-control::placeholder {
            color: #9ca3af;
        }
        
        .form-control.is-invalid {
            border-color: #ef4444;
            background: #fef2f2;
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--clsu-green) 0%, var(--clsu-cobra) 100%);
            border: none;
            border-radius: 14px;
            padding: 16px 24px;
            font-weight: 700;
            font-size: 16px;
            color: white;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 
                0 4px 14px rgba(0, 150, 57, 0.3),
                inset 0 -2px 0 rgba(0, 0, 0, 0.1);
            letter-spacing: 0.3px;
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 
                0 8px 24px rgba(0, 150, 57, 0.4),
                inset 0 -2px 0 rgba(0, 0, 0, 0.1);
        }
        
        .btn-login:active {
            transform: translateY(0);
            box-shadow: 
                0 2px 8px rgba(0, 150, 57, 0.3),
                inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 28px;
        }

        .form-check-input {
            width: 20px;
            height: 20px;
            border: 2px solid #d1d5db;
            border-radius: 6px;
            margin-right: 10px;
            cursor: pointer;
            transition: all 0.2s;
            appearance: none;
            background: white;
            position: relative;
        }

        .form-check-input:checked {
            background: var(--clsu-green);
            border-color: var(--clsu-green);
        }

        .form-check-input:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 14px;
            font-weight: bold;
        }

        .form-check-label {
            font-size: 14px;
            color: #4b5563;
            font-weight: 500;
            cursor: pointer;
            user-select: none;
        }
        
        .alert {
            border-radius: 12px;
            border: none;
            padding: 14px 18px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
            animation: slideUp 0.4s ease-out;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }
        
        .invalid-feedback {
            font-size: 13px;
            color: #ef4444;
            margin-top: 6px;
            font-weight: 500;
            display: block;
        }

        .back-link {
            text-align: center;
            margin-top: 24px;
        }

        .back-link a {
            color: var(--clsu-green);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .back-link a:hover {
            color: var(--clsu-cobra);
            transform: translateX(-3px);
        }

        .footer-text {
            text-align: center;
            margin-top: 28px;
            animation: slideUp 0.8s ease-out;
        }

        .footer-text small {
            color: rgba(255, 255, 255, 0.9);
            font-size: 13px;
            font-weight: 500;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-container {
                padding: 15px;
            }

            .login-header {
                padding: 40px 30px 30px;
            }

            .login-body {
                padding: 35px 30px;
            }

            .login-header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo-wrapper">
                    <img src="/images/clsu-logo-green.png" alt="CLSU Logo">
                </div>
                <h1>PMO Admin Panel</h1>
                <p>Procurement Management Office</p>
            </div>
            
            <div class="login-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-danger">
                        <strong>Login Failed!</strong> {{ $errors->first() }}
                    </div>
                @endif
                
                <form method="POST" action="{{ route('pmo.login') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-wrapper">
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus
                                   placeholder="pmo@clsu.edu.ph">
                            <svg class="input-icon" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-wrapper">
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required
                                   placeholder="Enter your password">
                            <svg class="input-icon" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                    </div>
                    
                    <button type="submit" class="btn-login">
                        Sign In to PMO
                    </button>
                </form>
                
                <div class="back-link">
                    <a href="{{ route('home') }}">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Website
                    </a>
                </div>
            </div>
        </div>
        
        <div class="footer-text">
            <small>© {{ date('Y') }} Central Luzon State University - Procurement Management Office</small>
        </div>
    </div>
</body>
</html>
