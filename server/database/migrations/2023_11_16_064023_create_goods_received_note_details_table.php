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
            $table->bigInteger('goods_received_note_id');
            $table->bigInteger('book_id');
            $table->Integer('quantity');
            $table->Integer('import_unit_price');
            $table->Integer('export_unit_price');
            $table->timestamps();

            // $table->foreign('goods_received_note_id')->references('id')->on('goods_received_notes')->onDelete('cascade');
            // $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
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
