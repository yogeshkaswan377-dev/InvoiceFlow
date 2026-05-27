{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>GST Invoice Builder — Create GST Invoices in Seconds</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    animation: {
                        float: 'float 8s ease-in-out infinite',
                        glow: 'glow 6s ease-in-out infinite alternate',
                        gradient: 'gradient 15s ease infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-14px)' }
                        },
                        glow: {
                            '0%': { opacity: '.4' },
                            '100%': { opacity: '.85' }
                        },
                        gradient: {
                            '0%,100%': { backgroundPosition: '0% 50%' },
                            '50%': { backgroundPosition: '100% 50%' }
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            background: #f7f9fc;
        }

        html { scroll-behavior: smooth; }

        .mesh-bg {
            background:
                radial-gradient(circle at top left, rgba(99,102,241,.25), transparent 40%),
                radial-gradient(circle at top right, rgba(168,85,247,.18), transparent 35%),
                radial-gradient(circle at bottom left, rgba(59,130,246,.18), transparent 40%),
                linear-gradient(180deg, #ffffff 0%, #f7f9fc 100%);
        }

        .glass {
            background: rgba(255,255,255,0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.5);
        }

        .soft-shadow {
            box-shadow: 0 12px 40px rgba(99,102,241,.08), 0 2px 10px rgba(0,0,0,.04);
        }

        .curve-top {
            border-top-left-radius: 4rem;
            border-top-right-radius: 4rem;
        }

        .curve-bottom {
            border-bottom-left-radius: 4rem;
            border-bottom-right-radius: 4rem;
        }
    </style>
</head>

<body class="text-slate-900 antialiased">

    {{-- Background --}}
    <div class="fixed inset-0 mesh-bg -z-10"></div>

    {{-- Glow blobs --}}
    <div class="fixed inset-0 pointer-events-none -z-10 overflow-hidden">
        <div class="absolute top-[-120px] left-[-80px] w-[420px] h-[420px] bg-indigo-400/20 rounded-full blur-3xl animate-glow"></div>
        <div class="absolute top-[30%] right-[-120px] w-[520px] h-[520px] bg-purple-400/20 rounded-full blur-3xl animate-glow"></div>
        <div class="absolute bottom-[-120px] left-[30%] w-[420px] h-[420px] bg-blue-400/20 rounded-full blur-3xl animate-glow"></div>
    </div>

    {{-- Announcement Bar --}}
    <div class="bg-slate-950 text-white text-center py-3 text-sm relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-600/20 via-purple-500/20 to-blue-500/20"></div>
        <span class="relative">
            🚀 Now GST 2.0 compliant — Generate invoices instantly with zero setup
        </span>
    </div>

    {{-- Navbar --}}
    <header class="sticky top-0 z-50 backdrop-blur-xl bg-white/70 border-b border-white/60">
        <div class="max-w-7xl mx-auto px-6">
            <div class="h-20 flex items-center justify-between">

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-indigo-500 via-purple-500 to-blue-500 text-white font-black flex items-center justify-center shadow-lg">
                        G
                    </div>
                    <span class="font-bold text-lg">GST Invoice Builder</span>
                </div>

                <nav class="hidden lg:flex items-center gap-8 text-sm text-slate-600">
                    <a href="#features">Features</a>
                    <a href="#pricing">Pricing</a>
                    <a href="#faq">FAQ</a>
                </nav>

                <div class="flex items-center gap-4">
                    <button class="text-sm text-slate-600">Sign in</button>
                    <button class="px-5 py-3 rounded-2xl bg-slate-950 text-white text-sm font-semibold hover:scale-[1.03] transition">
                        Start Free
                    </button>
                </div>

            </div>
        </div>
    </header>

    {{-- Hero --}}
    <section class="pt-24 pb-28 relative overflow-hidden">

        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-16 items-center">

            {{-- Left --}}
            <div>
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass soft-shadow">
                    <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></span>
                    <span class="text-sm text-slate-600">Built for Indian GST compliance</span>
                </div>

                <h1 class="mt-8 text-5xl lg:text-7xl font-black leading-[0.95] tracking-tight">
                    Create GST invoices in
                    <span class="bg-gradient-to-r from-indigo-600 via-purple-500 to-blue-500 bg-clip-text text-transparent">
                        seconds, not minutes.
                    </span>
                </h1>

                <p class="mt-6 text-lg text-slate-600 max-w-xl">
                    Generate GST-compliant invoices, manage clients, and track payments with a modern SaaS dashboard built for Indian businesses.
                </p>

                <div class="mt-10 flex gap-4">
                    <button class="px-8 py-4 rounded-2xl bg-gradient-to-r from-indigo-600 via-purple-500 to-blue-500 text-white font-semibold shadow-xl hover:scale-[1.03] transition">
                        Start Free Trial
                    </button>
                    <button class="px-8 py-4 rounded-2xl glass font-semibold hover:bg-white/80 transition">
                        View Demo
                    </button>
                </div>

                <div class="mt-12 grid grid-cols-3 gap-4 text-center">
                    <div class="glass p-4 rounded-2xl">
                        <div class="font-black text-xl">10K+</div>
                        <div class="text-xs text-slate-500">Businesses</div>
                    </div>
                    <div class="glass p-4 rounded-2xl">
                        <div class="font-black text-xl">2M+</div>
                        <div class="text-xs text-slate-500">Invoices</div>
                    </div>
                    <div class="glass p-4 rounded-2xl">
                        <div class="font-black text-xl">99.9%</div>
                        <div class="text-xs text-slate-500">Uptime</div>
                    </div>
                </div>
            </div>

            {{-- Mock Dashboard --}}
            <div class="relative animate-float">
                <div class="glass rounded-[2.5rem] p-6 soft-shadow">

                    <div class="flex justify-between items-center border-b pb-4">
                        <div class="flex gap-2">
                            <span class="w-3 h-3 bg-red-400 rounded-full"></span>
                            <span class="w-3 h-3 bg-yellow-400 rounded-full"></span>
                            <span class="w-3 h-3 bg-green-400 rounded-full"></span>
                        </div>
                        <span class="text-xs text-slate-400">invoice.gstbuilder.com</span>
                    </div>

                    <div class="mt-6 space-y-4">

                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white rounded-2xl p-4 shadow-sm">
                                <p class="text-xs text-slate-500">Total Invoices</p>
                                <p class="text-3xl font-black">1,284</p>
                            </div>

                            <div class="bg-gradient-to-br from-slate-900 to-slate-700 text-white rounded-2xl p-4">
                                <p class="text-xs text-white/60">Revenue</p>
                                <p class="text-3xl font-black">₹4.2L</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl p-6 shadow-sm">
                            <p class="font-semibold">Recent Invoice</p>
                            <p class="text-sm text-slate-500 mt-1">INV-2026-0142 • GST 18%</p>

                            <div class="mt-4 h-2 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full w-3/4 bg-gradient-to-r from-indigo-500 to-blue-500"></div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </section>

    {{-- Features --}}
    <section id="features" class="py-28 bg-white curve-top curve-bottom">

        <div class="max-w-7xl mx-auto px-6">

            <h2 class="text-5xl font-black tracking-tight">
                Everything you need to run GST billing
            </h2>

            <p class="mt-4 text-slate-600 text-lg max-w-2xl">
                Built for freelancers, SMEs, and growing Indian businesses.
            </p>

            <div class="mt-16 grid lg:grid-cols-3 gap-8">

                @foreach ([
                    ['GST-compliant invoices', 'Auto-generated GST calculations with proper tax breakup'],
                    ['Instant PDF export', 'Download and share professional invoices instantly'],
                    ['Client management', 'Store and manage all your business clients'],
                    ['Invoice tracking', 'Track paid, pending, and overdue invoices'],
                    ['Auto tax calculation', 'Automatically calculate CGST, SGST, IGST'],
                    ['Cloud sync', 'Secure cloud storage for all your invoices']
                ] as $feature)

                <div class="glass p-8 rounded-3xl soft-shadow hover:-translate-y-2 transition">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-r from-indigo-500 to-blue-500 mb-6"></div>
                    <h3 class="font-bold text-xl">{{ $feature[0] }}</h3>
                    <p class="text-slate-600 mt-3 text-sm">{{ $feature[1] }}</p>
                </div>

                @endforeach

            </div>

        </div>
    </section>

    {{-- Pricing --}}
    <section id="pricing" class="py-28">

        <div class="max-w-7xl mx-auto px-6 text-center">

            <h2 class="text-5xl font-black">Simple pricing</h2>
            <p class="mt-4 text-slate-600">No hidden fees. Cancel anytime.</p>

            <div class="mt-16 grid lg:grid-cols-3 gap-8 text-left">

                {{-- Free --}}
                <div class="glass p-10 rounded-3xl">
                    <h3 class="text-xl font-bold">Starter</h3>
                    <p class="text-4xl font-black mt-4">₹0</p>

                    <ul class="mt-6 space-y-2 text-sm text-slate-600">
                        <li>✓ 20 invoices/month</li>
                        <li>✓ GST calculation</li>
                        <li>✓ PDF export</li>
                    </ul>
                </div>

                {{-- Pro --}}
                <div class="bg-gradient-to-br from-indigo-600 to-blue-600 text-white p-10 rounded-3xl shadow-2xl">
                    <span class="text-xs bg-white/20 px-3 py-1 rounded-full">Most Popular</span>

                    <h3 class="text-xl font-bold mt-4">Pro</h3>
                    <p class="text-4xl font-black mt-4">₹299</p>

                    <ul class="mt-6 space-y-2 text-sm text-white/80">
                        <li>✓ Unlimited invoices</li>
                        <li>✓ Client management</li>
                        <li>✓ Priority support</li>
                    </ul>
                </div>

                {{-- Business --}}
                <div class="glass p-10 rounded-3xl">
                    <h3 class="text-xl font-bold">Business</h3>
                    <p class="text-4xl font-black mt-4">Custom</p>

                    <ul class="mt-6 space-y-2 text-sm text-slate-600">
                        <li>✓ Multi-user access</li>
                        <li>✓ API access</li>
                        <li>✓ Dedicated support</li>
                    </ul>
                </div>

            </div>

        </div>

    </section>

    {{-- CTA --}}
    <section class="py-28">
        <div class="max-w-5xl mx-auto px-6">
            <div class="rounded-[3rem] bg-gradient-to-r from-indigo-600 via-purple-500 to-blue-500 text-white p-16 text-center">

                <h2 class="text-5xl font-black">
                    Start generating invoices the modern way
                </h2>

                <p class="mt-6 text-white/80">
                    Join thousands of Indian businesses already using GST Invoice Builder.
                </p>

                <button class="mt-10 px-10 py-4 bg-white text-slate-900 rounded-2xl font-semibold hover:scale-105 transition">
                    Get Started Free
                </button>

            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="border-t bg-white/70 backdrop-blur-xl py-10">
        <div class="max-w-7xl mx-auto px-6 flex justify-between text-sm text-slate-500">
            <p>© {{ date('Y') }} GST Invoice Builder</p>
            <div class="flex gap-6">
                <a href="#">Privacy</a>
                <a href="#">Terms</a>
                <a href="#">Contact</a>
            </div>
        </div>
    </footer>

</body>
</html>