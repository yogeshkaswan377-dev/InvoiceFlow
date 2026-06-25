<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - GST Billing Pro</title>
    <meta name="description" content="Create your free GST Billing Pro account. Start creating GST invoices in minutes.">
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
            max-width: 460px;
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
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .btn-register {
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            color: white;
            border: none;
            padding: 13px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            width: 100%;
        }

        .btn-register:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
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
        <div class="logo">G</div>
        <h1>Create Your Account</h1>
        <p class="subtitle">Start creating GST invoices in minutes</p>

        @if($errors->any())
        <div class="alert alert-danger rounded-3 border-0" style="font-size:13px;">
            @foreach($errors->all() as $error)
            <div><i class="fas fa-exclamation-circle me-2"></i> {{ $error }}</div>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="row g-2 mb-2">
                <div class="col-md-6">
                    <label class="form-label fw-semibold" style="font-size:13px;">Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold" style="font-size:13px;">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold" style="font-size:13px;">Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="you@company.com" required>
            </div>

            <div class="row g-2 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold" style="font-size:13px;">Password *</label>
                    <input type="password" name="password" class="form-control" placeholder="Min 8 characters" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold" style="font-size:13px;">Confirm Password *</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>

            <button type="submit" class="btn-register">
                <i class="fas fa-user-plus me-2"></i> Create Free Account
            </button>
        </form>

        <p class="text-center mt-4" style="font-size:13px; color:#64748b;">
            Already registered? <a href="{{ route('login') }}" class="link">Login here</a>
        </p>
    </div>
</body>

</html>