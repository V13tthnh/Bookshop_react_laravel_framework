<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_combo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('combo_id');
            $table->unsignedBigInteger('book_id')->nullable();
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('book_combo');
    }
};
