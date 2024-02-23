<?php

namespace Tests\Feature\Livewire;

use App\Livewire\SaleForm;
use App\Models\Sale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SaleFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_record_sale()
    {
        Livewire::test(SaleForm::class)
            ->set('quantity', 1)
            ->set('unitCost', 10)
            ->call('recordSale');

        $this->assertCount(1, Sale::all());
        $this->assertEquals(23.34, Sale::first()->unit_cost);
    }

    /** @test */
    public function it_validates_required_fields()
    {
        Livewire::test(SaleForm::class)
            ->call('recordSale')
            ->assertHasErrors(['quantity', 'unitCost']);
    }

    /** @test */
    public function it_handles_negative_values_correctly()
    {
        Livewire::test(SaleForm::class)
            ->set('quantity', -5)
            ->set('unitCost', -10.0)
            ->call('calculateSellingPrice');

        $this->assertEquals(0.00, Livewire::test(SaleForm::class)->get('sellingPrice'));
    }

    /** @test */
    public function renders_successfully()
    {
        Livewire::test(SaleForm::class)
            ->assertStatus(200);
    }
}
