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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->longText('description')->nullable();
            $table->float('unit_price')->nullable();
            $table->bigInteger('quantity')->nullable();
            $table->Integer('weight')->nullable();
            $table->string('format')->nullable();
            $table->year('year')->nullable();
            $table->string('language')->nullable();
            $table->string('size')->nullable();
            $table->Integer('num_pages')->nullable();
            $table->string('slug')->nullable();
            $table->string('translator')->nullable();
            $table->bigInteger('e_book_price')->nullable();
            $table->string('link_pdf')->nullable();
            $table->float('overrate');
            $table->Integer('book_type')->nullable();
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('publisher_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
