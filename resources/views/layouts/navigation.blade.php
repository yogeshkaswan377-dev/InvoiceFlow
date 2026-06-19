<nav x-data="{ open: false }"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl border-r border-gray-200/50 dark:border-gray-800/50 transition-all duration-300 overflow-y-auto">

    <div class="flex flex-col h-full">
        {{-- Logo Section --}}
        <div class="px-5 py-6 border-b border-gray-100/50 dark:border-gray-800/50">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                {{-- Animated Logo --}}
                <div class="relative w-10 h-10 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/25 group-hover:shadow-indigo-500/40 group-hover:scale-105 transition-all duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    {{-- Glow Effect --}}
                    <div class="absolute inset-0 rounded-xl bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 blur-xl opacity-30 group-hover:opacity-50 transition-opacity duration-300 -z-10"></div>
                </div>
                <div>
                    <span class="text-lg font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-400 bg-clip-text text-transparent">GST</span>
                    <span class="text-lg font-bold bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400 bg-clip-text text-transparent">Bill</span>
                </div>
            </a>
        </div>

        {{-- User Mini Profile --}}
        <div class="px-4 py-4 border-b border-gray-100/50 dark:border-gray-800/50">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="w-9 h-9 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center text-white font-semibold text-sm shadow-lg shadow-blue-500/20">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-500 border-2 border-white dark:border-gray-900 rounded-full"></span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>

        {{-- Navigation Links --}}
        <div class="flex-1 px-3 py-5 space-y-1 overflow-y-auto">

            {{-- Dashboard --}}
            <a href="{{ route('dashboard') }}"
                class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 relative overflow-hidden
                      {{ request()->routeIs('dashboard') 
                         ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-400' 
                         : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800/50 hover:text-gray-900 dark:hover:text-white' }}">
                {{-- Active Indicator --}}
                @if(request()->routeIs('dashboard'))
                <div class="absolute left-0 top-2 bottom-2 w-1 bg-indigo-600 dark:bg-indigo-400 rounded-full"></div>
                @endif
                <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('dashboard') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>Dashboard</span>
            </a>

            {{-- Section: Invoices --}}
            <div class="pt-5 pb-2">
                <p class="px-3 text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Invoices</p>
            </div>

            @php
            $invoiceLinks = [
            ['route' => 'gst-invoices.index', 'label' => 'GST Invoices', 'icon' => '
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />'],
            ['route' => 'gst-invoices.create', 'label' => 'New GST Invoice', 'icon' => '
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />'],
            ['route' => 'proformas.index', 'label' => 'Proformas', 'icon' => '
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />'],
            ['route' => 'proformas.create', 'label' => 'New Proforma', 'icon' => '
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />'],
            ];
            @endphp

            @foreach($invoiceLinks as $link)
            <a href="{{ route($link['route']) }}"
                class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 relative overflow-hidden
                      {{ request()->routeIs($link['route']) 
                         ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-400' 
                         : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800/50 hover:text-gray-900 dark:hover:text-white' }}">
                @if(request()->routeIs($link['route']))
                <div class="absolute left-0 top-2 bottom-2 w-1 bg-indigo-600 dark:bg-indigo-400 rounded-full"></div>
                @endif
                <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs($link['route']) ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    {!! $link['icon'] !!}
                </svg>
                <span>{{ $link['label'] }}</span>
            </a>
            @endforeach

            {{-- Section: Management --}}
            <div class="pt-5 pb-2">
                <p class="px-3 text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Management</p>
            </div>

            @php
            $manageLinks = [
            ['route' => 'clients.index', 'label' => 'Clients', 'icon' => '
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />'],
            ['route' => 'products.index', 'label' => 'Products', 'icon' => '
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />'],
            ];
            @endphp

            @foreach($manageLinks as $link)
            <a href="{{ route($link['route']) }}"
                class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 relative overflow-hidden
                      {{ request()->routeIs($link['route']) 
                         ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-400' 
                         : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800/50 hover:text-gray-900 dark:hover:text-white' }}">
                @if(request()->routeIs($link['route']))
                <div class="absolute left-0 top-2 bottom-2 w-1 bg-indigo-600 dark:bg-indigo-400 rounded-full"></div>
                @endif
                <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs($link['route']) ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    {!! $link['icon'] !!}
                </svg>
                <span>{{ $link['label'] }}</span>
            </a>
            @endforeach

            {{-- Section: Reports --}}
            <div class="pt-5 pb-2">
                <p class="px-3 text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Reports</p>
            </div>

            <a href="{{ route('reports.outstanding') }}"
                class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 relative overflow-hidden
                      {{ request()->routeIs('reports.*') 
                         ? 'bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400' 
                         : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800/50 hover:text-gray-900 dark:hover:text-white' }}">
                @if(request()->routeIs('reports.*'))
                <div class="absolute left-0 top-2 bottom-2 w-1 bg-amber-600 dark:bg-amber-400 rounded-full"></div>
                @endif
                <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('reports.*') ? 'text-amber-600 dark:text-amber-400' : 'text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Outstanding</span>
                @if(isset($overdueCount) && $overdueCount > 0)
                <span class="ml-auto px-2 py-0.5 text-[11px] font-bold bg-red-100 dark:bg-red-900/50 text-red-600 dark:text-red-400 rounded-full animate-pulse">{{ $overdueCount }}</span>
                @endif
            </a>
        </div>

        {{-- Bottom Actions --}}
        <div class="border-t border-gray-100/50 dark:border-gray-800/50 p-3 space-y-1">
            {{-- Company Settings --}}
            <a href="{{ route('company.settings') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800/50 hover:text-gray-900 dark:hover:text-white transition-all duration-200">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Settings</span>
            </a>

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Log Out</span>
                </button>
            </form>
        </div>
    </div>
</nav>

{{-- Mobile overlay --}}
<div x-show="open" @click="open = false" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden" x-cloak></div>