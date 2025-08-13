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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orders_id');
            $table->enum('metode', ['tunai', 'transfer', 'qris']);
            $table->unsignedInteger('jumlah_bayar')->nullable();
            $table->unsignedInteger('kembalian')->nullable();
            $table->enum('status', ['menunggu', 'lunas', 'gagal']);
            $table->dateTime('waktu_bayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
