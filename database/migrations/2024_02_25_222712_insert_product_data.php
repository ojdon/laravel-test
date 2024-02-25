<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('profit_margin', 8, 2)->default(0.25);
            $table->decimal('shipping_cost', 8, 2)->default(10.00);
            $table->timestamps();
        });

        // Insert product data
        DB::table('products')->insert([
            ['name' => 'Gold Coffee', 'profit_margin' => 0.25, 'shipping_cost' => 10.00],
            ['name' => 'Arabic Coffee', 'profit_margin' => 0.15, 'shipping_cost' => 10.00]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
