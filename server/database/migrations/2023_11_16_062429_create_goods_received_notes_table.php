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
        Schema::create('goods_received_notes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('supplier_id');
            $table->string('formality')->nullable();
            $table->bigInteger('admin_id');
            $table->double('total')->nullable();
            $table->tinyInteger('status');
            $table->timestamps();

            // $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            // $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_received_notes');
    }
};
