{{-- resources/views/clients/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Client Details - ' . $client->display_name)

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Client Details</h2>
                    <div class="space-x-2">
                        <a href="{{ route('clients.edit', $client) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Edit Client
                        </a>
                        <a href="{{ route('clients.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to List
                        </a>
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="mb-6">
                    <span class="px-3 py-1 text-sm rounded-full {{ $client->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $client->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <div class="border rounded-lg p-4">
                        <h3 class="text-lg font-semibold mb-4 text-blue-600">Basic Information</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm text-gray-500">Client Type</label>
                                <p class="font-medium">{{ ucfirst($client->client_type) }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Contact Person</label>
                                <p class="font-medium">{{ $client->name }}</p>
                            </div>
                            @if($client->company_name)
                            <div>
                                <label class="text-sm text-gray-500">Company Name</label>
                                <p class="font-medium">{{ $client->company_name }}</p>
                            </div>
                            @endif
                            @if($client->email)
                            <div>
                                <label class="text-sm text-gray-500">Email</label>
                                <p class="font-medium">{{ $client->email }}</p>
                            </div>
                            @endif
                            @if($client->phone)
                            <div>
                                <label class="text-sm text-gray-500">Phone</label>
                                <p class="font-medium">{{ $client->phone }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- GST Information -->
                    <div class="border rounded-lg p-4">
                        <h3 class="text-lg font-semibold mb-4 text-blue-600">GST Information</h3>
                        <div class="space-y-3">
                            @if($client->gstin)
                            <div>
                                <label class="text-sm text-gray-500">GSTIN</label>
                                <p class="font-mono font-medium">{{ $client->formatted_gstin }}</p>
                            </div>
                            @endif
                            @if($client->pan)
                            <div>
                                <label class="text-sm text-gray-500">PAN</label>
                                <p class="font-mono font-medium">{{ $client->pan }}</p>
                            </div>
                            @endif
                            @if($client->state_name)
                            <div>
                                <label class="text-sm text-gray-500">State</label>
                                <p class="font-medium">{{ $client->state_name }} ({{ $client->state_code }})</p>
                            </div>
                            @endif
                            @if($client->place_of_supply)
                            <div>
                                <label class="text-sm text-gray-500">Place of Supply</label>
                                <p class="font-medium">{{ $client->place_of_supply }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Address Details -->
                    <div class="border rounded-lg p-4">
                        <h3 class="text-lg font-semibold mb-4 text-blue-600">Address Details</h3>
                        <div class="space-y-2">
                            @if($client->address_line_1)
                            <p>{{ $client->address_line_1 }}</p>
                            @endif
                            @if($client->address_line_2)
                            <p>{{ $client->address_line_2 }}</p>
                            @endif
                            <p>
                                {{ $client->city ? $client->city . ', ' : '' }}
                                {{ $client->state_name ? $client->state_name . ' - ' : '' }}
                                {{ $client->pincode ? $client->pincode : '' }}
                            </p>
                            <p>{{ $client->country }}</p>
                        </div>
                    </div>

                    <!-- Business Settings -->
                    <div class="border rounded-lg p-4">
                        <h3 class="text-lg font-semibold mb-4 text-blue-600">Business Settings</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm text-gray-500">Credit Limit</label>
                                <p class="font-medium">₹ {{ number_format($client->credit_limit, 2) }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Payment Terms</label>
                                <p class="font-medium">{{ $client->payment_terms ? $client->payment_terms . ' days' : 'Default (Company Setting)' }}</p>
                            </div>
                            @if($client->notes)
                            <div>
                                <label class="text-sm text-gray-500">Notes</label>
                                <p class="text-gray-700">{{ $client->notes }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Metadata -->
                <div class="mt-6 text-sm text-gray-500 border-t pt-4">
                    <p>Created: {{ $client->created_at->format('d M Y, h:i A') }}</p>
                    <p>Last Updated: {{ $client->updated_at->format('d M Y, h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection