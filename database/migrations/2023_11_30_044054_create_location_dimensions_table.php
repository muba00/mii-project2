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
        Schema::create('location_dimensions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warehouse_location_id')->constrained();
            $table->integer('width')->default(0); // cm
            $table->integer('height')->default(0); // cm
            $table->integer('depth')->default(0); // cm
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_dimensions');
    }
};
