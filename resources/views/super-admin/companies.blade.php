<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Manage Companies</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-3 px-4 text-left">Company</th>
                                <th class="py-3 px-4 text-left">GSTIN</th>
                                <th class="py-3 px-4 text-left">Plan</th>
                                <th class="py-3 px-4 text-left">Users</th>
                                <th class="py-3 px-4 text-left">Invoices</th>
                                <th class="py-3 px-4 text-left">Status</th>
                                <th class="py-3 px-4 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($companies as $company)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4">
                                    <div class="font-medium">{{ $company->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $company->email }}</div>
                                </td>
                                <td class="py-3 px-4 text-sm">{{ $company->gstin ?? '—' }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                        {{ ucfirst($company->subscription_plan) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-sm">{{ $company->users_count }}</td>
                                <td class="py-3 px-4 text-sm">{{ $company->invoices_count ?? 0 }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $company->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $company->is_active ? 'Active' : 'Suspended' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex space-x-2">
                                        @if($company->is_active)
                                        <form action="{{ route('super-admin.companies.suspend', $company) }}" method="POST">
                                            @csrf
                                            <button class="text-red-600 hover:text-red-900 text-sm font-medium">Suspend</button>
                                        </form>
                                        @else
                                        <form action="{{ route('super-admin.companies.approve', $company) }}" method="POST">
                                            @csrf
                                            <button class="text-green-600 hover:text-green-900 text-sm font-medium">Approve</button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="py-6 text-center text-gray-500">No companies found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $companies->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>