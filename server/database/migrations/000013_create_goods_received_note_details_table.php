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
        Schema::create('goods_received_note_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('goods_received_note_id');
            $table->unsignedBigInteger('book_id');
            $table->Integer('quantity');
            $table->Integer('cost_price');
            $table->Integer('selling_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_received_note_details');
    }
};
