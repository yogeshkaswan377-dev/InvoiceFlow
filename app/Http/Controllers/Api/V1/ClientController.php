<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    /**
     * List all clients for current company.
     */
    public function index(Request $request): JsonResponse
    {
        $clients = Client::where('company_id', session('current_company_id'))
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('company_name', 'LIKE', "%{$search}%")
                        ->orWhere('gstin', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                });
            })
            ->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'data' => ClientResource::collection($clients->items()),
            'meta' => [
                'current_page' => $clients->currentPage(),
                'last_page' => $clients->lastPage(),
                'per_page' => $clients->perPage(),
                'total' => $clients->total(),
                'from' => $clients->firstItem(),
                'to' => $clients->lastItem(),
            ],
            'links' => [
                'first' => $clients->url(1),
                'last' => $clients->url($clients->lastPage()),
                'prev' => $clients->previousPageUrl(),
                'next' => $clients->nextPageUrl(),
            ],
        ]);
    }

    /**
     * Store a new client.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'client_type' => 'required|in:individual,business,export',
            'name' => 'required|string|max:255',
            'company_name' => 'required_if:client_type,business|nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'gstin' => [
                'required_if:client_type,business',
                'nullable',
                'string',
                'size:15',
                'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/',
                'unique:clients,gstin',
            ],
            'state_code' => 'required|string|size:2',
            'state_name' => 'required|string|max:100',
            'address_line_1' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'pincode' => 'required|string|max:10',
            'country' => 'required|string|max:100',
            'credit_limit' => 'nullable|numeric|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        // Calculate place of supply (same logic as web controller)
        $user = Auth::user();
        $companyState = $user->company->state_code;
        $validated['place_of_supply'] = ($validated['state_code'] === $companyState)
            ? 'intra_state'
            : 'inter_state';

        $validated['state'] = $validated['state_name'];
        $validated['status'] = !empty($validated['is_active']) ? 'active' : 'inactive';
        $validated['company_id'] = session('current_company_id');

        $client = Client::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Client created successfully.',
            'data' => new ClientResource($client),
        ], 201);
    }

    /**
     * Show a single client.
     */
    public function show(Client $client): JsonResponse
    {
        $this->authorize('view', $client);

        return response()->json([
            'success' => true,
            'data' => new ClientResource($client),
        ]);
    }

    /**
     * Update a client.
     */
    public function update(Request $request, Client $client): JsonResponse
    {
        $this->authorize('update', $client);

        $validated = $request->validate([
            'client_type' => 'required|in:individual,business,export',
            'name' => 'required|string|max:255',
            'company_name' => 'required_if:client_type,business|nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'gstin' => [
                'required_if:client_type,business',
                'nullable',
                'string',
                'size:15',
                'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/',
                'unique:clients,gstin,' . $client->id,
            ],
            'state_code' => 'required|string|size:2',
            'state_name' => 'required|string|max:100',
            'address_line_1' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'pincode' => 'required|string|max:10',
            'country' => 'required|string|max:100',
            'credit_limit' => 'nullable|numeric|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        // Recalculate place of supply
        $user = Auth::user();
        $companyState = $user->company->state_code;
        $validated['place_of_supply'] = ($validated['state_code'] === $companyState)
            ? 'intra_state'
            : 'inter_state';

        $validated['state'] = $validated['state_name'];
        $validated['status'] = !empty($validated['is_active']) ? 'active' : 'inactive';

        $client->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Client updated successfully.',
            'data' => new ClientResource($client->fresh()),
        ]);
    }

    /**
     * Delete a client.
     */
    public function destroy(Client $client): JsonResponse
    {
        //$this->authorize('delete', $client);

        Log::warning('Client deleted via API', [
            'user_id' => Auth::id(),
            'client_name' => $client->name,
            'company_id' => $client->company_id,
        ]);

        $client->delete();

        return response()->json([
            'success' => true,
            'message' => 'Client deleted successfully.',
        ]);
    }

    /**
     * Search clients (AJAX).
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q');

        $clients = Client::where('company_id', session('current_company_id'))
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                    ->orWhere('company_name', 'LIKE', "%{$query}%")
                    ->orWhere('gstin', 'LIKE', "%{$query}%")
                    ->orWhere('email', 'LIKE', "%{$query}%");
            })
            ->limit(20)
            ->get();

        return response()->json([
            'success' => true,
            'data' => ClientResource::collection($clients),
        ]);
    }

    /**
     * Filter clients by state.
     */
    public function filterByState(Request $request): JsonResponse
    {
        $state = $request->get('state');

        $clients = Client::where('company_id', session('current_company_id'))
            ->where('state_name', $state)
            ->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'data' => ClientResource::collection($clients->items()),
            'meta' => [
                'current_page' => $clients->currentPage(),
                'last_page' => $clients->lastPage(),
                'per_page' => $clients->perPage(),
                'total' => $clients->total(),
            ],
        ]);
    }

    /**
     * Filter clients by status.
     */
    public function filterByStatus(Request $request): JsonResponse
    {
        $status = $request->get('status');

        $clients = Client::where('company_id', session('current_company_id'))
            ->where('status', $status)
            ->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'data' => ClientResource::collection($clients->items()),
            'meta' => [
                'current_page' => $clients->currentPage(),
                'last_page' => $clients->lastPage(),
                'per_page' => $clients->perPage(),
                'total' => $clients->total(),
            ],
        ]);
    }
}
