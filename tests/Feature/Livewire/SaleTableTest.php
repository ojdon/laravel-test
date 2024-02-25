<?php

namespace Tests\Feature\Livewire;

use App\Livewire\SaleTable;
use App\Models\Sale;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SaleTableTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_renders_correctly_with_sales_data()
    {
        Sale::factory()->create([
            'quantity' => 10,
            'unit_cost' => 5,
            'selling_price' => 10,
        ]);
        Sale::factory()->create([
            'quantity' => 15,
            'unit_cost' => 6,
            'selling_price' => 12,
        ]);

        // Mount the Livewire component
        Livewire::test(SaleTable::class)
            ->assertSee('10') // Ensure quantity is displayed
            ->assertSee('£5') // Ensure unit cost is displayed
            ->assertSee('£10') // Ensure selling price is displayed
            ->assertSee('15') // Ensure another quantity is displayed
            ->assertSee('£6') // Ensure another unit cost is displayed
            ->assertSee('£12'); // Ensure another selling price is displayed
    }

    /** @test */
    public function it_displays_message_when_no_sales_recorded()
    {
        // Mount the Livewire component without any sales data
        Livewire::test(SaleTable::class)
            ->assertSee('No sales recorded. Please enter using the form above to record a sale.');
    }

    /** @test */
    public function sales_table_is_updated_when_event_is_dispatched()
    {
        Livewire::test(SaleTable::class)
            ->call('loadSalesData')
            ->assertSet('sales', Sale::all());

        $this->assertCount(0, Sale::all());

        // Add a new sale record
        Sale::factory()->create([
            'quantity' => 10,
            'unit_cost' => 5,
            'selling_price' => 10,
        ]);

        // Dispatch the saleRecorded event
        Livewire::test(SaleTable::class)
            ->call('loadSalesData')
            ->dispatch('saleRecorded');

        // Ensure the sales table is updated with new data
        $this->assertCount(1, Sale::all());
    }
}
