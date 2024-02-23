<?php

namespace Tests\Feature\Livewire;

use App\Livewire\SaleTable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class SaleTableTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(SaleTable::class)
            ->assertStatus(200);
    }
}
