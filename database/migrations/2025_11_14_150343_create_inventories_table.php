<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('inventories', function (Blueprint $table) {
        $table->id();
        $table->foreignId('product_id')->constrained()->cascadeOnDelete();
        $table->integer('stock_in')->default(0);   // stok masuk dari distributor
        $table->integer('stock_out')->default(0);  // stok yang ditarik ke produk
        $table->integer('current_stock')->default(0); // stok tersisa di inventory
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
