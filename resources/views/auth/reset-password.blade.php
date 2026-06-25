<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - GST Billing Pro</title>
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
        }

        h1 {
            font-size: 20px;
            font-weight: 700;
            text-align: center;
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
    </style>
</head>

<body>
    <div class="auth-card">
        <h1><i class="fas fa-lock me-2" style="color:#3b82f6;"></i>Reset Password</h1>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label class="form-label fw-semibold" style="font-size:13px;">Email</label>
                <input type="email" name="email" value="{{ old('email', $email) }}" class="form-control" required readonly>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold" style="font-size:13px;">New Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold" style="font-size:13px;">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn-primary text-white">
                <i class="fas fa-check-circle me-2"></i> Reset Password
            </button>
        </form>
    </div>
</body>

</html>