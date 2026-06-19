@extends('layouts.super-admin')
@section('page-title', 'Analytics')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold mb-4">Revenue Trend</h3>
            <canvas id="revenueChart" height="200"></canvas>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold mb-4">Company Growth</h3>
            <canvas id="companyChart" height="200"></canvas>
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
                !!json_encode($monthlyRevenue - > pluck('month') - > map(fn($m) => date('F', mktime(0, 0, 0, $m, 1)))) !!
            },
            datasets: [{
                label: 'Revenue',
                data: {
                    !!json_encode($monthlyRevenue - > pluck('total')) !!
                },
                borderColor: '#6366F1',
                fill: true,
                backgroundColor: 'rgba(99,102,241,0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
    new Chart(document.getElementById('companyChart'), {
        type: 'bar',
        data: {
            labels: {
                !!json_encode($companyGrowth - > pluck('month')) !!
            },
            datasets: [{
                label: 'New Companies',
                data: {
                    !!json_encode($companyGrowth - > pluck('count')) !!
                },
                backgroundColor: '#10B981',
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endpush
@endsection