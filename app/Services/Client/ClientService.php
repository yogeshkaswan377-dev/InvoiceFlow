<?php
// app/Services/Client/ClientService.php

namespace App\Services\Client;

use App\DTOs\ClientData;
use App\Repositories\Contracts\ClientRepositoryInterface;
use App\Services\GST\GSTValidationService;
use App\Services\GST\PlaceOfSupplyService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ClientService
{
    public function __construct(
        protected ClientRepositoryInterface $clientRepository,
        protected GSTValidationService $gstValidationService,
        protected PlaceOfSupplyService $placeOfSupplyService
    ) {}
    
    public function getAllClients(int $companyId, array $filters = [])
    {
        return $this->clientRepository->getFiltered($companyId, $filters);
    }
    
    public function getClient(int $id, int $companyId)
    {
        $client = $this->clientRepository->findById($id, $companyId);
        
        if (!$client) {
            throw ValidationException::withMessages(['error' => 'Client not found']);
        }
        
        return $client;
    }
    
    public function createClient(ClientData $clientData)
    {
        return DB::transaction(function () use ($clientData) {
            // Validate GSTIN if provided
            if ($clientData->gstin) {
                $this->validateGSTINForClient($clientData->gstin, $clientData->company_id);
                
                // Auto-extract state from GSTIN if not provided
                if (!$clientData->state_code && $stateInfo = $this->gstValidationService->extractStateFromGSTIN($clientData->gstin)) {
                    $clientData = new ClientData(
                        company_id: $clientData->company_id,
                        client_type: $clientData->client_type,
                        name: $clientData->name,
                        company_name: $clientData->company_name,
                        email: $clientData->email,
                        phone: $clientData->phone,
                        gstin: $clientData->gstin,
                        pan: $clientData->pan,
                        state_code: $stateInfo['code'],
                        state_name: $stateInfo['name'],
                        address_line_1: $clientData->address_line_1,
                        address_line_2: $clientData->address_line_2,
                        city: $clientData->city,
                        pincode: $clientData->pincode,
                        country: $clientData->country,
                        place_of_supply: $clientData->place_of_supply,
                        credit_limit: $clientData->credit_limit,
                        payment_terms: $clientData->payment_terms,
                        notes: $clientData->notes,
                        is_active: $clientData->is_active,
                    );
                }
            }
            
            // Auto-calculate place of supply
            if ($clientData->state_code) {
                $supplyInfo = $this->placeOfSupplyService->determine(
                    companyStateCode: auth()->user()->company->state_code ?? '',
                    clientStateCode: $clientData->state_code,
                    clientCountry: $clientData->country
                );
                
                $clientData = new ClientData(
                    company_id: $clientData->company_id,
                    client_type: $clientData->client_type,
                    name: $clientData->name,
                    company_name: $clientData->company_name,
                    email: $clientData->email,
                    phone: $clientData->phone,
                    gstin: $clientData->gstin,
                    pan: $clientData->pan,
                    state_code: $clientData->state_code,
                    state_name: $clientData->state_name,
                    address_line_1: $clientData->address_line_1,
                    address_line_2: $clientData->address_line_2,
                    city: $clientData->city,
                    pincode: $clientData->pincode,
                    country: $clientData->country,
                    place_of_supply: $supplyInfo['description'],
                    credit_limit: $clientData->credit_limit,
                    payment_terms: $clientData->payment_terms,
                    notes: $clientData->notes,
                    is_active: $clientData->is_active,
                );
            }
            
            return $this->clientRepository->create($clientData->toArray());
        });
    }
    
    public function updateClient(int $id, int $companyId, ClientData $clientData)
    {
        return DB::transaction(function () use ($id, $companyId, $clientData) {
            $existingClient = $this->clientRepository->findById($id, $companyId);
            
            if (!$existingClient) {
                throw ValidationException::withMessages(['error' => 'Client not found']);
            }
            
            // Validate GSTIN if provided and changed
            if ($clientData->gstin && $clientData->gstin !== $existingClient->gstin) {
                $this->validateGSTINForClient($clientData->gstin, $companyId, $id);
            }
            
            // Auto-calculate place of supply
            if ($clientData->state_code) {
                $company = auth()->user()->company;
                $supplyInfo = $this->placeOfSupplyService->determine(
                    companyStateCode: $company->state_code ?? '',
                    clientStateCode: $clientData->state_code,
                    clientCountry: $clientData->country
                );
                
                $clientData = new ClientData(
                    company_id: $clientData->company_id,
                    client_type: $clientData->client_type,
                    name: $clientData->name,
                    company_name: $clientData->company_name,
                    email: $clientData->email,
                    phone: $clientData->phone,
                    gstin: $clientData->gstin,
                    pan: $clientData->pan,
                    state_code: $clientData->state_code,
                    state_name: $clientData->state_name,
                    address_line_1: $clientData->address_line_1,
                    address_line_2: $clientData->address_line_2,
                    city: $clientData->city,
                    pincode: $clientData->pincode,
                    country: $clientData->country,
                    place_of_supply: $supplyInfo['description'],
                    credit_limit: $clientData->credit_limit,
                    payment_terms: $clientData->payment_terms,
                    notes: $clientData->notes,
                    is_active: $clientData->is_active,
                );
            }
            
            return $this->clientRepository->update($id, $clientData->toArray());
        });
    }
    
    public function deleteClient(int $id, int $companyId): bool
    {
        $client = $this->clientRepository->findById($id, $companyId);
        
        if (!$client) {
            throw ValidationException::withMessages(['error' => 'Client not found']);
        }
        
        // Check if client has any invoices (Phase 3)
        // For now, just delete
        
        return $this->clientRepository->delete($id);
    }
    
    public function searchClients(int $companyId, string $term)
    {
        return $this->clientRepository->search($companyId, $term);
    }
    
    protected function validateGSTINForClient(string $gstin, int $companyId, ?int $excludeId = null): void
    {
        // Validate GSTIN format
        if (!$this->gstValidationService->validateGSTIN($gstin)) {
            throw ValidationException::withMessages([
                'gstin' => 'Invalid GSTIN format. Must be 15 characters with valid structure.'
            ]);
        }
        
        // Check uniqueness within company
        $existingClient = $this->clientRepository->findByGSTIN($companyId, $gstin);
        
        if ($existingClient && $existingClient->id !== $excludeId) {
            throw ValidationException::withMessages([
                'gstin' => 'A client with this GSTIN already exists for your company.'
            ]);
        }
    }
}