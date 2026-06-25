<div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-gray-900/50 lg:hidden" x-cloak></div>

<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col bg-slate-900 text-slate-200 transition-transform duration-300 ease-in-out lg:static lg:translate-x-0">
    <div class="flex items-center gap-2 h-16 px-4 border-b border-gray-800">
        <img src="{{ asset('images/logo.png') }}" alt="InvoiceFlow" style="width:32px; height:32px; border-radius:8px;">
        <span class="text-base font-bold text-white">InvoiceFlow</span>
    </div>

    <nav class="flex-1 space-y-1 px-4 py-4 overflow-y-auto text-sm">
        <a href="{{ route('super-admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-800 {{ Request::is('super-admin/dashboard') ? 'bg-indigo-600 text-white' : 'text-slate-400' }}">
            <i class="fa-solid fa-gauge w-5"></i> Dashboard
        </a>

        <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider pt-4 pb-1">Core Modules</p>
        <a href="/super-admin/companies" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-800 {{ Request::is('super-admin/companies*') ? 'bg-indigo-600 text-white' : 'text-slate-400' }}">
            <i class="fa-solid fa-building w-5"></i> Companies
        </a>
        <a href="/super-admin/users" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-800 {{ Request::is('super-admin/users*') ? 'bg-indigo-600 text-white' : 'text-slate-400' }}">
            <i class="fa-solid fa-users w-5"></i> Users
        </a>

        <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider pt-4 pb-1">Financials</p>
        <a href="/super-admin/subscriptions" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-800 {{ Request::is('super-admin/subscriptions*') ? 'bg-indigo-600 text-white' : 'text-slate-400' }}">
            <i class="fa-solid fa-credit-card w-5"></i> Subscriptions
        </a>
        <a href="/super-admin/invoices" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-800 {{ Request::is('super-admin/invoices*') ? 'bg-indigo-600 text-white' : 'text-slate-400' }}">
            <i class="fa-solid fa-file-invoice-dollar w-5"></i> Invoices
        </a>
        <a href="/super-admin/proformas" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-800 {{ Request::is('super-admin/proformas*') ? 'bg-indigo-600 text-white' : 'text-slate-400' }}">
            <i class="fa-solid fa-file-invoice w-5"></i> Proformas
        </a>

        <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider pt-4 pb-1">Intelligence & Debug</p>
        <a href="/super-admin/analytics" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-800 {{ Request::is('super-admin/analytics*') ? 'bg-indigo-600 text-white' : 'text-slate-400' }}">
            <i class="fa-solid fa-chart-simple w-5"></i> Analytics
        </a>
        <a href="/super-admin/audit" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-800 {{ Request::is('super-admin/audit*') ? 'bg-indigo-600 text-white' : 'text-slate-400' }}">
            <i class="fa-solid fa-clipboard-check w-5"></i> Audit Trails
        </a>
        <a href="/super-admin/logs" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-800 {{ Request::is('super-admin/logs*') ? 'bg-indigo-600 text-white' : 'text-slate-400' }}">
            <i class="fa-solid fa-terminal w-5"></i> Logs
        </a>
        <a href="/super-admin/settings" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-800 {{ Request::is('super-admin/settings*') ? 'bg-indigo-600 text-white' : 'text-slate-400' }}">
            <i class="fa-solid fa-gear w-5"></i> Settings
        </a>
    </nav>
</aside>