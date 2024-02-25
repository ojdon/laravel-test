<?php

namespace App\Livewire;

use App\Models\Sale;
use Livewire\Component;

class SaleTable extends Component
{
    public $sales;

    public function mount()
    {
        $this->sales = Sale::all();
    }

    public function render()
    {
        return view('livewire.sale-table');
    }
}
