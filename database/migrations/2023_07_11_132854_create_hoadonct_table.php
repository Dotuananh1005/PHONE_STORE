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
        Schema::create('bill_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('bill_id');
            $table->integer('size_id');
            $table->integer('qauntity');
            $table->string('coupon');
            $table->integer('price');
            $table->integer('total');//Tổng số tiền của từng mặt hàng (Số lượng * Đơn giá).
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoadonct');
    }
};
