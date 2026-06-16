<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">Invoices</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ $totalInvoices }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">Clients</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ $totalClients }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">Products</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ $totalProducts }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">Revenue</p>
                    <p class="text-2xl font-bold text-green-600">₹{{ number_format($totalRevenue, 0) }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">Pending</p>
                    <p class="text-2xl font-bold text-yellow-600">₹{{ number_format($pendingAmount, 0) }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">Overdue</p>
                    <p class="text-2xl font-bold text-red-600">{{ $overdueCount }}</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-8">
                <div class="flex gap-3 flex-wrap">
                    <a href="{{ route('proformas.create') }}" class="bg-indigo-100 hover:bg-indigo-200 text-indigo-800 px-4 py-2 rounded-lg text-sm font-medium">+ Proforma Invoice</a>
                    <a href="{{ route('gst-invoices.create') }}" class="bg-blue-100 hover:bg-blue-200 text-blue-800 px-4 py-2 rounded-lg text-sm font-medium">+ GST Invoice</a>
                    <a href="{{ route('clients.create') }}" class="bg-green-100 hover:bg-green-200 text-green-800 px-4 py-2 rounded-lg text-sm font-medium">+ New Client</a>
                    <a href="{{ route('products.create') }}" class="bg-purple-100 hover:bg-purple-200 text-purple-800 px-4 py-2 rounded-lg text-sm font-medium">+ New Product</a>
                    <a href="{{ route('reports.outstanding') }}" class="bg-yellow-100 hover:bg-yellow-200 text-yellow-800 px-4 py-2 rounded-lg text-sm font-medium">Outstanding Report</a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <!-- Revenue Chart -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Monthly Revenue</h3>
                    <canvas id="revenueChart" height="200"></canvas>
                </div>

                <!-- Status Chart -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Invoice Status</h3>
                    <canvas id="statusChart" height="200"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Recent Invoices -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Recent Invoices</h3>
                    @forelse($recentInvoices as $invoice)
                    <div class="flex justify-between items-center border-b border-gray-100 dark:border-gray-700 py-2">
                        <div>
                            <a href="{{ route($invoice->invoice_type === 'gst_invoice' ? 'gst-invoices.show' : 'proformas.show', $invoice->id) }}" class="font-medium text-blue-600 hover:underline text-sm">
                                {{ $invoice->invoice_number }}
                            </a>
                            <p class="text-xs text-gray-500">{{ $invoice->client->name ?? 'N/A' }} · {{ $invoice->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-sm">₹{{ number_format($invoice->grand_total, 2) }}</p>
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $invoice->status === 'paid' ? 'bg-green-100 text-green-800' : ($invoice->status === 'overdue' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-500 text-sm">No invoices yet.</p>
                    @endforelse
                </div>

                <!-- Recent Clients -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Recent Clients</h3>
                    @forelse($recentClients as $client)
                    <div class="flex justify-between items-center border-b border-gray-100 dark:border-gray-700 py-2">
                        <div>
                            <p class="font-medium text-sm">{{ $client->name }}</p>
                            <p class="text-xs text-gray-500">{{ $client->gstin ?? 'No GSTIN' }} · {{ $client->state ?? 'N/A' }}</p>
                        </div>
                        <span class="text-xs px-2 py-0.5 rounded-full {{ $client->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($client->status) }}
                        </span>
                    </div>
                    @empty
                    <p class="text-gray-500 text-sm">No clients yet.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        new Chart(document.getElementById('revenueChart'), {
            type: 'bar',
            data: {
                labels: {
                    !!json_encode(array_column($monthlyRevenue, 'month')) !!
                },
                datasets: [{
                    label: 'Revenue',
                    data: {
                        !!json_encode(array_column($monthlyRevenue, 'revenue')) !!
                    },
                    backgroundColor: '#6366f1',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Draft', 'Sent', 'Paid', 'Overdue'],
                datasets: [{
                    data: [{
                        !!$statusCounts['draft'] !!
                    }, {
                        !!$statusCounts['sent'] !!
                    }, {
                        !!$statusCounts['paid'] !!
                    }, {
                        !!$statusCounts['overdue'] !!
                    }],
                    backgroundColor: ['#9ca3af', '#3b82f6', '#22c55e', '#ef4444']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</x-app-layout>