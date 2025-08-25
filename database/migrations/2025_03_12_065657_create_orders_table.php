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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('order_date');
            $table->time('order_time');
            $table->string('city');
            $table->string('address');
            $table->string('phone');
            $table->string('status', 100)->enum('confirmed', 'preparing', 'checking', 'delivering', 'delivered');
            $table->integer('total')->unsigned();
            $table->string('transaction_id', 100)->nullable();
            $table->integer('gross_amount')->unsigned();
            $table->timestamps();
            $table->softDeletes();
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
