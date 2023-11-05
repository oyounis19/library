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
        Schema::create('daily_stats', function (Blueprint $table) {
            $table->id()->from(10001);
            $table->date('date');
            $table->decimal('total_income', 10, 2);
            $table->decimal('total_cost', 10, 2);
            // $table->decimal('net_income', 10, 2); Calculated attribute shouldn't be in the database
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_stats');
    }
};
