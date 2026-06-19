<header class="h-16 flex items-center justify-between px-6 bg-white border-b sticky top-0 z-20 ml-64">
    <h1 class="text-lg font-semibold text-gray-800">@yield('page-title', 'Super Admin')</h1>

    <div class="flex items-center gap-4" x-data="{ open: false }">
        

        <!-- User Dropdown -->
        <div class="relative">
            <button @click="open = !open"
                class="flex items-center gap-3 hover:opacity-80 transition">
                <span class="text-sm text-gray-700 hidden sm:block">{{ auth()->user()->name }}</span>
                <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center text-xs font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <svg class="w-4 h-4 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" @click.away="open = false"
                class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border z-50 py-1"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100">

                <div class="px-4 py-3 border-b">
                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                    <span class="inline-block mt-1 px-2 py-0.5 text-xs rounded-full bg-indigo-100 text-indigo-800">Super Admin</span>
                </div>

                <a href="{{ route('super-admin.profile') }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                    <span>👤</span> My Profile
                </a>
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                    <span>🏠</span> Back to App
                </a>

                <div class="border-t mt-1 pt-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition text-left">
                            <span>🚪</span> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>