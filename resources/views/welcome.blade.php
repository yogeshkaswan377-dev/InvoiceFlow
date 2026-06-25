<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO Meta --}}
    <title>GST Invoicing Software & Proforma Generator | Fast & Compliant</title>
    <meta name="description" content="Streamline Indian B2B billing. Automate accurate CGST, SGST, & IGST splits, convert proformas instantly, and generate UPI QR codes. Start free today!">
    <meta name="keywords" content="GST billing software, online invoicing SaaS, Proforma invoice generator India, automated tax billing app, Indian tax compliance engine, HSN SAC code billing, GSTR-1 ready reports, multi-company billing system, business invoice API">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url('/') }}">

    <meta property="og:title" content="GST Invoicing Software & Proforma Generator | Fast & Compliant">
    <meta property="og:description" content="Automate CGST, SGST & IGST splits. Convert proformas instantly. Generate UPI QR codes.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="GST Invoicing Software & Proforma Generator">

    <link rel="icon" href="/favicon.ico">
    <meta name="theme-color" content="#1e3a8a">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #1e3a8a;
            --primary-light: #3b82f6;
            --accent: #f59e0b;
            --bg: #f8fafc;
            --text: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            overflow-x: hidden;
            background: #f8fafc;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 14px 0;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        }

        .brand-logo {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            font-weight: 800;
        }

        .brand-name {
            font-size: 20px;
            font-weight: 800;
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-link {
            font-weight: 600 !important;
            color: #0f172a !important;
            font-size: 14px;
            transition: all 0.3s;
        }

        .nav-link:hover {
            color: #3b82f6 !important;
        }

        .btn-nav {
            padding: 10px 22px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-login {
            color: var(--primary);
            border: 1.5px solid var(--border);
            background: white;
        }

        .btn-login:hover {
            border-color: var(--primary-light);
            background: #f8fafc;
        }

        .btn-start {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            color: white;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }

        .btn-start:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
            color: white;
        }

        /* ===== HERO ===== */
        .hero {
            padding: 100px 0 80px;
            background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 50%, #eef2ff 100%);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -20%;
            width: 700px;
            height: 700px;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.06), rgba(139, 92, 246, 0.04));
            border-radius: 50%;
        }

        .hero-badge {
            background: #dbeafe;
            color: #1d4ed8;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 800;
            color: var(--text);
            line-height: 1.15;
        }

        .hero h1 span {
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            font-size: 1.1rem;
            color: var(--muted);
            line-height: 1.7;
            max-width: 560px;
        }

        .hero-img {
            max-width: 100%;
            border-radius: 20px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.12);
        }

        /* ===== STATS RIBBON ===== */
        .stats-ribbon {
            background: white;
            border-radius: 20px;
            padding: 30px 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
            margin-top: -50px;
            position: relative;
            z-index: 10;
        }

        .stat-item {
            text-align: center;
            padding: 0 20px;
        }

        .stat-item:not(:last-child) {
            border-right: 1px solid var(--border);
        }

        .stat-number {
            font-size: 28px;
            font-weight: 800;
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-desc {
            font-size: 13px;
            color: var(--muted);
            font-weight: 500;
        }

        /* ===== SECTION TITLES ===== */
        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--text);
        }

        .section-title p {
            color: var(--muted);
            font-size: 1.05rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .section-title .underline {
            width: 60px;
            height: 3px;
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            margin: 15px auto 0;
            border-radius: 5px;
        }

        /* ===== BIG 4 FEATURES ===== */
        .big-feature-card {
            background: white;
            border-radius: 24px;
            padding: 36px 28px;
            transition: all 0.3s ease;
            border: 1px solid #f1f5f9;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .big-feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.08);
            border-color: #bfdbfe;
        }

        .big-feature-card::before {
            content: '';
            position: absolute;
            top: -40%;
            right: -40%;
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.04), rgba(139, 92, 246, 0.03));
            border-radius: 50%;
        }

        .big-feature-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .big-feature-icon.blue {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .big-feature-icon.green {
            background: #d1fae5;
            color: #059669;
        }

        .big-feature-icon.purple {
            background: #ede9fe;
            color: #7c3aed;
        }

        .big-feature-icon.amber {
            background: #fef3c7;
            color: #d97706;
        }

        .big-feature-card h3 {
            font-size: 19px;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .big-feature-card p {
            font-size: 14px;
            color: var(--muted);
            line-height: 1.7;
            margin: 0;
            position: relative;
            z-index: 1;
        }

        /* ===== ADVANCED INSIGHTS ===== */
        .insight-card {
            background: white;
            border-radius: 20px;
            padding: 28px;
            border-left: 4px solid #3b82f6;
            transition: all 0.3s ease;
            height: 100%;
        }

        .insight-card:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.06);
            transform: translateX(4px);
        }

        .insight-card h4 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .insight-card p {
            font-size: 13px;
            color: var(--muted);
            line-height: 1.6;
            margin: 0;
        }

        .insight-icon {
            font-size: 24px;
            margin-bottom: 12px;
        }

        /* ===== TESTIMONIALS ===== */
        .testimonials-section {
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
            padding: 70px 0;
            overflow: hidden;
        }

        .testimonials-track {
            display: flex;
            gap: 24px;
            animation: scrollTestimonials 35s linear infinite;
            width: fit-content;
        }

        .testimonials-track:hover {
            animation-play-state: paused;
        }

        .testimonial-card {
            flex: 0 0 350px;
            background: white;
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            border: 1px solid #f1f5f9;
        }

        .testimonial-text {
            font-size: 14px;
            line-height: 1.7;
            color: #475569;
            font-style: italic;
            margin-bottom: 16px;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-top: 16px;
            border-top: 1px solid #f1f5f9;
        }

        .author-avatar {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 18px;
        }

        .author-name {
            font-size: 14px;
            font-weight: 700;
            color: var(--text);
        }

        .author-role {
            font-size: 11px;
            color: var(--muted);
        }

        .stars {
            color: #f59e0b;
            font-size: 13px;
            margin-bottom: 8px;
        }

        @keyframes scrollTestimonials {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        /* ===== FAQ ===== */
        .faq-section {
            background: white;
            border-radius: 24px;
            padding: 40px;
        }

        .accordion-button {
            font-weight: 600 !important;
            font-size: 15px !important;
            background: white !important;
            box-shadow: none !important;
        }

        .accordion-button:not(.collapsed) {
            color: #1e3a8a !important;
            background: #f8fafc !important;
        }

        .accordion-body {
            font-size: 14px;
            color: #64748b;
            line-height: 1.7;
        }

        /* ===== CTA ===== */
        .cta-section {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            padding: 80px 0;
            text-align: center;
            border-radius: 30px;
            margin: 60px 0;
        }

        .cta-section h2 {
            font-size: 2.2rem;
            font-weight: 800;
            color: white;
        }

        .cta-section p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.05rem;
            margin-bottom: 30px;
        }

        .btn-cta {
            background: white;
            color: var(--primary);
            padding: 14px 36px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 16px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            color: var(--primary);
        }

        /* ===== FOOTER ===== */
        .footer {
            background: #0f172a;
            color: white;
            padding: 50px 0 20px;
        }

        .footer a {
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            font-size: 13px;
            transition: all 0.3s;
        }

        .footer a:hover {
            color: white;
        }

        .footer h5 {
            color: white;
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 16px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .hero {
                padding: 60px 0 40px;
                text-align: center;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                max-width: 100%;
                font-size: 0.95rem;
            }

            .stat-item:not(:last-child) {
                border-right: none;
                border-bottom: 1px solid var(--border);
                padding-bottom: 16px;
                margin-bottom: 16px;
            }

            .stats-ribbon {
                padding: 20px;
                margin-top: -30px;
            }

            .stat-number {
                font-size: 22px;
            }

            .section-title h2 {
                font-size: 1.6rem;
            }

            .testimonial-card {
                flex: 0 0 280px;
                padding: 20px;
            }

            .cta-section {
                padding: 50px 20px;
                border-radius: 20px;
                margin: 30px 0;
            }

            .cta-section h2 {
                font-size: 1.5rem;
            }

            .faq-section {
                padding: 24px 16px;
            }
        }
    </style>
