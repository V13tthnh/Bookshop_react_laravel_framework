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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('customer_id');
            $table->float('money')->comment('Số tiền thanh toán');
            $table->string('note')->comment('Ghi chú');
            $table->string('vnp_response_code')->comment('Mã phản hồi');
            $table->string('code_vnpay')->comment('Mã giao dịch vnpay');
            $table->string('code_bank')->comment('Mã ngân hàng');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
