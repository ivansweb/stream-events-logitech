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
        Schema::create('merch_sales', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->integer('amount');
            $table->decimal('price', 10, 2);

            $table->unsignedBigInteger('user_id')->comment('Foreign key for seller user');
            $table->unsignedBigInteger('buyer_id')->comment('Foreign key for buyer user');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('buyer_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merch_sales');
    }
};
