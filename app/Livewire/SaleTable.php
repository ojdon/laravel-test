<?php

namespace App\Livewire;

use App\Models\Sale;
use Livewire\Attributes\On;
use Livewire\Component;

class SaleTable extends Component
{
    public $sales;

    public function mount()
    {
        $this->loadSalesData();
    }

    #[On('saleRecorded')]
    public function loadSalesData()
    {
        $this->sales = Sale::all()->sortByDesc('created_at');
    }

    public function render()
    {
        return view('livewire.sale-table', [
                'sales' => $this->sales,
            ]
        );
    }
}
