<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            // Fields
            $table->increments('id');
            $table->string('name');
            $table->decimal('price', 8, 2);
            $table->text('description')->nullable();
            $table->char('image', 255)->nullable();
            $table->text('legal_text')->nullable();
            $table->char('unit_name', 50)->nullable();
            $table->char('quantity_per_unit', 50)->nullable();
            $table->integer('manufacturer_id')->unsigned()->nullable();
            $table->text('storehouse_stock')->nullable();
            $table->boolean('discontinued')->default(false);
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('manufacturer_id')->references('id')->on('manufacturers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('products');
    }
}
