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
        Schema::create('sales', function (Blueprint $table) {
            $table->id()->from(10001);
            $table->unsignedBigInteger('user_id')->nullable(); // Associate each sale with a user.
            $table->boolean('promo_applied')->default(false);
            $table->decimal('discount_percentage', 5, 2)->nullable();
            $table->decimal('total_price',8,2, true);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
