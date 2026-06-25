<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Password - GST Billing Pro</title>
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
            max-width: 400px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .icon-circle {
            width: 56px;
            height: 56px;
            background: #fef3c7;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #d97706;
            margin: 0 auto 16px;
        }

        h1 {
            font-size: 18px;
            font-weight: 700;
        }

        p {
            color: #64748b;
            font-size: 13px;
        }

        .form-control {
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            padding: 12px 14px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            border: none;
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="auth-card">
        <div class="icon-circle"><i class="fas fa-shield-alt"></i></div>
        <h1>Confirm Password</h1>
        <p>Please confirm your password to continue.</p>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf
            <div class="mb-3 text-start">
                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
            </div>
            <button type="submit" class="btn-primary text-white">
                <i class="fas fa-check me-2"></i> Confirm
            </button>
        </form>
    </div>
</body>

</html>