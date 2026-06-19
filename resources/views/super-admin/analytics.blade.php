<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Platform Analytics</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Stats -->
            <div class="grid grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-sm text-gray-500">Total Revenue</p>
                    <p class="text-3xl font-bold text-green-600">₹{{ number_format($totalRevenue, 0) }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-sm text-gray-500">Companies by Plan</p>
                    <div class="mt-2 space-y-1">
                        @foreach($companiesByPlan as $plan)
                        <div class="flex justify-between text-sm">
                            <span class="capitalize">{{ $plan->subscription_plan }}</span>
                            <span class="font-bold">{{ $plan->count }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-sm text-gray-500">Current Month</p>
                    <p class="text-3xl font-bold">{{ now()->format('F Y') }}</p>
                </div>
            </div>

            <!-- Revenue Chart -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Monthly Revenue</h3>
                <canvas id="revenueChart" height="200"></canvas>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        new Chart(document.getElementById('revenueChart'), {
            type: 'line',
            data: {
                labels: {
                    !!json_encode($monthlyRevenue - > pluck('month') - > map(function($m) {
                        return date('F', mktime(0, 0, 0, $m, 1));
                    })) !!
                },
                datasets: [{
                    label: 'Revenue (₹)',
                    data: {
                        !!json_encode($monthlyRevenue - > pluck('total')) !!
                    },
                    borderColor: '#6366F1',
                    backgroundColor: 'rgba(99,102,241,0.1)',
                    fill: true,
                    tension: 0.4
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
    </script>
    @endpush
</x-app-layout>