<?php

namespace App\Livewire;

use Akaunting\Money\Currency;
use Akaunting\Money\Money;
use App\Models\Product\Product;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class SaleForm extends Component
{
    public int $productId;
    public Collection $products;
    public int $quantity = 0;
    public float $unitCost = 0.0;
    public float|int $sellingPrice;
    public string $currency = 'GBP';

    public function mount(): void
    {
        $this->products = Product::all();
        $this->productId = $this->products->first()->id;
    }

    public function updated($propertyName): void
    {
        // Check if either quantity or unitCost has changed
        if ($propertyName === 'productId' || $propertyName === 'quantity' || $propertyName === 'unitCost') {
            $this->calculateSellingPrice();
        }
    }

    public function calculateSellingPrice(): void
    {
        $product = $this->products->firstWhere('id', $this->productId);
        $profitMargin = $product ? $product->profit_margin : 0.25; // Default profit margin is 25%
        $shippingCost = $product ? $product->shipping_cost : 10.00; // Default shipping cost is 10.00

        $cost = $this->quantity * $this->unitCost;
        $formula = ($cost / (1 - $profitMargin)) + $shippingCost;
        $totalAmount = new Money($formula, new Currency($this->currency));
        $this->sellingPrice = round(ceil($totalAmount->getAmount()), 2);
    }

    public function recordSale(): void
    {
        try {
            // Validate the incoming inputs
            $validatedData = $this->validate([
                'productId' => 'required|exists:products,id',
                'quantity' => 'required|numeric|min:1',
                'unitCost' => 'required|numeric|min:1',
            ]);

            // Save the sale record to the database
            Sale::create([
                'product_id' => $this->productId,
                'quantity' => $this->quantity,
                'unit_cost' => $this->unitCost,
                'selling_price' => $this->sellingPrice,
            ]);

            $this->dispatch('saleRecorded');

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
