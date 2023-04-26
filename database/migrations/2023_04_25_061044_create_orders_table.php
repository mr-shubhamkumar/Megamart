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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate(); # (relation)  get data from user table id
            $table->foreignId('user_address_id')->constrained()->cascadeOnUpdate(); # (relation) get data from user address table id
            $table->foreignId('coupon_id')->nullable()->constrained()->cascadeOnUpdate();# (relation) get data from coupon table id
            $table->double('total_amount',10)->nullable();
            $table->double('discount_amount',10)->default(0);
            $table->string('status')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('razorpay_order_id')->nullable();
            $table->string('razorpay_order_status')->nullable();
            $table->string('razorpay_payment_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
