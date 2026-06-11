<?php

namespace App\Services\Invoice;

use App\Models\Invoice;
use Illuminate\Validation\ValidationException;

class InvoiceStateManager
{
    /**
     * Valid status transitions
     */
    private array $validTransitions = [
        'draft' => ['sent', 'cancelled'],
        'sent' => ['viewed', 'accepted', 'cancelled', 'overdue'],
        'viewed' => ['accepted', 'cancelled', 'overdue'],
        'accepted' => ['paid', 'partially_paid', 'cancelled', 'overdue'],
        'partially_paid' => ['paid', 'overdue'],
        'paid' => [], // Final state
        'overdue' => ['paid', 'partially_paid', 'cancelled'],
        'cancelled' => [], // Final state
    ];

    /**
     * Transition invoice to new status
     * 
     * @param Invoice $invoice
     * @param string $newStatus
     * @param array $additionalData
     * @return Invoice
     * @throws ValidationException
     */
    public function transition(Invoice $invoice, string $newStatus, array $additionalData = []): Invoice
    {
        // Validate transition
        if (!$this->canTransition($invoice->status, $newStatus)) {
            throw ValidationException::withMessages([
                'status' => "Cannot transition from '{$invoice->status}' to '{$newStatus}'"
            ]);
        }

        // Perform status-specific logic
        $data = array_merge(['status' => $newStatus], $this->getTransitionData($newStatus, $additionalData));

        $invoice->update($data);

        return $invoice->fresh();
    }

    /**
     * Check if transition is allowed
     * 
     * @param string $from
     * @param string $to
     * @return bool
     */
    public function canTransition(string $from, string $to): bool
    {
        return in_array($to, $this->validTransitions[$from] ?? []);
    }

    /**
     * Get additional data for transition
     * 
     * @param string $newStatus
     * @param array $additionalData
     * @return array
     */
    protected function getTransitionData(string $newStatus, array $additionalData): array
    {
        $data = [];

        switch ($newStatus) {
            case 'sent':
                $data['sent_at'] = now();
                break;
            case 'paid':
                $data['paid_date'] = $additionalData['paid_date'] ?? now();
                $data['balance_due'] = 0;
                $data['paid_amount'] = $data['paid_amount'] ?? $additionalData['invoice']->grand_total ?? 0;
                break;
            case 'partially_paid':
                $data['paid_date'] = $additionalData['paid_date'] ?? now();
                break;
            case 'cancelled':
                $data['cancelled_date'] = now();
                $data['balance_due'] = 0;
                break;
            case 'overdue':
                // Auto-set when date passes, or manual
                break;
        }

        return $data;
    }

    /**
     * Get allowed transitions for current status
     * 
     * @param string $currentStatus
     * @return array
     */
    public function getAllowedTransitions(string $currentStatus): array
    {
        return $this->validTransitions[$currentStatus] ?? [];
    }

    /**
     * Check if invoice is in final state
     * 
     * @param string $status
     * @return bool
     */
    public function isFinalState(string $status): bool
    {
        return in_array($status, ['paid', 'cancelled']);
    }

    /**
     * Auto-detect overdue invoices
     * 
     * @param Invoice $invoice
     * @return bool
     */
    public function shouldMarkAsOverdue(Invoice $invoice): bool
    {
        return $invoice->due_date->isPast()
            && in_array($invoice->status, ['sent', 'viewed', 'partially_paid'])
            && $invoice->balance_due > 0;
    }
}
