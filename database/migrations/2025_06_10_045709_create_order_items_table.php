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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id');
            $table->foreignId('menu_id');
            $table->string('nama_menu');
            $table->string('catatan_menu')->nullable();
            $table->integer('qty');
            $table->decimal('harga', 15, 2);
            $table->decimal('sub_total', 15, 2);
            $table->enum('status', ['siap','proses']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
