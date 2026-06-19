<x-app-layout>
    @section('page-title', 'Clients')

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold" style="color: var(--color-text-primary);">Clients</h2>
                <p class="text-sm mt-1" style="color: var(--color-text-secondary);">Manage your client relationships</p>
            </div>
            <a href="{{ route('clients.create') }}" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add New Client
            </a>
        </div>

        <!-- Search & Filters -->
        <div class="theme-card" x-data="clientSearch()">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="sm:col-span-2">
                    <input type="text" x-model="searchTerm" @input.debounce.300ms="searchClients()"
                           placeholder="Search by name, GSTIN, email..."
                           class="theme-input text-sm">
                </div>
                <select x-model="clientType" @change="applyFilters()" class="theme-input text-sm">
                    <option value="">All Types</option>
                    <option value="business">Business</option>
                    <option value="individual">Individual</option>
                    <option value="export">Export</option>
                </select>
                <select x-model="status" @change="applyFilters()" class="theme-input text-sm">
                    <option value="">All Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>

        <!-- Table -->
        <div class="theme-card p-0 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="theme-table">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th class="hidden md:table-cell">GSTIN</th>
                            <th class="hidden md:table-cell">State</th>
                            <th class="hidden lg:table-cell">Type</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clients as $client)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold text-white shrink-0" style="background-color: var(--color-primary);">
                                        {{ strtoupper(substr($client->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <a href="{{ route('clients.show', $client) }}" class="font-medium hover:underline" style="color: var(--color-text-primary);">
                                            {{ $client->name }}
                                        </a>
                                        @if($client->email)
                                            <p class="text-xs" style="color: var(--color-text-secondary);">{{ $client->email }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="hidden md:table-cell text-sm" style="color: var(--color-text-secondary);">
                                {{ $client->gstin ?? '—' }}
                            </td>
                            <td class="hidden md:table-cell text-sm" style="color: var(--color-text-secondary);">
                                {{ $client->state_name ?? $client->state ?? '—' }}
                            </td>
                            <td class="hidden lg:table-cell">
                                <span class="text-xs px-2 py-0.5 rounded-full font-medium" style="background-color: var(--color-bg); color: var(--color-text-secondary);">
                                    {{ ucfirst($client->client_type) }}
                                </span>
                            </td>
                            <td>
                                <span class="text-xs px-2 py-0.5 rounded-full font-medium {{ $client->is_active ? 'badge-accepted' : 'badge-draft' }}">
                                    {{ $client->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ url('clients', $client) }}" class="p-1.5 rounded-lg transition hover:opacity-70" style="color: var(--color-text-secondary);" title="View">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ route('clients.edit', $client) }}" class="p-1.5 rounded-lg transition hover:opacity-70" style="color: var(--color-primary);" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('clients.destroy', $client) }}" method="POST" onsubmit="return confirm('Delete this client?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg transition hover:opacity-70" style="color: #EF4444;" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-12">
                                <div class="w-14 h-14 mx-auto mb-3 rounded-full flex items-center justify-center" style="background-color: var(--color-bg);">
                                    <svg class="w-7 h-7" style="color: var(--color-text-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <p class="font-medium" style="color: var(--color-text-primary);">No clients yet</p>
                                <p class="text-sm mt-1" style="color: var(--color-text-secondary);">Get started by adding your first client.</p>
                                <a href="{{ route('clients.create') }}" class="btn-primary mt-4 inline-flex">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Add Client
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($clients->hasPages())
                <div class="px-6 py-4 border-t" style="border-color: var(--color-border);">
                    {{ $clients->links() }}
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        function clientSearch() {
            return {
                searchTerm: '',
                clientType: '',
                status: '',
                searchClients() { this.applyFilters(); },
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
</x-app-layout>