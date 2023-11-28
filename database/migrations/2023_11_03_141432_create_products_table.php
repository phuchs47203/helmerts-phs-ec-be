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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('brand');
            $table->string('imgurl');
            $table->string('color');
            $table->string('description');
            $table->bigInteger('origional_price');
            $table->bigInteger('sale_price');
            $table->decimal('discount', 4, 2);
            $table->integer('available');
            $table->integer('sold');
            $table->foreignId('cat_id')
                ->nullable()
                ->constrained(
                    'product_categories',
                    'id'
                )
                ->nullOnDelete()
                ->cascadeOnUpdate();

            // $table->foreignId('create_by')
            // $table->foreignId('create_by')

            // $table->foreignId('create_by')
            //     ->nullable()
            //     ->constrained()
            //     ->onDelete('set null'); cách thay thế 
            $table->foreignId('create_by')
                ->nullable()
                ->constrained(
                    'users',
                    'id'
                )
                ->onDelete('set null')
                ->cascadeOnUpdate();

            // alternative method
            // $table->cascadeOnUpdate();	Updates should cascade.
            // $table->restrictOnUpdate();	Updates should be restricted.
            // $table->cascadeOnDelete();	Deletes should cascade.
            // $table->restrictOnDelete();	Deletes should be restricted.
            // $table->nullOnDelete();	Deletes should set the foreign key value to null.

            $table->foreignId('update_by')
                ->nullable()
                ->constrained(
                    'users',
                    'id'
                )
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->timestamps();
        });
        // Schema::table('products', function (Blueprint $table) {
        //     $table->foreignId('create_by')->references('id')->on('users');
        //     $table->foreignId('create_by')->references('id')->on('users');

        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
