<?php

namespace App\Livewire;

use Akaunting\Money\Currency;
use Akaunting\Money\Money;
use App\Models\Sale;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class SaleForm extends Component
{
    public int $quantity = 0;
    public float $unitCost = 0.0;
    public float|int $sellingPrice;
    public string $currency = 'GBP';

    public function updated($propertyName): void
    {
        // Check if either quantity or unitCost has changed
        if ($propertyName === 'quantity' || $propertyName === 'unitCost') {
            $this->calculateSellingPrice();
        }
    }

    public function calculateSellingPrice($profitMargin = 0.25, $shippingCost = 10): void
    {
        $cost = $this->quantity * $this->unitCost;
        $formula = ($cost / ( 1 - $profitMargin)) + ($shippingCost);
        $totalAmount = new Money($formula, new Currency($this->currency));
        $totalAmount = round(ceil($totalAmount->getAmount()), 2);
        $this->sellingPrice = $totalAmount;
    }

    public function recordSale()
    {
        try {
            // Validate the incoming inputs
            $validatedData = $this->validate([
                'quantity' => 'required|numeric|min:1',
                'unitCost' => 'required|numeric|min:1',
            ]);

            // If validation passes, proceed to save the sale record
            $quantity = $validatedData['quantity'];
            $unitCost = $validatedData['unitCost'];
            $sellingPrice = $this->sellingPrice;

            // Save the sale record to the database
            Sale::create([
                'quantity' => $quantity,
                'unit_cost' => $unitCost,
                'selling_price' => $sellingPrice,
            ]);

            $this->reset(['quantity', 'unitCost']);
            $this->sellingPrice = 0.00;

        } catch (ValidationException $e) {
            $this->addError('validationError', $e->getMessage());
        }

    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.sale-form');
    }
}
