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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->boolean('synced')->default(false);
            $table->enum('type', ['received', 'shipped', 'moved', 'adjusted', 'damaged', 'expired', 'lost']);
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('warehouse_location_id');
            $table->integer('quantity');
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
