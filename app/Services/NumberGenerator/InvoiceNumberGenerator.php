<?php

namespace App\Services\NumberGenerator;

use App\Models\InvoiceSequence;
use Illuminate\Support\Facades\DB;

class InvoiceNumberGenerator
{
    /**
     * Generate unique invoice number
     * Format: PREFIX-YYYY-XXXXX
     * 
     * @param int $companyId
     * @return string
     */
    public function generateInvoiceNumber(int $companyId): string
    {
        return $this->generateNumber($companyId, 'invoice', 'INV');
    }

    /**
     * Generate unique proforma invoice number
     * Format: PF-YYYY-XXXXX
     * 
     * @param int $companyId
     * @return string
     */
    public function generateProformaNumber(int $companyId): string
    {
        return $this->generateNumber($companyId, 'proforma', 'PF');
    }

    /**
     * Generate unique quote number
     * Format: Q-YYYY-XXXXX
     * 
     * @param int $companyId
     * @return string
     */
    public function generateQuoteNumber(int $companyId): string
    {
        return $this->generateNumber($companyId, 'quote', 'Q');
    }

    /**
     * Core number generation with transaction safety
     * 
     * @param int $companyId
     * @param string $type
     * @param string $prefix
     * @return string
     */
    protected function generateNumber(int $companyId, string $type, string $prefix): string
    {
        return DB::transaction(function () use ($companyId, $type, $prefix) {
            $year = date('Y');

            // Get or create sequence record with lock
            $sequence = InvoiceSequence::where([
                'company_id' => $companyId,
                'type' => $type,
                'year' => $year,
            ])->lockForUpdate()->first();

            if (!$sequence) {
                $sequence = InvoiceSequence::create([
                    'company_id' => $companyId,
                    'type' => $type,
                    'prefix' => $prefix,
                    'year' => $year,
                    'last_sequence' => 0,
                ]);
            }

            // Increment sequence
            $sequence->increment('last_sequence');

            // Format: PREFIX-YYYY-XXXXX (5-digit padded sequence)
            return sprintf('%s-%s-%05d', $prefix, $year, $sequence->last_sequence);
        });
    }

    /**
     * Get next number without incrementing (preview only)
     * 
     * @param int $companyId
     * @param string $type
     * @return string
     */
    public function previewNumber(int $companyId, string $type): string
    {
        $sequence = InvoiceSequence::where([
            'company_id' => $companyId,
            'type' => $type,
            'year' => date('Y'),
        ])->first();

        $nextSequence = $sequence ? $sequence->last_sequence + 1 : 1;
        $prefix = $this->getPrefixForType($type);

        return sprintf('%s-%s-%05d', $prefix, date('Y'), $nextSequence);
    }

    /**
     * Get prefix for invoice type
     * 
     * @param string $type
     * @return string
     */
    protected function getPrefixForType(string $type): string
    {
        return match ($type) {
            'invoice' => 'INV',
            'proforma' => 'PF',
            'quote' => 'Q',
            default => 'INV',
        };
    }
}
