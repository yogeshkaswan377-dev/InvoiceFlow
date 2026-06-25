<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'GST Billing Pro') | {{ config('app.name', 'GST Billing Pro') }}</title>
    <meta name="description" content="@yield('meta_description', 'Professional GST billing & invoicing software for Indian businesses.')">
    <meta name="robots" content="noindex, nofollow">

    <link rel="icon" href="/favicon.ico">
    <meta name="theme-color" content="#1e3a8a">

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

        .guest-card {
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
    </style>

    @stack('styles')
</head>

<body>
    <div class="logo" style="background:none;">
        <img src="{{ asset('images/logo.png') }}" alt="InvoiceFlow" style="width:52px; height:52px; border-radius:14px;">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>