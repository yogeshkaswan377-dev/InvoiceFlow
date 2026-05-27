<?php
// app/Services/GST/PlaceOfSupplyService.php

namespace App\Services\GST;

class PlaceOfSupplyService
{
    public function determine(string $companyStateCode, ?string $clientStateCode, string $clientCountry = 'India'): array
    {
        // Export case
        if ($clientCountry !== 'India' || !$clientStateCode) {
            return [
                'type' => 'export',
                'tax_type' => 'IGST',
                'state_code' => $clientStateCode,
                'state_name' => $clientCountry,
                'description' => 'Export/SEZ Supply',
            ];
        }
        
        // Intra-state supply (same state)
        if ($companyStateCode === $clientStateCode) {
            $stateName = $this->getStateName($clientStateCode);
            return [
                'type' => 'intra',
                'tax_type' => 'CGST+SGST',
                'state_code' => $clientStateCode,
                'state_name' => $stateName,
                'description' => 'Intra-State Supply',
            ];
        }
        
        // Inter-state supply (different states)
        $stateName = $this->getStateName($clientStateCode);
        return [
            'type' => 'inter',
            'tax_type' => 'IGST',
            'state_code' => $clientStateCode,
            'state_name' => $stateName,
            'description' => 'Inter-State Supply',
        ];
    }
    
    protected function getStateName(string $stateCode): ?string
    {
        $states = config('indian_states.states', []);
        return $states[$stateCode] ?? null;
    }
    
    public function calculateTaxComponents(string $supplyType, float $rate, float $amount): array
    {
        $taxableValue = $amount;
        $taxAmount = ($amount * $rate) / 100;
        
        if ($supplyType === 'intra') {
            $cgst = $taxAmount / 2;
            $sgst = $taxAmount / 2;
            $igst = 0;
            
            return [
                'taxable_value' => $taxableValue,
                'cgst_rate' => $rate / 2,
                'sgst_rate' => $rate / 2,
                'igst_rate' => 0,
                'cgst_amount' => $cgst,
                'sgst_amount' => $sgst,
                'igst_amount' => 0,
                'total_tax' => $taxAmount,
            ];
        } else {
            $cgst = 0;
            $sgst = 0;
            $igst = $taxAmount;
            
            return [
                'taxable_value' => $taxableValue,
                'cgst_rate' => 0,
                'sgst_rate' => 0,
                'igst_rate' => $rate,
                'cgst_amount' => 0,
                'sgst_amount' => 0,
                'igst_amount' => $igst,
                'total_tax' => $taxAmount,
            ];
        }
    }
}