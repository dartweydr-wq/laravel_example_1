<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_categories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('products_id')
                ->nullable()
                ->constrained('products')
                ->onDelete('cascade');
            $table->index('products_id');

            $table->foreignId('categories_id')
                ->nullable()
                ->constrained('categories')
                ->onDelete('cascade');
            $table->index('categories_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_categories');
    }
}
