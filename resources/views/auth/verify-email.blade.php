<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email - GST Billing Pro</title>
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
            background: #d1fae5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            color: #059669;
            margin: 0 auto 20px;
        }

        h1 {
            font-size: 20px;
            font-weight: 700;
        }

        p {
            color: #64748b;
            font-size: 13px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            color: white;
        }
    </style>
</head>

<body>
    <div class="auth-card">
        <div class="icon-circle"><i class="fas fa-envelope-open-text"></i></div>
        <h1>Verify Your Email</h1>
        <p>A verification link has been sent to your email address. Please check your inbox.</p>

        @if(session('message'))
        <div class="alert alert-success rounded-3 border-0" style="font-size:13px;">
            {{ session('message') }}
        </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}" class="mt-3">
            @csrf
            <button type="submit" class="btn-primary">
                <i class="fas fa-redo me-2"></i> Resend Verification Email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit" class="btn btn-sm" style="color:#64748b; font-size:12px;">
                <i class="fas fa-sign-out-alt me-1"></i> Logout
            </button>
        </form>
    </div>
</body>

</html>