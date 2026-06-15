<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <p class="text-sm text-gray-500">Total Invoices</p>
                    <p class="text-2xl font-bold">{{ $totalInvoices }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <p class="text-sm text-gray-500">Total Clients</p>
                    <p class="text-2xl font-bold">{{ $totalClients }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <p class="text-sm text-gray-500">Revenue (Paid)</p>
                    <p class="text-2xl font-bold text-green-600">₹{{ number_format($totalRevenue, 0) }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <p class="text-sm text-gray-500">Pending Amount</p>
                    <p class="text-2xl font-bold text-yellow-600">₹{{ number_format($pendingAmount, 0) }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <p class="text-sm text-gray-500">Overdue</p>
                    <p class="text-2xl font-bold text-red-600">{{ $overdueCount }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <!-- Monthly Revenue Chart -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Monthly Revenue (Last 6 Months)</h3>
                    <canvas id="revenueChart" height="200"></canvas>
                </div>

                <!-- Invoice Status Chart -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Invoices by Status</h3>
                    <canvas id="statusChart" height="200"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Recent Invoices -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Recent Invoices</h3>
                    @if($recentInvoices->count() > 0)
                        <div class="space-y-3">
                            @foreach($recentInvoices as $invoice)
                                <div class="flex justify-between items-center border-b pb-2">
                                    <div>
                                        <p class="font-medium">{{ $invoice->invoice_number }}</p>
                                        <p class="text-sm text-gray-500">{{ $invoice->client->name ?? 'N/A' }} · {{ $invoice->created_at->format('d M') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium">₹{{ number_format($invoice->grand_total, 2) }}</p>
                                        <span class="text-xs px-2 py-1 rounded-full 
                                            {{ $invoice->status === 'paid' ? 'bg-green-100 text-green-800' : 
                                               ($invoice->status === 'overdue' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($invoice->status) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No invoices yet.</p>
                    @endif
                </div>

                <!-- Quick Links -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('proformas.create') }}" class="bg-indigo-100 hover:bg-indigo-200 text-indigo-800 p-4 rounded-lg text-center">
                            + Proforma Invoice
                        </a>
                        <a href="{{ route('gst-invoices.create') }}" class="bg-blue-100 hover:bg-blue-200 text-blue-800 p-4 rounded-lg text-center">
                            + GST Invoice
                        </a>
                        <a href="{{ route('clients.create') }}" class="bg-green-100 hover:bg-green-200 text-green-800 p-4 rounded-lg text-center">
                            + New Client
                        </a>
                        <a href="{{ route('products.create') }}" class="bg-purple-100 hover:bg-purple-200 text-purple-800 p-4 rounded-lg text-center">
                            + New Product
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Revenue Chart
        new Chart(document.getElementById('revenueChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_column($monthlyRevenue, 'month')) !!},
                datasets: [{
                    label: 'Revenue (₹)',
                    data: {!! json_encode(array_column($monthlyRevenue, 'revenue')) !!},
                    backgroundColor: '#6366f1',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });

        // Status Chart
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Draft', 'Sent', 'Paid', 'Overdue'],
                datasets: [{
                    data: [{!! $statusCounts['draft'] !!}, {!! $statusCounts['sent'] !!}, {!! $statusCounts['paid'] !!}, {!! $statusCounts['overdue'] !!}],
                    backgroundColor: ['#9ca3af', '#3b82f6', '#22c55e', '#ef4444'],
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    </script>
</x-app-layout>