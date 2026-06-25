<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - GST Billing Pro</title>
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
            max-width: 420px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .icon-circle {
            width: 64px;
            height: 64px;
            background: #dbeafe;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            color: #3b82f6;
            margin: 0 auto 20px;
        }

        h1 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        p {
            color: #64748b;
            font-size: 13px;
            margin-bottom: 24px;
        }

        .form-control {
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            padding: 12px 14px;
            font-size: 14px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            border: none;
            padding: 13px;
            border-radius: 12px;
            font-weight: 600;
            width: 100%;
        }

        .link {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
        }
    </style>
</head>

<body>
    <div class="auth-card">
        <div class="icon-circle"><i class="fas fa-key"></i></div>
        <h1>Forgot Password?</h1>
        <p>Enter your email and we'll send you a reset link.</p>

        @if(session('status'))
        <div class="alert alert-success rounded-3 border-0" style="font-size:13px;">
            <i class="fas fa-check-circle me-2"></i> {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3 text-start">
                <label class="form-label fw-semibold" style="font-size:13px;">Email</label>
                <input type="email" name="email" class="form-control" placeholder="you@company.com" required>
            </div>
            <button type="submit" class="btn-primary text-white">
                <i class="fas fa-paper-plane me-2"></i> Send Reset Link
            </button>
        </form>

        <p class="mt-4 mb-0">
            <a href="{{ route('login') }}" class="link"><i class="fas fa-arrow-left me-1"></i> Back to Login</a>
        </p>
    </div>
</body>

</html>