<aside class="fixed left-0 top-0 h-full w-64 bg-gray-900 text-white z-30 flex flex-col">
    <div class="flex items-center h-16 px-4 border-b border-gray-700">
        <span class="text-lg font-bold">👑 GST SaaS</span>
    </div>
    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
        @php
        $links = [
        ['url' => '/super-admin/dashboard', 'label' => 'Dashboard', 'icon' => '📊'],
        ['url' => '/super-admin/companies', 'label' => 'Companies', 'icon' => '🏢'],
        ['url' => '/super-admin/users', 'label' => 'Users', 'icon' => '👥'],
        ['url' => '/super-admin/invoices', 'label' => 'Invoices', 'icon' => '📄'],
        ['url' => '/super-admin/proformas', 'label' => 'Proformas', 'icon' => '📑'],
        ['url' => '/super-admin/analytics', 'label' => 'Analytics', 'icon' => '📈'],
        ['url' => '/super-admin/subscriptions', 'label' => 'Subscriptions', 'icon' => '📦'],
        ['url' => '/super-admin/logs', 'label' => 'Logs', 'icon' => '📝'],
        ['url' => '/super-admin/audit', 'label' => 'Audit Trail', 'icon' => '🔍'],
        ['url' => '/super-admin/settings', 'label' => 'Settings', 'icon' => '⚙️'],
        ];
        @endphp

        @foreach($links as $link)
        <a href="{{ $link['url'] }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition
                      {{ request()->is(trim($link['url'], '/').'*') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <span>{{ $link['icon'] }}</span>
            <span>{{ $link['label'] }}</span>
        </a>
        @endforeach
    </nav>
</aside>