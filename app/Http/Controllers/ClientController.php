<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $clients = Client::where('company_id', Auth::user()->company_id)->get();
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_type' => 'required|in:individual,business,export',
            'name' => 'required|string|max:255',
            'company_name' => 'required_if:client_type,business|nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'gstin' => 'nullable|string|max:15|unique:clients,gstin',
            'state_code' => 'required|string|size:2',
            'state_name' => 'required|string|max:100',
            'address_line_1' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'pincode' => 'required|string|max:10',
            'country' => 'required|string|max:100',
            'credit_limit' => 'nullable|numeric|min:0',
            'is_active' => 'boolean'
        ]);

        // Calculate place of supply
        $companyState = Auth::user()->company->state_code;
        $validated['place_of_supply'] = ($validated['state_code'] === $companyState) 
            ? 'Intra-State Supply' 
            : 'Inter-State Supply';
        
        // Add state and status fields
        $validated['state'] = $validated['state_name'];
        $validated['status'] = $validated['is_active'] ? 'active' : 'inactive';
        $validated['company_id'] = Auth::user()->company_id;

        Client::create($validated);

        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
    }

    public function update(Request $request, Client $client)
    {
        $this->authorize('update', $client);

        $validated = $request->validate([
            'client_type' => 'required|in:individual,business,export',
            'name' => 'required|string|max:255',
            'company_name' => 'required_if:client_type,business|nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'gstin' => 'nullable|string|max:15|unique:clients,gstin,' . $client->id,
            'state_code' => 'required|string|size:2',
            'state_name' => 'required|string|max:100',
            'address_line_1' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'pincode' => 'required|string|max:10',
            'country' => 'required|string|max:100',
            'credit_limit' => 'nullable|numeric|min:0',
            'is_active' => 'boolean'
        ]);

        // Recalculate place of supply
        $companyState = Auth::user()->company->state_code;
        $validated['place_of_supply'] = ($validated['state_code'] === $companyState) 
            ? 'Intra-State Supply' 
            : 'Inter-State Supply';
        
        $validated['state'] = $validated['state_name'];
        $validated['status'] = $validated['is_active'] ? 'active' : 'inactive';

        $client->update($validated);

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client)
    {
        $this->authorize('delete', $client);
        $client->delete();
        
        return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $clients = Client::where('company_id', Auth::user()->company_id)
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('company_name', 'LIKE', "%{$query}%")
                  ->orWhere('gstin', 'LIKE', "%{$query}%")
                  ->orWhere('email', 'LIKE', "%{$query}%");
            })
            ->get();

        if ($request->ajax()) {
            return response()->json($clients);
        }

        return view('clients.index', compact('clients'));
    }

    public function filterByState(Request $request)
    {
        $state = $request->get('state');
        $clients = Client::where('company_id', Auth::user()->company_id)
            ->where('state_name', $state)
            ->get();

        return view('clients.index', compact('clients'));
    }

    public function filterByStatus(Request $request)
    {
        $status = $request->get('status');
        $clients = Client::where('company_id', Auth::user()->company_id)
            ->where('status', $status)
            ->get();

        return view('clients.index', compact('clients'));
    }
}