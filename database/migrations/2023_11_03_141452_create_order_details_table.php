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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                ->nullable()
                ->constrained(
                    'orders',
                    'id'
                )
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('product_id')
                ->nullable()
                ->constrained(
                    'products',
                    'id'
                )
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->string('note')
                ->nullable();
            $table->integer('amount');
            $table->bigInteger('sale_price');
            $table->string('size_name');
            $table->foreignId('size_id')
                ->nullable()
                ->constrained(
                    'product_sizes',
                    'id'
                )
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
