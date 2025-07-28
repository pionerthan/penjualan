<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->id('PelangganID'); // AUTO_INCREMENT dan PRIMARY KEY
            $table->string('NamaPelanggan');
            $table->text('Alamat');
            $table->string('NomorTelepon', 15);
            // Jika tidak pakai timestamps:
            // $table->timestamps(); // Hanya jika kamu mau created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
