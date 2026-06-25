<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GST Billing Pro</title>
    <meta name="description" content="Login to your GST Billing Pro account. Manage invoices, clients & GST compliance.">
    <meta name="robots" content="noindex, nofollow">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 50%, #eef2ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-card {
            background: white;
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.1);
        }

        .logo {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 22px;
            font-weight: 800;
            margin: 0 auto 20px;
        }

        h1 {
            font-size: 22px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 6px;
        }

        .subtitle {
            color: #64748b;
            font-size: 13px;
            text-align: center;
            margin-bottom: 28px;
        }

        .form-control {
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            padding: 12px 14px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .btn-login {
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            color: white;
            border: none;
            padding: 13px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            width: 100%;
            transition: all 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
        }

        .link {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
        }

        .link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="auth-card">
        <div class="logo">G</div>
        <h1>Welcome Back</h1>
        <p class="subtitle">Login to your GST Billing Pro account</p>

        @if($errors->any())
        <div class="alert alert-danger rounded-3 border-0" style="font-size:13px;">
            <i class="fas fa-exclamation-circle me-2"></i> {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold" style="font-size:13px;">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="you@company.com" required autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold" style="font-size:13px;">Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <label class="form-check-label" style="font-size:13px;">
                    <input type="checkbox" name="remember" class="form-check-input"> Remember me
                </label>
                <a href="{{ route('password.request') }}" class="link">Forgot password?</a>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt me-2"></i> Login
            </button>
        </form>

        <p class="text-center mt-4" style="font-size:13px; color:#64748b;">
            Don't have an account? <a href="{{ route('register') }}" class="link">Register free</a>
        </p>
    </div>
</body>

</html>