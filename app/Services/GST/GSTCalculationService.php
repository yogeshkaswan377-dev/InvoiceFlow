<?php

namespace App\Services\GST;

use App\DTOs\TaxBreakdown;

class GSTCalculationService
{
    /**
     * Calculate GST for exclusive mode (GST added to base price)
     * 
     * @param float $basePrice Price without GST
     * @param string $sellerState Seller's state code
     * @param string $buyerState Buyer's state code  
     * @param float $gstRate Total GST rate (default 18%)
     * @return TaxBreakdown
     */
    public function calculateExclusiveGST(
        float $basePrice,
        string $sellerState,
        string $buyerState,
        float $gstRate = 18.0
    ): TaxBreakdown {
        $taxType = $this->determineTaxType($sellerState, $buyerState);
        $totalGstAmount = round($basePrice * ($gstRate / 100), 2);
        $finalPrice = round($basePrice + $totalGstAmount, 2);

        $cgstAmount = 0;
        $sgstAmount = 0;
        $igstAmount = 0;
        $cgstRate = 0;
        $sgstRate = 0;
        $igstRate = 0;

        if ($taxType === 'cgst_sgst') {
            $cgstRate = $sgstRate = $gstRate / 2;
            $cgstAmount = round($totalGstAmount / 2, 2);
            $sgstAmount = round($totalGstAmount / 2, 2);
        } else {
            $igstRate = $gstRate;
            $igstAmount = $totalGstAmount;
        }

        return new TaxBreakdown(
            taxType: $taxType,
            taxableValue: $basePrice,
            cgstAmount: $cgstAmount,
            sgstAmount: $sgstAmount,
            igstAmount: $igstAmount,
            totalGstAmount: $totalGstAmount,
            cgstRate: $cgstRate,
            sgstRate: $sgstRate,
            igstRate: $igstRate,
            basePrice: $basePrice,
            finalPrice: $finalPrice,
            mode: 'exclusive'
        );
    }

    /**
     * Calculate GST for inclusive mode (GST extracted from final price)
     * Formula: Base Price = (Final Price * 100) / (100 + GST Rate)
     * 
     * @param float $inclusivePrice Final price including GST
     * @param string $sellerState Seller's state code
     * @param string $buyerState Buyer's state code
     * @param float $gstRate Total GST rate (default 18%)
     * @return TaxBreakdown
     */
    public function calculateInclusiveGST(
        float $inclusivePrice,
        string $sellerState,
        string $buyerState,
        float $gstRate = 18.0
    ): TaxBreakdown {
        $taxType = $this->determineTaxType($sellerState, $buyerState);

        // Extract base price from inclusive price
        $basePrice = round(($inclusivePrice * 100) / (100 + $gstRate), 2);
        $totalGstAmount = round($inclusivePrice - $basePrice, 2);

        $cgstAmount = 0;
        $sgstAmount = 0;
        $igstAmount = 0;
        $cgstRate = 0;
        $sgstRate = 0;
        $igstRate = 0;

        if ($taxType === 'cgst_sgst') {
            $cgstRate = $sgstRate = $gstRate / 2;
            $cgstAmount = round($totalGstAmount / 2, 2);
            $sgstAmount = round($totalGstAmount / 2, 2);

            // Adjust for rounding errors
            $cgstAmount = round($basePrice * ($cgstRate / 100), 2);
            $sgstAmount = round($basePrice * ($sgstRate / 100), 2);
        } else {
            $igstRate = $gstRate;
            $igstAmount = round($basePrice * ($igstRate / 100), 2);
        }

        return new TaxBreakdown(
            taxType: $taxType,
            taxableValue: $basePrice,
            cgstAmount: $cgstAmount,
            sgstAmount: $sgstAmount,
            igstAmount: $igstAmount,
            totalGstAmount: $totalGstAmount,
            cgstRate: $cgstRate,
            sgstRate: $sgstRate,
            igstRate: $igstRate,
            basePrice: $basePrice,
            finalPrice: $inclusivePrice,
            mode: 'inclusive'
        );
    }

    /**
     * Determine tax type based on seller and buyer states
     * 
     * @param string $sellerState
     * @param string $buyerState
     * @return string 'cgst_sgst' for intra-state, 'igst' for inter-state
     */
    public function determineTaxType(string $sellerState, string $buyerState): string
    {
        if ($sellerState === $buyerState) {
            return 'cgst_sgst';
        }

        return 'igst';
    }

    /**
     * Split total GST into CGST and SGST (equal halves)
     * 
     * @param float $totalGstAmount
     * @return array ['cgst' => float, 'sgst' => float]
     */
    public function splitGSTIntoCGSTSGST(float $totalGstAmount): array
    {
        $cgst = round($totalGstAmount / 2, 2);
        $sgst = round($totalGstAmount / 2, 2);

        return [
            'cgst' => $cgst,
            'sgst' => $sgst,
        ];
    }

    /**
     * Calculate GST for a single invoice item
     * 
     * @param float $itemPrice Unit price
     * @param int $quantity Number of items
     * @param float $discount Discount percentage (0-100)
     * @param string $mode 'exclusive' or 'inclusive'
     * @param string $sellerState Seller's state code
     * @param string $buyerState Buyer's state code
     * @param float $gstRate GST rate percentage
     * @return TaxBreakdown
     */
    public function calculateItemGST(
        float $itemPrice,
        int $quantity,
        float $discount,
        string $mode,
        string $sellerState,
        string $buyerState,
        float $gstRate = 18.0
    ): TaxBreakdown {
        // Calculate price after discount
        $discountedPrice = $itemPrice * (1 - ($discount / 100));
        $totalItemPrice = $discountedPrice * $quantity;

        // Apply GST based on mode
        if ($mode === 'exclusive') {
            return $this->calculateExclusiveGST($totalItemPrice, $sellerState, $buyerState, $gstRate);
        }

        return $this->calculateInclusiveGST($totalItemPrice, $sellerState, $buyerState, $gstRate);
    }

    /**
     * Validate GST calculation precision
     * Ensures 2 decimal places rounding consistency
     * 
     * @param float $amount
     * @return float
     */
    public function roundToPaise(float $amount): float
    {
        return round($amount, 2);
    }

    /**
     * Calculate reverse charge GST
     * Under RCM, buyer pays tax instead of seller
     * 
     * @param float $basePrice
     * @param string $sellerState
     * @param string $buyerState
     * @param float $gstRate
     * @return TaxBreakdown
     */
    public function calculateReverseChargeGST(
        float $basePrice,
        string $sellerState,
        string $buyerState,
        float $gstRate = 18.0
    ): TaxBreakdown {
        // RCM calculation is same as forward charge
        // Difference is in liability assignment (buyer pays)
        $breakdown = $this->calculateExclusiveGST($basePrice, $sellerState, $buyerState, $gstRate);

        return new TaxBreakdown(
            taxType: $breakdown->taxType,
            taxableValue: $breakdown->taxableValue,
            cgstAmount: $breakdown->cgstAmount,
            sgstAmount: $breakdown->sgstAmount,
            igstAmount: $breakdown->igstAmount,
            totalGstAmount: $breakdown->totalGstAmount,
            cgstRate: $breakdown->cgstRate,
            sgstRate: $breakdown->sgstRate,
            igstRate: $breakdown->igstRate,
            basePrice: $breakdown->basePrice,
            finalPrice: $breakdown->finalPrice,
            mode: 'exclusive'
        );
    }
}