</head>

<body>

    {{-- ===== NAVBAR ===== --}}
    <nav class="navbar navbar-expand-lg sticky-top" id="navbar">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="InvoiceFlow" style="width:42px; height:42px; border-radius:12px;">
                <span class="brand-name">InvoiceFlow</span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navContent">
                <ul class="navbar-nav mx-auto gap-1">
                    <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#insights">Insights</a></li>
                    <li class="nav-item"><a class="nav-link" href="#testimonials">Testimonials</a></li>
                    <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
                </ul>

                <div class="d-flex gap-2">
                    @auth
                    <a href="{{ route('dashboard') }}" class="btn-nav btn-start">Dashboard</a>
                    @else
                    <a href="{{ route('login') }}" class="btn-nav btn-login">Login</a>
                    <a href="{{ route('register') }}" class="btn-nav btn-start">Get Started</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- ===== HERO ===== --}}
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="mb-3">
                        <span class="hero-badge">🇮🇳 Built for Indian Scale</span>
                    </div>
                    <h1>The Smarter <span>GST Billing Software</span> Built for Indian Scale</h1>
                    <p class="mt-3">
                        Stop wrestling with complex tax calculations and compliance errors. Instantly generate flawless, audited Proforma and Tax Invoices with automated tax splits, native HSN compliance, and built-in UPI payment links.
                    </p>
                    <div class="d-flex gap-3 mt-4">
                        <a href="{{ route('register') }}" class="btn-nav btn-start" style="padding:14px 30px; font-size:15px;">
                            <i class="fas fa-file-invoice me-2"></i> Create Your First Invoice Free
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="https://placehold.co/600x400/1e3a8a/white?text=GST+Invoice+Dashboard"
                        alt="GST Billing Pro Dashboard"
                        class="hero-img img-fluid">
                </div>
            </div>
        </div>
    </section>

    {{-- ===== STATS RIBBON ===== --}}
    <div class="container">
        <div class="stats-ribbon">
            <div class="row g-0">
                <div class="col-6 col-md-3 stat-item">
                    <div class="stat-number">100%</div>
                    <div class="stat-desc">GST Compliance</div>
                </div>
                <div class="col-6 col-md-3 stat-item">
                    <div class="stat-number">50L+</div>
                    <div class="stat-desc">Invoices Generated</div>
                </div>
                <div class="col-6 col-md-3 stat-item">
                    <div class="stat-number">5,000+</div>
                    <div class="stat-desc">Active Businesses</div>
                </div>
                <div class="col-6 col-md-3 stat-item">
                    <div class="stat-number">7x</div>
                    <div class="stat-desc">Faster Payments</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== BIG 4 FEATURES ===== --}}
    <section id="features" class="py-5 mt-5">
        <div class="container">
            <div class="section-title">
                <h2>The Core Engine Behind Your Billing</h2>
                <p>Four powerful pillars that transform your invoicing workflow</p>
                <div class="underline"></div>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="big-feature-card">
                        <div class="big-feature-icon blue"><i class="fas fa-balance-scale"></i></div>
                        <h3>Zero-Error Dual Mode GST Engine</h3>
                        <p>Protect your business from costly audit compliance mistakes with automatic Place of Supply (POS) detection that instantly applies accurate CGST, SGST, and IGST splits. Seamlessly toggle between tax-inclusive and tax-exclusive pricing models with perfect mathematical precision down to the last paisa.</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="big-feature-card">
                        <div class="big-feature-icon green"><i class="fas fa-shuffle"></i></div>
                        <h3>One-Click Proforma to Tax Invoice Pipeline</h3>
                        <p>Accelerate your deals by moving clients effortlessly from initial estimate to final payment without double data entry. The intelligent workflow handles sequential tracking numbers across financial years, ensuring your accounting remains audit-ready and organized automatically.</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="big-feature-card">
                        <div class="big-feature-icon purple"><i class="fas fa-qrcode"></i></div>
                        <h3>Dynamic PDFs with Instant UPI Payment QR Codes</h3>
                        <p>Get paid up to 7x faster by embedding secure, dynamic UPI payment QR codes directly onto beautifully structured invoice layouts. Your client and company records are fiercely protected by a bank-grade data-isolation policy architecture that guarantees absolute data privacy.</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="big-feature-card">
                        <div class="big-feature-icon amber"><i class="fas fa-bolt"></i></div>
                        <h3>Headless, Next.js-Ready REST API Architecture</h3>
                        <p>Future-proof your operational growth with an ultra-fast backend engineered to process hundreds of bills a second without performance drops. Seamlessly connect your web platform to future mobile apps, custom customer portals, or external ERP systems with no structural re-engineering required.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== ADVANCED INSIGHTS ===== --}}
    <section id="insights" class="py-5 bg-white">
        <div class="container">
            <div class="section-title">
                <h2>CFO-Grade Ledger Intelligence & Tax Readiness</h2>
                <p>Take the anxiety out of monthly filing cycles and tax season</p>
                <div class="underline"></div>
            </div>

            <p style="text-align:center; color:#64748b; max-width:700px; margin:0 auto 40px; font-size:14px; line-height:1.7;">
                Our advanced reporting layer translates raw invoice data into high-fidelity financial clarity, allowing modern business owners, CFOs, and CAs to monitor cash flow health in real time.
            </p>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="insight-card">
                        <div class="insight-icon">📊</div>
                        <h4>GSTR-1 Ready Summaries</h4>
                        <p>Export accurate, pre-formatted tax metrics that map directly to governmental filing requirements, saving hours of manual reconciliation.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="insight-card">
                        <div class="insight-icon">📈</div>
                        <h4>Granular Financial Snapshots</h4>
                        <p>Instantly break down your top-line earnings, collected taxes, and outstanding liabilities using clean monthly and quarterly reporting charts.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="insight-card">
                        <div class="insight-icon">⏰</div>
                        <h4>Aging Receivable Tracking</h4>
                        <p>Stop chasing late payments blindly—quickly view outstanding debts and send professional reminder nudges straight from your main dashboard.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== TESTIMONIALS ===== --}}
    <section id="testimonials" class="testimonials-section">
        <div class="container">
            <div class="section-title">
                <h2>Trusted by Businesses Across India</h2>
                <p>Join thousands of happy customers who bill smarter</p>
                <div class="underline"></div>
            </div>

            <div class="testimonials-track" id="testimonialsTrack">
                @php
                $testimonials = [
                ['name'=>'Rajesh Patel', 'role'=>'Owner, Patel Traders, Ahmedabad', 'text'=>'This software saved me hours every week. GST invoices now take less than a minute. The auto tax-split is flawless!', 'color'=>'#1d4ed8', 'initial'=>'R'],
                ['name'=>'Priya Sharma', 'role'=>'Chartered Accountant, Mumbai', 'text'=>'As a CA managing 50+ clients, this tool is a lifesaver. GSTR-1 ready reports are accurate and save me hours of manual work.', 'color'=>'#059669', 'initial'=>'P'],
                ['name'=>'Amit Gupta', 'role'=>'Director, Gupta Enterprises, Delhi', 'text'=>'Best GST billing software I have used. Clean interface, fast performance, and excellent customer support. Switched from Tally!', 'color'=>'#7c3aed', 'initial'=>'A'],
                ['name'=>'Sneha Iyer', 'role'=>'Freelancer, Bengaluru', 'text'=>'Even as a freelancer, this makes my invoicing professional. Clients love the clean PDF invoices with UPI QR codes.', 'color'=>'#d97706', 'initial'=>'S'],
                ['name'=>'Vikram Singh', 'role'=>'MD, Singh Distributors, Jaipur', 'text'=>'Bulk invoice feature is a game changer. The API architecture allowed us to integrate with our existing ERP seamlessly.', 'color'=>'#e11d48', 'initial'=>'V'],
                ];
                $testimonials = array_merge($testimonials, $testimonials);
                @endphp

                @foreach($testimonials as $t)
                <div class="testimonial-card">
                    <div class="stars">⭐⭐⭐⭐⭐</div>
                    <p class="testimonial-text">"{{ $t['text'] }}"</p>
                    <div class="testimonial-author">
                        <div class="author-avatar" style="background:{{ $t['color'] }};">{{ $t['initial'] }}</div>
                        <div>
                            <div class="author-name">{{ $t['name'] }}</div>
                            <div class="author-role">{{ $t['role'] }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===== FAQ ===== --}}
    <section id="faq" class="py-5">
        <div class="container">
            <div class="section-title">
                <h2>Frequently Asked Questions</h2>
                <p>Everything you need to know about GST compliance</p>
                <div class="underline"></div>
            </div>

            <div class="faq-section">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item border-0 mb-2">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                How does the platform handle intra-state vs. inter-state GST auto-detection?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                The platform reads the buyer's and seller's respective states via their registered GSTIN and Place of Supply (POS). It instantly triggers the correct tax logic—automatically calculating and splitting CGST + SGST for internal operations, or applying IGST for transactions across state lines.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-2">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Can I easily switch between tax-inclusive and tax-exclusive billing modes?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes. The dual-mode calculation engine lets you switch your tax logic on the fly. Whether your client contract demands a flat rate inclusive of taxes or standard line-item pricing plus tax, the engine recalculates the entire ledger dynamically without any manual rounding errors.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-2">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Is my financial data secure from other businesses using the app?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Absolutely. The system is designed using a strict data-isolation architectural pattern. Every company workspace operates inside its own secure layer, ensuring that your corporate records, transaction history, and client details are strictly visible to your authenticated team members only.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                Can I export data directly to my Chartered Accountant (CA) for monthly filing?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes. The system generates clean, audit-ready financial overviews and GSTR-1 summaries. You can download your data in structured formats or perfectly compiled PDFs to hand directly to your tax professional, making tax season frictionless.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== CTA ===== --}}
    <section class="container">
        <div class="cta-section">
            <h2>Ready to Transform Your GST Billing?</h2>
            <p>Join thousands of Indian businesses billing smarter, faster, and fully compliant.</p>
            <a href="{{ route('register') }}" class="btn-cta">
                <i class="fas fa-rocket me-2"></i> Create Your First Invoice Free
            </a>
        </div>
    </section>

    {{-- ===== FOOTER ===== --}}
    <footer id="contact" class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="brand-logo">G</div>
                        <span style="font-size:18px; font-weight:700; color:white;">GST Billing Pro</span>
                    </div>
                    <p style="color:rgba(255,255,255,0.5); font-size:13px;">
                        The smarter GST billing software built for Indian scale. Automate tax compliance, generate proformas, and get paid faster.
                    </p>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Product</h5>
                    <ul class="list-unstyled">
                        <li><a href="#features">Features</a></li>
                        <li><a href="#insights">Insights</a></li>
                        <li><a href="#">API</a></li>
                        <li><a href="#faq">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Company</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">About</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Careers</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Legal</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Contact</h5>
                    <ul class="list-unstyled" style="color:rgba(255,255,255,0.5); font-size:13px;">
                        <li><i class="fas fa-envelope me-2"></i> hello@gstbillingpro.com</li>
                        <li><i class="fas fa-phone me-2"></i> +91 99999 99999</li>
                    </ul>
                </div>
            </div>
            <hr style="border-color:rgba(255,255,255,0.1);">
            <div class="text-center" style="color:rgba(255,255,255,0.4); font-size:12px;">
                &copy; {{ date('Y') }} GST Billing Pro. All rights reserved. Made with ❤️ in India.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        window.addEventListener('scroll', () => {
            document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 50);
        });

        const track = document.getElementById('testimonialsTrack');
        track.addEventListener('mouseenter', () => track.style.animationPlayState = 'paused');
        track.addEventListener('mouseleave', () => track.style.animationPlayState = 'running');
    </script>

</body>

</html>