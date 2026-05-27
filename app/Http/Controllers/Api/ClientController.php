<?php
// app/Http/Controllers/Api/ClientController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Services\Client\ClientService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct(
        protected ClientService $clientService
    ) {}
    
    public function index(Request $request)
    {
        $clients = $this->clientService->getAllClients(
            auth()->user()->company_id,
            $request->only(['search', 'client_type', 'is_active'])
        );
        
        return response()->json([
            'success' => true,
            'data' => $clients,
        ]);
    }
    
    public function show(Client $client)
    {
        $this->authorize('view', $client);
        
        return response()->json([
            'success' => true,
            'data' => $client,
        ]);
    }
}