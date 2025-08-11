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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('kode_voucher')->unique();
            $table->decimal('diskon_persen', 5, 2); // contoh: 10.00 = 10%
            $table->date('mulai_berlaku');
            $table->date('kadaluarsa');
            $table->unsignedInteger('limit_penggunaan')->default(0); // 0 = tidak terbatas
            $table->unsignedInteger('digunakan')->default(0); // berapa kali sudah digunakan
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
