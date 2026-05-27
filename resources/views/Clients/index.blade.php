{{-- resources/views/clients/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Manage Clients')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Manage Clients</h2>
                    <a href="{{ route('clients.create') }}" 
                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Add New Client
                    </a>
                </div>
                
                <!-- Search and Filters -->
                <div x-data="clientSearch()" class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="col-span-2">
                            <input type="text" 
                                   x-model="searchTerm" 
                                   @input.debounce.300ms="searchClients()"
                                   placeholder="Search by name, GSTIN, email or phone..."
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </div>
                        
                        <div>
                            <select x-model="clientType" @change="applyFilters()" 
                                    class="w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">All Types</option>
                                <option value="business">Business</option>
                                <option value="individual">Individual</option>
                            </select>
                        </div>
                        
                        <div>
                            <select x-model="status" @change="applyFilters()"
                                    class="w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">All Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Clients Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-3 px-4 text-left">Name</th>
                                <th class="py-3 px-4 text-left">GSTIN</th>
                                <th class="py-3 px-4 text-left">State</th>
                                <th class="py-3 px-4 text-left">Place of Supply</th>
                                <th class="py-3 px-4 text-left">Status</th>
                                <th class="py-3 px-4 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clients as $client)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4">
                                    <div>
                                        <div class="font-medium">{{ $client->display_name }}</div>
                                        @if($client->email)
                                            <div class="text-sm text-gray-500">{{ $client->email }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-4">{{ $client->formatted_gstin ?? '-' }}</td>
                                <td class="py-3 px-4">{{ $client->state_name ?? '-' }}</td>
                                <td class="py-3 px-4">{{ $client->place_of_supply ?? '-' }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $client->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $client->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('clients.show', $client) }}" 
                                           class="text-blue-600 hover:text-blue-900">View</a>
                                        <a href="{{ route('clients.edit', $client) }}" 
                                           class="text-green-600 hover:text-green-900">Edit</a>
                                        <form action="{{ route('clients.destroy', $client) }}" 
                                              method="POST" 
                                              class="inline-block"
                                              onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-6 text-center text-gray-500">
                                    No clients found. <a href="{{ route('clients.create') }}" class="text-blue-600">Add your first client</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="mt-4">
                    {{ $clients->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function clientSearch() {
    return {
        searchTerm: '',
        clientType: '',
        status: '',
        searchClients() {
            this.applyFilters();
        },
        applyFilters() {
            let url = new URL(window.location.href);
            if (this.searchTerm) url.searchParams.set('search', this.searchTerm);
            else url.searchParams.delete('search');
            
            if (this.clientType) url.searchParams.set('client_type', this.clientType);
            else url.searchParams.delete('client_type');
            
            if (this.status !== '') url.searchParams.set('is_active', this.status);
            else url.searchParams.delete('is_active');
            
            window.location.href = url.toString();
        }
    }
}
</script>
@endpush
@endsection