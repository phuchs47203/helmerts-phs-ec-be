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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cus_id')
                ->nullable()
                ->constrained(
                    'users',
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
            $table->integer('star');
            $table->string('content');
            $table->string('imgurl')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
