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
            $table->bigInteger('total_payment');
            $table->bigInteger('total_product_cost');
            $table->foreignId('cus_id')
                ->nullable()
                ->constrained(
                    'users',
                    'id'
                )
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->bigInteger('shipping_fee');
            $table->string('note')
                ->nullable();
            $table->string('phone_number');
            $table->string('country');
            $table->string('city');
            $table->string('district');
            $table->string('address_Details');
            $table->string('status');
            $table->string('payment_status');
            $table->foreignId('confirm_by')
                ->nullable()
                ->constrained(
                    'users',
                    'id'
                )
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('update_by')
                ->nullable()
                ->constrained(
                    'users',
                    'id'
                )
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('shipper_id')
                ->nullable()
                ->constrained(
                    'users',
                    'id'
                )
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->date('est_arr_date');
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
