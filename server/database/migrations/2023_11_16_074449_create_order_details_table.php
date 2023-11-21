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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id');
            $table->bigInteger('book_id');
            $table->Integer('quantity');
            $table->Integer('unit_price')->nullable();
            $table->Integer('sale_price')->nullable();
            $table->tinyInteger('review_status')->nullable();
            $table->timestamps();
            
            // $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            // $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
