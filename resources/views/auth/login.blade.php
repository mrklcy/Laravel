<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - CLSU ADSO</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --clsu-green: #009639;
            --clsu-cobra: #1E6031;
            --clsu-yellow: #FFD700;
            --clsu-gold: #E0A70D;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #004d1f 0%, var(--clsu-cobra) 50%, var(--clsu-green) 100%);
            min-height: 100vh;
            position: relative;
            padding: 1rem 0;
        }

        /* Animated Blobs */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.2;
            z-index: 0;
            animation: float 20s ease-in-out infinite;
        }
        .blob-1 {
            width: 500px;
            height: 500px;
            background: var(--clsu-yellow);
            top: -150px;
            right: -150px;
        }
        .blob-2 {
            width: 400px;
            height: 400px;
            background: #00ff88;
            bottom: -100px;
            left: -100px;
            animation-delay: -5s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }

        /* Login Card */
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            z-index: 1; /* Above blobs */
            animation: slideUp 0.6s ease-out;
        }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-header {
            background: linear-gradient(135deg, var(--clsu-green) 0%, var(--clsu-cobra) 100%);
            padding: 2.5rem 2rem 2rem;
            text-align: center;
            color: white;
            position: relative;
        }
        
        .logo-img {
            width: 90px;
            height: 90px;
            background: white;
            padding: 10px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            margin-bottom: 1.5rem;
        }

        .form-control {
            border-radius: 12px;
            padding: 0.75rem 1rem 0.75rem 3rem; /* Space for icon */
            border: 2px solid #e5e7eb;
            background-color: #f9fafb;
            font-size: 0.95rem;
            font-weight: 500;
        }
        .form-control:focus {
            border-color: var(--clsu-green);
            box-shadow: 0 0 0 4px rgba(0, 150, 57, 0.1);
            background-color: white;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            width: 20px;
            height: 20px;
            z-index: 5;
            pointer-events: none;
        }
        .input-group { position: relative; }

        .btn-login {
            background: linear-gradient(135deg, var(--clsu-green) 0%, var(--clsu-cobra) 100%);
            border: none;
            border-radius: 12px;
            padding: 0.875rem;
            font-weight: 700;
            color: white;
            transition: all 0.2s;
            font-size: 1rem;
            letter-spacing: 0.3px;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 150, 57, 0.4);
            color: white;
        }
        
        .form-check-input:checked {
            background-color: var(--clsu-green);
            border-color: var(--clsu-green);
        }

        .link-back {
            color: var(--clsu-green);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: transform 0.2s;
        }
        .link-back:hover { 
            color: var(--clsu-cobra); 
            transform: translateX(-3px);
        }

        .footer {
            color: rgba(255,255,255,0.8);
            font-size: 0.85rem;
            margin-top: 1.5rem;
            text-align: center;
            z-index: 1;
        }
        
        /* Mobile adjustments */
        @media (max-width: 576px) {
            .login-header { padding: 2rem 1.5rem 1.5rem; }
            .login-card > div.p-4 { padding: 1.5rem !important; }
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 py-4">

    <!-- Blobs -->
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-11 col-sm-10 col-md-8 col-lg-5 col-xl-4 col-xxl-3">
                
                <div class="login-card">
                    <div class="login-header">
                        <img src="/images/clsu-logo-green.png" alt="CLSU Logo" class="logo-img">
                        <h2 class="fw-bold mb-1">Admin Panel</h2>
                        <p class="mb-0 opacity-75 small fw-medium">Administrative Services Development Office</p>
                    </div>

                    <div class="p-4 p-md-5 bg-white">
                        @if(session('success'))
                            <div class="alert alert-success border-0 shadow-sm d-flex align-items-center mb-4" role="alert" style="background-color: #d1fae5; color: #065f46;">
                                <svg class="bi flex-shrink-0 me-2" width="20" height="20" fill="currentColor" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg>
                                <div class="small fw-bold">{{ session('success') }}</div>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center mb-4" role="alert" style="background-color: #fee2e2; color: #991b1b;">
                                <svg class="bi flex-shrink-0 me-2" width="20" height="20" fill="currentColor" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>
                                <div class="small fw-bold">Invalid credentials.</div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.login') }}">
                            @csrf
                            
                            <div class="mb-4">
                                <label for="email" class="form-label fw-bold small text-secondary">EMAIL ADDRESS</label>
                                <div class="input-group">
                                    <span class="input-icon">
                                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="name@clsu.edu.ph">
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-bold small text-secondary">PASSWORD</label>
                                <div class="input-group">
                                    <span class="input-icon">
                                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    </span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="••••••••">
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label small text-secondary" for="remember">Remember me</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-login w-100 mb-4">Sign In</button>

                            <div class="text-center">
                                <a href="{{ route('home') }}" class="link-back">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                                    Back to Website
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="footer">
                    <p class="mb-0 fw-medium">© {{ date('Y') }} Central Luzon State University</p>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
