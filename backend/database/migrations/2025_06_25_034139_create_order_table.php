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
        Schema::create('order', function (Blueprint $table) {
            $table->integer('order_id')->primary()->autoIncrement(true);
            $table->foreignId('product_Id')->references('product_id')->on('product')->onDelete('cascade');
            $table->string('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->string('product_name');
            $table->decimal('price', 10 ,2);
            $table->integer('quantity');
            $table->decimal('total_price', 10 ,2);
            $table->string('image');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
