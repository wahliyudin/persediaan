<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('stock');
            $table->bigInteger('price');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('warehouse_id');

            $table->foreign('unit_id')->references('id')->on('units')->cascadeOnDelete();
            $table->foreign('type_id')->references('id')->on('types')->cascadeOnDelete();
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->cascadeOnDelete();
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
        Schema::dropIfExists('products');
    }
}
